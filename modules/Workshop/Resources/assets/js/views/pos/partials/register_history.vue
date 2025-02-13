<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        :close-on-click-modal="false"
        @close="close"
        @open="create"
        width="70%"
        append-to-body
    >
        <form @submit.prevent="submit">
            <br />
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 pb-2">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.customer_id }"
                            >
                                <label>
                                    Cliente
                                    <a
                                        href="#"
                                        @click.prevent="
                                            showDialogNewPerson = true
                                        "
                                        >[+ Nuevo]</a
                                    >
                                </label>
                                <el-select
                                    v-model="form.customer_id"
                                    filterable
                                    remote
                                    class="border-left rounded-left border-info"
                                    popper-class="el-select-customers"
                                    dusk="customer_id"
                                    placeholder="Escriba el nombre o número de documento del cliente"
                                    :remote-method="searchRemoteCustomers"
                                    :loading="loading_search"
                                >
                                    <el-option
                                        v-for="option in customers"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.placa }"
                            >
                                <label class="control-label">
                                    Número de Placa
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Este campo es obligatorio...!!!"
                                        placement="top"
                                    >
                                        <i
                                            class="fas fa-info-circle text-danger"
                                        ></i>
                                    </el-tooltip>
                                </label>
                                <div>
                                    <el-input
                                        ref="number"
                                        v-model="form.placa"
                                        :maxlength="6"
                                        dusk="number"
                                        show-word-limit
                                    >
                                        <template v-slot:append>
                                            <el-button
                                                :loading="loading_search"
                                                icon="el-icon-search"
                                                @click.prevent="searchPlaca"
                                            ></el-button>
                                        </template>
                                        <template v-slot:prefix>
                                            <i class="el-icon-edit-outline"></i>
                                        </template>
                                    </el-input>
                                </div>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.placa"
                                    v-text="errors.placa[0]"
                                ></small>
                            </div>
                        </div>
                        <div
                            class="col-md-3"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label for="tipo-vehiculo">Tipo de Vehiculo</label>
                            <el-select
                                v-model="form.tipo_vehiculo_id"
                                filterable
                                placeholder="Seleccione un tipo de vehículo"
                                @focus="getTipoVehiculo"
                            >
                                <el-option
                                    v-for="option in tipo_vehiculo"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.description"
                                v-text="errors.description[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.serie }"
                        >
                            <label>Serie</label>
                            <el-input v-model="form.serie"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.serie"
                                v-text="errors.serie[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.modelo }"
                        >
                            <label>Modelo</label>
                            <el-input v-model="form.modelo"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.modelo"
                                v-text="errors.modelo[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.marca }"
                        >
                            <label>Marca</label>
                            <el-input v-model="form.marca"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.marca"
                                v-text="errors.marca[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.color }"
                        >
                            <label>Color</label>
                            <el-input v-model="form.color"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.color"
                                v-text="errors.color[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.motor }"
                        >
                            <label>Motor</label>
                            <el-input v-model="form.motor"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.motor"
                                v-text="errors.motor[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.anio_fabricacion }"
                        >
                            <label>Año Fabricacion</label>
                            <el-date-picker
                                v-model="form.anio_fabricacion"
                                type="year"
                                placeholder="Seleccione año"
                                class="w-100"
                            >
                            </el-date-picker>
                            <small
                                class="form-control-feedback"
                                v-if="errors.anio_fabricacion"
                                v-text="errors.anio_fabricacion[0]"
                            ></small>
                        </div>
                        <div
                            class="col-md-4"
                            :class="{ 'has-danger': errors.kilometraje }"
                        >
                            <label>Kilometraje</label>
                            <el-input v-model="form.kilometraje"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.kilometraje"
                                v-text="errors.kilometraje[0]"
                            ></small>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold"
                                >Mecamico
                                <a
                                    href="#"
                                    @click.prevent="
                                        showDialogNewPersonal = true
                                    "
                                    >[+ Nuevo]</a
                                >
                            </label>
                            <el-select
                                v-model="form.personal_id"
                                filterable
                                @focus="getPersonalMecanica"
                            >
                                <el-option
                                    v-for="option in personal"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <label>Motivo de Ingreso</label>
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="Please input"
                                v-model="form.observacion"
                            ></el-input>
                        </div>
                        <div class="col-md-6">
                            <label>Trabajo a Realizar o Realizado</label>
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="Please input"
                                v-model="form.motive"
                            ></el-input>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <el-checkbox v-model="form.reparacion"
                                >Reparacion</el-checkbox
                            >
                        </div>
                        <div class="col-md-3">
                            <el-checkbox v-model="form.garantia"
                                >Garantia</el-checkbox
                            >
                        </div>
                        <div class="col-md-3">
                            <el-checkbox v-model="form.mantenimiento"
                                >Mantenimiento</el-checkbox
                            >
                        </div>
                        <div class="col-md-3">
                            <el-checkbox v-model="form.diagnostico"
                                >Diagnostico</el-checkbox
                            >
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-body">
                    <el-tabs tab-position="top">
                        <el-tab-pane label="Motor" v-if="servicesById[1]">
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[1]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane label="Frenos" v-if="servicesById[2]">
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[2]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane label="Transmision" v-if="servicesById[3]">
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[3]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane
                            label="Sitema de Escape"
                            v-if="servicesById[4]"
                        >
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[4]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane label="Suspension" v-if="servicesById[5]">
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[5]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane
                            label="Sistema Electrico"
                            v-if="servicesById[6]"
                        >
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[6]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane
                            label="Neumaticos Rotacion"
                            v-if="servicesById[7]"
                        >
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[7]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane
                            label="Sistema de Direccion"
                            v-if="servicesById[8]"
                        >
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[8]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane
                            label="Aire Acondicionado"
                            v-if="servicesById[9]"
                        >
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[9]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane
                            label="Sistema de Refrigeracion"
                            v-if="servicesById[10]"
                        >
                            <div class="row">
                                <div
                                    class="col-md-6"
                                    v-for="service in servicesById[9]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        @change="updateServicesIds(service.id)"
                                        >{{ service.name }}</el-checkbox
                                    >
                                </div>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </div>
            <br />
            <div class="col-md-12">
                <div class="card">
                    <div class="">
                        <el-tabs v-model="activeTab">
                            <el-tab-pane label="Check-List" name="vehiculo">
                                <span slot="label">
                                    <h6>Check-List</h6>
                                </span>
                                <div v-if="activeTab === 'vehiculo'">
                                    <checklist
                                        :vehiculo.sync="vehiculo"
                                    ></checklist>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="close">
                                <span slot="label">
                                    <h6>Close</h6>
                                </span>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Generar</el-button
                >
            </div>
            <br />
        </form>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :external="true"
            :user_id="form.user_id"
            :document_type_id="form.document_type_id"
        ></person-form>
        <personal-form
            :showDialog.sync="showDialogNewPersonal"
            type="personal"
            :external="true"
        ></personal-form>
    </el-dialog>
</template>
<script>
import checklist from "./checklist.vue";
import personForm from "../../../../../../../../resources/js/views/persons/form.vue";
import personalForm from "../../mecanico/form.vue";
export default {
    components: {
        personForm,
        checklist,
        personalForm
    },
    props: ["showDialog", "recordId"],
    data() {
        return {
            tabPosition: "left",
            titleDialog: null,
            errors: {},
            form: {},
            activeTab: "Motor",
            vehiculo: {},
            services_details: [],
            services_detail_ids: [],
            services: [],
            loading_submit: false,
            showDialogNewPerson: false,
            showDialogNewPersonal: false,
            showDialogChecklist: false,
            loading_search: false,
            customers: [],
            tipo_vehiculo: [],
            personal: [],
            historial: {},
            tipo_vehiculo_id: null,
            personal_id: null,
            resource: "workshop",
            value: null,
            number: null
        };
    },
    async created() {
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
        await this.initForm();
    },
    watch: {
        all_customers(newCustomer, _) {
            this.customers = newCustomer.filter(n => n.number != "88888888");
        }
    },
    computed: {
        servicesById() {
            return this.services_details.reduce((acc, service) => {
                if (!acc[service.service_id]) {
                    acc[service.service_id] = [];
                }
                acc[service.service_id].push(service);
                return acc;
            }, {});
        }
    },
    methods: {
        create() {
            this.titleDialog = this.recordId
                ? "Editar Datos de Vehiculo"
                : "Nuevo Registro de Vehiculo";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/vehiculo/record/${this.recordId}`)
                    .then(response => {
                        let data = response.data;
                        this.form = response.data.data;
                        this.vehiculo = this.form.vehiculo || {};
                    });
            }
            this.initForm();
            this.getTipoVehiculo();
            this.getServicesDetails();
            this.vehiculo = {};
        },
        updateRecord() {
            console.log("Actualizando registro", this.form);
            this.close();
        },
        listChekout() {
            this.showDialogChecklist = true;
        },
        updateServicesIds(id) {
            const index = this.services_detail_ids.indexOf(id);
            if (index === -1) {
                this.services_detail_ids.push(id);
            } else {
                this.services_detail_ids.splice(index, 1);
            }
            console.log(this.services_detail_ids);
        },
        initForm() {
            this.errors = {};
            this.form = {
                placa: null,
                marca: null,
                modelo: null,
                serie: null,
                color: null,
                motor: null,
                kilometraje: null,
                anio_fabricacion: null,
                customer_id: null,
                tipo_vehiculo_id: null,
                personal_id: null,
                observacion: null,
                motive: null,
                reparacion: 0,
                garantia: 0,
                mantenimiento: 0,
                diagnostico: 0,
                selectedServices: [],
                services_detail_ids: []
            };
        },
        searchPlaca() {
            this.loading_search = true;
            this.$http(`/carros/${this.form.placa}`)
                .then(response => {
                    const data = response.data.data;

                    this.form.serie = data.serie || "";
                    this.form.modelo = data.modelo || "";
                    this.form.marca = data.marca || "";
                    this.form.color = data.color || "";
                    this.form.motor = data.motor || "";
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.data;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {
                    this.loading_search = false;
                });
        },
        getTipoVehiculo() {
            if (this.tipo_vehiculo.length === 0) {
                this.$http
                    .get(`/${this.resource}/tipo/records`)
                    .then(response => {
                        this.tipo_vehiculo = response.data.data;
                        console.log("Tipos de vehículo:", this.tipo_vehiculo);
                    })
                    .catch(error => {
                        console.error(
                            "Error al obtener los tipos de vehículo:",
                            error
                        );
                    });
            }
        },
        getPersonalMecanica() {
            this.$http
                .get(`/${this.resource}/mecanico/records`)
                .then(response => {
                    this.personal = response.data.data;
                    console.log("Servicios detallados:", this.personal);
                })
                .catch(error => {
                    console.error("Servicios Detallados:", error);
                });
        },
        getServicesDetails() {
            this.$http
                .get(`/${this.resource}/servicesdetails/records`)
                .then(response => {
                    this.services_details = response.data.data;
                    this.services = this.services_details;
                    console.log("Servicios detallados:", this.services_details);
                })
                .catch(error => {
                    console.error("Servicios Detallados:", error);
                });
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/workshop/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.customers = this.all_customers;
                        }
                    });
            } else {
                this.customers = this.all_customers;
            }
        },
        validateVehiculo(vehiculo) {
            for (let prop in vehiculo) {
                if (prop === "gasoline_level") continue;
                if (vehiculo[prop] !== undefined) {
                    return true;
                }
            }
            return false;
        },
        validateForm() {
            const requiredFields = [
                "customer_id",
                "placa",
                "tipo_vehiculo_id",
                "serie",
                "color",
                "modelo",
                "marca",
                "motor",
                "anio_fabricacion",
                "kilometraje",
                "personal_id",
                "observacion"
            ];
            for (const field of requiredFields) {
                if (!this.form[field]) {
                    this.$showSAlert(
                        "ALERTA",
                        `El campo ${field.replace("_", " ")} es obligatorio`,
                        "error"
                    );
                    return false;
                }
            }
            return true;
        },
        async submit() {
            if (!this.validateForm()) {
                return;
            }
            if (this.validateVehiculo(this.vehiculo)) {
                this.form.vehiculo = this.vehiculo;
            }
            this.form.services_detail_ids = this.services_detail_ids;
            this.loading_submit = true;
            try {
                const response = await this.$http.post(
                    "/workshop/vehiculo",
                    this.form
                );
                this.$showSAlert(
                    "Vehiculo registrado correctamente",
                    "success"
                );
                this.$emit("recargar");
                this.close();
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.data;
                } else {
                    this.$showSAlert(
                        "ALERTA",
                        "Error al guardar el vehículo",
                        "error"
                    );
                }
            }
            this.loading_submit = false;
        },
        open() {},
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
