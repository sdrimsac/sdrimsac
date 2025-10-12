<template>
    <el-dialog :visible.sync="showDetailDialog" width="80%" :close-on-click-modal="false"
        :before-close="() => { showDetailDialog = false; currentRow = null; }" centered :destroy-on-close="true"
        :title="`Detalle de la promoción`" appended-to-body>
        <div>
            <div class="card mb-0 pt-2 pt-md-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <el-button type="success" icon="el-icon-phone" @click="showWhatsappDialog = true">enviar al WhatsApp</el-button>
                        </div>
                        <div class="col-md-3">
                            <el-button type="danger" icon="el-icon-document" @click="generatePDF">PDF</el-button>
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-body">
                        <!-- Consulta de productos accesibles por cliente -->
                        <div v-if="productsError" class="alert alert-danger" role="alert">{{ productsError }}</div>
                        <div v-if="accessibleProducts.length" class="mb-3">
                            <h6 class="mb-2">Productos accesibles</h6>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre promocion</th>
                                        <th>Puntos disponibles</th>
                                        <th>Producto</th>
                                        <th>Precio puntos</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(prod, idx) in accessibleProducts" :key="idx">
                                        <td>{{ prod.promotion_description }}</td>
                                        <td>{{ prod.customer_points }}</td>
                                        <td>
                                            {{ prod.item_description }}
                                        </td>
                                        <td>{{ prod.item_points_value }}</td>
                                        <td v-if="prod.item_quantity != null">Cant: {{ prod.item_quantity }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <Whatsapp :customer-id="customerId" :showDialog.sync="showWhatsappDialog"/>
    </el-dialog>
</template>
<script>
import Whatsapp from "./whatsap.vue";
export default {
    props: ['isPromotionPoints', 'showDialog', 'customerId'],
    components: { Whatsapp },
    data() {
        return {
            showDetailDialog: this.showDialog,
            accessibleProducts: [],
            loadingProducts: false,
            productsError: null,
            showWhatsappDialog : false,
        }
    },
    watch: {
        showDialog(val) {
            this.showDetailDialog = val;
        },
        showDetailDialog(val) {
            if (val) {
                this.fetchAccessibleProducts();
            } else {
                this.$emit('update:showDialog', false);
            }
        }
    },
    methods: {
        closeDialog() {
            this.showDetailDialog = false;
            this.currentRow = null;
        },
        getPoints() {
            return this.isPromotionPoints ? 'Puntos' : 'Monto';
        },
        async fetchAccessibleProducts() {
            try {
                const response = await this.$http.post('/promotions-document/get-records', {
                    customer_id: this.customerId,
                });
                if (response && response.status === 200) {
                    const payload = Array.isArray(response.data) ? response.data : (response.data?.data || []);
                    this.accessibleProducts = payload;
                }
            } catch (err) {
                this.productsError = (err && err.message) ? err.message : 'No se pudo obtener los productos.';
            } finally {
                this.loadingProducts = false;
            }
        },

        /* generatePDF() {
            const url = `/promotions-document/exportable-pdf?customer_id=${this.customerId}`;
            window.open(url, '_blank');
        } */

        generatePDF() {
            const url = `/promotions-document/exportable-pdf/${this.customerId}`;
            window.open(url, '_blank');
        }
    }
}
</script>