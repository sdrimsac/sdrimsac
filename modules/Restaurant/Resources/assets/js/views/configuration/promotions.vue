<template>
    <el-dialog
        title="Promociones Hotelería"
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        class="rounded-dialog"
        width="70%"
    >
        <div class="row mt-1 mb-1">
            <div class="col-12 d-flex justify-content-end">
                <el-button
                    class="btn_guardarsmall"
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="addNewRecord"
                >
                    Nuevo
                </el-button>
            </div>
        </div>

        <div class="row" v-if="records.length > 0">
            <div class="card body" style="padding: 8px;">
                <table class="table">
                <thead style="background-color: #073f68; color: #fff;">
                    <tr>
                        <th style="color: #fff;">Nombre</th>
                        <th style="color: #fff;">Descripción</th>
                        <th style="color: #fff;">Productos</th>
                        <th style="color: #fff;">Vencimiento</th>
                        <th style="color: #fff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
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
                            {{ record.due_time }}
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
            
        </div>
        <promotions-form
            @getRecords="getRecords"
            :recordId="recordId"
            :showDialog.sync="showAddPromotion"
        >
        </promotions-form>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px; 
    overflow: hidden; 
  }
</style>

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
