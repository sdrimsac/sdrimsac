<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible.sync="showDialog"
        title="Citas Medicas"
        width="90%"
    >
        <div class="card">
            <div class="row">
                <div class="col-md-4">
                    <label>Fecha</label>
                    <el-input placeholder="fecha"></el-input>
                </div>
                <div class="col-md-4">
                    <label>Especialidad</label>
                    <el-input placeholder="fecha"></el-input>
                </div>
                <div class="col-md-4">
                    <label>Medico</label>
                    <el-input placeholder="fecha"></el-input>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="row">
                <div class="col-md-4">
                    <label>Fecha</label>
                    <el-input placeholder="fecha"></el-input>
                </div>
                <div class="col-md-4">
                    <label>Especialidad</label>
                    <el-input placeholder="fecha"></el-input>
                </div>
                <div class="col-md-4">
                    <label>Medico</label>
                    <el-input placeholder="fecha"></el-input>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog", "recordId"],
    data() {
        return {};
    },
    methods: {
        open() {},
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
