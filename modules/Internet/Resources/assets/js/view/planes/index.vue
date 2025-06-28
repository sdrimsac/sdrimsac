<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0" v-loading="loading">
            <div class="d-flex flex-wrap justify-content-center w-100">
                <div class="col-md-6 col-12 card m-2 flex-grow-1" style="min-width:350px; max-width: 700px;">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h6 class="my-0 text-white">Lista de Planes</h6>
                        <button type="button" class="btn_guardarsmall" @click="newPlan()">
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row table-responsive">
                            <table class="table table-striped table-hover w-100 shadow-sm rounded"
                                style="background: #fff; border-radius: 8px; overflow: hidden;">
                                <thead>
                                    <tr
                                        style="background: linear-gradient(90deg, #1e5a85 0%, #2980b9 100%); color: #fff;">
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">#</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Descripción</th>
                                        <!-- <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Precio</th> -->
                                        <th
                                            style="color: #fff; font-weight: 600; letter-spacing: 1px; text-align: center;">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, idx) in paginatedPlanes" :key="idx"
                                        :style="{ background: idx % 2 === 0 ? '#f8fafc' : '#eaf1f8' }">
                                        <td style="vertical-align: middle; font-weight: 500;">{{ idx + 1 }}</td>
                                        <td style="vertical-align: middle;">{{ record.capacity }} Mb</td>
                                        <!-- <td style="vertical-align: middle;">{{ record.default_price }}</td> -->
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <el-tooltip content="Editar" placement="top">
                                                    <el-button size="mini" type="primary" icon="el-icon-edit" circle
                                                        @click="Edititem('planes', record.id)"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                                <el-tooltip :content="record.active ? 'Desactivar' : 'Activar'"
                                                    placement="top">
                                                    <el-button size="mini" :type="record.active ? 'danger' : 'success'"
                                                        :icon="record.active ? 'el-icon-close' : 'el-icon-check'" circle
                                                        @click="desactive(record.id, 'planes')"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!paginatedPlanes.length">
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="el-icon-info"></i> No hay planes registrados.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <button class="btn btn-sm btn-outline-primary" :disabled="planesPage === 1"
                                    @click="planesPage--">Anterior</button>
                                <span>Página {{ planesPage }}</span>
                                <button class="btn btn-sm btn-outline-primary"
                                    :disabled="planesPage * rowsPerPage >= planes.length"
                                    @click="planesPage++">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 card m-2 flex-grow-1" style="min-width:350px; max-width: 700px;">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h6 class="my-0 text-white">Lista de Conceptos</h6>
                        <button type="button" class="btn_guardarsmall" @click="newConcept()">
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row table-responsive">
                            <table class="table table-striped table-hover w-100 shadow-sm rounded"
                                style="background: #fff; border-radius: 8px; overflow: hidden;">
                                <thead>
                                    <tr
                                        style="background: linear-gradient(90deg, #1e5a85 0%, #2980b9 100%); color: #fff;">
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">#</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Descripción</th>
                                        <!-- <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Precio</th> -->
                                        <th
                                            style="color: #fff; font-weight: 600; letter-spacing: 1px; text-align: center;">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, idx) in paginatedConceptos" :key="idx"
                                        :style="{ background: idx % 2 === 0 ? '#f8fafc' : '#eaf1f8' }">
                                        <td style="vertical-align: middle; font-weight: 500;">{{ idx + 1 }}</td>
                                        <td style="vertical-align: middle;">{{ record.description }}</td>
                                        <!-- <td style="vertical-align: middle;">{{ record.default_price }}</td> -->
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <el-tooltip content="Editar" placement="top">
                                                    <el-button size="mini" type="primary" icon="el-icon-edit" circle
                                                        @click="Edititem('conceptos', record.id)"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                                <el-tooltip :content="record.active ? 'Desactivar' : 'Activar'"
                                                    placement="top">
                                                    <el-button size="mini" :type="record.active ? 'danger' : 'success'"
                                                        :icon="record.active ? 'el-icon-close' : 'el-icon-check'" circle
                                                        @click="desactive(record.id, 'conceptos')"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!paginatedConceptos.length">
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="el-icon-info"></i> No hay conceptos registrados.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <button class="btn btn-sm btn-outline-primary" :disabled="conceptosPage === 1"
                                    @click="conceptosPage--">Anterior</button>
                                <span>Página {{ conceptosPage }}</span>
                                <button class="btn btn-sm btn-outline-primary"
                                    :disabled="conceptosPage * rowsPerPage >= conceptos.length"
                                    @click="conceptosPage++">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center w-100">
                <div class="col-md-6 col-12 card m-2 flex-grow-1" style="min-width:350px; max-width: 700px;">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h6 class="my-0 text-white">Lista de Variacion de Planes</h6>
                        <button type="button" class="btn_guardarsmall" @click="newPlanVar()">
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row table-responsive">
                            <table class="table table-striped table-hover w-100 shadow-sm rounded"
                                style="background: #fff; border-radius: 8px; overflow: hidden;">
                                <thead>
                                    <tr
                                        style="background: linear-gradient(90deg, #1e5a85 0%, #2980b9 100%); color: #fff;">
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">#</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Plan Principal
                                        </th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Descripción
                                            Variacion</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Precio</th>
                                        <th
                                            style="color: #fff; font-weight: 600; letter-spacing: 1px; text-align: center;">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, idx) in paginatedVariacionPlan" :key="idx"
                                        :style="{ background: idx % 2 === 0 ? '#f8fafc' : '#eaf1f8' }">
                                        <td style="vertical-align: middle; font-weight: 500;">{{ idx + 1 }}</td>
                                        <td style="vertical-align: middle;">{{ record.plan_capacity }}Mb</td>
                                        <td style="vertical-align: middle;">{{ record.plan_variation_description }}</td>
                                        <td style="vertical-align: middle;">{{ record.plan_variation_price }}</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <el-tooltip content="Editar" placement="top">
                                                    <el-button size="mini" type="primary" icon="el-icon-edit" circle
                                                        @click="EditVar('planes', record.plan_variation_id)"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                                <el-tooltip
                                                    :content="record.plan_variation_active ? 'Desactivar' : 'Activar'"
                                                    placement="top">
                                                    <el-button size="mini"
                                                        :type="record.plan_variation_active ? 'danger' : 'success'"
                                                        :icon="record.plan_variation_active ? 'el-icon-close' : 'el-icon-check'"
                                                        circle @click="desactiveVar('planes', record.plan_variation_id)"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!paginatedVariacionPlan.length">
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="el-icon-info"></i> No hay variaciones de planes registradas.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <button class="btn btn-sm btn-outline-primary" :disabled="variacionPlanPage === 1"
                                    @click="variacionPlanPage--">Anterior</button>
                                <span>Página {{ variacionPlanPage }}</span>
                                <button class="btn btn-sm btn-outline-primary"
                                    :disabled="variacionPlanPage * rowsPerPage >= variacionPlan.length"
                                    @click="variacionPlanPage++">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card  -->
                <div class="col-md-6 col-12 card m-2 flex-grow-1" style="min-width:350px; max-width: 700px;">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h6 class="my-0 text-white">Lista de Variacion de Conceptos</h6>
                        <button type="button" class="btn_guardarsmall" @click="newConceptVar()">
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row table-responsive">
                            <table class="table table-striped table-hover w-100 shadow-sm rounded"
                                style="background: #fff; border-radius: 8px; overflow: hidden;">
                                <thead>
                                    <tr
                                        style="background: linear-gradient(90deg, #1e5a85 0%, #2980b9 100%); color: #fff;">
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">#</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Concepto
                                            Principal</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Descripción
                                            Variacion</th>
                                        <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Precio</th>
                                        <th
                                            style="color: #fff; font-weight: 600; letter-spacing: 1px; text-align: center;">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, idx) in paginatedVariacionConceptos" :key="idx"
                                        :style="{ background: idx % 2 === 0 ? '#f8fafc' : '#eaf1f8' }">
                                        <td style="vertical-align: middle; font-weight: 500;">{{ idx + 1 }}</td>
                                        <td style="vertical-align: middle;">{{ record.concept_description }}</td>
                                        <td style="vertical-align: middle;">{{ record.concept_variation_description }}
                                        </td>
                                        <td style="vertical-align: middle;">{{ record.concept_variation_price }}</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <el-tooltip content="Editar" placement="top">
                                                    <el-button size="mini" type="primary" icon="el-icon-edit" circle
                                                        @click="EditVar('conceptos', record.concept_variation_id)"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                                <el-tooltip
                                                    :content="record.concept_variation_active ? 'Desactivar' : 'Activar'"
                                                    placement="top">
                                                    <el-button size="mini"
                                                        :type="record.concept_variation_active ? 'danger' : 'success'"
                                                        :icon="record.concept_variation_active ? 'el-icon-close' : 'el-icon-check'"
                                                        circle
                                                        @click="desactiveVar('conceptos', record.concept_variation_id)"
                                                        style="border-radius: 50%;"></el-button>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!paginatedVariacionConceptos.length">
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="el-icon-info"></i> No hay variaciones de conceptos registradas.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <button class="btn btn-sm btn-outline-primary" :disabled="variacionConceptosPage === 1"
                                    @click="variacionConceptosPage--">Anterior</button>
                                <span>Página {{ variacionConceptosPage }}</span>
                                <button class="btn btn-sm btn-outline-primary"
                                    :disabled="variacionConceptosPage * rowsPerPage >= variacionconceptos.length"
                                    @click="variacionConceptosPage++">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card  -->
            </div>
        </div>
        <el-dialog :visible="dialogPlan" append-to-body @close="close('plan')" width="30%" title="Nuevo Plan ">
            <div>
                <div class="row col-md-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <label class="control-label">Tipo de plan / Cantidad de Mb
                        </label>
                        <input class="form-control text-center" type="text" v-model="form.mb"
                            placeholder="Ingrese el número de Mb" size="small" />
                    </div>
                    <!-- <div class="col-md-6">
                        <label>Precio del Plan </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.precioPlan"
                            v-on:keydown="validateNumber"
                            placeholder="Ingrese precio del plan a crear"
                            size="small"
                        />
                    </div> -->
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <el-button class="btn_cancelarsmall" @click="close('plan')">
                        <i class="fas fa-times fa-lg" style="margin-right: 4px;"></i>
                        Cancelar
                    </el-button>
                    <el-button class="btn_guardarsmall" type="primary" :loading="loadsavePlan" @click="saveNewPlan">
                        <i class="fas fa-save fa-lg" style="margin-right: 4px;"></i>
                        Guardar
                    </el-button>
                </div>
            </div>
            <!-- <span slot="footer">
                <el-button @click="close('plan')">Cerrar</el-button>
                <el-button :loading="loadsavePlan" @click="saveNewPlan" class="btn btn-primary">Guardar</el-button>
            </span> -->
        </el-dialog>
        <el-dialog :visible="dialogConcepto" append-to-body @close="close('concepto')" width="30%"
            title="Nuevo Concepto  ">
            <div>
                <div class="row col-md-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <label class="control-label">Descripción del concepto
                        </label>
                        <input class="form-control text-center" type="text" v-model="form.descConcept"
                            placeholder="Ingrese descripción del concepto" size="small" />
                    </div>
                    <!-- <div class="col-md-6">
                        <label>Precio del Plan </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.precioConcepto"
                            v-on:keydown="validateNumber"
                            placeholder="Ingrese precio del Concepto a crear"
                            size="small"
                        />
                    </div> -->
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <el-button class="btn_cancelarsmall" @click="close('concepto')">
                        <i class="fas fa-times fa-lg" style="margin-right: 4px;"></i>
                        Cancelar
                    </el-button>
                    <el-button class="btn_guardarsmall" type="primary" :loading="loadSaveConcept"
                        @click="saveNewConceptos">
                        <i class="fas fa-save fa-lg" style="margin-right: 4px;"></i>
                        Guardar
                    </el-button>
                </div>
            </div>
            <!-- <span slot="footer">
                <el-button @click="close('concepto')">Cerrar</el-button>
                <el-button :loading="loadSaveConcept" @click="saveNewConceptos"
                    class="btn btn-primary">Guardar</el-button>
            </span> -->
        </el-dialog>
        <el-dialog :title="Edittitle" :visible="dialogEdittitle" width="25%" @close="closeEdit">
            <div>
                <div v-if="modoEdicion == 'planes'" class="row col-md-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <label class="control-label">Tipo de plan / Cantidad de Mb
                        </label>
                        <input class="form-control text-center" type="text" v-model="form.mbEdit"
                            placeholder="Ingrese el numero de Mb" size="small" />
                    </div>
                    <!-- <div class="col-md-6">
                        <label>Precio del Plan </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.precioPlanEdit"
                            v-on:keydown="validateNumber"
                            placeholder="Ingrese precio del plan a crear"
                            size="small"
                        />
                    </div> -->
                </div>
                <div v-else class="row col-md-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <label class="control-label">Descripcion del concepto
                        </label>
                        <input class="form-control text-center" type="text" v-model="form.descConceptEdit"
                            placeholder="Ingrese descripcion del concepto" size="small" />
                    </div>
                    <!-- <div class="col-md-6">
                        <label>Precio del Plan </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.precioConceptoEdit"
                            v-on:keydown="validateNumber"
                            placeholder="Ingrese precio del Concepto a crear"
                            size="small"
                        />
                    </div> -->
                </div>
            </div>

            <span slot="footer">

                <el-button @click="closeEdit">Cerrar</el-button>
                <el-button :loading="saveEditloading" type="primary" @click="saveEdit()">Guardar</el-button>
            </span>
        </el-dialog>

        <newVariacionPlanesDialog :shownewVarPlanesdialog.sync="shownewVarPlanesdialog" :planes.sync="planes"
            @callBrotherMethod="getRecords">
        </newVariacionPlanesDialog>
        <newVariacionConceptosDialog :shownewVarConceptdialog.sync="shownewVarConceptdialog" :conceptos.sync="conceptos"
            @callBrotherMethod="getRecords">
        </newVariacionConceptosDialog>

        <EditVarPlan :showEditPlanVar.sync="showEditPlanVar" :formvarPlan.sync="formvarPlan" :planPrin.sync="planPrin"
            @actualizarData="getRecords">
        </EditVarPlan>

        <EditVarConcept :showEditconceptVar.sync="showEditconceptVar" :formvarConcept.sync="formvarConcept"
            :conceptPrin.sync="conceptPrin" @actualizarData="getRecords">
        </EditVarConcept>
    </div>
</template>
<script>
const newVariacionPlanesDialog = () =>
    import(/* webpackChunkName:"js/newVarPlanes"*/ "./newVarPlanes.vue");
const newVariacionConceptosDialog = () =>
    import(/* webpackChunkName:"js/newVarConceptos"*/ "./newVarConceptos.vue");
const EditVarPlan = () =>
    import(/*webpackChunkName:"js/editVarPlan"*/ "./editVarPlan.vue");
const EditVarConcept = () =>
    import(/*webpackChunkName:"js/editVarConcept"*/ "./editVarConcept.vue");
export default {
    components: {
        newVariacionPlanesDialog,
        newVariacionConceptosDialog,
        EditVarPlan,
        EditVarConcept
    },
    data() {
        return {
            resource: "/internet/planes",
            loading: false,
            planes: [],
            conceptos: [],
            variacionPlan: [],
            variacionconceptos: [],
            form: {
                idEdit: null
            },
            dialogPlan: false,
            dialogConcepto: false,
            loadsavePlan: false,
            loadSaveConcept: false,
            dialogEdittitle: false,
            Edittitle: "",
            modoEdicion: "",
            saveEditloading: false,
            shownewVarPlanesdialog: false,
            shownewVarConceptdialog: false,
            showEditPlanVar: false,
            showEditconceptVar: false,
            formvarPlan: {},
            formvarConcept: {},
            planPrin: {},
            conceptPrin: {},

            // Paginación
            planesPage: 1,
            conceptosPage: 1,
            variacionPlanPage: 1,
            variacionConceptosPage: 1,
            rowsPerPage: 10
        };
    },
    computed: {
        paginatedPlanes() {
            const start = (this.planesPage - 1) * this.rowsPerPage;
            return this.planes.slice(start, start + this.rowsPerPage);
        },
        paginatedConceptos() {
            const start = (this.conceptosPage - 1) * this.rowsPerPage;
            return this.conceptos.slice(start, start + this.rowsPerPage);
        },
        paginatedVariacionPlan() {
            const start = (this.variacionPlanPage - 1) * this.rowsPerPage;
            return this.variacionPlan.slice(start, start + this.rowsPerPage);
        },
        paginatedVariacionConceptos() {
            const start = (this.variacionConceptosPage - 1) * this.rowsPerPage;
            return this.variacionconceptos.slice(start, start + this.rowsPerPage);
        }
    },
    async created() {
        // this.getColumns();
        this.getRecords();
    },
    methods: {
        closeEdit() {
            this.dialogEdittitle = false;
        },

        validateNumber(evt) {
            if (evt.keyCode >= 65 && evt.keyCode <= 90) {
                evt.preventDefault();
            }
        },
        clickCreate(it) {
            console.log(it);
        },
        async getRecords() {
            try {
                const response = await axios.get(
                    `${this.resource}/getAllRecords`
                );
                const { status, data } = response;

                if (status == 200) {
                    this.conceptos = data.concets;
                    this.planes = data.plan;
                    this.variacionPlan = data.planVariacion;
                    this.variacionconceptos = data.planConcepto;
                    console.log(data.planConcepto);
                }
            } catch (error) {
                console.log(error);
            }
        },
        newPlan() {
            this.form = {
                idEdit: null
            };
            this.dialogPlan = true;
            //abri modal para nuevo plan y pasar el siguiente codigo para que guade los datops necesarios para el nuevo plan
        },
        newConcept() {
            this.form = {
                idEdit: null
            };
            this.dialogConcepto = true;
        },
        async desactive(id, tabla) {
            this.loadsavePlan = true;
            try {
                const response = await axios.post(
                    `${this.resource}/desactivePlanConcepts`,
                    {
                        id,
                        tabla
                    }
                );
                const { status, data } = response;

                if (status == 200) {
                    this.$toast.success(`${tabla} Modificado Correctamente`);
                    this.getRecords();
                }
            } catch (error) {
                if (error.request.status == 400) {
                    this.$toast.error(error.response.data.error);
                } else {
                    console.log(error);
                }
            } finally {
                this.loadsavePlan = false;
            }
        },
        async saveNewPlan() {
            this.loadsavePlan = true;
            try {
                const response = await axios.post(
                    `${this.resource}/createPlan`,
                    {
                        mb: this.form.mb,
                        precio: this.form.precioPlan
                    }
                );
                const { status, data } = response;

                if (status == 200) {
                    this.$toast.success("Plan guardado Correctamente");
                    this.close("plan");
                    this.getRecords();
                }
            } catch (error) {
                if (error.request.status == 400) {
                    this.$toast.error(error.response.data.error);
                } else {
                    console.log(error);
                }
            } finally {
                this.loadsavePlan = false;
            }
        },
        async saveNewConceptos() {
            this.loadSaveConcept = true;
            try {
                const response = await axios.post(
                    `${this.resource}/createConcepto`,
                    {
                        desc: this.form.descConcept,
                        precio: this.form.precioConcepto
                    }
                );
                const { status, data } = response;

                if (status == 200) {
                    this.$toast.success("Plan guardado Correctamente");
                    this.close("concepto");
                    this.getRecords();
                }
            } catch (error) {
                if (error.request.status == 400) {
                    this.$toast.error(error.response.data.error);
                } else {
                    console.log(error);
                }
            } finally {
                this.loadSaveConcept = false;
            }
        },
        close(cat) {
            if (cat == "plan") {
                this.dialogPlan = false;
            } else if (cat == "concepto") {
                this.dialogConcepto = false;
            }
        },
        async Edititem(plan, id) {
            try {
                const response = await axios.post(
                    `${this.resource}/editarPlanesConcepts`,
                    {
                        plan,
                        id
                    }
                );
                const { status, data } = response;

                if (status == 200) {
                    if (plan == "planes") {
                        this.form.mbEdit = data.capacity;
                        this.form.precioPlanEdit = data.default_price;
                        this.form.idEdit = data.id;
                    } else {
                        this.form.descConceptEdit = data.description;
                        this.form.precioConceptoEdit = data.default_price;
                        this.form.idEdit = data.id;
                    }

                    this.modoEdicion = plan;
                    this.Edittitle = plan.toUpperCase();
                    this.dialogEdittitle = true;
                }
            } catch (error) { }
        },
        async saveEdit() {
            this.saveEditloading = true;

            try {
                const response = await axios.post(
                    `${this.resource}/saveEditarPlanesConcepts`,
                    {
                        id: this.form.idEdit,
                        modo: this.modoEdicion,
                        mbEdit: this.form.mbEdit,
                        precioPlanEdit: this.form.precioPlanEdit,
                        descConceptEdit: this.form.descConceptEdit,
                        precioConceptoEdit: this.form.precioConceptoEdit
                    }
                );
                this.getRecords();
                this.form.idEdit = null;
                this.modoEdicion = null;
                this.form.mbEdit = null;
                this.form.precioPlanEdit = null;
                this.form.descConceptEdit = null;
                this.form.precioConceptoEdi = null;
            } catch (error) {
                console.log(error);
            } finally {
                this.saveEditloading = false;
                this.dialogEdittitle = false;
            }
        },
        newPlanVar() {
            this.shownewVarPlanesdialog = true;
        },
        newConceptVar() {
            this.shownewVarConceptdialog = true;
        },
        async EditVar(tipo, id) {
            try {
                const response = await axios.post(
                    `${this.resource}/searchEditVar`,
                    {
                        tipo,
                        id
                    }
                );
                const { status, data } = response;
                if (status == 200) {
                    if (tipo == "planes") {
                        this.formvarPlan = response.data;
                        this.planPrin = [
                            ...this.variacionPlan.filter(
                                item =>
                                    item.variation_plan_id ==
                                    this.formvarPlan.plan_id
                            )
                        ];
                        this.planPrin = this.planPrin[0];

                        this.showEditPlanVar = true;
                    } else {
                        let varconcepts = this.variacionconceptos;
                        this.formvarConcept = data.planConcept;
                        this.conceptPrin = [
                            ...varconcepts.filter(
                                item =>
                                    item.concept_variation_id ==
                                    this.formvarConcept.id
                            )
                        ];
                        this.conceptPrin = this.conceptPrin[0];

                        this.showEditconceptVar = true;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        async desactiveVar(tipo, id) {
            try {
                const response = await axios.post(
                    `${this.resource}/changestatusVar`,
                    {
                        tipo,
                        id
                    }
                );
                this.getRecords();
            } catch (error) {
                console.log(error);
            }
        }
    }
};
</script>
