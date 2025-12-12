<!-- Listado de Clientes Proveedores  en Admin-->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 8px;">
                    <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1rem; font-weight: bold;">
                        <i class="fas fa-coins" style="font-size: 1rem; margin-right: 0.5rem;"></i>
                        Módulo de {{ title }}
                    </h4>
                </div>

                <div class="data-table-visible-columns d-flex justify-content-start align-items-center mb-3"
                    style="margin-left: 1rem;">
                    <el-button class="btn_guardarsmall" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fas fa-plus"></i>
                        <span style="color: #fff;  font-weight: bold;">Nuevo</span>
                    </el-button>

                    <el-button class="btn_guardarsmall" href="javascript:void(0)" @click.prevent="clickZones()">
                        <i class="icofont-location-pin"></i>
                        <span style="color: #fff; font-weight: bold;">Zona</span>
                    </el-button>

                    <el-button class="btn_guardarsmall" href="javascript:void(0)" @click.prevent="clickImport()">
                        <i class="fa fa-upload"></i>
                        <span style="color: #fff; font-weight: bold;">Importar</span>
                    </el-button>
                </div>
                <div class="card-body">

                    <data-table :resource="resource + `/${this.type}`" :type-user="typeUser">
                        <tr slot="heading" class="bg-primary" style="border-radius: 12px;">
                            <!-- <th class="text-white text-center">Imagen</th> -->
                            <th class="text-white">#</th>
                            <th class="text-white text-left">Creado por Usuario</th>
                            <th class="text-white">{{ title }}</th>
                            <th class="text-center text-white" v-if="!configuration.mod_renta">Zona</th>
                            <th class="text-center text-white">Datos</th>
                            <th class="text-center text-white" v-if="configuration.mod_renta">Procedencia </th>
                            <th class="text-center text-white" v-if="configuration.mod_renta">Familiar</th>


                            <th class="text-center text-white">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }" :class="{ 'bg-secondary-darker': !row.enabled }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                            <!-- <td class="text-center" :class="!row.enabled ? 'td-amber' : ''">
                                <img v-if="row.image_url" :src="row.image_url" alt="avatar" style="width:40px; height:40px; object-fit:cover; border-radius:50%; border:1px solid #ccc;" />
                                <i v-else class="fas fa-user-circle" style="font-size: 2rem; color: #ccc;"></i>
                            </td> -->
                            <td :class="!row.enabled ? 'td-amber' : ''">{{ index }}</td>
                            <td class="text-left" :class="!row.enabled ? 'td-amber' : ''">
                                <span v-if="row.user_name" style="font-weight: bold; font-size: 0.8rem;">
                                    USUARIO: {{ row.user_name }}
                                </span>
                                <br v-if="row.user_name && row.updated_at">
                                <span v-if="row.updated_at" style="font-weight: bold; font-size: 0.8rem;">
                                    FECHA: {{ row.updated_at.split(' ')[0] }} <br>
                                    HORA : {{ row.updated_at.split(' ')[1] }}
                                </span>
                            </td>
                            <td style="font-size: 1.1rem;">
                                <span style="font-weight: bold;">{{ row.number }}</span> <br>
                                <span style="font-size: 1.2rem; color: #000;">{{ row.name }}</span><br>
                                <span style="font-size: 1rem; color: #888;">{{ row.alias }}</span>
                            </td>


                            <td class="text-center" v-if="!configuration.mod_renta" :class="!row.enabled ? 'td-amber' : ''">{{ row.zone_description }}</td>
                            <td class="text-center" :class="!row.enabled ? 'td-amber' : ''">
                                <span v-if="row.occupation">
                                    Ocupación: {{ row.occupation }}<br>
                                </span>
                                <span v-if="row.telephone">
                                    Teléfono: {{ row.telephone }}
                                </span>
                            </td>

                            <td class="text-center" v-if="configuration.mod_renta" :class="!row.enabled ? 'td-amber' : ''">{{ row.ref_origin }}</td>
                            <td class="text-center" v-if="configuration.mod_renta" :class="!row.enabled ? 'td-amber' : ''">
                                {{ row.parient_description }} - {{ row.name_family }} <br>
                                {{ row.telephone_family }}
                            </td>

                            <td class="text-center align-middle" :class="!row.enabled ? 'td-amber' : ''">
                                <div class="d-flex justify-content-center align-items-center" style="gap: 0.5rem;">
                                    <el-tooltip content="Editar" placement="top">
                                        <button
                                            v-if="row.enabled"
                                            class="btn btn-sm rounded-circle"
                                            style="color: #fff; background: #007bff; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0; border-radius: 50%;"
                                            @click.prevent="clickCreate(row.id)"
                                            :disabled="!row.enabled"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </el-tooltip>
                                    <!-- <el-tooltip content="Eliminar" placement="top"
                                        v-if="typeUser === 'admin' || typeUser === 'superadmin'">
                                        <button class="btn btn-sm rounded-circle"
                                            style="color: #fff; background: #dc3545; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0; border-radius: 50%;"
                                            @click.prevent="clickDelete(row.id)"
                                            :disabled="!row.enabled"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </el-tooltip> -->
                                    <el-tooltip content="Inhabilitar" placement="top"
                                        v-if="(typeUser === 'admin' || typeUser === 'superadmin') && row.enabled">
                                        <button class="btn btn-sm rounded-circle"
                                            style="color: #fff; background: #ffc107; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0; border-radius: 50%;"
                                            @click.prevent="clickDisable(row.id)"
                                            :disabled="!row.enabled"
                                        >
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip content="Habilitar" placement="top"
                                        v-if="(typeUser === 'admin' || typeUser === 'superadmin') && !row.enabled">
                                        <button class="btn btn-sm rounded-circle"
                                            style="color: #fff; background: #28a745; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0; border-radius: 50%;"
                                            @click.prevent="clickEnable(row.id)"
                                        >
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </el-tooltip>
                                </div>
                            </td>
                           
                        </tr>
                    </data-table>
                </div>
                <Printer :showDialogPrinter.sync="showDialogPrinter"></Printer>
                <persons-form :typeUser="typeUser" :showDialog.sync="showDialog" :type="type" :recordId="recordId"
                    :api_service_token="api_service_token" :isArca="isArca"></persons-form>

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
