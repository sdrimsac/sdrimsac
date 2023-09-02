<template>
    <el-dialog
        :visible="showDialog"
        @close="close"
        title="Crear guia de remision"
        @open="open"
        width="80%"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
    >
        <dispatch-create
                :parentId="parentId"
                :parentTable="parentTable"
                :document="document"
                @closeDispatch="close"
                :configuration="configuration"
                :pos="true"

            ></dispatch-create>
    </el-dialog>
</template>

<script>
const DispatchCreate = () =>
    import("../../../../../../../../resources/js/views/dispatches/create.vue");
export default {

    props:['showDialog','type','recordId','configuration'],
    components:{
        DispatchCreate
    },
    data() {
        return {
            parentId: null,
            parentTable:null,
            document:null,
        }
    },
    created(){
        console.log("la conf", this.configuration);
    },

    methods:{
       async getData(){
        let table = this.type == '80' ? 'sale_note' : 'document';
        let id = this.recordId;
        //create_new_info/{table}/{id}
        const response = await this.$http(`/dispatches/create_new_info/${table}/${id}`);
        if(response.status == 200){
            const {data} = response;
            this.parentId = data.parentId;
            this.parentTable = data.parentTable;
            this.document = data.document;
        }

        },
        close(){
            this.$emit('update:showDialog', false)
        },
        async open(){
            await this.getData();
        }
    }
}
</script>
