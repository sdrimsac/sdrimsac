<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Promociones</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de promociones</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-boxes"></i>
                    Listado de Promociones
                </h4>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="primary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    <i class="fas fa-plus-circle"></i>
                    Nuevo
                </el-button>
            </div>
            <div class="card-body">
                <data-table ref="datatable" :resource="resource">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Descripción</th>
                        <th class="text-white">
                            Fecha inicio
                        </th>
                        <th class="text-white">
                            Fecha Final
                        </th>
                        <th class="text-white">{{ accDescription }}</th>
                        <th class="text-white" v-if="promotionByPoints">
                            Puntos
                        </th>
                        <th class="text-white">
                            Limite de canje
                        </th>
                        <th class="text-white">Estado</th>
                        <th class="text-white text-right"></th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.description }}</td>
                        <td
                            :class="{
                                'text-danger': row.status === 'danger',
                                'text-warning': row.status === 'warning'
                            }"
                        >
                            {{ row.date_start }}
                        </td>
                        <td
                            :class="{
                                'text-danger': row.status === 'danger',
                                'text-warning': row.status === 'warning'
                            }"
                        >
                            {{ row.date_end }}
                        </td>
                        <td>{{ row.total }}</td>
                        <td v-if="promotionByPoints">{{ row.points_value }}</td>
                        <td>{{ row.limit_changes }}</td>
                        <td :class="{'text-success': row.active, 'text-danger': !row.active}">
                            {{ row.active ? 'Activo' : 'Desactivado' }}
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
                                    title=""
                                    data-bs-original-title="Item Count"
                                    aria-label="Item Count"
                                    >Acciones
                                </span>
                            </button>
                            <div
                                class="dropdown-menu dropdown-menu-end"
                                style=""
                            >
                                <a
                                    type="button"
                                    class="dropdown-item text-warning"
                                    @click.prevent="clickResetPoints(row.id)"
                                >
                                    <i class="fa fa-refresh"></i>
                                    Resetear Puntos
                                </a>
                                <a
                                    type="button"
                                    class="dropdown-item text-info"
                                    @click.prevent="
                                        clickDeactivatePromotion(row)
                                    "
                                >
                                    <i class="fa fa-power-off"></i>
                                    {{
                                        row.active
                                            ? "Desactivar Promoción"
                                            : "Activar Promoción"
                                    }}
                                </a>
                                <a
                                    type="button"
                                    class="dropdown-item text-secondary"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    <i class="fa fa-edit"></i>
                                    Editar
                                </a>

                                <a
                                    type="button"
                                    class="dropdown-item text-danger"
                                    @click.prevent="clickDelete(row.id)"
                                >
                                    <i class="fa fa-trash"></i>
                                    Eliminar
                                </a>
                            </div>
                        </td>
                    </tr>
                </data-table>
            </div>

            <promotion-form
                :showDialog.sync="showDialog"
                :record-id="recordId"
                :promotionByPoints="promotionByPoints"
                @reload="() => $refs.datatable.getRecords()"
            ></promotion-form>
        </div>
    </div>
</template>
<script>
import DataTable from "../../../../resources/js/components/DataTable.vue";
import { deletable } from "../../../../resources/js/mixins/deletable";
import PromotionForm from "./partials/form.vue";
export default {
    props: ["typeUser", "configuration"],
    mixins: [deletable],
    components: {
        DataTable,
        PromotionForm
    },
    data() {
        return {
            showDialog: false,
            showImportSetDialog: false,
            showImportSetIndividualDialog: false,
            showWarehousesDetail: false,
            resource: "promotions-document",
            recordId: null,
            warehousesDetail: []
        };
    },
    computed: {
        accDescription() {
            return this.configuration.is_promotion_document
                ? "Total a consumir"
                : "Monto por punto";
        },
        promotionByPoints() {
            return this.configuration.promotions_by_points;
        }
    },
    created() {},
    methods: {
        clickResetPoints(id) {
            let type = this.promotionByPoints ? "puntos" : "montos";
            let message = `¿Estás seguro de querer resetear los ${type} de la promoción?`;
            this.$confirm(message, "Confirmación", {
                confirmButtonText: "Resetear",
                cancelButtonText: "Cancelar",
                type: "warning"
            }).then(() => {
                this.$http
                    .post(`/${this.resource}/reset-points/${id}`)
                    .then(() => {
                        this.$eventHub.$emit("reloadData");
                        this.$toast.success("Puntos reseteados");
                    });
            });
        },
        clickDeactivatePromotion(row) {
            this.$confirm(
                "¿Estás seguro de querer " +
                    (row.active ? "desactivar" : "activar") +
                    " la promoción?",
                "Confirmación",
                {
                    confirmButtonText: "Desactivar",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            ).then(() => {
                this.$http
                    .post(`/${this.resource}/deactivate/${row.id}`)
                    .then(() => {
                        this.$toast.success(
                            "Promoción " +
                                (row.active ? "desactivada" : "activada")
                        );
                        this.$eventHub.$emit("reloadData");
                    });
            });
        },
        clickImportSetIndividual() {
            this.showImportSetIndividualDialog = true;
        },
        clickWarehouseDetail(warehouses) {
            this.warehousesDetail = warehouses;
            this.showWarehousesDetail = true;
        },
        clickCreate(recordId = null) {
            console.log(
                "🚀 ~ clickCreate ~ this.promotionByPoints:",
                this.promotionByPoints
            );
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickImportSet() {
            this.showImportSetDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
