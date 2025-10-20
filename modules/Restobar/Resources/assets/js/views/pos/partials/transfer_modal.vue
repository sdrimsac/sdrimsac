<template>
    <el-dialog :close-on-click-modal="false" width="600px" :visible="showDialog" class="transfer-modal-dialog"
        :show-close="false">

        <div v-loading="loading" class="transfer-modal-bg p-0">
            <div class="transfer-modal-header d-flex align-items-center px-4 py-3 mb-2">
                <i class="el-icon-box text-primary" style="font-size:2rem;"></i>
                <h4 class="ms-2 mb-0 fw-bold text-dark">Aceptar Mercadería</h4>
            </div>
            <div class="px-4 pb-3">
                <div class="row gx-2 gy-2 align-items-center">
                    <div class="col-7 d-flex align-items-center">
                        <el-input @input="getTransfer" v-model="code" placeholder="Código de transferencia" size="large"
                            class="rounded-pill" clearable></el-input>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <el-input :disabled="!transfer" show-password v-model="pin" placeholder="PIN" size="large"
                            class="rounded-pill" clearable></el-input>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <el-button v-if="transfer" type="success" @click="acceptTransfers" size="large" icon="el-icon-check"
                        class="btn_guardarsmall">
                        Aceptar
                    </el-button>
                    <el-button type="danger" @click="close" size="large" icon="el-icon-close" class="btn_cancelarsmall">
                        Cerrar
                    </el-button>
                </div>
            </div>
            <template v-if="transfer">
                <div class="transfer-modal-section px-4 pb-2">
                    <div class="row">
                        <div class="col-6">
                            <span class="text-muted small">De:</span>
                            <div class="fw-bold text-primary">
                                <template
                                    v-if="transfer.warehouse.description && transfer.warehouse.description.includes(' - ')">
                                    {{ transfer.warehouse.description.split(' - ')[0] }}<br>
                                    {{ transfer.warehouse.description.split(' - ')[1] }}
                                </template>
                                <template v-else>
                                    {{ transfer.warehouse.description }}
                                </template>
                            </div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small">A:</span>
                            <div class="fw-bold text-success">
                                <template
                                    v-if="transfer.warehouse_destination.description && transfer.warehouse_destination.description.includes(' - ')">
                                    {{ transfer.warehouse_destination.description.split(' - ')[0] }}<br>
                                    {{ transfer.warehouse_destination.description.split(' - ')[1] }}
                                </template>
                                <template v-else>
                                    {{ transfer.warehouse_destination.description }}
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive px-4 pb-3">
                    <table class="table table-sm table-hover table-borderless">
                        <thead style="background-color: #1e5a85;">
                            <tr>
                                <th class="text-center" style="color: #fff;">#</th>
                                <th style="color: #fff;">Producto</th>
                                <th class="text-center" style="color: #fff;">Cantidad</th>
                                <th style="color: #fff;">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, idx) in transfer.detail" :key="idx"
                                :class="idx % 2 === 0 ? 'bg-white' : 'bg-light'">
                                <td class="text-center text-muted">{{ idx + 1 }}</td>
                                <td>{{ data.item.description }}</td>
                                <td class="text-center fw-bold text-primary">{{ data.quantity }}
                                    <!-- iterar  -->
                                </td>
                                <td>
                                    <!-- si tiene color y talla  -->
                                    <div v-if="data.series_lots && data.series_lots.color_size">
                                        <div v-for="(cs, csIdx) in data.series_lots.color_size" :key="csIdx"
                                            class="small text-muted">
                                            {{ cs.code }} - {{ cs.quantity }} - Color: {{ cs.color }} - Talla:
                                            {{ cs.size }}
                                        </div>
                                    </div>
                                    <!-- si tiene lotes  -->
                                    <div v-else-if="data.series_lots && data.series_lots.lots">
                                        <div v-for="(lot, lotIdx) in data.series_lots.lots" :key="lotIdx"
                                            class="small text-muted">
                                            {{ lot.code }} - {{ lot.quantity }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
        </div>
    </el-dialog>
</template>

<style scoped>
.transfer-modal-bg {
    background: #f8fafc;
    border-radius: 18px;
}

.transfer-modal-header {
    background: linear-gradient(90deg, #e3f2fd 0%, #fff 100%);
    border-top-left-radius: 18px;
    border-top-right-radius: 18px;
}

.transfer-modal-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    margin-bottom: 10px;
}
</style>

<script>
import Swal from 'sweetalert2';

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
                const { success, message, pin_error } = response.data;
                if (success) {
                    this.$toast.success(message);
                    this.close();
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else if (pin_error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'PIN incorrecto',
                        text: message || 'El PIN no coincide con el usuario actual.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    this.$toast.error(message);
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Ocurrió un error: ${e}`,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Aceptar'
                });
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
                        // console.log("🚀 ~ file: transfer_modal.vue:124 ~ this.time=setTimeout ~ response:", response)
                        // console.log("🚀 ~ file: transfer_modal.vue:126 ~ this.time=setTimeout ~ message:", message)
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
