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
            <div
                class="col-md-6 d-flex align-items-center justify-content-center"
            >
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
                                        v-if="room.month_price > 0"
                                    >
                                        <el-checkbox
                                            @change="changeMonthRent(room)"
                                            v-model="room.is_month_rent"
                                            :disabled="!form.customer_id || room.is_reserve"
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
                                            :disabled="!form.customer_id || room.is_month_rent"
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
                                        :disabled="true"
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
                                    content="Puede fijar la cantidad o agregar ocupantes por nombre"
                                    placement="top"
                                    effect="dark"
                                >
                                    <i
                                        class="fas fa-info-circle ml-1"
                                        style="color: #409EFF;"
                                    ></i>
                                </el-tooltip>
                            </label>
                            <el-input
                                v-model.number="room.quantity_persons"
                                type="number"
                                :min="1"
                                style="width: 100%;"
                                size="small"
                                :disabled="!form.customer_id"
                                @input="
                                    val => {
                                        // Solo enteros >= 1
                                        let n = parseInt(val, 10);
                                        if (isNaN(n) || n < 1) n = 1;
                                        // Debe ser al menos el número de ocupantes con nombre
                                        if (room.guesses && n < room.guesses.length) {
                                            n = room.guesses.length;
                                        }
                                        room.quantity_persons = n;
                                    }
                                "
                                @keydown.native="
                                    e => {
                                        // Permitir dígitos, backspace, tab, flechas, delete
                                        const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete'];
                                        if (allowed.includes(e.key)) return;
                                        if (!/^[0-9]$/.test(e.key)) {
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
                            <el-input-number
                                type="number"
                                @input="val => {
                                    // Solo permitir 0.5 o enteros >= 1
                                    if (val === 0.5) {
                                        room.duration = 0.5;
                                    } else if (Number.isInteger(val) && val >= 1) {
                                        room.duration = val;
                                    } else if (val < 0.5) {
                                        room.duration = 0.5;
                                    } else {
                                        // Si no es válido, dejar el último valor válido
                                        room.duration = room.duration || 1;
                                    }
                                    changeTable(room);
                                }"
                                v-model="room.duration"
                                size="small"
                                :min="0.5"
                                style="width: 100%;"
                                :disabled="!form.customer_id"
                            />
                            <br />
                            <div
                                v-if="
                                    room.services.length > 0 &&
                                        !room.is_month_rent
                                "
                                class="mb-2"
                            >
                                Promociones
                                <div
                                    class="d-flex align-items-center mb-2 w-100"
                                >
                                    <el-checkbox
                                        @change="discountService(room)"
                                        v-model="room.discount_instead_services"
                                        label="Cambiar por descuento"
                                        :disabled="
                                            room.is_month_rent ||
                                                !form.customer_id
                                        "
                                        class="flex-grow-1"
                                        style="margin-left: 8px;"
                                    ></el-checkbox>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="total_room">Adelanto de pago</label>
                            <el-input
                                type="number"
                                :min="0"
                                :max="room.max_advance || 0"
                                step="any"
                                v-model.number="room.advances"
                                @input="val => onAdvancesInput(room, val)"
                                @keydown.native="e => {
                                    // Bloquear signo negativo y notación exponencial
                                    if (e.key === '-' || e.key === 'e' || e.key === 'E') {
                                        e.preventDefault();
                                    }
                                }"
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
                                        :disabled="
                                            room.discount_instead_services
                                        "
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
        // Obtiene un número seguro de un valor (prop numérica o dígitos en string)
        _toNum(v) {
            if (v === null || v === undefined) return NaN;
            if (typeof v === "number") return v;
            const m = String(v).match(/-?\d+/);
            return m ? Number(m[0]) : NaN;
        },
        // Ordena pisos de una torre por claves conocidas o por dígitos en name; fallback por id
        getOrderedFloorsForTower(towerId) {
            const keys = ["order", "position", "level", "number", "floor_number", "sort", "index"];
            const list = this.all_floors.filter(f => f.tower_id == towerId);
            return list.sort((a, b) => {
                let av = NaN, bv = NaN;
                for (const k of keys) {
                    if (k in a && k in b) {
                        av = this._toNum(a[k]);
                        bv = this._toNum(b[k]);
                        if (!Number.isNaN(av) && !Number.isNaN(bv)) break;
                    }
                }
                if (Number.isNaN(av) || Number.isNaN(bv)) {
                    av = this._toNum(a.name);
                    bv = this._toNum(b.name);
                }
                if (Number.isNaN(av) || Number.isNaN(bv)) {
                    av = this._toNum(a.id);
                    bv = this._toNum(b.id);
                }
                return av - bv;
            });
        },
        // Ordena mesas (tables) por 'number' si es numérico; si no, por id
        getOrderedTablesForFloor(floorId) {
            const list = this.all_tables.filter(t => t.floor_id == floorId);
            return list.sort((a, b) => {
                let av = this._toNum(a.number);
                let bv = this._toNum(b.number);
                if (Number.isNaN(av) || Number.isNaN(bv)) {
                    av = this._toNum(a.id);
                    bv = this._toNum(b.id);
                }
                return av - bv;
            });
        },
        onAdvancesInput(room, val) {
            // Normaliza entradas vacías o no numéricas a 0
            if (val === '' || val === null || val === undefined) {
                room.advances = 0;
                this.calculateTotal();
                return;
            }
            // Asegura no negativos
            let n = Number(val);
            if (isNaN(n) || n < 0) n = 0;

            const max = Number(room.max_advance || 0);

            // Permitir cualquier valor entre 0 y max (inclusive)
            if (n > max) n = max;
            if (n < 0) n = 0;

            // Redondeo opcional a 2 decimales
            room.advances = Math.round(n * 100) / 100;
            this.calculateTotal();
        },
        removeGuess(room, idx) {
            room.guesses.splice(idx, 1);
            // La cantidad mínima es 1 + ocupantes con nombre
            const base = 1 + (room.guesses ? room.guesses.length : 0);
            // No reducir por debajo del mínimo; mantener si el usuario fijó un número mayor
            room.quantity_persons = Math.max(base, room.quantity_persons || 1);
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
            // Si se marca mensual, desactiva reserva para esta habitación
            if (is_month_rent && room.is_reserve) {
                room.is_reserve = false;
            }
            await this.checkDateReserve(room);
            this.calculateTotal();
        },
        async changeTable(room, showAvailableMsg = false) {
            this.textLoading = "Verificando reserva...";
            // Sincroniza month_price según la mesa seleccionada
            const _table = this.all_tables.find(t => t.id == room.table_id);
            room.month_price = Number((_table && _table.month_price) || 0);
                if (!room.month_price) {
                    room.is_month_rent = false;
                }
            await this.checkDateReserve(room, showAvailableMsg);
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
                            return true;
                        } else {
                            this.$showSAlert(message, "puede realizar la reserva");
                        }
                    } else {
                        room.not_available = true;
                        this.$showSAlert("ALERTA", message, "warning");
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
                // Si se marca reserva, desactiva mensual para esta habitación
                if (room.is_month_rent) {
                    room.is_month_rent = false;
                }
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
            // Filtra y ordena los pisos por torre seleccionada
            const towerFloors = this.getOrderedFloorsForTower(tower_id);
            this.floors = towerFloors;

            // Mantiene el piso actual si sigue siendo válido; de lo contrario, selecciona el primero
            const currentFloorId = this.rooms[idx].floor_id;
            const hasValidCurrent = towerFloors.some(
                f => f.id == currentFloorId
            );
            if (!hasValidCurrent) {
                this.rooms[idx].floor_id = towerFloors.length ? towerFloors[0].id : null;
            }

            // Al cambiar de torre, limpia la mesa seleccionada y actualiza el listado de mesas según el piso vigente
            this.rooms[idx].table_id = null;
            // Resetear opción mensual al cambiar de torre/piso
            this.rooms[idx].month_price = 0;
            this.rooms[idx].is_month_rent = false;
            if (this.rooms[idx].floor_id) {
                this.filterTables(this.rooms[idx].floor_id, idx);
            } else {
                this.tables = [];
            }

            this.calculateTotal();
        },
        filterTables(floor_id, idx) {
            // Filtrar y ordenar mesas por número/id
            this.tables = this.getOrderedTablesForFloor(floor_id);
            this.rooms[idx].table_id = null;
            // Al limpiar la mesa seleccionada también ocultar opción mensual
            this.rooms[idx].month_price = 0;
                this.rooms[idx].is_month_rent = false;
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
                        room.description = table.description.replaceAll('/', '·');
                    }
                    if (table) {
                        let { price, month_price } = table;
                        if (room.is_month_rent) {
                            price = month_price;
                        }
                        price = price * room.duration;
                        room.original_price = price;
                        // Descuento por servicios si aplica
                        if (room.discount_instead_services && this.configuration && this.configuration.discount_amount_instead_service) {
                            price = price - (this.configuration.discount_amount_instead_service * room.duration);
                        }
                        // Descuento por pack si aplica
                        if (this.form && this.form.discount_pack && this.rooms.length > 1) {
                            price = price - Number(this.form.discount_pack || 0);
                        }

                        // Precio base (antes de adelanto) y tope de adelanto
                        const basePrice = Math.max(0, Number(price));
                        room.max_advance = basePrice;

                        // Clampea advances entre 0 y basePrice
                        const numericAdvance = Math.min(Math.max(0, Number(advances || 0)), basePrice);
                        room.advances = isNaN(numericAdvance) ? 0 : numericAdvance;

                        const result = Math.max(0, basePrice - Number(room.advances || 0));
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
                this.$showSAlert(
                    "ALERTA",
                    "El adelanto no puede ser mayor al total"
                );
            }
            let total = this.form.sub_total - this.form.advance;
            this.form.total = total;
        },
        addGuess(idx) {
            let customer = this.customers.find(
                c => c.id == this.rooms[idx].guess_id
            );
            this.rooms[idx].guesses.push(customer);
            // Si se agregan nombres, la cantidad mínima pasa a ser 1 + #nombres
            const base = 1 + this.rooms[idx].guesses.length;
            this.rooms[idx].quantity_persons = Math.max(
                base,
                this.rooms[idx].quantity_persons || 1
            );
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
                month_price: 0,
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
            if (table) {
                room.month_price = Number(table.month_price || 0);
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

            // Autoseleccionar torre (y por consecuencia el piso por defecto de esa torre)
            const idx = this.rooms.length - 1;
            if (this.all_towers && this.all_towers.length > 0) {
                const defaultTowerId = this.all_towers[0].id;
                // Asegura que el combo de torres esté poblado
                this.towers = this.all_towers;
                // Asignar torre y refrescar pisos/mesas con lógica centralizada
                this.rooms[idx].tower_id = defaultTowerId;
                // Forzar actualización inmediata por si el componente no emite change al setear programáticamente
                this.filterFloors(defaultTowerId, idx);

                // Asegura que el primer piso quede seleccionado y las mesas se carguen
                const towerFloors = this.getOrderedFloorsForTower(defaultTowerId);
                if (towerFloors.length > 0) {
                    const defaultFloorId = towerFloors[0].id;
                    this.rooms[idx].floor_id = this.rooms[idx].floor_id || defaultFloorId;
                    this.tables = this.getOrderedTablesForFloor(this.rooms[idx].floor_id);
                    // Selecciona automáticamente la primera mesa disponible
                    if (this.tables.length > 0) {
                        this.rooms[idx].table_id = this.tables[0].id;
                        // Inicializa servicios/totales sin mostrar alerta de disponibilidad
                        this.changeTable(this.rooms[idx], true);
                    }
                } else {
                    this.tables = [];
                }
            }

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

            // Inicializar opciones visibles
            this.towers = towers;
            this.floors = [];
            this.tables = [];
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
                    // Validar success del backend
                    if (response.data && response.data.success === false) {
                        this.$showSAlert("ALERTA", response.data.message, "warning");
                        this.loading = false;
                        return;
                    }
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
                this.$showSAlert(
                    "ALERTA",
                    "Error al ingresar huesped",
                    "warning"
                );
            }
        },
        validate() {
            console.log("Validando formulario...");
            let pass = true;
            let { customer_id, rooms, advance, sub_total } = this.form;
            if (!customer_id) {
                this.$showSAlert(
                    "ALERTA",
                    "Debe seleccionar un cliente",
                    "warning"
                );
                pass = false;
            }

            // Validación de adelanto mayor al subtotal
            if (Number(advance) > Number(sub_total)) {
                this.$showSAlert(
                    "ALERTA",
                    "El adelanto no puede ser mayor al total",
                    "warning"
                );
                pass = false;
            }

            for (let idx in rooms) {
                let room = rooms[idx];

                // Validación: no permitir que ambos flags estén activos
                if (room.is_month_rent && room.is_reserve) {
                    this.$showSAlert(
                        "ALERTA",
                        `Habitación N° ${parseInt(idx) + 1}: seleccione solo "Mensual" o "Reserva", no ambos`,
                        "warning"
                    );
                    pass = false;
                }

                if (
                    room.is_reserve &&
                    (!room.advances || Number(room.advances) <= 0)
                ) {
                    this.$showSAlert(
                        "ALERTA",
                        `debe ingresar un adelanto de pago para realizar reservas`,
                        "warning"
                    );
                    pass = false;
                }
                if (!room.table_id) {
                    this.$showSAlert(
                        "ALERTA",
                        `Habitación N° ${parseInt(idx) +
                            1} tiene datos incompletos`
                    );
                    pass = false;
                }
                if (room.not_available) {
                    this.$showSAlert(
                        "ALERTA",
                        `Habitación N° ${parseInt(idx) + 1} no está disponible`, "warning"
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
            } else {
                // Sin mesa preseleccionada: crear una habitación por defecto
                // y autoseleccionar torre/piso para que se carguen las mesas
                this.addEmptyRoom();
            }
            this.loading = false;
            // Lanzar alerta si no hay cliente seleccionado
            /* this.checkCustomerSelected(); */
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
            // Evitar duplicados por ID
            if (room.guesses && room.guesses.some(g => g.id == room.guess_id)) {
                Swal.fire("El ocupante ya fue agregado");
                return;
            }
            this.addGuess(idx);
            // Asegurar consistencia después de agregar
            const base = 1 + (room.guesses ? room.guesses.length : 0);
            room.quantity_persons = Math.max(base, room.quantity_persons || 1);
        }
    }
};
</script>
