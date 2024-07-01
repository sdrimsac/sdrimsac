/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

// window.Vue = require('vue');
import Vue from "vue";
import store from "./store";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
//import * as qz from 'qz-tray';
import Axios from "axios";
import lang from "element-ui/lib/locale/lang/es";
import locale from "element-ui/lib/locale";
import VueApexCharts from "vue-apexcharts";
import Select2 from "v-select2-component";
Vue.component("Select2", Select2);
Vue.use(VueApexCharts);
Vue.component("apexchart", VueApexCharts);
locale.use(lang);

//Vue.use(ElementUI)
Vue.use(ElementUI, { size: "small" });
Vue.prototype.$eventHub = new Vue();
Vue.prototype.$http = Axios;

Vue.prototype.$socketUrl = "https://casadedako.xyz";
Vue.prototype.$setStorage = function(name, obj) {
    localStorage.setItem(name, JSON.stringify(obj));
};
// Vue.prototype.$socketUrl = "http://localhost:3800";

/* Vue toast (notificaciones personalizadas )  */
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const options = {
    timeout: 5000
};

Vue.use(Toast, options);
document.addEventListener("DOMContentLoaded", function() {
    getDesarrollador();
    getAreaPrinter();
    getCashId();
});
const getCashId = async () => {
    try{
        const { data } = await Axios.get("/getCashId");
        Vue.prototype.$cashId = null;
    
        if (data != null) {
            if (data.cash_id) {
                Vue.prototype.$cashId = data.cash_id;
            }
        }
    }catch(e){
    }
};
const getDesarrollador = async () => {
    try{
        const { data } = await Axios.get("/getDesarrollador");

    if (data == null) {
        Vue.prototype.$desarrollador = "sdrimsac solutions";
    } else {
        if (data.name) {
            Vue.prototype.$desarrollador = data.name;
        } else {
            Vue.prototype.$desarrollador = data;
        }
    }
    }catch(e){
    }
};
const getAreaPrinter = async () => {
    try{
        const { data } = await Axios.get("/getAreaPrinter");

    if (data == null) {
        Vue.prototype.$areaPrinter = null;
    } else {
        if (data.printer) {
            Vue.prototype.$areaPrinter = data.printer;
        } else {
            Vue.prototype.$areaPrinter = null;
        }
    }
    }catch(e){

    }
};
/* Vue toast (notificaciones personalizadas )  */

//Vue.prototype.$http.defaults.withCredentials = false;

// import VueCharts from 'vue-charts'
// Vue.use(VueCharts);
// import { TableComponent, TableColumn } from 'vue-table-component';
//
// Vue.component('table-component', TableComponent);
// Vue.component('table-column', TableColumn);

// System
Vue.component(
    "system-clients-index",
    require("./views/system/clients/index.vue")
);
Vue.component(
    "system-clients-form",
    require("./views/system/clients/form.vue")
);
Vue.component("system-users-form", require("./views/system/users/form.vue"));

Vue.component(
    "system-certificate-index",
    require("./views/system/certificate/index.vue")
);
Vue.component(
    "system-companies-form",
    require("./views/system/companies/form.vue")
);

// Vue.component('system-accounting-index', require('@viewsModuleAccount/system/accounting/index.vue'));
Vue.component("system-plans-index", require("./views/system/plans/index.vue"));
Vue.component("system-plans-form", require("./views/system/plans/form.vue"));
//auto update
Vue.component("system-update", require("./views/system/update/index.vue"));

Vue.component("system-logo", require("./views/system/logo/index.vue"));
//auto update
Vue.component("system-backup", require("./views/system/backup/index.vue"));

//culqi
Vue.component(
    "system-configuration-culqi",
    require("./views/system/configuration/culqi.vue")
);

//apk url
Vue.component(
    "system-configuration-apk-url",
    require("./views/system/configuration/apk-url.vue")
);

//token
Vue.component(
    "system-configuration-token",
    require("./views/system/configuration/token_ruc_dni.vue")
);

// php info
Vue.component(
    "system-php-configuration",
    require("./views/system/configuration/php_info.vue")
);
Vue.component(
    "system-server-status",
    require("./views/system/configuration/server_status.vue")
);

//Configuración global del login
Vue.component(
    "system-login-settings",
    require("./views/system/configuration/login.vue")
);

Vue.component(
    "system-login-other-configuration",
    require("./views/system/configuration/other_configuration.vue")
);

//
Vue.component(
    "whatsapp-index",
    require("../../modules/Restaurant/Resources/assets/js/views/whatsapp/index.vue")
);

Vue.component("x-input-service", require("./components/InputService.vue"));
Vue.component("x-input-service", require("./components/InputService.vue"));
Vue.component("x-graph", require("./components/graph/src/Graph.vue"));
Vue.component("x-graph-line", require("./components/graph/src/GraphLine.vue"));
Vue.component(
    "x-report-credit-daily-cash",
    require("../../modules/Report/Resources/assets/js/views/credit/daily_cash.vue")
);

Vue.component("whatsapp-index", require("../../modules/Restaurant/Resources/assets/js/views/whatsapp/index.vue").default);
Vue.component("vip-items", require("../../modules/Vip/Resources/assets/js/views/index.vue").default);
Vue.component("etiqueta-index", require("../../modules/Etiquetas/Resources/assets/js/views/index.vue").default);
Vue.component("inventory-index", require("../../modules/inventory/Resources/assets/js/inventory/inventory.vue").default);
Vue.component("restaurant-food-list", require("../../modules/Restaurant/Resources/assets/js/views/food/index.vue").default);
Vue.component("tenant-restaurant-index", require("../../modules/Restaurant/Resources/assets/js/views/restaurant.vue").default);
Vue.component("tenant-restaurant-kitchen", require("../../modules/Restaurant/Resources/assets/js/views/kitchen.vue").default);
Vue.component("tenant-restaurant-items", require("../../modules/Restaurant/Resources/assets/js/views/configuration/items.vue").default);
Vue.component("restaurant-ordens-index", require("../../modules/Restaurant/Resources/assets/js/views/ordens/index.vue").default);
Vue.component("restaurant-worker-login", require("../../modules/Restaurant/Resources/assets/js/views/login/login.vue").default);
Vue.component("tenant-item-color-size-index", require("./views/item_color_size/index.vue").default);
Vue.component("tenant-item-sets-index", require("./views/item_sets/index.vue").default);
Vue.component("restaurant-worker-dashboard", require("../../modules/Restaurant/Resources/assets/js/views/worker/dashboard.vue").default);
Vue.component("restaurant-kitchen-dashboard", require("../../modules/Restaurant/Resources/assets/js/views/kitchen/dashboard.vue").default);
Vue.component("tenant-restaurant-workers", require("../../modules/Restaurant/Resources/assets/js/views/workers/workers.vue").default);
Vue.component("tenant-restaurant-pos", require("../../modules/Restaurant/Resources/assets/js/views/pos/index.vue").default);
Vue.component("tenant-dashboard-index", require("../../modules/Dashboard/Resources/assets/js/views/index.vue").default);
Vue.component("tenant-companies-form", require("./views/companies/form.vue").default);
Vue.component("tenant-account-export", require("../../modules/Format/Resources/assets/js/views/account/format.vue").default);
Vue.component("tenant-companies-logo", require("./views/companies/logo.vue").default);
Vue.component("tenant-certificates-index", require("./views/certificates/index.vue").default);
Vue.component("tenant-certificates-form", require("./views/certificates/form.vue").default);
Vue.component("tenant-configurations-form", require("./views/configurations/form.vue").default);
Vue.component("tenant-configurations-visual", require("./views/configurations/visual.vue").default);
Vue.component("tenant-configurations-pdf", require("./views/configurations/pdf_templates.vue").default);
Vue.component("tenant-items-client", require("./views/items/items_client.vue").default);
Vue.component("tenant-items-index", require("./views/items/index.vue").default);
Vue.component("tenant-persons-index", require("./views/persons/index.vue").default);
Vue.component("tenant-users-form", require("./views/users/form.vue").default);
Vue.component("tenant-documents-index", require("./views/documents/index.vue").default);
Vue.component("restaurant-documents-index", require("../../modules/Restaurant/Resources/assets/js/views/documents/index.vue").default);
Vue.component("tenant-documents-invoice", require("./views/documents/invoice.vue").default);
Vue.component("tenant-documents-note-other", require("./views/documents/note_other.vue").default);
Vue.component("tenant-documents-note", require("./views/documents/note.vue").default);
Vue.component("tenant-summaries-index", require("./views/summaries/index.vue").default);
Vue.component("tenant-voided-index", require("./views/voided/index.vue").default);
Vue.component("tenant-options-form", require("./views/options/form.vue").default);
Vue.component("tenant-users-index", require("./views/users/index.vue").default);
Vue.component("tenant-banks-index", require("./views/banks/index.vue").default);
Vue.component("tenant-unit_types-index", require("./views/unit_types/index.vue").default);
Vue.component("tenant-establishments-index", require("./views/establishments/index.vue").default);
Vue.component("tenant-currency-types-index", require("./views/currency_types/index.vue").default);
Vue.component("tenant-purchases-index", require("./views/purchases/index.vue").default);
Vue.component("tenant-purchases-form", require("./views/purchases/form.vue").default);
Vue.component("tenant-purchases-edit", require("./views/purchases/form_edit.vue").default);
Vue.component("tenant-attribute_types-index", require("./views/attribute_types/index.vue").default);
Vue.component("tenant-warehouses", require("./views/components/warehouses.vue").default);
Vue.component("tenant-arqueos-form", require("./views/arqueos/index.vue").default);
Vue.component("tenant-tasks-lists", require("./views/tasks/lists.vue").default);
Vue.component("tenant-tasks-form", require("./views/tasks/form.vue").default);
Vue.component("tenant-sale-notes-credit-penalty", require("./views/sale_notes/credit_penalty.vue").default);
Vue.component("tenant-sale-notes-index", require("./views/sale_notes/index.vue").default);
Vue.component("tenant-sale-notes-form", require("./views/sale_notes/form.vue").default);
Vue.component("tenant-cash-transfer-index", require("../../modules/Restaurant/Resources/assets/js/views/cash_transfer/index.vue").default);
Vue.component("tenant-cash-transfer-index-report", require("../../modules/Restaurant/Resources/assets/js/views/cash_transfer/report.vue").default);
Vue.component("tenant-cash-index", require("../../modules/Restaurant/Resources/assets/js/views/cash/index.vue").default);
Vue.component("cash-index-closed", require("@views/cash/closed.vue").default);
Vue.component("cash-index-main", require("@views/cash/main.vue").default);
Vue.component("tenant-card-brands-index", require("./views/card_brands/index.vue").default);
Vue.component("tenant-payment-method-index", require("./views/payment_method/index.vue").default);
Vue.component("tenant-category-index", require("./views/category/index.vue").default);
Vue.component("inventory-transactions-index", require("../../modules/Inventory/Resources/assets/js/transactions/index.vue").default);
Vue.component("inventory-transfers-index", require("../../modules/Inventory/Resources/assets/js/transfers/index.vue").default);
Vue.component("inventory-transfers-place-index", require("../../modules/Inventory/Resources/assets/js/transfers_place/index.vue").default);
Vue.component("tenant-account-format", require("../../modules/Format/Resources/assets/js/views/account/format.vue").default);
Vue.component("warehouses-index", require("../../modules/Inventory/Resources/assets/js/warehouses/index.vue").default);
Vue.component("tenant-inventories-form", require("../../modules/Inventory/Resources/assets/js/config/form.vue").default);
Vue.component("tenant-documents-not-sent", require("../../modules/Document/Resources/assets/js/views/documents/not_sent.vue").default);
Vue.component("tenant-report-purchases-index", require("../../modules/Report/Resources/assets/js/views/purchases/index.vue").default);
Vue.component("tenant-report-documents-index", require("../../modules/Report/Resources/assets/js/views/documents/index.vue").default);
Vue.component("tenant-report-customers-index", require("../../modules/Report/Resources/assets/js/views/customers/index.vue").default);
Vue.component("tenant-report-items-index", require("../../modules/Report/Resources/assets/js/views/items/index.vue").default);
Vue.component("tenant-report-items-defeated", require("../../modules/Report/Resources/assets/js/views/items/defeated.vue").default);
Vue.component("tenant-report-sale_notes-index", require("../../modules/Report/Resources/assets/js/views/sale_notes/index.vue").default);
Vue.component("tenant-report-cash-index", require("../../modules/Report/Resources/assets/js/views/cash/index.vue").default);
Vue.component("tenant-series-configurations-index", require("../../modules/Document/Resources/assets/js/views/series_configurations/index.vue").default);
Vue.component("tenant-report-order-notes-consolidated-index", require("../../modules/Report/Resources/assets/js/views/order_notes_consolidated/index.vue").default);
Vue.component("tenant-report-general-items-index", require("../../modules/Report/Resources/assets/js/views/general_items/index.vue").default);
Vue.component("tenant-report-order-notes-general-index", require("../../modules/Report/Resources/assets/js/views/order_notes_general/index.vue").default);
Vue.component("tenant-report-sales-consolidated-index", require("../../modules/Report/Resources/assets/js/views/sales_consolidated/index.vue").default);
Vue.component("tenant-categories-index", require("../../modules/Item/Resources/assets/js/views/categories/index.vue").default);
Vue.component("tenant-brands-index", require("../../modules/Item/Resources/assets/js/views/brands/index.vue").default);
Vue.component("tenant-manufactured-index", require("../../modules/Item/Resources/assets/js/views/manufactured/index.vue").default);
Vue.component("tenant-report-valued-kardex", require("../../modules/Inventory/Resources/assets/js/valued_kardex/index.vue").default);
Vue.component("tenant-finance-global-payments-index", require("../../modules/Finance/Resources/assets/js/views/global_payments/index.vue").default);
Vue.component("tenant-finance-balance-index", require("../../modules/Finance/Resources/assets/js/views/balance/index.vue").default);
Vue.component("tenant-finance-payment-method-types-index", require("../../modules/Finance/Resources/assets/js/views/payment_method_types/index.vue").default);
Vue.component("tenant-finance-unpaid-index", require("@viewsModuleFinance/unpaid/index.vue").default);
Vue.component("tenant-finance-income-index", require("@viewsModuleFinance/income/index.vue").default);
Vue.component("tenant-finance-income-form", require("@viewsModuleFinance/income/form.vue").default);
Vue.component("tenant-income-types-index", require("@viewsModuleFinance/income_types/index.vue").default);
Vue.component("tenant-income-reasons-index", require("@viewsModuleFinance/income_reasons/index.vue").default);
Vue.component("tenant-person-types-index", require("./views/person_types/index.vue").default);
Vue.component("x-form-group", require("./components/FormGroup.vue").default);
Vue.component("tenant-account-payment-index", require("./views/account/payment_index.vue").default);
Vue.component("tenant-account-configuration-index", require("./views/account/configuration.vue").default);
Vue.component("tenant-groups-index", require("./views/groups/index.vue").default);
Vue.component("tenant-subcategories-index", require("./views/subcategory/index.vue").default);
Vue.component("tenant-boxes-index", require("./views/boxes/index.vue").default);
Vue.component("tenant-boxes-expenses-index", require("../../modules/Restaurant/Resources/assets/js/views/expenses/index.vue").default);
Vue.component("tenant-boxes-incomes-index", require("../../modules/Restaurant/Resources/assets/js/views/incomes/index.vue").default);
Vue.component("tenant-incomes-index", require("./views/incomebox/index.vue").default);
Vue.component("tenant-boxes-reports", require("./views/boxes/report.vue").default);
Vue.component("tenant-boxes-reports-global", require("./views/boxes/global.vue").default);
Vue.component("tenant-boxes-reports-pos", require("../../modules/Restaurant/Resources/assets/js/views/boxes/report.vue").default);
Vue.component("inventory-form-masive", require("../../modules/Inventory/Resources/assets/js/transfers/form_masive.vue").default);
Vue.component("items-lot", require("../../modules/LotItem/Resources/assets/js/view/index.vue").default);
Vue.component("items-lot-group", require("../../modules/Item/Resources/assets/js/views/item_lots_group/index.vue").default);
Vue.component("tenant-hotels-room-report", require("../../modules/Restaurant/Resources/assets/js/views/reports/rooms.vue").default);
Vue.component("tenant-login-default", require("./views/login/index.vue").default);
Vue.component("cash-report", require("../../modules/Restaurant/Resources/assets/js/views/cash/report.vue").default);
Vue.component("toll-index", require("../../resources/js/views/toll/index.vue").default);
Vue.component("college-persons", require("../../modules/College/Resources/assets/js/views/persons/index.vue").default);
Vue.component("college-levels", require("../../modules/College/Resources/assets/js/views/levels/index.vue").default);
Vue.component("college-periods", require("../../modules/College/Resources/assets/js/views/periods/index.vue").default);
Vue.component("college-plans", require("../../modules/College/Resources/assets/js/views/plans/index.vue").default);
Vue.component("college-registers", require("../../modules/College/Resources/assets/js/views/registers/index.vue").default);
Vue.component("college-classrooms", require("../../modules/College/Resources/assets/js/views/classrooms/index.vue").default);
Vue.component("college-students", require("../../modules/College/Resources/assets/js/views/students/index.vue").default);
Vue.component("college-penalties", require("../../modules/College/Resources/assets/js/views/penalties/index.vue").default);
Vue.component("stockmin-report", require("../../modules/Inventory/Resources/assets/js/stockminReport/report.vue").default);
Vue.component("valued-report", require("../../modules/Inventory/Resources/assets/js/valuedReport/index.vue").default);
Vue.component("college-schoolsupplies", require("../../modules/College/Resources/assets/js/views/schoolSuplies/index.vue").default);
Vue.component("tenant-report-kardex-master", require("../../modules/Inventory/Resources/assets/js/kardex/index.vue").default);
Vue.component("tenant-dispatches-index", require("./views/dispatches/index.vue").default);
Vue.component("tenant-dispatches-form", require("./views/dispatches/form.vue").default);
Vue.component("tenant-dispatches-create", require("./views/dispatches/create.vue").default);
Vue.component("tenant-internet-pos", require("../../modules/Internet/Resources/assets/js/view/pos/index.vue").default);
Vue.component("tenant-health-global-index", require("./views/health_global/index.vue").default);
Vue.component("tenant-internet-workersadm", require("../../modules/Internet/Resources/assets/js/view/workers/index.vue").default);
Vue.component("tenant-internet-planes", require("../../modules/Internet/Resources/assets/js/view/planes/index.vue").default);
Vue.component("items-stock", require("./views/items/check_stock.vue").default);
Vue.component("tenant-quotations-index", require("./views/quotations/index.vue").default);
Vue.component("tenant-quotations-form", require("./views/quotations/form.vue").default);
Vue.component("tenant-quotations-edit", require("./views/quotations/form_edit.vue").default);
Vue.component("report-consignment-index", require("../../modules/Report/Resources/assets/js/views/consignment/index.vue").default);
Vue.component("report-credit-index-cash", require("../../modules/Report/Resources/assets/js/views/credit/index_cash.vue").default);
Vue.component("report-credit-daily-cash", require("../../modules/Report/Resources/assets/js/views/credit/daily_cash.vue").default);
Vue.component("report-credit-index", require("../../modules/Report/Resources/assets/js/views/credit/index.vue").default);
Vue.component("tenant-search-index", require("./views/search/index.vue").default);
Vue.component("tenant-registers-index", require("./views/registers/index.vue").default);
Vue.component("tenant-consignment-index", require("@viewsModuleConsignment/index.vue").default);
Vue.component("report-series-vendidas", require("../../modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue").default);
Vue.component("tenant-sellers-index", require("./views/sellers/index.vue").default);
Vue.component("tenant-bank_accounts-index", require("./views/bank_accounts/index.vue").default);
Vue.component("tenant-principal-categories-index", require("./views/principal_categories/index.vue").default);
Vue.component("tenant-commercial-treatment-index", require("./views/commercial_treatment/index.vue").default);
Vue.component("tenant-credit-list-index", require("./views/credit_list/index.vue").default);
Vue.component("worker-cleaner", require("../../modules/Restaurant/Resources/assets/js/views/cleaner/index.vue").default);
Vue.component("worker-maintenance", require("../../modules/Restaurant/Resources/assets/js/views/maintenance/index.vue").default);


const app = new Vue({
    store,
    el: "#main",

    components: {
    

    

    }
});
