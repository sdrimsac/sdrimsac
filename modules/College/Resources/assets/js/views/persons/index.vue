<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Lista de padres e hijos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de padres e hijos</span
                                >
                            </li>
                        </ol>
                    </div>
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <!-- Contact Button Start -->
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                        <!-- Contact Button End -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card" v-loading="loading">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Lista de padres e hijos</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="row ">
                            <div class="col-md-12 col-lg-12 col-xl-12 ">
                                <div class="row" v-if="applyFilter">
                                    <div
                                        class="col-lg-4 col-md-4 col-sm-12 pb-2"
                                    >
                                        <div class="d-flex">
                                            <div style="width:100px">
                                                Filtrar por:
                                            </div>
                                            <el-select
                                                v-model="search.column"
                                                placeholder="Select"
                                                @change="changeClearInput"
                                            >
                                                <el-option
                                                    v-for="(label,
                                                    key) in columns"
                                                    :key="key"
                                                    :value="key"
                                                    :label="label"
                                                ></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-3 col-md-4 col-sm-12 pb-2"
                                    >
                                        <template
                                            v-if="
                                                search.column ==
                                                    'date_of_issue' ||
                                                    search.column ==
                                                        'date_of_due' ||
                                                    search.column ==
                                                        'date_of_payment' ||
                                                    search.column ==
                                                        'delivery_date' ||
                                                    search.column == 'date'
                                            "
                                        >
                                            <template
                                                v-if="
                                                    resource !=
                                                        'caja/worker/expenses'
                                                "
                                            >
                                                <el-date-picker
                                                    v-model="search.value"
                                                    type="date"
                                                    style="width: 100%;"
                                                    placeholder="Buscar"
                                                    value-format="yyyy-MM-dd"
                                                    @change="getRecords"
                                                >
                                                </el-date-picker>
                                            </template>
                                            <template v-else>
                                                <el-date-picker
                                                    v-model="search.value"
                                                    type="daterange"
                                                    range-separator="A"
                                                    start-placeholder="Desde"
                                                    value-format="yyyy-MM-dd"
                                                    end-placeholder="Hasta"
                                                    @change="getRecords"
                                                >
                                                </el-date-picker>
                                            </template>
                                        </template>

                                        <template v-else>
                                            <el-input
                                                placeholder="Buscar"
                                                v-model="search.value"
                                                style="width: 100%;"
                                                prefix-icon="el-icon-search"
                                                @input="filterRecords"
                                            >
                                            </el-input>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Documento</th>
                                                <th>N° Hijos</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row, index) in records"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ customIndex(index) }}
                                                </td>
                                                <td>{{ row.parent.name }}</td>
                                                <td>{{ row.parent.number }}</td>
                                                <td>
                                                    <el-button
                                                        @click="
                                                            viewChildren(row.id)
                                                        "
                                                        icon="el-icon-search"
                                                    >
                                                        {{
                                                            row.children.length
                                                        }}
                                                    </el-button>
                                                </td>
                                                <td>
                                                    <el-button
                                                        @click="
                                                            clickCreate(row.id)
                                                        "
                                                        type="primary"
                                                    >
                                                        Editar
                                                    </el-button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <el-pagination
                                            @current-change="getRecords(true)"
                                            layout="total, prev, pager, next"
                                            :total="pagination.total"
                                            :current-page.sync="
                                                pagination.current_page
                                            "
                                            :page-size="pagination.per_page"
                                        >
                                        </el-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <create-form
            @memberCreated="getRecords"
            :recordId="recordId"
            :showDialog.sync="showCreateForm"
        >
        </create-form>
        <children-view
            :showDialog.sync="showViewChildren"
            :parentId="parentIdChildrenView"
        >
        </children-view>
    </div>
</template>

<script>
const CreateForm = () => import("./form.vue");
const ChildrenView = () => import("./children_view.vue");
import queryString from "query-string";
export default {
    components: { CreateForm, ChildrenView },
    data() {
        return {
            resource: "college",
            pagination: {},
            records: [],
            applyFilter: true,
            search: {
                column: "description"
            },
            columns: [],
            loading: false,
            showCreateForm: false,
            showViewChildren: false,
            parentIdChildrenView: null,
            timer: null,
            recordId: null
        };
    },
    async created() {
        this.getColumns();
        this.getRecords();
    },
    methods: {
             getQueryParameters() {
        
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                column: this.search.column
            });
        },
        viewChildren(id) {
            this.parentIdChildrenView = id;
            this.showViewChildren = true;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getColumns() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/persons/columns`
                );
                this.columns = response.data;
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
           async filterRecords(){
                this.getRecords();
        },
        async getRecords(pagination = false) {
            if (this.timer) {
                clearTimeout(this.timer);
            }
                 let ms = pagination ? 0 : 450;
            this.timer = setTimeout(async () => {
                try {
                    this.loading = true;
                         const response = await this.$http(
                        `/${this.resource}/persons/records?${
                            this.getQueryParameters()
                        }`
                    );
              
                    let { data, meta } = response.data;
                    this.records = data;
                    this.pagination = meta;
                } catch (e) {
                    console.log(e);
                } finally {
                    this.loading = false;
                }
            }, ms);
        },
        changeClearInput() {},
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showCreateForm = true;
        }
    }
};
</script>
