<!-- Listado de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            Listado De Medicos
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Listado Medicos</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                   Listado Medicos
                </h4>
                <div class="card-actions white-text">
                    <a
                        href="#"
                        class="card-action card-action-toggle text-white"
                        data-card-toggle=""
                    ></a>
                    <a
                        href="#"
                        class="card-action card-action-dismiss text-white"
                        data-card-dismiss=""
                    ></a>
                </div>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="primary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    Nuevo Medico
                </el-button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">NUMERO</th>
                                <th class="text-white">NOMBRES Y APELLIDOS</th>
                                <th class="text-white">TELEFONOS</th>
                                <th class="text-white">EMAIL</th>
                                <th class="text-white">ESPECIALIDAD</th>
                                <th class="text-end text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ row.number }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.telephone }}</td>
                                <td>{{ row.email }}</td>
                                <td>{{ row.specialty }}</td>
                                <td class="text-end">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <span
                                            class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-delay="0"
                                            title=""
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                            >Acciones</span
                                        >
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        style=""
                                    >
                                        <a
                                            type="button"
                                            class="dropdown-item text-secondary"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <template
                                        >
                                            <a
                                                type="button"
                                                class="dropdown-item text-danger"
                                                @click.prevent="
                                                    clickDelete(row.id)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </template>
                                        <a 
                                        type="button"
                                        class="dropdown-item text-success" 
                                        @click.prevent="
                                                    clickDetails(row.id)
                                                "
                                        >
                                            <i class="fa fa-eye"></i> Detalles
                                            
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Medic-form
                :showDialog.sync="showDialog"
                :recordId="recordId"
                :specialties="specialties"
                :countries="countries"
                :departments="departments"
                :provinces="provinces"
                :districts="districts"
            ></Medic-form>
            <Medic-details
                :showDialogMedicDetails.sync="showDialogMedicDetails"
                :recordId="recordId"
            ></Medic-details>
        </div>
    </div>
</template>

<script>
import MedicForm from "./form.vue";
import MedicDetails from "./medic_details.vue";
/* import { deletable } from "../../mixins/deletable"; */
import { deletable } from "../../../../../../../resources/js/mixins/deletable";

export default {
    mixins: [deletable],
    props: ["typeUser"],
    components: {
        MedicForm,
        MedicDetails,
    },
    data() {
        return {
            title: "",
            showDialog: false,
            showDialogMedicDetails: false,
            resource: "dental/medic",
            recordId: null,
            records: [],
            specialties: [],
            countries: [],
            departments: [],
            provinces: [],
            districts: [],
            country_id: "PE",
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
            this.getTables();
        });
        this.getData();
        this.getTables();
    },
    methods: {
        getTables() {
            this.$http.get(`/${this.resource}/tables`).then(response => {
                this.specialties = response.data.specialties;
                this.countries = response.data.countries;
                this.departments = response.data.departments;
                this.provinces = response.data.provinces;
                this.districts = response.data.districts;
                console.log("ver si esta llegando las especialidades", this.specialties)
            })

        },

        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDetails(recordId = null) {
            this.recordId = recordId;
            this.showDialogMedicDetails = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
