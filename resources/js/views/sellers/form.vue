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
                <label for="document_type">Tipo de documento</label>
                  <el-select
                    v-model="form.document_type_id"
                    :disabled="loading_submit"
                >
                    <el-option
                        v-for="(item,idx) in document_types"
                        :key="idx"
                        :label="item.description"
                        :value="item.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label for="document">Documento</label>
                <el-input
                    v-model="form.document"
                    placeholder="Documento"
                    :disabled="loading_submit"
                    minlength="8"
                >
                    <el-button
                        v-if="form.document_type_id == 1"
                        @click="searchDocument"
                        slot="prepend"
                        icon="el-icon-search"
                    ></el-button>
                </el-input>
            </div>
            <div class="col-md-4">
                <label for="name">Nombre</label>
                <el-input
                    v-model="form.name"
                    placeholder="Nombre"
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
            <el-button @click="close" :disabled="loading_submit"
                >Cancelar</el-button
            >
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
    props: ["showDialog", "recordId", "establishments","document_types"],
    data() {
        return {
            title: null,
            resource: "sellers",
            errors: {},
            form: {},
            loading_submit: false,
            loading_submitI: false,
            timer:null,
       
        };
    },
    methods: {
        initForm() {
            this.form = {
                name: null,
                document: null,
                establishment_id: null,
                document_type_id: null,
            };
        },
      async  searchDocument(){
             if (this.form.document === "") {
                this.$message.error("Ingresar el número a buscar");
                return;
            }
            if(this.form.document.length != 8){
                this.$message.error("El número debe tener 8 dígitos");
                return;
            }
            let identity_document_type_name = "dni";

            let response = await this.$http.get(
                `/service/${identity_document_type_name}/${this.form.document}`
            );
            if (response.data.success) {
                let data = response.data.data;

                this.form.name = data.nombre_completo;


            } else {
                this.$message.error(response.data.message);
            }
        },
        open() {
            console.log(this.recordId);
            if(this.recordId){
                this.title = "Editar vendedor";
                this.getRecord(this.recordId);
            }else{
                this.title = "Crear vendedor";
                this.initForm();
            }
        },
        async getRecord(id) {
            const response = await this.$http.get(`/${this.resource}/record/${id}`);
            this.form = response.data.data;
        },
        close() {
            this.$emit('update:showDialog', false);
        },
        async submit(){   
            const response = await this.$http.post(`/${this.resource}`, this.form);
            if (response.data.success) {
                this.$message.success(response.data.message);
                this.close();
                this.$eventHub.$emit("reloadData");
            } else {
                this.$message.error(response.data.message);
            }
        }
    }
};
</script>
