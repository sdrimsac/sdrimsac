<template>
    <el-dialog
        :visible.sync="localVisible"
        :close-on-click-modal="false"
        width="30%"
        @close="close"
        :title="item && item.description ? item.description.toUpperCase() : 'Producto'"
    >
        <div class="card bg-white">
            <div v-if="item && item.image" class="text-center">
                <img
                    :src="formattedImageUrl"
                    class="img-fluid"
                    style="max-height: 500px;"
                />
            </div>
            <div v-else class="text-center">
                <img
                    src="/images/imagen-no-disponible.jpg"
                    class="img-fluid"
                    style="max-height: 500px;"
                />
                <p class="mt-3">
                    No hay imágenes disponibles para este producto
                </p>
            </div>
        </div>
        <div class="text-right">
            <el-button
            type="primary"
            @click="close()"
            class="mt-3"
            round
            size="small"
            >
            Cerrar
            </el-button>
        </div>
    </el-dialog>
</template>

<script>
import { method } from 'lodash';

export default {
    props: {
        showDialog: {
            type: Boolean,
            default: false
        },
        item: {
            type: Object,
            default: () => ({})
        },
        config: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            localVisible: this.showDialog
        };
    },
    watch: {
        showDialog(newVal) {
            this.localVisible = newVal;
        },
        localVisible(newVal) {
            if (newVal !== this.showDialog) {
                this.$emit('update:showDialog', newVal);
                this.closeDialog();
            }
        }
    },
    computed: {
        formattedImageUrl() {
            if (
                !this.item ||
                !this.item.image ||
                this.item.image === "imagen-no-disponible.jpg"
            ) {
                return "/images/imagen-no-disponible.jpg";
            }
            return `/storage/uploads/items/${this.item.image}`;
        }
    },
    methods: {
        close() {
      this.$emit("update:showDialog", false);
    },
    }
};
</script>

<style scoped>
.el-dialog__body {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
