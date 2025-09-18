export function DiscountCalcItemAmounts(order) {
    try {
        const igvType = order.food.item.sale_affectation_igv_type_id; // '10' gravado, otros exoner/inafecto según SUNAT
        const qty = Number(order.quantity) || 0;
        const unitPrice = Number(order.price) || 0;
        const lineTotal = qty * unitPrice; // Total antes de descuento
        let discountInput = Number(order.food.item.discount) || 0; // valor ingreso
        const isPercent = !!order.discount; // true => porcentaje
        // Determinar monto de descuento
        let discountAmount = 0;
        if (isPercent) {
            // porcentaje sobre el total de la línea
            discountAmount = lineTotal * (discountInput / 100);
        } else {
            discountAmount = discountInput; // monto directo
        }
        if (discountAmount > lineTotal) discountAmount = lineTotal; // no permitir negativo
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
        console.log('DiscountCalcItemAmounts', { base, igv, total, discountAmount })
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
