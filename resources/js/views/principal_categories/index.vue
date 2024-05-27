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
                    <h4 class="my-0 text-white"><i class="fas fa-layer-group"></i> Listado de {{ title }}</h4>

                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-end">
                        <!-- Contact Button Start -->
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                        <!-- Contact Button End -->
                    </div>
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Nombre</th>
                            <th class="text-end">Identificador</th>
                            <th class="text-end">Expandir detalle reporte</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr
                            slot-scope="{ index, row }"
                        >
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>
                            <td class="text-end">
                                {{ row.identifier }}
                            </td>

                            <td class="text-end">
                                <el-switch
                                    v-model="row.is_expanded"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949"
                                    active-text="Si"
                                    inactive-text="No"
                                    @change="changeExpanded(row)"
                                >
                                </el-switch>
                            </td>
                        
                            <td class="text-end">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <template v-if="row.active">
                                    <a type="button" class="dropdown-item text-secondary" @click.prevent=" clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                                    </a>
                                    </template>
                                    <template
                                    v-if="
                                        typeUser === 'admin' ||
                                            typeUser === 'superadmin'">
                                    <a type="button" class="dropdown-item text-danger" @click.prevent=" clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                    </a>
                                </template>
                                </div>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
            <principal-category-form
                :record-id="recordId"
                :showDialog.sync="showDialog"
            ></principal-category-form>
    
        </div>
    </div>
</template>

<script>
const PrincipalCategoryForm = () => import("./form.vue");

import DataTable from "../../components/DataTablePersons.vue";
import { deletable } from "../../mixins/deletable";

export default {
    mixins: [deletable],
    props: ["type", "typeUser", "api_service_token"],
    components: { DataTable, PrincipalCategoryForm },
    data() {
        return {
            title: null,
            showDialog: false,
            showImportDialog: false,
            resource: "principal_categories",
            recordId: null,
            showDialogPrinter: false,
            showDialogCategories: false,
            showDialogItems: false,
            commercialTreatment: null
        };
    },
    created() {
        this.title = "Categorias principales";
        //    console.log(resource+`/${this.type}`)
    },
    methods: {
        changeExpanded(row) {
            this.$http(
                `/${this.resource}/expanded/${row.id}/${row.is_expanded}`
            ).then(() => this.$eventHub.$emit("reloadData"));
        },
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
