<template>
    <el-dialog append-to-body :title="titleDialog" :visible="showDialog" @close="close" @open="create" 
    width="30%">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" :class="{ 'has-danger': errors.description }">
                            <label class="control-label">Motivo de Anulación</label>
                            <el-input v-model="form.documents[0].description" dusk="description">
                                <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.description"
                                v-text="errors.description[0]"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <!-- <el-button class="btn_Cancelarsmall" type="danger" @click.prevent="close()">Cancelar</el-button> -->
                <el-button class="btn_Cancelarsmall" type="danger" native-type="submit" dusk="annulment-voided"
                    :loading="loading_submit">
                    <i class="el-icon-close"></i> Anular Sunat
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: ["showDialog", "recordId", "external"],
    components: {
        Swal
    },
    data() {
        return {
            titleDialog: null,
            loading_submit: false,
            resource: null,
            errors: {},
            form: {},
            group_id: null
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        initForm() {
            (this.loading_submit = false),
                (this.group_id = null),
                (this.errors = {}),
                (this.form = {
                    date_of_reference: null,
                    summary_status_type_id: "3",
                    affect_cash: false,
                    documents: [
                        {
                            document_id: null,
                            description: null
                        }
                    ]
                });
        },
        create() {
            this.$http
                .get(`/documents/record/${this.recordId}`)
                .then(response => {
                    let document = response.data.data;
                    this.group_id = document.group_id;
                    this.form.date_of_reference = document.date_of_issue;
                    this.form.documents[0].document_id = document.id;
                    this.titleDialog = "CPE : " + document.number;
                });
        },
        async submit() {
            this.loading_submit = true;

            const result = await Swal.fire({
                title: "¿Desea afectar la caja correspondiente?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Sí",
                cancelButtonText: "No",
                reverseButtons: true
            });
            if (result.isConfirmed) {
                this.form.affect_cash = true;
            } else {
                this.form.affect_cash = false;
            }
            // Verifica el contenido del form antes de enviar
            console.log('Datos enviados al backend:', this.form);
            this.resource = this.group_id === "01" ? "voided" : "summaries";
            try {
                const response = await this.$http.post(
                    `/${this.resource}`,
                    this.form
                );
                if (response.data.success) {

                    this.$eventHub.$emit("reloadData");
                    this.$toast.success(response.data.message);
                    if (this.external) {
                        this.$emit("getRecords");
                    }
                    this.close();
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.$toast.error(
                        error.response?.data?.message || "Error inesperado"
                    );
                }
            } finally {
                this.loading_submit = false;
            }
        },

        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
