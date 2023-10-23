<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        title="Ingreso de huesped"
        :close-on-click-modal="false"
        v-loading="loading"
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
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="total">Subtotal</label>
                <el-input type="number" readonly v-model="form.sub_total">
                </el-input>
            </div>
            <div class="col-md-4">
                <label for="total">Adelantos</label>
                <el-input
                    type="number"
                    @input="calculateTotal"
                    v-model="form.advance"
                >
                </el-input>
            </div>
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
        <el-collapse class="mt-2">
            <el-collapse-item name="1">
                <template slot="title">
                    N° Habitaciones {{ rooms.length }}
                </template>
                <div class="row mt-1" v-for="(room, idx) in rooms" :key="idx">
                    <el-divider content-position="left"
                        >Habitación {{ idx + 1 }}

                        <template v-if="rooms.length > 1">
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                size="mini"
                                @click="rooms.splice(idx, 1)"
                                circle
                            ></el-button>
                        </template>
                    </el-divider>
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
                            @change="calculateTotal"
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
                            :max="2"
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
                            v-model="room.checkin_date"
                            type="date"
                            placeholder="Fecha de ingreso"
                            size="small"
                            style="width: 100%;"
                            value-format="yyyy-MM-dd"
                            :picker-options="{
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
                            v-model="room.checkin_time"
                            size="small"
                            placeholder="Hora de ingreso"
                            style="width: 100%;"
                            value-format="HH:mm:ss"
                        ></el-time-picker>
                    </div>
                    <div class="col-md-2">
                        <label for="duration">Días</label>
                        <el-input
                            type="number"
                            v-model="room.duration"
                            placeholder="Duración"
                            size="small"
                            step="1"
                            style="width: 100%;"
                        ></el-input>
                    </div>
                    <div class="col-md-4">
                        <label for="name"
                            >Agregar datos huespedes
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
                    <div class="col-md-4 d-flex align-items-end">
                        <el-button @click="addGuess(idx)" type="primary">
                            Agregar Huesped
                        </el-button>
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
    props: ["showDialog", "table"],
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
            for (let room of this.rooms) {
                if (room.table_id) {
                    let table = this.tables.find(t => t.id == room.table_id);
                    console.log(
                        "🚀 ~ file: room_form.vue:356 ~ calculateSubtotal ~ table:",
                        table
                    );
                    let {
                        type: { price }
                    } = table;
                    subtotal += price;
                }
            }
            this.form.sub_total = subtotal;
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
            console.log(
                "🚀 ~ file: room_form.vue:375 ~ calculateTotal ~ this.form.total:",
                this.form.total
            );
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
                guess_id: null,
                tower_id,
                floor_id,
                table_id,
                quantity_persons: 1,
                duration: 1,
                checkin_date: new Date(),
                checkin_time: new Date(),
                guesses: []
            };

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
            const response = await this.$http.get(`/caja/rooms/tablas`);
            // this.rooms = response.data.tables;
            let { towers, floors, tables } = response.data;
            this.all_towers = towers;
            this.all_floors = floors;
            this.all_tables = tables;

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
        async submit() {
            this.form.rooms = this.rooms;
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
            }
            return pass;
        },
        async open() {
            this.loading = true;
            this.keyupCustomer();
            this.initForm();
            await this.getTables();

            if (this.table) {
                this.defaultTable(this.table);
                this.addRoom({
                    table_id: this.table.id,
                    floor_id: this.table.floor_id,
                    tower_id: this.table.floor.tower_id
                });
            }
            this.loading = false;
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
