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
            <div class="d-flex justify-content-end p-2">
                <button
                    v-if="hasTableOcuped"
                    type="button"
                    :class="
                        `btn ${changingOrden ? 'btn-warning' : 'btn-primary'}`
                    "
                    @click="changeOrden"
                >
                    {{
                        changingOrden
                            ? hasSelectedOrdenToChange
                                ? "Seleccione a la habitación destino"
                                : "Seleccionar habitación"
                            : "Cambiar orden"
                    }}
                </button>
                <button
                    type="button"
                    style="margin-left:15px;"
                    :class="`btn ${viewingRoom ? 'btn-danger' : 'btn-primary'}`"
                    @click="addOrden"
                >
                    {{ viewingRoom ? "Seleccione habtación" : "Nueva orden" }}
                </button>
                <button
                    type="button"
                    style="margin-left:15px;"
                    class="btn btn-light"
                    @click="close"
                >
                    Cerrar
                </button>
            </div>
            <template v-if="viewingRoom && currentRoom">
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
                        />
                    </div>
                    <div class="col-lg-3 col-6">
                        <label for="duration">
                            <strong>Duración</strong>
                            <a href="#" data-toggle="tooltip" title="Días">
                                [+ Agregar días]
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
                            <a href="#" data-toggle="tooltip" title="persons">
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
                <div class="d-flex m-2">
                    <button
                        type="button"
                        class="btn btn-success m-2"
                        @click="createOrden"
                    >
                        Ordenar
                    </button>
                    <!-- <button type="button" class="btn btn-success m-2">
                        Ver ordenes
                    </button> -->
                    <button type="button" class="btn btn-warning m-2">
                        Cancelar habitación
                    </button>
                    <!-- <div class="col-3 d-flex flex-column p-2 bg-warning rounded justify-content-center align-items-center">
                        Total ordenes <br />
                        S/ 1650.00
                    </div> -->
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
                                    <div>
                                        {{ orden.date }} - Total: {{ orden.total }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button
                                            style="margin-right:5px;"
                                            type="button"
                                            class="btn btn-primary btn-sm"
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
                <div class="row m-3"></div>
            </template>
            <template v-else>
                <div
                    v-if="tables.length > 0"
                    class="d-flex flex-wrap justify-content-center"
                >
                    <div
                        v-for="(table, idx) in tables"
                        :class="
                            `${
                                table.status_table_id == 1
                                    ? 'btn-primary'
                                    : 'btn-danger'
                            }`
                        "
                        class=" col-2 btn   m-1 d-flex flex-column justify-content-center align-items-center "
                        :key="idx"
                        @click="selectTable(table)"
                        style="max-height: 136px;    max-width: 135px;"
                    >
                        <span class="text-white m-1" style="font-size:45px;">
                            <template
                                v-if="table.status_table.description == 'Libre'"
                            >
                                <i class="fas fa-door-closed"></i>
                            </template>
                            <template
                                v-else-if="
                                    table.status_table.description == 'Ocupado'
                                "
                            >
                                <i class="fas fa-bed"></i>
                            </template>
                            <template
                                v-else-if="
                                    table.status_table.description ==
                                        'En mantenimiento'
                                "
                            >
                                <i class="fas fa-person-booth"></i>
                            </template>
                            <template v-else>
                                <i class="fas fa-ban"></i>
                            </template>
                        </span>

                        <span class="h2 mt-2 text-white">
                            {{ table.number.toString().toUpperCase() }}
                        </span>
                    </div>
                </div>
                <div
                    v-else
                    class="h-25 d-flex justify-content-center align-items-center"
                >
                    <span>Sin habitaciones</span>
                </div>
            </template>
        </div>

        <room-form
            @getTables="getTables"
            :showDialog.sync="showRoom"
            :table="currentTable"
        ></room-form>
    </el-dialog>
</template>

<script>
import RoomForm from "./room_form.vue";
export default {
    //tabla color verde
    props: ["showTables", "table"],
    components: {
        RoomForm
    },
    data() {
        return {
            activeOrdenRoom: "1",
            showRoom: false,
            viewingRoom: false,
            ordens: [],
            loading: false,
            resource: "/caja/rooms/tables",
            tables: [],
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
            currentRoom: null
        };
    },
    methods: {
        createOrden() {
            let { number, id } = this.currentTable;
            this.$emit("creatingOrden", number, id);
            this.close();
        },
        changeOrden() {
            console.log("object");
            this.changingOrden = !this.changingOrden;
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        addOrden() {
            this.viewingRoom = !this.viewingRoom;
        },
        async getRoomDetail(id) {
            try {
                this.loading = true;
                const response = await this.$http.get(`/caja/rooms/room/${id}`);
                const {
                    data: { data }
                } = response;
                this.currentRoom = data;
                this.viewingRoom = true;
            } catch (e) {
                console.log(
                    "🚀 ~ file: tables_rooms.vue:157 ~ getRoomDetail ~ e",
                    e
                );
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

        async selectTable(table) {
            this.currentTable = table;
            if (table.status_table_id == 2) {
                this.getRoomDetail(table.id);
                return;
            }
            this.showRoom = true;
            // if (
            //     this.changingOrden &&
            //     !this.hasSelectedTableToChange &&
            //     this.hasSelectedOrdenToChange
            // ) {
            //     if (table.status_table_id == 2) {
            //         this.$toast.warning("La mesa no esta libre");
            //         return;
            //     } else {
            //         this.sendOrdenToNewTable(this.ordenToChange, table);
            //         return;
            //     }
            // }

            // if (this.viewingRoom) {
            //     this.$emit("creatingOrden", table.number, table.id);
            //     this.close();
            //     return;
            // }

            // if (table.status_table_id == 1) {
            //     this.$toast.warning("La mesa no tiene ordenes");
            //     return;
            // }

            // this.loading = true;

            // this.tableSelectedNumber = table.number;
            // try {
            //     const response = await this.$http(
            //         `/caja/tables/orden/${table.id}`
            //     );
            //     if (response.status == 200) {
            //         const { ordens } = response.data;

            //         this.ordens = ordens;
            //         if (ordens.length == 1) {
            //             this.sendOrdens(this.ordens[0]);
            //         } else {
            //             if (this.changingOrden) {
            //                 this.hasSelectedTableToChange = true;
            //             }
            //         }
            //     }
            //     this.loading = false;
            // } catch (e) {
            //     this.loading = false;
            //     console.log(e);
            // }
        },
        async open() {
            this.closeOrden();
            await this.getTables();
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http(this.resource);
                if (response.status == 200) {
                    const { tables } = response.data;
                    //  this.tables = tables.filter(f => f.number != "caja");
                    this.tables = tables;
                    this.hasTableOcuped = tables.some(
                        s => s.status_table_id == 2
                    );
                } else {
                    this.$toast.warning("Ocurrió un error");
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);

                this.$toast.warning("Ocurrió un error");
            }
        },
        close() {
            this.viewingRoom = false;
            this.$emit("update:showTables", false);
        }
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    }
};
</script>
