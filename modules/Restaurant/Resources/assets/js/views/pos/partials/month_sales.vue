<template>
    <el-dialog
        append-to-body
        :visible="showDialog"
        title="Ventas por mes"
        @open="open"
        @close="close"
        v-loading="loading_search"
    >
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="month">Mes</label>
                <el-date-picker
                    v-model="month"
                    type="month"
                    placeholder="Selecciona un mes"
                    format="yyyy-MM"
                    value-format="yyyy-MM"
                    clearable
                    class="w-100"
                    @change="changeMonth"
                ></el-date-picker>
            </div>
        </div>
        <div class="row mt-1" v-if="form.establishment">
        
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="celda">Doc</th>
                            <th class="celda">Serie</th>
                            <th class="celda">Nro_ini</th>
                            <th class="celda">Nro_fin</th>
                            <th class="celda">Anulados</th>
                            <th class="celda">Rechazados</th>
                            <th class="celda">Notas de crédito</th>
                            <th class="celda_right">Importe total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="form.has_bv_info">
                            <td>
                                Factura
                            </td>
                            <td>
                                {{ form.first_ft.series }}
                            </td>
                            <td class="text-end">
                                {{ form.first_ft.number }}
                            </td>
                            <td class="text-end">
                                {{ form.last_ft.number }}
                            </td>
                            <td>
                                {{ form.anulates_voided_ft.join("-") }}
                            </td>
                            <td>
                                {{ form.rejected_ft.join("-") }}
                            </td>
                            <td>
                                {{ form.notes_ft.join("-") }}
                            </td>
                            <td class="text-end">
                                {{ form.ft_total }}
                            </td>
                        </tr>
                        <tr v-if="form.has_ft_info">
                            <td>Boleta</td>
                            <td>{{ form.first_bv.series }}</td>
                            <td class="text-end">{{ form.first_bv.number }}</td>
                            <td class="text-end">{{ form.last_bv.number }}</td>
                            <td>{{ form.anulates_voided_bv.join("-") }}</td>
                            <td>{{ form.rejected_bv.join("-") }}</td>
                            <td>{{ form.notes_bv.join("-") }}</td>
                            <td class="text-end">
                                {{ form.bv_total }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-right">Total mes</td>
                            <td class="text-end font-bold">{{ total.toFixed(2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import moment from "moment";
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            form: {},
            loading_search: false,
            timer: null,
            loading: false,
            month: moment().format("yyyy-MM"),
            total: 0
        };
    },
    methods: {
        changeMonth() {
            this.loading_search = true;
            this.$http
                .post("/sales-month-establishment", { month: this.month })
                .then(response => {
                    this.form = response.data[0];
                    this.total =
                        Number(this.form.ft_total) + Number(this.form.bv_total);
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading_search = false;
                });
        },
        changeItem() {
            this.form.quantity = 1;
        },
        open() {
            this.changeMonth();
            console.log("open");
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
