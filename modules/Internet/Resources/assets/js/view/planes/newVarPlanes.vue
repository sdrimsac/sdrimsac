<template>
    <el-dialog
        @open="open"
        :visible="shownewVarPlanesdialog"
        append-to-body
        @close="close"
        width="50%"
        title="Nueva Variación de Planes "
    >
        <div>
            <div class="row col-md-12 " style="  margin-top: 20px;">
                <div class="col-md-4">
                    <label class="control-label">
                        <i class="el-icon-s-operation" style="margin-right: 5px;"></i>
                        Plan Principal
                    </label>
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
                <div class="col-md-5">
                    <label class="control-label">
                        <i class="el-icon-edit-outline" style="margin-right: 5px;"></i>
                        Nombre Variación del Plan
                    </label>
                    <input
                        type="text"
                        class="form-control text-center"
                        v-model="form.nameVariacion"
                    />
                </div>
                <div class="col-md-3">
                    <label class="control-label">
                        <i class="el-icon-money" style="margin-right: 5px;"></i>
                        Precio Variación
                    </label>
                    <input
                        type="number"
                        class="form-control text-center"
                        v-model="form.precioVariacion"
                        step="0.01"
                        min="0"
                        @input="form.precioVariacion = form.precioVariacion
                            ? parseFloat(form.precioVariacion).toFixed(2)
                            : ''"
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
                @click="GuardarPlanVariaciacion()">
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
                @click="GuardarPlanVariaciacion()"
                >Guardar</el-button
            >
        </span> -->
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
