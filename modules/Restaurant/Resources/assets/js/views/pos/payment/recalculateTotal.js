export function inputReCalculateTotal() {
    // Conversión segura para evitar NaN
    function safeNumber(val) {
        const n = Number(val);
        return Number.isFinite(n) ? n : 0;
    }
    /* console.log("Recalculando totales"); */
    let total_discount = 0;
    let total_charge = 0;

    let total_exportation = 0;
    let total_taxed = 0;
    let total_exonerated = 0;
    let total_unaffected = 0;
    let total_free = 0;
    let total_igv = 0;
    let total_value = 0;
    let total = 0;
    let total_plastic_bag_taxes = 0;
    if (
        this.affectation_optional_id != null &&
        this.affectation_optional_id != undefined &&
        this.affectation_optional_id != ""
    ) {
        this.form.items = this.formatItems(
            this.form.items,
            this.affectation_optional_id
        );
    }

    this.form.items.forEach(row => {
        const qty = safeNumber(row.quantity);
        const line_charge = safeNumber(row.total_charge);
        const line_discount = safeNumber(row.total_discount);
        const plastic = safeNumber(row.total_plastic_bag_taxes);

        let line_total_value = safeNumber(row.total_value);
        let line_igv = safeNumber(row.total_igv);

        const gross = safeNumber(row.total);
        if (gross > 0) {
           
            const igvRate = this.toNumber(this.percentage_igv) / 100 || 0;
            if (["11", "12", "13", "14", "15", "16"].includes(row.affectation_igv_type_id) && igvRate > 0) {
                const base = gross / (1 + igvRate);
                line_igv = gross - base;
                line_total_value = base;
            } else if (row.affectation_igv_type_id === "10") {
                // gravado pero gross provided means gross == base + igv
                if (igvRate > 0) {
                    const base = gross / (1 + igvRate);
                    line_igv = gross - base;
                    line_total_value = base;
                } else {
                    line_igv = 0;
                    line_total_value = gross;
                }
            } else {
                // no gravado
                line_igv = 0;
                line_total_value = gross;
            }

            // usar gross como total de línea (antes de cargos/desc)
            var line_total = gross + plastic + line_charge - line_discount;
        } else {
            const igvRate = this.toNumber(this.percentage_igv) / 100 || 0;
            if (["11", "12", "13", "14", "15", "16"].includes(row.affectation_igv_type_id)) {
                if (igvRate > 0) {
                    // base = total_value / (1 + igvRate)
                    const base = line_total_value / (1 + igvRate);
                    const igvFromIncluded = line_total_value - base;
                    line_igv = igvFromIncluded;
                    line_total_value = base;
                }
            } else {
                // Si no viene total_igv calculado y es tipo gravado (10), calcularlo
                if (row.affectation_igv_type_id === "10") {
                    line_igv = line_total_value * (this.toNumber(this.percentage_igv) / 100);
                } else {
                    line_igv = 0;
                }
            }

            var line_total = line_total_value + line_igv + plastic + line_charge - line_discount;
        }

        if (row._total_line !== undefined && row._total_line !== null) {
            line_total = safeNumber(row._total_line);
        }

        // Acumular por tipo de afectación
        if (row.affectation_igv_type_id === "10") {
            total_taxed += line_total_value;
        } else if (row.affectation_igv_type_id === "20") {
            total_exonerated += line_total_value;
        } else if (row.affectation_igv_type_id === "30") {
            total_unaffected += line_total_value;
        } else if (row.affectation_igv_type_id === "40") {
            total_exportation += line_total_value;
        } else {
            total_free += line_total_value;
        }

        total_igv += line_igv;
        total_value += line_total_value;
        total_plastic_bag_taxes += plastic;
        total_discount += line_discount;
        total_charge += line_charge;
        total += line_total;
    });

    this.form.total_exportation = _.round(total_exportation, 2);
    this.form.total_taxed = _.round(total_taxed, 2);
    this.form.total_exonerated = _.round(total_exonerated, 2);
    this.form.total_unaffected = _.round(total_unaffected, 2);
    this.form.total_free = _.round(total_free, 2);
    this.form.total_igv = _.round(total_igv, 2);
    this.form.total_value = _.round(total_value, 2);
    this.form.total_value_without_rounding = total_value;
    this.form.total_taxes = _.round(total_igv + this.form.total_isc + total_plastic_bag_taxes, 2);
    this.form.total_plastic_bag_taxes = _.round(total_plastic_bag_taxes, 2);
    /* console.log("Totales después del redondeo:", {
        total_taxed: this.form.total_taxed,
        total_igv: this.form.total_igv,
        total_value: this.form.total_value,
        total_plastic_bag_taxes: this.form.total_plastic_bag_taxes,
        total_charge: total_charge,
        total_discount: total_discount
    }); */

    // Mostrar valor crudo antes de redondear para depuración
    console.log('[RECALC] pre-round total (raw):', total, 'total_igv:', total_igv, 'total_value:', total_value);
    // El total ya fue acumulado en `total` (que incluye base + igv + plastic + charges - discounts)
    // Añadir un pequeño epsilon y usar toFixed para evitar que 59.99999999 quede 59.99 por efectos de punto flotante
    this.form.total = Number((total + 1e-8).toFixed(2));
    console.log('[RECALC] total asignado (rounded):', this.form.total);

    if (this.discount_amount) {
        if (!this.original_totals_snapshot) {
            this.original_totals_snapshot = {
                total: this.form.total,
                total_value: this.form.total_value,
                total_igv: this.form.total_igv,
                total_taxed: this.form.total_taxed,
                total_exonerated: this.form.total_exonerated,
                total_unaffected: this.form.total_unaffected,
                total_exportation: this.form.total_exportation,
                total_free: this.form.total_free,
                total_plastic_bag_taxes: this.form.total_plastic_bag_taxes
            };
        }
        this.discountGlobal();
    }

    // this.discountGlobal();
}