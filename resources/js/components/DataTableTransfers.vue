<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                        <div class="d-flex">
                            <div style="width:100px">Filtrar por:</div>
                            <el-select
                                v-model="search.column"
                                placeholder="Select"
                                @change="changeClearInput"
                            >
                                <el-option
                                    v-for="(label, key) in columns"
                                    :key="key"
                                    :value="key"
                                    :label="label"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                        <template v-if="search.column == 'created_at'">
                            <el-date-picker
                                v-model="search.value"
                                type="date"
                                style="width: 100%;"
                                placeholder="Buscar"
                                value-format="yyyy-MM-dd"
                                @change="getRecords"
                            ></el-date-picker>
                        </template>
                        <template
                            v-if="
                                search.column == 'code' ||
                                    search.column == 'serie' ||
                                    search.column == 'lote' ||
                                    search.column == 'description'
                            "
                        >
                            <el-input
                                v-model="search.value"
                                style="width: 100%;"
                                placeholder="Buscar "
                                @input="getRecords"
                            ></el-input>
                        </template>
                        <template
                            v-if="
                                search.column == 'warehouse_id' ||
                                    search.column == 'warehouse_id_destination'
                            "
                        >
                            <el-select
                                v-model="search.value"
                                style="width: 100%;"
                                @change="getRecords"
                            >
                                <el-option
                                    v-for="w in warehouses"
                                    :key="w.id"
                                    :value="w.id"
                                    :label="w.description"
                                >
                                </el-option>
                            </el-select>
                        </template>
                        <template v-if="search.column == 'status'">
                            <el-select
                                v-model="search.value"
                                style="width: 100%;"
                                @change="getRecords"
                            >
                                <el-option
                                    v-for="w in states"
                                    :key="w.id"
                                    :value="w.id"
                                    :label="w.description"
                                >
                                </el-option>
                            </el-select>
                        </template>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody>
                            <slot
                                v-for="(row, index) in records"
                                :row="row"
                                :index="customIndex(index)"
                            ></slot>
                        </tbody>
                    </table>
                    <div>
                        <el-pagination
                            @current-change="getRecords"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                        ></el-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";

export default {
    props: {
        resource: String
    },
    data() {
        return {
            search: {
                column: null,
                value: null
            },
            states: [
                { id: 1, description: "Enviado" },
                { id: 2, description: "Aceptado" }
            ],
            columns: [],
            records: [],
            pagination: {},
            warehouses: [],
            time: null
        };
    },
    computed: {},
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        // console.log(this.resource);
        // let column_resource = _.split(this.resource, "/");

        await this.$http
            // .get(`/${_.head(column_resource)}/columns`)
            .get(`/${this.resource}/columns`)
            .then(response => {
                this.columns = response.data;
                this.search.column = _.head(Object.keys(this.columns));
            });

        await this.$http
            // .get(`/${_.head(column_resource)}/columns`)
            .get(`/${this.resource}/tables`)
            .then(response => {
                this.warehouses = response.data.warehouses;
                // this.search.column = _.head(Object.keys(this.columns));
            });
        await this.getRecords();
    },
    methods: {
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }

            this.time = setTimeout(async () => {
                const response = await this.$http.get(
                    `/${this.resource}/records?${this.getQueryParameters()}`
                );

                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            }, 500);
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
