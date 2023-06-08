<template>
    <div v-loading="loading">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Motivo
                    </th>
                    <th>Detalle</th>
                    <th>Fecha</th>
                    <th>
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, idx) in records" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>{{ data.description }}</td>
                    <td>
                        <template v-if="data.items.length != 0">
                            <el-button @click="seeDetail(data.items)">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Ver
                            </el-button>
                        </template>
                    </td>
                    <td>{{ data.date }}</td>
                    <td>{{ data.amount }} <br /></td>
                </tr>
            </tbody>
        </table>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        ></el-pagination>
        <el-dialog 
            append-to-body
            :visible.sync="showDetails">
                <div class="p-5">
            <table class="table">
                                <thead>
                                    <tr>
                                        <th>DESCP.</th>
                                        <th>CANT.</th>
                                        <th>PRECIO UNIT</th>
                                        <th>PRECIO ADICIONAL</th>
                                        <th>PRECIO TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(dt, idx) in currentItems" :key="idx">
                                        <td>{{ dt.detail }}</td>
                                        <td>
                                            {{ dt.quantity.toFixed(2) }}
                                            {{ dt.unit_id }}
                                        </td>
                                        <td>{{ dt.price.toFixed(2) }}</td>
                                        <td>{{ dt.extra_price.toFixed(2) }}</td>
                                        <td>
                                            {{
                                                (
                                                    dt.price * dt.quantity +
                                                    dt.extra_price
                                                ).toFixed(2)
                                            }}
                                        </td>
                                    
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
            </div>
        </el-dialog>
    </div>
</template>

<script>
export default {
    components: {},
    props: ["records", "pagination", "type", "company"],
    data() {
        return {
            loading: false,
            showWhatsappModal: false,
            currentId: null,
            currentType: null,
            currentNumber: null,
            currentItems: [],
            showDetails: false
        };
    },
    methods: {
        seeDetail(items) {
            this.currentItems = items;
            this.showDetails = true;
        },
        getRecords() {
            this.$emit("getRecords", this.pagination.current_page);
        }
    }
};
</script>
