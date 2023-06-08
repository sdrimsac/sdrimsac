<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Listado de planes</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Internet</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Planes / Conceptos</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0" v-loading="loading">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="col-md-5 col-12 card m-2">
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">Lista de Planes</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="
                    btn btn-outline-primary btn-icon btn-icon-start
                    w-100 w-md-auto
                  "
                                    @click="newPlan()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </div>
                        </div>
                        <div class="row table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <!-- <th>Precio</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in planes"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ record.capacity }} Mb</td>
                                        <!-- <td>{{ record.default_price }}</td> -->
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="
                                                        Edititem(
                                                            'planes',
                                                            record.id
                                                        )
                                                    "
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="
                                                        desactive(
                                                            record.id,
                                                            'planes'
                                                        )
                                                    "
                                                    size="mini"
                                                    :type="
                                                        record.active
                                                            ? 'danger'
                                                            : 'success'
                                                    "
                                                    >{{
                                                        record.active
                                                            ? "Desactivar"
                                                            : "Activar"
                                                    }}</el-button
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-12 card m-2">
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">Lista de Conceptos</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="
                    btn btn-outline-primary btn-icon btn-icon-start
                    w-100 w-md-auto
                  "
                                    @click="newConcept()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </div>
                        </div>
                        <div class="row table-responsive">
                            <table
                                class="table table table-striped table-hover"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <!-- <th>Precio</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in conceptos"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ record.description }}</td>
                                        <!-- <td>{{ record.default_price }}</td> -->
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="
                                                        Edititem(
                                                            'conceptos',
                                                            record.id
                                                        )
                                                    "
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="
                                                        desactive(
                                                            record.id,
                                                            'conceptos'
                                                        )
                                                    "
                                                    size="mini"
                                                    :type="
                                                        record.active
                                                            ? 'danger'
                                                            : 'success'
                                                    "
                                                    >{{
                                                        record.active
                                                            ? "Desactivar"
                                                            : "Activar"
                                                    }}</el-button
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="col-md-5 col-12 card m-2">
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">
                            Lista de Variacion de Planes
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="
                    btn btn-outline-primary btn-icon btn-icon-start
                    w-100 w-md-auto
                  "
                                    @click="newPlanVar()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table table table-striped table-hover"
                                    style="width: 100%; white-space: nowrap"
                                >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Plan Principal</th>
                                            <th>Descripción Variacion</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(record,
                                            idx) in variacionPlan"
                                            :key="idx"
                                        >
                                            <td>{{ idx + 1 }}</td>
                                            <td>
                                                {{ record.plan_capacity }}Mb
                                            </td>
                                            <td>
                                                {{
                                                    record.plan_variation_description
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    record.plan_variation_price
                                                }}
                                            </td>
                                            <td>
                                                <div
                                                    class="d-flex justify-content-end"
                                                >
                                                    <el-button
                                                        size="mini"
                                                        type="primary"
                                                        @click="
                                                            EditVar(
                                                                'planes',
                                                                record.plan_variation_id
                                                            )
                                                        "
                                                        >Editar</el-button
                                                    >
                                                    <el-button
                                                        @click="
                                                            desactiveVar(
                                                                'planes',
                                                                record.plan_variation_id
                                                            )
                                                        "
                                                        size="mini"
                                                        :type="
                                                            record.plan_variation_active
                                                                ? 'danger'
                                                                : 'success'
                                                        "
                                                        >{{
                                                            record.plan_variation_active
                                                                ? "Desactivar"
                                                                : "Activar"
                                                        }}</el-button
                                                    >
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card  -->
                <div class="col-md-5 col-12 card m-2">
                    <div class="card-header bg-primary">
                        <h6 class="my-0 text-white">
                            Lista de Variacion de Conceptos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="
                    btn btn-outline-primary btn-icon btn-icon-start
                    w-100 w-md-auto
                  "
                                    @click="newConceptVar()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table
                                class="table table table-striped table-hover"
                                style="width: 100%; white-space: nowrap"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plan Principal</th>
                                        <th>Descripción Variacion</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record,
                                        idx) in variacionconceptos"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>
                                            {{ record.concept_description }}
                                        </td>
                                        <td>
                                            {{
                                                record.concept_variation_description
                                            }}
                                        </td>
                                        <td>
                                            {{ record.concept_variation_price }}
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="primary"
                                                    @click="
                                                        EditVar(
                                                            'conceptos',
                                                            record.concept_variation_id
                                                        )
                                                    "
                                                    >Editar</el-button
                                                >
                                                <el-button
                                                    @click="
                                                        desactiveVar(
                                                            'conceptos',
                                                            record.concept_variation_id
                                                        )
                                                    "
                                                    size="mini"
                                                    :type="
                                                        record.concept_variation_active
                                                            ? 'danger'
                                                            : 'success'
                                                    "
                                                    >{{
                                                        record.concept_variation_active
                                                            ? "Desactivar"
                                                            : "Activar"
                                                    }}</el-button
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card  -->
            </div>
        </div>
        <el-dialog
            :visible="dialogPlan"
            append-to-body
            @close="close('plan')"
            width="40%"
            title="Nuevo Plan "
        >
            <div>
                <div class="row col-md-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <label class="control-label"
                            >Tipo de plan / Cantidad de Mb
                        </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.mb"
                            placeholder="Ingrese el numero de Mb"
                            size="small"
                        />
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
            <span slot="footer">
                <el-button @click="close('plan')">Cerrar</el-button>
                <el-button
                    :loading="loadsavePlan"
                    @click="saveNewPlan"
                    class="btn btn-primary"
                    >Guardar</el-button
                >
            </span>
        </el-dialog>
        <el-dialog
            :visible="dialogConcepto"
            append-to-body
            @close="close('concepto')"
            width="40%"
            title="Nuevo Concepto  "
        >
            <div>
                <div class="row col-md-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <label class="control-label"
                            >Descripcion del concepto
                        </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.descConcept"
                            placeholder="Ingrese descripcion del concepto"
                            size="small"
                        />
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
            <span slot="footer">
                <el-button @click="close('concepto')">Cerrar</el-button>
                <el-button
                    :loading="loadSaveConcept"
                    @click="saveNewConceptos"
                    class="btn btn-primary"
                    >Guardar</el-button
                >
            </span>
        </el-dialog>
        <el-dialog
            :title="Edittitle"
            :visible="dialogEdittitle"
            width="25%"
            @close="closeEdit"
        >
            <div>
                <div
                    v-if="modoEdicion == 'planes'"
                    class="row col-md-12"
                    style="margin-top: 20px"
                >
                    <div class="col-md-12">
                        <label class="control-label"
                            >Tipo de plan / Cantidad de Mb
                        </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.mbEdit"
                            placeholder="Ingrese el numero de Mb"
                            size="small"
                        />
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
                        <label class="control-label"
                            >Descripcion del concepto
                        </label>
                        <input
                            class="form-control text-center"
                            type="text"
                            v-model="form.descConceptEdit"
                            placeholder="Ingrese descripcion del concepto"
                            size="small"
                        />
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
                <el-button
                    :loading="saveEditloading"
                    type="primary"
                    @click="saveEdit()"
                    >Guardar</el-button
                >
            </span>
        </el-dialog>

        <newVariacionPlanesDialog
            :shownewVarPlanesdialog.sync="shownewVarPlanesdialog"
            :planes.sync="planes"
            @callBrotherMethod="getRecords"
        >
        </newVariacionPlanesDialog>
        <newVariacionConceptosDialog
            :shownewVarConceptdialog.sync="shownewVarConceptdialog"
            :conceptos.sync="conceptos"
            @callBrotherMethod="getRecords"
        >
        </newVariacionConceptosDialog>

        <EditVarPlan
            :showEditPlanVar.sync="showEditPlanVar"
            :formvarPlan.sync="formvarPlan"
            :planPrin.sync="planPrin"
            @actualizarData="getRecords"
        >
        </EditVarPlan>

        <EditVarConcept
            :showEditconceptVar.sync="showEditconceptVar"
            :formvarConcept.sync="formvarConcept"
            :conceptPrin.sync="conceptPrin"
            @actualizarData="getRecords"
        >
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
            conceptPrin: {}
        };
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
            } catch (error) {}
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
