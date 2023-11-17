<template>
    <el-dialog
        width="50%"
        title="Lista de créditos"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
    >
       <div class="row m-2 table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                Cliente
            </th>
            <th>
                Pendiente
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(record,idx) in records" :key="idx">
            <td>
                {{idx+1}}
            </td>
            <td>
                {{record.customer.name}}
            </td>
            <td>
                {{record.balance}}
            </td>
            <td>
                <el-tooltip
                    class="item"
                    effect="dark"
                    content="Pagar"
                    placement="top"
                >
                  
                    <el-button
                        type="primary"
                        icon="el-icon-check"
                        size="mini"
                        @click="submit(record.customer_id,record.customer.number)"
                    ></el-button>
                </el-tooltip>
            </td>

        </tr>
    </tbody>
</table>
       </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">A cuenta</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "amountToAdd"],
    data() {
        return {
            records:[],
            form: {
                total: 0,
                balance: 0,
                customer_id: null
            },
            customers: [],
            input_person: {
                number: null
            }
        };
    },
    methods: {
        async getRecords(){
            const response = await this.$http.get(`/credit-list/records`);
            
           if(response.status == 200){
                this.records = response.data.data;
           }
        },
    async    submit(id,customer_number) {
            const response = await this.$http.get(`/credit-list/get-ordens/${id}`);
                const {data} = response;
                 this.$emit("paymentsOrden", {
                items: data,
               is_room: true,
               is_list_credit:true,
                customer_number
            });
                this.close();
        },
        async getBalance(customer_id) {
            const response = await this.$http(
                `/credit-list/balance/${customer_id}`
            );
            this.form.balance = response.data;
            this.form.total =
                parseFloat(this.form.balance) + parseFloat(this.amountToAdd);
        },
        changeCustomer(customer_id) {
            this.getBalance(customer_id);
        },

        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {

                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}`
                );
                this.customers = response.data.customers;
                this.loading_search = false;
                this.input_person.number = null;

                // if (this.customers.length == 0) {
                //     this.filterCustomers();
                //     this.input_person.number = input;
                // }
            }
        },
        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
