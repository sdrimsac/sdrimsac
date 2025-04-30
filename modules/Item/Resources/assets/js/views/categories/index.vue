<!-- Módulo de Categorías -->
<template>
    <div v-loading="loading">
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 15px;"
                >
                    <h4
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <i
                            class="fas fa-sitemap"
                            style="font-size: 2rem; margin-right: 0.5rem;"
                        ></i>
                        Módulo de {{ title }}
                    </h4>
                </div>

                <div class="data-table-visible-columns">
                    <el-button
                        class="btn_titulos_modal"
                        href="javascript:void(0)"
                        @click.prevent="clickCreate()"
                    >
                        <i class="fas fa-sitemap"></i>
                        <i class="fas fa-plus"></i>
                        <span
                            style="color: #000; font-size: 1.25rem; font-weight: bold;"
                            >Nuevo</span
                        >
                    </el-button>
                    <el-button
                        v-if="configuration.health_network"
                        type="primary"
                        class="btn_titulos_modal"
                        href="javascript:void(0)"
                        @click.prevent="clickImport()"
                    >
                        <i class="fa fa-upload fa-lg"></i>
                        Importar
                    </el-button>
                </div>
                <div class="card-body">
                    <data-table
                        :resource="resource"
                        @clickReport="clickReport"
                        class="table-striped"
                    >
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Nombre</th>
                            <th class="text-white">Identificador</th>
                            <th class="text-white">Creado por</th>
                            <th class="text-white">Fecha creación</th>
                            <th class="text-white">Estado</th>
                            <th
                                class="text-white"
                                v-if="configuration.pos_drag_category"
                            >
                                Caja arrastre
                            </th>
                            <th class="text-right text-white">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>
                            <td>{{ row.identifier }}</td>
                            <td>{{ row.user_name }}</td>
                            <td>{{ row.created_at }}</td>
                            <!-- <td> 
                {{ row.active}}
              </td>-->
                            <td>
                                <span
                                    :class="{
                                        'text-white': row.active === 1,
                                        'text-white': row.active === 0
                                    }"
                                    :style="{
                                        'background-color':
                                            row.active === 1 ? 'green' : 'red',
                                        color: 'white',
                                        padding: '5px',
                                        'border-radius': '5px'
                                    }"
                                    >{{
                                        row.active === 1 ? "Activo" : "Inactivo"
                                    }}</span
                                >
                            </td>
                            <td v-if="configuration.pos_drag_category">
                                <el-checkbox
                                    @change="changeDrag(row)"
                                    v-model="row.drag"
                                ></el-checkbox>
                            </td>
                            <td class="text-right">
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
                                        title
                                        data-bs-original-title="Item Count"
                                        aria-label="Item Count"
                                        >Acciones</span
                                    >
                                </button>
                                <div
                                    class="dropdown-menu dropdown-menu-end"
                                    style
                                >
                                    <a
                                        type="button"
                                        class="dropdown-item text-secondary"
                                        @click.prevent="clickCreate(row.id)"
                                    >
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                    
                                    <a
                                        type="button"
                                        class="dropdown-item text-warning"
                                        @click.prevent="clickDisable(row.id)"
                                        v-if="row.active"
                                        >Inhabilitar</a
                                    >
                                    <a
                                        type="button"
                                        class="dropdown-item text-success"
                                        @click.prevent="clickEnable(row.id)"
                                        v-else
                                        >Habilitar</a
                                    >
                                </div>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <category-form
                    :configuration="configuration"
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                ></category-form>
                <import-form :showDialog.sync="showImportDialog"></import-form>
            </div>
        </div>
    </div>
</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
.custom-table th {
    background-color: #007bff;
    color: white;
}
.custom-table td {
    vertical-align: middle;
}
.icon-style {
    font-size: 1.25rem;
    margin-right: 0.5rem;
}
.label-style {
    font-size: 1.25rem;
    font-weight: bold;
}
</style>

<script>
import CategoryForm from "./form.vue";
import ImportForm from "./import.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
export default {
    props: ["configuration"],
    mixins: [deletable],
    components: {
        DataTable,
        CategoryForm,
        ImportForm
    },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "items/categories",
            recordId: null,
            loading: false,
            showImportDialog: false
        };
    },
    created() {
        console.log(this.configuration);
        this.title = "Categorías";
    },
    methods: {
        clickImport() {
            this.showImportDialog = true;
        },
        clickReport(query = null) {
            let { column, value } = query;
            window.open(
                `/items/categories/export?column=${column ||
                    ""}&value=${value || ""}`,
                "_blank"
            );
        },
        async changeDrag(row) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/update_drag/${row.id}`
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Se ha actualizado correctamente",
                        type: "success"
                    });
                }
            } catch (e) {
                this.$message({
                    message: "Ha ocurrido un error",
                    type: "error"
                });
            } finally {
                this.loading = false;
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
        },
        clickDisable(id) {
            this.disable(`/${this.resource}/enabled/${0}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickEnable(id) {
            this.enable(`/${this.resource}/enabled/${1}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
