<template>
    <el-dialog :visible.sync="showDialog" width="95%" :before-close="handleClose" :show-close="true">
        <!-- Header del Dialog -->
        <div slot="title" class="">
            <div class="">
                <h2 class="text-white flex items-center text-2xl font-bold">
                    <i class="fas fa-undo-alt mr-2"></i>
                    Devolución de Productos
                </h2>
            </div>
        </div>
        
        <!-- Formulario de búsqueda con diseño amarillo -->
        <div class="search-section">
            <div class="search-content">
                <div class="search-inputs">
                    <div class="input-group">
                        <label class="input-label">INGRESE SERIE COMPROBANTE</label>
                        <input 
                            type="text" 
                            class="custom-input" 
                            v-model="documentSeries" 
                            placeholder="NV01"
                        />
                    </div>
                    <div class="input-group">
                        <label class="input-label">INGRESE NUMERO COMPROBANTE</label>
                        <input 
                            type="text" 
                            class="custom-input" 
                            v-model="documentNumber" 
                            placeholder="89"
                        />
                    </div>
                    <div class="search-button-container">
                        <el-button 
                            type="primary" 
                            class="search-btn" 
                            @click="search"
                            size="medium"
                        >
                            Buscar
                        </el-button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Información del documento con diseño azul -->
        <div class="document-info-section" v-if="documentInfo">
            <div class="document-header">
                <div class="document-header-content">
                    <i class="fas fa-file-invoice-dollar document-icon"></i>
                    <h3 class="document-title">Detalles del Documento</h3>
                </div>
            </div>
            
            <div class="document-details">
                <!-- Fila superior -->
                <div class="details-row">
                    <div class="detail-item">
                        <label class="detail-label">TIPO DE DOCUMENTO</label>
                        <div class="detail-value">{{ documentInfo.document_type }}</div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">SERIE - NUMERO</label>
                        <div class="detail-value">{{ documentInfo.series }} - {{ documentInfo.number }}</div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">FECHA DE EMISIÓN</label>
                        <div class="detail-value">{{ new Date(documentInfo.date_of_issue).toLocaleDateString('es-PE', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        }) }}</div>
                    </div>
                    <div class="detail-item total-item">
                        <label class="detail-label">IMPORTE TOTAL</label>
                        <div class="total-value">S/ {{ parseFloat(documentInfo.total).toFixed(2) }}</div>
                    </div>
                </div>
                
                <!-- Fila inferior -->
                <div class="details-row">
                    <div class="detail-item client-item">
                        <label class="detail-label">CLIENTE</label>
                        <div class="detail-value">{{ documentInfo.customer_name }}</div>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">DOCUMENTO DEL CLIENTE</label>
                        <div class="detail-value">{{ documentInfo.customer_number }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Productos del documento con diseño azul -->
        <div class="products-section" v-if="items.length > 0">
            <div class="products-header">
                <div class="products-header-content">
                    <i class="fas fa-box-open products-icon"></i>
                    <h3 class="products-title">Productos del Documento</h3>
                </div>
            </div>
            
            <div class="products-content">
                <div class="products-table-container">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th class="desc-column">Descripción</th>
                                <th class="qty-column">Cantidad</th>
                                <th class="price-column">Precio Unitario</th>
                                <th class="total-column">Total</th>
                                <th class="size-color-column">Talla/Color/Lote</th>
                                <th class="stock-column">Stock</th>
                                <th class="action-column">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="item in items">
                                <!-- Si el item tiene color_size, mostrar cada talla/color por separado -->
                                <template v-if="item.item && item.item.color_size && item.item.color_size.length > 0">
                                    <tr v-for="(colorSize, index) in item.item.color_size" :key="`${item.id}-color-${index}`"
                                        :class="{ 'sub-row': index > 0 }">
                                        <td class="item-desc">
                                            <div v-if="index === 0" class="product-info">
                                                <div class="product-id">{{ item.internal_id }}</div>
                                                <div class="product-name">{{ item.description }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ index === 0 ? parseFloat(item.quantity).toFixed(2) : '' }}</td>
                                        <td class="text-center">{{ index === 0 ? 'S/ ' + parseFloat(item.unit_price).toFixed(2) : '' }}</td>
                                        <td class="text-center">{{ index === 0 ? 'S/ ' + parseFloat(item.total).toFixed(2) : '' }}</td>
                                        <td>
                                            <div class="size-color-info">
                                                <span class="size-text">Talla: {{ colorSize.size }}</span>
                                                <span class="color-text">Color: {{ colorSize.color }}</span>
                                                <span class="price-text">Precio: S/ {{ parseFloat(colorSize.price).toFixed(2) }}</span>
                                                <span class="code-text">Código: {{ colorSize.code }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="stock-value">{{ colorSize.stock }}</div>
                                        </td>
                                        <td class="text-center">
                                            <el-button 
                                                size="mini" 
                                                class="add-btn" 
                                                @click="returnColorSize(item, colorSize)"
                                            >
                                                Agregar
                                            </el-button>
                                        </td>
                                    </tr>
                                </template>
                                <!-- Si el item tiene lots, mostrar cada lote por separado -->
                                <template v-else-if="item.item && item.item.lots && item.item.lots.length > 0">
                                    <tr v-for="(lot, index) in item.item.lots" :key="`${item.id}-lot-${index}`"
                                        :class="{ 'sub-row': index > 0 }">
                                        <td class="item-desc">
                                            <div v-if="index === 0" class="product-info">
                                                <div class="product-id">{{ item.internal_id }}</div>
                                                <div class="product-name">{{ item.description }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ index === 0 ? parseFloat(item.quantity).toFixed(2) : '' }}</td>
                                        <td class="text-center">{{ index === 0 ? 'S/ ' + parseFloat(item.unit_price).toFixed(2) : '' }}</td>
                                        <td class="text-center">{{ index === 0 ? 'S/ ' + parseFloat(item.total).toFixed(2) : '' }}</td>
                                        <td>
                                            <div class="lot-info">
                                                <!-- <span class="lot-text">Lote: {{ lot.lot_code }}</span> -->
                                                <span class="series-text">Serie: {{ lot.series }}</span>
                                                <span class="date-text">Fecha: {{ lot.date }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="stock-value">1</div>
                                        </td>
                                        <td class="text-center">
                                            <el-button 
                                                size="mini" 
                                                class="add-btn" 
                                                @click="returnLot(item, lot)"
                                            >
                                                Agregar
                                            </el-button>
                                        </td>
                                    </tr>
                                </template>
                                <!-- Si no tiene color_size ni lots, mostrar el item normal -->
                                <tr v-else :key="item.id">
                                    <td class="item-desc">
                                        <div class="product-info">
                                            <div class="product-id">{{ item.internal_id }}</div>
                                            <div class="product-name">{{ item.description }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ parseFloat(item.quantity).toFixed(2) }}</td>
                                    <td class="text-center">S/ {{ parseFloat(item.unit_price).toFixed(2) }}</td>
                                    <td class="text-center">S/ {{ parseFloat(item.total).toFixed(2) }}</td>
                                    <td>
                                        <span class="no-variants-badge">Sin variantes</span>
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">
                                        <el-button 
                                            size="mini" 
                                            class="add-btn" 
                                            @click="returnItem(item)"
                                        >
                                            Agregar
                                        </el-button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Lista de productos para devolución -->
        <div class="card" v-if="returnItems.length > 0">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Productos Seleccionados para Devolución</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Talla/Color/Lote</th>
                            <th>Cantidad a Devolver</th>
                            <th>Precio Unit.</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(returnItem, index) in returnItems" :key="index">
                            <td>{{ returnItem.internal_id }}</td>
                            <td>{{ returnItem.description }}</td>
                            <td>
                                <span v-if="returnItem.color_size" class="badge"
                                    style="background-color: #28a745; color: white; font-weight: bold;">
                                    {{ returnItem.color_size.size }} - {{ returnItem.color_size.color }}
                                </span>
                                <span v-else-if="returnItem.lot" class="badge"
                                    style="background-color: #3b82f6; color: white; font-weight: bold;">
                                    Lote: {{ returnItem.lot.lot_code }} - Serie: {{ returnItem.lot.series }}
                                </span>
                                <span v-else class="badge badge-secondary">Sin variantes</span>
                            </td>
                            <td>
                                <el-input-number v-model="returnItem.quantity_to_return" controls-position="right"
                                    :min="1" :max="returnItem.max_quantity"
                                    @change="validateQuantity(returnItem)"></el-input-number>
                                <small class="text-muted d-block">Máximo: {{ returnItem.max_quantity }}</small>
                            </td>
                            <td>S/ {{ parseFloat(
                                (returnItem.color_size && returnItem.color_size.price) ? 
                                    returnItem.color_size.price : 
                                    (returnItem.lot && returnItem.lot.price) ? 
                                        returnItem.lot.price : 
                                        returnItem.unit_price
                            ).toFixed(2) }}</td>
                            <td>S/ {{ (returnItem.quantity_to_return * parseFloat(
                                (returnItem.color_size && returnItem.color_size.price) ? 
                                    returnItem.color_size.price : 
                                    (returnItem.lot && returnItem.lot.price) ? 
                                        returnItem.lot.price : 
                                        returnItem.unit_price
                            )).toFixed(2) }}</td>
                            <td>
                                <el-button size="mini" type="danger" @click="removeFromReturn(index)">
                                    <i class="fa fa-trash"></i>
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-info">
                            <td colspan="5" class="text-right"><strong>Total a Devolver:</strong></td>
                            <td><strong>S/ {{ calculateTotal() }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-right mt-3">
                    <el-button type="success" @click="processDevolution" :disabled="returnItems.length === 0">
                        <i class="fa fa-check"></i> Procesar Devolución
                    </el-button>
                </div>
            </div>
        </div>

        <div class="card" v-if="items.length === 0 && documentInfo === null">
            <div class="card-body text-center">
                <p class="text-muted">Ingrese los datos del documento y haga clic en "Buscar" para ver los productos
                    disponibles
                    para devolución.</p>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: {
        showDialog: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            title: "Devolución de Productos",
            documentSeries: "",
            documentNumber: "",
            clientId: null,
            clients: [],
            loadingClients: false,
            items: [],
            documentInfo: null,
            returnItems: [] // Items seleccionados para devolución
        };
    },
    methods: {
        search() {
            if (!this.documentSeries || !this.documentNumber) {
                this.$message.warning('Por favor ingrese la serie y número del documento');
                return;
            }

            const searchData = {
                series: this.documentSeries,
                number: this.documentNumber
            };

            axios.post('/devolutions/search', searchData)
                .then(response => {
                    // Manejar la respuesta exitosa
                    console.log('Resultado de búsqueda:', response.data);

                    if (response.data.success) {
                        this.documentInfo = response.data.document;
                        this.items = response.data.items || [];
                        this.$message.success('Documento encontrado exitosamente');
                    } else {
                        this.$message.error('No se encontró el documento');
                        this.items = [];
                        this.documentInfo = null;
                    }
                })
                .catch(error => {
                    console.error('Error en la búsqueda:', error);
                    this.$message.error('Error al buscar el documento');
                    this.items = [];
                    this.documentInfo = null;
                });
        },
        returnColorSize(item, colorSize) {
            // Crear objeto de devolución para item con talla/color específico
            const stockTallaColor = colorSize.stock || 0; // Stock específico de la talla/color

            if (stockTallaColor <= 0) {
                this.$message.warning(`No hay stock disponible para Talla: ${colorSize.size} Color: ${colorSize.color}`);
                return;
            }

            const returnItem = {
                id: item.id,
                description: item.description,
                internal_id: item.internal_id,
                unit_price: colorSize.price || item.unit_price, // Usar precio específico de talla/color
                quantity_to_return: 1, // Cantidad a devolver (editable)
                max_quantity: stockTallaColor, // Cantidad máxima basada en stock de talla/color
                color_size: {
                    id: colorSize.id,
                    code: colorSize.code,
                    size: colorSize.size,
                    color: colorSize.color,
                    stock: colorSize.stock,
                    price: colorSize.price
                },
                type: 'color_size'
            };

            // Verificar si ya está en la lista
            const existingIndex = this.returnItems.findIndex(ri =>
                ri.id === item.id && ri.color_size && ri.color_size.id === colorSize.id
            );

            if (existingIndex >= 0) {
                this.$message.warning('Este producto con esa talla/color ya está en la lista de devolución');
                return;
            }

            this.returnItems.push(returnItem);
            this.$message.success(`Producto agregado - Stock disponible para devolución: ${stockTallaColor}`);
        },
        returnItem(item) {
            // Crear objeto de devolución para item sin variantes
            const returnItem = {
                id: item.id,
                description: item.description,
                internal_id: item.internal_id,
                unit_price: item.unit_price,
                quantity_to_return: parseFloat(item.quantity),
                max_quantity: parseFloat(item.quantity),
                type: 'simple'
            };

            // Verificar si ya está en la lista
            const existingIndex = this.returnItems.findIndex(ri =>
                ri.id === item.id && ri.type === 'simple'
            );

            if (existingIndex >= 0) {
                this.$message.warning('Este producto ya está en la lista de devolución');
                return;
            }

            this.returnItems.push(returnItem);
            this.$message.success('Producto agregado a la lista de devolución');
        },
        returnLot(item, lot) {
            // Crear objeto de devolución para item con lote específico
            const returnItem = {
                id: item.id,
                description: item.description,
                internal_id: item.internal_id,
                unit_price: item.unit_price,
                quantity_to_return: 1, // Los lotes generalmente son cantidad fija de 1
                max_quantity: 1, // Máximo 1 por lote/serie
                lot: {
                    id: lot.id,
                    lot_code: lot.lot_code,
                    series: lot.series,
                    date: lot.date
                },
                type: 'lot'
            };

            // Verificar si ya está en la lista
            const existingIndex = this.returnItems.findIndex(ri =>
                ri.id === item.id && ri.lot && ri.lot.id === lot.id
            );

            if (existingIndex >= 0) {
                this.$message.warning('Este producto con ese lote/serie ya está en la lista de devolución');
                return;
            }

            this.returnItems.push(returnItem);
            this.$message.success('Producto con lote agregado a la lista de devolución');
        },
        removeFromReturn(index) {
            this.returnItems.splice(index, 1);
            this.$message.success('Producto removido de la lista de devolución');
        },
        processDevolution() {
            if (this.returnItems.length === 0) {
                this.$message.warning('Debe seleccionar al menos un producto para devolver');
                return;
            }

            // Mapear cada returnItem al formato de inventario solicitado
            const mappedItems = this.returnItems.map(item => {
                // Si es un item con talla/color, enviar la estructura con color_size dentro de un arreglo
                if (item.type === 'color_size' || (item.color_size && Object.keys(item.color_size).length > 0)) {
                    return {
                        id: null,
                        item_id: item.id,
                        warehouse_id: 1,
                        inventory_transaction_id: "05",
                        quantity: item.quantity_to_return,
                        type: "input",
                        color_size: [
                            {
                                color: item.color_size.color,
                                size: item.color_size.size,
                                stock: item.quantity_to_return,
                                price: item.color_size.price,
                                code: item.color_size.code
                            }
                        ],
                        date_of_due: null,
                        has_color_size: true,
                        lot_code: null,
                        lots: [],
                        lots_enabled: false,
                        series_enabled: false
                    };
                }
                
                // Si es un item con lote, enviar la estructura con lots dentro de un arreglo
                if (item.type === 'lot' || (item.lot && Object.keys(item.lot).length > 0)) {
                    return {
                        id: null,
                        item_id: item.id,
                        warehouse_id: 1,
                        inventory_transaction_id: "05",
                        quantity: item.quantity_to_return,
                        type: "input",
                        color_size: [],
                        date_of_due: null,
                        has_color_size: false,
                        lot_code: item.lot.lot_code,
                        lots: [
                            {
                                id: item.lot.id,
                                lot_code: item.lot.lot_code,
                                series: item.lot.series,
                                date: item.lot.date,
                                has_sale: false,
                                state: 'Activo'
                            }
                        ],
                        lots_enabled: true,
                        series_enabled: false
                    };
                }

                // Si es un item simple (sin variantes)
                return {
                    id: null,
                    item_id: item.id,
                    warehouse_id: 1,
                    inventory_transaction_id: "05",
                    quantity: item.quantity_to_return,
                    type: "input",
                    color_size: [],
                    date_of_due: null,
                    has_color_size: false,
                    lot_code: null,
                    lots: [],
                    lots_enabled: false,
                    series_enabled: false
                };
            });

            const devolutionData = {
                document_id: (this.documentInfo && this.documentInfo.id) ? this.documentInfo.id : null,
                document_series: (this.documentInfo && this.documentInfo.series) ? this.documentInfo.series : this.documentSeries,
                document_number: (this.documentInfo && this.documentInfo.number) ? this.documentInfo.number : this.documentNumber,
                items: mappedItems
            };

            console.log('Datos de devolución (inventario):', devolutionData);

            // Enviar al servidor para procesar la devolución
            axios.post('/inventory/transaction-devolution', devolutionData)
                .then(response => {
                    console.log('Respuesta del servidor:', response.data);
                    if (response.data.success) {
                        this.$message.success('Devolución registrada exitosamente');
                        this.returnItems = [];
                        this.$emit('records');
                        this.handleClose();
                    } else {
                        this.$message.error('Error al registrar la devolución: ' + (response.data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    let errorMessage = 'Error al procesar la devolución';
                    if (error.response && error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }
                    this.$message.error(errorMessage);
                });
        },

        validateQuantity(returnItem) {
            if (returnItem.quantity_to_return > returnItem.max_quantity) {
                returnItem.quantity_to_return = returnItem.max_quantity;
                this.$message.warning(`La cantidad máxima disponible es ${returnItem.max_quantity}`);
            }
            if (returnItem.quantity_to_return < 1) {
                returnItem.quantity_to_return = 1;
            }
        },
        calculateTotal() {
            return this.returnItems.reduce((total, item) => {
                let unitPrice = item.unit_price;
                if (item.color_size && item.color_size.price) {
                    unitPrice = item.color_size.price;
                } else if (item.lot && item.lot.price) {
                    unitPrice = item.lot.price;
                }
                return total + (item.quantity_to_return * parseFloat(unitPrice));
            }, 0).toFixed(2);
        },
        handleClose() {
            // Limpiar datos al cerrar
            this.documentSeries = "";
            this.documentNumber = "";
            this.clientId = null;
            this.items = [];
            this.documentInfo = null;
            this.returnItems = [];
            this.$emit('update:showDialog', false);
        },
        fetchClients(query) {
            if (query !== '') {
                this.loadingClients = true;
                // Simulate an API call
                setTimeout(() => {
                    this.clients = [
                        { id: 1, name: 'Cliente A', document_number: '123456' },
                        { id: 2, name: 'Cliente B', document_number: '654321' }
                    ].filter(client => client.name.toLowerCase().includes(query.toLowerCase()));
                    this.loadingClients = false;
                }, 500);
            } else {
                this.clients = [];
            }
        }
    }
};
</script>

<style scoped>
/* Dialog Principal */
.devolution-dialog {
    border-radius: 12px;
    overflow: hidden;
}

.devolution-dialog >>> .el-dialog {
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.devolution-dialog >>> .el-dialog__header {
    padding: 0;
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    flex-shrink: 0;
}

.devolution-dialog >>> .el-dialog__body {
    padding: 0;
    background: #f8fafc;
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1;
    max-height: calc(90vh - 80px);
}

/* Estilo personalizado del scrollbar */
.devolution-dialog >>> .el-dialog__body::-webkit-scrollbar {
    width: 8px;
}

.devolution-dialog >>> .el-dialog__body::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.devolution-dialog >>> .el-dialog__body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    border-radius: 4px;
    transition: background 0.3s ease;
}

.devolution-dialog >>> .el-dialog__body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #1e40af, #2563eb);
}

/* Header del Dialog */
.dialog-header {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    padding: 20px 30px;
    position: relative;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dialog-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
}

.close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Sección de búsqueda amarilla */
.search-section {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    padding: 25px 30px;
}

.search-content {
    max-width: 100%;
}

.search-inputs {
    display: flex;
    gap: 20px;
    align-items: end;
    flex-wrap: wrap;
}

.input-group {
    flex: 1;
    min-width: 200px;
}

.input-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}

.custom-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    background: white;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.custom-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-button-container {
    display: flex;
    align-items: center;
}

.search-btn {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important;
    border: none !important;
    padding: 12px 24px !important;
    font-size: 16px !important;
    font-weight: 600 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3) !important;
    transition: all 0.3s ease !important;
}

.search-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(30, 58, 138, 0.4) !important;
}

/* Información del documento */
.document-info-section {
    margin: 20px 30px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background: white;
}

.document-header {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    padding: 20px 25px;
}

.document-header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.document-icon {
    font-size: 24px;
}

.document-title {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
}

.document-details {
    padding: 25px;
}

.details-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.details-row:last-child {
    margin-bottom: 0;
}

.detail-item {
    flex: 1;
    min-width: 200px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #e5e7eb;
}

.detail-item.total-item {
    border-left-color: #10b981;
    background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
}

.detail-item.client-item {
    flex: 2;
}

.detail-label {
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    margin-bottom: 8px;
    display: block;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    line-height: 1.2;
}

.total-value {
    font-size: 20px;
    font-weight: 800;
    color: #10b981;
    line-height: 1.2;
}

/* Sección de productos */
.products-section {
    margin: 20px 30px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background: white;
}

.products-header {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    padding: 20px 25px;
}

.products-header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.products-icon {
    font-size: 24px;
}

.products-title {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
}

.products-content {
    padding: 0;
}

.products-table-container {
    overflow-x: auto;
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
}

/* Scrollbar para la tabla de productos */
.products-table-container::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.products-table-container::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 3px;
}

.products-table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.products-table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.products-table th {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: #1f2937;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    padding: 15px 12px;
    text-align: center;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e5e7eb;
}

.products-table td {
    padding: 15px 12px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

.products-table tr:hover {
    background: #f8fafc;
}

.products-table tr.sub-row {
    background: #fef3c7;
}

.item-desc {
    text-align: left !important;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.product-id {
    font-weight: 700;
    color: #1e3a8a;
    font-size: 15px;
}

.product-name {
    color: #374151;
    font-size: 13px;
    line-height: 1.3;
}

.size-color-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
    text-align: left;
}

.lot-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
    text-align: left;
}

.size-text, .color-text, .price-text, .code-text, .lot-text, .series-text, .date-text {
    font-size: 12px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 4px;
    display: inline-block;
}

.size-text {
    background: #dbeafe;
    color: #1e40af;
}

.color-text {
    background: #fef3c7;
    color: #92400e;
}

.price-text {
    background: #dcfce7;
    color: #166534;
}

.code-text {
    background: #f3e8ff;
    color: #7c3aed;
}

.lot-text {
    background: #e0e7ff;
    color: #3730a3;
}

.series-text {
    background: #ecfeff;
    color: #155e75;
}

.date-text {
    background: #f1f5f9;
    color: #475569;
}

.stock-value {
    font-weight: 700;
    color: #059669;
    font-size: 16px;
}

.add-btn {
    background: linear-gradient(135deg, #dc2626, #ef4444) !important;
    border: none !important;
    color: white !important;
    font-weight: 600 !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3) !important;
    transition: all 0.3s ease !important;
}

.add-btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4) !important;
}

.no-variants-badge {
    background: #f3f4f6;
    color: #6b7280;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.text-center {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .search-inputs {
        flex-direction: column;
    }
    
    .input-group {
        min-width: 100%;
    }
    
    .details-row {
        flex-direction: column;
    }
    
    .detail-item {
        min-width: 100%;
    }
    
    .products-table th,
    .products-table td {
        padding: 10px 8px;
        font-size: 12px;
    }
}
</style>