<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        :visible="showDialog"
        v-loading="loading"
        width="650px"
    >
        <div>
            <div class="row">
                <div class="col-md-6 col-12">
                    <label for="" class="label-control w-100"
                        >Descripción</label
                    >
                    <el-input v-model="form.description"> </el-input>
                </div>

                <div class="col-md-3 col-12">
                    <label for="" class="label-control w-100">
                        Tipo de cobro
                    </label>
                    <el-select v-model="form.type">
                        <el-option
                            value="percentage"
                            label="Porcentaje"
                        ></el-option>
                        <el-option value="amount" label="Monto fijo">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-3 col-12">
                    <label for="" class="label-control w-100">
                        {{
                            form.type == "percentage"
                                ? "Porcentaje %"
                                : "S/ Monto"
                        }}
                    </label>
                    <el-input-number
                        v-if="form.type == 'amount'"
                        style="width:100%;"
                        controls-position="right"
                        :precision="2"
                        :step="0.1"
                        v-model="form.percentage"
                    >
                    </el-input-number>
                    <el-input-number
                        v-else
                        style="width:100%;"
                        controls-position="right"
                        :precision="2"
                        :max="100"
                        :step="0.1"
                        v-model="form.percentage"
                    >
                    </el-input-number>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
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
            </div>
        </div>
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
            title: `Crear nuevo`,
            loading: false,
            form: {},
            timer: null,
            loading_search: false,
            items: [],
            price: null,
            loading_search_item: false,
            services: [],
            resource: "penalties",
            showFormCreateService: false
        };
    },
    async created() {
        await this.getTables();
    },
    methods: {
        openCreateService() {
            this.showFormCreateService = true;
        },
        add(data) {
            this.items = [...this.items, data];
            this.form.item_id = data.id;
            this.changeItem();
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `${this.resource}/tables`
                );
                const { items } = response.data;
                this.items = items;
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
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
        addItem() {
            let item = this.items.find(i => i.id == this.form.item_id);
            // let { id } = item;

            this.services = [item];
            // this.initItemForm();
        },
        changeItem() {
            this.addItem();
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
        async submit() {
            try {
                this.loading = true;
                this.form.services = this.services;
                const response = await this.$http.post(`penalties`, {
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
                console.log(response);
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
            this.form = {
                default_count: 1,
                type: "amount"
            };

            if (this.record) {
                console.log(this.record);
                this.form = { ...this.record };
                this.items = this.form.services.map(s => s.item);
                this.services = [...this.items];
                let [item] = this.items;
                this.form.item_id = item.id;
                this.title = `Editar penalidad`;
            } else {
                this.title = `Crear nueva penalidad`;
            }
        }
    }
};
</script>
