<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="rounded-dialog"
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.document_type_id }"
                        >
                            <label for="document_type">
                                <i class="far fa-id-card"></i> Tipo de Documento
                                <el-tooltip
                                    content="Campo Obligatorio"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-exclamation-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-select
                                v-model="form.identity_document_type_id"
                                :disabled="loading_submit"
                            >
                                <el-option
                                    v-for="(item, idx) in document_types"
                                    :key="idx"
                                    :label="item.description"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.document_type_id"
                                v-text="errors.document_type_id[0]"
                            >
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.number }"
                        >
                            <label for="document_number">
                                <i class="fas fa-list-ol"></i> Número de DNI/CE
                                <el-tooltip
                                    content="Campo Obligatorio"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-exclamation-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-input
                                v-model="form.number"
                                placeholder="Documento"
                                :disabled="loading_submit"
                                minlength="8"
                                maxlength="8"
                                show-word-limit
                                @input="validateNumbers('number')"
                            >
                                <el-button
                                    v-if="
                                        form.identity_document_type_id == 1 ||
                                            form.identity_document_type_id == 4
                                    "
                                    @click="searchDocument"
                                    slot="prepend"
                                    class="btn btn-primary"
                                    icon="el-icon-search"
                                >
                                </el-button>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.number"
                                v-text="errors.number[0]"
                            >
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.license }"
                        >
                            <label class="control-label"
                                >Numero de Licencia de Conducir
                            </label>
                            <el-input v-model="form.license">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.license"
                                v-text="errors.license[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name }"
                        >
                            <label for="name">
                                <i class="fas fa-tag"></i> Nombre
                                <el-tooltip
                                    content="Campo Obligatorio"
                                    placement="top"
                                >
                                    <i
                                        class="fas fa-exclamation-circle text-danger"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-input
                                v-model="form.name"
                                placeholder="Nombre"
                                :disabled="loading_submit"
                            >
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.name"
                                v-text="errors.name[0]"
                            >
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.telephone }"
                        >
                            <label class="control-label">telephone</label>
                            <el-input v-model="form.telephone">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.telephone"
                                v-text="errors.telephone[0]"
                            ></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button icon="fas fa-times fa-lg" @click.prevent="close()">
                    Cancelar</el-button
                >
                <el-button
                    icon="fas fa-save fa-lg"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                >
                    Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>
<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
export default {
    props: ["showDialog", "recordId", "document_types"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "drivers",
            errors: {},
            form: {},
            options: []
        };
    },
    watch: {
        "form.identity_document_type_id": function(newVal) {
            if (newVal !== null) {
                this.form.name = `${this.form.name || ""}`;
            }
        }
    },
    created() {
        this.initForm();
    },

    methods: {
        async searchDocument() {
            if (this.form.number === "") {
                Swal.fire({
                    icon: "warning",
                    title: "ALERTA",
                    text: "Ingresar el número a buscar",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            const documentTypeId = Number(this.form.identity_document_type_id);
            let identity_document_type_name;

            if (documentTypeId === 1) {
                identity_document_type_name = "dni";
            } else if (documentTypeId === 4) {
                identity_document_type_name = "ce";
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "ALERTA",
                    text: "Tipo de documento no reconocido.",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            try {
                let response;
                if (documentTypeId === 1) {
                    response = await this.$http.get(
                        `/service/${identity_document_type_name}/${this.form.number}`
                    );
                    this.form.name = response.data.data.nombre_completo;
                    console.log("Respuesta de DNI:", response.data);
                } else if (documentTypeId === 4) {
                    response = await this.$http.get(
                        `/search-ce/${this.form.number}`
                    );
                    console.log("Respuesta de CE:", response.data);
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "ERROR",
                    text: "Error de solicitud.",
                    timer: 2000,
                    showConfirmButton: false
                });
                console.error("Error de solicitud:", error);
            }
        },
        validateNumbers(field) {
            const value = this.form[field];
            if (/[^0-9]/.test(value)) {
                Swal.fire({
                    icon: "warning",
                    title: "ALERTA",
                    text: "Solo se permiten números.",
                    timer: 2000,
                    showConfirmButton: false
                });
                this.form[field] = value.replace(/[^0-9]/g, "");
            }
        },
        initForm() {
            this.errors = {};
            this.form = {
                identity_document_type_id: null,
                number: null,
                name: null,
                license: null,
                telephone: null
            };
        },
        create() {
            this.titleDialog = this.recordId
                ? "Editar Conductor"
                : "Nuevo Conductor";
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
            const formData = {
                ...this.form,
                identity_document_type_id: this.form.document_type_id
            };
            delete formData.document_type_id;
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
