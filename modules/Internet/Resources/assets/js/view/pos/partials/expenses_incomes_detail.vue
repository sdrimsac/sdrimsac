<template>
    <div v-loading="loading">
        <el-table
            :data="records"
            stripe
            border
            style="width: 100%; margin-bottom: 20px;"
            header-cell-style="background-color: #1e5a85; color: #fff; font-weight: bold;"
            size="medium"
        >
            <el-table-column
            label="#"
            type="index"
            width="50"
            align="center"
            header-align="center"
            />
            <el-table-column
            prop="description"
            label="Detalle/Concepto"
            min-width="200"
            show-overflow-tooltip
            />
            <el-table-column
            prop="date"
            label="Fecha"
            width="120"
            align="center"
            header-align="center"
            />
            <el-table-column
            prop="amount"
            label="Total"
            width="120"
            align="right"
            header-align="center"
            :formatter="row => Number(row.amount).toFixed(2)"
            >
            <template slot-scope="scope">
                <span style="font-weight: bold; color: #1e5a85;">
                {{ Number(scope.row.amount).toFixed(2) }}
                </span>
            </template>
            </el-table-column>
        </el-table>
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
            <el-pagination
            background
            @current-change="getRecords"
            layout="total, sizes, prev, pager, next, jumper"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size.sync="pagination.per_page"
            :page-sizes="[10, 20, 50, 100]"
            style="padding: 10px 0;"
            ></el-pagination>
        </div>
        
            <el-dialog append-to-body :visible.sync="showDetails">
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
