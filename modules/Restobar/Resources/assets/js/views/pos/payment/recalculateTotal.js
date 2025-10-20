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
    /* console.log("Items antes del cálculo:", JSON.stringify(this.form.items)); */
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
        total_discount += safeNumber(row.total_discount);
        total_charge += safeNumber(row.total_charge);

        if (row.affectation_igv_type_id === "10") {
            total_taxed += safeNumber(row.total_value);
        }
        if (row.affectation_igv_type_id === "20") {
            total_exonerated += safeNumber(row.total_value);
        }
        if (row.affectation_igv_type_id === "30") {
            total_unaffected += safeNumber(row.total_value);
        }
        if (row.affectation_igv_type_id === "40") {
            total_exportation += safeNumber(row.total_value);
        }
        /* console.log("row:", row.affectation_igv_type_id); */
        if (
            ["11", "12", "13", "14", "15", "16"].includes(
                row.affectation_igv_type_id
            )
        ) {
            let unit_value = safeNumber(row.total_value) / safeNumber(row.quantity);
            let total_value_partial = unit_value * safeNumber(row.quantity);
            row.total_taxes =
                safeNumber(row.total_value) -
                total_value_partial +
                safeNumber(row.total_plastic_bag_taxes);
            /* row.total_igv = total_value_partial * (row.percentage_igv / 100); */
            row.total_igv =
                        total_value_partial *
                        (this.toNumber(row.percentage_igv) / 100);
            row.total_base_igv = total_value_partial;
            console.log("restando de", row.total_value, total_value);
            total_value -= safeNumber(row.total_value);
            console.log("sumando", row.total, total);
            total += safeNumber(row.total);
        }
        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
            total_free += safeNumber(row.total_value);
            console.log("Total value actualizado:", total_value);
        }
        if (
            ["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) > -1
        ) {
            total_igv += safeNumber(row.total_igv);
            total += safeNumber(row.total);
        }
        total_value += safeNumber(row.total_value);
        total_plastic_bag_taxes += safeNumber(row.total_plastic_bag_taxes);
    });

    this.form.total_exportation = _.round(total_exportation, 2);
    this.form.total_taxed = _.round(total_taxed, 2);
    this.form.total_exonerated = _.round(total_exonerated, 2);
    this.form.total_unaffected = _.round(total_unaffected, 2);
    this.form.total_free = _.round(total_free, 2);
    this.form.total_igv = _.round(total_igv, 2);
    this.form.total_value = _.round(total_value, 2);
    this.form.total_value_without_rounding = total_value;
    this.form.total_taxes = _.round(total_igv, 2);
    this.form.total_plastic_bag_taxes = _.round(total_plastic_bag_taxes, 2);
    /* console.log("Totales después del redondeo:", {
        total_taxed: this.form.total_taxed,
        total_igv: this.form.total_igv,
        total_value: this.form.total_value,
        total_plastic_bag_taxes: this.form.total_plastic_bag_taxes,
        total_charge: total_charge,
        total_discount: total_discount
    }); */

    // this.form.total = _.round(total, 2)
    this.form.total = _.round(
        total_charge + total + this.form.total_plastic_bag_taxes,
        2
    );
    /* console.log("Total final calculado:", this.form.total); */

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