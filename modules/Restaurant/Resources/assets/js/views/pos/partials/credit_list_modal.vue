<template>
    <el-dialog
        width="50%"
        title="A cuenta"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
    >
        <div class="row m-2">
            <div class="col-12">
                <label for="customer">Cliente/Personal</label>
                <el-select
                    ref="cliente"
                    v-model="form.customer_id"
                    filterable
                    remote
                    popper-class="el-select-customers"
                    dusk="customer_id"
                    placeholder="Escriba el nombre o número de documento del cliente"
                    :remote-method="searchRemoteCustomers"
                    @change="changeCustomer"
                >
                    <el-option
                        v-for="option in customers"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <label for="account">Cuenta actual</label>
                <el-input readonly v-model="form.balance"></el-input>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <label for="account">A agregar</label>
                <el-input readonly v-model="amountToAdd"></el-input>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <label for="account">Cuenta total</label>
                <el-input readonly v-model="form.total"></el-input>
            </div>
            <div class="col-lg-3 col-md-3 col-12" v-if="form.has_credit_line">
                <label for="account">Limite de crédito</label>
                <el-input readonly v-model="form.credit_line"></el-input>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">A cuenta</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "amountToAdd","cashId"],
    data() {
        return {
            loading: false,
            form: {
                total: 0,
                balance: 0,
                customer_id: null,
                credit_line: 0,
                has_credit_line: false
            },
            customers: [],
            input_person: {
                number: null
            }
        };
    },
    methods: {
        submit() {
            let { has_credit_line, credit_line, total } = this.form;
            if (has_credit_line && credit_line < total) {
                this.$toast.error(
                    "El cliente/personal no tiene suficiente crédito para realizar esta operación"
                );
                return;
            }
            this.$emit("sendOrdenToCreditList", this.form.customer_id);
            this.close();
        },
        async getBalance(customer_id) {
            try{
            this.loading = true;
             const response = await this.$http(
                `/credit-list/balance/${customer_id}`
            );
            this.form.balance = response.data;
            this.form.total =
                parseFloat(this.form.balance) + parseFloat(this.amountToAdd);
            }catch(e){
                this.$toast.error(e.message);
            }finally{
                this.loading = false;
            }
        },
        async changeCustomer(customer_id) {
            let customer = this.customers.find(
                customer => customer.id == customer_id
            );
            this.form.credit_line = customer.credit_line;
            this.form.has_credit_line = customer.has_credit_line;
           await this.getBalance(customer_id);
        },

        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {

                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}&credit_list=1`
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
        initForm() {
            this.form = {
                total: 0,
                balance: 0,
                customer_id: null,
                credit_line: 0,
                has_credit_line: false
            };
        },
        open() {
            this.initForm();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
