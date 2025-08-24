<!-- Nuevo Vendedor -->
<template>
    <el-dialog :visible="showDialog" @open="open" @close="close" append-to-body :title="title" class="rounded-dialog"
        :close-on-click-modal="false">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="row mb-3">
                <!-- Tipo de Documento -->
                <div class="col-md-3">
                    <div class="form-group" :class="{ 'has-danger': errors.document_type_id }">
                        <label for="document_type">
                            <i class="far fa-id-card"></i> Tipo de Documento
                            <el-tooltip content="Campo Obligatorio" placement="top">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </el-tooltip>
                        </label>
                        <el-select v-model="form.document_type_id" :disabled="loading_submit">
                            <el-option v-for="(item, idx) in document_types.filter(dt => dt.description === 'DNI' || dt.description === 'CE')" :key="idx" :label="item.description"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.document_type_id"
                            v-text="errors.document_type_id[0]">
                        </small>
                    </div>
                </div>

                <!-- Número de DNI/CE -->
                <div class="col-md-3">
                    <div class="form-group" :class="{ 'has-danger': errors.document }">
                        <label for="document_number">
                            <i class="fas fa-list-ol"></i>DNI/CE
                            <el-tooltip content="Campo Obligatorio" placement="top">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </el-tooltip>
                        </label>
                        <el-input v-model="form.document" placeholder="Documento" :disabled="loading_submit"
                             maxlength="8" show-word-limit @input="validateNumbers('document')">
                            <template #append>
                                <el-button v-if="
                                    form.document_type_id == 1 ||
                                    form.document_type_id == 4
                                " @click="searchDocument" icon="el-icon-search">
                                </el-button>
                            </template>
                        </el-input>
                        <!-- <small class="form-control-feedback" v-if="errors.document" v-text="errors.document[0]"></small> -->
                    </div>
            </div>

                <!-- Nombre -->
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-danger': errors.name }">
                        <label for="name">
                            <i class="fas fa-tag"></i> Vendedor
                            <el-tooltip content="Campo Obligatorio" placement="top">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                            </el-tooltip>
                        </label>
                        <el-input v-model="form.name" placeholder="Nombre del vendedor" :disabled="loading_submit"
                            @input="convertToUppercase('name')">
                        </el-input>
                        <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]">
                        </small>
                    </div>
                </div>

               

            </div>
             <div class="row mb-1">
                    <!-- Teléfono -->
                    <div class="col-md-3">
                        <div class="form-group" :class="{ 'has-danger': errors.telephone }">
                            <label>
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </label>
                            <el-input v-model="form.telephone" placeholder="WhatsApp" :disabled="loading_submit"
                                maxlength="9" show-word-limit @input="validateNumbers('telephone')">
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.telephone" v-text="errors.telephone[0]">
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" :class="{ 'has-danger': errors.commission_percentage }">
                            <label>% Comisión</label>
                            <el-input v-model="form.commission_percentage" placeholder="Porcentaje de Comisión"
                                :disabled="loading_submit" maxlength="4" show-word-limit>
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.commission_percentage"
                                v-text="errors.commission_percentage[0]">
                            </small>
                        </div>
                    </div>

                    <!-- Establecimiento -->
                    <div class="col-md-3">
                        <div class="form-group" :class="{ 'has-danger': errors.establishment_id }">
                            <label for="establishment_id">
                                <i class="fas fa-store"></i> Establecimiento
                                <el-tooltip content="Campo Obligatorio" placement="top">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                </el-tooltip>
                            </label>
                            <el-select v-model="form.establishment_id" placeholder="Establecimiento"
                                :disabled="loading_submit">
                                <el-option v-for="item in establishments" :key="item.id" :label="item.description"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.establishment_id"
                                v-text="errors.establishment_id[0]">
                            </small>
                        </div>
                    </div>
                </div>



            <!-- Botones de acción -->
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <!-- Botón Cancelar -->
                <el-button class="btn_cancelarsmall" icon="fas fa-times fa-lg" @click.prevent="close()">
                    <span>Cancelar</span>
                </el-button>
                <!-- Botón Guardar -->
                <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary" native-type="submit"
                    :loading="loading_submit" @click.prevent="
                        convertToUppercase('name');
                    submit();
                    ">
                    <span>Guardar</span>
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: ["showDialog", "recordId", "establishments", "document_types"],
    data() {
        return {
            title: null,
            resource: "sellers",
            errors: {},
            form: {},
            loading_submit: false,
            loading_submitI: false,
            timer: null
        };
    },
    watch: {
        "form.document_type_id": function (newVal) {
            if (newVal !== null && this.form.name) {
                if (!this.form.name.startsWith("VENDEDOR - ")) {
                    this.form.name = `VENDEDOR - ${this.form.name}`;
                }
            }
        }
    },
    methods: {
        initForm() {
            this.form = {
                name: null,
                document: null,
                establishment_id: null,
                document_type_id: null,
                telephone: null
            };
        },
        async searchDocument() {
            if (this.form.document === "") {
                Swal.fire({
                    icon: "warning",
                    title: "ALERTA",
                    text: "Ingresar el número a buscar",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            const documentTypeId = Number(this.form.document_type_id);
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
                        `/service/${identity_document_type_name}/${this.form.document}`
                    );
                    console.log("Respuesta de DNI:", response.data);
                    // Usar response.data.data para obtener los datos correctos
                    const data = response.data.data;
                    if (data && data.nombres && data.apellido_paterno) {
                        const primerNombre = data.nombres.split(' ')[0];
                        const primerApellido = data.apellido_paterno.split(' ')[0];
                        this.form.name = `VENDEDOR - ${primerNombre} ${primerApellido}`;
                    }
                } else if (documentTypeId === 4) {
                    response = await this.$http.get(
                        `/search-ce/${this.form.document}`
                    );
                    console.log("Respuesta de CE:", response.data);
                    // Usar response.data.data para obtener los datos correctos
                    const data = response.data.data;
                    if (data && data.nombres && data.apellido_paterno) {
                        const primerNombre = data.nombres.split(' ')[0];
                        const primerApellido = data.apellido_paterno.split(' ')[0];
                        this.form.name = `VENDEDOR - ${primerNombre} ${primerApellido}`;
                    }
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
        open() {
            console.log(this.recordId);
            if (this.recordId) {
                this.title = "Editar Vendedor";
                this.getRecord(this.recordId);
            } else {
                this.title = "Nuevo Vendedor";
                this.initForm();
            }
        },
        async getRecord(id) {
            const response = await this.$http.get(
                `/${this.resource}/record/${id}`
            );
            this.form = response.data.data;
            // Evitar duplicar el prefijo al editar
            if (this.form.name && this.form.name.startsWith("VENDEDOR - ")) {
                // No hacer nada, ya tiene el prefijo
            } else if (this.form.name) {
                this.form.name = `VENDEDOR - ${this.form.name}`;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        async submit() {
            this.loading_submit = true;
            this.errors = {};
            // Convertir todos los campos string del formulario a mayúsculas antes de guardar
            const formUpper = {};
            Object.keys(this.form).forEach(key => {
                formUpper[key] = typeof this.form[key] === 'string'
                    ? this.form[key].toUpperCase()
                    : this.form[key];
            });
            const response = await this.$http.post(
                `/${this.resource}`,
                formUpper
            );
            if (response.data.success) {
                this.$message.success(response.data.message);
                this.close();
                this.$eventHub.$emit("reloadData");
            } else {
                if (response.data.errors) {
                    this.errors = response.data.errors;
                } else {
                    this.$message.error(response.data.message);
                }
            }
            this.loading_submit = false;
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
        convertToUppercase(field) {
            this.form[field] = this.form[field].toUpperCase();
        }
    }
};
</script>
