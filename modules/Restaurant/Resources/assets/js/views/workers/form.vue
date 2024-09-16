<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="rounded-dialog"
        :close-on-click-modal="false"
    >
        <br />
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.number }"
                        >
                            <div>
                                <i class="far fa-id-card"></i>
                                <!-- Icono de documento de identidad -->
                                <label class="control-label">DNI</label>
                            </div>
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
                            <div>
                                <i class="fas fa-user"></i>
                                <!-- Icono de usuario -->
                                <label class="control-label"
                                    >Nombres / Apellidos</label
                                >
                            </div>
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
                            <div>
                                <i class="fas fa-toolbox"></i>
                                <!-- Icono de Tipo de trabajador -->
                                <label class="control-label"
                                    >Tipo de trabajador</label
                                >
                            </div>
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
                            <div>
                                <i class="fa-solid fa-layer-group"></i>
                                <label class="control-label"
                                    >Área de trabajo</label
                                >
                            </div>
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
                            <div>
                                <i class="fas fa-store"></i>
                                <!-- Icono de tienda -->
                                <label class="control-label"
                                    >Establecimiento</label
                                >
                            </div>
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
                            <!-- <label class="control-label">Teléfono</label> -->
                            <div>
                                <i class="fab fa-whatsapp"></i>
                                <!-- Icono de WhatsApp -->
                                <label class="control-label">Teléfono</label>
                            </div>
                            <el-input v-model="form.telephone"> </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.telephone"
                                v-text="errors.telephone[0]"
                            ></small>
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
                    <div
                        class="col-md-4"
                        v-if="configuration.sale_note_credit_confirm"
                    >
                        <i class="far fa-credit-card"></i>
                        <!-- Icono de tarjeta de crédito -->
                        <label for="product"
                            >Créditos en Notas de Venta
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="si le da click al check  permitira  que el usuario acepte creditos en el Modo CREDITOS  EN NOTA DE VENTA"
                                placement="top"
                            >
                                <i class="fas fa-info-circle"></i>
                            </el-tooltip>
                        </label>
                        <el-checkbox
                            v-model="form.can_accept_credit_sale_note"
                            label="Acepta Créditos"
                        ></el-checkbox>
                    </div>
                    <div class="col-md-4" v-if="configuration.principal_cash">
                        <label for="product" class="w-100">
                            <i class="fas fa-cash-register"></i>

                            Usuario arca
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="si le da click al check  permitira  que el usuario administrador tenga las opciones de usuario arca"
                                placement="top"
                            >
                                <i class="fas fa-info-circle"></i>
                            </el-tooltip>
                        </label>
                        <el-checkbox
                            v-model="form.is_arca"
                            label="Es arca"
                        ></el-checkbox>
                    </div>

                    <!-- <div class="col-md-4" v-if="configuration.user_series_independientes_caja">
                    <div class="form-group" :class="{ 'has-danger': errors.series_type_id }">
                        <div>
                            <i class="fas fa-toolbox"></i>
                            
                            <label class="control-label">Seleccione Serie</label>
                        </div>
                        <el-select clearable v-model="form.series">
                            <el-option v-for="(data, index) in series" :key="index" :label="data.number" :value="data.id"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small> 
                    </div>
                </div> -->
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

                    <!--<div class="col-md-4">
                    <label class="form-control"> Seleccione Numero</label>
                     <div class="form-group mb-0" :class="{'has-danger': row.errors.document_type_id}">
                        <el-select v-model="row.document_type_id">
                            <el-option v-for="option in document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="row.errors.document_type_id" v-text="row.errors.document_type_id[0]"></small>
                    </div>
                </div> -->
                </div>
            </div>
    
            <div class="row" v-if="configuration.commercial_treatment_items">
                <div class="col-12">
                    Tratamientos Comerciales
                </div>
                <div class="col-12">
                    <el-tag
                        v-for="(data, index) in commercial_treatment_users"
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
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()" icon="fas fa-times">
                    Cancelar</el-button
                >
                <!-- Botón de Cancelar con icono -->
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    icon="fas fa-save"
                >
                    Guardar</el-button
                >
                <!-- Botón de Guardar con icono -->
            </div>

            <!-- <div class="form-actions text-end pt-2 pb-2">
            <el-button @click.prevent="close()">Cancelar</el-button>
            <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
        </div> -->
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
    props: [
        "showDialog",
        "recordId",
        "areas",
        "commercial_treatment",
        "configuration",
        "workersType",
        "establishments",
        "allEstablishments",
        "allWarehouses",
        "series"
    ],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "workers",
            errors: {},
            form: {},
            options: [],
            commercial_treatment_users: []
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        clickTag(data) {
            this.$http
                .post(`${this.resource}/commercial_treatment`, {
                    worker_id: this.form.id,
                    commercial_treatment_id: data.id
                })
                .then(response => {
                    this.create();
                    this.$toast.success(response.data.message);
                }).catch(error => {
                    console.log(error);
                    this.$toast.error("Error al guardar el tratamiento comercial");
                });
                
        },
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
        setCommercialTreatments() {
            if(this.form.commercial_treatment){
                this.commercial_treatment_users = this.commercial_treatment_users.map(
                    item => {
                        let exist = this.form.commercial_treatment.find(
                            element => element.id === item.id
                        );
                        if (exist) {
                            item.active = false;
                        }
                        return item;
                    }
                );
            }
        },

        create() {
            this.commercial_treatment_users = [...this.commercial_treatment];
            this.commercial_treatment_users = this.commercial_treatment_users.map(
                item => {
                    item.active = true;
                    return item;
                }
            );

            this.titleDialog = this.recordId ? "Editara " : "Nuevo ";
            if (this.recordId) {
                this.$http
                    .get(`${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.form.is_arca = this.form.is_arca == 1;
                        this.form.can_accept_credit_sale_note =
                            this.form.can_accept_credit_sale_note == 1;
                            this.setCommercialTreatments();
                    });
            }
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        // this.$toast.success(response.data.message);
                        this.$showSAlert(
                            "ok",
                            response.data.message,
                            "<i class='fa fa-cogs'></i>"
                        );
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
