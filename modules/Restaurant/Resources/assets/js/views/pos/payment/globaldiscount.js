export function inputDiscountAmount() {
    /* console.log("inputDiscountAmount - globaldiscount.js aplicado"); */

    const toNum = v => (v == null || v === "" ? 0 : parseFloat(v));
    let global_discount = toNum(this.discount_amount);
    // Inicializar snapshot original para evitar descuentos en cascada
    if (!this.original_totals_snapshot) {
        this.original_totals_snapshot = {
            total: toNum(this.form.total),
            total_value: toNum(this.form.total_value),
            total_igv: toNum(this.form.total_igv),
            total_taxed: toNum(this.form.total_taxed),
            total_exonerated: toNum(this.form.total_exonerated),
            total_unaffected: toNum(this.form.total_unaffected),
            total_exportation: toNum(this.form.total_exportation),
            total_free: toNum(this.form.total_free),
            total_plastic_bag_taxes: toNum(this.form.total_plastic_bag_taxes)
        };
    }

    const original = this.original_totals_snapshot;
    let total = toNum(original.total);
    // Bases por tipo de operación (antes del descuento)
    const baseTaxedAntes = toNum(original.total_taxed);
    const baseExoneratedAntes = toNum(original.total_exonerated);
    const baseUnaffectedAntes = toNum(original.total_unaffected);
    const baseExportationAntes = toNum(original.total_exportation);
    let baseAntes = toNum(original.total_value);

    if (global_discount <= 0) {
        this.$toast.error("El descuento debe ser mayor a 0");
        return;
    }

    if (global_discount > total) {
        this.discount_amount = 0;
        this.$forceUpdate();
        return this.$toast.error("El descuento no puede ser mayor al total");
    }

    // Prorrateo: Para descuento tipo 02, SOLO afecta la base gravada (IGV/IVAP).
    // Exoneradas/inafectas/exportación NO deben reducirse.
    const igvAntes = toNum(original.total_igv);
    const hasTaxedBase = baseTaxedAntes > 0;
    const taxableWithIgv = hasTaxedBase ? (baseTaxedAntes + igvAntes) : 0;
    let amount02 = 0; // parte del descuento que afecta base imponible (tipo 02)
    let amount03 = 0; // excedente que no afecta base (tipo 03)
    if (hasTaxedBase) {
        amount02 = Math.min(global_discount, taxableWithIgv);
        amount03 = _.round(global_discount - amount02, 2);
    } else {
        amount03 = global_discount;
    }

    const ratioTaxedRaw = taxableWithIgv > 0 ? (amount02 / taxableWithIgv) : 0;
    const ratioTaxed = Math.min(Math.max(ratioTaxedRaw, 0), 1);

    // Nuevas bases: solo modificar gravada si corresponde
    const newTaxedBasePrecise = hasTaxedBase ? (baseTaxedAntes * (1 - ratioTaxed)) : baseTaxedAntes;
    this.form.total_taxed = _.round(newTaxedBasePrecise, 2);
    this.form.total_exonerated = baseExoneratedAntes;
    this.form.total_unaffected = baseUnaffectedAntes;
    this.form.total_exportation = baseExportationAntes;
    this.form.total_free = toNum(original.total_free);
    this.form.total_value = _.round(
        this.form.total_taxed + this.form.total_exonerated + this.form.total_unaffected + this.form.total_exportation,
        2
    );

    // IGV prorrateado solo si hay base gravada
    const newIgvPrecise = hasTaxedBase ? (igvAntes * (1 - ratioTaxed)) : igvAntes;
    this.form.total_igv = _.round(newIgvPrecise, 2);
    this.form.total_taxes = _.round(
        this.form.total_igv + (this.form.total_isc || 0) + (toNum(original.total_plastic_bag_taxes) || 0),
        2
    );

    // El total final debe ser el total original menos el descuento ingresado
    this.form.total = _.round(total - global_discount, 2);
    this.form.subtotal = this.form.total;

    // Desglose del descuento para registro
    // Si hay base gravada, registrar tipo 02 hasta donde alcance (base+IGV). El excedente, tipo 03.
    let discountBasePrecise = 0;
    let discountIgvPrecise = 0;
    let discountBaseRoundedForRecord = 0;
    let discountIgvRoundedForRecord = 0;
    const discounts = [];

    if (amount02 > 0 && hasTaxedBase) {
        discountBasePrecise = baseTaxedAntes - newTaxedBasePrecise;
        discountIgvPrecise = igvAntes - newIgvPrecise;
        discountBaseRoundedForRecord = _.round(discountBasePrecise, 2);
        discountIgvRoundedForRecord = _.round(discountIgvPrecise, 2);
        const factor02 = baseTaxedAntes > 0 ? Number((discountBasePrecise / baseTaxedAntes).toFixed(5)) : 0;
        discounts.push({
            discount_type_id: "02",
            description: "Descuentos globales que afectan la base imponible del IGV/IVAP",
            factor: factor02,
            amount: discountBaseRoundedForRecord,
            base: _.round(baseTaxedAntes, 2)
        });
    }
    if (amount03 > 0) {
        const baseFor03 = baseAntes; // mantener criterio de base total de valor de venta
        const factor03 = baseFor03 > 0 ? Number((amount03 / baseFor03).toFixed(5)) : 0;
        discounts.push({
            discount_type_id: "03",
            description: "Descuentos globales que no afectan la base imponible",
            factor: factor03,
            amount: _.round(amount03, 2),
            base: _.round(baseFor03, 2)
        });
    }
    this.form.discounts = discounts;

    // Guardar desglose del descuento para uso en UI/logs
    this.discount_base_amount = discountBaseRoundedForRecord;
    this.discount_igv_amount = discountIgvRoundedForRecord;

    // Registrar descuento total (sobre total con IGV)
    this.form.total_discount = _.round(global_discount, 2);

    /* console.log("Totales después de aplicar descuento global:", {
        total: this.form.total,
        total_value: this.form.total_value,
        total_taxed: this.form.total_taxed,
        total_exonerated: this.form.total_exonerated,
        total_unaffected: this.form.total_unaffected,
        total_exportation: this.form.total_exportation,
        total_igv: this.form.total_igv,
        total_taxes: this.form.total_taxes,
        total_discount: this.form.total_discount,
        discount_input: global_discount,
        discount_base_amount: discountBaseRoundedForRecord,
        discount_igv_amount: discountIgvRoundedForRecord,
        split: { amount02, amount03 }
    }); */
}

