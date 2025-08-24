<!-- Modulo de Condutores  en Guia de Remisión-->
<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="open" append-to-body
        class="rounded-dialog" :close-on-click-modal="false">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group" :class="{ 'has-danger': errors.document_type_id }">
                            <label for="document_type">
                                <i class="far fa-id-card" style="margin-right: 6px;"></i>Tipo de Documento
                                <el-tooltip content="Campo Obligatorio" placement="top">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                </el-tooltip>
                            </label>
                            <el-select v-model="form.identity_document_type_id" :disabled="loading_submit"
                                placeholder="Seleccione">
                                <el-option v-for="(item, idx) in document_types" :key="idx" :label="item.description"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.document_type_id"
                                v-text="errors.document_type_id[0]">
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{ 'has-danger': errors.number }">
                            <label for="document_number">
                                <i class="fas fa-list-ol" style="margin-right: 6px;"></i> Número de DNI
                                <el-tooltip content="Campo Obligatorio" placement="top">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                </el-tooltip>
                            </label>
                            <el-input v-model="form.number" placeholder="Documento" :disabled="loading_submit"
                                minlength="8" maxlength="8" show-word-limit @input="validateNumbers('number')">
                                <el-button v-if="form.identity_document_type_id == 1" @click="searchDocument"
                                    slot="append" class="btn btn-primary" icon="el-icon-search">
                                </el-button>
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]">
                            </small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group" :class="{ 'has-danger': errors.license }">
                            <div class="row">
                                <div class="col-4">
                                 Licencia de
                                <br>
                                 Conducir
                            </div>
                            <div class="col-8">
                                <span class="license-text" style="font-size: 2rem;">{{ form.license }}</span>
                            </div>
                            </div>
                            
                            <!-- <label class="d-flex " >
                               
                                <div class="form-control ms-2 license-display">
                                    
                                </div>
                            </label> -->
                            <small class="form-control-feedback" v-if="errors.license"
                                v-text="errors.license[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group" :class="{ 'has-danger': errors.name }">
                            <label for="name">
                                <i class="fas fa-tag"></i> Nombre
                                <el-tooltip content="Campo Obligatorio" placement="top">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                </el-tooltip>
                            </label>
                            <el-input v-model="form.name" placeholder="Nombre" :disabled="loading_submit">
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]">
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group" :class="{ 'has-danger': errors.telephone }">
                            <label class="">Telefono</label>
                            <el-input v-model="form.telephone" ref="telephoneInput" maxlength="9"
                                @input="validateTelephone">
                                
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.telephone"
                                v-text="errors.telephone[0]"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-end align-items-center pt-2 pb-2">
                    <el-button class="btn_cancelarsmall" type="primary" icon="fas fa-times fa-lg" @click.prevent="close()">
                        Cancelar
                    </el-button>
                    <el-button class="btn_guardarsmall" type="primary" icon="fas fa-save fa-lg" native-type="submit" :loading="loading_submit">
                        Guardar
                    </el-button>
                </div>
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
    props: ["showDialog", "recordId"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "drivers",
            errors: {},
            form: {},
            options: [],
            document_types: []
        };
    },
    watch: {
        "form.identity_document_type_id": function (newVal) {
            if (newVal !== null) {
                this.form.name = `${this.form.name || ""}`;
            }
        }
    },
    created() {
        this.initForm();
    },

    methods: {
        async open() {
            // Asegura que los tipos de documento estén cargados antes de mostrar el modal
            await this.getTables();

            this.titleDialog = this.recordId
                ? "Editar Conductor"
                : "Nuevo Conductor";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                    });
            } else {
                // Selecciona automáticamente DNI (id=1) al crear nuevo
                this.form.identity_document_type_id = 1;
            }
        },
        async getTables() {
            const response = await this.$http(`${this.resource}/tables`);
            console.log(response);
            let { document_types } = response.data;
            // Asegura que todos los id sean numéricos
            this.document_types = document_types.map(dt => ({
                ...dt,
                id: Number(dt.id)
            }));
        },
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
                    // Rellenar licencia automáticamente
                    this.form.license = `P-${this.form.number}`;
                    // Hacer focus en teléfono
                    this.$nextTick(() => {
                        if (this.$refs.telephoneInput) {
                            this.$refs.telephoneInput.focus();
                        }
                    });
                    console.log("Respuesta de DNI:", response.data);
                } else if (documentTypeId === 4) {
                    response = await this.$http.get(
                        `/search-ce/${this.form.number}`
                    );
                    // Aquí puedes agregar lógica para CE si es necesario
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
        validateTelephone() {
            // Solo permite hasta 9 dígitos numéricos
            if (this.form.telephone) {
                this.form.telephone = this.form.telephone.replace(/[^0-9]/g, '').slice(0, 9);
            }
        },
        // searchDocument duplicada eliminada. Solo queda la versión asíncrona correcta.
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
                        if (this.external) {
                            // Emitir el evento con el nuevo conductor
                            this.$emit("addDriver", response.data.data);
                            console.log("Nuevo conductor emitido:", response.data.data);
                        } else {
                            this.$eventHub.$emit("reloadData");
                        }

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
