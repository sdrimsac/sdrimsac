<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        append-to-body
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div
                        v-if="type !== 'caja/tables' && type !== 'caja/rooms'"
                        class="col-md-12"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label class="control-label">Descripción</label>
                            <el-input v-model="form.description"></el-input>
                            <small
                                class="text-danger"
                                v-if="errors.description"
                                v-text="errors.description[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        v-if="
                            type == 'caja/areas' &&
                                configurations.multiple_boxes === 1
                        "
                        class="col-md-6"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.printer }"
                        >
                            <label class="control-label">Impresora</label>
                            <el-input v-model="form.printer"> </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.printer"
                                v-text="errors.printer[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        v-if="
                            type == 'caja/areas' &&
                                configurations.multiple_boxes === 1
                        "
                        class="col-md-6"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.printer }"
                        >
                            <label class="control-label">Nº COPIAS</label>
                            <el-input v-model="form.copies"> </el-input>
                            <small
                                class="text-danger"
                                v-if="errors.copies"
                                v-text="errors.copies[0]"
                            ></small>
                        </div>
                    </div>
                    <template
                        v-if="type == 'caja/tables' || type == 'caja/rooms'"
                    >
                        <!-- <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.number }"
                            >
                                <label class="control-label"
                                    >Número de mesa</label
                                >
                                <el-input v-model="form.number"></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.number"
                                    v-text="errors.number[0]"
                                ></small>
                            </div>
                        </div> -->
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.tower_id }"
                            >
                                <label class="control-label">Torre</label>
                                <el-select
                                    v-model="form.tower_id"
                                    @change="filterFloorsByTower(form.tower_id)"
                                >
                                    <el-option
                                        v-for="(data, index) in towers"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.floor_id"
                                    v-text="errors.floor_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.floor_id }"
                            >
                                <label class="control-label">Piso</label>
                                <el-select v-model="form.floor_id">
                                    <el-option
                                        v-for="(data, index) in floors"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.floor_id"
                                    v-text="errors.floor_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.table_type_id }"
                            >
                                <label class="control-label">Tipo</label>
                                <el-select v-model="form.table_type_id">
                                    <el-option
                                        v-for="(data, index) in types"
                                        :key="index"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.table_type_id"
                                    v-text="errors.table_type_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'caja/rooms'">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.price }"
                            >
                                <label class="control-label">Precio</label>
                                <el-input
                                    v-model="form.price"
                                    type="number"
                                ></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.price"
                                    v-text="errors.price[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{
                                    'has-danger': errors.status_table_id
                                }"
                            >
                                <label class="control-label"
                                    >Estado de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-select v-model="form.status_table_id">
                                    <el-option
                                        v-for="(data, index) in statusTable"
                                        :key="index"
                                        :label="data.description"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.status_table_id"
                                    v-text="errors.status_table_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.area_id }"
                            >
                                <label class="control-label"
                                    >Área de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-select
                                    v-model="form.area_id"
                                    :disabled="type == 'caja/rooms'"
                                >
                                    <el-option
                                        v-for="(data, index) in areas"
                                        :key="index"
                                        :label="data.description"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="text-danger"
                                    v-if="errors.area_id"
                                    v-text="errors.area_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{
                                    'has-danger': errors.establishment_id
                                }"
                            >
                                <label class="control-label"
                                    >Establecimiento</label
                                >
                                <el-select v-model="form.establishment_id">
                                    <el-option
                                        v-for="(data, index) in establishments"
                                        :key="index"
                                        :label="data.description"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="text-danger"
                                    v-if="errors.establishment_id"
                                    v-text="errors.establishment_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label w-100"
                                    >Número inicial de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-input-number
                                    class="w-100"
                                    v-model="form.initNumberTable"
                                ></el-input-number>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label w-100"
                                    >Número final de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-input-number
                                    class="w-100"
                                    v-model="form.finalNumberTable"
                                ></el-input-number>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>

<script>
export default {
    props: [
        "showDialog",
        "recordId",
        "type",
        "types",
        "areas",
        "statusTable",
        "configurations",
        "establishments"
    ],
    data() {
        return {
            all_floors: [],
            floors: [],
            all_towers: [],
            towers: [],
            tower_id: null,
            loading_submit: false,
            titleDialog: null,
            resource: this.type,
            errors: {},
            form: {},
            options: []
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                price: null,
                tower_id: null,
                floor_id: null,
                table_type_id: null,
                status_table_id: null,
                area_id: null,
                establishment_id: null,
                description: null,
                printer: null,
                copies: null,
                active: 1
            };
        },

        filterFloorsByTower(tower_id) {
            this.form.floor_id = null;
            this.form.tower_id = tower_id;
            this.floors = this.all_floors.filter(f => {
                return f.tower_id == tower_id;
            });
        },
        async getTables() {
            const response = await this.$http("/caja/rooms/tables");
            if (response.status == 200) {
                const { towers, floors } = response.data;
                this.all_floors = floors;
                this.all_towers = towers;
                this.towers = towers;
                let [tower] = towers;
                this.form.tower_id = tower.id;

                this.filterFloorsByTower(tower.id);
            } else {
                this.$toast.warning("Ocurrió un error");
            }
        },
        create() {
            this.getTables();
            this.titleDialog = "Nuevo Registro Masivo";
            this.initForm();
            if (this.type == "caja/rooms") {
                let area = this.areas.find(
                    area => area.description.toUpperCase() == "HOTEL"
                );
                if (area) {
                    this.form.area_id = area.id;
                }

                let status = this.statusTable.find(
                    status => status.description.toUpperCase() == "LIBRE"
                );
                if (status) {
                    this.form.status_table_id = status.id;
                }

                if (this.types.length > 0) {
                    this.form.table_type_id = this.types[0].id;
                }
            }
        },
        valid() {
            let pass = true;
            let {
                initNumberTable,
                finalNumberTable,
                area_id,
                establishment_id
            } = this.form;

            if (initNumberTable > finalNumberTable) {
                this.$toast.error(
                    "El número inicial de mesa no puede ser mayor al número final de mesa"
                );
                pass = false;
            }

            if (area_id == null) {
                this.$toast.error("Debe seleccionar un área");
                pass = false;
            }
            if (establishment_id == null) {
                this.$toast.error("Debe seleccionar un establecimiento");
                pass = false;
            }

            return pass;
        },
        createNumbers() {
            let { initNumberTable, finalNumberTable } = this.form;
            let numbers = [];
            for (let i = initNumberTable; i <= finalNumberTable; i++) {
                numbers.push(i);
            }
            return numbers;
        },
        submit() {
            if (!this.valid()) {
                return;
            }
            this.loading_submit = true;
            this.form.numbers = this.createNumbers();
            this.$http
                .post(`/${this.resource}/massive`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
