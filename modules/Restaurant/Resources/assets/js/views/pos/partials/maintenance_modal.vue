<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        width="30%"
        @close="close"
        @open="open"
        append-to-body
    >
        <div class="row m-2">
            <div class="col-12">
                <label for="">Trabajador</label>
                <el-select
                    v-model="form.worker_id"
                    placeholder="Seleccione un trabajador"
                >
                    <el-option
                        v-for="worker in workers"
                        :key="worker.id"
                        :label="worker.name"
                        :value="worker.id"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-12">
                <label for=""
                    >Descripción
                    <el-tooltip
                        class="item"
                        effect="dark"
                        content="Descripción del mantenimiento, se enviará por el whatsapp"
                        placement="top"
                    >
                        <i class="el-icon-info"></i>
                    </el-tooltip>
                </label>
                <el-input
                    v-model="form.description"
                    type="textarea"
                    placeholder="Descripción"
                ></el-input>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Aceptar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "type", "tableId", "tableName"],
    data() {
        return {
            title: "",
            workers: [],
            form: {
                worker_id: null,
                description: null
            }
        };
    },
    methods: {
        async getWorkers() {
            const response = await this.$http(
                `/caja/maintenance/workers?type=${this.type}`
            );
            const { data } = response;
            const { records } = data;
            this.workers = records;
        },
        async submit() {
            const response = await this.$http.post(
                `/caja/maintenance`,
                this.form
            );
            if (response.data.success) {
                this.$toast.success(response.data.message);
                this.$emit("getTables");
                this.close();
            } else {
                this.$toast.error(response.data.message);
            }
        },
        initForm() {
            this.form = {
                table_id: this.tableId,
                worker_id: null,
                description: null,
                type: this.type
            };
        },
        open() {
            this.title = this.type.toUpperCase() + " - " + this.tableName;
            this.initForm();
            this.getWorkers();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
