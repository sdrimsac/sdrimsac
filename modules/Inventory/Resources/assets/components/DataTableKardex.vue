<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="control-label">Producto</label>
                        <el-select
                            v-model="form.item_id"
                            filterable
                            remote
                            clearable
                            @change="hasMaxQuantity"
                            :remote-method="searchRemoteItems"
                        >
                            <el-option
                                v-for="option in items"
                                :key="option.id"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Fecha inicio</label>
                        <el-date-picker
                            class="w-100"
                            v-model="form.date_start"
                            type="date"
                            @change="changeDisabledDates"
                            value-format="yyyy-MM-dd"
                            format="dd/MM/yyyy"
                            :clearable="true"
                        ></el-date-picker>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Fecha término</label>
                        <el-date-picker
                            class="w-100"
                            v-model="form.date_end"
                            type="date"
                            :picker-options="pickerOptionsDates"
                            value-format="yyyy-MM-dd"
                            format="dd/MM/yyyy"
                            :clearable="true"
                        ></el-date-picker>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col-3">
                        <label class="control-label">Establecimiento </label>
                        <el-select
                            v-model="form.establish"
                            filterable
                            clearable
                        >
                            <el-option
                                v-for="option in establecimiento"
                                :key="option.id"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                    <div
                        class="col-3"
                        v-if="unitTypeDescription && records.length > 0"
                    >
                        <br />
                        <el-switch
                            @change="parsedMaxQuantity"
                            v-model="max_quantity"
                            :active-text="unitTypeDescription.max"
                            :inactive-text="unitTypeDescription.min"
                        >
                        </el-switch>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <el-button
                            class="submit"
                            type="primary"
                            @click.prevent="getRecordsByFilter"
                            :loading="loading_submit"
                            icon="el-icon-search"
                            >Buscar</el-button
                        >
                    </div>
                    <div class="col-md-6 col-12 mt-2">
                        <template v-if="records.length > 0">
                            <div class="form-group">
                                <label class="control-label w-100"
                                    >Exportar para usuario
                                </label>
                                <el-button
                                    class="submit"
                                    type="danger"
                                    icon="el-icon-tickets"
                                    @click.prevent="clickDownload('pdf')"
                                    >Exportar PDF</el-button
                                >
                                <el-button
                                    class="submit"
                                    type="success"
                                    @click.prevent="clickDownload('excel')"
                                    ><i class="fa fa-file-excel"></i> Exportar
                                    Excel</el-button
                                >
                            </div>
                        </template>
                    </div>
                    <!-- <div class="col-md-6 m-t-10">
                              <template v-if="records.length>0">
                                <label class="control-label">Exportar para sunat </label>
                                <div class="form-group">
                                     <el-button class="submit" type="success" @click.prevent="clickDownload2('excel')"><i class="fa fa-file-excel" ></i>  Exportar Excel</el-button>
                                     <el-button class="submit" type="default" @click.prevent="clickDownload2('txt')"><i class="fa fa-file-excel" ></i>  Exportar txt</el-button>
                                 </div>
                            </template>
                         </div> -->
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
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
    props: ["establecimiento", "resource"],
    data() {
        return {
            max_quantity: false,
            original_records: [],
            unitTypeDescription: null,
            loading_submit: false,
            columns: [],
            records: [],
            headers: headers_token,
            document_types: [],
            pagination: {},
            search: {},
            timer: null,
            totals: {},
            establishment: null,
            items: [],
            form: {},
            pickerOptionsDates: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM-DD");
                    return this.form.date_start > time;
                }
            }
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
        // await this.$http.get(`/${this.resource}/filter`).then(response => {
        //     this.items = response.data.items;
        // });
        // await this.getRecords()
    },

    methods: {
        maxQuantityFormat(
            qty,
            max_quantity,
            { max_quantity_description, unit_type_description }
        ) {
            let stock = Number(qty);
            let general = Math.trunc(stock / max_quantity);
            let part = (stock / max_quantity) % 1;
            let text = `${general} ${max_quantity_description}`;
            if (part != 0) {
                let new_part = part * max_quantity;
                new_part = new_part.toFixed(2);
                text += ` ${new_part} ${unit_type_description}`;
            }

            return text;
        },
        parsedMaxQuantity() {
            let item = this.items.find(item => item.id == this.form.item_id);
            let records = JSON.parse(JSON.stringify(this.original_records));
            this.records = records.map(record => {
                if (this.max_quantity) {
                    record.input =
                        record.input == "-"
                            ? "-"
                            : this.maxQuantityFormat(
                                  record.input,
                                  item.max_quantity,
                                  item
                              );
                    record.output =
                        record.output == "-"
                            ? "-"
                            : this.maxQuantityFormat(
                                  record.output,
                                  item.max_quantity,
                                  item
                              );
                    record.balance =
                        record.balance == "-"
                            ? "-"
                            : this.maxQuantityFormat(
                                  record.balance,
                                  item.max_quantity,
                                  item
                              );
                } else {
                    record.input =
                        record.input == "-"
                            ? "-"
                            : `${record.input} ${item.unit_type_description}`;
                    record.output =
                        record.output == "-"
                            ? "-"
                            : `${record.output} ${item.unit_type_description}`;
                    record.balance =
                        record.balance == "-"
                            ? "-"
                            : `${record.balance} ${item.unit_type_description}`;
                }
                //limitar a 2 decimales input output balance

                return record;
            });
        },
        searchRemoteItems(input) {
            this.unitTypeDescription = null;
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/documents/data-table/items?${parameters}`
                        );

                        this.items = response.data;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        hasMaxQuantity() {
            this.unitTypeDescription = null;
            this.records = [];
            let item = this.items.find(item => item.id == this.form.item_id);
            if (item.max_quantity && item.max_quantity_description) {
                this.unitTypeDescription = {
                    max: item.max_quantity_description,
                    min: item.unit_type_description
                };
            }
        },
        changeDisabledDates() {
            if (this.form.date_end < this.form.date_start) {
                this.form.date_end = this.form.date_start;
            }
            // this.loadAll();
        },
        clickDownload(type) {
            this.form.max_quantity = this.max_quantity;
            let query = queryString.stringify({
                ...this.form
            });
            window.open(`/${this.resource}/${type}?${query}`, "_blank");
        },
        clickDownload2(type) {
            let query = queryString.stringify({
                ...this.form
            });
            window.open(`/reports/inventorykardex/${type}?${query}`, "_blank");
        },
        initForm() {
            this.form = {
                item_id: null,
                date_start: null,
                date_end: null
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
            // if(!this.form.item_id){
            //     return this.$toast.error('El producto es obligatorio')
            // }

            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },
        async getRecords() {
            this.$eventHub.$emit("emitItemID", this.form.item_id);

            try {
                const response = await axios.get(
                    `/${this.resource}/records?${this.getQueryParameters()}`
                );

                const { status, data } = response;
                if (status == 200) {
                    let data = response.data.data;
                    let records_data = _.filter(data, { view: true });
                    this.original_records = records_data;
                    this.parsedMaxQuantity();
                    //********************************************
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading_submit = false;
                }
            } catch (error) {
                console.log(error);
                //this.$toast.error(error.response.data.error)
            }
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        }
    }
};
</script>
