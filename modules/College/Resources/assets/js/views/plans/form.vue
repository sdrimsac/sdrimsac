<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        :visible="showDialog"
        v-loading="loading"
    >
        <el-tabs tab-position="top" v-model="tab">
            <el-tab-pane name="plan" label="Datos del plan">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label>Nombre</label>
                                <el-input v-model="form.name"> </el-input>
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Descripción</label>
                                <el-input v-model="form.description">
                                </el-input>
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Periodo</label>
                                <el-select v-model="form.period_id">
                                    <el-option
                                        v-for="(period, idx) in periods"
                                        :key="idx"
                                        :label="period.description"
                                        :value="period.id"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Tipo</label>
                                <el-select v-model="form.type_id">
                                    <el-option
                                        v-for="(type, idx) in types"
                                        :key="idx"
                                        :label="type.description"
                                        :value="type.id"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-6 col-12 mt-1">
                                <label class="label-control w-100"
                                    >Penalidad</label
                                >
                                <el-select
                                    v-model="form.penalty_id"
                                    @change="changePenalty"
                                >
                                    <el-option
                                        v-for="(penalty, idx) in penalties"
                                        :key="idx"
                                        :label="penalty.description"
                                        :value="penalty.id"
                                    >
                                    </el-option>
                                </el-select>
                                <small
                                    class="text-primary"
                                    v-if="currentPenalty"
                                    >{{ currentPenalty }}</small
                                >
                            </div>
                            <div
                                v-if="form.penalty_id"
                                class="col-md-6 col-12 mt-1"
                            >
                                <label for="" class="label-control w-100">
                                    Días de prorroga
                                </label>
                                <el-input-number
                                    style="width:100%;"
                                    :precision="0"
                                    controls-position="right"
                                    v-model="form.days_extension"
                                >
                                </el-input-number>
                            </div>
                            <div class="col-md-6 col-12 mt-1">
                                <label class="label-control w-100"
                                    >Fecha de pago</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    format="dd/MM/yyyy"
                                    value-format="yyyy-MM-dd"
                                    v-model="form.payment_date"
                                >
                                </el-date-picker>
                            </div>
                            <div class="col-md-6 col-12 mt-1">
                                <label class="label-control w-100"
                                    >Vigencia</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    format="dd/MM/yyyy"
                                    value-format="yyyy-MM-dd"
                                    v-model="form.validity_date"
                                >
                                </el-date-picker>
                            </div>
                        </div>
                    </div></div
            ></el-tab-pane>
            <el-tab-pane name="service" label="Servicios">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="control-label w-100"
                                    >Servicio
                                    <a
                                        href="#"
                                        class="control-label font-weight-bold text-info"
                                        @click="openCreateService"
                                    >
                                        [ + Nuevo]</a
                                    >
                                </label>
                                <el-select
                                    class="w-100"
                                    v-model="form.item_id"
                                    filterable
                                    remote
                                    popper-class="el-select-customers"
                                    clearable
                                    placeholder="Nombre o código interno"
                                    :remote-method="searchRemoteItems"
                                    :loading="loading_search_item"
                                    @change="changeItem"
                                >
                                    <el-option
                                        v-for="option in items"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="control-label w-100"
                                    >Precio</label
                                >
                                <el-input
                                    v-model="price"
                                    :disabled="!disabled"
                                ></el-input
                                ><br />
                                <el-checkbox
                                    v-if="form.item_id"
                                    class="mt-1"
                                    v-model="disabled"
                                    >Editar</el-checkbox
                                >
                            </div>
                            <div class="col-md-3 ">
                                <label
                                    for=""
                                    class="control-label w-100"
                                ></label>
                                <el-button @click="addItem">
                                    Agregar
                                </el-button>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Costo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(service, idx) in services"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ service.item.description }}</td>
                                        <td>{{ service.price }}</td>
                                        <td>
                                            <el-button
                                                type="danger"
                                                size="mini"
                                                icon="el-icon-delete"
                                                circle
                                                @click="
                                                    deleteService(
                                                        service.item.id
                                                    )
                                                "
                                            ></el-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
        <form-service
            @add="add"
            :showDialog.sync="showFormCreateService"
        ></form-service>
    </el-dialog>
</template>

<script>
const FormService = () => import("./../../components/service_create.vue");
export default {
    components: {
        FormService
    },
    props: ["showDialog", "record"],
    data() {
        return {
            showFormCreateService: false,
            title: `Crear nuevo`,
            loading: false,
            resource: "plans",
            form: {},
            periods: [],
            tab: "plan",
            services: [],
            items: [],
            loading_search_item: false,
            timer: null,
            price: null,
            penalties: [],
            types: [],
            currentPenalty: null,
            disabled: false
        };
    },
    async created() {
        await this.getTables();
    },
    methods: {
        changePenalty() {
            let { penalty_id } = this.form;
            if (penalty_id) {
                let penalty = this.penalties.find(p => p.id == penalty_id);
                console.log(penalty);
                let { type, percentage } = penalty;
                if (type == "percentage") {
                    this.currentPenalty = `Por día: ${percentage} %`;
                } else {
                    this.currentPenalty = `Por día: S/ ${percentage}`;
                }
            }
        },
        add(data) {
            this.items = [...this.items, data];
            this.form.item_id = data.id;
            this.changeItem();
        },
        openCreateService() {
            this.showFormCreateService = true;
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
            // let { id } = item;

            // if (this.services.some(s => s.item_id == id)) {
            //     return this.$toast.error("Ya agregó ese servicio");
            // }
            this.services = [
                // ...this.services,
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
                            `/documents/data-table/items?service=1&${parameters}`
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
                    `${this.resource}/tables`
                );
                const { periods, items, types, penalties } = response.data;
                this.items = items;
                this.penalties = penalties;
                this.periods = periods;
                this.types = types;
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        },
        validate() {
            let fail = false;
            let {
                name,
                description,
                period_id,
                type_id,
                payment_date
            } = this.form;
            if (this.services.length == 0) {
                this.$toast.error("Debe agregar un servicio");
                fail = true;
            }
            if (!name) {
                this.$toast.error("Debe ingresar un nombre");
                fail = true;
            }

            if (!description) {
                this.$toast.error("Debe ingresar una descripción");
                fail = true;
            }
            if (!period_id) {
                this.$toast.error("Debe elegir un periodo");
                fail = true;
            }
            if (!type_id) {
                this.$toast.error("Debe elegir un tipo");
                fail = true;
            }

            if (type_id == 2) {
                if (!payment_date) {
                    this.$toast.error("La fecha de pago es obligatoria");
                    fail = true;
                }
            }
            return fail;
        },
        async submit() {
            if (this.validate()) {
                return;
            }
            try {
                this.loading = true;
                this.form.services = this.services;
                const response = await this.$http.post(`${this.resource}`, {
                    ...this.form,
                    id: this.record ? this.record.id : null
                });
                const { message, success } = response.data;
                if (success) {
                    this.$toast.success(message);
                    this.$emit("getRecords");
                } else {
                    this.$toast.error(message);
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
                this.close();
            }
        },
        close() {
            this.$emit("update:showDialog");
        },
        open() {
            this.currentPenalty = null;
            this.services = [];
            this.price = null;
            this.form = {
                default_count: 1,
                days_extension: 0
            };

            if (this.record) {
                this.form = { ...this.record };
                // this.form.penalty_id = this.form.penalty.id;
                this.services = [...this.form.services];
                if (this.form.payment_date) {
                    this.form.payment_date = this.form.payment_date
                        .split("/")
                        .reverse()
                        .join("-");
                    this.changePenalty();
                }

                this.title = `Editar plan`;
            } else {
                this.title = `Crear nuevo plan`;
            }
        }
    }
};
</script>
