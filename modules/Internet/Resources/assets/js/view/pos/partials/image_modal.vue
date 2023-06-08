<template>
    <el-dialog
        append-to-body
        @open="open"
        @close="close"
        :visible="showDialog"
        v-loading="loading"
        title="Imagen de la casa"
    >
        <div
            class=" d-flex flex-column justify-content-center align-items-center"
        >
            <div
                v-if="imageSaved"
                class="col-12 mb-2 d-flex  justify-content-center "
                style="max-width:350px"
            >
                <img :src="imageSaved" alt="imagen" class="img-thumbnail" />
            </div>
            <div v-else>
                <el-empty :image-size="350"></el-empty>
            </div>
            <el-button class="m-2" type="success" @click="$refs.file.click()">
                Subir imagen
            </el-button>
            <p><em>JPG, PNG, JPEG </em></p>
            <input
                accept="image/png, image/jpeg, image/jpg"
                type="file"
                @change="changeImage"
                ref="file"
                style="display: none"
            />
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "record"],
    data() {
        return {
            loading: false,
            imageSaved: null
        };
    },
    methods: {
        open() {
            this.imageSaved = this.record.house_photo;
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async changeImage() {
            let files = this.$refs.file.files;
            if (files.length > 0) {
                let file = files[0];
                try {
                    let reader = new FileReader();

                    reader.onload = async e => {
                        let base64Image = e.target.result;
                        this.loading = true;
                        try {
                            const response = await this.$http.post(
                                "/internet/image",
                                { image: base64Image, id: this.record.id }
                            );
                            this.$emit("getRecords");
                            this.$toast.success("Imagen actualizada");
                            const {
                                data: { image }
                            } = response;
                            this.imageSaved = image;
                            this.loading = false;
                        } catch (e) {
                            const {
                                data: { message }
                            } = e.response;
                            this.$toast.error(message);
                            this.loading = false;
                        }
                    };

                    reader.readAsDataURL(file);
                } catch (e) {
                    console.log(e);
                }
            }
        }
    }
};
</script>
