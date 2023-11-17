<template>
    <el-dialog
        width="50%"
        title="A cuenta"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
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
            <div class="col-lg-4 col-md-4 col-12">
                <label for="account">Cuenta actual</label>
                <el-input disabled v-model="form.balance"></el-input>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <label for="account">A agregar</label>
                <el-input disabled v-model="amountToAdd"></el-input>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <label for="account">Cuenta total</label>
                <el-input disabled v-model="form.total"></el-input>
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
    props: ["showDialog", "amountToAdd"],
    data() {
        return {
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
        submit() {
            this.$emit("sendOrdenToCreditList", this.form.customer_id);
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
        open() {},
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
