<!-- Zona de Atención Hotel -->
<template>
    <el-dialog
        :visible="showTables"
        v-loading="loading"
        @open="open"
        @close="close"
        width="83%"
        :title="titleDialog"
        :close-on-click-modal="false"
        :class="{ top }"
    >
        <div class="row">
            <!-- torres y pisos -->
            <div class="col-5 d-flex justify-content-start align-items-center">
                <div
                    class="card"
                    style="padding: 3px; background-color: #6c757d; display: inline-block; width: auto; margin-right: 10px;"
                >
                    <div
                        class="card-body"
                        style="padding: 0px;"
                        v-if="!viewingRoom && !isChangingRoom"
                    >
                        <span style="color: #000; font-weight: bold;"
                            >Torre</span
                        >
                        <br />
                        <div class="d-flex align-items-center">
                            <img
                                src="/images/imghotel/12.png"
                                alt="Imagen"
                                width="40"
                                height="40"
                                style="margin-right: 10px;"
                            />
                            <vs-button
                                v-for="(tower, idx) in towers"
                                :key="idx"
                                :active="tower_id == tower.id || active == 1"
                                @click="
                                    filterFloorsByTower(tower.id);
                                    active = 1;
                                "
                                style="margin-right:5px; border: 1px solid #ccc; border-radius: 8px; width: 30px; height: 30px;"
                                :class="
                                    tower_id == tower.id
                                        ? 'btn-primary text-white'
                                        : 'btn-light text-muted'
                                "
                                :style="
                                    tower_id == tower.id
                                        ? 'background-color: #073f68;'
                                        : ''
                                "
                            >
                                <el-tooltip
                                    :content="tower.name"
                                    placement="top"
                                >
                                    <span>{{ idx + 1 }}</span>
                                </el-tooltip>
                                <!-- {{ tower.name }} -->
                            </vs-button>
                            <button
                                v-if="isChangingRoom"
                                type="button"
                                style="margin-left:15px;"
                                class="btn btn-secondary"
                                @click="isChangingRoom = false"
                            >
                                Cancelar Cambio
                            </button>
                        </div>
                    </div>
                    <div v-else class="d-flex align-items-center">
                        <el-tooltip
                            content="Regresar a la Zona de Atención"
                            placement="top"
                        >
                            <button
                                v-if="viewingRoom"
                                type="button"
                                style="margin-left:15px; background-color: #ec1313; color: white;"
                                class="btn d-flex align-items-center"
                                @click="close2"
                            >
                                <i
                                    class="fas fa-arrow-left"
                                    style="margin-right: 5px;"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip
                            :content="
                                isChangingRoom
                                    ? 'Cancelar Cambio de Habitación'
                                    : 'Reubicar Habitación'
                            "
                            placement="top"
                        >
                            <button
                                type="button"
                                style="margin-left:15px;"
                                :class="
                                    isChangingRoom
                                        ? 'btn d-flex align-items-center'
                                        : 'btn btn-secondary d-flex align-items-center'
                                "
                                :style="
                                    isChangingRoom
                                        ? 'background-color: #ec1313; color: white;'
                                        : 'background-color: #073f68; color: white;'
                                "
                                @click="changeRoom"
                            >
                                <i
                                    :class="
                                        isChangingRoom
                                            ? 'fas fa-times'
                                            : 'fas fa-exchange-alt'
                                    "
                                    style="margin-right: 5px;"
                                ></i>
                            </button>
                        </el-tooltip>
                        <button
                            type="button"
                            style="margin-left:15px; background-color: #7030a0; color: white;"
                            class="btn btn-secondary d-flex align-items-center"
                            @click="reserveRoom"
                        >
                            <i
                                class="fas fa-calendar-alt"
                                style="margin-right: 5px;"
                            ></i>
                            Reservar
                        </button>
                    </div>
                </div>

                <div
                    class="card"
                    style="padding: 3px; background-color: #6c757d; display: inline-block; width: auto;"
                    v-if="!viewingRoom"
                >
                    <div
                        class="card-body"
                        style="padding: 0px;"
                        v-if="floors.length > 0"
                    >
                        <span style="color: #000; font-weight: bold;"
                            >Piso</span
                        >
                        <br />
                        <div class="d-flex align-items-center">
                            <img
                                src="/images/imghotel/13.png"
                                alt="Imagen"
                                width="40"
                                height="40"
                                style="margin-right: 10px;"
                            />
                            <vs-button
                                v-for="(floor, idx) in floors"
                                :key="idx"
                                :active="floor_id == floor.id || active == 2"
                                @click="
                                    filterTablesByFloor(floor.id);
                                    active = 1;
                                "
                                style="margin-right:5px; border: 1px solid #ccc; border-radius: 8px; width: 30px; height: 30px;"
                                :class="
                                    floor_id == floor.id
                                        ? 'btn-primary text-white'
                                        : 'btn-light text-muted'
                                "
                                :style="
                                    floor_id == floor.id
                                        ? 'background-color: #073f68;'
                                        : ''
                                "
                            >
                                <span>{{
                                    typeof floor.name === "string"
                                        ? floor.name.replace("Piso ", "")
                                        : ""
                                }}</span>
                                <el-tooltip
                                    :content="floor.name || ''"
                                    placement="top"
                                >
                                    {{ floor.name }}
                                </el-tooltip>
                            </vs-button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botones de filtro -->
            <div class="col-6 d-flex justify-content-end">
                <!-- Alquiler Mensual -->
                <el-tooltip>
                    <div slot="content">Mensual {{ all_months }}</div>
                    <vs-button
                        icon
                        relief
                        warn
                        animation-type="rotate"
                        @click="filterByMonth"
                        v-if="!viewingRoom && !isChangingRoom"
                        type="button"
                        style="width: 45px; height: 40px;"
                        class="btn btn-sm"
                    >
                        <img
                            src="/images/imghotel/9.png"
                            alt="Imagen"
                            width="20"
                            height="20"
                        />
                        <template #animate>
                            <img
                                src="/images/imghotel/9.png"
                                alt="Imagen"
                                width="20"
                                height="20"
                            />
                        </template>
                    </vs-button>
                </el-tooltip>

                <el-tooltip v-for="(statu, idx) in status" :key="idx">
                    <div slot="content">
                        {{ statu.description }} {{ statu.count }}
                    </div>
                    <vs-button
                        icon
                        relief
                        animation-type="rotate"
                        @click="filterByStatus(statu.id)"
                        v-if="!viewingRoom && !isChangingRoom"
                        type="button"
                        style="width: 45px; height: 40px;"
                        class="btn btn-sm"
                        :style="{
                            backgroundColor:
                                statu.id == 1
                                    ? '#006400'
                                    : statu.id == 2
                                    ? '#9f1019'
                                    : statu.id == 3
                                    ? '#000000'
                                    : statu.id == 5
                                    ? '#0e7ea6'
                                    : '#FFC300',
                            borderColor:
                                statu.id == 1
                                    ? '#7030a0'
                                    : statu.id == 2
                                    ? '#9f1019'
                                    : statu.id == 3
                                    ? '#000000'
                                    : statu.id == 5
                                    ? '#0e7ea6'
                                    : '#FFC300'
                        }"
                    >
                        <img
                            :src="
                                statu.id == 1
                                    ? '/images/imghotel/6.png'
                                    : statu.id == 2
                                    ? '/images/imghotel/2.png'
                                    : statu.id == 3
                                    ? '/images/imghotel/1.png'
                                    : statu.id == 5
                                    ? '/images/imghotel/5.png'
                                    : '/images/imghotel/3.png'
                            "
                            :alt="statu.description"
                            width="20"
                            height="20"
                        />
                        <template #animate>
                            <img
                                :src="
                                    statu.id == 1
                                        ? '/images/imghotel/6.png'
                                        : statu.id == 2
                                        ? '/images/imghotel/2.png'
                                        : statu.id == 3
                                        ? '/images/imghotel/1.png'
                                        : statu.id == 5
                                        ? '/images/imghotel/5.png'
                                        : '/images/imghotel/3.png'
                                "
                                :alt="statu.description"
                                width="20"
                                height="20"
                            />
                        </template>
                    </vs-button>
                </el-tooltip>

                <el-tooltip>
                    <div slot="content">
                        Reservadas ({{ all_reserves.length }})
                    </div>
                    <vs-button
                        icon
                        relief
                        animation-type="rotate"
                        @click="filterByReserve"
                        v-if="!viewingRoom && !isChangingRoom"
                        type="button"
                        style="width: 45px; height: 40px; background-color: #7030a0; border-color: #7030a0;"
                        class="btn btn-sm btn-reserve"
                    >
                        <img
                            src="/images/imghotel/3.png"
                            alt="Imagen"
                            width="20"
                            height="20"
                        />
                        <template #animate>
                            <img
                                src="/images/imghotel/3.png"
                                alt="Imagen"
                                width="20"
                                height="20"
                            />
                        </template>
                    </vs-button>
                </el-tooltip>
            </div>
        </div>
        <!-- en la Habitación -->
        <div v-if="ordens.length == 0 || hasSelectedOrdenToChange">
            <div class="card">
                <div class="-cardbody" :style="{ padding: '10px' }">
                    <template v-if="viewingRoom && currentRoom">
                        <div class="row m-2 align-items-center">
                            <div class="col-9">
                                <label for="customer"
                                    ><strong>Huesped :</strong></label
                                >
                                <label
                                    id="customer"
                                    style="color: #073f68; font-weight: bold;"
                                >
                                    {{ currentRoom.customer }}
                                </label>
                            </div>

                            <div class="col-3 d-flex justify-content-end">
                                <template v-if="currentRoom.credit_line > 0">
                                    <el-tooltip
                                        content="Garantía de Frigobar"
                                        placement="top"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            style="margin-top:20px; max-width: 100%;"
                                        >
                                            <i class="fas fa-shield-alt"></i>
                                            Garantía S/.{{
                                                currentRoom.credit_line.toFixed(
                                                    2
                                                )
                                            }}
                                        </button>
                                    </el-tooltip>
                                </template>
                            </div>
                        </div>

                        <!-- aqui los datos de Registro de la habitación -->
                        <div class="row m-2">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body" style="padding: 0;">
                                        <div class="col-lg-12 col-12 d-flex">
                                            <div
                                                class="col-lg-6 col-12"
                                                style="text-align: left; padding: 5;"
                                            >
                                                <label
                                                    for="checkin_datetime"
                                                    style="text-align: center; display: block;"
                                                >
                                                    Fecha Ingreso
                                                </label>
                                                <div
                                                    style="text-align: center;"
                                                >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="checkin_date"
                                                        :value="
                                                            `${new Date(
                                                                currentRoom.checkin_date +
                                                                    'T12:00:00'
                                                            ).toLocaleDateString(
                                                                'es-ES',
                                                                {
                                                                    weekday:
                                                                        'long',
                                                                    day:
                                                                        '2-digit',
                                                                    month:
                                                                        'long'
                                                                }
                                                            )}`
                                                        "
                                                        disabled
                                                    />
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="checkin_time"
                                                        :value="
                                                            currentRoom.checkin_time.slice(
                                                                0,
                                                                5
                                                            )
                                                        "
                                                        disabled
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="col-lg-6 col-12"
                                                v-if="
                                                    currentRoom.checkout_date_estimated &&
                                                        currentRoom.checkout_time_estimated
                                                "
                                                style="text-align: left; padding: 0;"
                                            >
                                                <label
                                                    for="checkout_datetime"
                                                    style="text-align: center; display: block;"
                                                >
                                                    Fecha Salida
                                                </label>
                                                <div
                                                    style="text-align: center;"
                                                >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="checkout_date"
                                                        :value="
                                                            `${new Date(
                                                                currentRoom.checkout_date_estimated +
                                                                    'T12:00:00'
                                                            ).toLocaleDateString(
                                                                'es-ES',
                                                                {
                                                                    weekday:
                                                                        'long',
                                                                    day:
                                                                        '2-digit',
                                                                    month:
                                                                        'long'
                                                                }
                                                            )}`
                                                        "
                                                        disabled
                                                    />
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="checkout_time"
                                                        :value="
                                                            currentRoom.checkout_time_estimated.slice(
                                                                0,
                                                                5
                                                            )
                                                        "
                                                        disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <label for="duration">
                                                    <strong>Duración</strong>
                                                    <a
                                                        href="#"
                                                        data-toggle="tooltip"
                                                        title="Días"
                                                        @click="
                                                            showAddDays = true
                                                        "
                                                    >
                                                        [+
                                                        {{
                                                            currentRoom
                                                                ? currentRoom.is_month_rent
                                                                    ? "Meses"
                                                                    : "Días"
                                                                : ""
                                                        }}]
                                                    </a>
                                                </label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="duration"
                                                    v-model="
                                                        currentRoom.duration
                                                    "
                                                    disabled
                                                />
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <label for="quantity">
                                                    Ocupantes
                                                    <a
                                                        href="#"
                                                        data-toggle="tooltip"
                                                        title="persons"
                                                        @click="
                                                            seeGuesses(
                                                                currentRoom
                                                            )
                                                        "
                                                        style="color: #073f68;"
                                                    >
                                                        <i
                                                            class="fas fa-eye"
                                                            style="color: green;"
                                                            title="Visualizar los ocupantes de la Habitación"
                                                        ></i>
                                                    </a>
                                                </label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="quantity"
                                                    v-model="
                                                        currentRoom.quantity_persons
                                                    "
                                                    disabled
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row m-2 ">
                            <div class="col-2">
                                <el-tooltip
                                    content="Solo aplica cuando no cumple con el horario final habitual"
                                    placement="top"
                                >
                                    <label for="extra_time">Media tarifa</label>
                                </el-tooltip>
                                <el-input
                                    readonly
                                    type="number"
                                    class="w-100"
                                    v-model="extra_time"
                                    disabled
                                ></el-input>
                            </div>
                            <div class="col-10 text-right">
                                <!-- <template v-if="currentRoom.credit_line > 0">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        style="margin-top:20px;"
                                    >
                                        <i class="fas fa-shield-alt"></i> Garantía S/.{{
                                            currentRoom.credit_line.toFixed(2)
                                        }}
                                    </button>
                                </template> -->
                                <el-tooltip
                                    content="Hacer pedido de productos adicionales a la Habitación"
                                    placement="top"
                                >
                                    <button
                                        v-if="!currentRoom.is_month_rent"
                                        type="button"
                                        class="btn btn-success btn-sm"
                                        @click="createOrden"
                                        style="margin-top:20px;"
                                    >
                                        <i
                                            class="fas fa-box"
                                            style="margin-right: 5px;"
                                        ></i
                                        >Productos
                                    </button>
                                </el-tooltip>
                                <el-tooltip
                                    content="Ver las promociones que corresponden al alquiler, así mismo se puede reimprimir ticket"
                                    placement="top"
                                >
                                    <button
                                        v-if="currentRoom.has_services"
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        @click="checkServices(currentRoom.id)"
                                        style="margin-top:20px;"
                                    >
                                        <i
                                            class="fas fa-gift"
                                            style="margin-right: 5px;"
                                        ></i
                                        >Promoción
                                    </button>
                                </el-tooltip>

                                <template
                                    v-if="
                                        currentRoom.toPay &&
                                            !currentRoom.is_month_rent
                                    "
                                >
                                    <el-tooltip
                                        content="Hacer el pago completo de lo  que se ocupó y se ha consumido"
                                        placement="top"
                                    >
                                        <button
                                            @click="payAll"
                                            type="button"
                                            class="btn btn-sm"
                                            style="margin-top:20px; background-color: #073f68; color: white;"
                                        >
                                            <i
                                                class="fas fa-credit-card"
                                                style="margin-right: 5px;"
                                            ></i
                                            >Pagar
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip
                                        content="Pagar con  Variación: Cambia el contenido del consumo por algo en particular"
                                        placement="top"
                                    >
                                        <button
                                            v-if="configuration.variation_hotel"
                                            @click="clickShowVariationModal"
                                            type="button"
                                            class="btn btn-info btn-sm"
                                            style="margin-top:20px;"
                                        >
                                            <i
                                                class="fas fa-exchange-alt"
                                                style="margin-right: 5px;"
                                            ></i
                                            >Variación
                                        </button>
                                    </el-tooltip>
                                </template>

                                <el-tooltip
                                    content="Desocupar la habitación antes de finalizar el periodo de alquiler"
                                    placement="top"
                                    v-else
                                >
                                    <button
                                        @click="desocupiedRoom(currentRoom.id)"
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        style="margin-top:20px;"
                                    >
                                        <i
                                            class="fas fa-door-open"
                                            style="margin-right: 5px;"
                                        ></i
                                        >Desocupar
                                    </button>
                                </el-tooltip>
                                <el-tooltip
                                    content="Hacer el pago completo de lo  que se ocupó y se ha consumido"
                                    placement="top"
                                >
                                    <button
                                        v-if="
                                            currentRoom.is_month_rent &&
                                                currentRoom.toPay
                                        "
                                        @click="payAll"
                                        type="button"
                                        class="btn btn-sm"
                                        style="margin-top:20px; background-color: #073f68; color: white;"
                                    >
                                        <i
                                            class="fas fa-credit-card"
                                            style="margin-right: 5px;"
                                        ></i
                                        >Pagar
                                    </button>
                                </el-tooltip>

                                <el-tooltip
                                    content="Anula el alquiler y todos los consumos que contengan"
                                    placement="top"
                                >
                                    <button
                                        @click="cancelRoom"
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        style="margin-top:20px;"
                                    >
                                        <i
                                            class="fas fa-times-circle"
                                            style="margin-right: 5px;"
                                        ></i
                                        >Anular
                                    </button>
                                </el-tooltip>
                            </div>
                        </div>
                        <div class="card mt-3 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">
                                    <i class="fas fa-chart-line"></i> Resumen de
                                    Consumo
                                </h5>
                                <div
                                    class="d-flex flex-wrap align-items-center gap-3"
                                >
                                    <div
                                        class="d-flex flex-column align-items-start"
                                        style="margin-right: 15px;"
                                    >
                                        <span class="fw-bold text-secondary h5"
                                            >Habitación:</span
                                        >
                                        <span class="text-dark h4">{{
                                            Number(
                                                currentRoom.total_room
                                            ).toFixed(2)
                                        }}</span>
                                    </div>
                                    <div
                                        class="d-flex flex-column align-items-start"
                                        style="margin-right: 15px;"
                                    >
                                        <span class="fw-bold text-secondary h5"
                                            >Adelantos:</span
                                        >
                                        <span class="text-dark h4">{{
                                            Number(currentRoom.advance).toFixed(
                                                2
                                            )
                                        }}</span>
                                    </div>
                                    <div
                                        class="d-flex flex-column align-items-start"
                                        style="margin-right: 15px;"
                                    >
                                        <span class="fw-bold text-secondary h5"
                                            >Resta S/:</span
                                        >
                                        <span class="text-success h4">{{
                                            (
                                                Number(currentRoom.total) +
                                                Number(extra_time)
                                            ).toFixed(2)
                                        }}</span>
                                    </div>
                                    <div
                                        class="d-flex flex-column align-items-start"
                                        style="margin-right: 15px;"
                                    >
                                        <span class="fw-bold text-secondary h5"
                                            >Órdenes:</span
                                        >
                                        <span class="text-dark h4">{{
                                            Number(
                                                currentRoom.total_orden
                                            ).toFixed(2)
                                        }}</span>
                                    </div>

                                    <template v-if="extra_time > 0">
                                        <div
                                            class="d-flex flex-column align-items-start"
                                            style="margin-right: 15px;"
                                        >
                                            <span
                                                class="fw-bold text-secondary h5"
                                                >Penalidad:</span
                                            >
                                            <span class="text-danger h4">{{
                                                Number(extra_time).toFixed(2)
                                            }}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 shadow-sm border-0">
                            <!-- Ordenes o pedidos adicionales -->
                            <div
                                class="row m-2"
                                v-if="currentRoom.ordens.length > 0"
                            >
                                <h5
                                    class="card-title text-primary mb-3"
                                    v-if="currentRoom.ordens.length > 0"
                                >
                                    <i class="fas fa-box-open"></i> Productos
                                    Adicionales
                                </h5>
                                <el-collapse
                                    v-model="activeOrdenRoom"
                                    accordion
                                >
                                    <el-collapse-item
                                        v-for="(orden,
                                        idx) in currentRoom.ordens"
                                        :key="idx"
                                        :name="idx + 1"
                                        style="background-color: #d4edda !important; border-top: none !important; border-bottom: none !important;"
                                    >
                                        <template slot="title">
                                            <div
                                                class="w-100 d-flex justify-content-between align-items-center"
                                            >
                                                <div
                                                    :class="[
                                                        'font-weight-bold',
                                                        orden.paid
                                                            ? 'text-success'
                                                            : 'text-danger'
                                                    ]"
                                                >
                                                    <span class="mx-2"> </span>
                                                    {{ orden.date }}
                                                    <span class="mx-2">|</span>
                                                    <span>
                                                        Hora:
                                                        {{
                                                            new Date(
                                                                orden.date
                                                            ).toLocaleTimeString(
                                                                "es-ES",
                                                                {
                                                                    hour:
                                                                        "2-digit",
                                                                    minute:
                                                                        "2-digit"
                                                                }
                                                            )
                                                        }}
                                                    </span>
                                                    <span class="mx-2">|</span>
                                                    <span
                                                        >Total:
                                                        <strong
                                                            >S/.
                                                            {{
                                                                orden.total
                                                            }}</strong
                                                        ></span
                                                    >
                                                    {{
                                                        orden.paid
                                                            ? "Cancelado"
                                                            : ""
                                                    }}
                                                </div>
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <el-tooltip
                                                        content="Ver documento PDF"
                                                        placement="top"
                                                    >
                                                        <a
                                                            v-if="
                                                                orden.document
                                                            "
                                                            :href="
                                                                orden.document
                                                            "
                                                            target="_blank"
                                                            class="btn btn-success btn-sm mx-1"
                                                        >
                                                            <i
                                                                class="fas fa-file-pdf"
                                                            ></i>
                                                        </a>
                                                    </el-tooltip>
                                                    <el-tooltip
                                                        content="Agregar más productos a este pedido"
                                                        placement="top"
                                                    >
                                                        <button
                                                            class="btn btn-primary btn-sm mx-1"
                                                            @click="
                                                                getOrden(
                                                                    orden.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-plus"
                                                            ></i>
                                                            Agregar Productos
                                                        </button>
                                                    </el-tooltip>
                                                    <!-- <el-tooltip content="Eliminar orden" placement="top">
                                                    <button
                                                        class="btn btn-danger btn-sm mx-1"
                                                        @click="deleteOrden(orden.id)"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </el-tooltip> -->
                                                </div>
                                            </div>
                                        </template>
                                        <table class="table">
                                            <thead
                                                style="background-color: #073f68; color: white;"
                                            >
                                                <tr>
                                                    <th style="color: white;">
                                                        Cantidad
                                                    </th>
                                                    <th style="color: white;">
                                                        Producto
                                                    </th>
                                                    <th style="color: white;">
                                                        Precio
                                                    </th>
                                                    <th style="color: white;">
                                                        Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(item,
                                                    idx) in orden.items"
                                                    :key="idx"
                                                >
                                                    <td>
                                                        {{
                                                            Math.floor(
                                                                item.quantity
                                                            )
                                                        }}
                                                    </td>
                                                    <td>{{ item.name }}</td>
                                                    <td>{{ item.price }}</td>
                                                    <td>{{ item.total }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </el-collapse-item>
                                </el-collapse>
                            </div>
                            <div
                                class="row m-2"
                                v-if="currentRoom.documents.length > 0"
                            >
                                <div class="col-12">
                                    <h5
                                        class="card-title text-primary mb-3"
                                        v-if="currentRoom.ordens.length > 0"
                                    >
                                        <i class="fas fa-file-invoice"></i>
                                        Comprobantes Generados
                                    </h5>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table class="table">
                                        <thead
                                            style="background-color: #073f68; color: white;"
                                        >
                                            <tr>
                                                <th style="color: white;">
                                                    CPE
                                                </th>
                                                <th style="color: white;">
                                                    Fecha de Emisión
                                                </th>
                                                <th style="color: white;">
                                                    Total
                                                </th>
                                                <th style="color: white;">
                                                    PDF
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(document,
                                                idx) in currentRoom.documents"
                                                :key="idx"
                                            >
                                                <td>{{ document.number }}</td>
                                                <td>
                                                    {{ document.date_of_issue }}
                                                </td>
                                                <td>{{ document.total }}</td>
                                                <td>
                                                    <a
                                                        :href="document.pdf"
                                                        target="_blank"
                                                        style="margin-right:5px;"
                                                        type="button"
                                                        class="btn btn-success btn-sm"
                                                    >
                                                        <i
                                                            class="fas fa-file-pdf"
                                                        ></i>
                                                    </a>
                                                    <el-tooltip
                                                        content="Ver documento variación"
                                                        effect="dark"
                                                        placement="top"
                                                        v-if="
                                                            document.document_variation_url
                                                        "
                                                    >
                                                        <a
                                                            :href="
                                                                document.document_variation_url
                                                            "
                                                            target="_blank"
                                                            style="margin-right:5px;  color: white;"
                                                            type="button"
                                                            class="btn btn-danger btn-sm"
                                                        >
                                                            <i
                                                                class="fas fa-file-pdf"
                                                            ></i>
                                                        </a>
                                                    </el-tooltip>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row m-3"></div>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <template v-if="!showReserves">
                            <!-- **** -->
                            <div
                                v-if="tables.length > 0"
                                class="d-flex flex-wrap justify-content-center"
                            >
                                <div
                                    v-for="(table, idx) in tables"
                                    :class="[
                                        table.rent_month &&
                                        table.status_table_id == 2
                                            ? 'btn-warning'
                                            : table.is_cleaning
                                            ? 'btn-dirty'
                                            : table.status_table_id == 1
                                            ? 'btn-free'
                                            : table.status_table_id == 2
                                            ? 'btn-danger'
                                            : table.status_table_id == 3
                                            ? 'btn-black'
                                            : table.status_table_id == 5
                                            ? 'btn-dirty'
                                            : 'btn-danger'
                                    ]"
                                    class=""
                                    :key="idx"
                                    @click="selectTable(table)"
                                    style="height: 150px; width: 300px; margin: 5px; border: 1px solid #ccc; border-radius: 8px; overflow: hidden;"
                                >
                                    <div>
                                        <div style="height: 70px;">
                                            <div
                                                class="row d-flex justify-content-center align-items-center"
                                            >
                                                <template
                                                    v-if="table.is_cleaning"
                                                >
                                                    <div
                                                        class="col-6 d-flex justify-content-center align-items-center"
                                                        style="display: flex; justify-content: center; align-items: center; height: 100%;"
                                                    >
                                                        <img
                                                            src="/images/imghotel/15.png"
                                                            alt="LimpiezaHabitaciones"
                                                            width="40"
                                                            height="40"
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-6 d-flex justify-content-center align-items-center"
                                                    >
                                                        <span
                                                            style="color: white; font-size: 40px;"
                                                            >{{
                                                                table.number
                                                            }}</span
                                                        >
                                                    </div>
                                                    <div
                                                        class="col-6 d-flex justify-content-center align-items-center"
                                                        v-if="
                                                            table.time_to_finish &&
                                                                table.time_to_finish !=
                                                                    0
                                                        "
                                                    >
                                                        <span
                                                            style="color: white;"
                                                        >
                                                            Restante:
                                                            <br />
                                                            <i
                                                                class="fas fa-clock"
                                                            ></i>
                                                            {{
                                                                table.time_to_finish
                                                                    ? table.time_to_finish
                                                                    : ""
                                                            }}
                                                        </span>
                                                    </div>
                                                    <div
                                                        v-else
                                                        class="col-12 d-flex justify-content-center align-items-center"
                                                    >
                                                        <span
                                                            style="color: white;"
                                                        >
                                                            en espera de
                                                            aceptación
                                                        </span>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div
                                                        class="col-4 d-flex justify-content-center align-items-center"
                                                        style="display: flex; justify-content: center; align-items: center; height: 100%;"
                                                    >
                                                        <span
                                                            class="text-white m-1"
                                                            style="font-size:35px;"
                                                        >
                                                            <template
                                                                v-if="
                                                                    table.status_table_id ==
                                                                        1
                                                                "
                                                            >
                                                                <img
                                                                    src="/images/imghotel/6.png"
                                                                    alt="Desocupado renta mensual"
                                                                    width="40"
                                                                    height="40"
                                                                />
                                                            </template>
                                                            <template
                                                                v-else-if="
                                                                    table.status_table_id ==
                                                                        2
                                                                "
                                                            >
                                                                <img
                                                                    src="/images/imghotel/2.png"
                                                                    alt="Ocupado"
                                                                    width="40"
                                                                    height="40"
                                                                />
                                                            </template>
                                                            <template
                                                                v-else-if="
                                                                    table.status_table_id ==
                                                                        3
                                                                "
                                                            >
                                                                <img
                                                                    src="/images/imghotel/1.png"
                                                                    alt="Mantenimiento"
                                                                    width="40"
                                                                    height="40"
                                                                />
                                                            </template>
                                                            <template
                                                                v-else-if="
                                                                    table.status_table_id ==
                                                                        5
                                                                "
                                                            >
                                                                <img
                                                                    src="/images/imghotel/5.png"
                                                                    alt="Limpieza"
                                                                    width="40"
                                                                    height="40"
                                                                />
                                                            </template>
                                                            <template v-else>
                                                                <i
                                                                    class="fas fa-ban"
                                                                ></i>
                                                                <img
                                                                    src="/images/imghotel/6.png"
                                                                    alt="Desocupado"
                                                                    width="40"
                                                                    height="40"
                                                                />
                                                            </template>
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="col-8 d-flex justify-content-center align-items-center"
                                                    >
                                                        <span
                                                            style="color: white; font-size: 40px;"
                                                            >{{
                                                                table.number
                                                            }}</span
                                                        >
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <div
                                            style="color: white; height: 20px;"
                                            v-if="!table.is_cleaning"
                                        >
                                            <div
                                                class="d-flex flex-column align-items-center justify-content-center"
                                            >
                                                <span
                                                    style="color: white; font-size: 14px;"
                                                >
                                                    {{
                                                        table.type.name ||
                                                            "Sin tipo"
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="card-footer"
                                            style="background-color: #073f68; height: 60px;"
                                            v-if="
                                                table.status_table_id != 3 &&
                                                    !table.is_cleaning
                                            "
                                        >
                                            <div class="row">
                                                <div class="col-6" style="">
                                                    <span style="color: white;">
                                                        {{
                                                            table.status_table_id ==
                                                            1
                                                                ? "Libre"
                                                                : table.status_table_id ==
                                                                  2
                                                                ? "Ocupada"
                                                                : table.status_table_id ==
                                                                  3
                                                                ? "Mantenimiento"
                                                                : table.status_table_id ==
                                                                  5
                                                                ? "Desocupado"
                                                                : "Estado Desconocido"
                                                        }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="col-6 d-flex justify-content-end"
                                                >
                                                    <el-tooltip
                                                        content="Enviar a Mantenimiento la Habitación"
                                                    >
                                                        <button
                                                            @click="
                                                                sendToMaintenance(
                                                                    $event,
                                                                    table.id
                                                                )
                                                            "
                                                            class="btn btn-sm mx-1"
                                                            style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; background-color: #000000; border: 1px solid white;"
                                                        >
                                                            <img
                                                                src="/images/imghotel/1.png"
                                                                alt="Imagen"
                                                                width="20"
                                                                height="20"
                                                            />
                                                        </button>
                                                    </el-tooltip>

                                                    <el-tooltip
                                                        content="Enviar a Limpiar Habitación"
                                                    >
                                                        <button
                                                            @click="
                                                                sendToCleanById(
                                                                    $event,
                                                                    table.id
                                                                )
                                                            "
                                                            class="btn btn-sm mx-1"
                                                            style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; background-color: #0e7ea6; border: 1px solid white;"
                                                        >
                                                            <img
                                                                src="/images/imghotel/5.png"
                                                                alt="Imagen"
                                                                width="20"
                                                                height="20"
                                                            />
                                                        </button>
                                                    </el-tooltip>
                                                    <el-tooltip
                                                        content="Habitación tiene reserva"
                                                    >
                                                        <button
                                                            v-if="
                                                                table.reserves
                                                                    .length > 0
                                                            "
                                                            @click.stop="
                                                                goToReservations()
                                                            "
                                                            class="btn btn-sm mx-1"
                                                            style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; background-color: #7030a0; border: 1px solid white;"
                                                        >
                                                            <img
                                                                src="/images/imghotel/3.png"
                                                                alt="Imagen"
                                                                width="20"
                                                                height="20"
                                                            />
                                                        </button>
                                                    </el-tooltip>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <!-- de las reservas -->
                        <template v-else>
                            <table
                                class="table table-striped "
                                v-if="all_reserves.length > 0"
                            >
                                <thead>
                                    <tr>
                                        <th scope="col" class="h5">
                                            #
                                        </th>
                                        <th scope="col" class="h5">
                                            FECHA
                                        </th>
                                        <th scope="col" class="h5">
                                            HORA
                                        </th>
                                        <th scope="col" class="h5">
                                            CLIENTE
                                        </th>
                                        <th scope="col" class="h5">
                                            HABITACIÓN
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(reserve, idx) in all_reserves"
                                        :key="idx"
                                    >
                                        <td>{{ idx + 1 }}</td>
                                        <td>{{ reserve.checkin_date }}</td>
                                        <td>{{ reserve.checkin_time }}</td>
                                        <td>
                                            {{ reserve.customer_name }}
                                            <br />
                                            <small>
                                                {{ reserve.customer_number }}
                                            </small>
                                        </td>
                                        <td>
                                            {{ reserve.room_number }}
                                            {{
                                                reserve.cleaning
                                                    ? " - Limpieza"
                                                    : ` - ${reserve.room_state}`
                                            }}
                                            <br />
                                            <small>
                                                {{ reserve.tower }}
                                            </small>
                                        </td>
                                        <td>
                                            <el-tooltip
                                                v-if="
                                                    reserve.room_state_id == 1
                                                "
                                                content="Tomar habitación"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-sm"
                                                    @click="
                                                        selectReserve(
                                                            reserve.id
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </el-tooltip>
                                            <el-tooltip content="Editar fecha">
                                                <button
                                                    type="button"
                                                    class="btn btn-success btn-sm"
                                                    @click="
                                                        editReserve(reserve.id)
                                                    "
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </el-tooltip>
                                            <el-tooltip
                                                content="Cancelar reserva"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm"
                                                    @click="
                                                        cancelReserve(
                                                            reserve.id
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </el-tooltip>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <span v-else class="text-center">Sin reservas</span>
                        </template>
                    </template>
                </div>
            </div>
        </div>

        <el-dialog
            :visible.sync="showGuesses"
            append-to-body
            whidth="50%"
            title="Registrados"
            @close="showGuesses = false"
        >
            <div class="row m-2 table-responsive" v-if="currentRoom">
                <table class="table table-hover ">
                    <thead>
                        <tr style="background-color: #073f68; color: white;">
                            <th style="color: white;">Nombre</th>
                            <th style="color: white;">Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(guess, idx) in currentRoom.guesses"
                            :key="idx"
                            style="background-color: #f9f9f9; border-bottom: 1px solid #ddd;"
                        >
                            <td
                                style="padding: 10px; font-weight: bold; color: #333;"
                            >
                                {{ guess.name }}
                            </td>
                            <td style="padding: 10px; color: #555;">
                                {{ guess.number }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </el-dialog>
        <room-form
            :configuration="configuration"
            @getTables="getTables"
            :showDialog.sync="showRoom"
            :table="currentTable"
            @emitAdvances="emitAdvances"
            :isReserve="isReserve"
            :hotelRentId="hotelRentId"
            :itemDefault.sync="itemDefault"
        ></room-form>

        <el-dialog
            :visible.sync="showAddDays"
            append-to-body
            width="30%"
            :title="
                currentRoom
                    ? currentRoom.is_month_rent
                        ? 'Agregar meses'
                        : 'Agregar días'
                    : ''
            "
        >
            <div class="row m-2" v-if="currentRoom">
                <div class="col-12">
                    <label for="days"
                        >{{
                            currentRoom
                                ? currentRoom.is_month_rent
                                    ? "Meses"
                                    : "Días"
                                : ""
                        }}
                        de alquiler</label
                    >
                    <el-input-number
                        :min="1"
                        class="w-100"
                        id="days"
                        v-model="currentRoom.new_duration"
                    ></el-input-number>
                </div>
            </div>
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <!-- Botón Cancelar -->
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-sm"
                    size="small"
                    @click="showAddDays = false"
                >
                    <span>Cancelar</span>
                </el-button>
                <!-- Botón Guardar -->
                <el-button
                    class="btn-save btn-save:hover"
                    icon="fas fa-save fa-sm"
                    type="primary"
                    size="small"
                    @click="addDays"
                >
                    <span>Agregar</span>
                </el-button>
            </div>
            <!-- <span slot="footer" class="dialog-footer">
                <el-button @click="showAddDays = false">Cancelar</el-button>
                <el-button type="primary" @click="addDays">Agregar</el-button>
            </span> -->
        </el-dialog>
        <maintenance-modal
            :tableName="tableNameMaintenance"
            :type="typeMaintenance"
            :tableId="tableIdMaintenance"
            :showDialog.sync="showModalMaintenance"
            @getTables="getTables"
        ></maintenance-modal>
        <edit-reserve
            :showDialog.sync="showEditDate"
            :roomEdit="roomEdit"
            @getTables="getTables"
        >
        </edit-reserve>
        <template v-if="currentRoom && currentTable">
            <services-room-modal
                :printer="printer"
                :showDialog.sync="showServices"
                :hotelRentItemId="currentRoom.id"
                :numberRoom="currentTable.number"
            >
            </services-room-modal>
        </template>
        <variation-modal
            :showDialog.sync="showVariationModal"
            @sendVariation="payAllVariation"
        ></variation-modal>
    </el-dialog>
</template>
<style>
.btn-black {
    background-color: #000;
}
.btn-free {
    background-color: #148406;
}
.btn-dirty {
    background-color: #0e7ea6;
}
.btn-reserve {
    background-color: #7030a0;
}
.btn-ocupado {
    background-color: #ad0a20;
}
</style>
<script>
import RoomForm from "./room_form.vue";
import EditReserve from "./edit_reserve.vue";
import ServicesRoomModal from "./services_room_modal.vue";
import MaintenanceModal from "./maintenance_modal.vue";
import VariationModal from "./variation_modal.vue";
export default {
    //tabla color verde
    props: [
        "showTables",
        "table",
        "roomSeeId",
        "printer",
        "configuration",
        "cash_id",
        "itemDefault",
        "fromPos"
    ],
    components: {
        RoomForm,
        EditReserve,
        ServicesRoomModal,
        MaintenanceModal,
        VariationModal
    },
    data() {
        return {
            showVariationModal: false,
            titleDialogOriginal: "Zona de Atención",
            titleDialog: "Zona de Atención",
            tableNameMaintenance: null,
            typeMaintenance: null,
            tableIdMaintenance: null,
            showModalMaintenance: false,
            all_months: [],
            roomEdit: null,
            showEditDate: false,
            status: [],
            all_status: [],
            all_reserves: [],
            isReserve: false,
            floor_id: null,
            all_floors: [],
            floors: [],
            showGuesses: false,
            activeOrdenRoom: "1",
            showRoom: false,
            viewingRoom: false,
            ordens: [],
            loading: false,
            resource: "/caja/rooms/tables",
            tables: [],
            all_tables: [],
            all_services: [],
            showOrdens: false,
            ordensSaved: [],
            top: "rounded-top",
            screenWidth: 0,
            hasTableOcuped: false,
            changingOrden: false,
            hasSelectedTableToChange: false,
            hasSelectedOrdenToChange: false,
            ordenToChange: null,
            currentTable: null,
            currentRoom: null,
            towers: [],
            active: false,
            timer: null,
            tower_id: null,
            showAddDays: false,
            extra_time: 0,
            isChangingRoom: false,
            showReserves: false,
            hotelRentId: null,
            showServices: false,
            value: "", // Variable para el v-model del vs-input
            get checkinDateTime() {
                return `${this.currentRoom?.checkin_date || ""} - ${this
                    .currentRoom?.checkin_time || ""}`;
            }
        };
    },
    created() {
        if (this.fromPos) {
            this.open();
        }
    },
    methods: {
        pdf(id) {
            window.open(`/caja/rooms/pdf/${id}`, "_blank");
        },
        clickShowVariationModal() {
            this.showVariationModal = true;
        },
        async deleteOrden(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de eliminar la orden?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.post(
                    `/caja/worker/cancel-orden-hotel`,
                    { id }
                );
                if (response.status == 200) {
                    this.$toast.success("Orden eliminada");
                    console.log(
                        "🚀 ~ file: tables_rooms.vue:1118 ~ deleteOrden ~ this.roomSeeId:",
                        this.roomSeeId
                    );
                    if (this.currentRoom) {
                        let table = this.all_tables.find(
                            t => t.id == this.currentTable.id
                        );
                        this.selectTable(table);
                    }
                } else {
                    this.$toast.error("Error al eliminar la orden");
                }
            } catch (e) {}
        },
        filterByMonth() {
            this.showReserves = false;
            this.tables = this.all_tables
                .filter(table => table.rent_month)
                .map(table => {
                    table.tower_name = table.floor.tower.name;
                    return table;
                });
        },
        async checkServices() {
            this.showServices = true;
        },
        async desocupiedRoom(id) {
            try {
                this.loading = true;
                // Usar Swal.fire para confirmación moderna
                const result = await Swal.fire({
                    title: "¿Está seguro de desocupar la habitación?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                });
                if (!result.isConfirmed) {
                    this.loading = false;
                    return;
                }
                const response = await this.$http.get(
                    `/caja/rooms/desocupied/${id}`
                );
                if (response.status == 200) {
                    await Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Habitación desocupada",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getTables();
                    this.close2();
                }
            } catch (e) {
                this.$toast.error("Error al cancelar la reserva");
            } finally {
                this.loading = false;
            }
        },
        async cancelReserve(id) {
            try {
                this.loading = true;
                await this.$confirm(
                    "¿Está seguro de cancelar la reserva?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.get(
                    `/caja/rooms/cancel_reserve/${id}`
                );
                if (response.status == 200) {
                    this.$toast.success("Reserva cancelada");
                    this.getTables();
                }
            } catch (e) {
                this.$toast.error("Error al cancelar la reserva");
            } finally {
                this.loading = false;
            }
        },
        filterFloors(tower_id, idx) {
            this.floors = this.all_floors.filter(f => f.tower_id == tower_id);
        },
        async editReserveDate(id) {
            let form = {
                id,
                checkin_date: this.roomEdit.checkin_date,
                checkin_time: this.roomEdit.checkin_time,
                table_id: this.roomEdit.table_id,
                duration: this.roomEdit.duration
            };
            const response = await this.$http.post(
                `/caja/rooms/set_reserve_date`,
                form
            );
            if (response.status == 200) {
                this.$toast.success("Fecha de reserva actualizada");
                this.showEditDate = false;
                this.getTables();
            }
        },
        async editReserve(id) {
            this.roomEdit = null;
            const response = await this.$http(
                `/caja/rooms/get_reserve_date/${id}`
            );
            if (response.status == 200) {
                this.roomEdit = response.data;
                this.roomEdit.id = id;
                this.showEditDate = true;
            }
        },
        async selectReserve(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de tomar la reserva?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.get(
                    `/caja/rooms/reserve_to_occupied/${id}`
                );
                if (response.status == 200) {
                    this.$toast.success("Reserva tomada");
                    this.getTables();
                }
            } catch (e) {}
        },
        async cancelRoom() {
            try {
                this.loading = true;
                const result = await Swal.fire({
                    title: "¿Está seguro de cancelar la habitación?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                });
                if (!result.isConfirmed) {
                    this.loading = false;
                    return;
                }
                // Solo si acepta, lanzar la petición
                const response = await this.$http(
                    `/caja/rooms/cancel/${this.currentRoom.id}`
                );
                if (response.status == 200) {
                    await Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Habitación cancelada",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    await this.getTables();
                    setTimeout(() => {
                        this.resetToListView();
                        console.log("resetToListView ejecutado", {
                            viewingRoom: this.viewingRoom,
                            currentRoom: this.currentRoom,
                            currentTable: this.currentTable
                        });
                    }, 150);
                }
            } catch (e) {
                this.$toast.error("Error al cancelar la habitación");
            } finally {
                this.loading = false;
            }
        },
        resetToListView() {
            this.titleDialog = this.titleDialogOriginal;
            this.viewingRoom = false;
            this.currentTable = null;
            this.currentRoom = null;
            this.isChangingRoom = false;
            this.showServices = false;
            this.showGuesses = false;
            this.showAddDays = false;
            this.showEditDate = false;
            // Si necesitas resetear más estados, agrégalos aquí
            this.$forceUpdate();
        },
        filterByReserve() {
            this.showReserves = true;
        },
        filterByStatus(id) {
            this.showReserves = false;
            this.tables = this.all_tables
                .filter(table => table.status_table_id == id)
                .filter(table => table.floor)
                .map(table => {
                    table.tower_name = table.floor.tower.name;
                    return table;
                });
        },
        reserveRoom() {
            this.isReserve = true;
            this.showRoom = true;
        },
        async emitAdvances(id, paymentVariation = null) {
            const response = await this.$http(`/caja/rooms/advance/${id}`);
            const { data } = response;
            let { items, hotel_rent_id, customer_number } = data;
            if (paymentVariation) {
                let { description, price } = paymentVariation;
                let foodDefault = this.itemDefault;
                foodDefault.description = description;
                foodDefault.quantity = 1;
                foodDefault.sale_unit_price = Number(price);
                this.$emit(
                    "paymentsOrden",
                    {
                        items,
                        is_room: true,
                        is_advance: true,
                        hotel_rent_id,
                        customer_number
                    },
                    [foodDefault]
                );
            } else {
                this.$emit("paymentsOrden", {
                    items,
                    is_room: true,
                    is_advance: true,
                    hotel_rent_id,
                    customer_number
                });
            }
            this.close();
        },

        changeRoom() {
            this.isChangingRoom = !this.isChangingRoom;
            if (this.isChangingRoom) {
                this.close2();
            }
        },
        async addDays() {
            await this.$http(
                `/caja/rooms/add_days/${this.currentRoom.id}/${this.currentRoom.new_duration}`
            );
            this.showAddDays = false;
            this.getRoomDetail(this.currentTable.id);
        },
        close2() {
            this.titleDialog = this.titleDialogOriginal;
            this.viewingRoom = false;
            this.currentTable = null;
            this.currentRoom = null;
            this.isChangingRoom = false;
            this.showServices = false;
            this.showGuesses = false;
            this.showAddDays = false;
            this.showEditDate = false;
            // Add any other state resets needed to ensure the list view is shown
        },
        async sendToMaintenance(event, id) {
            event.stopPropagation();
            if (this.configuration.maintenance_workers) {
                let table = this.all_tables.find(t => t.id == id);
                let number = table.number;
                let tower = table.floor.tower.name;
                let name = `${number} - ${tower}`;
                this.tableNameMaintenance = name;
                this.showModalMaintenance = true;
                this.typeMaintenance = "mantenimiento";
                this.tableIdMaintenance = id;
                return;
            }
            try {
                await this.$confirm(
                    "¿Está seguro de enviar a mantenimiento la habitación?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http(
                    `/caja/rooms/send_to_maintenance/${id}`
                );

                if (response.status == 200) {
                    this.getTables();
                }
            } catch (e) {}
        },
        async sendToCleanById(event, id) {
            event.stopPropagation();
            if (this.configuration.maintenance_workers) {
                let table = this.all_tables.find(t => t.id == id);
                let number = table.number;
                let tower = table.floor.tower.name;
                let name = `${number} - ${tower}`;
                this.tableNameMaintenance = name;
                this.showModalMaintenance = true;
                this.typeMaintenance = "limpieza";
                this.tableIdMaintenance = id;
                return;
            }
            try {
                await this.$confirm(
                    "¿Está seguro de enviar a limpiar esta habitación?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http(
                    `/caja/rooms/send_to_clean/${id}`
                );

                if (response.status == 200) {
                    this.$emit("getTablesToClean");
                    this.getTables();
                }
            } catch (e) {}
        },
        async sendToClean() {
            if (this.configuration.maintenance_workers) {
                this.sendToCleanById(null, this.currentTable.id);
            } else {
                const response = await this.$http(
                    `/caja/rooms/send_to_clean/${this.currentTable.id}`
                );

                if (response.status == 200) {
                    this.$emit("getTablesToClean");
                    this.getTables();
                }
            }
        },
        async payAllVariation(paymentVariation) {
            let { description, price } = paymentVariation;
            let foodDefault = this.itemDefault;
            foodDefault.description = description;
            foodDefault.quantity = 1;
            foodDefault.sale_unit_price = Number(price);

            const response = await this.$http.post(
                `/caja/rooms/all_ordens/${this.currentRoom.id}`,
                {
                    extra_time: this.extra_time
                }
            );
            const { data } = response;
            let {
                ordens_items,
                orden_ids,
                hotel_rent_item_ids,
                hotel_rent_id,
                customer_number,
                customer_id,
                credit_line
            } = data;
            this.$emit(
                "paymentsOrden",
                {
                    items: ordens_items,
                    is_room: true,
                    orden_ids,
                    hotel_rent_item_ids,
                    hotel_rent_id,
                    customer_number,
                    customer_id,
                    credit_line
                },
                [foodDefault]
            );
            this.close();
        },
        async payAll() {
            const response = await this.$http.post(
                `/caja/rooms/all_ordens/${this.currentRoom.id}`,
                {
                    extra_time: this.extra_time
                }
            );
            const { data } = response;
            let {
                ordens_items,
                orden_ids,
                hotel_rent_item_ids,
                hotel_rent_id,
                customer_number,
                customer_id,
                credit_line
            } = data;
            this.$emit("paymentsOrden", {
                items: ordens_items,
                is_room: true,
                orden_ids,
                hotel_rent_item_ids,
                hotel_rent_id,
                customer_number,
                customer_id,
                credit_line
            });
            this.close();
        },
        seeGuesses(room) {
            this.showGuesses = true;
        },
        async getOrden(id) {
            const response = await this.$http.get(
                `/caja/rooms/ordenById/${id}`
            );
            const {
                data: { orden }
            } = response;

            if (orden) {
                this.$emit("sendOrdens", orden);
                this.close();
            }
        },
        createOrden() {
            let { number, id, is_room } = this.currentTable;
            this.$emit("creatingOrden", number, id, is_room);
            this.close();
        },
        changeOrden() {
            this.changingOrden = !this.changingOrden;
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        addOrden() {
            this.viewingRoom = !this.viewingRoom;
        },
        async getRoomDetail(id) {
            this.extra_time = 0;
            try {
                this.loading = true;
                const response = await this.$http.get(`/caja/rooms/room/${id}`);
                const {
                    data: { data }
                } = response;
                this.currentRoom = data;
                let { table_name } = data;
                this.titleDialog = `Habitación ${table_name}`;
                this.extra_time = data.extra_time;
                this.viewingRoom = true;
            } catch (e) {
            } finally {
                this.loading = false;
            }
        },
        async sendOrdenToNewTable(orden, table) {
            let orden_id = orden.id;
            let table_id = table.id;
            try {
                this.loading = true;
                const response = await this.$http.post(`change-orden`, {
                    orden_id,
                    table_id
                });
                if (response.status == 200) {
                    this.$toast.success("Orden cambiada con éxito");
                } else {
                    this.$toast.error("Ocurrió un error, al cambiar la orden");
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error, al cambiar la orden");
            } finally {
                this.loading = false;
                this.close();
            }
        },
        closeOrden() {
            this.ordens = [];
            this.changingOrden = false;
            this.hasSelectedTableToChange = false;
            this.hasSelectedOrdenToChange = false;
            this.ordenToChange = null;
        },
        sendOrdens(orden) {
            if (this.changingOrden && !this.hasSelectedTableToChange) {
                this.hasSelectedTableToChange = true;
            } else if (this.changingOrden && this.hasSelectedTableToChange) {
                this.ordenToChange = orden;
                this.hasSelectedOrdenToChange = true;
                this.hasSelectedTableToChange = false;
            } else {
                this.$emit("sendOrdens", orden);
                this.close();
            }
        },
        async roomCleaned(id) {
            const response = await this.$http(`/caja/rooms/cleaned/${id}`);
            if (response.status == 200) {
                this.getTables();
                this.$emit("roomWasCleaned", id);
            }
            if (response.status == 200) {
                // Si el backend retorna success: false, mostramos el mensaje de error
                if (response.data && response.data.success === false) {
                    this.$showSAlert(
                        "ALERTA",
                        response.data.message,
                        "warning"
                    );
                    return;
                }
                this.getTables();
                this.$emit("roomWasCleaned", id);
            }
        },

        async selectTable(table) {
            if (this.isChangingRoom) {
                let { status_table_id } = table;
                if (status_table_id != 1) {
                    this.$toast.warning("La habitación no esta disponible");
                    return;
                }
                try {
                    const response = await this.$http(
                        `/caja/rooms/change_room/${this.currentTable.id}/${table.id}`
                    );
                    if (response.status == 200) {
                        this.$toast.success("Habitación cambiada con éxito");
                        this.close();
                    } else {
                        this.$toast.error(
                            "Ocurrió un error, al cambiar la habitación"
                        );
                    }
                    this.isChangingRoom = false;
                    return;
                } catch (e) {
                    this.$toast.error(
                        "Ocurrió un error, al cambiar la habitación"
                    );
                    this.isChangingRoom = false;
                    this.close();
                    return;
                }
            }
            this.currentTable = table;
            if (table.status_table_id == 2) {
                if (!this.cash_id) {
                    this.$message.warning("Abra una caja para continuar");
                    return;
                }
                this.getRoomDetail(table.id);
                return;
            } else if (table.status_table_id == 5) {
                if (table.is_cleaning) {
                    try {
                        await this.$confirm("¿Terminar limpieza?", "Atención", {
                            confirmButtonText: "Aceptar",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        });
                        this.roomCleaned(table.id);
                    } catch (e) {}
                } else {
                    // try {
                    //     await this.$confirm(
                    //         "¿Limpiar habitación?",
                    //         "Atención",
                    //         {
                    //             confirmButtonText: "Aceptar",
                    //             cancelButtonText: "Cancelar",
                    //             type: "warning"
                    //         }
                    //     );
                    //     this.sendToClean();
                    // } catch (e) {}
                }
            } else if (table.status_table_id == 3) {
                try {
                    await this.$confirm(
                        "Terminar el mantenimiento",
                        "Atención",
                        {
                            confirmButtonText: "Aceptar",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    console.log("asas");
                    const response = await this.$http(
                        `/caja/rooms/send_to_avaible/${table.id}`
                    );

                    /* if (response.status == 200) {
                        this.getTables();
                    } */
                    if (response.status == 200) {
                        if (response.data && response.data.success === false) {
                            this.$showSAlert(
                                "ALERTA",
                                response.data.message,
                                "warning"
                            );
                            return;
                        }
                        this.getTables();
                    }
                } catch (e) {
                    console.log(e);
                }
            } else {
                if (!this.cash_id) {
                    this.$message.warning("Abra una caja para continuar");
                    return;
                }
                this.showRoom = true;
            }
        },
        updateTime() {
            this.tables.forEach(t => {
                let now = new Date();
                if (t.status_table_id == 2 && t.counter) {
                    let { date_of_out } = t;
                    let date = new Date(date_of_out);
                    let diff = date.getTime() - now.getTime();
                    if (diff < 0) {
                        t.timer = null;
                    } else {
                        diff = Math.floor(diff / 1000);
                        let seconds = diff % 60;
                        diff = Math.floor(diff / 60);
                        let minutes = diff % 60;
                        t.timer = `${minutes < 10 ? "0" : ""}${minutes}:${
                            seconds < 10 ? "0" : ""
                        }${seconds} para salir`;
                    }
                }
                if (t.is_cleaning) {
                    let { cleaning_start_date } = t;
                    let date = new Date(cleaning_start_date);

                    let diff = date.getTime() - now.getTime();

                    if (diff < 0) {
                        t.time_to_finish = null;
                    } else {
                        diff = Math.floor(diff / 1000);
                        let seconds = diff % 60;
                        diff = Math.floor(diff / 60);
                        let minutes = diff % 60;
                        t.time_to_finish = `${
                            minutes < 10 ? "0" : ""
                        }${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
                    }
                    //transforma diff en minutos y segundos
                }
            });
        },
        async open() {
            this.isReserve = false;
            this.closeOrden();
            await this.getTables();
            this.timer = setInterval(() => {
                this.updateTime();
            }, 1000);
            if (this.roomSeeId) {
                let table = this.all_tables.find(t => t.id == this.roomSeeId);

                this.selectTable(table);
            }
        },
        filterTablesByFloor(floor_id) {
            this.showReserves = false;
            this.floor_id = floor_id;
            this.tables = this.all_tables.filter(f => {
                delete f.tower_name;
                return f.floor_id == floor_id;
            });
        },
        filterFloorsByTower(tower_id) {
            this.showReserves = false;
            this.tower_id = tower_id;
            this.floors = this.all_floors.filter(f => {
                return f.tower_id == tower_id;
            });
            let [floor] = this.floors;
            if (floor) {
                this.filterTablesByFloor(floor.id);
            } else {
                this.tables = [];
            }
        },

        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http(this.resource);
                if (response.status == 200) {
                    const {
                        reserves,
                        tables,
                        towers,
                        floors,
                        status
                    } = response.data;
                    //  this.tables = tables.filter(f => f.number != "caja");
                    this.all_tables = tables;
                    this.all_reserves = reserves;
                    this.all_tables = this.all_tables.map(t => ({
                        ...t,
                        time_to_finish: null,
                        timer: null
                    }));
                    this.all_months = this.all_tables.filter(
                        t => t.rent_month
                    ).length;
                    this.all_status = status;
                    this.status = status
                        .filter(s => s.id != 4)
                        .map(s => ({
                            ...s,
                            count: this.all_tables.filter(
                                t => t.status_table_id == s.id
                            ).length,
                            class:
                                s.id == 1
                                    ? "btn-free"
                                    : s.id == 2
                                    ? "btn-danger"
                                    : s.id == 5
                                    ? "btn-dirty"
                                    : s.id == 3
                                    ? "btn-black"
                                    : "btn-ocupado"
                        }));

                    this.all_floors = floors;
                    this.towers = towers;
                    let [tower] = towers;
                    this.tower_id = tower.id;

                    this.filterFloorsByTower(tower.id);
                    let [floor] = floors;
                    this.filterTablesByFloor(floor.id);
                    this.hasTableOcuped = this.tables.some(
                        s => s.status_table_id == 2
                    );
                } else {
                    this.$toast.warning("Ocurrió un error");
                }
            } catch (e) {
                this.loading = false;
                console.log(e);

                this.$toast.warning("Ocurrió un error");
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.viewingRoom = false;

            clearInterval(this.timer);

            this.$emit("update:showTables", false);
            this.$emit("update:roomSeeId", null);
        },
        goToReservations() {
            this.showReserves = true;
        }
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    }
};
</script>
