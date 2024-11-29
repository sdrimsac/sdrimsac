<template>
    <el-dialog
        title="Seleccionar politica de precio"
        :visible="showDialog"
        @close="close"
        @open="open"
        append-to-body
    >
        <div class="row mt-2">
          <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo de unidad</th>
                            <th>Precio</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="unit_type in unit_types" :key="unit_type.id">
                            <td>{{ unit_type.description }}</td>
                            <td>{{ getDefPrice(unit_type) }}</td>
                            <td>
                                <el-button type="primary" icon="el-icon-check"
                                    @click="selectUnitType(unit_type)"
                                ></el-button>
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
    props: ["showDialog", "item"],
    data() {
        return {
            unit_types: []
        };
    },
    methods: {
        open() {
            this.unit_types = this.item.types;
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getDefPrice(unit_type) {
            let prices = ["price1", "price2", "price3"];
            let defaulPrice = unit_type.price_default;
            let price = prices[defaulPrice - 1];
            return unit_type[price];
        },
        selectUnitType(unit_type) {
            this.$emit("update:showDialog", false);
            this.$emit("selectUnitType", unit_type);
        }
    }
};
</script>

<style></style>
