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
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            style="margin-right: 5px;"
                            @click.prevent="clickZones()"
                        >
                            <i class="icofont-location-pin"></i>
                            <span>Zonas</span>
                        </button>
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
                    <!-- <div class="col-sm-6">
                  <div class="bookmark">
                  <ul>
                    <li  v-if="typeUser != 'integrator'">
                          <el-tooltip class="item" effect="dark" content="Imprimir" placement="bottom-end">
                            <a  href="javascript:void(0)" @click.prevent="clickPrint()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                               <i data-feather="printer"></i>
                            </a>
                          </el-tooltip>
                    </li>
                    <li  v-if="typeUser != 'integrator'">
                          <el-tooltip class="item" effect="dark" content="Importar" placement="bottom-end">
                            <a  href="javascript:void(0)" @click.prevent="clickImport()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                <i data-feather="share"></i>
                            </a>
                          </el-tooltip>
                    </li>
                      <li  v-if="typeUser != 'integrator'">
                          <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                            <a  href="javascript:void(0)" @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                <i data-feather="plus-circle"></i>
                            </a>
                          </el-tooltip>
                    </li>
                </ul>
                </div>
                </div> -->
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource + `/${this.type}`">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Nombre</th>
                            <th class="text-end">Número</th>
                            <th class="text-end">Dirección</th>
                            <th class="text-end">Telefonos</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr
                            slot-scope="{ index, row }"
                            :class="{ disable_color: !row.enabled }"
                        >
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>
                            <td class="text-end">{{ row.number }}</td>
                            <td class="text-end">{{ row.address }}</td>
                            <td class="text-end">{{ row.telephone }}</td>
                            <td class="text-end">
                                <template v-if="row.enabled">
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
                <Printer :showDialogPrinter.sync="showDialogPrinter"></Printer>
                <persons-form
                :typeUser="typeUser"
                    :showDialog.sync="showDialog"
                    :type="type"
                    :recordId="recordId"
                    :api_service_token="api_service_token"
                ></persons-form>

                <persons-import
                    :showDialog.sync="showImportDialog"
                    :type="type"
                ></persons-import>
                <client-zones :showDialog.sync="showDialogZones">
                </client-zones>
            </div>
        </div>
    </div>
</template>

<script>
import PersonsForm from "./form.vue";
import PersonsImport from "./import.vue";
import Printer from "./printer.vue";
import ClientZones from "./client_zones.vue";
import DataTable from "../../components/DataTablePersons.vue";
import { deletable } from "../../mixins/deletable";
export default {
    mixins: [deletable],
    props: ["type", "typeUser", "api_service_token"],
    components: { PersonsForm, PersonsImport, DataTable, Printer, ClientZones },
    data() {
        return {
            showDialogZones: false,
            title: null,
            showDialog: false,
            showImportDialog: false,
            resource: "persons",
            recordId: null,
            showDialogPrinter: false
        };
    },
    created() {
        this.title = this.type === "customers" ? "Clientes" : "Proveedores";
        //    console.log(resource+`/${this.type}`)
    },
    methods: {
        clickZones() {
            this.showDialogZones = true;
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
