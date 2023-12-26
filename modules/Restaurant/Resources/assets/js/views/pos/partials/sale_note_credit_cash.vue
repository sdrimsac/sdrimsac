<template>
    <el-dialog
        :visible="showDialog"
        title="Notas de venta - Crédito"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row m-2">
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="pagination.per_page"
            >
            </el-pagination>
        </div>
        <div class="row m-2 table-responsive">
            <div class="col-12">
                <el-input
                    placeholder="Buscar"
                    v-model="search"
                    prefix-icon="el-icon-search"
                    clearable
                    @clear="getRecords"
                    @input="getRecordsTimer"
                ></el-input>
            </div>
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
                        <td>{{ record.total }}</td>
                        <td class="text-warning">
                            {{ record.remain.toFixed(2) }}
                        </td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                @click="pay(record.id)"
                            >
                                Pagar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <sale-note-payments
            :showDialog.sync="showDialogPayments"
            :documentId="recordId"
            @reloadData="getRecords"
        ></sale-note-payments>
    </el-dialog>
</template>

<script>
import SaleNotePayments from "../../../../../../../../resources/js/views/sale_notes/partials/payments.vue";
export default {
    props: ["showDialog"],
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
            search:"",
        };
    },
    methods: {
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
            let search = this.search||"";
            const response = await this.$http(`/${this.resource}/records?value=${search}&page=${this.pagination.current_page||1}`);
            let data = response.data;
            this.records = data.data;
            this.pagination = response.data.meta;
            this.pagination.per_page = parseInt(response.data.meta.per_page);
        }
    }
};
</script>
