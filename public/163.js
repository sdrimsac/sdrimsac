webpackJsonp([163],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a33ad4e8\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a33ad4e8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a33ad4e8", Component.options)
  } else {
    hotAPI.reload("data-v-a33ad4e8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


var PaymentInternet = function PaymentInternet() {
  return __webpack_require__.e/* import() */(136/* duplicate */).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/pos/partials/payment_internet.vue"));
};
/* import CashForm from "../../cash/form.vue";
import CloseCash from "../../cash/closecash.vue";
import OrdenPullApart from "./ordens_pull_apart.vue";
import TableOrdensPending from "./list_pending_ordens.vue";
import ObservationForm from "../../partials/observation_form.vue"; */


var CreateVariationForm = function CreateVariationForm() {
  return __webpack_require__.e/* import() */(206).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/pos/partials/create_variation_form.vue"));
};

var CashForm = function CashForm() {
  return __webpack_require__.e/* import() */(140/* duplicate */).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/cash/form.vue"));
};

var CloseCash = function CloseCash() {
  return __webpack_require__.e/* import() */(134/* duplicate */).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/cash/closecash.vue"));
}; // const OrdenPullApart = () => import("./ordens_pull_apart.vue");
// const TableOrdensPending = () => import("./list_pending_ordens.vue");
// const ObservationForm = () => import("../../partials/observation_form.vue");


var ExpensesIncomes = function ExpensesIncomes() {
  return __webpack_require__.e/* import() */(133/* duplicate */).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/pos/partials/expenses_incomes.vue"));
};

var ShowSeriesProduct = function ShowSeriesProduct() {
  return __webpack_require__.e/* import() */(201).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/pos/partials/show_series_product.vue"));
}; // const ShowLotesProduct = () => import("../partials/show_lotes_product.vue");


var TransfersModal = function TransfersModal() {
  return __webpack_require__.e/* import() */(199).then(__webpack_require__.bind(null, "./modules/Internet/Resources/assets/js/view/pos/partials/transfer_modal.vue"));
};

var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(126/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    PersonForm: PersonForm,
    CreateVariationForm: CreateVariationForm,
    CashForm: CashForm,
    CloseCash: CloseCash,
    PaymentInternet: PaymentInternet,
    // TableOrdensPending,
    // OrdenPullApart,
    // ObservationForm,
    ExpensesIncomes: ExpensesIncomes,
    ShowSeriesProduct: ShowSeriesProduct,
    // ShowLotesProduct,
    TransfersModal: TransfersModal
  },
  props: ["identityDocuments", "company", "customer_variation", "variationShow", "establishments", "itemDefault", "ordensPending", "area_id", "blockCart", "localOrden", "configuration", "ordens", "total2", "clientTableData", "isCreatingOrden", "ordenId", "cash_id", "series"],
  data: function data() {
    var _ref;

    return _ref = {
      zones: [],
      imageSaved: null,
      days: 0,
      pay_date: __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD"),
      paidDate: null,
      oldClient: false,
      showRegister: true,
      techs: [],
      newTech: false,
      showDialogNewPerson: false,
      is_payment: false,
      installMonthly: false,
      item: {},
      limitQty: 0,
      showFormVariation: false,
      showTransfersDialog: false,
      descriptionTemp: null,
      showChangeDescriptionVariation: false,
      variation: false,
      showObservations: false,
      boxOperation: "Abrir",
      showDialogCash: false,
      tags: [],
      showSeries: false,
      current: null,
      showDialogClose: false,
      showPendingOrdens: false,
      ordenLoading: false,
      listApart: false,
      apart: false,
      numberCustomerApart: null,
      ordenInBox: [],
      pin: "",
      totalOrdenItems: 0.0,
      total: 0.0,
      disableSend: false,
      totalOrden: 0.0,
      loading: false,
      commands_fisico: "",
      AllSelected: false,
      showDialogPing: false,
      dialogLocalObservation: false,
      currentLocalOrden: null,
      localObservation: null,
      dialogObservation: false,
      observation: null,
      loadingObservation: false,
      currentOrden: null,
      form_ped: {},
      to_carry: false,
      optionsMenu: [],
      foodDefault: null,
      showExpensesIncomes: false,
      showLotes: false,
      ordenLot: null,
      currentIdx: null,
      currentItem: null,
      currentSeries: [],
      screenWidth: 0,
      printing: false,
      form: {
        address: null,
        address_reference: null,
        name: null,
        telephone: null,
        install: 0
      },
      loading_search: false,
      timer: null,
      image: null,
      currentCustomer: null,
      plans: [],
      concepts: [],
      planVariations: [],
      conceptVariations: [],
      variationId: null,
      concept: {},
      loading_search_item: false,
      variationConceptId: null,
      conceptsSelected: [],
      items: [],
      variationData: {}
    }, _defineProperty(_ref, "showSeries", false), _defineProperty(_ref, "showModalSeries", false), _defineProperty(_ref, "itemsSelected", []), _defineProperty(_ref, "start_date", __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD")), _defineProperty(_ref, "start_date_migration", __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD")), _defineProperty(_ref, "start_end", null), _defineProperty(_ref, "seriesDocument", []), _defineProperty(_ref, "pickerStartOptions", {
      disabledDate: function disabledDate(time) {
        return time < Date.now();
      }
    }), _defineProperty(_ref, "pickerEndOptions", {
      disabledDate: function disabledDate(time) {
        return time.getTime() < Date.now();
      }
    }), _defineProperty(_ref, "data", null), _defineProperty(_ref, "paymentItems", []), _defineProperty(_ref, "serviceItem", null), _defineProperty(_ref, "phone", null), _ref;
  },
  watch: {
    cash_id: function cash_id(newCash, _) {
      this.boxOperation = newCash ? "Cerrar" : "Abrir";
      this.optionsMenu[2].title = [this.boxOperation, " Caja"];
    }
  },
  mounted: function mounted() {
    this.screenWidth = window.innerWidth;
    window.addEventListener("resize", this.handleResize);
    this.foodDefault = this.itemDefault;
    this.boxOperation = this.cash_id ? "Cerrar" : "Abrir";
    this.optionsMenu = [{
      id: 1,
      title: ["Configuración"],
      icon: "fas fa-cogs",
      visible: false
    }, {
      id: 2,
      title: ["Recibir ", "mercaderia"],
      icon: "fas fa-people-carry",
      visible: !this.configuration.college && this.configuration.receive_merchandise
    }, {
      id: 3,
      title: [this.boxOperation, " Caja"],
      icon: "fas fa-cash-register",
      visible: true
    }, {
      id: 7,
      title: ["Ingresos/", "/Gastos"],
      icon: "fas fa-money-bill-wave-alt",
      visible: true
    },
    /* {
        id: 4,
        title: ["Aparcado"],
        icon: "fas fa-cart-arrow-down",
        visible: !this.configuration.college
    }, */
    {
      id: 5,
      title: ["Ordenes"],
      icon: "fas fa-hourglass",
      visible: this.configuration.restaurant && !this.configuration.college
    }];
    var ordens = [];
    var ordensSave = localStorage.ordens;

    if (ordensSave) {
      ordens = JSON.parse(ordensSave);
    }

    this.ordenInBox = ordens;
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      var printing;
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.$eventHub.$on("reloadDataPersons", function (customer_id) {
                _this.reloadDataCustomers(customer_id);
              });

              _context.next = 3;
              return _this.getTables();

            case 3:
              printing = localStorage.getItem("cajaPrint");
              _this.printing = printing == 1;
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

            case 7:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    setStartDate: function setStartDate() {
      if (this.oldClient == false) {
        this.start_date = __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD");
      }
    },
    trigerFunction: function trigerFunction(id) {
      switch (id) {
        case 7:
          if (!this.cash_id) {
            this.$toast.error("Abra una caja");
          } else {
            this.showExpensesIncomes = true;
          }

          break;

        case 2:
          this.showTransfers();
          break;

        case 3:
          if (this.cash_id) {
            this.showDialogClose = true;
          } else {
            this.showDialogCash = true;
          }

          break;

        case 5:
          this.showOrdensPending();
          break;

        case 4:
          if (this.ordenInBox.length > 0) {
            this.listApart = true;
          } else {
            this.$toast.warning("Sin ventas apartacadas.");
          }

          break;

        default:
          //naa
          break;
      }
    },
    showTransfers: function showTransfers() {
      this.showTransfersDialog = true;
    },
    transformMac: function transformMac(mac) {
      mac = mac.replace(/:/g, "");
      var regex = /\b([\w:]+)\b/g;
      var words = [];
      mac.replace(regex, function (_, word) {
        if (/^[a-zA-Z0-9:]+$/.test(word)) {
          words.push(word);
        }
      });
      var formatedMac = words.map(function (word) {
        if (word.length > 2) {
          var chars = word.split("");
          var two = [];

          for (var i = 0; i < chars.length; i += 2) {
            two.push(chars.slice(i, i + 2).join(""));
          }

          return two.join(":");
        } else {
          return word;
        }
      }).join(" ");
      this.form.mac = formatedMac;
    },
    changeImage: function changeImage() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var files, file, formData, reader;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                files = _this2.$refs.file.files;

                if (files.length > 0) {
                  file = files[0];
                  formData = new FormData();
                  formData.append("file", file);

                  try {
                    reader = new FileReader();

                    reader.onload = function (e) {
                      _this2.image = e.target.result;
                    };

                    reader.readAsDataURL(file);
                  } catch (e) {
                    console.log(e);
                  }
                }

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    addAdvance: function addAdvance(advance) {
      this.data.advance = advance;
    },
    calculePrice: function calculePrice() {
      var _this3 = this;

      this.days = 0;

      if (__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).isAfter(this.pay_date)) {
        this.$toast.error("La fecha de inicio no puede ser mayor a la fecha de pago");
        this.pay_date = this.start_date;
        return;
      }

      var pay_date = __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.pay_date);
      var start_date = __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date);

      if (pay_date.diff(start_date, "months") > 0 && pay_date.date() != start_date.date()) {
        this.$toast.error("La diferencia entre la fecha de inicio y la fecha de pago no puede ser mayor a un mes");
        this.pay_date = this.start_date;
        return;
      }

      var days = __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.pay_date).diff(this.start_date, "days");
      var plan = this.plans.find(function (plan) {
        return plan.id == _this3.form.plan_id;
      });

      if (plan) {
        var planVariation = this.planVariations.find(function (variation) {
          return variation.id == _this3.variationId;
        });

        if (planVariation) {
          var price = Number(planVariation.price); //create a conceptPrice for each concept of conceptSelected and get the sum of price

          var conceptPrice = 0;
          this.conceptsSelected.forEach(function (concept) {
            conceptPrice += Number(concept.price);
          });
          var totalPrice = price + conceptPrice;

          if (days != 0 && !isNaN(totalPrice)) {
            totalPrice = totalPrice / 30 * days;
            this.days = days;
          }

          this.form.total = Number(totalPrice);
          this.$forceUpdate();
        }
      }
    },
    cleanForm: function cleanForm() {
      this.image = null;
      this.installMonthly = false;
      this.form = {};
      this.phone = null;
      this.concept = {};
      this.variationId = null;
      this.variationConceptId = null;
      this.itemsSelected = [];
      this.conceptsSelected = [];
      this.start_date = __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD");
      this.start_end = null;
      this.concept.id = null;
      this.oldClient = false;
      this.paidDate = null;
      this.days = 0;
    },
    getRegisters: function getRegisters() {
      this.cleanForm();
      this.$emit("getRecords");
    },
    getTechs: function getTechs() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, techs;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this4.$http.get("/internet/techs");

              case 2:
                response = _context3.sent;
                techs = response.data.techs;
                _this4.techs = techs !== null && techs !== void 0 ? techs : [];

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    reloadDataCustomers: function reloadDataCustomers(id) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, data, _id, _response, customers, _customers, customer;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (!_this5.newTech) {
                  _context4.next = 13;
                  break;
                }

                _context4.next = 3;
                return _this5.$http.get("/internet/create_tech/".concat(id));

              case 3:
                response = _context4.sent;

                if (!(response.status == 200)) {
                  _context4.next = 11;
                  break;
                }

                data = response.data;
                _id = data.id;
                _context4.next = 9;
                return _this5.getTechs();

              case 9:
                _this5.form.tech_id = _id;

                _this5.$forceUpdate();

              case 11:
                _context4.next = 25;
                break;

              case 13:
                _context4.next = 15;
                return _this5.$http.get("/documents/search/customer/".concat(id));

              case 15:
                _response = _context4.sent;
                customers = _response.data.customers;
                _customers = _slicedToArray(customers, 1), customer = _customers[0];
                _this5.form.number = customer.number;
                _this5.form.name = customer.name;
                _this5.phone = customer.phone;
                _this5.form.address = customer.address;
                _this5.form.person_id = customer.id;
                _this5.form.zone_id = customer.client_zone_id;
                _this5.form.identity_document_type_id = customer.identity_document_type_id;

              case 25:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    createTech: function createTech(id) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.next = 2;
                return _this6.$http("internet/create_tech/".concat(id));

              case 2:
                response = _context5.sent;

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    openCreateTechForm: function openCreateTechForm() {
      this.newTech = true;
      this.showDialogNewPerson = true;
    },
    openCreatePersonForm: function openCreatePersonForm() {
      this.newTech = false;
      this.showDialogNewPerson = true;
    },
    deepCopy: function deepCopy(obj) {
      if (obj === null || _typeof(obj) !== "object") {
        return obj;
      }

      var copy;

      if (obj instanceof Array) {
        copy = [];

        for (var i = 0; i < obj.length; i++) {
          copy[i] = this.deepCopy(obj[i]);
        }
      } else {
        copy = {};

        for (var key in obj) {
          if (obj.hasOwnProperty(key)) {
            copy[key] = this.deepCopy(obj[key]);
          }
        }
      }

      return copy;
    },
    initItems: function initItems() {
      var _this7 = this;

      var items = [];

      if (this.form.install && this.serviceItem) {
        var serviceItem = this.deepCopy(this.serviceItem);
        serviceItem.sale_unit_price = this.form.install;
        serviceItem.percentage_igv = 18;
        serviceItem.descriptionInternet = "Instalación";
        items.push(serviceItem);
      }

      if (this.installMonthly) {
        var plan = this.planVariations.find(function (p) {
          return p.id == _this7.variationId;
        });

        if (plan) {
          var generalPlan = this.plans.find(function (p) {
            return p.id == plan.plan_id;
          });

          if (generalPlan) {
            var itemPlan = this.deepCopy(generalPlan.item);
            itemPlan.sale_unit_price = plan.price;
            itemPlan.percentage_igv = 18;
            itemPlan.descriptionInternet = "Plan ".concat(generalPlan.capacity, " - ").concat(plan.description);
            itemPlan.descriptionInternet = "".concat(itemPlan.descriptionInternet, " - ").concat(this.generatePeriod());
            items.push(itemPlan);
          }
        }

        var _iterator = _createForOfIteratorHelper(this.conceptsSelected),
            _step;

        try {
          var _loop = function _loop() {
            var cp = _step.value;

            var generalConcept = _this7.concepts.find(function (c) {
              return c.id == cp.concept_id;
            });

            if (generalConcept) {
              var itemConcept = _this7.deepCopy(generalConcept.item);

              itemConcept.sale_unit_price = cp.price;
              itemConcept.percentage_igv = 18;
              itemConcept.descriptionInternet = "".concat(generalConcept.description, "-  ").concat(cp.description, " -                     \n                        ");
              items.push(itemConcept);
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
      }

      this.paymentItems = items;
    },
    generatePeriod: function generatePeriod() {
      if (__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).format("YYYY-MM-DD") == __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.pay_date).format("YYYY-MM-DD")) {
        return "".concat(__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).format("DD/MM/YYYY"), " - ").concat(__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).add(1, "month").format("DD/MM/YYYY"));
      } else {
        return "".concat(__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).format("DD/MM/YYYY"), " - ").concat(__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.pay_date).format("DD/MM/YYYY"));
      }
    },
    showPayment: function showPayment() {
      this.is_payment = true;
    },
    setSaleNote: function setSaleNote() {
      this.form.document_type_id = "80";
      this.seriesByDocument();
      this.form.serie_id = this.seriesDocument.find(function (s) {
        return s.document_type_id == "80";
      }).id;
    },
    sendRegister: function sendRegister() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var hasError, startDate, payDate, plan_concept, installation;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                hasError = _this8.validate();

                if (!hasError) {
                  _context6.next = 3;
                  break;
                }

                return _context6.abrupt("return");

              case 3:
                if (_this8.form.install == 0 && _this8.installMonthly == false) {
                  _this8.setSaleNote();
                }

                _this8.form.installItems = _this8.itemsSelected;
                _this8.form.concepts = _this8.conceptsSelected;
                _this8.form.plan_variation_id = _this8.variationId;
                _this8.form.plan = _this8.plans.find(function (p) {
                  return p.id == _this8.form.plan_id;
                });
                _this8.form.plan_variation = _this8.planVariations.find(function (p) {
                  return p.id == _this8.variationId;
                });
                _this8.data = _this8.form;

                if (_this8.image) {
                  _this8.data.image = _this8.image;
                }

                _this8.data.date = _this8.start_date;
                _this8.data.phone = _this8.phone;
                _this8.data.end_date = _this8.start_end;
                _this8.data.payMonth = _this8.installMonthly;
                _this8.data.paidDate = _this8.paidDate;
                _this8.data.pay_date = _this8.pay_date;
                _this8.data.oldClient = _this8.oldClient;

                _this8.initItems();

                startDate = __WEBPACK_IMPORTED_MODULE_1_moment___default()(_this8.start_date);
                payDate = __WEBPACK_IMPORTED_MODULE_1_moment___default()(_this8.pay_date);

                if (_this8.start_date != _this8.pay_date) {
                  _this8.observation = "SE REGISTR\xD3 PAGO DEL SERVICIO CON FECHA DE INICIO ".concat(startDate.format("DD/MM/YYYY"), " HASTA LA FECHA ").concat(payDate.format("DD/MM/YYYY"));
                } else {
                  _this8.observation = "SE REGISTR\xD3 PAGO DEL SERVICIO CON FECHA DE INICIO ".concat(startDate.format("DD/MM/YYYY"), " HASTA LA FECHA ").concat(startDate.add(1, "months").format("DD/MM/YYYY"));
                }

                if (_this8.days > 0) {
                  plan_concept = _this8.paymentItems.find(function (p) {
                    return p.descriptionInternet != "Instalación";
                  });
                  installation = _this8.paymentItems.find(function (p) {
                    return p.descriptionInternet == "Instalación";
                  });

                  if (plan_concept.sale_unit_price != _this8.form.total) {
                    plan_concept.sale_unit_price = _this8.form.total;
                  }

                  _this8.paymentItems = [installation, plan_concept];
                }

                _this8.is_payment = true;
                return _context6.abrupt("return");

              case 25:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    updateEndOptions: function updateEndOptions() {
      if (this.start_date) {
        if (!this.oldClient) {
          var startDate = new Date(this.start_date);

          if (startDate.getTime() < new Date().getTime() - 86400000) {
            this.$toast.error("La fecha de inicio no puede ser anterior al día actual");
            this.start_date = __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD");
          }
        }
      }
    },
    validEndDate: function validEndDate(time) {
      return time.getTime();
    },
    updateCashId: function updateCashId(id) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _this9.$emit("update:cash_id", id);

              case 1:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    validate: function validate() {
      var fail = false;

      var errors = _defineProperty({
        person_id: "El cliente debe ser creado",
        identity_document_type_id: "El documento de identidad es obligatorio",
        number: "El número del documento es obligatorio",
        name: "El nombre del cliente es obligatorio",
        type: "El tipo de instalación es obligatorio",
        mac: "La MAC es obligatoria",
        plan_id: "El plan es obligatorio",
        address: "La dirección es obligatoria",
        document_type_id: "El documento a emitir es obligatorio",
        serie_id: "La serie es obligatoria",
        tech_id: "El técnico es obligatorio",
        identifier: "El id es obligatorio",
        supplie: "El suministro eléctrico es obligatorio"
      }, "tech_id", "El técnico es obligatorio");

      if (!this.phone) {
        fail = true;
        this.$toast.error("El teléfono es obligatorio");
      } else {
        if (this.phone.length != 9) {
          fail = true;
          this.$toast.error("El teléfono debe tener 9 dígitos");
        }
      }

      var _iterator2 = _createForOfIteratorHelper(Object.keys(errors).reverse()),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var error = _step2.value;

          if (!this.form[error]) {
            fail = true;
            this.$toast.error(errors[error]);
          }
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }

      if (this.form.mac) {
        var mac = this.form.mac;
        mac = mac.split(":");

        if (mac.length != 6) {
          fail = true;
          this.$toast.error("La MAC debe tener 6 pares de caracteres separados por dos puntos (:)");
        } else {
          for (var i = 0; i < mac.length; i++) {
            if (mac[i].length != 2) {
              fail = true;
              this.$toast.error("La MAC debe tener 6 pares de caracteres separados por dos puntos (:)");
            }
          }
        }
      }

      if (this.form.supplie) {
        if (Number.isNaN(this.form.supplie)) {
          fail = true;
          this.$toast.error("El suministro debe ser numérico");
        }

        if (this.form.supplie.toString().length != 8) {
          fail = true;
          this.$toast.error("El suministro debe tener 8 dígitos");
        }
      }

      if (!this.variationId) {
        fail = true;
        this.$toast.error("El precio del plan es obligatorio");
      }

      if (this.itemsSelected.length == 0) {
        fail = true;
        this.$toast.error("Ingrese el equipo usado para la instalación");
      }

      if (this.start_date != null) {
        var past = __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).isBefore(__WEBPACK_IMPORTED_MODULE_1_moment___default()().set({
          hour: 0,
          minute: 0,
          second: 0,
          millisecond: 0
        })); // if (past) {
        //     fail = true;
        //     this.$toast.error(
        //         "La fecha de inicio no puede ser anterior al día actual"
        //     );
        // }

        if (this.start_end) {
          var startGreater = __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date) > __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_end);

          if (startGreater) {
            fail = true;
            this.$toast.error("La fecha final no puede ser anterior a la fecha de inicio");
          }
        }

        if (this.oldClient) {
          if (!this.paidDate) {
            fail = true;
            this.$toast.error("La fecha de la ultima mensualidad es obligatoria");
          }
        }

        if (this.paidDate && this.oldClient) {
          var _startGreater = __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date) > __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.paidDate);

          if (_startGreater) {
            fail = true;
            this.$toast.error("La fecha de la ultima mensualidad no puede ser anterior a la fecha de inicio");
          }

          if (__WEBPACK_IMPORTED_MODULE_1_moment___default()(this.start_date).date() != __WEBPACK_IMPORTED_MODULE_1_moment___default()(this.paidDate).date()) {
            fail = true;
            this.$toast.error("Coloque los mismos DÍAS para la fecha de inicio y ultima mensualidad");
          }
        }
      } else {
        fail = true;
        this.$toast.error("La fecha de inicio es obligatoria.");
      }

      if (this.pay_date == null) {
        fail = true;
        this.$toast.error("La fecha de pago es obligatoria.");
      } //tipo documento, nombre, document,
      //tipo, mac/id, tipo plan, precio,
      //direccion
      //equipo
      //fecha de inicio
      //documento serie instalacion


      return fail;
    },
    seriesByDocument: function seriesByDocument() {
      var document_type_id = this.form.document_type_id;

      if (document_type_id) {
        this.seriesDocument = this.series.filter(function (s) {
          return s.document_type_id == document_type_id;
        });

        if (this.seriesDocument.length != 0) {
          this.form.serie_id = this.seriesDocument[0].id;
        }
      }
    },
    removeItem: function removeItem(idx) {
      this.itemsSelected.splice(idx, 1);
    },
    removeConcept: function removeConcept(idx) {
      this.conceptsSelected.splice(idx, 1);
      this.calculateTotal();
    },
    addItem: function addItem() {
      var quantity = this.item.quantity;

      if (!quantity) {
        return this.$toast.error("Ingrese una cantidad válida");
      }

      var _this$currentItem = this.currentItem,
          id = _this$currentItem.id,
          description = _this$currentItem.description;
      this.itemsSelected = this.itemsSelected.filter(function (i) {
        return i.id != id;
      });
      this.itemsSelected.push({
        id: id,
        description: description,
        quantity: quantity,
        series: this.currentSeries
      });
      this.showSeries = false;
      this.item = {};
    },
    updateSeries: function updateSeries(idx, series) {
      this.item.quantity = series.length;
      this.currentSeries = series;
    },
    openModalSeries: function openModalSeries() {
      this.showModalSeries = true;
    },
    addVariation: function addVariation(form) {
      var _this10 = this;

      var type = form.type;

      if (type == "plan") {
        var _this$plans$filter = this.plans.filter(function (p) {
          return p.id == _this10.form.plan_id;
        }),
            _this$plans$filter2 = _slicedToArray(_this$plans$filter, 1),
            plan = _this$plans$filter2[0];

        plan.variations = [].concat(_toConsumableArray(plan.variations), [form]);
        this.planVariations = plan.variations;
      } else {
        var _this$concepts$filter = this.concepts.filter(function (p) {
          return p.id == _this10.concept.id;
        }),
            _this$concepts$filter2 = _slicedToArray(_this$concepts$filter, 1),
            concept = _this$concepts$filter2[0];

        concept.variations = [].concat(_toConsumableArray(concept.variations), [form]);
        this.conceptVariations = concept.variations;
      }
    },
    openCreationForm: function openCreationForm(type) {
      this.variationData = {
        type: type,
        typeId: type == "plan" ? this.form.plan_id : this.concept.id
      };
      this.showFormVariation = true;
    },
    searchRemoteItems: function searchRemoteItems(input) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                if (input.length > 2) {
                  if (_this11.timer) {
                    clearTimeout(_this11.timer);
                  }

                  _this11.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
                    var parameters, response;
                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
                      while (1) {
                        switch (_context8.prev = _context8.next) {
                          case 0:
                            _context8.prev = 0;
                            parameters = "input=".concat(input);
                            _this11.loading_search = true;
                            _context8.next = 5;
                            return _this11.$http.get("/documents/data-table/items?".concat(parameters));

                          case 5:
                            response = _context8.sent;
                            _this11.items = response.data;
                            _context8.next = 12;
                            break;

                          case 9:
                            _context8.prev = 9;
                            _context8.t0 = _context8["catch"](0);
                            console.log(_context8.t0);

                          case 12:
                            _context8.prev = 12;
                            _this11.loading_search = false;
                            return _context8.finish(12);

                          case 15:
                          case "end":
                            return _context8.stop();
                        }
                      }
                    }, _callee8, null, [[0, 9, 12, 15]]);
                  })), 250);
                }

              case 1:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    changeItem: function changeItem() {
      var _this12 = this;

      this.currentSeries = [];
      var item = this.items.find(function (i) {
        return i.id == _this12.item.id;
      });
      this.currentItem = item;
      var series_enabled = item.series_enabled;
      this.showSeries = !!series_enabled;
    },
    addConcept: function addConcept() {
      var _this13 = this;

      var _this$conceptVariatio = this.conceptVariations.filter(function (cv) {
        return cv.id == _this13.variationConceptId;
      }),
          _this$conceptVariatio2 = _slicedToArray(_this$conceptVariatio, 1),
          concept = _this$conceptVariatio2[0];

      if (concept) {
        var concept_id = concept.concept_id;

        var _this$concepts$find = this.concepts.find(function (c) {
          return c.id == concept_id;
        }),
            description = _this$concepts$find.description;

        this.conceptsSelected = this.conceptsSelected.filter(function (i) {
          return i.concept_id != concept.id;
        });
        this.conceptsSelected.push(_objectSpread(_objectSpread({}, concept), {}, {
          generalConcept: description
        }));
      }

      this.calculateTotal();
    },
    changeConcept: function changeConcept() {
      var _this14 = this;

      var _this$concepts$filter3 = this.concepts.filter(function (p) {
        return p.id == _this14.concept.id;
      }),
          _this$concepts$filter4 = _slicedToArray(_this$concepts$filter3, 1),
          concept = _this$concepts$filter4[0];

      this.conceptVariations = concept.variations;

      if (this.conceptVariations.length != 0) {
        this.variationConceptId = this.conceptVariations[0].id;
      } else {
        this.variationConceptId = null;
      }
    },
    changePrice: function changePrice() {
      var _this15 = this;

      var _this$plans$filter3 = this.plans.filter(function (p) {
        return p.id == _this15.form.plan_id;
      }),
          _this$plans$filter4 = _slicedToArray(_this$plans$filter3, 1),
          plan = _this$plans$filter4[0];

      this.form.plan_price = plan.default_price;
      this.planVariations = plan.variations;

      if (this.planVariations.length != 0) {
        this.variationId = this.planVariations[0].id;
      } else {
        this.variationId = null;
      }

      this.calculateTotal();
    },
    getTables: function getTables() {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        var response, _response$data, plans, concepts, items, service_item, techs, zones;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                _context10.prev = 0;
                _context10.next = 3;
                return _this16.$http("/internet/tables");

              case 3:
                response = _context10.sent;
                _response$data = response.data, plans = _response$data.plans, concepts = _response$data.concepts, items = _response$data.items, service_item = _response$data.service_item, techs = _response$data.techs, zones = _response$data.zones;
                _this16.zones = zones !== null && zones !== void 0 ? zones : [];
                _this16.plans = plans !== null && plans !== void 0 ? plans : [];
                _this16.concepts = concepts !== null && concepts !== void 0 ? concepts : [];
                _this16.items = items !== null && items !== void 0 ? items : [];
                _this16.techs = techs !== null && techs !== void 0 ? techs : [];
                _this16.serviceItem = service_item;
                _context10.next = 16;
                break;

              case 13:
                _context10.prev = 13;
                _context10.t0 = _context10["catch"](0);
                console.log(_context10.t0);

              case 16:
                _context10.prev = 16;
                _this16.loading = false;
                return _context10.finish(16);

              case 19:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10, null, [[0, 13, 16, 19]]);
      }))();
    },
    searchPerson: function searchPerson() {
      var _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee12() {
        var documentNumber;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                documentNumber = _this17.form.number;

                if (!(documentNumber == null || documentNumber == "")) {
                  _context12.next = 3;
                  break;
                }

                return _context12.abrupt("return");

              case 3:
                // if (documentNumber.length != 8 && documentNumber.length != 11) {
                //     this.$toast.error("Ingrese un documento válido");
                //     return;
                // }
                if (_this17.timer) {
                  clearTimeout(_this17.timer);
                }

                _this17.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee11() {
                  var response, _response$data2, success, data;

                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee11$(_context11) {
                    while (1) {
                      switch (_context11.prev = _context11.next) {
                        case 0:
                          _context11.prev = 0;
                          _this17.currentCustomer = null;
                          _this17.loading_search = true;
                          _context11.next = 5;
                          return _this17.$http("/internet/persons/".concat(documentNumber));

                        case 5:
                          response = _context11.sent;
                          _response$data2 = response.data, success = _response$data2.success, data = _response$data2.data;

                          if (success) {
                            _this17.form.person_id = data.id;
                            _this17.form.name = data.name;
                            _this17.phone = data.telephone;
                            _this17.form.address = data.address;
                            _this17.form.zone_id = data.client_zone_id;
                          } else {
                            _this17.$toast.error("Verifique los datos.");
                          }

                          _context11.next = 13;
                          break;

                        case 10:
                          _context11.prev = 10;
                          _context11.t0 = _context11["catch"](0);

                          _this17.$toast.error("No se pudo obtener los datos");

                        case 13:
                          _context11.prev = 13;
                          _this17.loading_search = false;
                          return _context11.finish(13);

                        case 16:
                        case "end":
                          return _context11.stop();
                      }
                    }
                  }, _callee11, null, [[0, 10, 13, 16]]);
                })), 250);

              case 5:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    handleResize: function handleResize() {
      this.screenWidth = window.innerWidth;

      if (this.screenWidth >= 768) {
        this.showRegister = true;
      }
    },
    justNumber: function justNumber(indexx) {
      this.localOrden[indexx].newSubtotal = this.localOrden[indexx].newSubtotal.replace(/[^0-9.]/g, "");
    },
    close: function close() {
      this.$emit("update:localOrden", []);
    },
    update_price: function update_price(index, sale_unit_price) {
      var localOrden_update = this.localOrden;
      localOrden_update[index].food.sale_unit_price = sale_unit_price;
      this.$emit("update:localOrden", localOrden_update);
      this.calculateTotal();
    },
    printTicket: function printTicket(id) {
      var _this18 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee13() {
        var response, url, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                _context13.prev = 0;
                _context13.next = 3;
                return _this18.$http.get("/restaurant/worker/record/".concat(id));

              case 3:
                response = _context13.sent;
                url = response.data.print;
                config = qz.configs.create(response.data.printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context13.next = 9;
                  break;
                }

                _context13.next = 9;
                return qz.websocket.connect(config);

              case 9:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: url
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this18.$toast.error(e.message);
                }); //this.$toast.success("se esta imprimiendo el comprobante con exito");
                // qz.websocket.disconnect()

                _context13.next = 16;
                break;

              case 13:
                _context13.prev = 13;
                _context13.t0 = _context13["catch"](0);

                _this18.$toast.error(_context13.t0.message);

              case 16:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13, null, [[0, 13]]);
      }))();
    },
    view_orders: function view_orders() {
      $(".style-switcher").animate({
        right: "0"
      }, 300).addClass("active");
    },
    closeDialog: function closeDialog() {
      var ordenId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

      var ordenToAdd = _toConsumableArray(this.localOrden);

      ordenToAdd = ordenToAdd.map(function (o) {
        return {
          status_orden_id: 1,
          food: {
            description: o.food.description,
            price: o.food.price
          },
          observations: o.observation
        };
      }); // let allOrdens = [...ordenToAdd, ...this.ordens];

      this.$emit("updateOrdens", ordenId);
      this.$emit("listtables"); // this.$emit("update:ordens", allOrdens);

      this.$emit("update:localOrden", []);
      this.$eventHub.$emit("reloadData");
      this.totalOrdenItems = 0.0;
      this.total = 0.0;
      this.totalOrden = 0.0;
    },
    clear_command: function clear_command() {
      this.commands_fisico = null;
    },
    checkIsExistSerie: function checkIsExistSerie() {
      var hasError = false;

      var _iterator3 = _createForOfIteratorHelper(this.localOrden),
          _step3;

      try {
        for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
          var ord = _step3.value;
          var series_enabled = ord.food.item.series_enabled;

          if (series_enabled && ord.series.length == 0) {
            hasError = true;
            break;
          }
        }
      } catch (err) {
        _iterator3.e(err);
      } finally {
        _iterator3.f();
      }

      return hasError;
    },
    payOrden: function payOrden() {
      var _this19 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee14() {
        var form_submit;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                if (!_this19.checkIsExistSerie()) {
                  _context14.next = 3;
                  break;
                }

                _this19.$toast.error("Producto sin serie seleccionada");

                return _context14.abrupt("return");

              case 3:
                if (_this19.cash_id) {
                  _context14.next = 6;
                  break;
                }

                _this19.$toast.error("No tiene una caja abierta");

                return _context14.abrupt("return");

              case 6:
                if (!_this19.clientTableData.table) {
                  _context14.next = 12;
                  break;
                }

                if (!(_this19.ordens.length == 0)) {
                  _context14.next = 10;
                  break;
                }

                _this19.$toast.warning("Orden sin productos");

                return _context14.abrupt("return");

              case 10:
                _context14.next = 15;
                break;

              case 12:
                if (!(_this19.localOrden.length == 0 && !_this19.variation)) {
                  _context14.next = 15;
                  break;
                }

                _this19.$toast.warning("Orden sin productos");

                return _context14.abrupt("return");

              case 15:
                _this19.disableSend = true;
                form_submit = {
                  id: null,
                  caja: true,
                  printDocument: _this19.printing,
                  printing: _this19.configuration.print_commands,
                  commands_fisico: _this19.commands_fisico,
                  print_kitchen: _this19.configuration.print_kitchen,
                  to_carry: _this19.to_carry,
                  orden: {
                    table_id: 1,
                    status_orden_id: 1
                  },
                  //enviar las ordenes a cobrar
                  //  items: this.ordens,
                  // items: this.localOrden,
                  pin: null
                };

                if (_this19.clientTableData.table) {
                  form_submit.items = _this19.ordens;
                } else {
                  form_submit.items = _this19.localOrden;
                }

                _this19.loading = true; // const responses = await this.$http.post(
                //     "/restaurant/worker/send-orden",
                //     form_submit
                // );

                _this19.commands_fisico = "";
                _this19.to_carry = false; //    let IdOrdensend = responses.data.id;
                //    if (responses.data.success == true) {

                _this19.loading = false; // this.$toast.success(responses.data.message);

                _this19.disableSend = false; //      document.querySelector("#close_offcanvas").click();
                // } else {
                //     this.loading = false;
                //     this.$toast.error(responses.data.message);
                // }

                if (_this19.variation) {
                  form_submit.variationItems = _this19.foodDefault;
                }

                _this19.loading = false;
                _this19.disableSend = false;

                if (_this19.variation) {
                  _this19.$emit("paymentsOrden", form_submit, _this19.foodDefault);
                } else {
                  _this19.$emit("paymentsOrden", form_submit);
                }

              case 27:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    formatUrlImage: function formatUrlImage(url) {
      if (!url) return;
      var formated = "storage/uploads/items/" + url;
      return "/".concat(formated);
    },
    calculateTotal: function calculateTotal() {
      var _this20 = this;

      var total = 0;
      var plan = this.planVariations.find(function (p) {
        return p.id == _this20.variationId;
      });

      if (plan) {
        total += Number(plan.price);
      }

      var totalConcept = this.conceptsSelected.reduce(function (a, b) {
        return a + Number(b.price);
      }, 0);
      total += totalConcept;
      this.form.total = total;
      this.calculePrice();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a33ad4e8\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.el-input-group__prepend {\r\n    padding-left: 6px !important;\r\n    padding-right: 6px !important;\n}\n.custom_input .el-input__inner {\r\n    padding: 0 5px !important;\n}\n.el-tag + .el-tag {\r\n    margin-left: 10px;\n}\n.button-new-tag {\r\n    margin-left: 10px;\r\n    height: 32px;\r\n    line-height: 30px;\r\n    padding-top: 0;\r\n    padding-bottom: 0;\n}\n.input-new-tag1 {\r\n    width: 70px;\r\n    margin-left: 10px;\r\n    vertical-align: bottom;\n}\n.input-new-tag1 .el-input__inner {\r\n    height: 30px !important;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/Internet/Resources/assets/js/view/pos/partials/modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue"],"names":[],"mappings":";AA6vBA;IACA,6BAAA;IACA,8BAAA;CACA;AAEA;IACA,0BAAA;CACA;AAEA;IACA,kBAAA;CACA;AAEA;IACA,kBAAA;IACA,aAAA;IACA,kBAAA;IACA,eAAA;IACA,kBAAA;CACA;AAEA;IACA,YAAA;IACA,kBAAA;IACA,uBAAA;CACA;AAEA;IACA,wBAAA;CACA","file":"register_form.vue","sourcesContent":["<template>\r\n    <div v-loading=\"ordenLoading\">\r\n        <div>\r\n            <div class=\"d-flex flex-wrap justify-content-between\">\r\n                <div\r\n                    v-for=\"(option, idx) in optionsMenu\"\r\n                    :key=\"idx\"\r\n                    v-show=\"option.visible\"\r\n                >\r\n                    <div\r\n                        v-if=\"option.visible\"\r\n                        @click=\"trigerFunction(option.id)\"\r\n                        class=\"buttons_ \r\n              m-1\r\n              btn btn-light\r\n              rounded\r\n              d-flex\r\n              flex-column\r\n              align-items-center\r\n              justify-content-center\r\n            \"\r\n                    >\r\n                        <div class=\"text-center\" style=\"margin-bottom: 2px\">\r\n                            <p\r\n                                style=\"margin: 0 !important; padding: 0 !important\"\r\n                                v-for=\"(title, idx2) in option.title\"\r\n                                :key=\"idx2\"\r\n                            >\r\n                                <span class=\"buttons_text_\">{{ title }}</span>\r\n                            </p>\r\n                        </div>\r\n                        <div>\r\n                            <label\r\n                                v-if=\"option.id == 4\"\r\n                                style=\"margin-left: 2px\"\r\n                                >{{ ordenInBox.length }}</label\r\n                            >\r\n                            <label\r\n                                v-if=\"option.id == 5\"\r\n                                style=\"margin-left: 2px\"\r\n                                >{{ ordensPending }}</label\r\n                            >\r\n                            <i :class=\"option.icon\"> </i>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"card\">\r\n                <div\r\n                    class=\"bg-primary align-items-center rounded-top\"\r\n                    style=\"padding-top: 12px\"\r\n                ></div>\r\n                <div :class=\"`p-1 bg-primary`\">\r\n                    <div\r\n                        class=\"d-flex justify-content-between col-md-12 mx-1 text-white\"\r\n                    >\r\n                        <span>CREAR REGISTRO</span>\r\n                        <span\r\n                            @click=\"showRegister = !showRegister\"\r\n                            v-if=\"screenWidth < 768\"\r\n                            role=\"button\"\r\n                            class=\"mx-5\"\r\n                        >\r\n                            <i v-if=\"!showRegister\" class=\"fas fa-eye\"></i>\r\n                            <i v-else class=\"fas fa-eye-slash\"></i>\r\n                        </span>\r\n                    </div>\r\n                </div>\r\n\r\n                <div v-show=\"showRegister\" class=\"card-body\">\r\n                    <div class=\"d-flex justify-content-end\">\r\n                        <el-checkbox v-model=\"oldClient\" @change=\"setStartDate\">\r\n                            <h4>Migrar cliente</h4>\r\n                        </el-checkbox>\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <div class=\"col-md-12 mt-2 mb-1\">\r\n                            PERSONAL DE LA INSTALACION\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">Técnico</label>\r\n                            <a\r\n                                @click=\"openCreateTechForm\"\r\n                                href=\"#\"\r\n                                class=\"control-label font-weight-bold text-info\"\r\n                            >\r\n                                [ + Nuevo]</a\r\n                            >\r\n                            <el-select\r\n                                filterable\r\n                                clearable\r\n                                v-model=\"form.tech_id\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in techs\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"data.person.name\"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <div class=\"col-md-12 mt-2 mb-1\">\r\n                            DATOS DEL USUARIO\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">Tipo Documento</label>\r\n                            <el-select v-model=\"form.identity_document_type_id\">\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in identityDocuments\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"data.description\"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"number\" class=\"control-label\"\r\n                                >Documento\r\n                                <a\r\n                                    @click=\"openCreatePersonForm\"\r\n                                    href=\"#\"\r\n                                    class=\"control-label font-weight-bold text-info\"\r\n                                >\r\n                                    [ + Nuevo]</a\r\n                                >\r\n                            </label>\r\n                            <el-input\r\n                                :disabled=\"!form.identity_document_type_id\"\r\n                                class=\"to_left\"\r\n                                style=\"width:100%;\"\r\n                                v-model=\"form.number\"\r\n                                :controls=\"false\"\r\n                            >\r\n                                <el-button\r\n                                    v-if=\"\r\n                                        form.identity_document_type_id == 1 ||\r\n                                            form.identity_document_type_id ==\r\n                                                6 ||\r\n                                            form.identity_document_type_id ==\r\n                                                'F' ||\r\n                                            form.identity_document_type_id ==\r\n                                                'A'\r\n                                    \"\r\n                                    slot=\"append\"\r\n                                    :loading=\"loading_search\"\r\n                                    icon=\"el-icon-search\"\r\n                                    @click.prevent=\"searchPerson\"\r\n                                ></el-button>\r\n                            </el-input>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"x\">Nombre</label>\r\n                            <el-input v-model=\"form.name\"></el-input>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"x\">Celular</label>\r\n                            <el-input v-model=\"phone\"></el-input>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"zone\">Zona</label>\r\n                            <el-select\r\n                                clearable\r\n                                filterable\r\n                                v-model=\"form.zone_id\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in zones\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"data.description\"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div class=\"col-md-12\">\r\n                            <el-divider></el-divider>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <div class=\"col-md-12 mb-2\">\r\n                            DATOS DE LA INSTALACION\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">Tipo</label>\r\n                            <el-select v-model=\"form.type\">\r\n                                <el-option label=\"Fibra\" value=\"fibra\">\r\n                                </el-option>\r\n                                <el-option label=\"Antena\" value=\"antena\">\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label class=\"w-100\" for=\"document type\"\r\n                                >Id Precinto</label\r\n                            >\r\n                            <el-input-number\r\n                                class=\"w-100\"\r\n                                :controls=\"false\"\r\n                                v-model=\"form.identifier\"\r\n                            ></el-input-number>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">MAC</label>\r\n                            <el-input\r\n                                @input=\"transformMac\"\r\n                                v-model=\"form.mac\"\r\n                            ></el-input>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label class=\"w-100\" for=\"document type\"\r\n                                >Suministro eléctrico</label\r\n                            >\r\n                            <el-input-number\r\n                                class=\"w-100\"\r\n                                :controls=\"false\"\r\n                                v-model=\"form.supplie\"\r\n                            ></el-input-number>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">Tipo Plan</label>\r\n                            <el-select\r\n                                v-model=\"form.plan_id\"\r\n                                @change=\"changePrice\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in plans\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"`${data.capacity} MB`\"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">Tarífa del plan</label>\r\n                            <el-select\r\n                                v-model=\"variationId\"\r\n                                @change=\"calculateTotal\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in planVariations\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"\r\n                                        `${data.description} S/.${data.price}`\r\n                                    \"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div class=\"col-md-5\">\r\n                            <label for=\"document type\">Extras/Conceptos</label>\r\n                            <el-select\r\n                                v-model=\"concept.id\"\r\n                                @change=\"changeConcept\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in concepts\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"data.description\"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n\r\n                        <div class=\"col-md-5\">\r\n                            <label for=\"document type\">Tarífa</label>\r\n                            <!-- <a\r\n                                v-if=\"concept.id\"\r\n                                @click=\"openCreationForm('concept')\"\r\n                                href=\"#\"\r\n                                class=\"control-label font-weight-bold text-info\"\r\n                            >\r\n                                [ + Nuevo]</a\r\n                            > -->\r\n                            <el-select v-model=\"variationConceptId\">\r\n                                <el-option\r\n                                    v-for=\"(data, idx) in conceptVariations\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"\r\n                                        `${data.description} S/.${data.price}`\r\n                                    \"\r\n                                    :value=\"data.id\"\r\n                                >\r\n                                </el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div\r\n                            class=\"col-md-2 mt-sm-2  mb-sm-1 d-flex align-items-end\"\r\n                        >\r\n                            <el-button\r\n                                size=\"mini\"\r\n                                type=\"primary\"\r\n                                icon=\"el-icon-plus\"\r\n                                circle\r\n                                @click=\"addConcept\"\r\n                            ></el-button>\r\n                        </div>\r\n                        <div\r\n                            class=\"col-md-12 mt-1 table-responsive\"\r\n                            v-if=\"conceptsSelected.length != 0\"\r\n                        >\r\n                            <table class=\"table  table-striped table-hover\">\r\n                                <thead>\r\n                                    <tr>\r\n                                        <th>#</th>\r\n                                        <th>Extra</th>\r\n                                        <th>Descripción</th>\r\n                                        <th>Total</th>\r\n                                        <th></th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody>\r\n                                    <tr\r\n                                        v-for=\"(concept,\r\n                                        idx) in conceptsSelected\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>{{ idx + 1 }}</td>\r\n                                        <td>\r\n                                            {{ concept.generalConcept }}\r\n                                        </td>\r\n                                        <td>\r\n                                            {{ concept.description }}\r\n                                        </td>\r\n                                        <td>{{ concept.price }}</td>\r\n                                        <td>\r\n                                            <el-button\r\n                                                @click=\"removeConcept(idx)\"\r\n                                                type=\"danger\"\r\n                                                icon=\"el-icon-delete\"\r\n                                                circle\r\n                                            ></el-button>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                        <div class=\"col-md-12\">\r\n                            <label for=\"document type\"\r\n                                >Dirección de instalación</label\r\n                            >\r\n                            <el-input v-model=\"form.address\" key=\"address\">\r\n                            </el-input>\r\n                        </div>\r\n                        <div class=\"col-md-12\">\r\n                            <label for=\"document type\">Referencia*</label>\r\n                            <el-input v-model=\"form.address_reference\">\r\n                            </el-input>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label for=\"document type\">Equipo</label>\r\n                            <el-select\r\n                                class=\"w-100\"\r\n                                v-model=\"item.id\"\r\n                                filterable\r\n                                remote\r\n                                popper-class=\"el-select-customers\"\r\n                                clearable\r\n                                placeholder=\"Nombre o código interno\"\r\n                                :remote-method=\"searchRemoteItems\"\r\n                                :loading=\"loading_search_item\"\r\n                                @change=\"changeItem\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"option in items\"\r\n                                    :key=\"option.id\"\r\n                                    :value=\"option.id\"\r\n                                    :label=\"option.description\"\r\n                                ></el-option>\r\n                            </el-select>\r\n                            <el-button\r\n                                v-if=\"showSeries\"\r\n                                size=\"mini\"\r\n                                type=\"primary\"\r\n                                @click=\"openModalSeries\"\r\n                            >\r\n                                Elegir series\r\n                            </el-button>\r\n                        </div>\r\n                        <div class=\"col-md-4\">\r\n                            <label for=\"document type\">Cantidad</label>\r\n                            <el-input\r\n                                :disabled=\"showSeries\"\r\n                                v-model=\"item.quantity\"\r\n                            >\r\n                            </el-input>\r\n                        </div>\r\n\r\n                        <div\r\n                            :class=\"\r\n                                `col-md-2 d-flex \r\n                        \r\n                        mt-sm-2  mb-sm-1 ${\r\n                            showSeries\r\n                                ? 'align-items-center'\r\n                                : 'align-items-end'\r\n                        }`\r\n                            \"\r\n                        >\r\n                            <el-button\r\n                                size=\"mini\"\r\n                                type=\"primary\"\r\n                                icon=\"el-icon-plus\"\r\n                                circle\r\n                                @click=\"addItem\"\r\n                            ></el-button>\r\n                            <small v-if=\"showSeries\"> </small>\r\n                        </div>\r\n                        <div\r\n                            class=\"col-md-12  mt-1 table-responsive\"\r\n                            v-if=\"itemsSelected.length != 0\"\r\n                        >\r\n                            <table class=\"table  table-striped table-hover\">\r\n                                <thead>\r\n                                    <tr>\r\n                                        <th>#</th>\r\n                                        <th>Descripción</th>\r\n                                        <th>Cantidad</th>\r\n                                        <th></th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody>\r\n                                    <tr\r\n                                        v-for=\"(item, idx) in itemsSelected\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>{{ idx + 1 }}</td>\r\n\r\n                                        <td>\r\n                                            {{ item.description }}\r\n                                            <template\r\n                                                v-if=\"item.series.length != 0\"\r\n                                            >\r\n                                                <div\r\n                                                    v-for=\"serie in item.series\"\r\n                                                    :key=\"serie.id\"\r\n                                                >\r\n                                                    <small>\r\n                                                        {{\r\n                                                            serie.series\r\n                                                        }}</small\r\n                                                    >\r\n                                                </div>\r\n                                            </template>\r\n                                        </td>\r\n                                        <td>{{ item.quantity }}</td>\r\n                                        <td>\r\n                                            <el-button\r\n                                                @click=\"removeItem(idx)\"\r\n                                                type=\"danger\"\r\n                                                icon=\"el-icon-delete\"\r\n                                                circle\r\n                                            ></el-button>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                           \r\n                                <label class=\"w-100\" for=\"date\"\r\n                                    >Fecha de instalación</label\r\n                                >\r\n                                <el-date-picker\r\n                                    class=\"w-100\"\r\n                                    v-model=\"start_date\"\r\n                                    @change=\"updateEndOptions\"\r\n                                    format=\"dd/MM/yyyy\"\r\n                                    value-format=\"yyyy-MM-dd\"\r\n                                ></el-date-picker>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <label class=\"w-100\" for=\"date\"\r\n                                >Fecha de pago</label\r\n                            >\r\n                            <el-date-picker\r\n                                class=\"w-100\"\r\n                                @change=\"calculePrice\"\r\n                                v-model=\"pay_date\"\r\n                                format=\"dd/MM/yyyy\"\r\n                                value-format=\"yyyy-MM-dd\"\r\n                            ></el-date-picker>\r\n                        </div>\r\n                        <div class=\"col-md-6\" v-if=\"oldClient\">\r\n                            <label class=\"w-100\" for=\"date\"\r\n                                >Ultima mensualidad pagada</label\r\n                            >\r\n                            <el-date-picker\r\n                                class=\"w-100\"\r\n                                v-model=\"paidDate\"\r\n                                @change=\"updateEndOptions\"\r\n                                format=\"dd/MM/yyyy\"\r\n                                value-format=\"yyyy-MM-dd\"\r\n                            ></el-date-picker>\r\n                        </div>\r\n                        <div class=\"col-md-6\" v-if=\"!oldClient\">\r\n                            <label class=\"w-100\" for=\"date\"\r\n                                >Fecha de termino</label\r\n                            >\r\n                            <el-date-picker\r\n                                class=\"w-100\"\r\n                                v-model=\"start_end\"\r\n                                format=\"dd/MM/yyyy\"\r\n                                value-format=\"yyyy-MM-dd\"\r\n                            ></el-date-picker>\r\n                        </div>\r\n                        <div class=\"col-md-12\">\r\n                            <el-divider></el-divider>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"row\" v-if=\"form.number\">\r\n                        <div class=\"col-md-12 mb-2\">\r\n                            DATOS DE FACTURACIÓN\r\n                        </div>\r\n                        <div class=\"col-md-4\">\r\n                            <label for=\"doctype\">Documento</label>\r\n                            <el-select\r\n                                @change=\"seriesByDocument\"\r\n                                v-model=\"form.document_type_id\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(d, idx) in [\r\n                                        {\r\n                                            description: 'Factura',\r\n                                            value: '01',\r\n                                            visible:\r\n                                                form.number.length == 11 &&\r\n                                                !oldClient\r\n                                        },\r\n                                        {\r\n                                            description: 'Boleta',\r\n                                            value: '03',\r\n                                            visible:\r\n                                                form.number.length != 11 &&\r\n                                                !oldClient\r\n                                        },\r\n                                        {\r\n                                            description: 'Nota de venta',\r\n                                            value: '80',\r\n                                            visible: true\r\n                                        }\r\n                                    ]\"\r\n                                    :key=\"idx\"\r\n                                    v-show=\"d.visible\"\r\n                                    :label=\"d.description\"\r\n                                    :value=\"d.value\"\r\n                                ></el-option>\r\n                            </el-select>\r\n                        </div>\r\n                        <div class=\"col-md-4\">\r\n                            <label for=\"doctype\">Serie</label>\r\n                            <el-select\r\n                                v-model=\"form.serie_id\"\r\n                                v-if=\"form.document_type_id\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"(d, idx) in seriesDocument\"\r\n                                    :key=\"idx\"\r\n                                    :label=\"d.number\"\r\n                                    :value=\"d.id\"\r\n                                ></el-option>\r\n                            </el-select>\r\n                            <el-input v-else class=\"w-100\" :disabled=\"true\">\r\n                            </el-input>\r\n                        </div>\r\n                        <div class=\"col-md-4\">\r\n                            <label for=\"doctype\">Cobro de instalación</label>\r\n                            <el-input-number\r\n                                class=\"w-100\"\r\n                                :controls=\"false\"\r\n                                v-model=\"form.install\"\r\n                            ></el-input-number>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"row mt-2\">\r\n                        <div\r\n                            class=\"col-12 d-flex flex-column justify-content-center align-items-center mb-2\"\r\n                        >\r\n                            <div\r\n                                class=\"col-12 mb-2 d-flex  justify-content-center \"\r\n                                style=\"max-width:350px;max-height:150px\"\r\n                            >\r\n                                <!-- <img\r\n                                    :src=\"imageSaved\"\r\n                                    alt=\"imagen\"\r\n                                    class=\"img-thumbnail\"\r\n                                /> -->\r\n                                <img\r\n                                    v-if=\"image\"\r\n                                    :src=\"image\"\r\n                                    alt=\"Vista previa de la imagen\"\r\n                                    style=\"max-width: 300px; max-height: 300px;\"\r\n                                />\r\n                            </div>\r\n\r\n                            <div class=\"d-flex\">\r\n                                <el-button\r\n                                    v-if=\"!image\"\r\n                                    class=\"m-2\"\r\n                                    type=\"success\"\r\n                                    @click=\"$refs.file.click()\"\r\n                                >\r\n                                    Subir imagen\r\n                                </el-button>\r\n                                <el-button\r\n                                    v-else\r\n                                    class=\"m-2\"\r\n                                    type=\"danger\"\r\n                                    @click=\"image = null\"\r\n                                >\r\n                                    Eliminar imagen\r\n                                </el-button>\r\n                            </div>\r\n                            <p><em>JPG, PNG, JPEG </em></p>\r\n                            <input\r\n                                accept=\"image/png, image/jpeg, image/jpg\"\r\n                                type=\"file\"\r\n                                @change=\"changeImage\"\r\n                                ref=\"file\"\r\n                                style=\"display: none\"\r\n                            />\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"row mt-2\">\r\n                        <div class=\"col-md-4\">\r\n                            <span class=\"h5\">\r\n                                INSTALACION S/.\r\n                                {{\r\n                                    this.form.install\r\n                                        ? this.form.install.toFixed(2)\r\n                                        : 0.0\r\n                                }}\r\n                            </span>\r\n                            <span\r\n                                class=\"h5\"\r\n                                :class=\"installMonthly ? '' : 'text-danger'\"\r\n                            >\r\n                                MENSUALIDAD S/.\r\n                                {{\r\n                                    this.form.total\r\n                                        ? this.form.total.toFixed(2)\r\n                                        : 0.0\r\n                                }}\r\n                                {{ days != 0 ? \" x \" + days + \" días\" : \"\" }}\r\n                            </span>\r\n                            <br />\r\n\r\n                            <br />\r\n                            <span class=\"h4\">\r\n                                TOTAL S/.\r\n                                <template v-if=\"installMonthly\">\r\n                                    {{\r\n                                        (\r\n                                            Number(\r\n                                                this.form.install\r\n                                                    ? this.form.install\r\n                                                    : 0.0\r\n                                            ) +\r\n                                            Number(\r\n                                                this.form.total\r\n                                                    ? this.form.total\r\n                                                    : 0.0\r\n                                            )\r\n                                        ).toFixed(2)\r\n                                    }}</template\r\n                                >\r\n                                <template v-else>\r\n                                    {{\r\n                                        Number(\r\n                                            this.form.install\r\n                                                ? this.form.install\r\n                                                : 0.0\r\n                                        ).toFixed(2)\r\n                                    }}\r\n                                </template>\r\n                            </span>\r\n                        </div>\r\n                        <div\r\n                            class=\"col-md-8 d-flex justify-content-end align-items-end\"\r\n                        >\r\n                            <div slot=\"footer\" class=\"dialog-footer\">\r\n                                <el-checkbox\r\n                                    v-if=\"!oldClient\"\r\n                                    v-model=\"installMonthly\"\r\n                                    >Cobrar mensualidad</el-checkbox\r\n                                >\r\n                                <el-button @click=\"close\">Cancelar</el-button>\r\n                                <el-button type=\"primary\" @click=\"sendRegister\"\r\n                                    >Registrar</el-button\r\n                                >\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <cash-form\r\n                :showDialog.sync=\"showDialogCash\"\r\n                :recordId=\"cash_id\"\r\n                :fromBox=\"true\"\r\n                @updateCashId=\"updateCashId\"\r\n            ></cash-form>\r\n            <close-cash\r\n                :recordId.sync=\"cash_id\"\r\n                :showDialogClose.sync=\"showDialogClose\"\r\n                :fromBox=\"true\"\r\n                @updateCashId=\"updateCashId\"\r\n            >\r\n            </close-cash>\r\n            <expenses-incomes\r\n                :showDialog.sync=\"showExpensesIncomes\"\r\n                :company=\"company\"\r\n                :cash_id=\"cash_id\"\r\n            >\r\n            </expenses-incomes>\r\n            <!-- <observation-form\r\n            :current=\"current\"\r\n            :observations.sync=\"tags\"\r\n            :showDialog.sync=\"showObservations\"\r\n            @addObservation=\"addObservation\"\r\n        >\r\n        </observation-form> -->\r\n            <show-series-product\r\n                :limitQty=\"limitQty\"\r\n                :idx=\"currentIdx\"\r\n                :item=\"currentItem\"\r\n                :showDialog.sync=\"showModalSeries\"\r\n                :seriesSelected.sync=\"currentSeries\"\r\n                @updateSeries=\"updateSeries\"\r\n            >\r\n            </show-series-product>\r\n        </div>\r\n        <create-variation-form\r\n            :showDialog.sync=\"showFormVariation\"\r\n            :dataVariation=\"variationData\"\r\n            @addVariation=\"addVariation\"\r\n        ></create-variation-form>\r\n        <payment-internet\r\n            :serviceItem=\"serviceItem\"\r\n            :configuration=\"configuration\"\r\n            @getRegisters=\"getRegisters\"\r\n            :paymentItems=\"paymentItems\"\r\n            :data.sync=\"data\"\r\n            :is_payment.sync=\"is_payment\"\r\n            :periodObservation=\"observation\"\r\n            @addAdvance=\"addAdvance\"\r\n        >\r\n        </payment-internet>\r\n        <person-form\r\n            :newTech=\"newTech\"\r\n            :external=\"true\"\r\n            :showDialog.sync=\"showDialogNewPerson\"\r\n        ></person-form>\r\n        <transfers-modal\r\n            :showDialog.sync=\"showTransfersDialog\"\r\n        ></transfers-modal>\r\n    </div>\r\n</template>\r\n<style>\r\n.el-input-group__prepend {\r\n    padding-left: 6px !important;\r\n    padding-right: 6px !important;\r\n}\r\n\r\n.custom_input .el-input__inner {\r\n    padding: 0 5px !important;\r\n}\r\n\r\n.el-tag + .el-tag {\r\n    margin-left: 10px;\r\n}\r\n\r\n.button-new-tag {\r\n    margin-left: 10px;\r\n    height: 32px;\r\n    line-height: 30px;\r\n    padding-top: 0;\r\n    padding-bottom: 0;\r\n}\r\n\r\n.input-new-tag1 {\r\n    width: 70px;\r\n    margin-left: 10px;\r\n    vertical-align: bottom;\r\n}\r\n\r\n.input-new-tag1 .el-input__inner {\r\n    height: 30px !important;\r\n}\r\n</style>\r\n<script>\r\nimport moment from \"moment\";\r\nconst PaymentInternet = () => import(\"./payment_internet.vue\");\r\n/* import CashForm from \"../../cash/form.vue\";\r\nimport CloseCash from \"../../cash/closecash.vue\";\r\nimport OrdenPullApart from \"./ordens_pull_apart.vue\";\r\nimport TableOrdensPending from \"./list_pending_ordens.vue\";\r\nimport ObservationForm from \"../../partials/observation_form.vue\"; */\r\nconst CreateVariationForm = () => import(\"./create_variation_form.vue\");\r\nconst CashForm = () => import(\"../../cash/form.vue\");\r\nconst CloseCash = () => import(\"../../cash/closecash.vue\");\r\n// const OrdenPullApart = () => import(\"./ordens_pull_apart.vue\");\r\n// const TableOrdensPending = () => import(\"./list_pending_ordens.vue\");\r\n// const ObservationForm = () => import(\"../../partials/observation_form.vue\");\r\nconst ExpensesIncomes = () => import(\"../partials/expenses_incomes.vue\");\r\nconst ShowSeriesProduct = () => import(\"../partials/show_series_product.vue\");\r\n// const ShowLotesProduct = () => import(\"../partials/show_lotes_product.vue\");\r\nconst TransfersModal = () => import(\"../partials/transfer_modal.vue\");\r\nconst PersonForm = () =>\r\n    import(\"../../../../../../../../resources/js/views/persons/form.vue\");\r\nexport default {\r\n    components: {\r\n        PersonForm,\r\n        CreateVariationForm,\r\n        CashForm,\r\n        CloseCash,\r\n        PaymentInternet,\r\n        // TableOrdensPending,\r\n        // OrdenPullApart,\r\n        // ObservationForm,\r\n        ExpensesIncomes,\r\n        ShowSeriesProduct,\r\n        // ShowLotesProduct,\r\n        TransfersModal\r\n    },\r\n    props: [\r\n        \"identityDocuments\",\r\n        \"company\",\r\n        \"customer_variation\",\r\n        \"variationShow\",\r\n        \"establishments\",\r\n        \"itemDefault\",\r\n        \"ordensPending\",\r\n        \"area_id\",\r\n        \"blockCart\",\r\n        \"localOrden\",\r\n        \"configuration\",\r\n        \"ordens\",\r\n        \"total2\",\r\n        \"clientTableData\",\r\n        \"isCreatingOrden\",\r\n        \"ordenId\",\r\n        \"cash_id\",\r\n        \"series\"\r\n    ],\r\n\r\n    data() {\r\n        return {\r\n            zones: [],\r\n            imageSaved: null,\r\n            days: 0,\r\n            pay_date: moment().format(\"YYYY-MM-DD\"),\r\n            paidDate: null,\r\n            oldClient: false,\r\n            showRegister: true,\r\n            techs: [],\r\n            newTech: false,\r\n            showDialogNewPerson: false,\r\n            is_payment: false,\r\n            installMonthly: false,\r\n            item: {},\r\n            limitQty: 0,\r\n            showFormVariation: false,\r\n            showTransfersDialog: false,\r\n            descriptionTemp: null,\r\n            showChangeDescriptionVariation: false,\r\n            variation: false,\r\n            showObservations: false,\r\n            boxOperation: \"Abrir\",\r\n            showDialogCash: false,\r\n            tags: [],\r\n            showSeries: false,\r\n            current: null,\r\n            showDialogClose: false,\r\n            showPendingOrdens: false,\r\n            ordenLoading: false,\r\n            listApart: false,\r\n            apart: false,\r\n            numberCustomerApart: null,\r\n            ordenInBox: [],\r\n            pin: \"\",\r\n            totalOrdenItems: 0.0,\r\n            total: 0.0,\r\n            disableSend: false,\r\n            totalOrden: 0.0,\r\n            loading: false,\r\n            commands_fisico: \"\",\r\n            AllSelected: false,\r\n            showDialogPing: false,\r\n            dialogLocalObservation: false,\r\n            currentLocalOrden: null,\r\n            localObservation: null,\r\n            dialogObservation: false,\r\n            observation: null,\r\n            loadingObservation: false,\r\n            currentOrden: null,\r\n            form_ped: {},\r\n            to_carry: false,\r\n            optionsMenu: [],\r\n            foodDefault: null,\r\n            showExpensesIncomes: false,\r\n            showLotes: false,\r\n            ordenLot: null,\r\n            currentIdx: null,\r\n            currentItem: null,\r\n            currentSeries: [],\r\n            screenWidth: 0,\r\n            printing: false,\r\n            form: {\r\n                address: null,\r\n                address_reference: null,\r\n                name: null,\r\n                telephone: null,\r\n                install: 0\r\n            },\r\n            loading_search: false,\r\n            timer: null,\r\n            image: null,\r\n            currentCustomer: null,\r\n            plans: [],\r\n            concepts: [],\r\n            planVariations: [],\r\n            conceptVariations: [],\r\n            variationId: null,\r\n            concept: {},\r\n            loading_search_item: false,\r\n            variationConceptId: null,\r\n            conceptsSelected: [],\r\n            items: [],\r\n            variationData: {},\r\n            showSeries: false,\r\n            showModalSeries: false,\r\n            itemsSelected: [],\r\n            start_date: moment().format(\"YYYY-MM-DD\"),\r\n            start_date_migration: moment().format(\"YYYY-MM-DD\"),\r\n            start_end: null,\r\n            seriesDocument: [],\r\n\r\n            pickerStartOptions: {\r\n                disabledDate(time) {\r\n                    return time < Date.now();\r\n                }\r\n            },\r\n            pickerEndOptions: {\r\n                disabledDate(time) {\r\n                    return time.getTime() < Date.now();\r\n                }\r\n            },\r\n            data: null,\r\n            paymentItems: [],\r\n            serviceItem: null,\r\n            phone: null\r\n        };\r\n    },\r\n\r\n    watch: {\r\n        cash_id(newCash, _) {\r\n            this.boxOperation = newCash ? \"Cerrar\" : \"Abrir\";\r\n            this.optionsMenu[2].title = [this.boxOperation, \" Caja\"];\r\n        }\r\n    },\r\n    mounted() {\r\n        this.screenWidth = window.innerWidth;\r\n        window.addEventListener(\"resize\", this.handleResize);\r\n        this.foodDefault = this.itemDefault;\r\n        this.boxOperation = this.cash_id ? \"Cerrar\" : \"Abrir\";\r\n\r\n        this.optionsMenu = [\r\n            {\r\n                id: 1,\r\n                title: [\"Configuración\"],\r\n                icon: \"fas fa-cogs\",\r\n                visible: false\r\n            },\r\n            {\r\n                id: 2,\r\n                title: [\"Recibir \", \"mercaderia\"],\r\n                icon: \"fas fa-people-carry\",\r\n                visible:\r\n                    !this.configuration.college &&\r\n                    this.configuration.receive_merchandise\r\n            },\r\n            {\r\n                id: 3,\r\n                title: [this.boxOperation, \" Caja\"],\r\n                icon: \"fas fa-cash-register\",\r\n                visible: true\r\n            },\r\n            {\r\n                id: 7,\r\n                title: [\"Ingresos/\", \"/Gastos\"],\r\n                icon: \"fas fa-money-bill-wave-alt\",\r\n                visible: true\r\n            },\r\n            /* {\r\n                id: 4,\r\n                title: [\"Aparcado\"],\r\n                icon: \"fas fa-cart-arrow-down\",\r\n                visible: !this.configuration.college\r\n            }, */\r\n\r\n            {\r\n                id: 5,\r\n                title: [\"Ordenes\"],\r\n                icon: \"fas fa-hourglass\",\r\n                visible:\r\n                    this.configuration.restaurant && !this.configuration.college\r\n            }\r\n        ];\r\n        let ordens = [];\r\n        let ordensSave = localStorage.ordens;\r\n        if (ordensSave) {\r\n            ordens = JSON.parse(ordensSave);\r\n        }\r\n        this.ordenInBox = ordens;\r\n    },\r\n    async created() {\r\n        this.$eventHub.$on(\"reloadDataPersons\", customer_id => {\r\n            this.reloadDataCustomers(customer_id);\r\n        });\r\n        await this.getTables();\r\n        let printing = localStorage.getItem(\"cajaPrint\");\r\n\r\n        this.printing = printing == 1;\r\n        qz.security.setCertificatePromise((resolve, reject) => {\r\n            this.$http\r\n                .get(\"/api/qz/crt/override\", {\r\n                    responseType: \"text\"\r\n                })\r\n                .then(response => {\r\n                    resolve(response.data);\r\n                })\r\n                .catch(error => {\r\n                    reject(error.data);\r\n                });\r\n        });\r\n        qz.security.setSignaturePromise(toSign => {\r\n            return (resolve, reject) => {\r\n                this.$http\r\n                    .post(\"/api/qz/signing\", {\r\n                        request: toSign\r\n                    })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            };\r\n        });\r\n    },\r\n    methods: {\r\n        setStartDate(){\r\n            if(this.oldClient == false){\r\n                this.start_date = moment().format(\"YYYY-MM-DD\");\r\n            }\r\n        },\r\n        trigerFunction(id) {\r\n            switch (id) {\r\n                case 7:\r\n                    if (!this.cash_id) {\r\n                        this.$toast.error(\"Abra una caja\");\r\n                    } else {\r\n                        this.showExpensesIncomes = true;\r\n                    }\r\n                    break;\r\n                case 2:\r\n                    this.showTransfers();\r\n                    break;\r\n                case 3:\r\n                    if (this.cash_id) {\r\n                        this.showDialogClose = true;\r\n                    } else {\r\n                        this.showDialogCash = true;\r\n                    }\r\n                    break;\r\n                case 5:\r\n                    this.showOrdensPending();\r\n                    break;\r\n                case 4:\r\n                    if (this.ordenInBox.length > 0) {\r\n                        this.listApart = true;\r\n                    } else {\r\n                        this.$toast.warning(\"Sin ventas apartacadas.\");\r\n                    }\r\n                    break;\r\n\r\n                default:\r\n                    //naa\r\n                    break;\r\n            }\r\n        },\r\n        showTransfers() {\r\n            this.showTransfersDialog = true;\r\n        },\r\n        transformMac(mac) {\r\n            mac = mac.replace(/:/g, \"\");\r\n            const regex = /\\b([\\w:]+)\\b/g;\r\n            const words = [];\r\n\r\n            mac.replace(regex, (_, word) => {\r\n                if (/^[a-zA-Z0-9:]+$/.test(word)) {\r\n                    words.push(word);\r\n                }\r\n            });\r\n\r\n            const formatedMac = words\r\n                .map(word => {\r\n                    if (word.length > 2) {\r\n                        const chars = word.split(\"\");\r\n                        const two = [];\r\n                        for (let i = 0; i < chars.length; i += 2) {\r\n                            two.push(chars.slice(i, i + 2).join(\"\"));\r\n                        }\r\n                        return two.join(\":\");\r\n                    } else {\r\n                        return word;\r\n                    }\r\n                })\r\n                .join(\" \");\r\n\r\n            this.form.mac = formatedMac;\r\n        },\r\n        async changeImage() {\r\n            let files = this.$refs.file.files;\r\n            if (files.length > 0) {\r\n                let file = files[0];\r\n                const formData = new FormData();\r\n                formData.append(\"file\", file);\r\n                try {\r\n                    let reader = new FileReader();\r\n\r\n                    reader.onload = e => {\r\n                        this.image = e.target.result;\r\n                    };\r\n                    reader.readAsDataURL(file);\r\n                } catch (e) {\r\n                    console.log(e);\r\n                }\r\n            }\r\n        },\r\n        addAdvance(advance) {\r\n            this.data.advance = advance;\r\n        },\r\n        calculePrice() {\r\n            this.days = 0;\r\n            if (moment(this.start_date).isAfter(this.pay_date)) {\r\n                this.$toast.error(\r\n                    \"La fecha de inicio no puede ser mayor a la fecha de pago\"\r\n                );\r\n                this.pay_date = this.start_date;\r\n                return;\r\n            }\r\n\r\n            let pay_date = moment(this.pay_date);\r\n            let start_date = moment(this.start_date);\r\n            if (\r\n                pay_date.diff(start_date, \"months\") > 0 &&\r\n                pay_date.date() != start_date.date()\r\n            ) {\r\n                this.$toast.error(\r\n                    \"La diferencia entre la fecha de inicio y la fecha de pago no puede ser mayor a un mes\"\r\n                );\r\n                this.pay_date = this.start_date;\r\n                return;\r\n            }\r\n            let days = moment(this.pay_date).diff(this.start_date, \"days\");\r\n            let plan = this.plans.find(plan => plan.id == this.form.plan_id);\r\n            if (plan) {\r\n                let planVariation = this.planVariations.find(\r\n                    variation => variation.id == this.variationId\r\n                );\r\n                if (planVariation) {\r\n                    let price = Number(planVariation.price);\r\n                    //create a conceptPrice for each concept of conceptSelected and get the sum of price\r\n                    let conceptPrice = 0;\r\n                    this.conceptsSelected.forEach(concept => {\r\n                        conceptPrice += Number(concept.price);\r\n                    });\r\n                    let totalPrice = price + conceptPrice;\r\n                    if (days != 0 && !isNaN(totalPrice)) {\r\n                        totalPrice = (totalPrice / 30) * days;\r\n                        this.days = days;\r\n                    }\r\n                    this.form.total = Number(totalPrice);\r\n                    this.$forceUpdate();\r\n                }\r\n            }\r\n        },\r\n        cleanForm() {\r\n            this.image = null;\r\n            this.installMonthly = false;\r\n            this.form = {};\r\n            this.phone = null;\r\n            this.concept = {};\r\n            this.variationId = null;\r\n            this.variationConceptId = null;\r\n            this.itemsSelected = [];\r\n            this.conceptsSelected = [];\r\n            this.start_date = moment().format(\"YYYY-MM-DD\");\r\n            this.start_end = null;\r\n            this.concept.id = null;\r\n            this.oldClient = false;\r\n            this.paidDate = null;\r\n            this.days = 0;\r\n        },\r\n        getRegisters() {\r\n            this.cleanForm();\r\n            this.$emit(\"getRecords\");\r\n        },\r\n        async getTechs() {\r\n            const response = await this.$http.get(`/internet/techs`);\r\n\r\n            const { techs } = response.data;\r\n            this.techs = techs ?? [];\r\n        },\r\n        async reloadDataCustomers(id) {\r\n            if (this.newTech) {\r\n                const response = await this.$http.get(\r\n                    `/internet/create_tech/${id}`\r\n                );\r\n                if (response.status == 200) {\r\n                    const { data } = response;\r\n                    const { id } = data;\r\n                    await this.getTechs();\r\n                    this.form.tech_id = id;\r\n                    this.$forceUpdate();\r\n                }\r\n            } else {\r\n                const response = await this.$http.get(\r\n                    `/documents/search/customer/${id}`\r\n                );\r\n                const { customers } = response.data;\r\n                let [customer] = customers;\r\n                this.form.number = customer.number;\r\n                this.form.name = customer.name;\r\n                this.phone = customer.phone;\r\n                this.form.address = customer.address;\r\n                this.form.person_id = customer.id;\r\n                this.form.zone_id = customer.client_zone_id;\r\n                this.form.identity_document_type_id =\r\n                    customer.identity_document_type_id;\r\n            }\r\n        },\r\n        async createTech(id) {\r\n            const response = await this.$http(`internet/create_tech/${id}`);\r\n        },\r\n        openCreateTechForm() {\r\n            this.newTech = true;\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        openCreatePersonForm() {\r\n            this.newTech = false;\r\n            this.showDialogNewPerson = true;\r\n        },\r\n        deepCopy(obj) {\r\n            if (obj === null || typeof obj !== \"object\") {\r\n                return obj;\r\n            }\r\n\r\n            let copy;\r\n\r\n            if (obj instanceof Array) {\r\n                copy = [];\r\n                for (let i = 0; i < obj.length; i++) {\r\n                    copy[i] = this.deepCopy(obj[i]);\r\n                }\r\n            } else {\r\n                copy = {};\r\n                for (let key in obj) {\r\n                    if (obj.hasOwnProperty(key)) {\r\n                        copy[key] = this.deepCopy(obj[key]);\r\n                    }\r\n                }\r\n            }\r\n\r\n            return copy;\r\n        },\r\n        initItems() {\r\n            let items = [];\r\n            if (this.form.install && this.serviceItem) {\r\n                let serviceItem = this.deepCopy(this.serviceItem);\r\n                serviceItem.sale_unit_price = this.form.install;\r\n\r\n                serviceItem.percentage_igv = 18;\r\n                serviceItem.descriptionInternet = \"Instalación\";\r\n\r\n                items.push(serviceItem);\r\n            }\r\n            if (this.installMonthly) {\r\n                let plan = this.planVariations.find(\r\n                    p => p.id == this.variationId\r\n                );\r\n                if (plan) {\r\n                    let generalPlan = this.plans.find(\r\n                        p => p.id == plan.plan_id\r\n                    );\r\n                    if (generalPlan) {\r\n                        let itemPlan = this.deepCopy(generalPlan.item);\r\n                        itemPlan.sale_unit_price = plan.price;\r\n                        itemPlan.percentage_igv = 18;\r\n                        itemPlan.descriptionInternet = `Plan ${generalPlan.capacity} - ${plan.description}`;\r\n                        itemPlan.descriptionInternet = `${\r\n                            itemPlan.descriptionInternet\r\n                        } - ${this.generatePeriod()}`;\r\n                        items.push(itemPlan);\r\n                    }\r\n                }\r\n\r\n                for (let cp of this.conceptsSelected) {\r\n                    let generalConcept = this.concepts.find(\r\n                        c => c.id == cp.concept_id\r\n                    );\r\n\r\n                    if (generalConcept) {\r\n                        let itemConcept = this.deepCopy(generalConcept.item);\r\n                        itemConcept.sale_unit_price = cp.price;\r\n\r\n                        itemConcept.percentage_igv = 18;\r\n                        itemConcept.descriptionInternet = `${generalConcept.description}-  ${cp.description} -                     \r\n                        `;\r\n                        items.push(itemConcept);\r\n                    }\r\n                }\r\n            }\r\n\r\n            this.paymentItems = items;\r\n        },\r\n        generatePeriod() {\r\n            if (\r\n                moment(this.start_date).format(\"YYYY-MM-DD\") ==\r\n                moment(this.pay_date).format(\"YYYY-MM-DD\")\r\n            ) {\r\n                return `${moment(this.start_date).format(\r\n                    \"DD/MM/YYYY\"\r\n                )} - ${moment(this.start_date)\r\n                    .add(1, \"month\")\r\n                    .format(\"DD/MM/YYYY\")}`;\r\n            } else {\r\n                return `${moment(this.start_date).format(\r\n                    \"DD/MM/YYYY\"\r\n                )} - ${moment(this.pay_date).format(\"DD/MM/YYYY\")}`;\r\n            }\r\n        },\r\n        showPayment() {\r\n            this.is_payment = true;\r\n        },\r\n        setSaleNote() {\r\n            this.form.document_type_id = \"80\";\r\n            this.seriesByDocument();\r\n            this.form.serie_id = this.seriesDocument.find(\r\n                s => s.document_type_id == \"80\"\r\n            ).id;\r\n        },\r\n        async sendRegister() {\r\n            let hasError = this.validate();\r\n            if (hasError) return;\r\n\r\n            if (this.form.install == 0 && this.installMonthly == false) {\r\n                this.setSaleNote();\r\n            }\r\n\r\n            this.form.installItems = this.itemsSelected;\r\n            this.form.concepts = this.conceptsSelected;\r\n            this.form.plan_variation_id = this.variationId;\r\n            this.form.plan = this.plans.find(p => p.id == this.form.plan_id);\r\n            this.form.plan_variation = this.planVariations.find(\r\n                p => p.id == this.variationId\r\n            );\r\n            this.data = this.form;\r\n            if (this.image) {\r\n                this.data.image = this.image;\r\n            }\r\n            this.data.date = this.start_date;\r\n            this.data.phone = this.phone;\r\n            this.data.end_date = this.start_end;\r\n            this.data.payMonth = this.installMonthly;\r\n            this.data.paidDate = this.paidDate;\r\n            this.data.pay_date = this.pay_date;\r\n            this.data.oldClient = this.oldClient;\r\n            this.initItems();\r\n            let startDate = moment(this.start_date);\r\n            let payDate = moment(this.pay_date);\r\n            if (this.start_date != this.pay_date) {\r\n                this.observation = `SE REGISTRÓ PAGO DEL SERVICIO CON FECHA DE INICIO ${startDate.format(\r\n                    \"DD/MM/YYYY\"\r\n                )} HASTA LA FECHA ${payDate.format(\"DD/MM/YYYY\")}`;\r\n            } else {\r\n                this.observation = `SE REGISTRÓ PAGO DEL SERVICIO CON FECHA DE INICIO ${startDate.format(\r\n                    \"DD/MM/YYYY\"\r\n                )} HASTA LA FECHA ${startDate\r\n                    .add(1, \"months\")\r\n                    .format(\"DD/MM/YYYY\")}`;\r\n            }\r\n            if (this.days > 0) {\r\n                let plan_concept = this.paymentItems.find(\r\n                    p => p.descriptionInternet != \"Instalación\"\r\n                );\r\n                let installation = this.paymentItems.find(\r\n                    p => p.descriptionInternet == \"Instalación\"\r\n                );\r\n                if (plan_concept.sale_unit_price != this.form.total) {\r\n                    plan_concept.sale_unit_price = this.form.total;\r\n                }\r\n                this.paymentItems = [installation, plan_concept];\r\n            }\r\n            this.is_payment = true;\r\n            return;\r\n        },\r\n        updateEndOptions() {\r\n            if (this.start_date) {\r\n                if(!this.oldClient){\r\n                 let startDate = new Date(this.start_date);\r\n                    if (startDate.getTime() < new Date().getTime() - 86400000) {\r\n                        this.$toast.error(\r\n                            \"La fecha de inicio no puede ser anterior al día actual\"\r\n                        );\r\n                        this.start_date = moment().format(\"YYYY-MM-DD\");\r\n                    }\r\n                }\r\n              \r\n            }\r\n        },\r\n        validEndDate(time) {\r\n            return time.getTime();\r\n        },\r\n        async updateCashId(id) {\r\n            this.$emit(\"update:cash_id\", id);\r\n        },\r\n\r\n        validate() {\r\n            let fail = false;\r\n\r\n            let errors = {\r\n                person_id: \"El cliente debe ser creado\",\r\n                identity_document_type_id:\r\n                    \"El documento de identidad es obligatorio\",\r\n                number: \"El número del documento es obligatorio\",\r\n                name: \"El nombre del cliente es obligatorio\",\r\n                type: \"El tipo de instalación es obligatorio\",\r\n                mac: \"La MAC es obligatoria\",\r\n                plan_id: \"El plan es obligatorio\",\r\n                address: \"La dirección es obligatoria\",\r\n                document_type_id: \"El documento a emitir es obligatorio\",\r\n                serie_id: \"La serie es obligatoria\",\r\n                tech_id: \"El técnico es obligatorio\",\r\n                identifier: \"El id es obligatorio\",\r\n                supplie: \"El suministro eléctrico es obligatorio\",\r\n                tech_id: \"El técnico es obligatorio\"\r\n            };\r\n            if (!this.phone) {\r\n                fail = true;\r\n                this.$toast.error(\"El teléfono es obligatorio\");\r\n            } else {\r\n                if (this.phone.length != 9) {\r\n                    fail = true;\r\n                    this.$toast.error(\"El teléfono debe tener 9 dígitos\");\r\n                }\r\n            }\r\n            for (let error of Object.keys(errors).reverse()) {\r\n                if (!this.form[error]) {\r\n                    fail = true;\r\n                    this.$toast.error(errors[error]);\r\n                }\r\n            }\r\n            if (this.form.mac) {\r\n                let mac = this.form.mac;\r\n                mac = mac.split(\":\");\r\n                if (mac.length != 6) {\r\n                    fail = true;\r\n                    this.$toast.error(\r\n                        \"La MAC debe tener 6 pares de caracteres separados por dos puntos (:)\"\r\n                    );\r\n                } else {\r\n                    for (let i = 0; i < mac.length; i++) {\r\n                        if (mac[i].length != 2) {\r\n                            fail = true;\r\n                            this.$toast.error(\r\n                                \"La MAC debe tener 6 pares de caracteres separados por dos puntos (:)\"\r\n                            );\r\n                        }\r\n                    }\r\n                }\r\n            }\r\n            if (this.form.supplie) {\r\n                if (Number.isNaN(this.form.supplie)) {\r\n                    fail = true;\r\n                    this.$toast.error(\"El suministro debe ser numérico\");\r\n                }\r\n\r\n                if (this.form.supplie.toString().length != 8) {\r\n                    fail = true;\r\n                    this.$toast.error(\"El suministro debe tener 8 dígitos\");\r\n                }\r\n            }\r\n            if (!this.variationId) {\r\n                fail = true;\r\n                this.$toast.error(\"El precio del plan es obligatorio\");\r\n            }\r\n\r\n            if (this.itemsSelected.length == 0) {\r\n                fail = true;\r\n                this.$toast.error(\r\n                    \"Ingrese el equipo usado para la instalación\"\r\n                );\r\n            }\r\n            if (this.start_date != null) {\r\n                let past = moment(this.start_date).isBefore(\r\n                    moment().set({\r\n                        hour: 0,\r\n                        minute: 0,\r\n                        second: 0,\r\n                        millisecond: 0\r\n                    })\r\n                );\r\n                // if (past) {\r\n                //     fail = true;\r\n                //     this.$toast.error(\r\n                //         \"La fecha de inicio no puede ser anterior al día actual\"\r\n                //     );\r\n                // }\r\n                if (this.start_end) {\r\n                    let startGreater =\r\n                        moment(this.start_date) > moment(this.start_end);\r\n\r\n                    if (startGreater) {\r\n                        fail = true;\r\n                        this.$toast.error(\r\n                            \"La fecha final no puede ser anterior a la fecha de inicio\"\r\n                        );\r\n                    }\r\n                }\r\n                if (this.oldClient) {\r\n                    if (!this.paidDate) {\r\n                        fail = true;\r\n                        this.$toast.error(\r\n                            \"La fecha de la ultima mensualidad es obligatoria\"\r\n                        );\r\n                    }\r\n                }\r\n                if (this.paidDate && this.oldClient) {\r\n                    let startGreater =\r\n                        moment(this.start_date) > moment(this.paidDate);\r\n\r\n                    if (startGreater) {\r\n                        fail = true;\r\n                        this.$toast.error(\r\n                            \"La fecha de la ultima mensualidad no puede ser anterior a la fecha de inicio\"\r\n                        );\r\n                    }\r\n\r\n                    if (\r\n                        moment(this.start_date).date() !=\r\n                        moment(this.paidDate).date()\r\n                    ) {\r\n                        fail = true;\r\n                        this.$toast.error(\r\n                            \"Coloque los mismos DÍAS para la fecha de inicio y ultima mensualidad\"\r\n                        );\r\n                    }\r\n                }\r\n            } else {\r\n                fail = true;\r\n                this.$toast.error(\"La fecha de inicio es obligatoria.\");\r\n            }\r\n            if (this.pay_date == null) {\r\n                fail = true;\r\n                this.$toast.error(\"La fecha de pago es obligatoria.\");\r\n            }\r\n            //tipo documento, nombre, document,\r\n            //tipo, mac/id, tipo plan, precio,\r\n            //direccion\r\n            //equipo\r\n            //fecha de inicio\r\n            //documento serie instalacion\r\n\r\n            return fail;\r\n        },\r\n        seriesByDocument() {\r\n            let { document_type_id } = this.form;\r\n            if (document_type_id) {\r\n                this.seriesDocument = this.series.filter(\r\n                    s => s.document_type_id == document_type_id\r\n                );\r\n                if (this.seriesDocument.length != 0) {\r\n                    this.form.serie_id = this.seriesDocument[0].id;\r\n                }\r\n            }\r\n        },\r\n        removeItem(idx) {\r\n            this.itemsSelected.splice(idx, 1);\r\n        },\r\n        removeConcept(idx) {\r\n            this.conceptsSelected.splice(idx, 1);\r\n            this.calculateTotal();\r\n        },\r\n        addItem() {\r\n            let { quantity } = this.item;\r\n            if (!quantity) {\r\n                return this.$toast.error(\"Ingrese una cantidad válida\");\r\n            }\r\n            let { id, description } = this.currentItem;\r\n            this.itemsSelected = this.itemsSelected.filter(i => i.id != id);\r\n            this.itemsSelected.push({\r\n                id,\r\n                description,\r\n                quantity,\r\n                series: this.currentSeries\r\n            });\r\n            this.showSeries = false;\r\n            this.item = {};\r\n        },\r\n        updateSeries(idx, series) {\r\n            this.item.quantity = series.length;\r\n            this.currentSeries = series;\r\n        },\r\n        openModalSeries() {\r\n            this.showModalSeries = true;\r\n        },\r\n        addVariation(form) {\r\n            let { type } = form;\r\n            if (type == \"plan\") {\r\n                let [plan] = this.plans.filter(p => p.id == this.form.plan_id);\r\n                plan.variations = [...plan.variations, form];\r\n                this.planVariations = plan.variations;\r\n            } else {\r\n                let [concept] = this.concepts.filter(\r\n                    p => p.id == this.concept.id\r\n                );\r\n                concept.variations = [...concept.variations, form];\r\n                this.conceptVariations = concept.variations;\r\n            }\r\n        },\r\n        openCreationForm(type) {\r\n            this.variationData = {\r\n                type,\r\n                typeId: type == \"plan\" ? this.form.plan_id : this.concept.id\r\n            };\r\n            this.showFormVariation = true;\r\n        },\r\n        async searchRemoteItems(input) {\r\n            if (input.length > 2) {\r\n                if (this.timer) {\r\n                    clearTimeout(this.timer);\r\n                }\r\n                this.timer = setTimeout(async () => {\r\n                    try {\r\n                        let parameters = `input=${input}`;\r\n                        this.loading_search = true;\r\n                        const response = await this.$http.get(\r\n                            `/documents/data-table/items?${parameters}`\r\n                        );\r\n\r\n                        this.items = response.data;\r\n                    } catch (e) {\r\n                        console.log(e);\r\n                    } finally {\r\n                        this.loading_search = false;\r\n                    }\r\n                }, 250);\r\n            }\r\n        },\r\n        changeItem() {\r\n            this.currentSeries = [];\r\n            let item = this.items.find(i => i.id == this.item.id);\r\n            this.currentItem = item;\r\n            let { series_enabled } = item;\r\n            this.showSeries = !!series_enabled;\r\n        },\r\n        addConcept() {\r\n            let [concept] = this.conceptVariations.filter(\r\n                cv => cv.id == this.variationConceptId\r\n            );\r\n\r\n            if (concept) {\r\n                let { concept_id } = concept;\r\n                let { description } = this.concepts.find(\r\n                    c => c.id == concept_id\r\n                );\r\n                this.conceptsSelected = this.conceptsSelected.filter(\r\n                    i => i.concept_id != concept.id\r\n                );\r\n                this.conceptsSelected.push({\r\n                    ...concept,\r\n                    generalConcept: description\r\n                });\r\n            }\r\n            this.calculateTotal();\r\n        },\r\n        changeConcept() {\r\n            let [concept] = this.concepts.filter(p => p.id == this.concept.id);\r\n\r\n            this.conceptVariations = concept.variations;\r\n\r\n            if (this.conceptVariations.length != 0) {\r\n                this.variationConceptId = this.conceptVariations[0].id;\r\n            } else {\r\n                this.variationConceptId = null;\r\n            }\r\n        },\r\n        changePrice() {\r\n            let [plan] = this.plans.filter(p => p.id == this.form.plan_id);\r\n\r\n            this.form.plan_price = plan.default_price;\r\n            this.planVariations = plan.variations;\r\n\r\n            if (this.planVariations.length != 0) {\r\n                this.variationId = this.planVariations[0].id;\r\n            } else {\r\n                this.variationId = null;\r\n            }\r\n            this.calculateTotal();\r\n        },\r\n        async getTables() {\r\n            try {\r\n                const response = await this.$http(\"/internet/tables\");\r\n                const {\r\n                    plans,\r\n                    concepts,\r\n                    items,\r\n                    service_item,\r\n                    techs,\r\n                    zones\r\n                } = response.data;\r\n                this.zones = zones ?? [];\r\n                this.plans = plans ?? [];\r\n                this.concepts = concepts ?? [];\r\n                this.items = items ?? [];\r\n                this.techs = techs ?? [];\r\n                this.serviceItem = service_item;\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async searchPerson() {\r\n            let documentNumber = this.form.number;\r\n\r\n            if (documentNumber == null || documentNumber == \"\") return;\r\n            // if (documentNumber.length != 8 && documentNumber.length != 11) {\r\n            //     this.$toast.error(\"Ingrese un documento válido\");\r\n            //     return;\r\n            // }\r\n            if (this.timer) {\r\n                clearTimeout(this.timer);\r\n            }\r\n            this.timer = setTimeout(async () => {\r\n                try {\r\n                    this.currentCustomer = null;\r\n                    this.loading_search = true;\r\n                    const response = await this.$http(\r\n                        `/internet/persons/${documentNumber}`\r\n                    );\r\n                    const { success, data } = response.data;\r\n                    if (success) {\r\n                        this.form.person_id = data.id;\r\n                        this.form.name = data.name;\r\n                        this.phone = data.telephone;\r\n                        this.form.address = data.address;\r\n                        this.form.zone_id = data.client_zone_id;\r\n                    } else {\r\n                        this.$toast.error(\"Verifique los datos.\");\r\n                    }\r\n                } catch (e) {\r\n                    this.$toast.error(\"No se pudo obtener los datos\");\r\n                } finally {\r\n                    this.loading_search = false;\r\n                }\r\n            }, 250);\r\n        },\r\n\r\n        handleResize() {\r\n            this.screenWidth = window.innerWidth;\r\n            if (this.screenWidth >= 768) {\r\n                this.showRegister = true;\r\n            }\r\n        },\r\n\r\n        justNumber(indexx) {\r\n            this.localOrden[indexx].newSubtotal = this.localOrden[\r\n                indexx\r\n            ].newSubtotal.replace(/[^0-9.]/g, \"\");\r\n        },\r\n\r\n        close() {\r\n            this.$emit(\"update:localOrden\", []);\r\n        },\r\n        update_price(index, sale_unit_price) {\r\n            let localOrden_update = this.localOrden;\r\n            localOrden_update[index].food.sale_unit_price = sale_unit_price;\r\n            this.$emit(\"update:localOrden\", localOrden_update);\r\n            this.calculateTotal();\r\n        },\r\n\r\n        async printTicket(id) {\r\n            try {\r\n                const response = await this.$http.get(\r\n                    `/restaurant/worker/record/${id}`\r\n                );\r\n                let url = response.data.print;\r\n\r\n                let config = qz.configs.create(response.data.printer, {\r\n                    scaleContent: false\r\n                });\r\n                if (!qz.websocket.isActive()) {\r\n                    await qz.websocket.connect(config);\r\n                }\r\n                let data = [\r\n                    {\r\n                        type: \"pdf\",\r\n                        format: \"file\",\r\n                        data: url\r\n                    }\r\n                ];\r\n                qz.print(config, data).catch(e => {\r\n                    this.$toast.error(e.message);\r\n                });\r\n\r\n                //this.$toast.success(\"se esta imprimiendo el comprobante con exito\");\r\n                // qz.websocket.disconnect()\r\n            } catch (e) {\r\n                this.$toast.error(e.message);\r\n            }\r\n        },\r\n\r\n        view_orders() {\r\n            $(\".style-switcher\")\r\n                .animate(\r\n                    {\r\n                        right: \"0\"\r\n                    },\r\n                    300\r\n                )\r\n                .addClass(\"active\");\r\n        },\r\n\r\n        closeDialog(ordenId = null) {\r\n            let ordenToAdd = [...this.localOrden];\r\n            ordenToAdd = ordenToAdd.map(o => ({\r\n                status_orden_id: 1,\r\n                food: {\r\n                    description: o.food.description,\r\n                    price: o.food.price\r\n                },\r\n                observations: o.observation\r\n            }));\r\n            // let allOrdens = [...ordenToAdd, ...this.ordens];\r\n            this.$emit(\"updateOrdens\", ordenId);\r\n            this.$emit(\"listtables\");\r\n            // this.$emit(\"update:ordens\", allOrdens);\r\n            this.$emit(\"update:localOrden\", []);\r\n            this.$eventHub.$emit(\"reloadData\");\r\n            this.totalOrdenItems = 0.0;\r\n            this.total = 0.0;\r\n            this.totalOrden = 0.0;\r\n        },\r\n        clear_command() {\r\n            this.commands_fisico = null;\r\n        },\r\n        checkIsExistSerie() {\r\n            let hasError = false;\r\n            for (let ord of this.localOrden) {\r\n                let { series_enabled } = ord.food.item;\r\n\r\n                if (series_enabled && ord.series.length == 0) {\r\n                    hasError = true;\r\n                    break;\r\n                }\r\n            }\r\n            return hasError;\r\n        },\r\n        async payOrden() {\r\n            if (this.checkIsExistSerie()) {\r\n                this.$toast.error(\"Producto sin serie seleccionada\");\r\n                return;\r\n            }\r\n            if (!this.cash_id) {\r\n                this.$toast.error(\"No tiene una caja abierta\");\r\n                return;\r\n            }\r\n            if (this.clientTableData.table) {\r\n                if (this.ordens.length == 0) {\r\n                    this.$toast.warning(\"Orden sin productos\");\r\n                    return;\r\n                }\r\n            } else {\r\n                if (this.localOrden.length == 0 && !this.variation) {\r\n                    this.$toast.warning(\"Orden sin productos\");\r\n                    return;\r\n                }\r\n            }\r\n\r\n            this.disableSend = true;\r\n            let form_submit = {\r\n                id: null,\r\n                caja: true,\r\n                printDocument: this.printing,\r\n                printing: this.configuration.print_commands,\r\n                commands_fisico: this.commands_fisico,\r\n                print_kitchen: this.configuration.print_kitchen,\r\n                to_carry: this.to_carry,\r\n                orden: {\r\n                    table_id: 1,\r\n                    status_orden_id: 1\r\n                },\r\n                //enviar las ordenes a cobrar\r\n                //  items: this.ordens,\r\n                // items: this.localOrden,\r\n                pin: null\r\n            };\r\n            if (this.clientTableData.table) {\r\n                form_submit.items = this.ordens;\r\n            } else {\r\n                form_submit.items = this.localOrden;\r\n            }\r\n            this.loading = true;\r\n            // const responses = await this.$http.post(\r\n            //     \"/restaurant/worker/send-orden\",\r\n            //     form_submit\r\n            // );\r\n\r\n            this.commands_fisico = \"\";\r\n            this.to_carry = false;\r\n            //    let IdOrdensend = responses.data.id;\r\n            //    if (responses.data.success == true) {\r\n\r\n            this.loading = false;\r\n            // this.$toast.success(responses.data.message);\r\n            this.disableSend = false;\r\n            //      document.querySelector(\"#close_offcanvas\").click();\r\n            // } else {\r\n            //     this.loading = false;\r\n            //     this.$toast.error(responses.data.message);\r\n            // }\r\n            if (this.variation) {\r\n                form_submit.variationItems = this.foodDefault;\r\n            }\r\n            this.loading = false;\r\n            this.disableSend = false;\r\n            if (this.variation) {\r\n                this.$emit(\"paymentsOrden\", form_submit, this.foodDefault);\r\n            } else {\r\n                this.$emit(\"paymentsOrden\", form_submit);\r\n            }\r\n        },\r\n        formatUrlImage(url) {\r\n            if (!url) return;\r\n            let formated = \"storage/uploads/items/\" + url;\r\n            return `/${formated}`;\r\n        },\r\n\r\n        calculateTotal() {\r\n            let total = 0;\r\n            let plan = this.planVariations.find(p => p.id == this.variationId);\r\n            if (plan) {\r\n                total += Number(plan.price);\r\n            }\r\n\r\n            let totalConcept = this.conceptsSelected.reduce(\r\n                (a, b) => a + Number(b.price),\r\n                0\r\n            );\r\n\r\n            total += totalConcept;\r\n\r\n            this.form.total = total;\r\n            this.calculePrice();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-a33ad4e8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.ordenLoading,
          expression: "ordenLoading"
        }
      ]
    },
    [
      _c(
        "div",
        [
          _c(
            "div",
            { staticClass: "d-flex flex-wrap justify-content-between" },
            _vm._l(_vm.optionsMenu, function(option, idx) {
              return _c(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: option.visible,
                      expression: "option.visible"
                    }
                  ],
                  key: idx
                },
                [
                  option.visible
                    ? _c(
                        "div",
                        {
                          staticClass:
                            "buttons_ \n          m-1\n          btn btn-light\n          rounded\n          d-flex\n          flex-column\n          align-items-center\n          justify-content-center\n        ",
                          on: {
                            click: function($event) {
                              return _vm.trigerFunction(option.id)
                            }
                          }
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass: "text-center",
                              staticStyle: { "margin-bottom": "2px" }
                            },
                            _vm._l(option.title, function(title, idx2) {
                              return _c(
                                "p",
                                {
                                  key: idx2,
                                  staticStyle: {
                                    margin: "0 !important",
                                    padding: "0 !important"
                                  }
                                },
                                [
                                  _c("span", { staticClass: "buttons_text_" }, [
                                    _vm._v(_vm._s(title))
                                  ])
                                ]
                              )
                            }),
                            0
                          ),
                          _vm._v(" "),
                          _c("div", [
                            option.id == 4
                              ? _c(
                                  "label",
                                  { staticStyle: { "margin-left": "2px" } },
                                  [_vm._v(_vm._s(_vm.ordenInBox.length))]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            option.id == 5
                              ? _c(
                                  "label",
                                  { staticStyle: { "margin-left": "2px" } },
                                  [_vm._v(_vm._s(_vm.ordensPending))]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _c("i", { class: option.icon })
                          ])
                        ]
                      )
                    : _vm._e()
                ]
              )
            }),
            0
          ),
          _vm._v(" "),
          _c("div", { staticClass: "card" }, [
            _c("div", {
              staticClass: "bg-primary align-items-center rounded-top",
              staticStyle: { "padding-top": "12px" }
            }),
            _vm._v(" "),
            _c("div", { class: "p-1 bg-primary" }, [
              _c(
                "div",
                {
                  staticClass:
                    "d-flex justify-content-between col-md-12 mx-1 text-white"
                },
                [
                  _c("span", [_vm._v("CREAR REGISTRO")]),
                  _vm._v(" "),
                  _vm.screenWidth < 768
                    ? _c(
                        "span",
                        {
                          staticClass: "mx-5",
                          attrs: { role: "button" },
                          on: {
                            click: function($event) {
                              _vm.showRegister = !_vm.showRegister
                            }
                          }
                        },
                        [
                          !_vm.showRegister
                            ? _c("i", { staticClass: "fas fa-eye" })
                            : _c("i", { staticClass: "fas fa-eye-slash" })
                        ]
                      )
                    : _vm._e()
                ]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.showRegister,
                    expression: "showRegister"
                  }
                ],
                staticClass: "card-body"
              },
              [
                _c(
                  "div",
                  { staticClass: "d-flex justify-content-end" },
                  [
                    _c(
                      "el-checkbox",
                      {
                        on: { change: _vm.setStartDate },
                        model: {
                          value: _vm.oldClient,
                          callback: function($$v) {
                            _vm.oldClient = $$v
                          },
                          expression: "oldClient"
                        }
                      },
                      [_c("h4", [_vm._v("Migrar cliente")])]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-md-12 mt-2 mb-1" }, [
                    _vm._v(
                      "\n                        PERSONAL DE LA INSTALACION\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Técnico")
                      ]),
                      _vm._v(" "),
                      _c(
                        "a",
                        {
                          staticClass:
                            "control-label font-weight-bold text-info",
                          attrs: { href: "#" },
                          on: { click: _vm.openCreateTechForm }
                        },
                        [_vm._v("\n                            [ + Nuevo]")]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { filterable: "", clearable: "" },
                          model: {
                            value: _vm.form.tech_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "tech_id", $$v)
                            },
                            expression: "form.tech_id"
                          }
                        },
                        _vm._l(_vm.techs, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: { label: data.person.name, value: data.id }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-md-12 mt-2 mb-1" }, [
                    _vm._v(
                      "\n                        DATOS DEL USUARIO\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Tipo Documento")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          model: {
                            value: _vm.form.identity_document_type_id,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.form,
                                "identity_document_type_id",
                                $$v
                              )
                            },
                            expression: "form.identity_document_type_id"
                          }
                        },
                        _vm._l(_vm.identityDocuments, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: { label: data.description, value: data.id }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c(
                        "label",
                        {
                          staticClass: "control-label",
                          attrs: { for: "number" }
                        },
                        [
                          _vm._v("Documento\n                            "),
                          _c(
                            "a",
                            {
                              staticClass:
                                "control-label font-weight-bold text-info",
                              attrs: { href: "#" },
                              on: { click: _vm.openCreatePersonForm }
                            },
                            [
                              _vm._v(
                                "\n                                [ + Nuevo]"
                              )
                            ]
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          staticClass: "to_left",
                          staticStyle: { width: "100%" },
                          attrs: {
                            disabled: !_vm.form.identity_document_type_id,
                            controls: false
                          },
                          model: {
                            value: _vm.form.number,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "number", $$v)
                            },
                            expression: "form.number"
                          }
                        },
                        [
                          _vm.form.identity_document_type_id == 1 ||
                          _vm.form.identity_document_type_id == 6 ||
                          _vm.form.identity_document_type_id == "F" ||
                          _vm.form.identity_document_type_id == "A"
                            ? _c("el-button", {
                                attrs: {
                                  slot: "append",
                                  loading: _vm.loading_search,
                                  icon: "el-icon-search"
                                },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.searchPerson.apply(
                                      null,
                                      arguments
                                    )
                                  }
                                },
                                slot: "append"
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "x" } }, [_vm._v("Nombre")]),
                      _vm._v(" "),
                      _c("el-input", {
                        model: {
                          value: _vm.form.name,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "name", $$v)
                          },
                          expression: "form.name"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "x" } }, [_vm._v("Celular")]),
                      _vm._v(" "),
                      _c("el-input", {
                        model: {
                          value: _vm.phone,
                          callback: function($$v) {
                            _vm.phone = $$v
                          },
                          expression: "phone"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "zone" } }, [_vm._v("Zona")]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { clearable: "", filterable: "" },
                          model: {
                            value: _vm.form.zone_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "zone_id", $$v)
                            },
                            expression: "form.zone_id"
                          }
                        },
                        _vm._l(_vm.zones, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: { label: data.description, value: data.id }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-12" }, [_c("el-divider")], 1)
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-md-12 mb-2" }, [
                    _vm._v(
                      "\n                        DATOS DE LA INSTALACION\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Tipo")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          model: {
                            value: _vm.form.type,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "type", $$v)
                            },
                            expression: "form.type"
                          }
                        },
                        [
                          _c("el-option", {
                            attrs: { label: "Fibra", value: "fibra" }
                          }),
                          _vm._v(" "),
                          _c("el-option", {
                            attrs: { label: "Antena", value: "antena" }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c(
                        "label",
                        {
                          staticClass: "w-100",
                          attrs: { for: "document type" }
                        },
                        [_vm._v("Id Precinto")]
                      ),
                      _vm._v(" "),
                      _c("el-input-number", {
                        staticClass: "w-100",
                        attrs: { controls: false },
                        model: {
                          value: _vm.form.identifier,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "identifier", $$v)
                          },
                          expression: "form.identifier"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("MAC")
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        on: { input: _vm.transformMac },
                        model: {
                          value: _vm.form.mac,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "mac", $$v)
                          },
                          expression: "form.mac"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c(
                        "label",
                        {
                          staticClass: "w-100",
                          attrs: { for: "document type" }
                        },
                        [_vm._v("Suministro eléctrico")]
                      ),
                      _vm._v(" "),
                      _c("el-input-number", {
                        staticClass: "w-100",
                        attrs: { controls: false },
                        model: {
                          value: _vm.form.supplie,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "supplie", $$v)
                          },
                          expression: "form.supplie"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Tipo Plan")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          on: { change: _vm.changePrice },
                          model: {
                            value: _vm.form.plan_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "plan_id", $$v)
                            },
                            expression: "form.plan_id"
                          }
                        },
                        _vm._l(_vm.plans, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: {
                              label: data.capacity + " MB",
                              value: data.id
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Tarífa del plan")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          on: { change: _vm.calculateTotal },
                          model: {
                            value: _vm.variationId,
                            callback: function($$v) {
                              _vm.variationId = $$v
                            },
                            expression: "variationId"
                          }
                        },
                        _vm._l(_vm.planVariations, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: {
                              label: data.description + " S/." + data.price,
                              value: data.id
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-5" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Extras/Conceptos")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          on: { change: _vm.changeConcept },
                          model: {
                            value: _vm.concept.id,
                            callback: function($$v) {
                              _vm.$set(_vm.concept, "id", $$v)
                            },
                            expression: "concept.id"
                          }
                        },
                        _vm._l(_vm.concepts, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: { label: data.description, value: data.id }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-5" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Tarífa")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          model: {
                            value: _vm.variationConceptId,
                            callback: function($$v) {
                              _vm.variationConceptId = $$v
                            },
                            expression: "variationConceptId"
                          }
                        },
                        _vm._l(_vm.conceptVariations, function(data, idx) {
                          return _c("el-option", {
                            key: idx,
                            attrs: {
                              label: data.description + " S/." + data.price,
                              value: data.id
                            }
                          })
                        }),
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
                        "col-md-2 mt-sm-2  mb-sm-1 d-flex align-items-end"
                    },
                    [
                      _c("el-button", {
                        attrs: {
                          size: "mini",
                          type: "primary",
                          icon: "el-icon-plus",
                          circle: ""
                        },
                        on: { click: _vm.addConcept }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.conceptsSelected.length != 0
                    ? _c(
                        "div",
                        { staticClass: "col-md-12 mt-1 table-responsive" },
                        [
                          _c(
                            "table",
                            { staticClass: "table  table-striped table-hover" },
                            [
                              _vm._m(0),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                _vm._l(_vm.conceptsSelected, function(
                                  concept,
                                  idx
                                ) {
                                  return _c("tr", { key: idx }, [
                                    _c("td", [_vm._v(_vm._s(idx + 1))]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(
                                        "\n                                        " +
                                          _vm._s(concept.generalConcept) +
                                          "\n                                    "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(
                                        "\n                                        " +
                                          _vm._s(concept.description) +
                                          "\n                                    "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(concept.price))]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _c("el-button", {
                                          attrs: {
                                            type: "danger",
                                            icon: "el-icon-delete",
                                            circle: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.removeConcept(idx)
                                            }
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ])
                                }),
                                0
                              )
                            ]
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Dirección de instalación")
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        key: "address",
                        model: {
                          value: _vm.form.address,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "address", $$v)
                          },
                          expression: "form.address"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Referencia*")
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        model: {
                          value: _vm.form.address_reference,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "address_reference", $$v)
                          },
                          expression: "form.address_reference"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Equipo")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          staticClass: "w-100",
                          attrs: {
                            filterable: "",
                            remote: "",
                            "popper-class": "el-select-customers",
                            clearable: "",
                            placeholder: "Nombre o código interno",
                            "remote-method": _vm.searchRemoteItems,
                            loading: _vm.loading_search_item
                          },
                          on: { change: _vm.changeItem },
                          model: {
                            value: _vm.item.id,
                            callback: function($$v) {
                              _vm.$set(_vm.item, "id", $$v)
                            },
                            expression: "item.id"
                          }
                        },
                        _vm._l(_vm.items, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.showSeries
                        ? _c(
                            "el-button",
                            {
                              attrs: { size: "mini", type: "primary" },
                              on: { click: _vm.openModalSeries }
                            },
                            [
                              _vm._v(
                                "\n                            Elegir series\n                        "
                              )
                            ]
                          )
                        : _vm._e()
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-4" },
                    [
                      _c("label", { attrs: { for: "document type" } }, [
                        _vm._v("Cantidad")
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        attrs: { disabled: _vm.showSeries },
                        model: {
                          value: _vm.item.quantity,
                          callback: function($$v) {
                            _vm.$set(_vm.item, "quantity", $$v)
                          },
                          expression: "item.quantity"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      class:
                        "col-md-2 d-flex \n                    \n                    mt-sm-2  mb-sm-1 " +
                        (_vm.showSeries
                          ? "align-items-center"
                          : "align-items-end")
                    },
                    [
                      _c("el-button", {
                        attrs: {
                          size: "mini",
                          type: "primary",
                          icon: "el-icon-plus",
                          circle: ""
                        },
                        on: { click: _vm.addItem }
                      }),
                      _vm._v(" "),
                      _vm.showSeries ? _c("small") : _vm._e()
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.itemsSelected.length != 0
                    ? _c(
                        "div",
                        { staticClass: "col-md-12  mt-1 table-responsive" },
                        [
                          _c(
                            "table",
                            { staticClass: "table  table-striped table-hover" },
                            [
                              _vm._m(1),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                _vm._l(_vm.itemsSelected, function(item, idx) {
                                  return _c("tr", { key: idx }, [
                                    _c("td", [_vm._v(_vm._s(idx + 1))]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(item.description) +
                                            "\n                                        "
                                        ),
                                        item.series.length != 0
                                          ? _vm._l(item.series, function(
                                              serie
                                            ) {
                                              return _c(
                                                "div",
                                                { key: serie.id },
                                                [
                                                  _c("small", [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(serie.series)
                                                    )
                                                  ])
                                                ]
                                              )
                                            })
                                          : _vm._e()
                                      ],
                                      2
                                    ),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(item.quantity))]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _c("el-button", {
                                          attrs: {
                                            type: "danger",
                                            icon: "el-icon-delete",
                                            circle: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.removeItem(idx)
                                            }
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ])
                                }),
                                0
                              )
                            ]
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c(
                        "label",
                        { staticClass: "w-100", attrs: { for: "date" } },
                        [_vm._v("Fecha de instalación")]
                      ),
                      _vm._v(" "),
                      _c("el-date-picker", {
                        staticClass: "w-100",
                        attrs: {
                          format: "dd/MM/yyyy",
                          "value-format": "yyyy-MM-dd"
                        },
                        on: { change: _vm.updateEndOptions },
                        model: {
                          value: _vm.start_date,
                          callback: function($$v) {
                            _vm.start_date = $$v
                          },
                          expression: "start_date"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-6" },
                    [
                      _c(
                        "label",
                        { staticClass: "w-100", attrs: { for: "date" } },
                        [_vm._v("Fecha de pago")]
                      ),
                      _vm._v(" "),
                      _c("el-date-picker", {
                        staticClass: "w-100",
                        attrs: {
                          format: "dd/MM/yyyy",
                          "value-format": "yyyy-MM-dd"
                        },
                        on: { change: _vm.calculePrice },
                        model: {
                          value: _vm.pay_date,
                          callback: function($$v) {
                            _vm.pay_date = $$v
                          },
                          expression: "pay_date"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.oldClient
                    ? _c(
                        "div",
                        { staticClass: "col-md-6" },
                        [
                          _c(
                            "label",
                            { staticClass: "w-100", attrs: { for: "date" } },
                            [_vm._v("Ultima mensualidad pagada")]
                          ),
                          _vm._v(" "),
                          _c("el-date-picker", {
                            staticClass: "w-100",
                            attrs: {
                              format: "dd/MM/yyyy",
                              "value-format": "yyyy-MM-dd"
                            },
                            on: { change: _vm.updateEndOptions },
                            model: {
                              value: _vm.paidDate,
                              callback: function($$v) {
                                _vm.paidDate = $$v
                              },
                              expression: "paidDate"
                            }
                          })
                        ],
                        1
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  !_vm.oldClient
                    ? _c(
                        "div",
                        { staticClass: "col-md-6" },
                        [
                          _c(
                            "label",
                            { staticClass: "w-100", attrs: { for: "date" } },
                            [_vm._v("Fecha de termino")]
                          ),
                          _vm._v(" "),
                          _c("el-date-picker", {
                            staticClass: "w-100",
                            attrs: {
                              format: "dd/MM/yyyy",
                              "value-format": "yyyy-MM-dd"
                            },
                            model: {
                              value: _vm.start_end,
                              callback: function($$v) {
                                _vm.start_end = $$v
                              },
                              expression: "start_end"
                            }
                          })
                        ],
                        1
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-12" }, [_c("el-divider")], 1)
                ]),
                _vm._v(" "),
                _vm.form.number
                  ? _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "col-md-12 mb-2" }, [
                        _vm._v(
                          "\n                        DATOS DE FACTURACIÓN\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-4" },
                        [
                          _c("label", { attrs: { for: "doctype" } }, [
                            _vm._v("Documento")
                          ]),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              on: { change: _vm.seriesByDocument },
                              model: {
                                value: _vm.form.document_type_id,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "document_type_id", $$v)
                                },
                                expression: "form.document_type_id"
                              }
                            },
                            _vm._l(
                              [
                                {
                                  description: "Factura",
                                  value: "01",
                                  visible:
                                    _vm.form.number.length == 11 &&
                                    !_vm.oldClient
                                },
                                {
                                  description: "Boleta",
                                  value: "03",
                                  visible:
                                    _vm.form.number.length != 11 &&
                                    !_vm.oldClient
                                },
                                {
                                  description: "Nota de venta",
                                  value: "80",
                                  visible: true
                                }
                              ],
                              function(d, idx) {
                                return _c("el-option", {
                                  directives: [
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value: d.visible,
                                      expression: "d.visible"
                                    }
                                  ],
                                  key: idx,
                                  attrs: {
                                    label: d.description,
                                    value: d.value
                                  }
                                })
                              }
                            ),
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-4" },
                        [
                          _c("label", { attrs: { for: "doctype" } }, [
                            _vm._v("Serie")
                          ]),
                          _vm._v(" "),
                          _vm.form.document_type_id
                            ? _c(
                                "el-select",
                                {
                                  model: {
                                    value: _vm.form.serie_id,
                                    callback: function($$v) {
                                      _vm.$set(_vm.form, "serie_id", $$v)
                                    },
                                    expression: "form.serie_id"
                                  }
                                },
                                _vm._l(_vm.seriesDocument, function(d, idx) {
                                  return _c("el-option", {
                                    key: idx,
                                    attrs: { label: d.number, value: d.id }
                                  })
                                }),
                                1
                              )
                            : _c("el-input", {
                                staticClass: "w-100",
                                attrs: { disabled: true }
                              })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-4" },
                        [
                          _c("label", { attrs: { for: "doctype" } }, [
                            _vm._v("Cobro de instalación")
                          ]),
                          _vm._v(" "),
                          _c("el-input-number", {
                            staticClass: "w-100",
                            attrs: { controls: false },
                            model: {
                              value: _vm.form.install,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "install", $$v)
                              },
                              expression: "form.install"
                            }
                          })
                        ],
                        1
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("div", { staticClass: "row mt-2" }, [
                  _c(
                    "div",
                    {
                      staticClass:
                        "col-12 d-flex flex-column justify-content-center align-items-center mb-2"
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-12 mb-2 d-flex  justify-content-center ",
                          staticStyle: {
                            "max-width": "350px",
                            "max-height": "150px"
                          }
                        },
                        [
                          _vm.image
                            ? _c("img", {
                                staticStyle: {
                                  "max-width": "300px",
                                  "max-height": "300px"
                                },
                                attrs: {
                                  src: _vm.image,
                                  alt: "Vista previa de la imagen"
                                }
                              })
                            : _vm._e()
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "d-flex" },
                        [
                          !_vm.image
                            ? _c(
                                "el-button",
                                {
                                  staticClass: "m-2",
                                  attrs: { type: "success" },
                                  on: {
                                    click: function($event) {
                                      return _vm.$refs.file.click()
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                                Subir imagen\n                            "
                                  )
                                ]
                              )
                            : _c(
                                "el-button",
                                {
                                  staticClass: "m-2",
                                  attrs: { type: "danger" },
                                  on: {
                                    click: function($event) {
                                      _vm.image = null
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                                Eliminar imagen\n                            "
                                  )
                                ]
                              )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _vm._m(2),
                      _vm._v(" "),
                      _c("input", {
                        ref: "file",
                        staticStyle: { display: "none" },
                        attrs: {
                          accept: "image/png, image/jpeg, image/jpg",
                          type: "file"
                        },
                        on: { change: _vm.changeImage }
                      })
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row mt-2" }, [
                  _c("div", { staticClass: "col-md-4" }, [
                    _c("span", { staticClass: "h5" }, [
                      _vm._v(
                        "\n                            INSTALACION S/.\n                            " +
                          _vm._s(
                            this.form.install
                              ? this.form.install.toFixed(2)
                              : 0.0
                          ) +
                          "\n                        "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass: "h5",
                        class: _vm.installMonthly ? "" : "text-danger"
                      },
                      [
                        _vm._v(
                          "\n                            MENSUALIDAD S/.\n                            " +
                            _vm._s(
                              this.form.total ? this.form.total.toFixed(2) : 0.0
                            ) +
                            "\n                            " +
                            _vm._s(
                              _vm.days != 0 ? " x " + _vm.days + " días" : ""
                            ) +
                            "\n                        "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("br"),
                    _vm._v(" "),
                    _c("br"),
                    _vm._v(" "),
                    _c(
                      "span",
                      { staticClass: "h4" },
                      [
                        _vm._v(
                          "\n                            TOTAL S/.\n                            "
                        ),
                        _vm.installMonthly
                          ? [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    (
                                      Number(
                                        this.form.install
                                          ? this.form.install
                                          : 0.0
                                      ) +
                                      Number(
                                        this.form.total ? this.form.total : 0.0
                                      )
                                    ).toFixed(2)
                                  )
                              )
                            ]
                          : [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    Number(
                                      this.form.install
                                        ? this.form.install
                                        : 0.0
                                    ).toFixed(2)
                                  ) +
                                  "\n                            "
                              )
                            ]
                      ],
                      2
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "col-md-8 d-flex justify-content-end align-items-end"
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "dialog-footer",
                          attrs: { slot: "footer" },
                          slot: "footer"
                        },
                        [
                          !_vm.oldClient
                            ? _c(
                                "el-checkbox",
                                {
                                  model: {
                                    value: _vm.installMonthly,
                                    callback: function($$v) {
                                      _vm.installMonthly = $$v
                                    },
                                    expression: "installMonthly"
                                  }
                                },
                                [_vm._v("Cobrar mensualidad")]
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c("el-button", { on: { click: _vm.close } }, [
                            _vm._v("Cancelar")
                          ]),
                          _vm._v(" "),
                          _c(
                            "el-button",
                            {
                              attrs: { type: "primary" },
                              on: { click: _vm.sendRegister }
                            },
                            [_vm._v("Registrar")]
                          )
                        ],
                        1
                      )
                    ]
                  )
                ])
              ]
            )
          ]),
          _vm._v(" "),
          _c("cash-form", {
            attrs: {
              showDialog: _vm.showDialogCash,
              recordId: _vm.cash_id,
              fromBox: true
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogCash = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogCash = $event
              },
              updateCashId: _vm.updateCashId
            }
          }),
          _vm._v(" "),
          _c("close-cash", {
            attrs: {
              recordId: _vm.cash_id,
              showDialogClose: _vm.showDialogClose,
              fromBox: true
            },
            on: {
              "update:recordId": function($event) {
                _vm.cash_id = $event
              },
              "update:record-id": function($event) {
                _vm.cash_id = $event
              },
              "update:showDialogClose": function($event) {
                _vm.showDialogClose = $event
              },
              "update:show-dialog-close": function($event) {
                _vm.showDialogClose = $event
              },
              updateCashId: _vm.updateCashId
            }
          }),
          _vm._v(" "),
          _c("expenses-incomes", {
            attrs: {
              showDialog: _vm.showExpensesIncomes,
              company: _vm.company,
              cash_id: _vm.cash_id
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showExpensesIncomes = $event
              },
              "update:show-dialog": function($event) {
                _vm.showExpensesIncomes = $event
              }
            }
          }),
          _vm._v(" "),
          _c("show-series-product", {
            attrs: {
              limitQty: _vm.limitQty,
              idx: _vm.currentIdx,
              item: _vm.currentItem,
              showDialog: _vm.showModalSeries,
              seriesSelected: _vm.currentSeries
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showModalSeries = $event
              },
              "update:show-dialog": function($event) {
                _vm.showModalSeries = $event
              },
              "update:seriesSelected": function($event) {
                _vm.currentSeries = $event
              },
              "update:series-selected": function($event) {
                _vm.currentSeries = $event
              },
              updateSeries: _vm.updateSeries
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("create-variation-form", {
        attrs: {
          showDialog: _vm.showFormVariation,
          dataVariation: _vm.variationData
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showFormVariation = $event
          },
          "update:show-dialog": function($event) {
            _vm.showFormVariation = $event
          },
          addVariation: _vm.addVariation
        }
      }),
      _vm._v(" "),
      _c("payment-internet", {
        attrs: {
          serviceItem: _vm.serviceItem,
          configuration: _vm.configuration,
          paymentItems: _vm.paymentItems,
          data: _vm.data,
          is_payment: _vm.is_payment,
          periodObservation: _vm.observation
        },
        on: {
          getRegisters: _vm.getRegisters,
          "update:data": function($event) {
            _vm.data = $event
          },
          "update:is_payment": function($event) {
            _vm.is_payment = $event
          },
          addAdvance: _vm.addAdvance
        }
      }),
      _vm._v(" "),
      _c("person-form", {
        attrs: {
          newTech: _vm.newTech,
          external: true,
          showDialog: _vm.showDialogNewPerson
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogNewPerson = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogNewPerson = $event
          }
        }
      }),
      _vm._v(" "),
      _c("transfers-modal", {
        attrs: { showDialog: _vm.showTransfersDialog },
        on: {
          "update:showDialog": function($event) {
            _vm.showTransfersDialog = $event
          },
          "update:show-dialog": function($event) {
            _vm.showTransfersDialog = $event
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("#")]),
        _vm._v(" "),
        _c("th", [_vm._v("Extra")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descripción")]),
        _vm._v(" "),
        _c("th", [_vm._v("Total")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("#")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descripción")]),
        _vm._v(" "),
        _c("th", [_vm._v("Cantidad")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", [_c("em", [_vm._v("JPG, PNG, JPEG ")])])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-a33ad4e8", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a33ad4e8\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a33ad4e8\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/register_form.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("0ed04d8b", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a33ad4e8\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./register_form.vue", function() {
     var newContent = require("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a33ad4e8\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./register_form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=163.js.map