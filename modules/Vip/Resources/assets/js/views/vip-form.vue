<template>
    <el-dialog
        :title="titleDialog"
        :visible="showFormVip"
        width="30%"
        @close="close"
        @open="create"
        v-loading="loading"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label class="control-label">Descripción</label>
                            <el-input v-model="form.description">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.description"
                                v-text="errors.description[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.percentage }"
                        >
                            <label class="control-label">Porcentaje </label
                            ><br />
                            <el-input-number
                                :min="1"
                                :max="100"
                                :precision="2"
                                :step="0.1"
                                v-model="form.percentage"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input-number>

                            <small
                                class="form-control-feedback"
                                v-if="errors.percentage"
                                v-text="errors.percentage[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.inscription_amount }"
                        >
                            <label class="control-label"
                                >Monto de inscripción </label
                            ><br />
                            <el-input-number
                                :precision="2"
                                :step="0.1"
                                v-model="form.inscription_amount"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input-number>

                            <small
                                class="form-control-feedback"
                                v-if="errors.inscription_amount"
                                v-text="errors.inscription_amount[0]"
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
                    :loading="loadingSubmit"
                    >Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>
<style scoped>
.el-input-number .el-input__inner {
    text-align: right !important;
}
</style>
<script>
export default {
    props: ["showFormVip", "recordId"],
    data() {
        return {
            loadingSubmit: false,
            titleDialog: "el titulo",
            loading: false,
            resource: "categories/record",
            errors: {},
            form: {}
        };
    },
    methods: {
        async create() {
            this.form = {};
            this.titleDialog = "Nueva categoria";
            if (this.recordId) {
                this.titleDialog = "Editando categoria";
                try {
                    this.loading = true;
                    const response = await this.$http(
                        `${this.resource}/${this.recordId}`
                    );
                    console.log(response);
                } catch (e) {
                    console.log(e);
                } finally {
                    this.loading = false;
                }
            }
        },
        async close() {
            this.$emit("update:showFormVip", false);
        },
        async submit() {
            try {
                this.loadingSubmit = true;
                const response = await this.$http.post(
                    "/vip/category",
                    this.form
                );
                if (response.status == 200) {
                    let msg = this.recordId
                        ? "Categoria editada"
                        : "Categoria creada";
                    this.$toast.success(msg);
                    this.close();
                    this.$eventHub.$emit("reloadData");
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loadingSubmit = false;
            }
        }
    }
};
</script>
