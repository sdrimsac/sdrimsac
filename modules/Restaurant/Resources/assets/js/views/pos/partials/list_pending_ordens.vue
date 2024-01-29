<template>
    <el-dialog
        @close="close"
        @open="open"
        :visible="showPendingOrdens"
        title="Ordenes pendientes"
    >
        <div v-loading="loading" class="card">
            <div class="d-flex">
                <div class="col-4" style="    margin-top: 15px;">
                    <el-input
                        @input="searchOrden"
                        v-model="form.value"
                        placeholder="N° orden"
                    >
                    </el-input>
                </div>
            </div>
            <div class="m-1"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mesa</th>
                        <th>Orden #</th>
                        <th>Referencia</th>
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
                            {{ ord.ref || "-" }}
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
                            <el-tooltip
                                v-if="ord.credit_list_id"
                                content="Imprimir a cuenta"
                                placement="top"
                            >
                                <el-button
                                    type="success"
                                    icon="el-icon-printer"
                                    @click="
                                        printCreditList(ord.credit_list_id)
                                    "
                                ></el-button>
                            </el-tooltip>
                            <el-button
                                type="primary"
                                icon="el-icon-printer"
                                @click="printTicket(ord.id)"
                            ></el-button>
                                <el-tooltip
                                    content="Ver detalle"
                                    placement="top"
                                >
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
            :visible.sync="showDialog"
            title="Listado de ordenes"
            width="60%"
            append-to-body
            @open="getOrdenItems"
            @close="showDialog = false"
            >
            <div class="row">
                <div class="table-responsive">
                    <table class="table table striped">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Pedido
                                </th>
                                <th>
                                    Cantidad
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in currentOrdenItems" :key="idx">
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
    props: ["showPendingOrdens", "areas"],
    data() {
        return {
            form: {},
            ordens: [],
            loading: false,
            pagination: {},
            timer: null,
            showDialog:false,
            currentOrdenId:null,
            currentOrdenItems:[]
        };
    },
    methods: {
        listOrden(id){
            this.showDialog = true;
            this.currentOrdenId = id;
            let orden = this.ordens.find(ord => ord.id == id);
            this.currentOrdenItems = orden.orden_items;
        },
        getOrdenItems(){

        },
        ///credit-list/receipt/${this.currentCreditList}/ticket
        async printCreditList(id) {
            let paperConfig = {
                scaleContent: false
            };

            let printer = this.$areaPrinter;

            let config = qz.configs.create(printer, paperConfig);
            let linkpdf = `/credit-list/receipt/${id}/ticket`;
            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            for (let index = 0; index < 2; index++) {
                await new Promise(resolve => setTimeout(resolve, 1500));
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
        },
        async printTicket(id) {
            try {
                const response = await this.$http.get(
                    `/caja/worker/record/${id}?to_kitchen=1`
                );
                let url = response.data.print;

                let config = qz.configs.create(response.data.printer, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: url
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });

                //this.$toast.success("se esta imprimiendo el comprobante con exito");
                // qz.websocket.disconnect()
            } catch (e) {
                this.$toast.error(e.message);
            }
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
                const response = await this.$http(`ordens-pending?${query}`);
                if (response.status == 200) {
                    const { data, meta } = response.data;
                    this.ordens = data;
                    this.pagination = meta;
                }
            } catch (e) {
                this.$toast.error("Ocurrió un erro");
            } finally {
                this.loading = false;
            }
        },
        async open() {
            console.log(this.areas);
            this.getRecords();
        },
        close() {
            this.form = {};
            this.$emit("update:showPendingOrdens", false);
        }
    }
};
</script>
