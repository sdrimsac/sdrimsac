<template>
    <el-dialog
        @close="close"
        @open="open"
        :visible="showPendingOrdens"
        title="Ordenes Pendientes"
        width="80%"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
    >

    <div class="card mb-3 p-3">
        <div class="row align-items-center">
            <div class="col-md-6 mb-2">
                <label for="order-number">Ingresar el número de orden</label>
                <el-input
                    id="order-number"
                    @input="searchOrden"
                    v-model="form.value"
                    placeholder="N° orden"
                >
                </el-input>
            </div>
            <div class="col-md-6 mb-2">
                <el-checkbox v-model="form.cash" @change="getRecords">
                    Filtrar Ventas Directas (sin mesa)
                </el-checkbox>
            </div>
        </div>
    </div>
        <div v-loading="loading" class="card">
            
        </div>
            
            <table 
                class="table table-hover table-striped table-bordered table-responsive"
                style="width: 100%; white-space: nowrap; font-size: 14px;"
            >
                <thead class="thead-dark">
                    <tr class="bg-primary text-center">
                        <th class="text-white">#</th>
                        <th class="text-white">Mesa</th>
                        <th class="text-white">Orden #</th>
                        <th class="text-white">Estado</th>
                        <th class="text-white">Referencia de la atención</th>
                        <th class="text-white">Cant.</th>
                        <th class="text-white">Fecha</th>
                        <th class="text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ord, idx) in ordens" :key="idx">
                        <td class="text-center">{{ idx + 1 }}</td>
                        <td class="text-center">{{ ord.table }}</td>
                        <td class="text-center">{{ ord.id }}</td>
                        <td>
                            <span
                                :class="{
                                    'text-success': ord.status_id == 3 || ord.status_id == 4,
                                    'text-warning': ord.status_id == 2,
                                    'text-danger': ord.status_id == 5,
                                    'text-info': ord.status_id == 1
                                }"
                            >
                                {{ ord.status }}
                            </span>
                        </td>
                        <td>{{ ord.ref || "-" }}</td>
                        <td class="text-center">{{ ord.orden_items.length }}</td>
                        <td>
                            {{ ord.date }}
                            <br />
                            <small>{{ ord.time }}</small>
                        </td>
                        <td class="text-center">
                            <el-tooltip
                                v-if="ord.credit_list_id"
                                content="Imprimir a cuenta"
                                placement="top"
                            >
                                <el-button
                                    type="success"
                                    icon="el-icon-printer"
                                    @click="printCreditList(ord.credit_list_id)"
                                ></el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-if="configuration.re_printer"
                                content="Imprimir ticket"
                                placement="top"
                            >
                                <el-button
                                    type="primary"
                                    icon="el-icon-printer"
                                    @click="printTicket(ord.id)"
                                ></el-button>
                            </el-tooltip>
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
    props: ["showPendingOrdens", "areas", "configuration"],
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
            showDialog: false,
            currentOrdenId: null,
            currentOrdenItems: []
        };
    },
    methods: {
        listOrden(id) {
            this.showDialog = true;
            this.currentOrdenId = id;
            let orden = this.ordens.find(ord => ord.id == id);
            this.currentOrdenItems = orden.orden_items;
        },
        getOrdenItems() {},
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
                let printerR = response.data.printer;

                await this.$http.post("/caja/re-print", {
                    url,
                    printer: printerR
                });
                return;
                let config = qz.configs.create(response.data.printer, {
                    scaleContent: false
                });
                let printer = response.data.printer;
                console.log(printer);
                let isPosd = printer.split(" ")[printer.split(" ").length - 1];
                console.log(isPosd);
                if (isPosd == "POSD") {
                    config.density = 200;
                }
                console.log(config);
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
                const response = await this.$http(
                    `ordens-pending?${query}&cash=${this.form.cash}`
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
            this.form = {};
            this.$emit("update:showPendingOrdens", false);
        }
    }
};
</script>
