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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                        v-model="service.selected"
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
                                    v-for="service in servicesById[10]"
                                    :key="service.id"
                                >
                                    <el-checkbox
                                        v-model="service.selected"
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
import personalForm from "../../mecanico/form.vue";
export default {
    components: {
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
            activeTab: "Motor",
            vehiculo: {},
            services_details: [],
            services_detail_ids: [],
            services: [],
            loading_submit: false,
            showDialogNewPersonal: false,
            showDialogChecklist: false,
            loading_search: false,
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
            this.resetForm();
            this.getServicesDetails();
            this.titleDialog = this.recordId
                ? "Editar Datos de Vehiculo"
                : "Nuevo Registro de Vehiculo";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/historial/record2/${this.recordId}`)
                    .then(response => {
                        let data = response.data.data;
                        let services_details_ids = data.services_details.map(
                            element => element.id
                        );

                        this.form = response.data.data;
                        this.historial = this.form.historial || {};
                        this.vehiculo = this.form.vehicle_features[0];

                        this.form.services_detail_ids = services_details_ids;
                        this.services_detail_ids = this.form.services_detail_ids;
                        console.log(
                            "services_detail_ids",
                            this.services_detail_ids
                        );

                        this.getServicesDetails();
                    });
            } else {
                this.initForm();
            }
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
                vehiculo_id: this.vehiculoId,
                personal_id: null,
                observacion: null,
                motive: null,
                reparacion: false,
                garantia: false,
                mantenimiento: false,
                diagnostico: false
            };
        },
        resetForm() {
            this.form = {};
            this.services_details = [];
            this.services_detail_ids = [];
            this.vehiculo = {};
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
                    this.services_details = response.data.data.map(service => ({
                        ...service,
                        selected: false
                    }));
                    console.log("Servicios detallados:", this.services_details);

                    if (this.recordId && this.form.services_detail_ids) {
                        this.markSelectedServices();
                    }
                })
                .catch(error => {
                    console.error("Servicios Detallados:", error);
                });
        },
        markSelectedServices() {
            const selectedIds = new Set(this.services_detail_ids);
            this.services_details = this.services_details.map(service => ({
                ...service,
                selected: selectedIds.has(service.id)
            }));
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
            this.form.services_detail_ids = this.services_details
                .filter(service => service.selected)
                .map(service => service.id);
            this.loading_submit = true;
            try {
                const response = await this.$http.post(
                    `/${this.resource}/new-history`,
                    this.form
                );
                console.log(response.data);
                this.$showSAlert(
                    "Nuevo historial registrado con éxito",
                    "success"
                );
                this.close();
                this.$emit("actualizar");
            } catch (error) {
                this.$showSAlert(
                    "ERROR",
                    "Error al guardar el vehículo",
                    "error"
                );
            }
            this.loading_submit = false;
        },
        close() {
            this.resetForm();
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
