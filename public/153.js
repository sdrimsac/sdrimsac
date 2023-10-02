webpackJsonp([153],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-385e4f75\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-385e4f75", Component.options)
  } else {
    hotAPI.reload("data-v-385e4f75", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_lodash__ = __webpack_require__("./node_modules/lodash/lodash.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_lodash___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_lodash__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_print_js__ = __webpack_require__("./node_modules/print-js/dist/print.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_print_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_print_js__);
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// import * as shajs from 'sha.js';

 //import CardBrandsForm from "../../../../../../../../resources/js/views/card_brands/form.vue";
// import SaleNotesOptions from '../../sale_notes/partials/options.vue'
//import OptionsForm from './options.vue'
//import MultiplePaymentForm from "./multiple_payment.vue";
//import PersonForm from "../../../../../../../../resources/js/views/persons/form.vue";
//import ShowSplitPaymentForm from "./split_payment.vue";

var ListItems = function ListItems() {
  return __webpack_require__.e/* import() */(184).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/list_items.vue"));
};

var CardBrandsForm = function CardBrandsForm() {
  return __webpack_require__.e/* import() */(171).then(__webpack_require__.bind(null, "./resources/js/views/card_brands/form.vue"));
};

var MultiplePaymentForm = function MultiplePaymentForm() {
  return __webpack_require__.e/* import() */(182).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue"));
};

var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(125/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

var ShowSplitPaymentForm = function ShowSplitPaymentForm() {
  return __webpack_require__.e/* import() */(174).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue"));
};

var PersonCollegeForm = function PersonCollegeForm() {
  return __webpack_require__.e/* import() */(127/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/views/persons/form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ListItems: ListItems,
    PersonCollegeForm: PersonCollegeForm,
    CardBrandsForm: CardBrandsForm,
    MultiplePaymentForm: MultiplePaymentForm,
    PersonForm: PersonForm,
    ShowSplitPaymentForm: ShowSplitPaymentForm
  },
  props: ["clientSaleNoteNumber", "clientSaleNoteDiscount", "ordens_all_table", "consignment_id", "isConsignment", "affectation_igv_types", "printer", "printing", "customer_default", "customer_variation", "variation", "establishments", "formVariation", "documentsType", "orden_items", "cash_id", "form", "exchangeRateSale", "is_payment", "soapCompany", "direct_printing", "auth_login", "payments", "configuration", "idOrden", "company", "desarrollador", "percentage_igv", "all_series", "all_customers", "personalWhatsapp", "sellers"],
  watch: {
    all_customers: function all_customers(newCustomer, _) {
      this.customers = newCustomer.filter(function (n) {
        return n.number != "88888888";
      });
    },
    method_payments: function method_payments(newMethod, _) {
      this.checkTotal(newMethod);
    }
  },
  data: function data() {
    return {
      showListItems: false,
      discountTotal: false,
      paymentCondition: "01",
      payment_condition: [{
        id: "01",
        description: "Contado"
      }, {
        id: "02",
        description: "Crédito"
      }],
      affectation_optional_id: null,
      hasCreditCardCharge: false,
      chargeCredit: {
        credit_type: "1",
        total_charge: 0,
        amount: 5
      },
      collegePersonId: null,
      conf: {},
      started: true,
      refCustomer: null,
      currentDocumentsType: [],
      time: null,
      splitPayments: [],
      splitProducts: [],
      showCollegePersonDialog: false,
      isInterno: false,
      showSplitPayment: false,
      currencyTypeActive: {
        symbol: "S/ "
      },
      currentPayments: [],
      input_person: {},
      customer: null,
      value: null,
      paymentsValue: {
        "01": "Efectivo",
        "02": "Culqui",
        "03": "Yape",
        "04": "PLIN",
        "05": "TARJETA: IZYPAY",
        "06": "TARJETA: NIUBIZ",
        "07": "TARJETA: OPENPAY"
      },
      last_number: {},
      showDialogNewPerson: false,
      loading: false,
      enabled_discount: true,
      discount_amount: 0,
      loading_submit: false,
      showDialogOptions: false,
      showDialogMultiplePayment: false,
      showDialogSaleNote: false,
      showDialogNewCardBrand: false,
      documentNewId: null,
      saleNotesNewId: null,
      resource_options: null,
      has_card: false,
      method_payments: "01",
      number: null,
      resource: "pos",
      resource_documents: "documents",
      resource_payments: "document_payments",
      amount: 0,
      printerOn: 0,
      button_payment: false,
      input_item: "",
      form_payment: {
        is_bank: false
      },
      series: [],
      cards_brand: [],
      cancel: false,
      form_cash_document: {},
      statusDocument: {},
      payment_method_types: [],
      invoice: true,
      receipt: true,
      sale_note: true,
      last_date: null,
      customers: [],
      datEmision: {
        disabledDate: function disabledDate(time) {
          return time.getTime() > moment();
        }
      },
      activeColo: "black",
      students: [],
      bank: null,
      hasExceedBank: false,
      bank_accounts: [] // percentage_igv: 18

    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      var _this$establishments$;

      var conf;
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.conf = (_this$establishments$ = _this.establishments.conf) !== null && _this$establishments$ !== void 0 ? _this$establishments$ : {};
              _this.button_payment = true;
              _this.currentDocumentsType = _this.documentsType;
              _this.form.identity_document_type_id = _this.currentDocumentsType[0].id;
              _this.form.customer_id = _this.establishments.customer_id;
              _this.value = _this.establishments.customer_id;
              _this.isInterno = _this.company.soap_type_id == "03"; // await this.getTables();

              _context.next = 9;
              return _this.date_of_issue();

            case 9:
              if (_this.conf.pos_quick_sale) {
                _context.next = 12;
                break;
              }

              _context.next = 12;
              return _this.getLastNumbersDocument();

            case 12:
              _context.next = 14;
              return _this.initFormPayment();

            case 14:
              _context.next = 16;
              return _this.setInitialAmount();

            case 16:
              _this.$eventHub.$on("reloadDataCardBrands", function (card_brand_id) {
                _this.reloadDataCardBrands(card_brand_id);
              });

              _context.next = 19;
              return _this.$eventHub.$on("reloadDataPersons", function (customer_id) {
                _this.reloadDataCustomers(customer_id);
              });

            case 19:
              _context.next = 21;
              return _this.getFormPosLocalStorage();

            case 21:
              if (_this.conf.pos_quick_sale) {
                qz.security.setCertificatePromise(function (resolve, reject) {
                  _this.$http.get("/api/qz/crt/override", {
                    responseType: "text"
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                });
                qz.security.setSignaturePromise(function (toSign) {
                  return function (resolve, reject) {
                    _this.$http.post("/api/qz/signing", {
                      request: toSign
                    }).then(function (response) {
                      resolve(response.data);
                    })["catch"](function (error) {
                      reject(error.data);
                    });
                  };
                });
              }

              _this.setAmountCash(_this.form.total);

              _this.filterSeries();

              _this.button_payment = false;
              conf = _this.establishments.conf;

              if (conf && conf.pos_quick_sale || _this.ordens_all_table) {
                _this.sendPayment(null, _this.form);
              }

              _this.getBankAccounts();

            case 28:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  mounted: function mounted() {},
  methods: {
    changeBankAccount: function changeBankAccount() {
      var _this2 = this;

      if (this.form_payment.is_bank) {
        var bank_account = this.bank_accounts.find(function (b) {
          return b.id == _this2.form.bank_account_id;
        });
        this.form.boxes = [{
          id: null,
          bank_account_id: bank_account.id,
          number_operation: this.form.reference_number,
          amount: this.form.total,
          method: "".concat(bank_account.description, "-").concat(bank_account.number)
        }];
      } else {
        this.form.boxes = [];
      }
    },
    getBankAccounts: function getBankAccounts() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this3.$http.get("/bank_accounts/records");

              case 2:
                response = _context2.sent;

                if (response.status == 200) {
                  _this3.bank_accounts = response.data.data;

                  if (_this3.bank_accounts.length > 0) {
                    _this3.form.bank_account_id = _this3.bank_accounts[0].id;
                  }
                }

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    checkLimitReceipt: function checkLimitReceipt() {
      var _this$form = this.form,
          customer_id = _this$form.customer_id,
          document_type_id = _this$form.document_type_id,
          total = _this$form.total;

      if (total > 699 && document_type_id == "03") {
        var customer = this.customers.find(function (c) {
          return c.id == customer_id;
        });

        if (customer) {
          if (customer.number == "99999999" || customer.identity_document_type_id != "6" && customer.identity_document_type_id != "1") {
            return true;
          }
        }
      }

      return false;
    },
    isClientesVarios: function isClientesVarios() {
      var id = this.value;

      if (id != null) {
        var customer = this.customers.find(function (c) {
          return c.id == id;
        });

        if (customer && customer.number == "99999999") {
          return true;
        }
      }

      return false;
    },
    checkTotal: function checkTotal(newMethod) {
      //xd
      if (newMethod == "01") {
        var total = this.form.total;

        if (total > 2000) {
          this.bank = "Bancarización: Ingresar voucher de pago o nro de operación";
          this.hasExceedBank = true;
        }
      } else {
        this.bank = null;
        this.hasExceedBank = false;
      }
    },
    formatItems: function formatItems() {
      var _this4 = this;

      var items = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
      var affectation = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      items = items.map(function (i) {
        var _objectSpread2;

        var affectation_igv_type_id = affectation != null && affectation != undefined ? affectation : i.sale_affectation_igv_type_id;
        return _objectSpread(_objectSpread({}, i), {}, (_objectSpread2 = {
          warehouse_id: null,
          item: i,
          item_id: i.id,
          unit_value: affectation_igv_type_id == 10 ? i.sale_unit_price / (1 + _this4.percentage_igv / 100) : i.sale_unit_price,
          quantity: i.quantity,
          aux_quantity: i.quantity,
          total_base_igv: affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this4.percentage_igv / 100) : i.sale_unit_price * i.quantity,
          percentage_igv: _this4.percentage_igv,
          total_igv: affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this4.percentage_igv / 100) * (_this4.percentage_igv / 100) : 0,
          total_base_isc: 0.0,
          percentage_isc: 0.0,
          total_isc: 0.0,
          total_base_other_taxes: 0.0,
          percentage_other_taxes: 0.0,
          total_other_taxes: 0.0,
          total_taxes: affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this4.percentage_igv / 100) * (_this4.percentage_igv / 100) : 0,
          total_value: affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this4.percentage_igv / 100) : i.quantity * i.sale_unit_price,
          total_charge: 0.0,
          total_discount: 0.0,
          total: i.sale_unit_price * i.quantity,
          price_type_id: "01",
          unit_price: i.sale_unit_price,
          unit_price_value: i.sale_unit_price,
          has_igv: i.has_igv,
          affectation_igv_type_id: affectation_igv_type_id
        }, _defineProperty(_objectSpread2, "unit_price", i.sale_unit_price), _defineProperty(_objectSpread2, "presentation", null), _defineProperty(_objectSpread2, "charges", []), _defineProperty(_objectSpread2, "discounts", []), _defineProperty(_objectSpread2, "attributes", []), _defineProperty(_objectSpread2, "affectation_igv_type", affectation_igv_type_id), _objectSpread2));
      });
      return items;
    },
    setItemsNewPrice: function setItemsNewPrice(prices) {
      var copyPrices = _toConsumableArray(prices);

      var items = _toConsumableArray(this.form.items.map(function (m) {
        return m.item;
      }));

      for (var i = 0; i < items.length; i++) {
        var item = items[i];

        if (item.cOlPrice) {
          item.sale_unit_price = item.cOlPrice;
          item.cOlPrice = null;
          item.cNewPrice = null;
        }

        var quantity = item.quantity;
        var sum = copyPrices.splice(0, 1).reduce(function (a, b) {
          return a + b;
        }, 0);
        var newPrice = sum / quantity;
        item.cOlPrice = item.sale_unit_price;
        item.cNewPrice = newPrice;
        item.sale_unit_price = Number(item.sale_unit_price) + newPrice;
      }

      return items;
    },
    toFixedTwoNumber: function toFixedTwoNumber(number) {
      return Number(number.toFixed(2));
    },
    divideCharge: function divideCharge(parts) {
      var amount = this.chargeCredit.total_charge;
      var part = amount / parts;
      var decimal = this.toFixedTwoNumber(part);
      var array = Array(parts).fill(decimal);
      var total = decimal * parts;
      var difference = (amount - total).toFixed(2);

      if (difference != 0) {
        array[0] = this.toFixedTwoNumber(array[0] + Number(difference));
      }

      return array;
    },
    calculateCharge: function calculateCharge() {
      var _this$chargeCredit = this.chargeCredit,
          amount = _this$chargeCredit.amount,
          credit_type = _this$chargeCredit.credit_type;

      if (credit_type == "1") {
        this.chargeCredit.total_charge = this.form.total * (amount / 100);
      } else {
        this.chargeCredit.total_charge = Number(amount);
      }

      this.chargeCredit.total_charge = Number(this.chargeCredit.total_charge.toFixed(1));

      if (this.form.total < this.chargeCredit.total_charge) {
        this.chargeCredit.total_charge = 0;
        this.chargeCredit.amount = 0;
        this.$toast.error("El monto a adicionar no puede ser mayor al total"); // this.reCalculateTotal();
        // return;
      }

      var prices = this.divideCharge(this.form.items.length);
      var items = this.setItemsNewPrice(prices);
      items = this.formatItems(items);
      this.form.items = items;
      this.reCalculateTotal();
      this.form.enter_amount = this.form.total;
    },
    openDialogPerson: function openDialogPerson() {
      if (this.configuration.college) {
        if (this.customer_default && this.customer_default.id == this.value) {
          this.showDialogNewPerson = true;
        } else {
          this.collegePersonId = this.value;
          this.showCollegePersonDialog = true;
        }
      } else {
        this.showDialogNewPerson = true;
      }
    },
    changeStudent: function changeStudent() {
      this.$forceUpdate();
    },
    existNumber: function existNumber() {
      var number = this.form.customer_telephone;

      if (!number.startsWith("9")) {
        return false;
      }

      if (number.length != 9) {
        return false;
      }

      if (isNaN(Number(number))) {
        return false;
      }

      return true;
    },
    createClient: function createClient() {
      this.value = null;
      this.form.document_type_id;
      this.form.customer_id = null;
      this.showDialogNewPerson = true;
    },
    reloadDataCustomers: function reloadDataCustomers(customer_id) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this5.$http.get("/pos/table/customers").then( /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3(response) {
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
                      while (1) {
                        switch (_context3.prev = _context3.next) {
                          case 0:
                            _context3.next = 2;
                            return _this5.$emit("update:all_customers", response.data);

                          case 2:
                            _this5.value = customer_id;
                            _this5.form.customer_id = customer_id;

                            _this5.changeCustomer();

                          case 5:
                          case "end":
                            return _context3.stop();
                        }
                      }
                    }, _callee3);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    totalItemSelected: function totalItemSelected(products) {
      var total = 0;
      products.forEach(function (p) {
        total += p.quantity * p.price;
      });
      return __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total, 2);
    },
    receivePayments: function receivePayments(payments) {
      this.splitPayments = payments;
    },
    receiveProducts: function receiveProducts(payments) {
      this.splitProducts = payments;
    },
    removePayment: function removePayment(id) {
      this.currentPayments = this.currentPayments.filter(function (c) {
        return c.id != id;
      });
      this.enterAmount();
    },
    checkPaymentTotal: function checkPaymentTotal() {
      var total = this.currentPayments.reduce(function (a, b) {
        return a + Number(b.amount);
      }, 0);
      return total != this.form.total ? Number(this.form.total) - total : 0.0;
    },
    disabledAddPayment: function disabledAddPayment() {
      if (this.form.payment_condition_id == "03") {
        return this.checkPaymentTotal() == 0.0;
      }

      if (this.form.payment_condition_id == "02") {
        return this.currentPayments.length > 0;
      }

      return false;
    },
    addPayment: function addPayment() {
      var id = this.currentPayments.length + 1;
      var method = this.paymentsValue[this.method_payments];

      if (this.form.total + 200 <= this.form.enter_amount) {
        this.$toast.error("el monto a agregar no puede ser 200 soles mayor al pago total ");
        return;
      }

      if (this.form.enter_amount != "" && !isNaN(this.form.enter_amount) && this.form.enter_amount != undefined) {
        if (this.form.payment_condition_id != "01") {
          var total = this.currentPayments.reduce(function (a, b) {
            return a + Number(b.amount);
          }, 0);

          if (this.form.total < total + Number(this.form.enter_amount)) {
            this.$toast.error("El monto a agregar no puede ser mayor al pago total ");
            return;
          }
        }

        var days = this.currentPayments.length + 1;
        var date = moment().add(5, "hours").add(days, "days");
        this.currentPayments.push({
          id: id,
          method_payment_id: this.method_payments,
          method: method,
          date: date,
          amount: this.form.enter_amount
        });

        if (this.form.payment_condition_id == "03") {
          this.form.enter_amount = this.checkPaymentTotal();
          this.enterAmount();
        } else {
          this.form.enter_amount = 0.0;
        }
      }
    },
    customerForm: function customerForm(isNew) {
      if (isNew) {
        this.form.customer_id = undefined;
      } else {
        this.form.customer_id = this.value;
      }

      this.showDialogNewPerson = true;
    },
    add_customer: function add_customer(value) {},
    reloadDataPersons: function reloadDataPersons() {},
    keyupCustomer: function keyupCustomer(e) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                //buscar
                if (_this6.time) {
                  clearTimeout(_this6.time);
                }

                _this6.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
                  var response, persons;
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
                    while (1) {
                      switch (_context5.prev = _context5.next) {
                        case 0:
                          _this6.input_person.number = _this6.$refs.select_person.$el.getElementsByTagName("input")[0].value;
                          _context5.next = 3;
                          return _this6.$http("/caja/search_customers?value=".concat(_this6.input_person.number));

                        case 3:
                          response = _context5.sent;
                          persons = response.data.persons;
                          _this6.customers = persons.filter(function (n) {
                            return n.number != "88888888";
                          });

                          _this6.updateAllCustomers(_this6.customers);

                        case 7:
                        case "end":
                          return _context5.stop();
                      }
                    }
                  }, _callee5);
                })), 500);

              case 2:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    updateAllCustomers: function updateAllCustomers(personsFromServer) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        var ids, persons, _iterator, _step, _loop, newData;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                ids = _this7.all_customers.map(function (c) {
                  return c.id;
                });
                persons = [];
                _iterator = _createForOfIteratorHelper(personsFromServer);

                try {
                  _loop = function _loop() {
                    var person = _step.value;
                    var existInList = ids.find(function (p) {
                      return p == person.id;
                    });

                    if (existInList == undefined) {
                      persons.push(person);
                    }
                  };

                  for (_iterator.s(); !(_step = _iterator.n()).done;) {
                    _loop();
                  }
                } catch (err) {
                  _iterator.e(err);
                } finally {
                  _iterator.f();
                }

                newData = [];

                if (_this7.clientSaleNoteNumber) {
                  newData = personsFromServer;
                } else {
                  newData = [].concat(_toConsumableArray(_this7.all_customers), persons);
                }

                if (!(persons.length != 0)) {
                  _context7.next = 10;
                  break;
                }

                _context7.next = 9;
                return _this7.$emit("update:all_customers", newData);

              case 9:
                if (newData.length == 1) {
                  _this7.value = newData[0].id;
                  _this7.form.customer_id = newData[0].id;

                  _this7.changeCustomer();
                }

              case 10:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    changeCustomer: function changeCustomer() {
      this.form.student_id = null;
      this.students = [];
      this.form.customer_id = this.value;

      var customer = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.customers, {
        id: this.form.customer_id
      });

      if (customer != null) {
        this.students = customer.students || [];
        this.customer = customer;

        if (this.form.document_type_id == "01") {
          if (customer.identity_document_type_id == "1" || customer.identity_document_type_id == "4" || customer.identity_document_type_id == "-") {
            this.form.document_type_id = "03";
          } //  else {
          //     this.form.document_type_id = "01";
          // }

        }

        this.form.customer_telephone = customer.phone;
        this.setLocalStorageIndex("customer", this.customer);

        if (this.clientSaleNoteNumber) {
          this.form.document_type_id = "03";
        }
      }

      this.setSeries();
    },
    setLocalStorageIndex: function setLocalStorageIndex(key, obj) {
      localStorage.setItem(key, JSON.stringify(obj));
    },
    getLastNumbersDocument: function getLastNumbersDocument() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _context8.next = 2;
                return _this8.$http.post("".concat(_this8.resource, "/last_number_documents"), {
                  series: _this8.all_series,
                  ordenId: _this8.idOrden
                });

              case 2:
                response = _context8.sent;

                if (response.status == 200) {
                  _this8.last_number = response.data.result;
                  _this8.refCustomer = response.data.customer;

                  if (_this8.refCustomer != null) {
                    _this8.refCustomer.description = "".concat(_this8.refCustomer.number, " - ").concat(_this8.refCustomer.name);
                    _this8.customers = [_this8.refCustomer].concat(_toConsumableArray(_this8.customers.filter(function (f) {
                      return f.id != _this8.refCustomer.id && f.number != "88888888";
                    })));
                    _this8.value = _this8.refCustomer.id;
                  }
                }

              case 4:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    changeEnabledDiscount: function changeEnabledDiscount() {
      if (!this.enabled_discount) {
        this.discount_amount = 0;
        this.deleteDiscountGlobal();
        this.reCalculateTotal();
      }
    },
    teclasInit: function teclasInit() {
      var _this9 = this;

      document.onkeydown = function (e) {
        var key = e.key;

        if (key == "F4") {//Agregar cliente
          // this.clickPayment();
        }

        if (key == "F6") {//Agregar Producto
          //this.clickAddItemInvoice()
          //return false;
        }

        if (key == "F7" && _this9.form.items.length > 0) {//Guardar
          // this.submit()
        }

        if (key == "F8") {//Cancelar
          // this.close()
        }
      };
    },
    date_of_issue: function date_of_issue() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
        var documents, invoice, sale_note, receipt, isRuc, form_efectivo;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                // this.discount_amount = 0;
                // this.form.customer_id
                // this.form.student_id = null;
                if (!_this10.configuration.restrict_receipt_date) {
                  _this10.form.date_of_issue = moment().format("YYYY-MM-DD");
                }

                documents = _this10.establishments.documents;

                if (documents) {
                  invoice = documents.invoice, sale_note = documents.sale_note, receipt = documents.receipt;
                  _this10.invoice = invoice;
                  _this10.sale_note = sale_note;
                  _this10.receipt = receipt;
                }

                _this10.customers = _this10.all_customers.filter(function (n) {
                  return n.number != "88888888";
                });
                _this10.customers = _toConsumableArray(_this10.customers.filter(function (c) {
                  return c.id != _this10.customer_default.id;
                }));

                if (_this10.form.document_type_id != "01") {
                  _this10.customers = [].concat(_toConsumableArray(_this10.customers), [_this10.customer_default]);
                }

                if (_this10.establishments.customer_id) {
                  isRuc = _this10.checkCustomerDocument("6");

                  if (isRuc && _this10.form.document_type_id != "01") {
                    _this10.value = _this10.establishments.customer_id;
                    _this10.form.customer_id = _this10.establishments.customer_id;
                  }
                }

                form_efectivo = {
                  enter_amount: 0,
                  difference: 0
                }; // const response_efectivo = await this.$http.post(
                //     `/efectivo`,
                //     form_efectivo
                // );

                if (_this10.clientSaleNoteNumber) {
                  setTimeout(function () {
                    _this10.$refs.select_person.$el.getElementsByTagName("input")[0].value = _this10.clientSaleNoteNumber;

                    _this10.keyupCustomer();
                  }, 800);
                  _this10.discount_amount = _this10.clientSaleNoteDiscount;

                  _this10.inputDiscountAmount();

                  _this10.discountTotal = true;

                  _this10.reCalculateTotal();
                }

                _this10.checkTotal("01");

              case 10:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    checkCustomerDocument: function checkCustomerDocument(type) {
      var customer_id = this.form.customer_id;
      var customer = this.customers.find(function (c) {
        return c.id == customer_id;
      });

      if (customer) {
        return customer.identity_document_type_id == type;
      }

      return false;
    },
    printerDocument: function printerDocument(Printer, linkpdf) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        var config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                qz.security.setCertificatePromise(function (resolve, reject) {
                  _this11.$http.get("/api/qz/crt/override", {
                    responseType: "text"
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                });
                qz.security.setSignaturePromise(function (toSign) {
                  return function (resolve, reject) {
                    _this11.$http.post("/api/qz/signing", {
                      request: toSign
                    }).then(function (response) {
                      resolve(response.data);
                    })["catch"](function (error) {
                      reject(error.data);
                    });
                  };
                });
                config = qz.configs.create(Printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context10.next = 6;
                  break;
                }

                _context10.next = 6;
                return qz.websocket.connect(config);

              case 6:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this11.$toast.error(e.message);
                }); // if (this.printerOn == 1) {
                //     if (multiple_boxes == true) {
                //         if (this.auth_login == auth) {
                //             let config = qz.configs.create(Printer, {
                //                 scaleContent: false
                //             });
                //             if (!qz.websocket.isActive()) {
                //                 await qz.websocket.connect(config);
                //             }
                //             let data = [
                //                 {
                //                     type: "pdf",
                //                     format: "file",
                //                     data: linkpdf
                //                 }
                //             ];
                //             qz.print(config, data).catch(e => {
                //                 this.$toast.error(e.message);
                //             });
                //             for (let index = 0; index < copies; index++) {
                //                 qz.print(config, data).catch(e => {
                //                     this.$toast.error(e.message);
                //                 });
                //             }
                //         }
                //     }
                //     if (multiple_boxes == false) {
                //         let config = qz.configs.create(Printer, {
                //             scaleContent: false
                //         });
                //         if (!qz.websocket.isActive()) {
                //             await qz.websocket.connect(config);
                //         }
                //         let data = [
                //             {
                //                 type: "pdf",
                //                 format: "file",
                //                 data: linkpdf
                //             }
                //         ];
                //         qz.print(config, data).catch(e => {
                //             this.$toast.error(e.message);
                //         });
                //         for (let index = 0; index < copies; index++) {
                //             qz.print(config, data).catch(e => {
                //                 this.$toast.error(e.message);
                //             });
                //         }
                //     }
                // }

              case 8:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    clickSendWhatsapp: function clickSendWhatsapp(document_type_id, document_id, number) {
      var _arguments = arguments,
          _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee11() {
        var form, formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                form = _arguments.length > 3 && _arguments[3] !== undefined ? _arguments[3] : {};

                if (!(form.customer_telephone != null)) {
                  _context11.next = 23;
                  break;
                }

                formWhatsapp = {
                  id: _this12.recordId,
                  document_id: document_id,
                  document_type_id: document_type_id,
                  customer_telephone: form.customer_telephone,
                  sender: "sdrimsac",
                  mensaje: "Su comprobante de pago electrónico " + number + "por S/" + _this12.form.total + " de *" + _this12.establishments.description + "*, ha sido generado correctamente a través del facturador electrónico de " + "*" + _this12.$desarrollador + "*"
                };
                _context11.prev = 3;
                _this12.loading = true;
                _context11.next = 7;
                return _this12.$http.post("/whatsapp", formWhatsapp);

              case 7:
                response = _context11.sent;

                if (response.data.success == true) {
                  _this12.$toast.success(response.data.message);

                  _this12.loading = false;
                }

                if (!(_this12.configuration.xml_whatsapp && document_type_id != "80")) {
                  _context11.next = 15;
                  break;
                }

                formWhatsapp.xml = true;
                _context11.next = 13;
                return _this12.$http.post("/whatsapp", formWhatsapp);

              case 13:
                response = _context11.sent;

                if (response.data.success == true) {
                  _this12.$toast.success(response.data.message);

                  _this12.loading = false;
                }

              case 15:
                _context11.next = 20;
                break;

              case 17:
                _context11.prev = 17;
                _context11.t0 = _context11["catch"](3);
                console.log(_context11.t0, " error");

              case 20:
                _context11.prev = 20;
                _this12.loading = false;
                return _context11.finish(20);

              case 23:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11, null, [[3, 17, 20, 23]]);
      }))();
    },
    changeDateOfIssue: function changeDateOfIssue() {
      var days_before_emit = this.configuration.days_before_emit; //si el document es una factura verificar que la fecha de emision no sea menor a la fecha actual menos days_before_emit sin tomar en cuenta la hora

      if (this.form.document_type_id == "01") {
        var date = moment();

        if (moment(this.form.date_of_issue).isBefore(date.subtract(days_before_emit, "days").format("YYYY-MM-DD"))) {
          this.$toast.error("La fecha de emisión no puede ser menor a " + days_before_emit + " días");
          this.form.date_of_issue = moment().format("YYYY-MM-DD");
        }
      } //si el documento es una boleta solo permitir emitir si la fecha de emision tiene el mismo mes que la fecha actual


      if (this.form.document_type_id == "03") {
        var _date = moment();

        if (moment(this.form.date_of_issue).month() != _date.month()) {
          this.$toast.error("La fecha de emisión debe ser del mismo mes");
          this.form.date_of_issue = moment().format("YYYY-MM-DD");
        }
      } // if(this.configuration.restrict_receipt_date){
      //     return;
      // }
      // this.form.date_of_due = this.form.date_of_issue;
      // if (
      //     moment(this.form.date_of_issue) < moment().day(-1) &&
      //     this.configuration.restrict_receipt_date
      // ) {
      //     this.$toast.error(
      //         "No puede seleccionar una fecha menor a 6 días."
      //     );
      //     this.dateValid = false;
      // } else {
      //     this.dateValid = true;
      // }
      // this.form.date_of_due = this.form.date_of_issue;
      // this.searchExchangeRateByDate(this.form.date_of_issue).then(
      //     response => {
      //         this.form.exchange_rate_sale = response;
      //     }
      // );


      this.form.exchange_rate_sale = 1;
    },
    NuevaVenta: function NuevaVenta() {
      this.$parent.nueva_venta();
    },
    setInitialAmount: function setInitialAmount() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee12() {
        var width;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                _this13.enter_amount = _this13.form.total;
                _this13.form.payments = _this13.payments; //get with screen size

                width = window.innerWidth;

                if (!(width > 800)) {
                  _context12.next = 10;
                  break;
                }

                _context12.next = 6;
                return _this13.$refs.enter_amount.$el.getElementsByTagName("input")[0].focus();

              case 6:
                _context12.next = 8;
                return _this13.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();

              case 8:
                _context12.next = 12;
                break;

              case 10:
                _context12.next = 12;
                return _this13.$refs.observation.$el.getElementsByTagName("textarea")[0].focus();

              case 12:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    inputDiscountAmount: function inputDiscountAmount() {
      if (this.enabled_discount) {
        if (this.discount_amount && !isNaN(this.discount_amount) && parseFloat(this.discount_amount) > 0) {
          this.form.total = this.form.total_value;
          if (this.discount_amount >= this.form.total) return this.$toast.error("El monto de descuento debe ser menor al total de venta");
          this.reCalculateTotal();
          this.enterAmount();
        } else {
          this.deleteDiscountGlobal();
          this.reCalculateTotal();
          this.enterAmount();
        }
      }
    },
    discountGlobal: function discountGlobal() {
      // this.form.total = this.form.total_value;
      var global_discount = parseFloat(this.discount_amount);
      var total = parseFloat(this.form.total);
      var base = parseFloat(this.form.total_value);

      if (global_discount > total) {
        this.discount_amount = 0;
        this.$forceUpdate();
        return this.$toast.error("El descuento no puede ser mayor al total");
      } // let total_value = parseFloat(this.form.total_value);


      var new_total = total - global_discount;

      var factor = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(global_discount / total, 4);

      this.form.discounts = [{
        discount_type_id: "03",
        description: "Descuentos globales que no afectan la base imponible del IGV/IVAP",
        factor: factor,
        amount: global_discount,
        base: total
      }];
      this.form.total_discount = global_discount;

      if (this.discountTotal) {
        this.form.total = new_total;
      } else {
        var global_discount_amount = global_discount;
        var global_discount_amount_without_rounding = global_discount;
        var discount_with_base_variant = this.configuration.discount_with_base_variant;

        if (discount_with_base_variant) {
          global_discount_amount = Number((global_discount / 1.18).toFixed(2));
          global_discount_amount_without_rounding = global_discount / 1.18;
        }

        var _factor = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(global_discount_amount / base, 4);

        this.form.discounts = [{
          discount_type_id: "02",
          description: "Descuentos globales que afectan la base imponible del IGV/IVAP",
          factor: _factor,
          amount: global_discount_amount,
          base: base
        }];
        var new_base = this.form.total_value_without_rounding;
        this.form.total_taxed = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(new_base - global_discount_amount_without_rounding, 2);
        this.form.total_value = this.form.total_taxed;

        if (this.configuration.affectation_igv_type_id == "10") {
          this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_taxed * (this.percentage_igv / 100), 2);
        } else {
          this.form.total_igv = 0;
        } //impuestos (isc + igv + icbper)


        this.form.total_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_igv + this.form.total_isc + this.form.total_plastic_bag_taxes, 2);
        this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_taxed + this.form.total_taxes, 2);
        this.form.subtotal = this.form.total;
      }
    },
    discountGlobal3: function discountGlobal3() {
      var global_discount = parseFloat(this.discount_amount);
      var total = parseFloat(this.form.total);

      if (global_discount > total) {
        this.discount_amount = 0;
        this.$forceUpdate();
        return this.$toast.error("El descuento no puede ser mayor al total");
      }

      var amount = parseFloat(global_discount);
      var discounts = this.splitDiscount(amount, this.form.items.length);
      this.setDiscountItems(discounts);
    },
    setDiscountItems: function setDiscountItems(discounts) {
      for (var _index = 0; _index < this.form.items.length; _index++) {
        var item = this.form.items[_index];
        var discount = discounts[_index];

        if (item.originalTotal == undefined) {
          item.originalTotal = item.total;
          item.originalTotalValue = item.total_value;
        }

        item.discounts = [{
          discount_type_id: "01",
          discount_type: {
            id: "01",
            active: 1,
            base: 0,
            level: "item",
            type: "discount",
            description: "Descuentos que no afectan la base imponible del IGV/IVAP"
          },
          is_amount: true,
          description: "Dscto",
          factor: __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(discount / item.originalTotalValue, 4),
          amount: discount,
          base: item.originalTotalValue
        }];
        item.total_discount = discount;
        item.total = item.originalTotal - discount;
        item.total_value = item.originalTotalValue - discount;
      }
    },
    splitDiscount: function splitDiscount(amount, n) {
      var parts = new Array(n).fill(Math.floor(amount / n));

      for (var i = 0; i < amount % n; i++) {
        parts[i]++;
      }

      return parts;
    },
    discountGlobal2: function discountGlobal2() {
      var global_discount = parseFloat(this.discount_amount);
      var base = parseFloat(this.form.total);
      var amount = parseFloat(global_discount);

      var factor = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount / base, 4);

      var discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.form.discounts, {
        discount_type_id: "03"
      });

      if (global_discount > 0 && !discount) {
        this.form.total_discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
        this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total - amount, 2);
        this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total / (1 + this.percentage_igv || 18 / 100), 2);
        this.form.total_taxed = this.form.total_value;
        this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_value * (this.percentage_igv || 18 / 100), 2);
        this.form.total_taxes = this.form.total_igv;
        this.form.discounts.push({
          discount_type_id: "03",
          description: "Descuentos globales que no afectan la base imponible del IGV/IVAP",
          factor: factor,
          amount: amount,
          base: base
        });
      } else {
        var _index2 = this.form.discounts.indexOf(discount);

        if (_index2 > -1) {
          this.form.total_discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
          this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total - amount, 2);
          this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total / (1 + this.percentage_igv || 18 / 100), 2);
          this.form.total_taxed = this.form.total_value;
          this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total_value * (this.percentage_igv || 18 / 100), 2);
          this.form.total_taxes = this.form.total_igv;
          this.form.discounts[_index2].base = base;
          this.form.discounts[_index2].amount = amount;
          this.form.discounts[_index2].factor = factor;
        }
      }
    },
    method_payment: function method_payment(method_pay) {
      this.hasCreditCardCharge = false;
      this.form.payment_condition_id = "01";
      this.form.method_pay = method_pay;
      this.form.afectar_caja = true;

      if (this.configuration.credit_mode) {
        if (method_pay == "TARJETA: IZYPAY" || method_pay == "TARJETA: NIUBIZ" || method_pay == "Culqui") {
          this.hasCreditCardCharge = true;
        } else {
          this.chargeCredit.amount = 0;
        }

        this.calculateCharge();
      }
    },
    reCalculateTotal: function reCalculateTotal() {
      var total_discount = 0;
      var total_charge = 0;
      var total_exportation = 0;
      var total_taxed = 0;
      var total_exonerated = 0;
      var total_unaffected = 0;
      var total_free = 0;
      var total_igv = 0;
      var total_value = 0;
      var total = 0;
      var total_plastic_bag_taxes = 0;

      if (this.affectation_optional_id != null && this.affectation_optional_id != undefined && this.affectation_optional_id != "") {
        this.form.items = this.formatItems(this.form.items, this.affectation_optional_id);
      }

      this.form.items.forEach(function (row) {
        total_discount += parseFloat(row.total_discount);
        total_charge += parseFloat(row.total_charge);

        if (row.affectation_igv_type_id === "10") {
          total_taxed += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "20") {
          total_exonerated += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "30") {
          total_unaffected += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "40") {
          total_exportation += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
          total_free += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) > -1) {
          total_igv += parseFloat(row.total_igv);
          total += parseFloat(row.total);
        }

        total_value += parseFloat(row.total_value);
        total_plastic_bag_taxes += isNaN(parseFloat(row.total_plastic_bag_taxes)) ? 0.0 : parseFloat(row.total_plastic_bag_taxes);
      });
      this.form.total_exportation = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_exportation, 2);
      this.form.total_taxed = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_taxed, 2);
      this.form.total_exonerated = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_exonerated, 2);
      this.form.total_unaffected = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_unaffected, 2);
      this.form.total_free = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_free, 2);
      this.form.total_igv = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_igv, 2);
      this.form.total_value = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_value, 2);
      this.form.total_value_without_rounding = total_value;
      this.form.total_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_igv, 2);
      this.form.total_plastic_bag_taxes = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_plastic_bag_taxes, 2); // this.form.total = _.round(total, 2)

      this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(total_charge + total + this.form.total_plastic_bag_taxes, 2);

      if (this.discount_amount) {
        this.discountGlobal();
      } // this.discountGlobal();

    },
    chargeGlobal: function chargeGlobal() {
      var base = parseFloat(this.form.total);
      var amount = parseFloat(this.chargeCredit.total_charge);

      var factor = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount / base, 5); // console.log(base,factor, amount)


      if (amount > 0) {
        this.form.total_charge = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(amount, 2);
        this.form.total = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.round(this.form.total + this.form.total_charge, 2);
        this.form.charges.push({
          charge_type_id: "50",
          description: "Cargos globales que no afectan la base imponible del IGV/IVAP",
          factor: factor,
          amount: amount,
          base: base
        });
      }
    },
    deleteChargeGlobal: function deleteChargeGlobal() {
      this.form.total_charge = 0;
    },
    deleteDiscountGlobal: function deleteDiscountGlobal() {
      // console.log("disque borrando");
      // let discount = _.find(this.form.discounts, {
      //     discount_type_id: "03"
      // });
      // let index = this.form.discounts.indexOf(discount);
      // if (index > -1) {
      //     this.form.discounts.splice(index, 1);
      //     this.form.total_discount = 0;
      // }
      for (var _index3 = 0; _index3 < this.form.items.length; _index3++) {
        var item = this.form.items[_index3];
        item.discounts = [];
        item.total_discount = 0;
        item.total = item.originalTotal || item.total;
        item.total_value = item.originalTotalValue || item.total_value;
      }
    },
    deleteDiscountGlobal2: function deleteDiscountGlobal2() {
      var discount = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.form.discounts, {
        discount_type_id: "03"
      });

      var index = this.form.discounts.indexOf(discount);

      if (index > -1) {
        this.form.discounts.splice(index, 1);
        this.form.total_discount = 0;
      }
    },
    getFormPosLocalStorage: function getFormPosLocalStorage() {
      var form_pos = localStorage.getItem("form_pos");
      form_pos = JSON.parse(form_pos);

      if (form_pos) {
        this.form.payments = form_pos.payments;
      }
    },
    clickAddPayment: function clickAddPayment() {
      this.showDialogMultiplePayment = true;
    },
    reloadDataCardBrands: function reloadDataCardBrands(card_brand_id) {
      var _this14 = this;

      this.$http.get("/".concat(this.resource, "/table/card_brands")).then(function (response) {
        _this14.cards_brand = response.data;
        _this14.form_payment.card_brand_id = card_brand_id;

        _this14.changePaymentMethodType();
      });
    },
    getDescriptionPaymentMethodType: function getDescriptionPaymentMethodType(id) {
      var payment_method_type = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.payment_method_types, {
        id: id
      });

      return payment_method_type ? payment_method_type.description : "";
    },
    changePaymentMethodType: function changePaymentMethodType() {
      var payment_method_type = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.find(this.payment_method_types, {
        id: this.form_payment.payment_method_type_id
      });

      this.has_card = payment_method_type.has_card;
      this.form_payment.card_brand_id = payment_method_type.has_card ? this.form_payment.card_brand_id : null;
    },
    addRow: function addRow(payments) {
      this.form.payments = payments;
      var acum_payment = 0;
      this.form.payments.forEach(function (item) {
        acum_payment += parseFloat(item.payment);
      }); // this.amount = acum_payment

      this.setAmount(acum_payment); // console.log(this.form.payments)
    },
    setAmount: function setAmount(amount) {
      // this.amount = parseFloat(this.amount) + parseFloat(amount)
      this.form.enter_amount = amount;
      this.amount = parseFloat(amount); //+ parseFloat(amount)
      //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)

      this.inputAmount(amount);
    },
    setAmountCash: function setAmountCash(amount) {
      this.setAmount(amount);
    },
    diferen: function diferen() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee13() {
        var differen;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                differen = (parseFloat(_this15.form.enter_amount) || 0) + _this15.totalPayments() - parseFloat(_this15.form.total);

                if (differen < 0 && _this15.form.payment_condition_id == "01") {
                  _this15.$toast.error("El monto de efectivo es menor al total de venta");
                }

              case 2:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    totalPayments: function totalPayments() {
      if (this.currentPayments.length != 0) {
        var enter_amount = 0.0;
        this.currentPayments.forEach(function (cp) {
          enter_amount += parseFloat(cp.amount);
        });
        return enter_amount;
      }

      return 0;
    },
    enterAmount: function enterAmount() {
      var _arguments2 = arguments,
          _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee14() {
        var amount, enter_amount, differen;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                amount = _arguments2.length > 0 && _arguments2[0] !== undefined ? _arguments2[0] : 0;
                _this16.amount = amount;
                enter_amount = (parseFloat(_this16.form.enter_amount) || 0) + _this16.totalPayments();
                differen = enter_amount - parseFloat(_this16.form.total);
                _this16.form.difference = parseFloat(differen);

                if (_this16.form.difference < 0) {
                  _this16.button_payment = true;
                  _this16.form.difference = differen;
                } else if (_this16.form.difference >= 0) {
                  _this16.button_payment = false;
                  parseFloat(_this16.form.enter_amount) - parseFloat(_this16.form.total);
                } else {
                  _this16.button_payment = true;
                } //this.form.difference = _.round(this.form.difference, 2);


                _this16.$eventHub.$emit("eventSetFormPosLocalStorage", _this16.form); // this.setAmountCash(amount)


              case 7:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    getLocalStoragePayment: function getLocalStoragePayment(key) {
      var re_default = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var ls_obj = localStorage.getItem(key);
      ls_obj = JSON.parse(ls_obj);

      if (ls_obj) {
        return ls_obj;
      }

      return re_default;
    },
    setLocalStoragePayment: function setLocalStoragePayment(key, obj) {
      return localStorage.setItem(key, JSON.stringify(obj));
    },
    inputAmount: function inputAmount() {
      var amount = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.enterAmount(amount);
      this.form.difference = this.form.enter_amount - this.form.total;

      if (isNaN(this.form.difference)) {
        this.button_payment = true;
        this.form.difference = "-";
      } else if (this.form.difference >= 0) {
        this.button_payment = false;
        this.form.difference = this.amount - this.form.total;
      } else {
        this.button_payment = true;
      }

      this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
    },
    lStoPayment: function lStoPayment() {
      this.setLocalStoragePayment("enter_amount", this.form.enter_amount);
      this.setLocalStoragePayment("amount", this.amount == 0 ? this.form.total : this.amount);
      this.setLocalStoragePayment("difference", this.amount == 0 ? this.form.total - this.amount : 0);
    },
    initFormPayment: function initFormPayment() {
      this.form.difference = this.form.total - this.form.enter_amount;
      this.form_payment = {
        id: null,
        date_of_payment: moment().format("YYYY-MM-DD"),
        payment_method_type_id: "01",
        reference: null,
        card_brand_id: null,
        document_id: null,
        sale_note_id: null,
        payment: this.form.total
      };
      this.form_cash_document = {
        document_id: null,
        sale_note_id: null
      };
    },
    cleanLocalStoragePayment: function cleanLocalStoragePayment() {
      this.setLocalStoragePayment("form_pos", null);
      this.setLocalStoragePayment("amount", null);
      this.setLocalStoragePayment("enter_amount", null);
      this.setLocalStoragePayment("difference", null);
    },
    sleep: function sleep(ms) {
      return new Promise(function (resolve) {
        return setTimeout(resolve, ms);
      });
    },
    passBoxes: function passBoxes(total, boxes) {
      var amounts = boxes.reduce(function (a, b) {
        return a + b.amount;
      }, 0);
      var rest = amounts - total;
      var plus = false;

      if (rest < 0) {
        plus = true;
        rest *= -1;
      }

      var newBoxes = _toConsumableArray(boxes);

      if (rest != 0) {
        for (var i = 0; i < newBoxes.length; i++) {
          var box = newBoxes[i];

          if (plus) {
            box.amount += rest;
            rest = 0;
          } else {
            if (box.amount - rest > 0) {
              box.amount -= rest;
              rest = 0;
            }
          }

          if (rest == 0) {
            break;
          }
        }
      }

      return newBoxes;
    },
    sendPayment: function sendPayment($event) {
      var _arguments3 = arguments,
          _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee15() {
        var form, pass, formVariation, noteVariation;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                form = _arguments3.length > 1 && _arguments3[1] !== undefined ? _arguments3[1] : null;
                // if (this.discount_amount) {
                //     let global_discount = parseFloat(this.discount_amount);
                //     let total = parseFloat(this.form.total);
                //     if (global_discount > total) {
                //         return this.$toast.error(
                //             "El descuento no puede ser mayor al total"
                //         );
                //     }
                // }
                //$confirm check if form.observation is null or empty confirmation
                pass = true;

                if (!(_this17.hasExceedBank && _this17.form.observation == null || _this17.form.observation == "")) {
                  _context15.next = 11;
                  break;
                }

                _context15.prev = 3;
                _context15.next = 6;
                return _this17.$confirm("¿Desea continuar sin registrar la bancarización?", "Advertencia", {
                  confirmButtonText: "Sí",
                  cancelButtonText: "No",
                  type: "warning"
                });

              case 6:
                _context15.next = 11;
                break;

              case 8:
                _context15.prev = 8;
                _context15.t0 = _context15["catch"](3);
                pass = false;

              case 11:
                if (pass) {
                  _context15.next = 13;
                  break;
                }

                return _context15.abrupt("return");

              case 13:
                if (!form) {
                  form = _this17.form;
                }

                form.printerOn = _this17.printerOn == 1 ? true : false;

                if (_this17.conf.pos_quick_sale) {
                  form.printerOn = form.printDocument;
                }

                _context15.next = 18;
                return _this17.clickPayment(form);

              case 18:
                if (!(_this17.formVariation.items.length != 0)) {
                  _context15.next = 35;
                  break;
                }

                formVariation = _this17.formVariation;
                formVariation.printerOn = false;
                formVariation.variation_document_id = _this17.documentNewId;
                formVariation.document_type_id = "80";
                formVariation.customer_telephone = null;
                formVariation.customer_id = _this17.customer_variation.id;
                _this17.customers = [].concat(_toConsumableArray(_this17.customers.filter(function (c) {
                  return c != _this17.customer_variation.id;
                })), [_this17.customer_variation]);
                formVariation.boxes = _this17.passBoxes(_this17.formVariation.total, _this17.form.boxes);
                noteVariation = _this17.all_series.find(function (s) {
                  return s.document_type_id == "80";
                });

                if (!noteVariation) {
                  _context15.next = 34;
                  break;
                }

                formVariation.series_id = noteVariation.id;
                _context15.next = 32;
                return _this17.clickPayment(formVariation);

              case 32:
                _context15.next = 35;
                break;

              case 34:
                _this17.$toast.error("Sin serie en nota de venta");

              case 35:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15, null, [[3, 8]]);
      }))();
    },
    checkPaymentsIsOk: function checkPaymentsIsOk() {
      var total = 0;
      this.currentPayments.forEach(function (p) {
        total += parseFloat(p.amount);
      });
      return total == this.form.total;
    },
    checkBankAccount: function checkBankAccount() {
      var pass = true;
      var is_bank = this.form_payment.is_bank;

      if (is_bank) {
        if (!this.form.bank_account_id) {
          this.$toast.error("Debe seleccionar una cuenta bancaria");
          pass = false;
        }

        if (!this.form.reference_number) {
          this.$toast.error("Debe ingresar el número de operación");
          pass = false;
        }
      }

      return pass;
    },
    clickPayment: function clickPayment(form) {
      var _this18 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee16() {
        var how_is, customer, isOk, form_efectivo, ordenId, responses, response, format, data, document_id, registerCollegeResponse, consigmentLiquidate, response2, itemspromo, procesarOferta, _response, message;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                if (_this18.checkBankAccount()) {
                  _context16.next = 2;
                  break;
                }

                return _context16.abrupt("return");

              case 2:
                _this18.reCalculateTotal(); // return;


                if (!_this18.form.series_id && _this18.conf.pos_quick_sale || _this18.ordens_all_table) {
                  _this18.setSeries();
                }

                if (!(_this18.configuration.college && !_this18.conf.pos_quick_sale)) {
                  _context16.next = 8;
                  break;
                }

                if (_this18.form.student_id) {
                  _context16.next = 8;
                  break;
                }

                _this18.$toast.error("El alumno es obligatorio");

                return _context16.abrupt("return");

              case 8:
                if (!((form.document_type_id == "01" || form.document_type_id == "03") && form.total <= 0)) {
                  _context16.next = 11;
                  break;
                }

                _this18.$toast.error("El monto total no puede ser menor o igual a 0");

                return _context16.abrupt("return");

              case 11:
                if (!(form.total + 200 <= form.enter_amount)) {
                  _context16.next = 14;
                  break;
                }

                _this18.$toast.error("El monto ingresado no puede ser S/. 200 mayor del Total a cobrar ");

                return _context16.abrupt("return");

              case 14:
                customer = _this18.customers.find(function (c) {
                  return c.id == form.customer_id;
                });

                if (!(form.customer_telephone != null && form.customer_telephone != "")) {
                  _context16.next = 19;
                  break;
                }

                if (_this18.existNumber()) {
                  _context16.next = 19;
                  break;
                }

                _this18.$toast.error("Número para envío whatsapp inválido");

                return _context16.abrupt("return");

              case 19:
                if (!(form.customer_id == null || form.customer_id == "")) {
                  _context16.next = 21;
                  break;
                }

                return _context16.abrupt("return", _this18.$toast.error("Elija un cliente"));

              case 21:
                if (!(customer.identity_document_type_id == "1" && form.document_type_id == "01")) {
                  _context16.next = 23;
                  break;
                }

                return _context16.abrupt("return", _this18.$toast.error("No puede emitir Factura con DNI"));

              case 23:
                if (form.series_id) {
                  _context16.next = 25;
                  break;
                }

                return _context16.abrupt("return", _this18.$toast.warning("El establecimiento no tiene series disponibles para el comprobante"));

              case 25:
                if (form.document_type_id === "80") {
                  form.prefix = "NV";
                  form.paid = 1;
                  _this18.resource_documents = "sale-notes";
                  _this18.resource_payments = "sale_note_payments";
                  _this18.resource_options = _this18.resource_documents;
                } else {
                  form.prefix = null;
                  _this18.resource_documents = "documents";
                  _this18.resource_payments = "document_payments";
                  _this18.resource_options = _this18.resource_documents;
                }

                if (_this18.orden != null) {
                  form.additional_information = "Orden N\xB0".concat(_this18.orden);
                }

                form.advances = 0.0;
                form.total_advances = 0.0;
                form.total_payment = form.total;
                form.payments = [{
                  payment_method_type_id: "01",
                  date_of_payment: form.date_of_issue,
                  payment: form.total
                }];
                form.cash_id = _this18.cash_id;

                if (!(_this18.form.payment_condition_id == "01")) {
                  _context16.next = 37;
                  break;
                }

                form.boxes = _this18.currentPayments;

                if (_this18.form_payment.is_bank) {
                  _this18.changeBankAccount();
                }

                _context16.next = 41;
                break;

              case 37:
                isOk = _this18.checkPaymentsIsOk();

                if (isOk) {
                  _context16.next = 41;
                  break;
                }

                _this18.$toast.error("Las cuotas no coinciden con el total");

                return _context16.abrupt("return");

              case 41:
                if (_this18.form.payment_condition_id !== "01") {
                  form.fee = _this18.currentPayments.map(function (b) {
                    return {
                      id: null,
                      currency_type_id: "PEN",
                      amount: b.amount,
                      date: b.date
                    };
                  });
                  form.payment_condition_id = "02";
                } else {
                  _this18.addPayment();
                }

                if (!_this18.checkLimitReceipt()) {
                  _context16.next = 45;
                  break;
                }

                _this18.$toast.error("Las boletas mayores a 699 deben tener un dni o ruc válido.");

                return _context16.abrupt("return");

              case 45:
                _this18.loading_submit = true;
                _this18.form.items = _this18.form.items.filter(function (item) {
                  return Number(item.quantity) > 0;
                });

                if (_this18.isConsignment) {
                  _this18.form.from_consignment = true;
                }

                _context16.prev = 48;
                form_efectivo = {
                  enter_amount: form.enter_amount,
                  difference: form.difference
                };
                ordenId = _this18.idOrden;

                if (!((ordenId == undefined || ordenId == null) && (form.variation == undefined || form.variation == null) && !_this18.conf.pos_quick_sale && !_this18.ordens_all_table)) {
                  _context16.next = 58;
                  break;
                }

                _context16.next = 54;
                return _this18.$http.post("/caja/worker/send-orden", _this18.orden_items);

              case 54:
                responses = _context16.sent;
                ordenId = responses.data.id;

                if (!(responses.status != 200)) {
                  _context16.next = 58;
                  break;
                }

                return _context16.abrupt("return");

              case 58:
                form.orden_id = ordenId;

                if (_this18.ordens_all_table) {
                  form.all_ordens = true;
                } // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);


                _context16.next = 62;
                return _this18.$http.post("/".concat(_this18.resource_documents), form);

              case 62:
                response = _context16.sent;

                if (!(response.status == 200)) {
                  _context16.next = 132;
                  break;
                }

                format = null;
                data = response.data.data;
                _context16.t0 = data.format_printer;
                _context16.next = _context16.t0 === 1 ? 69 : _context16.t0 === 2 ? 71 : 73;
                break;

              case 69:
                format = data.print_a4;
                return _context16.abrupt("break", 75);

              case 71:
                format = data.print_a5;
                return _context16.abrupt("break", 75);

              case 73:
                format = data.print_ticket;
                return _context16.abrupt("break", 75);

              case 75:
                if (_this18.printer && format && _this18.printerOn == 1) {// this.printerDocument(this.printer,format)
                }

                if (!(response.data.success == true)) {
                  _context16.next = 130;
                  break;
                }

                document_id = 0;

                if (form.document_type_id === "80") {
                  _this18.number = response.data.data.number;
                  document_id = response.data.data.id;
                  _this18.form_cash_document.sale_note_id = response.data.data.id;
                } else {
                  document_id = response.data.data.id;
                  _this18.form_cash_document.document_id = response.data.data.id;
                  _this18.number = response.data.data.number;
                }

                _this18.documentNewId = response.data.data.id;

                if (!(response.data.success == true)) {
                  _context16.next = 130;
                  break;
                }

                if (!ordenId) {
                  _context16.next = 125;
                  break;
                }

                if (!(_this18.configuration.college && _this18.form.student_id)) {
                  _context16.next = 86;
                  break;
                }

                _context16.next = 85;
                return _this18.$http.post("/college/registers/sale", {
                  is_sale_note: form.document_type_id == "80",
                  document_id: _this18.documentNewId,
                  detail: {
                    items: _this18.form.items.map(function (s) {
                      return s.item;
                    })
                  },
                  student_id: _this18.form.student_id
                });

              case 85:
                registerCollegeResponse = _context16.sent;

              case 86:
                if (!(_this18.configuration.consignment && _this18.consignment_id && _this18.isConsignment)) {
                  _context16.next = 91;
                  break;
                }

                _context16.next = 89;
                return _this18.$http.post("/consignment/liquidated", {
                  id: _this18.consignment_id,
                  items: _this18.form.items.map(function (i) {
                    return {
                      consignment_item_id: i.consignment_item_id,
                      toWarehouse: i.toWarehouse,
                      quantity: i.quantity
                    };
                  }),
                  document_id: _this18.documentNewId,
                  document_type_id: form.document_type_id
                });

              case 89:
                consigmentLiquidate = _context16.sent;

                if (consigmentLiquidate.status == 200) {
                  _this18.$toast.success("Liquidación de consignación realizada.");
                }

              case 91:
                _context16.next = 93;
                return _this18.$http.post("pos/orden_payment", {
                  id: ordenId,
                  customer_id: customer.id,
                  document: {
                    isNoteSale: form.document_type_id === "80",
                    id: _this18.documentNewId
                  }
                });

              case 93:
                response2 = _context16.sent;

                if (!_this18.configuration.promotions_sell) {
                  _context16.next = 101;
                  break;
                }

                how_is = _this18.all_customers.find(function (c) {
                  return c.id == form.customer_id;
                });

                if (how_is.name.includes("VARIOS")) {
                  _context16.next = 101;
                  break;
                }

                itemspromo = form.items;
                _context16.next = 100;
                return axios.post("pos/processPromo", {
                  itemspromo: itemspromo,
                  how_is: how_is
                });

              case 100:
                procesarOferta = _context16.sent;

              case 101:
                if (!(response2.data.success == true)) {
                  _context16.next = 122;
                  break;
                }

                if (!_this18.form.customer_telephone) {
                  _context16.next = 116;
                  break;
                }

                if (!_this18.personalWhatsapp) {
                  _context16.next = 108;
                  break;
                }

                _context16.next = 106;
                return _this18.$emit("getFile", {
                  total: _this18.form.total,
                  documentId: _this18.documentNewId,
                  documentTypeId: form.document_type_id,
                  number: _this18.form.customer_telephone,
                  message: _this18.form.message
                });

              case 106:
                _context16.next = 110;
                break;

              case 108:
                _context16.next = 110;
                return _this18.clickSendWhatsapp(form.document_type_id, _this18.documentNewId, _this18.number, form);

              case 110:
                _this18.$emit("limpiarForm");

                _this18.loading_submit = false;

                _this18.$emit("removeConsignment");

                _this18.back(true);

                _context16.next = 120;
                break;

              case 116:
                _this18.$emit("limpiarForm");

                _this18.loading_submit = false;

                _this18.$emit("removeConsignment");

                _this18.back(true);

              case 120:
                _context16.next = 123;
                break;

              case 122:
                console.log(response2);

              case 123:
                _context16.next = 130;
                break;

              case 125:
                if (_this18.conf.pos_quick_sale) {
                  _this18.$toast.success("Venta realizada.");
                }

                _this18.$emit("limpiarForm");

                _this18.$emit("removeConsignment");

                _this18.loading_submit = false;

                _this18.back(true);

              case 130:
                _context16.next = 134;
                break;

              case 132:
                _this18.loading_submit = true;

                _this18.$alert("<strong>Ocurrio un error </strong>" + response.statusCode + "<br>" + _this18.resource_documents, "HTML String", {
                  dangerouslyUseHTMLString: true
                });

              case 134:
                _context16.next = 143;
                break;

              case 136:
                _context16.prev = 136;
                _context16.t1 = _context16["catch"](48);
                console.log(_context16.t1);
                _response = _context16.t1.response;
                message = _response.data.message;

                _this18.$toast.error(message || "Ocurrió un error");

                _this18.loading_submit = false;

              case 143:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16, null, [[48, 136]]);
      }))();
    },
    clickPrintPos: function clickPrintPos(printerName, formatoPdf) {
      var _arguments4 = arguments,
          _this19 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee17() {
        var userId, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                userId = _arguments4.length > 2 && _arguments4[2] !== undefined ? _arguments4[2] : null;
                _context17.prev = 1;
                config = qz.configs.create(printerName, {
                  legacy: true
                }, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context17.next = 6;
                  break;
                }

                _context17.next = 6;
                return qz.websocket.connect(config);

              case 6:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: formatoPdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this19.$toast.error(e.message);
                });
                _context17.next = 13;
                break;

              case 10:
                _context17.prev = 10;
                _context17.t0 = _context17["catch"](1);

                _this19.$toast.error(_context17.t0.message);

              case 13:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17, null, [[1, 10]]);
      }))();
    },
    saveCashDocument: function saveCashDocument() {
      var _this20 = this;

      this.$http.post("/cash/cash_document", this.form_cash_document).then(function (response) {
        if (response.data.success) {// console.log(response)
        } else {
          _this20.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        console.log(error);
      });
    },
    savePaymentMethod: function savePaymentMethod() {
      var _this21 = this;

      this.$http.post("/".concat(this.resource_payments), this.form_payment).then(function (response) {
        if (response.data.success) {// console.log(response)
        } else {
          _this21.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this21.records[index].errors = error.response.data;
        } else {
          console.log(error);
        }
      });
    },
    getTables: function getTables() {
      this.filterSeries();
    },
    clickCancel: function clickCancel() {
      var _this22 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee18() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee18$(_context18) {
          while (1) {
            switch (_context18.prev = _context18.next) {
              case 0:
                _this22.loading_submit = true;
                _this22.loading_submit = false;

                _this22.cleanLocalStoragePayment();

                _this22.$eventHub.$emit("cancelSale");

              case 4:
              case "end":
                return _context18.stop();
            }
          }
        }, _callee18);
      }))();
    },
    back: function back() {
      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      this.splitPayments = []; //this.$emit("limpiarForm");

      if (!val) {
        this.$emit("openDrawer");
      }

      this.$emit("update:is_payment", false);
    },
    initLStoPayment: function initLStoPayment() {
      var _this23 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee19() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee19$(_context19) {
          while (1) {
            switch (_context19.prev = _context19.next) {
              case 0:
                _context19.next = 2;
                return _this23.getLocalStoragePayment("amount", _this23.form.total);

              case 2:
                _this23.amount = _context19.sent;
                _context19.next = 5;
                return _this23.getLocalStoragePayment("enter_amount", _this23.form.total);

              case 5:
                _this23.form.enter_amount = _context19.sent;
                _context19.next = 8;
                return _this23.getLocalStoragePayment("difference", _this23.form.total - _this23.form.enter_amount);

              case 8:
                _this23.form.difference = _context19.sent;

              case 9:
              case "end":
                return _context19.stop();
            }
          }
        }, _callee19);
      }))();
    },
    checkCustomers: function checkCustomers() {
      if (this.form.document_type_id == "01") {
        return this.customers.some(function (c) {
          return c.identity_document_type_id == "6";
        });
      } else {
        return this.customers.some(function (c) {
          return c.identity_document_type_id == "1";
        });
      }
    },
    setSeries: function setSeries() {
      var _this24 = this;

      this.form.series_id = null;
      this.series = __WEBPACK_IMPORTED_MODULE_1_lodash___default.a.filter(this.all_series, {
        document_type_id: this.form.document_type_id
      });
      this.series.forEach(function (s) {
        s.full_number = "".concat(s.number, "-").concat(_this24.last_number[s.number] || "1") || s.number;
      });
      this.form.series_id = this.series.length > 0 ? this.series[0].id : null;
    },
    filterSeries: function filterSeries() {
      var _this25 = this;

      var check = this.checkCustomers();

      if (!check && !this.started) {
        var dcto = "DNI";

        if (this.form.document_type_id == "01") {
          dcto = "RUC";
          this.form.document_type_id = "03";
        } else {
          this.form.document_type_id = "01";
        }

        this.$toast.warning("Digite el n\xFAmero de ".concat(dcto));
        this.setSeries();
        return;
      }

      this.started = false;

      if (this.form.document_type_id == "01") {
        this.currentDocumentsType = _toConsumableArray(this.documentsType.filter(function (f) {
          return f.description == "RUC";
        }));
        this.form.identity_document_type_id = this.currentDocumentsType[0].id;
      } else {
        this.currentDocumentsType = this.documentsType;
      }

      this.setSeries(); //aqui
      //factura solo ruc
      //boletas solo dni
      //note de venta todo

      var currentClient = null;

      if (this.value != null) {
        currentClient = this.all_customers.find(function (c) {
          return c.id == _this25.value;
        }); // if (currentClient.identity_document_type_id == "1") {
        //     this.form.document_type_id = "03";
        // }
      }

      if (this.form.document_type_id == "01") {
        this.customers = this.all_customers.filter(function (f) {
          return f.identity_document_type_id == "6";
        });

        if (this.customers.length == 0) {
          this.$toast.warning("Digite el número de RUC");
          this.form.document_type_id == "03"; // this.customers = this.all_customers;
        } else {
          if (currentClient && this.customers.some(function (c) {
            return c.id == currentClient.id;
          })) {
            this.form.customer_telephone = currentClient.phone;
            return;
          }

          this.value = this.customers[0].id;
          this.form.customer_telephone = this.customers[0].phone;
        }
      } // else if (
      //     this.form.document_type_id == "03" ||
      //     this.form.document_type_id == "80"
      // ) {
      //     this.customers = this.all_customers.filter(
      //         f => f.identity_document_type_id != "6"
      //     );
      //     if (this.form.total > 300) {
      //         this.customers = this.customers.filter(
      //             c => c.identity_document_type_id == "1"
      //         );
      //     }
      //     if (
      //         currentClient &&
      //         this.customers.some(c => c.id == currentClient.id)
      //     ) {
      //         this.form.customer_telephone = currentClient.phone;
      //         return;
      //     }
      //     let client = this.customers.find(c => {
      //         return c.name.toLowerCase().includes("varios");
      //     });
      //     if (client) {
      //         this.value = client.id;
      //         this.form.customer_telephone = client.phone;
      //     } else {
      //         this.value = this.customers[0].id;
      //         this.form.customer_telephone = this.customers[0].phone;
      //     }
      // }
      else {
        this.customers = this.all_customers;
      }

      this.customers = this.customers.filter(function (n) {
        return n.number != "88888888";
      });
      this.customers = _toConsumableArray(this.customers.filter(function (n) {
        return n.id != _this25.customer_default.id;
      }));

      if (this.form.document_type_id != "01") {
        this.customers = [].concat(_toConsumableArray(this.customers), [this.customer_default]);
      }

      this.changeCustomer();

      if (this.form.document_type_id == "80") {
        this.discount_amount = 0;
        this.inputDiscountAmount();
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.algunaClase .el-dialog .el-dialog__header .el-dialog__title {\r\n    font-size: 35px !important;\n}\n.el-scrollbar {\r\n    z-index: 2000 !important;\n}\n.c-width {\r\n    width: 80px !important;\r\n    padding: 0 !important;\r\n    margin-right: 0 !important;\n}\n.control-label,\r\nh4,\r\nh5,\r\nlabel {\r\n    color: #000;\n}\r\n/* .el-dialog__header {\r\n    padding: 0px;\r\n}\r\n.el-dialog__body {\r\n    padding: 0px !important;\r\n} */\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/Restaurant/Resources/assets/js/views/pos/partials/modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue"],"names":[],"mappings":";AA4wCA;IACA,2BAAA;CACA;AACA;IACA,yBAAA;CACA;AACA;IACA,uBAAA;IACA,sBAAA;IACA,2BAAA;CACA;AACA;;;;IAIA,YAAA;CACA;AACA;;;;;IAKA","file":"payment.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :visible=\"is_payment\"\r\n        @open=\"date_of_issue\"\r\n        :close-on-click-modal=\"false\"\r\n        :close-on-press-escape=\"false\"\r\n        :modal-append-to-body=\"true\"\r\n        :show-close=\"false\"\r\n        :append-to-body=\"true\"\r\n        width=\"850px\"\r\n        top=\"2vh\"\r\n        :title=\"`MODULO DE COBRO ${variation ? '- Variación' : ''}`\"\r\n        class=\"algunaClase\"\r\n    >\r\n        <div v-loading=\"loading\" class=\" mb-0\">\r\n            <div class=\"pt-1\" v-loading=\"loading_submit\">\r\n                <div class=\"d-flex pt-2 justify-content-end\">\r\n                    <el-button\r\n                        size=\"mini\"\r\n                        type=\"primary\"\r\n                        @click=\"showListItems = true\"\r\n                    >\r\n                        <i class=\"fas fa-clipboard-list\"></i>\r\n                    </el-button>\r\n                </div>\r\n                <div class=\"row pt-2\">\r\n                    <div class=\"col-lg-12\">\r\n                        <div class=\"mb-2\">\r\n                            <div class=\"card bg-light\">\r\n                                <div class=\"row \">\r\n                                    <div class=\"  col-md-6 col-lg-5 col-sm-6\">\r\n                                        <label class=\"control-label\"\r\n                                            >Comprobante de Pago\r\n                                        </label>\r\n                                        <div class=\"form-group\">\r\n                                            <el-radio-group\r\n                                                v-model=\"form.document_type_id\"\r\n                                                size=\"small\"\r\n                                                @change=\"\r\n                                                    date_of_issue();\r\n                                                    filterSeries();\r\n                                                \"\r\n                                            >\r\n                                                <template v-if=\"!isInterno\">\r\n                                                    <el-radio-button\r\n                                                        v-if=\"invoice\"\r\n                                                        label=\"01\"\r\n                                                        >FACTURA\r\n                                                    </el-radio-button>\r\n                                                    <el-radio-button\r\n                                                        v-if=\"receipt\"\r\n                                                        label=\"03\"\r\n                                                    >\r\n                                                        BOLETA\r\n                                                    </el-radio-button>\r\n                                                </template>\r\n                                                <el-radio-button\r\n                                                    v-if=\"\r\n                                                        !variation &&\r\n                                                            sale_note &&\r\n                                                            !clientSaleNoteNumber\r\n                                                    \"\r\n                                                    label=\"80\"\r\n                                                >\r\n                                                    N. VENTA\r\n                                                </el-radio-button>\r\n                                            </el-radio-group>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div\r\n                                        class=\"col-6 col-md-3 col-lg-3 col-xl-3\"\r\n                                    >\r\n                                        <label class=\"control-label\">\r\n                                            Serie\r\n                                        </label>\r\n                                        <div class=\"form-group\">\r\n                                            <el-select\r\n                                                v-model=\"form.series_id\"\r\n                                                class=\"w-100\"\r\n                                            >\r\n                                                <el-option\r\n                                                    style=\"z-index:2000 !important;\"\r\n                                                    v-for=\"option in series\"\r\n                                                    :key=\"option.id\"\r\n                                                    :label=\"option.full_number\"\r\n                                                    :value=\"option.id\"\r\n                                                >\r\n                                                </el-option>\r\n                                            </el-select>\r\n                                        </div>\r\n                                    </div>\r\n\r\n                                    <div class=\"col-6 col-md-4 col-lg-4 \">\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"control-label\"\r\n                                                >Fecha de Emisión</label\r\n                                            >\r\n                                            <el-date-picker\r\n                                                style=\"width:100%;\"\r\n                                                v-model=\"form.date_of_issue\"\r\n                                                type=\"date\"\r\n                                                value-format=\"yyyy-MM-dd\"\r\n                                                :clearable=\"false\"\r\n                                                format=\"dd-MM-yyyy\"\r\n                                                :readonly=\"\r\n                                                    this.configuration\r\n                                                        .restrict_receipt_date\r\n                                                \"\r\n                                                @change=\"changeDateOfIssue\"\r\n                                            >\r\n                                            </el-date-picker>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row \">\r\n                                    <div class=\"col-lg-6 \">\r\n                                        <div class=\"form-group\">\r\n                                            <template>\r\n                                                <div\r\n                                                    class=\"el-input el-input-group col-md-6 \"\r\n                                                    style=\"margin-bottom:3px;\"\r\n                                                >\r\n                                                    <label\r\n                                                        class=\"control-label\"\r\n                                                        style=\"margin-right:3px;\"\r\n                                                        >Cliente</label\r\n                                                    >\r\n                                                    <el-button\r\n                                                        :disabled=\"\r\n                                                            !value ||\r\n                                                                isClientesVarios()\r\n                                                        \"\r\n                                                        @click=\"\r\n                                                            openDialogPerson\r\n                                                        \"\r\n                                                        >Editar\r\n                                                        cliente</el-button\r\n                                                    >\r\n                                                    <el-button\r\n                                                        v-if=\"\r\n                                                            !configuration.college\r\n                                                        \"\r\n                                                        @click=\"createClient\"\r\n                                                        >Nuevo\r\n                                                        cliente</el-button\r\n                                                    >\r\n                                                </div>\r\n                                            </template>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-12 col-sm-8 col-lg-6\">\r\n                                        <el-select\r\n                                            class=\"col-md-6\"\r\n                                            ref=\"select_person\"\r\n                                            v-model=\"value\"\r\n                                            filterable\r\n                                            clearable\r\n                                            size=\"small\"\r\n                                            placeholder=\"Cliente\"\r\n                                            :disabled=\"loading\"\r\n                                            @change=\"changeCustomer\"\r\n                                            @keyup.native=\"keyupCustomer\"\r\n                                        >\r\n                                            <el-option\r\n                                                v-for=\"option in customers\"\r\n                                                :key=\"option.id\"\r\n                                                :label=\"option.description\"\r\n                                                :value=\"option.id\"\r\n                                            ></el-option>\r\n                                        </el-select>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div\r\n                                    v-if=\"students.length != 0\"\r\n                                    class=\"row col-lg-6 col-xl-12\"\r\n                                >\r\n                                    <div class=\"form-group\">\r\n                                        <label class=\"control-label w-100\"\r\n                                            >Estudiante</label\r\n                                        >\r\n                                        <el-select\r\n                                            @change=\"changeStudent\"\r\n                                            v-model=\"form.student_id\"\r\n                                        >\r\n                                            <el-option\r\n                                                v-for=\"(student,\r\n                                                idx) in students\"\r\n                                                :key=\"idx\"\r\n                                                :label=\"\r\n                                                    `${student.name} - ${student.class}`\r\n                                                \"\r\n                                                :value=\"student.id\"\r\n                                            >\r\n                                            </el-option>\r\n                                        </el-select>\r\n                                    </div>\r\n                                </div>\r\n                                <div\r\n                                    class=\"row\"\r\n                                    v-if=\"configuration.seller_caja\"\r\n                                >\r\n                                    <div class=\"col-md-4 col-12\">\r\n                                        <label for=\"seller\">Vendedor</label>\r\n                                        <el-select v-model=\"form.seller_id\">\r\n                                            <el-option\r\n                                                v-for=\"(option, idx) in sellers\"\r\n                                                :key=\"idx\"\r\n                                                :label=\"option.name\"\r\n                                                :value=\"option.id\"\r\n                                            >\r\n                                            </el-option>\r\n                                        </el-select>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row col-lg-12 col-xl-12\">\r\n                                    <div class=\"form-group\">\r\n                                        <label class=\"control-label\"\r\n                                            >Observaciones</label\r\n                                        >\r\n                                        <el-input\r\n                                            ref=\"observation\"\r\n                                            type=\"textarea\"\r\n                                            :rows=\"2\"\r\n                                            :placeholder=\"bank\"\r\n                                            v-model=\"form.observation\"\r\n                                        ></el-input>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\" v-if=\"form.document_type_id!='80'\">\r\n                                    <div class=\"col-md-4 form-group\">\r\n                                        <label class=\"control-label\"\r\n                                            >Monto Descuento</label\r\n                                        >\r\n                                        <el-input-number\r\n                                            :min=\"0\"\r\n                                            controls-position=\"right\"\r\n                                            @change=\"inputDiscountAmount\"\r\n                                            class=\"w-100\"\r\n                                            v-model=\"discount_amount\"\r\n                                        ></el-input-number>\r\n                                    </div>\r\n                                    <div\r\n                                        v-if=\"\r\n                                            configuration.affectation_igv_type_id ==\r\n                                                '10'\r\n                                        \"\r\n                                        class=\"col-md-4 form-group\"\r\n                                    >\r\n                                        <label class=\"control-label\"\r\n                                            >Tipo de descuento</label\r\n                                        >\r\n                                        <el-checkbox\r\n                                            v-model=\"discountTotal\"\r\n                                            @change=\"reCalculateTotal\"\r\n                                        >\r\n                                            {{\r\n                                                discountTotal\r\n                                                    ? \"Descuento del total\"\r\n                                                    : \"Descuento a la base\"\r\n                                            }}\r\n                                        </el-checkbox>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <div class=\"col-lg-12\">\r\n                        <div class=\" mb-2 \">\r\n                            <div\r\n                                class=\" text-center text-dark card  bg-light  \"\r\n                            >\r\n                                <div class=\"row\">\r\n                                    <div class=\"  col-lg-6 \">\r\n                                        <div class=\" align-items-start \">\r\n                                            <label class=\"control-label\"\r\n                                                >Medios de Pago</label\r\n                                            >\r\n                                            <label\r\n                                                role=\"button\"\r\n                                                class=\"text-primary control-label\"\r\n                                            ></label>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"radio-tile-group2 flex-wrap\"\r\n                                        >\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"cash\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"01\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'Efectivo'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonEfectivo.png') ; background-size: contain ; background-repeat: no-repeat\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon walk-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"cash\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"culqui\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"02\"\r\n                                                    @change=\"\r\n                                                        method_payment('Culqui')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/CulquiIcon.png') ; background-size: contain ; background-repeat: no-repeat\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"05\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: IZYPAY'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonIzipay.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                              <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"07\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: OPENPAY'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonOpenpay.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"06\"\r\n                                                    @change=\"\r\n                                                        method_payment(\r\n                                                            'TARJETA: NIUBIZ'\r\n                                                        )\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/botonNiubiz.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"yape\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"03\"\r\n                                                    @change=\"\r\n                                                        method_payment('Yape')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png') ; background-size: contain ; background-repeat: no-repeat\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"input-container2 border rounded-sm\"\r\n                                            >\r\n                                                <input\r\n                                                    :disabled=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                    id=\"plin\"\r\n                                                    v-model=\"method_payments\"\r\n                                                    class=\"radio-button2\"\r\n                                                    type=\"radio\"\r\n                                                    name=\"method_payment\"\r\n                                                    value=\"04\"\r\n                                                    @change=\"\r\n                                                        method_payment('PLIN')\r\n                                                    \"\r\n                                                />\r\n                                                <div\r\n                                                    class=\"radio-tile2\"\r\n                                                    style=\"background-image: url('../../images/plin-logo-0C4106153C-seeklogo.com.png') ; background-size: contain ; background-repeat: no-repeat; \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"icon bike-icon\"\r\n                                                    ></div>\r\n                                                    <label\r\n                                                        for=\"Tarjeta\"\r\n                                                        class=\"radio-tile-label2\"\r\n                                                    ></label>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"row col-md-12\">\r\n                                            <div\r\n                                                class=\"mt-2 d-flex justify-content-start align-items-end\"\r\n                                                v-if=\"\r\n                                                    hasCreditCardCharge &&\r\n                                                        configuration.credit_mode\r\n                                                \"\r\n                                            >\r\n                                                <div class=\"col-md-4\">\r\n                                                    <label\r\n                                                        class=\"w-100\"\r\n                                                        style=\"text-align:left;\"\r\n                                                    >\r\n                                                        {{\r\n                                                            chargeCredit.credit_type ==\r\n                                                            \"1\"\r\n                                                                ? \"Porcentaje\"\r\n                                                                : \"Monto\"\r\n                                                        }}\r\n                                                    </label>\r\n                                                    <el-input\r\n                                                        type=\"number\"\r\n                                                        @input=\"calculateCharge\"\r\n                                                        class=\"w-100\"\r\n                                                        v-model=\"\r\n                                                            chargeCredit.amount\r\n                                                        \"\r\n                                                    >\r\n                                                    </el-input>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"col-md-2\"\r\n                                                    style=\"text-align:left;margin-left:5px;\"\r\n                                                >\r\n                                                    <el-radio-group\r\n                                                        @change=\"\r\n                                                            calculateCharge\r\n                                                        \"\r\n                                                        v-model=\"\r\n                                                            chargeCredit.credit_type\r\n                                                        \"\r\n                                                        size=\"small\"\r\n                                                    >\r\n                                                        <el-radio-button\r\n                                                            label=\"1\"\r\n                                                            >%</el-radio-button\r\n                                                        >\r\n                                                        <el-radio-button\r\n                                                            label=\"2\"\r\n                                                            >S/</el-radio-button\r\n                                                        >\r\n                                                    </el-radio-group>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"col-md-3 align-self-center mt-4\"\r\n                                                    style=\"text-align:left;margin-left:5px;\"\r\n                                                >\r\n                                                    <label\r\n                                                        class=\"h5\"\r\n                                                        v-if=\"\r\n                                                            chargeCredit.total_charge !=\r\n                                                                0 &&\r\n                                                                chargeCredit.amount\r\n                                                        \"\r\n                                                    >\r\n                                                        S/\r\n                                                        {{\r\n                                                            chargeCredit.total_charge.toFixed(\r\n                                                                2\r\n                                                            )\r\n                                                        }}\r\n                                                    </label>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-lg-6\">\r\n                                        <template\r\n                                            v-if=\"bank_accounts.length != 0\"\r\n                                        >\r\n                                            <label for=\"banks\">\r\n                                                <el-checkbox\r\n                                                    v-model=\"\r\n                                                        form_payment.is_bank\r\n                                                    \"\r\n                                                ></el-checkbox>\r\n                                                Transferencia / Depositos</label\r\n                                            >\r\n                                            <el-select\r\n                                                :disabled=\"\r\n                                                    !form_payment.is_bank\r\n                                                \"\r\n                                                v-model=\"form.bank_account_id\"\r\n                                                @change=\"changeBankAccount\"\r\n                                            >\r\n                                                <el-option\r\n                                                    v-for=\"bank in bank_accounts\"\r\n                                                    :key=\"bank.id\"\r\n                                                    :label=\"\r\n                                                        `${bank.description}-${bank.number}`\r\n                                                    \"\r\n                                                    :value=\"bank.id\"\r\n                                                >\r\n                                                </el-option>\r\n                                            </el-select>\r\n                                            <el-input\r\n                                                :disabled=\"\r\n                                                    !form_payment.is_bank\r\n                                                \"\r\n                                                class=\"mt-1\"\r\n                                                placeholder=\"Nro Operación\"\r\n                                                v-model=\"form.reference_number\"\r\n                                            ></el-input\r\n                                        ></template>\r\n                                        <template v-else>\r\n                                            <span class=\"text-danger\"\r\n                                                >No hay cuentas bancarias\r\n                                                registradas</span\r\n                                            >\r\n                                        </template>\r\n                                    </div>\r\n                                    <div class=\"col-lg-12\">\r\n                                        <div class=\"row\">\r\n                                            <div\r\n                                                class=\"col-lg-4 col-md-5 col-xl-6\"\r\n                                            >\r\n                                                <label\r\n                                                    class=\"control-label text-left  d-flex align-items-start justify-content-start\"\r\n                                                >\r\n                                                    Ingrese Nro Celular\r\n                                                </label>\r\n                                                <el-input\r\n                                                    v-model=\"\r\n                                                        form.customer_telephone\r\n                                                    \"\r\n                                                >\r\n                                                    <template slot=\"prepend\"\r\n                                                        ><i\r\n                                                            class=\"fab fa-whatsapp fa-2x\"\r\n                                                        ></i>\r\n                                                    </template>\r\n                                                </el-input>\r\n                                            </div>\r\n                                            <div\r\n                                                class=\"radio-tile-group2 col-lg-6 col-xl-6 d \"\r\n                                                style=\"padding-top: 12px;\"\r\n                                            >\r\n                                                <div\r\n                                                    class=\"input-container2 border rounded-sm col-lg-3\"\r\n                                                >\r\n                                                    <input\r\n                                                        id=\"imprimir\"\r\n                                                        v-model=\"printerOn\"\r\n                                                        class=\"radio-button2\"\r\n                                                        type=\"radio\"\r\n                                                        name=\"imprimir\"\r\n                                                        value=\"1\"\r\n                                                    />\r\n                                                    <div class=\"radio-tile2\">\r\n                                                        <div\r\n                                                            class=\"icon walk-icon\"\r\n                                                        >\r\n                                                            <i\r\n                                                                class=\"fa fa-print\"\r\n                                                            ></i>\r\n                                                        </div>\r\n                                                        <label\r\n                                                            for=\"cash\"\r\n                                                            class=\"radio-tile-label2\"\r\n                                                            >Imprimir</label\r\n                                                        >\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"input-container2 border rounded-sm col-lg-3\"\r\n                                                >\r\n                                                    <input\r\n                                                        id=\"noimprimir\"\r\n                                                        v-model=\"printerOn\"\r\n                                                        class=\"radio-button2\"\r\n                                                        type=\"radio\"\r\n                                                        name=\"noimprimir\"\r\n                                                        value=\"0\"\r\n                                                    />\r\n                                                    <div class=\"radio-tile2\">\r\n                                                        <div\r\n                                                            class=\"icon bike-icon\"\r\n                                                        >\r\n                                                            <i\r\n                                                                class=\"fa fa-print\"\r\n                                                            ></i>\r\n                                                        </div>\r\n                                                        <label\r\n                                                            for=\"Tarjeta\"\r\n                                                            class=\"radio-tile-label2\"\r\n                                                            >No Imprimir</label\r\n                                                        >\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"row\">\r\n                                            <div\r\n                                                class=\"col-lg-8  d-flex flex-row align-items-end\"\r\n                                            ></div>\r\n                                            <div\r\n                                                class=\"d-flex flex-column\"\r\n                                            ></div>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"row d-flex justify-content-start\"\r\n                                        >\r\n                                            <table\r\n                                                class=\"table\"\r\n                                                v-if=\"\r\n                                                    currentPayments.length != 0\r\n                                                \"\r\n                                            >\r\n                                                <thead>\r\n                                                    <tr>\r\n                                                        <th\r\n                                                            colspan=\"4\"\r\n                                                            class=\"text-left\"\r\n                                                        >\r\n                                                            {{\r\n                                                                form.payment_condition_id !==\r\n                                                                \"01\"\r\n                                                                    ? \"Cuotas\"\r\n                                                                    : \"Pagos\"\r\n                                                            }}\r\n                                                        </th>\r\n                                                    </tr>\r\n                                                </thead>\r\n                                                <tbody>\r\n                                                    <tr\r\n                                                        v-for=\"(paymnt,\r\n                                                        idx) in currentPayments\"\r\n                                                        :key=\"idx\"\r\n                                                    >\r\n                                                        <td>{{ idx + 1 }}</td>\r\n                                                        <td\r\n                                                            v-if=\"\r\n                                                                form.payment_condition_id !==\r\n                                                                    '01'\r\n                                                            \"\r\n                                                        >\r\n                                                            <el-date-picker\r\n                                                                v-model=\"\r\n                                                                    paymnt.date\r\n                                                                \"\r\n                                                            >\r\n                                                            </el-date-picker>\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            {{ paymnt.method }}\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            <strong>{{\r\n                                                                paymnt.amount\r\n                                                            }}</strong>\r\n                                                        </td>\r\n                                                        <td>\r\n                                                            <label\r\n                                                                for=\"\"\r\n                                                                role=\"button\"\r\n                                                                @click=\"\r\n                                                                    removePayment(\r\n                                                                        paymnt.id\r\n                                                                    )\r\n                                                                \"\r\n                                                                class=\"text-danger\"\r\n                                                            >\r\n                                                                <i\r\n                                                                    class=\"fa fa-trash\"\r\n                                                                ></i\r\n                                                            ></label>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-lg-12\">\r\n                            <div class=\"mb-2\">\r\n                                <div class=\" card  bg-light \">\r\n                                    <div class=\"row\">\r\n                                        <div\r\n                                            class=\" col-xl-4\"\r\n                                            style=\"margin-top: 10px;padding-top: 5px;\"\r\n                                            :class=\"{\r\n                                                'has-danger':\r\n                                                    form.difference < 0\r\n                                            }\"\r\n                                        >\r\n                                            <label class=\"control-label h1\"\r\n                                                >Total a cobrar: </label\r\n                                            ><br />\r\n                                            <span\r\n                                                class=\"control-label font-weight-semibold text-center h3\"\r\n                                            >\r\n                                                S/ {{ \" \" + form.total }}\r\n                                            </span>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"col-xl-8\"\r\n                                            v-if=\"\r\n                                                form_payment.payment_method_type_id ==\r\n                                                    '01'\r\n                                            \"\r\n                                        >\r\n                                            <div\r\n                                                class=\"btn-group btn-group-square m-0 flex-wrap justify-content-around\"\r\n                                                role=\"group\"\r\n                                                style=\"padding-top: 12px\"\r\n                                            >\r\n                                                <label class=\"control-label\"\r\n                                                    >Ingrese monto</label\r\n                                                >\r\n                                                <div\r\n                                                    class=\"d-flex flex-wrap justify-content-around\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"col-3 col-lg-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary  m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    10\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            10\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-3 col-lg-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary  m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    20\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            20\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-3  col-lg-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary  m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    50\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            50\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-3 col-lg-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary  m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    100\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            100\r\n                                                        </button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-3 col-lg-2 col-md-2  col-xl-2\"\r\n                                                    >\r\n                                                        <button\r\n                                                            class=\"btn btn-outline-primary m-2\"\r\n                                                            @click=\"\r\n                                                                setAmountCash(\r\n                                                                    200\r\n                                                                )\r\n                                                            \"\r\n                                                        >\r\n                                                            200\r\n                                                        </button>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div\r\n                                                    class=\"row col-xl-12 col-12\"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\" col-xl-6 col-md-3 col-lg-3 col-12\"\r\n                                                    >\r\n                                                        <el-input\r\n                                                            id=\"inputTotal\"\r\n                                                            ref=\"enter_amount\"\r\n                                                            v-model=\"\r\n                                                                form.enter_amount\r\n                                                            \"\r\n                                                            @blur=\"diferen()\"\r\n                                                            @input=\"\r\n                                                                enterAmount()\r\n                                                            \"\r\n                                                        >\r\n                                                            <template\r\n                                                                slot=\"prepend\"\r\n                                                                >{{\r\n                                                                    currencyTypeActive.symbol\r\n                                                                }}</template\r\n                                                            >\r\n                                                        </el-input>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        class=\"col-xl-2 col-md-2 col-lg-2 col-6\"\r\n                                                    >\r\n                                                        <el-button\r\n                                                            type=\"primary\"\r\n                                                            @click=\"addPayment\"\r\n                                                            :disabled=\"\r\n                                                                disabledAddPayment()\r\n                                                            \"\r\n                                                        >\r\n                                                            <span\r\n                                                                v-if=\"\r\n                                                                    form.payment_condition_id ==\r\n                                                                        '01'\r\n                                                                \"\r\n                                                            >\r\n                                                                Agregar\r\n                                                            </span>\r\n                                                            <span v-else>\r\n                                                                Agregar cuota\r\n                                                            </span>\r\n                                                        </el-button>\r\n                                                    </div>\r\n                                                    <div\r\n                                                        v-if=\"\r\n                                                            form.payment_condition_id ==\r\n                                                                '01'\r\n                                                        \"\r\n                                                        class=\"col-xl-3 col-md-3 col-lg-3 col-6 \"\r\n                                                    >\r\n                                                        <el-button\r\n                                                            type=\"success\"\r\n                                                            @click=\"\r\n                                                                showSplitPayment = true\r\n                                                            \"\r\n                                                            >Dividir\r\n                                                            pago</el-button\r\n                                                        >\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\" row col-xl-4\">\r\n                                            <div\r\n                                                class=\"col-xl-5\"\r\n                                                style=\"margin-bottom: 10px\"\r\n                                            ></div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"col-xl-3\"></div>\r\n                                        <div class=\"col-xl-2\"></div>\r\n                                        <div class=\"col-xl-3\">\r\n                                            <el-select\r\n                                                v-if=\"\r\n                                                    form.document_type_id ==\r\n                                                        '01' ||\r\n                                                        form.document_type_id ==\r\n                                                            '03'\r\n                                                \"\r\n                                                v-model=\"\r\n                                                    form.payment_condition_id\r\n                                                \"\r\n                                            >\r\n                                                <el-option\r\n                                                    value=\"01\"\r\n                                                    label=\"Contado\"\r\n                                                >\r\n                                                </el-option>\r\n                                                <el-option\r\n                                                    value=\"02\"\r\n                                                    label=\"Crédito\"\r\n                                                >\r\n                                                </el-option>\r\n                                                <el-option\r\n                                                    value=\"03\"\r\n                                                    label=\"Crédito a cuotas\"\r\n                                                ></el-option>\r\n                                            </el-select>\r\n                                            <!-- <el-switch\r\n                                                v-if=\"\r\n                                                    form.document_type_id ==\r\n                                                        '01' ||\r\n                                                        form.document_type_id ==\r\n                                                            '03'\r\n                                                \"\r\n                                                active-text=\"Crédito\"\r\n                                                inactive-text=\"Contado\"\r\n                                                v-model=\"form.is_credit\"\r\n                                            ></el-switch> -->\r\n                                        </div>\r\n                                        <div class=\"col-xl-4\">\r\n                                            <div\r\n                                                class=\"form-group d-flex flex-row align-items-end\"\r\n                                                :class=\"{\r\n                                                    'has-danger':\r\n                                                        form.difference < 0\r\n                                                }\"\r\n                                            >\r\n                                                <label\r\n                                                    :class=\"\r\n                                                        `${\r\n                                                            form.difference < 0\r\n                                                                ? 'text-danger'\r\n                                                                : ''\r\n                                                        }`\r\n                                                    \"\r\n                                                    class=\"control-label fs-4\"\r\n                                                    v-text=\"\r\n                                                        form.difference < 0\r\n                                                            ? 'Faltante: '\r\n                                                            : 'Vuelto: '\r\n                                                    \"\r\n                                                ></label>\r\n                                                <span\r\n                                                    :class=\"\r\n                                                        `${\r\n                                                            form.difference < 0\r\n                                                                ? 'text-danger'\r\n                                                                : ''\r\n                                                        }`\r\n                                                    \"\r\n                                                    class=\"control-label font-weight-semibold text-center fs-4\"\r\n                                                >\r\n                                                    {{\r\n                                                        currencyTypeActive.symbol\r\n                                                    }}{{\r\n                                                        form.difference\r\n                                                            .toFixed(2)\r\n                                                            .replace(\"-\", \"\")\r\n                                                    }}</span\r\n                                                >\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div\r\n                                        v-if=\"hasExceedBank\"\r\n                                        class=\"d-flex justify-content-center\"\r\n                                    >\r\n                                        <div class=\"col-12 text-center\">\r\n                                            <span class=\"text-danger\">\r\n                                                Recuerde que debido al monto\r\n                                                deberá hacer esta operación\r\n                                                mediante Bancarización, y en el\r\n                                                campo <br />\r\n                                                \"Observaciones\" ingresar el\r\n                                                numero de voucher o numero de\r\n                                                operación.\r\n                                            </span>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div\r\n                    v-if=\"splitPayments.length != 0\"\r\n                    class=\"row m-1 p-2  bg-light rounded\"\r\n                >\r\n                    <span style=\"margin-bottom:5px;\">Pagos divididos</span>\r\n                    <div class=\"d-flex flex-wrap \">\r\n                        <div\r\n                            v-for=\"(payment, idx) in splitPayments\"\r\n                            :key=\"idx\"\r\n                            class=\"col-2\"\r\n                        >\r\n                            Pago {{ idx + 1 }}:\r\n                            <strong>S/. {{ payment.amount }}</strong>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div\r\n                    v-if=\"splitProducts.length != 0\"\r\n                    class=\"row m-1 p-2  bg-light rounded\"\r\n                >\r\n                    <span style=\"margin-bottom:5px;\"\r\n                        >Pagos divididos por producto</span\r\n                    >\r\n                    <div class=\"d-flex flex-wrap \">\r\n                        <div\r\n                            v-for=\"(payment, idx) in splitProducts\"\r\n                            :key=\"idx\"\r\n                            class=\"col-3 m-1\"\r\n                        >\r\n                            <table\r\n                                v-if=\"\r\n                                    payment.products &&\r\n                                        payment.products.length > 0\r\n                                \"\r\n                                class=\"col-12\"\r\n                            >\r\n                                <thead>\r\n                                    <tr\r\n                                        role=\"button\"\r\n                                        @click=\"selectAccount(idx)\"\r\n                                        :class=\"\r\n                                            'bg-primary text-white border rounded-top'\r\n                                        \"\r\n                                    >\r\n                                        <th class=\"text-center\" colspan=\"3\">\r\n                                            <b> CUENTA {{ idx + 1 }} </b>\r\n                                        </th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody\r\n                                    class=\"border rounded-top \"\r\n                                    v-if=\"\r\n                                        payment.products &&\r\n                                            payment.products.length > 0\r\n                                    \"\r\n                                >\r\n                                    <tr\r\n                                        v-for=\"(product,\r\n                                        idx) in payment.products\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{ product.quantity }}\r\n                                            </h3>\r\n                                        </td>\r\n                                        <td>\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{ product.description }}\r\n                                            </h3>\r\n                                        </td>\r\n                                        <td style=\"text-align:right\">\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                {{\r\n                                                    product.price *\r\n                                                        product.quantity\r\n                                                }}\r\n                                            </h3>\r\n                                        </td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td\r\n                                            colspan=\"2\"\r\n                                            class=\"text-muted text-small\"\r\n                                            style=\"text-align:right\"\r\n                                        >\r\n                                            <b> Total</b>\r\n                                        </td>\r\n                                        <td class=\"text-muted text-small\">\r\n                                            S/.\r\n                                            {{\r\n                                                totalItemSelected(\r\n                                                    payment.products\r\n                                                )\r\n                                            }}\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                                <tbody v-else class=\"border\">\r\n                                    <tr>\r\n                                        <td colspan=\"3\" class=\"text-center\">\r\n                                            <h3 class=\"text-muted text-small\">\r\n                                                Sin productos seleccionados\r\n                                            </h3>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"p-3\">\r\n                    <div class=\"row\">\r\n                        <template v-if=\"configuration.affectation_optional\">\r\n                            <div class=\"col-lg-6 col-md-6 col-12\">\r\n                                <label>\r\n                                    Afectación IGV para el documento\r\n                                </label>\r\n                                <el-select\r\n                                    v-model=\"affectation_optional_id\"\r\n                                    clearable\r\n                                    filterable\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in affectation_igv_types.filter(\r\n                                            affectation =>\r\n                                                affectation.id == '10'\r\n                                        )\"\r\n                                        :key=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                        :value=\"option.id\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </div>\r\n                        </template>\r\n                        <div\r\n                            class=\"col-lg-4 col-md-4 col-12 d-flex align-items-end justify-content-center\"\r\n                        >\r\n                            <div>\r\n                                <button\r\n                                    class=\"btn btn-block btn-primary\"\r\n                                    @click=\"sendPayment\"\r\n                                    :disabled=\"button_payment\"\r\n                                >\r\n                                    <i class=\"fas fa-money-bill-alt\"></i>\r\n                                    PAGAR\r\n                                </button>\r\n                            </div>\r\n                            <div>\r\n                                <button\r\n                                    class=\"btn btn-block btn-dark\"\r\n                                    @click=\"back(false)\"\r\n                                >\r\n                                    <i class=\"fa fa-reply\"></i> Cerrar\r\n                                </button>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n            <multiple-payment-form\r\n                :showDialog.sync=\"showDialogMultiplePayment\"\r\n                :payments=\"payments\"\r\n                @add=\"addRow\"\r\n            ></multiple-payment-form>\r\n\r\n            <!-- <sale-notes-options :showDialog.sync=\"showDialogSaleNote\"\r\n                          :recordId=\"saleNotesNewId\"\r\n                          :showClose=\"true\"></sale-notes-options>  -->\r\n\r\n            <card-brands-form\r\n                :showDialog.sync=\"showDialogNewCardBrand\"\r\n                :external=\"true\"\r\n                :recordId=\"null\"\r\n            ></card-brands-form>\r\n            <person-form\r\n                :showDialog.sync=\"showDialogNewPerson\"\r\n                type=\"customers\"\r\n                :input_person=\"input_person\"\r\n                :external=\"true\"\r\n                :user_id.sync=\"form.user_id\"\r\n                :document_type_id=\"form.document_type_id\"\r\n                @add_customer=\"add_customer\"\r\n                :recordId=\"form.customer_id\"\r\n            >\r\n            </person-form>\r\n            <show-split-payment-form\r\n                :orden_items=\"orden_items\"\r\n                @receivePayments=\"receivePayments\"\r\n                @receiveProducts=\"receiveProducts\"\r\n                :total=\"form.total\"\r\n                :showSplitPayment.sync=\"showSplitPayment\"\r\n            >\r\n            </show-split-payment-form>\r\n            <person-college-form\r\n                :showDialog.sync=\"showCollegePersonDialog\"\r\n                :extern=\"true\"\r\n                :fromPerson=\"true\"\r\n                :recordId=\"collegePersonId\"\r\n            >\r\n            </person-college-form>\r\n        </div>\r\n\r\n        <list-items :showDialog.sync=\"showListItems\" :form=\"form\"> </list-items>\r\n    </el-dialog>\r\n</template>\r\n\r\n<style>\r\n.algunaClase .el-dialog .el-dialog__header .el-dialog__title {\r\n    font-size: 35px !important;\r\n}\r\n.el-scrollbar {\r\n    z-index: 2000 !important;\r\n}\r\n.c-width {\r\n    width: 80px !important;\r\n    padding: 0 !important;\r\n    margin-right: 0 !important;\r\n}\r\n.control-label,\r\nh4,\r\nh5,\r\nlabel {\r\n    color: #000;\r\n}\r\n/* .el-dialog__header {\r\n    padding: 0px;\r\n}\r\n.el-dialog__body {\r\n    padding: 0px !important;\r\n} */\r\n</style>\r\n\r\n<script>\r\n// import * as shajs from 'sha.js';\r\nimport _ from \"lodash\";\r\nimport printjs from \"print-js\";\r\n//import CardBrandsForm from \"../../../../../../../../resources/js/views/card_brands/form.vue\";\r\n// import SaleNotesOptions from '../../sale_notes/partials/options.vue'\r\n//import OptionsForm from './options.vue'\r\n//import MultiplePaymentForm from \"./multiple_payment.vue\";\r\n//import PersonForm from \"../../../../../../../../resources/js/views/persons/form.vue\";\r\n//import ShowSplitPaymentForm from \"./split_payment.vue\";\r\nconst ListItems = () => import(\"./list_items.vue\");\r\nconst CardBrandsForm = () =>\r\n    import(\"../../../../../../../../resources/js/views/card_brands/form.vue\");\r\nconst MultiplePaymentForm = () => import(\"./multiple_payment.vue\");\r\nconst PersonForm = () =>\r\n    import(\"../../../../../../../../resources/js/views/persons/form.vue\");\r\nconst ShowSplitPaymentForm = () => import(\"./split_payment.vue\");\r\nconst PersonCollegeForm = () =>\r\n    import(\r\n        \"../../../../../../../College/Resources/assets/js/views/persons/form.vue\"\r\n    );\r\nexport default {\r\n    components: {\r\n        ListItems,\r\n        PersonCollegeForm,\r\n        CardBrandsForm,\r\n        MultiplePaymentForm,\r\n        PersonForm,\r\n        ShowSplitPaymentForm\r\n    },\r\n\r\n    props: [\r\n        \"clientSaleNoteNumber\",\r\n        \"clientSaleNoteDiscount\",\r\n        \"ordens_all_table\",\r\n        \"consignment_id\",\r\n        \"isConsignment\",\r\n        \"affectation_igv_types\",\r\n        \"printer\",\r\n        \"printing\",\r\n        \"customer_default\",\r\n        \"customer_variation\",\r\n        \"variation\",\r\n        \"establishments\",\r\n        \"formVariation\",\r\n        \"documentsType\",\r\n        \"orden_items\",\r\n        \"cash_id\",\r\n        \"form\",\r\n        \"exchangeRateSale\",\r\n        \"is_payment\",\r\n        \"soapCompany\",\r\n        \"direct_printing\",\r\n        \"auth_login\",\r\n        \"payments\",\r\n        \"configuration\",\r\n        \"idOrden\",\r\n        \"company\",\r\n        \"desarrollador\",\r\n        \"percentage_igv\",\r\n        \"all_series\",\r\n        \"all_customers\",\r\n        \"personalWhatsapp\",\r\n        \"sellers\"\r\n    ],\r\n    watch: {\r\n        all_customers(newCustomer, _) {\r\n            this.customers = newCustomer.filter(n => n.number != \"88888888\");\r\n        },\r\n        method_payments(newMethod, _) {\r\n            this.checkTotal(newMethod);\r\n        }\r\n    },\r\n    data() {\r\n        return {\r\n            showListItems: false,\r\n            discountTotal: false,\r\n            paymentCondition: \"01\",\r\n            payment_condition: [\r\n                {\r\n                    id: \"01\",\r\n                    description: \"Contado\"\r\n                },\r\n                {\r\n                    id: \"02\",\r\n                    description: \"Crédito\"\r\n                }\r\n            ],\r\n            affectation_optional_id: null,\r\n            hasCreditCardCharge: false,\r\n            chargeCredit: {\r\n                credit_type: \"1\",\r\n                total_charge: 0,\r\n                amount: 5\r\n            },\r\n            collegePersonId: null,\r\n            conf: {},\r\n            started: true,\r\n            refCustomer: null,\r\n            currentDocumentsType: [],\r\n            time: null,\r\n            splitPayments: [],\r\n            splitProducts: [],\r\n            showCollegePersonDialog: false,\r\n            isInterno: false,\r\n            showSplitPayment: false,\r\n            currencyTypeActive: {\r\n                symbol: \"S/ \"\r\n            },\r\n            currentPayments: [],\r\n            input_person: {},\r\n            customer: null,\r\n            value: null,\r\n            paymentsValue: {\r\n                \"01\": \"Efectivo\",\r\n                \"02\": \"Culqui\",\r\n                \"03\": \"Yape\",\r\n                \"04\": \"PLIN\",\r\n                \"05\": \"TARJETA: IZYPAY\",\r\n                \"06\": \"TARJETA: NIUBIZ\",\r\n                \"07\": \"TARJETA: OPENPAY\"\r\n            },\r\n            last_number: {},\r\n            showDialogNewPerson: false,\r\n            loading: false,\r\n            enabled_discount: true,\r\n            discount_amount: 0,\r\n            loading_submit: false,\r\n            showDialogOptions: false,\r\n            showDialogMultiplePayment: false,\r\n            showDialogSaleNote: false,\r\n            showDialogNewCardBrand: false,\r\n            documentNewId: null,\r\n            saleNotesNewId: null,\r\n            resource_options: null,\r\n            has_card: false,\r\n            method_payments: \"01\",\r\n            number: null,\r\n            resource: \"pos\",\r\n            resource_documents: \"documents\",\r\n            resource_payments: \"document_payments\",\r\n            amount: 0,\r\n            printerOn: 0,\r\n            button_payment: false,\r\n            input_item: \"\",\r\n            form_payment: {\r\n                is_bank: false\r\n            },\r\n            series: [],\r\n            cards_brand: [],\r\n            cancel: false,\r\n            form_cash_document: {},\r\n            statusDocument: {},\r\n            payment_method_types: [],\r\n            invoice: true,\r\n            receipt: true,\r\n            sale_note: true,\r\n            last_date: null,\r\n            customers: [],\r\n            datEmision: {\r\n                disabledDate(time) {\r\n                    return time.getTime() > moment();\r\n                }\r\n            },\r\n            activeColo: \"black\",\r\n            students: [],\r\n            bank: null,\r\n            hasExceedBank: false,\r\n            bank_accounts: []\r\n            // percentage_igv: 18\r\n        };\r\n    },\r\n\r\n    async created() {\r\n        this.conf = this.establishments.conf ?? {};\r\n        this.button_payment = true;\r\n        this.currentDocumentsType = this.documentsType;\r\n        this.form.identity_document_type_id = this.currentDocumentsType[0].id;\r\n        this.form.customer_id = this.establishments.customer_id;\r\n        this.value = this.establishments.customer_id;\r\n        this.isInterno = this.company.soap_type_id == \"03\";\r\n\r\n        // await this.getTables();\r\n        await this.date_of_issue();\r\n        if (!this.conf.pos_quick_sale) {\r\n            await this.getLastNumbersDocument();\r\n        }\r\n        await this.initFormPayment();\r\n        await this.setInitialAmount();\r\n        this.$eventHub.$on(\"reloadDataCardBrands\", card_brand_id => {\r\n            this.reloadDataCardBrands(card_brand_id);\r\n        });\r\n        await this.$eventHub.$on(\"reloadDataPersons\", customer_id => {\r\n            this.reloadDataCustomers(customer_id);\r\n        });\r\n\r\n        await this.getFormPosLocalStorage();\r\n\r\n        if (this.conf.pos_quick_sale) {\r\n            qz.security.setCertificatePromise((resolve, reject) => {\r\n                this.$http\r\n                    .get(\"/api/qz/crt/override\", {\r\n                        responseType: \"text\"\r\n                    })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            });\r\n\r\n            qz.security.setSignaturePromise(toSign => {\r\n                return (resolve, reject) => {\r\n                    this.$http\r\n                        .post(\"/api/qz/signing\", { request: toSign })\r\n                        .then(response => {\r\n                            resolve(response.data);\r\n                        })\r\n                        .catch(error => {\r\n                            reject(error.data);\r\n                        });\r\n                };\r\n            });\r\n        }\r\n\r\n        this.setAmountCash(this.form.total);\r\n\r\n        this.filterSeries();\r\n\r\n        this.button_payment = false;\r\n        let { conf } = this.establishments;\r\n        if ((conf && conf.pos_quick_sale) || this.ordens_all_table) {\r\n            this.sendPayment(null, this.form);\r\n        }\r\n        this.getBankAccounts();\r\n    },\r\n    mounted() {},\r\n    methods: {\r\n        changeBankAccount() {\r\n            if (this.form_payment.is_bank) {\r\n                let bank_account = this.bank_accounts.find(\r\n                    b => b.id == this.form.bank_account_id\r\n                );\r\n\r\n                this.form.boxes = [\r\n                    {\r\n                        id: null,\r\n                        bank_account_id: bank_account.id,\r\n                        number_operation: this.form.reference_number,\r\n                        amount: this.form.total,\r\n                        method: `${bank_account.description}-${bank_account.number}`,\r\n                    }\r\n                ];\r\n            } else {\r\n                this.form.boxes = [];\r\n            }\r\n        },\r\n        async getBankAccounts() {\r\n            const response = await this.$http.get(`/bank_accounts/records`);\r\n            if (response.status == 200) {\r\n                this.bank_accounts = response.data.data;\r\n                if(this.bank_accounts.length > 0){\r\n                    this.form.bank_account_id = this.bank_accounts[0].id;\r\n                }\r\n            }\r\n        },\r\n        checkLimitReceipt() {\r\n            let { customer_id, document_type_id, total } = this.form;\r\n            if (total > 699 && document_type_id == \"03\") {\r\n                let customer = this.customers.find(c => c.id == customer_id);\r\n                if (customer) {\r\n                    if (\r\n                        customer.number == \"99999999\" ||\r\n                        (customer.identity_document_type_id != \"6\" &&\r\n                            customer.identity_document_type_id != \"1\")\r\n                    ) {\r\n                        return true;\r\n                    }\r\n                }\r\n            }\r\n            return false;\r\n        },\r\n\r\n        isClientesVarios() {\r\n            let id = this.value;\r\n            if (id != null) {\r\n                let customer = this.customers.find(c => c.id == id);\r\n                if (customer && customer.number == \"99999999\") {\r\n                    return true;\r\n                }\r\n            }\r\n\r\n            return false;\r\n        },\r\n        checkTotal(newMethod) {\r\n            //xd\r\n            if (newMethod == \"01\") {\r\n                let { total } = this.form;\r\n                if (total > 2000) {\r\n                    this.bank =\r\n                        \"Bancarización: Ingresar voucher de pago o nro de operación\";\r\n                    this.hasExceedBank = true;\r\n                }\r\n            } else {\r\n                this.bank = null;\r\n                this.hasExceedBank = false;\r\n            }\r\n        },\r\n        formatItems(items = [], affectation = null) {\r\n            items = items.map(i => {\r\n                let affectation_igv_type_id =\r\n                    affectation != null && affectation != undefined\r\n                        ? affectation\r\n                        : i.sale_affectation_igv_type_id;\r\n                return {\r\n                    ...i,\r\n                    warehouse_id: null,\r\n                    item: i,\r\n                    item_id: i.id,\r\n                    unit_value:\r\n                        affectation_igv_type_id == 10\r\n                            ? i.sale_unit_price /\r\n                              (1 + this.percentage_igv / 100)\r\n                            : i.sale_unit_price,\r\n                    quantity: i.quantity,\r\n                    aux_quantity: i.quantity,\r\n                    total_base_igv:\r\n                        affectation_igv_type_id == 10\r\n                            ? (i.sale_unit_price * i.quantity) /\r\n                              (1 + this.percentage_igv / 100)\r\n                            : i.sale_unit_price * i.quantity,\r\n                    percentage_igv: this.percentage_igv,\r\n                    total_igv:\r\n                        affectation_igv_type_id == 10\r\n                            ? ((i.sale_unit_price * i.quantity) /\r\n                                  (1 + this.percentage_igv / 100)) *\r\n                              (this.percentage_igv / 100)\r\n                            : 0,\r\n                    total_base_isc: 0.0,\r\n                    percentage_isc: 0.0,\r\n                    total_isc: 0.0,\r\n                    total_base_other_taxes: 0.0,\r\n                    percentage_other_taxes: 0.0,\r\n                    total_other_taxes: 0.0,\r\n                    total_taxes:\r\n                        affectation_igv_type_id == 10\r\n                            ? ((i.sale_unit_price * i.quantity) /\r\n                                  (1 + this.percentage_igv / 100)) *\r\n                              (this.percentage_igv / 100)\r\n                            : 0,\r\n                    total_value:\r\n                        affectation_igv_type_id == 10\r\n                            ? (i.sale_unit_price * i.quantity) /\r\n                              (1 + this.percentage_igv / 100)\r\n                            : i.quantity * i.sale_unit_price,\r\n                    total_charge: 0.0,\r\n                    total_discount: 0.0,\r\n                    total: i.sale_unit_price * i.quantity,\r\n                    price_type_id: \"01\",\r\n                    unit_price: i.sale_unit_price,\r\n                    unit_price_value: i.sale_unit_price,\r\n                    has_igv: i.has_igv,\r\n                    affectation_igv_type_id: affectation_igv_type_id,\r\n                    unit_price: i.sale_unit_price,\r\n                    presentation: null,\r\n                    charges: [],\r\n                    discounts: [],\r\n                    attributes: [],\r\n                    affectation_igv_type: affectation_igv_type_id\r\n                };\r\n            });\r\n            return items;\r\n        },\r\n        setItemsNewPrice(prices) {\r\n            let copyPrices = [...prices];\r\n            let items = [...this.form.items.map(m => m.item)];\r\n            for (let i = 0; i < items.length; i++) {\r\n                const item = items[i];\r\n                if (item.cOlPrice) {\r\n                    item.sale_unit_price = item.cOlPrice;\r\n                    item.cOlPrice = null;\r\n                    item.cNewPrice = null;\r\n                }\r\n                const quantity = item.quantity;\r\n                let sum = copyPrices.splice(0, 1).reduce((a, b) => a + b, 0);\r\n                let newPrice = sum / quantity;\r\n                item.cOlPrice = item.sale_unit_price;\r\n                item.cNewPrice = newPrice;\r\n                item.sale_unit_price = Number(item.sale_unit_price) + newPrice;\r\n            }\r\n            return items;\r\n        },\r\n        toFixedTwoNumber(number) {\r\n            return Number(number.toFixed(2));\r\n        },\r\n        divideCharge(parts) {\r\n            let { total_charge: amount } = this.chargeCredit;\r\n            let part = amount / parts;\r\n            let decimal = this.toFixedTwoNumber(part);\r\n            let array = Array(parts).fill(decimal);\r\n            let total = decimal * parts;\r\n            let difference = (amount - total).toFixed(2);\r\n            if (difference != 0) {\r\n                array[0] = this.toFixedTwoNumber(array[0] + Number(difference));\r\n            }\r\n            return array;\r\n        },\r\n        calculateCharge() {\r\n            let { amount, credit_type } = this.chargeCredit;\r\n            if (credit_type == \"1\") {\r\n                this.chargeCredit.total_charge =\r\n                    this.form.total * (amount / 100);\r\n            } else {\r\n                this.chargeCredit.total_charge = Number(amount);\r\n            }\r\n            this.chargeCredit.total_charge = Number(\r\n                this.chargeCredit.total_charge.toFixed(1)\r\n            );\r\n            if (this.form.total < this.chargeCredit.total_charge) {\r\n                this.chargeCredit.total_charge = 0;\r\n                this.chargeCredit.amount = 0;\r\n                this.$toast.error(\r\n                    \"El monto a adicionar no puede ser mayor al total\"\r\n                );\r\n                // this.reCalculateTotal();\r\n                // return;\r\n            }\r\n\r\n            let prices = this.divideCharge(this.form.items.length);\r\n            let items = this.setItemsNewPrice(prices);\r\n            items = this.formatItems(items);\r\n            this.form.items = items;\r\n            this.reCalculateTotal();\r\n            this.form.enter_amount = this.form.total;\r\n        },\r\n        openDialogPerson() {\r\n            if (this.configuration.college) {\r\n                if (\r\n                    this.customer_default &&\r\n                    this.customer_default.id == this.value\r\n                ) {\r\n                    this.showDialogNewPerson = true;\r\n                } else {\r\n                    this.collegePersonId = this.value;\r\n                    this.showCollegePersonDialog = true;\r\n                }\r\n            } else {\r\n                this.showDialogNewPerson = true;\r\n            }\r\n        },\r\n        changeStudent() {\r\n            this.$forceUpdate();\r\n        },\r\n        existNumber() {\r\n            let number = this.form.customer_telephone;\r\n            if (!number.startsWith(\"9\")) {\r\n                return false;\r\n            }\r\n            if (number.length != 9) {\r\n                return false;\r\n            }\r\n            if (isNaN(Number(number))) {\r\n                return false;\r\n            }\r\n            return true;\r\n        },\r\n        createClient() {\r\n            this.value = null;\r\n            this.form.document_type_id;\r\n            this.form.customer_id = null;\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        async reloadDataCustomers(customer_id) {\r\n            this.$http.get(`/pos/table/customers`).then(async response => {\r\n                await this.$emit(\"update:all_customers\", response.data);\r\n                this.value = customer_id;\r\n                this.form.customer_id = customer_id;\r\n                this.changeCustomer();\r\n            });\r\n        },\r\n        totalItemSelected(products) {\r\n            let total = 0;\r\n            products.forEach(p => {\r\n                total += p.quantity * p.price;\r\n            });\r\n\r\n            return _.round(total, 2);\r\n        },\r\n        receivePayments(payments) {\r\n            this.splitPayments = payments;\r\n        },\r\n        receiveProducts(payments) {\r\n            this.splitProducts = payments;\r\n        },\r\n        removePayment(id) {\r\n            this.currentPayments = this.currentPayments.filter(c => c.id != id);\r\n            this.enterAmount();\r\n        },\r\n        checkPaymentTotal() {\r\n            let total = this.currentPayments.reduce(\r\n                (a, b) => a + Number(b.amount),\r\n                0\r\n            );\r\n            return total != this.form.total\r\n                ? Number(this.form.total) - total\r\n                : 0.0;\r\n        },\r\n        disabledAddPayment() {\r\n            if (this.form.payment_condition_id == \"03\") {\r\n                return this.checkPaymentTotal() == 0.0;\r\n            }\r\n            if (this.form.payment_condition_id == \"02\") {\r\n                return this.currentPayments.length > 0;\r\n            }\r\n            return false;\r\n        },\r\n        addPayment() {\r\n            let id = this.currentPayments.length + 1;\r\n            let method = this.paymentsValue[this.method_payments];\r\n            if (this.form.total + 200 <= this.form.enter_amount) {\r\n                this.$toast.error(\r\n                    \"el monto a agregar no puede ser 200 soles mayor al pago total \"\r\n                );\r\n                return;\r\n            }\r\n            if (\r\n                this.form.enter_amount != \"\" &&\r\n                !isNaN(this.form.enter_amount) &&\r\n                this.form.enter_amount != undefined\r\n            ) {\r\n                if (this.form.payment_condition_id != \"01\") {\r\n                    let total = this.currentPayments.reduce(\r\n                        (a, b) => a + Number(b.amount),\r\n                        0\r\n                    );\r\n                    if (\r\n                        this.form.total <\r\n                        total + Number(this.form.enter_amount)\r\n                    ) {\r\n                        this.$toast.error(\r\n                            \"El monto a agregar no puede ser mayor al pago total \"\r\n                        );\r\n                        return;\r\n                    }\r\n                }\r\n\r\n                let days = this.currentPayments.length + 1;\r\n\r\n                let date = moment()\r\n                    .add(5, \"hours\")\r\n                    .add(days, \"days\");\r\n                this.currentPayments.push({\r\n                    id,\r\n                    method_payment_id: this.method_payments,\r\n                    method,\r\n                    date,\r\n                    amount: this.form.enter_amount\r\n                });\r\n                if (this.form.payment_condition_id == \"03\") {\r\n                    this.form.enter_amount = this.checkPaymentTotal();\r\n                    this.enterAmount();\r\n                } else {\r\n                    this.form.enter_amount = 0.0;\r\n                }\r\n            }\r\n        },\r\n        customerForm(isNew) {\r\n            if (isNew) {\r\n                this.form.customer_id = undefined;\r\n            } else {\r\n                this.form.customer_id = this.value;\r\n            }\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        add_customer(value) {},\r\n        reloadDataPersons() {},\r\n        async keyupCustomer(e) {\r\n            //buscar\r\n            if (this.time) {\r\n                clearTimeout(this.time);\r\n            }\r\n            this.time = setTimeout(async () => {\r\n                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(\r\n                    \"input\"\r\n                )[0].value;\r\n                const response = await this.$http(\r\n                    `/caja/search_customers?value=${this.input_person.number}`\r\n                );\r\n                const { persons } = response.data;\r\n\r\n                this.customers = persons.filter(n => n.number != \"88888888\");\r\n                this.updateAllCustomers(this.customers);\r\n            }, 500);\r\n        },\r\n        async updateAllCustomers(personsFromServer) {\r\n            let ids = this.all_customers.map(c => c.id);\r\n            let persons = [];\r\n\r\n            for (let person of personsFromServer) {\r\n                let existInList = ids.find(p => p == person.id);\r\n                if (existInList == undefined) {\r\n                    persons.push(person);\r\n                }\r\n            }\r\n            let newData = [];\r\n            if (this.clientSaleNoteNumber) {\r\n                newData = personsFromServer;\r\n            } else {\r\n                newData = [...this.all_customers, ...persons];\r\n            }\r\n\r\n            if (persons.length != 0) {\r\n                await this.$emit(\"update:all_customers\", newData);\r\n                if (newData.length == 1) {\r\n                    this.value = newData[0].id;\r\n                    this.form.customer_id = newData[0].id;\r\n                    this.changeCustomer();\r\n                }\r\n            }\r\n        },\r\n        changeCustomer() {\r\n            this.form.student_id = null;\r\n            this.students = [];\r\n            this.form.customer_id = this.value;\r\n            let customer = _.find(this.customers, {\r\n                id: this.form.customer_id\r\n            });\r\n\r\n            if (customer != null) {\r\n                this.students = customer.students || [];\r\n                this.customer = customer;\r\n                if (this.form.document_type_id == \"01\") {\r\n                    if (\r\n                        customer.identity_document_type_id == \"1\" ||\r\n                        customer.identity_document_type_id == \"4\" ||\r\n                        customer.identity_document_type_id == \"-\"\r\n                    ) {\r\n                        this.form.document_type_id = \"03\";\r\n                    }\r\n                    //  else {\r\n                    //     this.form.document_type_id = \"01\";\r\n                    // }\r\n                }\r\n\r\n                this.form.customer_telephone = customer.phone;\r\n                this.setLocalStorageIndex(\"customer\", this.customer);\r\n                if (this.clientSaleNoteNumber) {\r\n                    this.form.document_type_id = \"03\";\r\n                }\r\n            }\r\n            this.setSeries();\r\n        },\r\n        setLocalStorageIndex(key, obj) {\r\n            localStorage.setItem(key, JSON.stringify(obj));\r\n        },\r\n        async getLastNumbersDocument() {\r\n            const response = await this.$http.post(\r\n                `${this.resource}/last_number_documents`,\r\n                { series: this.all_series, ordenId: this.idOrden }\r\n            );\r\n            if (response.status == 200) {\r\n                this.last_number = response.data.result;\r\n                this.refCustomer = response.data.customer;\r\n                if (this.refCustomer != null) {\r\n                    this.refCustomer.description = `${this.refCustomer.number} - ${this.refCustomer.name}`;\r\n                    this.customers = [\r\n                        this.refCustomer,\r\n                        ...this.customers.filter(\r\n                            f =>\r\n                                f.id != this.refCustomer.id &&\r\n                                f.number != \"88888888\"\r\n                        )\r\n                    ];\r\n\r\n                    this.value = this.refCustomer.id;\r\n                }\r\n            }\r\n        },\r\n        changeEnabledDiscount() {\r\n            if (!this.enabled_discount) {\r\n                this.discount_amount = 0;\r\n                this.deleteDiscountGlobal();\r\n                this.reCalculateTotal();\r\n            }\r\n        },\r\n        teclasInit() {\r\n            document.onkeydown = e => {\r\n                const key = e.key;\r\n\r\n                if (key == \"F4\") {\r\n                    //Agregar cliente\r\n                    // this.clickPayment();\r\n                }\r\n                if (key == \"F6\") {\r\n                    //Agregar Producto\r\n                    //this.clickAddItemInvoice()\r\n                    //return false;\r\n                }\r\n                if (key == \"F7\" && this.form.items.length > 0) {\r\n                    //Guardar\r\n                    // this.submit()\r\n                }\r\n                if (key == \"F8\") {\r\n                    //Cancelar\r\n                    // this.close()\r\n                }\r\n            };\r\n        },\r\n        async date_of_issue() {\r\n            // this.discount_amount = 0;\r\n            // this.form.customer_id\r\n            // this.form.student_id = null;\r\n            if (!this.configuration.restrict_receipt_date) {\r\n                this.form.date_of_issue = moment().format(\"YYYY-MM-DD\");\r\n            }\r\n            let { documents } = this.establishments;\r\n            if (documents) {\r\n                let { invoice, sale_note, receipt } = documents;\r\n                this.invoice = invoice;\r\n                this.sale_note = sale_note;\r\n                this.receipt = receipt;\r\n            }\r\n            this.customers = this.all_customers.filter(\r\n                n => n.number != \"88888888\"\r\n            );\r\n            this.customers = [\r\n                ...this.customers.filter(c => c.id != this.customer_default.id)\r\n            ];\r\n            if (this.form.document_type_id != \"01\") {\r\n                this.customers = [...this.customers, this.customer_default];\r\n            }\r\n\r\n            if (this.establishments.customer_id) {\r\n                let isRuc = this.checkCustomerDocument(\"6\");\r\n                if (isRuc && this.form.document_type_id != \"01\") {\r\n                    this.value = this.establishments.customer_id;\r\n                    this.form.customer_id = this.establishments.customer_id;\r\n                }\r\n            }\r\n\r\n            let form_efectivo = {\r\n                enter_amount: 0,\r\n                difference: 0\r\n            };\r\n            // const response_efectivo = await this.$http.post(\r\n            //     `/efectivo`,\r\n            //     form_efectivo\r\n            // );\r\n            if (this.clientSaleNoteNumber) {\r\n                setTimeout(() => {\r\n                    this.$refs.select_person.$el.getElementsByTagName(\r\n                        \"input\"\r\n                    )[0].value = this.clientSaleNoteNumber;\r\n                    this.keyupCustomer();\r\n                }, 800);\r\n                this.discount_amount = this.clientSaleNoteDiscount;\r\n                this.inputDiscountAmount();\r\n                this.discountTotal = true;\r\n                this.reCalculateTotal();\r\n            }\r\n            this.checkTotal(\"01\");\r\n        },\r\n        checkCustomerDocument(type) {\r\n            let { customer_id } = this.form;\r\n            let customer = this.customers.find(c => c.id == customer_id);\r\n            if (customer) {\r\n                return customer.identity_document_type_id == type;\r\n            }\r\n            return false;\r\n        },\r\n\r\n        async printerDocument(Printer, linkpdf) {\r\n            qz.security.setCertificatePromise((resolve, reject) => {\r\n                this.$http\r\n                    .get(\"/api/qz/crt/override\", {\r\n                        responseType: \"text\"\r\n                    })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            });\r\n            qz.security.setSignaturePromise(toSign => {\r\n                return (resolve, reject) => {\r\n                    this.$http\r\n                        .post(\"/api/qz/signing\", {\r\n                            request: toSign\r\n                        })\r\n                        .then(response => {\r\n                            resolve(response.data);\r\n                        })\r\n                        .catch(error => {\r\n                            reject(error.data);\r\n                        });\r\n                };\r\n            });\r\n            let config = qz.configs.create(Printer, {\r\n                scaleContent: false\r\n            });\r\n            if (!qz.websocket.isActive()) {\r\n                await qz.websocket.connect(config);\r\n            }\r\n            let data = [\r\n                {\r\n                    type: \"pdf\",\r\n                    format: \"file\",\r\n                    data: linkpdf\r\n                }\r\n            ];\r\n            qz.print(config, data).catch(e => {\r\n                this.$toast.error(e.message);\r\n            });\r\n            // if (this.printerOn == 1) {\r\n            //     if (multiple_boxes == true) {\r\n            //         if (this.auth_login == auth) {\r\n            //             let config = qz.configs.create(Printer, {\r\n            //                 scaleContent: false\r\n            //             });\r\n            //             if (!qz.websocket.isActive()) {\r\n            //                 await qz.websocket.connect(config);\r\n            //             }\r\n            //             let data = [\r\n            //                 {\r\n            //                     type: \"pdf\",\r\n            //                     format: \"file\",\r\n            //                     data: linkpdf\r\n            //                 }\r\n            //             ];\r\n            //             qz.print(config, data).catch(e => {\r\n            //                 this.$toast.error(e.message);\r\n            //             });\r\n            //             for (let index = 0; index < copies; index++) {\r\n            //                 qz.print(config, data).catch(e => {\r\n            //                     this.$toast.error(e.message);\r\n            //                 });\r\n            //             }\r\n            //         }\r\n            //     }\r\n            //     if (multiple_boxes == false) {\r\n            //         let config = qz.configs.create(Printer, {\r\n            //             scaleContent: false\r\n            //         });\r\n            //         if (!qz.websocket.isActive()) {\r\n            //             await qz.websocket.connect(config);\r\n            //         }\r\n            //         let data = [\r\n            //             {\r\n            //                 type: \"pdf\",\r\n            //                 format: \"file\",\r\n            //                 data: linkpdf\r\n            //             }\r\n            //         ];\r\n\r\n            //         qz.print(config, data).catch(e => {\r\n            //             this.$toast.error(e.message);\r\n            //         });\r\n            //         for (let index = 0; index < copies; index++) {\r\n            //             qz.print(config, data).catch(e => {\r\n            //                 this.$toast.error(e.message);\r\n            //             });\r\n            //         }\r\n            //     }\r\n            // }\r\n        },\r\n        async clickSendWhatsapp(\r\n            document_type_id,\r\n            document_id,\r\n            number,\r\n            form = {}\r\n        ) {\r\n            if (form.customer_telephone != null) {\r\n                let formWhatsapp = {\r\n                    id: this.recordId,\r\n                    document_id: document_id,\r\n                    document_type_id: document_type_id,\r\n                    customer_telephone: form.customer_telephone,\r\n                    sender: \"sdrimsac\",\r\n                    mensaje:\r\n                        \"Su comprobante de pago electrónico \" +\r\n                        number +\r\n                        \"por S/\" +\r\n                        this.form.total +\r\n                        \" de *\" +\r\n                        this.establishments.description +\r\n                        \"*, ha sido generado correctamente a través del facturador electrónico de \" +\r\n                        \"*\" +\r\n                        this.$desarrollador +\r\n                        \"*\"\r\n                };\r\n                try {\r\n                    this.loading = true;\r\n                    let response = await this.$http.post(\r\n                        `/whatsapp`,\r\n                        formWhatsapp\r\n                    );\r\n                    if (response.data.success == true) {\r\n                        this.$toast.success(response.data.message);\r\n                        this.loading = false;\r\n                    }\r\n\r\n                    if (\r\n                        this.configuration.xml_whatsapp &&\r\n                        document_type_id != \"80\"\r\n                    ) {\r\n                        formWhatsapp.xml = true;\r\n                        response = await this.$http.post(\r\n                            `/whatsapp`,\r\n                            formWhatsapp\r\n                        );\r\n                        if (response.data.success == true) {\r\n                            this.$toast.success(response.data.message);\r\n                            this.loading = false;\r\n                        }\r\n                    }\r\n                } catch (e) {\r\n                    console.log(e, \" error\");\r\n                } finally {\r\n                    this.loading = false;\r\n                }\r\n            }\r\n        },\r\n        changeDateOfIssue() {\r\n            let { days_before_emit } = this.configuration;\r\n            //si el document es una factura verificar que la fecha de emision no sea menor a la fecha actual menos days_before_emit sin tomar en cuenta la hora\r\n            if (this.form.document_type_id == \"01\") {\r\n                let date = moment();\r\n                if (\r\n                    moment(this.form.date_of_issue).isBefore(\r\n                        date\r\n                            .subtract(days_before_emit, \"days\")\r\n                            .format(\"YYYY-MM-DD\")\r\n                    )\r\n                ) {\r\n                    this.$toast.error(\r\n                        \"La fecha de emisión no puede ser menor a \" +\r\n                            days_before_emit +\r\n                            \" días\"\r\n                    );\r\n                    this.form.date_of_issue = moment().format(\"YYYY-MM-DD\");\r\n                }\r\n            }\r\n\r\n            //si el documento es una boleta solo permitir emitir si la fecha de emision tiene el mismo mes que la fecha actual\r\n            if (this.form.document_type_id == \"03\") {\r\n                let date = moment();\r\n                if (moment(this.form.date_of_issue).month() != date.month()) {\r\n                    this.$toast.error(\r\n                        \"La fecha de emisión debe ser del mismo mes\"\r\n                    );\r\n                    this.form.date_of_issue = moment().format(\"YYYY-MM-DD\");\r\n                }\r\n            }\r\n            // if(this.configuration.restrict_receipt_date){\r\n            //     return;\r\n            // }\r\n            // this.form.date_of_due = this.form.date_of_issue;\r\n            // if (\r\n            //     moment(this.form.date_of_issue) < moment().day(-1) &&\r\n            //     this.configuration.restrict_receipt_date\r\n            // ) {\r\n            //     this.$toast.error(\r\n            //         \"No puede seleccionar una fecha menor a 6 días.\"\r\n            //     );\r\n            //     this.dateValid = false;\r\n            // } else {\r\n            //     this.dateValid = true;\r\n            // }\r\n            // this.form.date_of_due = this.form.date_of_issue;\r\n            // this.searchExchangeRateByDate(this.form.date_of_issue).then(\r\n            //     response => {\r\n            //         this.form.exchange_rate_sale = response;\r\n            //     }\r\n            // );\r\n            this.form.exchange_rate_sale = 1;\r\n        },\r\n        NuevaVenta() {\r\n            this.$parent.nueva_venta();\r\n        },\r\n\r\n        async setInitialAmount() {\r\n            this.enter_amount = this.form.total;\r\n            this.form.payments = this.payments;\r\n            //get with screen size\r\n            let width = window.innerWidth;\r\n            if (width > 800) {\r\n                await this.$refs.enter_amount.$el\r\n                    .getElementsByTagName(\"input\")[0]\r\n                    .focus();\r\n                await this.$refs.enter_amount.$el\r\n                    .getElementsByTagName(\"input\")[0]\r\n                    .select();\r\n            } else {\r\n                await this.$refs.observation.$el\r\n                    .getElementsByTagName(\"textarea\")[0]\r\n                    .focus();\r\n            }\r\n        },\r\n        inputDiscountAmount() {\r\n            if (this.enabled_discount) {\r\n                if (\r\n                    this.discount_amount &&\r\n                    !isNaN(this.discount_amount) &&\r\n                    parseFloat(this.discount_amount) > 0\r\n                ) {\r\n                    this.form.total = this.form.total_value;\r\n                    if (this.discount_amount >= this.form.total)\r\n                        return this.$toast.error(\r\n                            \"El monto de descuento debe ser menor al total de venta\"\r\n                        );\r\n\r\n                    this.reCalculateTotal();\r\n                    this.enterAmount();\r\n                } else {\r\n                    this.deleteDiscountGlobal();\r\n                    this.reCalculateTotal();\r\n                    this.enterAmount();\r\n                }\r\n            }\r\n        },\r\n        discountGlobal() {\r\n            // this.form.total = this.form.total_value;\r\n            let global_discount = parseFloat(this.discount_amount);\r\n            let total = parseFloat(this.form.total);\r\n            let base = parseFloat(this.form.total_value);\r\n            if (global_discount > total) {\r\n                this.discount_amount = 0;\r\n                this.$forceUpdate();\r\n                return this.$toast.error(\r\n                    \"El descuento no puede ser mayor al total\"\r\n                );\r\n            }\r\n            // let total_value = parseFloat(this.form.total_value);\r\n            let new_total = total - global_discount;\r\n            let factor = _.round(global_discount / total, 4);\r\n            this.form.discounts = [\r\n                {\r\n                    discount_type_id: \"03\",\r\n                    description:\r\n                        \"Descuentos globales que no afectan la base imponible del IGV/IVAP\",\r\n                    factor,\r\n                    amount: global_discount,\r\n                    base: total\r\n                }\r\n            ];\r\n            this.form.total_discount = global_discount;\r\n            if (this.discountTotal) {\r\n                this.form.total = new_total;\r\n            } else {\r\n                let global_discount_amount = global_discount;\r\n                let global_discount_amount_without_rounding = global_discount;\r\n                let { discount_with_base_variant } = this.configuration;\r\n                if (discount_with_base_variant) {\r\n                    global_discount_amount = Number(\r\n                        (global_discount / 1.18).toFixed(2)\r\n                    );\r\n                    global_discount_amount_without_rounding =\r\n                        global_discount / 1.18;\r\n                }\r\n                let factor = _.round(global_discount_amount / base, 4);\r\n                this.form.discounts = [\r\n                    {\r\n                        discount_type_id: \"02\",\r\n                        description:\r\n                            \"Descuentos globales que afectan la base imponible del IGV/IVAP\",\r\n                        factor,\r\n                        amount: global_discount_amount,\r\n                        base\r\n                    }\r\n                ];\r\n\r\n                let new_base = this.form.total_value_without_rounding;\r\n                this.form.total_taxed = _.round(\r\n                    new_base - global_discount_amount_without_rounding,\r\n                    2\r\n                );\r\n                this.form.total_value = this.form.total_taxed;\r\n                if (this.configuration.affectation_igv_type_id == \"10\") {\r\n                    this.form.total_igv = _.round(\r\n                        this.form.total_taxed * (this.percentage_igv / 100),\r\n                        2\r\n                    );\r\n                } else {\r\n                    this.form.total_igv = 0;\r\n                }\r\n\r\n                //impuestos (isc + igv + icbper)\r\n                this.form.total_taxes = _.round(\r\n                    this.form.total_igv +\r\n                        this.form.total_isc +\r\n                        this.form.total_plastic_bag_taxes,\r\n                    2\r\n                );\r\n                this.form.total = _.round(\r\n                    this.form.total_taxed + this.form.total_taxes,\r\n                    2\r\n                );\r\n                this.form.subtotal = this.form.total;\r\n            }\r\n        },\r\n        discountGlobal3() {\r\n            let global_discount = parseFloat(this.discount_amount);\r\n            let total = parseFloat(this.form.total);\r\n            if (global_discount > total) {\r\n                this.discount_amount = 0;\r\n                this.$forceUpdate();\r\n                return this.$toast.error(\r\n                    \"El descuento no puede ser mayor al total\"\r\n                );\r\n            }\r\n            let amount = parseFloat(global_discount);\r\n            let discounts = this.splitDiscount(amount, this.form.items.length);\r\n            this.setDiscountItems(discounts);\r\n        },\r\n        setDiscountItems(discounts) {\r\n            for (let index = 0; index < this.form.items.length; index++) {\r\n                const item = this.form.items[index];\r\n                const discount = discounts[index];\r\n                if (item.originalTotal == undefined) {\r\n                    item.originalTotal = item.total;\r\n                    item.originalTotalValue = item.total_value;\r\n                }\r\n                item.discounts = [\r\n                    {\r\n                        discount_type_id: \"01\",\r\n                        discount_type: {\r\n                            id: \"01\",\r\n                            active: 1,\r\n                            base: 0,\r\n                            level: \"item\",\r\n                            type: \"discount\",\r\n                            description:\r\n                                \"Descuentos que no afectan la base imponible del IGV/IVAP\"\r\n                        },\r\n                        is_amount: true,\r\n                        description: \"Dscto\",\r\n                        factor: _.round(discount / item.originalTotalValue, 4),\r\n                        amount: discount,\r\n                        base: item.originalTotalValue\r\n                    }\r\n                ];\r\n\r\n                item.total_discount = discount;\r\n                item.total = item.originalTotal - discount;\r\n                item.total_value = item.originalTotalValue - discount;\r\n            }\r\n        },\r\n        splitDiscount(amount, n) {\r\n            let parts = new Array(n).fill(Math.floor(amount / n));\r\n            for (let i = 0; i < amount % n; i++) {\r\n                parts[i]++;\r\n            }\r\n            return parts;\r\n        },\r\n        discountGlobal2() {\r\n            let global_discount = parseFloat(this.discount_amount);\r\n            let base = parseFloat(this.form.total);\r\n            let amount = parseFloat(global_discount);\r\n            let factor = _.round(amount / base, 4);\r\n\r\n            let discount = _.find(this.form.discounts, {\r\n                discount_type_id: \"03\"\r\n            });\r\n\r\n            if (global_discount > 0 && !discount) {\r\n                this.form.total_discount = _.round(amount, 2);\r\n\r\n                this.form.total = _.round(this.form.total - amount, 2);\r\n\r\n                this.form.total_value = _.round(\r\n                    this.form.total / (1 + this.percentage_igv || 18 / 100),\r\n                    2\r\n                );\r\n                this.form.total_taxed = this.form.total_value;\r\n\r\n                this.form.total_igv = _.round(\r\n                    this.form.total_value * (this.percentage_igv || 18 / 100),\r\n                    2\r\n                );\r\n                this.form.total_taxes = this.form.total_igv;\r\n\r\n                this.form.discounts.push({\r\n                    discount_type_id: \"03\",\r\n                    description:\r\n                        \"Descuentos globales que no afectan la base imponible del IGV/IVAP\",\r\n                    factor: factor,\r\n                    amount: amount,\r\n                    base: base\r\n                });\r\n            } else {\r\n                let index = this.form.discounts.indexOf(discount);\r\n\r\n                if (index > -1) {\r\n                    this.form.total_discount = _.round(amount, 2);\r\n                    this.form.total = _.round(this.form.total - amount, 2);\r\n                    this.form.total_value = _.round(\r\n                        this.form.total / (1 + this.percentage_igv || 18 / 100),\r\n                        2\r\n                    );\r\n                    this.form.total_taxed = this.form.total_value;\r\n                    this.form.total_igv = _.round(\r\n                        this.form.total_value *\r\n                            (this.percentage_igv || 18 / 100),\r\n                        2\r\n                    );\r\n                    this.form.total_taxes = this.form.total_igv;\r\n\r\n                    this.form.discounts[index].base = base;\r\n                    this.form.discounts[index].amount = amount;\r\n                    this.form.discounts[index].factor = factor;\r\n                }\r\n            }\r\n        },\r\n        method_payment(method_pay) {\r\n            this.hasCreditCardCharge = false;\r\n            this.form.payment_condition_id = \"01\";\r\n            this.form.method_pay = method_pay;\r\n            this.form.afectar_caja = true;\r\n            if (this.configuration.credit_mode) {\r\n                if (\r\n                    method_pay == \"TARJETA: IZYPAY\" ||\r\n                    method_pay == \"TARJETA: NIUBIZ\" ||\r\n                    method_pay == \"Culqui\"\r\n                ) {\r\n                    this.hasCreditCardCharge = true;\r\n                } else {\r\n                    this.chargeCredit.amount = 0;\r\n                }\r\n\r\n                this.calculateCharge();\r\n            }\r\n        },\r\n\r\n        reCalculateTotal() {\r\n            let total_discount = 0;\r\n            let total_charge = 0;\r\n\r\n            let total_exportation = 0;\r\n            let total_taxed = 0;\r\n            let total_exonerated = 0;\r\n            let total_unaffected = 0;\r\n            let total_free = 0;\r\n            let total_igv = 0;\r\n            let total_value = 0;\r\n            let total = 0;\r\n            let total_plastic_bag_taxes = 0;\r\n            if (\r\n                this.affectation_optional_id != null &&\r\n                this.affectation_optional_id != undefined &&\r\n                this.affectation_optional_id != \"\"\r\n            ) {\r\n                this.form.items = this.formatItems(\r\n                    this.form.items,\r\n                    this.affectation_optional_id\r\n                );\r\n            }\r\n\r\n            this.form.items.forEach(row => {\r\n                total_discount += parseFloat(row.total_discount);\r\n                total_charge += parseFloat(row.total_charge);\r\n\r\n                if (row.affectation_igv_type_id === \"10\") {\r\n                    total_taxed += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"20\") {\r\n                    total_exonerated += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"30\") {\r\n                    total_unaffected += parseFloat(row.total_value);\r\n                }\r\n                if (row.affectation_igv_type_id === \"40\") {\r\n                    total_exportation += parseFloat(row.total_value);\r\n                }\r\n                if (\r\n                    [\"10\", \"20\", \"30\", \"40\"].indexOf(\r\n                        row.affectation_igv_type_id\r\n                    ) < 0\r\n                ) {\r\n                    total_free += parseFloat(row.total_value);\r\n                }\r\n                if (\r\n                    [\"10\", \"20\", \"30\", \"40\"].indexOf(\r\n                        row.affectation_igv_type_id\r\n                    ) > -1\r\n                ) {\r\n                    total_igv += parseFloat(row.total_igv);\r\n                    total += parseFloat(row.total);\r\n                }\r\n                total_value += parseFloat(row.total_value);\r\n                total_plastic_bag_taxes += isNaN(\r\n                    parseFloat(row.total_plastic_bag_taxes)\r\n                )\r\n                    ? 0.0\r\n                    : parseFloat(row.total_plastic_bag_taxes);\r\n            });\r\n\r\n            this.form.total_exportation = _.round(total_exportation, 2);\r\n            this.form.total_taxed = _.round(total_taxed, 2);\r\n            this.form.total_exonerated = _.round(total_exonerated, 2);\r\n            this.form.total_unaffected = _.round(total_unaffected, 2);\r\n            this.form.total_free = _.round(total_free, 2);\r\n            this.form.total_igv = _.round(total_igv, 2);\r\n            this.form.total_value = _.round(total_value, 2);\r\n            this.form.total_value_without_rounding = total_value;\r\n            this.form.total_taxes = _.round(total_igv, 2);\r\n            this.form.total_plastic_bag_taxes = _.round(\r\n                total_plastic_bag_taxes,\r\n                2\r\n            );\r\n            // this.form.total = _.round(total, 2)\r\n            this.form.total = _.round(\r\n                total_charge + total + this.form.total_plastic_bag_taxes,\r\n                2\r\n            );\r\n\r\n            if (this.discount_amount) {\r\n                this.discountGlobal();\r\n            }\r\n\r\n            // this.discountGlobal();\r\n        },\r\n        chargeGlobal() {\r\n            let base = parseFloat(this.form.total);\r\n            let amount = parseFloat(this.chargeCredit.total_charge);\r\n            let factor = _.round(amount / base, 5);\r\n            // console.log(base,factor, amount)\r\n            if (amount > 0) {\r\n                this.form.total_charge = _.round(amount, 2);\r\n                this.form.total = _.round(\r\n                    this.form.total + this.form.total_charge,\r\n                    2\r\n                );\r\n                this.form.charges.push({\r\n                    charge_type_id: \"50\",\r\n                    description:\r\n                        \"Cargos globales que no afectan la base imponible del IGV/IVAP\",\r\n                    factor: factor,\r\n                    amount: amount,\r\n                    base: base\r\n                });\r\n            }\r\n        },\r\n        deleteChargeGlobal() {\r\n            this.form.total_charge = 0;\r\n        },\r\n        deleteDiscountGlobal() {\r\n            // console.log(\"disque borrando\");\r\n            // let discount = _.find(this.form.discounts, {\r\n            //     discount_type_id: \"03\"\r\n            // });\r\n            // let index = this.form.discounts.indexOf(discount);\r\n\r\n            // if (index > -1) {\r\n            //     this.form.discounts.splice(index, 1);\r\n            //     this.form.total_discount = 0;\r\n            // }\r\n            for (let index = 0; index < this.form.items.length; index++) {\r\n                const item = this.form.items[index];\r\n                item.discounts = [];\r\n\r\n                item.total_discount = 0;\r\n                item.total = item.originalTotal || item.total;\r\n                item.total_value = item.originalTotalValue || item.total_value;\r\n            }\r\n        },\r\n        deleteDiscountGlobal2() {\r\n            let discount = _.find(this.form.discounts, {\r\n                discount_type_id: \"03\"\r\n            });\r\n            let index = this.form.discounts.indexOf(discount);\r\n\r\n            if (index > -1) {\r\n                this.form.discounts.splice(index, 1);\r\n                this.form.total_discount = 0;\r\n            }\r\n        },\r\n\r\n        getFormPosLocalStorage() {\r\n            let form_pos = localStorage.getItem(\"form_pos\");\r\n            form_pos = JSON.parse(form_pos);\r\n            if (form_pos) {\r\n                this.form.payments = form_pos.payments;\r\n            }\r\n        },\r\n        clickAddPayment() {\r\n            this.showDialogMultiplePayment = true;\r\n        },\r\n        reloadDataCardBrands(card_brand_id) {\r\n            this.$http\r\n                .get(`/${this.resource}/table/card_brands`)\r\n                .then(response => {\r\n                    this.cards_brand = response.data;\r\n                    this.form_payment.card_brand_id = card_brand_id;\r\n                    this.changePaymentMethodType();\r\n                });\r\n        },\r\n        getDescriptionPaymentMethodType(id) {\r\n            let payment_method_type = _.find(this.payment_method_types, {\r\n                id: id\r\n            });\r\n            return payment_method_type ? payment_method_type.description : \"\";\r\n        },\r\n        changePaymentMethodType() {\r\n            let payment_method_type = _.find(this.payment_method_types, {\r\n                id: this.form_payment.payment_method_type_id\r\n            });\r\n            this.has_card = payment_method_type.has_card;\r\n            this.form_payment.card_brand_id = payment_method_type.has_card\r\n                ? this.form_payment.card_brand_id\r\n                : null;\r\n        },\r\n        addRow(payments) {\r\n            this.form.payments = payments;\r\n            let acum_payment = 0;\r\n\r\n            this.form.payments.forEach(item => {\r\n                acum_payment += parseFloat(item.payment);\r\n            });\r\n            // this.amount = acum_payment\r\n            this.setAmount(acum_payment);\r\n\r\n            // console.log(this.form.payments)\r\n        },\r\n        setAmount(amount) {\r\n            // this.amount = parseFloat(this.amount) + parseFloat(amount)\r\n            this.form.enter_amount = amount;\r\n            this.amount = parseFloat(amount); //+ parseFloat(amount)\r\n            //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)\r\n            this.inputAmount(amount);\r\n        },\r\n        setAmountCash(amount) {\r\n            this.setAmount(amount);\r\n        },\r\n        async diferen() {\r\n            let differen =\r\n                (parseFloat(this.form.enter_amount) || 0) +\r\n                this.totalPayments() -\r\n                parseFloat(this.form.total);\r\n            if (differen < 0 && this.form.payment_condition_id == \"01\") {\r\n                this.$toast.error(\r\n                    \"El monto de efectivo es menor al total de venta\"\r\n                );\r\n            }\r\n        },\r\n        totalPayments() {\r\n            if (this.currentPayments.length != 0) {\r\n                let enter_amount = 0.0;\r\n                this.currentPayments.forEach(cp => {\r\n                    enter_amount += parseFloat(cp.amount);\r\n                });\r\n                return enter_amount;\r\n            }\r\n            return 0;\r\n        },\r\n        async enterAmount(amount = 0) {\r\n            this.amount = amount;\r\n\r\n            let enter_amount =\r\n                (parseFloat(this.form.enter_amount) || 0) +\r\n                this.totalPayments();\r\n\r\n            let differen = enter_amount - parseFloat(this.form.total);\r\n\r\n            this.form.difference = parseFloat(differen);\r\n\r\n            if (this.form.difference < 0) {\r\n                this.button_payment = true;\r\n                this.form.difference = differen;\r\n            } else if (this.form.difference >= 0) {\r\n                this.button_payment = false;\r\n                parseFloat(this.form.enter_amount) -\r\n                    parseFloat(this.form.total);\r\n            } else {\r\n                this.button_payment = true;\r\n            }\r\n            //this.form.difference = _.round(this.form.difference, 2);\r\n\r\n            this.$eventHub.$emit(\"eventSetFormPosLocalStorage\", this.form);\r\n            // this.setAmountCash(amount)\r\n        },\r\n        getLocalStoragePayment(key, re_default = null) {\r\n            let ls_obj = localStorage.getItem(key);\r\n            ls_obj = JSON.parse(ls_obj);\r\n\r\n            if (ls_obj) {\r\n                return ls_obj;\r\n            }\r\n\r\n            return re_default;\r\n        },\r\n        setLocalStoragePayment(key, obj) {\r\n            return localStorage.setItem(key, JSON.stringify(obj));\r\n        },\r\n        inputAmount(amount = null) {\r\n            this.enterAmount(amount);\r\n            this.form.difference = this.form.enter_amount - this.form.total;\r\n            if (isNaN(this.form.difference)) {\r\n                this.button_payment = true;\r\n                this.form.difference = \"-\";\r\n            } else if (this.form.difference >= 0) {\r\n                this.button_payment = false;\r\n                this.form.difference = this.amount - this.form.total;\r\n            } else {\r\n                this.button_payment = true;\r\n            }\r\n            this.$eventHub.$emit(\"eventSetFormPosLocalStorage\", this.form);\r\n        },\r\n        lStoPayment() {\r\n            this.setLocalStoragePayment(\"enter_amount\", this.form.enter_amount);\r\n            this.setLocalStoragePayment(\r\n                \"amount\",\r\n                this.amount == 0 ? this.form.total : this.amount\r\n            );\r\n            this.setLocalStoragePayment(\r\n                \"difference\",\r\n                this.amount == 0 ? this.form.total - this.amount : 0\r\n            );\r\n        },\r\n        initFormPayment() {\r\n            this.form.difference = this.form.total - this.form.enter_amount;\r\n            this.form_payment = {\r\n                id: null,\r\n                date_of_payment: moment().format(\"YYYY-MM-DD\"),\r\n                payment_method_type_id: \"01\",\r\n                reference: null,\r\n                card_brand_id: null,\r\n                document_id: null,\r\n                sale_note_id: null,\r\n                payment: this.form.total\r\n            };\r\n\r\n            this.form_cash_document = {\r\n                document_id: null,\r\n                sale_note_id: null\r\n            };\r\n        },\r\n\r\n        cleanLocalStoragePayment() {\r\n            this.setLocalStoragePayment(\"form_pos\", null);\r\n            this.setLocalStoragePayment(\"amount\", null);\r\n            this.setLocalStoragePayment(\"enter_amount\", null);\r\n            this.setLocalStoragePayment(\"difference\", null);\r\n        },\r\n        sleep(ms) {\r\n            return new Promise(resolve => setTimeout(resolve, ms));\r\n        },\r\n        passBoxes(total, boxes) {\r\n            let amounts = boxes.reduce((a, b) => a + b.amount, 0);\r\n            let rest = amounts - total;\r\n            let plus = false;\r\n            if (rest < 0) {\r\n                plus = true;\r\n                rest *= -1;\r\n            }\r\n            let newBoxes = [...boxes];\r\n\r\n            if (rest != 0) {\r\n                for (let i = 0; i < newBoxes.length; i++) {\r\n                    let box = newBoxes[i];\r\n                    if (plus) {\r\n                        box.amount += rest;\r\n                        rest = 0;\r\n                    } else {\r\n                        if (box.amount - rest > 0) {\r\n                            box.amount -= rest;\r\n                            rest = 0;\r\n                        }\r\n                    }\r\n\r\n                    if (rest == 0) {\r\n                        break;\r\n                    }\r\n                }\r\n            }\r\n            return newBoxes;\r\n        },\r\n        async sendPayment($event, form = null) {\r\n            // if (this.discount_amount) {\r\n            //     let global_discount = parseFloat(this.discount_amount);\r\n            //     let total = parseFloat(this.form.total);\r\n\r\n            //     if (global_discount > total) {\r\n            //         return this.$toast.error(\r\n            //             \"El descuento no puede ser mayor al total\"\r\n            //         );\r\n            //     }\r\n            // }\r\n            //$confirm check if form.observation is null or empty confirmation\r\n            let pass = true;\r\n            if (\r\n                (this.hasExceedBank && this.form.observation == null) ||\r\n                this.form.observation == \"\"\r\n            ) {\r\n                try {\r\n                    await this.$confirm(\r\n                        \"¿Desea continuar sin registrar la bancarización?\",\r\n                        \"Advertencia\",\r\n                        {\r\n                            confirmButtonText: \"Sí\",\r\n                            cancelButtonText: \"No\",\r\n                            type: \"warning\"\r\n                        }\r\n                    );\r\n                } catch (e) {\r\n                    pass = false;\r\n                }\r\n            }\r\n            if (!pass) {\r\n                return;\r\n            }\r\n            if (!form) {\r\n                form = this.form;\r\n            }\r\n            form.printerOn = this.printerOn == 1 ? true : false;\r\n            if (this.conf.pos_quick_sale) {\r\n                form.printerOn = form.printDocument;\r\n            }\r\n            await this.clickPayment(form);\r\n\r\n            if (this.formVariation.items.length != 0) {\r\n                let formVariation = this.formVariation;\r\n                formVariation.printerOn = false;\r\n                formVariation.variation_document_id = this.documentNewId;\r\n                formVariation.document_type_id = \"80\";\r\n                formVariation.customer_telephone = null;\r\n                formVariation.customer_id = this.customer_variation.id;\r\n                this.customers = [\r\n                    ...this.customers.filter(\r\n                        c => c != this.customer_variation.id\r\n                    ),\r\n                    this.customer_variation\r\n                ];\r\n                formVariation.boxes = this.passBoxes(\r\n                    this.formVariation.total,\r\n                    this.form.boxes\r\n                );\r\n\r\n                let noteVariation = this.all_series.find(\r\n                    s => s.document_type_id == \"80\"\r\n                );\r\n                if (noteVariation) {\r\n                    formVariation.series_id = noteVariation.id;\r\n                    await this.clickPayment(formVariation);\r\n                } else {\r\n                    this.$toast.error(\"Sin serie en nota de venta\");\r\n                }\r\n            }\r\n        },\r\n        checkPaymentsIsOk() {\r\n            let total = 0;\r\n            this.currentPayments.forEach(p => {\r\n                total += parseFloat(p.amount);\r\n            });\r\n            return total == this.form.total;\r\n        },\r\n        checkBankAccount(){\r\n            let pass = true;\r\n            let {is_bank}  = this.form_payment;\r\n            if(is_bank){\r\n                if(!this.form.bank_account_id){\r\n                    this.$toast.error(\"Debe seleccionar una cuenta bancaria\");\r\n                    pass = false;\r\n                }\r\n                if(!this.form.reference_number){\r\n                    this.$toast.error(\"Debe ingresar el número de operación\");\r\n                    pass = false;\r\n                }\r\n            }\r\n\r\n            return pass;\r\n        },\r\n        async clickPayment(form) {\r\n            if (!this.checkBankAccount()) {\r\n                return;\r\n            }\r\n    \r\n            let how_is;\r\n            this.reCalculateTotal();\r\n            // return;\r\n            if (\r\n                (!this.form.series_id && this.conf.pos_quick_sale) ||\r\n                this.ordens_all_table\r\n            ) {\r\n                this.setSeries();\r\n            }\r\n            if (this.configuration.college && !this.conf.pos_quick_sale) {\r\n                if (!this.form.student_id) {\r\n                    this.$toast.error(\"El alumno es obligatorio\");\r\n\r\n                    return;\r\n                }\r\n            }\r\n            if (\r\n                (form.document_type_id == \"01\" ||\r\n                    form.document_type_id == \"03\") &&\r\n                form.total <= 0\r\n            ) {\r\n                this.$toast.error(\r\n                    \"El monto total no puede ser menor o igual a 0\"\r\n                );\r\n                return;\r\n            }\r\n            if (form.total + 200 <= form.enter_amount) {\r\n                this.$toast.error(\r\n                    \"El monto ingresado no puede ser S/. 200 mayor del Total a cobrar \"\r\n                );\r\n                return;\r\n            }\r\n\r\n            let customer = this.customers.find(c => c.id == form.customer_id);\r\n\r\n            if (\r\n                form.customer_telephone != null &&\r\n                form.customer_telephone != \"\"\r\n            ) {\r\n                if (!this.existNumber()) {\r\n                    this.$toast.error(\"Número para envío whatsapp inválido\");\r\n                    return;\r\n                }\r\n            }\r\n            if (form.customer_id == null || form.customer_id == \"\") {\r\n                return this.$toast.error(\"Elija un cliente\");\r\n            }\r\n            if (\r\n                customer.identity_document_type_id == \"1\" &&\r\n                form.document_type_id == \"01\"\r\n            ) {\r\n                return this.$toast.error(\"No puede emitir Factura con DNI\");\r\n            }\r\n            if (!form.series_id) {\r\n                return this.$toast.warning(\r\n                    \"El establecimiento no tiene series disponibles para el comprobante\"\r\n                );\r\n            }\r\n\r\n            if (form.document_type_id === \"80\") {\r\n                form.prefix = \"NV\";\r\n                form.paid = 1;\r\n                this.resource_documents = \"sale-notes\";\r\n                this.resource_payments = \"sale_note_payments\";\r\n                this.resource_options = this.resource_documents;\r\n            } else {\r\n                form.prefix = null;\r\n                this.resource_documents = \"documents\";\r\n                this.resource_payments = \"document_payments\";\r\n                this.resource_options = this.resource_documents;\r\n            }\r\n            if (this.orden != null) {\r\n                form.additional_information = `Orden N°${this.orden}`;\r\n            }\r\n            form.advances = 0.0;\r\n            form.total_advances = 0.0;\r\n            form.total_payment = form.total;\r\n            form.payments = [\r\n                {\r\n                    payment_method_type_id: \"01\",\r\n                    date_of_payment: form.date_of_issue,\r\n                    payment: form.total\r\n                }\r\n            ];\r\n\r\n            form.cash_id = this.cash_id;\r\n            if (this.form.payment_condition_id == \"01\") {\r\n                form.boxes = this.currentPayments;\r\n                if(this.form_payment.is_bank){\r\n                    this.changeBankAccount();\r\n                }\r\n            } else {\r\n                let isOk = this.checkPaymentsIsOk();\r\n                if (!isOk) {\r\n                    this.$toast.error(\"Las cuotas no coinciden con el total\");\r\n                    return;\r\n                }\r\n            }\r\n\r\n            if (this.form.payment_condition_id !== \"01\") {\r\n                form.fee = this.currentPayments.map(b => ({\r\n                    id: null,\r\n                    currency_type_id: \"PEN\",\r\n                    amount: b.amount,\r\n                    date: b.date\r\n                }));\r\n                form.payment_condition_id = \"02\";\r\n            } else {\r\n                this.addPayment();\r\n            }\r\n            if (this.checkLimitReceipt()) {\r\n                this.$toast.error(\r\n                    \"Las boletas mayores a 699 deben tener un dni o ruc válido.\"\r\n                );\r\n                return;\r\n            }\r\n      \r\n            this.loading_submit = true;\r\n            this.form.items = this.form.items.filter(\r\n                item => Number(item.quantity) > 0\r\n            );\r\n            if (this.isConsignment) {\r\n                this.form.from_consignment = true;\r\n            }\r\n\r\n            try {\r\n                let form_efectivo = {\r\n                    enter_amount: form.enter_amount,\r\n                    difference: form.difference\r\n                };\r\n                let ordenId = this.idOrden;\r\n\r\n                if (\r\n                    (ordenId == undefined || ordenId == null) &&\r\n                    (form.variation == undefined || form.variation == null) &&\r\n                    !this.conf.pos_quick_sale &&\r\n                    !this.ordens_all_table\r\n                ) {\r\n                    const responses = await this.$http.post(\r\n                        \"/caja/worker/send-orden\",\r\n                        this.orden_items\r\n                    );\r\n                    ordenId = responses.data.id;\r\n                    if (responses.status != 200) {\r\n                        return;\r\n                    }\r\n                }\r\n                form.orden_id = ordenId;\r\n                if (this.ordens_all_table) {\r\n                    form.all_ordens = true;\r\n                }\r\n                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);\r\n\r\n                const response = await this.$http.post(\r\n                    `/${this.resource_documents}`,\r\n                    form\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    let format = null;\r\n                    let data = response.data.data;\r\n                    switch (data.format_printer) {\r\n                        case 1:\r\n                            format = data.print_a4;\r\n                            break;\r\n                        case 2:\r\n                            format = data.print_a5;\r\n                            break;\r\n                        default:\r\n                            format = data.print_ticket;\r\n                            break;\r\n                    }\r\n                    if (this.printer && format && this.printerOn == 1) {\r\n                        // this.printerDocument(this.printer,format)\r\n                    }\r\n                    if (response.data.success == true) {\r\n                        let document_id = 0;\r\n                        if (form.document_type_id === \"80\") {\r\n                            this.number = response.data.data.number;\r\n                            document_id = response.data.data.id;\r\n                            this.form_cash_document.sale_note_id =\r\n                                response.data.data.id;\r\n                        } else {\r\n                            document_id = response.data.data.id;\r\n                            this.form_cash_document.document_id =\r\n                                response.data.data.id;\r\n                            this.number = response.data.data.number;\r\n                        }\r\n                        this.documentNewId = response.data.data.id;\r\n\r\n                        if (response.data.success == true) {\r\n                            /* let customer = this.all_customers.find(\r\n                                c => c.id == form.customer_id\r\n                            ); */\r\n\r\n                            if (ordenId) {\r\n                                if (\r\n                                    this.configuration.college &&\r\n                                    this.form.student_id\r\n                                ) {\r\n                                    const registerCollegeResponse = await this.$http.post(\r\n                                        \"/college/registers/sale\",\r\n                                        {\r\n                                            is_sale_note:\r\n                                                form.document_type_id == \"80\",\r\n                                            document_id: this.documentNewId,\r\n                                            detail: {\r\n                                                items: this.form.items.map(\r\n                                                    s => s.item\r\n                                                )\r\n                                            },\r\n                                            student_id: this.form.student_id\r\n                                        }\r\n                                    );\r\n                                }\r\n\r\n                                if (\r\n                                    this.configuration.consignment &&\r\n                                    this.consignment_id &&\r\n                                    this.isConsignment\r\n                                ) {\r\n                                    const consigmentLiquidate = await this.$http.post(\r\n                                        `/consignment/liquidated`,\r\n                                        {\r\n                                            id: this.consignment_id,\r\n                                            items: this.form.items.map(i => ({\r\n                                                consignment_item_id:\r\n                                                    i.consignment_item_id,\r\n                                                toWarehouse: i.toWarehouse,\r\n                                                quantity: i.quantity\r\n                                            })),\r\n                                            document_id: this.documentNewId,\r\n                                            document_type_id:\r\n                                                form.document_type_id\r\n                                        }\r\n                                    );\r\n                                    if (consigmentLiquidate.status == 200) {\r\n                                        this.$toast.success(\r\n                                            \"Liquidación de consignación realizada.\"\r\n                                        );\r\n                                    }\r\n                                }\r\n                                const response2 = await this.$http.post(\r\n                                    \"pos/orden_payment\",\r\n                                    {\r\n                                        id: ordenId,\r\n                                        customer_id: customer.id,\r\n                                        document: {\r\n                                            isNoteSale:\r\n                                                form.document_type_id === \"80\",\r\n                                            id: this.documentNewId\r\n                                        }\r\n                                    }\r\n                                );\r\n\r\n                                if (this.configuration.promotions_sell) {\r\n                                    how_is = this.all_customers.find(\r\n                                        c => c.id == form.customer_id\r\n                                    );\r\n                                    if (!how_is.name.includes(\"VARIOS\")) {\r\n                                        let itemspromo = form.items;\r\n\r\n                                        const procesarOferta = await axios.post(\r\n                                            `pos/processPromo`,\r\n                                            { itemspromo, how_is }\r\n                                        );\r\n                                    }\r\n                                }\r\n\r\n                                if (response2.data.success == true) {\r\n                                    if (this.form.customer_telephone) {\r\n                                        if (this.personalWhatsapp) {\r\n                                            await this.$emit(\"getFile\", {\r\n                                                total: this.form.total,\r\n                                                documentId: this.documentNewId,\r\n                                                documentTypeId:\r\n                                                    form.document_type_id,\r\n                                                number: this.form\r\n                                                    .customer_telephone,\r\n                                                message: this.form.message\r\n                                            });\r\n                                        } else {\r\n                                            await this.clickSendWhatsapp(\r\n                                                form.document_type_id,\r\n                                                this.documentNewId,\r\n                                                this.number,\r\n                                                form\r\n                                            );\r\n                                        }\r\n                                        this.$emit(\"limpiarForm\");\r\n                                        this.loading_submit = false;\r\n                                        this.$emit(\"removeConsignment\");\r\n\r\n                                        this.back(true);\r\n                                    } else {\r\n                                        this.$emit(\"limpiarForm\");\r\n                                        this.loading_submit = false;\r\n                                        this.$emit(\"removeConsignment\");\r\n                                        this.back(true);\r\n                                    }\r\n                                } else {\r\n                                    console.log(response2);\r\n                                }\r\n                            } else {\r\n                                if (this.conf.pos_quick_sale) {\r\n                                    this.$toast.success(\"Venta realizada.\");\r\n                                }\r\n                                this.$emit(\"limpiarForm\");\r\n                                this.$emit(\"removeConsignment\");\r\n                                this.loading_submit = false;\r\n\r\n                                this.back(true);\r\n                            }\r\n                        }\r\n                    }\r\n                } else {\r\n                    this.loading_submit = true;\r\n                    this.$alert(\r\n                        \"<strong>Ocurrio un error </strong>\" +\r\n                            response.statusCode +\r\n                            \"<br>\" +\r\n                            this.resource_documents,\r\n                        \"HTML String\",\r\n                        {\r\n                            dangerouslyUseHTMLString: true\r\n                        }\r\n                    );\r\n                }\r\n            } catch (error) {\r\n                console.log(error);\r\n                const response = error.response;\r\n                let {\r\n                    data: { message }\r\n                } = response;\r\n\r\n                this.$toast.error(message || \"Ocurrió un error\");\r\n                this.loading_submit = false;\r\n            }\r\n        },\r\n\r\n        async clickPrintPos(printerName, formatoPdf, userId = null) {\r\n            try {\r\n                let config = qz.configs.create(\r\n                    printerName,\r\n                    { legacy: true },\r\n                    { scaleContent: false }\r\n                );\r\n                if (!qz.websocket.isActive()) {\r\n                    await qz.websocket.connect(config);\r\n                }\r\n                let data = [\r\n                    {\r\n                        type: \"pdf\",\r\n                        format: \"file\",\r\n                        data: formatoPdf\r\n                    }\r\n                ];\r\n                qz.print(config, data).catch(e => {\r\n                    this.$toast.error(e.message);\r\n                });\r\n            } catch (e) {\r\n                this.$toast.error(e.message);\r\n            }\r\n        },\r\n        saveCashDocument() {\r\n            this.$http\r\n                .post(`/cash/cash_document`, this.form_cash_document)\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                        // console.log(response)\r\n                    } else {\r\n                        this.$toast.error(response.data.message);\r\n                    }\r\n                })\r\n                .catch(error => {\r\n                    console.log(error);\r\n                });\r\n        },\r\n        savePaymentMethod() {\r\n            this.$http\r\n                .post(`/${this.resource_payments}`, this.form_payment)\r\n                .then(response => {\r\n                    if (response.data.success) {\r\n                        // console.log(response)\r\n                    } else {\r\n                        this.$toast.error(response.data.message);\r\n                    }\r\n                })\r\n                .catch(error => {\r\n                    if (error.response.status === 422) {\r\n                        this.records[index].errors = error.response.data;\r\n                    } else {\r\n                        console.log(error);\r\n                    }\r\n                });\r\n        },\r\n        getTables() {\r\n            this.filterSeries();\r\n        },\r\n\r\n        async clickCancel() {\r\n            this.loading_submit = true;\r\n\r\n            this.loading_submit = false;\r\n            this.cleanLocalStoragePayment();\r\n            this.$eventHub.$emit(\"cancelSale\");\r\n        },\r\n        back(val = false) {\r\n            this.splitPayments = [];\r\n            //this.$emit(\"limpiarForm\");\r\n            if (!val) {\r\n                this.$emit(\"openDrawer\");\r\n            }\r\n            this.$emit(\"update:is_payment\", false);\r\n        },\r\n        async initLStoPayment() {\r\n            this.amount = await this.getLocalStoragePayment(\r\n                \"amount\",\r\n                this.form.total\r\n            );\r\n            this.form.enter_amount = await this.getLocalStoragePayment(\r\n                \"enter_amount\",\r\n                this.form.total\r\n            );\r\n            this.form.difference = await this.getLocalStoragePayment(\r\n                \"difference\",\r\n                this.form.total - this.form.enter_amount\r\n            );\r\n        },\r\n        checkCustomers() {\r\n            if (this.form.document_type_id == \"01\") {\r\n                return this.customers.some(\r\n                    c => c.identity_document_type_id == \"6\"\r\n                );\r\n            } else {\r\n                return this.customers.some(\r\n                    c => c.identity_document_type_id == \"1\"\r\n                );\r\n            }\r\n        },\r\n        setSeries() {\r\n            this.form.series_id = null;\r\n            this.series = _.filter(this.all_series, {\r\n                document_type_id: this.form.document_type_id\r\n            });\r\n            this.series.forEach(s => {\r\n                s.full_number =\r\n                    `${s.number}-${this.last_number[s.number] || \"1\"}` ||\r\n                    s.number;\r\n            });\r\n            this.form.series_id =\r\n                this.series.length > 0 ? this.series[0].id : null;\r\n        },\r\n\r\n        filterSeries() {\r\n            let check = this.checkCustomers();\r\n            if (!check && !this.started) {\r\n                let dcto = \"DNI\";\r\n                if (this.form.document_type_id == \"01\") {\r\n                    dcto = \"RUC\";\r\n                    this.form.document_type_id = \"03\";\r\n                } else {\r\n                    this.form.document_type_id = \"01\";\r\n                }\r\n                this.$toast.warning(`Digite el número de ${dcto}`);\r\n\r\n                this.setSeries();\r\n                return;\r\n            }\r\n            this.started = false;\r\n\r\n            if (this.form.document_type_id == \"01\") {\r\n                this.currentDocumentsType = [\r\n                    ...this.documentsType.filter(f => f.description == \"RUC\")\r\n                ];\r\n                this.form.identity_document_type_id = this.currentDocumentsType[0].id;\r\n            } else {\r\n                this.currentDocumentsType = this.documentsType;\r\n            }\r\n            this.setSeries();\r\n            //aqui\r\n            //factura solo ruc\r\n            //boletas solo dni\r\n            //note de venta todo\r\n            let currentClient = null;\r\n            if (this.value != null) {\r\n                currentClient = this.all_customers.find(\r\n                    c => c.id == this.value\r\n                );\r\n\r\n                // if (currentClient.identity_document_type_id == \"1\") {\r\n                //     this.form.document_type_id = \"03\";\r\n                // }\r\n            }\r\n\r\n            if (this.form.document_type_id == \"01\") {\r\n                this.customers = this.all_customers.filter(\r\n                    f => f.identity_document_type_id == \"6\"\r\n                );\r\n                if (this.customers.length == 0) {\r\n                    this.$toast.warning(\"Digite el número de RUC\");\r\n                    this.form.document_type_id == \"03\";\r\n\r\n                    // this.customers = this.all_customers;\r\n                } else {\r\n                    if (\r\n                        currentClient &&\r\n                        this.customers.some(c => c.id == currentClient.id)\r\n                    ) {\r\n                        this.form.customer_telephone = currentClient.phone;\r\n                        return;\r\n                    }\r\n                    this.value = this.customers[0].id;\r\n                    this.form.customer_telephone = this.customers[0].phone;\r\n                }\r\n            }\r\n            // else if (\r\n            //     this.form.document_type_id == \"03\" ||\r\n            //     this.form.document_type_id == \"80\"\r\n            // ) {\r\n            //     this.customers = this.all_customers.filter(\r\n            //         f => f.identity_document_type_id != \"6\"\r\n            //     );\r\n            //     if (this.form.total > 300) {\r\n            //         this.customers = this.customers.filter(\r\n            //             c => c.identity_document_type_id == \"1\"\r\n            //         );\r\n            //     }\r\n\r\n            //     if (\r\n            //         currentClient &&\r\n            //         this.customers.some(c => c.id == currentClient.id)\r\n            //     ) {\r\n            //         this.form.customer_telephone = currentClient.phone;\r\n            //         return;\r\n            //     }\r\n            //     let client = this.customers.find(c => {\r\n            //         return c.name.toLowerCase().includes(\"varios\");\r\n            //     });\r\n            //     if (client) {\r\n            //         this.value = client.id;\r\n            //         this.form.customer_telephone = client.phone;\r\n            //     } else {\r\n            //         this.value = this.customers[0].id;\r\n            //         this.form.customer_telephone = this.customers[0].phone;\r\n            //     }\r\n            // }\r\n            else {\r\n                this.customers = this.all_customers;\r\n            }\r\n\r\n            this.customers = this.customers.filter(n => n.number != \"88888888\");\r\n            this.customers = [\r\n                ...this.customers.filter(n => n.id != this.customer_default.id)\r\n            ];\r\n            if (this.form.document_type_id != \"01\") {\r\n                this.customers = [...this.customers, this.customer_default];\r\n            }\r\n\r\n            this.changeCustomer();\r\n            if(this.form.document_type_id == \"80\"){\r\n                this.discount_amount = 0;\r\n                this.inputDiscountAmount();\r\n            }\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/print-js/dist/print.js":
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["printJS"] = factory();
	else
		root["printJS"] = factory();
})(window, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./sass/index.scss */ "./src/sass/index.scss");
/* harmony import */ var _sass_index_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_index_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _js_init__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./js/init */ "./src/js/init.js");


var printJS = _js_init__WEBPACK_IMPORTED_MODULE_1__["default"].init;

if (typeof window !== 'undefined') {
  window.printJS = printJS;
}

/* harmony default export */ __webpack_exports__["default"] = (printJS);

/***/ }),

/***/ "./src/js/browser.js":
/*!***************************!*\
  !*** ./src/js/browser.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var Browser = {
  // Firefox 1.0+
  isFirefox: function isFirefox() {
    return typeof InstallTrigger !== 'undefined';
  },
  // Internet Explorer 6-11
  isIE: function isIE() {
    return navigator.userAgent.indexOf('MSIE') !== -1 || !!document.documentMode;
  },
  // Edge 20+
  isEdge: function isEdge() {
    return !Browser.isIE() && !!window.StyleMedia;
  },
  // Chrome 1+
  isChrome: function isChrome() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : window;
    return !!context.chrome;
  },
  // At least Safari 3+: "[object HTMLElementConstructor]"
  isSafari: function isSafari() {
    return Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || navigator.userAgent.toLowerCase().indexOf('safari') !== -1;
  },
  // IOS Chrome
  isIOSChrome: function isIOSChrome() {
    return navigator.userAgent.toLowerCase().indexOf('crios') !== -1;
  }
};
/* harmony default export */ __webpack_exports__["default"] = (Browser);

/***/ }),

/***/ "./src/js/functions.js":
/*!*****************************!*\
  !*** ./src/js/functions.js ***!
  \*****************************/
/*! exports provided: addWrapper, capitalizePrint, collectStyles, addHeader, cleanUp, isRawHTML */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addWrapper", function() { return addWrapper; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "capitalizePrint", function() { return capitalizePrint; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "collectStyles", function() { return collectStyles; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addHeader", function() { return addHeader; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cleanUp", function() { return cleanUp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isRawHTML", function() { return isRawHTML; });
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



function addWrapper(htmlData, params) {
  var bodyStyle = 'font-family:' + params.font + ' !important; font-size: ' + params.font_size + ' !important; width:100%;';
  return '<div style="' + bodyStyle + '">' + htmlData + '</div>';
}
function capitalizePrint(obj) {
  return obj.charAt(0).toUpperCase() + obj.slice(1);
}
function collectStyles(element, params) {
  var win = document.defaultView || window; // String variable to hold styling for each element

  var elementStyle = ''; // Loop over computed styles

  var styles = win.getComputedStyle(element, '');

  for (var key = 0; key < styles.length; key++) {
    // Check if style should be processed
    if (params.targetStyles.indexOf('*') !== -1 || params.targetStyle.indexOf(styles[key]) !== -1 || targetStylesMatch(params.targetStyles, styles[key])) {
      if (styles.getPropertyValue(styles[key])) elementStyle += styles[key] + ':' + styles.getPropertyValue(styles[key]) + ';';
    }
  } // Print friendly defaults (deprecated)


  elementStyle += 'max-width: ' + params.maxWidth + 'px !important; font-size: ' + params.font_size + ' !important;';
  return elementStyle;
}

function targetStylesMatch(styles, value) {
  for (var i = 0; i < styles.length; i++) {
    if (_typeof(value) === 'object' && value.indexOf(styles[i]) !== -1) return true;
  }

  return false;
}

function addHeader(printElement, params) {
  // Create the header container div
  var headerContainer = document.createElement('div'); // Check if the header is text or raw html

  if (isRawHTML(params.header)) {
    headerContainer.innerHTML = params.header;
  } else {
    // Create header element
    var headerElement = document.createElement('h1'); // Create header text node

    var headerNode = document.createTextNode(params.header); // Build and style

    headerElement.appendChild(headerNode);
    headerElement.setAttribute('style', params.headerStyle);
    headerContainer.appendChild(headerElement);
  }

  printElement.insertBefore(headerContainer, printElement.childNodes[0]);
}
function cleanUp(params) {
  // If we are showing a feedback message to user, remove it
  if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_0__["default"].close(); // Check for a finished loading hook function

  if (params.onLoadingEnd) params.onLoadingEnd(); // If preloading pdf files, clean blob url

  if (params.showModal || params.onLoadingStart) window.URL.revokeObjectURL(params.printable); // Run onPrintDialogClose callback

  var event = 'mouseover';

  if (_browser__WEBPACK_IMPORTED_MODULE_1__["default"].isChrome() || _browser__WEBPACK_IMPORTED_MODULE_1__["default"].isFirefox()) {
    // Ps.: Firefox will require an extra click in the document to fire the focus event.
    event = 'focus';
  }

  var handler = function handler() {
    // Make sure the event only happens once.
    window.removeEventListener(event, handler);
    params.onPrintDialogClose(); // Remove iframe from the DOM

    var iframe = document.getElementById(params.frameId);

    if (iframe) {
      iframe.remove();
    }
  };

  window.addEventListener(event, handler);
}
function isRawHTML(raw) {
  var regexHtml = new RegExp('<([A-Za-z][A-Za-z0-9]*)\\b[^>]*>(.*?)</\\1>');
  return regexHtml.test(raw);
}

/***/ }),

/***/ "./src/js/html.js":
/*!************************!*\
  !*** ./src/js/html.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Get the DOM printable element
    var printElement = isHtmlElement(params.printable) ? params.printable : document.getElementById(params.printable); // Check if the element exists

    if (!printElement) {
      window.console.error('Invalid HTML element id: ' + params.printable);
      return;
    } // Clone the target element including its children (if available)


    params.printableElement = cloneElement(printElement, params); // Add header

    if (params.header) {
      Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params);
    } // Print html element contents


    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

function cloneElement(element, params) {
  // Clone the main node (if not already inside the recursion process)
  var clone = element.cloneNode(); // Loop over and process the children elements / nodes (including text nodes)

  var childNodesArray = Array.prototype.slice.call(element.childNodes);

  for (var i = 0; i < childNodesArray.length; i++) {
    // Check if we are skipping the current element
    if (params.ignoreElements.indexOf(childNodesArray[i].id) !== -1) {
      continue;
    } // Clone the child element


    var clonedChild = cloneElement(childNodesArray[i], params); // Attach the cloned child to the cloned parent node

    clone.appendChild(clonedChild);
  } // Get all styling for print element (for nodes of type element only)


  if (params.scanStyles && element.nodeType === 1) {
    clone.setAttribute('style', Object(_functions__WEBPACK_IMPORTED_MODULE_0__["collectStyles"])(element, params));
  } // Check if the element needs any state processing (copy user input data)


  switch (element.tagName) {
    case 'SELECT':
      // Copy the current selection value to its clone
      clone.value = element.value;
      break;

    case 'CANVAS':
      // Copy the canvas content to its clone
      clone.getContext('2d').drawImage(element, 0, 0);
      break;
  }

  return clone;
}

function isHtmlElement(printable) {
  // Check if element is instance of HTMLElement or has nodeType === 1 (for elements in iframe)
  return _typeof(printable) === 'object' && printable && (printable instanceof HTMLElement || printable.nodeType === 1);
}

/***/ }),

/***/ "./src/js/image.js":
/*!*************************!*\
  !*** ./src/js/image.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we are printing one image or multiple images
    if (params.printable.constructor !== Array) {
      // Create array with one image
      params.printable = [params.printable];
    } // Create printable element (container)


    params.printableElement = document.createElement('div'); // Create all image elements and append them to the printable container

    params.printable.forEach(function (src) {
      // Create the image element
      var img = document.createElement('img');
      img.setAttribute('style', params.imageStyle); // Set image src with the file url

      img.src = src; // The following block is for Firefox, which for some reason requires the image's src to be fully qualified in
      // order to print it

      if (_browser__WEBPACK_IMPORTED_MODULE_2__["default"].isFirefox()) {
        var fullyQualifiedSrc = img.src;
        img.src = fullyQualifiedSrc;
      } // Create the image wrapper


      var imageWrapper = document.createElement('div'); // Append image to the wrapper element

      imageWrapper.appendChild(img); // Append wrapper to the printable element

      params.printableElement.appendChild(imageWrapper);
    }); // Check if we are adding a print header

    if (params.header) Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params); // Print image

    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

/***/ }),

/***/ "./src/js/init.js":
/*!************************!*\
  !*** ./src/js/init.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _pdf__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./pdf */ "./src/js/pdf.js");
/* harmony import */ var _html__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./html */ "./src/js/html.js");
/* harmony import */ var _raw_html__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./raw-html */ "./src/js/raw-html.js");
/* harmony import */ var _image__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./image */ "./src/js/image.js");
/* harmony import */ var _json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./json */ "./src/js/json.js");


function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }








var printTypes = ['pdf', 'html', 'image', 'json', 'raw-html'];
/* harmony default export */ __webpack_exports__["default"] = ({
  init: function init() {
    var params = {
      printable: null,
      fallbackPrintable: null,
      type: 'pdf',
      header: null,
      headerStyle: 'font-weight: 300;',
      maxWidth: 800,
      properties: null,
      gridHeaderStyle: 'font-weight: bold; padding: 5px; border: 1px solid #dddddd;',
      gridStyle: 'border: 1px solid lightgray; margin-bottom: -1px;',
      showModal: false,
      onError: function onError(error) {
        throw error;
      },
      onLoadingStart: null,
      onLoadingEnd: null,
      onPrintDialogClose: function onPrintDialogClose() {},
      onIncompatibleBrowser: function onIncompatibleBrowser() {},
      modalMessage: 'Retrieving Document...',
      frameId: 'printJS',
      printableElement: null,
      documentTitle: 'Document',
      targetStyle: ['clear', 'display', 'width', 'min-width', 'height', 'min-height', 'max-height'],
      targetStyles: ['border', 'box', 'break', 'text-decoration'],
      ignoreElements: [],
      repeatTableHeader: true,
      css: null,
      style: null,
      scanStyles: true,
      base64: false,
      // Deprecated
      onPdfOpen: null,
      font: 'TimesNewRoman',
      font_size: '12pt',
      honorMarginPadding: true,
      honorColor: false,
      imageStyle: 'max-width: 100%;'
    }; // Check if a printable document or object was supplied

    var args = arguments[0];

    if (args === undefined) {
      throw new Error('printJS expects at least 1 attribute.');
    } // Process parameters


    switch (_typeof(args)) {
      case 'string':
        params.printable = encodeURI(args);
        params.fallbackPrintable = params.printable;
        params.type = arguments[1] || params.type;
        break;

      case 'object':
        params.printable = args.printable;
        params.fallbackPrintable = typeof args.fallbackPrintable !== 'undefined' ? args.fallbackPrintable : params.printable;
        params.fallbackPrintable = params.base64 ? "data:application/pdf;base64,".concat(params.fallbackPrintable) : params.fallbackPrintable;

        for (var k in params) {
          if (k === 'printable' || k === 'fallbackPrintable') continue;
          params[k] = typeof args[k] !== 'undefined' ? args[k] : params[k];
        }

        break;

      default:
        throw new Error('Unexpected argument type! Expected "string" or "object", got ' + _typeof(args));
    } // Validate printable


    if (!params.printable) throw new Error('Missing printable information.'); // Validate type

    if (!params.type || typeof params.type !== 'string' || printTypes.indexOf(params.type.toLowerCase()) === -1) {
      throw new Error('Invalid print type. Available types are: pdf, html, image and json.');
    } // Check if we are showing a feedback message to the user (useful for large files)


    if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_1__["default"].show(params); // Check for a print start hook function

    if (params.onLoadingStart) params.onLoadingStart(); // To prevent duplication and issues, remove any used printFrame from the DOM

    var usedFrame = document.getElementById(params.frameId);
    if (usedFrame) usedFrame.parentNode.removeChild(usedFrame); // Create a new iframe for the print job

    var printFrame = document.createElement('iframe');

    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
      // Set the iframe to be is visible on the page (guaranteed by fixed position) but hidden using opacity 0, because
      // this works in Firefox. The height needs to be sufficient for some part of the document other than the PDF
      // viewer's toolbar to be visible in the page
      printFrame.setAttribute('style', 'width: 1px; height: 100px; position: fixed; left: 0; top: 0; opacity: 0; border-width: 0; margin: 0; padding: 0');
    } else {
      // Hide the iframe in other browsers
      printFrame.setAttribute('style', 'visibility: hidden; height: 0; width: 0; position: absolute; border: 0');
    } // Set iframe element id


    printFrame.setAttribute('id', params.frameId); // For non pdf printing, pass an html document string to srcdoc (force onload callback)

    if (params.type !== 'pdf') {
      printFrame.srcdoc = '<html><head><title>' + params.documentTitle + '</title>'; // Attach css files

      if (params.css) {
        // Add support for single file
        if (!Array.isArray(params.css)) params.css = [params.css]; // Create link tags for each css file

        params.css.forEach(function (file) {
          printFrame.srcdoc += '<link rel="stylesheet" href="' + file + '">';
        });
      }

      printFrame.srcdoc += '</head><body></body></html>';
    } // Check printable type


    switch (params.type) {
      case 'pdf':
        // Check browser support for pdf and if not supported we will just open the pdf file instead
        if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isIE()) {
          try {
            console.info('Print.js doesn\'t support PDF printing in Internet Explorer.');
            var win = window.open(params.fallbackPrintable, '_blank');
            win.focus();
            params.onIncompatibleBrowser();
          } catch (error) {
            params.onError(error);
          } finally {
            // Make sure there is no loading modal opened
            if (params.showModal) _modal__WEBPACK_IMPORTED_MODULE_1__["default"].close();
            if (params.onLoadingEnd) params.onLoadingEnd();
          }
        } else {
          _pdf__WEBPACK_IMPORTED_MODULE_2__["default"].print(params, printFrame);
        }

        break;

      case 'image':
        _image__WEBPACK_IMPORTED_MODULE_5__["default"].print(params, printFrame);
        break;

      case 'html':
        _html__WEBPACK_IMPORTED_MODULE_3__["default"].print(params, printFrame);
        break;

      case 'raw-html':
        _raw_html__WEBPACK_IMPORTED_MODULE_4__["default"].print(params, printFrame);
        break;

      case 'json':
        _json__WEBPACK_IMPORTED_MODULE_6__["default"].print(params, printFrame);
        break;
    }
  }
});

/***/ }),

/***/ "./src/js/json.js":
/*!************************!*\
  !*** ./src/js/json.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we received proper data
    if (_typeof(params.printable) !== 'object') {
      throw new Error('Invalid javascript data object (JSON).');
    } // Validate repeatTableHeader


    if (typeof params.repeatTableHeader !== 'boolean') {
      throw new Error('Invalid value for repeatTableHeader attribute (JSON).');
    } // Validate properties


    if (!params.properties || !Array.isArray(params.properties)) {
      throw new Error('Invalid properties array for your JSON data.');
    } // We will format the property objects to keep the JSON api compatible with older releases


    params.properties = params.properties.map(function (property) {
      return {
        field: _typeof(property) === 'object' ? property.field : property,
        displayName: _typeof(property) === 'object' ? property.displayName : property,
        columnSize: _typeof(property) === 'object' && property.columnSize ? property.columnSize + ';' : 100 / params.properties.length + '%;'
      };
    }); // Create a print container element

    params.printableElement = document.createElement('div'); // Check if we are adding a print header

    if (params.header) {
      Object(_functions__WEBPACK_IMPORTED_MODULE_0__["addHeader"])(params.printableElement, params);
    } // Build the printable html data


    params.printableElement.innerHTML += jsonToHTML(params); // Print the json data

    _print__WEBPACK_IMPORTED_MODULE_1__["default"].send(params, printFrame);
  }
});

function jsonToHTML(params) {
  // Get the row and column data
  var data = params.printable;
  var properties = params.properties; // Create a html table

  var htmlData = '<table style="border-collapse: collapse; width: 100%;">'; // Check if the header should be repeated

  if (params.repeatTableHeader) {
    htmlData += '<thead>';
  } // Add the table header row


  htmlData += '<tr>'; // Add the table header columns

  for (var a = 0; a < properties.length; a++) {
    htmlData += '<th style="width:' + properties[a].columnSize + ';' + params.gridHeaderStyle + '">' + Object(_functions__WEBPACK_IMPORTED_MODULE_0__["capitalizePrint"])(properties[a].displayName) + '</th>';
  } // Add the closing tag for the table header row


  htmlData += '</tr>'; // If the table header is marked as repeated, add the closing tag

  if (params.repeatTableHeader) {
    htmlData += '</thead>';
  } // Create the table body


  htmlData += '<tbody>'; // Add the table data rows

  for (var i = 0; i < data.length; i++) {
    // Add the row starting tag
    htmlData += '<tr>'; // Print selected properties only

    for (var n = 0; n < properties.length; n++) {
      var stringData = data[i]; // Support nested objects

      var property = properties[n].field.split('.');

      if (property.length > 1) {
        for (var p = 0; p < property.length; p++) {
          stringData = stringData[property[p]];
        }
      } else {
        stringData = stringData[properties[n].field];
      } // Add the row contents and styles


      htmlData += '<td style="width:' + properties[n].columnSize + params.gridStyle + '">' + stringData + '</td>';
    } // Add the row closing tag


    htmlData += '</tr>';
  } // Add the table and body closing tags


  htmlData += '</tbody></table>';
  return htmlData;
}

/***/ }),

/***/ "./src/js/modal.js":
/*!*************************!*\
  !*** ./src/js/modal.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var Modal = {
  show: function show(params) {
    // Build modal
    var modalStyle = 'font-family:sans-serif; ' + 'display:table; ' + 'text-align:center; ' + 'font-weight:300; ' + 'font-size:30px; ' + 'left:0; top:0;' + 'position:fixed; ' + 'z-index: 9990;' + 'color: #0460B5; ' + 'width: 100%; ' + 'height: 100%; ' + 'background-color:rgba(255,255,255,.9);' + 'transition: opacity .3s ease;'; // Create wrapper

    var printModal = document.createElement('div');
    printModal.setAttribute('style', modalStyle);
    printModal.setAttribute('id', 'printJS-Modal'); // Create content div

    var contentDiv = document.createElement('div');
    contentDiv.setAttribute('style', 'display:table-cell; vertical-align:middle; padding-bottom:100px;'); // Add close button (requires print.css)

    var closeButton = document.createElement('div');
    closeButton.setAttribute('class', 'printClose');
    closeButton.setAttribute('id', 'printClose');
    contentDiv.appendChild(closeButton); // Add spinner (requires print.css)

    var spinner = document.createElement('span');
    spinner.setAttribute('class', 'printSpinner');
    contentDiv.appendChild(spinner); // Add message

    var messageNode = document.createTextNode(params.modalMessage);
    contentDiv.appendChild(messageNode); // Add contentDiv to printModal

    printModal.appendChild(contentDiv); // Append print modal element to document body

    document.getElementsByTagName('body')[0].appendChild(printModal); // Add event listener to close button

    document.getElementById('printClose').addEventListener('click', function () {
      Modal.close();
    });
  },
  close: function close() {
    var printModal = document.getElementById('printJS-Modal');

    if (printModal) {
      printModal.parentNode.removeChild(printModal);
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (Modal);

/***/ }),

/***/ "./src/js/pdf.js":
/*!***********************!*\
  !*** ./src/js/pdf.js ***!
  \***********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./print */ "./src/js/print.js");
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");


/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Check if we have base64 data
    if (params.base64) {
      var bytesArray = Uint8Array.from(atob(params.printable), function (c) {
        return c.charCodeAt(0);
      });
      createBlobAndPrint(params, printFrame, bytesArray);
      return;
    } // Format pdf url


    params.printable = /^(blob|http|\/\/)/i.test(params.printable) ? params.printable : window.location.origin + (params.printable.charAt(0) !== '/' ? '/' + params.printable : params.printable); // Get the file through a http request (Preload)

    var req = new window.XMLHttpRequest();
    req.responseType = 'arraybuffer';
    req.addEventListener('error', function () {
      Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
      params.onError(req.statusText, req); // Since we don't have a pdf document available, we will stop the print job
    });
    req.addEventListener('load', function () {
      // Check for errors
      if ([200, 201].indexOf(req.status) === -1) {
        Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
        params.onError(req.statusText, req); // Since we don't have a pdf document available, we will stop the print job

        return;
      } // Print requested document


      createBlobAndPrint(params, printFrame, req.response);
    });
    req.open('GET', params.printable, true);
    req.send();
  }
});

function createBlobAndPrint(params, printFrame, data) {
  // Pass response or base64 data to a blob and create a local object url
  var localPdf = new window.Blob([data], {
    type: 'application/pdf'
  });
  localPdf = window.URL.createObjectURL(localPdf); // Set iframe src with pdf document url

  printFrame.setAttribute('src', localPdf);
  _print__WEBPACK_IMPORTED_MODULE_0__["default"].send(params, printFrame);
}

/***/ }),

/***/ "./src/js/print.js":
/*!*************************!*\
  !*** ./src/js/print.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./browser */ "./src/js/browser.js");
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./functions */ "./src/js/functions.js");


var Print = {
  send: function send(params, printFrame) {
    // Append iframe element to document body
    document.getElementsByTagName('body')[0].appendChild(printFrame); // Get iframe element

    var iframeElement = document.getElementById(params.frameId); // Wait for iframe to load all content

    iframeElement.onload = function () {
      if (params.type === 'pdf') {
        // Add a delay for Firefox. In my tests, 1000ms was sufficient but 100ms was not
        if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
          setTimeout(function () {
            return performPrint(iframeElement, params);
          }, 1000);
        } else {
          performPrint(iframeElement, params);
        }

        return;
      } // Get iframe element document


      var printDocument = iframeElement.contentWindow || iframeElement.contentDocument;
      if (printDocument.document) printDocument = printDocument.document; // Append printable element to the iframe body

      printDocument.body.appendChild(params.printableElement); // Add custom style

      if (params.type !== 'pdf' && params.style) {
        // Create style element
        var style = document.createElement('style');
        style.innerHTML = params.style; // Append style element to iframe's head

        printDocument.head.appendChild(style);
      } // If printing images, wait for them to load inside the iframe


      var images = printDocument.getElementsByTagName('img');

      if (images.length > 0) {
        loadIframeImages(Array.from(images)).then(function () {
          return performPrint(iframeElement, params);
        });
      } else {
        performPrint(iframeElement, params);
      }
    };
  }
};

function performPrint(iframeElement, params) {
  try {
    iframeElement.focus(); // If Edge or IE, try catch with execCommand

    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isEdge() || _browser__WEBPACK_IMPORTED_MODULE_0__["default"].isIE()) {
      try {
        iframeElement.contentWindow.document.execCommand('print', false, null);
      } catch (e) {
        iframeElement.contentWindow.print();
      }
    } else {
      // Other browsers
      iframeElement.contentWindow.print();
    }
  } catch (error) {
    params.onError(error);
  } finally {
    if (_browser__WEBPACK_IMPORTED_MODULE_0__["default"].isFirefox()) {
      // Move the iframe element off-screen and make it invisible
      iframeElement.style.visibility = 'hidden';
      iframeElement.style.left = '-1px';
    }

    Object(_functions__WEBPACK_IMPORTED_MODULE_1__["cleanUp"])(params);
  }
}

function loadIframeImages(images) {
  var promises = images.map(function (image) {
    if (image.src && image.src !== window.location.href) {
      return loadIframeImage(image);
    }
  });
  return Promise.all(promises);
}

function loadIframeImage(image) {
  return new Promise(function (resolve) {
    var pollImage = function pollImage() {
      !image || typeof image.naturalWidth === 'undefined' || image.naturalWidth === 0 || !image.complete ? setTimeout(pollImage, 500) : resolve();
    };

    pollImage();
  });
}

/* harmony default export */ __webpack_exports__["default"] = (Print);

/***/ }),

/***/ "./src/js/raw-html.js":
/*!****************************!*\
  !*** ./src/js/raw-html.js ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _print__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./print */ "./src/js/print.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  print: function print(params, printFrame) {
    // Create printable element (container)
    params.printableElement = document.createElement('div');
    params.printableElement.setAttribute('style', 'width:100%'); // Set our raw html as the printable element inner html content

    params.printableElement.innerHTML = params.printable; // Print html contents

    _print__WEBPACK_IMPORTED_MODULE_0__["default"].send(params, printFrame);
  }
});

/***/ }),

/***/ "./src/sass/index.scss":
/*!*****************************!*\
  !*** ./src/sass/index.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 0:
/*!****************************!*\
  !*** multi ./src/index.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/index.js */"./src/index.js");


/***/ })

/******/ })["default"];
});
//# sourceMappingURL=print.map

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-385e4f75\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      staticClass: "algunaClase",
      attrs: {
        visible: _vm.is_payment,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "modal-append-to-body": true,
        "show-close": false,
        "append-to-body": true,
        width: "850px",
        top: "2vh",
        title: "MODULO DE COBRO " + (_vm.variation ? "- Variación" : "")
      },
      on: { open: _vm.date_of_issue }
    },
    [
      _c(
        "div",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading,
              expression: "loading"
            }
          ],
          staticClass: " mb-0"
        },
        [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading_submit,
                  expression: "loading_submit"
                }
              ],
              staticClass: "pt-1"
            },
            [
              _c(
                "div",
                { staticClass: "d-flex pt-2 justify-content-end" },
                [
                  _c(
                    "el-button",
                    {
                      attrs: { size: "mini", type: "primary" },
                      on: {
                        click: function($event) {
                          _vm.showListItems = true
                        }
                      }
                    },
                    [_c("i", { staticClass: "fas fa-clipboard-list" })]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("div", { staticClass: "row pt-2" }, [
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("div", { staticClass: "mb-2" }, [
                    _c("div", { staticClass: "card bg-light" }, [
                      _c("div", { staticClass: "row " }, [
                        _c(
                          "div",
                          { staticClass: "  col-md-6 col-lg-5 col-sm-6" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "Comprobante de Pago\n                                    "
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c(
                                  "el-radio-group",
                                  {
                                    attrs: { size: "small" },
                                    on: {
                                      change: function($event) {
                                        _vm.date_of_issue()
                                        _vm.filterSeries()
                                      }
                                    },
                                    model: {
                                      value: _vm.form.document_type_id,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.form,
                                          "document_type_id",
                                          $$v
                                        )
                                      },
                                      expression: "form.document_type_id"
                                    }
                                  },
                                  [
                                    !_vm.isInterno
                                      ? [
                                          _vm.invoice
                                            ? _c(
                                                "el-radio-button",
                                                { attrs: { label: "01" } },
                                                [
                                                  _vm._v(
                                                    "FACTURA\n                                                "
                                                  )
                                                ]
                                              )
                                            : _vm._e(),
                                          _vm._v(" "),
                                          _vm.receipt
                                            ? _c(
                                                "el-radio-button",
                                                { attrs: { label: "03" } },
                                                [
                                                  _vm._v(
                                                    "\n                                                    BOLETA\n                                                "
                                                  )
                                                ]
                                              )
                                            : _vm._e()
                                        ]
                                      : _vm._e(),
                                    _vm._v(" "),
                                    !_vm.variation &&
                                    _vm.sale_note &&
                                    !_vm.clientSaleNoteNumber
                                      ? _c(
                                          "el-radio-button",
                                          { attrs: { label: "80" } },
                                          [
                                            _vm._v(
                                              "\n                                                N. VENTA\n                                            "
                                            )
                                          ]
                                        )
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ],
                              1
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-6 col-md-3 col-lg-3 col-xl-3" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "\n                                        Serie\n                                    "
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c(
                                  "el-select",
                                  {
                                    staticClass: "w-100",
                                    model: {
                                      value: _vm.form.series_id,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form, "series_id", $$v)
                                      },
                                      expression: "form.series_id"
                                    }
                                  },
                                  _vm._l(_vm.series, function(option) {
                                    return _c("el-option", {
                                      key: option.id,
                                      staticStyle: {
                                        "z-index": "2000 !important"
                                      },
                                      attrs: {
                                        label: option.full_number,
                                        value: option.id
                                      }
                                    })
                                  }),
                                  1
                                )
                              ],
                              1
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-6 col-md-4 col-lg-4 " }, [
                          _c(
                            "div",
                            { staticClass: "form-group" },
                            [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Fecha de Emisión")
                              ]),
                              _vm._v(" "),
                              _c("el-date-picker", {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  type: "date",
                                  "value-format": "yyyy-MM-dd",
                                  clearable: false,
                                  format: "dd-MM-yyyy",
                                  readonly: this.configuration
                                    .restrict_receipt_date
                                },
                                on: { change: _vm.changeDateOfIssue },
                                model: {
                                  value: _vm.form.date_of_issue,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "date_of_issue", $$v)
                                  },
                                  expression: "form.date_of_issue"
                                }
                              })
                            ],
                            1
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row " }, [
                        _c("div", { staticClass: "col-lg-6 " }, [
                          _c(
                            "div",
                            { staticClass: "form-group" },
                            [
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "el-input el-input-group col-md-6 ",
                                    staticStyle: { "margin-bottom": "3px" }
                                  },
                                  [
                                    _c(
                                      "label",
                                      {
                                        staticClass: "control-label",
                                        staticStyle: { "margin-right": "3px" }
                                      },
                                      [_vm._v("Cliente")]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-button",
                                      {
                                        attrs: {
                                          disabled:
                                            !_vm.value || _vm.isClientesVarios()
                                        },
                                        on: { click: _vm.openDialogPerson }
                                      },
                                      [
                                        _vm._v(
                                          "Editar\n                                                    cliente"
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    !_vm.configuration.college
                                      ? _c(
                                          "el-button",
                                          { on: { click: _vm.createClient } },
                                          [
                                            _vm._v(
                                              "Nuevo\n                                                    cliente"
                                            )
                                          ]
                                        )
                                      : _vm._e()
                                  ],
                                  1
                                )
                              ]
                            ],
                            2
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-12 col-sm-8 col-lg-6" },
                          [
                            _c(
                              "el-select",
                              {
                                ref: "select_person",
                                staticClass: "col-md-6",
                                attrs: {
                                  filterable: "",
                                  clearable: "",
                                  size: "small",
                                  placeholder: "Cliente",
                                  disabled: _vm.loading
                                },
                                on: { change: _vm.changeCustomer },
                                nativeOn: {
                                  keyup: function($event) {
                                    return _vm.keyupCustomer.apply(
                                      null,
                                      arguments
                                    )
                                  }
                                },
                                model: {
                                  value: _vm.value,
                                  callback: function($$v) {
                                    _vm.value = $$v
                                  },
                                  expression: "value"
                                }
                              },
                              _vm._l(_vm.customers, function(option) {
                                return _c("el-option", {
                                  key: option.id,
                                  attrs: {
                                    label: option.description,
                                    value: option.id
                                  }
                                })
                              }),
                              1
                            )
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _vm.students.length != 0
                        ? _c("div", { staticClass: "row col-lg-6 col-xl-12" }, [
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c(
                                  "label",
                                  { staticClass: "control-label w-100" },
                                  [_vm._v("Estudiante")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "el-select",
                                  {
                                    on: { change: _vm.changeStudent },
                                    model: {
                                      value: _vm.form.student_id,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form, "student_id", $$v)
                                      },
                                      expression: "form.student_id"
                                    }
                                  },
                                  _vm._l(_vm.students, function(student, idx) {
                                    return _c("el-option", {
                                      key: idx,
                                      attrs: {
                                        label:
                                          student.name + " - " + student.class,
                                        value: student.id
                                      }
                                    })
                                  }),
                                  1
                                )
                              ],
                              1
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.configuration.seller_caja
                        ? _c("div", { staticClass: "row" }, [
                            _c(
                              "div",
                              { staticClass: "col-md-4 col-12" },
                              [
                                _c("label", { attrs: { for: "seller" } }, [
                                  _vm._v("Vendedor")
                                ]),
                                _vm._v(" "),
                                _c(
                                  "el-select",
                                  {
                                    model: {
                                      value: _vm.form.seller_id,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form, "seller_id", $$v)
                                      },
                                      expression: "form.seller_id"
                                    }
                                  },
                                  _vm._l(_vm.sellers, function(option, idx) {
                                    return _c("el-option", {
                                      key: idx,
                                      attrs: {
                                        label: option.name,
                                        value: option.id
                                      }
                                    })
                                  }),
                                  1
                                )
                              ],
                              1
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _c("div", { staticClass: "row col-lg-12 col-xl-12" }, [
                        _c(
                          "div",
                          { staticClass: "form-group" },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Observaciones")
                            ]),
                            _vm._v(" "),
                            _c("el-input", {
                              ref: "observation",
                              attrs: {
                                type: "textarea",
                                rows: 2,
                                placeholder: _vm.bank
                              },
                              model: {
                                value: _vm.form.observation,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "observation", $$v)
                                },
                                expression: "form.observation"
                              }
                            })
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _vm.form.document_type_id != "80"
                        ? _c("div", { staticClass: "row" }, [
                            _c(
                              "div",
                              { staticClass: "col-md-4 form-group" },
                              [
                                _c("label", { staticClass: "control-label" }, [
                                  _vm._v("Monto Descuento")
                                ]),
                                _vm._v(" "),
                                _c("el-input-number", {
                                  staticClass: "w-100",
                                  attrs: {
                                    min: 0,
                                    "controls-position": "right"
                                  },
                                  on: { change: _vm.inputDiscountAmount },
                                  model: {
                                    value: _vm.discount_amount,
                                    callback: function($$v) {
                                      _vm.discount_amount = $$v
                                    },
                                    expression: "discount_amount"
                                  }
                                })
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _vm.configuration.affectation_igv_type_id == "10"
                              ? _c(
                                  "div",
                                  { staticClass: "col-md-4 form-group" },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "control-label" },
                                      [_vm._v("Tipo de descuento")]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-checkbox",
                                      {
                                        on: { change: _vm.reCalculateTotal },
                                        model: {
                                          value: _vm.discountTotal,
                                          callback: function($$v) {
                                            _vm.discountTotal = $$v
                                          },
                                          expression: "discountTotal"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.discountTotal
                                                ? "Descuento del total"
                                                : "Descuento a la base"
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
                                    )
                                  ],
                                  1
                                )
                              : _vm._e()
                          ])
                        : _vm._e()
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("div", { staticClass: " mb-2 " }, [
                    _c(
                      "div",
                      {
                        staticClass: " text-center text-dark card  bg-light  "
                      },
                      [
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "  col-lg-6 " }, [
                            _c("div", { staticClass: " align-items-start " }, [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Medios de Pago")
                              ]),
                              _vm._v(" "),
                              _c("label", {
                                staticClass: "text-primary control-label",
                                attrs: { role: "button" }
                              })
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "radio-tile-group2 flex-wrap" },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "cash",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "01"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "01"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "01"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "Efectivo"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonEfectivo.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon walk-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "cash" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "culqui",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "02"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "02"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "02"
                                          },
                                          function($event) {
                                            return _vm.method_payment("Culqui")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/CulquiIcon.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "05"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "05"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "05"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: IZYPAY"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonIzipay.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "07"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "07"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "07"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: OPENPAY"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonOpenpay.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "06"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "06"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "06"
                                          },
                                          function($event) {
                                            return _vm.method_payment(
                                              "TARJETA: NIUBIZ"
                                            )
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/botonNiubiz.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "yape",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "03"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "03"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "03"
                                          },
                                          function($event) {
                                            return _vm.method_payment("Yape")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "input-container2 border rounded-sm"
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.method_payments,
                                          expression: "method_payments"
                                        }
                                      ],
                                      staticClass: "radio-button2",
                                      attrs: {
                                        disabled: _vm.form_payment.is_bank,
                                        id: "plin",
                                        type: "radio",
                                        name: "method_payment",
                                        value: "04"
                                      },
                                      domProps: {
                                        checked: _vm._q(
                                          _vm.method_payments,
                                          "04"
                                        )
                                      },
                                      on: {
                                        change: [
                                          function($event) {
                                            _vm.method_payments = "04"
                                          },
                                          function($event) {
                                            return _vm.method_payment("PLIN")
                                          }
                                        ]
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "radio-tile2",
                                        staticStyle: {
                                          "background-image":
                                            "url('../../images/plin-logo-0C4106153C-seeklogo.com.png')",
                                          "background-size": "contain",
                                          "background-repeat": "no-repeat"
                                        }
                                      },
                                      [
                                        _c("div", {
                                          staticClass: "icon bike-icon"
                                        }),
                                        _vm._v(" "),
                                        _c("label", {
                                          staticClass: "radio-tile-label2",
                                          attrs: { for: "Tarjeta" }
                                        })
                                      ]
                                    )
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "row col-md-12" }, [
                              _vm.hasCreditCardCharge &&
                              _vm.configuration.credit_mode
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "mt-2 d-flex justify-content-start align-items-end"
                                    },
                                    [
                                      _c(
                                        "div",
                                        { staticClass: "col-md-4" },
                                        [
                                          _c(
                                            "label",
                                            {
                                              staticClass: "w-100",
                                              staticStyle: {
                                                "text-align": "left"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                    " +
                                                  _vm._s(
                                                    _vm.chargeCredit
                                                      .credit_type == "1"
                                                      ? "Porcentaje"
                                                      : "Monto"
                                                  ) +
                                                  "\n                                                "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c("el-input", {
                                            staticClass: "w-100",
                                            attrs: { type: "number" },
                                            on: { input: _vm.calculateCharge },
                                            model: {
                                              value: _vm.chargeCredit.amount,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  _vm.chargeCredit,
                                                  "amount",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "\n                                                        chargeCredit.amount\n                                                    "
                                            }
                                          })
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass: "col-md-2",
                                          staticStyle: {
                                            "text-align": "left",
                                            "margin-left": "5px"
                                          }
                                        },
                                        [
                                          _c(
                                            "el-radio-group",
                                            {
                                              attrs: { size: "small" },
                                              on: {
                                                change: _vm.calculateCharge
                                              },
                                              model: {
                                                value:
                                                  _vm.chargeCredit.credit_type,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.chargeCredit,
                                                    "credit_type",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "\n                                                        chargeCredit.credit_type\n                                                    "
                                              }
                                            },
                                            [
                                              _c(
                                                "el-radio-button",
                                                { attrs: { label: "1" } },
                                                [_vm._v("%")]
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "el-radio-button",
                                                { attrs: { label: "2" } },
                                                [_vm._v("S/")]
                                              )
                                            ],
                                            1
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "col-md-3 align-self-center mt-4",
                                          staticStyle: {
                                            "text-align": "left",
                                            "margin-left": "5px"
                                          }
                                        },
                                        [
                                          _vm.chargeCredit.total_charge != 0 &&
                                          _vm.chargeCredit.amount
                                            ? _c(
                                                "label",
                                                { staticClass: "h5" },
                                                [
                                                  _vm._v(
                                                    "\n                                                    S/\n                                                    " +
                                                      _vm._s(
                                                        _vm.chargeCredit.total_charge.toFixed(
                                                          2
                                                        )
                                                      ) +
                                                      "\n                                                "
                                                  )
                                                ]
                                              )
                                            : _vm._e()
                                        ]
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-lg-6" },
                            [
                              _vm.bank_accounts.length != 0
                                ? [
                                    _c(
                                      "label",
                                      { attrs: { for: "banks" } },
                                      [
                                        _c("el-checkbox", {
                                          model: {
                                            value: _vm.form_payment.is_bank,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form_payment,
                                                "is_bank",
                                                $$v
                                              )
                                            },
                                            expression:
                                              "\n                                                    form_payment.is_bank\n                                                "
                                          }
                                        }),
                                        _vm._v(
                                          "\n                                            Transferencia / Depositos"
                                        )
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-select",
                                      {
                                        attrs: {
                                          disabled: !_vm.form_payment.is_bank
                                        },
                                        on: { change: _vm.changeBankAccount },
                                        model: {
                                          value: _vm.form.bank_account_id,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.form,
                                              "bank_account_id",
                                              $$v
                                            )
                                          },
                                          expression: "form.bank_account_id"
                                        }
                                      },
                                      _vm._l(_vm.bank_accounts, function(bank) {
                                        return _c("el-option", {
                                          key: bank.id,
                                          attrs: {
                                            label:
                                              bank.description +
                                              "-" +
                                              bank.number,
                                            value: bank.id
                                          }
                                        })
                                      }),
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c("el-input", {
                                      staticClass: "mt-1",
                                      attrs: {
                                        disabled: !_vm.form_payment.is_bank,
                                        placeholder: "Nro Operación"
                                      },
                                      model: {
                                        value: _vm.form.reference_number,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form,
                                            "reference_number",
                                            $$v
                                          )
                                        },
                                        expression: "form.reference_number"
                                      }
                                    })
                                  ]
                                : [
                                    _c("span", { staticClass: "text-danger" }, [
                                      _vm._v(
                                        "No hay cuentas bancarias\n                                            registradas"
                                      )
                                    ])
                                  ]
                            ],
                            2
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-lg-12" }, [
                            _c("div", { staticClass: "row" }, [
                              _c(
                                "div",
                                { staticClass: "col-lg-4 col-md-5 col-xl-6" },
                                [
                                  _c(
                                    "label",
                                    {
                                      staticClass:
                                        "control-label text-left  d-flex align-items-start justify-content-start"
                                    },
                                    [
                                      _vm._v(
                                        "\n                                                Ingrese Nro Celular\n                                            "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "el-input",
                                    {
                                      model: {
                                        value: _vm.form.customer_telephone,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form,
                                            "customer_telephone",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "\n                                                    form.customer_telephone\n                                                "
                                      }
                                    },
                                    [
                                      _c("template", { slot: "prepend" }, [
                                        _c("i", {
                                          staticClass: "fab fa-whatsapp fa-2x"
                                        })
                                      ])
                                    ],
                                    2
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "radio-tile-group2 col-lg-6 col-xl-6 d ",
                                  staticStyle: { "padding-top": "12px" }
                                },
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass:
                                        "input-container2 border rounded-sm col-lg-3"
                                    },
                                    [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: _vm.printerOn,
                                            expression: "printerOn"
                                          }
                                        ],
                                        staticClass: "radio-button2",
                                        attrs: {
                                          id: "imprimir",
                                          type: "radio",
                                          name: "imprimir",
                                          value: "1"
                                        },
                                        domProps: {
                                          checked: _vm._q(_vm.printerOn, "1")
                                        },
                                        on: {
                                          change: function($event) {
                                            _vm.printerOn = "1"
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        { staticClass: "radio-tile2" },
                                        [
                                          _c(
                                            "div",
                                            { staticClass: "icon walk-icon" },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-print"
                                              })
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "label",
                                            {
                                              staticClass: "radio-tile-label2",
                                              attrs: { for: "cash" }
                                            },
                                            [_vm._v("Imprimir")]
                                          )
                                        ]
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass:
                                        "input-container2 border rounded-sm col-lg-3"
                                    },
                                    [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: _vm.printerOn,
                                            expression: "printerOn"
                                          }
                                        ],
                                        staticClass: "radio-button2",
                                        attrs: {
                                          id: "noimprimir",
                                          type: "radio",
                                          name: "noimprimir",
                                          value: "0"
                                        },
                                        domProps: {
                                          checked: _vm._q(_vm.printerOn, "0")
                                        },
                                        on: {
                                          change: function($event) {
                                            _vm.printerOn = "0"
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        { staticClass: "radio-tile2" },
                                        [
                                          _c(
                                            "div",
                                            { staticClass: "icon bike-icon" },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-print"
                                              })
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "label",
                                            {
                                              staticClass: "radio-tile-label2",
                                              attrs: { for: "Tarjeta" }
                                            },
                                            [_vm._v("No Imprimir")]
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "row" }, [
                              _c("div", {
                                staticClass:
                                  "col-lg-8  d-flex flex-row align-items-end"
                              }),
                              _vm._v(" "),
                              _c("div", { staticClass: "d-flex flex-column" })
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass: "row d-flex justify-content-start"
                              },
                              [
                                _vm.currentPayments.length != 0
                                  ? _c("table", { staticClass: "table" }, [
                                      _c("thead", [
                                        _c("tr", [
                                          _c(
                                            "th",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "4" }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(
                                                    _vm.form
                                                      .payment_condition_id !==
                                                      "01"
                                                      ? "Cuotas"
                                                      : "Pagos"
                                                  ) +
                                                  "\n                                                    "
                                              )
                                            ]
                                          )
                                        ])
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "tbody",
                                        _vm._l(_vm.currentPayments, function(
                                          paymnt,
                                          idx
                                        ) {
                                          return _c("tr", { key: idx }, [
                                            _c("td", [_vm._v(_vm._s(idx + 1))]),
                                            _vm._v(" "),
                                            _vm.form.payment_condition_id !==
                                            "01"
                                              ? _c(
                                                  "td",
                                                  [
                                                    _c("el-date-picker", {
                                                      model: {
                                                        value: paymnt.date,
                                                        callback: function(
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            paymnt,
                                                            "date",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "\n                                                                paymnt.date\n                                                            "
                                                      }
                                                    })
                                                  ],
                                                  1
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            _c("td", [
                                              _vm._v(
                                                "\n                                                        " +
                                                  _vm._s(paymnt.method) +
                                                  "\n                                                    "
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _c("strong", [
                                                _vm._v(_vm._s(paymnt.amount))
                                              ])
                                            ]),
                                            _vm._v(" "),
                                            _c("td", [
                                              _c(
                                                "label",
                                                {
                                                  staticClass: "text-danger",
                                                  attrs: {
                                                    for: "",
                                                    role: "button"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.removePayment(
                                                        paymnt.id
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass: "fa fa-trash"
                                                  })
                                                ]
                                              )
                                            ])
                                          ])
                                        }),
                                        0
                                      )
                                    ])
                                  : _vm._e()
                              ]
                            )
                          ])
                        ])
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-12" }, [
                    _c("div", { staticClass: "mb-2" }, [
                      _c("div", { staticClass: " card  bg-light " }, [
                        _c("div", { staticClass: "row" }, [
                          _c(
                            "div",
                            {
                              staticClass: " col-xl-4",
                              class: {
                                "has-danger": _vm.form.difference < 0
                              },
                              staticStyle: {
                                "margin-top": "10px",
                                "padding-top": "5px"
                              }
                            },
                            [
                              _c("label", { staticClass: "control-label h1" }, [
                                _vm._v("Total a cobrar: ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "span",
                                {
                                  staticClass:
                                    "control-label font-weight-semibold text-center h3"
                                },
                                [
                                  _vm._v(
                                    "\n                                            S/ " +
                                      _vm._s(" " + _vm.form.total) +
                                      "\n                                        "
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm.form_payment.payment_method_type_id == "01"
                            ? _c("div", { staticClass: "col-xl-8" }, [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "btn-group btn-group-square m-0 flex-wrap justify-content-around",
                                    staticStyle: { "padding-top": "12px" },
                                    attrs: { role: "group" }
                                  },
                                  [
                                    _c(
                                      "label",
                                      { staticClass: "control-label" },
                                      [_vm._v("Ingrese monto")]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "d-flex flex-wrap justify-content-around"
                                      },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "col-3 col-lg-2 col-md-2  col-xl-2"
                                          },
                                          [
                                            _c(
                                              "button",
                                              {
                                                staticClass:
                                                  "btn btn-outline-primary  m-2",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.setAmountCash(10)
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                                        10\n                                                    "
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "col-3 col-lg-2 col-md-2  col-xl-2"
                                          },
                                          [
                                            _c(
                                              "button",
                                              {
                                                staticClass:
                                                  "btn btn-outline-primary  m-2",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.setAmountCash(20)
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                                        20\n                                                    "
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "col-3  col-lg-2 col-md-2  col-xl-2"
                                          },
                                          [
                                            _c(
                                              "button",
                                              {
                                                staticClass:
                                                  "btn btn-outline-primary  m-2",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.setAmountCash(50)
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                                        50\n                                                    "
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "col-3 col-lg-2 col-md-2  col-xl-2"
                                          },
                                          [
                                            _c(
                                              "button",
                                              {
                                                staticClass:
                                                  "btn btn-outline-primary  m-2",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.setAmountCash(
                                                      100
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                                        100\n                                                    "
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "col-3 col-lg-2 col-md-2  col-xl-2"
                                          },
                                          [
                                            _c(
                                              "button",
                                              {
                                                staticClass:
                                                  "btn btn-outline-primary m-2",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.setAmountCash(
                                                      200
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                                        200\n                                                    "
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      { staticClass: "row col-xl-12 col-12" },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              " col-xl-6 col-md-3 col-lg-3 col-12"
                                          },
                                          [
                                            _c(
                                              "el-input",
                                              {
                                                ref: "enter_amount",
                                                attrs: { id: "inputTotal" },
                                                on: {
                                                  blur: function($event) {
                                                    return _vm.diferen()
                                                  },
                                                  input: function($event) {
                                                    return _vm.enterAmount()
                                                  }
                                                },
                                                model: {
                                                  value: _vm.form.enter_amount,
                                                  callback: function($$v) {
                                                    _vm.$set(
                                                      _vm.form,
                                                      "enter_amount",
                                                      $$v
                                                    )
                                                  },
                                                  expression:
                                                    "\n                                                            form.enter_amount\n                                                        "
                                                }
                                              },
                                              [
                                                _c(
                                                  "template",
                                                  { slot: "prepend" },
                                                  [
                                                    _vm._v(
                                                      _vm._s(
                                                        _vm.currencyTypeActive
                                                          .symbol
                                                      )
                                                    )
                                                  ]
                                                )
                                              ],
                                              2
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "col-xl-2 col-md-2 col-lg-2 col-6"
                                          },
                                          [
                                            _c(
                                              "el-button",
                                              {
                                                attrs: {
                                                  type: "primary",
                                                  disabled: _vm.disabledAddPayment()
                                                },
                                                on: { click: _vm.addPayment }
                                              },
                                              [
                                                _vm.form.payment_condition_id ==
                                                "01"
                                                  ? _c("span", [
                                                      _vm._v(
                                                        "\n                                                            Agregar\n                                                        "
                                                      )
                                                    ])
                                                  : _c("span", [
                                                      _vm._v(
                                                        "\n                                                            Agregar cuota\n                                                        "
                                                      )
                                                    ])
                                              ]
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _vm.form.payment_condition_id == "01"
                                          ? _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "col-xl-3 col-md-3 col-lg-3 col-6 "
                                              },
                                              [
                                                _c(
                                                  "el-button",
                                                  {
                                                    attrs: { type: "success" },
                                                    on: {
                                                      click: function($event) {
                                                        _vm.showSplitPayment = true
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "Dividir\n                                                        pago"
                                                    )
                                                  ]
                                                )
                                              ],
                                              1
                                            )
                                          : _vm._e()
                                      ]
                                    )
                                  ]
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _c("div", { staticClass: " row col-xl-4" }, [
                            _c("div", {
                              staticClass: "col-xl-5",
                              staticStyle: { "margin-bottom": "10px" }
                            })
                          ])
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-xl-3" }),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-xl-2" }),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-xl-3" },
                            [
                              _vm.form.document_type_id == "01" ||
                              _vm.form.document_type_id == "03"
                                ? _c(
                                    "el-select",
                                    {
                                      model: {
                                        value: _vm.form.payment_condition_id,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form,
                                            "payment_condition_id",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "\n                                                form.payment_condition_id\n                                            "
                                      }
                                    },
                                    [
                                      _c("el-option", {
                                        attrs: { value: "01", label: "Contado" }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        attrs: { value: "02", label: "Crédito" }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        attrs: {
                                          value: "03",
                                          label: "Crédito a cuotas"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                : _vm._e()
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-xl-4" }, [
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group d-flex flex-row align-items-end",
                                class: {
                                  "has-danger": _vm.form.difference < 0
                                }
                              },
                              [
                                _c("label", {
                                  staticClass: "control-label fs-4",
                                  class:
                                    "" +
                                    (_vm.form.difference < 0
                                      ? "text-danger"
                                      : ""),
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.form.difference < 0
                                        ? "Faltante: "
                                        : "Vuelto: "
                                    )
                                  }
                                }),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "control-label font-weight-semibold text-center fs-4",
                                    class:
                                      "" +
                                      (_vm.form.difference < 0
                                        ? "text-danger"
                                        : "")
                                  },
                                  [
                                    _vm._v(
                                      "\n                                                " +
                                        _vm._s(_vm.currencyTypeActive.symbol) +
                                        _vm._s(
                                          _vm.form.difference
                                            .toFixed(2)
                                            .replace("-", "")
                                        )
                                    )
                                  ]
                                )
                              ]
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _vm.hasExceedBank
                          ? _c(
                              "div",
                              { staticClass: "d-flex justify-content-center" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "col-12 text-center" },
                                  [
                                    _c("span", { staticClass: "text-danger" }, [
                                      _vm._v(
                                        "\n                                            Recuerde que debido al monto\n                                            deberá hacer esta operación\n                                            mediante Bancarización, y en el\n                                            campo "
                                      ),
                                      _c("br"),
                                      _vm._v(
                                        '\n                                            "Observaciones" ingresar el\n                                            numero de voucher o numero de\n                                            operación.\n                                        '
                                      )
                                    ])
                                  ]
                                )
                              ]
                            )
                          : _vm._e()
                      ])
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.splitPayments.length != 0
                ? _c("div", { staticClass: "row m-1 p-2  bg-light rounded" }, [
                    _c("span", { staticStyle: { "margin-bottom": "5px" } }, [
                      _vm._v("Pagos divididos")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-flex flex-wrap " },
                      _vm._l(_vm.splitPayments, function(payment, idx) {
                        return _c("div", { key: idx, staticClass: "col-2" }, [
                          _vm._v(
                            "\n                        Pago " +
                              _vm._s(idx + 1) +
                              ":\n                        "
                          ),
                          _c("strong", [
                            _vm._v("S/. " + _vm._s(payment.amount))
                          ])
                        ])
                      }),
                      0
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.splitProducts.length != 0
                ? _c("div", { staticClass: "row m-1 p-2  bg-light rounded" }, [
                    _c("span", { staticStyle: { "margin-bottom": "5px" } }, [
                      _vm._v("Pagos divididos por producto")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "d-flex flex-wrap " },
                      _vm._l(_vm.splitProducts, function(payment, idx) {
                        return _c(
                          "div",
                          { key: idx, staticClass: "col-3 m-1" },
                          [
                            payment.products && payment.products.length > 0
                              ? _c("table", { staticClass: "col-12" }, [
                                  _c("thead", [
                                    _c(
                                      "tr",
                                      {
                                        class:
                                          "bg-primary text-white border rounded-top",
                                        attrs: { role: "button" },
                                        on: {
                                          click: function($event) {
                                            return _vm.selectAccount(idx)
                                          }
                                        }
                                      },
                                      [
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            attrs: { colspan: "3" }
                                          },
                                          [
                                            _c("b", [
                                              _vm._v(
                                                " CUENTA " +
                                                  _vm._s(idx + 1) +
                                                  " "
                                              )
                                            ])
                                          ]
                                        )
                                      ]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  payment.products &&
                                  payment.products.length > 0
                                    ? _c(
                                        "tbody",
                                        { staticClass: "border rounded-top " },
                                        [
                                          _vm._l(payment.products, function(
                                            product,
                                            idx
                                          ) {
                                            return _c("tr", { key: idx }, [
                                              _c("td", [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "text-muted text-small"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          product.quantity
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "text-muted text-small"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          product.description
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                {
                                                  staticStyle: {
                                                    "text-align": "right"
                                                  }
                                                },
                                                [
                                                  _c(
                                                    "h3",
                                                    {
                                                      staticClass:
                                                        "text-muted text-small"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            product.price *
                                                              product.quantity
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  )
                                                ]
                                              )
                                            ])
                                          }),
                                          _vm._v(" "),
                                          _c("tr", [
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-muted text-small",
                                                staticStyle: {
                                                  "text-align": "right"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [_c("b", [_vm._v(" Total")])]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-muted text-small"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        S/.\n                                        " +
                                                    _vm._s(
                                                      _vm.totalItemSelected(
                                                        payment.products
                                                      )
                                                    ) +
                                                    "\n                                    "
                                                )
                                              ]
                                            )
                                          ])
                                        ],
                                        2
                                      )
                                    : _c("tbody", { staticClass: "border" }, [
                                        _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              attrs: { colspan: "3" }
                                            },
                                            [
                                              _c(
                                                "h3",
                                                {
                                                  staticClass:
                                                    "text-muted text-small"
                                                },
                                                [
                                                  _vm._v(
                                                    "\n                                            Sin productos seleccionados\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      ])
                                ])
                              : _vm._e()
                          ]
                        )
                      }),
                      0
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "p-3" }, [
                _c(
                  "div",
                  { staticClass: "row" },
                  [
                    _vm.configuration.affectation_optional
                      ? [
                          _c(
                            "div",
                            { staticClass: "col-lg-6 col-md-6 col-12" },
                            [
                              _c("label", [
                                _vm._v(
                                  "\n                                Afectación IGV para el documento\n                            "
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "el-select",
                                {
                                  attrs: { clearable: "", filterable: "" },
                                  model: {
                                    value: _vm.affectation_optional_id,
                                    callback: function($$v) {
                                      _vm.affectation_optional_id = $$v
                                    },
                                    expression: "affectation_optional_id"
                                  }
                                },
                                _vm._l(
                                  _vm.affectation_igv_types.filter(function(
                                    affectation
                                  ) {
                                    return affectation.id == "10"
                                  }),
                                  function(option) {
                                    return _c("el-option", {
                                      key: option.id,
                                      attrs: {
                                        label: option.description,
                                        value: option.id
                                      }
                                    })
                                  }
                                ),
                                1
                              )
                            ],
                            1
                          )
                        ]
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "col-lg-4 col-md-4 col-12 d-flex align-items-end justify-content-center"
                      },
                      [
                        _c("div", [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-block btn-primary",
                              attrs: { disabled: _vm.button_payment },
                              on: { click: _vm.sendPayment }
                            },
                            [
                              _c("i", { staticClass: "fas fa-money-bill-alt" }),
                              _vm._v(
                                "\n                                PAGAR\n                            "
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _c("div", [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-block btn-dark",
                              on: {
                                click: function($event) {
                                  return _vm.back(false)
                                }
                              }
                            },
                            [
                              _c("i", { staticClass: "fa fa-reply" }),
                              _vm._v(" Cerrar\n                            ")
                            ]
                          )
                        ])
                      ]
                    )
                  ],
                  2
                )
              ])
            ]
          ),
          _vm._v(" "),
          _c("multiple-payment-form", {
            attrs: {
              showDialog: _vm.showDialogMultiplePayment,
              payments: _vm.payments
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogMultiplePayment = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogMultiplePayment = $event
              },
              add: _vm.addRow
            }
          }),
          _vm._v(" "),
          _c("card-brands-form", {
            attrs: {
              showDialog: _vm.showDialogNewCardBrand,
              external: true,
              recordId: null
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogNewCardBrand = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewCardBrand = $event
              }
            }
          }),
          _vm._v(" "),
          _c("person-form", {
            attrs: {
              showDialog: _vm.showDialogNewPerson,
              type: "customers",
              input_person: _vm.input_person,
              external: true,
              user_id: _vm.form.user_id,
              document_type_id: _vm.form.document_type_id,
              recordId: _vm.form.customer_id
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              "update:user_id": function($event) {
                return _vm.$set(_vm.form, "user_id", $event)
              },
              add_customer: _vm.add_customer
            }
          }),
          _vm._v(" "),
          _c("show-split-payment-form", {
            attrs: {
              orden_items: _vm.orden_items,
              total: _vm.form.total,
              showSplitPayment: _vm.showSplitPayment
            },
            on: {
              receivePayments: _vm.receivePayments,
              receiveProducts: _vm.receiveProducts,
              "update:showSplitPayment": function($event) {
                _vm.showSplitPayment = $event
              },
              "update:show-split-payment": function($event) {
                _vm.showSplitPayment = $event
              }
            }
          }),
          _vm._v(" "),
          _c("person-college-form", {
            attrs: {
              showDialog: _vm.showCollegePersonDialog,
              extern: true,
              fromPerson: true,
              recordId: _vm.collegePersonId
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showCollegePersonDialog = $event
              },
              "update:show-dialog": function($event) {
                _vm.showCollegePersonDialog = $event
              }
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("list-items", {
        attrs: { showDialog: _vm.showListItems, form: _vm.form },
        on: {
          "update:showDialog": function($event) {
            _vm.showListItems = $event
          },
          "update:show-dialog": function($event) {
            _vm.showListItems = $event
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-385e4f75", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/payment.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("71657b18", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment.vue", function() {
     var newContent = require("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-385e4f75\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./payment.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=153.js.map