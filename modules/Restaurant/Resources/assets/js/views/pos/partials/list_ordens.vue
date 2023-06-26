<template>
    <div v-loading="ordenLoading">
        <div>
            <div
                v-if="screenWidth > 678"
                class="d-md-flex  flex-wrap justify-content-between"
                
            >
                    <div class="dropdown-as-select d-inline-block mb-1" data-childselector="span"  >
                        <button
                            class="btn p-0"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <span
                                class="btn btn-primary dropdown-toggle"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-delay="0"
                                title=""
                                data-bs-original-title="Item Count"
                                aria-label="Item Count"
                                >Menu De Acciones </span>
                        </button>

                        <div
                            class="dropdown-menu dropdown-menu-end col-md-2 col-1 " style="width: 153px;"
                        >
                            <div
                                class="col-12"
                                v-for="(option, idx) in optionsMenu"
                                :key="idx"
                                v-show="option.visible"
                            >
                                <el-button
                                    v-if="
                                        option.visible 
                                            
                                    "
                                    @click="trigerFunction(option.id)"
                                    class="
                                            btn btn-light
                                            m-1
                                            rounded
                                            d-flex
                                            flex-column
                                            align-items-center
                                            justify-content-center
                                            col-12
                                            "
                                    style="max-width: 150px;"
                                >
                                    <div
                                        class="text-center"
                                        style="margin-bottom: 2px"
                                    >
                                        <p
                                            style="margin: 0 !important; padding: 0 !important"
                                            v-for="(title,
                                            idx2) in option.title"
                                            :key="idx2"
                                        >
                                            {{ title }}
                                        </p>
                                        <i :class="[option.icon, 'fa-1x']"></i>
                                    </div>
                                    <div></div>
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
                
            <div v-if="screenWidth < 600" class="d-flex flex-wrap">
                <div
                    v-for="(option, idx) in optionsMenu"
                    :key="idx"
                    v-show="option.visible"
                >
                    <div
                        v-if="option.visible && option.id != 5"
                        @click="trigerFunction(option.id)"
                        class="
                  m-1
                  btn btn-light
                  rounded
                  d-flex
                  flex-column
                  align-items-center
                  justify-content-center
                "
                        style="max-width: 60px; max-height: 60px"
                    >
                        <div
                            class="text-center"
                            style="margin-bottom: 2px"
                        ></div>
                        <div>
                            <label
                                v-if="option.id == 4"
                                style="margin-left: 2px"
                                >{{ ordenInBox.length }}</label
                            >

                            <i :class="[option.icon]"> </i>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="bg-primary align-items-center rounded-top"
                style="padding-top: 12px"
            >
                <div class="row col-12" v-if="clientTableData.table">
                    <div  class="col-6">
                        <h3 class="text-white">
                            <strong style="padding-left: 20px">
                                {{
                                    ` ${
                                        isCreatingOrden
                                            ? "CREANDO ORDEN"
                                            : clientTableData.orden_id
                                            ? `(ORDEN n°
                                                                ${clientTableData.orden_id})`
                                            : ""
                                    }`
                                }}
                            </strong>
                        </h3>
                    </div>
                    <div class="col-6">
                        <h3  class="text-white" style="text-align: right">
                            Total S/. {{ (total + totalOrdenItems).toFixed(2) }}
                        </h3>
                    </div>
                </div>
                

                <div
                    class="row h5 text-white col-12"
                    style="padding-left: 25px"
                    v-if="clientTableData.table"
                >
                    <strong>
                        Mesa {{ clientTableData.table }}- Ref:
                        {{ clientTableData.ref }}
                    </strong>
                </div>
                <div class="row col-12">
                    <div class="h5 text-white col-6" style="padding-left: 25px">
                        <strong v-if="!clientTableData.table">
                            VENTA DIRECTA</strong
                        >
                    </div>

                    <div class="col-6">
                        <h3 v-if="!clientTableData.table" class="text-white" style="text-align: right">
                            Total S/. {{ (total + totalOrdenItems).toFixed(2) }}
                        </h3>
                    </div>
                </div>

                <!-- <div
                    class="p-1 m-1 col-3 rounded text-center d-flex flex-column align-items-center justify-content-center"
                    style="color:darkblue;font-weight:bold;background-color:gray"
                >
                    <div>
                        <strong>Por enviar </strong>
                        S/. {{ total ? total.toFixed(2) : 0.0 }}
                    </div>
                    <div v-if="ordens.length != 0">
                        <strong>Atendidos </strong>
                        S/.
                        {{ totalOrdenItems ? totalOrdenItems.toFixed(2) : 0.0 }}
                    </div>
                </div> -->
            </div>
            <div :class="`p-1 bg-primary`">
                <div class="row col-md-12 mx-1">
                    <div>
                        <button
                            alt="Cobrar La venta "
                            v-if="isCreatingOrden == false"
                            class="btn btn-light mt-2"
                            type="button"
                            @click="payOrden()"
                            style="max-height: 45px ; max-width: 80px;"
                        >
                            <i class="fas fa-money-bill-wave" style="color: var(--primary) !important"></i> <br> Cobrar
                        </button>
                        
                        
                        <button
                            v-if="
                                isCreatingOrden == true ||
                                    clientTableData.table == undefined
                            "
                            class="btn btn-light mt-2"
                            type="button"
                            @click="cancelOrden"
                            style="max-height: 45px ; max-width: 80px;"
                        >
                            <i class="fas fa-trash" style="color: var(--primary) !important"></i>
                            <br>
                            Limpiar
                        </button>
                        
                        
                        <button
                            v-if="
                                (isCreatingOrden == true ||
                                    clientTableData.orden_id) &&
                                    localOrden.length != 0
                            "
                            class="btn btn-light mt-2"
                            type="button"
                            @click="sendOrden()"
                            style="max-height: 45px ; max-width: 80px;"
                        >
                            <i class="fas fa-paper-plane" style="color: var(--primary) !important"></i><br>
                            Enviar
                        </button>
                        <button
                            v-if="
                                isCreatingOrden == false &&
                                    clientTableData.table != undefined &&
                                    ordens.length != 0
                            "
                            class="btn btn-light mt-2"
                            type="button"
                            @click="printOrden()"
                            style="max-height: 45px ; max-width: 80px;"
                        >
                            <i class="fas fa-print" style="color: var(--primary) !important"></i><br>
                            Imprimir
                        </button>

                        <button
                            v-if="
                                isCreatingOrden == false &&
                                    clientTableData.table != undefined &&
                                    ordens.length != 0
                            "
                            class="btn btn-light mt-2"
                            type="button"
                            style="max-height: 45px ;  max-width: 80px;"
                            @click="
                                cancelGeneralOrden(clientTableData.orden_id)
                            "
                        >
                            <i class="fas fa-window-close" style="color: var(--primary) !important" ></i><br>
                            Cancelar
                        </button>
                        <div class="dropdown-as-select d-inline-block mt-2" data-childselector="span" >
                        <button
                            class="btn p-0"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="max-height: 45px ;max-width: 150px;"
                        >
                            <span
                                class="btn btn-light dropdown-toggle"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-delay="0"
                                title=""
                                data-bs-original-title="Item Count"
                                aria-label="Item Count"
                                > Mas Opciones..<i class="fas fa-list" style="color: var(--primary) !important"></i>
                            </span>
                            
                        </button>

                        <div
                            class="dropdown-menu dropdown-menu-start col-md-2 col-1" style="max-width: 154px;"
                        >
                            <div class="col-12">
                                <el-button v-if="isCreatingOrden == false && clientTableData.table == undefined && !configuration.college " 
                                    @click="openApart"
                                    class="
                                            btn btn-light
                                            m-1
                                            rounded
                                            d-flex
                                            flex-column
                                            align-items-center
                                            justify-content-center
                                            col-12
                                            "
                                            style="max-width: 150px;"
                                >
                                    <div class="text-center"  style="margin-bottom: 2px" >
                                        <span style="margin: 0 !important; padding: 0 !important" >
                                            Aparcar
                                        </span>
                                        <i class="fas fa-cart-arrow-down" style="color: var(--primary) !important"></i>
                                    </div>
                                    <div></div>
                                </el-button>
                                  <div></div>
                                
                            </div>
                            <div class="col-12">
                                <el-button v-if="configuration.quotation &&
                                            localOrden.length != 0
                                            "
                                        class="btn btn-light
                                            m-1
                                            rounded
                                            d-flex
                                            flex-column
                                            align-items-center
                                            justify-content-center
                                            col-12
                                            "
                                        type="button"
                                        @click="openQuotation"
                                        style="max-height: 45px ;max-width: 150px;"
                                    
                                >
                                    <div
                                        class="text-center"
                                        style="margin-bottom: 2px"
                                    >
                                        <span
                                            style="margin: 0 !important; padding: 0 !important"
                                            
                                        >
                                        Cotizar
                                        </span><i class="fas fa-clipboard-list" style="color: var(--primary) !important"></i>
                                        
                                    </div>
                                    <div></div>
                                </el-button>
                            </div>
                            <div class="col-12">
                                <el-button v-if="configuration.credits && localOrden.length != 0"
                                @click="openCredit"
                                    class="
                                            btn btn-light
                                            m-1
                                            rounded
                                            d-flex
                                            flex-column
                                            align-items-center
                                            justify-content-center
                                            col-12
                                            "
                                    style="max-width: 150px;"
                                >
                                    <div
                                        class="text-center"
                                        style="margin-bottom: 2px"
                                    >
                                        <span
                                            style="margin: 0 !important; padding: 0 !important"
                                           
                                        >
                                        Crédito 
                                        </span>
                                        <i class="fas fa-credit-card" style="color: var(--primary) !important"></i>
                                        
                                    </div>
                                    <div></div>
                                </el-button>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div v-if="clientTableData.table" class="col-md-3">
                        <button
                            @click="directSale"
                            class="btn btn-warning mt-2"
                            type="button"
                            style="max-height: 45px ;"
                        >
                            Venta Directa
                        </button>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="row col-md-12 mx-1">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                    </div>
                    <!-- <div class="col-4">
                        <div v-if="ordens.length > 0 || localOrden.length > 0"
                            class="d-flex flex-column p-2 text-white">
                            <div class="row p-r-10 ">
                                <div class="col-12 f-w-700 text-end p-t-5">
                                    POR ATENDER S/ {{ total.toFixed(2) }}
                                </div>
                                <div class="col-12 f-w-700 text-end p-t-5">
                                    ATENDIDO S/ {{ totalOrdenItems.toFixed(2) }}
                                </div>
                                <div class="col-12 f-w-700 text-end p-t-5 p-b-5">
                                    TOTAL S/
                                    {{ (total + totalOrdenItems).toFixed(2) }}
                                </div>
                                <div v-if="variation" class="col-12 f-w-700 text-end text-black p-t-5 p-b-5">
                                    <template v-if="
                                        !isNaN(foodDefault.sale_unit_price)
                                    ">
                                        <strong>
                                            VARIACION S/
                                            {{
                                                Number(
                                                    foodDefault.sale_unit_price
                                                                                        ).toFixed(2)
                                            }}
                                        </strong>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="d-flex align-items-center p-1 m-2">
                    <div class="col-12">
                        <template
                            v-if="
                                configuration.restaurant &&
                                    (clientTableData.table == undefined ||
                                        configuration.box_orden)
                            "
                        >
                            <el-checkbox
                                v-if="
                                    localOrden.length != 0 &&
                                        !configuration.college
                                "
                                v-model="to_carry"
                                @change="allToCarry"
                            >
                                <span class="text-white"
                                    >Para llevar</span
                                ></el-checkbox
                            >
                        </template>
                        <template>
                            <el-checkbox
                                class="margin-left:5px;"
                                v-model="variation"
                                @change="changeVariation"
                                v-if="configuration.show_variation_dcto"
                            >
                                <span class="text-white"
                                    >Variación</span
                                ></el-checkbox
                            >
                        </template>
                        <template>
                            <el-input
                                v-if="
                                    !configuration.college &&
                                        configuration.restaurant
                                "
                                type="text"
                                maxlength="11"
                                show-word-limit
                                v-model="clientTableData.ref"
                                placeholder="Referencia (DNI)"
                            ></el-input>
                        </template>
                    </div>

                    <div
                        class="col-md-6 d-flex  justify-content-end align-items-end"
                        v-if="
                            establishments.conf &&
                                establishments.conf.direct_sale
                        "
                    >
                        <div
                            class="d-flex flex-column"
                            style="margin-left:15px;"
                        >
                            <label class="text-white">Venta rápida</label>
                            <el-switch
                                @change="changeQuickSale"
                                v-model="establishments.conf.pos_quick_sale"
                                active-color="#13ce66"
                                inactive-color="#ff4949"
                            >
                            </el-switch>
                        </div>
                        <div
                            class="d-flex flex-column"
                            style="margin-left:15px;"
                        >
                            <template v-if="establishments.conf.pos_quick_sale">
                                <label class="text-white">Impresión</label>
                                <el-switch
                                    @change="savePrint"
                                    v-model="printing"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949"
                                >
                                </el-switch>
                            </template>
                        </div>
                    </div>
                </div>
                <section
                    v-loading="loading"
                    class="scroll-section border bg-white"
                    vid="checkboxes"
                >
                    <div class="scroll-out">
                        <div
                            class="
                scroll-by-count
                os-host
                os-theme-dark
                os-host-overflow
                os-host-overflow-y
                os-host-resize-disabled
                os-host-scrollbar-horizontal-hidden
                os-host-transition
              "
                            data-count="4"
                            id="checkboxTable"
                            style="height: 71vh"
                        >
                            <!-- calc(100vh - 8rem); -->
                            <div class="os-resize-observer-host observed">
                                <div
                                    class="os-resize-observer"
                                    style="left: 0px; right: auto"
                                ></div>
                            </div>
                            <div
                                class="os-size-auto-observer observed"
                                style="height: calc(100% + 1px); float: left"
                            >
                                <div class="os-resize-observer"></div>
                            </div>
                            <div
                                class="os-content-glue"
                                style="margin: 0px 5px"
                            ></div>
                            <div class="os-padding">
                                <div
                                    class="os-viewport"
                                    style="overflow-y: scroll; margin-right: 15px"
                                >
                                    <div class="m-3"></div>
                                    <div
                                        class="os-content"
                                        style="padding: 0px 5px; height: 100%; width: 100%"
                                    >
                                        <div
                                            v-if="
                                                ordens.length != 0 && !variation
                                            "
                                            class="
                        mx-2
                        h4
                        txt-info
                        p-10
                        f-w-700
                        d-flex
                        align-items-center
                      "
                                        >
                                            <a
                                                class="badge badge bg-dark text-white"
                                                style="margin-right: 5px"
                                            >
                                                <template
                                                    v-if="ordens.length <= 9"
                                                >
                                                    0{{ ordens.length }}
                                                </template>
                                                <template v-else>
                                                    {{ ordens.length }}
                                                </template>
                                            </a>
                                            Atendidos
                                        </div>
                                        <div
                                            v-if="variation"
                                            class="col-sm-12 col-md-12 col-lg-12 col-xl-12"
                                        >
                                            <div
                                                v-for="(variationItem,
                                                idx) in foodDefaults"
                                                :key="idx"
                                                class="
                          mx-2
                          coupon
                          rounded
                          d-flex
                          justify-content-between
                        "
                                            >
                                                <div
                                                    class="
                            tengah
                            py-2
                            d-flex
                            w-100
                            justify-content-start
                            p-2
                          "
                                                >
                                                    <div
                                                        class="overflow-hidden"
                                                    >
                                                        <h3
                                                            class="lead font-weight-light"
                                                        >
                                                            {{
                                                                variationItem.description.toUpperCase()
                                                            }}
                                                            <el-tag
                                                                role="button"
                                                                @click="
                                                                    showChangeDescription(
                                                                        idx
                                                                    )
                                                                "
                                                            >
                                                                Cambiar
                                                            </el-tag>

                                                            <el-tag
                                                                type="success"
                                                                v-if="idx == 0"
                                                                role="button"
                                                                @click="
                                                                    addVariation
                                                                "
                                                            >
                                                                Agregar
                                                            </el-tag>
                                                            <el-tag
                                                                v-if="
                                                                    foodDefaults.length >
                                                                        1
                                                                "
                                                                type="danger"
                                                                role="button"
                                                                @click="
                                                                    deleteDefaultFood(
                                                                        idx
                                                                    )
                                                                "
                                                                >x
                                                            </el-tag>
                                                        </h3>
                                                        <p
                                                            class="
                                badge
                                bg-foreground
                                text-uppercase
                                font-weight-light
                                p-0
                              "
                                                        ></p>
                                                        <div
                                                            class="row align-items-end"
                                                        >
                                                            <div
                                                                class="col-md-4"
                                                            >
                                                                <span
                                                                    class="text-muted"
                                                                >
                                                                    Cantidad<br />
                                                                    <div
                                                                        class="input-group spinner"
                                                                    >
                                                                        <input
                                                                            type="text"
                                                                            class="form-control text-center"
                                                                            v-model="
                                                                                variationItem.quantity
                                                                            "
                                                                            data-rule="currency"
                                                                        />
                                                                        <div
                                                                            class="input-group-text"
                                                                        >
                                                                            <button
                                                                                type="button"
                                                                                class="spin-up"
                                                                                data-spin="up"
                                                                                @click="
                                                                                    updateDefaultFoodQty(
                                                                                        true,
                                                                                        idx
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
                                                                                    updateDefaultFoodQty(
                                                                                        false,
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
                                                                </span>
                                                            </div>

                                                            <div
                                                                class="col-md-4"
                                                            >
                                                                <span
                                                                    class="time font-weight-light"
                                                                >
                                                                    <span
                                                                        class="text-muted"
                                                                    >
                                                                        Precio
                                                                        <br />
                                                                        <el-input
                                                                            class="custom_input"
                                                                            style="width: 100%"
                                                                            type="number"
                                                                            v-model="
                                                                                variationItem.sale_unit_price
                                                                            "
                                                                        >
                                                                            <template
                                                                                slot="prepend"
                                                                                style="
                                          padding-left: 6px;
                                          padding-right: 6px;
                                        "
                                                                            >
                                                                                S/
                                                                            </template>
                                                                        </el-input>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-show="
                                                ordens.length > 0 && !variation
                                            "
                                            class="col-sm-12 col-md-12 col-lg-12 col-xl-12"
                                            v-for="(ord, idx) in ordens"
                                            :key="`${idx}-A`"
                                        >
                                            <div
                                                class="
                          mx-2
                          coupon
                          rounded
                          d-flex
                          justify-content-between
                        "
                                            >
                                                <div
                                                    class="
                            tengah
                            py-2
                            d-flex
                            w-100
                            justify-content-start
                            p-2
                          "
                                                >
                                                    <div
                                                        class="overflow-hidden card shadow-lg p-3"
                                                        style="
                              box-shadow: rgba(0, 0, 0, 0.18) 0px 1rem 3rem !important;
                            "
                                                    >
                                                        <h3
                                                            class="lead font-weight-light"
                                                        >
                                                            {{
                                                                ord.food.description.toUpperCase()
                                                            }}
                                                            <span
                                                                v-if="
                                                                    ord.type_id
                                                                "
                                                                class="text-primary"
                                                            >
                                                                <small
                                                                    ><strong
                                                                        >*{{
                                                                            ord.type_description
                                                                        }}</strong
                                                                    >
                                                                </small>
                                                            </span>
                                                        </h3>
                                                        <p
                                                            class="
                                badge
                                bg-foreground
                                text-uppercase
                                font-weight-light
                                p-0
                              "
                                                        ></p>
                                                        <div
                                                            class="row align-items-end"
                                                        >
                                                            <div
                                                                class="col-5 col-md-5 col-lg-3 col-xl-4"
                                                            >
                                                                <span
                                                                    class="text-muted"
                                                                >
                                                                    Cantidad<br />
                                                                    <div
                                                                        class="input-group spinner"
                                                                        data-trigger="spinner"
                                                                    >
                                                                        <input
                                                                            type="text"
                                                                            readonly
                                                                            class="form-control text-center"
                                                                            v-model="
                                                                                ord.quantity
                                                                            "
                                                                            data-rule="currency"
                                                                        />
                                                                        <div
                                                                            class="input-group-text"
                                                                        >
                                                                            <button
                                                                                type="button"
                                                                                class="spin-up"
                                                                                data-spin="up"
                                                                            >
                                                                                <span
                                                                                    class="arrow"
                                                                                ></span>
                                                                            </button>
                                                                            <button
                                                                                type="button"
                                                                                class="spin-down"
                                                                                data-spin="down"
                                                                            >
                                                                                <span
                                                                                    class="arrow"
                                                                                ></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>

                                                            <div
                                                                class="col-6 col-md-5 col-lg-3 col-xl-4"
                                                            >
                                                                <span
                                                                    class="time font-weight-light"
                                                                >
                                                                    <span
                                                                        class="text-muted"
                                                                    >
                                                                        Precio
                                                                        <br />
                                                                        <el-input
                                                                            class="custom_input"
                                                                            style="width: 100%"
                                                                            type="number"
                                                                            v-model="
                                                                                ord.price
                                                                            "
                                                                            @input="
                                                                                calculateTotal
                                                                            "
                                                                        >
                                                                            <template
                                                                                slot="prepend"
                                                                                v-if="
                                                                                    ord
                                                                                        .food
                                                                                        .item
                                                                                        .currency_type_id ==
                                                                                        'PEN'
                                                                                "
                                                                            >
                                                                                S/
                                                                            </template>
                                                                            <template
                                                                                slot="prepend"
                                                                                v-if="
                                                                                    ord
                                                                                        .food
                                                                                        .item
                                                                                        .currency_type_id ==
                                                                                        'USD'
                                                                                "
                                                                            >
                                                                                $
                                                                            </template>
                                                                        </el-input>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="col-md-6 m2 mt-2"
                                                            >
                                                                <el-button-group>
                                                                    <el-button
                                                                        v-if="
                                                                            ord.status_orden_id !=
                                                                                3
                                                                        "
                                                                        @click="
                                                                            ordenReady(
                                                                                ord.id
                                                                            )
                                                                        "
                                                                        type="success"
                                                                        icon="el-icon-check"
                                                                        size="mini"
                                                                        circle
                                                                    ></el-button>
                                                                    <el-button
                                                                        class="text-white"
                                                                        type="danger"
                                                                        icon="el-icon-delete"
                                                                        size="mini"
                                                                        circle
                                                                        @click="
                                                                            cancelOrdena(
                                                                                ord.id
                                                                            )
                                                                        "
                                                                    >
                                                                    </el-button>
                                                                </el-button-group>
                                                                <el-tag
                                                                    size="medium"
                                                                >
                                                                    <strong
                                                                        style="font-weight: 700"
                                                                    >
                                                                        {{
                                                                            parseFloat(
                                                                                ord.price *
                                                                                    ord.quantity
                                                                            ).toFixed(
                                                                                2
                                                                            )
                                                                        }}</strong
                                                                    >
                                                                </el-tag>
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    configuration.restaurant &&
                                                                        ord.observations
                                                                "
                                                                class="col-md-12 mt-1"
                                                            >
                                                                <small
                                                                    >OBS:
                                                                    {{
                                                                        ord.observations
                                                                    }}</small
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            v-if="configuration.restaurant"
                                            class="
                        mx-4
                        h4
                        txt-info
                        p-10
                        f-w-700
                        d-flex
                        align-items-center
                      "
                                        >
                                            <a
                                                class="badge badge bg-dark text-white"
                                                style="margin-right: 5px"
                                            >
                                                <template
                                                    v-if="
                                                        localOrden.length <= 9
                                                    "
                                                >
                                                    0{{ localOrden.length }}
                                                </template>
                                                <template v-else>
                                                    {{ localOrden.length }}
                                                </template>
                                            </a>
                                            Por solicitar
                                        </div>
                                        <div
                                            v-show="localOrden.length > 0"
                                            class="col-sm-12 col-md-12 col-lg-12 col-xl-12"
                                            v-for="(order_pend,
                                            indexx) in localOrden"
                                            :key="indexx"
                                        >
                                            <!--  -->
                                            <div
                                                class="
                          mx-2
                          coupon
                          rounded
                          d-flex
                          justify-content-between
                        "
                                            >
                                                <div
                                                    class="
                            tengah
                            py-2
                            d-flex
                            w-100
                            justify-content-start
                            p-2
                          "
                                                >
                                                    <div
                                                        class="
                              col-md-12
                              overflow-hidden
                              card
                              shadow-lg
                              p-3
                              rounded
                            "
                                                        style="
                              box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%) !important;
                            "
                                                    >
                                                        <div class="row">
                                                            <h3
                                                                class="lead font-weight-light"
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
                                                                        <strong
                                                                            >*{{
                                                                                order_pend.type_description
                                                                            }}</strong
                                                                        >
                                                                    </small>
                                                                </span>
                                                            </h3>
                                                            <p
                                                                class="
                                  badge
                                  bg-foreground
                                  text-uppercase
                                  font-weight-light
                                  p-0
                                "
                                                            ></p>
                                                        </div>
                                                        <div class="row col-12">
                                                            <div
                                                                class="col-2 col-md-2"
                                                                v-if="
                                                                    !configuration.college
                                                                "
                                                            >
                                                                <el-tag
                                                                    v-if="
                                                                        configuration.restaurant
                                                                    "
                                                                    @click="
                                                                        toCarry(
                                                                            indexx
                                                                        )
                                                                    "
                                                                    size="medium"
                                                                    role="button"
                                                                    :type="
                                                                        order_pend.to_carry
                                                                            ? 'success'
                                                                            : 'info'
                                                                    "
                                                                    :effect="
                                                                        order_pend.to_carry
                                                                            ? 'dark'
                                                                            : 'plain'
                                                                    "
                                                                >
                                                                    <i
                                                                        class="fas fa-biking"
                                                                        style="color: black"
                                                                    ></i>
                                                                </el-tag>
                                                            </div>
                                                            <div
                                                                class="col-4 col-md-4"
                                                            >
                                                                <el-button-group>
                                                                    <el-button
                                                                        class="text-white"
                                                                        type="danger"
                                                                        icon="el-icon-delete"
                                                                        size="mini"
                                                                        circle
                                                                        @click="
                                                                            deleteFood(
                                                                                indexx
                                                                            )
                                                                        "
                                                                    >
                                                                    </el-button>
                                                                    <el-button
                                                                        v-if="
                                                                            configuration.restaurant &&
                                                                                !configuration.college
                                                                        "
                                                                        class="text-white"
                                                                        type="info"
                                                                        icon="el-icon-s-order"
                                                                        size="mini"
                                                                        circle
                                                                        @click="
                                                                            openLocalObservationDialog(
                                                                                indexx,
                                                                                order_pend.observation
                                                                            )
                                                                        "
                                                                    >
                                                                    </el-button>
                                                                </el-button-group>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="row align-items-end"
                                                        >
                                                            <div
                                                                class="col-4 col-md-5 col-lg-4 col-xl-4"
                                                            >
                                                                <span
                                                                    class="text-muted"
                                                                >
                                                                    Cantidad<br />
                                                                    <div
                                                                        class="input-group spinner"
                                                                        data-trigger="spinner"
                                                                    >
                                                                        <input
                                                                            type="text"
                                                                            :readonly="
                                                                                !configuration.quantity_cash ||
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .series_enabled ==
                                                                                        1 ||
                                                                                    (order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .lots_enabled ==
                                                                                        1 &&
                                                                                        order_pend
                                                                                            .food
                                                                                            .item
                                                                                            .lots_group
                                                                                            .length >
                                                                                            1)
                                                                            "
                                                                            class="form-control text-center"
                                                                            v-model="
                                                                                order_pend.quantity
                                                                            "
                                                                            data-rule="currency"
                                                                            @input="
                                                                                verifyStock(
                                                                                    order_pend,
                                                                                    indexx
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
                                                                                :disabled="
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .series_enabled ==
                                                                                        1 ||
                                                                                        (order_pend
                                                                                            .food
                                                                                            .item
                                                                                            .lots_enabled ==
                                                                                            1 &&
                                                                                            order_pend
                                                                                                .food
                                                                                                .item
                                                                                                .lots_group
                                                                                                .length >
                                                                                                1)
                                                                                "
                                                                                @click="
                                                                                    sumar_orden(
                                                                                        indexx
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
                                                                                :disabled="
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .series_enabled ==
                                                                                        1 ||
                                                                                        (order_pend
                                                                                            .food
                                                                                            .item
                                                                                            .lotes_enabled ==
                                                                                            1 &&
                                                                                            order_pend
                                                                                                .food
                                                                                                .item
                                                                                                .lots_group
                                                                                                .length >
                                                                                                1)
                                                                                "
                                                                                @click="
                                                                                    restar_orden(
                                                                                        indexx
                                                                                    )
                                                                                "
                                                                            >
                                                                                <span
                                                                                    class="arrow"
                                                                                ></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="col-4 col-md-5 col-lg-5 col-xl-4"
                                                            >
                                                                <span
                                                                    class="time font-weight-light"
                                                                >
                                                                    <span
                                                                        class="text-muted"
                                                                    >
                                                                        Precio
                                                                        <br />
                                                                        <el-input
                                                                            class="custom_input"
                                                                            :disabled="
                                                                                order_pend.type_id !=
                                                                                    null ||
                                                                                    configuration.edit_price_sales ==
                                                                                        false
                                                                            "
                                                                            type="number"
                                                                            v-model="
                                                                                order_pend.price
                                                                            "
                                                                            @input="
                                                                                update_price(
                                                                                    indexx,
                                                                                    order_pend.price
                                                                                )
                                                                            "
                                                                        >
                                                                            <template
                                                                                slot="prepend"
                                                                                v-if="
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .currency_type_id ==
                                                                                        'PEN'
                                                                                "
                                                                            >
                                                                                S/
                                                                            </template>
                                                                            <template
                                                                                slot="prepend"
                                                                                v-if="
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .currency_type_id ==
                                                                                        'USD'
                                                                                "
                                                                            >
                                                                                $
                                                                            </template>
                                                                        </el-input>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="col-4 col-md-2 col-lg-3 mt-2"
                                                            >
                                                                <el-tag
                                                                    :disable-transitions="
                                                                        true
                                                                    "
                                                                    v-if="
                                                                        !order_pend.change_subtotal
                                                                    "
                                                                    size="medium"
                                                                >
                                                                    <strong
                                                                        style="font-weight: 700"
                                                                    >
                                                                        {{
                                                                            parseFloat(
                                                                                order_pend.price *
                                                                                    order_pend.quantity
                                                                            ).toFixed(
                                                                                2
                                                                            )
                                                                        }}</strong
                                                                    >
                                                                </el-tag>
                                                                <el-input
                                                                    v-else
                                                                    class="input-new-tag1"
                                                                    v-model="
                                                                        order_pend.newSubtotal
                                                                    "
                                                                    @input="
                                                                        justNumber(
                                                                            indexx
                                                                        )
                                                                    "
                                                                    placeholder="0.00"
                                                                    size="medium"
                                                                >
                                                                </el-input>
                                                                <template
                                                                    v-if="
                                                                        configuration.edit_subtotal_box
                                                                    "
                                                                >
                                                                    <el-tag
                                                                        v-if="
                                                                            !order_pend.change_subtotal
                                                                        "
                                                                        role="button"
                                                                        size="medium"
                                                                        @click="
                                                                            changeSubtotal(
                                                                                indexx
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="fas fa-edit text-primary"
                                                                        ></i>
                                                                    </el-tag>
                                                                    <el-tag
                                                                        v-else
                                                                        role="button"
                                                                        size="medium"
                                                                        @click="
                                                                            saveSubtotal(
                                                                                indexx
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="fas fa-save text-primary"
                                                                        ></i>
                                                                    </el-tag>
                                                                </template>
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                order_pend.food
                                                                    .item
                                                                    .series_enabled
                                                            "
                                                        >
                                                            <template
                                                                v-if="
                                                                    order_pend
                                                                        .series
                                                                        .length ==
                                                                        0
                                                                "
                                                            >
                                                                <el-tag
                                                                    style="margin-top: 5px"
                                                                    role="button"
                                                                    @click="
                                                                        showSeriesDialog(
                                                                            order_pend,
                                                                            indexx
                                                                        )
                                                                    "
                                                                    type="danger"
                                                                    >**Seleccione
                                                                    una serie
                                                                </el-tag>
                                                            </template>
                                                            <template v-else>
                                                                <div
                                                                    v-for="(serie,
                                                                    idx) in order_pend.series"
                                                                    :key="idx"
                                                                    style="margin-top: 5px"
                                                                >
                                                                    <el-tag
                                                                        type="primary"
                                                                        closable
                                                                        :disable-transitions="
                                                                            false
                                                                        "
                                                                        @close="
                                                                            deleteSerie(
                                                                                indexx,
                                                                                serie.id
                                                                            )
                                                                        "
                                                                    >
                                                                        {{
                                                                            serie.series
                                                                        }}
                                                                    </el-tag>
                                                                    <br />
                                                                </div>
                                                                <el-tag
                                                                    style="margin-top: 5px"
                                                                    role="button"
                                                                    @click="
                                                                        showSeriesDialog(
                                                                            order_pend,
                                                                            indexx
                                                                        )
                                                                    "
                                                                    type="success"
                                                                    >Ver Series
                                                                </el-tag>
                                                            </template>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                order_pend.food
                                                                    .item
                                                                    .lots_enabled &&
                                                                    !order_pend
                                                                        .food
                                                                        .item
                                                                        .series_enabled
                                                            "
                                                        >
                                                            <template
                                                                v-if="
                                                                    order_pend
                                                                        .lotes
                                                                        .length ==
                                                                        0
                                                                "
                                                            >
                                                                <el-tag
                                                                    style="margin-top: 5px"
                                                                    role="button"
                                                                    @click="
                                                                        showLotesDialog
                                                                    "
                                                                    type="danger"
                                                                    >**Seleccione
                                                                    el
                                                                    lote</el-tag
                                                                >
                                                            </template>
                                                            <template v-else>
                                                                <div
                                                                    v-for="(lot,
                                                                    idx) in order_pend.lotes"
                                                                    :key="idx"
                                                                    style="margin-top: 5px"
                                                                    v-show="
                                                                        lot.quantitySelected >
                                                                            0
                                                                    "
                                                                >
                                                                    <el-tooltip
                                                                        :content="
                                                                            `Cant. en almacén: ${lot.quantity}`
                                                                        "
                                                                    >
                                                                        <el-tag
                                                                            type="primary"
                                                                        >
                                                                            {{
                                                                                lot.code
                                                                            }}
                                                                            <template
                                                                                v-if="
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .lots_group
                                                                                        .length >
                                                                                        1
                                                                                "
                                                                            >
                                                                                -
                                                                                Cant.
                                                                                {{
                                                                                    lot.quantitySelected
                                                                                }}
                                                                            </template>
                                                                        </el-tag>
                                                                    </el-tooltip>
                                                                    <br />
                                                                </div>
                                                                <el-tag
                                                                    v-if="
                                                                        order_pend
                                                                            .food
                                                                            .item
                                                                            .lots_group
                                                                            .length >
                                                                            1
                                                                    "
                                                                    style="margin-top: 5px"
                                                                    role="button"
                                                                    @click="
                                                                        showLotesDialog(
                                                                            order_pend,
                                                                            indexx
                                                                        )
                                                                    "
                                                                    type="success"
                                                                    >Ver Lotes
                                                                </el-tag>
                                                            </template>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                order_pend.observation
                                                            "
                                                        >
                                                            <small
                                                                >OBS:
                                                                {{
                                                                    order_pend.observation
                                                                }}</small
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                        <div
                                            class="
                        d-flex
                        h-50
                        justify-content-center
                        align-items-center
                      "
                                            v-if="
                                                localOrden.length == 0 &&
                                                    !variation
                                            "
                                        >
                                            <p class="font-weight-lighter">
                                                Lista vacía.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <el-dialog
            @close="closeLocalObservationDialog"
            :visible="dialogLocalObservation"
            append-to-body
            title="Editando observación"
        >
            <span>
                <label class="control-label"> Observación </label>
                <el-input v-model="localObservation"></el-input>
            </span>
            <span slot="footer" class="dialog-footer">
                <button
                    class="btn btn-sm btn-secondary"
                    @click="changeLocalObservation"
                >
                    Cambiar
                </button>
                <button
                    class="btn btn-sm btn-light"
                    @click="closeLocalObservationDialog"
                >
                    Cerrar
                </button>
            </span>
        </el-dialog>

        <el-dialog
            :visible="apart"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            title="Aparcar orden"
            @close="apart = false"
            width="20%"
        >
            <div class="card p-2">
                <label class="control-label">Datos Referenciales</label>
                <el-input
                    v-model="numberCustomerApart"
                    placeholder="Dni o Nombre"
                >
                </el-input>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-light m-1" @click="apart = false">
                        Cancelar
                    </button>

                    <button class="btn btn-primary m-1" @click="pullApartOrden">
                        Aparcar
                    </button>
                </div>
            </div>
        </el-dialog>
        <transfers-modal
            :showDialog.sync="showTransfersDialog"
        ></transfers-modal>
        <show-lotes-product
            :idx="currentIdx"
            :orden="ordenLot"
            :showDialog.sync="showLotes"
            @updateLotes="updateLotes"
        ></show-lotes-product>
        <show-series-product
            :limitQty="limitQty"
            :idx="currentIdx"
            :item="currentItem"
            :showDialog.sync="showSeries"
            :seriesSelected.sync="currentSeries"
            @updateSeries="updateSeries"
             :establishments="establishments"
        >
        </show-series-product>

        <orden-pull-apart
            @restoreToLocalOrdens="restoreToLocalOrdens"
            :showPullApart.sync="listApart"
            :ordenInBox.sync="ordenInBox"
        >
        </orden-pull-apart>
        <table-ordens-pending
            :areas="areas"
            :showPendingOrdens.sync="showPendingOrdens"
        >
        </table-ordens-pending>
        <cash-form
            :showDialog.sync="showDialogCash"
            :recordId="cash_id"
            :fromBox="true"
         
            @updateCashId="updateCashId"
        ></cash-form>
        <close-cash
            :recordId.sync="cash_id"
            :showDialogClose.sync="showDialogClose"
            :fromBox="true"
               :configuration="configuration"
            @updateCashId="updateCashId"
        >
        </close-cash>
        <expenses-incomes
            :showDialog.sync="showExpensesIncomes"
            :company="company"
            :cash_id="cash_id"
          :establishments="establishments"
        >
        </expenses-incomes>
        <observation-form
            :current="current"
            :observations.sync="tags"
            :showDialog.sync="showObservations"
            @addObservation="addObservation"
        >
        </observation-form>
        <quotation-form
            :showDialog.sync="showQuotationForm"
            :items="localOrden"
            :customers="customers"
            @limpiarForm="limpiarForm"
            :cash_id="cash_id"
        >
        </quotation-form>

        <credit-form
            :showDialog.sync="showCreditForm"
            :items="localOrden"
            :customers="customers"
            @limpiarForm="limpiarForm"
            :cash_id="cash_id"
            :all_series.sync="all_series"
            :establishments="establishments"
        >
        </credit-form>
        <el-dialog
            :visible.sync="showChangeDescriptionVariation"
            title="Cambiar descripción"
            @close="showChangeDescriptionVariation = false"
        >
            <div class="card p-3">
                <el-input
                    placeholder="Nueva descripción"
                    v-model="descriptionTemp"
                >
                </el-input
                ><br />
                <div class="d-flex justify-content-end">
                    <el-button type="primary" @click="changeDescription">
                        Cambiar
                    </el-button>
                    <el-button @click="showChangeDescriptionVariation = false">
                        Cerrar
                    </el-button>
                </div>
            </div>
        </el-dialog>
        <el-dialog
            v-loading="deleteOrdenLoading"
            width="450px"
            :visible.sync="showPinRequest"
            title="Ingrese su PIN"
            append-to-body
        >
            <div class="row mt-1">
                <h5>
                    Para poder eliminar la orden debe ingresar un motivo y su
                    PIN de usuario.
                </h5>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <el-input
                        v-model="reasonToDelete"
                        placeholder="Ingrese un motivo"
                        type="textarea"
                        maxlength="200"
                        show-word-limit
                    ></el-input>
                </div>
            </div>
            <div class="row mt-2 d-flex justify-content-center">
                <div class="col-8 ">
                    <el-input
                        v-model="pin"
                        placeholder="Ingrese su PIN"
                        type="password"
                        maxlength="4"
                        readonly
                    ></el-input>
                </div>
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <el-button
                        v-for="num in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]"
                        :key="num"
                        class="m-2"
                        @click="generatePin(num)"
                        >{{ num }}</el-button
                    >
                    <el-button
                        @click="pin = ''"
                        class="m-2"
                        type="danger"
                        icon="el-icon-delete"
                    ></el-button>
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showPinRequest = false">Cancelar</el-button>
                <el-button type="primary" @click="cancelOrdenaPin"
                    >Eliminar</el-button
                >
            </div>
        </el-dialog>
    </div>
</template>
<style>
.el-input-group__prepend {
    padding-left: 6px !important;
    padding-right: 6px !important;
}

.custom_input .el-input__inner {
    padding: 0 5px !important;
}

.el-tag + .el-tag {
    margin-left: 10px;
}

.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}

.input-new-tag1 {
    width: 70px;
    margin-left: 10px;
    vertical-align: bottom;
}

.input-new-tag1 .el-input__inner {
    height: 30px !important;
}
</style>
<script>
const QuotationForm = () => import("./quotation_modal.vue");
const CreditForm = () => import("./credit_modal.vue");
const CashForm = () => import("../../cash/form.vue");
const CloseCash = () => import("../../cash/closecash.vue");
const OrdenPullApart = () => import("./ordens_pull_apart.vue");
const TableOrdensPending = () => import("./list_pending_ordens.vue");
const ObservationForm = () => import("../../partials/observation_form.vue");
const ExpensesIncomes = () => import("../partials/expenses_incomes.vue");
const ShowSeriesProduct = () => import("../partials/show_series_product.vue");
const ShowLotesProduct = () => import("../partials/show_lotes_product.vue");
const TransfersModal = () => import("../partials/transfer_modal.vue");
export default {
    components: {
        CreditForm,
        CashForm,
        CloseCash,
        TableOrdensPending,
        OrdenPullApart,
        ObservationForm,
        ExpensesIncomes,
        ShowSeriesProduct,
        ShowLotesProduct,
        TransfersModal,
        QuotationForm
    },
    props: [
        "all_series",
        "areas",
        "customers",
        "company",
        "customer_variation",
        "variationShow",
        "establishments",
        "itemDefault",
        "ordensPending",
        "area_id",
        "blockCart",
        "localOrden",
        "configuration",
        "ordens",
        "total2",
        "clientTableData",
        "isCreatingOrden",
        "ordenId",
        "cash_id"
    ],

    data() {
        return {
            deleteGeneralOrden: false,
            deleteOrdenLoading: false,
            reasonToDelete: null,
            ordenIdToDelete: null,
            showPinRequest: false,
            showCreditForm: false,
            showQuotationForm: false,
            limitQty: 0,
            showTransfersDialog: false,
            descriptionTemp: null,
            showChangeDescriptionVariation: false,
            variation: false,
            showObservations: false,
            boxOperation: "Abrir",
            showDialogCash: false,
            tags: [],
            showSeries: false,
            current: null,
            showDialogClose: false,
            showPendingOrdens: false,
            ordenLoading: false,
            listApart: false,
            apart: false,
            numberCustomerApart: null,
            ordenInBox: [],
            pin: "",
            totalOrdenItems: 0.0,
            total: 0.0,
            disableSend: false,
            totalOrden: 0.0,
            loading: false,
            commands_fisico: "",
            AllSelected: false,
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
            optionsMenu: [],
            foodDefault: null,
            showExpensesIncomes: false,
            showLotes: false,
            ordenLot: null,
            currentIdx: null,
            currentItem: null,
            currentSeries: [],
            screenWidth: 0,
            printing: false,
            foodDefaults: [],
            currentFoodDefault: null
        };
    },

    watch: {
        variationShow(variat, _) {
            if (this.variation && !variat) {
                this.variation = false;
            }
        },
        itemDefault(newItem, _) {
            this.foodDefault = this.itemDefault;
            this.foodDefault.quantity = 1;
            this.foodDefault.sale_unit_price = Number(
                this.foodDefault.sale_unit_price
            );
            this.foodDefaults = [{ ...this.foodDefault }];
        },
        cash_id(newCash, _) {
            this.boxOperation = newCash ? "Cerrar" : "Abrir";
            this.optionsMenu[2].title = [this.boxOperation, " Caja"];
        },
        ordens(newOrdens, _) {
            this.calculateTotal(newOrdens);
        },
        localOrden(newOrdens, _) {
            console.log(newOrdens);
            this.calculateTotal(this.ordens);
        }
    },
  
  mounted() {
    
    this.screenWidth = window.innerWidth;
    window.addEventListener("resize", this.handleResize);
    this.foodDefault = this.itemDefault;
    this.boxOperation = this.cash_id ? "Cerrar" : "Abrir";

        this.optionsMenu = [
            {
                id: 1,
                title: ["Configuración"],
                icon: "fas fa-cogs",
                visible: false
            },
            {
                id: 2,
                title: ["Recibir ", "mercaderia"],
                icon: "fas fa-people-carry",
                visible: this.configuration.receive_merchandise
            },
            {
                id: 3,
                title: [this.boxOperation, " Caja"],
                icon: "fas fa-cash-register",
                visible: true
            },
            {
                id: 7,
                title: ["Ingresos/", "/Gastos"],
                icon: "fas fa-money-bill-wave-alt",
                visible: true
            },
            {
                id: 4,
                title: ["Aparcado"],
                icon: "fas fa-cart-arrow-down",
                visible: !this.configuration.college
            },

            {
                id: 5,
                title: ["Ordenes"],
                icon: "fas fa-hourglass",
                visible:
                    this.configuration.restaurant && !this.configuration.college
            }
        ];
        let ordens = [];
        let ordensSave = localStorage.ordens;
        if (ordensSave) {
            ordens = JSON.parse(ordensSave);
        }
        this.ordenInBox = ordens;
    },
    async created() {
        let printing = localStorage.getItem("cajaPrint");

        this.printing = printing == 1;
        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });

        await this.getTags();
    },
    methods: {
        async changeQuickSale() {
            let { conf } = this.establishments;
            try {
                let response = await this.$http.post(
                    "/establishments/update_conf",
                    { ...conf }
                );
                this.$toast.success(response.data.message);
            } catch (e) {
                console.log(e);
            }
        },
        deleteDefaultFood(index) {
            this.foodDefaults = this.foodDefaults.filter((_, i) => i != index);
        },
        addVariation() {
            let foodDefault = { ...this.itemDefault };
            foodDefault.description =
                foodDefault.description +
                " " +
                Number(this.foodDefaults.length + 1);
            this.foodDefaults = [...this.foodDefaults, foodDefault];
        },
        openCredit() {
            this.showCreditForm = true;
        },
        openQuotation() {
            this.showQuotationForm = true;
        },
        savePrint() {
            localStorage.setItem("cajaPrint", this.printing ? 1 : 0);
            this.$toast.success("Configuración guardada");
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        showTransfers() {
            this.showTransfersDialog = true;
        },
        deleteSerie(index, serie_id) {
            let ordens = [...this.localOrden];

            ordens[index].series = ordens[index].series.filter(
                s => s.id != serie_id
            );
            ordens[index].quantity = ordens[index].series.length;
            this.$emit("update:localOrden", ordens);
        },
        updateSeries(idx, series) {
            let ordens = [...this.localOrden];
            ordens[idx].series = series;
            if (this.limitQty) {
                ordens[idx].quantity = series.length / this.limitQty;
            } else {
                ordens[idx].quantity = series.length;
            }

            this.$emit("update:localOrden", ordens);
        },
        updateLotes(idx, lotes) {
            let ordens = [...this.localOrden];
            ordens[idx].lotes = lotes;
            ordens[idx].quantity = lotes.reduce(
                (a, b) => a + Number(b.quantitySelected),
                0
            );
            this.$emit("update:localOrden", ordens);
        },
        showLotesDialog(orden, index) {
            this.ordenLot = orden;
            this.currentIdx = index;
            this.showLotes = true;
        },
        showSeriesDialog(orden, index = null) {
            this.limitQty = orden.type_quantity ?? 0;

            let ordens = this.localOrden.filter(l => l.id == orden.id);
            if (ordens.length == 1) {
                let [currentOrden] = ordens;
                let series = currentOrden.series.map(s => ({
                    ...s,
                    disabled: false
                }));
                this.currentSeries = series;
            } else {
                let series = [];
                for (let i = 0; i < ordens.length; i++) {
                    let currentOrden = ordens[i];
                    series = [
                        ...series,
                        ...currentOrden.series.map(s => ({
                            ...s,
                            disabled: orden.type_id != currentOrden.type_id
                        }))
                    ];
                }
                this.currentSeries = series;
            }
            this.currentItem = orden.food.item;
            // this.currentSeries = orden.series;

            this.currentIdx = index;
            this.showSeries = true;
        },
        justNumber(indexx) {
            this.localOrden[indexx].newSubtotal = this.localOrden[
                indexx
            ].newSubtotal.replace(/[^0-9.]/g, "");
        },
        updateDefaultFoodQty(bool, idx) {
            let foodDefault = this.foodDefaults[idx];
            if (bool) {
                foodDefault.quantity += 1;
            } else {
                if (foodDefault.quantity > 1) {
                    foodDefault.quantity -= 1;
                }
            }

            this.$forceUpdate();
        },
        showChangeDescription(idx) {
            this.descriptionTemp = null;
            this.currentFoodDefault = idx;
            this.showChangeDescriptionVariation = true;
        },
        changeDescription() {
            let foodDefault = this.foodDefaults[this.currentFoodDefault];
            foodDefault.description = this.descriptionTemp;
            this.showChangeDescriptionVariation = false;
        },
        changeVariation() {
            if (this.customer_variation == null) {
                this.variation = false;

                return this.$toast.error("Clientes modificado no creado");
            }
            if (this.itemDefault == null) {
                this.variation = false;

                return this.$toast.error(
                    "Producto para variación no seleccionado"
                );
            }

            this.foodDefaults = [this.foodDefault];
        },
        saveSubtotal(idx) {
            let ordensModified = [...this.localOrden];
            let currentOrden = ordensModified[idx];
            let sub = Number(currentOrden.newSubtotal);
            if (isNaN(sub) || sub <= 0) {
                ordensModified[idx].change_subtotal = false;
                ordensModified[idx].series = [];
                ordensModified[idx].lotes = [];
                ordensModified[idx].newSubtotal = null;
                this.$emit("update:localOrden", ordensModified);
                this.$toast.error("Subtotal no válido");
                return;
            }
            let qty = Number(currentOrden.quantity);
            let price = sub / qty;
            ordensModified[idx].price = price;
            ordensModified[idx].change_subtotal = false;
            ordensModified[idx].series = [];
            ordensModified[idx].lotes = [];
            ordensModified[idx].newSubtotal = null;
            this.$emit("update:localOrden", ordensModified);
            this.calculateTotal();
            this.$toast.success("Subtotal actualizado");
        },
        changeSubtotal(idx) {
            let ordensModified = [...this.localOrden];
            ordensModified[idx].change_subtotal = !ordensModified[idx]
                .change_subtotal;
            this.$emit("update:localOrden", ordensModified);
        },
        addObservation(obs) {
            let ordensModified = [...this.localOrden];
            ordensModified[this.currentLocalOrden].observation = obs;
            this.$emit("update:localOrden", ordensModified);
        },
        async getTags() {
            const response = await this.$http("../observations/records");
            if (response.status == 200) {
                const { data } = response;
                this.tags = data;
            }
        },
        async updateCashId(id) {
            this.$emit("update:cash_id", id);
        },
        cancelGeneralOrdenPin() {
            this.deleteGeneralOrden = true;
            this.showPinRequest = true;
        },
        async deleteGeneralOrdenPin() {
            try {
                this.deleteOrdenLoading = true;
                let id = this.ordens[0].orden_id;
                let form = {
                    id,
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
                        this.directSale();
                    } else {
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                if (e != "cancel") {
                    console.log(e);
                    // this.$toast.error("Ocurrió un error");
                }
            } finally {
                this.pin = "";
                this.deleteOrdenLoading = false;
            }
        },
        async cancelGeneralOrden(id) {
            if (this.configuration.pin_orden_delete) {
                this.cancelGeneralOrdenPin();
            } else {
                try {
                    let res = await this.$confirm(
                        "Desea cancelar toda la orden?",
                        "Cancelar",
                        {
                            confirmButtonText: "Ok",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    if (res) {
                        this.loading = true;

                        let form = {
                            id
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
                            this.directSale();
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
        allToCarry() {
            if (this.localOrden.length == 0) return;
            let ord = [...this.localOrden];
            ord = ord.map(o => {
                let {
                    food: {
                        item: { delivery_cost }
                    }
                } = o;
                let delivery = Number(delivery_cost);
                let factor = this.to_carry ? 1 : -1;
                let price = Number(o.price) + delivery * factor;

                return {
                    ...o,
                    to_carry: this.to_carry,
                    price
                };
            });
            this.$emit("update:localOrden", ord);
        },
        toCarry(idx) {
            let ord = [...this.localOrden];
            let {
                food: {
                    item: { delivery_cost }
                }
            } = ord[idx];
            ord[idx].to_carry = !ord[idx].to_carry;
            let delivery = Number(delivery_cost);
            let factor = ord[idx].to_carry ? 1 : -1;
            ord[idx].price = Number(ord[idx].price) + delivery * factor;

            this.$emit("update:localOrden", ord);
        },
        verifyStock(orden, idx) {
            if (this.configuration.sales_stock) {
                let current_orden = this.localOrden.filter(
                    o => o.id == orden.id
                );
                let qty = current_orden.reduce(
                    (a, b) => a + Number(b.quantity),
                    0
                );
                let stock = 0;
                if (
                    current_orden.length == 1 &&
                    current_orden[0].lotes.length == 1
                ) {
                    let [orden] = current_orden;
                    let [lote] = orden.lotes;
                    stock = lote.quantity;
                } else {
                    stock = Number(current_orden[0].food.item.stock);
                }
                if (qty > stock) {
                    this.$toast.warning("Sobrepaso el stock");
                    let localOrden_quantity = this.localOrden;
                    localOrden_quantity[idx].quantity = 1;
                    return;
                }
                if (current_orden.length == 1) {
                    let [orden] = current_orden;
                    if (orden.lotes.length == 1) {
                        orden.lotes[0].quantitySelected = this.localOrden[
                            idx
                        ].quantity;
                    }
                }
            }

            this.calculateTotal();
        },
        showOrdensPending() {
            this.showPendingOrdens = true;
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
        async printOrden() {
            this.ordenLoading = true;
            try {
                await this.printTicket(this.clientTableData.orden_id);
            } catch (e) {
                this.$toast.error("No se pudo imprimir");
            } finally {
                this.ordenLoading = false;
            }
        },
        async sendOrden() {
            if (this.localOrden.length == 0 && !this.variation) {
                this.$toast.warning("Orden sin productos");
                return;
            }
            let orden = {
                status_orden_id: 1,
                table_id: this.clientTableData.table_id,
                to_carry: this.to_carry
            };

            this.ordenLoading = true;
            try {
                const responses = await this.$http.post(
                    "/restaurant/worker/send-orden",
                    {
                        id: this.clientTableData.orden_id,
                        ref: this.clientTableData.ref,
                        items: this.localOrden,
                        caja: true,
                        printing: true,
                        saleDirect: false,
                        orden
                    }
                );
                let ordenId = responses.data.id;
                this.ordenLoading = false;
                if (responses.status != 200) {
                    this.$toast.warning("Ocurrió un error");

                    return;
                }
                this.to_carry = false;
                this.$emit("cancelOrden");
                this.$emit("update:isCreatingOrden", false);
                let msg = "";
                if (this.clientTableData.orden_id) {
                    msg = `Se agregaron los pedidos a la orden ${ordenId}`;
                } else {
                    msg = `La orden ${ordenId} fue creada.`;
                }
                this.$toast.success(msg);
            } catch (e) {
                this.ordenLoading = false;
                //no jala el clientdata tble - ref // lo guarda con el id mesa caja
                this.$toast.error("Ocurrió un error");
            }
        },
        directSale() {
            this.$emit("update:clientTableData", {});
            this.$emit("update:localOrden", []);
            this.$emit("update:ordens", []);
            this.$emit("update:blockCart", false);
            this.$emit("update:isCreatingOrden", false);
            //ordenId
            this.$emit("update:idOrden", null);
            this.$emit("resetOrden");
        },
        restoreToLocalOrdens(ordens) {
            this.$emit("update:localOrden", ordens);
        },
        trigerFunction(id) {
            switch (id) {
                case 7:
                    if (!this.cash_id) {
                        this.$toast.error("Abra una caja");
                    } else {
                        this.showExpensesIncomes = true;
                    }
                    break;
                case 2:
                    this.showTransfers();
                    break;
                case 3:
                    if (this.cash_id) {
                        this.showDialogClose = true;
                    } else {
                        this.showDialogCash = true;
                    }
                    break;
                case 5:
                    this.showOrdensPending();
                    break;
                case 4:
                    if (this.ordenInBox.length > 0) {
                        this.listApart = true;
                    } else {
                        this.$toast.warning("Sin ventas apartacadas.");
                    }
                    break;

                default:
                    //naa
                    break;
            }
        },
        limpiarForm() {
            this.$emit("limpiarForm");
        },
        openApart() {
            if (this.localOrden.length == 0) {
                this.$toast.error("Sin ordenes pendientes");
                return;
            }
            this.apart = true;
        },
        pullApartOrden() {
            if (
                !this.numberCustomerApart &&
                this.numberCustomerApart.length <= 1
            ) {
                this.$toast.error("Documento o referencia inválida");
                return;
            } else if (this.ordenInBox.length == 3) {
                this.$toast.error("Limite excedido. ");
                return;
            } else if (
                this.ordenInBox.some(
                    f =>
                        f.ref.toLowerCase() ==
                        this.numberCustomerApart.toLowerCase()
                )
            ) {
                this.$toast.error("La referencia ya existe");
                return;
            } else {
                this.ordenInBox.push({
                    ref: this.numberCustomerApart,
                    ordens: this.localOrden
                });

                localStorage.ordens = JSON.stringify(this.ordenInBox);
                this.numberCustomerApart = undefined;
                this.apart = false;
                this.$emit("cancelOrden");
                this.$toast.success("Orden aparcada");
            }
        },
        async cancelOrden() {
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
                this.$emit("cancelOrden");
            }
        },
        addNumberPin(number) {
            if (this.pin.length >= 4) {
                return;
            }
            this.pin += number.toString();
        },
        close() {
            this.$emit("update:localOrden", []);
        },
        update_price(index, sale_unit_price) {
            let localOrden_update = this.localOrden;
            localOrden_update[index].food.sale_unit_price = sale_unit_price;
            this.$emit("update:localOrden", localOrden_update);
            this.calculateTotal();
        },
        sumar_orden(index) {
            if (this.validStock(this.localOrden[index])) {
                this.$toast.warning("Limite de stock alcanzado");
                return;
            }
            let localOrden_quantity = this.localOrden;
            if (this.localOrden[index].type_id) {
                localOrden_quantity[index].quantity =
                    Number(localOrden_quantity[index].quantity) + 1;
                // localOrden_quantity[index].quantity =
                //     Number(localOrden_quantity[index].quantity) +
                //     Number(localOrden_quantity[index].type_quantity);
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
        async printTicket(id) {
            try {
                const response = await this.$http.get(
                    `/restaurant/worker/record/${id}`
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
        clear_command() {
            this.commands_fisico = null;
        },
        checkIsExistSerie() {
            let hasError = false;
            for (let ord of this.localOrden) {
                let { series_enabled } = ord.food.item;

                if (series_enabled && ord.series.length == 0) {
                    hasError = true;
                    break;
                }
            }
            return hasError;
        },
        async payOrden() {
            if (this.checkIsExistSerie()) {
                this.$toast.error("Producto sin serie seleccionada");
                return;
            }
            if (!this.cash_id) {
                this.$toast.error("No tiene una caja abierta");
                return;
            }
            if (this.clientTableData.table) {
                if (this.ordens.length == 0) {
                    this.$toast.warning("Orden sin productos");
                    return;
                }
            } else {
                if (this.localOrden.length == 0 && !this.variation) {
                    this.$toast.warning("Orden sin productos");
                    return;
                }
            }

            this.disableSend = true;
            let form_submit = {
                id: null,
                caja: true,
                printDocument: this.printing,
                printing: this.configuration.print_commands,
                commands_fisico: this.commands_fisico,
                print_kitchen: this.configuration.print_kitchen,
                to_carry: this.to_carry,
                orden: {
                    table_id: 1,
                    status_orden_id: 1
                },
                //enviar las ordenes a cobrar
                //  items: this.ordens,
                // items: this.localOrden,
                pin: null
            };
            if (this.clientTableData.table) {
                form_submit.items = this.ordens;
            } else {
                form_submit.items = this.localOrden;
            }
            this.loading = true;
            // const responses = await this.$http.post(
            //     "/restaurant/worker/send-orden",
            //     form_submit
            // );

            this.commands_fisico = "";
            this.to_carry = false;
            //    let IdOrdensend = responses.data.id;
            //    if (responses.data.success == true) {

            this.loading = false;
            // this.$toast.success(responses.data.message);
            this.disableSend = false;
            //      document.querySelector("#close_offcanvas").click();
            // } else {
            //     this.loading = false;
            //     this.$toast.error(responses.data.message);
            // }
            if (this.variation) {
                form_submit.variationItems = this.foodDefaults;
            }
            this.loading = false;
            this.disableSend = false;

            if (this.variation) {
                this.$emit("paymentsOrden", form_submit, this.foodDefaults);
            } else {
                this.$emit("paymentsOrden", form_submit);
            }
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        // async cancelGeneralOrden() {
        //     this.loading = true;
        //     try {
        //         let res = await this.$confirm(
        //             "Desea cancelar toda la orden?",
        //             "Cancelar",
        //             {
        //                 confirmButtonText: "Ok",
        //                 cancelButtonText: "Cancelar",
        //                 type: "warning"
        //             }
        //         );
        //         if (res) {
        //             let form = {
        //                 id: this.ordens[0].orden_id
        //             };
        //             const response = await this.$http.post(
        //                 "cancel-orden",
        //                 form
        //             );
        //             if (response.status == 200) {
        //                 const { message } = response.data;
        //                 this.$toast.success(message);
        //                 this.$eventHub.$emit("reloadData");
        //                 this.$emit("ordenDeleted");
        //                 this.directSale();
        //             }
        //         }
        //     } catch (e) {
        //         if (e != "cancel") {
        //             console.log(e);
        //             this.$toast.error("Ocurrió un error");
        //         }
        //     }
        //     this.loading = false;
        // },
        calculateTotal(w = null) {
            this.totalOrdenItems = 0.0;
            this.total = 0.0;
            this.totalOrden = 0.0;
            let OrdenPen = 0;
            let OrdenPenAtendidos = 0;
            let nTotal_poratendidos = _.forEach(this.localOrden, function(
                value
            ) {
                OrdenPen = parseFloat(OrdenPen) + value.quantity * value.price;
            });
            this.totalOrden = _.round(OrdenPen, 2);
            let nTotal_atendidos = _.forEach(this.ordens, function(values) {
                OrdenPenAtendidos =
                    parseFloat(OrdenPenAtendidos) +
                    values.quantity * values.price;
            });
            this.totalOrdenItems = _.round(OrdenPenAtendidos, 2);
            // this.total = this.totalOrden + this.totalOrdenItems;
            this.total = _.round(this.totalOrden, 2);
            this.$emit("total_salcancelOrdenaes", this.total);
        },
        deleteFood(idx) {
            this.$emit("deletedFood", idx);
            this.calculateTotal();
        },
        async submit() {
            //this.loading = true;
            this.showDialogPing = true;
            this.open_orders();
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
        async cancelOrdena(id) {
            if (this.configuration.pin_orden_delete) {
                this.showPinRequest = true;
                this.ordenIdToDelete = id;
            } else {
                try {
                    let x = await this.$confirm(
                        `Está apunto de cancelar un producto de una orden.`,
                        "Mensaje de Advertencia",
                        {
                            confirmButtonText: "Eliminar",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    if (id && x) {
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
                    console.log(e);
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
            } finally {
                this.loading = false;
            }
        },
        changeLocalObservation() {
            let ordensModified = [...this.localOrden];
            ordensModified[
                this.currentLocalOrden
            ].observation = this.localObservation;
            this.$emit("update:localOrden", ordensModified);
            this.closeLocalObservationDialog();
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

        openLocalObservationDialog(idx, obs) {
            this.showObservations = true;
            this.currentLocalOrden = idx;
            this.current = obs;
            return;

            this.localObservation = this.localOrden[idx].observation;
            this.dialogLocalObservation = true;
        },
        closeLocalObservationDialog() {
            this.dialogLocalObservation = false;
            this.currentLocalOrden = null;
            this.localObservation = null;
        }
    }
};
</script>
