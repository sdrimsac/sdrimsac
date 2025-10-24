<template>
    <el-dialog
        @close="close"
        @open="open"
        :visible="showDialog"
        title="Ordenes atendidos por cocina"
    >
        <div v-loading="loading" class="card">
            <div class="d-flex">
                <div class="col-4 m-3">
                    <el-input
                        @input="searchOrden"
                        v-model="form.value"
                        placeholder="N° orden"
                    >
                    </el-input>
                </div>
                <div class="col-2">
                    <br>
                    <el-checkbox v-model="form.cash" @change="getRecords">
                         Venta directa
                    </el-checkbox>
                </div>
            </div>
            <div class="m-1"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mesa</th>
                        <th>Orden #</th>
                        <th>Estado</th>
                        <th>Referencia</th>
                        <th>Pedido Realizado</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ord, idx) in ordens" :key="idx">
                        <td>
                            {{ idx + 1 }}
                        </td>
                        <td>
                            {{ ord.table }}
                        </td>
                        <td>
                            {{ ord.id }}
                        </td>
                        <td>
                            <span
                                :class="{
                                    'text-success':
                                        ord.status_id == 3 ||
                                        ord.status_id == 4,
                                    'text-warning': ord.status_id == 2,
                                    'text-danger': ord.status == 5,
                                    'text-info': ord.status == 1
                                }"
                            >
                                {{ ord.status }}
                            </span>
                        </td>
                        <td>
                            {{ ord.ref || "-" }}
                        </td>
                        <td>
                            {{ ord.mozo_name  || "-" }}
                        </td>
                        <td>{{ ord.orden_items.length }}</td>
                        <td>
                            {{ ord.date }}
                            <br />
                            <small>
                                {{ ord.time }}
                            </small>
                        </td>
                        <td>
                            <!-- <el-tooltip
                                v-if="ord.credit_list_id"
                                content="Imprimir a cuenta"
                                placement="top"
                            >
                                <el-button
                                    type="success"
                                    icon="el-icon-printer"
                                    @click="printCreditList(ord.credit_list_id)"
                                ></el-button>
                            </el-tooltip> -->
                            <!-- <el-button
                                type="primary"
                                icon="el-icon-printer"
                                @click="printTicket(ord.id)"
                            ></el-button> -->
                            <el-tooltip content="Ver detalle" placement="top">
                                <el-button
                                    type="warning"
                                    icon="el-icon-tickets"
                                    @click="listOrden(ord.id)"
                                ></el-button>
                            </el-tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="Number(pagination.per_page)"
            >
            </el-pagination>
            <el-dialog
                :visible.sync="showNestedDialog"
                title="Listado de ordenes"
                width="40%"
                append-to-body
                @close="showNestedDialog = false"
            >
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table striped">
                            <thead style="background-color: #1e5a85; color: white;">
                                <tr>
                                    <th style="color: white;">
                                        #
                                    </th>
                                    <th style="color: white;">
                                        Pedido
                                    </th>
                                    <th style="color: white;">
                                        Cantidad
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, idx) in currentOrdenItems"
                                    :key="idx"
                                >
                                    <td>
                                        {{ idx + 1 }}
                                    </td>
                                    <td>
                                        {{ item.food.description }}
                                    </td>
                                    <td>
                                        {{ item.quantity }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </el-dialog>
        </div>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
export default {
    props: ["showDialog", "areas"],
    data() {
        return {
            form: {
                cash: false,
                value: ""
            },
            ordens: [],
            loading: false,
            pagination: {},
            timer: null,
            currentOrdenId: null,
            currentOrdenItems: [],
            showNestedDialog: false
        };
    },
    methods: {
        listOrden(id) {
            this.showNestedDialog = true;
            this.currentOrdenId = id;
            let orden = this.ordens.find(ord => ord.id == id);
            this.currentOrdenItems = orden.orden_items;
        },
    
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                ...this.form

                // limit: this.limit
            });
        },
        searchOrden() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                await this.getRecords();
            }, 500);
        },
        async getRecords() {
            let query = this.getQueryParameters();
            try {
                this.loading = true;
                const response = await this.$http(
                    `ordens-kitchen?${query}&cash=${this.form.cash}`
                );
                if (response.status == 200) {
                    const { data, meta } = response.data;
                    this.ordens = data;
                    this.pagination = meta;
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error");
            } finally {
                this.loading = false;
            }
        },
        async open() {
            console.log(this.areas);
            this.getRecords();
        },
        close() {
            this.$emit('update:showDialog', false);
        }
    }
};
</script>
