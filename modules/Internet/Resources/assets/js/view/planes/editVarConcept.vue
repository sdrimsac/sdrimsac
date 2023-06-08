<template>
    <el-dialog
        @open="open"
        :visible="showEditconceptVar"
        append-to-body
        @close="close"
        width="60%"
        title="Nueva Variacion de Planes "
    >
        <div>
            <div class="row col-md-12 " style="  margin-top: 20px;">
                <div class="col-md-4">
                    <label class="control-label">Plan Principal </label>
                    <input
                        type="text"
                        disabled
                        class="form-control text-center"
                        v-model="conceptPrin.concept_description"
                    />
                </div>
                <div class="col-md-4">
                    <label class="control-label"
                        >Nombre Variacion del Concepto
                    </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="formvarConcept.description"
                    />
                </div>
                <div class="col-md-4">
                    <label class="control-label">Precio Variacion </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="formvarConcept.price"
                    />
                </div>
            </div>
        </div>
        <span slot="footer">
            <el-button @click="close">Cancel</el-button>
            <el-button
                class="btn btn-primary"
                :loading="loadingGuardar"
                @click="GuardarEdit"
                >Guardar</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showEditconceptVar", "formvarConcept", "conceptPrin"],

    data() {
        return {
            resource: "/internet/planes",
            loadingGuardar: false,
            form: {},
            planPrin: {}
        };
    },
    methods: {
        open() {
            this.form = {};
        },
        close() {
            this.$emit("update:showEditconceptVar", false);
        },
        GuardarEdit() {
            this.loadingGuardar = true;
            console.log("guardar concepto editt");

            try {
                const response = axios.post(
                    `${this.resource}/saveEdicionVariacion`,
                    {
                        form: this.formvarConcept,
                        concept: this.conceptPrin
                    }
                );
                const { status, data } = response;
                if (status == 200) {
                    this.$toast.success(
                        "Variacion de plan actualizado correctamente"
                    );
                    this.$emit("actualizarData");
                    this.close();
                }
            } catch (error) {
                console.log(error);
                this.$toast.error("Tuvimos un inconveniente");
            } finally {
                this.loadingGuardar = false;
            }
        }
    }
};
</script>
