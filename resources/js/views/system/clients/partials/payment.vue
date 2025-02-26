<template>
    <el-dialog
        :visible="showDialog"
        title="Pago"
        @close="closeDialog"
        @open="openDialog"
        append-to-body
        v-loading="loading"
    >
        <div class="row">
            <div class="col-md-12">
                <label for="customer_number">Documento cliente</label>
                <el-input
                    v-model="form.customer_number"
                    placeholder="Número de cliente"
                ></el-input>
            </div>
            <div class="col-md-12">
                <label for="description">Descripción servicio</label>
                <el-input
                    type="textarea"
                    v-model="form.description"
                    placeholder="Descripción"
                ></el-input>
            </div>
            <div class="col-md-6">
                <label for="total_difference">Total a pagar</label>
                <el-input
                    :disabled="true"
                    v-model="total_difference"
                    placeholder="Total a pagar"
                ></el-input>
            </div>
            <div class="col-md-6">
                <label for="payment_method">Método de pago</label>
                <el-select
                    v-model="form.payment_method"
                    placeholder="Método de pago"
                >
                    <el-option
                        v-for="(value, key) in paymentsValue"
                        :key="key"
                        :label="value"
                        :value="key"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-12 mt-2 d-flex text-end">
                <el-button type="primary" @click="submit" :disabled="!cash_id">
                    <template v-if="cash_id">
                        Emitir documento
                    </template>
                    <template v-else>
                        <el-tooltip
                            class="item"
                            effect="dark"
                            content="No se puede emitir el documento, no hay caja configurada"
                            placement="top"
                        >
                            <el-button type="primary" disabled
                                >Emitir documento</el-button
                            >
                        </el-tooltip>
                    </template>
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import moment from "moment";
export default {
    props: [
        "cash_id",
        "showDialog",
        "client_number",
        "client_name",
        "affectation_tenant",
        "total_difference",
        "recordId",
        "date_of_payment"
    ],
    data() {
        return {
            loading: false,
            resource: "clients",
            form: {
                customer_number: null,
                description: null,
                payment_method: "01"
            },
            monthsSpanish: {
                "01": "ENERO",
                "02": "FEBRERO",
                "03": "MARZO",
                "04": "ABRIL",
                "05": "MAYO",
                "06": "JUNIO",
                "07": "JULIO",
                "08": "AGOSTO",
                "09": "SEPTIEMBRE",
                "10": "OCTUBRE",
                "11": "NOVIEMBRE",
                "12": "DICIEMBRE"
            },
            paymentsValue: {
                "01": "Efectivo",
                "02": "Culqui",
                "03": "Yape",
                "04": "PLIN",
                "05": "TARJETA: IZYPAY",
                "06": "TARJETA: NIUBIZ",
                "07": "TARJETA: OPENPAY",
                "08": "DIDI FOOD",
                "09": "PEDIDOS YA",
                "10": "RAPPI"
            }
        };
    },
    methods: {
        async submit() {
            this.loading = true;
            let document = this.formatDocument();
            await this.$http
                .post(`/${this.resource}/client-emit-document`, {
                    document
                })
                .then(response => {
                    console.log(response);
                    let { data, success } = response.data;
                    if (success) {
                        let successData = data.data;
                        let number = successData.number;
                        let ticket = successData.ticket;
                        this.loading = true;
                        this.$http
                            .post(`/client_payments/cancel_payment_client`, {
                                client_payment_id: this.recordId,
                                document: number,
                                ticket: ticket
                            })
                            .then(response => {
                                if (response.data.success) {
                                    this.$message.success(
                                        response.data.message
                                    );
                                    this.$emit("successPayment");
                                    this.$emit("update:showDialog", false);
                                } else {
                                    this.$message.error(response.data.message);
                                }
                            }).finally(() => {
                                this.loading = false;
                            });
                    } else {
                        this.$message.error(data.message);
                    }
                }).catch(error => {
                    this.$message.error(error.response.data.message);
                }).finally(() => {
                    this.loading = false;
                });
        },

        openDialog() {
            this.form.customer_number = this.client_number;
            this.form.payment_method = "01";
            let date = moment(this.date_of_payment, "D/M/YYYY");
            let monthNumber = ("0" + (date.month() + 2)).slice(-2);
            let month = this.monthsSpanish[monthNumber];
            this.form.description = "MEMBRESIA 12 MESES DE APP FACTURACION ELECTRONICA Y CONTROL INTERNO – PAGO POR USO CORRESPONDE AL MES DE "+ month;
        },
        closeDialog() {
            this.$emit("update:showDialog", false);
        },

        formatItems() {
            let amount = Number(this.total_difference);
            let item = {
                codigo_interno: "ZZFT",
                descripcion: this.form.description,
                codigo_producto_sunat: "",
                codigo_producto_gsl: "",
                unidad_de_medida: "ZZ",
                cantidad: 1,
                valor_unitario: amount,
                codigo_tipo_precio: "01",
                precio_unitario: amount,
                codigo_tipo_afectacion_igv: this.affectation_tenant,
                total_base_igv: amount,
                porcentaje_igv: 18,
                total_igv: 0,
                total_impuestos: 0,
                total_valor_item: amount,
                total_item: amount
            };

            if (this.affectation_tenant == "10") {
                item.total_igv = (amount / 1.18) * 0.18;
                item.total_impuestos = (amount / 1.18) * 0.18;
                item.valor_unitario = (amount / 1.18).toFixed(2);
                item.total_valor_item = (amount / 1.18).toFixed(2);
                item.total_base_igv = (amount / 1.18).toFixed(2);
            }

            return [item];
        },
        formatPayment() {
            let payment = {
                fecha_de_emision: moment().format("YYYY-MM-DD"),
                codigo_metodo_pago: this.form.payment_method,
                referencia: "",
                monto: this.total_difference
            };
            return [payment];
            //             fecha_de_emision
            // codigo_metodo_pago
            // referencia
            // monto
        },
        formatDocument() {
            let document = {
                serie_documento: "F001",
                numero_documento: "#",
                fecha_de_emision: moment().format("YYYY-MM-DD"),
                hora_de_emision: moment().format("HH:mm:ss"),
                codigo_tipo_operacion: "0101",
                codigo_tipo_documento: "01",
                codigo_tipo_moneda: "PEN",
                fecha_de_vencimiento: moment().format("YYYY-MM-DD"),
                datos_del_cliente_o_receptor: {
                    codigo_tipo_documento_identidad: "6",
                    numero_documento: this.client_number,
                    apellidos_y_nombres_o_razon_social: this.client_name,
                    codigo_pais: "PE",
                    ubigeo: "150101",
                    direccion: "-",
                    correo_electronico: "-",
                    telefono: "-"
                },
                totales: {
                    total_exportacion: 0.0,
                    total_operaciones_gravadas: 0.0,
                    total_operaciones_inafectas: 0.0,
                    total_operaciones_exoneradas: 0.0,
                    total_operaciones_gratuitas: 0.0,
                    total_igv_operaciones_gratuitas: 0.0,
                    total_igv: 0.0,
                    total_impuestos: 0.0,
                    total_valor: 0,
                    total_venta: 0
                },
                items: this.formatItems(),
                pagos: this.formatPayment()
            };

            let item = document.items[0];

            document.totales.total_igv = item.total_igv;
            document.totales.total_impuestos = item.total_impuestos;
            document.totales.valor_unitario = item.valor_unitario;
            document.totales.total_valor_item = item.total_valor_item;
            document.totales.total_venta = item.total_item;
            document.totales.total_valor = item.total_valor_item;
            if (this.affectation_tenant == "10") {
                document.totales.total_operaciones_gravadas =
                    item.total_valor_item;
            } else {
                document.totales.total_operaciones_exoneradas = item.total_item;
            }

            return document;
        }
    }
};
</script>
