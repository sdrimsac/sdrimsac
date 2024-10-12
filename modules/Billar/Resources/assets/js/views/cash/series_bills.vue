<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row">
            <el-tabs v-model="activeName">
                <!-- <el-tab-pane label="10" name="diez">
                    <div class="row">
                        <el-input
                            v-model="inputDiez"
                            placeholder="Ingrese serie de billetes"
                        >
                            <el-button
                                slot="append"
                                type="primary"
                                icon="el-icon-circle-plus-outline"
                                @click="addSeries('Diez')"
                            ></el-button>
                        </el-input>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="20" name="veinte">
                    <div class="row">
                        <el-input
                            v-model="inputVeinte"
                            placeholder="Ingrese serie de billetes"
                        >
                            <el-button
                                slot="append"
                            ></el-button>
                        </el-input>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="50" name="cincuenta">
                    <div class="row">
                        <el-input
                            v-model="inputCincuenta"
                            placeholder="Ingrese serie de billetes"
                        >
                            <el-button
                                slot="append"
                                icon="el-icon-add"
                                @click="addSeries('Cincuenta')"
                            ></el-button>
                        </el-input>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="100" name="cien">
                    <div class="row">
                        <el-input
                            v-model="inputCien"
                            placeholder="Ingrese serie de billetes"
                        >
                            <el-button
                                slot="append"
                                icon="el-icon-add"
                                @click="addSeries('Cien')"
                            ></el-button>
                        </el-input>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="200" name="doscientos">
                    <div class="row">
                        <el-input
                            v-model="inputDoscientos"
                            placeholder="Ingrese serie de billetes"
                        >
                            <el-button
                                slot="append"
                                icon="el-icon-add"
                                @click="addSeries('Doscientos')"
                            ></el-button>
                        </el-input>
                    </div>
                </el-tab-pane> -->
                <el-tab-pane
                    v-for="(bill, idx) in bills"
                    :label="bill.label"
                    :name="bill.value"
                    :key="idx"
                >
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <el-input
                                maxlength="9"
                                type="text"
                                v-model="bill.input"
                                placeholder="Ingrese serie de billetes"
                            >
                                <el-button
                                    slot="append"
                                    type="info"
                                    icon="el-icon-circle-plus-outline"
                                    @click="addSeries(bill.value)"
                                ></el-button>
                            </el-input>
                        </div>
                    </div>
                    <div class="row" style="height:450px;overflow-x:auto;">
                        <div class="col-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Serie</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(serie, idx) in localSeries[
                                            bill.value
                                        ]"
                                        :key="idx"
                                    >
                                        <td style="padding:.1rem .1rem;">
                                            {{ idx + 1 }}
                                        </td>
                                        <td style="padding:.1rem .1rem;">
                                            {{ serie }}
                                        </td>
                                        <td style="padding:.1rem .1rem;">
                                            <el-button
                                                type="danger"
                                                size="mini"
                                                icon="el-icon-delete"
                                                @click="
                                                    deleteSerie(bill.value, idx)
                                                "
                                            ></el-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="save">Guardar</el-button>
        </span>
    </el-dialog>
</template>
<style>
.x-sc {
    overflow-x: auto;
}
</style>
<script>
export default {
    props: ["showDialog", "seriesBills"],
    data() {
        return {
            bills: [
                { label: "10", value: "diez", input: "" },
                { label: "20", value: "veinte", input: "" },
                { label: "50", value: "cincuenta", input: "" },
                { label: "100", value: "cien", input: "" },
                { label: "200", value: "doscientos", input: "" }
            ],

            activeName: "diez",
            title: "Serie de billetes",
            localSeries: {
                diez: [],
                veinte: [],
                cincuenta: [],
                cien: [],
                doscientos: []
            }
        };
    },
    methods: {
        save() {
            this.$emit("update:seriesBills", this.localSeries);
            this.close();
        },
        deleteSerie(type, idx) {
            this.localSeries[type].splice(idx, 1);
        },
        addSeries(type) {
            let serie = this.bills.find(bill => bill.value === type);
            if (serie) {
                let input = serie.input;
                if (input && input.length == 9) {
                    //verificar que no exista
                    let exist = this.localSeries[type].find(
                        serie => serie === input
                    );
                    if (exist) {
                        this.$toast.error("La serie ya fue ingresada");
                        return;
                    }
                    this.localSeries[type].push(input);
                    serie.input = "";
                } else {
                    this.$toast.error("La serie debe tener 9 caracteres");
                }
            }
        },

        open() {
            //si seriesBills tiene propiedades entonces se asigna a localSeries, iterar
            if (this.seriesBills) {
                for (let key in this.seriesBills) {
                    if (this.localSeries[key]) {
                        this.localSeries[key] = this.seriesBills[key];
                    }
                }
            }

        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
