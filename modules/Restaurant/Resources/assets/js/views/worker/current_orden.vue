<template>
    <div v-loading="loading" class="orden-container">
        <observation-form :current="current" :observations.sync="tags" :showDialog.sync="showObservations"
            :configuration="configuration" :ordenId="currentOrden" @addObservation="addObservation"></observation-form>
        <el-dialog key="db" v-loading="loadingObservation" @close="closeLocalObservationDialog"
            :visible="dialogObservation" append-to-body title="Editando observación">
            <label class="control-label">Observación</label>
            <el-input v-model="observation"></el-input>
            <div class="row mt-1 d-flex flex-row justify-content-end">
                <button class="btn btn-sm btn-primary" @click="changeObservation">
                    Cambiar
                </button>
            </div>
        </el-dialog>

        <template>
            <open-items :showDialog.sync="showOpenOrden" :localOrden="localOrden" />
            <Pinform @sendOrden="sendOrden" :showDialogPing.sync="showDialogPing" :to_carry.sync="to_carry"
                :configuration.sync="configuration" :ordenSelectedId.sync="ordenSelectedId" :tableId.sync="tableId"
                :localOrden.sync="localOrden" @add="closeDialog" :referencia="referenciaInput"></Pinform>
        </template>

        <div id="ordens" class="ordens-wrapper">
            <div class="header-section bg-primary rounded-top">
                <!-- Header Title y Total -->
                <div class="header-title-row">
                    <span class="title-text text-white">
                        Lista de Ordenes
                    </span>
                    <div v-if="ordens.length > 0 || localOrden.length > 0" class="total-text">
                        TOTAL S/ {{ total.toFixed(2) }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons-row">
                    <el-button-group class="button-group-responsive">
                        <el-button v-if="localOrden.length != 0 && table.is_delivery !== '1'"
                            :class="to_carry ? 'btn_excelsmall' : 'btn_disabledsmall'" size="mini"
                            @click="to_carry = !to_carry; allToCarry(); playClickSound();">
                            <i class="fas fa-biking"></i>
                            <b class="btn-text-hide-mobile">{{ to_carry ? "Sí" : "No" }}</b>
                        </el-button>

                        <template v-if="table && table.is_delivery === '1' && ordens.length === 0">
                            <el-tooltip effect="dark" content="Delivery" placement="top-start">
                                <el-button v-if="localOrden.length != 0" type="success" class="btn_excelsmall"
                                    @click="openDelivery">
                                    <i class="fas fa-biking"></i>
                                </el-button>
                            </el-tooltip>
                        </template>
                        <template v-else>
                            <el-tooltip effect="dark" content="Enviar ordenes" placement="top-start">
                                <el-button v-if="localOrden.length != 0" class="btn_excelsmall"
                                    @click="playClickSound(); submit();" :disabled="disableEnviarOrdenes">
                                    <i class="el-icon-s-promotion"></i>
                                    <span class="btn-text-hide-mobile">Enviar</span>
                                </el-button>
                            </el-tooltip>
                        </template>

                        <el-tooltip effect="dark" content="Imprimir Precuenta en caja" placement="top-start">
                            <el-button type="success" class="btn_excelsmall" @click="playClickSound(); printTicketPos()"
                                v-if="configuration.print_pos_worker && ordens.length > 0">
                                <i class="icofont-printer"></i>
                            </el-button>
                        </el-tooltip>
                        <el-tooltip effect="dark" content="re-Imprimir comanda sus respectivas areas" placement="top-start">
                            <el-button type="warning" class="btn_excelsmall"
                                @click="playClickSound(); printTicketRePrint()" v-if="ordens.length > 0">
                                <i class="icofont-printer"></i>
                                PC
                            </el-button>
                        </el-tooltip>
                        <el-tooltip effect="dark" content="re-Imprimir comanda en caja" placement="top-start">
                            <el-button v-if="configuration.re_printer && ordens.length > 0" type="sucess"
                                class="btn_excelsmall" @click="playClickSound(); printTicket()">
                                <i class="icofont-printer"></i>
                                
                            </el-button>
                        </el-tooltip>
                        <el-tooltip effect="dark" content="Imprimir ticket en cocina" placement="top-start">
                            <el-button v-if="configuration.pdf_preorder && ordens.length > 0" type="info"
                                @click="playClickSound(); printTicketPdf()" class="btn_pdfsmall">
                                <i class="icofont-printer"></i>
                                <span class="btn-text-hide-mobile">PDF</span>
                            </el-button>
                        </el-tooltip>

                        <el-tooltip effect="dark" content="Cancelar orden" placement="top-start">
                            <el-button v-if="configuration.delete_mozo && ordens.length > 0" type="danger"
                                @click="playClickSound(); cancelGeneralOrden()" class="btn_cancelarsmall">
                                <i class="el-icon-delete"></i>
                            </el-button>
                        </el-tooltip>
                    </el-button-group>
                </div>

                <!-- Mozo Selection -->
                <template v-if="configuration && configuration.seller_mozo">
                    <div class="mozo-selection-row">
                        <label class="mozo-label text-white">Seleccione Mozo <span class="text-danger">*</span></label>
                        <el-select v-model="selectedMozo" placeholder="Seleccione un mozo" @change="updateMozo"
                            clearable class="mozo-select">
                            <el-option v-for="mozo in mozos" :key="mozo.id" :label="mozo.name" :value="mozo.id">
                            </el-option>
                        </el-select>
                    </div>
                </template>

                <!-- Referencia Input -->
                <div v-if="ordens.length > 0 || localOrden.length > 0" class="referencia-row">
                    <el-input v-model="referenciaInput" placeholder="Referencia (DNI)"></el-input>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="ordens.length == 0 && localOrden.length == 0" class="empty-state">
                <i class="el-icon-box" style="font-size: 48px; color: #ccc;"></i>
                <p>Lista Vacía</p>
            </div>

            <!-- Lista de Ordenes -->
            <div class="products-list">
                <!-- POR SOLICITAR -->
                <div v-if="localOrden.length != 0" class="section-orders">
                    <div class="section-header">
                        <div class="section-title">
                            <p class="h4 txt-info txt-primary f-w-700 mb-1">
                                <i class="icofont icofont-fork-and-knife"></i>
                                <span class="badge bg-dark text-white">
                                    <template v-if="localOrden.length > 0 && localOrden.length <= 9">
                                        0{{ localOrden.length }}
                                    </template>
                                    <template v-else>
                                        {{ localOrden.length }}
                                    </template>
                                </span>
                                Por Solicitar
                            </p>
                        </div>
                        <div v-if="configuration.divided_items" class="section-checkbox">
                            <el-checkbox v-model="localDividedItems" @change="saveDividedItemsLocalStorage">
                                <span class="checkbox-text">Dividir Pedidos Iguales</span>
                            </el-checkbox>
                        </div>
                    </div>

                    <!-- Cards de ordenes locales -->
                    <div class="order-card" v-for="(order_pend, idx) in localOrden" :key="idx">
                        <div class="card-content">
                            <!-- Imagen -->
                            <div class="card-image" v-if="order_pend.food.image != 'imagen-no-disponible.jpg'">
                                <img :src="formatUrlImage(order_pend.food.image)" alt="Product" class="product-img" />
                            </div>

                            <!-- Info del producto -->
                            <div class="card-info">
                                <div class="product-name">
                                    {{ order_pend.food.description.toUpperCase() }}
                                    <span v-if="order_pend.type_id" class="text-primary">
                                        <small><strong>*{{ order_pend.type_description }}</strong></small>
                                    </span>
                                </div>

                                <div class="product-controls">
                                    <!-- Quantity and Price -->
                                    <div class="quantity-price-section">
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <input type="text"
                                                :disabled="order_pend.food.item.is_set && !configuration.item_set_quantity_pos"
                                                class="form-control text-center quantity-input"
                                                v-model="order_pend.quantity" data-rule="currency"
                                                @change="verifyStock(order_pend, idx)" />
                                            <div class="input-group-text">
                                                <button type="button" class="spin-up" data-spin="up" 
                                                    @click="sumar_orden(idx, parseInt(order_pend.food.item.stock))">
                                                    <span class="arrow"></span>
                                                </button>
                                                <button type="button" class="spin-down" data-spin="down"
                                                    @click="restar_orden(idx)">
                                                    <span class="arrow"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="price-display">
                                            S/ {{ order_pend.price }}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="action-buttons">
                                        <el-button-group>
                                            <el-button v-if="configuration.restaurant && table.is_delivery !== '1'"
                                                @click="toCarry(idx); playClickSound();" size="mini"
                                                :class="order_pend.to_carry ? 'btn_excelsmall' : 'btn_disabledsmall'"
                                                style="width: auto; white-space: nowrap;">
                                                <i class="fas fa-biking" style="margin-right: 5px; margin-left: 5px;"></i>
                                                <b class="btn-text-hide-mobile" style="margin-left: 5px; margin-right: 5px;">{{ order_pend.to_carry ? "  Sí " : "  No " }}</b>
                                            </el-button>
                                        </el-button-group>
                                        <el-button-group>
                                            <el-button class="text-white" type="danger" size="mini"
                                                icon="el-icon-delete" @click="deleteFood(idx)" circle>
                                            </el-button>
                                            <el-button class="text-white" size="mini" type="info"
                                                icon="el-icon-s-order" 
                                                @click="openLocalObservationDialog(idx, order_pend.observation, order_pend.food.item.id)"
                                                circle>
                                            </el-button>
                                        </el-button-group>
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="observations" v-if="order_pend.observation">
                                    <small>OBS.: {{ order_pend.observation }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORDENES ENVIADAS -->
                <div v-if="ordens.length != 0" class="section-orders">
                    <div class="section-header">
                        <p class="h4 txt-info txt-primary f-w-700">
                            <i class="icofont icofont-fork-and-knife"></i>
                            <span class="badge bg-dark text-white">
                                <template v-if="ordens.length > 0 && ordens.length <= 9">
                                    0{{ ordens.length }}
                                </template>
                                <template v-else>
                                    {{ ordens.length }}
                                </template>
                            </span>
                            Orden de Pedido Nº {{ ordenSelectedId }}
                        </p>
                    </div>

                    <!-- Cards de ordenes enviadas -->
                    <div class="order-card" v-for="(ord_row, idxx) in ordens" :key="idxx">
                        <div class="card-content">
                            <!-- Imagen -->
                            <div class="card-image" v-if="ord_row.food.image != 'imagen-no-disponible.jpg'">
                                <img :src="formatUrlImage(ord_row.food.image)" alt="Product" class="product-img" />
                            </div>

                            <!-- Info del producto -->
                            <div class="card-info">
                                <div class="product-name">
                                    {{ ord_row.food && ord_row.food.description ? ord_row.food.description.toUpperCase() : "" }}
                                </div>

                                <div class="product-controls">
                                    <div class="quantity-price-section">
                                        <div class="order-quantity-price">
                                            {{ Number(ord_row.quantity).toFixed(2) }} x {{ Number(ord_row.price).toFixed(2) }}
                                        </div>
                                    </div>

                                    <div class="action-buttons">
                                        <el-button-group>
                                            <el-tooltip v-if="ord_row.status_orden_id != 3" effect="dark"
                                                content="Pedido listo" placement="top-start">
                                                <el-button @click="ordenReady(ord_row.id)" type="success"
                                                    icon="el-icon-check" size="mini" circle>
                                                </el-button>
                                            </el-tooltip>
                                        </el-button-group>
                                        <el-button-group>
                                            <el-tooltip effect="dark" content="Cancelar pedido" placement="top-start">
                                                <el-button v-if="configuration.delete_mozo" type="danger"
                                                    icon="el-icon-delete" @click="cancelOrden(ord_row.id)"
                                                    circle size="mini">
                                                </el-button>
                                            </el-tooltip>
                                        </el-button-group>
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="observations" v-if="ord_row.observations">
                                    <small>OBS: {{ ord_row.observations }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <el-dialog v-loading="deleteOrdenLoading" width="100%" :visible.sync="showPinRequest" title="Ingrese su PIN"
            append-to-body :style="{ maxWidth: '350px', margin: '0 auto' }" @open="onOpenPinModal">
            <!-- <div class="row mt-1">
                <h6 class="fw-bold">
                    Para poder eliminar la orden debe ingresar un motivo y su
                    PIN de usuario.
                </h6>
            </div> -->
            <div class="row mt-1">
                <div class="col-12">
                    <el-input v-model="reasonToDelete" placeholder="Ingrese un motivo para eli" type="textarea"
                        maxlength="200" show-word-limit></el-input>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <!-- <el-input
            ref="pinInput"
            v-model="pin"
            class="form-control"
            placeholder="Ingrese su PIN"
            type="password"
            maxlength="4"
            name="listeanzahl"
            readonly
            @keydown="handleKeyDown"
          ></el-input>-->
                    <input ref="pinInput" v-model="pin" class="form-control" type="password" size="2" name="listeanzahl"
                        value="10" style="text-align: center; letter-spacing: 1rem" @keydown="handleKeyDown" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-center">
                    <div v-for="num in [1, 2, 3]" :key="num" class="col-4 p-1 d-flex justify-content-center">
                        <el-button class="circular-btn" type="primary" @click="generatePin(num)" circle>{{ num
                            }}</el-button>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div v-for="num in [4, 5, 6]" :key="num" class="col-4 p-1 d-flex justify-content-center">
                        <el-button class="circular-btn" type="primary" @click="generatePin(num)" circle>{{ num
                            }}</el-button>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div v-for="num in [7, 8, 9]" :key="num" class="col-4 p-1 d-flex justify-content-center">
                        <el-button class="circular-btn" type="primary" @click="generatePin(num)" circle>{{ num
                            }}</el-button>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="col-4 p-1 d-flex justify-content-center">
                        <el-button class="circular-btn" type="danger" icon="el-icon-delete" @click="pin = ''"
                            circle></el-button>
                    </div>
                    <div class="col-4 p-1 d-flex justify-content-center">
                        <el-button class="circular-btn" type="primary" @click="generatePin(0)" circle>0</el-button>
                    </div>
                    <div class="col-4 p-1 d-flex justify-content-center">
                        <el-button class="circular-btn" type="success" @click="cancelOrdenaPin" circle>Ok</el-button>
                    </div>
                </div>
            </div>
            <!-- <div slot="footer" class="dialog-footer">
                <el-button @click="showPinRequest = false">Cancelar</el-button>
                <el-button type="primary" @click="cancelOrdenaPin">Eliminar</el-button>
            </div> -->
        </el-dialog>

        <DeliveryForm :visible="showDeliveryForm" @close="showDeliveryForm = false" :localOrden="localOrden"
            :configuration="configuration" :fromPos="true" :cash_id="cash_id" />
    </div>
</template>

<style scoped>
/* ============================================
   ESTILOS BASE Y VARIABLES
   ============================================ */
.orden-container {
    width: 100%;
    height: 100%;
}

.ordens-wrapper {
     max-height: calc(100vh - 100px);
    /* max-height: 800px; */
    height: auto;
    padding: 10px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* ============================================
   HEADER SECTION
   ============================================ */
.header-section {
    padding: 1rem;
    flex-shrink: 0;
}

.header-title-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 10px;
}

.title-text {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 1.25rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.total-text {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: white;
    letter-spacing: 0.5px;
}

/* ============================================
   ACTION BUTTONS
   ============================================ */
.action-buttons-row {
    margin-bottom: 1rem;
}

.button-group-responsive {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.button-group-responsive .el-button {
    margin: 0 !important;
}

/* ============================================
   MOZO SELECTION
   ============================================ */
.mozo-selection-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    flex-wrap: wrap;
}

.mozo-label {
    margin: 0;
    white-space: nowrap;
}

.mozo-select {
    flex: 1;
    min-width: 200px;
}

/* ============================================
   REFERENCIA INPUT
   ============================================ */
.referencia-row {
    display: flex;
    justify-content: center;
    padding: 0.5rem 0;
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    flex: 1;
    background-color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    min-height: 300px;
}

/* ============================================
   PRODUCTS LIST
   ============================================ */
.products-list {
    background-color: white;
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 10px;
    min-height: 0;
}

/* ============================================
   SECTION ORDERS
   ============================================ */
.section-orders {
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.section-title {
    flex: 1;
}

.section-checkbox {
    display: flex;
    justify-content: center;
}

.checkbox-text {
    color: black;
    font-weight: bold;
}

/* ============================================
   ORDER CARDS
   ============================================ */
.order-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.order-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.card-content {
    display: flex;
    flex-direction: row;
    padding: 0.5rem;
    gap: 0.75rem;
}

.card-content:not(:has(.card-image)) .card-info {
    /* Sin imagen - más espacio para el contenido */
    max-width: 100%;
}

.card-image {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    overflow: hidden;
    border-radius: 6px;
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    min-width: 0;
}

.product-name {
    font-size: 1.1rem;
    font-weight: bold;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* ============================================
   PRODUCT CONTROLS
   ============================================ */
.product-controls {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.quantity-price-section {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.quantity-input {
    background-color: white !important;
    font-weight: bold;
    color: black !important;
}

.price-display {
    font-weight: bold;
    font-size: 1rem;
    white-space: nowrap;
}

.order-quantity-price {
    font-weight: 500;
    font-size: 0.95rem;
}

.action-buttons {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-buttons .el-button {
    width: 28px;
    height: 28px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* ============================================
   OBSERVATIONS
   ============================================ */
.observations {
    padding: 0.5rem;
    background-color: #f5f5f5;
    border-radius: 4px;
    font-style: italic;
}

/* ============================================
   PIN MODAL
   ============================================ */
.button-code {
    margin-right: 1.5px !important;
}

.pin-code {
    font-weight: bold;
    font-size: 20px !important;
    letter-spacing: 10px;
}

.circular-btn {
    width: 50px;
    height: 50px;
    font-size: 20px;
    line-height: 50px;
}

.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}

/* ============================================
   MEDIA QUERIES - TABLET (768px - 1200px)
   ============================================ */
@media (max-width: 1200px) {
    .ordens-wrapper {
        max-height: calc(100vh - 120px);
        padding: 8px;
    }

    .products-list {
        max-height: none;
    }

    .header-section {
        padding: 0.75rem;
    }

    .title-text,
    .total-text {
        font-size: 1.1rem;
    }

    .button-group-responsive {
        justify-content: center;
    }

    .mozo-select {
        min-width: 150px;
    }

    .card-image {
        width: 100px;
        height: 100px;
    }

    .product-name {
        font-size: 1rem;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .section-checkbox {
        width: 100%;
        justify-content: flex-start;
    }
}

/* ============================================
   MEDIA QUERIES - MOBILE (max-width: 767px)
   ============================================ */
@media (max-width: 767px) {
    .ordens-wrapper {
        max-height: calc(100vh - 100px);
        padding: 5px;
    }

    .products-list {
        max-height: none;
        padding: 5px;
    }

    .header-section {
        padding: 0.5rem;
    }

    .header-title-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .title-text {
        font-size: 1rem;
    }

    .total-text {
        font-size: 1.1rem;
        align-self: flex-end;
    }

    /* Ocultar texto en botones móviles */
    .btn-text-hide-mobile {
        display: none;
    }

    .button-group-responsive {
        width: 100%;
        justify-content: space-around;
    }

    .button-group-responsive .el-button {
        padding: 8px 10px;
        font-size: 14px;
    }

    .mozo-selection-row {
        flex-direction: column;
        align-items: stretch;
        gap: 0.25rem;
    }

    .mozo-label {
        font-size: 0.9rem;
    }

    .mozo-select {
        width: 100%;
        min-width: auto;
    }

    /* Cards responsive en móvil */
    .card-content {
        flex-direction: column;
        padding: 0.5rem;
        gap: 0.5rem;
    }

    .card-image {
        width: 100%;
        height: 150px;
        margin: 0 auto;
    }

    .card-info {
        width: 100%;
    }

    .product-name {
        font-size: 0.95rem;
        text-align: center;
    }

    .product-controls {
        gap: 0.75rem;
    }

    .quantity-price-section {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .quantity-price-section .input-group {
        width: 100%;
    }

    .price-display {
        text-align: center;
        font-size: 1.1rem;
        padding: 0.5rem;
        background-color: #f0f0f0;
        border-radius: 4px;
    }

    .action-buttons {
        justify-content: center;
        gap: 0.75rem;
    }

    .action-buttons .el-button-group {
        display: flex;
        gap: 0.5rem;
    }

    .section-header {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .section-title .h4 {
        font-size: 1rem;
    }

    .observations {
        padding: 0.4rem;
        font-size: 0.85rem;
    }

    /* PIN Modal en móvil */
    .circular-btn {
        width: 60px;
        height: 60px;
        font-size: 22px;
    }

    .empty-state {
        min-height: 300px;
        font-size: 0.9rem;
    }
}

/* ============================================
   MEDIA QUERIES - VERY SMALL MOBILE (max-width: 480px)
   ============================================ */
@media (max-width: 480px) {
    .card-image {
        height: 120px;
    }

    .product-name {
        font-size: 0.9rem;
    }

    .button-group-responsive .el-button {
        padding: 6px 8px;
        font-size: 12px;
    }

    .action-buttons .el-button {
        width: 32px;
        height: 32px;
    }

    .circular-btn {
        width: 55px;
        height: 55px;
        font-size: 20px;
    }
}

/* ============================================
   UTILITIES
   ============================================ */
.badge {
    display: inline-block;
    padding: 0.25em 0.6em;
    font-size: 0.9em;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.bg-dark {
    background-color: #343a40 !important;
}
</style>

<script>
import Pinform from "./paid.vue";
import ObservationForm from "../partials/observation_form.vue";
import swal from "sweetalert2";
import DeliveryForm from "../pos/partials/delivery_from.vue";
const OpenItems = () => import("../../views/pos/partials/visualizate.vue");

export default {
    props: [
        "localOrden",
        "configuration",
        "tableId",
        "ordens",
        "ordenSelectedId",
        "referencia",
        "table",
        "divided_items",
        "mozos",
        "cash_id",
        "customerId",
        "disableEnviarOrdenes"
    ],
    async created() {
        this.referenciaInput = this.referencia || "";
        this.mozos = this.mozos || [];
        this.readDividedItemsLocalStorage();
        await this.getTags();

        this.$eventHub.$on("ordenFormLimpiar", async ordenId => {
            console.log("ordenFormLimpiar event received, ordenId:", ordenId);
            await this.reloadOrders(ordenId);
        });
    },
    watch: {
        referencia(newVal) {
            if (!this.referenciaInput) {
                this.referenciaInput = newVal || "";
            }
        },
        ordenSelectedId(newVal) {
            this.localOrdenSelectedId = newVal;
            // Cuando cambia la orden seleccionada, actualiza el input con la referencia de la nueva orden
            if (this.referencia) {
                this.referenciaInput = this.referencia;
            }
            console.log("ordenSelectedId changed:", newVal);
        },
        ordens(newOrdens, _) {
            this.calculateTotal(newOrdens);
        },
        selectedMozo(newValue) {
            this.$emit("mozo-selected", newValue);
        }
    },
    components: {
        swal,
        Pinform,
        ObservationForm,
        OpenItems,
        DeliveryForm
    },
    data() {
        return {
            showDeliveryForm: false,
            showOpenOrden: false,
            localDividedItems: this.divided_items,
            deleteGeneralOrden: false,
            ordenIdToDelete: null,
            deleteOrdenLoading: false,
            showPinRequest: false,
            reasonToDelete: null,
            showObservations: false,
            tags: [],
            current: null,
            referenciaInput: undefined,
            pin: "",
            totalOrdenItems: 0.0,
            total: 0.0,
            totalOrden: 0.0,
            loading: false,
            showDialogPing: false,
            dialogLocalObservation: false,
            currentLocalOrden: null,
            localObservation: null,
            dialogObservation: false,
            observation: null,
            loadingObservation: false,
            currentOrden: null,
            form_ped: {},
            to_carry: false,
            selectedMozo: null,
            localOrdenSelectedId: this.ordenSelectedId
        };
    },
    watch: {
        ordens(newOrdens, _) {
            this.calculateTotal(newOrdens);
        },
        selectedMozo(newValue) {
            this.$emit("mozo-selected", newValue);
        },
        ordenSelectedId(newVal) {
            this.localOrdenSelectedId = newVal;
            console.log("ordenSelectedId changed:", newVal);
        }
    },
    mounted() { },
    methods: {
        async reloadOrders(ordenId) {
            // Lógica para recargar la lista de órdenes, puedes personalizar según tu API
            try {
                this.loading = true;
                // Ejemplo: obtener las órdenes actualizadas
                const response = await this.$http.get(
                    "/caja/worker/orden-new/{}".replace("{}", ordenId)
                );
                if (response.status === 200 && response.data) {
                    //this.$emit("update:ordens", response.data.ordens || []);

                    //this.$emit("update:ordens", response.data.ordens || []);
                    this.$emit("update:localOrden", []);
                    this.$emit("update:disableEnviarOrdenes", false);
                }
            } catch (e) {
                this.$toast &&
                    this.$toast.error(
                        "No se pudo actualizar la lista de órdenes"
                    );
            } finally {
                this.loading = false;
            }
        },
        openDelivery() {
            this.to_carry = true;
            this.allToCarry();
            this.showDeliveryForm = true;
        },
        openOrden() {
            this.showOpenOrden = true;
        },
        saveDividedItemsLocalStorage() {
            this.$emit("update:divided_items", this.localDividedItems);

            localStorage.setItem("divided_items", this.localDividedItems);
        },
        readDividedItemsLocalStorage() {
            let divided_items = localStorage.getItem("divided_items");
            if (divided_items) {
                this.localDividedItems = divided_items == "true";
                this.$emit("update:divided_items", this.localDividedItems);
            }
        },
        async printTicketPos() {
            let id = this.ordens[0].orden_id;
            try {
                const response = await this.$http.get(
                    `/caja/worker/record-worker/${id}?precuenta=true&printpos=true`
                );
            } catch (e) {
                console.log(e);
            }
        },
        onOpenPinModal() {
            this.$nextTick(() => {
                this.focusPinInput();
            });
        },
        focusPinInput() {
            const pinInput = this.$refs.pinInput;
            if (pinInput) {
                pinInput.focus();
            } else {
                console.error("El input para el PIN no está disponible.");
            }
        },
        handleKeyDown(event) {
            const key = event.key;
            if (key === "Enter") {
                this.cancelOrdenaPin();
            } else if (/^[0-9]$/.test(key) && this.pin.length < 4) {
                this.pin += key;
            } else if (key === "Backspace") {
                this.pin = this.pin.slice(0, -1);
            } else {
                event.preventDefault();
            }
        },
        handleKeyDown(event) {
            event.preventDefault(); // Prevent default action of the input

            const key = event.key;

            if (key === "Enter") {
                this.cancelOrdenaPin();
            } else if (/^[0-9]$/.test(key) && this.pin.length < 4) {
                this.pin += key;
            } else if (key === "Backspace") {
                this.pin = this.pin.slice(0, -1);
            }
        },
        generatePin(num) {
            if (this.pin.length < 4) {
                this.pin += num.toString();
            }
        },

        addNumberPin(number) {
            if (this.pin.length >= 4) {
                return;
            }
            this.pin += number.toString();
        },
        async allToCarry() {
            if (this.localOrden.length == 0) return;
            let ord = [...this.localOrden];
            ord = ord.map(o => {
                let price = o.price;
                let delivery = this.getDeliveryCost(o);
                //crear una variable que cheque si la propiedad to_carry del elemento es diferente a la propiedad this.to_carry solo ahi aplicar
                let passCarry = o.to_carry != this.to_carry;
                if (passCarry) {
                    if (this.to_carry) {
                        price = price + delivery;
                    } else {
                        price = price - delivery;
                    }
                    return { ...o, to_carry: this.to_carry, price };
                } else {
                    return o;
                }
            });
            await this.$emit("update:localOrden", ord);
            // setTimeout(() => {
            this.calculateTotal();
            // }, 200);
        },
        getDeliveryCost(item) {
            let {
                food: { item: realItem }
            } = item;
            let { delivery_cost } = realItem;
            let delivery = parseFloat(delivery_cost || "0");
            return delivery;
        },
        toCarry(idx) {
            let ord = [...this.localOrden];
            let item = ord[idx];
            let delivery = this.getDeliveryCost(item);
            ord[idx].to_carry = !ord[idx].to_carry;
            if (ord[idx].to_carry) {
                ord[idx].price = ord[idx].price + delivery;
            } else {
                ord[idx].price = ord[idx].price - delivery;
            }

            this.$emit("update:localOrden", ord);

            this.calculateTotal();
        },
        verifyStock(orden, idx) {
            let current_orden = this.localOrden.filter(o => o.id == orden.id);
            let qty = current_orden.reduce((a, b) => a + Number(b.quantity), 0);
            let stock = Number(current_orden[0].food.item.stock);

            if (qty > stock) {
                this.$toast.warning("Sobrepaso el stock");
                let localOrden_quantity = this.localOrden;
                localOrden_quantity[idx].quantity = 1;
                return;
            }
            this.calculateTotal();
        },
        async getTags() {
            const response = await this.$http("../observations/records");
            if (response.status == 200) {
                const { data } = response;
                this.tags = data;
            }
        },
        addObservation(obs) {
            let ordensModified = [...this.localOrden];
            ordensModified[this.currentLocalOrden].observation = obs;
            this.$emit("update:localOrden", ordensModified);
        },
        open() {
            //     this.referenciaInput = this.referencia;
        },
        addNumberPin(number) {
            if (this.pin.length >= 4) {
                return;
            }
            this.pin += number.toString();
        },
        change_quantity(index, quantity, stock) {
            let stock_disp = stock;
            let localOrden_quantity = this.localOrden;
            if (
                this.configuration.sales_stock == false ||
                this.configuration.sales_stock == 0
            ) {
                localOrden_quantity[index].quantity = quantity;
            } else {
                if (localOrden_quantity[index].quantity < stock) {
                    localOrden_quantity[index].quantity = quantity;
                } else {
                    localOrden_quantity[index].quantity = 1;
                    this.$alert(
                        "Stock Insuficiente..... <br> Stock Disponible: " +
                        parseInt(stock_disp),
                        "Aviso de Advertencia",
                        {
                            dangerouslyUseHTMLString: true,
                            confirmButtonText: "Aceptar",
                            type: "error"
                        }
                    );
                }
            }

            this.$emit("update:localOrden", localOrden_quantity);
        },
        validStock(orden, quantity = 1) {
            let qty = this.localOrden
                .filter(o => o.id == orden.id)
                .reduce((a, b) => a + Number(b.quantity), 0);
            if (orden.type_id) {
                qty += orden.type_quantity;
            } else {
                qty += quantity;
            }
            let stock = Number(orden.food.item.stock);

            if (this.configuration.sales_stock == true) {
                if (qty > stock) {
                    return true;
                }
            }
            return false;
        },
        sumar_orden(index) {
            /* if (this.validStock(this.localOrden[index])) {
                this.$toast.warning("Limite de stock alcanzado");
                return;
            } */
            let localOrden_quantity = this.localOrden;
            if (this.localOrden[index].type_id) {
                // localOrden_quantity[index].quantity =
                //     Number(localOrden_quantity[index].quantity) +
                //     Number(localOrden_quantity[index].type_quantity);
                localOrden_quantity[index].quantity =
                    Number(localOrden_quantity[index].quantity) + 1;
            } else {
                localOrden_quantity[index].quantity =
                    Number(localOrden_quantity[index].quantity) + 1;
            }

            this.$emit("update:localOrden", localOrden_quantity);
            this.calculateTotal();
        },
        restar_orden(index) {
            let localOrden_quantity = this.localOrden;
            let min = 1;
            if (this.localOrden[index].type_id) {
                min = Number(localOrden_quantity[index].type_quantity);
            }
            let quantity = localOrden_quantity[index].quantity * min;
            if (quantity > min) {
                // if (localOrden_quantity[index].quantity > min) {
                if (this.localOrden[index].type_id) {
                    // localOrden_quantity[index].quantity =
                    //     Number(localOrden_quantity[index].quantity) -
                    //     Number(localOrden_quantity[index].type_quantity);
                    localOrden_quantity[index].quantity =
                        Number(localOrden_quantity[index].quantity) - 1;
                } else {
                    localOrden_quantity[index].quantity =
                        Number(localOrden_quantity[index].quantity) - 1;
                }

                this.$emit("update:localOrden", localOrden_quantity);
                this.calculateTotal();
            } else {
                this.$toast.warning("Mínimo permitido");
            }
        },
        async printTicketPdf() {
            try {
                let id = this.ordens[0].orden_id;
                const response = await this.$http.get(
                    `/caja/worker/record/${id}?precuenta=true`
                );
                let url = response.data.print;
                window.open(url, "_blank");
                console.log("regresando");
                return;
            } catch (e) {
                console.log(e);
            }
        },
        async printTicket() {
            let id = this.ordens[0].orden_id;
            try {
                const response = await this.$http.get(
                    `/caja/worker/record-worker/${id}?re_printer=true`
                );
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        async printTicketRePrint() {
            let id = this.ordens[0].orden_id;
            try {
                const response = await this.$http.get(
                    `/caja/worker/re-print-ticket/${id}?re_printer=true`
                );
                // puedes usar response.data si necesitas usar los datos retornados
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        open_orders() {
            $(".style-switcher").hasClass("active")
                ? $(".style-switcher")
                    .animate(
                        {
                            right: "-" + $(".style-switcher").width() + "px"
                        },
                        300
                    )
                    .removeClass("active")
                : $(".style-switcher")
                    .animate(
                        {
                            right: "0"
                        },
                        300
                    )
                    .addClass("active");
        },
        view_orders() {
            $(".style-switcher")
                .animate(
                    {
                        right: "0"
                    },
                    300
                )
                .addClass("active");
        },
        async sendOrden(pin = null) {
            if (this.configuration.seller_mozo && !this.selectedMozo) {
                this.$toast.error("Debe seleccionar un mozo");
                return;
            }

            for (let item of this.localOrden) {
                if (!item.id) {
                    this.$toast.error("Uno o más productos no tienen ID");
                    return;
                }
            }

            let form_submit = {
                id: this.ordenSelectedId,
                caja: false,
                to_carry: this.to_carry,
                printing: this.configuration.print_commands,
                commands_fisico: null,
                ref: this.referencia,
                mozo_id: this.selectedMozo,
                orden: {
                    table_id: this.tableId,
                    status_orden_id: 1,
                    customer_id: null
                },
                items: this.localOrden,
                ref: this.referenciaInput,
                pin
            };
            if (this.table.is_room) {
                form_submit.add_charge_room = true;
            }
            try {
                this.loading = true;
                const response = await this.$http.post(
                    "send-orden",
                    form_submit
                );
                if (response.status == 200) {
                    const { success, message, ordenId } = response.data;
                    console.log("ver datos en el data", response.data);
                    if (success) {
                        this.showDialogPing = false;
                        this.referenciaInput = null;

                        //this.$toast.success(message);
                        this.$showSAlert(message, "success");
                        this.localOrdenSelectedId = ordenId;
                        this.$emit("update:ordenSelectedId", ordenId);

                        this.closeDialog(ordenId);
                        if (this.configuration.order_mozo) {
                            this.$nextTick(() => {
                                this.$emit("selectNewOrden", ordenId);
                            });
                        }

                        // this.loading = false;
                    } else {
                        //this.$toast.error(message);
                        /* this.$showSAlert("ALERTA", message, "error", {
                            confirmButtonText: 'OK'
                        }); */
                        Swal.fire({
                            title: "ALERTA",
                            text: message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        // this.loading = false;
                    }
                    //this.ordenNew(ordenId);
                }
            } catch (e) {
                this.$toast.error(e);
            } finally {
                this.loading = false;
            }
        },

        closeDialog(ordenId = null) {
            let ordenToAdd = [...this.localOrden];
            ordenToAdd = ordenToAdd.map(o => ({
                status_orden_id: 1,
                food: {
                    description: o.food.description,
                    price: o.food.price
                },
                observations: o.observation
            }));
            this.to_carry = false;
            // let allOrdens = [...ordenToAdd, ...this.ordens];
            this.$emit("updateOrdens", ordenId);
            this.$emit("listtables");
            // this.$emit("update:ordens", allOrdens);
            this.$emit("update:localOrden", []);
            this.$eventHub.$emit("reloadData");
            this.totalOrdenItems = 0.0;
            this.total = 0.0;
            this.totalOrden = 0.0;
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        cancelGeneralOrdenPin() {
            this.deleteGeneralOrden = true;
            this.showPinRequest = true;
        },
        async deleteGeneralOrdenPin() {
            try {
                this.deleteOrdenLoading = true;

                let form = {
                    id: this.ordens[0].orden_id,
                    pin: this.pin,
                    reason: this.reasonToDelete
                };
                const response = await this.$http.post("cancel-orden", form);
                if (response.status == 200) {
                    const { message, success } = response.data;
                    if (success) {
                        this.$toast.success(message);
                        this.$eventHub.$emit("reloadData");
                        this.$emit("ordenDeleted");
                        this.deleteGeneralOrden = false;
                        this.showPinRequest = false;
                        this.reasonToDelete = null;
                    } else {
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                if (e != "cancel") {
                    console.log(e);
                    this.$toast.error("Ocurrió un error");
                }
            } finally {
                this.pin = "";
                this.deleteOrdenLoading = false;
            }
        },
        async cancelGeneralOrden() {
            if (this.configuration.pin_orden_delete) {
                this.cancelGeneralOrdenPin();
            } else {
                try {
                    const result = await swal.fire({
                        title: "Desea cancelar toda la orden?",
                        text: "Esta acción no se puede revertir",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Cancelar",
                        confirmButtonText: "Ok"
                    });

                    if (result.isConfirmed) {
                        this.loading = true;
                        let form = {
                            id: this.ordens[0].orden_id
                        };
                        const response = await this.$http.post(
                            "cancel-orden",
                            form
                        );
                        if (response.status == 200) {
                            const { message } = response.data;
                            this.$toast.success(message);
                            this.$eventHub.$emit("reloadData");
                            this.$emit("ordenDeleted");
                        }
                    }
                } catch (e) {
                    if (e != "cancel") {
                        console.log(e);
                        this.$toast.error("Ocurrió un error");
                    }
                } finally {
                    this.loading = false;
                }
            }
        },
        calculateTotal(w = null) {
            this.totalOrdenItems = 0.0;
            this.total = 0.0;
            this.totalOrden = 0.0;
            let OrdenPen = 0;
            let OrdenPenAtendidos = 0;

            _.forEach(this.localOrden, function (value) {
                OrdenPen = parseFloat(OrdenPen) + value.quantity * value.price;
            });
            this.totalOrden = _.round(OrdenPen, 2);
            _.forEach(this.ordens, function (values) {
                OrdenPenAtendidos =
                    parseFloat(OrdenPenAtendidos) +
                    values.quantity * values.price;
            });
            this.totalOrdenItems = _.round(OrdenPenAtendidos, 2);
            this.total = this.totalOrden + this.totalOrdenItems;
        },
        deleteFood(idx) {
            this.$emit("deleteFood", idx);
            if (this.localOrden.length == 0) {
                // this.clearPin();
            }
        },
        async submit() {
            if (this.configuration.pin_switch) {
                this.showDialogPing = true;
            } else {
                this.sendOrden();
            }
        },
        async cancelOrdenaPin() {
            if (this.pin.length > 3 && this.reasonToDelete) {
                if (this.deleteGeneralOrden) {
                    this.deleteGeneralOrdenPin();
                } else {
                    try {
                        this.deleteOrdenLoading = true;
                        const response = await this.$http.post(
                            `delete-orden-pin`,
                            {
                                id: this.ordenIdToDelete,
                                pin: this.pin,
                                reason: this.reasonToDelete
                            }
                        );
                        if (response.status == 200) {
                            if (response.data.success) {
                                const { message } = response.data;
                                let newOrdenItems = [...this.ordens];
                                newOrdenItems = newOrdenItems.filter(
                                    n => n.id != this.ordenIdToDelete
                                );
                                this.$emit("update:ordens", newOrdenItems);
                                this.$eventHub.$emit("reloadData");
                                this.$toast.success(message);
                                this.reasonToDelete = null;
                                this.showPinRequest = false;
                            } else {
                                this.$toast.error(response.data.message);
                            }
                        }
                    } catch (e) {
                        console.log(e);
                        this.$toast.error("Ocurrió un error");
                    } finally {
                        this.pin = "";
                        this.deleteOrdenLoading = false;
                    }
                }
            } else {
                this.$toast.error("Ingrese el pin");
                return;
            }
        },

        generatePin(num) {
            if (this.pin.length == 4) {
                return;
            }
            this.pin += num;
        },
        async cancelOrden(id) {
            if (this.configuration.pin_orden_delete) {
                this.deleteGeneralOrden = false;
                this.showPinRequest = true;
                this.ordenIdToDelete = id;
            } else {
                try {
                    let res = await this.$confirm(
                        "Desea cancelar este pedido?",
                        "Cancelar",
                        {
                            confirmButtonText: "Ok",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    if (res) {
                        const response = await this.$http.delete(
                            `delete-orden/${id}`
                        );
                        if (response.status == 200) {
                            const { message } = response.data;
                            let newOrdenItems = [...this.ordens];
                            newOrdenItems = newOrdenItems.filter(
                                n => n.id != id
                            );
                            this.$emit("update:ordens", newOrdenItems);
                            this.$eventHub.$emit("reloadData");
                            this.$toast.success(message);
                        }
                    }
                } catch (e) {
                    //todo
                    if (e != "cancel") {
                        this.$toast.error("Ocurrió un error");
                    }
                }
            }
        },
        async ordenReady(id) {
            this.loading = true;
            try {
                const response = await this.$http.get(`ordens-ready/${id}`);

                const { success, message } = response.data;
                success
                    ? this.$toast.success(message)
                    : this.$toast.error(message);
                if (success) {
                    let cloneOrdenItems = [...this.ordens];
                    cloneOrdenItems = cloneOrdenItems.map(o => {
                        if (o.id == id) {
                            o.status_orden_id = 3;
                        }
                        return o;
                    });
                    this.$emit("update:ordens", cloneOrdenItems);
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error");
            }
            this.loading = false;
        },
        async changeObservation() {
            //this.localObservation
            this.loadingObservation = true;
            const response = await this.$http.post("change-observation", {
                observation: this.observation,
                id: this.currentOrden
            });
            if (response.status == 200) {
                this.$eventHub.$emit("reloadData");
                let newOrdenItems = [...this.ordens];
                newOrdenItems.find(
                    n => n.id == this.currentOrden
                ).observations = this.observation;
            }
            this.loadingObservation = false;
            this.closeObservationDialog();
        },
        openObservationDialog(id, idx) {
            this.currentOrden = id;
            this.observation = this.ordens[idx].observations;
            this.dialogObservation = true;
        },
        closeObservationDialog() {
            this.dialogObservation = false;
            this.observation = null;
        },
        changeLocalObservation() {
            let ordenModified = [...this.localOrden];
            ordenModified[
                this.currentLocalOrden
            ].observation = this.localObservation;
            this.$emit("update:localOrden", ordenModified);
            this.closeLocalObservationDialog();
        },
        openLocalObservationDialog(idx, obs, ordenId) {
            this.currentOrden = ordenId;
            this.showObservations = true;
            this.currentLocalOrden = idx;
            this.current = obs;
            return;
        },
        closeLocalObservationDialog() {
            this.dialogLocalObservation = false;
            this.currentLocalOrden = null;
            this.localObservation = null;
        },
        updateMozo(value) {
            // Optionally emit an event when mozo changes
            this.$emit("mozo-selected", value);
        },
        playClickSound() {
            // Play click sound
            try {
                const audio = new Audio('/images/audios/click.mp3');
                audio.volume = 0.5;
                audio.play().catch(err => {
                    console.log('Error playing sound:', err);
                });
            } catch (error) {
                console.log('Error creating audio:', error);
            }
        }
        /* addProductToOrder(product) {
            console.log("ver como llega el dato", product);
            this.localOrden.push(product);
            this.calculateTotal();
        } */
    }
};
</script>
