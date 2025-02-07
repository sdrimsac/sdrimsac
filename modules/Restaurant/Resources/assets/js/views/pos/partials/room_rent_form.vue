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
        width="60%"
    >
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="name"
                    >Cliente
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
                    placeholder="Cliente"
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

            <div class="col-md-4">
                <label for="quantity_persons">N° Personas</label>
                <el-input-number
                    v-model="form.quantity_persons"
                    :min="1"
                    style="width: 100%;"
                    :step="1"
                    :max="4"
                    size="small"
                ></el-input-number>
            </div>
            <div class="col-md-4">
                <label for="checkin_date">
                    Fecha de ingreso
                </label>
                <el-date-picker
                    v-model="form.checkin_date"
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
            <div class="col-md-4">
                <label for="checkin_date">
                    Fecha de pago
                </label>
                <el-date-picker
                    v-model="form.date_payment"
                    type="date"
                    placeholder="Fecha de pago"
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
            <div class="col-md-4">
                <label for="checkin_date">
                    Tiempo de permanencia (en meses)
                </label>
                <el-input-number
                    class="w-100"
                    v-model="form.duration"
                    :min="1"
                    :max="36"
                    size="small"
                ></el-input-number>
            
            </div>
            <div class="col-md-4">
                <label for="checkin_date">
                    Tipo
                </label>
                <el-select v-model="form.table_type_id" @change="updatePrice">
                    <el-option
                        v-for="(data, index) in types"
                        :key="index"
                        :label="data.name"
                        :value="data.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label for="total">Mensualidad</label>
                <el-input type="number"
                @input="calculateTotal"
                 v-model="form.sub_total">
                </el-input>
            </div>
            <div class="col-md-4">
                <label for="total_room">Garantia</label>
                <el-input
                    type="number"
                    :min="0"
                    @input="calculateTotal"
                    v-model="form.advances"
                >
                </el-input>
            </div>

            <div class="col-md-4">
                <label for="total">Total a pagar</label>
                <el-input type="number" readonly v-model="form.total">
                </el-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                        <label for="name"
                            >Agregar huespedes
                            <a href="#" @click.prevent="createClient(null)">
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
                                v-for="(option, idx) in customers"
                                :key="idx"
                                :label="option.description"
                                :value="option.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div
                        class="col-md-3 d-flex"
                        :class="
                            `${
                            
                                ' align-items-end'
                            }`
                        "
                    >
                        <el-button @click="addGuess()" type="primary">
                            Agregar Huesped
                        </el-button>
                    </div>
        </div>
        <div
                        class="row mt-2"
                        v-for="(guess, gidx) in guesses"
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
                                @click.prevent="removeGuess(guess, gidx)"
                                circle
                            ></el-button>
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

        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <!-- Botón Cancelar -->
            <el-button
                class="btn-cancel btn-cancel:hover"
                icon="fas fa-times fa-lg"
                @click="close()"
            >
                <span>Cancelar</span>
            </el-button>
            <!-- Botón Guardar -->
            <el-button
                class="btn-save btn-save:hover"
                icon="fas fa-save fa-lg"
                type="primary"
                @click="submit"
            >
                <span>Guardar</span>
            </el-button>
        </div>
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
import moment from "moment";
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: [
        "configuration",
        "showDialog",
        "table",
        "isReserve",
        "hotelRentId",
        "types"
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

    },
    data() {
        return {
            guesses: [],
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
            form: {
                quantity_persons: 1,
                checkin_date: moment().format("YYYY-MM-DD"),
                checkout_date: null,
                observation: "",
                customer_id: null,
                sub_total: 0,
                advances: 0,
                total: 0,
                table_type_id: null
            },
            towers: [],
            table_types: [],
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
            room: {}
        };
    },
    methods: {
        removeGuess(guess, idx){
            this.guesses.splice(idx, 1);
            this.form.quantity_persons = this.guesses.length;
            if (this.guesses.length == 0) {
                this.form.quantity_persons = 1;
            }
        },
        addGuess(){
            if (this.guesses && this.guesses.length >= 4) {
                this.$message({
                    message: "Solo puede agregar hasta 4 huéspedes",
                    type: "warning"
                });
                return;
            }

            if (!this.room.guess_id) {
                this.$message({
                    message: "Debe seleccionar un huésped",
                    type: "warning"
                });
                return;
            }
            let customer = this.customers.find(
                c => c.id == this.room.guess_id
            );
            this.guesses.push(customer);

            if (this.guesses) {
                this.form.quantity_persons = this.guesses.length;
            }

            // this.form.quantity_persons = this.rooms[idx].quantity_persons;
            this.room.guess_id = null;
        },

        updatePrice() {
            let [type] = this.types.filter(
                t => t.id == this.form.table_type_id

            );
            this.form.advances = type.price;
            this.form.sub_total = type.price;
            this.calculateTotal();
        },
        removeGuess(room, idx) {
            room.guesses.splice(idx, 1);
            room.quantity_persons = room.guesses.length;
            if (room.quantity_persons == 0) {
                room.quantity_persons = 1;
            }
            // this.calculateTotal();
        },
    
        limitInsumos(room, idx) {
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
    
    
        resetTextLoading() {
            this.textLoading = "Cargando...";
        },
    
    
    

        initForm() {
            this.guesses = [];
            this.rooms = [];
            this.services = [];
            this.form = {
                duration: 1,
                date_payment: moment().format("YYYY-MM-DD"),
                quantity_persons: 1,
                checkin_date: moment().format("YYYY-MM-DD"),
                checkout_date: null,
                observation: "",
                customer_id: null,
                sub_total: 0,
                advance: 0,
                total: 0,
                table_type_id: null
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
    
        calculateTotal() {
            
            let total = Number(this.form.sub_total) + Number(this.form.advances)    ;
            this.form.total = total;
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
                is_month_rent: true,
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
                table_types,
                tables,
                services,
                credit_line_hotel_limit
            } = response.data;
            this.all_towers = towers;
            this.insumos = insumos;
            this.all_floors = floors;
            this.table_types = table_types;
            this.all_tables = tables;
            this.all_services = services;
            this.credit_line_limit = credit_line_hotel_limit || 150;

            ///
            // this.towers = towers;
            // this.floors = floors;
            // this.tables = tables;
        },
        createClient(idx = null) {
        
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

            if (e && e.target) {
                const value = e.target.value;
                if (value) {
                    this.input_person.number = value;
                    setTimeout(async () => {
                        const response = await this.$http(
                            `/caja/search_customers?value=${this.input_person.number}`
                        );
                        const { persons } = response.data;

                        let customers = persons.filter(
                            n => n.number != "88888888"
                        );
                        this.updateAllCustomers(customers);
                    }, 500);
                }
            } else {
                console.warn(
                    "El evento o su propiedad target no están disponibles."
                );
            }
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
    
            if (!this.validate()) {
                return;
            }
            try {
                this.loading = true;
                this.form.table_id = this.table.id;
                this.form.guesses = this.guesses;
                const response = await this.$http.post(
                    "/caja/rent/set-room-rent",
                    this.form
                );
                if (response.status == 200) {
                    let { rent_id } = response.data;
                    this.$emit("finishRegister", rent_id);
                    this.$emit("update:rentId", rent_id);
                    this.close();
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                this.$toast.error("Error al ingresar huesped");
            }
        },
        validate() {
            let pass = true;
            let { customer_id, table_type_id, sub_total, advances , checkin_date, duration} = this.form;
            if (!customer_id) {
                this.$toast.warning("Debe seleccionar un cliente");
                pass = false;
            }

            if (!table_type_id) {
                this.$toast.warning("Debe seleccionar un tipo de habitación");
                pass = false;
            }

            if (!duration || duration < 1) {
                this.$toast.warning("Debe ingresar el tiempo de permanencia");
                pass = false;
            }


            if (!sub_total || sub_total < 0) {
                this.$toast.warning("Debe ingresar la mensualidad");
                pass = false;
            }

            if (!advances || advances < 0) {
                this.$toast.warning("Debe ingresar la garantía");
                pass = false;
            }

            if (!checkin_date) {
                this.$toast.warning("Debe ingresar la fecha de ingreso");
                pass = false;
            }

            return pass;
        },
        async open() {
            this.paymentVariation = {
                description: "Consumo",
                price: 0
            };
            this.loading = true;
            this.initForm();
            if (this.table) {
                let [type] = this.types;
                if (type) {
                    this.form.table_type_id = type.id;
                    this.updatePrice();
                }
            }
            this.loading = false;
        },
        updateServices() {
            this.$forceUpdate();
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
                /* table_type_id, */
                floor_id,
                floor: { tower_id }
            } = table;
            this.towers = this.all_towers;
            this.floors = this.all_floors.filter(f => f.tower_id == tower_id);
            this.tables = this.all_tables.filter(t => t.floor_id == floor_id);
            /* this.table_types = this.all_tables.filter(
                t => t.table_type_id == table_type_id
            ); */
        },
        close() {
            
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
