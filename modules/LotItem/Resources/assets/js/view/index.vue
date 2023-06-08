<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Series (productos)</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Series de productos</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h6 class="my-0  text-white">
                                Listado Series (productos)
                            </h6>
                        </div>
                        <div class="data-table-visible-columns">
                            <el-dropdown :hide-on-click="false">
                                <el-button type="primary">
                                    Mostrar/Ocultar columnas<i
                                        class="el-icon-arrow-down el-icon--right"
                                    ></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item
                                        v-for="(column, index) in columns"
                                        :key="index"
                                    >
                                        <el-checkbox v-model="column.visible">{{
                                            column.title
                                        }}</el-checkbox>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>
                        <div class="card-body">
                            <data-table :resource="resource">
                                <tr slot="heading">
                                    <th>#</th>
                                    <th>Serie</th>
                                    <th>
                                        Producto
                                    </th>
                                    <th>Fecha</th>
                                    <th>
                                        Almacén
                                    </th>
                                    <th>Vendido</th>
                                    <th>Estado</th>
                                </tr>

                                <tr></tr>
                                <tr slot-scope="{ index, row }">
                                    <td>
                                        {{ index }}
                                    </td>
                                    <td>
                                        {{ row.series }}
                                    </td>
                                    <td>
                                        {{ row.item.description }}
                                    </td>
                                    <td>
                                        {{ row.date }}
                                    </td>
                                    <td>
                                        {{ row.warehouse.description }}
                                    </td>
                                    <td>
                                        {{ row.has_sale ? "Sí" : "No" }}
                                    </td>
                                    <td>
                                        {{ row.active }}
                                    </td>
                                </tr>
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../components/Datatable.vue";
export default {
    components: { DataTable },
    data() {
        return {
            resource: "lotitem",
            columns: {}
        };
    }
};
</script>
