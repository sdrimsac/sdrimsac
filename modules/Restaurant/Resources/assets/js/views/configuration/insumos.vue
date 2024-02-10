<template>
    <el-dialog
        title="Insumos"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
    >
        <div class="row m-2">
            <div class="col-md-8 col-lg-8 col-12">
                <label class="control-label w-100">Producto </label>
                <el-select
                    class="w-100"
                    v-model="form.item_id"
                    filterable
                    remote
                    popper-class="el-select-customers"
                    clearable
                    placeholder="Nombre o código interno"
                    :remote-method="searchRemoteItems"
                    :loading="loading_search_item"
                >
                    <el-option
                        v-for="option in items"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-4 col-lg-4 col-12 d-flex align-items-center">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="add"
                    >Agregar</el-button
                >
            </div>
        </div>
        <div class="row m-2"></div>
        <div class="row m-2" v-if="records.length > 0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>
                            Factor por días

                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Cada insumo se multiplica por el número de días que fue ocupada la habitación"
                                placement="top"
                            >
                                <i class="el-icon-info"></i>
                            </el-tooltip>
                        </th>
                        <th>
                            Factor por personas

                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Cada insumo se multiplica por el número de personas que se encuentran en la habitación"
                                placement="top"
                            >
                                <i class="el-icon-info"></i>
                            </el-tooltip>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id">
                        <td>{{ record.item.description }}</td>
                        <td class="text-center">
                            <el-checkbox
                                @change="updateRecord(record.id)"
                                v-model="record.days_factor"
                            ></el-checkbox>
                        </td>
                        <td class="text-center">
                            <el-checkbox
                                @change="updateRecord(record.id)"
                                v-model="record.persons_factor"
                            ></el-checkbox>
                        </td>
                        <td>
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                size="mini"
                                @click="deleteRecord(record.id)"
                            >
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    components: {},
    data() {
        return {
            form: {
                item_id: null
            },
            records: [],
            showAddPromotion: false,
            recordId: null,
            items: [],
            timer: null,
            loading_search: false,
            loading_search_item: false
        };
    },
    methods: {
        async searchRemoteItems(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/documents/data-table/items?${parameters}`
                        );

                        this.items = response.data;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        async updateRecord(id) {
            console.log("🚀 ~ file: insumos.vue:147 ~ updateRecord ~ id:", id);
            let insumo = this.records.find(record => record.id == id);
            const response = await this.$http.post(
                `/caja/rooms/insumos/record/update`,
                insumo
            );
            if (response.status == 200) {
                this.$message({
                    message: "Registro actualizado correctamente",
                    type: "success"
                });
            } else {
                this.$message({
                    message: "Ocurrió un error",
                    type: "error"
                });
            }
        },
        async add() {
            try {
                const response = await this.$http.post(
                    `/caja/rooms/insumos`,
                    this.form
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Registro agregado correctamente",
                        type: "success"
                    });
                    this.form = {
                        item_id: null
                    };
                    this.getRecords();
                } else {
                    this.$message({
                        message: "Ocurrió un error",
                        type: "error"
                    });
                }
            } catch (e) {
                this.$message({
                    message: "Ocurrió un error",
                    type: "error"
                });
            }
        },
        editRecord(id) {
            this.recordId = id;
            this.showAddPromotion = true;
        },
        async deleteRecord(id) {
            await this.$confirm(
                "¿Está seguro que desea eliminar este registro?",
                "Advertencia",
                {
                    confirmButtonText: "Sí",
                    cancelButtonText: "No",
                    type: "warning"
                }
            );
            const response = await this.$http.delete(
                `/caja/rooms/insumos/record/${id}`
            );
            if (response.status == 200) {
                this.$message({
                    message: "Registro eliminado correctamente",
                    type: "success"
                });
                this.getRecords();
            }
        },
        addNewRecord() {
            this.recordId = null;
            this.showAddPromotion = true;
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async getRecords() {
            const response = await this.$http.get(
                `/caja/rooms/insumos/records`
            );
            if (response.status == 200) {
                this.records = response.data.data;
            }
        },
        open() {
            this.getRecords();
        }
    }
};
</script>
