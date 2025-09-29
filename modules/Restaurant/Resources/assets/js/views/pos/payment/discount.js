export function inputDiscountAmount() {
   /*  console.log("inputDiscountAmount - globaldiscount.js hola"); */
    if (!this.enabled_discount) return;

    if (!this.discount_mode) {
        this.discount_mode = "amount";
    }

    let hasDiscount = false;
    // Siempre usar el snapshot original si existe (evita descuentos en cascada)
    let baseTotalOriginal = null;
    if (this.original_totals_snapshot) {
        baseTotalOriginal = this.original_totals_snapshot.total;
    }
    const totalConIGV = parseFloat(
        baseTotalOriginal != null ? baseTotalOriginal : this.form.total || 0
    );

    if (this.discount_mode === "percent") {
        const pct = parseFloat(this.discount_percentage);
        // Solo permitir valores entre 1 y 99
        if (!isNaN(pct) && pct >= 1 && pct <= 99) {
            const boundedPct = Math.min(Math.max(pct, 1), 99);
            this.discount_percentage = boundedPct;
            this.discount_input_percentage = boundedPct;
            this.discount_dirty = true;
            this.discount_applied = false;

            const montoDescuentoTotal = totalConIGV * (boundedPct / 100);
            // Prorratear contra la base original (desde snapshot si existe)
            const baseAntes = this.original_totals_snapshot
                ? parseFloat(this.original_totals_snapshot.total_value || 0)
                : parseFloat(this.form.total_value || 0);
            const ratio = totalConIGV > 0 ? (boundedPct / 100) : 0;
            let baseDescuento = baseAntes * ratio;
            let igvDescuento = montoDescuentoTotal - baseDescuento;

            this.discount_amount = _.round(montoDescuentoTotal, 2);
            this.discount_base_amount = _.round(baseDescuento, 2);
            this.discount_igv_amount = _.round(igvDescuento, 2);
            hasDiscount = this.discount_amount > 0;
        } else {
            // Si el valor no está en el rango, limpiar el campo y mostrar alerta
            this.discount_percentage = "";
            this.discount_input_percentage = 0;
            this.discount_amount = 0;
            this.discount_base_amount = 0;
            this.discount_igv_amount = 0;
            if (!isNaN(pct)) {
                Swal.fire({
                    icon: "error",
                    title: "Descuento inválido",
                    text: "El porcentaje debe ser entre 1% y 99%.",
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: "top-end"
                });
            }
        }
    } else {
        // amount
        if (
            this.discount_amount &&
            !isNaN(this.discount_amount) &&
            parseFloat(this.discount_amount) > 0
        ) {
            this.discount_input_percentage = 0; // en modo monto directo no se usa
            // Si el usuario ingresa un monto directo y hay IGV, descomponer para mantener consistencia
            if (
                this.configuration.affectation_igv_type_id == "10" &&
                this.percentage_igv
            ) {
                const baseD =
                    this.discount_amount / (1 + this.percentage_igv / 100);
                this.discount_dirty = true;
                this.discount_applied = false;
                const igvD = this.discount_amount - baseD;
                this.discount_base_amount = _.round(baseD, 2);
                this.discount_igv_amount = _.round(igvD, 2);
            } else {
                this.discount_dirty = true;
                this.discount_applied = false;
                this.discount_base_amount = this.discount_amount;
                this.discount_igv_amount = 0;
            }
            hasDiscount = true;
        }
    }

    if (hasDiscount) {
        // Validar contra el total ORIGINAL (no el ya descontado)
        const totalOriginalForValidation = parseFloat(
            baseTotalOriginal != null ? baseTotalOriginal : this.form.total || 0
        );
        if (this.discount_amount >= totalOriginalForValidation) {
            this.discount_amount = 0;
            // Revertir a estado sin descuento
            this.deleteDiscountGlobal();
            this.discount_dirty = false;
            this.discount_applied = false;
            this.original_totals_snapshot = null;
            this.reCalculateTotal();
            this.enterAmount();
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "El descuento debe ser menor al total de venta",
                timer: 3000,
                showConfirmButton: false,
                toast: true
            });
            return;
        }
        // Capturar snapshot original antes de recalcular (evita descuentos en cascada)
        if (!this.original_totals_snapshot) {
            this.original_totals_snapshot = {
                total: this.form.total,
                total_value: this.form.total_value,
                total_igv: this.form.total_igv,
                total_taxed: this.form.total_taxed,
                total_exonerated: this.form.total_exonerated
            };
        }
        this.discount_applied = true;
        this.reCalculateTotal();
        // Logs después de recalcular, reflejan montos finales
        this.discount_dirty = false;
        this.enterAmount();
    } else {
        this.deleteDiscountGlobal();
        this.discount_dirty = false;
        this.discount_applied = false;
        this.original_totals_snapshot = null;
        this.reCalculateTotal();
        this.enterAmount();
    }
}
