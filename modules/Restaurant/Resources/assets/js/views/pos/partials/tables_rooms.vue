<template>
    <el-dialog
        :visible="showTables"
        v-loading="loading"
        @open="open"
        @close="close"
        width="70%"
        title="ZONA DE ATENCIÓN HOTEL"
        :close-on-click-modal="false"
        :class="{ top }"
    >
        <div v-if="ordens.length == 0 || hasSelectedOrdenToChange">
            <div class="d-flex justify-content-between p-2">
                <div v-if="!viewingRoom && !isChangingRoom" class="d-flex">
                    <button
                        v-for="(tower, idx) in towers"
                        :key="idx"
                        type="button"
                        style="margin-left:15px;"
                        :class="
                            `btn ${
                                tower_id == tower.id
                                    ? 'btn-primary text-white'
                                    : 'btn-light'
                            }`
                        "
                        @click="filterFloorsByTower(tower.id)"
                    >
                        Torre {{ tower.name }}
                    </button>
                    <button
                        v-if="isChangingRoom"
                        type="button"
                        style="margin-left:15px;"
                        class="btn btn-secondary"
                        @click="isChangingRoom = false"
                    >
                        Cancelar cambio
                    </button>
                </div>
                <div v-else>
                    <button
                        v-if="viewingRoom"
                        type="button"
                        style="margin-left:15px;"
                        class="btn btn-light"
                        @click="close2"
                    >
                        Atras
                    </button>
                    <button
                        type="button"
                        style="margin-left:15px;"
                        class="btn btn-secondary"
                        @click="changeRoom"
                    >
                        {{
                            isChangingRoom
                                ? "Cancelar cambio"
                                : "Cambiar habitación"
                        }}
                    </button>
                    <span v-if="isChangingRoom" class="text-muted h4"
                        >Elija habitación</span
                    >
                    <button
                        type="button"
                        style="margin-left:15px;"
                        class="btn btn-secondary"
                        @click="reserveRoom"
                    >
                        Reservar habitación
                    </button>
                </div>

                <div>
                    <el-tooltip>
                        <div slot="content">Mensual ({{ all_months }})</div>

                        <button
                            @click="filterByMonth"
                            v-if="!viewingRoom && !isChangingRoom"
                            type="button"
                            style="margin-left:8px;"
                            class="btn btn-sm btn-warning"
                        >
                            <span
                                class="text-white m-1"
                                style="font-size:18px;"
                            >
                                <i class="fas fa-bed"></i>
                            </span>
                        </button>
                    </el-tooltip>
                    <el-tooltip v-for="(statu, idx) in status" :key="idx">
                        <div slot="content">
                            {{ statu.description }} ({{ statu.count }})
                        </div>
                        <button
                            @click="filterByStatus(statu.id)"
                            v-if="!viewingRoom && !isChangingRoom"
                            type="button"
                            style="margin-left:8px;"
                            class="btn btn-sm"
                            :class="statu.class"
                        >
                            <span
                                class="text-white m-1"
                                style="font-size:18px;"
                            >
                                <template v-if="statu.id == 1">
                                    <i class="fas fa-door-closed"></i>
                                </template>
                                <template v-else-if="statu.id == 2">
                                    <i class="fas fa-bed"></i>
                                </template>
                                <template v-else-if="statu.id == 3">
                                    <i class="fas fa-tools"></i>
                                </template>
                                <template v-else-if="statu.id == 5">
                                    <i class="fas fa-walking"></i>
                                </template>
                                <template v-else>
                                    <i class="fas fa-ban"></i>
                                </template>
                            </span>
                        </button>
                    </el-tooltip>
                    <el-tooltip>
                        <div slot="content">
                            Reservadas ({{ all_reserves.length }})
                        </div>

                        <button
                            @click="filterByReserve"
                            v-if="!viewingRoom && !isChangingRoom"
                            type="button"
                            style="margin-left:8px;"
                            class="btn btn-sm btn-reserve"
                        >
                            <span
                                class="text-white m-1"
                                style="font-size:18px;"
                            >
                                <i class="fas fa-calendar"></i>
                            </span>
                        </button>
                    </el-tooltip>
                    <button
                        type="button"
                        style="margin-left:15px;"
                        class="btn btn-light"
                        @click="close"
                    >
                        Cerrar
                    </button>
                </div>
            </div>
            <template v-if="!viewingRoom">
                <div class="d-flex p-2" v-if="floors.length > 0">
                    <button
                        v-for="(floor, idx) in floors"
                        :key="idx"
                        type="button"
                        style="margin-left:15px;"
                        :class="
                            `btn ${
                                floor_id == floor.id
                                    ? 'btn-primary text-white'
                                    : 'btn-light'
                            }`
                        "
                        @click="filterTablesByFloor(floor.id)"
                    >
                        {{ floor.name }}
                    </button>
                </div>
                <div v-else class="d-flex p-2">
                    <span>
                        No hay pisos en esta torre
                    </span>
                </div>
            </template>

            <template v-if="viewingRoom && currentRoom">
                <div class="row m-2">
                    <div class="col-lg-8 col-md-8 col-12">
                        <label for="customer"
                            >Cliente

                            <a
                                v-if="currentRoom.has_many_rooms"
                                href="#"
                                data-toggle="tooltip"
                                @click="showRoom = true"
                            >
                                [+ Cancelar más de 1 habitación]
                            </a>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="customer"
                            v-model="currentRoom.customer"
                            disabled
                        />
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-lg-3 col-6">
                        <label for="checkin_date">
                            <strong>Fecha de ingreso</strong>
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="checkin_date"
                            v-model="currentRoom.checkin_date"
                            disabled
                        />
                    </div>
                    <div class="col-lg-3 col-6">
                        <label for="checkout_time">
                            <strong>Hora de ingreso</strong>
                        </label>
                        <input
                            type="time"
                            class="form-control"
                            id="checkout_time"
                            v-model="currentRoom.checkin_time"
                            disabled
                            value-format="HH:mm:ss"
                            :format="'hh:mm A'"
                            :picker-options="{
                                format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                            }"
                        />
                    </div>
                    <div class="col-lg-3 col-6">
                        <label for="duration">
                            <strong>Duración</strong>
                            <a
                                href="#"
                                data-toggle="tooltip"
                                title="Días"
                                @click="showAddDays = true"
                            >
                                [+
                                {{
                                    currentRoom
                                        ? currentRoom.is_month_rent
                                            ? "Agregar meses"
                                            : "Agregar días"
                                        : ""
                                }}]
                            </a>
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="duration"
                            v-model="currentRoom.duration"
                            disabled
                        />
                    </div>
                    <div class="col-lg-3 col-6">
                        <label for="quantity"
                            >Cantidad de personas
                            <a
                                href="#"
                                data-toggle="tooltip"
                                title="persons"
                                @click="seeGuesses(currentRoom)"
                            >
                                [+ Ver detalle]
                            </a>
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="quantity"
                            v-model="currentRoom.quantity_persons"
                            disabled
                        />
                    </div>
                </div>
                <div class="row m-2">
                    <div
                        class="col-lg-3 col-6"
                        v-if="currentRoom.checkout_date_estimated"
                    >
                        <label for="checkin_date">
                            <strong>Fecha estimada de salida</strong>
                        </label>
                        <input
                            type="date"
                            class="form-control"
                            id="checkin_date"
                            v-model="currentRoom.checkout_date_estimated"
                            disabled
                        />
                    </div>
                    <div
                        class="col-lg-3 col-6"
                        v-if="currentRoom.checkout_time_estimated"
                    >
                        <label for="checkout_time">
                            <strong>Hora estimada de salida</strong>
                        </label>
                        <input
                            type="time"
                            class="form-control"
                            id="checkout_time"
                            v-model="currentRoom.checkout_time_estimated"
                            disabled
                            value-format="HH:mm:ss"
                            :format="'hh:mm A'"
                            :picker-options="{
                                format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                            }"
                        />
                    </div>
                </div>
                <div class="row m-2 ">
                    <!-- <button
                        v-if="!currentTable.is_cleaning"
                        type="button"
                        class="btn btn-info m-2"
                        @click="sendToClean"
                    >
                        Limpiar habitación
                    </button> -->
                    <div class="col-md-6 col-lg-3 col-sm-6 col-6">
                        <label for="extra_time">Media tarifa</label>
                        <el-input
                            readonly
                            type="number"
                            class="w-100"
                            v-model="extra_time"
                        >
                        </el-input>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-6">
                        <button
                            type="button"
                            class="btn btn-success btn-sm"
                            @click="createOrden"
                            style="margin-top:20px;"
                        >
                            Ordenar
                        </button>
                        <button
                            v-if="currentRoom.has_services"
                            type="button"
                            class="btn btn-primary btn-sm"
                            @click="checkServices(currentRoom.id)"
                            style="margin-top:20px;"
                        >
                            Promociones
                        </button>
                        <!-- <button type="button" class="btn btn-success m-2">
                        Ver ordenes
                    </button> -->

                        <button
                            v-if="
                                currentRoom.toPay && !currentRoom.is_month_rent
                            "
                            @click="payAll"
                            type="button"
                            class="btn btn-warning  btn-sm"
                            style="margin-top:20px;"
                        >
                            Pagar habitación
                        </button>

                        <button
                            v-else
                            @click="desocupiedRoom(currentRoom.id)"
                            type="button"
                            class="btn btn-warning  btn-sm"
                            style="margin-top:20px;"
                        >
                            Desocupar habitación
                        </button>
                        <button
                            @click="cancelRoom"
                            type="button"
                            class="btn btn-danger  btn-sm"
                            style="margin-top:20px;"
                        >
                            Cancelar alquiler
                        </button>
                    </div>
                    <!-- <div class="col-3 d-flex flex-column p-2 bg-warning rounded justify-content-center align-items-center">
                        Total ordenes <br />
                        S/ 1650.00
                    </div> -->
                </div>
                <div
                    class="m-1 d-flex justify-content-center alig-items-center"
                >
                    <div class="col-2 d-flex align-items-center">
                        <span class="text-muted h5">T. HABITACIÓN: </span>
                        <span class="h4">{{ currentRoom.total_room }}</span>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <span class="text-muted h5">T. ORDENES: </span>
                        <span class="h4">{{ currentRoom.total_orden }}</span>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <span class="text-muted h5">T. ADELANTO: </span>
                        <span class="h4">{{ currentRoom.advance }}</span>
                    </div>
                    <div
                        class="col-2 d-fle align-items-center"
                        v-if="extra_time > 0"
                    >
                        <span class="text-muted h5">PENALIDAD: </span>
                        <span class="h4">{{ extra_time }}</span>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <span class="text-muted h5">TOTAL: </span>
                        <span class="h4">{{
                            (
                                Number(currentRoom.total) + Number(extra_time)
                            ).toFixed(2)
                        }}</span>
                    </div>
                </div>
                <div class="row m-2" v-if="currentRoom.ordens.length > 0">
                    <div class="col-12">
                        <span class="text-muted h2">ORDENES</span>
                    </div>
                    <el-collapse v-model="activeOrdenRoom" accordion>
                        <el-collapse-item
                            v-for="(orden, idx) in currentRoom.ordens"
                            :key="idx"
                            :name="idx + 1"
                        >
                            <template slot="title">
                                <div
                                    class="w-100 d-flex justify-content-between"
                                >
                                    <div
                                        :class="
                                            `${orden.paid ? 'text-danger' : ''}`
                                        "
                                    >
                                        {{ orden.date }} - Total:
                                        {{ orden.total }} -
                                        {{ orden.paid ? "Cancelado" : "" }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a
                                            v-if="orden.document"
                                            :href="orden.document"
                                            target="_blank"
                                            style="margin-right:5px;"
                                            type="button"
                                            class="btn btn-success btn-sm"
                                        >
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <button
                                            style="margin-right:5px;"
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            @click="getOrden(orden.id)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            style="margin-right:5px;"
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, idx) in orden.items"
                                        :key="idx"
                                    >
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.quantity }}</td>
                                        <td>{{ item.price }}</td>
                                        <td>{{ item.total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </el-collapse-item>
                    </el-collapse>
                </div>
                <div class="row m-2" v-if="currentRoom.documents.length > 0">
                    <div class="col-12">
                        <span class="text-muted h4">
                            DOCUMENTOS DE ADELANTO
                        </span>
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Pdf</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(document,
                                    idx) in currentRoom.documents"
                                    :key="idx"
                                >
                                    <td>{{ document.number }}</td>
                                    <td>{{ document.date_of_issue }}</td>
                                    <td>{{ document.total }}</td>
                                    <td>
                                        <a
                                            :href="document.pdf"
                                            target="_blank"
                                            style="margin-right:5px;"
                                            type="button"
                                            class="btn btn-success btn-sm"
                                        >
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row m-3"></div>
            </template>
            <template v-else>
                <template v-if="!showReserves">
                    <div
                        v-if="tables.length > 0"
                        class="d-flex flex-wrap justify-content-center"
                    >
                        <div
                            v-for="(table, idx) in tables"
                            :class="
                                `${
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
                                        : 'btn-warning'
                                }`
                            "
                            class=" col-2 btn   m-1 d-flex flex-column justify-content-center align-items-center "
                            :key="idx"
                            @click="selectTable(table)"
                            style="max-height: 150px;    max-width: 135px;"
                        >
                            <template v-if="table.is_cleaning">
                                <el-tooltip
                                    :disabled="table.reserves.length == 0"
                                    placement="top"
                                >
                                    <div slot="content">
                                        <div
                                            v-for="(reserve,
                                            idx) in table.reserves"
                                            :key="idx"
                                        >
                                            <span>
                                                {{ reserve.checkin_date }} -
                                                {{ reserve.checkin_time }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div
                                            class="col-6 d-flex align-items-center overflow-hidden"
                                        >
                                            <svg
                                                fill="#fff"
                                                height="70px"
                                                width="60px"
                                                version="1.1"
                                                id="Layer_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 250 300"
                                                xml:space="preserve"
                                            >
                                                <g id="SVGRepo_iconCarrier">
                                                    <g id="XMLID_205_">
                                                        <g>
                                                            <g>
                                                                <circle
                                                                    cx="114.685"
                                                                    cy="24.613"
                                                                    r="24.613"
                                                                ></circle>
                                                                <path
                                                                    d="M251.932,283.747c-4.962-5.641-15.326-4.916-22.37-3.589c-1.214,0.229-2.467-0.078-3.437-0.844 c-0.969-0.766-1.262-1.964-1.616-3.148c-1.971-6.611-7.064-9.753-14.863-11.812c-3.568-0.943-7.014-1.531-10.401-1.472V112.795 l7.655-5.758c5.241-3.943,6.295-11.388,2.351-16.63c-2.443-3.248-6.231-4.883-10.007-4.723V36.035c0-3.231-2.619-5.85-5.85-5.85 s-5.85,2.619-5.85,5.85v55.84l-12.896,9.701l-0.083-16.541c-0.078-15.419-12.685-27.963-28.104-27.963 c-6.611,0-57.131,0-63.756,0c-15.419,0-28.026,12.544-28.104,27.963c-0.012,2.522-0.395,78.767-0.415,82.757 c-9.596,4.419-16.329,14.024-16.582,25.206l5.922,55.998c0.235,2.163,2.062,3.802,4.237,3.802h36.541 c2.18,0,4.009-1.645,4.239-3.814l5.932-55.986c-0.252-11.164-6.965-20.757-16.537-25.186c0.032-6.384,0.395-78.707,0.415-82.658 c0.007-1.265,1.035-2.285,2.299-2.281c1.264,0.004,2.287,1.029,2.287,2.293v74.952c15.831,8.013,21.539,24.83,20.585,33.838 l-5.932,55.986c-0.722,6.815-6.435,11.955-13.288,11.955h-1.36v22.894c0,7.871,6.38,14.251,14.251,14.251 s14.251-6.38,14.251-14.251V170.882h6.154v113.911c0,7.871,6.38,14.251,14.251,14.251c7.871,0,14.251-6.38,14.251-14.251 c0-186.144-0.253-83.868-0.259-199.861c0-1.373,1.113-2.487,2.487-2.488c1.373,0,2.488,1.113,2.488,2.486 c0,0.073-0.001,0.148-0.004,0.224l0.202,40.186c0.023,4.491,2.576,8.585,6.599,10.579c4.027,1.997,8.832,1.547,12.416-1.149 l17.514-13.175v143.328c-12.721,4.114-21.929,12.995-21.929,12.995c-34.275,30.775,58.298,17.672,81.737,20.622 C270.794,301.49,259.848,292.747,251.932,283.747z M85.377,192.998H46.706c0.214-6.457,3.607-12.123,8.659-15.48 c1.492,3.073,3.97,6.703,10.678,6.7c6.942-0.003,9.165-3.591,10.675-6.701C81.77,180.875,85.162,186.54,85.377,192.998z"
                                                                ></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div
                                            class="col-6 d-flex flex-column align-items-center justify-content-center"
                                        >
                                            <span>
                                                Limpieza
                                            </span>
                                            <span>
                                                {{
                                                    table.number
                                                        .toString()
                                                        .toUpperCase()
                                                }}
                                            </span>
                                            <span>
                                                {{
                                                    table.time_to_finish
                                                        ? table.time_to_finish
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </el-tooltip>
                            </template>
                            <template v-else>
                                <el-tooltip
                                    :disabled="table.reserves.length == 0"
                                    placement="top"
                                >
                                    <div slot="content">
                                        <div
                                            v-for="(reserve,
                                            idx) in table.reserves"
                                            :key="idx"
                                        >
                                            <span>
                                                Reserva N° {{ idx + 1 }} |
                                                {{ reserve.checkin_date }} -
                                                {{ reserve.checkin_time }}
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-column justify-content-center align-items-center"
                                    >
                                        <span
                                            class="text-white m-1"
                                            style="font-size:45px;"
                                        >
                                            <template
                                                v-if="
                                                    table.status_table_id == 1
                                                "
                                            >
                                                <i
                                                    class="fas fa-door-closed"
                                                ></i>
                                            </template>
                                            <template
                                                v-else-if="
                                                    table.status_table_id == 2
                                                "
                                            >
                                                <i class="fas fa-bed"></i>
                                            </template>
                                            <template
                                                v-else-if="
                                                    table.status_table_id == 3
                                                "
                                            >
                                                <i class="fas fa-tools"></i>
                                            </template>
                                            <template
                                                v-else-if="
                                                    table.status_table_id == 5
                                                "
                                            >
                                                <i class="fas fa-walking"></i>
                                            </template>
                                            <template v-else>
                                                <i class="fas fa-ban"></i>
                                            </template>
                                        </span>

                                        <span class="h6 mt-2 text-white">
                                            {{
                                                table.number
                                                    .toString()
                                                    .toUpperCase()
                                            }}
                                        </span>
                                        <small
                                            v-if="table.timer"
                                            class="text-white"
                                        >
                                            {{ table.timer }}
                                        </small>

                                        <span v-if="table.tower_name">
                                            {{ table.tower_name.toUpperCase() }}
                                        </span>
                                        <div
                                            class="d-flex"
                                            v-if="table.status_table_id != 3"
                                        >
                                            <el-tooltip
                                                content="Limpiar habitación"
                                            >
                                                <el-button
                                                    size="mini"
                                                    class="m-1"
                                                    @click="
                                                        sendToCleanById(
                                                            $event,
                                                            table.id
                                                        )
                                                    "
                                                >
                                                    <svg
                                                        fill="#000"
                                                        width="20px"
                                                        height="20px"
                                                        viewBox="-8.08 0 122.88 122.88"
                                                        version="1.1"
                                                        id="Layer_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        style="enable-background:new 0 0 106.72 122.88"
                                                        xml:space="preserve"
                                                        stroke="#ffffff"
                                                        stroke-width="0.0012288"
                                                        transform="rotate(0)"
                                                    >
                                                        <g
                                                            id="SVGRepo_iconCarrier"
                                                        >
                                                            <g>
                                                                <path
                                                                    d="M4.42,33.57c-0.66-5.38,0.44-9.98,2.7-13.69c1.65-2.7,3.9-4.9,6.54-6.56c2.6-1.63,5.57-2.74,8.69-3.27 c4.94-0.84,10.29-0.24,15.13,1.96c1.72-3.29,4.16-6.1,7.33-8.19C48.46,1.41,53.04,0,58.53,0c5.96,0,11.59,2.53,15.71,6.6 c3.05,3.03,5.27,6.92,6.17,11.26c3.55-1.84,6.87-2.69,9.86-2.68c2.46,0,4.7,0.58,6.67,1.65c1.96,1.07,3.63,2.61,4.96,4.56 c2.24,3.27,3.54,7.71,3.69,12.93c0.64,0.92,1.01,2.03,1.11,3.33c0.04,0.51,0.03,1.04-0.01,1.58c-0.02,0.19-0.05,0.37-0.1,0.54 l-16,70.03c-0.01,0.03-0.02,0.07-0.03,0.1l0,0c-3.72,13.67-13.03,13.27-23.32,12.82c-1.58-0.07-3.19-0.14-5.05-0.14h-17 c-2.48,0-3.96,0.03-5.31,0.05c-14.36,0.27-17.53,0.33-22.17-19.11l0-0.01l-0.01,0l-0.23-0.97c-2.1-1.21-4.08-2.72-5.91-4.54 C1.39,87.86-3.71,67.96,3.11,35.55c0.14-0.68,0.53-1.24,1.04-1.62C4.23,33.8,4.32,33.68,4.42,33.57L4.42,33.57z M78.35,44.25 c4.2,0,7.6,3.4,7.6,7.6c0,3.49-2.36,6.43-5.56,7.32c-2.3,19.92-14.95,35.36-29.48,42.62c-6.76,3.38-13.94,5.01-20.71,4.54 c-2.24-0.16-4.43-0.54-6.55-1.16c3.28,12.33,6.04,12.28,16.15,12.09c1.88-0.03,3.95-0.07,5.39-0.07h17c1.61,0,3.46,0.08,5.28,0.16 c8.03,0.35,15.3,0.66,17.89-8.86h0l15.96-69.87c0.02-0.23,0.02-0.43,0-0.6c-0.02-0.24-0.05-0.42-0.11-0.54 c-0.1-0.08-0.19-0.17-0.28-0.27c-0.2-0.09-0.5-0.15-0.89-0.19c-0.33-0.03-0.69-0.03-1.07-0.01c-0.11,0.01-0.21,0.02-0.33,0.02H8.7 c-0.13,0.02-0.2,0.06-0.22,0.1c-0.22,0.5-0.25,1.36-0.15,2.43l13.81,59.34c2.64,1.19,5.48,1.87,8.41,2.07 c5.83,0.4,12.05-1.03,17.95-3.98c13.05-6.53,24.42-20.39,26.53-38.31c-2.54-1.23-4.29-3.83-4.29-6.84 C70.76,47.66,74.16,44.25,78.35,44.25L78.35,44.25z M15.58,94.42L5.85,52.64c-2.04,20.94,2.21,34.29,9.5,41.56 C15.43,94.28,15.5,94.35,15.58,94.42L15.58,94.42z M100,31.62c-0.4-2.9-1.26-5.35-2.54-7.21c-0.86-1.25-1.9-2.22-3.09-2.87 c-1.19-0.65-2.57-0.99-4.11-0.99c-2.97,0-6.54,1.25-10.6,4.03l0,0c-0.44,0.3-0.97,0.47-1.54,0.47c-1.47-0.02-2.65-1.22-2.65-2.69 c-0.01-0.07-0.01-0.14-0.01-0.21c0-4.56-1.95-8.71-5-11.73c-3.13-3.1-7.41-5.03-11.92-5.03c-4.4,0-7.99,1.08-10.78,2.92 c-3.01,1.98-5.16,4.9-6.46,8.33c-0.06,0.17-0.14,0.33-0.24,0.49c-0.77,1.27-2.43,1.67-3.69,0.89c-4.34-2.65-9.45-3.46-14.12-2.66 c-2.43,0.41-4.73,1.26-6.72,2.51c-1.95,1.23-3.62,2.84-4.82,4.81c-1.48,2.43-2.27,5.44-2.06,8.97h88.98 C99.1,31.62,99.56,31.61,100,31.62L100,31.62z"
                                                                ></path>
                                                            </g>
                                                        </g>
                                                    </svg> </el-button
                                            ></el-tooltip>
                                            <el-tooltip
                                                content="Enviar mantenimiento"
                                            >
                                                <el-button
                                                    size="mini"
                                                    class="m-1"
                                                    @click="
                                                        sendToMaintenance(
                                                            $event,
                                                            table.id
                                                        )
                                                    "
                                                >
                                                    <svg
                                                        fill="#000000"
                                                        version="1.1"
                                                        id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        width="20px"
                                                        height="20px"
                                                        viewBox="0 0 500 500"
                                                        xml:space="preserve"
                                                    >
                                                        <g
                                                            id="SVGRepo_iconCarrier"
                                                        >
                                                            <g>
                                                                <path
                                                                    d="M487.43,70.684H12.57C5.628,70.684,0,76.312,0,83.255V256.19c0,6.942,5.628,12.57,12.57,12.57h84.374v118.273H34.665 c-6.942,0-12.571,5.629-12.571,12.571v17.142c0,6.941,5.629,12.569,12.571,12.569h149.7c6.942,0,12.569-5.628,12.569-12.569 v-17.142c0-6.941-5.627-12.571-12.569-12.571h-62.28V268.76h261.118v118.273h-62.28c-6.941,0-12.569,5.629-12.569,12.571v17.142 c0,6.941,5.628,12.569,12.569,12.569h149.701c6.942,0,12.569-5.628,12.569-12.569v-17.142c0-6.941-5.627-12.571-12.569-12.571 h-62.28V268.76h79.086c6.942,0,12.57-5.628,12.57-12.57V83.255C500,76.312,494.372,70.684,487.43,70.684z M42.372,243.62h-17.23 v-53.036l107.727-94.76h69.491L42.372,243.62z M135.373,243.62L295.951,95.825h68.677L204.05,243.62H135.373z M474.859,148.86 l-107.729,94.76h-69.49L457.629,95.825h17.23V148.86L474.859,148.86z"
                                                                ></path>
                                                            </g>
                                                        </g>
                                                    </svg> </el-button
                                            ></el-tooltip>
                                        </div>
                                    </div>
                                </el-tooltip>
                            </template>
                        </div>
                    </div>
                    <div
                        v-else
                        class="h-25 d-flex justify-content-center align-items-center"
                    >
                        <span>Sin habitaciones</span>
                    </div></template
                >
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
                                        v-if="reserve.room_state_id == 1"
                                        content="Tomar habitación"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            @click="selectReserve(reserve.id)"
                                        >
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip content="Editar fecha">
                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm"
                                            @click="editReserve(reserve.id)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip content="Cancelar reserva">
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            @click="cancelReserve(reserve.id)"
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
        <el-dialog
            :visible.sync="showGuesses"
            append-to-body
            title="Detalle de personas"
            @close="showGuesses = false"
        >
            <div class="row m-2 table-responsive" v-if="currentRoom">
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(guess, idx) in currentRoom.guesses"
                            :key="idx"
                        >
                            <td>{{ guess.name }}</td>
                            <td>{{ guess.number }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </el-dialog>
        <room-form
            @getTables="getTables"
            :showDialog.sync="showRoom"
            :table="currentTable"
            @emitAdvances="emitAdvances"
            :isReserve="isReserve"
            :hotelRentId="hotelRentId"
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
                        v-model="currentRoom.duration"
                    ></el-input-number>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showAddDays = false">Cancelar</el-button>
                <el-button type="primary" @click="addDays">Agregar</el-button>
            </span>
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
    </el-dialog>
</template>
<style>
.btn-black {
    background-color: #000;
}
.btn-free {
    background-color: #91d24c;
}
.btn-dirty {
    background-color: #a7a5a8;
}
.btn-reserve {
    background-color: #7030a0;
}
</style>
<script>
import RoomForm from "./room_form.vue";
import EditReserve from "./edit_reserve.vue";
import ServicesRoomModal from "./services_room_modal.vue";
import MaintenanceModal from "./maintenance_modal.vue";
export default {
    //tabla color verde
    props: ["showTables", "table", "roomSeeId", "printer", "configuration"],
    components: {
        RoomForm,
        EditReserve,
        ServicesRoomModal,
        MaintenanceModal
    },
    data() {
        return {
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
            timer: null,
            tower_id: null,
            showAddDays: false,
            extra_time: 0,
            isChangingRoom: false,
            showReserves: false,
            hotelRentId: null,
            showServices: false
        };
    },
    methods: {
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
                await this.$confirm(
                    "¿Está seguro de desocupar la habitación?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.get(
                    `/caja/rooms/desocupied/${id}`
                );
                if (response.status == 200) {
                    this.$toast.success("Habitación desocupada");
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
                await this.$confirm(
                    "¿Está seguro de cancelar la habitación?",
                    "Confirmación",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http(
                    `/caja/rooms/cancel/${this.currentRoom.id}`
                );
                if (response.status == 200) {
                    this.$toast.success("Habitación cancelada");
                    this.close2();
                    this.getTables();
                }
            } catch (e) {}
        },
        filterByReserve() {
            this.showReserves = true;
        },
        filterByStatus(id) {
            this.showReserves = false;
            this.tables = this.all_tables
                .filter(table => table.status_table_id == id)
                .map(table => {
                    table.tower_name = table.floor.tower.name;
                    return table;
                });
        },
        reserveRoom() {
            this.isReserve = true;
            this.showRoom = true;
        },
        async emitAdvances(id) {
            const response = await this.$http(`/caja/rooms/advance/${id}`);
            const { data } = response;
            let { items, hotel_rent_id, customer_number } = data;
            this.$emit("paymentsOrden", {
                items,
                is_room: true,
                is_advance: true,
                hotel_rent_id,
                customer_number
            });
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
                `/caja/rooms/add_days/${this.currentRoom.id}/${this.currentRoom.duration}`
            );
            this.showAddDays = false;
            this.getRoomDetail(this.currentTable.id);
        },
        close2() {
            this.viewingRoom = false;
            // this.currentTable = null;
            this.currentRoom = null;
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
            if(this.configuration.maintenance_workers){
                this.sendToCleanById(null, this.currentTable.id);
            }else{
                  const response = await this.$http(
                `/caja/rooms/send_to_clean/${this.currentTable.id}`
            );

            if (response.status == 200) {
                this.$emit("getTablesToClean");
                this.getTables();
            }
            }
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
                customer_id
            } = data;
            this.$emit("paymentsOrden", {
                items: ordens_items,
                is_room: true,
                orden_ids,
                hotel_rent_item_ids,
                hotel_rent_id,
                customer_number,
                customer_id
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

                    if (response.status == 200) {
                        this.getTables();
                    }
                } catch (e) {
                    console.log(e);
                }
            } else {
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
                                    : "btn-warning"
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
        }
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    }
};
</script>
