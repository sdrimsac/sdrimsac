<template>
    <el-dialog
        :close-on-click-modal="false"
        width="40%"
        :visible="showDialog"
        @close="close"
        title="Aceptar Mercaderia "
    >
        <div v-loading="loading" class="p-2">
            <div class="row">
                <div class="col-md-4">
                    <span>Código de transferaencia</span>
                    <el-input @input="getTransfer" v-model="code"></el-input>
                </div>
                <div class="col-md-4">
                    <span>PIN</span>
                    <el-input
                        :disabled="!transfer"
                        show-password
                        v-model="pin"
                    ></el-input>
                </div>
                <div
                    v-if="transfer"
                    class="col-md-4 d-flex align-items-end justify-content-start"
                >
                    <el-button type="primary" @click="acceptTransfers">
                        Aceptar
                    </el-button>
                </div>
            </div>
            <template v-if="transfer">
                <div class="d-flex flex-column" style="margin-top:10px;">
                    <h5>
                        De:
                        <strong>{{ transfer.warehouse.description }}</strong>
                    </h5>
                    <h5>
                        A:
                        <strong>{{
                            transfer.warehouse_destination.description
                        }}</strong>
                    </h5>
                </div>
                <div class="row" style="margin-top:10px;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="(data, idx) in transfer.detail"
                                :key="idx"
                            >
                                <td>{{ idx + 1 }}</td>
                                <td>{{ data.item.description }}</td>
                                <td>{{ data.quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            <div class="p-3"></div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            loading: false,
            code: null,
            pin: null,
            transfer: null,
            time: null
        };
    },
    methods: {
        async acceptTransfers() {
            try {
                this.loading = true;
                const form = {
                    code: this.code,
                    pin: this.pin
                };
                const response = await this.$http.post(
                    "/transfers/accept_transfer",
                    form
                );
                const { success, message } = response.data;
                if (success) {
                    this.$toast.success(message);
                } else {
                    this.$toast.error(message);
                }

                this.close();
            } catch (e) {
                this.$toast.error(`Ocurrió un error ${e}`);
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async getTransfer() {
        console.log("aaaa");
            if (this.code.length == 5) {
                if (this.time) {
                    clearTimeout(this.time);
                }

                this.time = setTimeout(async () => {
                    try {
                        this.loading = true;
                        const response = await this.$http(
                            `/transfers/places?code=${this.code}`
                        );
                        console.log("🚀 ~ file: transfer_modal.vue:124 ~ this.time=setTimeout ~ response:", response)
                        console.log("🚀 ~ file: transfer_modal.vue:126 ~ this.time=setTimeout ~ message:", message)
                        const { message, success, transfer } = response.data;
                        if (success) {
                            this.transfer = transfer;
                        } else {
                            // this.$toast.warning(message);
                        }
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading = false;
                    }
                }, 500);
            }
        },
        close() {
            this.$emit("update:showDialog", false);
            this.code = null;
            this.pin = null;
            this.transfer = null;
            this.time = null;
        }
    }
};
</script>
