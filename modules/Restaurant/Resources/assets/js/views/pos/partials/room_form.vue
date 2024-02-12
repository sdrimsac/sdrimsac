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
    >
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="name"
                    >Cliente
                    <a href="#" @click.prevent="createClient">
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
                    placeholder="Cliente"
                    :disabled="loading"
                    @change="changeCustomer"
                    @keyup.native="keyupCustomer"
                >
                    <el-option
                        v-for="option in customers"
                        :key="option.id"
                        :label="option.description"
                        :value="option.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <el-button @click="addRoom" type="primary">
                    Agregar habitación
                </el-button>
            </div>
            <div class="col-md-5"
                v-if="rooms.length > 1"
            >
                <label 
                class="w-100"
                for="discount_pack">Pack - Dscto por cada habitación</label>
               <el-input
               class="w-100"
                    type="number"
                    :min="1"
                    @input="calculateTotal"
                    v-model="form.discount_pack"
                    placeholder="Descuento por paquete"
                    size="small"
                >
                </el-input>
            </div>
        </div>
        <div class="row mt-2">
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
        </div>
        <div class="row mt-2">
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
                    N° {{ isReserve ? "Reservas" : "Habitaciones" }}
                    {{ rooms.length }}
                </template>
                <div class="row mt-1" v-for="(room, idx) in rooms" :key="idx">
                    <el-divider content-position="left"
                        >{{ isReserve ? "Reserva" : "Habitación" }}
                        {{ idx + 1 }}

                        <template v-if="rooms.length > 1">
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                size="mini"
                                @click="removeRoom(idx)"
                                circle
                            ></el-button>
                        </template>
                    </el-divider>
                    <div class="col-12" v-if="room.description">
                        <div class="alert alert-success">
                            LA HABITACIÓN INCLUYE:
                            <strong>
                                {{ room.description }}
                            </strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <el-checkbox
                                @change="changeMonthRent(room)"
                                v-model="room.is_month_rent"
                                label="Alquiler mensual"
                            ></el-checkbox>
                        </div>
                        <div class="col-3">
                            <el-checkbox
                                v-if="!isReserve"
                                @change="verifyIsReserve(room)"
                                v-model="room.is_reserve"
                                label="Es reserva"
                            ></el-checkbox>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Torre</label>
                        <el-select
                            v-model="room.tower_id"
                            @change="filterFloors(room.tower_id, idx)"
                        >
                            <el-option
                                v-for="option in towers"
                                :key="option.id"
                                :label="option.name"
                                :value="option.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Piso</label>
                        <el-select
                            v-model="room.floor_id"
                            @change="filterTables(room.floor_id, idx)"
                        >
                            <el-option
                                v-for="option in floors"
                                :key="option.id"
                                :label="option.name"
                                :value="option.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Habitación</label>
                        <el-select
                            @change="changeTable(room)"
                            v-model="room.table_id"
                        >
                            <el-option
                                v-for="option in tables"
                                :key="option.id"
                                :label="option.number"
                                :value="option.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4">
                        <label for="quantity_persons">N° Personas</label>
                        <el-input-number
                            v-model="room.quantity_persons"
                            :min="1"
                            style="width: 100%;"
                            :step="1"
                            size="small"
                        ></el-input-number>
                    </div>
                    <div class="col-md-3">
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
                                    return time.getTime() < Date.now() - 8.64e7;
                                }
                            }"
                        ></el-date-picker>
                    </div>
                    <div class="col-md-3">
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
                        ></el-time-picker>
                    </div>
                    <div class="col-md-2">
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
                        ></el-input>
                    </div>
                    <div class="col-md-3">
                        <label for="name"
                            >Agregar huespedes
                            <a href="#" @click.prevent="createClient(idx)">
                                [ + Nuevo ]
                            </a>
                        </label>
                        <el-select
                            class="col-md-6"
                            ref="select_guess"
                            v-model="room.guess_id"
                            filterable
                            clearable
                            size="small"
                            placeholder="Cliente"
                            :disabled="loading"
                            @keyup.native="keyupCustomer"
                        >
                            <el-option
                                v-for="option in customers"
                                :key="option.id"
                                :label="option.description"
                                :value="option.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 d-flex"
                    :class="`${
                        room.discount_instead_services ? ' align-items-center' : ' align-items-end'
                    }`"
                    >
                        <el-button @click="addGuess(idx)" type="primary">
                            Agregar Huesped
                        </el-button>
                    </div>
                    <div class="col-md-3">
                        <label for="total_room">Adelanto de pago </label>
                        <el-input
                            type="number"
                            :min="0"
                            @input="calculateTotal"
                            v-model="room.advances"
                        >
                        </el-input>
                    </div>
                    <div class="col-md-3">
                        <label for="total_room">Subtotal</label>
                        <el-input type="number" readonly v-model="room.total">
                        </el-input>
                        <small 
                        class="text-danger"
                        v-if="room.discount_instead_services">
                           Descuento S/{{ configuration.discount_amount_instead_service * room.duration }}
                           
                        </small>
                    </div>
                    <div
                        class="row mt-2"
                        v-for="(guess, gidx) in room.guesses"
                        :key="gidx"
                    >
                        <div class="col-8">
                            <span>
                                {{ guess.name }}
                                <br />
                                <small>
                                    {{ guess.number }}
                                </small>
                            </span>
                        </div>
                        <div class="col-4">
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                size="mini"
                                @click="room.guesses.splice(gidx, 1)"
                                circle
                            ></el-button>
                        </div>
                    </div>
                    <el-divider
                        v-if="room.services.length > 0"
                        content-position="left"
                        >Promociones
                        
                        <el-checkbox
                            @change="discountService(room)"
                            v-model="room.discount_instead_services"
                            label="Cambiar por descuento"
                        ></el-checkbox>
                        </el-divider
                    >
                    <div v-if="room.services.length > 0" class="row">
                        <div
                            class="col-md-3"
                            v-for="(service, sidx) in room.services"
                            :key="`_sidx${sidx}`"
                        >
                            <label for="total_room" class="w-100">{{ service.name }} </label>
                            <el-input-number
                                :min="0"
                                :max="2"
                                :disabled="room.discount_instead_services"
                                @input="updateServices"
                                v-model="service.quantity"
                            >
                            </el-input-number>
                        </div>
                    </div>
                    <template v-if="room.has_frigobar">
                        <el-divider content-position="left"> </el-divider>
                        <div class="row">
                            <div class="col-md-3">
                                <el-checkbox v-model="room.enable_frigobar">
                                    Garantía frigobar
                                </el-checkbox>
                                <el-input
                                    :disabled="!room.enable_frigobar"
                                    type="number"
                                    :min="0"
                                    step="any"
                                    v-model="room.credit_line"
                                >
                                </el-input>
                            </div>
                            <div class="col-md-3" v-if="insumos.length > 0">
                                <label for="insumos" class="label-control"
                                    >Insumos

                                    <el-tooltip effect="dark" placement="top">
                                        <span slot="content">
                                            <div
                                                v-for="insumo in insumos"
                                                :key="insumo.id"
                                            >
                                                {{ insumo.item_description }}
                                                <br />
                                            </div>
                                        </span>
                                        <i class="fas fa-info-circle"></i>
                                    </el-tooltip>
                                </label>
                                <el-input
                                    type="number"
                                    :min="1"
                                    :max="2"
                                    step="any"
                                    v-model="room.insumos"
                                    @input="limitInsumos(room,idx)"
                                >
                                </el-input>
                            </div>
                        </div>
                    </template>
                </div>
            </el-collapse-item>
        </el-collapse>

        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </span>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :input_person="input_person"
            :external="true"
            :recordId="form.customer_id"
        >
        </person-form>
    </el-dialog>
</template>

<script>
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: [
        "configuration",
        "showDialog", "table", "isReserve", "hotelRentId"],
    components: {
        PersonForm
    },

    created() {
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
    },
    data() {
        return {
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
            idxRoom: null
        };
    },
    methods: {
        discountService(room){
            let {discount_instead_services} = room;
            if(discount_instead_services){
                room.services = room.services.map(s=>{
                    s.quantity = 0;
                    return s;
                });
            }
            this.calculateTotal();
        },
        limitInsumos(room,idx) {
            if (room.insumos > 2) {
                this.$message({
                    message: "Solo puede seleccionar 2 insumos",
                    type: "warning"
                });
                room.insumos = 2;
            }
            if (room.insumos < 1) {
                this.$message({
                    message: "Debe seleccionar al menos 1 insumo",
                    type: "warning"
                });
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
        async changeTable(room) {
            this.textLoading = "Verificando reserva...";
            await this.checkDateReserve(room);
            this.showServices(room);
            this.calculateTotal();
        },
        resetTextLoading() {
            this.textLoading = "Cargando...";
        },
        async checkDateReserve(room) {
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
                        this.$toast.success(message);
                    } else {
                        room.not_available = true;
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
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
            let ids = this.customers.map(c => c.id);
            let persons = [];

            for (let person of this.all_customers) {
                let existInList = ids.find(p => p == person.id);
                if (existInList == undefined) {
                    persons.push(person);
                }
            }
            let newData = [];

            newData = [...this.customers, ...persons];

            this.customers = newData;
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
                        if(room.discount_instead_services){
                            let {discount_amount_instead_service} = this.configuration;
                            discount_amount_instead_service = Number(discount_amount_instead_service);
                            result -= discount_amount_instead_service * room.duration;
                        }
                        if(this.form.discount_pack > 0){
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
                this.$message({
                    message: "El adelanto no puede ser mayor al total",
                    type: "warning"
                });
            }
            let total = this.form.sub_total - this.form.advance;
            this.form.total = total;
        },
        addGuess(idx) {
            if (!this.rooms[idx].guess_id) {
                this.$message({
                    message: "Debe seleccionar un cliente",
                    type: "warning"
                });
                return;
            }
            let customer = this.customers.find(
                c => c.id == this.rooms[idx].guess_id
            );
            this.rooms[idx].guesses.push(customer);
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
                discount_instead_services:false,
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
            this.form.customer_id = null;
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
        hasAdvances() {
            let has = false;
            for (let room of this.rooms) {
                if (room.advances > 0) {
                    has = true;
                    break;
                }
            }
            return has;
        },

        async submit() {

            this.form.rooms = this.rooms;
            if(this.rooms.length == 0){
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
                    this.$toast.success("Huesped ingresado correctamente");
                    this.$emit("getTables");
                    if (this.hasAdvances()) {
                        let { id } = response.data;
                        this.$emit("emitAdvances", id);
                    }
                    this.$emit("update:showDialog", false);
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                this.$toast.error("Error al ingresar huesped");
            }
        },
        validate() {
            let pass = true;
            let { customer_id, rooms } = this.form;
            if (!customer_id) {
                this.$toast.warning("Debe seleccionar un cliente");
                pass = false;
            }
            for (let idx in rooms) {
                let room = rooms[idx];
                if (!room.table_id) {
                    this.$toast.warning(
                        `Habitación N° ${idx + 1} tiene datos incompletos`
                    );
                    pass = false;
                }
                if (room.not_available) {
                    this.$toast.warning(
                        `Habitación N° ${idx + 1} no está disponible`
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
        }
    }
};
</script>
