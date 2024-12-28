<!-- Modulo de Colores y Tallas -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos Con Garantia</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de Productos con Garantia</span
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
                   Productos Garantia</h4>
            </div>
            <div class="card-body">
                <data-table class="table-striped" ref="datatable" :resource="resource">
                    <tr slot="heading" width="100%" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Código</th>
                        <th class="text-white">Producto</th>
                        <th class="text-white">Cliente</th>
                        <th class="text-white">Fecha Inicio Garantia</th>
                        <th class="text-white">Tiempo De Garantia</th>
                        <th class="text-white">Fecha final Garantia</th>
                        <th class="text-white">Tiempo Restante De Garantia</th>
                        <!-- <th class="text-right text-white">Acciones</th> -->
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index + 1 }}</td>
                        <!-- <td>{{ row.item.internal_id  }}</td> -->
                        <td>{{ row.producto_internal_id }}</td>
                        <td>{{ row.producto_descripcion }}</td>
                        <td>
                            {{ row.customer.name }}<br>
                            {{ row.customer.number }}
                        </td>
                        <td>{{ row.warranty_start_date }}</td>
                        <td v-if="row.producto_month_day && row.producto_month_day !== 'NA'">{{ row.producto_month_day }} meses</td>
                        <td v-else></td>
                        <td>{{ row.warranty_end_date }}</td>
                        <td :class="{ 'text-danger': row.dias_restantes <= 0, 'text-success': row.dias_restantes > 0 }">
                            <span v-if="row.dias_restantes > 0">{{ row.dias_restantes }} dias Restantes</span>
                            <span v-else>Garantia Finalizada</span>
                        </td>
                        <!-- <td class="text-right">
                            <template
                                v-if="
                                    typeUser === 'admin' ||
                                        typeUser === 'superadmin'
                                "
                            >
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-xs btn-info btn-sm"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-xs btn-danger btn-sm"
                                    @click.prevent="clickDelete(row.id)"
                                >
                                    Eliminar
                                </button>
                            </template>
                        </td> -->
                    </tr>
                </data-table>
            </div>
        </div>
    </div>
</template>

<style>

.table-striped tr:nth-child(even) {
background-color: #f2f2f2;
}
</style>

<script>
import DataTable from "../../../../resources/js/components/DataTableWarranty.vue";

import { deletable } from "../../../../resources/js/mixins/deletable";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        DataTable,
    },
    data() {
        return {
            showDialog: false,
            resource: "warranty",
            recordId: null,
            warehousesDetail: []
        };
    },
    created() {},
    methods: {
        
        clickWarehouseDetail(warehouses) {
            this.warehousesDetail = warehouses;
            this.showWarehousesDetail = true;
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
