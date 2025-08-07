<template>
    <el-dialog
        :visible="showTables"
        v-loading="loading"
        @open="open"
        @close="close"
        width="80%"
        title="ZONA DE ATENCIÓN"
        :close-on-click-modal="false"
        :class="{ top }"
    >
        <el-tabs v-model="activeTab" class="mb-3" @tab-click="handleTabClick">
            <el-tab-pane label="Mesas" name="Mesas">
                <div
                    class="card"
                    v-if="ordens.length == 0 || hasSelectedOrdenToChange"
                >
                    <div class="d-flex justify-content-end p-2">
                        <button
                            type="button"
                            style="margin-left:15px;"
                            :class="
                                `btn ${
                                    isDisabling ? 'btn-danger' : 'btn-warning'
                                }`
                            "
                            @click="disablingTable"
                        >
                            {{ isDisabling ? "Cancelar" : "Deshabilitar" }}
                        </button>
                        <button
                            v-if="hasTableOcuped && configuration.edit_mesa"
                            type="button"
                            :class="
                                `btn ${
                                    changingOrden
                                        ? 'btn-warning'
                                        : 'btn-primary'
                                }`
                            "
                            @click="changeOrden"
                        >
                            {{
                                changingOrden
                                    ? hasSelectedOrdenToChange
                                        ? "Seleccione a la mesa destino"
                                        : "Seleccionar mesa"
                                    : "Cambiar orden"
                            }}
                        </button>
                        <button
                            type="button"
                            style="margin-left:15px;"
                            :class="
                                `btn ${
                                    addingOrden ? 'btn-danger' : 'btn-primary'
                                }`
                            "
                            @click="addOrden"
                        >
                            {{
                                addingOrden ? "Seleccione mesa" : "Nueva orden"
                            }}
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
                    <div class="d-flex justify-content-center p-2">
                        <button
                            v-for="(zone, idx) in zones"
                            :key="idx"
                            type="button"
                            style="margin-left:15px;"
                            :class="
                                `btn ${
                                    zone_id == zone.id
                                        ? 'btn-success text-white'
                                        : 'btn-primary'
                                }`
                            "
                            @click="filterZones(zone.id)"
                        >
                            ZONA {{ zone.name }}
                        </button>
                    </div>
                    <div
                        v-if="tables.length > 0"
                        class="d-flex flex-wrap justify-content-center"
                    >
                        <div
                            v-for="(table, idx) in tables"
                            :class="getTableClass(table)"
                            class="col-2 btn m-1 d-flex flex-column justify-content-center align-items-center"
                            :key="idx"
                            @click="selectTable(table)"
                            style="max-height: 200px; max-width: 300px;"
                        >
                            <strong class="h3 text-white">Mesa</strong>
                            <i class="icofont-dining-table icofont-4x"></i>
                            <span class="h2 text-white">{{
                                table.number
                            }}</span>
                            <div class="user-info text-center">
                                <template v-if="getUserByTable(table.id)">
                                    <span
                                        class="h5 mb-0"
                                        :class="
                                            getUserByTable(table.id).usuario ===
                                            'CAJA'
                                                ? 'text-white'
                                                : 'text-white'
                                        "
                                    >
                                        {{
                                            getUserByTable(
                                                table.id
                                            ).usuario.substring(0, 25)
                                        }}
                                    </span>
                                </template>
                                <template v-else>
                                    <span class="text-white-50">LIBRE</span>
                                </template>
                            </div>
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
                        <div
                            class="col-3"
                            v-for="(ord, idx) in ordens"
                            :key="idx"
                        >
                            <button
                                @click="sendOrdens(ord)"
                                type="button"
                                class="btn btn-primary p-1 m-1 "
                            >
                                <span class="h3 text-white"
                                    >#{{ ord.correlative }}</span
                                ><br />
                                <span class="h4 text-white">{{
                                    ord.ref ? ord.ref : "Sin referencia"
                                }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn btn-light"
                            @click="closeOrden"
                        >
                            Regresar
                        </button>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane
                label="Delivery"
                name="Delivery"
                v-if="configuration.restaurant_delivery"
            >
                <div class="card">
                    <div class="card-body">
                        <div v-if="deliveryOrders.length > 0">
                            <div
                                class="d-grid gap-3"
                                style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));"
                            >
                                <div
                                    class="card shadow text-white bg-danger text-center"
                                    style="aspect-ratio: 1 / 1; cursor: pointer;"
                                    v-for="(ord, idx) in deliveryOrders"
                                    :key="idx"
                                    @click="sendOrdens(ord)"
                                >
                                    <div
                                        class="card-body d-flex flex-column justify-content-center align-items-center"
                                    >
                                        <h2 class="fw-bold">
                                            #{{
                                                ord.order_number ||
                                                    ord.correlative ||
                                                    ord.id
                                            }}
                                        </h2>
                                        <p>{{ ord.ref || "Sin referencia" }}</p>
                                    </div>
                                    <el-button
                                        class="btn btn-light"
                                        @click.stop="DeliveryTicket(ord)"
                                        >Ticket Delivery</el-button
                                    >
                                </div>
                            </div>
                        </div>

                        <div
                            v-else
                            class="h-25 d-flex justify-content-center align-items-center"
                        >
                            <span>Sin órdenes de delivery</span>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
    </el-dialog>
</template>

<script>
export default {
    //tabla color verde
    props: ["showTables", "table", "configuration"],

    data() {
        return {
            //activeTab: "tables",
            activeTab: "Mesas",
            addingOrden: false,
            ordens: [],
            loading: false,
            resource: "/caja/tables/tables",
            tables: [],
            all_tables: [],
            zones: [],
            showOrdens: false,
            ordensSaved: [],
            top: "rounded-top",
            screenWidth: 0,
            hasTableOcuped: false,
            changingOrden: false,
            hasSelectedTableToChange: false,
            hasSelectedOrdenToChange: false,
            ordenToChange: null,
            ordenes: [],
            isDisabling: false,
            userOrders: [],
            zone_id: null,
            deliveryTable: null,
            deliveryOrders: [],
            deliveryLoaded: false
        };
    },
    async mounted() {
        this.userOrders = await this.userorden();
    },
    methods: {
        filterZones(zone_id) {
            // If same zone is clicked, show all tables
            if (this.zone_id === zone_id) {
                this.zone_id = null;
                this.tables = this.all_tables;
                return;
            }

            this.zone_id = zone_id;
            if (this.all_tables && this.all_tables.length > 0) {
                this.tables = this.all_tables.filter(table => {
                    return table.zone_id == zone_id;
                });
            } else {
                this.tables = []; // Ensure we have an empty array if all_tables is not populated
            }
        },
        async userorden() {
            try {
                const response = await this.$http.get(`/caja/tables/UserTable`);
                if (response.status === 200 && response.data.success) {
                    return response.data.data;
                }
                throw new Error(response.data.error || "Error desconocido");
            } catch (error) {
                this.$toast.error("Error al obtener usuarios de mesas");
                return [];
            }
        },
        getUserByTable(tableId) {
            if (!this.userOrders || !Array.isArray(this.userOrders)) {
                return null;
            }
            const numericTableId = Number(tableId);

            const foundUser = this.userOrders.find(order => {
                return Number(order.table_id) === numericTableId;
            });

            return foundUser || null;
        },

        async DeliveryTicket(ord) {
            try {
                const response = await this.$http.get(
                    `/caja/delivery/DeliveryPrinter?id=${ord.id}`
                );
                let url = response.data.print;
                let printerR = response.data.printer;

                await this.$http.post("/caja/re-print", {
                    url,
                    printer: printerR
                });
                return;
                let config = qz.configs.create(response.data.printer, {
                    scaleContent: false
                });
                let printer = response.data.printer;
                console.log(printer);
                let isPosd = printer.split(" ")[printer.split(" ").length - 1];
                console.log(isPosd);
                if (isPosd == "POSD") {
                    config.density = 200;
                }
                console.log(config);
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

        getUserTypeClass(tableId) {
            const user = this.getUserByTable(tableId);
            if (!user) return "text-white";
            return user.name.toUpperCase() === "CAJA"
                ? "text-warning"
                : "text-info";
        },

        getTableClass(table) {
            return table.enabled == false
                ? "btn-light"
                : table.status_table_id == 1
                ? "btn-primary"
                : table.status_table_id == 2
                ? "btn-danger"
                : "btn-warning";
        },
        async disabledTable(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de deshabilitar la mesa?",
                    "Advertencia",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.post(
                    `/caja/tables/disabled-table`,
                    {
                        table_id: id
                    }
                );
                if (response.status === 200) {
                    await this.updateAllData();
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Error al deshabilitar la mesa");
            }
        },
        async enabledTable(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de habilitar la mesa?",
                    "Advertencia",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.post(
                    `/caja/tables/enabled-table`,
                    {
                        table_id: id
                    }
                );
                if (response.status === 200) {
                    await this.updateAllData();
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Error al habilitar la mesa");
            }
        },
        async updateAllData() {
            try {
                this.loading = true;
                await Promise.all([
                    this.getTables(),
                    this.userorden().then(data => {
                        this.userOrders = data;
                    })
                ]);
            } catch (e) {
                console.log(e);
                this.$toast.error("Error al actualizar los datos");
            } finally {
                this.loading = false;
            }
        },
        disablingTable() {
            this.isDisabling = !this.isDisabling;
        },
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
            if (table.enabled == false) {
                this.changingOrden = false;
                await this.enabledTable(table.id);
                await this.getTables();
                return;
            }
            if (this.isDisabling && table.enabled) {
                await this.disabledTable(table.id);
                this.isDisabling = false;
                await this.getTables();
                return;
            }
            if (
                this.changingOrden &&
                !this.hasSelectedTableToChange &&
                this.hasSelectedOrdenToChange
            ) {
                this.sendOrdenToNewTable(this.ordenToChange, table);
            }

            if (this.addingOrden) {
                if (
                    this.configuration.order_mozo &&
                    table.status_table_id == 2
                ) {
                    this.$toast.warning(
                        "No se puede crear una nueva orden en una mesa ocupada"
                    );
                    return;
                }
                this.$emit("creatingOrden", table.number, table.id);
                this.close();
                return;
            }

            if (table.status_table_id == 1) {
                this.$toast.warning("La mesa no tiene ordenes");
                return;
            }

            this.loading = true;

            this.tableSelectedNumber = table.number;
            try {
                const response = await this.$http(
                    `/caja/tables/orden/${table.id}`
                );
                if (response.status == 200) {
                    const { ordens } = response.data;
                    console.log("ver si llega los ordenes", this.ordens);

                    this.ordens = ordens;
                    if (ordens.length == 1) {
                        this.sendOrdens(this.ordens[0]);
                    } else {
                        if (this.changingOrden) {
                            this.hasSelectedTableToChange = true;
                        }
                    }
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);
            }
        },
        async open() {
            this.activeTab = "Mesas";
            this.deliveryLoaded = false;
            this.closeOrden();
            await this.updateAllData();
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http(this.resource);
                console.log("Respuesta del servidor:", response.data);

                if (response.status == 200) {
                    const { tables, ordenes, zones } = response.data;
                    console.log("Órdenes recibidas:", ordenes);
                    this.ordenes = ordenes;
                    this.zones = zones;

                    // Buscar la mesa de delivery y guardarla
                    this.deliveryTable = tables.find(
                        t =>
                            t.is_delivery == 1 ||
                            t.is_delivery === "1" ||
                            t.is_delivery === true
                    );

                    let { show_caja_table } = this.configuration;
                    // Filtrar mesas: quitar caja y delivery
                    this.all_tables = tables.filter(f => {
                        const isCaja =
                            !show_caja_table &&
                            f.number.toLowerCase() == "caja";
                        const isDelivery =
                            f.is_delivery == 1 ||
                            f.is_delivery === "1" ||
                            f.is_delivery === true;
                        return !isCaja && !isDelivery;
                    });

                    // Limpiar deliveryOrders por defecto
                    this.deliveryOrders = [];

                    // By default, show all tables
                    if (this.zone_id) {
                        // If a zone is already selected, filter by that zone
                        this.filterZones(this.zone_id);
                    } else {
                        // Otherwise show all tables
                        this.tables = this.all_tables;
                    }

                    this.hasTableOcuped = this.all_tables.some(
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

        async getTablesDelivery() {
            try {
                this.loading = true;
                const response = await this.$http(
                    "/caja/tables/getTablesDelivery"
                );
                console.log("Respuesta del servidor:", response.data);

                if (response.status == 200) {
                    const { tables, ordenes, zones } = response.data;
                    console.log("Órdenes recibidas:", ordenes);
                    this.ordenes = ordenes;
                    this.zones = zones;

                    // Buscar la mesa de delivery y guardarla, pero NO cargar órdenes aquí ni modificar all_tables
                    this.deliveryTable = tables.find(
                        t =>
                            t.is_delivery == 1 ||
                            t.is_delivery === "1" ||
                            t.is_delivery === true
                    );
                    // Limpiar deliveryOrders por defecto
                    this.deliveryOrders = [];
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

        async getDeliveryOrders() {
            if (!this.deliveryTable) {
                this.deliveryOrders = [];
                return;
            }
            this.loading = true;
            try {
                const deliveryResp = await this.$http(
                    `/caja/tables/orden/${this.deliveryTable.id}`
                );
                if (deliveryResp.status == 200) {
                    this.deliveryOrders = deliveryResp.data.ordens;
                } else {
                    this.deliveryOrders = [];
                }
            } catch (e) {
                this.deliveryOrders = [];
            } finally {
                this.loading = false;
            }
        },

        handleTabClick(tab) {
            if (tab.label === "Delivery") {
                if (!this.deliveryLoaded) {
                    this.getTablesDelivery().then(() => {
                        this.getDeliveryOrders().then(() => {
                            this.deliveryLoaded = true;
                        });
                    });
                }
            } else if (tab.label === "Mesas") {
                // Si vuelves a mesas, puedes resetear la bandera si quieres forzar recarga después
                // this.deliveryLoaded = false;
            }
        },
        close() {
            this.addingOrden = false;
            this.deliveryLoaded = false;
            this.$emit("update:showTables", false);
        }
    },
    created() {
        // Asegurarnos de cargar los usuarios al inicio
        this.userorden().then(data => {
            this.userOrders = data;
            console.log("userOrders cargados:", this.userOrders);
        });
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    }
};
</script>

<style scoped>
.user-info {
    background: rgba(0, 0, 0, 0.1);
    padding: 5px 10px;
    border-radius: 4px;
    margin-top: 5px;
}
.text-warning {
    color: #ffc107 !important;
}
.text-info {
    color: #17a2b8 !important;
}
.text-white-50 {
    color: rgba(255, 255, 255, 0.5) !important;
}
</style>
