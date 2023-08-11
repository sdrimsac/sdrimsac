<template>
    <el-dialog
        :visible="showDialog"
        close-on-click-modal
        append-to-body
        @open="open"
        @close="close"
        v-loading="loading"
        :title="title"
        width="75%"
    >
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plan</th>
                    <th>Pagado</th>
                    <th>Deuda</th>
                    <th>Penalidad</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(payment, idx) in registers" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>
                        {{ payment.plan.name }}-{{ payment.plan.description }}
                    </td>
                    <td>
                        {{ payment.paid.toFixed(2) }}
                    </td>
                    <td>
                        {{ (payment.rest || 0).toFixed(2) }}
                    </td>
                    <td v-if="payment.penalty">
                        {{ payment.penalty.toFixed(2) }}
                    </td>
                    <td v-else>-</td>
                    <td v-if="payment.penalty">
                        {{ (payment.penalty + (payment.rest || 0)).toFixed(2) }}
                    </td>
                    <td v-else>
                        {{ (payment.rest || 0).toFixed(2) }}
                    </td>
                    <td>
                        <el-button
                            v-if="payment.payments.length != 0"
                            type="primary"
                            @click="openFormPayments(payment)"
                        >
                            Ver Pagos
                        </el-button>
                        <el-button
                            v-if="payment.rest > 0"
                            type="success"
                            @click="openFormPayment(payment)"
                        >
                            Pagar
                        </el-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <payment-college
            type="incomplete"
            :plan="planForm"
            :register.sync="registerForm"
            :is_payment.sync="showPayment"
            @getRecords="getRecords"
            :services="servicesForm"
            :member="memberForm"
            :payable="payableForm"
        >
        </payment-college>
        <show-payments-form
            :title.sync="titlePayment"
            :showDialog.sync="showPayments"
            :payments="paymentsForm"
        >
        </show-payments-form>
    </el-dialog>
</template>

<script>
import moment from "moment";
const PaymentCollege = () => import("../components/payment_college.vue");
const ShowPaymentsForm = () => import("../components/show_payments.vue");
export default {
    components: { PaymentCollege, ShowPaymentsForm },
    props: ["member", "showDialog", "title"],
    data() {
        return {
            showPayment: false,
            loading: false,
            registers: [],
            resource: "registers",
            planForm: null,
            registerForm: null,
            servicesForm: [],
            paymentsForm: [],
            memberForm: null,
            showPayments: false,
            payableForm: null,
            date: moment(),
            titlePayment: ""
        };
    },
    methods: {
        openFormPayments(record) {
            this.showPayments = true;
            this.paymentsForm = record.payments;
            let [payment] = record.payments;
            if (payment) {
                let { document, sale_note } = payment;
                let doct = document ?? sale_note;
                console.log(doct);
                let [item] = doct.items;
                let name = item.item.description;
                this.titlePayment = `Pagos de ${name}`;
            } else {
                this.titlePayment = `Pagos de ${this.member.person.name}`;
            }
        },
        getRecords() {
            this.getRegisters();
            this.$emit("getRecords");
        },
        openFormPayment(record) {
            this.planForm = record.plan;
            this.registerForm = record;
            this.servicesForm = record.services;
            this.memberForm = this.member;
            this.payableForm = record.total - record.paid;
            this.showPayment = true;
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async open() {
            await this.getRegisters();
        },

        checkPenalty(plan, month, date) {
            let penalties = [];
            let { total, penalty, payment_date } = plan;
            if (!penalty) return;
            let paymentDay = payment_date.split("-")[2];
            // let date = moment(
            //     `${month}-${paymentDay}-${this.date.format("Y")}`
            // );
            if (this.date.isAfter(date)) {
                if (penalty) {
                    let { percentage, type } = penalty;
                    percentage =
                        type == "percentage"
                            ? Number(percentage) / 100
                            : Number(percentage);
                    let totalPerDay =
                        type == "percentage" ? total * percentage : percentage;
                    let days = this.date.diff(date, "days");
                    penalties.push(days * totalPerDay);
                }
            }

            return penalties.reduce((a, b) => a + b, 0);
        },
        async getRegisters() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/college/${this.resource}/records?member_id=${this.member.id}`
                );
                if (response.status == 200) {
                    const { data } = response.data;

                    this.registers = data.map(d => {
                        if (d.payments.length > 0) {
                            let lastPayment = d.payments[d.payments.length - 1];
                            let { items, penalties } = lastPayment.details;
                            let penaltiesAmount = 0;
                            if (penalties) {
                                penaltiesAmount = penalties.reduce(
                                    (a, b) => a + Number(b.sale_unit_price),
                                    0
                                );
                            }
                            let itemsAmount = 0;
                            itemsAmount = items.reduce(
                                (a, b) => a + Number(b.sale_unit_price),
                                0
                            );
                            d.rest =
                                itemsAmount +
                                (penaltiesAmount || 0) -
                                (lastPayment.document
                                    ? lastPayment.document.total
                                    : lastPayment.sale_note.total);
                            console.log(d.rest);
                        }

                        d.paid = d.payments.reduce((a, b) => {
                            if (b.sale_note) {
                                return a + parseFloat(b.sale_note.total);
                            } else {
                                return a + parseFloat(b.document.total);
                            }
                        }, 0);
                        // let times = d.plan.period.default_count;
                        d.total = d.services.reduce(
                            (a, b) => a + parseFloat(b.price),
                            0
                        );
                        let months = d.payments.reduce(
                            (a, b) => a + b.months.length,
                            0
                        );
                        d.total = d.total * (months == 0 ? 1 : months);
                        if (d.plan.penalty) {
                            let payment = d.payments[d.payments.length - 1];
                            if (payment) {
                                let { created_at } = payment;
                                let date = moment(created_at);
                                if (payment.months.length != 0) {
                                    let month = payment.months[0];
                                    d.penalty = this.checkPenalty(
                                        d.plan,
                                        month.month,
                                        date
                                    );
                                }
                            }
                        }

                        return d;
                    });
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
