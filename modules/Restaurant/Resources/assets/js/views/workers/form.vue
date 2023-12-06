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
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.number }"
                        >
                            <label class="control-label">DNI</label>
                            <el-input v-model="form.number" :maxlength="8">
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.number"
                                v-text="errors.number[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name }"
                        >
                            <label class="control-label"
                                >Nombres / Apellidos</label
                            >
                            <el-input v-model="form.name"> </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.name"
                                v-text="errors.name[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.worker_type_id }"
                        >
                            <label class="control-label"
                                >Tipo de trabajador</label
                            >
                            <el-select v-model="form.worker_type_id">
                                <el-option
                                    v-for="(data, index) in workersType"
                                    :key="index"
                                    :label="data.description"
                                    :value="data.id"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.worker_type_id"
                                v-text="errors.worker_type_id[0]"
                            ></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.area_id }"
                        >
                            <label class="control-label">Área de trabajo</label>
                            <el-select v-model="form.area_id">
                                <el-option
                                    v-for="(data, index) in areas"
                                    :key="index"
                                    :label="data.description"
                                    :value="data.id"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.area_id"
                                v-text="errors.area_id[0]"
                            ></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.establishment_id }"
                        >
                            <label class="control-label">Establecimiento</label>
                            <el-select v-model="form.establishment_id">
                                <el-option
                                    v-for="(data, index) in establishments"
                                    :key="index"
                                    :label="data.description"
                                    :value="data.id"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.establishment_id"
                                v-text="errors.establishment_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.telephone }"
                        >
                            <label class="control-label">Teléfono</label>
                            <el-input v-model="form.telephone"> </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.telephone"
                                v-text="errors.telephone[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="product"
                            >Establecimiento productos
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Establecimiento desde el cual obtendrá los productos"
                                placement="top"
                            >
                                <i class="fas fa-info-circle"></i>
                            </el-tooltip>
                        </label>
                        <el-select v-model="form.warehouse_product_id">
                            <el-option
                                v-for="(data, index) in allWarehouses"
                                :key="index"
                                :label="data.description"
                                :value="data.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4">
                        <label for="product"
                            >Establecimiento mesa
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Establecimiento desde el cual obtendrá las mesas"
                                placement="top"
                            >
                                <i class="fas fa-info-circle"></i>
                            </el-tooltip>
                        </label>
                        <el-select v-model="form.establishment_table_id">
                            <el-option
                                v-for="(data, index) in allEstablishments"
                                :key="index"
                                :label="data.description"
                                :value="data.id"
                            ></el-option>
                        </el-select>
                    </div>
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
        "areas",
        "workersType",
        "establishments",
        "allEstablishments",
        "allWarehouses"
    ],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "workers",
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
                description: null,
                telephone: null,
                active: 1,
                establishment_id: this.establishments[0].id
            };
        },
        create() {
            this.titleDialog = this.recordId ? "Editar " : "Nuevo ";
            if (this.recordId) {
                this.$http
                    .get(`${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                    });
            }
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`${this.resource}`, this.form)
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
