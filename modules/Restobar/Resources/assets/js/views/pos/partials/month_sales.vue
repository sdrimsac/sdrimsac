<template>
    <el-dialog
        append-to-body
        :visible="showDialog"
        title="Resumen Ventas por mes"
        @open="open"
        @close="close"
        v-loading="loading_search"
        width="80%"
    >
        <div class="row mt-2 align-items-center">
            <div class="col-4 text-end">
            <label for="month" class="mb-0">Seleccione el mes a consultar</label>
            </div>
            <div class="col-4">
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
                    <thead style="background-color: #073f68; color: #fff;">
                        <tr>
                            <th class="celda text-center" style="color: #fff; width: 10%;">CPE</th>
                            <th class="celda text-center" style="color: #fff; width: 7%;">Serie</th>
                            <th class="celda text-center" style="color: #fff; width: 8%;">Inicio</th>
                            <th class="celda text-center" style="color: #fff; width: 8%;">Final</th>
                            <th class="celda text-center" style="color: #fff; width: 15%;">Anulados</th>
                            <th class="celda text-center" style="color: #fff; width: 15%;">Rechazados</th>
                            <th class="celda text-center" style="color: #fff; width: 15%;">NC</th>
                            <th class="celda text-end" style="color: #fff; width: 20%;">Importe total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="form.has_ft_info">
                            <td class="text-center">
                                Factura
                            </td>
                            <td class="text-center">
                                {{ form.first_ft ? form.first_ft.series : "" }}
                            </td>
                            <td class="text-end">
                                {{ form.first_ft ? form.first_ft.number : "" }}
                            </td>
                            <td class="text-end">
                                {{ form.last_ft ? form.last_ft.number : "" }}
                            </td>
                            <td class="text-center">
                                {{ form.anulates_voided_ft.join("-") }}
                            </td>
                            <td class="text-center">
                                {{ form.rejected_ft.join("-") }}
                            </td>
                            <td class="text-center">
                                {{ form.notes_ft.join("-") }}
                            </td>
                            <td class="text-end">
                                {{ form.ft_total }}
                            </td>
                        </tr>
                        <tr v-if="form.has_bv_info">
                            <td class="text-center">Boleta</td>
                            <td class="text-center">
                                {{ form.first_bv ? form.first_bv.series : "" }}
                            </td>
                            <td class="text-center">
                                {{ form.first_bv ? form.first_bv.number : "" }}
                            </td>
                            <td class="text-center">
                                {{ form.last_bv ? form.last_bv.number : "" }}
                            </td>
                            <td class="text-center">{{ form.anulates_voided_bv.join("-") }}</td>
                            <td class="text-center">{{ form.rejected_bv.join("-") }}</td>
                            <td class="text-center">{{ form.notes_bv.join("-") }}</td>
                            <td class="text-end">
                                {{ form.bv_total }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-end">Total ventas del mes</td>
                            <td class="text-end font-bold">
                                {{ total.toFixed(2) }}
                            </td>
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
