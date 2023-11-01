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
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                      <button
                            v-if="resource == 'caja/rooms'"
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5"
                            @click.prevent="clickSeeTypes()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Tipo de habitaciones</span>
                        </button>
                        <button
                            v-if="resource == 'caja/rooms'"
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5"
                            @click.prevent="clickSeeTowers()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Torres</span>
                        </button>
                        <button
                            v-if="resource == 'caja/rooms'"
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5"
                            @click.prevent="clickSeeFloors()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Pisos</span>
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
                        <button
                            v-if="
                                resource == 'caja/tables' ||
                                    resource == 'caja/rooms'
                            "
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-l-5"
                            @click.prevent="clickCreateMassive()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Crear masivamente</span>
                        </button>
                        <!-- Contact Button End -->
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
                            <th
                                v-if="
                                    type != 'caja/tables' &&
                                        type != 'caja/rooms'
                                "
                            >
                                Descripción
                            </th>
                            <th
                                v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                "
                            >
                                Número
                            </th>
                            <th v-if="type == 'caja/rooms'">
                                Tipo
                            </th>
                            <th
                                v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                "
                            >
                                Área
                            </th>
                            <th
                                v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                "
                            >
                                Establecimiento
                            </th>
                            <th v-if="type == 'caja/rooms'">
                                Piso
                            </th>
                            <th v-if="type == 'caja/areas'">
                                Impresora
                            </th>
                            <th v-if="type == 'caja/areas'">
                                Forzar impresión
                            </th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td
                                v-if="
                                    type != 'caja/tables' &&
                                        type != 'caja/rooms'
                                "
                            >
                                {{ row.description }}
                            </td>
                            <td
                                v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                "
                            >
                                {{ row.number }}
                            </td>
                            <td v-if="type == 'caja/rooms'">
                                {{ row.type }}
                            </td>
                            <td
                                v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                "
                            >
                                {{ row.area.description }}
                            </td>
                            <td
                                v-if="
                                    type == 'caja/tables' ||
                                        type == 'caja/rooms'
                                "
                            >
                                {{ row.establishment }}
                            </td>
                            <td v-if="type == 'caja/rooms'">
                                {{ row.floor }}
                            </td>
                            <td v-if="type == 'caja/areas'">
                                {{ row.printer }}
                            </td>
                            <td v-if="type == 'caja/areas'">
                                <el-switch
                                    v-if="row.printer == null"
                                    @change="updateSearchPrint(row)"
                                    v-model="row.search_print"
                                >
                                </el-switch>
                            </td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickDelete(row.id)"
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <create-form
                    :types="types"
                    :showDialog.sync="showDialog"
                    :areas="areas"
                    :type="type"
                    :configurations.sync="configurations"
                    :recordId.sync="recordId"
                    :statusTable="statusTable"
                    :establishments="establishments"
                ></create-form>

                <create-form-massive
                    :types="types"
                    :showDialog.sync="showDialogMassive"
                    :areas="areas"
                    :type="type"
                    :configurations.sync="configurations"
                    :recordId.sync="recordId"
                    :statusTable="statusTable"
                    :establishments="establishments"
                ></create-form-massive>
                <items-rooms :showDialog.sync="showItems" :type="typeItem">
                </items-rooms>
            </div>
        </div>
    </div>
</template>

<script>
import CreateForm from "./form.vue";
import CreateFormMassive from "./formTableMassive.vue";
import ItemsRooms from "./items_rooms.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
import queryString from "query-string";
export default {
    props: ["type", "title", "configurations"],
    mixins: [deletable],
    components: { DataTable, CreateForm, CreateFormMassive, ItemsRooms },
    data() {
        return {
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
            typeItem: null
        };
    },
    created() {
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
                console.log(
                    "🚀 ~ file: items.vue:284 ~ this.$http.get ~ response:",
                    response
                );
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
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
