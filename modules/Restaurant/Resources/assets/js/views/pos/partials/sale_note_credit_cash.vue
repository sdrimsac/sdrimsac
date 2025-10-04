<template>
    <el-dialog :visible="showDialog" title="Notas de venta - Crédito" @open="open" @close="close" width="80%"
        append-to-body>
        <div class="row m-2">
            <el-pagination @current-change="getRecords" layout="total, prev, pager, next" :total="pagination.total"
                :current-page.sync="pagination.current_page" :page-size="pagination.per_page">
            </el-pagination>
        </div>
        <div class="row mt-1">
            <div class="col-4">
                <el-input placeholder="Buscar" v-model="search" prefix-icon="el-icon-search" clearable
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
                <el-select v-model="establishment_id" @change="getRecords" placeholder="Seleccione establecimiento" clearable filterable>
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
        <sale-note-payments :showDialog.sync="showDialogPayments" :documentId="recordId" @reloadData="getRecords"
            :configuration="configuration"></sale-note-payments>
    </el-dialog>
</template>

<script>
import SaleNotePayments from "../../../../../../../../resources/js/views/sale_notes/partials/payments_cash.vue";
export default {
    props: ["showDialog", "configuration"],
    components: {
        SaleNotePayments
    },
    data() {
        return {
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
        };
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

        getRecordsTimer() {
            console.log("object");
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.getRecords();
            }, 500);
        },
        open() {
            console.log("open");
            this.getRecords();
        },
        pay(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
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
        }
    }
};
</script>
