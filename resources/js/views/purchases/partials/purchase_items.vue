<template>
    <el-dialog :title="title" :visible.sync="showDialog" width="70%" :before-close="close">
        <div class="row mb-2">
            <div class="col-4">
                <div class="col-12">
                    <el-button class="btn_guardarsmall" type="primary" @click.prevent="
                        $refs.file.click()
                        ">Cargar Archivo
                        <i class="fas fa-file-excel"></i>
                    </el-button>
                    <input type="file" @change="
                        ImportItems
                    " style="visibility:hidden;" ref="file" accept=".xlsx,.xls" />

                    

                </div>
            </div>
            <div class="col-4">
                <a href="/formats/purchase_items.xlsx" download>
                        <i class="el-icon-download"></i>
                        Descargar AQUÍ el formato

                    </a>
            </div>
            <div class="col-">
                <div class="col-4 d-flex justify-content-end">
                    <!-- <el-button class="btn_cancelarsmall" type="primary" @click="close">Cerrar</el-button> -->
                    <!-- <el-button class="btn_guardarsmall" type="primary" @click="close">Agregar</el-button> -->
                </div>
            </div>

        </div>

        
        <!-- <div v-if="items.length > 0" class="mt-4">
            <el-table :data="items" style="width: 100%">
                <el-table-column prop="id" label="ID del producto" />
                <el-table-column prop="internal_id" label="ID Interno" />
                <el-table-column prop="description" label="Descripción" />
                <el-table-column prop="stock" label="Stock" />
                <el-table-column prop="unit_type_id" label="Unidad" />
                <el-table-column prop="purchase_unit_price" label="Precio Compra" />
                <el-table-column prop="warehouse_id" label="Almacén" />
                <el-table-column prop="sale_unit_price" label="Precio Venta" />
                <el-table-column prop="affectation_igv_type_id" label="Afectación IGV" />
                
            </el-table>
        </div> -->
    
    </el-dialog>
</template>
<script>
import readXlsxFile from 'read-excel-file'
import { calculateRowItem } from "../../../helpers/functions";

export default {
    name: "PurchaseItems",
    props: ["showDialog", "form", "affectation_igv_types",
        "currencyTypeIdActive", "exchangeRateSale", "includes", "percentage_igv"
    ],
    data() {
        return {
            title: "Importar Items de Compra",
            items: [],
            localForm: { ...this.form }
        };
    },
    methods: {
        close() {
            
            this.$emit("update:showDialog", false);
        },

        ImportItems(event) {
            let file = event.target.files[0];
            readXlsxFile(file).then(async rows => {
                console.log('Archivo leído, filas:', rows);
                rows.shift(); // quitar cabecera

                // 1. Armar lista de ids y demás campos
                let excelItems = rows.map(row => ({
                    internal_id: row[0],
                    quantity: row[1],
                    unit_type_id: row[2],
                    purchase_unit_price: Number(row[3]) || 0,
                    warehouse_id: row[4],
                    sale_unit_price: row[5],
                    affectation_igv_type_id: row[6]
                }));

                let ids = excelItems.map(i => i.internal_id);

                // Función para dividir en bloques de 60
                function chunkArray(array, size) {
                    const result = [];
                    for (let i = 0; i < array.length; i += size) {
                        result.push(array.slice(i, i + size));
                    }
                    return result;
                }

                let idChunks = chunkArray(ids, 60);
                let allProducts = [];

                try {
                    // 2. Consultas en bloques al server
                    for (let chunk of idChunks) {
                        let response = await this.$http.post(`/items/records-by-ids`, { ids: chunk });
                        let products = Array.isArray(response.data.data) ? response.data.data : response.data.items || [];
                        allProducts = allProducts.concat(products);
                    }

                    let validItems = [];
                    let notFoundItems = [];

                    for (let item of excelItems) {
                        let found = allProducts.find(p => String(p.internal_id) === String(item.internal_id));
                        if (found) {
                            // Adecuar el formulario para cada item y procesar por clickAddItem
                            // Buscar el almacén correcto por ID
                            let warehouse = Array.isArray(this.warehouses)
                                ? this.warehouses.find(w => String(w.id) === String(item.warehouse_id))
                                : null;

                            // Buscar el tipo de afectación IGV correcto
                            let affectation_igv_type = Array.isArray(this.affectation_igv_types)
                                ? this.affectation_igv_types.find(t => String(t.id) === String(item.affectation_igv_type_id))
                                : {};

                            // Determinar el IGV correcto
                            let percentage_igv = Number(found.percentage_igv);
                            if (isNaN(percentage_igv) || percentage_igv === 0) {
                                percentage_igv = Number(this.percentage_igv) || 18;
                            }

                            this.localForm = {
                                item_id: found.id,
                                item: {
                                    ...found,
                                    ...item,
                                    lots_enabled: typeof found.lots_enabled === 'boolean' ? found.lots_enabled : false
                                },
                                quantity: Number(item.quantity) || 0,
                                unit_type_id: item.unit_type_id || '',
                                purchase_unit_price: Number(item.purchase_unit_price) || 0,
                                unit_price: Number(item.purchase_unit_price) || 0,
                                warehouse_id: warehouse ? warehouse.id : item.warehouse_id || null,
                                warehouse_description: warehouse ? warehouse.description : '',
                                sale_unit_price: Number(item.sale_unit_price) || 0,
                                affectation_igv_type_id: item.affectation_igv_type_id || '',
                                affectation_igv_type: affectation_igv_type,
                                discounts: Array.isArray(found.discounts) ? found.discounts : [],
                                charges: Array.isArray(found.charges) ? found.charges : [],
                                attributes: Array.isArray(found.attributes) ? found.attributes : [],
                                name_product_pdf: found.name_product_pdf || '',
                                input_unit_price_value: Number(found.input_unit_price_value) || 0,
                                has_isc: !!found.has_isc,
                                system_isc_type_id: found.system_isc_type_id || null,
                                percentage_isc: Number(found.percentage_isc) || 0,
                                record_id: found.record_id || found.id || null,
                                id: found.id || null,
                                total_price: Number(item.quantity) * Number(item.purchase_unit_price) || 0,
                                color_size: Array.isArray(found.color_size) ? found.color_size : [],
                                lots: Array.isArray(found.lots) ? found.lots : [],
                                lots_group: Array.isArray(found.lots_group) ? found.lots_group : [],
                                date_of_due: found.date_of_due || null,
                                lot_code: found.lot_code || null,
                                purchase_has_igv: typeof found.purchase_has_igv === 'boolean' ? found.purchase_has_igv : true,
                                purchase_unit_value: Number(found.purchase_unit_value) || 0,
                                currency_type_id: found.currency_type_id || 'PEN',
                                sale_unit_price: Number(item.sale_unit_price) || 0,
                                percentage_igv: percentage_igv,
                                price_type_id: found.price_type_id || '01',
                                original_unit_price: Number(found.original_unit_price) || Number(item.purchase_unit_price) || 0,
                                original_includes_state: typeof found.original_includes_state === 'boolean' ? found.original_includes_state : true,
                            };
                            // Si necesitas inicializar otros campos como color_size, lots, etc., hazlo aquí
                            // Ejemplo:
                            this.color_size = [];
                            this.lots = [];
                            // Procesar el item por clickAddItem
                            await this.clickAddItem();
                            // Mostrar la cantidad importada como 'stock' en la tabla
                            validItems.push({
                                ...found,
                                ...item,
                                stock: item.quantity, // Sobrescribe el stock con la cantidad importada
                                warehouse_id: warehouse ? warehouse.id : item.warehouse_id || null,
                                warehouse_description: warehouse ? warehouse.description : '',
                                affectation_igv_type: affectation_igv_type,
                                percentage_igv: percentage_igv
                            });
                        } else {
                            notFoundItems.push(item.internal_id);
                        }
                    }

                    // 3. Mostrar errores si hay
                    if (notFoundItems.length > 0) {
                        this.$message.error(
                            `Los siguientes productos no existen: ${notFoundItems.join(', ')}`
                        );
                        return;
                    }

                    // 4. Emitir al padre si lo necesitas
                    // this.$emit('items-imported-all', validItems);
                    console.log('Productos válidos para importar:', validItems);
                    // 5. Mostrar en tabla local
                    this.items = validItems;

                    // Limpiar formulario
                    this.localForm = {};
                    // Emitir cambios al padre
                    this.$emit('update:form', this.localForm);
                    // Cerrar el modal
                    this.$emit("update:showDialog", false);
                    // Mostrar mensaje de éxito
                    return this.$showSAlert(
                        "Éxito",
                        "Archivo Excel cargado correctamente.",
                        "success"
                    );

                } catch (error) {
                    console.error('Error en importación (catch):', error);
                    if (error.response) {
                        console.error('Respuesta del servidor en catch:', error.response);
                        this.$message.error(`Error al validar productos: ${error.response.data && error.response.data.message ? error.response.data.message : 'Ver consola para detalles.'}`);
                    } else {
                        this.$message.error("Error al validar productos");
                    }
                }
            });
        },

        async clickAddItem() {
            if (!this.localForm.item_id || !this.localForm.item) {
                return this.$showSAlert(
                    "Alerta",
                    "Debe seleccionar un producto para poder agregar.",
                    "error"
                );
            }
            // Validación de total en 0
            if (
                this.localForm.total_price === 0 ||
                this.localForm.total_price === null ||
                this.localForm.total_price === undefined
            ) {
                // Igualar precio de compra al purchase_unit_price del item importado
                if (this.localForm.item && this.localForm.item.purchase_unit_price) {
                    this.localForm.unit_price = this.localForm.item.purchase_unit_price;
                    this.localForm.purchase_unit_price = this.localForm.item.purchase_unit_price;
                }
                return Swal.fire(
                    "No se puede agregar un Producto o Servicios con Valor 0"
                );
            }
            this.insertTotalPrice = false;

            // Validation for color and size
            if (this.localForm.item.has_color_size && this.color_size.length === 0) {
                return this.$showSAlert(
                    "Alerta",
                    "Debe agregar al menos un color y talla para poder realizar la Compra",
                    "error"
                );
            }

            // Validation for lots
            /* if (this.localForm.item.lots_enabled && this.lots.length === 0) {
                    return this.$toast.error("Debe agregar al menos un lote para poder realizar la compra.");
                } */

            // Validation for series
            if (this.localForm.item.series_enabled) {
                if (this.lots.length > this.localForm.quantity) {
                    // return this.$toast.error("La cantidad de series registradas es superior al stock");
                    return this.$showSAlert(
                        "Alerta",
                        "La cantidad de series registradas es superior al stock",
                        "error"
                    );
                }

                if (this.lots.length != this.localForm.quantity) {
                    // return this.$toast.error(
                    //     "La cantidad de series registradas son diferentes al stock"
                    // );
                    return this.$showSAlert(
                        "Alerta",
                        "La cantidad de series registradas son diferentes al stock",
                        "error"
                    );
                }
            }

            let date_of_due = this.localForm.date_of_due;
            this.localForm.item.unit_price = this.localForm.unit_price;
            this.localForm.item.presentation = this.item_unit_type;
            // Buscar el tipo de afectación IGV correctamente (string vs número)
            let affectation_igv_type = Array.isArray(this.affectation_igv_types)
                ? this.affectation_igv_types.find(t => String(t.id) === String(this.localForm.affectation_igv_type_id))
                : {};
            this.localForm.affectation_igv_type = affectation_igv_type || {};

            // Determinar el IGV correcto
            let percentage_igv = Number(affectation_igv_type && affectation_igv_type.percentage_igv)
                ? Number(affectation_igv_type.percentage_igv)
                : Number(this.percentage_igv) || 18;
            this.localForm.percentage_igv = percentage_igv;

            this.row = await calculateRowItem(
                this.localForm,
                this.currencyTypeIdActive,
                this.exchangeRateSale,
                this.includes,
                "documents",
                false,
                percentage_igv
            );

            // Limpiar NaN en campos numéricos importantes
            const numericFields = [
                'total_value',
                'total_value_without_rounding',
                'total_without_rounding',
                'unit_price',
                'unit_price_igv',
                'total',
                'total_base_igv',
                'total_base_igv_without_rounding',
                'total_base_isc',
                'total_base_other_taxes',
                'total_charge',
                'total_discount',
                'total_igv',
                'total_igv_without_rounding',
                'total_isc',
                'total_other_taxes',
                'total_plastic_bag_taxes',
                'total_taxes',
                'total_taxes_without_rounding',
                'total_price',
                'purchase_unit_price',
                'sale_unit_price',
                'purchase_unit_value',
                'input_unit_price_value',
                'original_unit_price',
                'percentage_igv',
                'percentage_isc',
                'percentage_other_taxes',
                'unit_value'
            ];
            numericFields.forEach(field => {
                if (typeof this.row[field] !== 'undefined' && isNaN(this.row[field])) {
                    this.row[field] = 0;
                }
            });
            if (this.noIsUnid) {
                this.row.real_quantity = this.localForm.real_quantity;
                this.row.max_quantity = this.unids;
                this.row.max_quantity_description = this.localForm.max_quantity_description;
            }
            this.row.sale_unit_price = this.localForm.sale_unit_price;
            this.row.lot_code = await this.lot_code;
            this.row.lots_group = await this.lotsGroup;
            this.row.item.lots_group = await this.lotsGroup;
            this.row.lots = await this.lots;
            this.row.item.lots = await this.lots;
            this.row.color_size = this.color_size;
            this.row.item.color_size = this.color_size;

            this.row = this.changeWarehouse(this.row);

            this.row.date_of_due = date_of_due;

            this.unids = 0;
            this.noIsUnid = false;
            this.input_barcode = null;
            if (this.barcode_lector) {
                this.$refs.input_barcode.focus();
            }
            // Emitir cambios al padre
            this.$emit('update:form', this.localForm);
            this.$emit("add", this.row);
            console.log('Item agregado:', this.row);
            this.colorSizeImported = false;
        },
        changeWarehouse(row) {
            // Protege si no hay almacenes o el almacén no existe
            // Usar el warehouse_id que viene del Excel (row.warehouse_id)
            let warehouseId = row.warehouse_id || null;
            let warehouse = Array.isArray(this.warehouses)
                ? _.find(this.warehouses, { id: warehouseId })
                : null;
            if (warehouse && warehouse.id) {
                row.warehouse_id = warehouse.id;
                row.warehouse_description = warehouse.description || '';
            } else {
                // Si no se encuentra el almacén, deja los datos como están
                row.warehouse_id = warehouseId;
                row.warehouse_description = '';
            }
            return row;
        },

    }
}
</script>
