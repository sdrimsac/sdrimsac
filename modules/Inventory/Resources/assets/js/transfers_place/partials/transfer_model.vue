<template>
    <el-dialog :visible.sync="dialogVisible" width="70%" :close-on-click-modal="false" :before-close="handleClose" :title="`Detalle de Traslado (${items.length} items)`"
        centered :append-to-body="true">

        <div>
            <!-- <h3
                style="margin-bottom: 18px; text-align: center; font-weight: bold; font-size: 20px; letter-spacing: 1px; color: #2d3a4b;">
                Detalle de Traslado</h3> -->
            <div style="overflow-x:auto;">
                <table
                    style="width:100%; border-collapse:collapse; background:#fff; border-radius:8px; box-shadow:0 2px 8px #e0e7ef; font-size:14px;">
                    <thead style="background:#f5f7fa;">
                        <tr>
                            <th style="padding:10px 8px; border-bottom:2px solid #e4e7ed; color:#34495e;">Producto</th>
                            <th style="padding:10px 8px; border-bottom:2px solid #e4e7ed; color:#34495e;">Cantidad</th>
                            <th style="padding:10px 8px; border-bottom:2px solid #e4e7ed; color:#34495e;">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" :key="index" style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:8px 6px; color:#222;">{{ item.description || item.item }}</td>
                            <td style="padding:8px 6px; text-align:center; color:#222;">{{ item.quantity }}</td>
                            <td style="padding:8px 6px;">
                                <!-- LOTES -->
                                <div v-if="item.lots_enabled" class="mb-1">
                                    <strong style="font-size:11px;">Lotes:</strong>
                                    <table
                                        v-if="item.series_lots && Array.isArray(item.series_lots.lotes) && item.series_lots.lotes.length"
                                        style="width:100%; margin-top:2px; font-size:11px; border:1px solid #e4e7ed; border-radius:4px;">
                                        <tr style="background:#f9fafb;">
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Código</th>
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Cant.</th>
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Vence</th>
                                        </tr>
                                        <tr v-for="(lote, i) in item.series_lots.lotes" :key="lote.code || i">
                                            <td style="padding:3px 4px;">{{ lote.code }}</td>
                                            <td style="padding:3px 4px; text-align:center;">{{ lote.quantity }}</td>
                                            <td style="padding:3px 4px;">{{ lote.date_of_due }}</td>
                                        </tr>
                                    </table>
                                    <span v-else style="font-size:11px; color:#888;">Sin lotes</span>
                                </div>
                                <!-- SERIES -->
                                <div v-if="item.series_enabled" class="mb-1">
                                    <strong style="font-size:11px;">Series:</strong>
                                    <div v-if="item.series_lots && Array.isArray(item.series_lots.series) && item.series_lots.series.length"
                                        style="display:flex; flex-wrap:wrap; gap:4px; margin-top:2px;">
                                        <span v-for="(ser, i) in item.series_lots.series" :key="ser.id || i"
                                            style="background:#eaf1fb; border:1px solid #b3c6e0; border-radius:4px; padding:2px 8px; margin-right:2px; font-size:11px; color:#2d3a4b;">{{
                                            ser.series }}</span>
                                    </div>
                                    <span v-else style="font-size:11px; color:#888;">Sin series</span>
                                </div>
                                <!-- TALLA / COLOR -->
                                <div v-if="item.has_color_size" class="mb-1">
                                    <strong style="font-size:11px;">Talla / Color:</strong>
                                    <table
                                        v-if="item.series_lots && Array.isArray(item.series_lots.color_size) && item.series_lots.color_size.length"
                                        style="width:100%; margin-top:2px; font-size:11px; border:1px solid #e4e7ed; border-radius:4px;">
                                        <tr style="background:#f9fafb;">
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Código</th>
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Talla</th>
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Color</th>
                                            <th style="padding:4px; border-bottom:1px solid #e4e7ed;">Cant.</th>
                                        </tr>
                                        <tr v-for="(cs, i) in item.series_lots.color_size" :key="cs.code || i">
                                            <td style="padding:3px 4px;">{{ cs.code }}</td>
                                            <td style="padding:3px 4px;">{{ cs.size }}</td>
                                            <td style="padding:3px 4px;">{{ cs.color }}</td>
                                            <td style="padding:3px 4px; text-align:center;">{{ cs.quantity }}</td>
                                        </tr>
                                    </table>
                                    <span v-else style="font-size:11px; color:#888;">Sin talla/color</span>
                                </div>
                                <!-- Si no hay ningún detalle adicional -->
                                <div v-if="!item.lots_enabled && !item.series_enabled && !item.has_color_size"
                                    style="font-size:11px; color:#888;">Sin detalle</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: ["dialogVisible", "items"],
        
    methods: {
        handleClose() {
            this.$emit('update:dialogVisible', false);
        }
    }
};
</script>