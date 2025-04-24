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
                    <!-- Campo DNI -->
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.number }"
                        >
                            <label for="dni">
                                <i class="far fa-id-card"></i> DNI
                            </label>
                            <el-input
                                v-model="form.number"
                                :maxlength="8"
                                id="dni"
                                placeholder="Ingrese el DNI"
                                :class="{ 'is-invalid': errors.number }"
                                @input="validateNumbers('number')"
                            >
                                <el-button
                                    slot="append"
                                    :loading="loading_search"
                                    icon="el-icon-search"
                                    @click.prevent="searchWorker"
                                    type="primary"
                                ></el-button>
                            </el-input>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.number"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>

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

                    <!-- Tipo de Trabajador -->
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.worker_type_id }"
                        >
                            <label for="worker_type">
                                <i class="fas fa-toolbox"></i> Tipo de
                                Trabajador
                            </label>
                            <el-select
                                v-model="form.worker_type_id"
                                id="worker_type"
                                placeholder="Seleccione el tipo de trabajador"
                                :class="{ 'is-invalid': errors.worker_type_id }"
                            >
                                <el-option
                                    v-for="(data, index) in workersType"
                                    :key="index"
                                    :value="data.id"
                                    :label="data.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.worker_type_id"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.worker_type_id }"
                        >
                            <label for="type">
                                <i class="fas fa-toolbox"></i> Tipo usuario
                            </label>
                            <el-select
                                v-model="form.worker_type_id"
                                id="worker_type"
                                placeholder="Seleccione el tipo de trabajador"
                                :class="{ 'is-invalid': errors.worker_type_id }"
                            >
                                <el-option
                                    v-for="(data, index) in workersType"
                                    :key="index"
                                    :value="data.id"
                                    :label="data.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.worker_type_id"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>

                    <!-- Área de Trabajo -->
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.area_id }"
                        >
                            <label for="area">
                                <i class="fa-solid fa-layer-group"></i> Área de
                                Trabajo
                            </label>
                            <el-select
                                v-model="form.area_id"
                                id="area"
                                placeholder="Seleccione el área de trabajo"
                                :class="{ 'is-invalid': errors.area_id }"
                            >
                                <el-option
                                    v-for="(data, index) in areas"
                                    :key="index"
                                    :value="data.id"
                                    :label="data.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.area_id"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>

                    <!-- Establecimiento -->
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.establishment_id }"
                        >
                            <label for="establishment">
                                <i class="fas fa-store"></i> Establecimiento
                            </label>
                            <el-select
                                v-model="form.establishment_id"
                                id="establishment"
                                placeholder="Seleccione un establecimiento"
                                :class="{
                                    'is-invalid': errors.establishment_id
                                }"
                            >
                                <el-option
                                    v-for="(data, index) in establishments"
                                    :key="index"
                                    :value="data.id"
                                    :label="data.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback text-danger"
                                v-if="errors.establishment_id"
                            >
                                Ingreso Obligatorio
                            </small>
                        </div>
                    </div>

                    <!-- Teléfono -->
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
                        <i class="fas fa-cube"></i>
                        <!-- Icono de producto -->
                        <i class="fas fa-store-alt"></i>
                        <!-- Icono de sucursal -->
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
                        <i class="fas fa-chair"></i>
                        <!-- Icono de mesa -->
                        <i class="fas fa-store-alt"></i>
                        <!-- Icono de establecimiento -->
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

                    <!-- Créditos en Notas de Venta -->
                    <div
                        class="col-md-4"
                        v-if="configuration.sale_note_credit_confirm"
                    >
                        <label for="credit_sales">
                            <i class="far fa-credit-card"></i> Créditos en Notas
                            de Venta
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Permite que el usuario acepte créditos en el modo 'CREDITOS' en Nota de Venta"
                                placement="top"
                            >
                                <i class="fas fa-info-circle"></i>
                            </el-tooltip>
                        </label>
                        <el-checkbox
                            v-model="form.can_accept_credit_sale_note"
                            id="credit_sales"
                            label="Acepta Créditos"
                        ></el-checkbox>
                    </div>

                    <!-- Usuario Arca -->
                    <div class="col-md-4" v-if="configuration.principal_cash">
                        <label for="arca_user">
                            <i class="fas fa-cash-register"></i> Usuario Arca
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Permite al usuario tener opciones de ARCA"
                                placement="top"
                            >
                                <i class="fas fa-info-circle"></i>
                            </el-tooltip>
                        </label>
                        <el-checkbox
                            v-model="form.is_arca"
                            id="arca_user"
                            label="Es Arca?"
                        ></el-checkbox>
                    </div>
                    <div
                        class="col-md-4"
                        v-if="form.is_arca && configuration.health_network"
                    >
                        <label for="arca_user">
                            Tipo de Usuario Arca >
                        </label>
                        <el-select v-model="form.arca_type" clearable>
                            <el-option
                                value="product"
                                label="Productos"
                            ></el-option>
                            <el-option
                                value="service"
                                label="Servicios"
                            ></el-option>
                        </el-select>
                    </div>
                    <div
                        class="col-md-4"
                        v-if="configuration.user_series_independientes_caja"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.series }"
                        >
                            <div>
                                <i class="fas fa-toolbox"></i>
                                <!-- Icono de Tipo de trabajador -->
                                <label class="control-label"
                                    >Seleccione Serie</label
                                >
                            </div>
                            <el-select clearable v-model="form.series">
                                <el-option
                                    v-for="(data, index) in series"
                                    :key="index"
                                    :label="data.number"
                                    :value="data.id"
                                ></el-option>
                            </el-select>
                            <!-- <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small> -->
                        </div>
                    </div>
                    <div class="col-md-4"
                    v-if="isEstilista"
                    >
                    
                        <label for="product"
                            >Ver/Editar servicios
                            
                        </label>
                        <el-button type="primary" @click="openUserItems">Ver/Editar servicios</el-button>
                    </div>
                    <div
                        class="row"
                        v-if="configuration.commercial_treatment_items"
                    >
                        <div class="col-12">
                            Tratamientos Comerciales
                        </div>
                        <div class="col-12">
                            <el-tag
                                v-for="(data,
                                index) in commercial_treatment_users"
                                :key="index"
                                :type="`${data.active ? 'success' : 'info'}`"
                                style="margin-right: 5px;"
                                role="button"
                                @click="clickTag(data)"
                            >
                                {{ data.description }}
                            </el-tag>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Imagen
                                <span class="text-danger"></span>
                            </label>
                            <el-upload
                                class="avatar-uploader bg-white"
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
            <user-items :showDialog.sync="showUserItems" :userId="recordId"
            @saveItems="saveItems"
            ></user-items>

            <!-- Botones -->
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close"
                >
                    <span>Cancelar</span>
                </el-button>
                <el-button
                    class="btn-save btn-save:hover"
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
import Swal from "sweetalert2";
import { serviceNumber } from "../../../../../../../resources/js/mixins/functions";
import UserItems from "./user_items.vue";
export default {
    mixins: [serviceNumber],
    components: {
        UserItems
    },
    props: [
        "showDialog",
        "recordId",
        "areas",
        "workersType",
        "establishments",
        "configuration",
        "allEstablishments",
        "allWarehouses",
        "series",
        "commercial_treatment"
    ],
    data() {
        return {
            form: {
                workers: true,
                identity_document_type_id: "1", // Tipo de documento
                number: "", // DNI
                name: "", // Nombres y apellidos
                worker_type_id: null, // Tipo de trabajador
                area_id: null, // Área de trabajo
                establishment_id: null, // Establecimiento
                telephone: null, // Teléfono
                can_accept_credit_sale_note: false, // Créditos en notas de venta
                is_arca: false, // Usuario Arca
                active: 1 // Estado activo
            },
            errors: {}, // Almacena errores
            loading_submit: false,
            loading_search: false,
            titleDialog: null,
            resource: "workers",
            headers: headers_token,
            image_url: null,
            commercial_treatment_users: [],
            showUserItems: false
        };
    },
    created() {
        this.initForm();
    },
    computed: {
        isEstilista() {
            let workerType = this.workersType.find(type => type.id === this.form.worker_type_id);
            if(!workerType) return false;
            return workerType.description === 'ESTILISTA';
        }
    },
    /* watch: {
        "form.worker_type_id"(newVal, oldVal) {
            if (oldVal) {
                const oldWorkerType = this.workersType.find(
                    type => type.id === oldVal
                );
                if (oldWorkerType) {
                    this.form.name = this.form.name.replace(
                        `${oldWorkerType.description} - `,
                        ""
                    );
                }
            }
            const selectedWorkerType = this.workersType.find(
                type => type.id === newVal
            );
            if (selectedWorkerType) {
                this.form.name = `${selectedWorkerType.description} - ${this.form.name}`;
            }
        }
    }, */
    watch: {
        "form.worker_type_id"(newVal, oldVal) {
            if (oldVal) {
                const oldWorkerType = this.workersType.find(
                    type => type.id === oldVal
                );
                if (oldWorkerType) {
                    // Elimina la descripción del tipo anterior
                    this.form.name = this.form.name.replace(
                        `${oldWorkerType.description} - `,
                        ""
                    );
                }
            }

            const selectedWorkerType = this.workersType.find(
                type => type.id === newVal
            );
            if (selectedWorkerType) {
                // Solo agrega la descripción si aún no está presente
                if (
                    !this.form.name.startsWith(
                        `${selectedWorkerType.description} - `
                    )
                ) {
                    this.form.name = `${selectedWorkerType.description} - ${this.form.name}`;
                }
            }
        }
    },
    methods: {
        saveItems(items){
            this.form.user_items = items;
        },
        openUserItems(){
            this.showUserItems = true;
        },
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

        // Validar el formulario
        validateForm() {
            this.errors = {};

            if (!this.form.number) {
                this.errors.number = ["El DNI es obligatorio."];
            } else if (this.form.number.length !== 8) {
                this.errors.number = ["El DNI debe tener 8 dígitos."];
            }

            if (!this.form.name) {
                this.errors.name = ["El nombre es obligatorio."];
            }

            if (!this.form.worker_type_id) {
                this.errors.worker_type_id = [
                    "El tipo de trabajador es obligatorio."
                ];
            }

            if (!this.form.area_id) {
                this.errors.area_id = ["El área de trabajo es obligatoria."];
            }

            if (!this.form.establishment_id) {
                this.errors.establishment_id = [
                    "El establecimiento es obligatorio."
                ];
            }

            if (Object.keys(this.errors).length > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Faltan Rellenar los campos obligatorios.",
                    timer: 2000,
                    showConfirmButton: false
                });
                return false;
            }

            return true;
        },

        // Enviar formulario
        submit() {
            if (!this.validateForm()) return;

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

        // Mostrar alertas
        showAlert(type, message) {
            Swal.fire({
                icon: type,
                title: message,
                timer: 2000,
                showConfirmButton: false
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
        searchWorker() {
            this.searchServiceNumberByType();
        }
    }
};
</script>
