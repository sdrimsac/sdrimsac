<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
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
                        <div class="col-md-4">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.number }"
                            >
                                <label class="control-label"
                                    >Número de
                                    {{
                                        type == "caja/tables"
                                            ? "mesa"
                                            : "habitación"
                                    }}</label
                                >
                                <el-input v-model="form.number"></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.number"
                                    v-text="errors.number[0]"
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
                                        :label="data.description"
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
                                :class="{ 'has-danger': errors.type_id }"
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
                                    v-if="errors.type_id"
                                    v-text="errors.type_id[0]"
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
                                <el-select v-model="form.area_id">
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
        "types",
        "type",
        "areas",
        "statusTable",
        "configurations",
        "establishments"
    ],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: this.type,
            errors: {},
            form: {},
            options: [],
            floors: [
                {
                    id: 1,
                    description: "Piso 1"
                },
                {
                    id: 2,
                    description: "Piso 2"
                },
                {
                    id: 3,
                    description: "Piso 3"
                },
                {
                    id: 4,
                    description: "Piso 4"
                },
                {
                    id: 5,
                    description: "Piso 5"
                },
                {
                    id: 6,
                    description: "Piso 6"
                },
                {
                    id: 7,
                    description: "Piso 7"
                },
                {
                    id: 8,
                    description: "Piso 8"
                },
                {
                    id: 9,
                    description: "Piso 9"
                },
                {
                    id: 10,
                    description: "Piso 10"
                }
            ]
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
                description: null,
                printer: null,
                copies: null,
                active: 1
            };
        },
        create() {
            this.titleDialog = this.recordId
                ? "Modificar Registro"
                : "Nuevo Registro";
            this.initForm();
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                    });
            }
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
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
