<!-- Mantenimiento hotel -->
<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        width="40%"
        @close="close"
        @open="open"
        append-to-body
    >
        <div class="row m-2" v-loading="loading">
            <div class="col-12">
                <label for="">{{ workerLabel }}</label>
                <el-select
                    v-model="form.worker_id"
                    :placeholder="workerPlaceholder"
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
        <div class="col-md-12 d-flex align-items-center justify-content-end">
            <!-- Botón Cancelar -->
            <el-button
            class="btn-cancel btn-cancel:hover"
            icon="fas fa-times fa-lg"
            @click="close"
            size="small"
            >
            <span>Cancelar</span>
            </el-button>
            <!-- Botón Guardar -->
            <el-button
            class="btn-save btn-save:hover"
            icon="fab fa-whatsapp fa-lg"
            type="primary"
            @click="submit"
            >
            <span>Enviar</span>
            </el-button>
        </div>
        <!-- <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Aceptar</el-button>
        </span> -->
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "type", "tableId", "tableName"],
    data() {
        return {
            loading: false,
            title: "",
            workers: [],
            form: {
                worker_id: null,
                description: null
            }
        };
    },
    computed: {
        workerLabel() {
            return this.type === 'limpieza' ? 'Personal de Limpieza' : 'Técnico de Mantenimiento';
        },
        workerPlaceholder() {
            return this.type === 'limpieza' ? 'Seleccione personal' : 'Seleccione un técnico';
        }
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
            try {
                this.loading = true;
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
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loading = false;
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
