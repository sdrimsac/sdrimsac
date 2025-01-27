<!-- Módulo de Clientes 
    Módulo de Proveedores -->
<template>
<div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
                <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
                    <i class="fas fa-coins" style="font-size: 2rem; margin-right: 0.5rem;"></i>
                    Módulo de {{ title }}
                </h4>
            </div>

            <div class="data-table-visible-columns">
                <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickCreate()">
                    <i class="fas fa-users"></i>
                    <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Nuevo</span>
                </el-button>
                <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickZones()">
                    <i class="icofont-location-pin"></i>
                    <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Zona</span>
                </el-button>
                <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickImport()">
                    <i class="fa fa-upload"></i>
                    <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Importar</span>
                </el-button>
            </div>
            <div class="card-body">

                <data-table :resource="resource + `/${this.type}`">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Nombre</th>
                        <th class="text-white text-center">Creado por Usuario</th>
                        <th class="text-center text-white">Alias</th>
                        <th class="text-center text-white">DNI/RUC</th>
                        <th class="text-center text-white">Zona</th>
                        <th class="text-center text-white">Telefonos</th>

                        <th class="text-center text-white" v-if="configuration.mod_renta">Procedencia </th>
                        <th class="text-center text-white" v-if="configuration.mod_renta">Nombre de Familiar</th>
                        <th class="text-center text-white" v-if="configuration.mod_renta">Telefono  de Familiar</th>
                        <th class="text-center text-white" v-if="configuration.mod_renta">Ocupacion</th>
                        <th class="text-end text-white">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }" :class="{ 'bg-primary': !row.enabled }">
                        <td>{{ index }}</td>
                        <td>{{ row.name }}</td>
                        <td class="text-center">{{ row.user_name }} <br> {{ row.updated_at }}
                        </td>
                        <td class="text-center">{{ row.alias }}</td>
                        <td class="text-center">{{ row.number }}</td>
                        <td class="text-center">{{ row.zone_description }}</td>
                        <td class="text-center">{{ row.telephone }}</td>

                        <td class="text-center" v-if="configuration.mod_renta">{{ row.ref_origin }}</td>
                        <td class="text-center" v-if="configuration.mod_renta">{{ row.parient_description }} - {{ row.name_family }}</td>
                        <td class="text-center" v-if="configuration.mod_renta">{{ row.telephone_family }}</td>
                        <td class="text-center" v-if="configuration.mod_renta">{{ row.occupation }}</td>
                        <td class="text-end">

                            <!-- **** -->
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <template v-if="row.enabled">
                                    <a type="button" class="dropdown-item text-secondary" @click.prevent=" clickCreate(row.id)">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                </template>

                                <template v-if="typeUser === 'admin' || typeUser === 'superadmin'">
                                    <a type="button" class="dropdown-item text-danger" @click.prevent="
                                            clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                    </a>
                                </template>

                                <a type="button" class="dropdown-item text-warning" @click.prevent="clickDisable(row.id)" v-if="row.active">
                                    Inhabilitar
                                </a>
                                <a type="button" class="dropdown-item text-success" @click.prevent="clickEnable(row.id)" v-else>
                                    Habilitar
                                </a>
                            </div>

                            <!-- **** -->
                            <!-- <template v-if="row.enabled">
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
                                </template> -->
                        </td>
                    </tr>
                </data-table>
            </div>
            <Printer :showDialogPrinter.sync="showDialogPrinter"></Printer>
            <persons-form :typeUser="typeUser" :showDialog.sync="showDialog" :type="type" :recordId="recordId" :api_service_token="api_service_token" :isArca="isArca"></persons-form>

            <persons-import :showDialog.sync="showImportDialog" :type="type"></persons-import>
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
import {
    deletable
} from "../../mixins/deletable";
export default {
    mixins: [deletable],
    props: ["typeUser", "user", "type", "api_service_token", "isArca"],
    components: {
        PersonsForm,
        PersonsImport,
        DataTable,
        Printer,
        ClientZones
    },
    data() {
        return {
            showDialogZones: false,
            title: null,
            showDialog: false,
            showImportDialog: false,
            resource: "persons",
            recordId: null,
            showDialogPrinter: false,
            configuration: {},
        };
    },
    async created() {
        this.title = this.type === "customers" ? "Clientes" : "Proveedores";
        //    console.log(resource+`/${this.type}`)

        await this.$http.get(`/${this.resource}/tables`).then(response => {
            
            this.configuration = response.data.configuration;
            
            console.log(
                "🚀 ~ file: form.vue ~ line 153 ~ created ~ parent",
                this.parent
            );
        });
        
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
