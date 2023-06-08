<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Comisiones</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Comisiones</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Comisiones por producto</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" width="100%">
                            <th>#</th>
                            <!-- <th>Cód. Interno</th> -->
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Comisión</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <!-- <td>{{ row.internal_id }}</td> -->
                            <td>{{ row.full_description }}</td>
                            <td>{{ row.commission_type }}</td>
                            <td>{{ row.commission_amount }}</td>
                            <td class="text-end">
                                <template
                                    v-if="
                                        typeUser === 'admin' ||
                                            typeUser === 'superadmin'
                                    "
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickCreate(row.id)"
                                    >
                                        Comisión
                                    </button>
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        Eliminar
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <items-form
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                ></items-form>
            </div>
        </div>
    </div>
</template>
<script>
import ItemsForm from "./form.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";

export default {
    props: ["typeUser"],
    components: { ItemsForm, DataTable },
    data() {
        return {
            showDialog: false,
            showImportDialog: false,
            showWarehousesDetail: false,
            resource: "incentives",
            recordId: null
        };
    },
    created() {},
    methods: {
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        destroy(url) {
            return new Promise(resolve => {
                this.$confirm("¿Desea eliminar el incentivo?", "Eliminar", {
                    confirmButtonText: "Eliminar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                })
                    .then(() => {
                        this.$http
                            .delete(url)
                            .then(res => {
                                if (res.data.success) {
                                    this.$toast.success(res.data.message);
                                    resolve();
                                } else {
                                    this.$toast.error(res.data.message);
                                    resolve();
                                }
                            })
                            .catch(error => {
                                if (error.response.status === 500) {
                                    this.$toast.error(
                                        "Error al intentar eliminar"
                                    );
                                } else {
                                    console.log(error.response.data.message);
                                }
                            });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        }
    }
};
</script>
