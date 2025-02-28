<!-- Nuevo Vendedor -->
<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        class="rounded-dialog"
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="row">
                <div class="col-md-4">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.document_type_id }"
                    >
                        <label for="document_type">
                            <i class="far fa-id-card"></i> Documento de
                            identidad
                        </label>
                        <el-select
                            v-model="form.document_type_id"
                            :disabled="loading_submit"
                        >
                            <el-option
                                v-for="(item, idx) in document_types"
                                :key="idx"
                                :label="item.description"
                                :value="item.id"
                            ></el-option>
                        </el-select>
                        <small
                            class="form-control-feedback"
                            v-if="errors.document_type_id"
                            v-text="errors.document_type_id[0]"
                        ></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.document }"
                    >
                        <label for="document_number">
                            <i class="fas fa-list-ol"></i> Número de documento
                            de identidad
                        </label>
                        <el-input
                            v-model="form.document"
                            placeholder="Documento"
                            :disabled="loading_submit"
                            minlength="8"
                            maxlength="20"
                            show-word-limit
                            @input="validateNumbers('document')"
                        >
                            <el-button
                                v-if="
                                    form.document_type_id == 1 ||
                                        form.document_type_id == 4
                                "
                                @click="searchDocument"
                                slot="prepend"
                                icon="el-icon-search"
                            ></el-button>
                        </el-input>
                        <small
                            class="form-control-feedback"
                            v-if="errors.document"
                            v-text="errors.document[0]"
                        ></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.establishment_id }"
                    >
                        <label for="establishment_id">
                            <i class="fas fa-store"></i> Establecimiento
                        </label>
                        <el-select
                            v-model="form.establishment_id"
                            placeholder="Establecimiento"
                            :disabled="loading_submit"
                        >
                            <el-option
                                v-for="item in establishments"
                                :key="item.id"
                                :label="item.description"
                                :value="item.id"
                            ></el-option>
                        </el-select>
                        <small
                            class="form-control-feedback"
                            v-if="errors.establishment_id"
                            v-text="errors.establishment_id[0]"
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
                        </label>
                        <el-input
                            v-model="form.name"
                            placeholder="Nombre"
                            :disabled="loading_submit"
                            @input="convertToUppercase('name')"
                        ></el-input>
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
                        :class="{ 'has-danger': errors.telephone }"
                    >
                        <label>Telefono</label>
                        <el-input
                            v-model="form.telephone"
                            placeholder="Telefono"
                            :disabled="loading_submit"
                            maxlength="9"
                            show-word-limit
                            @input="validateNumbers('telephone')"
                        ></el-input>
                        <small
                            class="form-control-feedback"
                            v-if="errors.telephone"
                            v-text="errors.telephone[0]"
                        ></small>
                    </div>
                </div>
            </div>
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <!-- Botón Cancelar -->
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close()"
                >
                    <span>Cancelar</span>
                </el-button>
                <!-- Botón Guardar -->
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
export default {
    props: ["showDialog", "recordId", "establishments", "document_types"],
    data() {
        return {
            title: null,
            resource: "mozo",
            errors: {},
            form: {},
            loading_submit: false,
            loading_submitI: false,
            timer: null,
            cursorPosition: 0
        };
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
                    if (response.data.success) {
                        const data = response.data.data;
                        const fullName = `${data.apellido_paterno} ${data.apellido_materno} ${data.nombres}`;
                        // Solo agregar el prefijo si no existe
                        if (!fullName.includes('MOZO -')) {
                            this.form.name = `MOZO - ${fullName}`;
                        } else {
                            this.form.name = fullName;
                        }
                    }
                } else if (documentTypeId === 4) {
                    response = await this.$http.get(
                        `/search-ce/${this.form.document}`
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
        
        open() {
            console.log(this.recordId);
            if (this.recordId) {
                this.title = "Editar vendedor";
                this.getRecord(this.recordId);
            } else {
                this.title = "Crear vendedor";
                this.initForm();
            }
        },

        async getRecord(id) {
            const response = await this.$http.get(
                `/${this.resource}/record/${id}`
            );
            this.form = response.data.data;
            
            // Limpiar cualquier prefijo duplicado al cargar
            if (this.form.name) {
                const cleanName = this.form.name.replace(/^(MOZO - )+/g, 'MOZO - ');
                this.form.name = cleanName;
            }
        },

        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },

        async submit() {
            this.loading_submit = true;
            this.errors = {};
            // Convert non-numeric fields to lowercase before saving
            this.form.name = this.form.name.toLowerCase();
            const response = await this.$http.post(
                `/${this.resource}`,
                this.form
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
                this.form[field] = value.replace(/[^0-9]/g, ""); // Reemplazar caracteres no válidos
            }
        },
        convertToUppercase(field) {
            const input = document.querySelector(`input[name="${field}"]`) || document.activeElement;
            this.cursorPosition = input.selectionStart;
            
            // Convertir a mayúsculas sin modificar el prefijo "MOZO -"
            let value = this.form[field];
            if (value.startsWith('MOZO -')) {
                const prefix = 'MOZO - ';
                const rest = value.substring(prefix.length);
                this.form[field] = prefix + rest.toUpperCase();
            } else {
                this.form[field] = value.toUpperCase();
            }

            // Restaurar la posición del cursor en el siguiente tick
            this.$nextTick(() => {
                input.setSelectionRange(this.cursorPosition, this.cursorPosition);
            });
        }
    }
};
</script>
