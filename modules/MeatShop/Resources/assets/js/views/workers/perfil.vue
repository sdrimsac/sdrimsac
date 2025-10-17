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
                <div class="row g-3">
                    <!-- Campo Nombres / Apellidos -->
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.name }"
                        >
                            <label for="name">
                                <i class="fas fa-user"></i> Nombres / Apellidos
                            </label>
                            <el-input
                                v-model="form.name"
                                id="name"
                                placeholder="Ingrese los nombres y apellidos"
                                :class="{ 'is-invalid': errors.name }"
                                @input="convertToUppercase('name')"
                            ></el-input>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.name"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telephone">
                                <i class="fab fa-whatsapp"></i> Teléfono
                            </label>
                            <el-input
                                v-model="form.telephone"
                                id="telephone"
                                placeholder="Ingrese el teléfono"
                                @input="validateNumbers('telephone')"
                            ></el-input>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Imagen
                                <span class="text-danger"></span>
                            </label>
                            <el-upload
                                class="avatar-uploader"
                                :data="{ type: 'workers' }"
                                :headers="headers"
                                :action="`/caja/${resource}/uploads`"
                                :show-file-list="false"
                                :on-success="onSuccess"
                            >
                                <img
                                    v-if="form.image_url"
                                    :src="form.image_url"
                                    class="avatar"
                                />
                                <i
                                    v-else
                                    class="el-icon-plus avatar-uploader-icon"
                                ></i>
                            </el-upload>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <el-button
                    class="btn_cancelarsmall"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close"
                >
                    <span>Cancelar</span>
                </el-button>
                <el-button
                    class="btn_guardarsmall"
                    icon="fas fa-save fa-lg"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                >
                    <span>Guardar</span>
                </el-button>



                
            </div>
        </form>
    </el-dialog>
</template>
<script>
import { serviceNumber } from "../../../../../../../resources/js/mixins/functions";
export default {
    mixins: [serviceNumber],
    props: [
        "showDialog",
        "recordId",
        "areas",
        "workersType",
        "establishments",
        "configuration"
    ],
    data() {
        return {
            form: {
                workers: true,
            },
            loading_submit: false,
            loading_search: false,
            titleDialog: null,
            resource: "workers",
            headers: headers_token,
            image_url: null
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        onSuccess(response, file, fileList) {
            if (response.success) {
                this.form.image = response.data.filename;
                this.form.image_url = response.data.temp_image;
                this.form.temp_path = response.data.temp_path;
            } else {
                this.$toast.error(response.message);
            }
        },
        // Validar números en tiempo real
        validateNumbers(field) {
            const value = this.form[field];
            if (/[^0-9]/.test(value)) {
                Swal.fire({
                    icon: "warning",
                    title: "Solo se permiten números.",
                    timer: 2000,
                    showConfirmButton: false
                });
                this.form[field] = value.replace(/[^0-9]/g, ""); // Reemplazar caracteres no válidos
            }
        },

        // Convertir texto a mayúsculas en tiempo real
        convertToUppercase(field) {
            this.form[field] = this.form[field].toUpperCase();
        },

        // Inicializar el formulario
        initForm() {
            this.errors = {};
            this.form = {
                workers: true,
                identity_document_type_id: "1",
                number: "",
                name: "",
                worker_type_id: null,
                area_id: null,
                establishment_id: null,
                telephone: null,
                can_accept_credit_sale_note: false,
                is_arca: false,
                active: 1
            };
        },

        // Enviar formulario
        submit() {
            if (!this.validateForm()) {
                // Opcional: mostrar mensaje general de error
                Swal.fire({
                    icon: "warning",
                    title: "Por favor complete los campos obligatorios.",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            this.loading_submit = true;

            this.$http
                .post(`${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Formulario enviado correctamente.",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: response.data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error(error);
                    }
                })
                .finally(() => {
                    this.loading_submit = false;
                });
        },

        // Cerrar modal
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },

        // Crear o cargar datos en el formulario
        create() {
            this.titleDialog = this.recordId
                ? "Editar Usuario del Sistema"
                : "Nuevo Usuario del Sistema";

            if (this.recordId) {
                this.$http
                    .get(`${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.form.is_arca = this.form.is_arca === 1;
                        this.form.can_accept_credit_sale_note =
                            this.form.can_accept_credit_sale_note === 1;
                    });
            } else {
                this.initForm();
            }
        },
        // Validar formulario según tipo de usuario
        validateForm() {
            this.errors = {};
            // Ajusta el campo y valores según tu lógica de roles
            // Ejemplo: si tienes form.user_type o form.worker_type_id
            const adminRoles = ["Administrador", "Contador", "Soporte"];
            // Suponiendo que tienes form.user_type con el nombre del rol
            // Si usas IDs, reemplaza los valores por los IDs correspondientes
            const isAdmin = adminRoles.includes(this.form.user_type);

            let valid = true;

            // Validar nombre
            if (!this.form.name || !this.form.name.trim()) {
                this.errors.name = true;
                valid = false;
            }

            // Solo validar estos campos si NO es admin/contador/soporte
            if (!isAdmin) {
                if (!this.form.worker_type_id) {
                    this.errors.worker_type_id = true;
                    valid = false;
                }
                if (!this.form.user_type) {
                    this.errors.user_type = true;
                    valid = false;
                }
                if (!this.form.area_id) {
                    this.errors.area_id = true;
                    valid = false;
                }
            }

            return valid;
        },
    }
};
</script>
