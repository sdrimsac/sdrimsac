<template>
    <el-dialog
        title="Bonus"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
    >
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad mínima</th>
                        <th>Bonificación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in item_unit_type" :key="index">
                        <td>{{ item.description }}</td>
                        <td>
                            <el-input-number
                                v-model="item.qty_min"
                                :min="0"
                                :step="1"
                            ></el-input-number>
                        </td>
                        <td>
                            <el-input-number
                                v-model="item.qty_free"
                                :min="0"
                                :step="1"
                            ></el-input-number>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <el-button class="btn-cancel btn-cancel:hover" @click="close"
                >Cancelar</el-button
            >
            <el-button class="btn-save btn-save:hover" @click="save"
                >Guardar</el-button
            >
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            item_unit_type: [],
            bonus_unit_type: [],
            item_unit_type: [],
            loading: false
        };
    },
    methods: {
        save() {
            this.loading = true;
            this.$http
                .post("/items/bonus-unit-type", {
                    item_unit_type: this.item_unit_type
                })
                .then(response => {
                    this.$showSAlert("Exito", "Bonificaciones guardadas");
                    this.close();
                    // console.log(response);
                })
                .catch(error => {
                    this.$showSAlert(
                        "Error",
                        "Error al guardar bonificaciones",
                        "error"
                    );
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        getUnitTypes() {
            this.loading = true;
            this.$http("/items/bonus-unit-type")
                .then(response => {
                    let { data } = response;
                    this.item_unit_type_descriptions = data.item_unit_type;
                    this.bonus_unit_type = data.bonus_unit_type;
                    this.item_unit_type = this.item_unit_type_descriptions.map(
                        description => {
                            let bonus = this.bonus_unit_type.find(
                                bonus => bonus.description === description
                            );
                            let item = { description };
                            if (bonus) {
                                item.qty_free = bonus.qty_free;
                                item.qty_min = bonus.qty_min;
                            } else {
                                item.qty_free = 0;
                                item.qty_min = 0;
                            }
                            return item;
                        }
                    );
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        open() {
            this.getUnitTypes();
            console.log("open");
        },
        close() {
            console.log("close");
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
