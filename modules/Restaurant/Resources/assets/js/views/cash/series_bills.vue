<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        width="35%"
    >
        <div class="row">
            <el-tabs v-model="activeName">
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
                                    type="success"
                                   
                                    @click="addSeries(bill.value)"
                                    style="color: white; background-color: #28a745; border-color: #28a745;"
                                >
                                    <i class="el-icon-circle-plus-outline" style="color: white; font-size: 10px;"></i>
                                    <el-tooltip content="Subir la serie cargada en el input" placement="top">
                                        <el-button
                                            slot="append"
                                            type="success"
                                            @click="validateAndAddSeries(bill.value)"
                                            style="color: white; background-color: #28a745; border-color: #28a745;"
                                        >
                                            <i class="el-icon-circle-plus-outline" style="color: white; font-size: 10px;"></i>
                                        </el-button>
                                    </el-tooltip>
                                </el-button>
                            </el-input>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="height:450px;overflow-x:auto;">
                        <div class="col-12 table-responsive">

                            <table class="table">
                                <thead style="background-color: #0e477d; color: white;">
                                    <tr>
                                        <th class="text-white">#</th>
                                        <th class="text-white">Serie</th>
                                        <th class="text-white">Acciones</th>
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
                <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <!-- Cancelar -->
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close"
                >
                    <span>Cancelar</span>
                </el-button>

                <el-button
                    class="btn-save btn-save:hover"
                    icon="fas fa-save fa-lg"
                    type="primary"
                    @click="save"
                >
                    <span>Guardar</span>
                </el-button>
            </div>
            </el-tabs>
        </div>
     
    </el-dialog>
</template>

<style>
.x-sc {
    overflow-x: auto;
}

.el-tab-pane {
    width: 100% !important;
    height: 80% !important;
    background-color: #b7b4b4f0 !important;
    border-radius: 8px !important;
    padding: 20px !important;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
    overflow: hidden !important;
}
.el-tabs {
    width: 100% !important;
    height: 60vh !important;
    background-color: #f5f5f5 !important;
    border-radius: 10px !important;
    padding: 15px !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
    display: flex !important;
    flex-direction: column !important;
}

.el-tabs__header {
    background-color: #ffffff !important;
    border-bottom: 2px solid #dcdcdc !important;
    border-radius: 10px 10px 0 0 !important;
    padding: 10px !important;
    font-weight: bold !important;
    color: #333 !important;
}

.el-tabs__item {
    padding: 0px 0px !important;
    border-radius: 5px !important;
    transition: all 0.3s ease !important;
    width: 80px !important;
}

.el-tabs__item.is-active {
    background-color: #0e477d !important;
    color: #ffffff !important;
    font-weight: bold !important;
}

.el-tabs__content {
    flex-grow: 1 !important;
    padding: 20px !important;
    background-color: #ffffff !important;
    border-radius: 0 0 10px 10px !important;
    overflow-y: auto !important;
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
