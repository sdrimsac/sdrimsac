<template>
    <div>
        <div class="card bg-light" v-loading="loading">
            <div class="row">
                <div class="col-md-12 col-12">
                    <label class="label-control w-100">Cliente </label>

                    <el-input v-model="form.person_id"></el-input>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: ["showDialog", "record"],
    data() {
        return {
            currentParent: null,
            testForm: {
                document_type_id: "01",
                difference: 16,
                customer_id: 1
            },

            showPaymentForm: false,
            showCreateMemberForm: false,
            title: `Crear nuevo`,
            loading: false,
            resource: "registers",
            form: {},
            periods: [],
            tab: "plan",
            students: [],
            items: [],
            loading_search_item: false,
            timer: null,
            parents: [],
            plans: [],
            members: [],
            price: null,
            percentage_igv: 18,
            affectationIgvTypes: [],
            establishment: null,
            methodPayment: null,
            user: null,
            currencyTypes: [],
            documentsType: [],
            company: null,
            categories: []
        };
    },
    async created() {
        await this.getTables();
    },
    methods: {
        initForm() {
            this.form = {};
        },
        updateTotal() {
            if (
                !this.form.plan_id ||
                !this.form.parent_id ||
                !this.form.member_id
            ) {
                return;
            }
            let plan = this.plans.find(p => p.id == this.form.plan_id);
            let items = [];
            if (plan) {
                items = plan.services.map(s => {
                    s.item.sale_unit_price = s.price;
                    s.item.percentage_igv = 18;

                    return s.item;
                });
            }
            let { name, description } = plan;
            let { id, parent, person } = this.members.find(
                m => m.id == this.form.member_id
            );

            let form = {
                member_id: id,
                plan_id: plan.id,
                first_pay: "2023-01-30",
                last_pay: "2023-01-30",
                payment_count: 1,
                active: 1,
                detail: { items }
            };
            this.$emit("createFormRegister", form);

            let observation = `${name} - ${description} `.toUpperCase();
            this.$emit("updateItems", items);
            this.$emit("updateObservation", observation);
            this.$emit("updateCustomer", parent.person);
            //member_id, plan_id, classroom_id, first_pay, last_pay, payment_count, active
            // this.$emit("updateTotal", total);
        },
        typeParent(type) {
            let types = {
                mother: "Madre:",
                father: "Padre:",
                attorney: "Apoderado:"
            };

            return types[type];
        },
        async memberCreated(number) {
            await this.searchRemoteParent(number);
        },
        editMember() {
            this.currentParent = this.form.parent_id;
            this.showCreateMemberForm = true;
        },
        openCreateMember() {
            this.currentParent = null;
            this.showCreateMemberForm = true;
        },
        searchRemoteParent(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `description=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/college/registers/parents?${parameters}`
                        );

                        this.parents = response.data;
                        if (this.parents.length != 0) {
                            let [parent] = this.parents;
                            setTimeout(async () => {
                                this.form.parent_id = parent.id;
                                await this.getMember();
                            });
                        }
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        async getMember() {
            if (!this.form.parent_id) {
                this.form.member_id = null;
                return;
            }

            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/college/persons/member/${this.form.parent_id}`
                );
                this.members = response.data;
                if (this.members.length != 0) {
                    let [member] = this.members;
                    this.form.member_id = member.id;
                } else {
                    this.form.member_id = null;
                }
                this.updateTotal();
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        initItemForm() {
            this.form.item_id = null;
            this.form.disabled = false;
            this.price = null;
        },
        deleteService(id) {
            this.services = this.services.filter(s => s.item_id != id);
        },
        changeItem() {
            let item = this.items.find(i => i.id == this.form.item_id);
            let { sale_unit_price } = item;

            this.price = Number(sale_unit_price).toFixed(2);
        },
        addItem() {
            let item = this.items.find(i => i.id == this.form.item_id);
            let { id } = item;

            if (this.services.some(s => s.item_id == id)) {
                return this.$toast.error("Ya agregó ese servicio");
            }
            this.services = [
                ...this.services,
                {
                    price: this.price,
                    item,
                    item_id: item.id
                }
            ];
            this.initItemForm();
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/documents/data-table/items?series=1&${parameters}`
                        );

                        this.items = response.data;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/college/${this.resource}/tables?register=1`
                );
                const { plans, parents } = response.data;
                this.plans = plans.map(r => ({
                    ...r,
                    total: r.services.reduce((a, b) => a + Number(b.price), 0)
                }));
                this.parents = parents;
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        },

        open() {
            this.form = {
                year: moment().year()
            };

            if (this.record) {
                let record = this.record;
                this.title = `Matricula ${record.level} | ${record.degree}-${record.section} | ${record.turn}`;
            } else {
                this.title = `Crear nuevo salón`;
            }
        }
    }
};
</script>
