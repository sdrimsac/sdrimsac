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
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
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

                        <!-- Dropdown Button Start -->
                        <div class="ms-1">
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-icon btn-icon-only"
                                data-bs-offset="0,3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-submenu
                            >
                                <i data-cs-icon="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="clickPrint()"
                                >
                                    <i class="icofont-printer"></i> Imprimir
                                </button>
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="clickImport('excel')"
                                >
                                    <i class="icofont-upload-alt"></i> Importar
                                </button>
                            </div>
                        </div>
                        <!-- Dropdown Button End -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Descripción</th>
                            <th class="text-end">Afectación</th>
                            <th class="text-end">Categorias</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr
                            slot-scope="{ index, row }"
                            :class="{ disable_color: !row.active }"
                        >
                            <td>{{ index }}</td>
                            <td>{{ row.description }}</td>
                            <td class="text-end">{{ row.is_amount ? 'Monto' : 'Porcentaje'  }}</td>
                          
                            <td class="text-end">
                                <el-button
                                size="mini"
                                @click="clickOpenCategories(row)"
                                >
                                Modificar
                                </el-button>

                            </td>
                            <td class="text-end">
                                <template v-if="row.active">
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickCreate(row.id)"
                                    >
                                        Editar
                                    </button>
                                </template>

                                <template
                                    v-if="
                                        typeUser === 'admin' ||
                                            typeUser === 'superadmin'
                                    "
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        Eliminar
                                    </button>

                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDisable(row.id)"
                                        v-if="row.enabled"
                                    >
                                        Inhabilitar
                                    </button>
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-primary"
                                        @click.prevent="clickEnable(row.id)"
                                        v-else
                                    >
                                        Habilitar
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
            <commercial-treatment-form
                :record-id="recordId"
                :showDialog.sync="showDialog"
            ></commercial-treatment-form>
            <categories
            :showDialog.sync="showDialogCategories"
            :commercialTreatment="commercialTreatment"
            ></categories>
        </div>
    </div>
</template>

<script>
const CommercialTreatmentForm = () => import("./form.vue");
const Categories = () => import("./categories.vue");
import DataTable from "../../components/DataTablePersons.vue";
import { deletable } from "../../mixins/deletable";

export default {
    mixins: [deletable],
    props: ["type", "typeUser", "api_service_token"],
    components: { DataTable, CommercialTreatmentForm,Categories },
    data() {
        return {
            title: null,
            showDialog: false,
            showImportDialog: false,
            resource: "commercial_treatment",
            recordId: null,
            showDialogPrinter: false,
            showDialogCategories: false,
            commercialTreatment: null
        };
    },
    created() {
        this.title = "Tratamientos comerciales";
        //    console.log(resource+`/${this.type}`)
    },
    methods: {
        clickOpenCategories(row){
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
