<template>
    <div class=" card d-flex flex-column align-items-center m-2 ">
        <span>{{ item.description }}</span>
        <template v-if="item.image == 'imagen-no-disponible.jpg'">
            <img
                src="/images/imagen-no-disponible.jpg"
                alt="User Img"
                style="width:150px;height:150px;"
            />
        </template>
        <template v-else>
            <img
                :src="formatUrlImage(item.image)"
                style="width:150px;height:150px;"
            />
        </template>

        <div class="d-flex justify-content-end">
            <el-button
                type="danger"
                icon="el-icon-delete"
                circle
                @click="deleteToll(item.tollId,item.description)"
            ></el-button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["item", "tollId"],
    data() {
        return {};
    },
    methods: {
        deleteToll(id,description) {
            this.$confirm(
                `¿Está seguro de eliminar esta categoria: ${description} ?`,
                "Advertencia",
                {
                    confirmButtonText: "Sí",
                    cancelButtonText: "No",
                    type: "warning"
                }
            )
                .then(() => {
                    this.$http
                        .get(`/toll/delete/${id}`)
                        .then(() => {
                            this.$message({
                                type: "success",
                                message: "Categoria eliminada con éxito"
                            });
                            this.$emit("reloadData");
                        })
                        .catch(() => {});
                })
                .catch(() => {});
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        }
    }
};
</script>
