<template>
    <el-dialog
        :title="title"
        append-to-body
        :visible="showDialog"
        @open="open"
        @close="close"
    >
        <div class="card">
            <div class="row mt-5">
                <table v-if="payments.length > 0" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Penalidad</th>
                            <th>Total</th>
                            <th>Pagó</th>
                            <th>Resta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(payment, idx) in records" :key="idx">
                            <td>{{ idx + 1 }}</td>
                            <td>{{ payment.date_of_issue }}</td>
                            <td>{{ payment.items.toFixed(2) }}</td>
                            <td v-if="payment.penalties">
                                {{ payment.penalties.toFixed(2) }}
                            </td>
                            <td v-else>0.00</td>
                            <td>
                                {{ payment.total.toFixed(2) }}
                            </td>
                            <td>{{ payment.document.total }}</td>
                            <td>
                                {{
                                    (
                                        payment.total - payment.document.total
                                    ).toFixed(2)
                                }}
                            </td>
                            <td>
                                <el-button
                                    @click="viewDocument(payment.a4)"
                                    type="secondary"
                                    size="mini"
                                >
                                    A4 PDF
                                </el-button>
                                <el-button
                                    @click="viewDocument(payment.ticket)"
                                    type="secondary"
                                    size="mini"
                                >
                                    TICKET PDF
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center" v-else>
                    <span>SIN PAGOS MENSUALES</span>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "payments", "title"],
    data() {
        return {
            records: []
        };
    },
    methods: {
        viewDocument(url) {
            window.open(url);
        },
        open() {
            this.records = this.payments.map(p => {
                if (p.sale_note) {
                    p.document = p.sale_note;
                    p.a4 = `/sale-notes/print/${p.sale_note.external_id}/a4`;
                    p.ticket = `/sale-notes/print/${p.sale_note.external_id}/ticket`;
                } else {
                    p.a4 = `/print/document/${p.document.external_id}/a4`;
                    p.ticket = `/print/document/${p.document.external_id}/ticket`;
                }
                if (!p.date_of_issue) {
                    p.date_of_issue = moment(p.document.date_of_issue).format(
                        "DD/MM/YYYY"
                    );
                }
                let { items, penalties } = p.details;

                if (penalties) {
                    p.penalties = penalties.reduce(
                        (a, b) => a + Number(b.sale_unit_price),
                        0
                    );
                }
                p.items = items.reduce(
                    (a, b) => a + Number(b.sale_unit_price),
                    0
                );
                p.total = p.items + (p.penalties || 0);
                return {
                    ...p
                };
            });
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
