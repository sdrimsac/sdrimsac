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
                        <th>Hora</th>
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
                            {{ ord.time }}
                        </td>
                        <td>
                            <el-button
                                type="primary"
                                icon="el-icon-printer"
                                @click="printTicket(ord.id)"
                            ></el-button>
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
            timer: null
        };
    },
    methods: {
        async printTicket(id) {
            try {
                const response = await this.$http.get(
                    `/restaurant/worker/record/${id}?to_kitchen=1`
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
