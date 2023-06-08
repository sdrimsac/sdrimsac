<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Reporte de Stock Minimo</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Reporte</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Stock Minimo</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">
                        Listado de productos con stock minimo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 ">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <h3 class=" text-muted ">
                                    Buscar
                                </h3>

                                <el-input
                                    ref="input_itemMobil"
                                    size="small"
                                    v-model="input_searchItems"
                                    placeholder="Ingrese aca Un Producto"
                                >
                                    <el-button
                                        slot="append"
                                        icon="el-icon-search"
                                    ></el-button>
                                </el-input>
                            </div>

                            <div class="col-md-3" style="align-self: self-end;">
                                <div class="form-group">
                                    <label class="control-label"> </label>
                                    <el-button
                                        type="primary"
                                        size="small"
                                        @click="showOrdenCompra"
                                    >
                                        Ver Ordenes de Compra
                                    </el-button>
                                </div>
                            </div>
                            <div class="col-md-3" style="align-self: self-end;">
                                <div class="form-group">
                                    <label class="control-label"> </label>
                                    <el-button
                                        type="primary"
                                        size="small"
                                        @click="newOrdenCompra"
                                    >
                                        Generar Orden de Compra
                                    </el-button>
                                </div>
                            </div>
                            <div class="col-md-3" style="align-self: self-end;">
                                <div class="form-group">
                                    <label class="control-label"> </label>
                                    <el-button
                                        type="primary"
                                        size="small"
                                        @click="newOrdenCompraMasiva"
                                    >
                                        Generar Orden de Compra Masiva
                                    </el-button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <data-table
                                ref="DataTable"
                                :input_searchItems.sync="this.input_searchItems"
                            >
                                <tr slot="heading">
                                    <th>#</th>
                                    <th>Acciones</th>
                                    <th>Descripcion</th>
                                    <th class="text-end">Stok Minimo</th>
                                    <th class="text-end">Stock en Almacen</th>
                                    <th class="text-end">Almacen</th>
                                </tr>

                                <tr></tr>
                                <tr slot-scope="{ index, row }">
                                    <td>{{ index }}</td>
                                    <td>
                                        <button
                                            v-if="row.has_orden_compra == 0"
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-info"
                                            @click.prevent="
                                                verProveedores(row.id)
                                            "
                                        >
                                            Proveedores
                                        </button>
                                    </td>
                                    <td>{{ row.description }}</td>
                                    <td class="text-end ">
                                        {{ row.stock_min }}
                                    </td>
                                    <td class="text-end ">{{ row.stock }}</td>
                                    <td class="text-end">{{ row.almacen }}</td>
                                </tr>
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <el-dialog
            title="Lista de precios de Compra"
            :visible.sync="showDialogVerProveedores"
            width="75%"
            @close="showDialogVerProveedores = false"
        >
            <h3 style=" margin-top: 20px;">{{ `Producto: ${ProdDesc}` }}</h3>
            <div
                class="row container table-responsive col-md-12"
                id="showDataprovDesc"
            >
                <table
                    class="table table-hover table-striped table-condensed  table-responsive"
                    style="width:100%;     white-space: nowrap;"
                >
                    <thead>
                        <tr>
                            <th>
                                Acciones
                            </th>
                            <th>
                                Precio De Compra
                            </th>
                            <th>Fecha</th>
                            <th>
                                Nombre Del Proveedor
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, idx) in recordsDescProv" :key="idx">
                            <td>
                                <el-button
                                    class="btn btn-primary"
                                    @click.prevent="
                                        insertAprovisionar(
                                            data.persona_id,
                                            data.item_id,
                                            data.unit_price
                                        )
                                    "
                                    :loading="loading_submit"
                                >
                                    {{ `Aprovisionar ` }}</el-button
                                >
                            </td>
                            <td>{{ data.unit_price }}</td>
                            <td>{{ data.date_of_issue }}</td>
                            <td>{{ data.NAME }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <span slot="footer">
                <el-button @click="showDialogVerProveedores = false"
                    >Cancel</el-button
                >
            </span>
        </el-dialog>

        <generar-orden-compra
            @callBrotherMethod="callMethod"
            :showGenOrdenCompra.sync="showGenOrdenCompra"
        >
        </generar-orden-compra>
        <genOrdenCompraMasiva
            @callBrotherMethod="callMethod"
            :showOrdenCompraMasiva.sync="showOrdenCompraMasiva"
        >
        </genOrdenCompraMasiva>
        <show-ordenes-compra
            :showdialogOrdenesCompra.sync="showdialogOrdenesCompra"
        >
        </show-ordenes-compra>
    </div>
</template>
<style>
.el-dialog__header {
    background-color: var(--primary) !important;
}
.el-dialog__title {
    color: var(--light-text) !important;
}
.el-dialog__headerbtn .el-dialog__close {
    color: white !important;
}
</style>

<script>
import DataTable from "./datatableStockMin.vue";
//import GenerarOrdenCompra from './genOrdenCompra.vue'
import ShowOrdenesCompra from "./ShowOrdenesCompra.vue";
import genOrdenCompraMasiva from "./genOrdenCompraMasv.vue"

const GenerarOrdenCompra = () =>
    import(/* webpackChunkName: "GenerarOrdenCompra" */ "./genOrdenCompra.vue");
//const ShowOrdenesCompra = () => import(/* webpackChunkName: "ShowOrdenesCompra" */'./ShowOrdenesCompra.vue');


export default {
    components: { DataTable, GenerarOrdenCompra, ShowOrdenesCompra , genOrdenCompraMasiva},
    props: ["stablecimientos", "categoria"],
    data() {
        return {
            form: {},
            showDialogVerProveedores: false,
            resource: "reports/stockmin",
            ProdDesc: "",
            recordsDescProv: "",
            OrdenDeCompra: {
                id: "",
                idItem: "",
                idProve: ""
            },
            botonOculto: false,
            loading_submit: false,
            showGenOrdenCompra: false,
            showdialogOrdenesCompra: false,
            input_searchItems: "", 
            showOrdenCompraMasiva: false 
        };
    },
    methods: {
        verProveedores(id) {
            try {
                return this.$http
                    .get(`/${this.resource}/recordsProveedor/${id}`)
                    .then(response => {
                        if (response.data.length > 0) {
                            if (response.data[0].has_orden_compra == 1) {
                                this.botonOculto = true;
                            }
                            this.ProdDesc = response.data[0].description;
                            //console.log(response.data[0].description)
                            //ProdDesc
                            this.recordsDescProv = response.data;
                            //console.log(this.recordsDescProv)
                            this.showDialogVerProveedores = true;
                            //id del contenedor showDataprovDesc
                        } else {
                            this.$toast.error(
                                "No se le ha realizado compras a este producto "
                            );
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async insertAprovisionar(prov_id, item_id, precio_compra) {
            this.loading_submit = true;
            try {
                const response = await this.$http.post(
                    `/${this.resource}/insertAprovisionar`,
                    {
                        item_id,
                        prov_id,
                        precio_compra
                    }
                );

                const { message, status } = response;
                if (status == 200) {
                    this.$toast.success(
                        "Producto Preparado con exito para generar Orden de compra "
                    );
                    await this.$refs.DataTable.getRecords();
                    this.showDialogVerProveedores = false;
                } else {
                    console.log(response);
                }
            } catch (error) {
                this.$toast.error(error.message);
            } finally {
                this.loading_submit = false;
            }
        },
        showOrdenCompra() {
            this.showdialogOrdenesCompra = true;
        },
        newOrdenCompra() {
            this.showGenOrdenCompra = true;
        },
        callMethod() {
            this.$refs.DataTable.getRecords();
        },
        newOrdenCompraMasiva(){
            this.showOrdenCompraMasiva = true 
        }
    }
};
</script>
