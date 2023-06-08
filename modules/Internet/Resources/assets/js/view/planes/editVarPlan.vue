<template>
    <el-dialog
        @open="open"
        :visible="showEditPlanVar"
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
                        v-model="planPrin.plan_capacity"
                    />
                </div>
                <div class="col-md-4">
                    <label class="control-label"
                        >Nombre Variacion del Plan
                    </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="formvarPlan.description"
                    />
                </div>
                <div class="col-md-4">
                    <label class="control-label">Precio Variacion </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="formvarPlan.price"
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
    props: ["showEditPlanVar", "formvarPlan", "planPrin"],

    data() {
        return {
            loadingGuardar: false,
            resource: "/internet/planes",
            form: {}
        };
    },
    methods: {
        open() {
            this.form = {};
        },
        close() {
            this.$emit("update:showEditPlanVar", false);
        },
        async GuardarEdit() {
            try {
                const response = await axios.post(
                    `${this.resource}/guardarEdicionVariacion`,
                    {
                        id: this.formvarPlan.id,
                        descripcion: this.formvarPlan.description,
                        precio: this.formvarPlan.price,
                        planPrin: this.planPrin
                    }
                );

                const { status, data } = response;
                console.log(response);
                if (status == 200) {
                    this.$toast.success(
                        "Variacion de plan actualizado correctamente"
                    );
                    this.$emit("actualizarData");
                    this.close();
                }
            } catch (error) {
                console.log(error);
                this.$toast.error("Algo malo ha ocurrido ");
            }
        }
    }
};
</script>
