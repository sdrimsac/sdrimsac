<template>
    <el-dialog
        title="Nuevo Historial"
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
                        <div class="col-md-4">
                            <label class="fw-bold">
                                Mecamico
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
                        <div class="col-md-4">
                            <label>Motivo de Ingreso</label>
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="Please input"
                                v-model="form.observacion"
                            ></el-input>
                        </div>
                        <div class="col-md-4">
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
                    <div class="card-body">
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
    props: ["showDialog", "recordId", "vehiculoId", "historial_id"],
    data() {
        return {
            customers: [],
            titleDialog: null,
            errors: {},
            form: {},
            activeTab: "",
            vehiculo: {},
            services_details: [],
            services_detail_ids: [],
            activeTab: "Motor",
            services: [],
            loading_submit: false,
            showDialogNewPerson: false,
            showDialogNewPersonal: false,
            showDialogChecklist: false,
            errors: {},
            form: {},
            loading_search: false,
            tipo_vehiculo: [],
            servicesDetails: [],
            personal: [],
            historial: {},
            tipo_vehiculo_id: null,
            personal_id: null,
            resource: "workshop",
            value: null,
            number: null
        };
    },
    mounted() {
        console.log(
            "pARA CREAR UN NUEVO HISTORIAL PARA ESE VEHICULO ID ",
            this.vehiculoId
        );
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
                    .get(`/${this.resource}/historial/record2/${this.recordId}`)
                    .then(response => {
                        let data = response.data;
                        this.form = response.data.data;
                        this.historial = this.form.historial || {};
                    });
            }
            this.initForm();
        },
        updateRecord() {
            console.log("Actualizando registro", this.form);
            this.close();
        },
        /* fillForm(data) {
      this.form = { ...data };
    }, */
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
                vehiculo_id: this.vehiculoId,
                personal_id: null,
                observacion: null,
                motive: null
            };
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
        validateVehiculo(vehiculo) {
            for (let prop in vehiculo) {
                if (prop === "gasoline_level") continue;
                if (vehiculo[prop] !== undefined) {
                    return true;
                }
            }
            return false;
        },
        async submit() {
            if (this.validateVehiculo(this.vehiculo)) {
                this.form.vehiculo = this.vehiculo;
            }
            this.form.services_detail_ids = this.services_detail_ids;
            this.loading_submit = true;
            try {
                const response = await this.$http.post(
                    this.recordId ? `/${this.resource}/historial/update/${this.recordId}` : "/workshop/new-history",
                    this.form
                );
                console.log(response.data);
                this.$message({
                    message: this.recordId ? "El Vehiculo ha sido actualizado correctamente" : "El Vehiculo ha sido registrado correctamente"
                });
                this.close();
            } catch (error) {
                console.error("Error al guardar el vehículo:", error);
            }
            this.loading_submit = false;
        },
        open() {
          /* this.getServicesDetails(); */
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
