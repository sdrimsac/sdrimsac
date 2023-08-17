<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        title="Previsualización"
        width="350px;"
    >
        <div class="d-flex justify-content-center" v-loading="loading"
        element-loading-text="Cargando..."
        >
            <div class="col-12 text-center">
                 <embed
                                :src="resource"
                                type="application/pdf"
                                width="100%"
                                height="450px"
                            />
            
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button type="primary" @click="download"
            icon="el-icon-download"
            >Descargar</el-button>
            <el-button @click="close">Cerrar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "resource"],
    data() {
        return {
            loading: false
        };
    },
    methods: {
        open() {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 2500);
        },
        download(){
            window.open(this.resource, "_blank");
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
