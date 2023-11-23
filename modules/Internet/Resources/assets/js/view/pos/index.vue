<template>
    <div>
        <div
            v-loading.fullscreen="loading"
            element-loading-text="Espere..."
            class="row "
        >
            <div
                class="d-flex flex-md-row flex-column-reverse justify-content-start card mb-2"
            >
                <div class="col-sm-12 col-md-5 col-xl-7 col-xxl-7">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="d-flex flex-wrap ">
                                <div
                                    v-for="(option, idx) in optionsMenu"
                                    :key="idx"
                                    v-show="option.visible"
                                >
                                    <div
                                        v-if="option.visible && option.id != 8"
                                        @click.prevent="
                                            trigerFunction(option.id)
                                        "
                                        class="
                                        buttons_
                                        btn btn-light
                                        m-1
                                        rounded
                                        d-flex
                                        flex-column
                                        align-items-center
                                        justify-content-center
                                        "
                                    >
                                        <div
                                            class="text-center"
                                            style="margin-bottom: 2px"
                                        >
                                            <p
                                                style="margin: 0 !important; padding: 0 !important"
                                                v-for="(title,
                                                idx2) in option.title"
                                                :key="idx2"
                                            >
                                                <span class="buttons_text_">{{
                                                    title
                                                }}</span>
                                            </p>
                                        </div>
                                        <div>
                                            <i :class="option.icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex row align-items-center">
                                <div class="col-12 col-md-4 p-2">
                                    <h2 class="text-muted text-small">
                                        Buscar
                                    </h2>
                                    <template>
                                        <el-input
                                            ref="input_items"
                                            size="small"
                                            v-model="input_item"
                                            @input="search()"
                                            @focus="clear_input()"
                                            autofocus
                                        >
                                        </el-input>
                                    </template>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <template>
                                        <h2 class="text-muted text-small">
                                            Categorias
                                        </h2>
                                        <el-select
                                            v-model="category"
                                            filterable
                                            clearable
                                            placeholder="Selecionar aqui...."
                                            @change="search_register"
                                        >
                                            <el-option
                                                v-for="(item,
                                                idx) in categories"
                                                :key="idx"
                                                :label="item.name"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </template>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <el-button
                                        type="success"
                                        plain
                                        icon="fas fa-file-excel"
                                        @click="exportRegister('excel')"
                                    ></el-button>
                                    <el-button
                                        type="danger"
                                        plain
                                        icon="far fa-file-pdf"
                                        @click="exportRegister('pdf')"
                                        class="text-white"
                                    ></el-button>
                                    <el-button
                                        @click="openWhatsapp"
                                        type="default"
                                        plain
                                        icon="fab fa-whatsapp"
                                    ></el-button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Fecha de pago</th>
                                        <th class="d-none d-sm-table-cell">
                                            Código
                                        </th>
                                        <th>Plan</th>

                                        <th>Mensualidad</th>
                                        <th>Deuda</th>
                                        <th v-if="category == 2">Suspensión</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(record, idx) in records"
                                        :key="idx"
                                    >
                                        <td>{{ customIndex(idx) }}</td>
                                        <td
                                            :class="
                                                `${
                                                    record.active
                                                        ? ''
                                                        : 'text-danger'
                                                }`
                                            "
                                        >
                                            {{ record.person.name }}
                                            <br />
                                            <small class="text-muted">{{
                                                record.person.number
                                            }}</small>
                                        </td>
                                        <td>
                                            {{ record.date }}
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{ record.identifier }}
                                        </td>
                                        <td>{{ record.plan.capacity }}</td>

                                        <td>
                                            {{ record.total.toFixed(2) }}
                                        </td>

                                        <td>
                                            <template
                                                v-if="
                                                    record.last_payment &&
                                                        record.last_payment
                                                            .state ==
                                                            'incomplete'
                                                "
                                            >
                                                <span class="text-danger">
                                                    {{
                                                        record.last_payment.rest
                                                    }}
                                                </span>
                                            </template>
                                        </td>
                                        <td v-if="category == 2">
                                            <small>
                                                {{
                                                    record.suspension_description ||
                                                        "-"
                                                }}
                                            </small>
                                        </td>
                                        <td class="text-end">
                                            <div
                                                class="btn-toolbar mb-2"
                                                role="toolbar"
                                            >
                                                <div class="btn-group mb-1">
                                                    <button
                                                        class="btn btn-secondary btn-sm dropdown-toggle"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                    >
                                                        <i
                                                            class="fas fa-ellipsis-v"
                                                        ></i>
                                                    </button>
                                                    <div
                                                        class="dropdown-menu dropdown-menu-sm"
                                                    >
                                                        <a
                                                            v-if="record.active"
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                contractGenere(
                                                                    record.id
                                                                )
                                                            "
                                                            ><i
                                                                class="fas fa-file-contract"
                                                            ></i>
                                                            Generar contrato
                                                        </a>
                                                        <a
                                                            v-if="record.active"
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                updateData(
                                                                    record
                                                                )
                                                            "
                                                            ><i
                                                                class="fas fa-file-contract"
                                                            ></i>
                                                            Actualizar datos
                                                        </a>
                                                        <a
                                                            v-if="record.active"
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                openPaymentMonth(
                                                                    record.id,
                                                                    true
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-file-excel"
                                                            ></i>
                                                            Cambiar plan
                                                        </a>
                                                        <a
                                                            v-if="record.active"
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                openPaymentMonth(
                                                                    record.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-file-excel"
                                                            ></i>
                                                            Pagar mensualidad
                                                        </a>
                                                        <a
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                openImage(
                                                                    record
                                                                )
                                                            "
                                                            ><i
                                                                class="fas fa-image"
                                                            ></i>
                                                            Ver Imagen
                                                        </a>
                                                        <a
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                openPayments(
                                                                    record.id,
                                                                    record.person
                                                                )
                                                            "
                                                            ><i
                                                                class="fas fa-print"
                                                            ></i>
                                                            Ver Pagos
                                                        </a>
                                                        <a
                                                            href="!#"
                                                            class="dropdown-item"
                                                            @click.prevent="
                                                                updateService(
                                                                    record
                                                                )
                                                            "
                                                            ><i
                                                                class="fas fa-trash"
                                                            ></i>
                                                            {{
                                                                record.active
                                                                    ? "Suspender servicio"
                                                                    : "Activar servicio"
                                                            }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <el-pagination
                                @current-change="
                                    getRecords(
                                        `page=${pagination.current_page}`
                                    )
                                "
                                layout="total, prev, pager, next"
                                :total="pagination.total"
                                :current-page.sync="pagination.current_page"
                                :page-size="pagination.per_page"
                            >
                            </el-pagination>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-xl-5">
                    <div class="card-body p-2">
                        <register-form
                            @getRecords="getRecords"
                            :series="all_series"
                            :company.sync="company"
                            :customer_variation="customer_variation"
                            :variationShow.sync="variation"
                            :establishments="establishments"
                            :itemDefault.sync="itemDefault"
                            :cash_id.sync="cashId"
                            :ordenId.sync="ordenId"
                            :ordensPending.sync="ordensPending"
                            :area_id="area_id"
                            :isCreatingOrden.sync="isCreatingOrden"
                            :blockCart.sync="blockCart"
                            :total2.sync="form.total"
                            :configuration.sync="configuration"
                            :localOrden.sync="localOrden"
                            :ordens.sync="ordensItems"
                            @total_sales="total_sales"
                            @updateOrdens="updateOrdens"
                            @paymentsOrden="paymentsOrden"
                            @deletedFood="deletedFood"
                            @cancelOrden="cancelOrden"
                            @ordenDeleted="createOrden"
                            :identityDocuments.sync="documentsType"
                            :clientTableData.sync="clientTableData"
                        ></register-form>
                    </div>
                </div>
            </div>
        </div>
        <DrawerOrdens
            ref="ordenRef"
            :configuration.sync="configuration"
            :localOrden.sync="localOrden"
            :ordens.sync="ordensItems"
            @total_sales="total_sales"
            @updateOrdens="updateOrdens"
            @paymentsOrden="paymentsOrden"
            @deletedFood="deletedFood"
            @ordenDeleted="createOrden"
        >
        </DrawerOrdens>

        <template>
            <payment-internet
                :updatePlan.sync="updatePlan"
                :all_series="all_series"
                :paymentItems="paymentItems"
                :is_payment.sync="is_payment"
                :registerInternetId="registerId"
                :isReconnection="isReconnection"
                @getRegisters="getRecords"
            >
            </payment-internet>
        </template>
        <template v-if="configuration.college">
            <college-parents
                :showDialog.sync="showDialogNewPerson"
            ></college-parents>
        </template>
        <template v-else>
            <person-form
                :external="false"
                :showDialog.sync="showDialogNewPerson"
            ></person-form>
        </template>
        <cash-history
            :cash_id.sync="cashId"
            :showHistoryCash.sync="showHistoryCash"
            :area_id="area_id"
            :sender="personalWhatsapp ? sender : 'sdrimsac'"
        >
        </cash-history>
        <item-form
            :showDialog.sync="showDialogNewItem"
            :external="true"
            :worker="worker"
        ></item-form>
        <!-- <college
            :showDialog.sync="showDialogCollege"
            :configuration="configuration"
        >
        </college> -->
        <warehouses-detail
            :showDialog.sync="showWarehousesDetail"
            :warehouses="warehousesDetail"
            :unit_type="unittypeDetail"
        >
        </warehouses-detail>
        <tables
            @creatingOrden="creatingOrden"
            @sendOrdens="sendOrdens"
            :showTables.sync="showTables"
        ></tables>

        <documents-print
            :sender="personalWhatsapp ? sender : 'sdrimsac'"
            :company="company"
            :showDialog.sync="showDocumentsPrint"
            :config.sync="config"
            :establishment.sync="establishment"
        ></documents-print>
        <payments-internet
            :person.sync="currentPerson"
            :establishment.sync="establishments"
            :configuration="configuration"
            :showDialog.sync="see_payments"
            :registerId="registerId"
        ></payments-internet>
        <el-dialog
            :visible.sync="showChangeDate"
            @close="showChangeDate = false"
            append-to-body
            title="Cambiar fecha"
            width="450px"
        >
            <div class="row m-2">
                <label class="w-100">
                    Fecha de vencimiento / reinstalación
                </label>
                <el-date-picker
                    class="w-100"
                    format="dd/MM/yyyy"
                    value-format="yyyy-MM-dd"
                    v-model="currentDate"
                >
                </el-date-picker>
            </div>
            <div class="row mb-3">
                <el-button @click="updateDate" type="primary">
                    Actualizar
                </el-button>
            </div>
        </el-dialog>
        <image-modal
            @getRecords="getRecords"
            :showDialog.sync="dialogImage"
            :record="currentRecord"
        ></image-modal>
        <el-dialog
            :visible.sync="showSupensionModal"
            @close="showSupensionModal = false"
            append-to-body
            title="Suspender servicio"
        >
            <div v-if="formSuspension.register_id" class="row">
                <div class="col-12 mt-2">
                    <span>
                        <strong>
                            SUSPENDER SERVICIO DE
                            {{ formSuspension.name.toUpperCase() }}
                        </strong>
                    </span>
                </div>
                <div class="col-12">
                    <el-input
                        v-model="formSuspension.description"
                        placeholder="Motivo de suspensión"
                        type="textarea"
                        :rows="3"
                    >
                    </el-input>
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showSupensionModal = false"
                    >Cancelar</el-button
                >
                <el-button type="primary" @click="sendSuspend"
                    >Suspender</el-button
                >
            </div>
        </el-dialog>

        <el-dialog
            title="Enviar archivos"
            @close="registerWhatsapp = false"
            :visible.sync="registerWhatsapp"
            append-to-body
        >
            <div class="card ">
                <div class="row d-flex align-items-center">
                    <div class="col-8">
                        <el-input v-model="number" placeholder="tlf: 999999999">
                        </el-input>
                    </div>
                    <div class="col-4">
                        <el-switch
                            v-model="fileType"
                            active-text="PDF"
                            inactive-text="Excel"
                        >
                        </el-switch>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-2">
                    <el-button @click="sendFiles" type="primary"
                        >Enviar</el-button
                    >
                    <el-button @click="registerWhatsapp = false">
                        Cerrar
                    </el-button>
                </div>
            </div>
        </el-dialog>
        <el-dialog
            width="90%"
            class="hid-header"
            :visible.sync="showPlans"
            append-to-body
            :show-close="false"
            title="Planes y conceptos"
        >
            <plans></plans>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showPlans = false">Cancelar</el-button>
            </div>
        </el-dialog>

        <el-dialog
            width="90%"
            class="hid-header"
            :visible.sync="showTechs"
            append-to-body
            :show-close="false"
            title="Trabajadores / Técnicos"
        >
            <techs :pos="true"></techs>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showTechs = false">Cancelar</el-button>
            </div>
        </el-dialog>

        <zones :showDialog.sync="showZones"></zones>

        <change-data-modal
            @getRecords="getRecords"
            :showDialog.sync="showChangeData"
            :record="currentRecord"
        >
        </change-data-modal>
    </div>
</template>

<style>
/* .hid-header .el-dialog .el-dialog__header {
    display: none !important;
}
.hid-header .page-header {
    padding-top: 50px;
} */
.el-checkbox#barcode .el-checkbox__label {
    padding-top: 10px !important;
}
.buttons_ {
    min-width: 120px;
    min-height: 75px;
}
@media (max-width: 400px) {
    .buttons_ {
        min-width: 90px;
        min-height: 45px;
    }
}
@media (max-width: 400px) {
    .buttons_ {
        min-width: 90px;
        min-height: 45px;
    }
}
@media (max-width: 400px) {
    .buttons_text_ {
        display: none;
    }

    .buttons_ {
        min-width: 90px;
        min-height: 45px;
    }
}
</style>
<script>
import _ from "lodash";
const DrawerOrdens = () => import("./partials/drawer.vue");
//import DrawerOrdens from "./partials/drawer.vue";
import ListFood from "./partials/list_food.vue";
import {
    functions,
    exchangeRate
} from "../../../../../../../resources/js/mixins/functions";
import { calculateRowItem } from "../../../../../../../resources/js/helpers/functions";
// calculateRowItem,

//import PaymentForm from "./partials/payment.vue";
// import ItemForm from "./partials/form.vue";

//import ItemForm from "../../../../../../../resources/js/views/items/form.vue";
import queryString from "query-string";

//import PersonForm from "../../../../../../../resources/js/views/persons/form.vue";
//import NumberPad from "./partials/num_pad.vue";
//import ListOrden from "./partials/list_ordens.vue";
//import WarehousesDetail from "../../../../../../../resources/js/views/items/partials/warehouses.vue";
//import Tables from "./partials/tables.vue";
//import CashHistory from "./partials/cash_history.vue";
//import DocumentsPrint from "./partials/documents_print.vue";
const ImageModal = () => import("./partials/image_modal.vue");
const PaymentInternet = () => import("./partials/payment_internet.vue");
const ItemForm = () =>
    import("../../../../../../../resources/js/views/items/form.vue");
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
const NumberPad = () => import("./partials/num_pad.vue");
const WarehousesDetail = () =>
    import(
        "../../../../../../../resources/js/views/items/partials/warehouses.vue"
    );
const Tables = () => import("./partials/tables.vue");
const CashHistory = () => import("./partials/cash_history.vue");
const DocumentsPrint = () => import("../../../../../../Restaurant/Resources/assets/js/views/pos/partials/documents_print.vue");
const ListOrden = () => import("./partials/list_ordens.vue");
const RegisterForm = () => import("./partials/register_form.vue");
const ListFoodMobiles = () => import("./partials/list_food_mobiles.vue");

const PaymentsInternet = () => import("./partials/payments_internet.vue");
const Plans = () => import("./../planes/index.vue");
const Techs = () => import("./../workers/index.vue");
const Zones = () =>
    import("../../../../../../../resources/js/views/persons/client_zones.vue");
const ChangeDataModal = () => import("./partials/change_data_modal.vue");
const options = {
    text: "Loading ...",
    customClass: "login_loading",
    spinner: "el-icon-loading",
    lock: true
};
export default {
    props: [
        "pending_order",
        "cash_id",
        "worker",
        "configuration",
        "establishments",
        "auth_login",
        "desarrollador",
        "company",
        "area_id"
    ],
    components: {
        Zones,
        Techs,
        Plans,
        ImageModal,
        PaymentsInternet,
        ChangeDataModal,
        CashHistory,
        DocumentsPrint,
        NumberPad,
        PaymentInternet,
        ItemForm,
        PersonForm,
        WarehousesDetail,
        DrawerOrdens,
        ListFood,
        ListOrden,
        Tables,
        ListFoodMobiles,
        RegisterForm
    },
    mixins: [functions, exchangeRate],

    data() {
        return {
            products_to_due: 0,
            showZones: false,
            showTechs: false,
            showChangeData: false,
            showPlans: false,
            currentPerson: null,
            formSuspension: {},
            showSupensionModal: false,
            fileType: true,
            registerWhatsapp: false,
            dialogImage: false,
            isReconnection: false,
            paymentItems: [],
            registerId: null,
            conf: {},
            showDialogCollege: false,
            barcode: false,
            sender: null,
            socket: null,
            variation: false,
            showDocumentsPrint: false,
            cashId: null,
            formVariation: {},
            ordensPending: 0,
            isCreatingOrden: false,
            table: {},
            tableSelectedNumber: null,
            clientTableData: {},
            tactil: false,
            showTables: false,
            showHistoryCash: false,
            itemDefault: null,
            optionsMenu: [],
            time: null,
            blockCart: false,
            pagination: {},
            category: null,
            allSelected: false,
            selected: [],
            allFoods: [],
            listFoods: [],
            idOrden: null,
            listar_tables: [],
            ordensItems: [],
            newFood: null,
            paraLlevar: false,
            editProd: false,
            localOrden: [],
            type_search: "Descripcion",
            selectOption: null,
            tableSelect: {},
            OrdenLength: 0,
            selecttables: 0,
            categories: [
                { id: 3, name: "Activos" },
                {
                    id: 4,
                    name: "Deudores"
                },
                {
                    id: 2,
                    name: "Suspendidos"
                }
            ],
            ordenId: null,
            name_product_pdf: null,
            ordens: [],
            listtables: [],
            value: null,
            payments: [],
            slickOptions: {
                slidesToShow: 3
                // Any other options that can be got from plugin documentation
            },
            category_selected: 0,
            history_item_id: null,
            date_last: null,
            search_item_by_barcode: false,
            warehousesDetail: [],
            unittypeDetail: [],
            input_person: {},
            showDialogHistoryPurchases: false,
            showDialogHistorySales: false,
            showDialogNewPerson: false,
            showDialogNewItem: false,
            showDialogViewItems: false,
            loading: true,
            colors: ["#1cb973", "#bf7ae6", "#fc6304", "#9b4db4", "#77c1f3"],
            buscar_por: 1,
            userId: null,
            place: false,
            is_payment: false,
            // is_payment: true,//aq
            showWarehousesDetail: false,
            resource: "pos",
            recordId: null,
            input_item: "",
            items: [],
            all_items: [],
            all_series: [],
            customers: [],
            affectation_igv_types: [],
            all_customers: [],
            establishment: null,
            currency_type: {},
            form_item: {},
            customer: {},
            row: {},
            user: {},
            form: {},
            document_type_id: null,
            last_date: null,
            direct_printing: 0,
            customer_default: {},
            customer_variation: null,
            isAllSelected: false,
            selectedCatIds: [],
            foodItem: 0,
            disableCantidad: false,
            total_sales_pos: 0,
            percentage_igv: null,
            orden_items: [],
            documentsType: [],
            personalWhatsapp: false,
            config: {},
            screenWidth: 0,
            records: [],
            see_payments: false,
            currentRecord: null,
            showChangeDate: false,
            currentDate: null,
            pickerEndOptions: {},
            number: null,
            updatePlan: false
        };
    },

    async created() {
        // console.log(this.establishments, " xdl");
        this.conf = this.establishments.conf ?? {};
        this.cashId = this.cash_id;
        this.ordensPending = this.pending_order;
        this.loading = true;
        this.socketWhatsappConfig();
        await this.getTables();
        await this.getRecords();
        await this.getSeries();
        await this.initForm(this.customer_default.id);
        // await this.getFoods();
        // await this.filterCategorie(0, false);
        // await this.changeCustomer();
        this.loading = false;
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
        let form_data = {
            establishment_id: this.establishment.id,
            date: moment().format("YYYY-MM-DD")
        };
        const response = await this.$http.post("/get_igv", form_data);
        this.percentage_igv = response.data;
        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });
    },
    sockets: {},
    computed: {},
    methods: {
      
        updateData(record) {
            this.currentRecord = record;
            this.showChangeData = true;
        },
        async sendSuspend() {
            try {
                this.loading = true;
                const response = await this.$http.post(
                    "/internet/register/update_service",
                    this.formSuspension
                );

                this.getRecords();
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
                this.showSupensionModal = false;
            }
        },
        openWhatsapp() {
            this.registerWhatsapp = true;
        },
        async sendFiles() {
            if (
                !this.number ||
                !this.number.match(/^[0-9]+$/) ||
                this.number.length != 9
            ) {
                this.$message({
                    message:
                        "El número de celular debe ser numérico y tener 9 dígitos",
                    type: "error",
                    duration: 3000
                });
                return;
            }
            let url = `/internet/register/export?type=${
                this.fileType ? "pdf" : "excel"
            }&value=${this.input_item.toLowerCase() || ""}&category=${this
                .category || ""}`;
            //methods with async/await
            let formWhatsapp = {
                resource: url,
                file_name:
                    "reporte_de_registros " +
                    moment().format("YYYY-MM-DD") +
                    `.${this.fileType ? "pdf" : "xlsx"}`,
                number: this.number,
                message: "Reporte_de_registros"
            };
            try {
                this.loading = true;
                let response = await this.$http.post(
                    `/whatsapp/historial`,
                    formWhatsapp
                );

                if (response.status == 200) {
                    this.$toast.success("El mensaje se envió correctamente");
                } else {
                    this.$toast.error("Ocurrió un error en el envio");
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error en el envio");
            } finally {
                this.number = null;
                this.loading = false;
                this.registerWhatsapp = false;
            }
        },
        exportRegister(type) {
            let url = `/internet/register/export?type=${type}&value=${this.input_item.toLowerCase() ||
                ""}&category=${this.category || ""}`;
            window.open(url, "_blank");
        },

        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        openImage(record) {
            this.currentRecord = record;
            this.dialogImage = true;
        },
        async updateService(row) {
            this.updatePlan = false;
            this.formSuspension = {
                description: ""
            };
            if (!row.active) {
                this.registerId = row.id;
                this.isReconnection = true;
                this.is_payment = true;
            } else {
                this.showSupensionModal = true;
                this.formSuspension.register_id = row.id;
                this.formSuspension.name = row.person.name;
                // try {
                //     //confirm
                //     let confirm = await this.$confirm(
                //         `¿Está seguro de suspender el servicio de ${row.person.name}?`,
                //         "Confirmación",
                //         {
                //             confirmButtonText: "Aceptar",
                //             cancelButtonText: "Cancelar",
                //             type: "warning"
                //         }
                //     );
                //     if (confirm == "confirm") {
                //         await this.$http(
                //             `/internet/register/update_service?register_id=${row.id}`
                //         );
                //         this.getRecords();
                //     }
                // } catch (e) {
                //     console.log(e);
                // }
            }
        },
        async updateDate() {
            try {
                const response = await this.$http(
                    `/internet/register/update_date?register_id=${this.currentRecord.id}&date=${this.currentDate}`
                );
                this.getRecords();
                this.showChangeDate = false;
            } catch (e) {
                console.log(e);
                this.showChangeDate = false;
            }
        },
        openChangeDate(row) {
            this.currentRecord = row;
            this.currentDate = row.date_value;
            let startDate = new Date(this.currentDate);
            startDate.setDate(startDate.getDate() + 1);
            this.pickerEndOptions = {
                disabledDate(time) {
                    return time.getTime() < startDate;
                }
            };
            this.showChangeDate = true;
        },
        openPayments(id, person = null) {
            this.registerId = id;
            this.currentPerson = person;
            this.see_payments = true;
        },
        openPaymentMonth(id, updatePlan = false) {
            this.isReconnection = false;
            this.registerId = id;
            this.is_payment = true;
            this.updatePlan = updatePlan;
        },
        contractGenere(id) {
            window.open(`/internet/contract/${id}`);
        },
        async getRecords(query) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/internet/records?${query || ""}`
                );
                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        openCollege() {
            this.showDialogCollege = true;
        },
        changeCategory(category) {
            console.log(
                `cambiando la categoria de ${this.category} a ${category}`
            );
            change;
        },

        receiveData(data) {
            this.search_items(data);
        },
        chlidMetod(data) {
            console.log(data);
        },
        searchFromMobil(data) {
            console.log(data);
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        showMessage(text, duration = 6000) {
            this.$message({
                message: text,
                duration,
                type: "success"
            });
        },
        socketWhatsappConfig() {
            let hostName = window.location.hostname;
            let url = `https://${hostName}`;
            this.sender = hostName
                .replace(/https?\:\/\//, "")
                .replace("/", "")
                .split(".")
                .join("");
            try {
                this.socket = io.connect(this.$socketUrl);
            } catch (e) {
                console.log(e);
            }
            this.socket.on("ready", message => {
                this.showMessage(message);
            });
            this.socket.on("authenticated", ({ message, sender }) => {
                this.sender = sender;
                this.showMessage(message);
            });
            this.socket.on("connected", ({ message }) => {
                this.$toast.success(message, { icon: "fab fa-whatsapp fa-2x" });
                this.socket.emit("getStatus", url);
            });
            this.socket.on("setStatus", ({ status, sender }) => {
                if (!status) {
                    this.$toast.warning("Sesión iniciada con SDRIMSAC", {
                        icon: "fab fa-whatsapp fa-2x"
                    });
                } else {
                    this.sender = sender;
                    this.personalWhatsapp = true;
                    this.$toast.success("Whatsapp Listo!");
                }
            });
            //MessageResponse
            this.socket.on("MessageResponse", ({ success, message }) => {
                if (success) {
                    this.$message.success(message);
                } else {
                    this.$message.error(message);
                }
            });
        },

        async getFile({ documentId, documentTypeId, number, message }) {
            try {
                const response = await this.$http.post(
                    "/whatsapp/get-file",

                    {
                        document_id: documentId,
                        document_type_id: documentTypeId
                    }
                );
                const { pdf, xml, name } = response.data;
                let basicMessage =
                    "Su comprobante de pago electrónico " +
                    name +
                    " de *" +
                    this.company.name +
                    "*, ha sido generado correctamente a través del facturador electrónico de "+"*"+this.$desarrollador+"*"
                if (message) {
                    basicMessage += "\n" + message;
                }
                this.socket.emit("basicMessage", {
                    message: basicMessage,
                    sender: this.sender,
                    number: `51${number}`
                });

                // file, name, number, sender }
                this.socket.emit("sendFile", {
                    file: pdf,
                    name: `${name}.pdf`,
                    number: `51${number}`,
                    sender: this.sender
                });

                if (xml) {
                    this.socket.emit("sendFile", {
                        file: xml,
                        name: `${name}.xml`,
                        number: `51${number}`,
                        sender: this.sender
                    });
                }
            } catch (e) {
                let msg = "Ocurrió un error";
                if (e.response) {
                    const { response } = e;
                    if (response.status == 404) {
                        msg = "No se encontró la ruta";
                    } else {
                        msg = response.data.message;
                    }
                }
                this.$message.error(msg);
                console.log(e);
            } finally {
                this.limpiarForm();
            }
        },
        creatingOrden(number, id) {
            this.isCreatingOrden = true;
            this.clientTableData = {
                ref: undefined,
                table: number,
                table_id: id
            };
        },
        //aqui se envia los productos desde la mesa
        sendOrdens(orden) {
            if (this.localOrden.length != 0 && !this.configuration.box_orden) {
                this.$toast.warning("Tiene productos seleccionados.");
                return;
            }
            this.clientTableData = {
                table: orden.mesa.number,
                ref: orden.ref ?? "-",
                table_id: orden.mesa.id,
                orden_id: orden.id
            };

            // orden.type_id = type ? type.id : null;
            //  orden.type_description = type ? type.description : null;
            // orden.type_quantity = type ? Number(type.quantity_unit) : 0;
            this.ordensItems = [
                ...orden.orden_items.map(o => {
                    let orden = o;
                    orden.price = Number(orden.price).toFixed(2);
                    if (orden.unit_type_id) {
                        let { item } = orden.food;

                        let unit_type = item.item_unit_types.find(
                            u => u.id == orden.unit_type_id
                        );
                        if (unit_type) {
                            orden.type_id = unit_type.id;
                            orden.type_description = unit_type.description;
                            orden.type_quantity = Number(
                                unit_type.quantity_unit
                            );
                        }
                    }
                    return {
                        ...orden,
                        sended: true
                    };
                })
            ];
            this.blockCart = true;
            this.isCreatingOrden = false;
            this.idOrden = orden.id;
        },
        async rePrint() {
            try {
                const response = await this.$http(`print_last_document`);
                const { data } = response;
                if (!data.success) {
                    this.$toast.error("No se pudo imprimir");
                }
            } catch (e) {
                this.$toast.error("No se pudo imprimir");
            }
        },
        trigerFunction(id) {
            switch (id) {
                case 1:
                    this.showDocumentsPrint = true;
                    //this.rePrint();
                    break;
                case 5:
                    this.openTables();
                    break;
                case 6:
                    this.view_modal();
                    break;
                case 7:
                    this.showHistory();
                    break;
                case 3:
                    this.showDialogNewItem = true;
                    break;
                case 4:
                    this.showDialogNewPerson = true;
                    break;
                case 8:
                    this.openviewsItemsMobil();
                    break;
                case 9:
                    this.openCollege();
                    break;
                case 10:
                    this.showPlans = true;

                    break;
                case 55:
                    this.showTechs = true;

                    break;
                case 56:
                    this.showZones = true;

                    break;
                default:
                    break;
            }
        },
        showHistory() {
            this.showHistoryCash = true;
        },
        openTables() {
            this.showTables = true;
        },
        openviewsItemsMobil() {
            this.showDialogViewItems = true;
        },
        cancelOrden() {
            this.localOrden = [];
            this.ordensItems = [];
            this.clientTableData = {};
            this.isCreatingOrden = false;
            this.idOrden = undefined;
        },
        async changePage(page) {
            this.pagination.current_page = page;
            await this.search_items();
        },
        async openDrawer() {
            let elementDrawer = document.querySelector("#drawer");
            if (elementDrawer != undefined) {
                elementDrawer.click();
            }
        },
        selectAllCats() {
            if (this.isAllSelected) {
                this.selectedCatIds = [];
                this.isAllSelected = false;
            } else {
                this.selectedCatIds = [];
                for (let cat = 0; cat < this.tableSelect.ordens.length; cat++) {
                    for (
                        let index = 0;
                        index < this.tableSelect.ordens[cat].orden_items.length;
                        index++
                    ) {
                        this.selectedCatIds.push(
                            this.tableSelect.ordens[cat].orden_items[index].id
                        );
                        this.foodItem = this.foodItem + 1;
                    }
                }
                this.isAllSelected = true;
            }
        },
        buscarnuevo() {
            this.$refs.input_items.$el.getElementsByTagName("input")[0].focus();
            this.$refs.input_items.$el.getElementsByTagName("input")[0].value =
                "";
        },
        add_customer(value) {
            this.value = value;
            this.form.customer_id = this.value;
        },
        forma(i) {
            return {
                ...i,
                item: i,
                item_id: i.id,
                unit_value:
                    i.sale_affectation_igv_type_id == 10
                        ? i.sale_unit_price / (1 + this.percentage_igv / 100)
                        : i.sale_unit_price,
                quantity: i.quantity,
                aux_quantity: i.quantity,
                total_base_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.sale_unit_price * i.quantity,
                percentage_igv: this.percentage_igv,
                total_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_base_isc: 0.0,
                percentage_isc: 0.0,
                total_isc: 0.0,
                total_base_other_taxes: 0.0,
                percentage_other_taxes: 0.0,
                total_other_taxes: 0.0,
                total_taxes:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_value:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.quantity * i.sale_unit_price,
                total_charge: 0.0,
                total_discount: 0.0,
                total: i.sale_unit_price * i.quantity,
                price_type_id: "01",
                unit_price: i.sale_unit_price,
                unit_price_value: i.sale_unit_price,
                has_igv: i.has_igv,
                affectation_igv_type_id: i.sale_affectation_igv_type_id,
                unit_price: i.sale_unit_price,
                presentation: null,
                charges: [],
                discounts: [],
                attributes: [],
                affectation_igv_type: i.sale_affectation_igv_type_id
            };
        },
        async paymentsOrden(form, variationItem = null) {
            this.orden_items = form;
            this.form.printDocument = form.printDocument;
            let { items } = form;
            this.ordens = items;
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                this.ordens[i].food.item.from_unit_type_id = item.type_id;
                this.ordens[i].food.item.from_unit_type_id_desc =
                    item.type_description;

                this.ordens[i].food.item.quantity = item.quantity;
                this.ordens[i].food.item.lotes = item.lotes;
                this.ordens[i].food.item.lots = item.series;
                this.ordens[i].food.item.sale_unit_price = item.price;
                this.ordens[i].food.price = item.price;
            }
            if (variationItem) {
                this.variation = true;
                this.formVariation.items = [
                    this.formatVariation(variationItem)
                ];
                this.formVariation.enter_amount = variationItem.sale_unit_price;
                this.formVariation.difference = 0;
                this.formVariation.total = this.formVariation.enter_amount;
                this.formVariation.establishment_id = this.establishment.id;
                if (!this.formVariation.customer_id) {
                    let varios = this.all_customers.filter(a =>
                        a.name.toLowerCase().includes("varios")
                    );
                    if (varios.length == 0) {
                        this.formVariation.customer_id = this.all_customers[0].id;
                    } else {
                        this.formVariation.customer_id = varios[0].id;
                    }
                }
                this.calculateTotalVariation(this.formVariation);
            }
            this.form.items = this.ordens.map(o => o.food.item);
            this.formatItems();
            this.calculateTotal();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;
            this.form.establishment_id = this.establishment.id;
            if (!this.form.customer_id) {
                let varios = this.all_customers.filter(a =>
                    a.name.toLowerCase().includes("varios")
                );
                if (varios.length == 0) {
                    this.form.customer_id = this.all_customers[0].id;
                } else {
                    this.form.customer_id = varios[0].id;
                }
                if (!this.form.customer_id) {
                    this.is_payment = false;
                    return this.$toast.error("Seleccione un cliente");
                }
            } else {
                if (variationItem) {
                    let tmpchange = this.formVariation;
                    let tmpchange2 = this.form;

                    this.form = tmpchange;
                    this.formVariation = tmpchange2;
                    this.form.variation = true;
                }
                if (this.variation) {
                    this.isNoteIsDefault();
                }

                this.is_payment = true;
            }
        },
        formatVariation(i) {
            return {
                ...i,
                item: i,
                item_id: i.id,
                unit_value:
                    i.sale_affectation_igv_type_id == 10
                        ? i.sale_unit_price / (1 + this.percentage_igv / 100)
                        : i.sale_unit_price,
                quantity: i.quantity,
                aux_quantity: i.quantity,
                total_base_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.sale_unit_price * i.quantity,
                percentage_igv: this.percentage_igv,
                total_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_base_isc: 0.0,
                percentage_isc: 0.0,
                total_isc: 0.0,
                total_base_other_taxes: 0.0,
                percentage_other_taxes: 0.0,
                total_other_taxes: 0.0,
                total_taxes:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_value:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.quantity * i.sale_unit_price,
                total_charge: 0.0,
                total_discount: 0.0,
                total: i.sale_unit_price * i.quantity,
                price_type_id: "01",
                unit_price: i.sale_unit_price,
                unit_price_value: i.sale_unit_price,
                has_igv: i.has_igv,
                affectation_igv_type_id: i.sale_affectation_igv_type_id,
                unit_price: i.sale_unit_price,
                presentation: null,
                charges: [],
                discounts: [],
                attributes: [],
                affectation_igv_type: i.sale_affectation_igv_type_id
            };
        },

        select(id) {
            if (this.selectedCatIds.length + 1 == this.foodItem) {
                this.isAllSelected = true;
            } else {
                this.isAllSelected = false;
            }
        },
        deletedFood(idx) {
            this.localOrden.splice(idx, 1);
            this.calculateTotal();
        },
        getDefaultPrice(type) {
            let listPricesDescription = ["price1", "price2", "price3"];
            let currentPriceIndx =
                listPricesDescription[type.price_default - 1];
            let price = type[currentPriceIndx];
            if (type.total == null) {
                // this.$toast.error(
                //     "Politica de precio sin total: Tomando precio unitario.."
                // );
            } else {
                price = Number(type.total);
            }
            return price;
        },
        insertOrden(orden, food_id, type) {
            //esto ya no me puede traer solo uno
            //ya que podré agregar más de una vez un producto
            // let ordenAdded = _.filter(this.localOrden, {
            //     id: food_id
            // });
            let ordenAdded = this.localOrden.filter(ord => ord.id == food_id);

            //si el producto no existe en el listado en ninguna presentacion

            if (ordenAdded.length == 0) {
                orden.to_carry = false;
                orden.change_subtotal = false;
                orden.series = [];
                orden.lotes = [];
                let added = false;
                let {
                    food: {
                        item: { lots_group }
                    }
                } = orden;

                if (lots_group.length != 0) {
                    for (let i = 0; i < lots_group.length; i++) {
                        let lot = lots_group[i];
                        if (lot.quantity > 0 && !added) {
                            orden.lotes = [
                                {
                                    ...lot,
                                    quantitySelected: 1
                                }
                            ];
                            added = true;
                        } else {
                            orden.lotes = [
                                ...orden.lotes,
                                { ...lot, quantitySelected: 0 }
                            ];
                        }
                    }
                }

                orden.type_id = type ? type.id : null;
                orden.type_description = type ? type.description : null;
                orden.type_quantity = type ? Number(type.quantity_unit) : 0;
                //si es el primer registro del prod en la lista

                if (type) {
                    // orden.quantity = Number(type.quantity_unit);
                    orden.quantity = orden.food.item.series_enabled ? 0 : 1;
                    orden.price = this.getDefaultPrice(type);
                }
                this.localOrden.unshift(orden);
            }
            //aca existe en original o en alguna  presentación
            else {
                //si la orden agregada es una presentación

                if (type != null) {
                    //si es, verificar si ya existe esa presentación en la lista
                    let indexFind = this.localOrden.findIndex(
                        orden => orden.type_id == type.id
                    );
                    if (indexFind != -1) {
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) + 1;
                        // Number(type.quantity_unit);
                    } else {
                        // orden.quantity = Number(type.quantity_unit);
                        orden.quantity = orden.food.item.series_enabled ? 0 : 1;
                        orden.price = this.getDefaultPrice(type);
                        orden.type_id = type.id;
                        orden.type_description = type.description;
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        let {
                            food: {
                                item: { lots_group }
                            }
                        } = orden;
                        if (lots_group.length != 0) {
                            for (let i = 0; i < lots_group.length; i++) {
                                let lot = lots_group[i];
                                if (lot.quantity > 0) {
                                    orden.lotes = [
                                        {
                                            ...lot,
                                            quantitySelected: 1
                                        }
                                    ];
                                    break;
                                }
                            }
                        }
                        orden.type_quantity = type
                            ? Number(type.quantity_unit)
                            : 0;
                        this.localOrden.unshift(orden);
                    }

                    //y si no agregarla como nueva
                } else {
                    //si es original, seguir agregando uno
                    let indexFind = this.localOrden.findIndex(
                        p => p.id == food_id && p.type_id == null
                    );
                    if (indexFind != -1) {
                        //actualizamos el elemento que agregamos, pero lo sacamos del objeot y lo volvemos a colocar de primero, de esta manera podemos saber si ya esta el producto que estamos agregando a la lista y saber cuanto tenemos en total
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) + 1;
                        let itemAwait = this.localOrden[indexFind];
                        this.localOrden.splice(indexFind, 1);
                        this.localOrden.unshift(itemAwait);
                    } else {
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        this.localOrden.unshift(orden);
                    }
                }

                this.localOrden = [...this.localOrden];
            }
            this.$refs.ordenRef.calculateTotal();
        },
        total_sales(val) {
            this.total_sales_pos = val;
        },

        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/documents/search/customer/${customer_id}`)
                .then(response => {
                    this.all_customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        },

        updateOrdens() {
            this.createOrden();
        },
        createOrden() {
            this.ordensItems = [];
        },
        facturar_orden() {
            this.ordens = [];
            for (let cat = 0; cat < this.tableSelect.ordens.length; cat++) {
                for (
                    let indexxx = 0;
                    indexxx < this.tableSelect.ordens[cat].orden_items.length;
                    indexxx++
                ) {
                    let idOrden = this.tableSelect.ordens[cat].orden_items[
                        indexxx
                    ].id;
                    for (
                        let index = 0;
                        index < this.selectedCatIds.length;
                        index++
                    ) {
                        if (this.selectedCatIds[index] == idOrden) {
                            this.addNewFood(
                                this.tableSelect.ordens[cat].orden_items[
                                    indexxx
                                ].food_id
                            );
                        }
                    }
                }
            }
            this.selectOption = 1;
        },
        selectTable(row, index) {
            this.tableSelect = [];
            this.selecttables = row.id;
            this.tableSelect = this.listar_tables[index];
            this.OrdenLength = this.tableSelect.ordens.length;
            if (this.tableSelect.ordens.length == 1) {
                this.OrdenLength = this.tableSelect.ordens.length + 1;
            } else {
                this.OrdenLength = this.tableSelect.ordens.length;
            }
            for (let cat = 0; cat < this.tableSelect.ordens.length; cat++) {
                for (
                    let index = 0;
                    index < this.tableSelect.ordens[cat].orden_items.length;
                    index++
                ) {
                    this.foodItem++;
                }
            }
        },
        consumir() {
            this.ordens = [];
            this.form.total_exonerated = 0;
            this.form.total_taxed = 0;
            this.form.total_igv = 0;
            this.form.total = 0;
            this.$refs.input_item.$el.getElementsByTagName("input")[0].focus();
            this.calculateTotal();
        },

        addNewFood(newFood = null) {
            let f = this.allFoods.find(ai => ai.id == newFood);

            if (f) {
                f.llevar = true;
                f.item.quantity = 1;
                f.name_product_pdf = null;
                this.ordens = [
                    ...this.ordens,
                    {
                        food: f
                    }
                ];
            }
            this.newFood = null;
            if (this.selectOption == 2) {
                this.ordens[0].food.item.name_product_pdf = "POR CONSUMO";
            }
            this.calculateTotal();
        },

        paLlevar() {
            this.paraLlevar = !this.paraLlevar;
        },
        next() {
            this.$refs.slick.next();
        },
        editarProd() {
            this.editProd = !this.editProd;
        },
        add_product_pdf(index) {
            this.ordens[
                index
            ].food.item.name_product_pdf = this.name_product_pdf;

            this.editProd = !this.editProd;
        },
        prev() {
            this.$refs.slick.prev();
        },
        async date_of_issue() {
            let form_date_of_issue = {
                document_type_id: this.form.document_type_id
            };

            const response_date = await this.$http.post(
                `/${this.resource}/date_of_issue`,
                form_date_of_issue
            );

            this.last_date = response_date.data.date_last;
        },
        async view_modal() {
            this.loading = true;
            const response = await this.$http.get(
                `/caja/worker/totales_sales?cash_id=${this.cashId}`
            );
            this.$toast(
                ` Venta Acumulada S/ ` + response.data.total_sales.toFixed(2)
            );
            this.loading = false;
        },
        async list_tables() {
            this.loading = true;
            const response = await this.$http.get(
                `/caja/worker/${this.resource}/listtables`
            );
            this.listtables = response.data;
            this.listar_tables = response.data;
            this.loading = false;
        },
        reInit() {
            // Helpful if you have to deal with v-for to update dynamic lists
            this.$nextTick(() => {
                this.$refs.slick.reSlick();
            });
        },
        async clickPrintPos(printerName, formatoPdf) {
            try {
                let config = qz.configs.create(printerName, {
                    size: {
                        width: 148,
                        height: 210
                    },
                    units: "mm",
                    colorType: "grayscale",
                    copies: 2
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: formatoPdf
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
                // this.clickNewSaleNote();
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        clear_input() {
            this.input_item = "";
        },
        selectFocus(input_) {
            this.$refs[input_][0].select();
        },
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;
                if (key == "F3") {
                    this.$refs.input_item.$el
                        .getElementsByTagName("input")[0]
                        .focus();
                }
                if (key == "F4") {
                    //Agregar cliente
                    this.clickPayment();
                }
                if (key == "F6") {
                    //Agregar Producto
                    //this.clickAddItemInvoice()
                    //return false;
                }
                if (key == "F7" && this.form.items.length > 0) {
                    //Guardar
                    // this.submit()
                }
                if (key == "F8") {
                    //Cancelar
                    // this.close()
                }
            };
        },

        leftarrow(input, index) {
            let split = input.split("_");

            if (split[1] != this.form.items.length) {
                this.$nextTick(this.$refs[index][0].focus());
            }
        },
        rightarrow(index) {
            let split = index.split("_");
            if (split[1] != this.form.items.length) {
                this.$nextTick(this.$refs[index][0].focus());
            }
        },
        upDown(index, next = false) {
            let split = index.split("_");
            if (index != 0) {
                if (split[1] != this.form.items.length) {
                    this.$nextTick(this.$refs[index][0].focus());
                }
                if (split[1] != this.form.items.length) {
                    this.$nextTick(this.$refs[index][0].focus());
                }
            }
        },
        arrowDown(index, next = false) {
            let split = index.split("_");
            if (split[1] != this.form.items.length) {
                this.$nextTick(this.$refs[index][0].focus());
            }
        },
        select_cantidad(index, next = false) {
            let split = index.split("_");
            if (next == false) {
                if (split[1] == this.form.items.length - 1) {
                } else {
                    this.$nextTick(this.$refs[index][0].focus());
                }
            } else {
                if (split[1] != this.form.items.length) {
                    this.$nextTick(this.$refs[index][0].focus());
                }
            }
        },
        clickClose: function() {
            this.$confirm("¿Desea Salir del Punto de Venta?", "Advertencia", {
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cerrar",
                type: "warning"
            }).then(() => {
                location.href = `/dashboard`;
            });
        },
        async nueva_venta() {
            this.initForm(this.customer_default.id);
            this.events();
            await this.getFormPosLocalStorage();
            await this.initCurrencyType();

            this.customer = await this.getLocalStorageIndex("customer");
        },
        filterCategorie(id, mod = false) {
            this.category_selected = id;
            // this.$refs.list_foods.searchFoodCategories(id);
        },

        initCurrencyType() {
            this.currency_type = _.find(this.currency_types, {
                id: this.form.currency_type_id
            });
        },

        getFormPosLocalStorage() {
            let form_pos = localStorage.getItem("form_pos");

            form_pos = JSON.parse(form_pos);
            if (form_pos) {
                this.form = form_pos;

                this.calculateTotal();
            }
        },
        deleteFormPosLocalStorage() {
            localStorage.setItem("form_pos", JSON.stringify(this.form));
        },
        setFormPosLocalStorage(form_param = null) {
            /*if (form_param) {
                      localStorage.setItem("form_pos", JSON.stringify(form_param));
                  } else {
                      localStorage.setItem("form_pos", JSON.stringify(this.form));
                  }
                  */
        },

        cancelFormPosLocalStorage() {
            localStorage.setItem("form_pos", JSON.stringify(null));
            this.setLocalStorageIndex("customer", null);
        },
        clickOpenInputEditUP(index) {
            this.items[index].edit_unit_price = true;
        },
        clickEditUnitPriceItem(index) {
            let item_search = this.items[index];
            this.items[index].sale_unit_price = this.items[
                index
            ].edit_sale_unit_price;
            this.items[index].edit_unit_price = false;
        },
        clickCancelUnitPriceItem(index) {
            this.items[index].edit_unit_price = false;
        },
        clickWarehouseDetail(item) {
            this.unittypeDetail = item.unit_type;
            this.warehousesDetail = item.warehouses;
            this.showWarehousesDetail = true;
        },
        clickHistoryPurchases(item_id) {
            this.history_item_id = item_id;
            this.showDialogHistoryPurchases = true;
        },
        clickHistorySales(item_id) {
            if (!this.form.customer_id)
                return this.$toast.error("Debe seleccionar el cliente");
            this.history_item_id = item_id;
            this.showDialogHistorySales = true;
        },
        keyupEnterCustomer() {
            if (this.input_person.number) {
                if (!isNaN(parseInt(this.input_person.number))) {
                    switch (this.input_person.number.length) {
                        case 8:
                            this.input_person.identity_document_type_id = "1";
                            this.showDialogNewPerson = true;
                            break;

                        case 11:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                        default:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                    }
                }
            }
        },
        keyupCustomer(e) {
            //if(e.key !== "Enter"){
            this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                "input"
            )[0].value;
            let exist_persons = this.all_customers.filter(customer => {
                let pos = customer.description.search(this.input_person.number);
                return pos > -1;
            });
            this.input_person.number =
                exist_persons.length == 0 ? this.input_person.number : null;
            //}
        },
        calculateQuantity(index) {
            if (this.form.items[index].item.calculate_quantity) {
                let quantity = _.round(
                    parseFloat(this.form.items[index].total) /
                        parseFloat(this.form.items[index].unit_price),
                    4
                );

                if (quantity) {
                    this.form.items[index].quantity = quantity;
                    this.form.items[index].item.aux_quantity = quantity;
                } else {
                    this.form.items[index].quantity = 0;
                    this.form.items[index].item.aux_quantity = 0;
                }
                // this.calculateTotal()
            }

            //  this.clickAddItem(this.form.items[index],index, true)
        },
        blurCalculateQuantity(index) {
            this.row = calculateRowItem(
                this.form.items[index],
                this.form.currency_type_id,
                1
            );
            this.form.items[index] = this.row;
            this.calculateTotal();
            this.setFormPosLocalStorage();
        },
        blurCalculateQuantity2(index) {
            this.row = calculateRowItem(
                this.form.items[index],
                this.form.currency_type_id,
                1
            );
            this.form.items[index] = this.row;
            this.calculateTotal();
        },
        changeCustomer() {
            this.form.customer_id = this.value;
            let customer = _.find(this.all_customers, {
                id: this.form.customer_id
            });
            this.customer = customer;
            if (customer) {
                this.form.document_type_id =
                    customer.identity_document_type_id == "1" ? "03" : "01";
            }
            this.setLocalStorageIndex("customer", this.customer);
            //  this.setFormPosLocalStorage()
        },

        getLocalStorageIndex(key, re_default = null) {
            let ls_obj = localStorage.getItem(key);
            ls_obj = JSON.parse(ls_obj);

            if (ls_obj) {
                return ls_obj;
            }

            return re_default;
        },
        setLocalStorageIndex(key, obj) {
            localStorage.setItem(key, JSON.stringify(obj));
        },
        async events() {
            await this.$eventHub.$on("initInputPerson", () => {
                this.initInputPerson();
            });

            await this.$eventHub.$on(
                "eventSetFormPosLocalStorage",
                form_param => {
                    this.setFormPosLocalStorage(form_param);
                }
            );

            await this.$eventHub.$on("cancelSale", () => {
                this.is_payment = false;
                this.getTables();
                this.initForm(this.customer_default.id);
                this.changeExchangeRate();
                this.ordenId = null;
                this.ordens = [];
                //  this.cancelFormPosLocalStorage()
            });

            await this.$eventHub.$on("reloadDataItems", item_id => {
                this.reloadDataItems(item_id);
            });

            await this.$eventHub.$on("saleSuccess", () => {
                //  this.is_payment = false;
                this.getTables();
                this.initForm(this.customer_default.id);
                this.setFormPosLocalStorage();
                this.ordenId = null;
                this.ordens = [];
            });
        },
        async initForm(customer_default = null) {
            this.variation = false;
            this.form = {
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                establishment_id: null,
                document_type_id:
                    this.company.soap_type_id != "03"
                        ? this.establishments.document_default
                        : "80",
                series_id: null,
                prefix: null,
                user_id: this.user.id,
                number: "#",
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                currency_type_id: "PEN",
                purchase_order: null,
                exchange_rate_sale: 1,
                total_prepayment: 0,
                total_charge: 0,
                total_discount: 0,
                total_exportation: 0,
                total_free: 0,
                total_taxed: 0,
                total_unaffected: 0,
                total_exonerated: 0,
                total_igv: 0,
                total_base_isc: 0,
                total_isc: 0,
                total_base_other_taxes: 0,
                total_other_taxes: 0,
                total_taxes: 0,
                total_value: 0,
                total: 0,
                operation_type_id: "0101",
                date_of_due: moment().format("YYYY-MM-DD"),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                hotel: {},
                additional_information: null,
                payment_condition_id: "01",
                printerOn: false,
                actions: {
                    format_pdf: "a4"
                },
                difference: 0.0,
                enter_amount: 0.0,
                method_pay: "Efectivo",
                commands_fisico: null,
                to_carry: false
            };
            this.formVariation = {
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                establishment_id: null,
                document_type_id: this.establishments.document_default,
                series_id: null,
                prefix: null,
                user_id: this.user.id,
                number: "#",
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                currency_type_id: "PEN",
                purchase_order: null,
                exchange_rate_sale: 1,
                total_prepayment: 0,
                total_charge: 0,
                total_discount: 0,
                total_exportation: 0,
                total_free: 0,
                total_taxed: 0,
                total_unaffected: 0,
                total_exonerated: 0,
                total_igv: 0,
                total_base_isc: 0,
                total_isc: 0,
                total_base_other_taxes: 0,
                total_other_taxes: 0,
                total_taxes: 0,
                total_value: 0,
                total: 0,
                operation_type_id: "0101",
                date_of_due: moment().format("YYYY-MM-DD"),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                hotel: {},
                additional_information: null,
                payment_condition_id: "01",
                printerOn: false,
                actions: {
                    format_pdf: "a4"
                },
                difference: 0.0,
                enter_amount: 0.0,
                method_pay: "Efectivo",
                commands_fisico: null,
                to_carry: false
            };
            this.value = customer_default;
            this.form.customer_id = customer_default;
            this.initFormItem();
            this.changeDateOfIssue();
            this.initInputPerson();
            //  this.changeCustomer();
            this.name_product_pdf = null;
        },
        initInputPerson() {
            this.input_person = {
                number: "",
                identity_document_type_id: ""
            };
        },
        initFormItem() {
            this.form_item = {
                item_id: null,
                item: {},
                affectation_igv_type_id: null,
                affectation_igv_type: {},
                has_isc: false,
                system_isc_type_id: null,
                calculate_quantity: false,
                percentage_isc: 0,
                suggested_price: 0,
                quantity: 1,
                aux_quantity: 1,
                unit_price_value: 0,
                unit_price: 0,
                charges: [],
                discounts: [],
                attributes: [],
                has_igv: false
            };
        },
        async clickPayment() {
            if (this.orden_items.length == 0) {
                this.orden_items = { items: this.ordens };
            }
            if (this.selectOption == 1) {
                this.form.orden_id = this.input_item;
                this.idOrden = this.input_item;
            }
            this.form.items = this.ordens.map(o => o.food.item);
            this.formatItems();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;

            if (this.ordens[0].food.price == 0 && this.selectOption == 2) {
                return this.$toast.error("Ingrese el Precio por consumo");
            }
            if (!this.form.customer_id)
                return this.$toast.error("Seleccione un cliente");
            this.form.establishment_id = this.establishment.id;

            this.is_payment = true;
        },
        getLocalPrinter(key) {
            let ls_obj = localStorage.getItem(key);
            return ls_obj;
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        clickDeleteCustomer() {
            this.form.customer_id = null;
            this.setFormPosLocalStorage();
        },
        formatItems() {
            this.form.items = this.form.items.map(i => {
                return {
                    ...i,
                    warehouse_id: null,
                    item: i,
                    item_id: i.id,
                    unit_value:
                        i.sale_affectation_igv_type_id == 10
                            ? i.sale_unit_price /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price,
                    quantity: i.quantity,
                    aux_quantity: i.quantity,
                    total_base_igv:
                        i.sale_affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price * i.quantity,
                    percentage_igv: this.percentage_igv,
                    total_igv:
                        i.sale_affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_base_isc: 0.0,
                    percentage_isc: 0.0,
                    total_isc: 0.0,
                    total_base_other_taxes: 0.0,
                    percentage_other_taxes: 0.0,
                    total_other_taxes: 0.0,
                    total_taxes:
                        i.sale_affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_value:
                        i.sale_affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.quantity * i.sale_unit_price,
                    total_charge: 0.0,
                    total_discount: 0.0,
                    total: i.sale_unit_price * i.quantity,
                    price_type_id: "01",
                    unit_price: i.sale_unit_price,
                    unit_price_value: i.sale_unit_price,
                    has_igv: i.has_igv,
                    affectation_igv_type_id: i.sale_affectation_igv_type_id,
                    unit_price: i.sale_unit_price,
                    presentation: null,
                    charges: [],
                    discounts: [],
                    attributes: [],
                    affectation_igv_type: i.sale_affectation_igv_type_id
                };
            });
            this.calculateTotal();
        },
        isNoteIsDefault() {
            if (this.form.document_type_id == "80") {
                this.form.document_type_id = "03";
            }
        },
        async clickAddItem(
            item,
            index,
            input = false,
            price_sale = 0,
            focus = false
        ) {
            //this.loading = true;
            let exchangeRateSale = this.form.exchange_rate_sale;
            let exist_item = _.find(this.form.items, {
                item_id: item.item_id
            });
            let pos = this.form.items.indexOf(exist_item);
            let response = null;
            if (exist_item) {
                if (input) {
                    response = await this.getStatusStock(
                        item.item_id,
                        exist_item.item.aux_quantity
                    );
                    if (!response.success) {
                        item.item.aux_quantity = item.quantity;
                        this.loading = false;
                        return this.$toast.error(response.message);
                    }
                    exist_item.quantity = exist_item.item.aux_quantity;
                } else {
                    response = await this.getStatusStock(
                        item.item_id,
                        parseFloat(exist_item.item.aux_quantity) + 1
                    );
                    if (!response.success) {
                        // this.loading = false;
                        return this.$toast.error(response.message);
                    }

                    exist_item.quantity++;
                    exist_item.item.aux_quantity++;
                }

                let search_item_bd = await _.find(this.items, {
                    item_id: item.item_id
                });
                if (search_item_bd) {
                    exist_item.item.unit_price = parseFloat(
                        search_item_bd.sale_unit_price
                    );
                }
                if (price_sale > 0) {
                    exist_item.item.sale_unit_price = price_sale;
                }

                let unit_price = exist_item.item.has_igv
                    ? exist_item.item.sale_unit_price
                    : exist_item.item.sale_unit_price *
                      (1 + this.percentage_igv / 100);
                // exist_item.unit_price = unit_price
                exist_item.item.unit_price = unit_price;
                this.row = calculateRowItem(
                    exist_item,
                    this.form.currency_type_id,
                    exchangeRateSale
                );
                this.form.items[pos] = this.row;
            } else {
                response = await this.getStatusStock(item.item_id, 1);
                if (!response.success) {
                    // this.loading = false;
                    return this.$toast.error(response.message);
                }

                this.form_item.item = item;
                this.form_item.unit_price_value = this.form_item.item.sale_unit_price;
                this.form_item.has_igv = this.form_item.item.has_igv;
                this.form_item.affectation_igv_type_id = this.form_item.item.sale_affectation_igv_type_id;
                this.form_item.quantity = 1;
                this.form_item.aux_quantity = 1;

                let unit_price = this.form_item.has_igv
                    ? this.form_item.unit_price_value
                    : this.form_item.unit_price_value *
                      (1 + this.percentage_igv / 100);

                this.form_item.unit_price = unit_price;
                this.form_item.item.unit_price = unit_price;
                this.form_item.item.presentation = null;

                this.form_item.charges = [];
                this.form_item.discounts = [];
                this.form_item.attributes = [];
                this.form_item.affectation_igv_type = _.find(
                    this.affectation_igv_types,
                    {
                        id: this.form_item.affectation_igv_type_id
                    }
                );

                this.row = calculateRowItem(
                    this.form_item,
                    this.form.currency_type_id,
                    exchangeRateSale
                );
                this.form.items.push(this.row);
                item.aux_quantity = 1;
            }

            this.$notify({
                title: "",
                message: "Producto añadido!",
                type: "success",
                duration: 700,
                position: "bottom-right"
            });
            await this.calculateTotal();
            this.loading = false;
            await this.setFormPosLocalStorage();
            if (focus == true) {
                let indexx = this.form.items.length - 1;
                this.$nextTick(this.$refs["input_" + indexx][0].focus());
                this.$nextTick(this.$refs["input_" + indexx][0].select());
            }

            localStorage.setItem("form_pos", JSON.stringify(this.form));
        },
        async focus() {
            await this.sleep(200);
            let indexx = this.form.items.length - 1;
        },
        async Printer(
            Printer,
            linkpdf,
            copies,
            auth = null,
            multiple_boxes = false,
            typeuser = null,
            printing = true
        ) {
            let paperConfig = {
                scaleContent: false
            };
            let partsUrl = linkpdf.split("/");
            let document = partsUrl[partsUrl.length - 1];
            let isTicket = document.toLowerCase().includes("ticket");
            if(!isTicket){
                let print_service = linkpdf.includes("print_service");
                isTicket = print_service;
            }
            let tipoBandejaImpresora = this.config.new_old_printer;

            if (!isTicket && tipoBandejaImpresora == 1) {
                //opciones que permiten hacer una impresion correcta en impresoras nuevas
                paperConfig.density = 600;
                paperConfig.orientation = "portrait";
                paperConfig.margins = { left: 2 };
            } else if (!isTicket && tipoBandejaImpresora == 0) {
                paperConfig.density = 350;
                paperConfig.orientation = "portrait";
            }
            let config = qz.configs.create(Printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
            for (let index = 0; index < copies; index++) {
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
            // if (multiple_boxes == true && typeuser != "admin") {
            //     //  if (true) { this.auth_login - auth
            //     let config = qz.configs.create(Printer, paperConfig);

            //     if (!qz.websocket.isActive()) {
            //         await qz.websocket.connect(config);
            //     }
            //     let data = [
            //         {
            //             type: "pdf",
            //             forma    t: "file",
            //             data: linkpdf
            //         }
            //     ];

            //     qz.print(config, data).catch(e => {
            //         this.$toast.error(e.message);
            //     });
            //     for (let index = 0; index < copies; index++) {
            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //     }
            // }
            // if (
            //     multiple_boxes == true &&
            //     (typeuser == "admin" || typeuser == "superadmin")
            // ) {
            //     let config = qz.configs.create(Printer, paperConfig);
            //     console.log(paperConfig, "configu");
            //     console.log(config);
            //     if (!qz.websocket.isActive()) {
            //         await qz.websocket.connect(config);
            //     }
            //     let data = [
            //         {
            //             type: "pdf",
            //             format: "file",
            //             data: linkpdf
            //         }
            //     ];
            //     qz.print(config, data).catch(e => {
            //         this.$toast.error(e.message);
            //     });
            //     for (let index = 0; index < copies; index++) {
            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //     }
            // }
            // if (multiple_boxes == false) {
            //     let config = qz.configs.create(Printer, paperConfig);
            //     console.log(paperConfig, "configu");
            //     console.log(config);
            //     if (!qz.websocket.isActive()) {
            //         await qz.websocket.connect(config);
            //     }
            //     let data = [
            //         {
            //             type: "pdf",
            //             format: "file",
            //             data: linkpdf
            //         }
            //     ];

            //     qz.print(config, data).catch(e => {
            //         this.$toast.error(e.message);
            //     });
            //     for (let index = 0; index < copies; index++) {
            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //     }
            // }
        },
        async getStatusStock(item_id, quantity) {
            let data = {};
            if (!quantity) quantity = 0;
            await this.$http
                .get(`/${this.resource}/validate_stock/${item_id}/${quantity}`)
                .then(response => {
                    data = response.data;
                });
            return data;
        },
        async clickDeleteItem(index) {
            this.form.items.splice(index, 1);
            this.calculateTotal();
            this.deleteFormPosLocalStorage();
        },
        calculateItem(index, quantity = 0, price = 0) {
            this.ordens[index].food.quantity = quantity;
            this.ordens[index].food.price = price;
            this.form.items[index].quantity = quantity;
            let total_venta = _.round(
                Math.round(parseFloat(quantity) * parseFloat(price) * 10) / 10,
                2
            );
            this.form.items[index].total = total_venta;
            if (this.form.items[index].affectation_igv_type_id == "10") {
                this.form.items[index].total_value = (
                    this.form.items[index].total /
                    (1 + this.percentage_igv / 100)
                ).toFixed(2);
                this.form.items[index].total_taxes = (
                    (quantity * price * (this.percentage_igv / 100)) /
                    (1 + this.percentage_igv / 100)
                ).toFixed(2);
                this.form.items[index].total_base_igv = _.round(
                    this.form.items[index].total /
                        (1 + this.percentage_igv / 100),
                    2
                );
                this.form.items[index].unit_value = (
                    price /
                    (1 + this.percentage_igv / 100)
                ).toFixed(6);
                this.form.items[index].total_igv = _.round(
                    (this.form.items[index].total /
                        (1 + this.percentage_igv / 100)) *
                        (this.percentage_igv / 100),
                    2
                );
                this.form.items[index].total_base_igv = _.round(
                    this.form.items[index].total /
                        (1 + this.percentage_igv / 100),
                    2
                );
            } else {
                this.form.items[index].total_value =
                    Math.round(parseFloat(quantity) * parseFloat(price) * 10) /
                    10;
                this.form.items[index].total_taxes = 0.0;
                this.form.items[index].total_base_igv = _.round(
                    Math.round(parseFloat(quantity) * parseFloat(price) * 10) /
                        10,
                    2
                );
                this.form.items[index].unit_value = price;
                this.form.items[index].total_igv = 0;
                this.form.items[index].total_base_igv = _.round(
                    Math.round(parseFloat(quantity) * parseFloat(price) * 10) /
                        10,
                    2
                );
            }

            this.calculateTotal();
        },
        calculateTotalVariation(formVariation) {
            let total_exportation = 0;
            let total_taxed = 0;
            let total_taxes = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            let total_discount = 0;
            let total_charge = 0;
            //  total_igv = _.round((total / (1+(this.percentage_igv/100))) * (this.percentage_igv/100), 2);

            formVariation.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);
                total += parseFloat(row.total);
                total_taxes += parseFloat(row.total_taxes);
                if (row.sale_affectation_igv_type_id === "10") {
                    total_igv += _.round(
                        parseFloat(row.total_value) *
                            (this.percentage_igv / 100),
                        2
                    );
                    total_value += _.round(row.total_value, 2);
                    total_taxed += parseFloat(row.total_value);
                }
                if (row.sale_affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "30") {
                    total_unaffected += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "40") {
                    total_exportation += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += parseFloat(row.total_value);
                }
            });

            formVariation.total_exportation = _.round(total_exportation, 2);
            formVariation.total_taxed = _.round(total_taxed, 2);
            formVariation.total_taxes = _.round(total_taxes, 2);
            formVariation.total_exonerated = _.round(total_exonerated, 2);
            formVariation.total_unaffsected = _.round(total_unaffected, 2);
            formVariation.total_free = _.round(total_free, 2);
            formVariation.total_igv = _.round(total_igv, 2);
            formVariation.total_value = _.round(total_value, 2);
            formVariation.total = _.round(total, 2);
        },
        calculateTotal(sale_unit_price = 0) {
            let total_discount = 0;
            let total_charge = 0;
            let total_exportation = 0;
            let total_taxed = 0;
            let total_taxes = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            this.ordens.forEach(orden => {
                total += _.round(
                    orden.food.item.quantity * orden.food.price,
                    2
                );
            });

            //  total_igv = _.round((total / (1+(this.percentage_igv/100))) * (this.percentage_igv/100), 2);

            this.form.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);

                total_taxes += parseFloat(row.total_taxes);
                if (row.sale_affectation_igv_type_id === "10") {
                    total_igv += _.round(
                        parseFloat(row.total_value) *
                            (this.percentage_igv / 100),
                        2
                    );
                    total_value += _.round(row.total_value, 2);
                    total_taxed += parseFloat(row.total_value);
                }
                if (row.sale_affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "30") {
                    total_unaffected += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "40") {
                    total_exportation += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += parseFloat(row.total_value);
                }
            });

            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_taxes = _.round(total_taxes, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffsected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            this.form.total_value = _.round(total_value, 2);
            this.form.total = _.round(total, 2);
            if (this.ordens.length > 0) {
                if (this.selectOption == 2) {
                    this.ordens[0].food.item.sale_unit_price = sale_unit_price;
                }
            }
        },
        changeDateOfIssue() {
            // this.searchExchangeRateByDate(this.form.date_of_issue).then(response => {
            //     this.form.exchange_rate_sale = response
            // })
        },
        changeExchangeRate() {
            // this.searchExchangeRateByDate(this.form.date_of_issue).then(
            //   (response) => {
            //     this.form.exchange_rate_sale = response;
            //   }
            // );
        },
        //   import queryString from 'query-string'
        //   this.pagination = response.data.meta
        //   this.pagination.per_page = parseInt(response.data.meta.per_page)
        //  getQueryParameters() {
        //         return queryString.stringify({
        //             page: this.pagination.current_page,
        //             limit: this.limit
        //         })
        //     }
        getQueryParameters(form = {}) {
            return queryString.stringify({
                page: this.pagination.current_page,
                ...form

                // limit: this.limit
            });
        },
        async getFoods(query = "") {
            try {
                const response = await this.$http.get(
                    `${this.resource}/foods?${query}`
                );
                this.loading = true;
                if (response.status == 200) {
                    const {
                        data: { data, meta }
                    } = response;

                    this.allFoods = data.map(d => {
                        if (d.item.lots_group.length > 0) {
                            d.item.lots_group = d.item.lots_group.filter(
                                lt =>
                                    lt.warehouse_id ==
                                    this.worker.establishment_id
                            );
                        }
                        return d;
                    });
                    this.listFoods = this.allFoods;
                    this.pagination = meta;

                    this.selectOption = 4;
                    this.loading = false;
                }
            } catch (e) {
                console.log(e);
                this.loading = false;
            }
        },
        async getTables() {
            //this.loadingInstance = Loading.service({fullscreen: false,lock:true,text:"Espere por favor..."});
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                // this.all_items = response.data.items;
    this.products_to_due = response.data.products_to_due;
                this.payments = response.data.method_payment;
                this.date_last = response.data.date_last;
                this.documentsType = response.data.documents_type;
                this.itemDefault = response.data.item_default;
                this.affectation_igv_types =
                    response.data.affectation_igv_types;
                this.all_customers = response.data.customers;

                let defaultClient = this.all_customers.find(c =>
                    c.name.toLowerCase().includes("varios")
                );
                if (defaultClient) {
                    this.form.customer_id = defaultClient.id;
                }

                this.establishment = response.data.establishment;
                this.currency_types = response.data.currency_types;
                this.customer_default =
                    response.data.customers_default[0] ||
                    response.data.customers[0];

                let [customerVariation] = response.data.customers_variation;
                if (customerVariation) {
                    this.customer_variation = customerVariation;
                }
                this.all_customers = [
                    ...this.all_customers.filter(
                        c => c.id != this.customer_default.id
                    ),
                    this.customer_default
                ];
                this.user = response.data.user;
                // this.desarrollador=response.data.desarrollador
                this.currency_types.length > 0
                    ? this.currency_types[0].id
                    : null;
                // this.currency_type = _.find(this.currency_types, {'id': this.form.currency_type_id})
                // this.changeCurrencyType();
                // this.filterItems();
                // this.changeDateOfIssue();
                // this.changeExchangeRate();
                this.config = response.data.config;
            });

            // this.loadingInstance.close()
        },
        async getSeries() {
            this.$http.get(`/pos/payment_tables`).then(response => {
                this.all_series = response.data.series;
            });
        },
        getColor(i) {
            return this.colors[i % this.colors.length];
        },

        async limpiarForm() {
      
            this.selectOption = 4;
            this.blockCart = false;
            this.variation = false;
            this.cancelOrden();
            if (
                this.configuration.sales_quick == 1 ||
                this.configuration.sales_quick == true
            ) {
                this.ordens = [];
                this.localOrden = [];
                this.initFormItem();
                await this.initForm(this.customer_default.id);
            }
            await this.getFoods();
            await this.calculateTotal();
            this.$refs.input_items.$el.getElementsByTagName("input")[0].focus();
            this.total_sales_pos = 0;
        },
        typesearch() {
            this.ordens = [];
            this.localOrden = [];
            this.orden_items = [];
            this.initForm(this.customer_default.id);
            this.initFormItem();
            this.$refs.input_item?.$el
                ?.getElementsByTagName("input")[0]
                .focus();
            if (this.selectOption == 0) {
                this.type_search = "Buscar Mesa";
            } else if (this.selectOption == 1) {
                this.type_search = "Buscar Orden";
            } else if (this.selectOption == 2) {
                this.type_search = "Buscar Orden";
            } else if (this.selectOption == 3) {
                this.type_search = "Buscar Producto";
            } else if (this.selectOption == 4) {
                this.type_search = "Buscar Producto";
            }
        },
        search_tables() {
            this.listar_tables = this.listtables.filter(f =>
                f.number.toLowerCase().includes(this.input_item.toLowerCase())
            );
        },
        async search_orden() {
            this.loading = true;
            if (this.input_item.length > 0) {
                this.loading = true;
                let parameters = `input_item=${this.input_item}`;
                const response = await this.$http.get(
                    `${this.resource}/search_orden?${parameters}`
                );
                let { ordens, success, message } = response.data;
                if (!success) {
                    this.$toast.error(message);
                    this.loading = false;
                    return;
                }
                if (success) {
                    this.ordenId = ordens.id;
                    this.loading = false;
                    if (this.selectOption == 2) {
                        let f = this.allFoods[0];
                        if (f) {
                            f.llevar = true;
                            if (this.selectOption == 2) {
                                f.item.name_product_pdf = "POR CONSUMO";
                                f.item.quantity = 1;
                            }

                            this.ordens = [
                                ...this.ordens,
                                {
                                    food: f
                                }
                            ];
                        }
                        if (this.selectOption == 2) {
                            this.ordens[0].food.price = 0.0;
                        }

                        this.calculateTotal();
                    } else {
                        this.ordens = ordens.orden_items;
                        for (
                            let index = 0;
                            index < this.ordens.length;
                            index++
                        ) {
                            this.ordens[index].food.item.quantity = this.ordens[
                                index
                            ].quantity;
                        }
                    }
                    // this.ordens = ordens.orden_items;
                    this.form.items = this.ordens.map(o => o.food.item);
                    this.formatItems();
                    this.calculateTotal();
                    this.loading = false;
                }
            } else {
                this.filterItems();
            }
            this.newFood = null;
            this.name_product_pdf = null;
            this.loading = false;
        },
        async search_items(data) {
            let inputitem = this.input_item.toLowerCase();
            if (data == undefined) {
                let form = {
                    value: inputitem,
                    category: this.category
                };
                await this.getFoods(this.getQueryParameters(form));
            } else {
                let form = {
                    value: data,
                    category: this.category
                };
                await this.getFoods(this.getQueryParameters(form));
            }

            //            this.$refs.list_foods.searchFood(inputitem, this.type_search);
            //
            //  this.listFoods = this.allFoods.filter((f) =>
            //   f.description.toLowerCase().includes(inputitem)
            // );
        },
        async search() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(() => {
                this.search_register();
            }, 500);
        },
        async search_register() {
            let inputitem = this.input_item.toLowerCase();
            let query = `value=${inputitem || ""}&category=${this.category ||
                ""}&page=${this.pagination.current_page}`;
            await this.getRecords(query);
        },
        async searchItemsBarcode() {
            if (this.input_item.length > 1) {
                this.loading = true;

                let parameters = `input_item=${this.input_item}`;

                await this.$http
                    .get(`/${this.resource}/search_items?${parameters}`)
                    .then(response => {
                        this.items = response.data.items;
                        this.enabledSearchItemsBarcode();
                        this.loading = false;
                        if (this.items.length == 0) {
                            this.filterItems();
                        }
                    });
            } else {
                await this.filterItems();
            }
        },
        enabledSearchItemsBarcode() {
            if (this.search_item_by_barcode) {
                if (this.items.length == 1) {
                    this.clickAddItem(this.items[0], 0);
                    this.filterItems();
                }

                this.cleanInput();
            }
        },
        changeSearchItemBarcode() {
            this.cleanInput();
        },
        cleanInput() {
            this.input_item = null;
        },
        filterItems() {
            this.items = this.all_items;
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/${this.resource}/table/customers`)
                .then(response => {
                    this.all_customers = response.data;
                    this.form.customer_id = customer_id;
                    // this.changeCustomer();
                });
        },
        reloadDataItems(item_id) {
            this.$http.get(`/${this.resource}/table/items`).then(response => {
                this.all_items = response.data;
                let array_temp = _.filter(this.all_items, {
                    id: item_id
                });
                this.input_item = array_temp[0].description;
                this.filterItems();
                this.searchItems();
                this.clickAddItem(array_temp[0], 0, false);
            });
        },
        selectCurrencyType() {
            this.form.currency_type_id =
                this.form.currency_type_id === "PEN" ? "USD" : "PEN";
            this.changeCurrencyType();
        },
        async changeCurrencyType() {
            this.currency_type = await _.find(this.currency_types, {
                id: this.form.currency_type_id
            });
            let items = [];
            this.form.items.forEach(row => {
                items.push(
                    calculateRowItem(
                        row,
                        this.form.currency_type_id,
                        this.form.exchange_rate_sale
                    )
                );
            });
            this.form.items = items;
            this.calculateTotal();

            await this.setFormPosLocalStorage();
        },
        openFullWindow() {
            location.href = `/${this.resource}/pos_full`;
        },
        back(valor) {
            if (valor == 2) {
                this.place = true;
            } else {
                this.place = false;
                this.$refs.input_item.$el
                    .getElementsByTagName("input")[0]
                    .focus();
            }
        },
        setView() {
            this.place = "cat2";
        },
        nameSets(id) {
            let row = this.items.find(x => x.item_id == id);
            if (row) {
                if (row.sets.length > 0) {
                    return row.sets.join("-");
                } else {
                    return "";
                }
            }
        }
    },
   
    mounted() {

        this.optionsMenu = [
            {
                id: 1,
                title: ["Reimprimir"],
                icon: "fas fa-print ",
                visible: true
            },
            /* {
                    id: 2,
                    title: ["Abrir", "cajon"],
                    icon: "fas fa-cash-register",
                    visible: true
                }, */
            // {
            //     id: 3,
            //     title: ["Reabrir", "tickets"],
            //     icon: "fas fa-folder-open",
            //     visible: true
            // },
            {
                id: 3,
                title: ["Productos"],
                icon: "fas fa-box-open",
                visible: true
            },
            {
                id: 4,
                title: ["Clientes"],
                //icon: "fas fa-hand-holding-water"
                icon: "fas fa-user ",
                visible: !this.conf.direct_sale
            },
            {
                id: 5,
                title: [" Zona "],
                icon: "fas fa-map-pin ",
                visible:
                    this.configuration.restaurant && !this.configuration.college
            },
            {
                id: 6,
                title: ["Venta", "del Dia"],
                icon: "icofont-money-bag",
                visible: true
            },

            {
                id: 7,
                title: ["Historial", ""],
                icon: "fas fa-history ",
                visible: true
            },
            {
                id: 8,
                title: ["Listar "],
                icon: "fas fa-cart-plus",
                visible: true
            },
            {
                id: 9,
                title: ["Matriculas", "Mensualidades"],
                icon: "fas fa-user-edit",
                visible: this.configuration.college && !this.conf.direct_sale
            },
            {
                id: 10,
                title: ["Planes", "Conceptos"],
                icon: "fas fa-user-edit",
                visible: this.configuration.internet
            },
            {
                id: 55,
                title: ["Trabajadores", "Tecnicos"],
                icon: "fas fa-user",
                visible: this.configuration.internet
            },
            {
                id: 56,
                title: ["Zona", "Clientes"],
                icon: "icofont-location-pin",
                visible: true
            }

            // {
            //     title: ["Configuración"],
            //     icon: "fas fa-printer"
            // },
            // {
            //     title: ["Movimiento ", "efectivo"],
            //     icon: "fas fa-printer"
            // },
            // {
            //     title: ["Abrir / Cerrar", " Caja"],
            //     icon: "fas fa-printer"
            // }
        ];
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);

        this.teclasInit();
        Echo.channel("orden_pending").listen(
            `.orden-pending-${this.configuration.socket_channel}`,
            e => {
                let num = Number(e.amount);
                this.ordensPending = this.ordensPending + num;
                if(num>0){
    this.$notify({
                    title: "Aviso",
                    duration: 1500,
                    iconClass:
                      "el-icon-star-on" ,
                    message: "Nueva orden",
                    position: "bottom-left"
                });
                }
            
            }
        );
        Echo.channel("stock_orden").listen(
            `.stock-order-${this.configuration.socket_channel}`,
            e => {
                for (let index = 0; index < e.data.order_item.length; index++) {
                    let xFind = _.find(this.listFoods, {
                        id: e.data.order_item[index].food_id
                    });
                    if (xFind) {
                        let index_find = _.findIndex(this.listFoods, {
                            id: xFind.id
                        });
                        if (index_find !== -1) {
                            let nSaldo =
                                parseInt(
                                    this.listFoods[index_find].item.stock
                                ) - e.data.order_item[index].fquantity;
                            this.listFoods[index_find].item.stock = nSaldo;
                        }
                    }
                }
            }
        );
        Echo.channel("print_orden").listen(
            `.print-order-${this.configuration.socket_channel}`,
            e => {
                console.log("imprimiendo", e);
                if (e.data.direct_printing == true) {
                    if (e.data.printing == true) {
                        this.Printer(
                            e.data.printer,
                            e.data.print,
                            e.data.copies,
                            e.data.user_id,
                            e.data.multiple_boxes,
                            e.data.typeuser,
                            e.data.printing
                        );
                    }
                }
            }
        );
    }
};
</script>
