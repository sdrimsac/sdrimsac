<template>
    <div class="card">
        <div class="row mt-2">
            <div class="col-12">
                <label class="label-control w-100">Plan</label>
                <el-select v-model="form.plan_id" disabled>
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["plan", "register", "services", "member", "payable"],
    data() {
        return {
            loading: false,
            form: {},
            plans: [this.plan],
            resource: "payments"
        };
    },
    created() {},
    methods: {
        typeParent(type) {
            let types = {
                mother: "Madre:",
                father: "Padre:",
                attorney: "Apoderado:"
            };

            return types[type];
        },
        initForm() {},
        updateTotal() {
            if (!this.form.plan_id) {
                return;
            }

            let { payments, penalty, rest } = this.register;

            let lastPayment = payments[payments.length - 1];
            let {
                details: { items: paymentItems, penalties: paymentPenalties }
            } = lastPayment;
            let detail = {};
            let items = paymentItems.map(s => {
                s.sale_unit_price = rest;
                s.percentage_igv = 18;

                return s;
            });
            detail.items = items;
            let penalties = [];
            if (paymentPenalties) {
                penalties = paymentPenalties.map(s => {
                    s.sale_unit_price = penalty || 0;
                    s.percentage_igv = 18;

                    return s;
                });
            }
            detail.penalties = penalties;

            this.$emit("createFormRegister", { detail });
            items = [...items, ...penalties];
            let { name, description } = this.plan;
            let { parent, person } = this.member;

            let observation = `${name} - ${description} `.toUpperCase();

            console.log(items);
            this.$emit("updateItems", items);
            this.$emit("updateObservation", observation);
            this.$emit("updateCustomer", parent.person);
        },
        async getTables() {
            setTimeout(() => {
                this.plan.total = this.services.reduce(
                    (a, b) => a + parseFloat(b.price),
                    0
                );
                this.form.plan_id = this.plan.id;
                this.$forceUpdate();
                this.updateTotal();
            }, 250);
        }
    }
};
</script>
