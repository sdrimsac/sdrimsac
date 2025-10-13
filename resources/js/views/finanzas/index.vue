<!-- Modulo de Cotizaciones -->
<template>
    <el-tabs type="border-card" v-model="activeTab" @tab-click="handleTabClick">
        <el-tab-pane label="Creditos CPE" name="cpe">
            <div>
                <div class="row m-2">
                    <el-pagination @current-change="getCpeRecords" layout="total, prev, pager, next"
                        :total="paginationCpe.total" :current-page.sync="paginationCpe.current_page"
                        :page-size="paginationCpe.per_page">
                    </el-pagination>
                </div>
                <div class="row mt-1">
                    <div class="col-4">
                        <el-input placeholder="Buscar cliente" v-model="searchCpe" prefix-icon="el-icon-search"
                            clearable @clear="getCpeRecords" @input="getCpeRecordsTimer"></el-input>
                    </div>
                    <div class="col-4">
                        <el-date-picker v-model="date_start_cpe" type="date" placeholder="Fecha inicio"
                            @change="getCpeRecords" value-format="yyyy-MM-dd" class="w-100"></el-date-picker>
                    </div>
                    <div class="col-4">
                        <el-date-picker class="w-100" v-model="date_end_cpe" type="date" placeholder="Fecha fin"
                            @change="getCpeRecords" value-format="yyyy-MM-dd"></el-date-picker>
                    </div>
                    <div class="col-4">
                        <el-select v-model="establishment_id_cpe" @change="getCpeRecords"
                            placeholder="Seleccione establecimiento" clearable filterable>
                            <el-option v-for="establishment in establishments" :key="establishment.id"
                                :label="establishment.description" :value="establishment.id"></el-option>
                        </el-select>
                    </div>
                    <div class="col-6" v-if="recordsCpe.length">
                        <el-button type="primary" @click="exportExcelCpe">Exportar Excel</el-button>
                    </div>
                </div>
                <div class="row m-2 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in recordsCpe" :key="record.id">
                                <td>{{ record.date_of_issue }}</td>
                                <td>
                                    {{ record.customer_name }}
                                    <br />
                                    <small>
                                        {{ record.customer_number }}
                                    </small>
                                </td>
                                <td>{{ record.number }}</td>
                                <td>{{ Number(record.total).toFixed(2) }}</td>
                                <td class="text-warning">
                                    {{ Number(record.remain).toFixed(2) }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        @click="clickPayment(record.id)">
                                        Pagar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <documents-payments @getRecords="getCpeRecords" :external="true" :showDialog.sync="showDialogPayments"
                    :documentId="recordId"></documents-payments>
            </div>
        </el-tab-pane>
        <el-tab-pane label="Creditos nota de venta" name="salenote">
            <div>
                <div class="row m-2">
                    <el-pagination @current-change="getRecords" layout="total, prev, pager, next"
                        :total="pagination.total" :current-page.sync="pagination.current_page"
                        :page-size="pagination.per_page">
                    </el-pagination>
                </div>
                <div class="row mt-1">
                    <div class="col-4">
                        <el-input placeholder="Buscar cliente" v-model="search" prefix-icon="el-icon-search" clearable
                            @clear="getRecords" @input="getRecordsTimer"></el-input>
                    </div>
                    <div class="col-4">
                        <el-date-picker v-model="date_start" type="date" placeholder="Fecha inicio" @change="getRecords"
                            value-format="yyyy-MM-dd" class="w-100"></el-date-picker>
                    </div>
                    <div class="col-4">
                        <el-date-picker class="w-100" v-model="date_end" type="date" placeholder="Fecha fin"
                            @change="getRecords" value-format="yyyy-MM-dd"></el-date-picker>
                    </div>
                    <div class="col-4">
                        <el-select v-model="establishment_id" @change="getRecords"
                            placeholder="Seleccione establecimiento" clearable filterable>
                            <el-option v-for="establishment in establishments" :key="establishment.id"
                                :label="establishment.description" :value="establishment.id"></el-option>
                        </el-select>
                    </div>
                    <div class="col-6" v-if="records.length">
                        <el-button type="primary" @click="exportExcel">Exportar Excel</el-button>
                    </div>
                </div>
                <div class="row m-2 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in records" :key="record.id">
                                <td>{{ record.date_of_issue }}</td>
                                <td>
                                    {{ record.customer_name }}
                                    <br />
                                    <small>
                                        {{ record.customer_number }}
                                    </small>
                                </td>
                                <td>{{ record.full_number }}</td>
                                <td>{{ Number(record.total).toFixed(2) }}</td>
                                <td class="text-warning">
                                    {{ Number(record.remain).toFixed(2) }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" @click="pay(record.id)">
                                        Pagar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <sale-note-payments :showDialog.sync="showDialogPaymentsSalenote" :documentId="recordId"
                    @reloadData="getRecords" :configuration="configuration"></sale-note-payments>
            </div>
        </el-tab-pane>
    </el-tabs>
</template>
<style scoped>
.anulate_color {
    color: red;
}
</style>
<script>
import SaleNotePayments from "../sale_notes/partials/payments_cash.vue";
const DocumentsPayments = () =>
    import(
        "../documents/partials/payments.vue"
    );
export default {
    props: ["showDialog", "configuration", "isCreditCash"],
    components: {
        SaleNotePayments,
        DocumentsPayments
    },
    data() {
        return {
            activeTab: 'cpe',
            showDialogPaymentsSalenote: false,
            showDialogPayments: false,
            recordId: null,
            records: [],
            resource: "sale-notes/credit-cash",
            pagination: {},
            loading: false,
            timer: null,
            search: "",
            date_start: null,
            date_end: null,
            establishment_id: null,
            establishments: []
            ,
            recordsCpe: [],
            resourceCpe: "documents/credit-cash-records",
            paginationCpe: {},
            timerCpe: null,
            searchCpe: "",
            date_start_cpe: null,
            date_end_cpe: null,
            establishment_id_cpe: null
        };
    },

    mounted() {
        this.getCpeRecords();
    },

    async created() {
        /* await this.initForm(); */
        await this.$http.get(`/sale_note_payments/tables`).then(response => {
            this.payment_destinations = response.data.payment_destinations;
            this.payment_method_types = response.data.payment_method_types;
            this.establishments = response.data.establishments;
            //this.initDocumentTypes()
        });
    },

    methods: {
        exportExcel() {
            window.open(`/${this.resource}/export?date_start=${this.date_start || ""}&date_end=${this.date_end || ""}&value=${this.search || ""}`, "_blank");
        },

        // Export for CPE credits tab
        exportExcelCpe() {
            window.open(`/${this.resourceCpe}/export?date_start=${this.date_start_cpe || ""}&date_end=${this.date_end_cpe || ""}&value=${this.searchCpe || ""}&establishment_id=${this.establishment_id_cpe || ""}`, "_blank");
        },

        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },

        getRecordsTimer() {
            console.log("object");
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.getRecords();
            }, 500);
        },
        getCpeRecordsTimer() {
            clearTimeout(this.timerCpe);
            this.timerCpe = setTimeout(() => {
                this.getCpeRecords();
            }, 500);
        },
        open() {
            console.log("open");
            // Fetch according to active tab: default is 'cpe'
            if (this.activeTab === 'cpe') {
                this.getCpeRecords();
            } else if (this.activeTab === 'salenote') {
                this.getRecords();
            }
        },
        handleTabClick(tab) {
            if (tab.name === 'cpe') {
                this.getCpeRecords();
            } else if (tab.name === 'salenote') {
                this.getRecords();
            }
        },
        pay(recordId) {
            this.recordId = recordId;
            this.showDialogPaymentsSalenote = true;
        },

        close() {
            this.$emit("update:showDialog", false);
        },
        async getRecords() {
            let search = this.search || "";
            const response = await this.$http(
                `/${this.resource}/records?value=${search}&page=${this
                    .pagination.current_page || 1}&date_start=${this
                        .date_start || ""}&date_end=${this.date_end || ""}&establishment_id=${this.establishment_id || ""}`
            );
            let data = response.data;
            this.records = data.data;
            this.pagination = response.data.meta;
            this.pagination.per_page = parseInt(response.data.meta.per_page);
        },

        // Fetch records for CPE credits tab from `documents/credit-cash-records`
        async getCpeRecords() {
            let search = this.searchCpe || "";
            const response = await this.$http(
                `/${this.resourceCpe}/records?value=${search}&page=${this
                    .paginationCpe.current_page || 1}&date_start=${this
                        .date_start_cpe || ""}&date_end=${this.date_end_cpe || ""}&establishment_id=${this.establishment_id_cpe || ""}`
            );
            let data = response.data;
            this.recordsCpe = data.data;
            this.paginationCpe = response.data.meta;
            this.paginationCpe.per_page = parseInt(response.data.meta.per_page);
        }
    }
};
</script>
