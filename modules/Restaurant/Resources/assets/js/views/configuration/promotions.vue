<template>
    <el-dialog
        title="Promociones"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
    >
        <div class="row mt-2">
            <div class="col-12 text-center">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="addNewRecord"
                    >Nuevo</el-button
                >
            </div>
        </div>

        <div class="row" v-if="records.length > 0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Productos</th>
                        <th>Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id">
                        <td>{{ record.name }}</td>
                        <td>{{ record.description }}</td>
                        <td>
                            <template v-if="record.has_items">
                                <el-tooltip effect="dark" placement="top">
                                    <div slot="content">
                                        <div
                                            v-for="item in record.items"
                                            :key="item.id"
                                        >
                                            {{ item.description }} <br />
                                        </div>
                                    </div>
                                    <el-button icon="el-icon-view" size="mini">
                                        {{ record.items.length }}
                                    </el-button>
                                </el-tooltip>
                            </template>
                        </td>
                        <td>
                            {{ record.due_date && (record.due_date | formatDate) }}
                        </td>
                        <td>
                            <el-button
                                type="primary"
                                icon="el-icon-edit"
                                size="mini"
                                @click="editRecord(record.id)"
                            >
                            </el-button>
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
        <promotions-form
            @getRecords="getRecords"
            :recordId="recordId"
            :showDialog.sync="showAddPromotion"
        >
        </promotions-form>
    </el-dialog>
</template>

<script>
const PromotionsForm = () => import("./promotions_form.vue");
export default {
    props: ["showDialog"],
    components: {
        PromotionsForm
    },
    data() {
        return {
            records: [],
            showAddPromotion: false,
            recordId: null
        };
    },
    methods: {
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
                `/caja/room_services/record/${id}`
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
                `/caja/room_services/records`
            );
            if (response.status == 200) {
                this.records = response.data.records;
            }
        },
        open() {
            this.getRecords();
        }
    }
};
</script>
