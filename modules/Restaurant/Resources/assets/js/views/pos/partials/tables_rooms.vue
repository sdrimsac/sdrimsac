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
        <div class="card" v-if="ordens.length == 0 || hasSelectedOrdenToChange">
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
                    :class="`btn ${addingOrden ? 'btn-danger' : 'btn-primary'}`"
                    @click="addOrden"
                >
                    {{ addingOrden ? "Seleccione habtación" : "Nueva orden" }}
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
                     <template v-if="table.status_table.description == 'Libre'">
                        <i class="fas fa-door-closed"></i>
                    </template>
                    <template
                        v-else-if="table.status_table.description == 'Ocupado'"
                    >
                        <i class="fas fa-bed"></i>
                    </template>
                    <template
                        v-else-if="
                            table.status_table.description == 'En mantenimiento'
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
                <span>Sin mesas</span>
            </div>
        </div>
        <div
            class="card-body p-2"
            v-if="ordens.length > 0 && !hasSelectedOrdenToChange"
        >
            <div class="row" v-if="hasSelectedTableToChange">
                <h3>Seleccione la orden a cambiar</h3>
            </div>
            <div class="d-flex flex-wrap justify-content-left">
                <div class="col-3" v-for="(ord, idx) in ordens" :key="idx">
                    <button
                        @click="sendOrdens(ord)"
                        type="button"
                        class="btn btn-primary p-1 m-1 "
                    >
                        <span class="h3 text-white">#{{ ord.id }}</span
                        ><br />
                        <span class="h4 text-white">{{
                            ord.ref ? ord.ref : "Sin referencia"
                        }}</span>
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-light" @click="closeOrden">
                    Regresar
                </button>
            </div>
        </div>
        <room-form :showDialog.sync="showRoom" :table="currentTable"></room-form>
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
            showRoom:false,
            addingOrden: false,
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
        };
    },
    methods: {
        changeOrden() {
            console.log("object");
            this.changingOrden = !this.changingOrden;
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        addOrden() {
            this.addingOrden = !this.addingOrden;
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

            // if (this.addingOrden) {
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
            this.addingOrden = false;
            this.$emit("update:showTables", false);
        }
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    }
};
</script>
