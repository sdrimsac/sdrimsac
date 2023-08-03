<template>
    <el-dialog
        @open="open"
        @close="close"
        v-loading="loading"
        :title="titleDialog"
        :visible="showDialog"
    >
        <div class="row m-2">
            <div class="col-md-4">
                <label for="serie">Serie</label>
                <el-input class="w-100" v-model="form.series"> </el-input>
            </div>
            <div class="col-md-4">
                <label for="serie">Fecha</label>
                <el-date-picker
                    class="w-100"
                    v-model="form.date"
                    type="date"
                    value-format="yyyy-MM-dd"
                    default-timezone="local"
                ></el-date-picker>
            </div>
            <div class="col-md-4">
                <label for="serie">Estado</label>
                <el-select class="w-100" v-model="form.state">
                    <el-option value="Activo">Activo</el-option>
                    <el-option value="Inactivo">Inactivo</el-option>
                </el-select>
            </div>
        </div>
        <div class="row m-2"></div>
        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {
            titleDialog: "Series",
            loading: false,
            errors: {},
            form: {}
        };
    },
    async created() {},
    methods: {
        initForm() {
            this.form = {
                series: null,
                date: null
            };
        },
        open() {
            this.initForm();
            this.loading = true;
            this.$http
                .get(`/lotitem/record/${this.recordId}`)
                .then(response => {
                    this.form = response.data.record;
                    console.log(this.form);
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        close() {
            this.form = {};
            this.errors = {};
            this.$emit("update:showDialog", false);
        },

        submit() {
            this.loading = true;
            this.$http
                .post(`/lotitem/record`, this.form)
                .then(response => {
                    const { message } = response.data;
                    this.loading = false;
                    this.$toast.success(message);
                    this.$emit("update:showDialog", false);
                    this.$emit("reload");
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        }
    }
};
</script>
