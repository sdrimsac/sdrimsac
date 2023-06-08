<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Registros de actividades</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Registros</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Actividades</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="bookmark">
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Operaciones"
                                placement="bottom-end"
                            >
                                <template v-if="realTime">
                                    <button
                                        @click="getRecords"
                                        class="btn btn-primary btn-icon btn-icon-start"
                                    >
                                        Salir de tiempo real
                                    </button>
                                </template>
                                <template v-else>
                                    <button
                                        @click="realTime = true"
                                        class="btn btn-success btn-icon btn-icon-start"
                                    >
                                        Ver en tiempo real
                                    </button>
                                </template>
                            </el-tooltip>
                        </div>
                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-body container table-responsive col-md-12">
                    <div v-if="!realTime" class="row">
                        <div class="col-md-3">
                            <label>Filtro</label>
                            <el-select
                                v-model="search.column"
                                placeholder="Seleccione el filtro"
                            >
                                <el-option
                                    v-for="(value, key) in columns"
                                    :key="key"
                                    :label="value"
                                    :value="key"
                                >
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <template
                                v-if="search.column == 'event_description'"
                            >
                                <label>
                                    <i class="fa fas-search"></i>
                                </label>
                                <el-select
                                    clearable
                                    filterable
                                    v-model="search.value"
                                    placeholder="Seleccione el evento"
                                >
                                    <el-option
                                        v-for="(value, key) in events"
                                        :key="key"
                                        :label="value"
                                        :value="key"
                                    >
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else-if="search.column == 'model'">
                                <label>
                                    <i class="fa fas-search"></i>
                                </label>
                                <el-select
                                    clearable
                                    filterable
                                    v-model="search.value"
                                    placeholder="Seleccione el evento"
                                >
                                    <el-option
                                        v-for="(value, key) in models"
                                        :key="key"
                                        :label="value"
                                        :value="key"
                                    >
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else-if="search.column == 'user_id'">
                                <label>
                                    <i class="fa fas-search"></i>
                                </label>
                                <el-select
                                    clearable
                                    filterable
                                    v-model="search.value"
                                    placeholder="Seleccione un usuario"
                                >
                                    <el-option
                                        v-for="(value, key) in users"
                                        :key="key"
                                        :label="value.name"
                                        :value="value.id"
                                    >
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else>
                                <label>
                                    <i class="fa fas-search"></i>
                                </label>
                                <el-input v-model="search.value"> </el-input>
                            </template>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <el-button type="primary" @click="getRecords">
                                Buscar
                            </el-button>
                        </div>
                    </div>
                    <div v-if="!realTime">
                        <el-pagination
                            @current-change="getRecords"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                        >
                        </el-pagination>
                    </div>
                    <template v-if="realTime">
                        <table class="table table-hover table-striped table-condensed  table-responsive" style="width: 100%; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Descripción</th>
                                    <th>Detalle</th>
                                    <th>Registro</th>
                                </tr>
                            </thead>

                            <transition-group name="fade" tag="tbody">
                                <tr
                                    class="registers_event"
                                    v-for="record in recordsRealTime"
                                    :key="record.id"
                                    :class="
                                        record.event == 'create'
                                            ? 'bg-success'
                                            : record.event == 'update'
                                            ? 'bg-primary'
                                            : 'bg-danger'
                                    "
                                >
                                    <td>
                                        <h6 class="text-white">
                                            {{ record.time_of_issue }}
                                        </h6>
                                        <h5 class="text-white">
                                            {{ record.date_of_issue }}
                                        </h5>
                                    </td>
                                    <td>
                                        {{ record.user }}
                                        <template v-if="record.ip"><br />
                                            <strong>IP: {{ record.ip }}</strong>
                                        </template>
                                        <template v-if="record.system">
                                            <br />
                                            <strong
                                                >Sistema:
                                                {{ record.system }}</strong
                                            >
                                        </template>
                                    </td>
                                    <td>
                                        {{ record.description }}
                                    </td>
                                    <td>
                                        <div class="detalles-wrap">
                                            <div
                                                :key="key"
                                                class="detalle"
                                                v-for="(value,
                                                key) in record.detail"
                                            >
                                                <strong
                                                    class="h5 text-white"
                                                    style="text-transform: uppercase; font-weight: bold "
                                                    >{{
                                                        translatePros[key]
                                                    }}:</strong
                                                >
                                                <span class="h6 text-white ">
                                                    {{ formatValue(value,key) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ record.event_description }}
                                    </td>
                                </tr>
                            </transition-group>
                        </table>
                    </template>
                    <template v-else>
                        <table class="table table-hover table-striped table-condensed  table-responsive" style="width: 100%; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Descripción</th>
                                    <th>Detalle</th>
                                    <th>Registro</th>
                                </tr>
                            </thead>

                            <tbody class="registers_event">
                                <tr
                                    v-for="(record, index) in records"
                                    :key="index"
                                    :class="
                                        record.event == 'create'
                                            ? 'bg-success'
                                            : record.event == 'update'
                                            ? 'bg-primary'
                                            : 'bg-danger'
                                    "
                                >
                                    <td>
                                        <h6 class="text-white">
                                            {{ record.time_of_issue }}
                                        </h6>
                                        <h5 class="text-white">
                                            {{ record.date_of_issue }}
                                        </h5>
                                    </td>
                                    <td>{{ record.user }}
   <template v-if="record.ip"
                                            ><br />
                                            <strong>IP: {{ record.ip }}</strong>
                                        </template>
                                        <template v-if="record.system">
                                            <br />
                                            <strong
                                                >
                                                Sistema:
                                                {{ record.system }}</strong
                                            >
                                        </template>

                                    </td>
                                    <td>
                                        {{ record.description }}
                                    </td>
                                    <td>
                                        <div class="detalles-wrap">
                                            <div
                                                :key="key"
                                                class="detalle"
                                                v-for="(value,
                                                key) in record.detail"
                                            >
                                                <strong
                                                    v-if="value"
                                                    class="h5 text-white"
                                                    style="text-transform: uppercase; font-weight: bold "
                                                    >{{
                                                        translatePros[key]
                                                    }}:</strong
                                                >
                                                <span class="h6 text-white ">
                                                    {{ formatValue(value,key) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ record.event_description }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.detalles-wrap {
    white-space: nowrap;
}

.detalle {
    display: inline-block;
    margin-right: 10px;
}

.registers_event td {
    color: #fff !important;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
<script>
import { deletable } from "../../mixins/deletable";
import queryString from "query-string";
export default {
    props: ["configuration", "user_type"],
    mixins: [deletable],
    components: {},
    data() {
        return {
            realTime: false,
            loading: false,
            records: [],
            recordsRealTime: [],
            users: [],
            resource: "registers",
            translatePros: {
                number: "Número",
                table: "Zona",
                area: "Área",
                customer: "Cliente",
                ref: "Referencia",
                total: "Total",
                food: "Pedido",
                quantity: "Cantidad",
                price: "Precio",
                observations: "Observaciones",
                method: "Método de pago",
                document: "Documento",
                amount: "Monto",
                description: "Descripción"
            },
            columns: [],
            pagination: {
                current_page: 1,
                per_page: 10,
                total: 0
            },
            search: {
                column: "",
                value: ""
            },
            events: {
                create: "Creación",
                update: "Actualización",
                delete: "Eliminación"
            },
            models: {
                orden: "Orden",
                ordenItem: "Item de orden",
                table: "Mesa",
                document: "Documento",
                saleNote: "Nota de venta",
                box: "Caja"
            }
        };
    },
    created() {
        this.getRecords();
        this.getColumns();
        this.getTables();
    },

    filters: {},
    methods: {
        formatValue(value,propertie) {
            if(propertie == 'price'){
                 if (!isNaN(value)) {
                return parseFloat(value).toFixed(2);
            }
            }
            return value;
        },
        async getTables() {
            try {
                const response = await this.$http.get(
                    `/${this.resource}/tables`
                );
                console.log(response);
                if (response.status === 200) {
                    this.users = response.data.users;
                }
            } catch (e) {
                console.log(e);
            }
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                column: this.search.column
            });
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
                const response = await this.$http.get(
                    `/${this.resource}/columns`
                );
                console.log(response);
                if (response.status === 200) {
                    this.columns = response.data;
                }
            } catch (e) {
                console.log(e);
            }
        },
        async getRecords() {
            this.realTime = false;
            this.recordsRealTime = [];
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/${this.resource}/records?${this.getQueryParameters()}`
                );
                if (response.status === 200) {
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        Echo.channel("register").listen(
            `.register-${this.configuration.socket_channel}`,
            e => {
                console.log("imprimiendo", e);

                this.recordsRealTime.unshift(e.register);
                this.recordsRealTime = this.recordsRealTime.slice(0, 20);
            }
        );
    }
};
</script>
