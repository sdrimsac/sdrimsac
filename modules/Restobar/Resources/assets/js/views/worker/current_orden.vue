<template>
    <div v-loading="loading">
        <observation-form
            :current="current"
            :observations.sync="tags"
            :showDialog.sync="showObservations"
            :configuration="configuration"
            :ordenId="currentOrden"
            @addObservation="addObservation"
        ></observation-form>
        <el-dialog
            key="db"
            v-loading="loadingObservation"
            @close="closeLocalObservationDialog"
            :visible="dialogObservation"
            append-to-body
            title="Editando observación"
        >
            <label class="control-label">Observación</label>
            <el-input v-model="observation"></el-input>
            <div class="row mt-1 d-flex flex-row justify-content-end">
                <button
                    class="btn btn-sm btn-primary"
                    @click="changeObservation"
                >
                    Cambiar
                </button>
            </div>
        </el-dialog>

        <template>
            <open-items
                :showDialog.sync="showOpenOrden"
                :localOrden="localOrden"
            />
            <Pinform
                @sendOrden="sendOrden"
                :showDialogPing.sync="showDialogPing"
                :to_carry.sync="to_carry"
                :configuration.sync="configuration"
                :ordenSelectedId.sync="ordenSelectedId"
                :tableId.sync="tableId"
                :localOrden.sync="localOrden"
                @add="closeDialog"
                :referencia="referenciaInput"
            ></Pinform>
        </template>
        <div>
            <template v-if="configuration.divided_items">
                <el-checkbox
                    v-model="localDividedItems"
                    style="margin-left: 10px;"
                    @change="saveDividedItemsLocalStorage"
                    >Dividir Ordenes Iguales</el-checkbox
                >
            </template>
        </div>
        <div>
            <template v-if="configuration && configuration.seller_mozo">
                <label
                    >Seleccione Mozo <span class="text-danger">*</span></label
                >
                <el-select
                    v-model="selectedMozo"
                    placeholder="Seleccione un mozo"
                    @change="updateMozo"
                    clearable
                >
                    <el-option
                        v-for="mozo in mozos"
                        :key="mozo.id"
                        :label="mozo.name"
                        :value="mozo.id"
                    >
                    </el-option>
                </el-select>
            </template>
        </div>
        <br />
        <div id="ordens " class="border-dark rounded-top">
            <div class="bg-primary rounded-top p-2">
                <span class="el-dialog__title text-white"
                    >Lista de Ordenes</span
                >
            </div>
            <div class="row d-flex flex-row p-2">
                <div class="col-12 d-flex justify-content-end">
                    <el-button-group>
                        <el-button
                        v-if="localOrden.length != 0 && table.is_delivery !== '1'"
                            :type="to_carry ? 'success' : 'info'"
                            size="mini"
                            @click="
                                to_carry = !to_carry;
                                allToCarry();
                            "
                        >
                        <i class="fas fa-biking"></i>
                            <i class="el-icon-shopping-bag" style="margin-right: 4px;"></i>
                            <!-- <i class="el-icon-truck" style="margin-right: 4px;"></i> -->
                             <b>{{ to_carry ? "Sí" : "No" }}</b>
                        </el-button>
                        <template
                            v-if="
                                table &&
                                    table.is_delivery === '1' &&
                                    ordens.length === 0
                            "
                        >
                            <el-tooltip
                                effect="dark"
                                content="Delivery"
                                placement="top-start"
                            >
                                <el-button
                                v-if="localOrden.length != 0"
                                    type="primary"
                                    class="btn btn-sm"
                                    @click="openDelivery"
                                >
                                    <i class="fas fa-biking"></i>
                                </el-button>
                            </el-tooltip>
                        </template>
                        <template v-else>
                            <el-tooltip
                                effect="dark"
                                content="Enviar ordenes"
                                placement="top-start"
                            >
                                <el-button
                                v-if="localOrden.length != 0"
                                    @click="submit"
                                    class="btn-sm bg-success"
                                >
                                    <i class="el-icon-s-promotion"></i>
                                </el-button>
                            </el-tooltip>
                        </template>

                        <el-tooltip
                            effect="dark"
                            content="Imprimir Precuenta en caja"
                            placement="top-start"
                        >
                            <el-button
                                type="success"
                                class="btn btn-sm"
                                @click="printTicketPos"
                                v-if="configuration.print_pos_worker && ordens.length > 0"
                            >
                                <i class="icofont-printer"></i>
                            </el-button>
                        </el-tooltip>
                        <el-tooltip
                            effect="dark"
                            content="re-Imprimir comanda sus respectivas areas"
                            placement="top-start"
                        >
                            <el-button
                                type="warning"
                                class="btn btn-sm"
                                @click="printTicketRePrint"
                                v-if="ordens.length > 0"
                            >
                                <i class="icofont-printer"></i>
                            </el-button>
                        </el-tooltip>
                        <el-tooltip
                            effect="dark"
                            content="re-Imprimir comanda en caja"
                            placement="top-start"
                        >
                            <el-button
                                v-if="configuration.re_printer && ordens.length > 0"
                                type="primary"
                                class="btn btn-sm"
                                @click="printTicket"
                            >
                                <i class="icofont-printer"></i>
                            </el-button>
                        </el-tooltip>
                        <el-tooltip
                            effect="dark"
                            content="Imprimir ticket en cocina"
                            placement="top-start"
                        >
                            <el-button
                                v-if="configuration.pdf_preorder && ordens.length > 0"
                                type="info"
                                @click="printTicketPdf"
                                class="btn btn-sm"
                            >
                                <i class="icofont-printer"></i> PDF
                            </el-button>
                        </el-tooltip>

                        <el-tooltip
                            effect="dark"
                            content="Cancelar orden"
                            placement="top-start"
                        >
                            <el-button
                                v-if="configuration.delete_mozo && ordens.length > 0"
                                type="danger"
                                @click="cancelGeneralOrden"
                                class="btn btn-sm"
                            >
                                <i class="icofont-close-line"></i>
                            </el-button>
                        </el-tooltip>
                    </el-button-group>
                </div>
            </div>
            <!-- <div class="row p-2" v-if="localOrden.length != 0">
                <div
                    class="col-4 f-w-700 text-end pt-2 pb-2"
                    v-if="table.is_delivery !== '1'"
                ></div>
                <div class="col-8 d-flex justify-content-end">
                    <template
                        v-if="
                            table &&
                                table.is_delivery === '1' &&
                                ordens.length === 0
                        "
                    >
                        <el-tooltip
                            effect="dark"
                            content="Delivery"
                            placement="top-start"
                        >
                            <el-button
                                type="primary"
                                class="btn btn-sm"
                                @click="openDelivery"
                            >
                                <i class="fas fa-biking"></i>
                            </el-button>
                        </el-tooltip>
                    </template>
                    <template v-else>
                        <el-tooltip
                            effect="dark"
                            content="Enviar ordenes"
                            placement="top-start"
                        >
                            <el-button
                                @click="submit"
                                class="btn-sm bg-success"
                            >
                                <i class="el-icon-s-promotion"></i>
                            </el-button>
                        </el-tooltip>
                    </template>

                    <el-tooltip
                        effect="dark"
                        content="ver ordenes antes de enviar"
                        placement="top-start"
                    >
                        <el-button
                            class="btn-sm"
                            @click="openOrden"
                            icon="el-icon-view"
                        ></el-button>
                    </el-tooltip>
                </div>
            </div> -->

            <div
                v-if="ordens.length == 0 && localOrden.length == 0"
                style="min-height:300px;"
                class="d-flex flex-column align-items-center justify-content-center"
            >
                Sin productos
                <br />
            </div>
            <div
                v-if="ordens.length > 0 || localOrden.length > 0"
                class="d-flex justify-content-center p-1"
            >
                <el-input
                    v-model="referenciaInput"
                    placeholder="Referencia (DNI)"
                ></el-input>
            </div>
            <div
                class="product-wrapper-grid list-view p-2"
                style="height:calc(100vh - 27rem);overflow-y: auto;overflow-x:hidden;margin-bottom:15px;"
            >
                <div class="row" v-if="localOrden.length != 0">
                    <div class="col-12">
                        <p class="h4 txt-info p-10 txt-primary f-w-700">
                            <i class="icofont icofont-fork-and-knife"></i>
                            <a
                                class="badge badge bg-dark text-white"
                                href="javascript:void(0)"
                            >
                                <template
                                    v-if="
                                        localOrden.length > 0 &&
                                            localOrden.length <= 9
                                    "
                                    >0{{ localOrden.length }}</template
                                >
                                <template v-else>{{
                                    localOrden.length
                                }}</template>
                            </a>
                            Ordenes Pendiente
                        </p>
                    </div>
                    <div
                        class="col-md-12"
                        v-for="(order_pend, idx) in localOrden"
                        :key="idx"
                    >
                        <div class="card mb-2" id="card">
                            <div class="row">
                                <div class="col-auto">
                                    <template
                                        v-if="
                                            order_pend.food.image ==
                                                'imagen-no-disponible.jpg'
                                        "
                                    >
                                        <img
                                            src="/images/imagen-no-disponible.jpg"
                                            alt="User Img"
                                            class="card-img card-img-horizontal h-100 thumbail"
                                        />
                                    </template>
                                    <template v-else>
                                        <img
                                            :src="
                                                formatUrlImage(
                                                    order_pend.food.image
                                                )
                                            "
                                            class="card-img card-img-horizontal h-100 thumbail"
                                        />
                                    </template>
                                </div>
                                <div
                                    class="col position-relative h-100 p-0 m-0"
                                >
                                    <div class="card-body p-1">
                                        <div class="row h-100">
                                            <div
                                                class="col-12 mb-md-0 d-flex align-items-center"
                                            >
                                                <div class="pt-0 pb-0 pe-2">
                                                    <div
                                                        class="h6 mb-0 clamp-line"
                                                        data-line="1"
                                                    >
                                                        {{
                                                            order_pend.food.description.toUpperCase()
                                                        }}
                                                        <span
                                                            v-if="
                                                                order_pend.type_id
                                                            "
                                                            class="text-primary"
                                                        >
                                                            <small>
                                                                <strong>
                                                                    *{{
                                                                        order_pend.type_description
                                                                    }}
                                                                </strong>
                                                            </small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row h-100">
                                            <div
                                                class="col-5 mb-md-0 d-flex align-items-center"
                                            >
                                                <div
                                                    class="input-group spinner"
                                                    data-trigger="spinner"
                                                >
                                                    <input
                                                        type="text"
                                                        :disabled="
                                                            order_pend.food.item
                                                                .is_set &&
                                                                !configuration.item_set_quantity_pos
                                                        "
                                                        class="form-control text-center"
                                                        v-model="
                                                            order_pend.quantity
                                                        "
                                                        data-rule="currency"
                                                        @change="
                                                            verifyStock(
                                                                order_pend,
                                                                idx
                                                            )
                                                        "
                                                    />
                                                    <div
                                                        class="input-group-text"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="spin-up"
                                                            data-spin="up"
                                                            @click="
                                                                sumar_orden(
                                                                    idx,
                                                                    parseInt(
                                                                        order_pend
                                                                            .food
                                                                            .item
                                                                            .stock
                                                                    )
                                                                )
                                                            "
                                                        >
                                                            <span
                                                                class="arrow"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="spin-down"
                                                            data-spin="down"
                                                            @click="
                                                                restar_orden(
                                                                    idx
                                                                )
                                                            "
                                                        >
                                                            <span
                                                                class="arrow"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-4 d-flex justify-content-start justify-content-md-start align-items-center p-1"
                                            >
                                                <div
                                                    class="h6 mb-0"
                                                    style="margin-right:3px;"
                                                >
                                                    S/
                                                    {{ order_pend.price }}
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div
                                                    class="col-4"
                                                    v-if="
                                                        table.is_delivery !==
                                                            '1'
                                                    "
                                                >
                                                    <el-tag
                                                        v-if="
                                                            configuration.restaurant
                                                        "
                                                        @click="toCarry(idx)"
                                                        size="medium"
                                                        role="button"
                                                        :type="
                                                            order_pend.to_carry
                                                                ? 'success'
                                                                : 'info'
                                                        "
                                                        >Para llevar</el-tag
                                                    >
                                                </div>
                                                <div class="col-4">
                                                    <el-button-group>
                                                        <el-button
                                                            class="text-white"
                                                            type="danger"
                                                            size="small"
                                                            icon="el-icon-delete"
                                                            @click="
                                                                deleteFood(idx)
                                                            "
                                                            style="width: 38px; height: 38px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center;"
                                                        ></el-button>
                                                        <el-button
                                                            class="text-white"
                                                            size="small"
                                                            type="info"
                                                            icon="el-icon-s-order"
                                                            @click="
                                                                openLocalObservationDialog(
                                                                    idx,
                                                                    order_pend.observation,
                                                                    order_pend
                                                                        .food
                                                                        .item.id
                                                                )
                                                            "
                                                            style="width: 38px; height: 38px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; margin-left: 6px;"
                                                        ></el-button>
                                                    </el-button-group>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="row mt-1"
                                            v-if="order_pend.observation"
                                        >
                                            <div class="col-md-12">
                                                <small>
                                                    OBS.:
                                                    {{ order_pend.observation }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="ordens.length != 0">
                    <div class="col-12">
                        <p class="h4 txt-info p-10 txt-primary f-w-700">
                            <i class="icofont icofont-fork-and-knife"></i>
                            <a
                                class="badge badge bg-dark text-white"
                                href="javascript:void(0)"
                            >
                                <template
                                    v-if="
                                        ordens.length > 0 && ordens.length <= 9
                                    "
                                    >0{{ ordens.length }}</template
                                >
                                <template v-else>{{ ordens.length }}</template>
                            </a>
                            Orden de Pedido Nº {{ ordenSelectedId }}
                        </p>
                    </div>
                    <div
                        class="col-md-12"
                        v-for="(ord_row, idxx) in ordens"
                        :key="idxx"
                    >
                        <div class="card mb-2" id="card">
                            <div class="row">
                                <div class="col-auto">
                                    <template
                                        v-if="
                                            ord_row.food.image ==
                                                'imagen-no-disponible.jpg'
                                        "
                                    >
                                        <img
                                            src="/images/imagen-no-disponible.jpg"
                                            alt="User Img"
                                            class="card-img card-img-horizontal h-100 thumbail"
                                        />
                                    </template>
                                    <template v-else>
                                        <img
                                            :src="
                                                formatUrlImage(
                                                    ord_row.food.image
                                                )
                                            "
                                            class="card-img card-img-horizontal h-100 thumbail"
                                        />
                                    </template>
                                </div>
                                <div
                                    class="col position-relative h-100 p-0 m-0"
                                >
                                    <div class="card-body p-2">
                                        <div class="row h-100">
                                            <div
                                                class="col-12 mb-md-0 d-flex align-items-center p-1"
                                            >
                                                <div class="pt-0 pb-0 pe-2">
                                                    <div
                                                        class="h6 mb-0 clamp-line"
                                                        data-line="1"
                                                    >
                                                        {{
                                                            ord_row.food &&
                                                            ord_row.food
                                                                .description
                                                                ? ord_row.food.description.toUpperCase()
                                                                : ""
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row h-100">
                                            <div
                                                class="col-5 mb-md-0 d-flex align-items-center p-1"
                                            >
                                                {{ ord_row.quantity }} x
                                                {{
                                                    Number(
                                                        ord_row.price
                                                    ).toFixed(2)
                                                }}
                                            </div>

                                            <div
                                                class="col-5 d-flex justify-content-start justify-content-md-start align-items-center p-1"
                                            >
                                                <el-button-group>
                                                    <el-tooltip
                                                        v-if="
                                                            ord_row.status_orden_id !=
                                                                3
                                                        "
                                                        effect="dark"
                                                        content="Pedido listo"
                                                        placement="top-start"
                                                    >
                                                        <el-button
                                                            @click="
                                                                ordenReady(
                                                                    ord_row.id
                                                                )
                                                            "
                                                            type="success"
                                                            icon="el-icon-check"
                                                            size="mini"
                                                            style="width: 58px;"
                                                        ></el-button>
                                                    </el-tooltip>
                                                </el-button-group>
                                                <el-button-group>
                                                    <el-tooltip
                                                        effect="dark"
                                                        content="Cancelar pedido"
                                                        placement="top-start"
                                                    >
                                                        <el-button
                                                            v-if="
                                                                configuration.delete_mozo
                                                            "
                                                            type="danger"
                                                            icon="el-icon-delete"
                                                            @click="
                                                                cancelOrden(
                                                                    ord_row.id
                                                                )
                                                            "
                                                            style="width: 58px;"
                                                            size="mini"
                                                        ></el-button>
                                                    </el-tooltip>
                                                </el-button-group>
                                            </div>
                                            <div
                                                class="col-md-12"
                                                v-if="ord_row.observations"
                                            >
                                                <small>
                                                    OBS:
                                                    {{ ord_row.observations }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="ordens.length > 0 || localOrden.length > 0"
                class="d-flex flex-column p-2 text-black"
            >
                <div class="row p-r-10">
                    <div class="col-12 f-w-700 text-end p-t-5">
                        POR ATENDER S/ {{ totalOrden.toFixed(2) }}
                    </div>

                    <div class="col-12 f-w-700 text-end p-t-5">
                        ATENDIDO S/ {{ totalOrdenItems.toFixed(2) }}
                    </div>

                    <div class="col-12 f-w-700 text-end p-t-5 p-b-5">
                        TOTAL S/ {{ total.toFixed(2) }}
                    </div>
                </div>
            </div>
        </div>
        <el-dialog
            v-loading="deleteOrdenLoading"
            width="100%"
            :visible.sync="showPinRequest"
            title="Ingrese su PIN"
            append-to-body
            :style="{ maxWidth: '350px', margin: '0 auto' }"
            @open="onOpenPinModal"
        >
            <!-- <div class="row mt-1">
                <h6 class="fw-bold">
                    Para poder eliminar la orden debe ingresar un motivo y su
                    PIN de usuario.
                </h6>
            </div> -->
            <div class="row mt-1">
                <div class="col-12">
                    <el-input
                        v-model="reasonToDelete"
                        placeholder="Ingrese un motivo para eli"
                        type="textarea"
                        maxlength="200"
                        show-word-limit
                    ></el-input>
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
                    <input
                        ref="pinInput"
                        v-model="pin"
                        class="form-control"
                        type="password"
                        size="2"
                        name="listeanzahl"
                        value="10"
                        style="text-align: center; letter-spacing: 1rem"
                        @keydown="handleKeyDown"
                    />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-center">
                    <div
                        v-for="num in [1, 2, 3]"
                        :key="num"
                        class="col-4 p-1 d-flex justify-content-center"
                    >
                        <el-button
                            class="circular-btn"
                            type="primary"
                            @click="generatePin(num)"
                            circle
                            >{{ num }}</el-button
                        >
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div
                        v-for="num in [4, 5, 6]"
                        :key="num"
                        class="col-4 p-1 d-flex justify-content-center"
                    >
                        <el-button
                            class="circular-btn"
                            type="primary"
                            @click="generatePin(num)"
                            circle
                            >{{ num }}</el-button
                        >
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div
                        v-for="num in [7, 8, 9]"
                        :key="num"
                        class="col-4 p-1 d-flex justify-content-center"
                    >
                        <el-button
                            class="circular-btn"
                            type="primary"
                            @click="generatePin(num)"
                            circle
                            >{{ num }}</el-button
                        >
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="col-4 p-1 d-flex justify-content-center">
                        <el-button
                            class="circular-btn"
                            type="danger"
                            icon="el-icon-delete"
                            @click="pin = ''"
                            circle
                        ></el-button>
                    </div>
                    <div class="col-4 p-1 d-flex justify-content-center">
                        <el-button
                            class="circular-btn"
                            type="primary"
                            @click="generatePin(0)"
                            circle
                            >0</el-button
                        >
                    </div>
                    <div class="col-4 p-1 d-flex justify-content-center">
                        <el-button
                            class="circular-btn"
                            type="success"
                            @click="cancelOrdenaPin"
                            circle
                            >Ok</el-button
                        >
                    </div>
                </div>
            </div>
            <!-- <div slot="footer" class="dialog-footer">
                <el-button @click="showPinRequest = false">Cancelar</el-button>
                <el-button type="primary" @click="cancelOrdenaPin">Eliminar</el-button>
            </div> -->
        </el-dialog>

        <DeliveryForm
            :visible="showDeliveryForm"
            @close="showDeliveryForm = false"
            :localOrden="localOrden"
            :configuration="configuration"
            :fromPos="true"
            :cash_id="cash_id"
        />
    </div>
</template>

<style scoped>
.button-code {
    margin-right: 1.5px !important;
}

.pin-code {
    font-weight: bold;
    font-size: 20px !important;
    letter-spacing: 10px;
}
.circular-btn {
    width: 70px;
    height: 70px;
    font-size: 20px;
    line-height: 50px;
}
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
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
    mounted() {},
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

            _.forEach(this.localOrden, function(value) {
                OrdenPen = parseFloat(OrdenPen) + value.quantity * value.price;
            });
            this.totalOrden = _.round(OrdenPen, 2);
            _.forEach(this.ordens, function(values) {
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
        }
        /* addProductToOrder(product) {
            console.log("ver como llega el dato", product);
            this.localOrden.push(product);
            this.calculateTotal();
        } */
    }
};
</script>
