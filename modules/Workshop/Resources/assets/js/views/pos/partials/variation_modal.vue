<template>
    <el-dialog
        :visible="showDialog"
        @close="close"
        @open="open"
        title="Variación"
        append-to-body
    >
        <div class="row mt-2">
            <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                <label for="description">Descripción</label>
                <el-input
                    v-model="form.description"
                    placeholder="Descripción"
                    clearable
                ></el-input>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                <label for="price">Precio</label>
                <el-input
                    v-model="form.price"
                    placeholder="Precio"
                    clearable
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
    props: ["showDialog"],
    data() {
        return {
            form: {
                description: "",
                price: 0
            }
        };
    },
    methods: {
        open() {
            this.form = {
                description: "Consumo",
                price: 0
            };
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        submit(){
            if(this.form.description == "" || this.form.price == 0){
                this.$message.error("Por favor, complete todos los campos");
                return;
            }
            this.$emit("sendVariation", this.form);
            this.close();
        }
    }
};
</script>

<style></style>
