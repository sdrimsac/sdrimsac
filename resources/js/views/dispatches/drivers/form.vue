<!-- Editar Conductor en Guias de Remisión -->
<template>
    <el-dialog
        :close-on-click-modal="false"
        :title="titleDialog"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="create"
        @opened="opened"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div
                            :class="{
                                'has-danger': errors.identity_document_type_id
                            }"
                            class="form-group"
                        >
                            <label class="control-label"
                                >Tipo Doc. Identidad
                                <span class="text-danger">*</span></label
                            >
                            <el-select
                                v-model="form.identity_document_type_id"
                                dusk="identity_document_type_id"
                                filterable
                                popper-class="el-select-identity_document_type"
                                @change="changeIdentityDocType"
                            >
                                <el-option
                                    v-for="option in identity_document_types"
                                    :key="option.id"
                                    :label="option.description"
                                    :value="option.id"
                                ></el-option>
                            </el-select>
                            <small
                                v-if="errors.identity_document_type_id"
                                class="form-control-feedback"
                                v-text="errors.identity_document_type_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            :class="{ 'has-danger': errors.number }"
                            class="form-group"
                        >
                            <label class="control-label"
                                >Número
                                <span class="text-danger">*</span></label
                            >

                            <!-- <el-input v-model="form.number" :maxlength="maxLength" dusk="number">
                            </el-input> -->

                            <div v-if="api_service_token != false">
                                <x-input-service
                                    v-model="form.number"
                                    :identity_document_type_id="
                                        form.identity_document_type_id
                                    "
                                    @search="searchNumber"
                                ></x-input-service>
                            </div>
                            <div v-else>
                                <el-input
                                    v-model="form.number"
                                    :maxlength="maxLength"
                                    dusk="number"
                                >
                                    <template
                                        v-if="
                                            form.identity_document_type_id ===
                                                '6' ||
                                                form.identity_document_type_id ===
                                                    '1'
                                        "
                                    >
                                        <el-button
                                            slot="append"
                                            :loading="loading_search"
                                            icon="el-icon-search"
                                            type="primary"
                                            @click.prevent="searchCustomer"
                                        >
                                            <template
                                                v-if="
                                                    form.identity_document_type_id ===
                                                        '6'
                                                "
                                            >
                                                SUNAT
                                            </template>
                                            <template
                                                v-if="
                                                    form.identity_document_type_id ===
                                                        '1'
                                                "
                                            >
                                                RENIEC
                                            </template>
                                        </el-button>
                                    </template>
                                </el-input>
                            </div>

                            <small
                                v-if="errors.number"
                                class="form-control-feedback"
                                v-text="errors.number[0]"
                            ></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div
                            :class="{ 'has-danger': errors.name }"
                            class="form-group"
                        >
                            <label class="control-label"
                                >Nombre
                                <span class="text-danger">*</span></label
                            >
                            <el-input
                                v-model="form.name"
                                dusk="name"
                            ></el-input>
                            <small
                                v-if="errors.name"
                                class="form-control-feedback"
                                v-text="errors.name[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            :class="{ 'has-danger': errors.license }"
                            class="form-group"
                        >
                            <label class="control-label">Licencia</label>
                            <el-input
                                v-model="form.license"
                                @keyup.native="keyUpLicense"
                                @focus="addLicensePrefix"
                            ></el-input>
                            <small
                                v-if="errors.license"
                                class="form-control-feedback"
                                v-text="errors.license[0]"
                            ></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div
                            :class="{ 'has-danger': errors.telephone }"
                            class="form-group"
                        >
                            <label class="control-label">Teléfono</label>
                            <el-input
                                v-model="form.telephone"
                                dusk="telephone"
                                ref="inputTelephone"
                            ></el-input>
                            <small
                                v-if="errors.telephone"
                                class="form-control-feedback"
                                v-text="errors.telephone[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="margin-top: 32px;">
                            <vs-switch color="#073f68" v-model="form.is_default" val="Predeterminado">
                                Predeterminado
                            </vs-switch>
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
            <!-- <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    :loading="loading_submit"
                    native-type="submit"
                    type="primary"
                    >Guardar
                </el-button>
            </div> -->
        </form>
    </el-dialog>
</template>

<script>
import { serviceNumber } from "@mixins/functions";

export default {
    name: "DispatchDriverForm",
    mixins: [serviceNumber],
    props: ["showDialog", "recordId", "external"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "drivers",
            errors: {},
            form: {},
            api_service_token: false,
            identity_document_types: []
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.api_service_token = response.data.api_service_token;
            let types = response.data.identity_document_types || [];
            // Verificar si existe DNI (id: '1'), si no, agregarlo
            if (!types.some(t => t.id === '1' || t.id === 1)) {
                types.unshift({ id: '1', description: 'DNI' });
            }
            this.identity_document_types = types;
        });
    },
    computed: {
        maxLength: function() {
            if (this.form.identity_document_type_id === "6") {
                return 11;
            }
            if (this.form.identity_document_type_id === "1") {
                return 8;
            }
        }
    },
    methods: {
        keyUpLicense(e) {
            if (
                this.form.license.length == 1 &&
                e.keyCode !== 8 &&
                this.form.number
            ) {
                this.form.license = this.form.license.concat(this.form.number);
            }
        },
        addLicensePrefix() {
            // Si ya tiene el prefijo y el número, no hacer nada
            const number = this.form.number ? this.form.number.toString() : '';
            const expected = 'P-' + number;
            if (number && this.form.license !== expected) {
                this.form.license = expected;
            } else if (!number && (typeof this.form.license !== 'string' || !this.form.license.startsWith('P-'))) {
                this.form.license = 'P-';
            }
        },
        initForm() {
            this.errors = {};

            this.form = {
                id: null,
                identity_document_type_id: "1",
                number: "",
                name: null,
                license: '', // Siempre string
                telephone: null,
                is_default: false,
                is_active: true
            };
        },
        async opened() {},
        create() {
            this.titleDialog = this.recordId
                ? "Editar Conductor"
                : "Nuevo Conductor";

            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        // Aseguramos que license sea string y tenga el prefijo
                        const data = response.data.data;
                        data.license = (data.license || '').toString();
                        if (data.license && !data.license.startsWith('P-')) {
                            data.license = 'P-' + data.license;
                        }
                        this.form = data;
                    });
            }
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.$emit("success", response.data.id);
                        this.close();
                    } else {
                        this.$message.error(response.data.message);
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
        changeIdentityDocType() {
            // (this.recordId == null) ? this.setDataDefaultCustomer() : null
        },
        setDataDefaultCustomer() {
            // if(this.form.identity_document_type_id == '0'){
            //     this.form.number = '99999999'
            //     this.form.name = "Clientes - Varios"
            // }else{
            //     this.form.number = ''
            //     this.form.name = null
            // }
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        searchCustomer() {
            this.searchServiceNumberByType();
        },
        /**
         * Normaliza las respuestas de diferentes APIs de consulta DNI/RUC
         * para que tengan la misma estructura
         */
        normalizeApiResponse(rawData) {
            // Verificar si los datos están dentro de una propiedad 'data'
            const data = rawData.data || rawData;
            
            // Estructura normalizada
            const normalized = {
                numero: data.numero || '',
                nombre_completo: data.nombre_completo || '',
                nombres: data.nombres || '',
                apellido_paterno: data.apellido_paterno || '',
                apellido_materno: data.apellido_materno || '',
                
                // Campos adicionales para RUC
                nombre_o_razon_social: data.nombre_o_razon_social || data.nombre_completo || '',
            };

            return normalized;
        },
        searchNumber(rawData) {
            // Normaliza los datos antes de procesarlos
            const data = this.normalizeApiResponse(rawData);
            
            this.form.name =
                this.form.identity_document_type_id === "1"
                    ? data.nombre_completo
                    : data.nombre_o_razon_social;
            // Actualizar la licencia automáticamente con el número encontrado
            if (this.form.identity_document_type_id === "1" && this.form.number) {
                this.form.license = 'P-' + this.form.number;
            }
            // Hacer focus en el input de teléfono
            this.$nextTick(() => {
                if (this.$refs.inputTelephone && this.$refs.inputTelephone.focus) {
                    this.$refs.inputTelephone.focus();
                }
            });
        }
    }
};
</script>
