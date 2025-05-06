<template>
    <el-dialog
        :title="titleDialog"
        width="35%"
        :visible.sync="showDialog"
        @open="create"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        :show-close="true"
    >
        <div>
            <div class="d-flex align-items-center gap-2">
                <label class="d-flex align-items-center">
                    <i class="fas fa-barcode" style="margin-right: 5px;"></i>
                    Buscar
                </label>
                <el-input
                    v-model="series"
                    @input="getSeries"
                    placeholder="Buscar por serie o lote"
                    clearable
                    size="small"
                    style="width: 300px;"
                ></el-input>
            </div>
        </div>
        <br />
        <div class="form-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 table-responsive">
                    <table width="100%" class="table">
                        <thead>
                            <tr
                                :style="{
                                    backgroundColor: '#001f3f',
                                    color: 'white',
                                    fontWeight: 'bold',
                                    borderRadius: '5px'
                                }"
                            >
                                <th class="text-center text-white">
                                    Seleccionar
                                </th>
                                <th class="text-center text-white">
                                    Cod. Lote
                                </th>
                                <th class="text-center text-white">Serie</th>
                                <th class="text-center text-white">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in lots" :key="index">
                                <td class="text-center">
                                    <el-checkbox
                                        ref="checkboxes"
                                        :ref="'checkbox-' + index"
                                        v-model="row.has_sale"
                                    ></el-checkbox>
                                </td>
                                <td class="text-center">
                                    <span
                                        :style="{
                                            color: row.lot_code
                                                ? 'blue'
                                                : 'rgba(0, 0, 0, 0.5)'
                                        }"
                                    >
                                        {{ row.lot_code || "Item sin Lote" }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ row.series }}
                                </td>
                                <td class="text-center">
                                    {{ row.date }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <el-button
                class="btn-save btn-save:hover"
                icon="fas fa-save fa-lg"
                type="primary"
                native-type="submit"
                @click.prevent="close"
                :loading="loading_submit"
            >
                <span
                    >Cargar Series
                    <el-tooltip
                        content="Carga las SERIES chekeadas a la lista de Traslados"
                        placement="top"
                    >
                        <i class="fas fa-info-circle" style="color: red;"></i>
                    </el-tooltip>
                </span>
            </el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "lots"],
    data() {
        return {
            titleDialog: "Seleccionar Series a trasladar",
            loading: false,
            errors: {},
            form: {},
            series: "",
            loading_submit: false,
            localLots: []
        };
    },
    async created() {
        console.log("created ver como llega", this.lots);
    },
    watch: {
        lots: {
            immediate: true,
            handler(newLots) {
                if (newLots) {
                    this.localLots = JSON.parse(JSON.stringify(newLots));
                } else {
                    this.localLots = [];
                }
            }
        }
    },
    methods: {
        create() {},
        async submit() {
            let val_lots = await this.validateLots()
            if(!val_lots.success)
            return this.$toast.error(val_lots.message);
            await this.$emit('addRowLot', this.lots);
            await this.$emit('update:showDialog', false)
        },
        close() {
            this.$emit("update:showDialog", false);
            this.$emit("addRowOutputLot", this.lots);
        },
        async clickCancelSubmit() {},

        async getSeries() {
            if (this.seriesTimer) {
                clearTimeout(this.seriesTimer);
            }
            this.seriesTimer = setTimeout(async () => {
                this.loading = true;
                try {
                    const response = await this.$http.get("lots_records", {
                        params: { search: this.series }
                    });

                    const lotData = Array.isArray(response.data.data)
                        ? response.data.data
                        : [response.data.data];

                    //his.localLots = lotData;
                    this.localLots = lotData;

                    const matchedLotIndex = this.localLots.findIndex(
                        lot => lot.series === this.series
                    );
                    if (matchedLotIndex !== -1) {
                        // Marcar el checkbox correspondiente
                        this.localLots[matchedLotIndex].has_sale = true;

                        const originalIndex = this.lots.findIndex(
                            lot => lot.series === this.series
                        );
                        if (originalIndex !== -1) {
                            this.lots[originalIndex].has_sale = true;
                        }

                        this.$toast.success(
                            `Serie ${this.series} seleccionada automáticamente.`
                        );

                        this.series = "";

                        /* this.$nextTick(() => {
                            const checkboxRef = this.$refs[
                                `checkbox-${matchedLotIndex}`
                            ];
                            console.log("checkboxRef:", checkboxRef);
                            if (checkboxRef && checkboxRef[0]) {
                                checkboxRef[0].$emit("input", true);
                            } else if (checkboxRef) {
                                checkboxRef.$emit("input", true);
                            }
                        }); */

                        this.$toast.success(
                            `Serie ${this.series} seleccionada automáticamente.`
                        );
                    } else {
                        this.$toast.error(
                            `La serie ${this.series} no se encontró en los lotes.`
                        );
                    }
                } catch (error) {
                    console.error(error);
                    this.$toast.error(
                        "Ocurrió un error al buscar la serie. Intente nuevamente."
                    );
                } finally {
                    this.loading = false;
                }
            }, 100); // Delay de 100ms
        }
    }
};
</script>
