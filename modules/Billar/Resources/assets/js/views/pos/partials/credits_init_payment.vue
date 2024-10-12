<template>
    <el-dialog
        :visible="showDialog"
        width="30%"
        title="Registrar pagos anteriores"
        @close="close"
        @open="open"
        append-to-body
        v-loading="loading"
    >
        <div class="row table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cuota</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr v-for="(payment, idx) in payments" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>
                            {{ payment.date_payment }}
                        </td>
                        <td>
                            {{ payment.amount }}
                        </td>
                        <td>
                            <template v-if="payment.paid == 0">
                                <el-input
                                    :disabled="checkDisabled(idx)"
                                    v-model="payment.init_amount"
                                >
                                </el-input>
                            </template>
                            <template v-else>
                                {{ payment.amount_paid }}
                            </template>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            loading: false,
            form: {
                total: 0,
                balance: 0,
                customer_id: null,
                credit_line: 0,
                has_credit_line: false
            },
            customers: [],
            input_person: {
                number: null
            },
            payments: []
        };
    },
    methods: {
        checkDisabled(idx) {
            if (idx === 0) {
                return false;
            }

            let previousItem = this.array[idx - 1];
            if (previousItem.paid === 1) {
                return true;
            }

            if (previousItem.paid === 0 && previousItem.init_amount > 0) {
                return true;
            }

            return false;
        },
        async getPayments() {
            const response = await this.$http(
                `/sale-notes/payments-init/${this.recordId}`
            );
            if (response.status == 200) {
                let { data } = response;
                this.payments = data.payments;
                this.payments = this.payments.map(p => ({
                    ...p,
                    init_amount: 0
                }));
            }
            console.log("🚀 ~ getPayments ~ response:", response);
        },
        async open() {
            await this.getPayments();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
