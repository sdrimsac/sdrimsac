<template>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h6>
                        <span>Productos / {{ title }}</span>
                    </h6>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/items">Dashboard</a>
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
                            <th>Porcentaje</th>
                            <th>Monto de inscripción</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.description }}</td>
                            <td>{{ row.percentage }}</td>
                            <td>{{ row.inscription_amount }}</td>
                            <td>
                                {{ row.active ? "Activado" : "Desactivado" }}
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
                                    class=""
                                    @click.prevent="clickDelete(row.id)"
                                >
                                    Desactivar
                                </button>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <vip-form :showFormVip.sync="showFormVip" :recordId="recordId">
                </vip-form>
            </div>
        </div>
    </div>
</template>

<script>
import VipForm from "./vip-form.vue";
import DataTable from "../../../../../../resources/js/components/DataTable.vue";

export default {
    props: ["type"],
    components: { DataTable, VipForm },
    data() {
        return {
            title: null,
            showDialog: false,
            showFormVip: false,
            resource: `vip/${this.type}`,
            recordId: null
        };
    },
    created() {
        this.title = "Categorías";
    },
    methods: {
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showFormVip = true;
        },
        async clickDelete(id) {
            try {
                const response = await this.$http(
                    `${this.resource}/desactive/${id}`
                );
                if (response.status == 200) {
                    this.$eventHub.$emit("reloadData");
                }
            } catch (e) {
                console.log(e);
            } finally {
            }
            //desactive
        }
    }
};
</script>
