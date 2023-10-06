<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        :title="title"
        v-loading="loading"
    >
        <div class="row m-1" v-if="commercialTreatment">
            <span class="h4">
                Tipo de afectación:
                {{ commercialTreatment.is_amount ? "Monto" : "Porcentaje" }}
            </span>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            <div v-for="(data, idx) in tableData" :key="idx" class="m-1">
                <label for="desc">
                    {{ data.name }}
                </label>

                <el-input
                    type="number"
                    class="w-100"
                    v-model="data.amount"
                ></el-input>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "commercialTreatment"],
    data() {
        return {
            originalTitle: "Categoria x tratamiento comercial",
            title: "Categoria x tratamiento comercial",
            form: {},
            loading: false,
            resource: "commercial_treatment/categories",
            tableData: []
        };
    },
    methods: {
        async getTable() {
            this.loading = true;
            const response = await this.$http.get(
                `${this.resource}/records/${this.commercialTreatment.id}`
            );
            if (response.status == 200) {
                this.tableData = response.data;
            }
            this.loading = false;
        },

        async submit() {
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `${this.resource}/${this.commercialTreatment.id}`,
                    {
                        data: this.tableData
                    }
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Datos guardados correctamente",
                        type: "success"
                    });
                    this.close();
                }
            } catch (e) {
                this.$message({
                    message: "Ocurrio un error al guardar los datos",
                    type: "error"
                });
            } finally {
                this.loading = false;
            }
        },
        async open() {
            this.title =
                this.originalTitle + "/" + this.commercialTreatment.description;
            await this.getTable();
        },
        async close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
