export function inputdiscountGlobal2() {
    let global_discount = parseFloat(this.discount_amount);
    let base = parseFloat(this.form.total);
    let amount = parseFloat(global_discount);
    let factor = _.round(amount / base, 4);

    let discount = _.find(this.form.discounts, {
        discount_type_id: "03"
    });

    if (global_discount > 0 && !discount) {
        this.form.total_discount = _.round(amount, 2);

        this.form.total = _.round(this.form.total - amount, 2);

        this.form.total_value = _.round(
            this.form.total / (1 + this.percentage_igv || 18 / 100),
            2
        );
        this.form.total_taxed = this.form.total_value;

        this.form.total_igv = _.round(
            this.form.total_value * (this.percentage_igv || 18 / 100),
            2
        );
        this.form.total_taxes = this.form.total_igv;

        this.form.discounts.push({
            discount_type_id: "03",
            description:
                "Descuentos globales que no afectan la base imponible del IGV/IVAP",
            factor: factor,
            amount: amount,
            base: base
        });
    } else {
        let index = this.form.discounts.indexOf(discount);

        if (index > -1) {
            this.form.total_discount = _.round(amount, 2);
            this.form.total = _.round(this.form.total - amount, 2);
            this.form.total_value = _.round(
                this.form.total / (1 + this.percentage_igv || 18 / 100),
                2
            );
            this.form.total_taxed = this.form.total_value;
            this.form.total_igv = _.round(
                this.form.total_value * (this.percentage_igv || 18 / 100),
                2
            );
            this.form.total_taxes = this.form.total_igv;

            this.form.discounts[index].base = base;
            this.form.discounts[index].amount = amount;
            this.form.discounts[index].factor = factor;
        }
    }
}
