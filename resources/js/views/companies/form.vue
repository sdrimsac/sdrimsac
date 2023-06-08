<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div v-loading="loading" class="card">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Datos de la Empresa</h6>
                </div>
                <div class="card-body">
                    <form autocomplete="off">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.number }"
                                    >
                                        <label class="control-label"
                                            >Número</label
                                        >
                                        <el-input
                                            @input="searchDocument()"
                                            v-model="form.number"
                                            :maxlength="11"
                                            :show-word-limit="true"
                                        >
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.number"
                                            v-text="errors.number[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.name }"
                                    >
                                        <label class="control-label"
                                            >Nombre
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >

                                        <el-input v-model="form.name" disabled>
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.name"
                                            v-text="errors.name[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.representative
                                        }"
                                    >
                                        <label class="control-label"
                                            >Representante Legal
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input v-model="form.representative">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.representative"
                                            v-text="errors.representative[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.representative_number
                                        }"
                                    >
                                        <label class="control-label"
                                            >Nº DNI Representante Legal
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input
                                            :maxlength="8"
                                            @input="searchDocument(false)"
                                            v-model="form.representative_number"
                                        >
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.representative_number"
                                            v-text="
                                                errors.representative_number[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.representative_address
                                        }"
                                    >
                                        <label class="control-label"
                                            >Direccion Representante Legal
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input
                                            v-model="
                                                form.representative_address
                                            "
                                        >
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.representative_address"
                                            v-text="
                                                errors.representative_address[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.trade_name
                                        }"
                                    >
                                        <label class="control-label"
                                            >Nombre comercial
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input v-model="form.trade_name">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.trade_name"
                                            v-text="errors.trade_name[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.eslogan
                                        }"
                                    >
                                        <label class="control-label"
                                            >eslogan<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input v-model="form.eslogan">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.eslogan"
                                            v-text="errors.eslogan[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Logo</label
                                        >
                                        <el-input
                                            v-model="form.logo"
                                            :readonly="true"
                                        >
                                            <el-upload
                                                slot="append"
                                                :headers="headers"
                                                :data="{ type: 'logo' }"
                                                action="/companies/uploads"
                                                :show-file-list="false"
                                                :on-success="successUpload"
                                            >
                                                <el-button
                                                    type="primary"
                                                    icon="el-icon-upload"
                                                ></el-button>
                                            </el-upload>
                                        </el-input>
                                        <div class="badge text-danger">
                                            <small
                                                >Se recomienda resoluciones
                                                700x300</small
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Logo Documento</label
                                        >
                                        <el-input
                                            v-model="form.document_logo"
                                            :readonly="true"
                                        >
                                            <el-upload
                                                slot="append"
                                                :headers="headers"
                                                :data="{
                                                    type: 'document_logo'
                                                }"
                                                action="/companies/uploads"
                                                :show-file-list="false"
                                                :on-success="successUpload"
                                            >
                                                <el-button
                                                    type="primary"
                                                    icon="el-icon-upload"
                                                ></el-button>
                                            </el-upload>
                                        </el-input>
                                        <div class="badge text-danger">
                                            <small
                                                >Se recomienda resoluciones
                                                700x300</small
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Imagen Fondo</label
                                        >
                                        <el-input
                                            v-model="form.img_bg"
                                            :readonly="true"
                                        >
                                            <el-upload
                                                slot="append"
                                                :headers="headers"
                                                :data="{ type: 'img_bg' }"
                                                action="/companies/img_bg"
                                                :show-file-list="false"
                                                :on-success="successUpload"
                                            >
                                                <el-button
                                                    type="primary"
                                                    icon="el-icon-upload"
                                                ></el-button>
                                            </el-upload>
                                        </el-input>
                                        <div class="badge text-danger">
                                            <small
                                                >Se recomienda resoluciones
                                                700x300</small
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Favicon</label
                                        >
                                        <el-input
                                            v-model="form.favicon"
                                            :readonly="true"
                                        >
                                            <el-upload
                                                slot="append"
                                                :headers="headers"
                                                :data="{ type: 'favicon' }"
                                                action="/companies/favicon"
                                                :show-file-list="false"
                                                :on-success="successUpload"
                                            >
                                                <el-button
                                                    type="primary"
                                                    icon="el-icon-upload"
                                                ></el-button>
                                            </el-upload>
                                        </el-input>
                                        <div class="badge text-danger">
                                            <small
                                                >Se recomienda resoluciones
                                                32x32</small
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4" v-show="false">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.operation_amazonia
                                    }"
                                >
                                    <el-checkbox
                                        v-model="form.operation_amazonia"
                                        >¿Emite en la Amazonía?</el-checkbox
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h6 class="border-bottom">
                                    Entorno del sistema
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.soap_type_id
                                    }"
                                >
                                    <label class="control-label"
                                        >SOAP Tipo</label
                                    >
                                    <el-select v-model="form.soap_type_id">
                                        <el-option
                                            v-for="option in soap_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>

                                    <el-checkbox
                                        v-if="
                                            form.soap_send_id == '02' &&
                                                form.soap_type_id == '01'
                                        "
                                        v-model="toggle"
                                        label="Ingresar Usuario"
                                    >
                                    </el-checkbox>
                                    <small
                                        class="text-danger"
                                        v-if="errors.soap_type_id"
                                        v-text="errors.soap_type_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div
                                class="col-md-3"
                                v-if="form.soap_type_id != '03'"
                            >
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.soap_send_id
                                    }"
                                >
                                    <label class="control-label"
                                        >SOAP Envio</label
                                    >
                                    <el-select v-model="form.soap_send_id">
                                        <el-option
                                            v-for="(option,
                                            index) in soap_sends"
                                            :key="index"
                                            :value="index"
                                            :label="option"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.soap_send_id"
                                        v-text="errors.soap_send_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div
                                class="col-md-4"
                                v-if="form.soap_type_id == '02'"
                            >
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.soap_send_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Certificado Digital</label
                                    >
                                    <tenant-certificates-index></tenant-certificates-index>
                                </div>
                            </div>
                        </div>
                        <template
                            v-if="form.soap_type_id == '02' || toggle == true"
                        >
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <h6 class="border-bottom">
                                        Usuario Secundario Sunat
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.soap_username
                                        }"
                                    >
                                        <label class="control-label"
                                            >SOAP Usuario
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input v-model="form.soap_username">
                                        </el-input>
                                        <div class="badge text-muted">
                                            <small
                                                >RUC + Usuario. Ejemplo:
                                                01234567890ELUSUARIO</small
                                            >
                                        </div>
                                        <small
                                            class="text-danger"
                                            v-if="errors.soap_username"
                                            v-text="errors.soap_username[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.soap_password
                                        }"
                                    >
                                        <label class="control-label"
                                            >SOAP Password
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <el-input v-model="form.soap_password">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.soap_password"
                                            v-text="errors.soap_password[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="row" v-if="form.soap_send_id == '02'">
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.soap_url }"
                                >
                                    <label class="control-label"
                                        >SOAP Url</label
                                    >
                                    <el-input v-model="form.soap_url">
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.soap_url"
                                        v-text="errors.soap_url[0]"
                                    ></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-end pt-2 pb-2">
                            <el-button
                                type="primary"
                                :loading="loading_submit"
                                @click="submit()"
                                >Guardar</el-button
                            >
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">Guías electrónicas</h6>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="submit">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="border-bottom">
                                            Usuario Secundario Sunat
                                        </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div
                                            :class="{
                                                'has-danger':
                                                    errors.soap_sunat_username
                                            }"
                                            class="form-group"
                                        >
                                            <label class="control-label"
                                                >SOAP Usuario</label
                                            >
                                            <el-input
                                                v-model="
                                                    form.soap_sunat_username
                                                "
                                            ></el-input>
                                            <div class="sub-title text-muted">
                                                <small
                                                    >RUC + Usuario. Ejemplo:
                                                    01234567890ELUSUARIO</small
                                                >
                                            </div>
                                            <small
                                                v-if="
                                                    errors.soap_sunat_username
                                                "
                                                class="form-control-feedback"
                                                v-text="
                                                    errors
                                                        .soap_sunat_username[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            :class="{
                                                'has-danger':
                                                    errors.soap_sunat_password
                                            }"
                                            class="form-group"
                                        >
                                            <label class="control-label"
                                                >SOAP Password</label
                                            >
                                            <el-input
                                                v-model="
                                                    form.soap_sunat_password
                                                "
                                            ></el-input>
                                            <small
                                                v-if="
                                                    errors.soap_sunat_password
                                                "
                                                class="form-control-feedback"
                                                v-text="
                                                    errors
                                                        .soap_sunat_password[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div
                                            :class="{
                                                'has-danger':
                                                    errors.api_sunat_id
                                            }"
                                            class="form-group"
                                        >
                                            <label class="control-label"
                                                >Client ID</label
                                            >
                                            <el-input
                                                v-model="form.api_sunat_id"
                                            ></el-input>
                                            <small
                                                v-if="errors.api_sunat_id"
                                                class="form-control-feedback"
                                                v-text="errors.api_sunat_id[0]"
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            :class="{
                                                'has-danger':
                                                    errors.api_sunat_secret
                                            }"
                                            class="form-group"
                                        >
                                            <label class="control-label"
                                                >Client Secret (Clave)</label
                                            >
                                            <el-input
                                                v-model="form.api_sunat_secret"
                                            ></el-input>
                                            <small
                                                v-if="errors.api_sunat_secret"
                                                class="form-control-feedback"
                                                v-text="
                                                    errors.api_sunat_secret[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-right pt-2">
                                <el-button
                                    :loading="loading_submit"
                                    native-type="submit"
                                    type="primary"
                                    >Guardar
                                </el-button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <el-divider></el-divider> -->
                <establishments-index
                    :soap_type_id="form.soap_type_id"
                ></establishments-index>
            </div>
        </div>
    </div>
</template>
<style>
.no-radius.card-header {
    border-radius: 0px !important;
}
</style>
<script>
// tenant-certificates-index
const TenantCertificatesIndex = () => import("../certificates/index.vue");
const EstablishmentsIndex = () => import("../establishments/index.vue");
export default {
    components: { TenantCertificatesIndex, EstablishmentsIndex },
    data() {
        return {
            loading_submit: false,
            headers: headers_token,
            resource: "companies",
            errors: {},
            time: null,
            form: {},
            soap_sends: [],
            soap_types: [],
            loading: false,
            toggle: false //Creando el objeto a retornar con v-model
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.soap_sends = response.data.soap_sends;
            this.soap_types = response.data.soap_types;
        });
        await this.$http.get(`/${this.resource}/record`).then(response => {
            if (response.data !== "") {
                this.form = response.data.data;
            }
        });
    },
    methods: {
        async searchDocument(isRuc = true) {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                let number = isRuc
                    ? this.form.number
                    : this.form.representative_number;
                if (!number) {
                    return this.$toast.warning(`No puede ser un campo vacio`);
                }
                if (isRuc && number.length != 11) {
                    return;
                }

                ///service/ruc/xxxx
                try {
                    this.loading = true;
                    const response = await this.$http(
                        `/service/${isRuc ? "ruc" : "dni"}/${number}`
                    );
                    if (response.status == 200) {
                        const { success, data } = response.data;
                        if (success) {
                            if (isRuc) {
                                //direccion_completa
                                this.form.name = data.nombre_o_razon_social;
                                this.form.trade_name =
                                    data.nombre_o_razon_social;
                            } else {
                                this.form.representative_address =
                                    data.direccion_completa;
                                this.form.representative = data.nombre_completo;
                            }
                        } else {
                            this.$toast.warning(
                                `El número ${number} es incorrecto`
                            );
                        }
                    } else {
                        this.$toast.error(
                            "Ocurrió un error al buscar: " + number
                        );
                    }
                } catch (e) {
                    console.log(e);
                    this.$toast.error("Ocurrió un error ");
                } finally {
                    this.loading = false;
                }
            }, 600);
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                identity_document_type_id: "06000006",
                number: null,
                name: null,
                trade_name: null,
                soap_send_id: "01",
                soap_type_id: "01",
                soap_username: null,
                soap_password: null,
                soap_url: null,
                certificate: null,
                logo: null,
                favicon: null,
                key: null,
                logo_store: null,
                img_bg: null,
                detraction_account: null,
                operation_amazonia: false,
                toggle: false,
                config_system_env: false,
                representative: null,
                representative_number: null,
                representative_address: null,
                eslogan: null,
                pusher_app_key: null,
                pusher_app_secret: null,
                pusher_app_id: null,
                pusher_app_cluster: null
            };
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        //console.log(error.response.data.errors.name[0]);
                        this.$toast.error(error.response.data.errors.name[0]);
                        this.errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        successUploadBg(response, file, fileList) {
            if (response.success) {
                this.$toast.success(response.message);
                this.form.img_bg = response.name;
            } else {
                this.$toast.error("Error al subir el archivo");
            }
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$toast.success(response.message);
                this.form[response.type] = response.name;
            } else {
                this.$toast.error("Error al subir el archivo");
            }
        }
    }
};
</script>
