export function DiscountCalcItemAmounts(order) {
    // Solo calcula montos, no maneja advertencias visuales ni estado Vue
    try {
        const igvType = order.food.item.sale_affectation_igv_type_id; // '10' gravado, otros exoner/inafecto según SUNAT
        const qty = Number(order.quantity) || 0;
        const unitPrice = Number(order.price) || 0;
        const originalPrice = Number(order.food.item.price_original ?? order.food.item.price);
        const lineTotal = qty * unitPrice; // Total antes de descuento
        let discountInput = Number(order.food.item.discount) || 0; // valor ingreso
    const isPercent = Boolean(order.discount); // true => porcentaje
    console.log('Descuento:', discountInput, 'Tipo:', isPercent, 'Precio:', unitPrice, 'Original:', originalPrice);

        // Si el precio fue modificado manualmente, no aplicar descuento
        let discountAmount = 0;
        if (Math.abs(Number(unitPrice) - Number(originalPrice)) > 0.01) {
            discountAmount = 0;
        } else {
            // Determinar monto de descuento
            if (isPercent) {
                // porcentaje sobre el total de la línea
                discountAmount = lineTotal * (discountInput / 100);
            } else {
                discountAmount = discountInput; // monto directo
            }
            if (discountAmount > lineTotal) discountAmount = lineTotal; // no permitir negativo
        }

        // Monto luego del descuento
        const netAfterDiscount = lineTotal - discountAmount;
        // IGV 18% si es tipo 10 (gravado)
        let base = 0,
            igv = 0,
            total = 0;
        if (igvType == "10") {
            // Gravado
            // netAfterDiscount incluye IGV -> separar base e igv
            const factor = 1 + 0.18; // 18%
            base = netAfterDiscount / factor;
            igv = netAfterDiscount - base;
            total = base + igv; // = netAfterDiscount
        } else {
            // Exonerado / Inafecto: todo es base, sin IGV
            base = netAfterDiscount;
            igv = 0;
            total = netAfterDiscount;
        }
        return {
            base: Number(base.toFixed(2)),
            igv: Number(igv.toFixed(2)),
            total: Number(total.toFixed(2)),
            discount_amount: Number(discountAmount.toFixed(2)),
        };
    } catch (e) {
        return { base: 0, igv: 0, total: 0, discount_amount: 0 };
    }
}
