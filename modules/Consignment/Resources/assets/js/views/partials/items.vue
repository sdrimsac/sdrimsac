<template>
    <el-dialog :visible="showDialog" title="Productos" append-to-body
    @open="open"
    @close="close"
    >
        
        <div class="row">
            <table class="table table-responsive table-stripe">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                    v-for="(item,index) in items"
                    :key="index"
                    >

                        <td>{{index+1}}</td>
                        <td>{{item.name}}
                            <template v-if="item.has_lots">
                                <br>
                                <small>
                                    <a href="#">
                                        Ver series
                                    </a>
                                </small>
                            </template>
                        </td>
                        <td>{{item.quantity}}</td>
                        <td>{{item.price}}</td>
                        <td>{{item.total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog","recordId"],
    data() {
        return {
            form:{},
            items:[]
        };
    },
    methods: {
        async getItems(){
            const response = await this.$http(`/consignment/items/${this.recordId}`);
            if(response.status == 200){
                this.items = response.data.items;
            }
        },
        open() {
            this.getItems();
            console.log("open");
        },
        close() {
            console.log("close");
        }
    }
};
</script>
