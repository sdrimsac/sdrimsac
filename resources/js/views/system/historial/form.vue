<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        width="80%"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="col-md-12">
                    <div class="card">
                        <div class="">
                            <div>
                                <h4 class="card-title">
                                    DATOS CONSIGNADOS DEL CLIENTE
                                </h4>
                            </div>
                            <br />
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.number }"
                                    >
                                        <label class="control-label">DNI</label>
                                        <div class="d-flex align-items-center">
                                            <x-input-service
                                                v-model="form.number"
                                                :identity_document_type_id="
                                                    form.document_type.dni
                                                "
                                                @search="searchNumber"
                                            ></x-input-service>
                                        </div>
                                        <small
                                            class="form-control-feedback"
                                            v-if="errors.number"
                                            v-text="errors.number[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.name }"
                                    >
                                        <label class="control-label"
                                            >NOMBRES/APELLIDOS</label
                                        >
                                        <el-input
                                            v-model="form.name"
                                        ></el-input>
                                        <small
                                            class="form-control-feedback"
                                            v-if="errors.name"
                                            v-text="errors.name[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.telephone
                                        }"
                                    >
                                        <label class="control-label"
                                            >TELEFONO</label
                                        >
                                        <el-input
                                            v-model="form.telephone"
                                            :maxlength="9"
                                            show-word-limit
                                        ></el-input>
                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.telephone"
                                            v-text="errors.telephone[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.business_id
                                        }"
                                    >
                                        <label class="control-label"
                                            >TIPO DE NEGOCIO</label
                                        >
                                        <el-select
                                            v-model="form.business_id"
                                            placeholder="Seleccione"
                                            clearable
                                        >
                                            <el-option
                                                v-for="item in business"
                                                :key="item.id"
                                                :label="item.description"
                                                :value="item.id"
                                            ></el-option>
                                        </el-select>
                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.business_id"
                                            v-text="errors.business_id[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.direccion
                                        }"
                                    >
                                        <label class="control-label"
                                            >DIRECCION CLIENTE</label
                                        >
                                        <el-input
                                            v-model="form.direccion"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.direccion"
                                            v-text="errors.direccion[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.email }"
                                    >
                                        <label class="control-label"
                                            >EMAIL</label
                                        >
                                        <el-input
                                            v-model="form.email"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.email"
                                            v-text="errors.email[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="">
                            <div>
                                <h4 class="card-title">
                                    CLAVE SOL Y USUARIO SECUNDARIO
                                </h4>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        :class="{ 'has-danger': errors.ruc }"
                                        class="form-group"
                                    >
                                        <label class="control-label">RUC</label>
                                        <!-- apiperu -->
                                        <x-input-service
                                            v-model="form.ruc"
                                            :identity_document_type_id="
                                                form.document_type.ruc
                                            "
                                            @search="searchNumber"
                                        ></x-input-service>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.user }"
                                    >
                                        <label class="control-label"
                                            >USUARIO</label
                                        >
                                        <el-input
                                            v-model="form.user"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.user"
                                            v-text="errors.user[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.password
                                        }"
                                    >
                                        <label class="control-label"
                                            >CONTRASEÑA
                                        </label>
                                        <el-input
                                            v-model="form.password"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.password"
                                            v-text="errors.password[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.user_secondary
                                        }"
                                    >
                                        <label class="control-label"
                                            >USUARIO SECUNDARIO</label
                                        >
                                        <el-input
                                            v-model="form.user_secondary"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.user_secondary"
                                            v-text="errors.user_secondary[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.password_secondary
                                        }"
                                    >
                                        <label class="control-label"
                                            >CONTRASEÑA DEL USUARIO
                                            SECUNDARIO</label
                                        >
                                        <el-input
                                            v-model="form.password_secondary"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.password_secondary"
                                            v-text="
                                                errors.password_secondary[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.direccion_secondary
                                        }"
                                    >
                                        <label class="control-label"
                                            >NOMBRE DE NEGOCIO</label
                                        >
                                        <el-input
                                            v-model="form.direccion_secondary"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.direccion_secondary"
                                            v-text="
                                                errors.direccion_secondary[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.direccion_secondary
                                        }"
                                    >
                                        <label class="control-label"
                                            >DIRECCION NEGOCIO</label
                                        >
                                        <el-input
                                            v-model="form.direccion_secondary"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.direccion_secondary"
                                            v-text="
                                                errors.direccion_secondary[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="">
                            <div>
                                <h4 class="card-title">
                                    DATOS DEL CERTIFICADO DIGITAL
                                </h4>
                            </div>
                            <br />
                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.password_certificate
                                        }"
                                    >
                                        <label class="control-label"
                                            >CLAVE DE CERTIFICADO DIGITAL</label
                                        >
                                        <el-input
                                            v-model="form.password_certificate"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.password_certificate"
                                            v-text="
                                                errors.password_certificate[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.date_certificate
                                        }"
                                    >
                                        <label class="control-label">
                                            FECHA DE SOLICITUD DE CERTIFICADO
                                        </label>
                                        <el-input
                                            type="date"
                                            v-model="form.date_certificate"
                                        ></el-input>

                                        <small
                                            class="form-control-feedback d-block"
                                            v-if="errors.date_certificate"
                                            v-text="errors.date_certificate[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right pt-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit"
                    >Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog", "recordId", "records", "business"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "historial",
            errors: {},
            form: {},
            documentTypes: {
                dni: "1",
                ruc: "6"
            }
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        initForm() {
            this.errors = {};

            this.form = {
                identity_document_type_id: "1",
                document_type: {
                    ruc: "6",
                    dni: "1"
                },
                id: null,
                name: null,
                business_id: null,
                number: null,
                telephone: null,
                direccion: null,
                direccion_secondary: null,
                email: null,
                ruc: null,
                user: null,
                password: null,
                user_secondary: null,
                password_secondary: null,
                password_certificate: null,
                date_certificate: null
            };
        },
        create() {
            this.titleDialog = this.recordId
                ? "Editar Datos Cliente"
                : "Nuevo Datos Cliente";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.data = response.data.data;
                        this.form = {
                            id: this.data.id,
                            name: this.data.name,
                            business_id: this.data.business_id,
                            number: this.data.number,
                            telephone: this.data.telephone,
                            direccion: this.data.direccion,
                            direccion_secondary: this.data.direccion_secondary,
                            email: this.data.email,
                            ruc: this.data.ruc,
                            user: this.data.user,
                            password: this.data.password,
                            user_secondary: this.data.user_secondary,
                            password_secondary: this.data.password_secondary,
                            password_certificate: this.data
                                .password_certificate,
                            date_certificate: this.data.date_certificate
                        };
                    });
            }
        },
        searchDni(data) {
            this.form.identity_document_type_id = this.documentTypes.dni;
            this.searchNumber(data);
        },

        searchRuc(data) {
            this.form.identity_document_type_id = this.documentTypes.ruc;
            this.searchNumber(data);
        },

        searchNumber(data) {
            // El tipo de documento vendrá en la respuesta del componente x-input-service
            this.form.identity_document_type_id =
                data.identity_document_type_id;
            this.form.direccion_secondary = data.direccion_secondary;
            this.form.name = data.name;
            this.form.telephone = data.telephone;
            this.form.email = data.email;
            this.form.direccion = data.direccion;

            this.form.direccion_secondary = data.name;
        },
        /* searchClients(data) {
            
        }, */
        submit() {
            /* this.transform(); */

            this.loading_submit = true;
            this.$http
                .post(`${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        searchClients() {
            this.searchServiceNumberByType();
        },
        searchSunat() {
            this.searchServiceNumber();
        }
    }
};
</script>
