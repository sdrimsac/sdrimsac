export function inputReCalculateTotal() {
    console.log("Recalculando totales");
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
        total_discount += parseFloat(row.total_discount);
        total_charge += parseFloat(row.total_charge);

        if (row.affectation_igv_type_id === "10") {
            total_taxed += parseFloat(row.total_value);
        }
        if (row.affectation_igv_type_id === "20") {
            total_exonerated += parseFloat(row.total_value);
        }
        if (row.affectation_igv_type_id === "30") {
            total_unaffected += parseFloat(row.total_value);
        }
        if (row.affectation_igv_type_id === "40") {
            total_exportation += parseFloat(row.total_value);
        }
        console.log("row:", row.affectation_igv_type_id);
        if (
            ["11", "12", "13", "14", "15", "16"].includes(
                row.affectation_igv_type_id
            )
        ) {
            let unit_value = row.total_value / row.quantity;
            let total_value_partial = unit_value * row.quantity;
            row.total_taxes =
                row.total_value -
                total_value_partial +
                (isNaN(parseFloat(row.total_plastic_bag_taxes))
                    ? 0.0
                    : parseFloat(row.total_plastic_bag_taxes));
            row.total_igv = total_value_partial * (row.percentage_igv / 100);
            row.total_base_igv = total_value_partial;
            console.log("restando de", row.total_value, total_value);
            total_value -= row.total_value;
            console.log("sumando", row.total, total);
            total += parseFloat(row.total);
        }
        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
            total_free += parseFloat(row.total_value);
            console.log("Total value actualizado:", total_value);
        }
        if (
            ["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) > -1
        ) {
            total_igv += parseFloat(row.total_igv);
            total += parseFloat(row.total);
        }
        total_value += parseFloat(row.total_value);
        total_plastic_bag_taxes += isNaN(
            parseFloat(row.total_plastic_bag_taxes)
        )
            ? 0.0
            : parseFloat(row.total_plastic_bag_taxes);
    });
    console.log("Totales antes del redondeo:");
    console.log("Total Taxed:", total_taxed);
    console.log("Total Exonerated:", total_exonerated);
    console.log("Total IGV:", total_igv);
    console.log("Total Value:", total_value);
    console.log("Total Plastic Bag Taxes:", total_plastic_bag_taxes);
    console.log("Total Charge:", total_charge);
    console.log("Total Discount:", total_discount);

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
    console.log("Totales después del redondeo:", {
        total_taxed: this.form.total_taxed,
        total_igv: this.form.total_igv,
        total_value: this.form.total_value,
        total_plastic_bag_taxes: this.form.total_plastic_bag_taxes,
        total_charge: total_charge,
        total_discount: total_discount
    });

    // this.form.total = _.round(total, 2)
    this.form.total = _.round(
        total_charge + total + this.form.total_plastic_bag_taxes,
        2
    );
    console.log("Total final calculado:", this.form.total);

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
