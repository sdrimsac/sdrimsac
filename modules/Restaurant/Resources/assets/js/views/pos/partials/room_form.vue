<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        :close-on-click-modal="false"
        v-loading="loading"
        :element-loading-text="textLoading"
        width="70%"
    >
        <div class="row mt-2">
            <div class="col-md-8">
                <div class="card p-3 mb-2" style="margin-right: 8px;">
                    <div class="row align-items-center">
                        <div class="col-md-2 d-flex justify-content-center">
                            <i class="fas fa-user fa-4x text-primary"></i>
                        </div>
                        <div class="col-md-10">
                            <label for="name"
                                >Huesped
                                <a href="#" @click.prevent="createClient(null)">
                                    [ + Nuevo ]
                                </a>
                            </label>
                            <el-select
                                class="col-md-6"
                                ref="select_person"
                                v-model="form.customer_id"
                                filterable
                                clearable
                                size="small"
                                placeholder="Ingrese datos del Huesped"
                                :disabled="loading"
                                @change="changeCustomer"
                                @keyup.native="keyupCustomer"
                            >
                                <el-option
                                    v-for="(option, idx) in customers"
                                    :key="idx"
                                    :label="option.description"
                                    :value="option.id"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 mb-2" style="margin-left: 8px;">
                    <div class="col-md-4" style="display: none;">
                        <label for="total">Subtotal</label>
                        <el-input
                            type="number"
                            readonly
                            v-model="form.sub_total"
                        >
                        </el-input>
                    </div>
                    <!-- <div class="col-md-4">
                        <label for="total">Adelantos</label>
                        <el-input
                            type="number"
                            readonly
                            v-model="form.advance"
                        >
                        </el-input>
                    </div> -->
                    <div class="col-md-12">
                        <label for="total">Total a pagar</label>
                        <el-input type="number" readonly v-model="form.total">
                        </el-input>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <el-tooltip
                            content="Agregar mas habitaciones para obtener Pack de descuento"
                            placement="top"
                        >
                            <el-button
                                class="btn-agregar btn-agregar:hover"
                                @click="addEmptyRoom"
                                type="primary"
                                :disabled="!form.customer_id"
                            >
                                <i class="fas fa-bed mr-2"></i>
                                Agregar
                            </el-button>
                        </el-tooltip>
                    </div>
                    <div
                        class="col-md-6"
                        v-if="
                            form.customer_id &&
                                showPackInput &&
                                rooms.length > 1
                        "
                    >
                        <label class="w-100" for="discount_pack">
                            Descuento
                            <el-tooltip
                                content="Descuento por PACK de habitaciones"
                                placement="top"
                            >
                                <i
                                    class="fas fa-info-circle text-danger ml-2"
                                ></i>
                            </el-tooltip>
                        </label>
                        <el-input
                            class="w-100"
                            type="number"
                            :min="1"
                            @input="calculateTotal"
                            v-model="form.discount_pack"
                            placeholder=""
                            size="small"
                            :disabled="!form.customer_id"
                        >
                        </el-input>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div
                    class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
                >
                    <!-- Botón Cancelar -->
                    <el-button
                        class="btn-cancel btn-cancel:hover"
                        icon="fas fa-times fa-lg"
                        @click="close()"
                        size="small"
                    >
                        <span>Cancelar</span>
                    </el-button>
                    <!-- Botón Guardar -->
                    <el-button
                        class="btn-save btn-save:hover"
                        icon="fas fa-save fa-lg"
                        type="primary"
                        @click="submit"
                        :disabled="!form.customer_id"
                        size="small"
                    >
                        <span>Guardar</span>
                    </el-button>
                </div>
            </div>
        </div>

        <!-- Datos que son validos  pero que no se muestran  -->
        <div class="row mt-2" style="display: none;">
            <div class="col-md-4">
                <label for="total">Subtotal</label>
                <el-input type="number" readonly v-model="form.sub_total">
                </el-input>
            </div>
            <!-- <div class="col-md-4">
            <label for="total">Adelantos</label>
            <el-input
                type="number"
                readonly
                v-model="form.advance"
            >
            </el-input>
            </div> -->
            <div class="col-md-4">
                <label for="total">Total a pagar</label>
                <el-input type="number" readonly v-model="form.total">
                </el-input>
            </div>
            <div class="col-12">
                <label for="observation">Observación</label>
                <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="Observación"
                    v-model="form.observation"
                >
                </el-input>
            </div>
        </div>

        <el-collapse v-model="collap" class="mt-2">
            <el-collapse-item name="1">
                <template slot="title">
                    <div class="card-body ms-3">
                        N° {{ isReserve ? "Reservas" : "Habitaciones" }}
                        {{ rooms.length }}
                    </div>
                </template>
                <div
                    class="row mt-1 card-body"
                    v-for="(room, idx) in rooms"
                    :key="idx"
                    style="background-color: #e9dada;"
                >
                    <el-divider content-position="left">
                        {{ isReserve ? "Reserva" : "Habitación" }}
                        {{ idx + 1 }}

                        <template v-if="rooms.length > 1">
                            <el-tooltip
                                content="Elimina habitación adicional"
                                placement="top"
                            >
                                <el-button
                                    type="danger"
                                    icon="el-icon-delete"
                                    size="mini"
                                    @click="removeRoom(idx)"
                                    circle
                                    :disabled="!form.customer_id"
                                ></el-button>
                            </el-tooltip>
                        </template>
                    </el-divider>
                    <div class="col-12" v-if="room.description">
                        <div class="alert alert-success">
                            <div class="row">
                                <div class="col-2">
                                    <strong>Incluye:</strong>
                                </div>
                                <div class="col-10">
                                    <span style="font-size: 0.9em;">
                                        {{ room.description }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-5">
                            <div class="card p-2 mb-2">
                                <div class="row">
                                    <div
                                        class="col-6 d-flex align-items-center"
                                    >
                                        <el-checkbox
                                            @change="changeMonthRent(room)"
                                            v-model="room.is_month_rent"
                                            :disabled="!form.customer_id"
                                            label="Mensual"
                                        >
                                            <span
                                                style="color: #FFC107; font-weight: bold;"
                                                >Mensual</span
                                            >
                                        </el-checkbox>
                                    </div>
                                    <div
                                        class="col-6 d-flex align-items-center"
                                    >
                                        <el-checkbox
                                            v-if="!isReserve"
                                            @change="verifyIsReserve(room)"
                                            v-model="room.is_reserve"
                                            :disabled="!form.customer_id"
                                            label="Reserva"
                                        >
                                            <span
                                                style="color: #7030a0; font-weight: bold;"
                                                >Reserva</span
                                            >
                                        </el-checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="row w-100">
                                <div class="col-md-4 d-flex flex-column">
                                    <label for="name">
                                        <i class="fas fa-building mr-1"></i>
                                        Torre
                                    </label>
                                    <el-select
                                        v-model="room.tower_id"
                                        @change="
                                            filterFloors(room.tower_id, idx)
                                        "
                                        :disabled="!form.customer_id"
                                    >
                                        <el-option
                                            v-for="option in towers"
                                            :key="option.id"
                                            :label="option.name"
                                            :value="option.id"
                                        ></el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-4 d-flex flex-column">
                                    <label for="name">
                                        <i class="fas fa-layer-group mr-1"></i>
                                        Piso
                                    </label>
                                    <el-select
                                        v-model="room.floor_id"
                                        @change="
                                            filterTables(room.floor_id, idx)
                                        "
                                        :disabled="!form.customer_id"
                                    >
                                        <el-option
                                            v-for="option in floors"
                                            :key="option.id"
                                            :label="option.name"
                                            :value="option.id"
                                        ></el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-4 d-flex flex-column">
                                    <label for="name">
                                        <i class="fas fa-hashtag mr-1"></i> Nro
                                    </label>
                                    <el-select
                                        @change="changeTable(room)"
                                        v-model="room.table_id"
                                        :disabled="!form.customer_id"
                                    >
                                        <el-option
                                            v-for="option in tables"
                                            :key="option.id"
                                            :label="option.number"
                                            :value="option.id"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="quantity_persons">
                                # Ocupantes
                                <el-tooltip
                                    content="Máximo 2 Ocupantes por habitación"
                                    placement="top"
                                    effect="dark"
                                >
                                    <i
                                        class="fas fa-info-circle ml-1"
                                        style="color: #ff4d4f;"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-input
                                v-model.number="room.quantity_persons"
                                type="number"
                                :min="1"
                                :max="2"
                                style="width: 100%;"
                                size="small"
                                :disabled="!form.customer_id"
                                @input="
                                    val => {
                                        if (val < 1) room.quantity_persons = 1;
                                        else if (val > 2)
                                            room.quantity_persons = 2;
                                    }
                                "
                                @keydown.native="
                                    e => {
                                        // Permitir solo 1, 2, backspace, tab, flechas, delete
                                        if (
                                            ![
                                                '1',
                                                '2',
                                                'Backspace',
                                                'Tab',
                                                'ArrowLeft',
                                                'ArrowRight',
                                                'Delete'
                                            ].includes(e.key)
                                        ) {
                                            e.preventDefault();
                                        }
                                    }
                                "
                            />
                        </div>
                        <div class="col-md-9">
                            <label for="name"
                                >Ocupante
                                <a href="#" @click.prevent="createClient(idx)">
                                    <el-tooltip
                                        content="Crear Nuevo Ocupante"
                                        placement="top"
                                    >
                                        <i
                                            class="fas fa-plus"
                                            style="color: #28a745;"
                                        ></i>
                                    </el-tooltip>
                                </a>
                            </label>
                            <div class="d-flex align-items-end">
                                <el-select
                                    class="mr-2 flex-grow-1"
                                    ref="select_guess"
                                    v-model="room.guess_id"
                                    filterable
                                    clearable
                                    size="small"
                                    placeholder=""
                                    :disabled="loading || !form.customer_id"
                                    @keyup.native="keyupCustomer"
                                    style="min-width: 0;"
                                >
                                    <el-option
                                        v-for="(option, idx) in customers"
                                        :key="idx"
                                        :label="option.description"
                                        :value="option.id"
                                    ></el-option>
                                </el-select>
                                <el-button
                                    @click="checkGuessSelected(idx)"
                                    type="primary"
                                    :disabled="!form.customer_id"
                                    style="margin-left: 8px;"
                                >
                                    Agregar Ocupante
                                </el-button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="checkin_date">
                                Fecha de ingreso
                            </label>
                            <el-date-picker
                                @change="changeTable(room)"
                                v-model="room.checkin_date"
                                type="date"
                                placeholder="Fecha de ingreso"
                                size="small"
                                style="width: 100%;"
                                value-format="yyyy-MM-dd"
                                :picker-options="{
                                    defaultDate: Date.now('America/Lima'),
                                    disabledDate: time => {
                                        return (
                                            time.getTime() < Date.now() - 8.64e7
                                        );
                                    }
                                }"
                                :disabled="!form.customer_id"
                            ></el-date-picker>

                            <label for="checkin_time">
                                Hora de ingreso
                            </label>
                            <el-time-picker
                                @change="changeTable(room)"
                                v-model="room.checkin_time"
                                size="small"
                                placeholder="Hora de ingreso"
                                style="width: 100%;"
                                value-format="HH:mm:ss"
                                :format="'hh:mm A'"
                                :picker-options="{
                                    format: 'hh:mm A'
                                }"
                                timezone="America/Lima"
                                :disabled="!form.customer_id"
                            ></el-time-picker>
                        </div>
                        <div class="col-md-4">
                            <label for="duration">
                                <template v-if="room.is_month_rent">
                                    Mes
                                </template>
                                <template v-else>
                                    Días
                                </template>
                            </label>
                            <el-input
                                type="number"
                                @input="changeTable(room)"
                                v-model="room.duration"
                                placeholder="Duración"
                                size="small"
                                step="1"
                                style="width: 100%;"
                                :disabled="!form.customer_id"
                            ></el-input>
                            <br />
                            <div v-if="room.services.length > 0 && !room.is_month_rent" class="mb-2">
                                Promociones
                                <div
                                    class="d-flex align-items-center mb-2 w-100"
                                >
                                    <el-checkbox
                                        @change="discountService(room)"
                                        v-model="room.discount_instead_services"
                                        label="Cambiar por descuento"
                                        :disabled="room.is_month_rent || !form.customer_id"
                                        class="flex-grow-1"
                                        style="margin-left: 8px;"
                                    ></el-checkbox>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="total_room">Adelanto de pago </label>
                            <el-input
                                type="number"
                                :min="0"
                                @input="calculateTotal"
                                v-model="room.advances"
                                :disabled="!form.customer_id"
                            >
                            </el-input>
                            <label for="total_room">Subtotal</label>
                            <el-input
                                type="number"
                                readonly
                                v-model="room.total"
                            >
                            </el-input>
                            <small
                                class="text-danger"
                                v-if="room.discount_instead_services"
                            >
                                Descuento S/{{
                                    configuration.discount_amount_instead_service *
                                        room.duration
                                }}
                            </small>
                        </div>
                    </div>

                    <div class="row mt-2" v-if="!room.is_month_rent">
                        <div class="col-md-6">
                            <template v-if="room.has_frigobar">
                                <div class="row">
                                    <div class="col-md-6" v-if="room">
                                        <el-checkbox
                                            v-model="room.enable_frigobar"
                                            :disabled="!form.customer_id"
                                        >
                                            <i
                                                class="fas fa-wine-bottle mr-1"
                                            ></i>
                                            Frigobar
                                        </el-checkbox>
                                        <el-input
                                            :disabled="
                                                !room.enable_frigobar ||
                                                    !form.customer_id
                                            "
                                            type="number"
                                            :min="0"
                                            step="any"
                                            v-model="room.credit_line"
                                        >
                                        </el-input>
                                    </div>
                                    <div
                                        class="col-md-6"
                                        v-if="insumos.length > 0"
                                    >
                                        <label
                                            for="insumos"
                                            class="label-control"
                                        >
                                            Insumos
                                            <el-tooltip
                                                effect="dark"
                                                placement="top"
                                            >
                                                <span slot="content">
                                                    <div
                                                        v-for="insumo in insumos"
                                                        :key="insumo.id"
                                                    >
                                                        {{
                                                            insumo.item_description
                                                        }}
                                                        <br />
                                                    </div>
                                                </span>
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-input
                                            type="number"
                                            :min="1"
                                            :max="2"
                                            step="any"
                                            v-model="room.insumos"
                                            @input="limitInsumos(room, idx)"
                                            :disabled="!form.customer_id"
                                        >
                                        </el-input>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="col-md-6">
                            <div v-if="room.services.length > 0" class="row">
                                <!-- <div
                                    class="col-md-4"
                                    v-for="(service, sidx) in room.services"
                                    :key="`_sidx${sidx}`"
                                >
                                    <label for="total_room" class="w-100">
                                        {{ service.name }}
                                    </label>
                                    <el-input-number
                                        :min="1"
                                        :max="2"
                                        :controls="false"
                                        :disabled="
                                            room.discount_instead_services ||
                                                !form.customer_id
                                        "
                                        @input="
                                            val => {
                                                if (val < 1)
                                                    service.quantity = 1;
                                                else if (val > 2)
                                                    service.quantity = 2;
                                                updateServices;
                                            }
                                        "
                                        @keydown.native="
                                            e => {
                                                // Permitir solo 1, 2, backspace, tab, flechas, delete
                                                if (
                                                    ![
                                                        '1',
                                                        '2',
                                                        'Backspace',
                                                        'Tab',
                                                        'ArrowLeft',
                                                        'ArrowRight',
                                                        'Delete'
                                                    ].includes(e.key)
                                                ) {
                                                    e.preventDefault();
                                                }
                                            }
                                        "
                                        v-model="service.quantity"
                                    >
                                    </el-input-number>
                                </div> -->
                                <div
                                    class="col-md-6"
                                    v-for="(service, sidx) in room.services"
                                    :key="`_sidx${sidx}`"
                                >
                                    <label for="total_room" class="w-100"
                                        >{{ service.name }}
                                    </label>
                                    <!-- <el-input-number
                                        :min="0"
                                        :max="2"
                                        :disabled="
                                            room.discount_instead_services
                                        "
                                        @input="updateServices"
                                        v-model="service.quantity"
                                    >
                                    </el-input-number> -->

                                    <el-input-number
                                        v-model="service.quantity"
                                        controls-position="right"
                                        @input="updateServices"
                                        
                                        :min="0"
                                        :max="2"
                                    >
                                    </el-input-number>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row mt-2" v-for="(guess, gidx) in room.guesses" :key="gidx">
                       
                        <div class="col-4">
                            <div v-if="room.services.length > 0" class="row">
                                <div
                                    class="col-md-3"
                                    v-for="(service, sidx) in room.services"
                                    :key="`_sidx${sidx}`"
                                >
                                    <label for="total_room" class="w-100"
                                        >{{ service.name }}
                                    </label>
                                    <el-input-number
                                        :min="0"
                                        :max="2"
                                        :disabled="room.discount_instead_services || !form.customer_id"
                                        @input="checkCustomerSelected($event, updateServices)"
                                        v-model="service.quantity"
                                    >
                                    </el-input-number>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div
                        class="col-12"
                        v-for="(guess, gidx) in room.guesses"
                        :key="gidx"
                    >
                        <div class="d-flex align-items-center">
                            <div class="row">
                                <div class="col-8">
                                    <span class="mr-2">
                                        <strong>Ocupante:</strong>
                                        <br />
                                        {{ guess.name }}
                                        <br />
                                        <small class="d-block">{{
                                            guess.number
                                        }}</small>
                                    </span>
                                </div>
                                <div class="col-4">
                                    <el-button
                                        type="danger"
                                        icon="el-icon-delete"
                                        size="mini"
                                        @click.prevent="removeGuess(room, gidx)"
                                        circle
                                        :disabled="!form.customer_id"
                                        class="ml-2"
                                    ></el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-collapse-item>
        </el-collapse>
        <div
            class="row mt-2"
            v-if="hasAdvances > 0 && configuration.variation_hotel"
        >
            <div class="row">
                PRODUCTO VARIACIÓN
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                    <label for="description">Descripción</label>
                    <el-input
                        v-model="paymentVariation.description"
                        placeholder="Descripción"
                        clearable
                        :disabled="!form.customer_id"
                    ></el-input>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <label for="price">Precio</label>
                    <el-input
                        v-model="paymentVariation.price"
                        placeholder="Precio"
                        clearable
                        :disabled="!form.customer_id"
                    ></el-input>
                </div>
            </div>
        </div>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :input_person="input_person"
            :external="true"
        >
        </person-form>
    </el-dialog>
</template>
<script>
import Swal from "sweetalert2";
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: [
        "itemDefault",
        "configuration",
        "showDialog",
        "table",
        "isReserve",
        "hotelRentId"
    ],
    components: {
        PersonForm
    },

    created() {
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
    },
    computed: {
        hasAdvances() {
            return this.rooms.filter(r => r.advances > 0).length;
        }
    },
    data() {
        return {
            paymentVariation: {
                description: "Consumo",
                price: 0
            },
            credit_line_limit: 150,
            services: [],
            all_services: [],
            title: "Ingreso de huesped",
            textLoading: "Cargando...",
            collap: ["1"],
            loading: false,
            input_person: {
                number: ""
            },
            rooms: [],
            form: {},
            towers: [],
            floors: [],
            tables: [],
            all_towers: [],
            all_floors: [],
            all_tables: [],
            customers: [],
            all_customers: [],
            time: null,
            loading: false,
            showDialogNewPerson: false,
            idxRoom: null,
            showPackInput: false // <-- NUEVO
        };
    },
    methods: {
        checkCustomerSelected(action) {
            if (!this.form.customer_id) {
                this.$showSAlert(
                    "Alerta",
                    "Debe seleccionar un cliente",
                    "warning"
                );
                return;
            }
            if (typeof action === "function") {
                action();
            }
        },
        removeGuess(room, idx) {
            room.guesses.splice(idx, 1);
            room.quantity_persons = room.guesses.length;
            if (room.quantity_persons == 0) {
                room.quantity_persons = 1;
            }
            // this.calculateTotal();
        },
        discountService(room) {
            let { discount_instead_services } = room;
            if (discount_instead_services) {
                room.services = room.services.map(s => {
                    s.quantity = 0;
                    return s;
                });
            }
            this.calculateTotal();
        },
        limitInsumos(room, idx) {
            if (room.insumos > 2) {
                Swal.fire("Solo puede seleccionar 2 insumos");
                room.insumos = 2;
            }
            if (room.insumos < 1) {
                Swal.fire("Debe seleccionar al menos 1 insumo");
                room.insumos = 1;
            }
        },
        async changeMonthRent(room) {
            let { is_month_rent } = room;
            if (is_month_rent) {
            }
            await this.checkDateReserve(room);
            this.calculateTotal();
        },
        /* async changeMonthRent(room) {
            let { is_month_rent } = room;
            if (is_month_rent) {
                // Verificar disponibilidad al marcar "Mensual"
                const disp = await this.checkDateReserve(room, true);
                if (disp) {
                    Swal.fire({
                        icon: "success",
                        title: "Habitación Disponible",
                        text: "Puede continuar con el procedimiento."
                    });
                }
            }
            this.calculateTotal();
        }, */
        async changeTable(room) {
            this.textLoading = "Verificando reserva...";
            await this.checkDateReserve(room);
            this.showServices(room);
            this.calculateTotal();
        },
        resetTextLoading() {
            this.textLoading = "Cargando...";
        },
        async checkDateReserve(room, showAvailableMsg = false) {
            try {
                this.loading = true;
                let {
                    table_id,
                    checkin_date,
                    checkin_time,
                    duration,
                    is_month_rent
                } = room;
                const response = await this.$http.post(
                    "/caja/rooms/check_reserve",
                    {
                        table_id,
                        checkin_date,
                        checkin_time,
                        duration,
                        is_month_rent
                    }
                );
                if (response.status == 200) {
                    const { success, message } = response.data;
                    if (success) {
                        delete room.not_available;
                        if (showAvailableMsg) {
                            // Mensaje personalizado solo si se solicita
                            return true;
                        } else {
                            Swal.fire(message);
                        }
                    } else {
                        room.not_available = true;
                        Swal.fire(message);
                    }
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
            return false;
        },
        async verifyIsReserve(room) {
            if (room.is_reserve) {
                this.textLoading = "Verificando reserva...";
                await this.checkDateReserve(room);
            }

            this.resetTextLoading();
        },
        removeRoom(idx) {
            this.rooms.splice(idx, 1);
            this.calculateTotal();
        },
        filterFloors(tower_id, idx) {
            this.floors = this.all_floors.filter(f => f.tower_id == tower_id);
            this.rooms[idx].floor_id = null;
            this.rooms[idx].table_id = null;
            this.calculateTotal();
        },
        filterTables(floor_id, idx) {
            this.tables = this.all_tables.filter(t => t.floor_id == floor_id);
            this.rooms[idx].table_id = null;
            this.calculateTotal();
        },
        initForm() {
            this.rooms = [];
            this.services = [];
            this.form = {
                observation: "",
                customer_id: null,
                sub_total: 0,
                advance: 0,
                total: 0
            };
        },
        async reloadDataCustomers(customer_id) {
            this.$http.get(`/pos/table/customers`).then(async response => {
                this.customers = [...this.customers, ...response.data];
                this.removeDuplicateCustomer();

                if (this.idxRoom != null) {
                    this.rooms[this.idxRoom].guess_id = customer_id;
                } else {
                    this.form.customer_id = customer_id;
                }
                // this.changeCustomer();
            });
        },
        removeDuplicateCustomer() {
            const ids = new Set(this.customers.map(c => c.id));
            const persons = this.all_customers.filter(
                person => !ids.has(person.id)
            );

            this.customers = [...this.customers, ...persons];
        },
        calculateSubtotal() {
            let subtotal = 0;
            let advance = 0;
            for (let room of this.rooms) {
                let { advances } = room;

                if (room.table_id) {
                    let table = this.all_tables.find(
                        t => t.id == room.table_id
                    );
                    if (table.description) {
                        room.description = table.description.replaceAll(
                            "/",
                            "·"
                        );
                    }
                    if (table) {
                        let { price, month_price } = table;
                        if (room.is_month_rent) {
                            price = month_price;
                        }
                        price = price * room.duration;
                        room.original_price = price;
                        let result = price - Number(advances);
                        if (room.discount_instead_services) {
                            let {
                                discount_amount_instead_service
                            } = this.configuration;
                            discount_amount_instead_service = Number(
                                discount_amount_instead_service
                            );
                            result -=
                                discount_amount_instead_service * room.duration;
                        }
                        if (
                            this.form.discount_pack > 0 &&
                            this.rooms.length > 1
                        ) {
                            result -= this.form.discount_pack;
                        }
                        room.total = result;

                        subtotal += result;
                    }
                }
                // advance += Number(advances);
            }
            this.form.sub_total = subtotal;
            this.form.advance = advance;
        },
        calculateTotal() {
            this.calculateSubtotal();
            if (this.form.advance > this.form.sub_total) {
                this.form.advance = 0;
                Swal.fire("El adelanto no puede ser mayor al total");
            }
            let total = this.form.sub_total - this.form.advance;
            this.form.total = total;
        },
        addGuess(idx) {
            if (!this.rooms[idx].guess_id) {
                Swal.fire("Debe seleccionar un cliente");
                return;
            }
            let customer = this.customers.find(
                c => c.id == this.rooms[idx].guess_id
            );
            this.rooms[idx].guesses.push(customer);
            if (this.rooms[idx].guesses) {
                this.rooms[idx].quantity_persons = this.rooms[
                    idx
                ].guesses.length;
            }
            this.rooms[idx].guess_id = null;
        },
        checkRoomIsExist({ tower_id, floor_id, table_id }) {
            let exist = this.rooms.find(
                r =>
                    r.tower_id == tower_id &&
                    r.floor_id == floor_id &&
                    r.table_id == table_id
            );
            if (exist) {
                return true;
            }
            return false;
        },
        addRoom({ tower_id, floor_id, table_id }) {
            let room = {
                discount_instead_services: false,
                insumos: 1,
                enable_frigobar: false,
                credit_line: 0,
                is_reserve: this.isReserve,
                total: 0,
                original_total: 0,
                is_month_rent: false,
                advances: 0,
                guess_id: null,
                tower_id,
                floor_id,
                table_id,
                quantity_persons: 1,
                duration: 1,
                checkin_date: new Date(),
                checkin_time: new Date(),
                guesses: [],
                services: []
            };
            let table = this.all_tables.find(t => t.id == table_id);

            if (table && table.description) {
                room.description = table.description.replaceAll("/", "·");
                room.has_frigobar = table.has_frigobar;
                room.credit_line = this.credit_line_limit;
            }
            this.rooms.push(room);
            this.calculateTotal();
            // if(!this.checkRoomIsExist(room)){
            //     this.rooms.push(room);
            // }else{
            //     this.$message({
            //         message: "La habitación ya existe",
            //         type: "warning"
            //     });
            // }
        },
        addEmptyRoom() {
            this.addRoom({ tower_id: null, floor_id: null, table_id: null });
            if (this.form.customer_id && this.rooms.length > 1) {
                this.showPackInput = true;
            }
        },
        async getTables() {
            const response = await this.$http.get(
                `/caja/rooms/tablas?is_reserve=${this.isReserve}`
            );
            // this.rooms = response.data.tables;
            let {
                insumos,
                towers,
                floors,
                tables,
                services,
                credit_line_hotel_limit
            } = response.data;
            this.all_towers = towers;
            this.insumos = insumos;
            this.all_floors = floors;
            this.all_tables = tables;
            this.all_services = services;
            this.credit_line_limit = credit_line_hotel_limit || 150;

            ///
            // this.towers = towers;
            // this.floors = floors;
            // this.tables = tables;
        },
        createClient(idx = null) {
            this.idxRoom = idx;
            this.value = null;
            if (idx == null) {
                this.form.customer_id = null;
            }
            this.showDialogNewPerson = true;
        },
        async updateAllCustomers(personsFromServer) {
            // Mapea los nuevos datos por sus IDs
            const newCustomersById = new Map(
                personsFromServer.map(person => [person.id, person])
            );

            // Combina los nuevos datos con los datos existentes usando un conjunto para evitar duplicados
            const combinedCustomers = new Map([
                ...this.customers.map(customer => [customer.id, customer]),
                ...newCustomersById
            ]);

            // Actualiza this.customers con la nueva lista de clientes
            this.customers = Array.from(combinedCustomers.values());
        },
        async keyupCustomer(e) {
            //buscar
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0].value;
                const response = await this.$http(
                    `/caja/search_customers?value=${this.input_person.number}`
                );
                const { persons } = response.data;

                let customers = persons.filter(n => n.number != "88888888");
                this.updateAllCustomers(customers);
            }, 500);
        },
        async keyupGuess(e) {
            //buscar
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.input_person.number = this.$refs.select_guess.$el.getElementsByTagName(
                    "input"
                )[0].value;
                const response = await this.$http(
                    `/caja/search_customers?value=${this.input_person.number}`
                );
                const { persons } = response.data;

                this.customers = persons.filter(n => n.number != "88888888");
                this.updateAllCustomers(this.customers);
            }, 500);
        },
        changeCustomer() {},

        async submit() {
            this.form.rooms = this.rooms;
            if (this.rooms.length == 0) {
                this.form.discount_pack = 0;
            }
            if (!this.validate()) {
                return;
            }
            try {
                this.loading = true;

                const response = await this.$http.post(
                    "/caja/rooms/set-guess",
                    this.form
                );
                if (response.status == 200) {
                    this.$showSAlert(
                        "Éxito",
                        "Huesped ingresado correctamente"
                    );
                    this.$emit("getTables");
                    if (this.hasAdvances) {
                        let { id } = response.data;
                        if (this.paymentVariation.price > 0) {
                            this.$emit(
                                "emitAdvances",
                                id,
                                this.paymentVariation
                            );
                        } else {
                            this.$emit("emitAdvances", id);
                        }
                    }
                    this.$emit("update:showDialog", false);
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                Swal.fire("Error al ingresar huesped");
            }
        },
        validate() {
            let pass = true;
            let { customer_id, rooms } = this.form;
            if (!customer_id) {
                Swal.fire("Debe seleccionar un cliente");
                pass = false;
            }
            for (let idx in rooms) {
                let room = rooms[idx];
                if (!room.table_id) {
                    Swal.fire(
                        `Habitación N° ${parseInt(idx) +
                            1} tiene datos incompletos`
                    );
                    pass = false;
                }
                if (room.not_available) {
                    Swal.fire(
                        `Habitación N° ${parseInt(idx) + 1} no está disponible`
                    );
                    pass = false;
                }
                if (!room.enable_frigobar) {
                    room.credit_line = 0;
                }
            }
            return pass;
        },
        async open() {
            this.paymentVariation = {
                description: "Consumo",
                price: 0
            };
            this.loading = true;
            this.keyupCustomer();
            this.initForm();
            await this.getTables();
            await this.getHotelRent();
            if (this.table) {
                this.defaultTable(this.table);
                this.addRoom({
                    table_id: this.table.id,
                    floor_id: this.table.floor_id,
                    tower_id: this.table.floor.tower_id
                });
                if (this.isReserve) {
                    this.title = "Reserva de habitación";
                    let [room] = this.rooms;
                    this.textLoading = "Verificando reserva...";
                    await this.checkDateReserve(room);
                }
                let [room] = this.rooms;
                this.showServices(room);
            }
            this.loading = false;
            // Lanzar alerta si no hay cliente seleccionado
            this.checkCustomerSelected();
        },
        updateServices() {
            this.$forceUpdate();
        },
        showServices(room) {
            let table = this.all_tables.find(t => t.id == room.table_id);
            if (table) {
                let { services, has_frigobar } = table;
                if (services.length > 0) {
                    room.services = this.all_services
                        .filter(s =>
                            services.some(ss => ss.room_service_id == s.id)
                        )
                        .map(s => {
                            s.quantity = 0;
                            return s;
                        });
                } else {
                    room.services = [];
                }
                room.has_frigobar = has_frigobar;
            } else {
                room.services = [];
            }
        },
        async getHotelRent() {
            if (!this.hotelRentId) return;

            const response = await this.$http(
                `/caja/rooms/get_hotel_rent/${this.hotelRentId}`
            );
            const { data } = response;
            let { customer } = data;
            this.customers = [customer];
            this.all_customers = [customer];
            this.form.customer_id = customer.id;
        },
        defaultTable(table) {
            let {
                floor_id,
                floor: { tower_id }
            } = table;
            this.towers = this.all_towers;
            this.floors = this.all_floors.filter(f => f.tower_id == tower_id);
            this.tables = this.all_tables.filter(t => t.floor_id == floor_id);
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        checkGuessSelected(idx) {
            const room = this.rooms[idx];
            if (!room.guess_id) {
                Swal.fire("seleccionar  un huesped o Registrar uno nuevo");
                return;
            }
            if (room.guesses.length >= 2) {
                Swal.fire("Máximo puedo agregar 2 ocupantes por habitación");
                return;
            }
            this.addGuess(idx);
        }
    }
};
</script>
