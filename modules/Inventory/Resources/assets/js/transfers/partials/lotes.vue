<template>
    <el-dialog
        :title="titleDialog"
        width="40%"
        :visible="showDialog"
        @open="create"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        :show-close="false"
    >
        <div class="form-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 table-responsive">
                    <table width="100%" class="table">
                        <thead>
                            <tr width="100%">
                                <th class="text-center">#</th>
                                <th>Cod. Lote</th>
                                <th>Fecha</th>
                                <th>Cantidad</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in lotes"
                                :key="index"
                                width="100%"
                            >
                                <td class="text-center">
                                    {{ index + 1 }}
                                </td>
                                <td>
                                    {{ row.code }}
                                </td>
                                <td>
                                    {{ row.date_of_due }}
                                </td>
                                <td>
                                    {{ row.quantity }}
                                </td>
                                <td>
                                    <el-input v-model="row.selectedQuantity">
                                    </el-input>
                                </td>
                                <br />
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-actions text-end pt-2 pb-2">
            <el-button @click.prevent="close()">Cerrar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "lotes"],
    data() {
        return {
            titleDialog: "Series",
            loading: false,
            errors: {},
            form: {}
        };
    },
    async created() {},
    methods: {
        create() {},
        async submit() {
            let quantity = this.lotes.reduce(
                (a, b) => a + Number(b.selectedQuantity ?? "0"),
                0
            );
            this.$emit("sumLotes", quantity);
            this.close();
        },
        close() {
            this.$emit("addRowOutputLote", this.lotes);
            this.$emit("update:showDialog", false);
        },
        async clickCancelSubmit() {}
    }
};
</script>
