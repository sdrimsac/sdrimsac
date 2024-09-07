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
import Swal from 'sweetalert2';
const options = {
    timeout: 5000
};

// Vue.use(Swal);
Vue.prototype.$showSAlert = (title, text, iconHtml, backgroundColor = null) =>{
    Swal.fire({
        title: `<div style="text-align: center;">${title}</div>`, // Título en mayúsculas y centrado
        html: `
    <div style="display: flex; align-items: center; justify-content: center;">
        ${iconHtml}
    </div>
    <p style="font-weight: bold; font-size: 1.2rem;">${text}</p>
`, // Texto normal
        timer: 2000, // Duración de 2 segundos
        showConfirmButton: false,
        background: backgroundColor ? backgroundColor : undefined,
        customClass: {
            popup: 'swal2-no-border', // Clase personalizada
        },
        position: 'center'
    });
}

Vue.use(Toast, options);

document.addEventListener("DOMContentLoaded", function() {
    getDesarrollador();
    getAreaPrinter();
    getCashId();
});
const getCashId = async () => {
    try {
        const { data } = await Axios.get("/getCashId");
        Vue.prototype.$cashId = null;

        if (data != null) {
            if (data.cash_id) {
                Vue.prototype.$cashId = data.cash_id;
            }
        }
    } catch (e) {}
};
const getDesarrollador = async () => {
    try {
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
    } catch (e) {}
};
const getAreaPrinter = async () => {
    try {
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
    } catch (e) {}
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
Vue.component(
    "tenant-report-document-detractions-index",
    require("../../modules/Report/Resources/assets/js/views/document-detractions/index.vue")
);
/* Vue.component("tenant-report-document-ventas-index",
    require("../../modules/Report/Resources/assets/js/views/document-ventas/index.vue")
); */
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

const app = new Vue({
    store,
    el: "#main",

    components: {
        "tenant-report-methods-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/methods/index.vue"
            ),
        "tenant-productos-index": () =>
            import("../js/views/productos/index.vue"),
        "whatsapp-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/whatsapp/index.vue"
            ),
        "vip-items": () =>
            import("../../modules/Vip/Resources/assets/js/views/index.vue"),

        "etiqueta-index": () =>
            import(
                "../../modules/Etiquetas/Resources/assets/js/views/index.vue"
            ),

        "inventory-index": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/inventory/inventory.vue"
            ),

        /* "productos-index": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/inventory/productos.vue"
            ), */
        "restaurant-food-list": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/food/index.vue"
            ),

        "tenant-restaurant-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/restaurant.vue"
            ),

        "tenant-restaurant-kitchen": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/kitchen.vue"
            ),

        "tenant-restaurant-items": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/configuration/items.vue"
            ),

        "restaurant-ordens-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/ordens/index.vue"
            ),

        "restaurant-worker-login": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/login/login.vue"
            ),

        "tenant-item-color-size-index": () =>
            import("./views/item_color_size/index.vue"),
        "tenant-item-sets-index": () => import("./views/item_sets/index.vue"),
        "tenant-receta-index": () => import("./views/receta/index.vue"),
        "restaurant-worker-dashboard": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/worker/dashboard.vue"
            ),
        "restaurant-kitchen-dashboard": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/kitchen/dashboard.vue"
            ),
        "tenant-restaurant-workers": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/workers/workers.vue"
            ),
        "tenant-restaurant-pos": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/pos/index.vue"
            ),
        "tenant-dashboard-index": () =>
            import(
                "../../modules/Dashboard/Resources/assets/js/views/index.vue"
            ),

        "tenant-companies-form": () => import("./views/companies/form.vue"),
        "tenant-account-export": () =>
            import(
                "../../modules/Format/Resources/assets/js/views/account/format.vue"
            ),
        "tenant-companies-logo": () => import("./views/companies/logo.vue"),

        "tenant-certificates-index": () =>
            import("./views/certificates/index.vue"),

        "tenant-certificates-form": () =>
            import("./views/certificates/form.vue"),
        "tenant-configurations-form": () =>
            import("./views/configurations/form.vue"),
        "tenant-configurations-visual": () =>
            import("./views/configurations/visual.vue"),
        "tenant-configurations-pdf": () =>
            import("./views/configurations/pdf_templates.vue"),
        //
        "tenant-items-client": () => import("./views/items/items_client.vue"),
        "tenant-items-index": () => import("./views/items/index.vue"),
        "tenant-persons-index": () => import("./views/persons/index.vue"),

        "tenant-users-form": () => import("./views/users/form.vue"),

        "tenant-documents-index": () => import("./views/documents/index.vue"),
        "tenant-detractions-index": () =>
            import("./views/documents/detractions/index.vue"),
        "tenant-ventas-index": () =>
            import("./views/documents/ventas/index.vue"),
        "restaurant-documents-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/documents/index.vue"
            ),
        "tenant-documents-invoice": () =>
            import("./views/documents/invoice.vue"),
        "tenant-documents-note-other": () =>
            import("./views/documents/note_other.vue"),

        "tenant-documents-note": () => import("./views/documents/note.vue"),
        "tenant-summaries-index": () => import("./views/summaries/index.vue"),
        "tenant-voided-index": () => import("./views/voided/index.vue"),

        "tenant-options-form": () => import("./views/options/form.vue"),
        "tenant-users-index": () => import("./views/users/index.vue"),
        "tenant-banks-index": () => import("./views/banks/index.vue"),

        "tenant-unit_types-index": () => import("./views/unit_types/index.vue"),

        "tenant-establishments-index": () =>
            import("./views/establishments/index.vue"),

        "tenant-currency-types-index": () =>
            import("./views/currency_types/index.vue"),

        "tenant-purchases-index": () => import("./views/purchases/index.vue"),
        "tenant-purchases-form": () => import("./views/purchases/form.vue"),

        "tenant-purchases-edit": () =>
            import("./views/purchases/form_edit.vue"),

        "tenant-attribute_types-index": () =>
            import("./views/attribute_types/index.vue"),

        "tenant-warehouses": () => import("./views/components/warehouses.vue"),

        "tenant-arqueos-form": () => import("./views/arqueos/index.vue"),
        "tenant-tasks-lists": () => import("./views/tasks/lists.vue"),
        "tenant-tasks-form": () => import("./views/tasks/form.vue"),

        "tenant-sale-notes-credit-penalty": () =>
            import("./views/sale_notes/credit_penalty.vue"),
        "tenant-sale-notes-index": () => import("./views/sale_notes/index.vue"),
        "tenant-sale-notes-form": () => import("./views/sale_notes/form.vue"),
        "tenant-cash-transfer-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/cash_transfer/index.vue"
            ),
        "tenant-cash-transfer-index-report": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/cash_transfer/report.vue"
            ),
        "tenant-cash-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/cash/index.vue"
            ),
        "cash-index-closed": () => import("@views/cash/closed.vue"),
        "cash-index-main": () => import("@views/cash/main.vue"),
        "tenant-card-brands-index": () =>
            import("./views/card_brands/index.vue"),

        "tenant-payment-method-index": () =>
            import("./views/payment_method/index.vue"),

        "tenant-category-index": () => import("./views/category/index.vue"),

        "inventory-transactions-index": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/transactions/index.vue"
            ),
        "inventory-transfers-index": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/transfers/index.vue"
            ),
        "inventory-transfers-place-index": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/transfers_place/index.vue"
            ),
        "tenant-account-format": () =>
            import(
                "../../modules/Format/Resources/assets/js/views/account/format.vue"
            ),

        "warehouses-index": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/warehouses/index.vue"
            ),

        "tenant-inventories-form": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/config/form.vue"
            ),

        "tenant-documents-not-sent": () =>
            import(
                "../../modules/Document/Resources/assets/js/views/documents/not_sent.vue"
            ),
        "tenant-report-purchases-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/purchases/index.vue"
            ),
        "tenant-report-documents-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/documents/index.vue"
            ),
        "tenant-report-customers-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/customers/index.vue"
            ),
        "tenant-report-items-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/items/index.vue"
            ),
        "tenant-report-items-defeated": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/items/defeated.vue"
            ),

        "tenant-report-sale_notes-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/sale_notes/index.vue"
            ),

        "tenant-report-cash-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/cash/index.vue"
            ),

        "tenant-series-configurations-index": () =>
            import(
                "../../modules/Document/Resources/assets/js/views/series_configurations/index.vue"
            ),

        "tenant-report-order-notes-consolidated-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/order_notes_consolidated/index.vue"
            ),

        "tenant-report-general-items-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/general_items/index.vue"
            ),

        "tenant-report-order-notes-general-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/order_notes_general/index.vue"
            ),

        "tenant-report-sales-consolidated-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/sales_consolidated/index.vue"
            ),

        "tenant-categories-index": () =>
            import(
                "../../modules/Item/Resources/assets/js/views/categories/index.vue"
            ),

        "tenant-brands-index": () =>
            import(
                "../../modules/Item/Resources/assets/js/views/brands/index.vue"
            ),

        "tenant-manufactured-index": () =>
            import(
                "../../modules/Item/Resources/assets/js/views/manufactured/index.vue"
            ),
        "tenant-report-valued-kardex": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/valued_kardex/index.vue"
            ),

        "tenant-finance-global-payments-index": () =>
            import(
                "../../modules/Finance/Resources/assets/js/views/global_payments/index.vue"
            ),

        "tenant-finance-balance-index": () =>
            import(
                "../../modules/Finance/Resources/assets/js/views/balance/index.vue"
            ),

        "tenant-finance-payment-method-types-index": () =>
            import(
                "../../modules/Finance/Resources/assets/js/views/payment_method_types/index.vue"
            ),

        "tenant-finance-unpaid-index": () =>
            import("@viewsModuleFinance/unpaid/index.vue"),

        "tenant-finance-income-index": () =>
            import("@viewsModuleFinance/income/index.vue"),

        "tenant-finance-income-form": () =>
            import("@viewsModuleFinance/income/form.vue"),

        "tenant-income-types-index": () =>
            import("@viewsModuleFinance/income_types/index.vue"),

        "tenant-income-reasons-index": () =>
            import("@viewsModuleFinance/income_reasons/index.vue"),

        "tenant-person-types-index": () =>
            import("./views/person_types/index.vue"),

        "x-form-group": () => import("./components/FormGroup.vue"),

        "tenant-account-payment-index": () =>
            import("./views/account/payment_index.vue"),

        "tenant-account-configuration-index": () =>
            import("./views/account/configuration.vue"),

        "tenant-groups-index": () => import("./views/groups/index.vue"),

        "tenant-subcategories-index": () =>
            import("./views/subcategory/index.vue"),

        "tenant-boxes-index": () => import("./views/boxes/index.vue"),

        "tenant-boxes-expenses-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/expenses/index.vue"
            ),

        "tenant-boxes-incomes-index": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/incomes/index.vue"
            ),

        "tenant-incomes-index": () => import("./views/incomebox/index.vue"),

        "tenant-boxes-reports": () => import("./views/boxes/report.vue"),
        "tenant-boxes-reports-global": () => import("./views/boxes/global.vue"),
        "tenant-boxes-reports-pos": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/boxes/report.vue"
            ),
        "inventory-form-masive": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/transfers/form_masive.vue"
            ),
        "items-lot": () =>
            import("../../modules/LotItem/Resources/assets/js/view/index.vue"),
        "items-lot-group": () =>
            import(
                "../../modules/Item/Resources/assets/js/views/item_lots_group/index.vue"
            ),

        "tenant-boxes-reports": () => import("./views/boxes/report.vue"),

        "tenant-boxes-reports-pos": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/boxes/report.vue"
            ),
        "tenant-hotels-room-report": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/reports/rooms.vue"
            ),
            
        "tenant-login-default": () => import("./views/login/index.vue"),

        "cash-report": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/cash/report.vue"
            ),
        "toll-index": () => import("../../resources/js/views/toll/index.vue"),

        "college-persons": () =>
            import(
                "../../modules/College/Resources/assets/js/views/persons/index.vue"
            ),

        "college-levels": () =>
            import(
                "../../modules/College/Resources/assets/js/views/levels/index.vue"
            ),

        "college-periods": () =>
            import(
                "../../modules/College/Resources/assets/js/views/periods/index.vue"
            ),
        "college-plans": () =>
            import(
                "../../modules/College/Resources/assets/js/views/plans/index.vue"
            ),
        "college-registers": () =>
            import(
                "../../modules/College/Resources/assets/js/views/registers/index.vue"
            ),
        "college-classrooms": () =>
            import(
                "../../modules/College/Resources/assets/js/views/classrooms/index.vue"
            ),

        "college-students": () =>
            import(
                "../../modules/College/Resources/assets/js/views/students/index.vue"
            ),

        "college-penalties": () =>
            import(
                "../../modules/College/Resources/assets/js/views/penalties/index.vue"
            ),
        "stockmin-report": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/stockminReport/report.vue"
            ),
        "valued-report": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/valuedReport/index.vue"
            ),
        "college-schoolsupplies": () =>
            import(
                "../../modules/College/Resources/assets/js/views/schoolSuplies/index.vue"
            ),
        "tenant-report-kardex-master": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/kardex/index.vue"
            ),

        "tenant-dispatches-index": () => import("./views/dispatches/index.vue"),
        "tenant-dispatches-form": () => import("./views/dispatches/form.vue"),
        "tenant-dispatches-create": () =>
            import("./views/dispatches/create.vue"),
        "tenant-internet-pos": () =>
            import(
                "../../modules/Internet/Resources/assets/js/view/pos/index.vue"
            ),
        "tenant-health-global-index": () =>
            import("./views/health_global/index.vue"),
        "tenant-internet-workersadm": () =>
            import(
                "../../modules/Internet/Resources/assets/js/view/workers/index.vue"
            ),
        "tenant-internet-planes": () =>
            import(
                "../../modules/Internet/Resources/assets/js/view/planes/index.vue"
            ),
        "items-stock": () => import("./views/items/check_stock.vue"),

        "tenant-quotations-index": () => import("./views/quotations/index.vue"),

        "tenant-quotations-form": () => import("./views/quotations/form.vue"),

        "tenant-quotations-edit": () =>
            import("./views/quotations/form_edit.vue"),
        //report-credit-index-cash
        //report-consignment-index
        "report-consignment-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/consignment/index.vue"
            ),
        "report-credit-index-cash": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/credit/index_cash.vue"
            ),
        "report-credit-daily-cash": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/credit/daily_cash.vue"
            ),
        "report-credit-index": () =>
            import(
                "../../modules/Report/Resources/assets/js/views/credit/index.vue"
            ),
        "tenant-search-index": () => import("./views/search/index.vue"),

        "tenant-registers-index": () => import("./views/registers/index.vue"),

        "tenant-consignment-index": () =>
            import("@viewsModuleConsignment/index.vue"),
        "report-series-vendidas": () =>
            import(
                "../../modules/Inventory/Resources/assets/js/series/reporteSeriesSell.vue"
            ),
        "tenant-sellers-index": () => import("./views/sellers/index.vue"),
        "tenant-bank_accounts-index": () =>
            import("./views/bank_accounts/index.vue"),
        "tenant-banks-index": () => import("./views/banks/index.vue"),
        "tenant-principal-categories-index": () =>
            import("./views/principal_categories/index.vue"),

        "tenant-commercial-treatment-index": () =>
            import("./views/commercial_treatment/index.vue"),
        "tenant-credit-list-index": () =>
            import("./views/credit_list/index.vue"),
        "worker-cleaner": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/cleaner/index.vue"
            ),
        "worker-maintenance": () =>
            import(
                "../../modules/Restaurant/Resources/assets/js/views/maintenance/index.vue"
            )
        /* "tenant-etiquetas-index": () =>
            import("./views/etiquetas/index.vue") */
    }
});
