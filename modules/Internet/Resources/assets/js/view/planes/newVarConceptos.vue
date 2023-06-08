<template>
    <el-dialog
        :visible="shownewVarConceptdialog"
        append-to-body
        @close="close"
        @open="open"
        width="60%"
        title="Nueva Variacion de Concepto "
    >
        <div>
            <div class="row col-md-12 " style="  margin-top: 20px;">
                <div class="col-md-4">
                    <label class="control-label">Concepto Principal </label>
                    <el-select
                        v-model="form.select"
                        placeholder="Seleccione Concepto principal"
                        clearable
                        filterable
                    >
                        <el-option
                            v-for="item in conceptos"
                            :key="item.id"
                            :label="item.description"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label class="control-label"
                        >Nombre Variacion del Concepto
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
        </div>
        <span slot="footer">
            <el-button @click="close">Cancel</el-button>
            <el-button
                :loading="loadingGuardarvariacion"
                @click="guardarVariacionConcept"
                class="btn btn-primary"
                >Guardar</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["shownewVarConceptdialog", "conceptos"],

    data() {
        return {
            resource: "/internet/planes",
            form: {},
            loadingGuardarvariacion: false
        };
    },
    methods: {
        open() {
            this.form = {};
        },
        close() {
            this.$emit("update:shownewVarConceptdialog", false);
        },
        async guardarVariacionConcept() {
            this.loadingGuardarvariacion = true;
            console.log("guardando concepto");
            if (
                this.form.select == undefined ||
                this.form.nameVariacion == undefined ||
                this.form.precioVariacion == undefined ||
                this.select == "" ||
                this.form.nameVariacion == "" ||
                this.form.precioVariacion == undefined
            ) {
                this.$toast.warning("Recuerde rellenar todos los campos ");
                this.loadingGuardar = false;
                return;
            }
            try {
                const response = await axios.post(
                    `${this.resource}/newconceptVar`,
                    {
                        select: this.form.select,
                        nameVariacion: this.form.nameVariacion,
                        precioVariacion: this.form.precioVariacion
                    }
                );
                this.$toast.success("Registro guardado correctamente");
                this.$emit("callBrotherMethod");
                this.$emit("update:shownewVarConceptdialog", false);
            } catch (error) {
                console.log(error);
            } finally {
                this.loadingGuardarvariacion = false;
            }
        }
    }
};
</script>
