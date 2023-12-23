<template>
    <el-dialog
        :visible="showDialog"
        title="Notas de venta - Crédito"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row m-2"></div>
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
                        <td>{{ record.total }}</td>
                        <td class="text-warning">{{ record.remain.toFixed(2) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm"
                            @click="pay(record.id)"
                                >Pagar</button
                            >
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
            loading: false
        };
    },
    methods: {
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
            const response = await this.$http(`/${this.resource}/records`);
            let data = response.data;
            this.records = data.data;
            this.pagination = data.meta;
            //ale-notes/credit-cash/records
            console.log(
                "🚀 ~ file: sale_note_credit_cash.vue:30 ~ getRecords ~ response:",
                response
            );
        }
    }
};
</script>
