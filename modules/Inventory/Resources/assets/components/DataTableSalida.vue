<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row mt-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Almacen</label>
                            <el-select
                                v-model="form.warehouse_id"
                                clearable
                                filterable
                            >
                                <el-option
                                    v-for="option in warehouses"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Categoria</label>
                            <el-select
                                v-model="form.category_id"
                                clearable
                                filterable
                            >
                                <el-option
                                    v-for="option in categories"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                        <label for="date_start">Fecha inicial</label>
                        <el-date-picker
                            v-model="form.date_start"
                            type="date"
                            style="width: 100%;"
                            placeholder="Fecha inicial"
                            value-format="yyyy-MM-dd"
                            @change="getRecords"
                        >
                        </el-date-picker>
                    </div>
                    <div class="col-md-2 col-lg-3">
                        <label for="date_end">Fecha final</label>

                        <el-date-picker
                            v-model="form.date_end"
                            type="date"
                            style="width: 100%;"
                            placeholder="Fecha final"
                            value-format="yyyy-MM-dd"
                            @change="getRecords"
                        >
                        </el-date-picker>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"
                                >Filtro Por Productos</label
                            >
                            <el-select
                                v-model="form.description"
                                clearable
                                filterable
                            >
                                <el-option
                                    v-for="option in items"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Filtro Por tipo</label>
                            <el-select
                                v-model="form.qty_type"
                                clearable
                                filterable
                            >
                                <el-option
                                    v-for="option in qty_types"
                                    :key="option.id"
                                    :value="option.value"
                                    :label="option.active"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div
                        class="col-lg-4 col-md-4 col-md-4 col-sm-12 d-flex align-items-center"
                    >
                        <el-button
                            class="submit"
                            type="primary"
                            @click.prevent="getRecordsByFilter"
                            :loading="loading_submit"
                            icon="el-icon-search"
                            >Buscar</el-button
                        >
                        <template v-if="records.length > 0">
                            <!-- <el-button class="submit" type="danger" @click.prevent="clickDownload('pdf')"><i class="fa fa-file-pdf" ></i>  Exportal PDF</el-button> -->
                            <el-button
                                class="submit"
                                type="success"
                                @click.prevent="clickDownload('excel')"
                                ><i class="fa fa-file-excel"></i> Exportal
                                Excel</el-button
                            >
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br />
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <slot name="heading"></slot>
                    </thead>
                    <tbody>
                        <slot
                            v-for="(row, index) in records"
                            :row="row"
                            :index="customIndex(index)"
                        ></slot>
                    </tbody>
                </table>
                <div>
                    <el-pagination
                        @current-change="getRecords"
                        layout="total, prev, pager, next"
                        :total="pagination.total"
                        :current-page.sync="pagination.current_page"
                        :page-size="pagination.per_page"
                    >
                    </el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.font-custom {
    font-size: 15px !important;
}
</style>

<script>
import moment from "moment";
import queryString from "query-string";

export default {
    props: {
        resource: String,
        external: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            qty_types: [
                {
                    id: 1,
                    name: "Entrada",
                    value: "input"
                },
                {
                    id: 2,
                    name: "Salida",
                    value: "output"
                }
            ],
            loading_submit: false,
            loading_search: false,
            columns: [],
            records: [],
            pagination: {},
            search: {
                date_start: null,
                date_end: null
            },
            totals: {},
            categories: [],
            warehouses: [],
            items: [],
            inventory_transactions: [],
            inventories: [],
        };
    },
    computed: {},
    created() {
        this.initForm();
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.warehouses = response.data.warehouses;
            this.categories = response.data.categories;
            this.items = response.data.items;
            this.inventory_transactions = response.data.inventory_transactions;
            this.inventories = response.data.inventories;

            /* console.log('Warehouses:', this.warehouses);
                console.log('Categories:', this.categories); */
        });

        await this.getRecords();
        console.log("Records after mount:", this.records);
    },
    methods: {
        async clickDownload(type) {
            let query = queryString.stringify({
                ...this.form
            });
            if (type == "pdf") {
                window.open(`/${this.resource}/${type}/?${query}`, "_blank");
            } else {
                // console.log(`/${this.resource}/${type}?${query}`);
                const response = await this.$http.get(
                    `/${this.resource}/${type}/?${query}`,
                    {
                        responseType: "blob"
                    }
                );
                const blob = new Blob([response.data], {
                    type:
                        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = "Reporte_Movi";
                link.click();
                URL.revokeObjectURL(link.href);
            }
        },
        initForm() {
            this.form = {
                qty_type: null,
                description: null,
                warehouse_id: null,
                category_id: null,
                /* created_at: null, */
                date_start: null,
                date_end: null,
                typeresult: "detallado"
            };
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },

        getRecords() {
            return this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    let data = response.data;
                    console.log(response);

                    this.records = data.data;

                    this.pagination = data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading_submit = false;

                    /* console.log('Pagination:', this.pagination); */
                    // this.initTotals()
                });
        },

        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        },
        changeDisabledDates() {
            if (this.form.date_end < this.form.date_start) {
                this.form.date_end = this.form.date_start;
            }
        },
        changeDisabledMonths() {
            if (this.form.month_end < this.form.month_start) {
                this.form.month_end = this.form.month_start;
            }
        },
        changePeriod() {
            if (this.form.period === "month") {
                this.form.month_start = moment().format("YYYY-MM");
                this.form.month_end = moment().format("YYYY-MM");
            }
            if (this.form.period === "between_months") {
                this.form.month_start = moment()
                    .startOf("year")
                    .format("YYYY-MM"); //'2019-01';
                this.form.month_end = moment()
                    .endOf("year")
                    .format("YYYY-MM");
            }
            if (this.form.period === "date") {
                this.form.date_start = moment().format("YYYY-MM-DD");
                this.form.date_end = moment().format("YYYY-MM-DD");
            }
            if (this.form.period === "between_dates") {
                this.form.date_start = moment()
                    .startOf("month")
                    .format("YYYY-MM-DD");
                this.form.date_end = moment()
                    .endOf("month")
                    .format("YYYY-MM-DD");
            }
            // this.loadAll();
        }
    }
};
</script>
