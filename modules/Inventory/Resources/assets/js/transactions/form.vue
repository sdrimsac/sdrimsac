<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <el-input v-model="form.name" >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div
                            class="form-group"
                            :class="{
                                'has-danger': errors.type
                            }"
                        >
                            <label class="control-label">Tipo</label>
                            <el-select v-model="form.type">
                                <el-option
                                    v-for="(option, idx) in ['output', 'input']"
                                    :key="idx"
                                    :value="option"
                                    :label="
                                        option == 'output'
                                            ? 'Salida'
                                            : 'Entrada'
                                    "
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.type"
                                v-text="errors.type[0]"
                            ></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId", "isDirect"],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            showDialogLotsOutput: false,
            resource: "transactions",
            errors: {},
            form: {},
            warehouses: []
        };
    },
    created() {
        this.initForm();
        this.$http.get(`/${this.resource}/tables`).then(response => {
            this.warehouses = response.data.warehouses;
        });
    },
    methods: {
        clickLotcodeOutput() {
            this.showDialogLotsOutput = true;
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                name: null,
                type: "output"
            };
        },
        create() {
            if(this.recordId){
                this.titleDialog = "Editar tipo de transacción";
            this.$http
                .get(`/${this.resource}/record/${this.recordId}`)
                .then(response => {
                    console.log("🚀 ~ file: form.vue:102 ~ create ~ response:", response)
                    this.form = response.data;
                });
            }else{
                this.titleDialog = "Crear tipo de trasancción";
            }
        },
        async submit() {
            // if(this.form.lots_enabled){
            //     let select_lots = await _.filter(this.form.lots, {'has_sale':true})
            //     if(select_lots.length != this.form.quantity_move){
            //         return this.$toast.error('La cantidad ingresada es diferente a las series seleccionadas');
            //     }
            // }

            this.loading_submit = true;
            await this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
