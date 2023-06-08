<template>
    <div class="card bg-ligth" v-loading="loading">
        <div class="row mt-2">
            <div class="col-12">
                <label class="label-control w-100">Plan</label>
                <el-select v-model="form.plan_id" @change="changePlan">
                    <el-option
                        v-for="(plan, idx) in plans"
                        :key="idx"
                        :label="
                            `${plan.name} ${plan.description} S/${plan.total}`
                        "
                        :value="plan.id"
                    >
                    </el-option>
                </el-select>
                <label v-if="paymentDay" class="mt-2 label-control"
                    >Vencimiento:
                    <strong>
                        {{ `${paymentDay.split("/")[0]} de cada mes` }}</strong
                    ></label
                >
                <label
                    v-if="currentPlan && currentPlan.days_extension != 0"
                    class="text-primary"
                    style="font-weight:bold"
                >
                    / Prorroga:
                    <strong> {{ currentPlan.days_extension }} días </strong>
                </label>
            </div>
        </div>
        <div class="row mt-1 ">
            <el-checkbox-group
                :disabled="!form.plan_id"
                v-model="selectedMonths"
                class=" d-flex flex-wrap justify-content-center"
                @change="selectMonth"
            >
                <el-checkbox-button
                    class="mt-1"
                    v-for="m in months"
                    :disabled="m.disabled"
                    :label="m.id"
                    :key="m.id"
                    >{{ m.label }}</el-checkbox-button
                >
            </el-checkbox-group>
        </div>
        <div
            v-if="penalties.length != 0"
            class="row p-2 d-flex justify-content-center"
        >
            <table class="table-sm table-bordered border-danger w-75">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">
                            Mes
                        </th>
                        <th class="text-center">Días de retraso</th>
                        <th class="text-center">
                            Penalidad x día{{
                                currentPlan.penalty.type == "percentage"
                                    ? ` ${currentPlan.penalty.percentage} %`
                                    : ` S/ ${currentPlan.penalty.percentage}`
                            }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(penal, idx) in penalties" :key="idx">
                        <td class="text-center">{{ penal.label }}</td>
                        <td class="text-center">{{ penal.days }}</td>
                        <td class="text-center">
                            {{ penal.penalty.toFixed(2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">
                            <span class="bold">Total</span>
                        </td>
                        <td class="text-center">
                            {{
                                penalties
                                    .reduce((a, b) => a + Number(b.penalty), 0)
                                    .toFixed(2)
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import moment from "moment";
export default {
    props: ["member"],

    data() {
        return {
            resource: "registers",
            loading: false,
            plans: [],
            date: moment(),
            monthsPayed: [],
            paymentDay: null,
            form: {},
            currentPlan: null,
            penalties: [],
            limitDate: null,
            selectedMonths: [],
            months: [
                { id: 1, label: "Enero", disabled: false },
                { id: 2, label: "Febrero", disabled: false },
                { id: 3, label: "Marzo", disabled: false },
                { id: 4, label: "Abril", disabled: false },
                { id: 5, label: "Mayo", disabled: false },
                { id: 6, label: "Junio", disabled: false },
                { id: 7, label: "Julio", disabled: false },
                { id: 8, label: "Agosto", disabled: false },
                { id: 9, label: "Setiembre", disabled: false },
                { id: 10, label: "Octubre", disabled: false },
                { id: 11, label: "Noviembre", disabled: false },
                { id: 12, label: "Diciembre", disabled: false }
            ]
        };
    },
    async created() {
        // await this.getTables();
    },
    methods: {
        changePlan() {
            this.paymentDay = null;
            this.penalties = [];
            this.currentPlan = null;
            this.limitDate = null;
            this.selectedMonths = [];
            this.updateTotal();
        },
        //limit  es una fecha, con el mes y año actual, pero con el día del pago
        //date es la fecha actual
        //paymentday es solo el día
        //
        checkPenalty(date) {
            let { total, penalty, days_extension } = this.currentPlan;

            date = date.add(days_extension, "days");
            if (this.date.isAfter(date.add())) {
                if (penalty) {
                    let { percentage, type } = penalty;
                    percentage =
                        type == "percentage"
                            ? Number(percentage) / 100
                            : Number(percentage);
                    let totalPerDay =
                        type == "percentage" ? total * percentage : percentage;
                    let days = this.date.diff(date, "days");
                    let month = date.get("month") + 1;
                    let nameMonth = this.months.find(m => m.id == month).label;
                    this.penalties.push({
                        id: month,
                        days,
                        label: nameMonth,
                        penalty: days * totalPerDay
                    });
                }
            }
        },
        selectMonth() {
            this.penalties = [];
            if (this.paymentDay) {
                this.selectedMonths.forEach(sm => {
                    let date = moment(
                        `${sm}-${this.paymentDay}-${this.date.format("Y")}`
                    );
                    this.checkPenalty(date);
                });
            }
            this.updateTotal();
        },
        initForm() {
            this.currentPlan = null;
            this.penalties = [];
            this.paymentDay = null;
            this.form = {};
            this.months = [
                { id: 1, label: "Enero", disabled: false },
                { id: 2, label: "Febrero", disabled: false },
                { id: 3, label: "Marzo", disabled: false },
                { id: 4, label: "Abril", disabled: false },
                { id: 5, label: "Mayo", disabled: false },
                { id: 6, label: "Junio", disabled: false },
                { id: 7, label: "Julio", disabled: false },
                { id: 8, label: "Agosto", disabled: false },
                { id: 9, label: "Setiembre", disabled: false },
                { id: 10, label: "Octubre", disabled: false },
                { id: 11, label: "Noviembre", disabled: false },
                { id: 12, label: "Diciembre", disabled: false }
            ];
        },
        typeParent(type) {
            let types = {
                mother: "Madre:",
                father: "Padre:",
                attorney: "Apoderado:"
            };

            return types[type];
        },

        async setMonths() {
            this.months = [
                { id: 1, label: "Enero", disabled: false },
                { id: 2, label: "Febrero", disabled: false },
                { id: 3, label: "Marzo", disabled: false },
                { id: 4, label: "Abril", disabled: false },
                { id: 5, label: "Mayo", disabled: false },
                { id: 6, label: "Junio", disabled: false },
                { id: 7, label: "Julio", disabled: false },
                { id: 8, label: "Agosto", disabled: false },
                { id: 9, label: "Setiembre", disabled: false },
                { id: 10, label: "Octubre", disabled: false },
                { id: 11, label: "Noviembre", disabled: false },
                { id: 12, label: "Diciembre", disabled: false }
            ];
            if (this.form.plan_id) {
                let months = this.monthsPayed.filter(
                    m => m.plan_id == this.form.plan_id
                );

                months.forEach(m => {
                    this.months.find(n => n.id == m.month).disabled = true;
                });
            }
        },

        async updateTotal() {
            if (!this.form.plan_id) {
                return;
            }
            this.setMonths();
            let plan = this.plans.find(p => p.id == this.form.plan_id);

            let items = [];
            if (plan) {
                this.currentPlan = plan;
                if (plan.payment_date) {
                    this.paymentDay = plan.payment_date.split("/")[0];
                    this.limitDate = moment().set("date", this.paymentDay);
                }
                items = plan.services.map(s => {
                    s.item.sale_unit_price =
                        s.price * this.selectedMonths.length;
                    s.item.percentage_igv = 18;

                    return s.item;
                });
            } else {
                this.currentPlan = null;
                this.paymentDay = null;
                this.limitDate = null;
            }

            let { name, description } = plan;
            let { id, parent, person } = this.member;

            let observation = `${name} - ${description} ${
                this.selectedMonths.length != 0
                    ? `Meses: ${this.selectedMonths
                          .sort((a, b) => a - b)
                          .map(n => this.months.find(m => m.id == n).label)
                          .join("-")}`
                    : ""
            }`.toUpperCase();
            this.penalties.sort((a, b) => a.id - b.id);
            let totalPenalties = this.penalties.reduce(
                (a, b) => a + Number(b.penalty),
                0
            );
            let form = {
                member_id: id,
                plan_id: plan.id,
                first_pay: "2023-01-30",
                last_pay: "2023-01-30",
                payment_count: 1,
                active: 1,
                months: this.selectedMonths
            };
            if (this.currentPlan && this.currentPlan.penalty) {
                let penalties = this.currentPlan.penalty.services.map(s => {
                    s.item.sale_unit_price = totalPenalties;
                    s.item.percentage_igv = 18;

                    return s.item;
                });
                form.detail = { items, penalties };
                items = [...items, ...penalties];
            }

            this.$emit("createFormRegister", form);

            this.$emit("updateItems", items);

            this.$emit("updateObservation", observation);
            this.$emit("updateCustomer", parent.person);
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/college/${this.resource}/tables?service=1&member_id=${this.member.id}`
                );
                const { plans, months } = response.data;
                this.monthsPayed = months;
                this.setMonths();
                this.plans = plans.map(r => ({
                    ...r,
                    total: r.services.reduce((a, b) => a + Number(b.price), 0)
                }));
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
