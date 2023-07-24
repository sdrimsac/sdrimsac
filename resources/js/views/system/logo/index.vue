<template>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="my-0">Logo de distribuidor</h3>
        </div>
        <div class="card-body">
            <div
                class="d-flex flex-column align-items-center justify-content-center"
            >
                <div class="image-upload-container">
                    <input
                        type="file"
                        ref="upload"
                        @change="beforeUpload"
                        accept="image/png"
                        class="image-upload-input"
                    />
                    <el-button
                        size="small"
                        type="primary"
                        @click="$refs.upload.click()"
                        >Seleccionar imagen</el-button
                    >
                </div>

                <div v-if="imageUrl" class="image-preview">
                    <img :src="imageUrl" alt="Imagen Previsualizada" />
                </div>

                <div>
                    <el-button
                        v-if="logoFile"
                        type="success"
                        native-type="submit"
                        @click.prevent="clickSave"
                        >Guardar</el-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.image-upload-container {
    position: relative;
    overflow: hidden;
    display: inline-block;
}

.image-upload-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

/* Estilo opcional para el botón */
.el-button {
    margin-top: 8px; /* Puedes ajustar el margen según tus necesidades */
}
.image-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
}
.image-preview {
    margin-top: 20px;
    text-align: center;
}
.image-preview img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 6px;
}
</style>
<script>
import { deletable } from "../../../mixins/deletable";

export default {
    mixins: [deletable],
    components: {},
    data() {
        return {
            logoFile: null,
            uploadUrl: "/logos", // Reemplaza esto con la URL real de tu servidor
            imageUrl: null,
            showDialog: false,
            headers: headers_token,
            resource: "certificates",
            recordId: null,
            record: {},
            soap_username: null,
            soap_password: null
        };
    },
    created() {
        this.imageUrl = "/acorn/img/profile/store.png";
    },
    methods: {
        beforeUpload(event) {
            let { files } = event.target;
            let file = files[0];
            if (file.type != "image/png") {
                this.$message.error("Solo se permiten imágenes png.");
                return false;
            }
            this.logoFile = file;
            this.imageUrl = URL.createObjectURL(file);
            const isImage = file.type.startsWith("image/");
            if (!isImage) {
                this.$message.error("Solo se permiten imágenes.");
                return false;
            }
        },
        handleUpload(file) {},

        async clickSave() {
            const formData = new FormData();
            formData.append("file", this.logoFile);

            const response = await this.$http.post("logos", formData);
            if (response.status == 200) {
                this.$toast.success(response.data.message);
                window.location.reload(true);
            } else {
                this.$toast.error(response.data.message);
            }

            console.log(response);
        }
    }
};
</script>
