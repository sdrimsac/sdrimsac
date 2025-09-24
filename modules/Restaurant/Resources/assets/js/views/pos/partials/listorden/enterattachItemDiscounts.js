export function attachItemDiscounts(items) {
    console.log("attachItemDiscounts reawfsdvsdfdfsdfasdsdf", items);
    try {
        items.forEach(item => {
            if (!item || !item.food || !item.food.item) return;

            // Validar si existe el precio original
            const originalPrice = Number(item.food.item.price_original ?? item.food.item.price);
            const currentPrice = Number(item.price) || 0;
            const qty = Number(item.quantity) || 0;
            if (qty <= 0 || currentPrice < 0) return;

            // Si el precio fue modificado manualmente, no aplicar descuento
            if (Number(currentPrice).toFixed(2) !== Number(originalPrice).toFixed(2)) {
                item.discounts = [];
                item.discount_igv = 0;
                item.total_discount = 0;
                return;
            }

            const lineTotal = qty * currentPrice; // total original con IGV (si aplica)
            const igvType = item.food.item.sale_affectation_igv_type_id;
            const discountInput = Number(item.food.item.discount) || 0;
            const isPercent = !!item.discount; // true => porcentaje

            if (discountInput <= 0) return;

            // Calcular descuento ingresado
            let discountAmount = 0;
            if (isPercent) {
                discountAmount = lineTotal * (discountInput / 100);
            } else {
                discountAmount = discountInput;
            }

            if (discountAmount > lineTotal) discountAmount = lineTotal;

            let discountBase = discountAmount;
            let discountIgv = 0;
            let baseOriginal = lineTotal;

            if (igvType === "10") {
                // El descuento se ingresa con IGV, lo separamos en base e IGV
                discountBase = discountAmount / 1.18;
                discountIgv = discountAmount - discountBase;

                // La base imponible original (sin descuento)
                baseOriginal = lineTotal / 1.18;
            }

            const factor = _.round(discountBase / baseOriginal, 4);
            const amount = _.round(discountBase, 2);
            const base = _.round(baseOriginal, 2);

            item.discounts = [
                {
                    discount_type_id: "00",
                    description:
                        "Descuento que afecta la base imponible del IGV/IVAP",
                    factor,
                    amount, // base imponible del descuento
                    base
                }
            ];

            // Este es el descuento total con IGV (lo que el cliente ve)
            /* item.total_discount = _.round(discountAmount, 2); */
            /* console.log("ver el total del descuento", item.total_discount); */

            // Opcional: guardar también el IGV del descuento
            item.discount_igv = _.round(discountIgv, 2);
        });
    } catch (e) {
        console.error("Error al adjuntar descuentos a los items:", e);
    }
}
