<template>
    <el-dialog
        :visible="showDialog"
        title="Pago"
        @close="closeDialog"
        @open="openDialog"
        append-to-body
    >
        <div class="row">
            <div class="col-md-12"></div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {};
    },
    methods: {
        openDialog() {},
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        submit() {}
    }
};
</script>
