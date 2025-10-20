export function listcalculateTotal(w = null) {

    console.log("listcalculateTotal", w);
    // Obtener el IGV dinámico desde this.percentage_igv (propagado desde list_ordens.vue)
    const percentage_igv = Number(this.percentage_igv) || 18;
    const igvFactor = 1 + (percentage_igv / 100);
    const igvRate = percentage_igv / 100;

    // Totales generales
    this.totalOrdenItems = 0.0;
    this.total = 0.0;
    this.totalOrden = 0.0;
    let totalGravado = 0,
        totalExonerado = 0,
        totalIgv = 0,
        totalDescuentos = 0;

    _.forEach(this.localOrden, value => {
        // Pasar el IGV dinámico a la función de cálculo de montos si lo soporta
        let amounts;
        if (typeof this._calcItemAmounts === 'function' && this._calcItemAmounts.length >= 2) {
            amounts = this._calcItemAmounts(value, percentage_igv);
        } else {
            amounts = this._calcItemAmounts(value);
        }
        // Guardar montos calculados en el item para referencia (reactivo)
        value._base = amounts.base;
        value._igv = amounts.igv;
        value._total_line = amounts.total;
        value._discount_amount = amounts.discount_amount;
        console.log("amounts ver el descuento", value.discount_amount);
        totalDescuentos += amounts.discount_amount;
        if (value.food.item.sale_affectation_igv_type_id == "10") {
            totalGravado += amounts.base;
            totalIgv += amounts.igv;
        } else {
            totalExonerado += amounts.base; // en exonerado base = total línea
        }
    });

    this.totalOrden = _.round(totalGravado + totalExonerado + totalIgv, 2);

    // Totales de ordenes ya atendidas (sin modificar su estructura original)
    let atendidosGravExoIgv = 0;
    _.forEach(this.ordens, values => {
        atendidosGravExoIgv += values.quantity * values.price; // Mantener comportamiento anterior
    });
    this.totalOrdenItems = _.round(atendidosGravExoIgv, 2);
    this.total = _.round(this.totalOrden, 2);
    // Emitir totales detallados si se requieren para otro componente
    this.$emit("totales_detallados", {
        gravado: Number(totalGravado.toFixed(2)),
        exonerado: Number(totalExonerado.toFixed(2)),
        igv: Number(totalIgv.toFixed(2)),
        descuentos: Number(totalDescuentos.toFixed(2)),
        total: this.total
    });

    console.log("total de la orden", this.total);
    this.$emit("total_salcancelOrdenaes", this.total);
}
