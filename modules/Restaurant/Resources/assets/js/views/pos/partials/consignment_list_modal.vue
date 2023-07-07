<template>

    <el-dialog
    v-loading="loading"
    @open="open"
    @close="close"
    :visible="showDialog"
    title="Lista de Consignaciones"
    >
    <div class="row mt-2"></div>
    <div class="row mt-2">
        <table class="table table-responsive table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha de consignación</th>
                    <th>Fecha de liquidación</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(consignment,idx) in records" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>{{ consignment.person.name }}</td>
                    <td>{{ consignment.date_of_issue }}</td>
                    <td>{{ consignment.date_of_end }}</td>
                    <td>
                        <el-button
                            type="primary"
                            icon="el-icon-search"
                            @click="clickShowProducts(consignment)"
                        >{{consignment.stock}}</el-button>
                    </td>
                    <td>{{ consignment.total }}</td>
                    <td>
                        <el-button
                        @click="clickLiquidate(consignment)"
                        type="success"
                        >
                            <i class="el-icon-cash"></i>
                            Liquidar
                        </el-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <items-modal
        :showDialog.sync="showDialogItems"
        :recordId="recordId"
        >

        </items-modal>
    </div>
    </el-dialog>
</template>

<script>
const ItemsModal = () => import("../../../../../../../Consignment/Resources/assets/js/views/partials/items.vue");
export default {
    props:["showDialog"],
    components:{
        ItemsModal
    },
    data(){
        return {
            loading: false,
            showDialogItems: false,
            recordId: null,
            form: {},
            records: [],
            loading_search: false,
            resource:"/consignment",
            pagination:{},
        };
    },
    methods:{
       async clickLiquidate(consignment){

        const response = await this.$http(`${this.resource}/liquidate/${consignment.id}`);
        let {foods } = response.data;
        foods = foods.map(food => {
            food.toWarehouse = 0;
            return food;
        });
        this.$emit('setItemsToLiquidate',foods,consignment)
        this.close();
            
        },
        clickShowProducts(consignment){
            this.recordId = consignment.id;
            this.showDialogItems = true;
        
        },
        async getRecords(){
            try{
                this.loading = true;
                const response = await this.$http(`${this.resource}/records`);
                console.log(response);
                this.records = response.data.data;
            }catch(e){
                this.$toast.error(e.message);
            }finally{
                this.loading = false;
            }
        },
        open(){
            this.getRecords();
        },
        close(){
            this.$emit('update:showDialog', false);
        },
    }
}
</script>