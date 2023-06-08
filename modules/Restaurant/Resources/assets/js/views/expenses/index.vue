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
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table @clickReport="clickReport" :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Descripcion</th>

                            <th>Detalle de lista</th>
                            <th>Fecha</th>
                            <th>Efectivo</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.description }}</td>

                            <td>
                                <template v-if="row.items.length != 0">
                                    <el-button @click="seeDetail(row.items)">
                                        <i
                                            class="fa fa-search"
                                            aria-hidden="true"
                                        ></i>
                                        Ver
                                    </el-button>
                                </template>
                            </td>
                            <td>{{ row.date }}</td>
                            <td>{{ row.amount }}</td>

                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-primary"
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

                <boxForm
                    :cashid="cashid"
                    :showDialog.sync="showDialog"
                    :groupid.sync="groupid"
                    :categoryid.sync="categoryid"
                    :subcategoryid.sync="subcategoryid"
                    :userid.sync="userid"
                    :soaptypeid.sync="soaptypeid"
                    :recordId="recordId"
                >
                </boxForm>
            </div>
        </div>
        <el-dialog
            title="Detalle"
            append-to-body
            :visible.sync="showDetallesdialog"
        >
            <div class="p-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>DESCP.</th>
                            <th>CANT.</th>
                            <th>PRECIO UNIT</th>
                            <th>PRECIO ADICIONAL</th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(dt, idx) in showItemsDetalle" :key="idx">
                            <td>{{ dt.detail }}</td>
                            <td>
                                {{ dt.quantity.toFixed(2) }}
                                {{ dt.unit_id }}
                            </td>
                            <td>{{ dt.price.toFixed(2) }}</td>
                            <td>{{ dt.extra_price.toFixed(2) }}</td>
                            <td>
                                {{
                                    (
                                        dt.price * dt.quantity +
                                        dt.extra_price
                                    ).toFixed(2)
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import BoxReport from "./report.vue";
import BoxForm from "./form.vue";
import DataTable from "@components/DataTable.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
export default {
    props: [
        "cashid",
        "groupid",
        "categoryid",
        "userid",
        "subcategoryid",
        "soaptypeid"
    ],
    mixins: [deletable],
    components: { DataTable, BoxForm, BoxReport },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "restaurant/worker/expenses",
            recordId: null,
            showDialog_report: false,
            showItemsDetalle: [],
            showDetallesdialog: false
        };
    },
    created() {
        this.title = "Egresos Caja";
    },
    methods: {
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickReport(query = null) {
            //this.recordId = recordId
            //report-boxes/reports_type
            let { column, value } = query;

            window.open(
                `/restaurant/report-boxes/reports_type?type_box=expenses&column=${column}&value=${value}`
            );
            console.log("report-boxes/reports_type");
        },

        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        seeDetail(items) {
            this.showItemsDetalle = items;
            this.showDetallesdialog = true;
        }
    }
};
</script>
