<!-- Listado de Mesas -->
 <!-- Listado de Habitaciones -->
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
                            <a href="/dashboard">{{ title }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <!-- <span class="text-muted">Marcas</span> -->
                        </li>
                    </ol>
                </div>
                <!-- <div class="col-12 col-md-6 d-flex align-items-start justify-content-end">
                    <button v-if="resource == 'caja/rooms'" type="primary" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5" @click.prevent="clickSeeInsumos">
                        <i class="icofont-plus-circle"></i>
                        <span>Insumos</span>
                    </button>
                    <button v-if="resource == 'caja/rooms'" type="primary" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5" @click.prevent="clickSeePromotions">
                        <i class="icofont-plus-circle"></i>
                        <span>Promociones</span>
                    </button>
                    <button v-if="resource == 'caja/rooms'" type="primary" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5" @click.prevent="clickSeeTypes()">
                        <i class="icofont-plus-circle"></i>
                        <span>Tipo de habitaciones</span>
                    </button>
                    <button v-if="resource == 'caja/rooms'" type="primary" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5" @click.prevent="clickSeeTowers()">
                        <i class="icofont-plus-circle"></i>
                        <span>Torres</span>
                    </button>
                    <button v-if="resource == 'caja/rooms'" type="primary" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5" @click.prevent="clickSeeFloors()">
                        <i class="icofont-plus-circle"></i>
                        <span>Pisos</span>
                    </button>
                    
                    <button type="primary" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click.prevent="clickCreate()">
                        <i class="icofont-plus-circle"></i>
                        <span>Nuevo</span>
                    </button>
                    <button v-if="
                                resource == 'caja/tables' ||
                                    resource == 'caja/rooms'
                            " type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5" @click.prevent="clickCreateMassive()">
                        <i class="icofont-plus-circle"></i>
                        <span>Crear masivamente</span>
                    </button>
                    
                </div> -->
            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <template>
                <div>
                    <div class="card-header bg-primary d-flex align-items-center">
                        <template v-if="resource == 'caja/tables'">
                            <i class="fas fa-table text-white mr-2"></i>
                        </template>
                        <template v-if="resource == 'caja/rooms'">
                            <i class="fas fa-door-open text-white mr-2"></i>
                        </template>
                        <h4 class="my-0 text-white"> {{ title }}</h4>
                    </div>
                </div>
                </template>
            <!-- <div class="card-header bg-primary">
                <h4 class="my-0 text-white">Listado de {{ title }}</h4>
            </div> -->
            <div class="data-table-visible-columns">
                <el-button v-if="resource == 'caja/rooms'" class="custom-button" @click.prevent="clickSeeInsumos">
                    <i class="fas fa-boxes"></i>
                    <span>Insumos</span>
                </el-button>
                <el-button v-if="resource == 'caja/rooms'" class="custom-button" @click.prevent="clickSeePromotions">
                    <i class="fas fa-tags"></i>
                    <span>Promociones</span>
                </el-button>
                <el-button v-if="resource == 'caja/rooms'" class="custom-button" @click.prevent="clickSeeTypes()">
                    <i class="fas fa-bed"></i>
                    <span>Tipo de habitaciones</span>
                </el-button>
                <el-button v-if="resource == 'caja/rooms'" class="custom-button" @click.prevent="clickSeeTowers()">
                    <i class="fas fa-building"></i>
                    <span>Torres</span>
                </el-button>
                <el-button v-if="resource == 'caja/rooms'" class="custom-button" @click.prevent="clickSeeFloors()">
                    <i class="fas fa-layer-group"></i>
                    <span>Pisos</span>
                </el-button>
                <!-- Contact Button Start -->
                <el-button type="primary" 
                        class="custom-button" 
                        href="javascript:void(0)"
                        @click.prevent="clickCreate()">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nuevo</span>
                </el-button>
                <el-button 
                        v-if="resource == 'caja/tables' || resource == 'caja/rooms'"
                        type="primary"
                        class="custom-button" 
                        href="javascript:void(0)"
                        @click.prevent="clickCreateMassive()">
                        <i class="fas fa-plus-circle"></i>
                        <span>Crear masivamente</span>
                </el-button>
            </div>

            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white"
                                 v-if="
                                    type != 'caja/tables' &&
                                        type != 'caja/rooms'
                                ">
                            Descripción
                        </th>
                        <th class="text-white"
                         v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                ">
                            Número
                        </th>
                        <th  class="text-white"
                        v-if="type == 'caja/rooms'">
                            Tipo
                        </th>
                        <th class="text-white"
                        v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                ">
                            Área
                        </th>
                        <th class="text-white"
                        v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                ">
                            Establecimiento
                        </th>
                        <th class="text-white"
                        v-if="type == 'caja/rooms'">
                            Torre
                        </th>
                        <th class="text-white"
                            v-if="type == 'caja/rooms'">
                            Piso
                        </th>
                        <th    class="text-white"
                        v-if="type == 'caja/areas'">
                            Impresora
                        </th>
                        <th class="text-white" v-if="type == 'caja/areas'">
                            Forzar impresión
                        </th>
                        <th class="text-white" v-if="type == 'caja/rooms'">
                            Precio
                        </th>
                        <th class="text-white" v-if="type == 'caja/rooms'">
                            Incluye
                        </th>
                        <th class="text-white text-end">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td v-if="
                                    type != 'caja/tables' &&
                                        type != 'caja/rooms'
                                ">
                            {{ row.description }}
                        </td>
                        <td v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                ">
                            {{ row.number }}
                        </td>
                        <td v-if="type == 'caja/rooms'">
                            {{ row.type }}
                        </td>
                        <td v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                ">
                            {{ row.area.description }}
                        </td>
                        <td v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                ">
                            {{ row.establishment }}
                        </td>
                        <td v-if="type == 'caja/rooms'">
                            {{ row.tower }}
                        </td>
                        <td v-if="type == 'caja/rooms'">
                            {{ row.floor }}
                        </td>
                        <td v-if="type == 'caja/areas'">
                            {{ row.printer }}
                        </td>
                        <td v-if="type == 'caja/areas'">
                            <el-switch v-if="row.printer == null" @change="updateSearchPrint(row)" v-model="row.search_print">
                            </el-switch>
                        </td>
                        <td v-if="type == 'caja/rooms'">
                            {{ row.price }}
                        </td>
                        <td v-if="type == 'caja/rooms'">
                            <template v-if="
                                        row.description != null &&
                                            row.description != ''
                                    ">
                                <el-tooltip class="item" effect="dark" :content="row.description" placement="top">
                                    <!-- icono dde ojo -->
                                    <i class="icofont-eye-alt"></i>
                                </el-tooltip>
                            </template>
                        </td>
                        <td class="text-end">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a type="button" class="dropdown-item" @click.prevent="clickCreate(row.id)"><i class="fa fa-edit"></i> Editar</a>
                                <a type="button" class="dropdown-item btn waves-effect waves-light btn-sm" :class="row.active
                                ? 'btn btn-danger btn-sm'
                                : 'btn btn-success btn-sm'
                                " @click.prevent="clickDelete(row.id, row.active)"><i class="fa fa-delete"></i>
                                    <template v-if="type == 'caja/workers-type'">
                                        <template v-if="row.active">
                                            Desactivar
                                        </template>
                                        <template v-else>
                                            Activar
                                        </template>
                                    </template>
                                    <template v-else><i class="fa fa-delete"></i>
                                        Eliminar
                                    </template>
                                </a>
                            </div>
                        </td>
                    </tr>
                </data-table>
            </div>

            <create-form :types="types" :showDialog.sync="showDialog" :areas="areas" :type="type" :configurations.sync="configurations" :recordId.sync="recordId" :statusTable="statusTable" :establishments="establishments"></create-form>

            <create-form-massive :types="types" :showDialog.sync="showDialogMassive" :areas="areas" :type="type" :configurations.sync="configurations" :recordId.sync="recordId" :statusTable="statusTable" :establishments="establishments"></create-form-massive>
            <items-rooms :showDialog.sync="showItems" :type="typeItem">
            </items-rooms>
            <promotions :showDialog.sync="showPromotions"></promotions>
            <insumos :showDialog.sync="showInsumos"></insumos>
        </div>
    </div>
</div>
</template>

    <style scoped>
    .custom-button {
        border-radius: 5px; /* Redondear el botón */
        color: white; /* Letras blancas */
        background-color: #14385f; /* Color de fondo azul (primario) */
        border: 1px solid #ffffff; /* Borde del mismo color que el fondo */
        padding: 10px 20px; /* Espaciado interno */
        transition: transform 0.2s ease, background-color 0.2s ease; /* Añadir una transición suave */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        margin: 5px;
    }

    .custom-button:hover {
        transform: scale(1.05); /* Aumenta ligeramente el tamaño al pasar el ratón */
    }

    .custom-button:active {
        transform: scale(0.95); /* Reduce ligeramente el tamaño al hacer clic */
    }
</style>

<script>
const Promotions = () => import("./promotions.vue");
const Insumos = () => import("./insumos.vue");
import CreateForm from "./form.vue";
import CreateFormMassive from "./formTableMassive.vue";
import ItemsRooms from "./items_rooms.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import {
    deletable
} from "../../../../../../../resources/js/mixins/deletable";
import queryString from "query-string";
export default {
    props: ["type", "title", "configurations"],
    mixins: [deletable],
    components: {
        DataTable,
        CreateForm,
        CreateFormMassive,
        ItemsRooms,
        Promotions,
        Insumos
    },
    data() {
        return {
            showInsumos: false,
            showItems: false,
            showDialog: false,
            showDialogMassive: false,
            resource: this.type,
            recordId: null,
            areas: [],
            statusTable: [],
            ascending: false,
            sortColumn: "",
            search: {
                column: null,
                value: null
            },
            active_column: "",
            columns: [],
            records: [],
            establishments: [],
            pagination: {},
            loading_data: false,
            disabled_next: false,
            disabled_previos: false,
            myOptions: ["op1", "op2", "op3"],
            types: [],
            typeItem: null,
            showPromotions: false
        };
    },
    created() {
        console.log(this.type);
        if (this.type == "caja/tables" || this.type == "caja/rooms") {
            this.getTables();
        }
        // this.getData();
        this.$eventHub.$on("reloadData", () => {
            this.getData();
            //   this.recordId =null
        });
    },
    methods: {
        clickSeeInsumos() {
            this.showInsumos = true;
        },
        clickSeePromotions() {
            this.showPromotions = true;
        },
        clickSeeTypes() {
            this.typeItem = "table_types";
            this.showItems = true;
        },
        clickSeeTowers() {
            this.typeItem = "towers";
            this.showItems = true;
        },
        clickSeeFloors() {
            this.typeItem = "floors";
            this.showItems = true;
        },
        clickCreateMassive() {
            this.showDialogMassive = true;
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        async getData(page = 1) {
            this.pagination.current_page = parseInt(page);
            this.pagination.per_page = parseInt(page);
            this.loading_data = true;
            return this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading_data = false;
                });
            //}
        },
        async getTables() {
            this.$http
                .get(`/caja/areas/records?column=description&page=1&value`)
                .then(response => {
                    this.areas = response.data.data;
                });
            this.$http
                .get(
                    `/caja/status-tables/records?column=description&page=1&value`
                )
                .then(response => {
                    this.statusTable = response.data.data;
                });
            this.$http.get(`/caja/rooms/types`).then(response => {
                this.types = response.data.data;
            });
            this.$http.get(`/establishments/records`).then(response => {
                this.establishments = response.data.data;

                console.log(this.establishments);
            });
        },
        async updateSearchPrint(row) {
            try {
                this.loading_data = true;
                const response = await this.$http.post(
                    `/${this.resource}`,
                    row
                );
                if (response.status == 200) {
                    this.$toast.success("Area actualizada");
                } else {
                    this.$toast.warning("Ocurrió un error");
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("error");
            } finally {
                this.loading_data = false;
            }
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDelete(id, active) {
            if (active == undefined) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit("reloadData")
                );
            } else {
                if (active) {
                    this.disable(`/${this.resource}/${id}`).then(() =>
                        this.$eventHub.$emit("reloadData")
                    );
                } else {
                    this.enable(`/${this.resource}/${id}`).then(() =>
                        this.$eventHub.$emit("reloadData")
                    );
                }
            }
        }
    }
};
</script>
