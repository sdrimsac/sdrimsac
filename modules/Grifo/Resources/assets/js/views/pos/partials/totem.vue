<template>
    <el-dialog :visible.sync="dialogTotem" width="60%" :close-on-click-modal="false" :show-close="false" center
        :title="title">
        <div>
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" :key="item.id || index">
                            <td>{{ item.id }}</td>
                            <td>{{ item.description }}</td>
                            <td>
                                <input type="number" step="0.01" v-model="item.sale_unit_price" class="form-control" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top: 16px; text-align: right;">
                    <el-button type="secondary" @click="closeDialog">Cancelar</el-button>
                    <el-button type="primary" @click="savePrices">Guardar</el-button>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: ['dialogTotem'],
    data() {
        return {
            title: 'Cambiar precios de los combustibles',
            items: []
        };
    },
    watch: {
        dialogTotem(val) {
            if (val) {
                this.getItem();
            }
        }
    },
    methods: {
        getItem() {
            this.$http.get('/items/records-totem').then(response => {
                this.items = response.data.data;
            });
        },

        savePrices() {

            const baseItem = {
                account_id: null,
                all_establishment: false,
                apply_store: false,
                area_id: 2,
                attributes: [],
                barcode: "",
                brand_id: null,
                calculate_quantity: false,
                categoria_madera: [],
                categoria_madera_item: [],
                category_id: 1,
                codes_family: false,
                commercial_treatments: [],
                commission: "0.00",
                commission_amount: null,
                commission_type: "amount",
                currency_type_id: "PEN",
                date_of_due: null,
                delivery_cost: "0.0000",
                description: "",
                has_color_size: false,
                has_igv: false,
                has_isc: false,
                has_perception: false,
                has_warranty: false,
                id: null,
                image: "imagen-no-disponible.jpg",
                image_url: "",
                individual_items: [],
                init_report: false,
                internal_id: "",
                is_manufactured: false,
                is_promotion: false,
                item_code: null,
                item_code_gsl: null,
                item_codes: [],
                item_price_ranges: [],
                item_unit_types: [],
                item_warehouses: [],
                location: null,
                lot_code: null,
                lots: [],
                lots_enabled: false,
                max_quantity: null,
                max_quantity_description: null,
                model: null,
                month_day: null,
                name: null,
                origin: null,
                percentage_isc: "0.00",
                percentage_of_profit: "0.00",
                percentage_perception: "0.00",
                promotion_count: 0,
                purchase_affectation_igv_type_id: "10",
                purchase_unit_price: "0.00",
                quality: null,
                sale_affectation_igv_type_id: "20",
                sale_unit_price: "0.00",
                second_name: null,
                series_enabled: false,
                stock: "0.00",
                stock_min: "1.00",
                subject_to_detraction: false,
                suggested_price: "0.00",
                system_isc_type_id: null,
                unit_type_id: "GLL",
                warehouse_id: 1,
                warehouse_prices: [],
                warehouses: [],
                weight: "0.00"
            };
            const requests = this.items.map(item => {
                let cleanPurchaseUnitPrice = item.purchase_unit_price;
                if (typeof cleanPurchaseUnitPrice === 'string') {
                    cleanPurchaseUnitPrice = cleanPurchaseUnitPrice.replace(/^S\/\s?/, '').trim();
                }
               
                let updatedWarehousePrices = Array.isArray(item.warehouse_prices) ? item.warehouse_prices.map(wp => {
             
                    if (wp && wp.warehouse_id === 1) {
                        return { ...wp, price: item.sale_unit_price };
                    }
                    return wp;
                }) : [];
                const fullItem = { ...baseItem, ...item, purchase_unit_price: cleanPurchaseUnitPrice, warehouse_prices: updatedWarehousePrices };
                return this.$http.post('/items', fullItem);
            });
            Promise.all(requests)
                .then(() => {
                    this.$message.success('Precios actualizados correctamente');
                    this.getItem();
                    this.$emit('update:dialogTotem', false);
                })
                .catch(() => {
                    this.$message.error('Error al actualizar los precios');
                });
        },

        closeDialog() {
            this.$emit('update:dialogTotem', false);
        }
    }
};
</script>