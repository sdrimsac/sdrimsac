<template>
    <el-dialog
        @open="open"
        :visible="shownewVarPlanesdialog"
        append-to-body
        @close="close"
        width="60%"
        title="Nueva Variacion de Planes "
    >
        <div>
            <div class="row col-md-12 " style="  margin-top: 20px;">
                <div class="col-md-4">
                    <label class="control-label">Plan Principal </label>
                    <el-select
                        v-model="form.select"
                        placeholder="Seleccione plan principal"
                        clearable
                        filterable
                    >
                        <el-option
                            v-for="item in planes"
                            :key="item.id"
                            :label="item.capacity + 'Mb'"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label class="control-label"
                        >Nombre Variacion del Plan
                    </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="form.nameVariacion"
                    />
                </div>
                <div class="col-md-4">
                    <label class="control-label">Precio Variacion </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="form.precioVariacion"
                    />
                </div>
            </div>
            <div class="row col-md-12"></div>
        </div>
        <span slot="footer">
            <el-button @click="close">Cancel</el-button>
            <el-button
                class="btn btn-primary"
                :loading="loadingGuardar"
                @click="GuardarPlanVariaciacion()"
                >Guardar</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["shownewVarPlanesdialog", "planes"],

    data() {
        return {
            resource: "/internet/planes",
            form: { item_id: "" },
            loadingGuardar: false
        };
    },
    methods: {
        open() {
            this.form = {};
        },
        close() {
            this.$emit("update:shownewVarPlanesdialog", false);
        },
        async GuardarPlanVariaciacion() {
            this.loadingGuardar = true;

            if (
                this.form.select == undefined ||
                this.form.nameVariacion == undefined ||
                this.form.precioVariacion == undefined ||
                this.select == "" ||
                this.form.nameVariacion == "" ||
                this.form.precioVariacion == undefined
            ) {
                this.$toast.warning("recuerde rellenar todos los campos ");
                this.loadingGuardar = false;
                return;
            }
            try {
                const response = await axios.post(
                    `${this.resource}/newPlanVar`,
                    {
                        select: this.form.select,
                        nameVariacion: this.form.nameVariacion,
                        precioVariacion: this.form.precioVariacion
                    }
                );
                this.$toast.success("Registro guardado correctamente");
                this.$emit("callBrotherMethod");
                this.$emit("update:shownewVarPlanesdialog", false);
            } catch (error) {
                console.log(error);
            } finally {
                this.loadingGuardar = false;
            }
        }
    }
};
</script>
