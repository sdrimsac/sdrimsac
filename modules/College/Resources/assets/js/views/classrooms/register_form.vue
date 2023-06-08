<template>
    <div>
        <div class="card bg-light" v-loading="loading">
            <div class="row">
                <div class="col-md-6 col-12">
                    <label class="label-control w-100"
                        >Apoderado
                        <a
                            href="#"
                            class="control-label font-weight-bold text-info"
                            @click="openCreateMember"
                        >
                            [ + Nuevo]</a
                        >

                        <a
                            v-if="form.parent_id"
                            href="#"
                            class="control-label font-weight-bold text-info"
                            @click="openCreateMember"
                        >
                            [ Editar]</a
                        >
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.parent_id"
                        filterable
                        remote
                        placeholder="Nombre o código interno"
                        :remote-method="searchRemoteParent"
                        :loading="loading_search_item"
                        @change="getMember"
                    >
                        <el-option
                            v-for="(parent, idx) in parents"
                            :key="idx"
                            :label="parent.person.name"
                            :value="parent.id"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-6 col-12">
                    <label class="label-control w-100">Estudiante</label>
                    <el-select
                        :disabled="!form.parent_id"
                        v-model="form.member_id"
                        @change="updateTotal"
                    >
                        <el-option
                            v-for="(member, idx) in members"
                            :key="idx"
                            :label="member.person.name"
                            :value="member.id"
                        >
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <label class="label-control w-100">Plan</label>
                    <el-select
                        slot="prepend"
                        v-model="form.plan_id"
                        @change="updateTotal"
                    >
                        <el-tooltip
                            v-for="(plan, idx) in plans"
                            :key="idx"
                            placement="left"
                            :disabled="!plan.validity_date"
                        >
                            <div slot="content">
                                Vence: {{ plan.validity_date }}
                            </div>
                            <el-option
                                :label="
                                    `${plan.name} ${plan.description} S/${plan.total}`
                                "
                                :value="plan.id"
                            ></el-option>
                        </el-tooltip>
                    </el-select>
                </div>
            </div>
        </div>
        <create-form
            :showDialog.sync="showCreateMemberForm"
            @memberCreated="memberCreated"
            :extern="true"
            :recordId="form.parent_id"
        >
        </create-form>
    </div>
</template>

<script>
import moment from "moment";
const CreateForm = () => import("../persons/form.vue");
const PaymentForm = () => import("../../components/payment_college.vue");
export default {
    props: ["showDialog", "record"],
    components: { CreateForm, PaymentForm },
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
