<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        :title="title"
    >
        <div class="row">
            <div class="col-md-4">
                <label for="name">Nombre</label>
                <el-input
                    v-model="form.name"
                    placeholder="Nombre"
                    :disabled="loading_submit"
                ></el-input>
            </div>
            <div class="col-md-4">
                <label for="document">Documento</label>
                <el-input
                    v-model="form.document"
                    placeholder="Documento"
                    :disabled="loading_submit"
                ></el-input>
            </div>
            <div class="col-md-4">
                <label for="establishment_id">Establecimiento</label>
                <el-select
                    v-model="form.establishment_id"
                    placeholder="Establecimiento"
                    :disabled="loading_submit"
                >
                    <el-option
                        v-for="item in establishments"
                        :key="item.id"
                        :label="item.description"
                        :value="item.id"
                    ></el-option>
                </el-select>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close" :disabled="loading_submit">Cancelar</el-button>
            <el-button
                type="primary"
                native-type="submit"
                @click="submit"
                :loading="loading_submit"
                >Guardar</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId", "establishments"],
    data() {
        return {
            title: null,
            resource: "sellers",
            errors: {},
            form: {},
            loading_submit: false,
            loading_submitI: false
        };
    },
    methods: {
        initForm() {
            this.form = {
                name: null,
                document: null,
                establishment_id: null
            };
        },
        open() {
            console.log(this.recordId);
            if(this.recordId){
                this.title = "Editar vendedor";
                // this.getRecord(this.recordId);
            }else{
                this.title = "Crear vendedor";
                this.initForm();
            }
        },
        close() {
            this.$emit('update:showDialog', false);
        },
        submit(){}
    }
};
</script>
