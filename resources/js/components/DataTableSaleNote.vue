<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    <div class="col-12"></div>
                    <div class="row" style="padding:0; margin:0;">
                        <div class="col-10" style="padding:0;">
                            <div class="d-flex flex-wrap align-items-end">
                                <div class="me-2 mb-2" style="min-width: 250px;">
                                    <el-select @change="getRecords" placeholder="Serie CPE" v-model="search.series"
                                        filterable clearable style="width: 100%;">
                                        <el-option v-for="option in series" :key="option.number" :value="option.number"
                                            :label="option.number"></el-option>
                                    </el-select>
                                </div>
                                <div class="me-2 mb-2" style="min-width: 250px;">
                                    <el-input placeholder="Ingresar N° Nota Venta" v-model="search.number"
                                        @input="getRecords" style="width: 100%;">
                                        <i slot="prefix" class="el-icon-edit-outline"></i>
                                    </el-input>
                                </div>
                                <div class="me-2 mb-2" style="min-width: 250px;">
                                    <el-date-picker v-model="search.date_start" type="date" style="width: 100%;"
                                        placeholder="Fecha Inicial" value-format="yyyy-MM-dd" @change="getRecords">
                                    </el-date-picker>
                                </div>
                                <div class="me-2 mb-2" style="min-width: 250px;">
                                    <el-date-picker v-model="search.date_end" type="date" style="width: 100%;"
                                        placeholder="Fecha Final" value-format="yyyy-MM-dd" @change="getRecords">
                                    </el-date-picker>
                                </div>
                                <div class="mb-2" style="min-width: 250px;">
                                    <el-select clearable v-model="search.state_type_id" placeholder="Seleccione un estado"
                                        @change="getRecords" style="width: 100%;">
                                        <el-option v-for="(option, idx) in state_types" :key="idx" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-end mt-2">
                                <div class="me-2 mb-2" style="min-width: 800px;">
                                    <!-- <label for="customer_id" class="mb-1">Cliente</label> -->
                                    <el-select v-model="search.customer_id" filterable remote
                                        class="border-left rounded-left border-info" popper-class="el-select-customers"
                                        dusk="customer_id" placeholder="Escriba el nombre o número de documento del cliente"
                                        :remote-method="searchRemoteCustomers" :loading="loading_search"
                                        @change="getRecords" style="width: 100%;">
                                        <el-option v-for="option in customers" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                </div>
                                <div class="me-2 mb-2" style="min-width: 300px;">
                                    <!-- <label for="seller_id" class="mb-1">Vendedor</label> -->
                                    <el-select clearable v-model="search.seller_id"
                                        class="border-left rounded-left border-info w-100"
                                        popper-class="el-select-customers" placeholder="Seleccione un Asesor - Vendedor"
                                        @change="getRecords" style="width: 100%;">
                                        <el-option v-for="(option, idx) in sellers" :key="idx" :value="option.id"
                                            :label="option.name"></el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 mb-2" style="padding:0;" >
                            <div class="d-flex flex-column align-items-center justify-content-center h-100" v-if="configuration.sale_note_credit_cash">
                                <span style="font-weight: bold; font-size: 1.1rem;">
                                    Total por cobrar :
                                </span>
                                <el-tag style="font-size: 1.1rem;">
                                    {{ saleNotesPending.toFixed(2) }}
                                </el-tag>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-2">
                                <el-button class="btn_excelsmall" type="success" icon="el-icon-download" size="small" v-if="records.length > 0"
                                    @click="exportRecords">
                                    Exportar
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                        <div class="d-flex">
                            <div style="width:100px">
                                Filtrar por:
                            </div>
                                v-model="search.column"
                                placeholder="Select"
                                @change="changeClearInput"
                            <style scoped>
                                <el-option
                                    v-for="(label, key) in columns"
                                    :key="key"
                                    :value="key"
                                    :label="label"
                                ></el-option>
                            </el-select>
                        </div>
                    </div> -->


            </div>
        </div>

        <div class="col-md-12">
            <div id="scroll1" style="overflow-x: auto">
                <div style="height: 20px"></div>
            </div>
            <div class="table-responsive" id="scroll2" style="overflow-x: auto">
                <table class="table table-hover table-striped">
                    <thead>
                        <slot name="heading"></slot>
                    </thead>
                    <tbody>
                        <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                    </tbody>
                </table>

                <div class="row mb-5" v-if="totalsNV > 0">
                    <div class="col-md-12 text-end  border-top">
                        <h6>
                            <b>Total Por busqueda S/ {{ totalsNV.toFixed(2) }}</b>
                        </h6>
                    </div>
                </div>
                <div class="col-md-12 text-end ">
                    <h6>
                        <b>Total Suma Documentos S/ {{ totalSum.total_pen }}</b>
                    </h6>
                </div>

                <div>
                    <el-pagination @current-change="getRecords" layout="total, prev, pager, next"
                        :total="pagination.total" :current-page.sync="pagination.current_page"
                        :page-size="pagination.per_page">
                    </el-pagination>
                </div>
            </div>
        </div>
    </div>
    
</template>

<style>
td {
    color: #000;
}
/* Azul para todos los placeholders de Element UI */
.el-input__inner::placeholder,
.el-select .el-input__inner::placeholder,
.el-date-editor.el-input__inner::placeholder {
  color: #073f68 !important;
  opacity: 1 !important; /* Para que no se vea deshabilitado */
}
</style>
<script>
import moment from "moment";
import queryString from "query-string";

export default {
    props: {
        resource: String,
        applyFilter: {
            type: Boolean,
            default: true,
            required: false
        }
    },
    data() {
        return {
            totalSum: 0,
            totalsNV: 0,
            state_types: [],
            sellers: [],
            customers: [],
            loading_search: false,
            search: {
                state_type_id: null, // Mostrar todos los estados por defecto
                number: null,
                customer_id: null,
                date_start: null,
                date_end: null,
                seller_id: null,
                series: null,
                end: null
            },
            totals: {
                total_pen: 0,
                total_paid_pen: 0,
                total_pending_paid_pen: 0
            },
            columns: [],
            records: [],
            pagination: {},
            array_users: [],
            series: [],
            saleNotesPending: 0,
            configuration: {}
            // sale_notes_pending:0
        };
    },
    computed: {},
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
            this.getTotals();
            // this.filter_users()
        });
        this.$http.get(`/sale-notes/tables`).then(response => {
            console.log(response);
            this.array_users = response.data.users;
            this.sellers = response.data.sellers;
            if (response.data.configuration) {
                this.configuration = response.data.configuration;
            }
            // Agregar opción 'Pendiente' solo si configuration.sale_note_credit_cash
            if (this.configuration.sale_note_credit_cash) {
                this.state_types = [
                    ...response.data.state_types,
                    { id: 'pending', description: 'Pendiente' }
                ];
            } else {
                this.state_types = [...response.data.state_types];
            }
        });
    },
    async mounted() {
        let column_resource = _.split(this.resource, "/");
        // console.log(column_resource)
        await this.$http
            .get(`/${_.head(column_resource)}/columns`)
            .then(response => {
                this.columns = response.data;
                this.search.column = _.head(Object.keys(this.columns));
            });

        await this.$http
            .get(`/${_.head(column_resource)}/columns2`)
            .then(response => {
                this.series = response.data.series;
            });

        await this.getRecords();
        await this.getTotals();
        await this.cargalo();
        await this.getCreditPending();
    },
    methods: {
        async getCreditPending() {
            // Usar los mismos filtros que el datatable
            const params = this.getQueryParameters();
            const response = await this.$http.get(`/sale-notes/credit_pending?${params}`);
            this.saleNotesPending = response.data.sale_notes_pending;
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.allCustomers();
                        }
                    });
            } else {
                this.allCustomers();
            }
        },
        getTotals() {
            this.$http.get(`/${this.resource}/totals`).then(response => {
                // console.log(response)
                this.totalSum = response.data;
            });
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        exportRecords() {
            window.open(
                `/${this.resource}/excel?${this.getQueryParameters()}`,
                "_blank"
            );
        },
        getRecords() {
            this.getTotalsNV();
            this.getCreditPending();
            this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                });
        },
        getTotalsNV() {
            return this.$http
                .get(`/${this.resource}/total_records?${this.getQueryParameters()}`)
                .then(response => {
                    console.log("la response", response);
                    this.totalsNV = response.data;
                });
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        },
        cargalo() {
            $("#scroll1 div").width($(".table").width());
            $("#scroll1").on("scroll", function () {
                $("#scroll2").scrollLeft($(this).scrollLeft());
            });
            $("#scroll2").on("scroll", function () {
                $("#scroll1").scrollLeft($(this).scrollLeft());
            });
        }
    }
};
</script>
