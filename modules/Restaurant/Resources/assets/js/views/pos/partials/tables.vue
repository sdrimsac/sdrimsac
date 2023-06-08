<template>
    <el-dialog
        :visible="showTables"
        v-loading="loading"
        @open="open"
        @close="close"
        width="70%"
        title="ZONA DE ATENCIÓN "
        :close-on-click-modal="false"
        :class="{ top }"
    >
        <div class="card" v-if="ordens.length == 0">
            <div class="d-flex justify-content-end p-2">
                <button
                    type="button"
                    :class="`btn ${addingOrden ? 'btn-danger' : 'btn-primary'}`"
                    @click="addOrden"
                >
                    {{ addingOrden ? "Seleccione mesa" : "Nueva orden" }}
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
                    <strong class="h3 text-white  ">Mesa</strong>
                    <i class="icofont-dining-table icofont-4x"></i>

                    <span class="h2  text-white">
                        {{ table.number }}
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
        <!-- <div class="card" v-if="ordens.length == 0 && screenWidth < 600">
            <div class="d-flex justify-content-end p-2">
                <button
                    type="button"
                    :class="`btn ${addingOrden ? 'btn-danger' : 'btn-primary'}`"
                    @click="addOrden"
                >
                    {{ addingOrden ? "Seleccione mesa" : "Nueva orden" }}
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
            <div               v-if="tables.length > 0"                class="d-flex flex-wrap justify-content-center"            >
                
                <div                    v-for="(table, idx) in tables"                    
                :class="`${ table.status_table_id == 1? 'btn-primary': 'btn-danger'}`"
                    class=" col-2 btn   m-1 d-flex flex-column justify-content-center align-items-center "
                    :key="idx"
                    @click="selectTable(table)" style="max-height: 64px;    max-width: 62px;"
                >
                    
                    <i class="icofont-dining-table icofont-2x"></i>

                    <span class="h2  text-white">
                        {{ table.number }}
                    </span>

                    
                </div>
            </div>
            <div v-else class="h-25 d-flex justify-content-center align-items-center">
                <span>Sin mesas</span>
            </div>
            
        </div> -->

        <div class="card-body p-2" v-if="ordens.length > 0">
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
    </el-dialog>
</template>

<script>
export default {
    //tabla color verde
    props: ["showTables", "table"],

    data() {
        return {
            addingOrden: false,
            ordens: [],
            loading: false,
            resource: "/restaurant/tables/tables",
            tables: [],
            showOrdens: false,
            ordensSaved: [],
            top: "rounded-top",
            screenWidth: 0
        };
    },
    methods: {
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        addOrden() {
            this.addingOrden = !this.addingOrden;
        },
        closeOrden() {
            this.ordens = [];
        },
        sendOrdens(orden) {
            this.$emit("sendOrdens", orden);
            this.close();
        },
        async selectTable(table) {
            if (this.addingOrden) {
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
                    `/restaurant/tables/orden/${table.id}`
                );
                if (response.status == 200) {
                    const { ordens } = response.data;

                    this.ordens = ordens;
                    if (ordens.length == 1) {
                        this.sendOrdens(this.ordens[0]);
                    } else {
                        this.showOrdens = true;
                    }
                }
                this.loading = false;
            } catch (e) {
                this.loading = false;
                console.log(e);
            }
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
