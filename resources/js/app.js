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
});
const getDesarrollador = async () =>{
    const { data } = await Axios.get("/getDesarrollador");
    if(data == null){
        Vue.prototype.$desarrollador = "sdrimsac solutions";
    }else{
        if(data.name){
            Vue.prototype.$desarrollador = data.name;
        }else{
            Vue.prototype.$desarrollador = data;
        }
    }
}

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

const app = new Vue({

    store,
    el: "#main",

    components: {
        "whatsapp-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/whatsapp/index.vue"
            ),
        "vip-items": () =>
            import(
                /* webpackChunkName: "js/Vip-items" */

                "../../modules/Vip/Resources/assets/js/views/index.vue"
            ),
        "etiqueta-index": () =>
            import(
                /* webpackChunkName: "js/etiqueta-index" */

                "../../modules/Etiquetas/Resources/assets/js/views/index.vue"
            ),

        "inventory-index": () =>
            import(
                /* webpackChunkName: "js/inventory-index" */

                "../../modules/inventory/Resources/assets/js/inventory/inventory.vue"
            ),
        "restaurant-food-list": () =>
            import(
                /* webpackChunkName: "js/restaurant-food-list" */

                "../../modules/Restaurant/Resources/assets/js/views/food/index.vue"
            ),

        "tenant-restaurant-index": () =>
            import(
                /* webpackChunkName: "js/tenant-restaurant-index" */

                "../../modules/Restaurant/Resources/assets/js/views/restaurant.vue"
            ),

        "tenant-restaurant-kitchen": () =>
            import(
                /* webpackChunkName: "js/tenant-restaurant-kitchen " */

                "../../modules/Restaurant/Resources/assets/js/views/kitchen.vue"
            ),

        "tenant-restaurant-items": () =>
            import(
                /* webpackChunkName:tenant-restaurant-items"js/ " */

                "../../modules/Restaurant/Resources/assets/js/views/configuration/items.vue"
            ),

        "restaurant-ordens-index": () =>
            import(
                /* webpackChunkName:restaurant-ordens-index"js/ " */

                "../../modules/Restaurant/Resources/assets/js/views/ordens/index.vue"
            ),

        "restaurant-worker-login": () =>
            import(
                /* webpackChunkName:restaurant-worker-login"js/ " */

                "../../modules/Restaurant/Resources/assets/js/views/login/login.vue"
            ),

        "tenant-item-sets-index": () =>
            import(
                /* webpackChunkName:"tenat-tem-sets-indexjs/ " */ "./views/item_sets/index.vue"
            ),
        "restaurant-worker-dashboard": () =>
            import(
                /* webpackChunkName:"js/restaurant-worker-dashboard" */
                "../../modules/Restaurant/Resources/assets/js/views/worker/dashboard.vue"
            ),
        "restaurant-kitchen-dashboard": () =>
            import(
                /* webpackChunkName:"js/restaurant-kitchen-dashboard" */
                "../../modules/Restaurant/Resources/assets/js/views/kitchen/dashboard.vue"
            ),
        "tenant-restaurant-workers": () =>
            import(
                /* webpackChunkName:"js/tenant-restaurant-workers" */
                "../../modules/Restaurant/Resources/assets/js/views/workers/workers.vue"
            ),
        "tenant-restaurant-pos": () =>
            import(
                /* webpackChunkName:"js/tenant-restaurant-pos" */
                "../../modules/Restaurant/Resources/assets/js/views/pos/index.vue"
            ),
        "tenant-dashboard-index": () =>
            import(
                /* webpackChunkName:"js/tenant-dashboard-index" */
                "../../modules/Dashboard/Resources/assets/js/views/index.vue"
            ),
        "x-graph": () =>
            import(
                /* webpackChunkName:"js/x-graph" */
                "./components/graph/src/Graph.vue"
            ),
        "x-graph-line": () =>
            import(
                /* webpackChunkName:"js/x-graph-line" */
                "./components/graph/src/GraphLine.vue"
            ),
        "tenant-companies-form": () =>
            import(
                /* webpackChunkName:"js/tenant-companies-form" */
                "./views/companies/form.vue"
            ),
        "tenant-account-export": () =>
            import(
                /* webpackChunkName:"js/tenant-account-export" */
                "../../modules/Format/Resources/assets/js/views/account/format.vue"
            ),
        "tenant-companies-logo": () =>
            import(
                /* webpackChunkName:"js/tenant-companies-logo" */
                "./views/companies/logo.vue"
            ),

        "tenant-certificates-index": () =>
            import(
                /* webpackChunkName:"js/tenant-certificates-index" */
                "./views/certificates/index.vue"
            ),

        "tenant-certificates-form": () =>
            import(
                /* webpackChunkName:"js/tenant-certificates-form" */
                "./views/certificates/form.vue"
            ),
        "tenant-configurations-form": () =>
            import(
                /* webpackChunkName:"js/tenant-configurations-form" */
                "./views/configurations/form.vue"
            ),
        "tenant-configurations-visual": () =>
            import(
                /* webpackChunkName:"js/tenant-configurations-visual" */
                "./views/configurations/visual.vue"
            ),
        "tenant-configurations-pdf": () =>
            import(
                /* webpackChunkName:"js/tenant-configurations-pdf" */
                "./views/configurations/pdf_templates.vue"
            ),
        "tenant-items-index": () =>
            import(
                /* webpackChunkName:"js/tenant-items-index" */
                "./views/items/index.vue"
            ),
        "tenant-persons-index": () =>
            import(
                /* webpackChunkName:"js/tenant-persons-index" */
                "./views/persons/index.vue"
            ),

        "tenant-users-form": () =>
            import(
                /* webpackChunkName:"js/tenant-users-form" */
                "./views/users/form.vue"
            ),
        "tenant-documents-index": () =>
            import(
                /* webpackChunkName:"js/tenant-documents-index" */
                "./views/documents/index.vue"
            ),
        "restaurant-documents-index": () =>
            import(
                /* webpackChunkName:"js/restaurant-documents-index" */
                "../../modules/Restaurant/Resources/assets/js/views/documents/index.vue"
            ),
        "tenant-documents-invoice": () =>
            import(
                /* webpackChunkName:"js/tenant-documents-invoice" */
                "./views/documents/invoice.vue"
            ),

        "tenant-documents-note": () =>
            import(
                /* webpackChunkName:"js/tenant-documents-note" */
                "./views/documents/note.vue"
            ),
        "tenant-summaries-index": () =>
            import(
                /* webpackChunkName:"js/tenant-summaries-index" */ "./views/summaries/index.vue"
            ),
        "tenant-voided-index": () =>
            import(
                /* webpackChunkName:"js/tenant-voided-index" */ "./views/voided/index.vue"
            ),

        "tenant-options-form": () =>
            import(
                /* webpackChunkName:"js/tenant-options-form" */ "./views/options/form.vue"
            ),
        "tenant-users-index": () =>
            import(
                /* webpackChunkName:"js/tenant-users-index" */ "./views/users/index.vue"
            ),
        "tenant-banks-index": () =>
            import(
                /* webpackChunkName:"js/tenant-banks-index" */ "./views/banks/index.vue"
            ),

        "tenant-unit_types-index": () =>
            import(
                /* webpackChunkName:"js/tenant-unit_types-index" */ "./views/unit_types/index.vue"
            ),

        "tenant-establishments-index": () =>
            import(
                /* webpackChunkName:"js/tenant-establishments-index" */ "./views/establishments/index.vue"
            ),

        "tenant-currency-types-index": () =>
            import(
                /* webpackChunkName:"js/tenant-currencu-types-index" */ "./views/currency_types/index.vue"
            ),

        "tenant-purchases-index": () =>
            import(
                /* webpackChunkName:"js/tenant-purchases-index" */ "./views/purchases/index.vue"
            ),
        "tenant-purchases-form": () =>
            import(
                /* webpackChunkName:"js/tenant-purchases-form" */ "./views/purchases/form.vue"
            ),

        "tenant-purchases-edit": () =>
            import(
                /* webpackChunkName:"js/tenant-purchases-edit" */ "./views/purchases/form_edit.vue"
            ),

        "tenant-attribute_types-index": () =>
            import(
                /* webpackChunkName:"js/tenant-attribute_types-index" */ "./views/attribute_types/index.vue"
            ),

        "tenant-warehouses": () =>
            import(
                /* webpackChunkName:"js/tenant-warehouses" */ "./views/components/warehouses.vue"
            ),

        "tenant-arqueos-form": () =>
            import(
                /* webpackChunkName:"js/tenant-arqueos-form" */ "./views/arqueos/index.vue"
            ),
        "tenant-tasks-lists": () =>
            import(
                /* webpackChunkName:"js/tenant-taks-form" */ "./views/tasks/lists.vue"
            ),
        "tenant-tasks-form": () =>
            import(
                /* webpackChunkName:"js/tenant-task-form" */ "./views/tasks/form.vue"
            ),

        "tenant-sale-notes-index": () =>
            import(
                /* webpackChunkName:"js/tenant-sale-notes-index" */ "./views/sale_notes/index.vue"
            ),
        "tenant-sale-notes-form": () =>
            import(
                /* webpackChunkName:"js/tenant-sale-notes-form" */ "./views/sale_notes/form.vue"
            ),

        "tenant-cash-index": () =>
            import(
                /* webpackChunkName:"js/tenant-cash-index" */
                "../../modules/Restaurant/Resources/assets/js/views/cash/index.vue"
            ),
        "cash-index-closed": () =>
            import(
                /* webpackChunkName:"js/tenant-cash-closed" */
                "@views/cash/closed.vue"
            ),
        "tenant-card-brands-index": () =>
            import(
                /* webpackChunkName:"js/tenant-card-brands-index" */ "./views/card_brands/index.vue"
            ),

        "tenant-payment-method-index": () =>
            import(
                /* webpackChunkName:"js/tenant-payment-method-index" */ "./views/payment_method/index.vue"
            ),

        "tenant-category-index": () =>
            import(
                /* webpackChunkName:"js/tenant-category-index" */ "./views/category/index.vue"
            ),

        "inventory-transfers-index": () =>
            import(
                /* webpackChunkName:"js/inventory-transfers-index" */
                "../../modules/Inventory/Resources/assets/js/transfers/index.vue"
            ),
        "inventory-transfers-place-index": () =>
            import(
                /* webpackChunkName:"js/inventory-transfers-index" */
                "../../modules/Inventory/Resources/assets/js/transfers_place/index.vue"
            ),
        "tenant-account-format": () =>
            import(
                /* webpackChunkName:"js/tenant-accouint-format" */
                "../../modules/Format/Resources/assets/js/views/account/format.vue"
            ),

        "warehouses-index": () =>
            import(
                /* webpackChunkName:"js/warehouses-index" */
                "../../modules/Inventory/Resources/assets/js/warehouses/index.vue"
            ),

        "tenant-inventories-form": () =>
            import(
                /* webpackChunkName:"js/tenant-inventories-form" */
                "../../modules/Inventory/Resources/assets/js/config/form.vue"
            ),

        "tenant-documents-not-sent": () =>
            import(
                /* webpackChunkName:"js/tenant-documents-not-sent" */
                "../../modules/Document/Resources/assets/js/views/documents/not_sent.vue"
            ),
        "tenant-report-purchases-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-purchases-index"*/
                "../../modules/Report/Resources/assets/js/views/purchases/index.vue"
            ),
        "tenant-report-documents-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-documents-index"*/
                "../../modules/Report/Resources/assets/js/views/documents/index.vue"
            ),
        "tenant-report-customers-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-0customers-index"*/
                "../../modules/Report/Resources/assets/js/views/customers/index.vue"
            ),
        "tenant-report-items-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-items-index"*/
                "../../modules/Report/Resources/assets/js/views/items/index.vue"
            ),
        "tenant-report-items-defeated": () =>
            import(
                /* webpackChunkName:"js/tenant-report-items-defeated"*/
                "../../modules/Report/Resources/assets/js/views/items/defeated.vue"
            ),

        "tenant-report-sale_notes-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-sale_notes-index"*/
                "../../modules/Report/Resources/assets/js/views/sale_notes/index.vue"
            ),

        "tenant-report-cash-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-cash-index"*/
                "../../modules/Report/Resources/assets/js/views/cash/index.vue"
            ),

        "tenant-series-configurations-index": () =>
            import(
                /* webpackChunkName:"js/tenant-series-configurations-index"*/
                "../../modules/Document/Resources/assets/js/views/series_configurations/index.vue"
            ),

        "tenant-report-order-notes-consolidated-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-order-notes-consolidated-index"*/
                "../../modules/Report/Resources/assets/js/views/order_notes_consolidated/index.vue"
            ),

        "tenant-report-general-items-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-general-items-index"*/
                "../../modules/Report/Resources/assets/js/views/general_items/index.vue"
            ),

        "tenant-report-order-notes-general-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-order-notes-general-index"*/
                "../../modules/Report/Resources/assets/js/views/order_notes_general/index.vue"
            ),

        "tenant-report-sales-consolidated-index": () =>
            import(
                /* webpackChunkName:"js/tenant-report-sales-consolidated-index"*/
                "../../modules/Report/Resources/assets/js/views/sales_consolidated/index.vue"
            ),

        "tenant-categories-index": () =>
            import(
                /* webpackChunkName:"js/tenant-categories-index"*/
                "../../modules/Item/Resources/assets/js/views/categories/index.vue"
            ),

        "tenant-brands-index": () =>
            import(
                /* webpackChunkName:"js/tenant-brands-index"*/
                "../../modules/Item/Resources/assets/js/views/brands/index.vue"
            ),

        "tenant-report-valued-kardex": () =>
            import(
                /* webpackChunkName:"js/tenat-report-valued-kardex"*/
                "../../modules/Inventory/Resources/assets/js/valued_kardex/index.vue"
            ),

        "tenant-finance-global-payments-index": () =>
            import(
                /* webpackChunkName:"js/"*/
                "../../modules/Finance/Resources/assets/js/views/global_payments/index.vue"
            ),

        "tenant-finance-balance-index": () =>
            import(
                /* webpackChunkName:"js/tenant-finance-balance-index"*/
                "../../modules/Finance/Resources/assets/js/views/balance/index.vue"
            ),

        "tenant-finance-payment-method-types-index": () =>
            import(
                /* webpackChunkName:"js/tenant-finance-payment-method-types-index"*/
                "../../modules/Finance/Resources/assets/js/views/payment_method_types/index.vue"
            ),

        "tenant-finance-unpaid-index": () =>
            import(
                /* webpackChunkName:"js/tenant-finance-unpaid-index"*/
                "@viewsModuleFinance/unpaid/index.vue"
            ),

        "tenant-finance-income-index": () =>
            import(
                /* webpackChunkName:"js/tenant-finance-income-index"*/
                "@viewsModuleFinance/income/index.vue"
            ),

        "tenant-finance-income-form": () =>
            import(
                /* webpackChunkName:"js/tenant-finance-income-form"*/
                "@viewsModuleFinance/income/form.vue"
            ),

        "tenant-income-types-index": () =>
            import(
                /* webpackChunkName:"js/tenant-income-types-index"*/
                "@viewsModuleFinance/income_types/index.vue"
            ),

        "tenant-income-reasons-index": () =>
            import(
                /* webpackChunkName:"js/tenant-income-reason-index"*/
                "@viewsModuleFinance/income_reasons/index.vue"
            ),

        "tenant-person-types-index": () =>
            import(
                /* webpackChunkName:"js/tenant-person-types-index"*/
                "./views/person_types/index.vue"
            ),

        "x-form-group": () =>
            import(
                /* webpackChunkName:"js/x-form-grpup"*/

                "./components/FormGroup.vue"
            ),

        "tenant-account-payment-index": () =>
            import(
                /* webpackChunkName:"js/tenant-account-payment-index"*/
                "./views/account/payment_index.vue"
            ),

        "tenant-account-configuration-index": () =>
            import(
                /* webpackChunkName:"js/tenant-account-configuration-index"*/
                "./views/account/configuration.vue"
            ),

        "tenant-groups-index": () =>
            import(
                /* webpackChunkName:"js/tenant-groups-index"*/
                "./views/groups/index.vue"
            ),

        "tenant-subcategories-index": () =>
            import(
                /* webpackChunkName:"js/tenant-subcategories-index"*/
                "./views/subcategory/index.vue"
            ),

        "tenant-boxes-index": () =>
            import(
                /* webpackChunkName:"js/tenant-boxes-index"*/
                "./views/boxes/index.vue"
            ),

        "tenant-boxes-expenses-index": () =>
            import(
                /* webpackChunkName:"js/tenant-boxes-expenses-index"*/
                "../../modules/Restaurant/Resources/assets/js/views/expenses/index.vue"
            ),

        "tenant-boxes-incomes-index": () =>
            import(
                /* webpackChunkName:"js/tenant-boxes-incomes-index"*/
                "../../modules/Restaurant/Resources/assets/js/views/incomes/index.vue"
            ),

        "tenant-incomes-index": () =>
            import(
                /* webpackChunkName:"js/tenant-incomes-index"*/
                "./views/incomebox/index.vue"
            ),

        "tenant-boxes-reports": () =>
            import(
                /* webpackChunkName:"js/tenant-boxes-reports"*/
                "./views/boxes/report.vue"
            ),

        "tenant-boxes-reports-pos": () =>
            import(
                /* webpackChunkName: "js/tentant-boxes-report" */

                "../../modules/Restaurant/Resources/assets/js/views/boxes/report.vue"
            ),
        "inventory-form-masive": () =>
            import(
                /* webpackChunkName: "js/inventory-form-masive" */

                "../../modules/Inventory/Resources/assets/js/transfers/form_masive.vue"
            ),
        "items-lot": () =>
            import(
                /* webpackChunkName:"js/items-lot/"*/

                "../../modules/LotItem/Resources/assets/js/view/index.vue"
            ),
        "items-lot-group": () =>
            import(
                /* webpackChunkName:"js/items-lot/"*/

                "../../modules/Item/Resources/assets/js/views/item_lots_group/index.vue"
            ),

        "tenant-boxes-reports": () =>
            import(
                /* webpackChunkName:"js/tenant-boxes-reports"*/
                "./views/boxes/report.vue"
            ),

        "tenant-boxes-reports-pos": () =>
            import(
                /* webpackChunkName: "js/tentant-boxes-report" */

                "../../modules/Restaurant/Resources/assets/js/views/boxes/report.vue"
            ),

        "tenant-login-default": () =>
            import(
                /* webpackChunkName:"js/tenant-login-default"*/
                "./views/login/index.vue"
            ),

        "cash-report": () =>
            import(
                /* webpackChunkName:"js/cash-report"*/
                "../../modules/Restaurant/Resources/assets/js/views/cash/report.vue"
            ),
        "toll-index": () =>
            import(
                /* webpackChunkName:"js/toll-index"*/
                "../../resources/js/views/toll/index.vue"
            ),

        "college-persons": () =>
            import(
                /* webpackChunkName:"js/college-persons"*/
                "../../modules/College/Resources/assets/js/views/persons/index.vue"
            ),

        "college-levels": () =>
            import(
                /* webpackChunkName:"js/college-levels"*/
                "../../modules/College/Resources/assets/js/views/levels/index.vue"
            ),

        "college-periods": () =>
            import(
                /* webpackChunkName:"js/college-periods"*/
                "../../modules/College/Resources/assets/js/views/periods/index.vue"
            ),
        "college-plans": () =>
            import(
                /* webpackChunkName:"js/college-plans"*/
                "../../modules/College/Resources/assets/js/views/plans/index.vue"
            ),
        "college-registers": () =>
            import(
                /* webpackChunkName:"js/college-registers"*/
                "../../modules/College/Resources/assets/js/views/registers/index.vue"
            ),
        "college-classrooms": () =>
            import(
                /* webpackChunkName:"js/college-classrooms"*/
                "../../modules/College/Resources/assets/js/views/classrooms/index.vue"
            ),

        "college-students": () =>
            import(
                /* webpackChunkName:"js/college-students"*/
                "../../modules/College/Resources/assets/js/views/students/index.vue"
            ),

        "college-penalties": () =>
            import(
                /* webpackChunkName:"js/college-penalties"*/
                "../../modules/College/Resources/assets/js/views/penalties/index.vue"
            ),
        "stockmin-report": () =>
            import(
                /* webpackChunkName:"js/stockmin-report"*/
                "../../modules/Inventory/Resources/assets/js/stockminReport/report.vue"
            ),
        "valued-report": () =>
            import(
                /* webpackChunkName:"js/valued-report"*/
                "../../modules/Inventory/Resources/assets/js/valuedReport/index.vue"
            ),
        "college-schoolsupplies": () =>
            import(
                /* webpackChunkName:"js/stockmin-report"*/
                "../../modules/College/Resources/assets/js/views/schoolSuplies/index.vue"
            ),
        "tenant-report-kardex-master": () =>
            import(
                /* webpackChunkName:"js/tenant-report-kardex-master"*/
                "../../modules/Inventory/Resources/assets/js/kardex/index.vue"
            ),

        "tenant-dispatches-index": () =>
            import(
                /* webpackChunkName:"js/tenant-dispatches-index"*/
                "./views/dispatches/index.vue"
            ),
        "tenant-dispatches-form": () =>
            import(
                /* webpackChunkName:"js/tenant-dispatches-form"*/
                "./views/dispatches/form.vue"
            ),
        "tenant-dispatches-create": () =>
            import(
                /* webpackChunkName:"js/tenant-dispatches-create"*/
                "./views/dispatches/create.vue"
            ),
        "tenant-internet-pos": () =>
            import(
                /* webpackChunkName:"js/tenant-internet-pos" */
                "../../modules/Internet/Resources/assets/js/view/pos/index.vue"
            ),
        "tenant-internet-workersadm": () =>
            import(
                /* webpackChunkName:"js/tenant-internet-workersadm" */
                "../../modules/Internet/Resources/assets/js/view/workers/index.vue"
            ),
        "tenant-internet-planes": () =>
            import(
                /* webpackChunkName:"js/tenant-internet-planes" */
                "../../modules/Internet/Resources/assets/js/view/planes/index.vue"
            ),
        "items-stock": () =>
            import(
                /*webpackChunkName:"tenant-registers-index"*/
                "./views/items/check_stock.vue"
            ),

        "tenant-quotations-index": () =>
            import(
                /*webpackChunkName:"tenant-quotations-index"*/
                "./views/quotations/index.vue"
            ),

        "tenant-quotations-form": () =>
            import(
                /*webpackChunkName:"tenant-quotations-form"*/
                "./views/quotations/form.vue"
            ),

        "tenant-quotations-edit": () =>
            import(
                /*webpackChunkName:"tenant-quotations-edit"*/
                "./views/quotations/form_edit.vue"
            ),
        //report-consignment-index
        "report-consignment-index": () =>
            import(
                /*webpackChunkName:"report-credit-index"*/
                "../../modules/Report/Resources/assets/js/views/consignment/index.vue"
            ),
        "report-credit-index": () =>
            import(
                /*webpackChunkName:"report-credit-index"*/
                "../../modules/Report/Resources/assets/js/views/credit/index.vue"
            ),
        "tenant-search-index": () =>
            import(
                /*webpackChunkName:"tenant-search-index"*/
                "./views/search/index.vue"
            ),

        "tenant-registers-index": () =>
            import(
                /*webpackChunkName:"tenant-registers-index"*/
                "./views/registers/index.vue"
            ),

        "tenant-consignment-index": () =>
            import(
                /*webpackChunkName:"tenant-consigment-index"*/
                "@viewsModuleConsignment/index.vue"
            ),
        "report-series-vendidas": () =>
            import(
                /*webpackChunkName:"reporte-series-vendidas"*/
                "../../modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue"
            ),
            "tenant-sellers-index": () =>
            import(
                /*webpackChunkName:"reporte-series-vendidas"*/
                "./views/sellers/index.vue"
            ),
                "tenant-bank_accounts-index": ()=>

                import(
                    /*webpackChunkName:"bank_accounts"*/
                    "./views/bank_accounts/index.vue")
            ,
            "tenant-banks-index": ()=>
            import(
                /*webpackChunkName:"banks"*/
                "./views/banks/index.vue")
            ,
            "tenant-commercial-treatment-index":  ()=>
            import(
                /*webpackChunkName:"commercial_treatment"*/
                "./views/commercial_treatment/index.vue")
            ,
            "tenant-credit-list-index": ()=>
            import(
                /*webpackChunkName:"credit_list"*/
                "./views/credit_list/index.vue")
            ,
            "worker-cleaner" : ()=>
            import(
                /*webpackChunkName:"worker-cleaner"*/
                "../../modules/Restaurant/Resources/assets/js/views/cleaner/index.vue")
            ,
            
    },
 
});
