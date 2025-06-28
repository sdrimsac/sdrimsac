<template>
    <el-dialog
        @open="open"
        :visible="showEditPlanVar"
        append-to-body
        @close="close"
        width="50%"
        title="Nueva Variación de Planes "
    >
        <div>
            <div class="row col-md-12 " style="  margin-top: 20px;">
                <div class="col-md-4">
                    <label class="control-label">
                        <i class="el-icon-s-platform" style="margin-right:5px;"></i>
                        Plan Principal
                    </label>
                    <input
                        type="text"
                        disabled
                        class="form-control text-center"
                        v-model="planPrin.plan_capacity"
                    />
                </div>
                <div class="col-md-5">
                    <label class="control-label">
                        <i class="el-icon-document" style="margin-right:5px;"></i>
                        Nombre Variación del Plan
                    </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="formvarPlan.description"
                    />
                </div>
                <div class="col-md-3">
                    <label class="control-label">
                        <i class="el-icon-money" style="margin-right:5px;"></i>
                        Precio Variación
                    </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="formvarPlan.price"
                    />
                </div>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <el-button class="btn_cancelarsmall" @click="close">
                    <i class="fas fa-times fa-lg" style="margin-right: 4px;"></i>
                    Cancelar
                </el-button>
                <el-button class="btn_guardarsmall" type="primary" :loading="loadingGuardar"
                @click="GuardarEdit">
                    <i class="fas fa-save fa-lg" style="margin-right: 4px;"></i>
                    Guardar
                </el-button>
            </div>
        </div>
        <!-- <span slot="footer">
            <el-button @click="close">Cancel</el-button>
            <el-button
                class="btn btn-primary"
                :loading="loadingGuardar"
                @click="GuardarEdit"
                >Guardar</el-button
            >
        </span> -->
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
