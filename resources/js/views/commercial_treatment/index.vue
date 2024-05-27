<!-- Listado de Tratamientos comerciales -->
<template>
<div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h6>
                        <span>{{ title }}</span>
                    </h6>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="text-muted">{{ title }}</span>
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-handshake"></i> <!-- Icono de tratamiento comercial -->
                    Listado de {{ title }}
                </h4>
            </div>

            <div class="data-table-visible-columns">
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickCreate()">
                                <i class="fas fa-handshake fa-lg"></i>
                                <i class="icofont-plus-circle"></i>
                                Nuevo Tratamiento Comercial
                    </el-button>
            </div> 
            <div class="card-body">
                
                <data-table :resource="resource">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white text-center">Descripción</th>
                        <th class="text-white text-center">Afectación</th>
                        <th class="text-white text-center">Categorias</th>
                        <!-- <th class="text-end">Productos</th> -->
                        <th class="text-end text-white">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }" :class="{ disable_color: !row.active }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.description }}</td>
                        <td class="text-center">
                            {{ row.is_amount ? "Monto" : "Porcentaje" }}
                        </td>

                        <td class="text-center">
                            <el-button size="mini" @click="clickOpenCategories(row)" type="primary" icon="fas fa-edit">
                                Modificar
                            </el-button>
                        </td>
                     
                        <!-- <td class="text-end">
                                <el-button
                                    size="mini"
                                    @click="clickOpenItems(row)"
                                >
                                    Modificar
                                </el-button>
                            </td> -->
                            
                            
                        <td class="text-end">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                        <a type="button" class="dropdown-item text-secondary" @click.prevent=" clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a type="button" class="dropdown-item text-danger" @click.prevent="
                                                            clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                        <!-- <a type="button" class="dropdown-item text-warning" @click.prevent="
                                                            clickDisable(row.id)" v-if="row.active">Inhabilitar
                                        </a>
                                        <a type="button" class="dropdown-item text-success" @click.prevent="
                                                            clickEnable(row.id)" v-else>Habilitar
                                        </a> -->
                                    </div>
                        </td>
                    </tr>
                </data-table>
            </div>
        </div>
        <commercial-treatment-form :record-id="recordId" :showDialog.sync="showDialog"></commercial-treatment-form>
        <categories :showDialog.sync="showDialogCategories" :commercialTreatment="commercialTreatment"></categories>
        <items :showDialog.sync="showDialogItems" :commercialTreatment="commercialTreatment"></items>
    </div>
</div>
</template>

<script>
const CommercialTreatmentForm = () => import("./form.vue");
const Categories = () => import("./categories.vue");
const Items = () => import("./items.vue");
import DataTable from "../../components/DataTablePersons.vue";
import {
    deletable
} from "../../mixins/deletable";

export default {
    mixins: [deletable],
    props: ["type", "typeUser", "api_service_token"],
    components: {
        DataTable,
        CommercialTreatmentForm,
        Categories,
        Items
    },
    data() {
        return {
            title: null,
            showDialog: false,
            showImportDialog: false,
            resource: "commercial_treatment",
            recordId: null,
            showDialogPrinter: false,
            showDialogCategories: false,
            showDialogItems: false,
            commercialTreatment: null
        };
    },
    created() {
        this.title = "Tratamientos comerciales";
        //    console.log(resource+`/${this.type}`)
    },
    methods: {
        clickOpenItems(row) {
            this.commercialTreatment = row;
            this.showDialogItems = true;
        },
        clickOpenCategories(row) {
            this.commercialTreatment = row;
            this.showDialogCategories = true;
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickImport() {
            this.showImportDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickDisable(id) {
            this.disable(`/${this.resource}/enabled/${0}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickPrint() {
            this.showDialogPrinter = true;
        },
        clickEnable(id) {
            this.enable(`/${this.resource}/enabled/${1}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
