<template>
    <div v-loading="loading">
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Productos / {{ title }}</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Productos / {{ title }}</span
                                >
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
                    </div>
                    <!-- <div class="col-sm-6">
                <div class="bookmark">
                <ul>
                    <li  v-if="typeUser != 'integrator'">
                        <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                            <a  href="javascript:void(0)"  @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
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
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Fecha creación</th>
                            <th v-if="configuration.pos_drag_category"> Caja arrastre</th>
                            <th class="text-right">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>
                            <td>
                                <img :src="row.icono" height="30" width="30" />
                            </td>
                            <td>{{ row.created_at }}</td>
                            <td v-if="configuration.pos_drag_category">
                                <el-checkbox
                                    @change="changeDrag(row)"
                                    v-model="row.drag"
                                >
                                </el-checkbox>
                            </td>
                            <td class="text-right">
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

                <category-form
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                ></category-form>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryForm from "./form.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
export default {
    props:["configuration"],
    mixins: [deletable],
    components: { DataTable, CategoryForm },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "items/categories",
            recordId: null,
            loading: false
        };
    },
    created() {
        console.log(this.configuration);
        this.title = "Categorías";
    },
    methods: {
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
        }
    }
};
</script>
