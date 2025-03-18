<template>
    <el-dialog  
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="Productos con Garantia"
    close-on-click-modal
    width="50%"
    >
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label>Producto</label>
                    <el-input></el-input>

                </div>
                <div class="col-md-6">
                    <label>Almacen</label>
                    <el-input></el-input>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">DESCRIPCION</th>
                                <th class="text-white">STOCK MINIMO</th>
                                <th class="text-white">STOCK EN ALMACEN</th>
                                <th class="text-white">ALMACEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr v-for="record in warranty" :key="record.id">
                                <td>{{ record.document_number }}</td>
                                <td>{{ record.client }}</td>
                                <td>{{ record.product }}</td>
                                <td>{{ record.series }}</td>
                                <td>{{ record.remaining_warranty }}</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <!-- <div>
                        <el-pagination
                            @current-change="getWarrantyRecords"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                        >
                        </el-pagination>
                    </div> -->
            </div>
        </div>
    </div>

    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            
        }
    },
    methods: {
        open() {
            
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        
       

    },
}
</script>