<template>
    <el-dialog
        width="50%"
        title="Lista de créditos"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
    >   
        <div class="row m-2">
            <div class="col-12">
                <label for="customer">Cliente/Personal</label>
                <el-input
                    v-model="search.value"
                    placeholder="Escriba el nombre o número de documento del cliente"
                    @input="getRecordsTimer"
                ></el-input>

            </div>
        </div>
        <div class="row m-2 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th class="text-end">
                            Pendiente
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <td>
                            {{ customIndex(idx) }}
                        </td>
                        <td>
                            {{ record.customer.name }}
                        </td>
                        <td class="text-end">
                            {{ record.balance }}
                        </td>
                        <td>
                            <!-- <el-tooltip
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
                </el-tooltip> -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="Number(pagination.per_page)"
            >
            </el-pagination>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
        </span>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
export default {
    props: ["showDialog", "amountToAdd"],
    data() {
        return {
            loading: false,
            records: [],
            search: {},
            form: {
                total: 0,
                balance: 0,
                customer_id: null
            },
            pagination: {
                total: 0,
                per_page: 0,
                current_page: 1
            },
            customers: [],
            input_person: {
                number: null
            },
            timer: null
        };
    },
    methods: {
        customIndex(idx) {
            return (
                idx +
                1 +
                (this.pagination.current_page - 1) * this.pagination.per_page
            );
        },
        initForm() {
            this.form = {
                total: 0,
                balance: 0,
                customer_id: null
            };
        },
        getRecordsTimer() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.getRecords();
            }, 500);
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http.get(`/credit-list/records?${queryString.stringify(this.search)}`);

                if (response.status == 200) {
                    this.pagination = response.data.meta;
                    this.records = response.data.data;
                }
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loading = false;
            }
        },
        async submit(id, customer_number) {
            const response = await this.$http.get(
                `/credit-list/get-ordens/${id}`
            );
            const { data } = response;
            this.$emit("paymentsOrden", {
                items: data,
                is_room: true,
                is_list_credit: true,
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
        // changeCustomer(customer_id) {
        //     this.getBalance(customer_id);
        // },

        // async searchRemoteCustomers(input) {
        //     if (input.length > 0) {
        //         // if (input!="") {

        //         this.loading_search = true;
        //         let parameters = `input=${input}`;
        //         const response = await this.$http.get(
        //             `/documents/search/customers?${parameters}`
        //         );
        //         this.customers = response.data.customers;
        //         this.loading_search = false;
        //         this.input_person.number = null;

        //         // if (this.customers.length == 0) {
        //         //     this.filterCustomers();
        //         //     this.input_person.number = input;
        //         // }
        //     }
        // },
        open() {
            this.initForm();
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
