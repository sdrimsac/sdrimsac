export function inputReCalculateTotal() {
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
        /* console.log("row:", row.affectation_igv_type_id); */
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
            /* row.total_igv = total_value_partial * (row.percentage_igv / 100); */
            row.total_igv =
                        total_value_partial *
                        (this.toNumber(row.percentage_igv) / 100);
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

/* reCalculateTotal() {
            if (!this.form.items || this.form.items.length == 0) {
                return;
            }
            // Si ya existe un snapshot (descuento aplicado) y se están recalculando los items sin cambiar el descuento, restaurar valores base antes de recomputar
            if (
                this.original_totals_snapshot &&
                this.discount_applied &&
                !this.discount_dirty
            ) {
                // Evitar que se consoliden nuevamente los valores con descuento como base
                this.form.total = this.original_totals_snapshot.total;
                this.form.total_value = this.original_totals_snapshot.total_value;
                this.form.total_igv = this.original_totals_snapshot.total_igv;
                this.form.total_taxed = this.original_totals_snapshot.total_taxed;
                this.form.total_exonerated = this.original_totals_snapshot.total_exonerated;
            }
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
                
                total_discount += this.toNumber(row.total_discount);
                total_charge += this.toNumber(row.total_charge);

                if (row.affectation_igv_type_id === "10") {
                    total_taxed += this.toNumber(row.total_value);
                }
                if (row.affectation_igv_type_id === "20") {
                    total_exonerated += this.toNumber(row.total_value);
                }
                if (row.affectation_igv_type_id === "30") {
                    total_unaffected += this.toNumber(row.total_value);
                }
                if (row.affectation_igv_type_id === "40") {
                    total_exportation += this.toNumber(row.total_value);
                }
                if (
                    ["11", "12", "13", "14", "15", "16"].includes(
                        row.affectation_igv_type_id
                    )
                ) {
                    // guard against undefined values and division by zero
                    let unit_value =
                        this.toNumber(row.total_value) /
                        (this.toNumber(row.quantity) || 1);
                    let total_value_partial =
                        unit_value * this.toNumber(row.quantity);
                    // ensure ternary applies only to the plastic bag taxes
                    row.total_taxes =
                        this.toNumber(row.total_value) -
                        total_value_partial +
                        (isNaN(parseFloat(row.total_plastic_bag_taxes))
                            ? 0.0
                            : this.toNumber(row.total_plastic_bag_taxes));
                    row.total_igv =
                        total_value_partial *
                        (this.toNumber(row.percentage_igv) / 100);
                    row.total_base_igv = total_value_partial;
                    total_value -= this.toNumber(row.total_value);
                    total += this.toNumber(row.total);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += this.toNumber(row.total_value);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) > -1
                ) {
                    total_igv += this.toNumber(row.total_igv);
                    total += this.toNumber(row.total);
                }
                if (!["21", "37"].includes(row.affectation_igv_type_id)) {
                    total_value += this.toNumber(row.total_value);
                }
                total_plastic_bag_taxes += this.toNumber(
                    row.total_plastic_bag_taxes
                );
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
            this.form.total_plastic_bag_taxes = _.round(
                total_plastic_bag_taxes,
                2
            );

            // this.form.total = _.round(total, 2)
            this.form.total = _.round(
                total_charge + total + this.form.total_plastic_bag_taxes,
                2
            );
            //para el calculo de venta en descuento global
            //if (!(
            //    boxes + amount1 < amount2 &&
            //    this.form.document_type_id == "80")){
            //    this.form.enter_amount = this.form.total;
            //    this.enterAmount();
            //}

            if (
                this.discount_amount &&
                (!this.discount_applied || this.discount_dirty)
            ) {
                // Antes de aplicar nuevamente, asegurar snapshot de base intacta
                if (this.discount_dirty && this.original_totals_snapshot) {
                    this.form.total = this.original_totals_snapshot.total;
                    this.form.total_value = this.original_totals_snapshot.total_value;
                    this.form.total_igv = this.original_totals_snapshot.total_igv;
                    this.form.total_taxed = this.original_totals_snapshot.total_taxed;
                    this.form.total_exonerated = this.original_totals_snapshot.total_exonerated;
                }
                this.discountGlobal();
            }

            console.log(this.form);

            // Recalcular total_discount consolidado (descuentos por item + descuento global aplicado)
            // 1. Sumar descuentos de cada item (item.total_discount)
            let itemLevelDiscount = 0;
            this.form.items.forEach(row => {
                itemLevelDiscount += this.toNumber(row.total_discount);
            });

            // 2. Verificar si existe un descuento global en form.discounts (tipo 03 u otros) y sumar su monto
            let globalLevelDiscount = 0;
            if (
                Array.isArray(this.form.discounts) &&
                this.form.discounts.length
            ) {
                this.form.discounts.forEach(d => {
                    // campos posibles: amount, amount_base, factor. Usamos amount si existe.
                    if (d && d.amount)
                        globalLevelDiscount += this.toNumber(d.amount);
                });
            }

            // 3. Si se ingresó discount_amount manual (this.discount_amount) y no está reflejado en form.discounts, lo integramos.
            // Evitar doble conteo: solo sumar si no hay descuento global ya registrado.
            if (this.discount_amount && globalLevelDiscount === 0) {
                // discount_amount representa un descuento total directo sobre la venta
                globalLevelDiscount += this.toNumber(this.discount_amount);
            }

            // 4. Total consolidado
            const consolidatedDiscount = _.round(
                itemLevelDiscount + globalLevelDiscount,
                2
            );
            this.form.total_discount = consolidatedDiscount;

            // 5. (Opcional) Garantizar que total no sea negativo
            if (this.form.total < 0) {
                this.form.total = 0;
            }

            console.log("Totales después del redondeo:", {
                total_taxed: this.form.total_taxed,
                total_igv: this.form.total_igv,
                total_value: this.form.total_value,
                total_discount: this.form.total_discount,
            });
            // this.discountGlobal();

            let saleTotal = this.form.total; // Monto total de la venta
            let promotionTotal = this.total || 0; // Monto que tiene la promoción
            let points_value = this.points_value || 0.1; // Valor de puntos por unidad monetaria

            // Calcula puntos solo si hay un monto de venta
            if (saleTotal > 0) {
                // Si hay monto de promoción, usa ese para calcular puntos
                if (promotionTotal > 0) {
                    this.ventalista = parseFloat(
                        (saleTotal / promotionTotal).toFixed(2)
                    );
                } else {
                    // Si no hay monto de promoción, usa el cálculo estándar
                    this.ventalista = parseFloat(
                        (saleTotal * points_value).toFixed(2)
                    );
                }
            } else {
                this.ventalista = 0;
            }
        } */
