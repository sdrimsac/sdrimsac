<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        :visible="showDialog"
        v-loading="loading"
    >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <label class="label-control w-100">Turno</label>
                        <el-select v-model="form.turn_id">
                            <el-option
                                v-for="(turn, idx) in turns"
                                :key="idx"
                                :label="turn.description"
                                :value="turn.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="label-control w-100">Nivel</label>
                        <el-select v-model="form.level_id">
                            <el-option
                                v-for="(level, idx) in levels"
                                :key="idx"
                                :label="level.description"
                                :value="level.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="label-control w-100">Grado</label>
                        <el-select v-model="form.degree_id">
                            <el-option
                                v-for="(degree, idx) in degrees"
                                :key="idx"
                                :label="degree.description"
                                :value="degree.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="label-control w-100">Sección</label>
                        <el-select v-model="form.section_id">
                            <el-option
                                v-for="(section, idx) in sections"
                                :key="idx"
                                :label="section.description"
                                :value="section.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3 col-12">
                        <label class="label-control w-100">
                            Cupos
                        </label>
                        <el-input-number v-model="form.places">
                        </el-input-number>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="label-control w-100">
                            Año
                        </label>
                        <el-input disabled v-model="form.year"> </el-input>
                    </div>
                </div>
            </div>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
import moment from "moment";
export default {
    props: ["showDialog", "record", "sections", "levels", "degrees", "turns"],
    data() {
        return {
            title: `Crear nuevo`,
            loading: false,
            resource: "classrooms",
            form: {},
            periods: [],
            tab: "plan",
            students: [],
            items: [],
            loading_search_item: false,
            timer: null,
            price: null
        };
    },
    async created() {
        // await this.getTables();
    },
    methods: {
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

        async submit() {
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
                    this.close();
                } else {
                    this.$toast.error(message);
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog");
        },
        open() {
            this.form = {
                year: moment().year()
            };

            if (this.record) {
                this.form = { ...this.record };
                this.title = `Editar salón`;
            } else {
                this.title = `Crear nuevo salón`;
            }
        }
    }
};
</script>
