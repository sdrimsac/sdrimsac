<template>
    <div class="card bg-ligth" v-loading="loading">
        <div class="row mt-2">
            <div class="col-12">
                <label class="label-control w-100">Plan Actual</label>
                <el-input :readonly="true" :value="plan.name"> </el-input>
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
        <template v-if="updatePlan">
            <div class="row mt-2">
                <div class="col-md-6">
                    <label for="document type">Plan nuevo</label>
                    <el-select v-model="form.plan_id" @change="changePrice">
                        <el-option
                            v-for="(data, idx) in plans"
                            :key="idx"
                            :label="data.capacity"
                            :value="data.id"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-6">
                    <label for="document type">Precio</label>
                    <el-select
                        v-model="variationId"
                        @change="updateNewPlanCost"
                    >
                        <el-option
                            v-for="(data, idx) in planVariations"
                            :key="idx"
                            :label="`${data.description} S/.${data.price}`"
                            :value="data.id"
                        >
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-5">
                    <label for="document type">Extras/Conceptos</label>
                    <el-select v-model="concept.id" @change="changeConcept">
                        <el-option
                            v-for="(data, idx) in concepts"
                            :key="idx"
                            :label="data.description"
                            :value="data.id"
                        >
                        </el-option>
                    </el-select>
                </div>

                <div class="col-md-5">
                    <label for="document type">Precio</label>
                    <el-select v-model="variationConceptId">
                        <el-option
                            v-for="(data, idx) in conceptVariations"
                            :key="idx"
                            :label="`${data.description} S/.${data.price}`"
                            :value="data.id"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-2 mt-sm-2  mb-sm-1 d-flex align-items-end">
                    <el-button
                        size="mini"
                        type="primary"
                        icon="el-icon-plus"
                        circle
                        @click="addConcept"
                    ></el-button>
                </div>
                <div
                    class="col-md-12 mt-1 table-responsive"
                    v-if="conceptsSelected.length != 0"
                >
                    <table class="table  table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Extra</th>
                                <th>Descripción</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(concept, idx) in conceptsSelected"
                                :key="idx"
                            >
                                <td>{{ idx + 1 }}</td>
                                <td>
                                    {{ concept.generalConcept }}
                                </td>
                                <td>
                                    {{ concept.description }}
                                </td>
                                <td>{{ concept.price }}</td>
                                <td>
                                    <el-button
                                        @click="removeConcept(idx)"
                                        type="danger"
                                        icon="el-icon-delete"
                                        circle
                                    ></el-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                
            </div>
        </template>
        <template v-else>
            <div class="row mt-1 ">
                <el-checkbox-group
                    v-model="monthsToPay"
                    disabled
                    class=" d-flex flex-wrap justify-content-center"
                    @change="payMonth"
                >
                    <el-checkbox-button
                        class="mt-1"
                        :class="m.isNew ? 'customcheck' : ''"
                        v-for="(m, idx) in monthsPayed"
                        :key="idx"
                        :label="m.start_date"
                        >{{
                            `${formatDate(m.start_date)} - ${formatDate(
                                m.end_date
                            )}`
                        }}</el-checkbox-button
                    >
                </el-checkbox-group>
            </div>
            <div class=" mt-1 d-flex justify-content-center">
                <el-button-group>
                    <el-button
                        type="primary"
                        icon="el-icon-circle-plus
"
                        @click="addPayment"
                        >Agregar pago</el-button
                    >
                    <el-button type="danger" @click="removePayment"
                        >Retirar Pago
                        <i class="el-icon-delete el-icon-right"></i
                    ></el-button>
                </el-button-group>
            </div>
        </template>
    </div>
</template>
<style>
.customcheck {
    background-color: #67c23a !important;
    border-color: #e1f3d8 !important;
}
.customcheck span {
    background-color: #67c23a !important;
    color: #ffffff !important;
}
</style>
<script>
import moment from "moment";
export default {
    props: ["registerId", "plan", "updatePlan"],

    data() {
        return {
            payments: [],
            passedDays: 0,
            leftDays: 0,
            conceptsSelected: [],
            newPlanCost: 0,
            concept: {},
            planVariations: [],
            conceptVariations: [],
            variationId: null,
            variationConceptId: null,
            plans: [],
            concepts: [],
            items: [],
            techs: [],
            serviceItem: null,
            dataReconnection: null,
            originalMonthsPayed: [],
            monthsPayed: [],
            monthsToPay: [],
            resource: "registers",
            loading: false,
            plans: [],
            date: moment(),
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
        removeConcept(idx) {
            this.conceptsSelected.splice(idx, 1);
            this.updateNewPlanCost();
        },
        updateNewPlanCost() {
            let [variation] = this.planVariations.filter(
                p => p.id == this.variationId
            );
            this.newPlanCost = Number(variation.price);
            if (this.conceptsSelected.length > 0) {
                this.conceptsSelected.forEach(c => {
                    this.newPlanCost += Number(c.price);
                });
            }

            this.updateTotal();
        },
        observationChange() {
            let [toPay] = this.calculateRestPlan();
            let observation = `CAMBIO DE PLAN: ${toPay} RESTA PAGAR DEL PLAN ANTERIOR\n`;
            return observation;
        },
        changeConcept() {
            let [concept] = this.concepts.filter(p => p.id == this.concept.id);

            this.conceptVariations = concept.variations;

            if (this.conceptVariations.length != 0) {
                this.variationConceptId = this.conceptVariations[0].id;
            } else {
                this.variationConceptId = null;
            }
        },
        addConcept() {
            let [concept] = this.conceptVariations.filter(
                cv => cv.id == this.variationConceptId
            );

            if (concept) {
                let { concept_id } = concept;
                let { description } = this.concepts.find(
                    c => c.id == concept_id
                );
                this.conceptsSelected = this.conceptsSelected.filter(
                    i => i.concept_id != concept.id
                );
                this.conceptsSelected.push({
                    ...concept,
                    generalConcept: description
                });
            }
            this.updateNewPlanCost();
        },
        changePrice() {
            let [plan] = this.plans.filter(p => p.id == this.form.plan_id);

            this.form.plan_price = plan.default_price;
            this.planVariations = plan.variations;

            if (this.planVariations.length != 0) {
                this.variationId = this.planVariations[0].id;
            } else {
                this.variationId = null;
            }
            if (this.variationId) {
                this.updateNewPlanCost();
            }
            // this.calculateTotal();
        },
        addPayment() {
            let end_date;
            let amount;
            let monthsNew = [];
            if (this.monthsPayed.length == 0) {
                end_date = this.plan.install_date;
                amount = this.plan.total;
            } else {
                let lastPayment = this.monthsPayed[this.monthsPayed.length - 1];
                monthsNew = this.monthsPayed.filter(m => m.isNew);
                amount = lastPayment.amount;
                if (this.dataReconnection && monthsNew.length == 0) {
                    end_date = this.dataReconnection;
                } else {
                    end_date = lastPayment.end_date;
                }
            }

            let newEndDate = moment(end_date).add(1, "month");

            if (
                monthsNew.length != 0 &&
                this.originalMonthsPayed.length == 12
            ) {
                this.monthsPayed = this.originalMonthsPayed.slice(
                    monthsNew.length + 1
                );
            }

            this.monthsPayed = [
                ...this.monthsPayed.filter(m => !m.isNew),
                ...monthsNew
            ];
            this.monthsPayed = [
                ...this.monthsPayed,
                {
                    amount,
                    start_date: end_date,
                    end_date: newEndDate,
                    isNew: true
                }
            ];
            this.monthsToPay.push(end_date);

            this.checkMonths();
            this.updateTotal();
        },
        changeInitialDate(date) {
            this.dataReconnection = date;
        },
        checkForIncomplete() {
            let observation = "";
            let incomplete = this.originalMonthsPayed.find(
                m => m.state == "incomplete"
            );
            if (this.originalMonthsPayed.length == 0 && incomplete == null) {
                let payment = this.payments[this.payments.length - 1];
                if (payment.type == "incomplete") {
                    incomplete = {};
                    incomplete.rest = payment.rest;
                    incomplete.start_date = this.plan.install_date;
                    incomplete.end_date = this.plan.install_date;
                }
            }
            if (incomplete) {
                if (incomplete.start_date == incomplete.end_date) {
                    observation = `Saldo pendiente de la instalacion ${moment(
                        incomplete.start_date
                    ).format("DD/MM/YYYY")}\n`;
                } else {
                    observation = `Saldo pendiente del periodo ${moment(
                        incomplete.start_date
                    ).format("DD/MM/YYYY")} - ${moment(
                        incomplete.end_date
                    ).format("DD/MM/YYYY")}\n`;
                }
            }
            return observation;
        },
        checkMonths() {
            let observation = this.checkForIncomplete();
            if (this.monthsToPay.length == 1) {
                let month = moment(this.monthsToPay[0]).format("DD/MM/YYYY");
                let nextMonth = moment(this.monthsToPay[0])
                    .add(1, "month")
                    .format("DD/MM/YYYY");
                observation += `Mensualidad de ${month} a ${nextMonth}`;
            } else if (this.monthsToPay.length == 0) {
                observation = "";
            } else {
                let month = moment(this.monthsToPay[0]).format("DD/MM/YYYY");
                let nextMonth = moment(
                    this.monthsToPay[this.monthsToPay.length - 1]
                )
                    .add(1, "month")
                    .format("DD/MM/YYYY");
                observation += `Mensualidad de ${month} a ${nextMonth}`;
            }
            observation = observation.toUpperCase();
            this.$emit("updateObservation", observation);
        },
        removePayment() {
            let hasNew = this.monthsPayed.some(m => m.isNew);
            if (hasNew) {
                let lastNew = this.monthsPayed.pop();
                let monthsNew = this.monthsPayed.filter(m => m.isNew);
                if (
                    monthsNew.length != 0 &&
                    this.originalMonthsPayed.length == 12
                ) {
                    this.monthsPayed = this.originalMonthsPayed.slice(
                        monthsNew.length
                    );
                }

                this.monthsPayed = [
                    ...this.monthsPayed.filter(m => !m.isNew),
                    ...monthsNew
                ];

                this.monthsToPay = this.monthsToPay.filter(
                    m => m != lastNew.start_date
                );

                this.checkMonths();
                this.updateTotal();

                if (monthsNew.length == 0) {
                    this.setIncompleteObservation();
                }
            }
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },

        payMonth(x) {},
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
        setPaymentMonths(months, payments = []) {
            this.originalMonthsPayed = months.reverse();
            this.payments = payments;
            this.monthsPayed = [...this.originalMonthsPayed];
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
            let today = moment();
            let installDate = moment(this.plan.install_date);

            if (today.year() == installDate.year()) {
                let month = installDate.month() + 1;
                this.months = this.months.map(m => {
                    if (m.id < month) {
                        m.disabled = true;
                    }
                    return m;
                });
            }
            let payments = this.plan.payments;
            let paidmonths = [];
            if (payments) {
                for (let i = 0; i < payments.length; i++) {
                    const payment = payments[i];
                    if (payment.type == "complete") {
                        paidmonths = [
                            ...paidmonths,
                            ...payment.months
                                .filter(m => {
                                    let dt = moment(m.year);
                                    if (today.year() == dt.year()) {
                                        return m;
                                    }
                                })
                                .map(m => m.month)
                        ];
                    } else {
                    }
                }
            }

            for (let m of paidmonths) {
                let month = this.months.find(mth => mth.id == m);
                if (month) {
                    month.disabled = true;
                }
            }
        },
        deepCopy(obj) {
            if (obj === null || typeof obj !== "object") {
                return obj;
            }

            let copy;

            if (obj instanceof Array) {
                copy = [];
                for (let i = 0; i < obj.length; i++) {
                    copy[i] = this.deepCopy(obj[i]);
                }
            } else {
                copy = {};
                for (let key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        copy[key] = this.deepCopy(obj[key]);
                    }
                }
            }

            return copy;
        },
        calculateRestPlan() {
            let total = this.plan.total;
            let month = this.originalMonthsPayed[
                this.originalMonthsPayed.length - 1
            ];
            let today = moment().startOf("day");
            let endDate = moment(month.end_date).startOf("day");
            let startDate = moment(month.start_date).startOf("day");
            let passed_days = endDate.diff(startDate, "days");
            let left_days = endDate.diff(today, "days"); // devuelve 1

            let totalPerDay = total / passed_days;
            let toPay = totalPerDay * (passed_days - left_days);


            return [toPay.toFixed(2), left_days, passed_days];
        },
        async updateTotal(localItem) {
            let items = [];

            if (this.monthsToPay.length > 0) {
                let plan = this.deepCopy(this.plan);
                let { item, name, total } = plan;
                item.sale_unit_price = total * this.monthsToPay.length;
                item.percentage_igv = 18;
                item.descriptionInternet = name;
                items.push(item);
            }
            let incomplete = this.originalMonthsPayed.find(
                m => m.state == "incomplete"
            );
            if (this.originalMonthsPayed.length == 0 && incomplete == null) {
                let payment = this.payments[this.payments.length - 1];
                if (payment.type == "incomplete") {
                    incomplete = {};
                    incomplete.rest = payment.rest;
                    incomplete.start_date = this.plan.install_date;
                    incomplete.end_date = this.plan.install_date;
                }
            }
            if (this.updatePlan) {
                let [toPay, left_days, passed_days] = this.calculateRestPlan();
                this.leftDays = left_days;
                this.passedDays = passed_days;
                let plan = this.deepCopy(this.plan);
                let { item, name } = plan;
                item.sale_unit_price = toPay;
                item.percentage_igv = 18;
                item.descriptionInternet = name + " (Saldo plan anterior)";
                items.push(item);
                let observation = `CAMBIO DE PLAN: ${toPay} RESTA PAGAR DEL PLAN ANTERIOR`;
                this.$emit("updateObservation", observation);
            }
            if (incomplete) {
                let plan = this.deepCopy(this.plan);
                let { item: incompleteItem } = plan;
                if (!incompleteItem) {
                    incompleteItem = localItem.item;
                }
                incompleteItem.sale_unit_price = incomplete.rest;
                incompleteItem.percentage_igv = 18;
                if (incomplete.start_date == incomplete.end_date) {
                    incompleteItem.descriptionInternet = `Saldo pendiente de la instalación ${moment(
                        incomplete.start_date
                    ).format("DD/MM/YYYY")}`;
                } else {
                    incompleteItem.descriptionInternet = `Saldo pendiente del periodo ${moment(
                        incomplete.start_date
                    ).format("DD/MM/YYYY")} - ${moment(
                        incomplete.end_date
                    ).format("DD/MM/YYYY")}`;
                }
                items.push(incompleteItem);

                if (localItem) {
                    this.setIncompleteObservation();
                }
            }

            let form = {
                operation_id: this.plan.operation_id,
                months: this.monthsToPay
            };

            if (this.updatePlan) {
                let perDay = this.newPlanCost / this.passedDays;
                let toPay = perDay * this.leftDays;
                form = {
                    rest: toPay,
                    operation_id: this.plan.operation_id,
                    update: true,
                    concepts: this.conceptsSelected,
                    plan_variation_id: this.variationId
                };
                if (
                    this.newPlanCost > 0 &&
                    this.leftDays > 0 &&
                    this.passedDays > 0
                ) {
                    let obs = this.observationChange();
                    let perDay = this.newPlanCost / this.passedDays;
                    let toPay = perDay * this.leftDays;
                    toPay = toPay.toFixed(2);
                    obs += `SALDO RESTANTE NUEVO PLAN ${toPay}\n`;
                    this.$emit("updateObservation", obs);
                }
            }

            this.$emit("createFormRegister", form);

            this.$emit("updateItems", items);
        },

        setIncompleteObservation() {
            let observation = this.checkForIncomplete().toUpperCase();
            if (this.updatePlan) {
                observation += "CAMBIO DE PLAN\n";
            }
            if (observation.length > 0) {
                this.$emit("updateObservation", observation);
            }
        },
        async getTables() {
            this.selectedMonths = [];
            this.monthsToPay = [];
            this.newPlanCost = 0;
            this.leftDays = 0;
            this.passedDays = 0;
            this.variationId = null;
            this.form = {};
            this.variationConceptId = null;
            this.conceptsSelected = [];
            try {
                const response = await this.$http("/internet/tables");

                const {
                    plans,
                    concepts,
                    items,
                    service_item,
                    techs
                } = response.data;
                this.plans = plans ?? [];
                this.concepts = concepts ?? [];
                this.items = items ?? [];
                this.techs = techs ?? [];
                this.serviceItem = service_item;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
