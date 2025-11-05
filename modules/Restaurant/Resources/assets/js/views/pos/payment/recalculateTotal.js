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
    let total_value = 0; // base values (without IGV)
    let total = 0; // grand total (base + igv + other taxes + charges - discounts)
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

    // Recalcular por cada línea de item de forma clara y predecible
    this.form.items.forEach(row => {
        const qty = safeNumber(row.quantity);
        const line_charge = safeNumber(row.total_charge);
        const line_discount = safeNumber(row.total_discount);
        const plastic = safeNumber(row.total_plastic_bag_taxes);

        // Determinar base (valor sin IGV) de la línea. Si ya viene como total_value
        // lo usamos; en algunos casos la línea puede venir con precio con IGV incluido
        // (affectation ids 11-16), en cuyo caso separamos la base y el IGV.
        let line_total_value = safeNumber(row.total_value);
        let line_igv = safeNumber(row.total_igv);

        // Si la línea tiene un tipo que indica precio incluye IGV (11-16)
        if (["11", "12", "13", "14", "15", "16"].includes(row.affectation_igv_type_id)) {
            // Descomponer precio que incluye IGV en base + igv
            const igvRate = this.toNumber(this.percentage_igv) / 100 || 0;
            if (igvRate > 0) {
                // base = total_value / (1 + igvRate)
                const base = _.round(line_total_value / (1 + igvRate), 8);
                const igvFromIncluded = _.round(line_total_value - base, 2);
                line_igv = igvFromIncluded;
                line_total_value = _.round(base, 2);
            }
        } else {
            // Si no viene total_igv calculado y es tipo gravado (10), calcularlo
            if (row.affectation_igv_type_id === "10") {
                line_igv = _.round(line_total_value * (this.toNumber(this.percentage_igv) / 100), 2);
            } else {
                line_igv = 0;
            }
        }

        // total de la línea: base + igv + plastic taxes + charges - discounts
        let line_total = _.round(line_total_value + line_igv + plastic + line_charge - line_discount, 2);

        // If a pre-computed total per line exists (e.g. merged items set _total_line),
        // prefer that authoritative value to avoid tiny rounding drifts between
        // the ordens calculation and this payment recalculation.
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

    // this.form.total = _.round(total, 2)
    // El total ya fue acumulado en `total` (que incluye base + igv + plastic + charges - discounts)
    this.form.total = _.round(total, 2);
   // console.log("Total final calculado:", this.form.total);

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