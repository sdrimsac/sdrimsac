webpackJsonp([155],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-28dd8919\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-28dd8919\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-28dd8919", Component.options)
  } else {
    hotAPI.reload("data-v-28dd8919", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var ConsignmentForm = function ConsignmentForm() {
  return __webpack_require__.e/* import() */(190).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_modal.vue"));
};

var QuotationForm = function QuotationForm() {
  return __webpack_require__.e/* import() */(177).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue"));
};

var CreditForm = function CreditForm() {
  return __webpack_require__.e/* import() */(188).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue"));
};

var CashForm = function CashForm() {
  return __webpack_require__.e/* import() */(193).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/cash/form.vue"));
};

var CloseCash = function CloseCash() {
  return __webpack_require__.e/* import() */(159).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/cash/closecash.vue"));
};

var OrdenPullApart = function OrdenPullApart() {
  return __webpack_require__.e/* import() */(180).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue"));
};

var TableOrdensPending = function TableOrdensPending() {
  return __webpack_require__.e/* import() */(183).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue"));
};

var ObservationForm = function ObservationForm() {
  return __webpack_require__.e/* import() */(158).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/partials/observation_form.vue"));
};

var ExpensesIncomes = function ExpensesIncomes() {
  return __webpack_require__.e/* import() */(148).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/expenses_incomes.vue"));
};

var ShowSeriesProduct = function ShowSeriesProduct() {
  return __webpack_require__.e/* import() */(175).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/show_series_product.vue"));
};

var ShowLotesProduct = function ShowLotesProduct() {
  return __webpack_require__.e/* import() */(176).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue"));
};

var TransfersModal = function TransfersModal() {
  return __webpack_require__.e/* import() */(172).then(__webpack_require__.bind(null, "./modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ConsignmentForm: ConsignmentForm,
    CreditForm: CreditForm,
    CashForm: CashForm,
    CloseCash: CloseCash,
    TableOrdensPending: TableOrdensPending,
    OrdenPullApart: OrdenPullApart,
    ObservationForm: ObservationForm,
    ExpensesIncomes: ExpensesIncomes,
    ShowSeriesProduct: ShowSeriesProduct,
    ShowLotesProduct: ShowLotesProduct,
    TransfersModal: TransfersModal,
    QuotationForm: QuotationForm
  },
  props: ["sellers", "affectation_igv_types", "all_series", "areas", "customers", "company", "customer_variation", "variationShow", "establishments", "itemDefault", "ordensPending", "area_id", "blockCart", "localOrden", "configuration", "ordens", "total2", "clientTableData", "isCreatingOrden", "ordenId", "cash_id"],
  data: function data() {
    return {
      quotation_stock: false,
      name_pdf: null,
      showChangeName: false,
      isConsignment: false,
      showConsignmentForm: false,
      deleteGeneralOrden: false,
      deleteOrdenLoading: false,
      reasonToDelete: null,
      ordenIdToDelete: null,
      showPinRequest: false,
      showCreditForm: false,
      showQuotationForm: false,
      limitQty: 0,
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
      foodDefaults: [],
      currentFoodDefault: null
    };
  },
  watch: {
    variationShow: function variationShow(variat, _) {
      if (this.variation && !variat) {
        this.variation = false;
      }
    },
    itemDefault: function itemDefault(newItem, _) {
      this.foodDefault = this.itemDefault;
      this.foodDefault.quantity = 1;
      this.foodDefault.sale_unit_price = Number(this.foodDefault.sale_unit_price);
      this.foodDefaults = [_objectSpread({}, this.foodDefault)];
    },
    cash_id: function cash_id(newCash, _) {
      this.boxOperation = newCash ? "Cerrar" : "Abrir";
      this.optionsMenu[2].title = [this.boxOperation, " Caja"];
    },
    ordens: function ordens(newOrdens, _) {
      this.calculateTotal(newOrdens);
    },
    localOrden: function localOrden(newOrdens, _) {
      this.calculateTotal(this.ordens);
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
      visible: this.configuration.receive_merchandise
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
    }, {
      id: 4,
      title: ["Aparcado"],
      icon: "fas fa-cart-arrow-down",
      visible: !this.configuration.college
    }, {
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
              _context.next = 6;
              return _this.getTags();

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    setQuotationStock: function setQuotationStock() {
      var quotation_stock = this.quotation_stock ? 1 : 0;
      localStorage.setItem("quotation_stock", quotation_stock);

      if (!this.quotation_stock) {
        this.directSale();
      }
    },
    restoreName: function restoreName(idx) {
      var ordens = _toConsumableArray(this.localOrden);

      ordens[idx].food.item.name_product_pdf = null;
      this.$emit("update:localOrden", ordens);
    },
    changeNamePdf: function changeNamePdf() {
      var idx = this.currentIdx;

      var ordens = _toConsumableArray(this.localOrden);

      ordens[idx].food.item.name_product_pdf = this.name_pdf;
      this.$emit("update:localOrden", ordens);
      this.showChangeName = false;
    },
    changeName: function changeName(idx) {
      this.currentIdx = idx;

      var ordens = _toConsumableArray(this.localOrden);

      this.name_pdf = ordens[idx].food.description;
      this.showChangeName = true;
    },
    updateWarehouse: function updateWarehouse(order, index) {
      var ordens = _toConsumableArray(this.localOrden);

      ordens[index].toWarehouse = order.toWarehouse;
      var newQuantity = ordens[index].originalQuantity - order.toWarehouse;

      if (newQuantity < 0) {
        this.$toast.error("No puede ser mayor a la cantidad original");
        ordens[index].toWarehouse = 0;
        ordens[index].quantity = ordens[index].originalQuantity;
      } else {
        ordens[index].quantity = ordens[index].originalQuantity - order.toWarehouse;
      }

      this.$emit("update:localOrden", ordens);
    },
    setConsignment: function setConsignment(consigment) {
      this.isConsignment = true;
    },
    removeConsignment: function removeConsignment() {
      this.isConsignment = false;
    },
    openConsignment: function openConsignment() {
      this.showConsignmentForm = true;
    },
    changeQuickSale: function changeQuickSale() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var conf, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                conf = _this2.establishments.conf;
                _context2.prev = 1;
                _context2.next = 4;
                return _this2.$http.post("/establishments/update_conf", _objectSpread({}, conf));

              case 4:
                response = _context2.sent;

                _this2.$toast.success(response.data.message);

                _context2.next = 11;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](1);
                console.log(_context2.t0);

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[1, 8]]);
      }))();
    },
    deleteDefaultFood: function deleteDefaultFood(index) {
      this.foodDefaults = this.foodDefaults.filter(function (_, i) {
        return i != index;
      });
    },
    addVariation: function addVariation() {
      var foodDefault = _objectSpread({}, this.itemDefault);

      foodDefault.description = foodDefault.description + " " + Number(this.foodDefaults.length + 1);
      this.foodDefaults = [].concat(_toConsumableArray(this.foodDefaults), [foodDefault]);
    },
    openCredit: function openCredit() {
      this.showCreditForm = true;
    },
    openQuotation: function openQuotation() {
      this.showQuotationForm = true;
    },
    savePrint: function savePrint() {
      localStorage.setItem("cajaPrint", this.printing ? 1 : 0);
      this.$toast.success("Configuración guardada");
    },
    handleResize: function handleResize() {
      this.screenWidth = window.innerWidth;
    },
    showTransfers: function showTransfers() {
      this.showTransfersDialog = true;
    },
    deleteSerie: function deleteSerie(index, serie_id) {
      var ordens = _toConsumableArray(this.localOrden);

      ordens[index].series = ordens[index].series.filter(function (s) {
        return s.id != serie_id;
      });
      ordens[index].quantity = ordens[index].series.length;
      this.$emit("update:localOrden", ordens);
    },
    updateSeries: function updateSeries(idx, series) {
      var ordens = _toConsumableArray(this.localOrden);

      ordens[idx].series = series;

      if (this.limitQty) {
        ordens[idx].quantity = series.length / this.limitQty;
      } else {
        ordens[idx].quantity = series.length;
      }

      this.$emit("update:localOrden", ordens);
    },
    updateLotes: function updateLotes(idx, lotes) {
      var ordens = _toConsumableArray(this.localOrden);

      ordens[idx].lotes = lotes;
      ordens[idx].quantity = lotes.reduce(function (a, b) {
        return a + Number(b.quantitySelected);
      }, 0);
      this.$emit("update:localOrden", ordens);
    },
    showLotesDialog: function showLotesDialog(orden, index) {
      this.ordenLot = orden;
      this.currentIdx = index;
      this.showLotes = true;
    },
    showSeriesDialog: function showSeriesDialog(orden) {
      var _orden$type_quantity;

      var index = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      this.limitQty = (_orden$type_quantity = orden.type_quantity) !== null && _orden$type_quantity !== void 0 ? _orden$type_quantity : 0;
      var ordens = this.localOrden.filter(function (l) {
        return l.id == orden.id;
      });

      if (ordens.length == 1) {
        var _ordens = _slicedToArray(ordens, 1),
            currentOrden = _ordens[0];

        var series = currentOrden.series.map(function (s) {
          return _objectSpread(_objectSpread({}, s), {}, {
            disabled: false
          });
        });
        this.currentSeries = series;
      } else {
        var _series = [];

        var _loop = function _loop(i) {
          var currentOrden = ordens[i];
          _series = [].concat(_toConsumableArray(_series), _toConsumableArray(currentOrden.series.map(function (s) {
            return _objectSpread(_objectSpread({}, s), {}, {
              disabled: orden.type_id != currentOrden.type_id
            });
          })));
        };

        for (var i = 0; i < ordens.length; i++) {
          _loop(i);
        }

        this.currentSeries = _series;
      }

      this.currentItem = orden.food.item; // this.currentSeries = orden.series;

      this.currentIdx = index;
      this.showSeries = true;
    },
    justNumber: function justNumber(indexx) {
      this.localOrden[indexx].newSubtotal = this.localOrden[indexx].newSubtotal.replace(/[^0-9.]/g, "");
    },
    updateDefaultFoodQty: function updateDefaultFoodQty(bool, idx) {
      var foodDefault = this.foodDefaults[idx];

      if (bool) {
        foodDefault.quantity += 1;
      } else {
        if (foodDefault.quantity > 1) {
          foodDefault.quantity -= 1;
        }
      }

      this.$forceUpdate();
    },
    showChangeDescription: function showChangeDescription(idx) {
      this.descriptionTemp = null;
      this.currentFoodDefault = idx;
      this.showChangeDescriptionVariation = true;
    },
    changeDescription: function changeDescription() {
      var foodDefault = this.foodDefaults[this.currentFoodDefault];
      foodDefault.description = this.descriptionTemp;
      this.showChangeDescriptionVariation = false;
    },
    changeVariation: function changeVariation() {
      if (this.customer_variation == null) {
        this.variation = false;
        return this.$toast.error("Clientes modificado no creado");
      }

      if (this.itemDefault == null) {
        this.variation = false;
        return this.$toast.error("Producto para variación no seleccionado");
      }

      this.foodDefaults = [this.foodDefault];
    },
    saveSubtotal: function saveSubtotal(idx) {
      var ordensModified = _toConsumableArray(this.localOrden);

      var currentOrden = ordensModified[idx];
      var sub = Number(currentOrden.newSubtotal);

      if (isNaN(sub) || sub <= 0) {
        ordensModified[idx].change_subtotal = false;
        ordensModified[idx].series = [];
        ordensModified[idx].lotes = [];
        ordensModified[idx].newSubtotal = null;
        this.$emit("update:localOrden", ordensModified);
        this.$toast.error("Subtotal no válido");
        return;
      }

      var qty = Number(currentOrden.quantity);
      var price = sub / qty;
      ordensModified[idx].price = price;
      ordensModified[idx].change_subtotal = false;
      ordensModified[idx].series = [];
      ordensModified[idx].lotes = [];
      ordensModified[idx].newSubtotal = null;
      this.$emit("update:localOrden", ordensModified);
      this.calculateTotal();
      this.$toast.success("Subtotal actualizado");
    },
    changeSubtotal: function changeSubtotal(idx) {
      var ordensModified = _toConsumableArray(this.localOrden);

      ordensModified[idx].change_subtotal = !ordensModified[idx].change_subtotal;
      this.$emit("update:localOrden", ordensModified);
    },
    addObservation: function addObservation(obs) {
      var ordensModified = _toConsumableArray(this.localOrden);

      ordensModified[this.currentLocalOrden].observation = obs;
      this.$emit("update:localOrden", ordensModified);
    },
    getTags: function getTags() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this3.$http("../observations/records");

              case 2:
                response = _context3.sent;

                if (response.status == 200) {
                  data = response.data;
                  _this3.tags = data;
                }

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    updateCashId: function updateCashId(id) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.$emit("update:cash_id", id);

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    cancelGeneralOrdenPin: function cancelGeneralOrdenPin() {
      this.deleteGeneralOrden = true;
      this.showPinRequest = true;
    },
    deleteGeneralOrdenPin: function deleteGeneralOrdenPin() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var id, form, response, _response$data, message, success;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.prev = 0;
                _this5.deleteOrdenLoading = true;
                id = _this5.ordens[0].orden_id;
                form = {
                  id: id,
                  pin: _this5.pin,
                  reason: _this5.reasonToDelete
                };
                _context5.next = 6;
                return _this5.$http.post("cancel-orden", form);

              case 6:
                response = _context5.sent;

                if (response.status == 200) {
                  _response$data = response.data, message = _response$data.message, success = _response$data.success;

                  if (success) {
                    _this5.$toast.success(message);

                    _this5.$eventHub.$emit("reloadData");

                    _this5.$emit("ordenDeleted");

                    _this5.deleteGeneralOrden = false;
                    _this5.showPinRequest = false;
                    _this5.reasonToDelete = null;

                    _this5.directSale();
                  } else {
                    _this5.$toast.error(message);
                  }
                }

                _context5.next = 13;
                break;

              case 10:
                _context5.prev = 10;
                _context5.t0 = _context5["catch"](0);

                if (_context5.t0 != "cancel") {
                  console.log(_context5.t0); // this.$toast.error("Ocurrió un error");
                }

              case 13:
                _context5.prev = 13;
                _this5.pin = "";
                _this5.deleteOrdenLoading = false;
                return _context5.finish(13);

              case 17:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, null, [[0, 10, 13, 17]]);
      }))();
    },
    cancelGeneralOrden: function cancelGeneralOrden(id) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var res, form, response, message;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                if (!_this6.configuration.pin_orden_delete) {
                  _context6.next = 4;
                  break;
                }

                _this6.cancelGeneralOrdenPin();

                _context6.next = 23;
                break;

              case 4:
                _context6.prev = 4;
                _context6.next = 7;
                return _this6.$confirm("Desea cancelar toda la orden?", "Cancelar", {
                  confirmButtonText: "Ok",
                  cancelButtonText: "Cancelar",
                  type: "warning"
                });

              case 7:
                res = _context6.sent;

                if (!res) {
                  _context6.next = 15;
                  break;
                }

                _this6.loading = true;
                form = {
                  id: id
                };
                _context6.next = 13;
                return _this6.$http.post("cancel-orden", form);

              case 13:
                response = _context6.sent;

                if (response.status == 200) {
                  message = response.data.message;

                  _this6.$toast.success(message);

                  _this6.$eventHub.$emit("reloadData");

                  _this6.$emit("ordenDeleted");

                  _this6.directSale();
                }

              case 15:
                _context6.next = 20;
                break;

              case 17:
                _context6.prev = 17;
                _context6.t0 = _context6["catch"](4);

                if (_context6.t0 != "cancel") {
                  console.log(_context6.t0);

                  _this6.$toast.error("Ocurrió un error");
                }

              case 20:
                _context6.prev = 20;
                _this6.loading = false;
                return _context6.finish(20);

              case 23:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, null, [[4, 17, 20, 23]]);
      }))();
    },
    allToCarry: function allToCarry() {
      var _this7 = this;

      if (this.localOrden.length == 0) return;

      var ord = _toConsumableArray(this.localOrden);

      ord = ord.map(function (o) {
        var delivery_cost = o.food.item.delivery_cost;
        var delivery = Number(delivery_cost);
        var factor = _this7.to_carry ? 1 : -1;
        var price = Number(o.price) + delivery * factor;
        return _objectSpread(_objectSpread({}, o), {}, {
          to_carry: _this7.to_carry,
          price: price
        });
      });
      this.$emit("update:localOrden", ord);
    },
    toCarry: function toCarry(idx) {
      var ord = _toConsumableArray(this.localOrden);

      var delivery_cost = ord[idx].food.item.delivery_cost;
      ord[idx].to_carry = !ord[idx].to_carry;
      var delivery = Number(delivery_cost);
      var factor = ord[idx].to_carry ? 1 : -1;
      ord[idx].price = Number(ord[idx].price) + delivery * factor;
      this.$emit("update:localOrden", ord);
    },
    verifyStock: function verifyStock(orden, idx) {
      var current_orden = this.localOrden.filter(function (o) {
        return o.id == orden.id;
      });
      var unit_type_id = current_orden[0].food.item.unit_type_id;

      if (this.configuration.sales_stock && !this.quotation_stock && unit_type_id != 'ZZ') {
        var qty = current_orden.reduce(function (a, b) {
          return a + Number(b.quantity);
        }, 0);
        var stock = 0;

        if (current_orden.length == 1 && current_orden[0].lotes.length == 1) {
          var _current_orden = _slicedToArray(current_orden, 1),
              _orden = _current_orden[0];

          var _orden$lotes = _slicedToArray(_orden.lotes, 1),
              lote = _orden$lotes[0];

          stock = lote.quantity;
        } else {
          stock = Number(current_orden[0].food.item.stock);
        }

        if (qty > stock) {
          this.$toast.warning("Sobrepaso el stock");
          var localOrden_quantity = this.localOrden;
          localOrden_quantity[idx].quantity = 1;
          return;
        }

        if (current_orden.length == 1) {
          var _current_orden2 = _slicedToArray(current_orden, 1),
              _orden2 = _current_orden2[0];

          if (_orden2.lotes.length == 1) {
            _orden2.lotes[0].quantitySelected = this.localOrden[idx].quantity;
          }
        }
      }

      this.calculateTotal();
    },
    showOrdensPending: function showOrdensPending() {
      this.showPendingOrdens = true;
    },
    validStock: function validStock(orden) {
      var quantity = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
      var qty = this.localOrden.filter(function (o) {
        return o.id == orden.id;
      }).reduce(function (a, b) {
        return a + Number(b.quantity);
      }, 0);

      if (orden.type_id) {
        qty += orden.type_quantity;
      } else {
        qty += quantity;
      }

      var stock = Number(orden.food.item.stock);
      var unit_type_id = orden.food.item.unit_type_id;

      if (this.configuration.sales_stock == true && !this.quotation_stock && unit_type_id != 'ZZ') {
        if (qty > stock) {
          return true;
        }
      }

      return false;
    },
    printOrden: function printOrden() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _this8.ordenLoading = true;
                _context7.prev = 1;
                _context7.next = 4;
                return _this8.printTicket(_this8.clientTableData.orden_id);

              case 4:
                _context7.next = 9;
                break;

              case 6:
                _context7.prev = 6;
                _context7.t0 = _context7["catch"](1);

                _this8.$toast.error("No se pudo imprimir");

              case 9:
                _context7.prev = 9;
                _this8.ordenLoading = false;
                return _context7.finish(9);

              case 12:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7, null, [[1, 6, 9, 12]]);
      }))();
    },
    sendOrden: function sendOrden() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var orden, responses, ordenId, msg;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                if (!(_this9.localOrden.length == 0 && !_this9.variation)) {
                  _context8.next = 3;
                  break;
                }

                _this9.$toast.warning("Orden sin productos");

                return _context8.abrupt("return");

              case 3:
                orden = {
                  status_orden_id: 1,
                  table_id: _this9.clientTableData.table_id,
                  to_carry: _this9.to_carry
                };
                _this9.ordenLoading = true;
                _context8.prev = 5;
                _context8.next = 8;
                return _this9.$http.post("/caja/worker/send-orden", {
                  id: _this9.clientTableData.orden_id,
                  ref: _this9.clientTableData.ref,
                  items: _this9.localOrden,
                  caja: true,
                  printing: true,
                  saleDirect: false,
                  orden: orden
                });

              case 8:
                responses = _context8.sent;
                ordenId = responses.data.id;
                _this9.ordenLoading = false;

                if (!(responses.status != 200)) {
                  _context8.next = 14;
                  break;
                }

                _this9.$toast.warning("Ocurrió un error");

                return _context8.abrupt("return");

              case 14:
                _this9.to_carry = false;

                _this9.$emit("cancelOrden");

                _this9.$emit("update:isCreatingOrden", false);

                msg = "";

                if (_this9.clientTableData.orden_id) {
                  msg = "Se agregaron los pedidos a la orden ".concat(ordenId);
                } else {
                  msg = "La orden ".concat(ordenId, " fue creada.");
                }

                _this9.$toast.success(msg);

                _context8.next = 26;
                break;

              case 22:
                _context8.prev = 22;
                _context8.t0 = _context8["catch"](5);
                _this9.ordenLoading = false; //no jala el clientdata tble - ref // lo guarda con el id mesa caja

                _this9.$toast.error("Ocurrió un error");

              case 26:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8, null, [[5, 22]]);
      }))();
    },
    directSale: function directSale() {
      this.$emit("update:clientTableData", {});
      this.$emit("update:localOrden", []);
      this.$emit("update:ordens", []);
      this.$emit("update:blockCart", false);
      this.$emit("update:isCreatingOrden", false); //ordenId

      this.$emit("update:idOrden", null);
      this.$emit("resetOrden");
    },
    restoreToLocalOrdens: function restoreToLocalOrdens(ordens) {
      this.$emit("update:localOrden", ordens);
    },
    checkTables: function checkTables() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _context9.next = 2;
                return _this10.$http("/caja/tables/check");

              case 2:
                response = _context9.sent;
                data = response.data;
                return _context9.abrupt("return", data);

              case 5:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    trigerFunction: function trigerFunction(id) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        var data, ordenes, total, items;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                _context10.t0 = id;
                _context10.next = _context10.t0 === 7 ? 3 : _context10.t0 === 2 ? 5 : _context10.t0 === 3 ? 7 : _context10.t0 === 5 ? 33 : _context10.t0 === 4 ? 35 : 37;
                break;

              case 3:
                if (!_this11.cash_id) {
                  _this11.$toast.error("Abra una caja");
                } else {
                  _this11.showExpensesIncomes = true;
                }

                return _context10.abrupt("break", 38);

              case 5:
                _this11.showTransfers();

                return _context10.abrupt("break", 38);

              case 7:
                if (!_this11.cash_id) {
                  _context10.next = 31;
                  break;
                }

                if (!_this11.configuration.ordens_cash) {
                  _context10.next = 28;
                  break;
                }

                _context10.next = 11;
                return _this11.checkTables();

              case 11:
                data = _context10.sent;

                if (data.success) {
                  _context10.next = 16;
                  break;
                }

                _this11.showDialogClose = true;
                _context10.next = 26;
                break;

              case 16:
                ordenes = data.ordenes, total = data.total, items = data.items;
                _context10.prev = 17;
                _context10.next = 20;
                return _this11.$confirm("Existen ".concat(ordenes, " ordenes pendientes por cobrar, con un total de ").concat(total, " soles. Desea emitir una nota de venta por el total?"), "Cerrar Caja", {
                  confirmButtonText: "Emitir",
                  cancelButtonText: "Cerrar",
                  type: "warning"
                });

              case 20:
                _this11.$emit("sendOrdensAllTables", items);

                _context10.next = 26;
                break;

              case 23:
                _context10.prev = 23;
                _context10.t1 = _context10["catch"](17);
                console.log(_context10.t1);

              case 26:
                _context10.next = 29;
                break;

              case 28:
                _this11.showDialogClose = true;

              case 29:
                _context10.next = 32;
                break;

              case 31:
                _this11.showDialogCash = true;

              case 32:
                return _context10.abrupt("break", 38);

              case 33:
                _this11.showOrdensPending();

                return _context10.abrupt("break", 38);

              case 35:
                if (_this11.ordenInBox.length > 0) {
                  _this11.listApart = true;
                } else {
                  _this11.$toast.warning("Sin ventas apartacadas.");
                }

                return _context10.abrupt("break", 38);

              case 37:
                return _context10.abrupt("break", 38);

              case 38:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10, null, [[17, 23]]);
      }))();
    },
    limpiarForm: function limpiarForm() {
      this.quotation_stock = false;
      this.$emit("limpiarForm");
    },
    openApart: function openApart() {
      if (this.localOrden.length == 0) {
        this.$toast.error("Sin ordenes pendientes");
        return;
      }

      this.apart = true;
    },
    pullApartOrden: function pullApartOrden() {
      var _this12 = this;

      if (!this.numberCustomerApart && this.numberCustomerApart.length <= 1) {
        this.$toast.error("Documento o referencia inválida");
        return;
      } else if (this.ordenInBox.length == 3) {
        this.$toast.error("Limite excedido. ");
        return;
      } else if (this.ordenInBox.some(function (f) {
        return f.ref.toLowerCase() == _this12.numberCustomerApart.toLowerCase();
      })) {
        this.$toast.error("La referencia ya existe");
        return;
      } else {
        this.ordenInBox.push({
          ref: this.numberCustomerApart,
          ordens: this.localOrden
        });
        localStorage.ordens = JSON.stringify(this.ordenInBox);
        this.numberCustomerApart = undefined;
        this.apart = false;
        this.$emit("cancelOrden");
        this.$toast.success("Orden aparcada");
      }
    },
    cancelOrden: function cancelOrden() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee11() {
        var res;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                _context11.prev = 0;
                _context11.next = 3;
                return _this13.$confirm("Desea cancelar este pedido?", "Cancelar", {
                  confirmButtonText: "Ok",
                  cancelButtonText: "Cancelar",
                  type: "warning"
                });

              case 3:
                res = _context11.sent;

                if (res) {
                  _this13.isConsignment = false;

                  _this13.$emit("cancelOrden");
                }

                _context11.next = 9;
                break;

              case 7:
                _context11.prev = 7;
                _context11.t0 = _context11["catch"](0);

              case 9:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11, null, [[0, 7]]);
      }))();
    },
    addNumberPin: function addNumberPin(number) {
      if (this.pin.length >= 4) {
        return;
      }

      this.pin += number.toString();
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
    sumar_orden: function sumar_orden(index) {
      if (this.validStock(this.localOrden[index])) {
        this.$toast.warning("Limite de stock alcanzado");
        return;
      }

      var localOrden_quantity = this.localOrden;

      if (this.localOrden[index].type_id) {
        localOrden_quantity[index].quantity = Number(localOrden_quantity[index].quantity) + 1; // localOrden_quantity[index].quantity =
        //     Number(localOrden_quantity[index].quantity) +
        //     Number(localOrden_quantity[index].type_quantity);
      } else {
        localOrden_quantity[index].quantity = Number(localOrden_quantity[index].quantity) + 1;
      }

      this.$emit("update:localOrden", localOrden_quantity);
      this.calculateTotal();
    },
    restar_orden: function restar_orden(index) {
      var localOrden_quantity = this.localOrden;
      var min = 1;

      if (this.localOrden[index].type_id) {
        min = Number(localOrden_quantity[index].type_quantity);
      }

      var quantity = localOrden_quantity[index].quantity * min;

      if (quantity > min) {
        // if (localOrden_quantity[index].quantity > min) {
        if (this.localOrden[index].type_id) {
          // localOrden_quantity[index].quantity =
          //     Number(localOrden_quantity[index].quantity) -
          //     Number(localOrden_quantity[index].type_quantity);
          localOrden_quantity[index].quantity = Number(localOrden_quantity[index].quantity) - 1;
        } else {
          localOrden_quantity[index].quantity = Number(localOrden_quantity[index].quantity) - 1;
        }

        this.$emit("update:localOrden", localOrden_quantity);
        this.calculateTotal();
      } else {
        this.$toast.warning("Mínimo permitido");
      }
    },
    printTicket: function printTicket(id) {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee12() {
        var response, url, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                _context12.prev = 0;
                _context12.next = 3;
                return _this14.$http.get("/caja/worker/record/".concat(id));

              case 3:
                response = _context12.sent;
                url = response.data.print;
                config = qz.configs.create(response.data.printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context12.next = 9;
                  break;
                }

                _context12.next = 9;
                return qz.websocket.connect(config);

              case 9:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: url
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this14.$toast.error(e.message);
                }); //this.$toast.success("se esta imprimiendo el comprobante con exito");
                // qz.websocket.disconnect()

                _context12.next = 16;
                break;

              case 13:
                _context12.prev = 13;
                _context12.t0 = _context12["catch"](0);

                _this14.$toast.error(_context12.t0.message);

              case 16:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12, null, [[0, 13]]);
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

      var _iterator = _createForOfIteratorHelper(this.localOrden),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var ord = _step.value;
          var series_enabled = ord.food.item.series_enabled;

          if (series_enabled && ord.series.length == 0) {
            hasError = true;
            break;
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      return hasError;
    },
    payOrden: function payOrden() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee13() {
        var form_submit;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                if (!_this15.checkIsExistSerie()) {
                  _context13.next = 3;
                  break;
                }

                _this15.$toast.error("Producto sin serie seleccionada");

                return _context13.abrupt("return");

              case 3:
                if (_this15.cash_id) {
                  _context13.next = 6;
                  break;
                }

                _this15.$toast.error("No tiene una caja abierta");

                return _context13.abrupt("return");

              case 6:
                if (!_this15.clientTableData.table) {
                  _context13.next = 12;
                  break;
                }

                if (!(_this15.ordens.length == 0)) {
                  _context13.next = 10;
                  break;
                }

                _this15.$toast.warning("Orden sin productos");

                return _context13.abrupt("return");

              case 10:
                _context13.next = 15;
                break;

              case 12:
                if (!(_this15.localOrden.length == 0 && !_this15.variation)) {
                  _context13.next = 15;
                  break;
                }

                _this15.$toast.warning("Orden sin productos");

                return _context13.abrupt("return");

              case 15:
                _this15.disableSend = true;
                form_submit = {
                  id: null,
                  caja: true,
                  printDocument: _this15.printing,
                  printing: _this15.configuration.print_commands,
                  commands_fisico: _this15.commands_fisico,
                  print_kitchen: _this15.configuration.print_kitchen,
                  to_carry: _this15.to_carry,
                  orden: {
                    table_id: 1,
                    status_orden_id: 1
                  },
                  pin: null
                };

                if (_this15.clientTableData.table) {
                  form_submit.items = _this15.ordens;
                } else {
                  form_submit.items = _this15.localOrden;
                }

                form_submit.items = _this15.mergeItems(form_submit.items);
                _this15.loading = true;
                _this15.commands_fisico = "";
                _this15.to_carry = false;
                _this15.loading = false;
                _this15.disableSend = false;

                if (_this15.variation) {
                  form_submit.variationItems = _this15.foodDefaults;
                }

                _this15.loading = false;
                _this15.disableSend = false;

                if (_this15.variation) {
                  _this15.$emit("paymentsOrden", form_submit, _this15.foodDefaults);
                } else {
                  _this15.$emit("paymentsOrden", form_submit);
                }

              case 28:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    mergeItems: function mergeItems(items) {
      var hasFoodId = items.every(function (item) {
        return item.food && item.food.id;
      });

      if (!hasFoodId) {
        return items;
      }

      var resultado = {}; // Recorrer el arreglo original

      items.forEach(function (obj) {
        var key = "".concat(obj.food.id, "-").concat(Number(obj.price).toFixed(2));

        if (resultado[key]) {
          resultado[key].quantity += Number(obj.quantity);
        } else {
          resultado[key] = _objectSpread(_objectSpread({}, obj), {}, {
            quantity: Number(obj.quantity)
          });
        }
      });
      var arregloResultado = Object.values(resultado);
      return arregloResultado;
    },
    formatUrlImage: function formatUrlImage(url) {
      if (!url) return;
      var formated = "storage/uploads/items/" + url;
      return "/".concat(formated);
    },
    calculateTotal: function calculateTotal() {
      var w = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.totalOrdenItems = 0.0;
      this.total = 0.0;
      this.totalOrden = 0.0;
      var OrdenPen = 0;
      var OrdenPenAtendidos = 0;

      var nTotal_poratendidos = _.forEach(this.localOrden, function (value) {
        OrdenPen = parseFloat(OrdenPen) + value.quantity * value.price;
      });

      this.totalOrden = _.round(OrdenPen, 2);

      var nTotal_atendidos = _.forEach(this.ordens, function (values) {
        OrdenPenAtendidos = parseFloat(OrdenPenAtendidos) + values.quantity * values.price;
      });

      this.totalOrdenItems = _.round(OrdenPenAtendidos, 2); // this.total = this.totalOrden + this.totalOrdenItems;

      this.total = _.round(this.totalOrden, 2);
      this.$emit("total_salcancelOrdenaes", this.total);
    },
    deleteFood: function deleteFood(idx) {
      this.$emit("deletedFood", idx);
      this.calculateTotal();
    },
    submit: function submit() {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee14() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                //this.loading = true;
                _this16.showDialogPing = true;

                _this16.open_orders();

              case 2:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    cancelOrdenaPin: function cancelOrdenaPin() {
      var _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee15() {
        var response, message, newOrdenItems;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                if (!(_this17.pin.length > 3 && _this17.reasonToDelete)) {
                  _context15.next = 23;
                  break;
                }

                if (!_this17.deleteGeneralOrden) {
                  _context15.next = 5;
                  break;
                }

                _this17.deleteGeneralOrdenPin();

                _context15.next = 21;
                break;

              case 5:
                _context15.prev = 5;
                _this17.deleteOrdenLoading = true;
                _context15.next = 9;
                return _this17.$http.post("delete-orden-pin", {
                  id: _this17.ordenIdToDelete,
                  pin: _this17.pin,
                  reason: _this17.reasonToDelete
                });

              case 9:
                response = _context15.sent;

                if (response.status == 200) {
                  if (response.data.success) {
                    message = response.data.message;
                    newOrdenItems = _toConsumableArray(_this17.ordens);
                    newOrdenItems = newOrdenItems.filter(function (n) {
                      return n.id != _this17.ordenIdToDelete;
                    });

                    _this17.$emit("update:ordens", newOrdenItems);

                    _this17.$eventHub.$emit("reloadData");

                    _this17.$toast.success(message);

                    _this17.reasonToDelete = null;
                    _this17.showPinRequest = false;
                  } else {
                    _this17.$toast.error(response.data.message);
                  }
                }

                _context15.next = 17;
                break;

              case 13:
                _context15.prev = 13;
                _context15.t0 = _context15["catch"](5);
                console.log(_context15.t0);

                _this17.$toast.error("Ocurrió un error");

              case 17:
                _context15.prev = 17;
                _this17.pin = "";
                _this17.deleteOrdenLoading = false;
                return _context15.finish(17);

              case 21:
                _context15.next = 25;
                break;

              case 23:
                _this17.$toast.error("Ingrese el pin");

                return _context15.abrupt("return");

              case 25:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15, null, [[5, 13, 17, 21]]);
      }))();
    },
    generatePin: function generatePin(num) {
      if (this.pin.length == 4) {
        return;
      }

      this.pin += num;
    },
    cancelOrdena: function cancelOrdena(id) {
      var _this18 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee16() {
        var x, response, message, newOrdenItems;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                if (!_this18.configuration.pin_orden_delete) {
                  _context16.next = 5;
                  break;
                }

                _this18.showPinRequest = true;
                _this18.ordenIdToDelete = id;
                _context16.next = 20;
                break;

              case 5:
                _context16.prev = 5;
                _context16.next = 8;
                return _this18.$confirm("Est\xE1 apunto de cancelar un producto de una orden.", "Mensaje de Advertencia", {
                  confirmButtonText: "Eliminar",
                  cancelButtonText: "Cancelar",
                  type: "warning"
                });

              case 8:
                x = _context16.sent;

                if (!(id && x)) {
                  _context16.next = 14;
                  break;
                }

                _context16.next = 12;
                return _this18.$http["delete"]("delete-orden/".concat(id));

              case 12:
                response = _context16.sent;

                if (response.status == 200) {
                  message = response.data.message;
                  newOrdenItems = _toConsumableArray(_this18.ordens);
                  newOrdenItems = newOrdenItems.filter(function (n) {
                    return n.id != id;
                  });

                  _this18.$emit("update:ordens", newOrdenItems);

                  _this18.$eventHub.$emit("reloadData");

                  _this18.$toast.success(message);
                }

              case 14:
                _context16.next = 20;
                break;

              case 16:
                _context16.prev = 16;
                _context16.t0 = _context16["catch"](5);
                //todo
                console.log(_context16.t0);

                if (_context16.t0 != "cancel") {
                  _this18.$toast.error("Ocurrió un error");
                }

              case 20:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16, null, [[5, 16]]);
      }))();
    },
    ordenReady: function ordenReady(id) {
      var _this19 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee17() {
        var response, _response$data2, success, message, cloneOrdenItems;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                _this19.loading = true;
                _context17.prev = 1;
                _context17.next = 4;
                return _this19.$http.get("ordens-ready/".concat(id));

              case 4:
                response = _context17.sent;
                _response$data2 = response.data, success = _response$data2.success, message = _response$data2.message;
                success ? _this19.$toast.success(message) : _this19.$toast.error(message);

                if (success) {
                  cloneOrdenItems = _toConsumableArray(_this19.ordens);
                  cloneOrdenItems = cloneOrdenItems.map(function (o) {
                    if (o.id == id) {
                      o.status_orden_id = 3;
                    }

                    return o;
                  });

                  _this19.$emit("update:ordens", cloneOrdenItems);
                }

                _context17.next = 14;
                break;

              case 10:
                _context17.prev = 10;
                _context17.t0 = _context17["catch"](1);
                console.log(_context17.t0);

                _this19.$toast.error("Ocurrió un error");

              case 14:
                _context17.prev = 14;
                _this19.loading = false;
                return _context17.finish(14);

              case 17:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17, null, [[1, 10, 14, 17]]);
      }))();
    },
    changeLocalObservation: function changeLocalObservation() {
      var ordensModified = _toConsumableArray(this.localOrden);

      ordensModified[this.currentLocalOrden].observation = this.localObservation;
      this.$emit("update:localOrden", ordensModified);
      this.closeLocalObservationDialog();
    },
    changeObservation: function changeObservation() {
      var _this20 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee18() {
        var response, newOrdenItems;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee18$(_context18) {
          while (1) {
            switch (_context18.prev = _context18.next) {
              case 0:
                //this.localObservation
                _this20.loadingObservation = true;
                _context18.next = 3;
                return _this20.$http.post("change-observation", {
                  observation: _this20.observation,
                  id: _this20.currentOrden
                });

              case 3:
                response = _context18.sent;

                if (response.status == 200) {
                  _this20.$eventHub.$emit("reloadData");

                  newOrdenItems = _toConsumableArray(_this20.ordens);
                  newOrdenItems.find(function (n) {
                    return n.id == _this20.currentOrden;
                  }).observations = _this20.observation;
                }

                _this20.loadingObservation = false;

                _this20.closeObservationDialog();

              case 7:
              case "end":
                return _context18.stop();
            }
          }
        }, _callee18);
      }))();
    },
    openObservationDialog: function openObservationDialog(id, idx) {
      this.currentOrden = id;
      this.observation = this.ordens[idx].observations;
      this.dialogObservation = true;
    },
    closeObservationDialog: function closeObservationDialog() {
      this.dialogObservation = false;
      this.observation = null;
    },
    openLocalObservationDialog: function openLocalObservationDialog(idx, obs) {
      this.showObservations = true;
      this.currentLocalOrden = idx;
      this.current = obs;
      return;
      this.localObservation = this.localOrden[idx].observation;
      this.dialogLocalObservation = true;
    },
    closeLocalObservationDialog: function closeLocalObservationDialog() {
      this.dialogLocalObservation = false;
      this.currentLocalOrden = null;
      this.localObservation = null;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-28dd8919\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.el-input-group__prepend {\r\n    padding-left: 6px !important;\r\n    padding-right: 6px !important;\n}\n.custom_input .el-input__inner {\r\n    padding: 0 5px !important;\n}\n.el-tag + .el-tag {\r\n    margin-left: 10px;\n}\n.button-new-tag {\r\n    margin-left: 10px;\r\n    height: 32px;\r\n    line-height: 30px;\r\n    padding-top: 0;\r\n    padding-bottom: 0;\n}\n.input-new-tag1 {\r\n    width: 70px;\r\n    margin-left: 10px;\r\n    vertical-align: bottom;\n}\n.input-new-tag1 .el-input__inner {\r\n    height: 30px !important;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/Restaurant/Resources/assets/js/views/pos/partials/modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue"],"names":[],"mappings":";AAqmEA;IACA,6BAAA;IACA,8BAAA;CACA;AAEA;IACA,0BAAA;CACA;AAEA;IACA,kBAAA;CACA;AAEA;IACA,kBAAA;IACA,aAAA;IACA,kBAAA;IACA,eAAA;IACA,kBAAA;CACA;AAEA;IACA,YAAA;IACA,kBAAA;IACA,uBAAA;CACA;AAEA;IACA,wBAAA;CACA","file":"list_ordens.vue","sourcesContent":["<template>\r\n    <div v-loading=\"ordenLoading\">\r\n        <div>\r\n            <div\r\n                v-if=\"screenWidth > 678\"\r\n                class=\"d-md-flex  flex-wrap justify-content-between\"\r\n            >\r\n                <div\r\n                    class=\"dropdown-as-select d-inline-block mb-1\"\r\n                    data-childselector=\"span\"\r\n                >\r\n                    <button\r\n                        class=\"btn p-0\"\r\n                        type=\"button\"\r\n                        data-bs-toggle=\"dropdown\"\r\n                        aria-haspopup=\"true\"\r\n                        aria-expanded=\"false\"\r\n                    >\r\n                        <span\r\n                            class=\"btn btn-primary dropdown-toggle\"\r\n                            data-bs-toggle=\"tooltip\"\r\n                            data-bs-placement=\"top\"\r\n                            data-bs-delay=\"0\"\r\n                            title=\"\"\r\n                            data-bs-original-title=\"Item Count\"\r\n                            aria-label=\"Item Count\"\r\n                            >Menu De Acciones\r\n                        </span>\r\n                    </button>\r\n\r\n                    <div\r\n                        class=\"dropdown-menu dropdown-menu-end col-md-2 col-1 \"\r\n                        style=\"width: 153px;\"\r\n                    >\r\n                        <div\r\n                            class=\"col-12\"\r\n                            v-for=\"(option, idx) in optionsMenu\"\r\n                            :key=\"idx\"\r\n                            v-show=\"option.visible\"\r\n                        >\r\n                            <el-button\r\n                                v-if=\"option.visible\"\r\n                                @click=\"trigerFunction(option.id)\"\r\n                                class=\"\r\n                                            btn btn-light\r\n                                            m-1\r\n                                            rounded\r\n                                            d-flex\r\n                                            flex-column\r\n                                            align-items-center\r\n                                            justify-content-center\r\n                                            col-12\r\n                                            \"\r\n                                style=\"max-width: 150px;\"\r\n                            >\r\n                                <div\r\n                                    class=\"text-center\"\r\n                                    style=\"margin-bottom: 2px\"\r\n                                >\r\n                                    <p\r\n                                        style=\"margin: 0 !important; padding: 0 !important; font-size: 15px;\"\r\n                                        v-for=\"(title, idx2) in option.title\"\r\n                                        :key=\"idx2\"\r\n                                    >\r\n                                        {{ title }}\r\n                                    </p>\r\n                                    <i :class=\"[option.icon, 'fa-1x']\"></i>\r\n                                </div>\r\n                                <div></div>\r\n                            </el-button>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n            <div v-if=\"screenWidth < 600\" class=\"d-flex flex-wrap\">\r\n                <div\r\n                    v-for=\"(option, idx) in optionsMenu\"\r\n                    :key=\"idx\"\r\n                    v-show=\"option.visible\"\r\n                >\r\n                    <div\r\n                        v-if=\"option.visible && option.id != 5\"\r\n                        @click=\"trigerFunction(option.id)\"\r\n                        class=\"\r\n                  m-1\r\n                  btn btn-light\r\n                  rounded\r\n                  d-flex\r\n                  flex-column\r\n                  align-items-center\r\n                  justify-content-center\r\n                \"\r\n                        style=\"max-width: 60px; max-height: 60px\"\r\n                    >\r\n                        <div\r\n                            class=\"text-center\"\r\n                            style=\"margin-bottom: 2px\"\r\n                        ></div>\r\n                        <div>\r\n                            <label\r\n                                v-if=\"option.id == 4\"\r\n                                style=\"margin-left: 2px\"\r\n                                >{{ ordenInBox.length }}</label\r\n                            >\r\n\r\n                            <i :class=\"[option.icon]\"> </i>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div\r\n                class=\"bg-primary align-items-center rounded-top\"\r\n                style=\"padding-top: 12px\"\r\n            >\r\n                <div class=\"row col-12\" v-if=\"clientTableData.table\">\r\n                    <div class=\"col-6\">\r\n                        <h3 class=\"text-white\">\r\n                            <strong style=\"padding-left: 20px\">\r\n                                {{\r\n                                    ` ${\r\n                                        isCreatingOrden\r\n                                            ? \"CREANDO ORDEN\"\r\n                                            : clientTableData.orden_id\r\n                                            ? `(ORDEN n°\r\n                                                                ${clientTableData.orden_id})`\r\n                                            : \"\"\r\n                                    }`\r\n                                }}\r\n                            </strong>\r\n                        </h3>\r\n                    </div>\r\n                    <div class=\"col-6\">\r\n                        <h3 class=\"text-white\" style=\"text-align: right\">\r\n                            Total S/. {{ (total + totalOrdenItems).toFixed(2) }}\r\n                        </h3>\r\n                    </div>\r\n                </div>\r\n\r\n                <div\r\n                    class=\"row h5 text-white col-12\"\r\n                    style=\"padding-left: 25px\"\r\n                    v-if=\"clientTableData.table\"\r\n                >\r\n                    <strong>\r\n                        Mesa {{ clientTableData.table }}- Ref:\r\n                        {{ clientTableData.ref }}\r\n                    </strong>\r\n                </div>\r\n                <div class=\"row col-12\">\r\n                    <div class=\"h5 text-white col-6\" style=\"padding-left: 25px\">\r\n                        <strong v-if=\"!clientTableData.table\">\r\n                            <template v-if=\"!isConsignment\">\r\n                                VENTA DIRECTA\r\n                            </template>\r\n                            <template v-else>\r\n                                LIQUIDACIÓN DE CONSIGNACIÓN\r\n                            </template>\r\n                        </strong>\r\n                    </div>\r\n\r\n                    <div class=\"col-6\">\r\n                        <h3\r\n                            v-if=\"!clientTableData.table\"\r\n                            class=\"text-white\"\r\n                            style=\"text-align: right\"\r\n                        >\r\n                            Total S/. {{ (total + totalOrdenItems).toFixed(2) }}\r\n                        </h3>\r\n                    </div>\r\n                </div>\r\n\r\n                <!-- <div\r\n                    class=\"p-1 m-1 col-3 rounded text-center d-flex flex-column align-items-center justify-content-center\"\r\n                    style=\"color:darkblue;font-weight:bold;background-color:gray\"\r\n                >\r\n                    <div>\r\n                        <strong>Por enviar </strong>\r\n                        S/. {{ total ? total.toFixed(2) : 0.0 }}\r\n                    </div>\r\n                    <div v-if=\"ordens.length != 0\">\r\n                        <strong>Atendidos </strong>\r\n                        S/.\r\n                        {{ totalOrdenItems ? totalOrdenItems.toFixed(2) : 0.0 }}\r\n                    </div>\r\n                </div> -->\r\n            </div>\r\n            <div :class=\"`p-1 bg-primary`\">\r\n                <div class=\"row col-md-12 mx-1\">\r\n                    <div>\r\n                        <template\r\n                            v-if=\"\r\n                                this.quotation_stock &&\r\n                                    configuration.quotation &&\r\n                                    localOrden.length != 0\r\n                            \"\r\n                        >\r\n                            <button\r\n                                alt=\"Cotizar \"\r\n                                class=\"btn btn-light mt-2\"\r\n                                type=\"button\"\r\n                                @click=\"openQuotation\"\r\n                                style=\"max-height: 45px ; max-width: 80px;\"\r\n                            >\r\n                                <i\r\n                                    class=\"fas fa-clipboard-list\"\r\n                                    style=\"color: var(--primary) !important\"\r\n                                ></i>\r\n                                <br />\r\n                                Cotizar\r\n                            </button>\r\n                        </template>\r\n                        <template v-else>\r\n                            <button\r\n                                alt=\"Cobrar La venta \"\r\n                                v-if=\"isCreatingOrden == false\"\r\n                                class=\"btn btn-light mt-2\"\r\n                                type=\"button\"\r\n                                @click=\"payOrden()\"\r\n                                style=\"max-height: 45px ; max-width: 80px;\"\r\n                            >\r\n                                <i\r\n                                    class=\"fas fa-money-bill-wave\"\r\n                                    style=\"color: var(--primary) !important\"\r\n                                ></i>\r\n                                <br />\r\n                                Cobrar\r\n                            </button>\r\n                        </template>\r\n\r\n                        <button\r\n                            v-if=\"\r\n                                isCreatingOrden == true ||\r\n                                    clientTableData.table == undefined\r\n                            \"\r\n                            class=\"btn btn-light mt-2\"\r\n                            type=\"button\"\r\n                            @click=\"cancelOrden\"\r\n                            style=\"max-height: 45px ; max-width: 80px;\"\r\n                        >\r\n                            <i\r\n                                class=\"fas fa-trash\"\r\n                                style=\"color: var(--primary) !important\"\r\n                            ></i>\r\n                            <br />\r\n                            Limpiar\r\n                        </button>\r\n\r\n                        <button\r\n                            v-if=\"\r\n                                (isCreatingOrden == true ||\r\n                                    clientTableData.orden_id) &&\r\n                                    localOrden.length != 0\r\n                            \"\r\n                            class=\"btn btn-light mt-2\"\r\n                            type=\"button\"\r\n                            @click=\"sendOrden()\"\r\n                            style=\"max-height: 45px ; max-width: 80px;\"\r\n                        >\r\n                            <i\r\n                                class=\"fas fa-paper-plane\"\r\n                                style=\"color: var(--primary) !important\"\r\n                            ></i\r\n                            ><br />\r\n                            Enviar\r\n                        </button>\r\n                        <button\r\n                            v-if=\"\r\n                                isCreatingOrden == false &&\r\n                                    clientTableData.table != undefined &&\r\n                                    ordens.length != 0\r\n                            \"\r\n                            class=\"btn btn-light mt-2\"\r\n                            type=\"button\"\r\n                            @click=\"printOrden()\"\r\n                            style=\"max-height: 45px ; max-width: 80px;\"\r\n                        >\r\n                            <i\r\n                                class=\"fas fa-print\"\r\n                                style=\"color: var(--primary) !important\"\r\n                            ></i\r\n                            ><br />\r\n                            Imprimir\r\n                        </button>\r\n\r\n                        <button\r\n                            v-if=\"\r\n                                isCreatingOrden == false &&\r\n                                    clientTableData.table != undefined &&\r\n                                    ordens.length != 0\r\n                            \"\r\n                            class=\"btn btn-light mt-2\"\r\n                            type=\"button\"\r\n                            style=\"max-height: 45px ;  max-width: 80px;\"\r\n                            @click=\"\r\n                                cancelGeneralOrden(clientTableData.orden_id)\r\n                            \"\r\n                        >\r\n                            <i\r\n                                class=\"fas fa-window-close\"\r\n                                style=\"color: var(--primary) !important\"\r\n                            ></i\r\n                            ><br />\r\n                            Cancelar\r\n                        </button>\r\n                        <div\r\n                            class=\"dropdown-as-select d-inline-block mt-2\"\r\n                            data-childselector=\"span\"\r\n                        >\r\n                            <button\r\n                                class=\"btn p-0\"\r\n                                type=\"button\"\r\n                                data-bs-toggle=\"dropdown\"\r\n                                aria-haspopup=\"true\"\r\n                                aria-expanded=\"false\"\r\n                                style=\"max-height: 45px ;max-width: 150px;\"\r\n                            >\r\n                                <span\r\n                                    class=\"btn btn-light dropdown-toggle\"\r\n                                    data-bs-toggle=\"tooltip\"\r\n                                    data-bs-placement=\"top\"\r\n                                    data-bs-delay=\"0\"\r\n                                    title=\"\"\r\n                                    data-bs-original-title=\"Item Count\"\r\n                                    aria-label=\"Item Count\"\r\n                                >\r\n                                    Mas Opciones..<i\r\n                                        class=\"fas fa-list\"\r\n                                        style=\"color: var(--primary) !important\"\r\n                                    ></i>\r\n                                </span>\r\n                            </button>\r\n\r\n                            <div\r\n                                class=\"dropdown-menu dropdown-menu-start col-md-2 col-1\"\r\n                                style=\"max-width: 154px;\"\r\n                            >\r\n                                <div class=\"col-12\">\r\n                                    <el-button\r\n                                        v-if=\"\r\n                                            isCreatingOrden == false &&\r\n                                                clientTableData.table ==\r\n                                                    undefined &&\r\n                                                !configuration.college\r\n                                        \"\r\n                                        @click=\"openApart\"\r\n                                        class=\"\r\n                                            btn btn-light\r\n                                            m-1\r\n                                            rounded\r\n                                            d-flex\r\n                                            flex-column\r\n                                            align-items-center\r\n                                            justify-content-center\r\n                                            col-12\r\n                                            \"\r\n                                        style=\"max-width: 150px;\"\r\n                                    >\r\n                                        <div\r\n                                            class=\"text-center\"\r\n                                            style=\"margin-bottom: 2px\"\r\n                                        >\r\n                                            <span\r\n                                                style=\"margin: 0 !important; padding: 0 !important\"\r\n                                            >\r\n                                                Aparcar\r\n                                            </span>\r\n                                            <i\r\n                                                class=\"fas fa-cart-arrow-down\"\r\n                                                style=\"color: var(--primary) !important\"\r\n                                            ></i>\r\n                                        </div>\r\n                                        <div></div>\r\n                                    </el-button>\r\n                                    <div></div>\r\n                                </div>\r\n                                <!-- <div class=\"col-12\">\r\n                                    <el-button\r\n                                        v-if=\"\r\n                                            configuration.quotation &&\r\n                                                localOrden.length != 0\r\n                                        \"\r\n                                        class=\"btn btn-light\r\n                                            m-1\r\n                                            rounded\r\n                                            d-flex\r\n                                            flex-column\r\n                                            align-items-center\r\n                                            justify-content-center\r\n                                            col-12\r\n                                            \"\r\n                                        type=\"button\"\r\n                                        @click=\"openQuotation\"\r\n                                        style=\"max-height: 45px ;max-width: 150px;\"\r\n                                    >\r\n                                        <div\r\n                                            class=\"text-center\"\r\n                                            style=\"margin-bottom: 2px\"\r\n                                        >\r\n                                            <span\r\n                                                style=\"margin: 0 !important; padding: 0 !important\"\r\n                                            >\r\n                                                Cotizar </span\r\n                                            ><i\r\n                                                class=\"fas fa-clipboard-list\"\r\n                                                style=\"color: var(--primary) !important\"\r\n                                            ></i>\r\n                                        </div>\r\n                                        <div></div>\r\n                                    </el-button>\r\n                                </div> -->\r\n                                <div class=\"col-12\">\r\n                                    <el-button\r\n                                        v-if=\"\r\n                                            configuration.consignment &&\r\n                                                localOrden.length != 0\r\n                                        \"\r\n                                        class=\"btn btn-light\r\n                                            m-1\r\n                                            rounded\r\n                                            d-flex\r\n                                            flex-column\r\n                                            align-items-center\r\n                                            justify-content-center\r\n                                            col-12\r\n                                            \"\r\n                                        type=\"button\"\r\n                                        @click=\"openConsignment\"\r\n                                        style=\"max-height: 45px ;max-width: 150px;\"\r\n                                    >\r\n                                        <div\r\n                                            class=\"text-center\"\r\n                                            style=\"margin-bottom: 2px\"\r\n                                        >\r\n                                            <span\r\n                                                style=\"margin: 0 !important; padding: 0 !important\"\r\n                                            >\r\n                                                Consignar </span\r\n                                            ><i\r\n                                                class=\"fas fa-clipboard-list\"\r\n                                                style=\"color: var(--primary) !important\"\r\n                                            ></i>\r\n                                        </div>\r\n                                        <div></div>\r\n                                    </el-button>\r\n                                </div>\r\n                                <div class=\"col-12\">\r\n                                    <el-button\r\n                                        v-if=\"\r\n                                            configuration.credits &&\r\n                                                localOrden.length != 0\r\n                                        \"\r\n                                        @click=\"openCredit\"\r\n                                        class=\"\r\n                                            btn btn-light\r\n                                            m-1\r\n                                            rounded\r\n                                            d-flex\r\n                                            flex-column\r\n                                            align-items-center\r\n                                            justify-content-center\r\n                                            col-12\r\n                                            \"\r\n                                        style=\"max-width: 150px;\"\r\n                                    >\r\n                                        <div\r\n                                            class=\"text-center\"\r\n                                            style=\"margin-bottom: 2px\"\r\n                                        >\r\n                                            <span\r\n                                                style=\"margin: 0 !important; padding: 0 !important\"\r\n                                            >\r\n                                                Crédito\r\n                                            </span>\r\n                                            <i\r\n                                                class=\"fas fa-credit-card\"\r\n                                                style=\"color: var(--primary) !important\"\r\n                                            ></i>\r\n                                        </div>\r\n                                        <div></div>\r\n                                    </el-button>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <div v-if=\"clientTableData.table\" class=\"col-md-3\">\r\n                        <button\r\n                            @click=\"directSale\"\r\n                            class=\"btn btn-warning mt-2\"\r\n                            type=\"button\"\r\n                            style=\"max-height: 45px ;\"\r\n                        >\r\n                            Venta Directa\r\n                        </button>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row col-md-12\">\r\n                    <div class=\"row col-md-12 mx-1\">\r\n                        <div class=\"col-md-3\"></div>\r\n                        <div class=\"col-md-3\"></div>\r\n                    </div>\r\n                    <!-- <div class=\"col-4\">\r\n                        <div v-if=\"ordens.length > 0 || localOrden.length > 0\"\r\n                            class=\"d-flex flex-column p-2 text-white\">\r\n                            <div class=\"row p-r-10 \">\r\n                                <div class=\"col-12 f-w-700 text-end p-t-5\">\r\n                                    POR ATENDER S/ {{ total.toFixed(2) }}\r\n                                </div>\r\n                                <div class=\"col-12 f-w-700 text-end p-t-5\">\r\n                                    ATENDIDO S/ {{ totalOrdenItems.toFixed(2) }}\r\n                                </div>\r\n                                <div class=\"col-12 f-w-700 text-end p-t-5 p-b-5\">\r\n                                    TOTAL S/\r\n                                    {{ (total + totalOrdenItems).toFixed(2) }}\r\n                                </div>\r\n                                <div v-if=\"variation\" class=\"col-12 f-w-700 text-end text-black p-t-5 p-b-5\">\r\n                                    <template v-if=\"\r\n                                        !isNaN(foodDefault.sale_unit_price)\r\n                                    \">\r\n                                        <strong>\r\n                                            VARIACION S/\r\n                                            {{\r\n                                                Number(\r\n                                                    foodDefault.sale_unit_price\r\n                                                                                        ).toFixed(2)\r\n                                            }}\r\n                                        </strong>\r\n                                    </template>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div> -->\r\n                </div>\r\n                <div class=\"d-flex align-items-center p-1 m-2\">\r\n                    <div class=\"col-12\">\r\n                        <template\r\n                            v-if=\"\r\n                                configuration.restaurant &&\r\n                                    (clientTableData.table == undefined ||\r\n                                        configuration.box_orden)\r\n                            \"\r\n                        >\r\n                            <el-checkbox\r\n                                v-if=\"\r\n                                    localOrden.length != 0 &&\r\n                                        !configuration.college\r\n                                \"\r\n                                v-model=\"to_carry\"\r\n                                @change=\"allToCarry\"\r\n                            >\r\n                                <span class=\"text-white\"\r\n                                    >Para llevar</span\r\n                                ></el-checkbox\r\n                            >\r\n                        </template>\r\n                        <template>\r\n                            <el-checkbox\r\n                                class=\"margin-left:5px;\"\r\n                                v-model=\"variation\"\r\n                                @change=\"changeVariation\"\r\n                                v-if=\"configuration.show_variation_dcto\"\r\n                            >\r\n                                <span class=\"text-white\"\r\n                                    >Variación</span\r\n                                ></el-checkbox\r\n                            >\r\n                        </template>\r\n                        <template>\r\n                            <el-checkbox\r\n                                class=\"margin-left:5px;\"\r\n                                v-model=\"quotation_stock\"\r\n                                @change=\"setQuotationStock\"\r\n                                v-if=\"configuration.quotation\"\r\n                            >\r\n                                <span class=\"text-white\"\r\n                                    >Para cotizar\r\n                                    <el-tooltip\r\n                                        content=\"No se toma en cuenta el stock de los productos\"\r\n                                    >\r\n                                        <i\r\n                                            class=\"el-tooltip fa fa-info-circle item\"\r\n                                        ></i>\r\n                                    </el-tooltip>\r\n                                </span>\r\n                            </el-checkbox>\r\n                        </template>\r\n                        <template>\r\n                            <el-input\r\n                                v-if=\"\r\n                                    !configuration.college &&\r\n                                        configuration.restaurant\r\n                                \"\r\n                                type=\"text\"\r\n                                maxlength=\"11\"\r\n                                show-word-limit\r\n                                v-model=\"clientTableData.ref\"\r\n                                placeholder=\"Referencia (DNI)\"\r\n                            ></el-input>\r\n                        </template>\r\n                    </div>\r\n\r\n                    <div\r\n                        class=\"col-md-6 d-flex  justify-content-end align-items-end\"\r\n                        v-if=\"\r\n                            establishments.conf &&\r\n                                establishments.conf.direct_sale\r\n                        \"\r\n                    >\r\n                        <div\r\n                            class=\"d-flex flex-column\"\r\n                            style=\"margin-left:15px;\"\r\n                        >\r\n                            <label class=\"text-white\">Venta rápida</label>\r\n                            <el-switch\r\n                                @change=\"changeQuickSale\"\r\n                                v-model=\"establishments.conf.pos_quick_sale\"\r\n                                active-color=\"#13ce66\"\r\n                                inactive-color=\"#ff4949\"\r\n                            >\r\n                            </el-switch>\r\n                        </div>\r\n                        <div\r\n                            class=\"d-flex flex-column\"\r\n                            style=\"margin-left:15px;\"\r\n                        >\r\n                            <template v-if=\"establishments.conf.pos_quick_sale\">\r\n                                <label class=\"text-white\">Impresión</label>\r\n                                <el-switch\r\n                                    @change=\"savePrint\"\r\n                                    v-model=\"printing\"\r\n                                    active-color=\"#13ce66\"\r\n                                    inactive-color=\"#ff4949\"\r\n                                >\r\n                                </el-switch>\r\n                            </template>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <section\r\n                    v-loading=\"loading\"\r\n                    class=\"scroll-section border bg-white\"\r\n                    vid=\"checkboxes\"\r\n                >\r\n                    <div class=\"scroll-out\">\r\n                        <div\r\n                            class=\"\r\n                scroll-by-count\r\n                os-host\r\n                os-theme-dark\r\n                os-host-overflow\r\n                os-host-overflow-y\r\n                os-host-resize-disabled\r\n                os-host-scrollbar-horizontal-hidden\r\n                os-host-transition\r\n              \"\r\n                            data-count=\"4\"\r\n                            id=\"checkboxTable\"\r\n                            style=\"height: 71vh\"\r\n                        >\r\n                            <!-- calc(100vh - 8rem); -->\r\n                            <div class=\"os-resize-observer-host observed\">\r\n                                <div\r\n                                    class=\"os-resize-observer\"\r\n                                    style=\"left: 0px; right: auto\"\r\n                                ></div>\r\n                            </div>\r\n                            <div\r\n                                class=\"os-size-auto-observer observed\"\r\n                                style=\"height: calc(100% + 1px); float: left\"\r\n                            >\r\n                                <div class=\"os-resize-observer\"></div>\r\n                            </div>\r\n                            <div\r\n                                class=\"os-content-glue\"\r\n                                style=\"margin: 0px 5px\"\r\n                            ></div>\r\n                            <div class=\"os-padding\">\r\n                                <div\r\n                                    class=\"os-viewport\"\r\n                                    style=\"overflow-y: scroll; margin-right: 15px\"\r\n                                >\r\n                                    <div class=\"m-3\"></div>\r\n                                    <div\r\n                                        class=\"os-content\"\r\n                                        style=\"padding: 0px 5px; height: 100%; width: 100%\"\r\n                                    >\r\n                                        <div\r\n                                            v-if=\"\r\n                                                ordens.length != 0 && !variation\r\n                                            \"\r\n                                            class=\"\r\n                        mx-2\r\n                        h4\r\n                        txt-info\r\n                        p-10\r\n                        f-w-700\r\n                        d-flex\r\n                        align-items-center\r\n                      \"\r\n                                        >\r\n                                            <a\r\n                                                class=\"badge badge bg-dark text-white\"\r\n                                                style=\"margin-right: 5px\"\r\n                                            >\r\n                                                <template\r\n                                                    v-if=\"ordens.length <= 9\"\r\n                                                >\r\n                                                    0{{ ordens.length }}\r\n                                                </template>\r\n                                                <template v-else>\r\n                                                    {{ ordens.length }}\r\n                                                </template>\r\n                                            </a>\r\n                                            Atendidos\r\n                                        </div>\r\n                                        <div\r\n                                            v-if=\"variation\"\r\n                                            class=\"col-sm-12 col-md-12 col-lg-12 col-xl-12\"\r\n                                        >\r\n                                            <div\r\n                                                v-for=\"(variationItem,\r\n                                                idx) in foodDefaults\"\r\n                                                :key=\"idx\"\r\n                                                class=\"\r\n                          mx-2\r\n                          coupon\r\n                          rounded\r\n                          d-flex\r\n                          justify-content-between\r\n                        \"\r\n                                            >\r\n                                                <div\r\n                                                    class=\"\r\n                            tengah\r\n                            py-2\r\n                            d-flex\r\n                            w-100\r\n                            justify-content-start\r\n                            p-2\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"overflow-hidden\"\r\n                                                    >\r\n                                                        <h3\r\n                                                            class=\"lead font-weight-light\"\r\n                                                        >\r\n                                                            {{\r\n                                                                variationItem.description.toUpperCase()\r\n                                                            }}\r\n                                                            <el-tag\r\n                                                                role=\"button\"\r\n                                                                @click=\"\r\n                                                                    showChangeDescription(\r\n                                                                        idx\r\n                                                                    )\r\n                                                                \"\r\n                                                            >\r\n                                                                Cambiar\r\n                                                            </el-tag>\r\n\r\n                                                            <el-tag\r\n                                                                type=\"success\"\r\n                                                                v-if=\"idx == 0\"\r\n                                                                role=\"button\"\r\n                                                                @click=\"\r\n                                                                    addVariation\r\n                                                                \"\r\n                                                            >\r\n                                                                Agregar\r\n                                                            </el-tag>\r\n                                                            <el-tag\r\n                                                                v-if=\"\r\n                                                                    foodDefaults.length >\r\n                                                                        1\r\n                                                                \"\r\n                                                                type=\"danger\"\r\n                                                                role=\"button\"\r\n                                                                @click=\"\r\n                                                                    deleteDefaultFood(\r\n                                                                        idx\r\n                                                                    )\r\n                                                                \"\r\n                                                                >x\r\n                                                            </el-tag>\r\n                                                        </h3>\r\n                                                        <p\r\n                                                            class=\"\r\n                                badge\r\n                                bg-foreground\r\n                                text-uppercase\r\n                                font-weight-light\r\n                                p-0\r\n                              \"\r\n                                                        ></p>\r\n                                                        <div\r\n                                                            class=\"row align-items-end\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"col-md-4\"\r\n                                                            >\r\n                                                                <span\r\n                                                                    class=\"text-muted\"\r\n                                                                >\r\n                                                                    Cantidad<br />\r\n                                                                    <div\r\n                                                                        class=\"input-group spinner\"\r\n                                                                    >\r\n                                                                        <input\r\n                                                                            type=\"text\"\r\n                                                                            class=\"form-control text-center\"\r\n                                                                            v-model=\"\r\n                                                                                variationItem.quantity\r\n                                                                            \"\r\n                                                                            data-rule=\"currency\"\r\n                                                                        />\r\n                                                                        <div\r\n                                                                            class=\"input-group-text\"\r\n                                                                        >\r\n                                                                            <button\r\n                                                                                type=\"button\"\r\n                                                                                class=\"spin-up\"\r\n                                                                                data-spin=\"up\"\r\n                                                                                @click=\"\r\n                                                                                    updateDefaultFoodQty(\r\n                                                                                        true,\r\n                                                                                        idx\r\n                                                                                    )\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                <span\r\n                                                                                    class=\"arrow\"\r\n                                                                                ></span>\r\n                                                                            </button>\r\n                                                                            <button\r\n                                                                                type=\"button\"\r\n                                                                                class=\"spin-down\"\r\n                                                                                data-spin=\"down\"\r\n                                                                                @click=\"\r\n                                                                                    updateDefaultFoodQty(\r\n                                                                                        false,\r\n                                                                                        idx\r\n                                                                                    )\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                <span\r\n                                                                                    class=\"arrow\"\r\n                                                                                ></span>\r\n                                                                            </button>\r\n                                                                        </div>\r\n                                                                    </div>\r\n                                                                </span>\r\n                                                            </div>\r\n\r\n                                                            <div\r\n                                                                class=\"col-md-4\"\r\n                                                            >\r\n                                                                <span\r\n                                                                    class=\"time font-weight-light\"\r\n                                                                >\r\n                                                                    <span\r\n                                                                        class=\"text-muted\"\r\n                                                                    >\r\n                                                                        Precio\r\n                                                                        <br />\r\n                                                                        <el-input\r\n                                                                            class=\"custom_input\"\r\n                                                                            style=\"width: 100%\"\r\n                                                                            type=\"number\"\r\n                                                                            v-model=\"\r\n                                                                                variationItem.sale_unit_price\r\n                                                                            \"\r\n                                                                        >\r\n                                                                            <template\r\n                                                                                slot=\"prepend\"\r\n                                                                                style=\"\r\n                                          padding-left: 6px;\r\n                                          padding-right: 6px;\r\n                                        \"\r\n                                                                            >\r\n                                                                                S/\r\n                                                                            </template>\r\n                                                                        </el-input>\r\n                                                                    </span>\r\n                                                                </span>\r\n                                                            </div>\r\n                                                        </div>\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div\r\n                                            v-show=\"\r\n                                                ordens.length > 0 && !variation\r\n                                            \"\r\n                                            class=\"col-sm-12 col-md-12 col-lg-12 col-xl-12\"\r\n                                            v-for=\"(ord, idx) in ordens\"\r\n                                            :key=\"`${idx}-A`\"\r\n                                        >\r\n                                            <div\r\n                                                class=\"\r\n                          mx-2\r\n                          coupon\r\n                          rounded\r\n                          d-flex\r\n                          justify-content-between\r\n                        \"\r\n                                            >\r\n                                                <div\r\n                                                    class=\"\r\n                            tengah\r\n                            py-2\r\n                            d-flex\r\n                            w-100\r\n                            justify-content-start\r\n                            p-2\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"overflow-hidden card shadow-lg p-3\"\r\n                                                        style=\"\r\n                              box-shadow: rgba(0, 0, 0, 0.18) 0px 1rem 3rem !important;\r\n                            \"\r\n                                                    >\r\n                                                        <h3\r\n                                                            class=\"lead font-weight-light\"\r\n                                                        >\r\n                                                            {{\r\n                                                                ord.food.description.toUpperCase()\r\n                                                            }}\r\n                                                            <span\r\n                                                                v-if=\"\r\n                                                                    ord.type_id\r\n                                                                \"\r\n                                                                class=\"text-primary\"\r\n                                                            >\r\n                                                                <small\r\n                                                                    ><strong\r\n                                                                        >*{{\r\n                                                                            ord.type_description\r\n                                                                        }}</strong\r\n                                                                    >\r\n                                                                </small>\r\n                                                            </span>\r\n                                                        </h3>\r\n                                                        <p\r\n                                                            class=\"\r\n                                badge\r\n                                bg-foreground\r\n                                text-uppercase\r\n                                font-weight-light\r\n                                p-0\r\n                              \"\r\n                                                        ></p>\r\n                                                        <div\r\n                                                            class=\"row align-items-end\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"col-5 col-md-5 col-lg-3 col-xl-4\"\r\n                                                            >\r\n                                                                <span\r\n                                                                    class=\"text-muted\"\r\n                                                                >\r\n                                                                    Cantidad<br />\r\n                                                                    <div\r\n                                                                        class=\"input-group spinner\"\r\n                                                                        data-trigger=\"spinner\"\r\n                                                                    >\r\n                                                                        <input\r\n                                                                            type=\"text\"\r\n                                                                            readonly\r\n                                                                            class=\"form-control text-center\"\r\n                                                                            v-model=\"\r\n                                                                                ord.quantity\r\n                                                                            \"\r\n                                                                            data-rule=\"currency\"\r\n                                                                        />\r\n                                                                        <div\r\n                                                                            class=\"input-group-text\"\r\n                                                                        >\r\n                                                                            <button\r\n                                                                                type=\"button\"\r\n                                                                                class=\"spin-up\"\r\n                                                                                data-spin=\"up\"\r\n                                                                            >\r\n                                                                                <span\r\n                                                                                    class=\"arrow\"\r\n                                                                                ></span>\r\n                                                                            </button>\r\n                                                                            <button\r\n                                                                                type=\"button\"\r\n                                                                                class=\"spin-down\"\r\n                                                                                data-spin=\"down\"\r\n                                                                            >\r\n                                                                                <span\r\n                                                                                    class=\"arrow\"\r\n                                                                                ></span>\r\n                                                                            </button>\r\n                                                                        </div>\r\n                                                                    </div>\r\n                                                                </span>\r\n                                                            </div>\r\n\r\n                                                            <div\r\n                                                                class=\"col-6 col-md-5 col-lg-3 col-xl-4\"\r\n                                                            >\r\n                                                                <span\r\n                                                                    class=\"time font-weight-light\"\r\n                                                                >\r\n                                                                    <span\r\n                                                                        class=\"text-muted\"\r\n                                                                    >\r\n                                                                        Precio\r\n                                                                        <br />\r\n                                                                        <el-input\r\n                                                                            class=\"custom_input\"\r\n                                                                            style=\"width: 100%\"\r\n                                                                            type=\"number\"\r\n                                                                            v-model=\"\r\n                                                                                ord.price\r\n                                                                            \"\r\n                                                                            @input=\"\r\n                                                                                calculateTotal\r\n                                                                            \"\r\n                                                                        >\r\n                                                                            <template\r\n                                                                                slot=\"prepend\"\r\n                                                                                v-if=\"\r\n                                                                                    ord\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .currency_type_id ==\r\n                                                                                        'PEN'\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                S/\r\n                                                                            </template>\r\n                                                                            <template\r\n                                                                                slot=\"prepend\"\r\n                                                                                v-if=\"\r\n                                                                                    ord\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .currency_type_id ==\r\n                                                                                        'USD'\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                $\r\n                                                                            </template>\r\n                                                                        </el-input>\r\n                                                                    </span>\r\n                                                                </span>\r\n                                                            </div>\r\n                                                            <div\r\n                                                                class=\"col-md-6 m2 mt-2\"\r\n                                                            >\r\n                                                                <el-button-group>\r\n                                                                    <el-button\r\n                                                                        v-if=\"\r\n                                                                            ord.status_orden_id !=\r\n                                                                                3\r\n                                                                        \"\r\n                                                                        @click=\"\r\n                                                                            ordenReady(\r\n                                                                                ord.id\r\n                                                                            )\r\n                                                                        \"\r\n                                                                        type=\"success\"\r\n                                                                        icon=\"el-icon-check\"\r\n                                                                        size=\"mini\"\r\n                                                                        circle\r\n                                                                    ></el-button>\r\n                                                                    <el-button\r\n                                                                        class=\"text-white\"\r\n                                                                        type=\"danger\"\r\n                                                                        icon=\"el-icon-delete\"\r\n                                                                        size=\"mini\"\r\n                                                                        circle\r\n                                                                        @click=\"\r\n                                                                            cancelOrdena(\r\n                                                                                ord.id\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                    </el-button>\r\n                                                                </el-button-group>\r\n                                                                <el-tag\r\n                                                                    size=\"medium\"\r\n                                                                >\r\n                                                                    <strong\r\n                                                                        style=\"font-weight: 700\"\r\n                                                                    >\r\n                                                                        {{\r\n                                                                            parseFloat(\r\n                                                                                ord.price *\r\n                                                                                    ord.quantity\r\n                                                                            ).toFixed(\r\n                                                                                2\r\n                                                                            )\r\n                                                                        }}</strong\r\n                                                                    >\r\n                                                                </el-tag>\r\n                                                            </div>\r\n                                                            <div\r\n                                                                v-if=\"\r\n                                                                    configuration.restaurant &&\r\n                                                                        ord.observations\r\n                                                                \"\r\n                                                                class=\"col-md-12 mt-1\"\r\n                                                            >\r\n                                                                <small\r\n                                                                    >OBS:\r\n                                                                    {{\r\n                                                                        ord.observations\r\n                                                                    }}</small\r\n                                                                >\r\n                                                            </div>\r\n                                                        </div>\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n\r\n                                        <div\r\n                                            v-if=\"configuration.restaurant\"\r\n                                            class=\"\r\n                        mx-4\r\n                        h4\r\n                        txt-info\r\n                        p-10\r\n                        f-w-700\r\n                        d-flex\r\n                        align-items-center\r\n                      \"\r\n                                        >\r\n                                            <a\r\n                                                class=\"badge badge bg-dark text-white\"\r\n                                                style=\"margin-right: 5px\"\r\n                                            >\r\n                                                <template\r\n                                                    v-if=\"\r\n                                                        localOrden.length <= 9\r\n                                                    \"\r\n                                                >\r\n                                                    0{{ localOrden.length }}\r\n                                                </template>\r\n                                                <template v-else>\r\n                                                    {{ localOrden.length }}\r\n                                                </template>\r\n                                            </a>\r\n                                            Por solicitar\r\n                                        </div>\r\n                                        <div\r\n                                            v-show=\"localOrden.length > 0\"\r\n                                            class=\"col-sm-12 col-md-12 col-lg-12 col-xl-12\"\r\n                                            v-for=\"(order_pend,\r\n                                            indexx) in localOrden\"\r\n                                            :key=\"indexx\"\r\n                                        >\r\n                                            <!--  -->\r\n                                            <div\r\n                                                class=\"\r\n                          mx-2\r\n                          coupon\r\n                          rounded\r\n                          d-flex\r\n                          justify-content-between\r\n                        \"\r\n                                            >\r\n                                                <div\r\n                                                    class=\"\r\n                            tengah\r\n                            py-2\r\n                            d-flex\r\n                            w-100\r\n                            justify-content-start\r\n                            p-2\r\n                          \"\r\n                                                >\r\n                                                    <div\r\n                                                        class=\"\r\n                              col-md-12\r\n                              overflow-hidden\r\n                              card\r\n                              shadow-lg\r\n                              p-3\r\n                              rounded\r\n                            \"\r\n                                                        style=\"\r\n                              box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%) !important;\r\n                            \"\r\n                                                    >\r\n                                                        <div class=\"row\">\r\n                                                            <h3\r\n                                                                class=\"lead font-weight-light\"\r\n                                                            >\r\n                                                                <template\r\n                                                                    v-if=\"\r\n                                                                        order_pend\r\n                                                                            .food\r\n                                                                            .item\r\n                                                                            .name_product_pdf\r\n                                                                    \"\r\n                                                                >\r\n                                                                    {{\r\n                                                                        order_pend.food.item.name_product_pdf.toUpperCase()\r\n                                                                    }}\r\n                                                                </template>\r\n                                                                <template\r\n                                                                    v-else\r\n                                                                >\r\n                                                                    {{\r\n                                                                        order_pend.food.description.toUpperCase()\r\n                                                                    }}\r\n                                                                </template>\r\n\r\n                                                                <span\r\n                                                                    v-if=\"\r\n                                                                        order_pend.type_id\r\n                                                                    \"\r\n                                                                    class=\"text-primary\"\r\n                                                                >\r\n                                                                    <small>\r\n                                                                        <strong\r\n                                                                            >*{{\r\n                                                                                order_pend.type_description\r\n                                                                            }}</strong\r\n                                                                        >\r\n                                                                    </small>\r\n                                                                </span>\r\n                                                                <el-tooltip\r\n                                                                    v-if=\"\r\n                                                                        configuration.edit_name_product\r\n                                                                    \"\r\n                                                                    content=\"Cambiar nombre del producto\"\r\n                                                                >\r\n                                                                    <el-tag\r\n                                                                        role=\"button\"\r\n                                                                        type=\"success\"\r\n                                                                        size=\"mini\"\r\n                                                                        @click=\"\r\n                                                                            changeName(\r\n                                                                                indexx\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                        <i\r\n                                                                            class=\"fas fa-edit text-black\"\r\n                                                                        ></i>\r\n                                                                    </el-tag>\r\n                                                                </el-tooltip>\r\n                                                                <el-tooltip\r\n                                                                    v-if=\"\r\n                                                                        order_pend\r\n                                                                            .food\r\n                                                                            .item\r\n                                                                            .name_product_pdf\r\n                                                                    \"\r\n                                                                    content=\"Restaurar nombre del producto\"\r\n                                                                >\r\n                                                                    <el-tag\r\n                                                                        role=\"button\"\r\n                                                                        type=\"danger\"\r\n                                                                        size=\"mini\"\r\n                                                                        @click=\"\r\n                                                                            restoreName(\r\n                                                                                indexx\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                        <i\r\n                                                                            class=\"fas fa-times text-black\"\r\n                                                                        ></i>\r\n                                                                    </el-tag>\r\n                                                                </el-tooltip>\r\n                                                            </h3>\r\n                                                            <p\r\n                                                                class=\"\r\n                                  badge\r\n                                  bg-foreground\r\n                                  text-uppercase\r\n                                  font-weight-light\r\n                                  p-0\r\n                                \"\r\n                                                            ></p>\r\n                                                        </div>\r\n                                                        <div class=\"row col-12\">\r\n                                                            <div\r\n                                                                class=\"col-2 col-md-2\"\r\n                                                                v-if=\"\r\n                                                                    !configuration.college\r\n                                                                \"\r\n                                                            >\r\n                                                                <el-tag\r\n                                                                    v-if=\"\r\n                                                                        configuration.restaurant\r\n                                                                    \"\r\n                                                                    @click=\"\r\n                                                                        toCarry(\r\n                                                                            indexx\r\n                                                                        )\r\n                                                                    \"\r\n                                                                    size=\"medium\"\r\n                                                                    role=\"button\"\r\n                                                                    :type=\"\r\n                                                                        order_pend.to_carry\r\n                                                                            ? 'success'\r\n                                                                            : 'info'\r\n                                                                    \"\r\n                                                                    :effect=\"\r\n                                                                        order_pend.to_carry\r\n                                                                            ? 'dark'\r\n                                                                            : 'plain'\r\n                                                                    \"\r\n                                                                >\r\n                                                                    <i\r\n                                                                        class=\"fas fa-biking\"\r\n                                                                        style=\"color: black\"\r\n                                                                    ></i>\r\n                                                                </el-tag>\r\n                                                            </div>\r\n                                                            <div\r\n                                                                class=\"col-4 col-md-4\"\r\n                                                            >\r\n                                                                <el-button-group>\r\n                                                                    <el-button\r\n                                                                        class=\"text-white\"\r\n                                                                        type=\"danger\"\r\n                                                                        icon=\"el-icon-delete\"\r\n                                                                        size=\"mini\"\r\n                                                                        circle\r\n                                                                        @click=\"\r\n                                                                            deleteFood(\r\n                                                                                indexx\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                    </el-button>\r\n                                                                    <el-button\r\n                                                                        v-if=\"\r\n                                                                            configuration.restaurant &&\r\n                                                                                !configuration.college\r\n                                                                        \"\r\n                                                                        class=\"text-white\"\r\n                                                                        type=\"info\"\r\n                                                                        icon=\"el-icon-s-order\"\r\n                                                                        size=\"mini\"\r\n                                                                        circle\r\n                                                                        @click=\"\r\n                                                                            openLocalObservationDialog(\r\n                                                                                indexx,\r\n                                                                                order_pend.observation\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                    </el-button>\r\n                                                                </el-button-group>\r\n                                                            </div>\r\n                                                        </div>\r\n\r\n                                                        <div\r\n                                                            class=\"row align-items-end\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"col-4 col-md-5 col-lg-4 col-xl-4\"\r\n                                                            >\r\n                                                                <span\r\n                                                                    class=\"text-muted\"\r\n                                                                >\r\n                                                                    Cantidad<br />\r\n                                                                    <div\r\n                                                                        class=\"input-group spinner\"\r\n                                                                        data-trigger=\"spinner\"\r\n                                                                    >\r\n                                                                        <input\r\n                                                                            type=\"text\"\r\n                                                                            :readonly=\"\r\n                                                                                order_pend\r\n                                                                                    .food\r\n                                                                                    .item\r\n                                                                                    .is_set ==\r\n                                                                                    1 ||\r\n                                                                                    isConsignment ||\r\n                                                                                    !configuration.quantity_cash ||\r\n                                                                                    order_pend\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .series_enabled ==\r\n                                                                                        1 ||\r\n                                                                                    (order_pend\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .lots_enabled ==\r\n                                                                                        1 &&\r\n                                                                                        order_pend\r\n                                                                                            .food\r\n                                                                                            .item\r\n                                                                                            .lots_group\r\n                                                                                            .length >\r\n                                                                                            1)\r\n                                                                            \"\r\n                                                                            class=\"form-control text-center\"\r\n                                                                            v-model=\"\r\n                                                                                order_pend.quantity\r\n                                                                            \"\r\n                                                                            data-rule=\"currency\"\r\n                                                                            @input=\"\r\n                                                                                verifyStock(\r\n                                                                                    order_pend,\r\n                                                                                    indexx\r\n                                                                                )\r\n                                                                            \"\r\n                                                                        />\r\n                                                                        <div\r\n                                                                            class=\"input-group-text\"\r\n                                                                        >\r\n                                                                            <button\r\n                                                                                type=\"button\"\r\n                                                                                class=\"spin-up\"\r\n                                                                                data-spin=\"up\"\r\n                                                                                :disabled=\"\r\n                                                                                    order_pend\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .is_set ==\r\n                                                                                        1 ||\r\n                                                                                        isConsignment ||\r\n                                                                                        order_pend\r\n                                                                                            .food\r\n                                                                                            .item\r\n                                                                                            .series_enabled ==\r\n                                                                                            1 ||\r\n                                                                                        (order_pend\r\n                                                                                            .food\r\n                                                                                            .item\r\n                                                                                            .lots_enabled ==\r\n                                                                                            1 &&\r\n                                                                                            order_pend\r\n                                                                                                .food\r\n                                                                                                .item\r\n                                                                                                .lots_group\r\n                                                                                                .length >\r\n                                                                                                1)\r\n                                                                                \"\r\n                                                                                @click=\"\r\n                                                                                    sumar_orden(\r\n                                                                                        indexx\r\n                                                                                    )\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                <span\r\n                                                                                    class=\"arrow\"\r\n                                                                                ></span>\r\n                                                                            </button>\r\n                                                                            <button\r\n                                                                                type=\"button\"\r\n                                                                                class=\"spin-down\"\r\n                                                                                data-spin=\"down\"\r\n                                                                                :disabled=\"\r\n                                                                                    isConsignment ||\r\n                                                                                        order_pend\r\n                                                                                            .food\r\n                                                                                            .item\r\n                                                                                            .series_enabled ==\r\n                                                                                            1 ||\r\n                                                                                        (order_pend\r\n                                                                                            .food\r\n                                                                                            .item\r\n                                                                                            .lotes_enabled ==\r\n                                                                                            1 &&\r\n                                                                                            order_pend\r\n                                                                                                .food\r\n                                                                                                .item\r\n                                                                                                .lots_group\r\n                                                                                                .length >\r\n                                                                                                1)\r\n                                                                                \"\r\n                                                                                @click=\"\r\n                                                                                    restar_orden(\r\n                                                                                        indexx\r\n                                                                                    )\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                <span\r\n                                                                                    class=\"arrow\"\r\n                                                                                ></span>\r\n                                                                            </button>\r\n                                                                        </div>\r\n                                                                    </div>\r\n                                                                </span>\r\n                                                            </div>\r\n                                                            <div\r\n                                                                class=\"col-4 col-md-5 col-lg-5 col-xl-4\"\r\n                                                            >\r\n                                                                <span\r\n                                                                    class=\"time font-weight-light\"\r\n                                                                >\r\n                                                                    <span\r\n                                                                        class=\"text-muted\"\r\n                                                                    >\r\n                                                                        Precio\r\n                                                                        <br />\r\n                                                                        <el-input\r\n                                                                            class=\"custom_input\"\r\n                                                                            :disabled=\"\r\n                                                                                order_pend.type_id !=\r\n                                                                                    null ||\r\n                                                                                    configuration.edit_price_sales ==\r\n                                                                                        false\r\n                                                                            \"\r\n                                                                            type=\"number\"\r\n                                                                            v-model=\"\r\n                                                                                order_pend.price\r\n                                                                            \"\r\n                                                                            @input=\"\r\n                                                                                update_price(\r\n                                                                                    indexx,\r\n                                                                                    order_pend.price\r\n                                                                                )\r\n                                                                            \"\r\n                                                                        >\r\n                                                                            <template\r\n                                                                                slot=\"prepend\"\r\n                                                                                v-if=\"\r\n                                                                                    order_pend\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .currency_type_id ==\r\n                                                                                        'PEN'\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                S/\r\n                                                                            </template>\r\n                                                                            <template\r\n                                                                                slot=\"prepend\"\r\n                                                                                v-if=\"\r\n                                                                                    order_pend\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .currency_type_id ==\r\n                                                                                        'USD'\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                $\r\n                                                                            </template>\r\n                                                                        </el-input>\r\n                                                                    </span>\r\n                                                                </span>\r\n                                                            </div>\r\n                                                            <div\r\n                                                                class=\"col-4 col-md-2 col-lg-3 mt-2\"\r\n                                                            >\r\n                                                                <el-tag\r\n                                                                    :disable-transitions=\"\r\n                                                                        true\r\n                                                                    \"\r\n                                                                    v-if=\"\r\n                                                                        !order_pend.change_subtotal\r\n                                                                    \"\r\n                                                                    size=\"medium\"\r\n                                                                >\r\n                                                                    <strong\r\n                                                                        style=\"font-weight: 700\"\r\n                                                                    >\r\n                                                                        {{\r\n                                                                            parseFloat(\r\n                                                                                order_pend.price *\r\n                                                                                    order_pend.quantity\r\n                                                                            ).toFixed(\r\n                                                                                2\r\n                                                                            )\r\n                                                                        }}</strong\r\n                                                                    >\r\n                                                                </el-tag>\r\n                                                                <el-input\r\n                                                                    v-else\r\n                                                                    class=\"input-new-tag1\"\r\n                                                                    v-model=\"\r\n                                                                        order_pend.newSubtotal\r\n                                                                    \"\r\n                                                                    @input=\"\r\n                                                                        justNumber(\r\n                                                                            indexx\r\n                                                                        )\r\n                                                                    \"\r\n                                                                    placeholder=\"0.00\"\r\n                                                                    size=\"medium\"\r\n                                                                >\r\n                                                                </el-input>\r\n                                                                <template\r\n                                                                    v-if=\"\r\n                                                                        configuration.edit_subtotal_box\r\n                                                                    \"\r\n                                                                >\r\n                                                                    <el-tag\r\n                                                                        v-if=\"\r\n                                                                            !order_pend.change_subtotal\r\n                                                                        \"\r\n                                                                        role=\"button\"\r\n                                                                        size=\"medium\"\r\n                                                                        @click=\"\r\n                                                                            changeSubtotal(\r\n                                                                                indexx\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                        <i\r\n                                                                            class=\"fas fa-edit text-primary\"\r\n                                                                        ></i>\r\n                                                                    </el-tag>\r\n                                                                    <el-tag\r\n                                                                        v-else\r\n                                                                        role=\"button\"\r\n                                                                        size=\"medium\"\r\n                                                                        @click=\"\r\n                                                                            saveSubtotal(\r\n                                                                                indexx\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                        <i\r\n                                                                            class=\"fas fa-save text-primary\"\r\n                                                                        ></i>\r\n                                                                    </el-tag>\r\n                                                                </template>\r\n                                                            </div>\r\n                                                        </div>\r\n                                                        <div\r\n                                                            v-if=\"\r\n                                                                order_pend.food\r\n                                                                    .item\r\n                                                                    .series_enabled\r\n                                                            \"\r\n                                                        >\r\n                                                            <template\r\n                                                                v-if=\"\r\n                                                                    order_pend\r\n                                                                        .series\r\n                                                                        .length ==\r\n                                                                        0\r\n                                                                \"\r\n                                                            >\r\n                                                                <el-tag\r\n                                                                    style=\"margin-top: 5px\"\r\n                                                                    role=\"button\"\r\n                                                                    @click=\"\r\n                                                                        showSeriesDialog(\r\n                                                                            order_pend,\r\n                                                                            indexx\r\n                                                                        )\r\n                                                                    \"\r\n                                                                    type=\"danger\"\r\n                                                                    >**Seleccione\r\n                                                                    una serie\r\n                                                                </el-tag>\r\n                                                            </template>\r\n                                                            <template v-else>\r\n                                                                <div\r\n                                                                    v-for=\"(serie,\r\n                                                                    idx) in order_pend.series\"\r\n                                                                    :key=\"idx\"\r\n                                                                    style=\"margin-top: 5px\"\r\n                                                                >\r\n                                                                    <el-tag\r\n                                                                        type=\"primary\"\r\n                                                                        closable\r\n                                                                        :disable-transitions=\"\r\n                                                                            false\r\n                                                                        \"\r\n                                                                        @close=\"\r\n                                                                            deleteSerie(\r\n                                                                                indexx,\r\n                                                                                serie.id\r\n                                                                            )\r\n                                                                        \"\r\n                                                                    >\r\n                                                                        {{\r\n                                                                            serie.series\r\n                                                                        }}\r\n                                                                    </el-tag>\r\n                                                                    <br />\r\n                                                                </div>\r\n                                                                <el-tag\r\n                                                                    style=\"margin-top: 5px\"\r\n                                                                    role=\"button\"\r\n                                                                    @click=\"\r\n                                                                        showSeriesDialog(\r\n                                                                            order_pend,\r\n                                                                            indexx\r\n                                                                        )\r\n                                                                    \"\r\n                                                                    type=\"success\"\r\n                                                                    >Ver Series\r\n                                                                </el-tag>\r\n                                                            </template>\r\n                                                        </div>\r\n                                                        <div\r\n                                                            v-if=\"\r\n                                                                order_pend.food\r\n                                                                    .item\r\n                                                                    .lots_enabled &&\r\n                                                                    !order_pend\r\n                                                                        .food\r\n                                                                        .item\r\n                                                                        .series_enabled\r\n                                                            \"\r\n                                                        >\r\n                                                            <template\r\n                                                                v-if=\"\r\n                                                                    order_pend\r\n                                                                        .lotes\r\n                                                                        .length ==\r\n                                                                        0\r\n                                                                \"\r\n                                                            >\r\n                                                                <el-tag\r\n                                                                    style=\"margin-top: 5px\"\r\n                                                                    role=\"button\"\r\n                                                                    @click=\"\r\n                                                                        showLotesDialog\r\n                                                                    \"\r\n                                                                    type=\"danger\"\r\n                                                                    >**Seleccione\r\n                                                                    el\r\n                                                                    lote</el-tag\r\n                                                                >\r\n                                                            </template>\r\n                                                            <template v-else>\r\n                                                                <div\r\n                                                                    v-for=\"(lot,\r\n                                                                    idx) in order_pend.lotes\"\r\n                                                                    :key=\"idx\"\r\n                                                                    style=\"margin-top: 5px\"\r\n                                                                    v-show=\"\r\n                                                                        lot.quantitySelected >\r\n                                                                            0\r\n                                                                    \"\r\n                                                                >\r\n                                                                    <el-tooltip\r\n                                                                        :content=\"\r\n                                                                            `Cant. en almacén: ${lot.quantity}`\r\n                                                                        \"\r\n                                                                    >\r\n                                                                        <el-tag\r\n                                                                            type=\"primary\"\r\n                                                                        >\r\n                                                                            {{\r\n                                                                                lot.code\r\n                                                                            }}\r\n                                                                            <template\r\n                                                                                v-if=\"\r\n                                                                                    order_pend\r\n                                                                                        .food\r\n                                                                                        .item\r\n                                                                                        .lots_group\r\n                                                                                        .length >\r\n                                                                                        1\r\n                                                                                \"\r\n                                                                            >\r\n                                                                                -\r\n                                                                                Cant.\r\n                                                                                {{\r\n                                                                                    lot.quantitySelected\r\n                                                                                }}\r\n                                                                            </template>\r\n                                                                        </el-tag>\r\n                                                                    </el-tooltip>\r\n                                                                    <br />\r\n                                                                </div>\r\n                                                                <el-tag\r\n                                                                    v-if=\"\r\n                                                                        order_pend\r\n                                                                            .food\r\n                                                                            .item\r\n                                                                            .lots_group\r\n                                                                            .length >\r\n                                                                            1\r\n                                                                    \"\r\n                                                                    style=\"margin-top: 5px\"\r\n                                                                    role=\"button\"\r\n                                                                    @click=\"\r\n                                                                        showLotesDialog(\r\n                                                                            order_pend,\r\n                                                                            indexx\r\n                                                                        )\r\n                                                                    \"\r\n                                                                    type=\"success\"\r\n                                                                    >Ver Lotes\r\n                                                                </el-tag>\r\n                                                            </template>\r\n                                                        </div>\r\n                                                        <div\r\n                                                            v-if=\"\r\n                                                                order_pend.observation\r\n                                                            \"\r\n                                                        >\r\n                                                            <small\r\n                                                                >OBS:\r\n                                                                {{\r\n                                                                    order_pend.observation\r\n                                                                }}</small\r\n                                                            >\r\n                                                        </div>\r\n                                                        <div\r\n                                                            class=\"row\"\r\n                                                            v-if=\"isConsignment\"\r\n                                                        >\r\n                                                            <div\r\n                                                                class=\"col-md-4\"\r\n                                                                v-if=\"\r\n                                                                    !order_pend.is_penalty\r\n                                                                \"\r\n                                                            >\r\n                                                                <label\r\n                                                                    for=\"warehouse\"\r\n                                                                    >Para el\r\n                                                                    almacen</label\r\n                                                                >\r\n                                                                <el-input-number\r\n                                                                    :min=\"0\"\r\n                                                                    @change=\"\r\n                                                                        updateWarehouse(\r\n                                                                            order_pend,\r\n                                                                            indexx\r\n                                                                        )\r\n                                                                    \"\r\n                                                                    class=\"w-100\"\r\n                                                                    controls-position=\"right\"\r\n                                                                    v-model=\"\r\n                                                                        order_pend.toWarehouse\r\n                                                                    \"\r\n                                                                >\r\n                                                                </el-input-number>\r\n                                                            </div>\r\n                                                        </div>\r\n                                                    </div>\r\n                                                </div>\r\n                                                <hr />\r\n                                            </div>\r\n                                        </div>\r\n                                        <div\r\n                                            class=\"\r\n                        d-flex\r\n                        h-50\r\n                        justify-content-center\r\n                        align-items-center\r\n                      \"\r\n                                            v-if=\"\r\n                                                localOrden.length == 0 &&\r\n                                                    !variation\r\n                                            \"\r\n                                        >\r\n                                            <p class=\"font-weight-lighter\">\r\n                                                Lista vacía.\r\n                                            </p>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </section>\r\n            </div>\r\n        </div>\r\n\r\n        <el-dialog\r\n            @close=\"closeLocalObservationDialog\"\r\n            :visible=\"dialogLocalObservation\"\r\n            append-to-body\r\n            title=\"Editando observación\"\r\n        >\r\n            <span>\r\n                <label class=\"control-label\"> Observación </label>\r\n                <el-input v-model=\"localObservation\"></el-input>\r\n            </span>\r\n            <span slot=\"footer\" class=\"dialog-footer\">\r\n                <button\r\n                    class=\"btn btn-sm btn-secondary\"\r\n                    @click=\"changeLocalObservation\"\r\n                >\r\n                    Cambiar\r\n                </button>\r\n                <button\r\n                    class=\"btn btn-sm btn-light\"\r\n                    @click=\"closeLocalObservationDialog\"\r\n                >\r\n                    Cerrar\r\n                </button>\r\n            </span>\r\n        </el-dialog>\r\n\r\n        <el-dialog\r\n            :visible=\"apart\"\r\n            :close-on-click-modal=\"false\"\r\n            :close-on-press-escape=\"false\"\r\n            title=\"Aparcar orden\"\r\n            @close=\"apart = false\"\r\n            width=\"20%\"\r\n        >\r\n            <div class=\"card p-2\">\r\n                <label class=\"control-label\">Datos Referenciales</label>\r\n                <el-input\r\n                    v-model=\"numberCustomerApart\"\r\n                    placeholder=\"Dni o Nombre\"\r\n                >\r\n                </el-input>\r\n\r\n                <div class=\"d-flex justify-content-end\">\r\n                    <button class=\"btn btn-light m-1\" @click=\"apart = false\">\r\n                        Cancelar\r\n                    </button>\r\n\r\n                    <button class=\"btn btn-primary m-1\" @click=\"pullApartOrden\">\r\n                        Aparcar\r\n                    </button>\r\n                </div>\r\n            </div>\r\n        </el-dialog>\r\n        <transfers-modal\r\n            :showDialog.sync=\"showTransfersDialog\"\r\n        ></transfers-modal>\r\n        <show-lotes-product\r\n            :idx=\"currentIdx\"\r\n            :orden=\"ordenLot\"\r\n            :showDialog.sync=\"showLotes\"\r\n            @updateLotes=\"updateLotes\"\r\n        ></show-lotes-product>\r\n        <show-series-product\r\n            :limitQty=\"limitQty\"\r\n            :idx=\"currentIdx\"\r\n            :item=\"currentItem\"\r\n            :showDialog.sync=\"showSeries\"\r\n            :seriesSelected.sync=\"currentSeries\"\r\n            @updateSeries=\"updateSeries\"\r\n            :establishments=\"establishments\"\r\n        >\r\n        </show-series-product>\r\n\r\n        <orden-pull-apart\r\n            @restoreToLocalOrdens=\"restoreToLocalOrdens\"\r\n            :showPullApart.sync=\"listApart\"\r\n            :ordenInBox.sync=\"ordenInBox\"\r\n        >\r\n        </orden-pull-apart>\r\n        <table-ordens-pending\r\n            :areas=\"areas\"\r\n            :showPendingOrdens.sync=\"showPendingOrdens\"\r\n        >\r\n        </table-ordens-pending>\r\n        <cash-form\r\n            :showDialog.sync=\"showDialogCash\"\r\n            :recordId=\"cash_id\"\r\n            :fromBox=\"true\"\r\n            @updateCashId=\"updateCashId\"\r\n        ></cash-form>\r\n        <close-cash\r\n            :recordId.sync=\"cash_id\"\r\n            :showDialogClose.sync=\"showDialogClose\"\r\n            :fromBox=\"true\"\r\n            :configuration=\"configuration\"\r\n            @updateCashId=\"updateCashId\"\r\n        >\r\n        </close-cash>\r\n        <expenses-incomes\r\n            :showDialog.sync=\"showExpensesIncomes\"\r\n            :company=\"company\"\r\n            :cash_id=\"cash_id\"\r\n            :establishments=\"establishments\"\r\n        >\r\n        </expenses-incomes>\r\n        <observation-form\r\n            :current=\"current\"\r\n            :observations.sync=\"tags\"\r\n            :showDialog.sync=\"showObservations\"\r\n            @addObservation=\"addObservation\"\r\n        >\r\n        </observation-form>\r\n        <quotation-form\r\n            :showDialog.sync=\"showQuotationForm\"\r\n            :items=\"localOrden\"\r\n            :customers=\"customers\"\r\n            @limpiarForm=\"limpiarForm\"\r\n            :cash_id=\"cash_id\"\r\n            :sellers=\"sellers\"\r\n        >\r\n        </quotation-form>\r\n\r\n        <credit-form\r\n            :showDialog.sync=\"showCreditForm\"\r\n            :items=\"localOrden\"\r\n            :customers=\"customers\"\r\n            @limpiarForm=\"limpiarForm\"\r\n            :cash_id=\"cash_id\"\r\n            :all_series.sync=\"all_series\"\r\n            :establishments=\"establishments\"\r\n        >\r\n        </credit-form>\r\n        <el-dialog\r\n            :visible.sync=\"showChangeDescriptionVariation\"\r\n            title=\"Cambiar descripción\"\r\n            @close=\"showChangeDescriptionVariation = false\"\r\n        >\r\n            <div class=\"card p-3\">\r\n                <el-input\r\n                    placeholder=\"Nueva descripción\"\r\n                    v-model=\"descriptionTemp\"\r\n                >\r\n                </el-input\r\n                ><br />\r\n                <div class=\"d-flex justify-content-end\">\r\n                    <el-button type=\"primary\" @click=\"changeDescription\">\r\n                        Cambiar\r\n                    </el-button>\r\n                    <el-button @click=\"showChangeDescriptionVariation = false\">\r\n                        Cerrar\r\n                    </el-button>\r\n                </div>\r\n            </div>\r\n        </el-dialog>\r\n        <el-dialog\r\n            v-loading=\"deleteOrdenLoading\"\r\n            width=\"450px\"\r\n            :visible.sync=\"showPinRequest\"\r\n            title=\"Ingrese su PIN\"\r\n            append-to-body\r\n        >\r\n            <div class=\"row mt-1\">\r\n                <p class=\"h5\" style=\"word-break: break-word;\">\r\n                    Para poder eliminar la orden debe ingresar un motivo y su\r\n                    PIN de usuario.\r\n                </p>\r\n            </div>\r\n            <div class=\"row mt-1\">\r\n                <div class=\"col-12 \">\r\n                    <el-input\r\n                        v-model=\"reasonToDelete\"\r\n                        placeholder=\"Ingrese un motivo\"\r\n                        type=\"textarea\"\r\n                        maxlength=\"200\"\r\n                        show-word-limit\r\n                    ></el-input>\r\n                </div>\r\n            </div>\r\n            <div class=\"row mt-2 \">\r\n                <div class=\"col-12 \">\r\n                    <el-input\r\n                        v-model=\"pin\"\r\n                        placeholder=\"Ingrese su PIN\"\r\n                        type=\"password\"\r\n                        maxlength=\"4\"\r\n                        readonly\r\n                    ></el-input>\r\n                </div>\r\n                <div\r\n                    class=\"col-12 card \"\r\n                    style=\"max-width: 218px;margin-left: 104px;margin-top: 14px;\"\r\n                >\r\n                    <div class=\"row\" style=\"  margin-left: 20px;\">\r\n                        <el-button\r\n                            v-for=\"num in [1, 2, 3]\"\r\n                            :key=\"num\"\r\n                            class=\"m-2 col-md-4 btn-rounded2 btn-primary\"\r\n                            @click=\"generatePin(num)\"\r\n                            style=\"border-radius: 50% !important ; width: 42px; color:white\"\r\n                            >{{ num }}\r\n                        </el-button>\r\n                    </div>\r\n                    <div class=\"row\" style=\"  margin-left: 20px;\">\r\n                        <el-button\r\n                            v-for=\"num in [4, 5, 6]\"\r\n                            :key=\"num\"\r\n                            class=\"m-2 col-md-4 btn-primary\"\r\n                            @click=\"generatePin(num)\"\r\n                            style=\"border-radius: 50% !important ; width: 42px; color:white\"\r\n                            >{{ num }}\r\n                        </el-button>\r\n                    </div>\r\n                    <div class=\"row\" style=\"  margin-left: 20px;\">\r\n                        <el-button\r\n                            v-for=\"num in [7, 8, 9]\"\r\n                            :key=\"num\"\r\n                            class=\"m-2 col-md-4 btn-primary\"\r\n                            @click=\"generatePin(num)\"\r\n                            style=\"border-radius: 50% !important ; width: 42px; color:white\"\r\n                            >{{ num }}\r\n                        </el-button>\r\n                    </div>\r\n                    <div class=\"row\" style=\"  margin-left: 20px;\">\r\n                        <el-button\r\n                            @click=\"pin = ''\"\r\n                            class=\"m-2 col-md-4 \"\r\n                            type=\"danger\"\r\n                            icon=\"el-icon-delete\"\r\n                            style=\"border-radius: 50% !important ; width: 42px;\"\r\n                        >\r\n                        </el-button>\r\n\r\n                        <el-button\r\n                            v-for=\"num in [0]\"\r\n                            :key=\"num\"\r\n                            class=\"m-2 col-md-4 btn-primary\"\r\n                            @click=\"generatePin(num)\"\r\n                            style=\"border-radius: 50% !important ; width: 42px; color:white\"\r\n                            >{{ num }}\r\n                        </el-button>\r\n                        <div class=\"col-md-4\"></div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div\r\n                slot=\"footer\"\r\n                class=\"dialog-footer\"\r\n                style=\"text-align: center !important ; \"\r\n            >\r\n                <el-button @click=\"showPinRequest = false\">Cancelar</el-button>\r\n                <el-button type=\"primary\" @click=\"cancelOrdenaPin\"\r\n                    >Eliminar</el-button\r\n                >\r\n            </div>\r\n        </el-dialog>\r\n        <consignment-form\r\n            :showDialog.sync=\"showConsignmentForm\"\r\n            :items=\"localOrden\"\r\n            :all_customers=\"customers\"\r\n            :establishments=\"establishments\"\r\n            @limpiarForm=\"limpiarForm\"\r\n        >\r\n        </consignment-form>\r\n        <el-dialog\r\n            :visible.sync=\"showChangeName\"\r\n            title=\"Cambiar nombre de producto\"\r\n            @close=\"showChangeName = false\"\r\n            append-to-body\r\n        >\r\n            <div class=\"row m-2\">\r\n                <el-input v-model=\"name_pdf\" placeholder=\"Ingrese un nombre\">\r\n                </el-input>\r\n            </div>\r\n            <div slot=\"footer\" class=\"dialog-footer\">\r\n                <el-button @click=\"showChangeName = false\">Cancelar</el-button>\r\n                <el-button type=\"primary\" @click=\"changeNamePdf\"\r\n                    >Guardar</el-button\r\n                >\r\n            </div>\r\n        </el-dialog>\r\n    </div>\r\n</template>\r\n<style>\r\n.el-input-group__prepend {\r\n    padding-left: 6px !important;\r\n    padding-right: 6px !important;\r\n}\r\n\r\n.custom_input .el-input__inner {\r\n    padding: 0 5px !important;\r\n}\r\n\r\n.el-tag + .el-tag {\r\n    margin-left: 10px;\r\n}\r\n\r\n.button-new-tag {\r\n    margin-left: 10px;\r\n    height: 32px;\r\n    line-height: 30px;\r\n    padding-top: 0;\r\n    padding-bottom: 0;\r\n}\r\n\r\n.input-new-tag1 {\r\n    width: 70px;\r\n    margin-left: 10px;\r\n    vertical-align: bottom;\r\n}\r\n\r\n.input-new-tag1 .el-input__inner {\r\n    height: 30px !important;\r\n}\r\n</style>\r\n<script>\r\nconst ConsignmentForm = () => import(\"./consignment_modal.vue\");\r\nconst QuotationForm = () => import(\"./quotation_modal.vue\");\r\nconst CreditForm = () => import(\"./credit_modal.vue\");\r\nconst CashForm = () => import(\"../../cash/form.vue\");\r\nconst CloseCash = () => import(\"../../cash/closecash.vue\");\r\nconst OrdenPullApart = () => import(\"./ordens_pull_apart.vue\");\r\nconst TableOrdensPending = () => import(\"./list_pending_ordens.vue\");\r\nconst ObservationForm = () => import(\"../../partials/observation_form.vue\");\r\nconst ExpensesIncomes = () => import(\"../partials/expenses_incomes.vue\");\r\nconst ShowSeriesProduct = () => import(\"../partials/show_series_product.vue\");\r\nconst ShowLotesProduct = () => import(\"../partials/show_lotes_product.vue\");\r\nconst TransfersModal = () => import(\"../partials/transfer_modal.vue\");\r\nexport default {\r\n    components: {\r\n        ConsignmentForm,\r\n        CreditForm,\r\n        CashForm,\r\n        CloseCash,\r\n        TableOrdensPending,\r\n        OrdenPullApart,\r\n        ObservationForm,\r\n        ExpensesIncomes,\r\n        ShowSeriesProduct,\r\n        ShowLotesProduct,\r\n        TransfersModal,\r\n        QuotationForm\r\n    },\r\n    props: [\r\n     \r\n        \"sellers\",\r\n        \"affectation_igv_types\",\r\n        \"all_series\",\r\n        \"areas\",\r\n        \"customers\",\r\n        \"company\",\r\n        \"customer_variation\",\r\n        \"variationShow\",\r\n        \"establishments\",\r\n        \"itemDefault\",\r\n        \"ordensPending\",\r\n        \"area_id\",\r\n        \"blockCart\",\r\n        \"localOrden\",\r\n        \"configuration\",\r\n        \"ordens\",\r\n        \"total2\",\r\n        \"clientTableData\",\r\n        \"isCreatingOrden\",\r\n        \"ordenId\",\r\n        \"cash_id\"\r\n    ],\r\n\r\n    data() {\r\n        return {\r\n            quotation_stock: false,\r\n            name_pdf: null,\r\n            showChangeName: false,\r\n            isConsignment: false,\r\n            showConsignmentForm: false,\r\n            deleteGeneralOrden: false,\r\n            deleteOrdenLoading: false,\r\n            reasonToDelete: null,\r\n            ordenIdToDelete: null,\r\n            showPinRequest: false,\r\n            showCreditForm: false,\r\n            showQuotationForm: false,\r\n            limitQty: 0,\r\n            showTransfersDialog: false,\r\n            descriptionTemp: null,\r\n            showChangeDescriptionVariation: false,\r\n            variation: false,\r\n            showObservations: false,\r\n            boxOperation: \"Abrir\",\r\n            showDialogCash: false,\r\n            tags: [],\r\n            showSeries: false,\r\n            current: null,\r\n            showDialogClose: false,\r\n            showPendingOrdens: false,\r\n            ordenLoading: false,\r\n            listApart: false,\r\n            apart: false,\r\n            numberCustomerApart: null,\r\n            ordenInBox: [],\r\n            pin: \"\",\r\n            totalOrdenItems: 0.0,\r\n            total: 0.0,\r\n            disableSend: false,\r\n            totalOrden: 0.0,\r\n            loading: false,\r\n            commands_fisico: \"\",\r\n            AllSelected: false,\r\n            showDialogPing: false,\r\n            dialogLocalObservation: false,\r\n            currentLocalOrden: null,\r\n            localObservation: null,\r\n            dialogObservation: false,\r\n            observation: null,\r\n            loadingObservation: false,\r\n            currentOrden: null,\r\n            form_ped: {},\r\n            to_carry: false,\r\n            optionsMenu: [],\r\n            foodDefault: null,\r\n            showExpensesIncomes: false,\r\n            showLotes: false,\r\n            ordenLot: null,\r\n            currentIdx: null,\r\n            currentItem: null,\r\n            currentSeries: [],\r\n            screenWidth: 0,\r\n            printing: false,\r\n            foodDefaults: [],\r\n            currentFoodDefault: null\r\n        };\r\n    },\r\n\r\n    watch: {\r\n        variationShow(variat, _) {\r\n            if (this.variation && !variat) {\r\n                this.variation = false;\r\n            }\r\n        },\r\n        itemDefault(newItem, _) {\r\n            this.foodDefault = this.itemDefault;\r\n            this.foodDefault.quantity = 1;\r\n            this.foodDefault.sale_unit_price = Number(\r\n                this.foodDefault.sale_unit_price\r\n            );\r\n            this.foodDefaults = [{ ...this.foodDefault }];\r\n        },\r\n        cash_id(newCash, _) {\r\n            this.boxOperation = newCash ? \"Cerrar\" : \"Abrir\";\r\n            this.optionsMenu[2].title = [this.boxOperation, \" Caja\"];\r\n        },\r\n        ordens(newOrdens, _) {\r\n            this.calculateTotal(newOrdens);\r\n        },\r\n        localOrden(newOrdens, _) {\r\n            this.calculateTotal(this.ordens);\r\n        }\r\n    },\r\n\r\n    mounted() {\r\n        this.screenWidth = window.innerWidth;\r\n        window.addEventListener(\"resize\", this.handleResize);\r\n        this.foodDefault = this.itemDefault;\r\n        this.boxOperation = this.cash_id ? \"Cerrar\" : \"Abrir\";\r\n\r\n        this.optionsMenu = [\r\n            {\r\n                id: 1,\r\n                title: [\"Configuración\"],\r\n                icon: \"fas fa-cogs\",\r\n                visible: false\r\n            },\r\n            {\r\n                id: 2,\r\n                title: [\"Recibir \", \"mercaderia\"],\r\n                icon: \"fas fa-people-carry\",\r\n                visible: this.configuration.receive_merchandise\r\n            },\r\n            {\r\n                id: 3,\r\n                title: [this.boxOperation, \" Caja\"],\r\n                icon: \"fas fa-cash-register\",\r\n                visible: true\r\n            },\r\n            {\r\n                id: 7,\r\n                title: [\"Ingresos/\", \"/Gastos\"],\r\n                icon: \"fas fa-money-bill-wave-alt\",\r\n                visible: true\r\n            },\r\n            {\r\n                id: 4,\r\n                title: [\"Aparcado\"],\r\n                icon: \"fas fa-cart-arrow-down\",\r\n                visible: !this.configuration.college\r\n            },\r\n\r\n            {\r\n                id: 5,\r\n                title: [\"Ordenes\"],\r\n                icon: \"fas fa-hourglass\",\r\n                visible:\r\n                    this.configuration.restaurant && !this.configuration.college\r\n            }\r\n        ];\r\n        let ordens = [];\r\n        let ordensSave = localStorage.ordens;\r\n        if (ordensSave) {\r\n            ordens = JSON.parse(ordensSave);\r\n        }\r\n        this.ordenInBox = ordens;\r\n    },\r\n    async created() {\r\n        let printing = localStorage.getItem(\"cajaPrint\");\r\n\r\n        this.printing = printing == 1;\r\n        qz.security.setCertificatePromise((resolve, reject) => {\r\n            this.$http\r\n                .get(\"/api/qz/crt/override\", {\r\n                    responseType: \"text\"\r\n                })\r\n                .then(response => {\r\n                    resolve(response.data);\r\n                })\r\n                .catch(error => {\r\n                    reject(error.data);\r\n                });\r\n        });\r\n        qz.security.setSignaturePromise(toSign => {\r\n            return (resolve, reject) => {\r\n                this.$http\r\n                    .post(\"/api/qz/signing\", {\r\n                        request: toSign\r\n                    })\r\n                    .then(response => {\r\n                        resolve(response.data);\r\n                    })\r\n                    .catch(error => {\r\n                        reject(error.data);\r\n                    });\r\n            };\r\n        });\r\n\r\n        await this.getTags();\r\n    },\r\n    methods: {\r\n        setQuotationStock() {\r\n            let quotation_stock = this.quotation_stock ? 1 : 0;\r\n            localStorage.setItem(\"quotation_stock\", quotation_stock);\r\n            if (!this.quotation_stock) {\r\n                this.directSale();\r\n            }\r\n        },\r\n        restoreName(idx) {\r\n            let ordens = [...this.localOrden];\r\n            ordens[idx].food.item.name_product_pdf = null;\r\n            this.$emit(\"update:localOrden\", ordens);\r\n        },\r\n        changeNamePdf() {\r\n            let idx = this.currentIdx;\r\n            let ordens = [...this.localOrden];\r\n            ordens[idx].food.item.name_product_pdf = this.name_pdf;\r\n            this.$emit(\"update:localOrden\", ordens);\r\n            this.showChangeName = false;\r\n        },\r\n        changeName(idx) {\r\n            this.currentIdx = idx;\r\n            let ordens = [...this.localOrden];\r\n            this.name_pdf = ordens[idx].food.description;\r\n            this.showChangeName = true;\r\n        },\r\n        updateWarehouse(order, index) {\r\n            let ordens = [...this.localOrden];\r\n            ordens[index].toWarehouse = order.toWarehouse;\r\n            let newQuantity =\r\n                ordens[index].originalQuantity - order.toWarehouse;\r\n            if (newQuantity < 0) {\r\n                this.$toast.error(\"No puede ser mayor a la cantidad original\");\r\n                ordens[index].toWarehouse = 0;\r\n                ordens[index].quantity = ordens[index].originalQuantity;\r\n            } else {\r\n                ordens[index].quantity =\r\n                    ordens[index].originalQuantity - order.toWarehouse;\r\n            }\r\n            this.$emit(\"update:localOrden\", ordens);\r\n        },\r\n        setConsignment(consigment) {\r\n            this.isConsignment = true;\r\n        },\r\n        removeConsignment() {\r\n            this.isConsignment = false;\r\n        },\r\n        openConsignment() {\r\n            this.showConsignmentForm = true;\r\n        },\r\n        async changeQuickSale() {\r\n            let { conf } = this.establishments;\r\n            try {\r\n                let response = await this.$http.post(\r\n                    \"/establishments/update_conf\",\r\n                    { ...conf }\r\n                );\r\n                this.$toast.success(response.data.message);\r\n            } catch (e) {\r\n                console.log(e);\r\n            }\r\n        },\r\n        deleteDefaultFood(index) {\r\n            this.foodDefaults = this.foodDefaults.filter((_, i) => i != index);\r\n        },\r\n        addVariation() {\r\n            let foodDefault = { ...this.itemDefault };\r\n            foodDefault.description =\r\n                foodDefault.description +\r\n                \" \" +\r\n                Number(this.foodDefaults.length + 1);\r\n            this.foodDefaults = [...this.foodDefaults, foodDefault];\r\n        },\r\n        openCredit() {\r\n            this.showCreditForm = true;\r\n        },\r\n        openQuotation() {\r\n            this.showQuotationForm = true;\r\n        },\r\n        savePrint() {\r\n            localStorage.setItem(\"cajaPrint\", this.printing ? 1 : 0);\r\n            this.$toast.success(\"Configuración guardada\");\r\n        },\r\n        handleResize() {\r\n            this.screenWidth = window.innerWidth;\r\n        },\r\n        showTransfers() {\r\n            this.showTransfersDialog = true;\r\n        },\r\n        deleteSerie(index, serie_id) {\r\n            let ordens = [...this.localOrden];\r\n\r\n            ordens[index].series = ordens[index].series.filter(\r\n                s => s.id != serie_id\r\n            );\r\n            ordens[index].quantity = ordens[index].series.length;\r\n            this.$emit(\"update:localOrden\", ordens);\r\n        },\r\n        updateSeries(idx, series) {\r\n            let ordens = [...this.localOrden];\r\n            ordens[idx].series = series;\r\n            if (this.limitQty) {\r\n                ordens[idx].quantity = series.length / this.limitQty;\r\n            } else {\r\n                ordens[idx].quantity = series.length;\r\n            }\r\n\r\n            this.$emit(\"update:localOrden\", ordens);\r\n        },\r\n        updateLotes(idx, lotes) {\r\n            let ordens = [...this.localOrden];\r\n            ordens[idx].lotes = lotes;\r\n            ordens[idx].quantity = lotes.reduce(\r\n                (a, b) => a + Number(b.quantitySelected),\r\n                0\r\n            );\r\n            this.$emit(\"update:localOrden\", ordens);\r\n        },\r\n        showLotesDialog(orden, index) {\r\n            this.ordenLot = orden;\r\n            this.currentIdx = index;\r\n            this.showLotes = true;\r\n        },\r\n        showSeriesDialog(orden, index = null) {\r\n            this.limitQty = orden.type_quantity ?? 0;\r\n\r\n            let ordens = this.localOrden.filter(l => l.id == orden.id);\r\n            if (ordens.length == 1) {\r\n                let [currentOrden] = ordens;\r\n                let series = currentOrden.series.map(s => ({\r\n                    ...s,\r\n                    disabled: false\r\n                }));\r\n                this.currentSeries = series;\r\n            } else {\r\n                let series = [];\r\n                for (let i = 0; i < ordens.length; i++) {\r\n                    let currentOrden = ordens[i];\r\n                    series = [\r\n                        ...series,\r\n                        ...currentOrden.series.map(s => ({\r\n                            ...s,\r\n                            disabled: orden.type_id != currentOrden.type_id\r\n                        }))\r\n                    ];\r\n                }\r\n                this.currentSeries = series;\r\n            }\r\n            this.currentItem = orden.food.item;\r\n            // this.currentSeries = orden.series;\r\n\r\n            this.currentIdx = index;\r\n            this.showSeries = true;\r\n        },\r\n        justNumber(indexx) {\r\n            this.localOrden[indexx].newSubtotal = this.localOrden[\r\n                indexx\r\n            ].newSubtotal.replace(/[^0-9.]/g, \"\");\r\n        },\r\n        updateDefaultFoodQty(bool, idx) {\r\n            let foodDefault = this.foodDefaults[idx];\r\n            if (bool) {\r\n                foodDefault.quantity += 1;\r\n            } else {\r\n                if (foodDefault.quantity > 1) {\r\n                    foodDefault.quantity -= 1;\r\n                }\r\n            }\r\n\r\n            this.$forceUpdate();\r\n        },\r\n        showChangeDescription(idx) {\r\n            this.descriptionTemp = null;\r\n            this.currentFoodDefault = idx;\r\n            this.showChangeDescriptionVariation = true;\r\n        },\r\n        changeDescription() {\r\n            let foodDefault = this.foodDefaults[this.currentFoodDefault];\r\n            foodDefault.description = this.descriptionTemp;\r\n            this.showChangeDescriptionVariation = false;\r\n        },\r\n        changeVariation() {\r\n            if (this.customer_variation == null) {\r\n                this.variation = false;\r\n\r\n                return this.$toast.error(\"Clientes modificado no creado\");\r\n            }\r\n            if (this.itemDefault == null) {\r\n                this.variation = false;\r\n\r\n                return this.$toast.error(\r\n                    \"Producto para variación no seleccionado\"\r\n                );\r\n            }\r\n\r\n            this.foodDefaults = [this.foodDefault];\r\n        },\r\n        saveSubtotal(idx) {\r\n            let ordensModified = [...this.localOrden];\r\n            let currentOrden = ordensModified[idx];\r\n            let sub = Number(currentOrden.newSubtotal);\r\n            if (isNaN(sub) || sub <= 0) {\r\n                ordensModified[idx].change_subtotal = false;\r\n                ordensModified[idx].series = [];\r\n                ordensModified[idx].lotes = [];\r\n                ordensModified[idx].newSubtotal = null;\r\n                this.$emit(\"update:localOrden\", ordensModified);\r\n                this.$toast.error(\"Subtotal no válido\");\r\n                return;\r\n            }\r\n            let qty = Number(currentOrden.quantity);\r\n            let price = sub / qty;\r\n            ordensModified[idx].price = price;\r\n            ordensModified[idx].change_subtotal = false;\r\n            ordensModified[idx].series = [];\r\n            ordensModified[idx].lotes = [];\r\n            ordensModified[idx].newSubtotal = null;\r\n            this.$emit(\"update:localOrden\", ordensModified);\r\n            this.calculateTotal();\r\n            this.$toast.success(\"Subtotal actualizado\");\r\n        },\r\n        changeSubtotal(idx) {\r\n            let ordensModified = [...this.localOrden];\r\n            ordensModified[idx].change_subtotal = !ordensModified[idx]\r\n                .change_subtotal;\r\n            this.$emit(\"update:localOrden\", ordensModified);\r\n        },\r\n        addObservation(obs) {\r\n            let ordensModified = [...this.localOrden];\r\n            ordensModified[this.currentLocalOrden].observation = obs;\r\n            this.$emit(\"update:localOrden\", ordensModified);\r\n        },\r\n        async getTags() {\r\n            const response = await this.$http(\"../observations/records\");\r\n            if (response.status == 200) {\r\n                const { data } = response;\r\n                this.tags = data;\r\n            }\r\n        },\r\n        async updateCashId(id) {\r\n            this.$emit(\"update:cash_id\", id);\r\n        },\r\n        cancelGeneralOrdenPin() {\r\n            this.deleteGeneralOrden = true;\r\n            this.showPinRequest = true;\r\n        },\r\n        async deleteGeneralOrdenPin() {\r\n            try {\r\n                this.deleteOrdenLoading = true;\r\n                let id = this.ordens[0].orden_id;\r\n                let form = {\r\n                    id,\r\n                    pin: this.pin,\r\n                    reason: this.reasonToDelete\r\n                };\r\n                const response = await this.$http.post(\"cancel-orden\", form);\r\n                if (response.status == 200) {\r\n                    const { message, success } = response.data;\r\n                    if (success) {\r\n                        this.$toast.success(message);\r\n                        this.$eventHub.$emit(\"reloadData\");\r\n                        this.$emit(\"ordenDeleted\");\r\n                        this.deleteGeneralOrden = false;\r\n                        this.showPinRequest = false;\r\n                        this.reasonToDelete = null;\r\n                        this.directSale();\r\n                    } else {\r\n                        this.$toast.error(message);\r\n                    }\r\n                }\r\n            } catch (e) {\r\n                if (e != \"cancel\") {\r\n                    console.log(e);\r\n                    // this.$toast.error(\"Ocurrió un error\");\r\n                }\r\n            } finally {\r\n                this.pin = \"\";\r\n                this.deleteOrdenLoading = false;\r\n            }\r\n        },\r\n        async cancelGeneralOrden(id) {\r\n            if (this.configuration.pin_orden_delete) {\r\n                this.cancelGeneralOrdenPin();\r\n            } else {\r\n                try {\r\n                    let res = await this.$confirm(\r\n                        \"Desea cancelar toda la orden?\",\r\n                        \"Cancelar\",\r\n                        {\r\n                            confirmButtonText: \"Ok\",\r\n                            cancelButtonText: \"Cancelar\",\r\n                            type: \"warning\"\r\n                        }\r\n                    );\r\n                    if (res) {\r\n                        this.loading = true;\r\n\r\n                        let form = {\r\n                            id\r\n                        };\r\n                        const response = await this.$http.post(\r\n                            \"cancel-orden\",\r\n                            form\r\n                        );\r\n                        if (response.status == 200) {\r\n                            const { message } = response.data;\r\n                            this.$toast.success(message);\r\n                            this.$eventHub.$emit(\"reloadData\");\r\n                            this.$emit(\"ordenDeleted\");\r\n                            this.directSale();\r\n                        }\r\n                    }\r\n                } catch (e) {\r\n                    if (e != \"cancel\") {\r\n                        console.log(e);\r\n                        this.$toast.error(\"Ocurrió un error\");\r\n                    }\r\n                } finally {\r\n                    this.loading = false;\r\n                }\r\n            }\r\n        },\r\n        allToCarry() {\r\n            if (this.localOrden.length == 0) return;\r\n            let ord = [...this.localOrden];\r\n            ord = ord.map(o => {\r\n                let {\r\n                    food: {\r\n                        item: { delivery_cost }\r\n                    }\r\n                } = o;\r\n                let delivery = Number(delivery_cost);\r\n                let factor = this.to_carry ? 1 : -1;\r\n                let price = Number(o.price) + delivery * factor;\r\n\r\n                return {\r\n                    ...o,\r\n                    to_carry: this.to_carry,\r\n                    price\r\n                };\r\n            });\r\n            this.$emit(\"update:localOrden\", ord);\r\n        },\r\n        toCarry(idx) {\r\n            let ord = [...this.localOrden];\r\n            let {\r\n                food: {\r\n                    item: { delivery_cost }\r\n                }\r\n            } = ord[idx];\r\n            ord[idx].to_carry = !ord[idx].to_carry;\r\n            let delivery = Number(delivery_cost);\r\n            let factor = ord[idx].to_carry ? 1 : -1;\r\n            ord[idx].price = Number(ord[idx].price) + delivery * factor;\r\n\r\n            this.$emit(\"update:localOrden\", ord);\r\n        },\r\n        verifyStock(orden, idx) {\r\n              let current_orden = this.localOrden.filter(\r\n                    o => o.id == orden.id\r\n                );\r\n            let unit_type_id = current_orden[0].food.item.unit_type_id;\r\n            if (this.configuration.sales_stock && !this.quotation_stock && unit_type_id != 'ZZ') {\r\n              \r\n                let qty = current_orden.reduce(\r\n                    (a, b) => a + Number(b.quantity),\r\n                    0\r\n                );\r\n                let stock = 0;\r\n                if (\r\n                    current_orden.length == 1 &&\r\n                    current_orden[0].lotes.length == 1\r\n                ) {\r\n                    let [orden] = current_orden;\r\n                    let [lote] = orden.lotes;\r\n                    stock = lote.quantity;\r\n                } else {\r\n                    stock = Number(current_orden[0].food.item.stock);\r\n                }\r\n                if (qty > stock) {\r\n                    this.$toast.warning(\"Sobrepaso el stock\");\r\n                    let localOrden_quantity = this.localOrden;\r\n                    localOrden_quantity[idx].quantity = 1;\r\n                    return;\r\n                }\r\n                if (current_orden.length == 1) {\r\n                    let [orden] = current_orden;\r\n                    if (orden.lotes.length == 1) {\r\n                        orden.lotes[0].quantitySelected = this.localOrden[\r\n                            idx\r\n                        ].quantity;\r\n                    }\r\n                }\r\n            }\r\n\r\n            this.calculateTotal();\r\n        },\r\n        showOrdensPending() {\r\n            this.showPendingOrdens = true;\r\n        },\r\n\r\n        validStock(orden, quantity = 1) {\r\n            let qty = this.localOrden\r\n                .filter(o => o.id == orden.id)\r\n                .reduce((a, b) => a + Number(b.quantity), 0);\r\n            if (orden.type_id) {\r\n                qty += orden.type_quantity;\r\n            } else {\r\n                qty += quantity;\r\n            }\r\n            let stock = Number(orden.food.item.stock);\r\n            let unit_type_id = orden.food.item.unit_type_id;\r\n            if (\r\n                this.configuration.sales_stock == true &&\r\n                !this.quotation_stock && unit_type_id != 'ZZ'\r\n            ) {\r\n                if (qty > stock) {\r\n                    return true;\r\n                }\r\n            }\r\n            return false;\r\n        },\r\n        async printOrden() {\r\n            this.ordenLoading = true;\r\n            try {\r\n                await this.printTicket(this.clientTableData.orden_id);\r\n            } catch (e) {\r\n                this.$toast.error(\"No se pudo imprimir\");\r\n            } finally {\r\n                this.ordenLoading = false;\r\n            }\r\n        },\r\n        async sendOrden() {\r\n            if (this.localOrden.length == 0 && !this.variation) {\r\n                this.$toast.warning(\"Orden sin productos\");\r\n                return;\r\n            }\r\n            let orden = {\r\n                status_orden_id: 1,\r\n                table_id: this.clientTableData.table_id,\r\n                to_carry: this.to_carry\r\n            };\r\n\r\n            this.ordenLoading = true;\r\n            try {\r\n                const responses = await this.$http.post(\r\n                    \"/caja/worker/send-orden\",\r\n                    {\r\n                        id: this.clientTableData.orden_id,\r\n                        ref: this.clientTableData.ref,\r\n                        items: this.localOrden,\r\n                        caja: true,\r\n                        printing: true,\r\n                        saleDirect: false,\r\n                        orden\r\n                    }\r\n                );\r\n                let ordenId = responses.data.id;\r\n                this.ordenLoading = false;\r\n                if (responses.status != 200) {\r\n                    this.$toast.warning(\"Ocurrió un error\");\r\n\r\n                    return;\r\n                }\r\n                this.to_carry = false;\r\n                this.$emit(\"cancelOrden\");\r\n                this.$emit(\"update:isCreatingOrden\", false);\r\n                let msg = \"\";\r\n                if (this.clientTableData.orden_id) {\r\n                    msg = `Se agregaron los pedidos a la orden ${ordenId}`;\r\n                } else {\r\n                    msg = `La orden ${ordenId} fue creada.`;\r\n                }\r\n                this.$toast.success(msg);\r\n            } catch (e) {\r\n                this.ordenLoading = false;\r\n                //no jala el clientdata tble - ref // lo guarda con el id mesa caja\r\n                this.$toast.error(\"Ocurrió un error\");\r\n            }\r\n        },\r\n        directSale() {\r\n            this.$emit(\"update:clientTableData\", {});\r\n            this.$emit(\"update:localOrden\", []);\r\n            this.$emit(\"update:ordens\", []);\r\n            this.$emit(\"update:blockCart\", false);\r\n            this.$emit(\"update:isCreatingOrden\", false);\r\n            //ordenId\r\n            this.$emit(\"update:idOrden\", null);\r\n            this.$emit(\"resetOrden\");\r\n        },\r\n        restoreToLocalOrdens(ordens) {\r\n            this.$emit(\"update:localOrden\", ordens);\r\n        },\r\n        async checkTables() {\r\n            const response = await this.$http(\"/caja/tables/check\");\r\n            const { data } = response;\r\n            return data;\r\n        },\r\n\r\n        async trigerFunction(id) {\r\n            switch (id) {\r\n                case 7:\r\n                    if (!this.cash_id) {\r\n                        this.$toast.error(\"Abra una caja\");\r\n                    } else {\r\n                        this.showExpensesIncomes = true;\r\n                    }\r\n                    break;\r\n                case 2:\r\n                    this.showTransfers();\r\n                    break;\r\n                case 3:\r\n                    if (this.cash_id) {\r\n                        if (this.configuration.ordens_cash) {\r\n                            let data = await this.checkTables();\r\n                            if (!data.success) {\r\n                                this.showDialogClose = true;\r\n                            } else {\r\n                                let { ordenes, total, items } = data;\r\n                                try {\r\n                                    await this.$confirm(\r\n                                        `Existen ${ordenes} ordenes pendientes por cobrar, con un total de ${total} soles. Desea emitir una nota de venta por el total?`,\r\n                                        \"Cerrar Caja\",\r\n                                        {\r\n                                            confirmButtonText: \"Emitir\",\r\n                                            cancelButtonText: \"Cerrar\",\r\n                                            type: \"warning\"\r\n                                        }\r\n                                    );\r\n\r\n                                    this.$emit(\"sendOrdensAllTables\", items);\r\n                                } catch (e) {\r\n                                    console.log(e);\r\n                                }\r\n                            }\r\n                        } else {\r\n                            this.showDialogClose = true;\r\n                        }\r\n                    } else {\r\n                        this.showDialogCash = true;\r\n                    }\r\n                    break;\r\n                case 5:\r\n                    this.showOrdensPending();\r\n                    break;\r\n                case 4:\r\n                    if (this.ordenInBox.length > 0) {\r\n                        this.listApart = true;\r\n                    } else {\r\n                        this.$toast.warning(\"Sin ventas apartacadas.\");\r\n                    }\r\n                    break;\r\n\r\n                default:\r\n                    //naa\r\n                    break;\r\n            }\r\n        },\r\n        limpiarForm() {\r\n            this.quotation_stock = false;\r\n            this.$emit(\"limpiarForm\");\r\n        },\r\n        openApart() {\r\n            if (this.localOrden.length == 0) {\r\n                this.$toast.error(\"Sin ordenes pendientes\");\r\n                return;\r\n            }\r\n            this.apart = true;\r\n        },\r\n        pullApartOrden() {\r\n            if (\r\n                !this.numberCustomerApart &&\r\n                this.numberCustomerApart.length <= 1\r\n            ) {\r\n                this.$toast.error(\"Documento o referencia inválida\");\r\n                return;\r\n            } else if (this.ordenInBox.length == 3) {\r\n                this.$toast.error(\"Limite excedido. \");\r\n                return;\r\n            } else if (\r\n                this.ordenInBox.some(\r\n                    f =>\r\n                        f.ref.toLowerCase() ==\r\n                        this.numberCustomerApart.toLowerCase()\r\n                )\r\n            ) {\r\n                this.$toast.error(\"La referencia ya existe\");\r\n                return;\r\n            } else {\r\n                this.ordenInBox.push({\r\n                    ref: this.numberCustomerApart,\r\n                    ordens: this.localOrden\r\n                });\r\n\r\n                localStorage.ordens = JSON.stringify(this.ordenInBox);\r\n                this.numberCustomerApart = undefined;\r\n                this.apart = false;\r\n                this.$emit(\"cancelOrden\");\r\n                this.$toast.success(\"Orden aparcada\");\r\n            }\r\n        },\r\n        async cancelOrden() {\r\n            try {\r\n                let res = await this.$confirm(\r\n                    \"Desea cancelar este pedido?\",\r\n                    \"Cancelar\",\r\n                    {\r\n                        confirmButtonText: \"Ok\",\r\n                        cancelButtonText: \"Cancelar\",\r\n                        type: \"warning\"\r\n                    }\r\n                );\r\n                if (res) {\r\n                    this.isConsignment = false;\r\n                    this.$emit(\"cancelOrden\");\r\n                }\r\n            } catch (e) {}\r\n        },\r\n        addNumberPin(number) {\r\n            if (this.pin.length >= 4) {\r\n                return;\r\n            }\r\n            this.pin += number.toString();\r\n        },\r\n        close() {\r\n            this.$emit(\"update:localOrden\", []);\r\n        },\r\n        update_price(index, sale_unit_price) {\r\n            let localOrden_update = this.localOrden;\r\n            localOrden_update[index].food.sale_unit_price = sale_unit_price;\r\n            this.$emit(\"update:localOrden\", localOrden_update);\r\n            this.calculateTotal();\r\n        },\r\n        sumar_orden(index) {\r\n            if (this.validStock(this.localOrden[index])) {\r\n                this.$toast.warning(\"Limite de stock alcanzado\");\r\n                return;\r\n            }\r\n            let localOrden_quantity = this.localOrden;\r\n            if (this.localOrden[index].type_id) {\r\n                localOrden_quantity[index].quantity =\r\n                    Number(localOrden_quantity[index].quantity) + 1;\r\n                // localOrden_quantity[index].quantity =\r\n                //     Number(localOrden_quantity[index].quantity) +\r\n                //     Number(localOrden_quantity[index].type_quantity);\r\n            } else {\r\n                localOrden_quantity[index].quantity =\r\n                    Number(localOrden_quantity[index].quantity) + 1;\r\n            }\r\n\r\n            this.$emit(\"update:localOrden\", localOrden_quantity);\r\n            this.calculateTotal();\r\n        },\r\n        restar_orden(index) {\r\n            let localOrden_quantity = this.localOrden;\r\n            let min = 1;\r\n            if (this.localOrden[index].type_id) {\r\n                min = Number(localOrden_quantity[index].type_quantity);\r\n            }\r\n            let quantity = localOrden_quantity[index].quantity * min;\r\n            if (quantity > min) {\r\n                // if (localOrden_quantity[index].quantity > min) {\r\n                if (this.localOrden[index].type_id) {\r\n                    // localOrden_quantity[index].quantity =\r\n                    //     Number(localOrden_quantity[index].quantity) -\r\n                    //     Number(localOrden_quantity[index].type_quantity);\r\n                    localOrden_quantity[index].quantity =\r\n                        Number(localOrden_quantity[index].quantity) - 1;\r\n                } else {\r\n                    localOrden_quantity[index].quantity =\r\n                        Number(localOrden_quantity[index].quantity) - 1;\r\n                }\r\n\r\n                this.$emit(\"update:localOrden\", localOrden_quantity);\r\n                this.calculateTotal();\r\n            } else {\r\n                this.$toast.warning(\"Mínimo permitido\");\r\n            }\r\n        },\r\n        async printTicket(id) {\r\n            try {\r\n                const response = await this.$http.get(\r\n                    `/caja/worker/record/${id}`\r\n                );\r\n                let url = response.data.print;\r\n\r\n                let config = qz.configs.create(response.data.printer, {\r\n                    scaleContent: false\r\n                });\r\n                if (!qz.websocket.isActive()) {\r\n                    await qz.websocket.connect(config);\r\n                }\r\n                let data = [\r\n                    {\r\n                        type: \"pdf\",\r\n                        format: \"file\",\r\n                        data: url\r\n                    }\r\n                ];\r\n                qz.print(config, data).catch(e => {\r\n                    this.$toast.error(e.message);\r\n                });\r\n\r\n                //this.$toast.success(\"se esta imprimiendo el comprobante con exito\");\r\n                // qz.websocket.disconnect()\r\n            } catch (e) {\r\n                this.$toast.error(e.message);\r\n            }\r\n        },\r\n\r\n        view_orders() {\r\n            $(\".style-switcher\")\r\n                .animate(\r\n                    {\r\n                        right: \"0\"\r\n                    },\r\n                    300\r\n                )\r\n                .addClass(\"active\");\r\n        },\r\n\r\n        closeDialog(ordenId = null) {\r\n            let ordenToAdd = [...this.localOrden];\r\n            ordenToAdd = ordenToAdd.map(o => ({\r\n                status_orden_id: 1,\r\n                food: {\r\n                    description: o.food.description,\r\n                    price: o.food.price\r\n                },\r\n                observations: o.observation\r\n            }));\r\n            // let allOrdens = [...ordenToAdd, ...this.ordens];\r\n            this.$emit(\"updateOrdens\", ordenId);\r\n            this.$emit(\"listtables\");\r\n            // this.$emit(\"update:ordens\", allOrdens);\r\n            this.$emit(\"update:localOrden\", []);\r\n            this.$eventHub.$emit(\"reloadData\");\r\n            this.totalOrdenItems = 0.0;\r\n            this.total = 0.0;\r\n            this.totalOrden = 0.0;\r\n        },\r\n        clear_command() {\r\n            this.commands_fisico = null;\r\n        },\r\n        checkIsExistSerie() {\r\n            let hasError = false;\r\n            for (let ord of this.localOrden) {\r\n                let { series_enabled } = ord.food.item;\r\n\r\n                if (series_enabled && ord.series.length == 0) {\r\n                    hasError = true;\r\n                    break;\r\n                }\r\n            }\r\n            return hasError;\r\n        },\r\n        async payOrden() {\r\n            if (this.checkIsExistSerie()) {\r\n                this.$toast.error(\"Producto sin serie seleccionada\");\r\n                return;\r\n            }\r\n            if (!this.cash_id) {\r\n                this.$toast.error(\"No tiene una caja abierta\");\r\n                return;\r\n            }\r\n            if (this.clientTableData.table) {\r\n                if (this.ordens.length == 0) {\r\n                    this.$toast.warning(\"Orden sin productos\");\r\n                    return;\r\n                }\r\n            } else {\r\n                if (this.localOrden.length == 0 && !this.variation) {\r\n                    this.$toast.warning(\"Orden sin productos\");\r\n                    return;\r\n                }\r\n            }\r\n\r\n            this.disableSend = true;\r\n            let form_submit = {\r\n                id: null,\r\n                caja: true,\r\n                printDocument: this.printing,\r\n                printing: this.configuration.print_commands,\r\n                commands_fisico: this.commands_fisico,\r\n                print_kitchen: this.configuration.print_kitchen,\r\n                to_carry: this.to_carry,\r\n                orden: {\r\n                    table_id: 1,\r\n                    status_orden_id: 1\r\n                },\r\n\r\n                pin: null\r\n            };\r\n            if (this.clientTableData.table) {\r\n                form_submit.items = this.ordens;\r\n            } else {\r\n                form_submit.items = this.localOrden;\r\n            }\r\n            form_submit.items = this.mergeItems(form_submit.items);\r\n            this.loading = true;\r\n\r\n\r\n            this.commands_fisico = \"\";\r\n            this.to_carry = false;\r\n\r\n\r\n            this.loading = false;\r\n            this.disableSend = false;\r\n         \r\n            if (this.variation) {\r\n                form_submit.variationItems = this.foodDefaults;\r\n            }\r\n            this.loading = false;\r\n            this.disableSend = false;\r\n\r\n            if (this.variation) {\r\n                this.$emit(\"paymentsOrden\", form_submit, this.foodDefaults);\r\n            } else {\r\n                this.$emit(\"paymentsOrden\", form_submit);\r\n            }\r\n        },\r\n        mergeItems(items) {\r\n            let hasFoodId = items.every(item => item.food && item.food.id);\r\n            if (!hasFoodId) {\r\n                return items;\r\n            }\r\n            const resultado = {};\r\n            // Recorrer el arreglo original\r\n            items.forEach(obj => {\r\n                const key = `${obj.food.id}-${Number(obj.price).toFixed(2)}`;\r\n                if (resultado[key]) {\r\n                    resultado[key].quantity += Number(obj.quantity);\r\n                } else {\r\n                    resultado[key] = { ...obj,quantity: Number(obj.quantity) };\r\n                }\r\n            });\r\n\r\n            const arregloResultado = Object.values(resultado);\r\n            return arregloResultado;\r\n        },\r\n        formatUrlImage(url) {\r\n            if (!url) return;\r\n            let formated = \"storage/uploads/items/\" + url;\r\n            return `/${formated}`;\r\n        },\r\n    \r\n        calculateTotal(w = null) {\r\n            this.totalOrdenItems = 0.0;\r\n            this.total = 0.0;\r\n            this.totalOrden = 0.0;\r\n            let OrdenPen = 0;\r\n            let OrdenPenAtendidos = 0;\r\n            let nTotal_poratendidos = _.forEach(this.localOrden, function(\r\n                value\r\n            ) {\r\n                OrdenPen = parseFloat(OrdenPen) + value.quantity * value.price;\r\n            });\r\n            this.totalOrden = _.round(OrdenPen, 2);\r\n            let nTotal_atendidos = _.forEach(this.ordens, function(values) {\r\n                OrdenPenAtendidos =\r\n                    parseFloat(OrdenPenAtendidos) +\r\n                    values.quantity * values.price;\r\n            });\r\n            this.totalOrdenItems = _.round(OrdenPenAtendidos, 2);\r\n            // this.total = this.totalOrden + this.totalOrdenItems;\r\n            this.total = _.round(this.totalOrden, 2);\r\n            this.$emit(\"total_salcancelOrdenaes\", this.total);\r\n        },\r\n        deleteFood(idx) {\r\n            this.$emit(\"deletedFood\", idx);\r\n            this.calculateTotal();\r\n        },\r\n        async submit() {\r\n            //this.loading = true;\r\n            this.showDialogPing = true;\r\n            this.open_orders();\r\n        },\r\n        async cancelOrdenaPin() {\r\n            if (this.pin.length > 3 && this.reasonToDelete) {\r\n                if (this.deleteGeneralOrden) {\r\n                    this.deleteGeneralOrdenPin();\r\n                } else {\r\n                    try {\r\n                        this.deleteOrdenLoading = true;\r\n                        const response = await this.$http.post(\r\n                            `delete-orden-pin`,\r\n                            {\r\n                                id: this.ordenIdToDelete,\r\n                                pin: this.pin,\r\n                                reason: this.reasonToDelete\r\n                            }\r\n                        );\r\n                        if (response.status == 200) {\r\n                            if (response.data.success) {\r\n                                const { message } = response.data;\r\n                                let newOrdenItems = [...this.ordens];\r\n                                newOrdenItems = newOrdenItems.filter(\r\n                                    n => n.id != this.ordenIdToDelete\r\n                                );\r\n                                this.$emit(\"update:ordens\", newOrdenItems);\r\n                                this.$eventHub.$emit(\"reloadData\");\r\n                                this.$toast.success(message);\r\n                                this.reasonToDelete = null;\r\n                                this.showPinRequest = false;\r\n                            } else {\r\n                                this.$toast.error(response.data.message);\r\n                            }\r\n                        }\r\n                    } catch (e) {\r\n                        console.log(e);\r\n                        this.$toast.error(\"Ocurrió un error\");\r\n                    } finally {\r\n                        this.pin = \"\";\r\n                        this.deleteOrdenLoading = false;\r\n                    }\r\n                }\r\n            } else {\r\n                this.$toast.error(\"Ingrese el pin\");\r\n                return;\r\n            }\r\n        },\r\n\r\n        generatePin(num) {\r\n            if (this.pin.length == 4) {\r\n                return;\r\n            }\r\n            this.pin += num;\r\n        },\r\n        async cancelOrdena(id) {\r\n            if (this.configuration.pin_orden_delete) {\r\n                this.showPinRequest = true;\r\n                this.ordenIdToDelete = id;\r\n            } else {\r\n                try {\r\n                    let x = await this.$confirm(\r\n                        `Está apunto de cancelar un producto de una orden.`,\r\n                        \"Mensaje de Advertencia\",\r\n                        {\r\n                            confirmButtonText: \"Eliminar\",\r\n                            cancelButtonText: \"Cancelar\",\r\n                            type: \"warning\"\r\n                        }\r\n                    );\r\n                    if (id && x) {\r\n                        const response = await this.$http.delete(\r\n                            `delete-orden/${id}`\r\n                        );\r\n                        if (response.status == 200) {\r\n                            const { message } = response.data;\r\n                            let newOrdenItems = [...this.ordens];\r\n                            newOrdenItems = newOrdenItems.filter(\r\n                                n => n.id != id\r\n                            );\r\n                            this.$emit(\"update:ordens\", newOrdenItems);\r\n                            this.$eventHub.$emit(\"reloadData\");\r\n                            this.$toast.success(message);\r\n                        }\r\n                    }\r\n                } catch (e) {\r\n                    //todo\r\n                    console.log(e);\r\n                    if (e != \"cancel\") {\r\n                        this.$toast.error(\"Ocurrió un error\");\r\n                    }\r\n                }\r\n            }\r\n        },\r\n        async ordenReady(id) {\r\n            this.loading = true;\r\n            try {\r\n                const response = await this.$http.get(`ordens-ready/${id}`);\r\n\r\n                const { success, message } = response.data;\r\n                success\r\n                    ? this.$toast.success(message)\r\n                    : this.$toast.error(message);\r\n                if (success) {\r\n                    let cloneOrdenItems = [...this.ordens];\r\n                    cloneOrdenItems = cloneOrdenItems.map(o => {\r\n                        if (o.id == id) {\r\n                            o.status_orden_id = 3;\r\n                        }\r\n                        return o;\r\n                    });\r\n                    this.$emit(\"update:ordens\", cloneOrdenItems);\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n                this.$toast.error(\"Ocurrió un error\");\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        changeLocalObservation() {\r\n            let ordensModified = [...this.localOrden];\r\n            ordensModified[\r\n                this.currentLocalOrden\r\n            ].observation = this.localObservation;\r\n            this.$emit(\"update:localOrden\", ordensModified);\r\n            this.closeLocalObservationDialog();\r\n        },\r\n        async changeObservation() {\r\n            //this.localObservation\r\n            this.loadingObservation = true;\r\n            const response = await this.$http.post(\"change-observation\", {\r\n                observation: this.observation,\r\n                id: this.currentOrden\r\n            });\r\n            if (response.status == 200) {\r\n                this.$eventHub.$emit(\"reloadData\");\r\n                let newOrdenItems = [...this.ordens];\r\n                newOrdenItems.find(\r\n                    n => n.id == this.currentOrden\r\n                ).observations = this.observation;\r\n            }\r\n            this.loadingObservation = false;\r\n            this.closeObservationDialog();\r\n        },\r\n        openObservationDialog(id, idx) {\r\n            this.currentOrden = id;\r\n            this.observation = this.ordens[idx].observations;\r\n            this.dialogObservation = true;\r\n        },\r\n        closeObservationDialog() {\r\n            this.dialogObservation = false;\r\n            this.observation = null;\r\n        },\r\n\r\n        openLocalObservationDialog(idx, obs) {\r\n            this.showObservations = true;\r\n            this.currentLocalOrden = idx;\r\n            this.current = obs;\r\n            return;\r\n\r\n            this.localObservation = this.localOrden[idx].observation;\r\n            this.dialogLocalObservation = true;\r\n        },\r\n        closeLocalObservationDialog() {\r\n            this.dialogLocalObservation = false;\r\n            this.currentLocalOrden = null;\r\n            this.localObservation = null;\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-28dd8919\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue":
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
      _c("div", [
        _vm.screenWidth > 678
          ? _c(
              "div",
              { staticClass: "d-md-flex  flex-wrap justify-content-between" },
              [
                _c(
                  "div",
                  {
                    staticClass: "dropdown-as-select d-inline-block mb-1",
                    attrs: { "data-childselector": "span" }
                  },
                  [
                    _vm._m(0),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "dropdown-menu dropdown-menu-end col-md-2 col-1 ",
                        staticStyle: { width: "153px" }
                      },
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
                            key: idx,
                            staticClass: "col-12"
                          },
                          [
                            option.visible
                              ? _c(
                                  "el-button",
                                  {
                                    staticClass:
                                      "\n                                        btn btn-light\n                                        m-1\n                                        rounded\n                                        d-flex\n                                        flex-column\n                                        align-items-center\n                                        justify-content-center\n                                        col-12\n                                        ",
                                    staticStyle: { "max-width": "150px" },
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
                                      [
                                        _vm._l(option.title, function(
                                          title,
                                          idx2
                                        ) {
                                          return _c(
                                            "p",
                                            {
                                              key: idx2,
                                              staticStyle: {
                                                margin: "0 !important",
                                                padding: "0 !important",
                                                "font-size": "15px"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                    " +
                                                  _vm._s(title) +
                                                  "\n                                "
                                              )
                                            ]
                                          )
                                        }),
                                        _vm._v(" "),
                                        _c("i", {
                                          class: [option.icon, "fa-1x"]
                                        })
                                      ],
                                      2
                                    ),
                                    _vm._v(" "),
                                    _c("div")
                                  ]
                                )
                              : _vm._e()
                          ],
                          1
                        )
                      }),
                      0
                    )
                  ]
                )
              ]
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.screenWidth < 600
          ? _c(
              "div",
              { staticClass: "d-flex flex-wrap" },
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
                    option.visible && option.id != 5
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "\n              m-1\n              btn btn-light\n              rounded\n              d-flex\n              flex-column\n              align-items-center\n              justify-content-center\n            ",
                            staticStyle: {
                              "max-width": "60px",
                              "max-height": "60px"
                            },
                            on: {
                              click: function($event) {
                                return _vm.trigerFunction(option.id)
                              }
                            }
                          },
                          [
                            _c("div", {
                              staticClass: "text-center",
                              staticStyle: { "margin-bottom": "2px" }
                            }),
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
                              _c("i", { class: [option.icon] })
                            ])
                          ]
                        )
                      : _vm._e()
                  ]
                )
              }),
              0
            )
          : _vm._e(),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "bg-primary align-items-center rounded-top",
            staticStyle: { "padding-top": "12px" }
          },
          [
            _vm.clientTableData.table
              ? _c("div", { staticClass: "row col-12" }, [
                  _c("div", { staticClass: "col-6" }, [
                    _c("h3", { staticClass: "text-white" }, [
                      _c(
                        "strong",
                        { staticStyle: { "padding-left": "20px" } },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                " " +
                                  (_vm.isCreatingOrden
                                    ? "CREANDO ORDEN"
                                    : _vm.clientTableData.orden_id
                                    ? "(ORDEN n°\n                                                            " +
                                      _vm.clientTableData.orden_id +
                                      ")"
                                    : "")
                              ) +
                              "\n                        "
                          )
                        ]
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-6" }, [
                    _c(
                      "h3",
                      {
                        staticClass: "text-white",
                        staticStyle: { "text-align": "right" }
                      },
                      [
                        _vm._v(
                          "\n                        Total S/. " +
                            _vm._s(
                              (_vm.total + _vm.totalOrdenItems).toFixed(2)
                            ) +
                            "\n                    "
                        )
                      ]
                    )
                  ])
                ])
              : _vm._e(),
            _vm._v(" "),
            _vm.clientTableData.table
              ? _c(
                  "div",
                  {
                    staticClass: "row h5 text-white col-12",
                    staticStyle: { "padding-left": "25px" }
                  },
                  [
                    _c("strong", [
                      _vm._v(
                        "\n                    Mesa " +
                          _vm._s(_vm.clientTableData.table) +
                          "- Ref:\n                    " +
                          _vm._s(_vm.clientTableData.ref) +
                          "\n                "
                      )
                    ])
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _c("div", { staticClass: "row col-12" }, [
              _c(
                "div",
                {
                  staticClass: "h5 text-white col-6",
                  staticStyle: { "padding-left": "25px" }
                },
                [
                  !_vm.clientTableData.table
                    ? _c(
                        "strong",
                        [
                          !_vm.isConsignment
                            ? [
                                _vm._v(
                                  "\n                            VENTA DIRECTA\n                        "
                                )
                              ]
                            : [
                                _vm._v(
                                  "\n                            LIQUIDACIÓN DE CONSIGNACIÓN\n                        "
                                )
                              ]
                        ],
                        2
                      )
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-6" }, [
                !_vm.clientTableData.table
                  ? _c(
                      "h3",
                      {
                        staticClass: "text-white",
                        staticStyle: { "text-align": "right" }
                      },
                      [
                        _vm._v(
                          "\n                        Total S/. " +
                            _vm._s(
                              (_vm.total + _vm.totalOrdenItems).toFixed(2)
                            ) +
                            "\n                    "
                        )
                      ]
                    )
                  : _vm._e()
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c("div", { class: "p-1 bg-primary" }, [
          _c("div", { staticClass: "row col-md-12 mx-1" }, [
            _c(
              "div",
              [
                this.quotation_stock &&
                _vm.configuration.quotation &&
                _vm.localOrden.length != 0
                  ? [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-light mt-2",
                          staticStyle: {
                            "max-height": "45px",
                            "max-width": "80px"
                          },
                          attrs: { alt: "Cotizar ", type: "button" },
                          on: { click: _vm.openQuotation }
                        },
                        [
                          _c("i", {
                            staticClass: "fas fa-clipboard-list",
                            staticStyle: { color: "var(--primary) !important" }
                          }),
                          _vm._v(" "),
                          _c("br"),
                          _vm._v(
                            "\n                            Cotizar\n                        "
                          )
                        ]
                      )
                    ]
                  : [
                      _vm.isCreatingOrden == false
                        ? _c(
                            "button",
                            {
                              staticClass: "btn btn-light mt-2",
                              staticStyle: {
                                "max-height": "45px",
                                "max-width": "80px"
                              },
                              attrs: {
                                alt: "Cobrar La venta ",
                                type: "button"
                              },
                              on: {
                                click: function($event) {
                                  return _vm.payOrden()
                                }
                              }
                            },
                            [
                              _c("i", {
                                staticClass: "fas fa-money-bill-wave",
                                staticStyle: {
                                  color: "var(--primary) !important"
                                }
                              }),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(
                                "\n                            Cobrar\n                        "
                              )
                            ]
                          )
                        : _vm._e()
                    ],
                _vm._v(" "),
                _vm.isCreatingOrden == true ||
                _vm.clientTableData.table == undefined
                  ? _c(
                      "button",
                      {
                        staticClass: "btn btn-light mt-2",
                        staticStyle: {
                          "max-height": "45px",
                          "max-width": "80px"
                        },
                        attrs: { type: "button" },
                        on: { click: _vm.cancelOrden }
                      },
                      [
                        _c("i", {
                          staticClass: "fas fa-trash",
                          staticStyle: { color: "var(--primary) !important" }
                        }),
                        _vm._v(" "),
                        _c("br"),
                        _vm._v(
                          "\n                        Limpiar\n                    "
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                (_vm.isCreatingOrden == true || _vm.clientTableData.orden_id) &&
                _vm.localOrden.length != 0
                  ? _c(
                      "button",
                      {
                        staticClass: "btn btn-light mt-2",
                        staticStyle: {
                          "max-height": "45px",
                          "max-width": "80px"
                        },
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.sendOrden()
                          }
                        }
                      },
                      [
                        _c("i", {
                          staticClass: "fas fa-paper-plane",
                          staticStyle: { color: "var(--primary) !important" }
                        }),
                        _c("br"),
                        _vm._v(
                          "\n                        Enviar\n                    "
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.isCreatingOrden == false &&
                _vm.clientTableData.table != undefined &&
                _vm.ordens.length != 0
                  ? _c(
                      "button",
                      {
                        staticClass: "btn btn-light mt-2",
                        staticStyle: {
                          "max-height": "45px",
                          "max-width": "80px"
                        },
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.printOrden()
                          }
                        }
                      },
                      [
                        _c("i", {
                          staticClass: "fas fa-print",
                          staticStyle: { color: "var(--primary) !important" }
                        }),
                        _c("br"),
                        _vm._v(
                          "\n                        Imprimir\n                    "
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.isCreatingOrden == false &&
                _vm.clientTableData.table != undefined &&
                _vm.ordens.length != 0
                  ? _c(
                      "button",
                      {
                        staticClass: "btn btn-light mt-2",
                        staticStyle: {
                          "max-height": "45px",
                          "max-width": "80px"
                        },
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.cancelGeneralOrden(
                              _vm.clientTableData.orden_id
                            )
                          }
                        }
                      },
                      [
                        _c("i", {
                          staticClass: "fas fa-window-close",
                          staticStyle: { color: "var(--primary) !important" }
                        }),
                        _c("br"),
                        _vm._v(
                          "\n                        Cancelar\n                    "
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "dropdown-as-select d-inline-block mt-2",
                    attrs: { "data-childselector": "span" }
                  },
                  [
                    _vm._m(1),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "dropdown-menu dropdown-menu-start col-md-2 col-1",
                        staticStyle: { "max-width": "154px" }
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "col-12" },
                          [
                            _vm.isCreatingOrden == false &&
                            _vm.clientTableData.table == undefined &&
                            !_vm.configuration.college
                              ? _c(
                                  "el-button",
                                  {
                                    staticClass:
                                      "\n                                        btn btn-light\n                                        m-1\n                                        rounded\n                                        d-flex\n                                        flex-column\n                                        align-items-center\n                                        justify-content-center\n                                        col-12\n                                        ",
                                    staticStyle: { "max-width": "150px" },
                                    on: { click: _vm.openApart }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "text-center",
                                        staticStyle: { "margin-bottom": "2px" }
                                      },
                                      [
                                        _c(
                                          "span",
                                          {
                                            staticStyle: {
                                              margin: "0 !important",
                                              padding: "0 !important"
                                            }
                                          },
                                          [
                                            _vm._v(
                                              "\n                                            Aparcar\n                                        "
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("i", {
                                          staticClass: "fas fa-cart-arrow-down",
                                          staticStyle: {
                                            color: "var(--primary) !important"
                                          }
                                        })
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c("div")
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _c("div")
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-12" },
                          [
                            _vm.configuration.consignment &&
                            _vm.localOrden.length != 0
                              ? _c(
                                  "el-button",
                                  {
                                    staticClass:
                                      "btn btn-light\n                                        m-1\n                                        rounded\n                                        d-flex\n                                        flex-column\n                                        align-items-center\n                                        justify-content-center\n                                        col-12\n                                        ",
                                    staticStyle: {
                                      "max-height": "45px",
                                      "max-width": "150px"
                                    },
                                    attrs: { type: "button" },
                                    on: { click: _vm.openConsignment }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "text-center",
                                        staticStyle: { "margin-bottom": "2px" }
                                      },
                                      [
                                        _c(
                                          "span",
                                          {
                                            staticStyle: {
                                              margin: "0 !important",
                                              padding: "0 !important"
                                            }
                                          },
                                          [
                                            _vm._v(
                                              "\n                                            Consignar "
                                            )
                                          ]
                                        ),
                                        _c("i", {
                                          staticClass: "fas fa-clipboard-list",
                                          staticStyle: {
                                            color: "var(--primary) !important"
                                          }
                                        })
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c("div")
                                  ]
                                )
                              : _vm._e()
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-12" },
                          [
                            _vm.configuration.credits &&
                            _vm.localOrden.length != 0
                              ? _c(
                                  "el-button",
                                  {
                                    staticClass:
                                      "\n                                        btn btn-light\n                                        m-1\n                                        rounded\n                                        d-flex\n                                        flex-column\n                                        align-items-center\n                                        justify-content-center\n                                        col-12\n                                        ",
                                    staticStyle: { "max-width": "150px" },
                                    on: { click: _vm.openCredit }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "text-center",
                                        staticStyle: { "margin-bottom": "2px" }
                                      },
                                      [
                                        _c(
                                          "span",
                                          {
                                            staticStyle: {
                                              margin: "0 !important",
                                              padding: "0 !important"
                                            }
                                          },
                                          [
                                            _vm._v(
                                              "\n                                            Crédito\n                                        "
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("i", {
                                          staticClass: "fas fa-credit-card",
                                          staticStyle: {
                                            color: "var(--primary) !important"
                                          }
                                        })
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c("div")
                                  ]
                                )
                              : _vm._e()
                          ],
                          1
                        )
                      ]
                    )
                  ]
                )
              ],
              2
            ),
            _vm._v(" "),
            _vm.clientTableData.table
              ? _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-warning mt-2",
                      staticStyle: { "max-height": "45px" },
                      attrs: { type: "button" },
                      on: { click: _vm.directSale }
                    },
                    [
                      _vm._v(
                        "\n                        Venta Directa\n                    "
                      )
                    ]
                  )
                ])
              : _vm._e()
          ]),
          _vm._v(" "),
          _vm._m(2),
          _vm._v(" "),
          _c("div", { staticClass: "d-flex align-items-center p-1 m-2" }, [
            _c(
              "div",
              { staticClass: "col-12" },
              [
                _vm.configuration.restaurant &&
                (_vm.clientTableData.table == undefined ||
                  _vm.configuration.box_orden)
                  ? [
                      _vm.localOrden.length != 0 && !_vm.configuration.college
                        ? _c(
                            "el-checkbox",
                            {
                              on: { change: _vm.allToCarry },
                              model: {
                                value: _vm.to_carry,
                                callback: function($$v) {
                                  _vm.to_carry = $$v
                                },
                                expression: "to_carry"
                              }
                            },
                            [
                              _c("span", { staticClass: "text-white" }, [
                                _vm._v("Para llevar")
                              ])
                            ]
                          )
                        : _vm._e()
                    ]
                  : _vm._e(),
                _vm._v(" "),
                [
                  _vm.configuration.show_variation_dcto
                    ? _c(
                        "el-checkbox",
                        {
                          staticClass: "margin-left:5px;",
                          on: { change: _vm.changeVariation },
                          model: {
                            value: _vm.variation,
                            callback: function($$v) {
                              _vm.variation = $$v
                            },
                            expression: "variation"
                          }
                        },
                        [
                          _c("span", { staticClass: "text-white" }, [
                            _vm._v("Variación")
                          ])
                        ]
                      )
                    : _vm._e()
                ],
                _vm._v(" "),
                [
                  _vm.configuration.quotation
                    ? _c(
                        "el-checkbox",
                        {
                          staticClass: "margin-left:5px;",
                          on: { change: _vm.setQuotationStock },
                          model: {
                            value: _vm.quotation_stock,
                            callback: function($$v) {
                              _vm.quotation_stock = $$v
                            },
                            expression: "quotation_stock"
                          }
                        },
                        [
                          _c(
                            "span",
                            { staticClass: "text-white" },
                            [
                              _vm._v(
                                "Para cotizar\n                                "
                              ),
                              _c(
                                "el-tooltip",
                                {
                                  attrs: {
                                    content:
                                      "No se toma en cuenta el stock de los productos"
                                  }
                                },
                                [
                                  _c("i", {
                                    staticClass:
                                      "el-tooltip fa fa-info-circle item"
                                  })
                                ]
                              )
                            ],
                            1
                          )
                        ]
                      )
                    : _vm._e()
                ],
                _vm._v(" "),
                [
                  !_vm.configuration.college && _vm.configuration.restaurant
                    ? _c("el-input", {
                        attrs: {
                          type: "text",
                          maxlength: "11",
                          "show-word-limit": "",
                          placeholder: "Referencia (DNI)"
                        },
                        model: {
                          value: _vm.clientTableData.ref,
                          callback: function($$v) {
                            _vm.$set(_vm.clientTableData, "ref", $$v)
                          },
                          expression: "clientTableData.ref"
                        }
                      })
                    : _vm._e()
                ]
              ],
              2
            ),
            _vm._v(" "),
            _vm.establishments.conf && _vm.establishments.conf.direct_sale
              ? _c(
                  "div",
                  {
                    staticClass:
                      "col-md-6 d-flex  justify-content-end align-items-end"
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass: "d-flex flex-column",
                        staticStyle: { "margin-left": "15px" }
                      },
                      [
                        _c("label", { staticClass: "text-white" }, [
                          _vm._v("Venta rápida")
                        ]),
                        _vm._v(" "),
                        _c("el-switch", {
                          attrs: {
                            "active-color": "#13ce66",
                            "inactive-color": "#ff4949"
                          },
                          on: { change: _vm.changeQuickSale },
                          model: {
                            value: _vm.establishments.conf.pos_quick_sale,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.establishments.conf,
                                "pos_quick_sale",
                                $$v
                              )
                            },
                            expression: "establishments.conf.pos_quick_sale"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass: "d-flex flex-column",
                        staticStyle: { "margin-left": "15px" }
                      },
                      [
                        _vm.establishments.conf.pos_quick_sale
                          ? [
                              _c("label", { staticClass: "text-white" }, [
                                _vm._v("Impresión")
                              ]),
                              _vm._v(" "),
                              _c("el-switch", {
                                attrs: {
                                  "active-color": "#13ce66",
                                  "inactive-color": "#ff4949"
                                },
                                on: { change: _vm.savePrint },
                                model: {
                                  value: _vm.printing,
                                  callback: function($$v) {
                                    _vm.printing = $$v
                                  },
                                  expression: "printing"
                                }
                              })
                            ]
                          : _vm._e()
                      ],
                      2
                    )
                  ]
                )
              : _vm._e()
          ]),
          _vm._v(" "),
          _c(
            "section",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading,
                  expression: "loading"
                }
              ],
              staticClass: "scroll-section border bg-white",
              attrs: { vid: "checkboxes" }
            },
            [
              _c("div", { staticClass: "scroll-out" }, [
                _c(
                  "div",
                  {
                    staticClass:
                      "\n            scroll-by-count\n            os-host\n            os-theme-dark\n            os-host-overflow\n            os-host-overflow-y\n            os-host-resize-disabled\n            os-host-scrollbar-horizontal-hidden\n            os-host-transition\n          ",
                    staticStyle: { height: "71vh" },
                    attrs: { "data-count": "4", id: "checkboxTable" }
                  },
                  [
                    _vm._m(3),
                    _vm._v(" "),
                    _vm._m(4),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "os-content-glue",
                      staticStyle: { margin: "0px 5px" }
                    }),
                    _vm._v(" "),
                    _c("div", { staticClass: "os-padding" }, [
                      _c(
                        "div",
                        {
                          staticClass: "os-viewport",
                          staticStyle: {
                            "overflow-y": "scroll",
                            "margin-right": "15px"
                          }
                        },
                        [
                          _c("div", { staticClass: "m-3" }),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass: "os-content",
                              staticStyle: {
                                padding: "0px 5px",
                                height: "100%",
                                width: "100%"
                              }
                            },
                            [
                              _vm.ordens.length != 0 && !_vm.variation
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "\n                    mx-2\n                    h4\n                    txt-info\n                    p-10\n                    f-w-700\n                    d-flex\n                    align-items-center\n                  "
                                    },
                                    [
                                      _c(
                                        "a",
                                        {
                                          staticClass:
                                            "badge badge bg-dark text-white",
                                          staticStyle: { "margin-right": "5px" }
                                        },
                                        [
                                          _vm.ordens.length <= 9
                                            ? [
                                                _vm._v(
                                                  "\n                                                0" +
                                                    _vm._s(_vm.ordens.length) +
                                                    "\n                                            "
                                                )
                                              ]
                                            : [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(_vm.ordens.length) +
                                                    "\n                                            "
                                                )
                                              ]
                                        ],
                                        2
                                      ),
                                      _vm._v(
                                        "\n                                        Atendidos\n                                    "
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.variation
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "col-sm-12 col-md-12 col-lg-12 col-xl-12"
                                    },
                                    _vm._l(_vm.foodDefaults, function(
                                      variationItem,
                                      idx
                                    ) {
                                      return _c(
                                        "div",
                                        {
                                          key: idx,
                                          staticClass:
                                            "\n                      mx-2\n                      coupon\n                      rounded\n                      d-flex\n                      justify-content-between\n                    "
                                        },
                                        [
                                          _c(
                                            "div",
                                            {
                                              staticClass:
                                                "\n                        tengah\n                        py-2\n                        d-flex\n                        w-100\n                        justify-content-start\n                        p-2\n                      "
                                            },
                                            [
                                              _c(
                                                "div",
                                                {
                                                  staticClass: "overflow-hidden"
                                                },
                                                [
                                                  _c(
                                                    "h3",
                                                    {
                                                      staticClass:
                                                        "lead font-weight-light"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                                        " +
                                                          _vm._s(
                                                            variationItem.description.toUpperCase()
                                                          ) +
                                                          "\n                                                        "
                                                      ),
                                                      _c(
                                                        "el-tag",
                                                        {
                                                          attrs: {
                                                            role: "button"
                                                          },
                                                          on: {
                                                            click: function(
                                                              $event
                                                            ) {
                                                              return _vm.showChangeDescription(
                                                                idx
                                                              )
                                                            }
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                            Cambiar\n                                                        "
                                                          )
                                                        ]
                                                      ),
                                                      _vm._v(" "),
                                                      idx == 0
                                                        ? _c(
                                                            "el-tag",
                                                            {
                                                              attrs: {
                                                                type: "success",
                                                                role: "button"
                                                              },
                                                              on: {
                                                                click:
                                                                  _vm.addVariation
                                                              }
                                                            },
                                                            [
                                                              _vm._v(
                                                                "\n                                                            Agregar\n                                                        "
                                                              )
                                                            ]
                                                          )
                                                        : _vm._e(),
                                                      _vm._v(" "),
                                                      _vm.foodDefaults.length >
                                                      1
                                                        ? _c(
                                                            "el-tag",
                                                            {
                                                              attrs: {
                                                                type: "danger",
                                                                role: "button"
                                                              },
                                                              on: {
                                                                click: function(
                                                                  $event
                                                                ) {
                                                                  return _vm.deleteDefaultFood(
                                                                    idx
                                                                  )
                                                                }
                                                              }
                                                            },
                                                            [
                                                              _vm._v(
                                                                "x\n                                                        "
                                                              )
                                                            ]
                                                          )
                                                        : _vm._e()
                                                    ],
                                                    1
                                                  ),
                                                  _vm._v(" "),
                                                  _c("p", {
                                                    staticClass:
                                                      "\n                            badge\n                            bg-foreground\n                            text-uppercase\n                            font-weight-light\n                            p-0\n                          "
                                                  }),
                                                  _vm._v(" "),
                                                  _c(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "row align-items-end"
                                                    },
                                                    [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "col-md-4"
                                                        },
                                                        [
                                                          _c(
                                                            "span",
                                                            {
                                                              staticClass:
                                                                "text-muted"
                                                            },
                                                            [
                                                              _vm._v(
                                                                "\n                                                                Cantidad"
                                                              ),
                                                              _c("br"),
                                                              _vm._v(" "),
                                                              _c(
                                                                "div",
                                                                {
                                                                  staticClass:
                                                                    "input-group spinner"
                                                                },
                                                                [
                                                                  _c("input", {
                                                                    directives: [
                                                                      {
                                                                        name:
                                                                          "model",
                                                                        rawName:
                                                                          "v-model",
                                                                        value:
                                                                          variationItem.quantity,
                                                                        expression:
                                                                          "\n                                                                            variationItem.quantity\n                                                                        "
                                                                      }
                                                                    ],
                                                                    staticClass:
                                                                      "form-control text-center",
                                                                    attrs: {
                                                                      type:
                                                                        "text",
                                                                      "data-rule":
                                                                        "currency"
                                                                    },
                                                                    domProps: {
                                                                      value:
                                                                        variationItem.quantity
                                                                    },
                                                                    on: {
                                                                      input: function(
                                                                        $event
                                                                      ) {
                                                                        if (
                                                                          $event
                                                                            .target
                                                                            .composing
                                                                        ) {
                                                                          return
                                                                        }
                                                                        _vm.$set(
                                                                          variationItem,
                                                                          "quantity",
                                                                          $event
                                                                            .target
                                                                            .value
                                                                        )
                                                                      }
                                                                    }
                                                                  }),
                                                                  _vm._v(" "),
                                                                  _c(
                                                                    "div",
                                                                    {
                                                                      staticClass:
                                                                        "input-group-text"
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "button",
                                                                        {
                                                                          staticClass:
                                                                            "spin-up",
                                                                          attrs: {
                                                                            type:
                                                                              "button",
                                                                            "data-spin":
                                                                              "up"
                                                                          },
                                                                          on: {
                                                                            click: function(
                                                                              $event
                                                                            ) {
                                                                              return _vm.updateDefaultFoodQty(
                                                                                true,
                                                                                idx
                                                                              )
                                                                            }
                                                                          }
                                                                        },
                                                                        [
                                                                          _c(
                                                                            "span",
                                                                            {
                                                                              staticClass:
                                                                                "arrow"
                                                                            }
                                                                          )
                                                                        ]
                                                                      ),
                                                                      _vm._v(
                                                                        " "
                                                                      ),
                                                                      _c(
                                                                        "button",
                                                                        {
                                                                          staticClass:
                                                                            "spin-down",
                                                                          attrs: {
                                                                            type:
                                                                              "button",
                                                                            "data-spin":
                                                                              "down"
                                                                          },
                                                                          on: {
                                                                            click: function(
                                                                              $event
                                                                            ) {
                                                                              return _vm.updateDefaultFoodQty(
                                                                                false,
                                                                                idx
                                                                              )
                                                                            }
                                                                          }
                                                                        },
                                                                        [
                                                                          _c(
                                                                            "span",
                                                                            {
                                                                              staticClass:
                                                                                "arrow"
                                                                            }
                                                                          )
                                                                        ]
                                                                      )
                                                                    ]
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
                                                        {
                                                          staticClass:
                                                            "col-md-4"
                                                        },
                                                        [
                                                          _c(
                                                            "span",
                                                            {
                                                              staticClass:
                                                                "time font-weight-light"
                                                            },
                                                            [
                                                              _c(
                                                                "span",
                                                                {
                                                                  staticClass:
                                                                    "text-muted"
                                                                },
                                                                [
                                                                  _vm._v(
                                                                    "\n                                                                    Precio\n                                                                    "
                                                                  ),
                                                                  _c("br"),
                                                                  _vm._v(" "),
                                                                  _c(
                                                                    "el-input",
                                                                    {
                                                                      staticClass:
                                                                        "custom_input",
                                                                      staticStyle: {
                                                                        width:
                                                                          "100%"
                                                                      },
                                                                      attrs: {
                                                                        type:
                                                                          "number"
                                                                      },
                                                                      model: {
                                                                        value:
                                                                          variationItem.sale_unit_price,
                                                                        callback: function(
                                                                          $$v
                                                                        ) {
                                                                          _vm.$set(
                                                                            variationItem,
                                                                            "sale_unit_price",
                                                                            $$v
                                                                          )
                                                                        },
                                                                        expression:
                                                                          "\n                                                                            variationItem.sale_unit_price\n                                                                        "
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "template",
                                                                        {
                                                                          staticStyle: {
                                                                            "padding-left":
                                                                              "6px",
                                                                            "padding-right":
                                                                              "6px"
                                                                          },
                                                                          slot:
                                                                            "prepend"
                                                                        },
                                                                        [
                                                                          _vm._v(
                                                                            "\n                                                                            S/\n                                                                        "
                                                                          )
                                                                        ]
                                                                      )
                                                                    ],
                                                                    2
                                                                  )
                                                                ],
                                                                1
                                                              )
                                                            ]
                                                          )
                                                        ]
                                                      )
                                                    ]
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ]
                                      )
                                    }),
                                    0
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm._l(_vm.ordens, function(ord, idx) {
                                return _c(
                                  "div",
                                  {
                                    directives: [
                                      {
                                        name: "show",
                                        rawName: "v-show",
                                        value:
                                          _vm.ordens.length > 0 &&
                                          !_vm.variation,
                                        expression:
                                          "\n                                            ordens.length > 0 && !variation\n                                        "
                                      }
                                    ],
                                    key: idx + "-A",
                                    staticClass:
                                      "col-sm-12 col-md-12 col-lg-12 col-xl-12"
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "\n                      mx-2\n                      coupon\n                      rounded\n                      d-flex\n                      justify-content-between\n                    "
                                      },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "\n                        tengah\n                        py-2\n                        d-flex\n                        w-100\n                        justify-content-start\n                        p-2\n                      "
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "overflow-hidden card shadow-lg p-3",
                                                staticStyle: {
                                                  "box-shadow":
                                                    "rgba(0, 0, 0, 0.18) 0px 1rem 3rem !important"
                                                }
                                              },
                                              [
                                                _c(
                                                  "h3",
                                                  {
                                                    staticClass:
                                                      "lead font-weight-light"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                        " +
                                                        _vm._s(
                                                          ord.food.description.toUpperCase()
                                                        ) +
                                                        "\n                                                        "
                                                    ),
                                                    ord.type_id
                                                      ? _c(
                                                          "span",
                                                          {
                                                            staticClass:
                                                              "text-primary"
                                                          },
                                                          [
                                                            _c("small", [
                                                              _c("strong", [
                                                                _vm._v(
                                                                  "*" +
                                                                    _vm._s(
                                                                      ord.type_description
                                                                    )
                                                                )
                                                              ])
                                                            ])
                                                          ]
                                                        )
                                                      : _vm._e()
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c("p", {
                                                  staticClass:
                                                    "\n                            badge\n                            bg-foreground\n                            text-uppercase\n                            font-weight-light\n                            p-0\n                          "
                                                }),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "row align-items-end"
                                                  },
                                                  [
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "col-5 col-md-5 col-lg-3 col-xl-4"
                                                      },
                                                      [
                                                        _c(
                                                          "span",
                                                          {
                                                            staticClass:
                                                              "text-muted"
                                                          },
                                                          [
                                                            _vm._v(
                                                              "\n                                                                Cantidad"
                                                            ),
                                                            _c("br"),
                                                            _vm._v(" "),
                                                            _c(
                                                              "div",
                                                              {
                                                                staticClass:
                                                                  "input-group spinner",
                                                                attrs: {
                                                                  "data-trigger":
                                                                    "spinner"
                                                                }
                                                              },
                                                              [
                                                                _c("input", {
                                                                  directives: [
                                                                    {
                                                                      name:
                                                                        "model",
                                                                      rawName:
                                                                        "v-model",
                                                                      value:
                                                                        ord.quantity,
                                                                      expression:
                                                                        "\n                                                                            ord.quantity\n                                                                        "
                                                                    }
                                                                  ],
                                                                  staticClass:
                                                                    "form-control text-center",
                                                                  attrs: {
                                                                    type:
                                                                      "text",
                                                                    readonly:
                                                                      "",
                                                                    "data-rule":
                                                                      "currency"
                                                                  },
                                                                  domProps: {
                                                                    value:
                                                                      ord.quantity
                                                                  },
                                                                  on: {
                                                                    input: function(
                                                                      $event
                                                                    ) {
                                                                      if (
                                                                        $event
                                                                          .target
                                                                          .composing
                                                                      ) {
                                                                        return
                                                                      }
                                                                      _vm.$set(
                                                                        ord,
                                                                        "quantity",
                                                                        $event
                                                                          .target
                                                                          .value
                                                                      )
                                                                    }
                                                                  }
                                                                }),
                                                                _vm._v(" "),
                                                                _vm._m(5, true)
                                                              ]
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
                                                          "col-6 col-md-5 col-lg-3 col-xl-4"
                                                      },
                                                      [
                                                        _c(
                                                          "span",
                                                          {
                                                            staticClass:
                                                              "time font-weight-light"
                                                          },
                                                          [
                                                            _c(
                                                              "span",
                                                              {
                                                                staticClass:
                                                                  "text-muted"
                                                              },
                                                              [
                                                                _vm._v(
                                                                  "\n                                                                    Precio\n                                                                    "
                                                                ),
                                                                _c("br"),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "el-input",
                                                                  {
                                                                    staticClass:
                                                                      "custom_input",
                                                                    staticStyle: {
                                                                      width:
                                                                        "100%"
                                                                    },
                                                                    attrs: {
                                                                      type:
                                                                        "number"
                                                                    },
                                                                    on: {
                                                                      input:
                                                                        _vm.calculateTotal
                                                                    },
                                                                    model: {
                                                                      value:
                                                                        ord.price,
                                                                      callback: function(
                                                                        $$v
                                                                      ) {
                                                                        _vm.$set(
                                                                          ord,
                                                                          "price",
                                                                          $$v
                                                                        )
                                                                      },
                                                                      expression:
                                                                        "\n                                                                            ord.price\n                                                                        "
                                                                    }
                                                                  },
                                                                  [
                                                                    ord.food
                                                                      .item
                                                                      .currency_type_id ==
                                                                    "PEN"
                                                                      ? _c(
                                                                          "template",
                                                                          {
                                                                            slot:
                                                                              "prepend"
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              "\n                                                                            S/\n                                                                        "
                                                                            )
                                                                          ]
                                                                        )
                                                                      : _vm._e(),
                                                                    _vm._v(" "),
                                                                    ord.food
                                                                      .item
                                                                      .currency_type_id ==
                                                                    "USD"
                                                                      ? _c(
                                                                          "template",
                                                                          {
                                                                            slot:
                                                                              "prepend"
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              "\n                                                                            $\n                                                                        "
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
                                                        )
                                                      ]
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "col-md-6 m2 mt-2"
                                                      },
                                                      [
                                                        _c(
                                                          "el-button-group",
                                                          [
                                                            ord.status_orden_id !=
                                                            3
                                                              ? _c(
                                                                  "el-button",
                                                                  {
                                                                    attrs: {
                                                                      type:
                                                                        "success",
                                                                      icon:
                                                                        "el-icon-check",
                                                                      size:
                                                                        "mini",
                                                                      circle: ""
                                                                    },
                                                                    on: {
                                                                      click: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.ordenReady(
                                                                          ord.id
                                                                        )
                                                                      }
                                                                    }
                                                                  }
                                                                )
                                                              : _vm._e(),
                                                            _vm._v(" "),
                                                            _c("el-button", {
                                                              staticClass:
                                                                "text-white",
                                                              attrs: {
                                                                type: "danger",
                                                                icon:
                                                                  "el-icon-delete",
                                                                size: "mini",
                                                                circle: ""
                                                              },
                                                              on: {
                                                                click: function(
                                                                  $event
                                                                ) {
                                                                  return _vm.cancelOrdena(
                                                                    ord.id
                                                                  )
                                                                }
                                                              }
                                                            })
                                                          ],
                                                          1
                                                        ),
                                                        _vm._v(" "),
                                                        _c(
                                                          "el-tag",
                                                          {
                                                            attrs: {
                                                              size: "medium"
                                                            }
                                                          },
                                                          [
                                                            _c(
                                                              "strong",
                                                              {
                                                                staticStyle: {
                                                                  "font-weight":
                                                                    "700"
                                                                }
                                                              },
                                                              [
                                                                _vm._v(
                                                                  "\n                                                                    " +
                                                                    _vm._s(
                                                                      parseFloat(
                                                                        ord.price *
                                                                          ord.quantity
                                                                      ).toFixed(
                                                                        2
                                                                      )
                                                                    )
                                                                )
                                                              ]
                                                            )
                                                          ]
                                                        )
                                                      ],
                                                      1
                                                    ),
                                                    _vm._v(" "),
                                                    _vm.configuration
                                                      .restaurant &&
                                                    ord.observations
                                                      ? _c(
                                                          "div",
                                                          {
                                                            staticClass:
                                                              "col-md-12 mt-1"
                                                          },
                                                          [
                                                            _c("small", [
                                                              _vm._v(
                                                                "OBS:\n                                                                " +
                                                                  _vm._s(
                                                                    ord.observations
                                                                  )
                                                              )
                                                            ])
                                                          ]
                                                        )
                                                      : _vm._e()
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              }),
                              _vm._v(" "),
                              _vm.configuration.restaurant
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "\n                    mx-4\n                    h4\n                    txt-info\n                    p-10\n                    f-w-700\n                    d-flex\n                    align-items-center\n                  "
                                    },
                                    [
                                      _c(
                                        "a",
                                        {
                                          staticClass:
                                            "badge badge bg-dark text-white",
                                          staticStyle: { "margin-right": "5px" }
                                        },
                                        [
                                          _vm.localOrden.length <= 9
                                            ? [
                                                _vm._v(
                                                  "\n                                                0" +
                                                    _vm._s(
                                                      _vm.localOrden.length
                                                    ) +
                                                    "\n                                            "
                                                )
                                              ]
                                            : [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(
                                                      _vm.localOrden.length
                                                    ) +
                                                    "\n                                            "
                                                )
                                              ]
                                        ],
                                        2
                                      ),
                                      _vm._v(
                                        "\n                                        Por solicitar\n                                    "
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm._l(_vm.localOrden, function(
                                order_pend,
                                indexx
                              ) {
                                return _c(
                                  "div",
                                  {
                                    directives: [
                                      {
                                        name: "show",
                                        rawName: "v-show",
                                        value: _vm.localOrden.length > 0,
                                        expression: "localOrden.length > 0"
                                      }
                                    ],
                                    key: indexx,
                                    staticClass:
                                      "col-sm-12 col-md-12 col-lg-12 col-xl-12"
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "\n                      mx-2\n                      coupon\n                      rounded\n                      d-flex\n                      justify-content-between\n                    "
                                      },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "\n                        tengah\n                        py-2\n                        d-flex\n                        w-100\n                        justify-content-start\n                        p-2\n                      "
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "\n                          col-md-12\n                          overflow-hidden\n                          card\n                          shadow-lg\n                          p-3\n                          rounded\n                        ",
                                                staticStyle: {
                                                  "box-shadow":
                                                    "0 1rem 3rem rgb(0 0 0 / 18%) !important"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  { staticClass: "row" },
                                                  [
                                                    _c(
                                                      "h3",
                                                      {
                                                        staticClass:
                                                          "lead font-weight-light"
                                                      },
                                                      [
                                                        order_pend.food.item
                                                          .name_product_pdf
                                                          ? [
                                                              _vm._v(
                                                                "\n                                                                " +
                                                                  _vm._s(
                                                                    order_pend.food.item.name_product_pdf.toUpperCase()
                                                                  ) +
                                                                  "\n                                                            "
                                                              )
                                                            ]
                                                          : [
                                                              _vm._v(
                                                                "\n                                                                " +
                                                                  _vm._s(
                                                                    order_pend.food.description.toUpperCase()
                                                                  ) +
                                                                  "\n                                                            "
                                                              )
                                                            ],
                                                        _vm._v(" "),
                                                        order_pend.type_id
                                                          ? _c(
                                                              "span",
                                                              {
                                                                staticClass:
                                                                  "text-primary"
                                                              },
                                                              [
                                                                _c("small", [
                                                                  _c("strong", [
                                                                    _vm._v(
                                                                      "*" +
                                                                        _vm._s(
                                                                          order_pend.type_description
                                                                        )
                                                                    )
                                                                  ])
                                                                ])
                                                              ]
                                                            )
                                                          : _vm._e(),
                                                        _vm._v(" "),
                                                        _vm.configuration
                                                          .edit_name_product
                                                          ? _c(
                                                              "el-tooltip",
                                                              {
                                                                attrs: {
                                                                  content:
                                                                    "Cambiar nombre del producto"
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "el-tag",
                                                                  {
                                                                    attrs: {
                                                                      role:
                                                                        "button",
                                                                      type:
                                                                        "success",
                                                                      size:
                                                                        "mini"
                                                                    },
                                                                    on: {
                                                                      click: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.changeName(
                                                                          indexx
                                                                        )
                                                                      }
                                                                    }
                                                                  },
                                                                  [
                                                                    _c("i", {
                                                                      staticClass:
                                                                        "fas fa-edit text-black"
                                                                    })
                                                                  ]
                                                                )
                                                              ],
                                                              1
                                                            )
                                                          : _vm._e(),
                                                        _vm._v(" "),
                                                        order_pend.food.item
                                                          .name_product_pdf
                                                          ? _c(
                                                              "el-tooltip",
                                                              {
                                                                attrs: {
                                                                  content:
                                                                    "Restaurar nombre del producto"
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "el-tag",
                                                                  {
                                                                    attrs: {
                                                                      role:
                                                                        "button",
                                                                      type:
                                                                        "danger",
                                                                      size:
                                                                        "mini"
                                                                    },
                                                                    on: {
                                                                      click: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.restoreName(
                                                                          indexx
                                                                        )
                                                                      }
                                                                    }
                                                                  },
                                                                  [
                                                                    _c("i", {
                                                                      staticClass:
                                                                        "fas fa-times text-black"
                                                                    })
                                                                  ]
                                                                )
                                                              ],
                                                              1
                                                            )
                                                          : _vm._e()
                                                      ],
                                                      2
                                                    ),
                                                    _vm._v(" "),
                                                    _c("p", {
                                                      staticClass:
                                                        "\n                              badge\n                              bg-foreground\n                              text-uppercase\n                              font-weight-light\n                              p-0\n                            "
                                                    })
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  { staticClass: "row col-12" },
                                                  [
                                                    !_vm.configuration.college
                                                      ? _c(
                                                          "div",
                                                          {
                                                            staticClass:
                                                              "col-2 col-md-2"
                                                          },
                                                          [
                                                            _vm.configuration
                                                              .restaurant
                                                              ? _c(
                                                                  "el-tag",
                                                                  {
                                                                    attrs: {
                                                                      size:
                                                                        "medium",
                                                                      role:
                                                                        "button",
                                                                      type: order_pend.to_carry
                                                                        ? "success"
                                                                        : "info",
                                                                      effect: order_pend.to_carry
                                                                        ? "dark"
                                                                        : "plain"
                                                                    },
                                                                    on: {
                                                                      click: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.toCarry(
                                                                          indexx
                                                                        )
                                                                      }
                                                                    }
                                                                  },
                                                                  [
                                                                    _c("i", {
                                                                      staticClass:
                                                                        "fas fa-biking",
                                                                      staticStyle: {
                                                                        color:
                                                                          "black"
                                                                      }
                                                                    })
                                                                  ]
                                                                )
                                                              : _vm._e()
                                                          ],
                                                          1
                                                        )
                                                      : _vm._e(),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "col-4 col-md-4"
                                                      },
                                                      [
                                                        _c(
                                                          "el-button-group",
                                                          [
                                                            _c("el-button", {
                                                              staticClass:
                                                                "text-white",
                                                              attrs: {
                                                                type: "danger",
                                                                icon:
                                                                  "el-icon-delete",
                                                                size: "mini",
                                                                circle: ""
                                                              },
                                                              on: {
                                                                click: function(
                                                                  $event
                                                                ) {
                                                                  return _vm.deleteFood(
                                                                    indexx
                                                                  )
                                                                }
                                                              }
                                                            }),
                                                            _vm._v(" "),
                                                            _vm.configuration
                                                              .restaurant &&
                                                            !_vm.configuration
                                                              .college
                                                              ? _c(
                                                                  "el-button",
                                                                  {
                                                                    staticClass:
                                                                      "text-white",
                                                                    attrs: {
                                                                      type:
                                                                        "info",
                                                                      icon:
                                                                        "el-icon-s-order",
                                                                      size:
                                                                        "mini",
                                                                      circle: ""
                                                                    },
                                                                    on: {
                                                                      click: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.openLocalObservationDialog(
                                                                          indexx,
                                                                          order_pend.observation
                                                                        )
                                                                      }
                                                                    }
                                                                  }
                                                                )
                                                              : _vm._e()
                                                          ],
                                                          1
                                                        )
                                                      ],
                                                      1
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "row align-items-end"
                                                  },
                                                  [
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "col-4 col-md-5 col-lg-4 col-xl-4"
                                                      },
                                                      [
                                                        _c(
                                                          "span",
                                                          {
                                                            staticClass:
                                                              "text-muted"
                                                          },
                                                          [
                                                            _vm._v(
                                                              "\n                                                                Cantidad"
                                                            ),
                                                            _c("br"),
                                                            _vm._v(" "),
                                                            _c(
                                                              "div",
                                                              {
                                                                staticClass:
                                                                  "input-group spinner",
                                                                attrs: {
                                                                  "data-trigger":
                                                                    "spinner"
                                                                }
                                                              },
                                                              [
                                                                _c("input", {
                                                                  directives: [
                                                                    {
                                                                      name:
                                                                        "model",
                                                                      rawName:
                                                                        "v-model",
                                                                      value:
                                                                        order_pend.quantity,
                                                                      expression:
                                                                        "\n                                                                            order_pend.quantity\n                                                                        "
                                                                    }
                                                                  ],
                                                                  staticClass:
                                                                    "form-control text-center",
                                                                  attrs: {
                                                                    type:
                                                                      "text",
                                                                    readonly:
                                                                      order_pend
                                                                        .food
                                                                        .item
                                                                        .is_set ==
                                                                        1 ||
                                                                      _vm.isConsignment ||
                                                                      !_vm
                                                                        .configuration
                                                                        .quantity_cash ||
                                                                      order_pend
                                                                        .food
                                                                        .item
                                                                        .series_enabled ==
                                                                        1 ||
                                                                      (order_pend
                                                                        .food
                                                                        .item
                                                                        .lots_enabled ==
                                                                        1 &&
                                                                        order_pend
                                                                          .food
                                                                          .item
                                                                          .lots_group
                                                                          .length >
                                                                          1),
                                                                    "data-rule":
                                                                      "currency"
                                                                  },
                                                                  domProps: {
                                                                    value:
                                                                      order_pend.quantity
                                                                  },
                                                                  on: {
                                                                    input: [
                                                                      function(
                                                                        $event
                                                                      ) {
                                                                        if (
                                                                          $event
                                                                            .target
                                                                            .composing
                                                                        ) {
                                                                          return
                                                                        }
                                                                        _vm.$set(
                                                                          order_pend,
                                                                          "quantity",
                                                                          $event
                                                                            .target
                                                                            .value
                                                                        )
                                                                      },
                                                                      function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.verifyStock(
                                                                          order_pend,
                                                                          indexx
                                                                        )
                                                                      }
                                                                    ]
                                                                  }
                                                                }),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "div",
                                                                  {
                                                                    staticClass:
                                                                      "input-group-text"
                                                                  },
                                                                  [
                                                                    _c(
                                                                      "button",
                                                                      {
                                                                        staticClass:
                                                                          "spin-up",
                                                                        attrs: {
                                                                          type:
                                                                            "button",
                                                                          "data-spin":
                                                                            "up",
                                                                          disabled:
                                                                            order_pend
                                                                              .food
                                                                              .item
                                                                              .is_set ==
                                                                              1 ||
                                                                            _vm.isConsignment ||
                                                                            order_pend
                                                                              .food
                                                                              .item
                                                                              .series_enabled ==
                                                                              1 ||
                                                                            (order_pend
                                                                              .food
                                                                              .item
                                                                              .lots_enabled ==
                                                                              1 &&
                                                                              order_pend
                                                                                .food
                                                                                .item
                                                                                .lots_group
                                                                                .length >
                                                                                1)
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.sumar_orden(
                                                                              indexx
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "span",
                                                                          {
                                                                            staticClass:
                                                                              "arrow"
                                                                          }
                                                                        )
                                                                      ]
                                                                    ),
                                                                    _vm._v(" "),
                                                                    _c(
                                                                      "button",
                                                                      {
                                                                        staticClass:
                                                                          "spin-down",
                                                                        attrs: {
                                                                          type:
                                                                            "button",
                                                                          "data-spin":
                                                                            "down",
                                                                          disabled:
                                                                            _vm.isConsignment ||
                                                                            order_pend
                                                                              .food
                                                                              .item
                                                                              .series_enabled ==
                                                                              1 ||
                                                                            (order_pend
                                                                              .food
                                                                              .item
                                                                              .lotes_enabled ==
                                                                              1 &&
                                                                              order_pend
                                                                                .food
                                                                                .item
                                                                                .lots_group
                                                                                .length >
                                                                                1)
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.restar_orden(
                                                                              indexx
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "span",
                                                                          {
                                                                            staticClass:
                                                                              "arrow"
                                                                          }
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
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
                                                      {
                                                        staticClass:
                                                          "col-4 col-md-5 col-lg-5 col-xl-4"
                                                      },
                                                      [
                                                        _c(
                                                          "span",
                                                          {
                                                            staticClass:
                                                              "time font-weight-light"
                                                          },
                                                          [
                                                            _c(
                                                              "span",
                                                              {
                                                                staticClass:
                                                                  "text-muted"
                                                              },
                                                              [
                                                                _vm._v(
                                                                  "\n                                                                    Precio\n                                                                    "
                                                                ),
                                                                _c("br"),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "el-input",
                                                                  {
                                                                    staticClass:
                                                                      "custom_input",
                                                                    attrs: {
                                                                      disabled:
                                                                        order_pend.type_id !=
                                                                          null ||
                                                                        _vm
                                                                          .configuration
                                                                          .edit_price_sales ==
                                                                          false,
                                                                      type:
                                                                        "number"
                                                                    },
                                                                    on: {
                                                                      input: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.update_price(
                                                                          indexx,
                                                                          order_pend.price
                                                                        )
                                                                      }
                                                                    },
                                                                    model: {
                                                                      value:
                                                                        order_pend.price,
                                                                      callback: function(
                                                                        $$v
                                                                      ) {
                                                                        _vm.$set(
                                                                          order_pend,
                                                                          "price",
                                                                          $$v
                                                                        )
                                                                      },
                                                                      expression:
                                                                        "\n                                                                            order_pend.price\n                                                                        "
                                                                    }
                                                                  },
                                                                  [
                                                                    order_pend
                                                                      .food.item
                                                                      .currency_type_id ==
                                                                    "PEN"
                                                                      ? _c(
                                                                          "template",
                                                                          {
                                                                            slot:
                                                                              "prepend"
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              "\n                                                                            S/\n                                                                        "
                                                                            )
                                                                          ]
                                                                        )
                                                                      : _vm._e(),
                                                                    _vm._v(" "),
                                                                    order_pend
                                                                      .food.item
                                                                      .currency_type_id ==
                                                                    "USD"
                                                                      ? _c(
                                                                          "template",
                                                                          {
                                                                            slot:
                                                                              "prepend"
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              "\n                                                                            $\n                                                                        "
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
                                                        )
                                                      ]
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "col-4 col-md-2 col-lg-3 mt-2"
                                                      },
                                                      [
                                                        !order_pend.change_subtotal
                                                          ? _c(
                                                              "el-tag",
                                                              {
                                                                attrs: {
                                                                  "disable-transitions": true,
                                                                  size: "medium"
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "strong",
                                                                  {
                                                                    staticStyle: {
                                                                      "font-weight":
                                                                        "700"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "\n                                                                    " +
                                                                        _vm._s(
                                                                          parseFloat(
                                                                            order_pend.price *
                                                                              order_pend.quantity
                                                                          ).toFixed(
                                                                            2
                                                                          )
                                                                        )
                                                                    )
                                                                  ]
                                                                )
                                                              ]
                                                            )
                                                          : _c("el-input", {
                                                              staticClass:
                                                                "input-new-tag1",
                                                              attrs: {
                                                                placeholder:
                                                                  "0.00",
                                                                size: "medium"
                                                              },
                                                              on: {
                                                                input: function(
                                                                  $event
                                                                ) {
                                                                  return _vm.justNumber(
                                                                    indexx
                                                                  )
                                                                }
                                                              },
                                                              model: {
                                                                value:
                                                                  order_pend.newSubtotal,
                                                                callback: function(
                                                                  $$v
                                                                ) {
                                                                  _vm.$set(
                                                                    order_pend,
                                                                    "newSubtotal",
                                                                    $$v
                                                                  )
                                                                },
                                                                expression:
                                                                  "\n                                                                    order_pend.newSubtotal\n                                                                "
                                                              }
                                                            }),
                                                        _vm._v(" "),
                                                        _vm.configuration
                                                          .edit_subtotal_box
                                                          ? [
                                                              !order_pend.change_subtotal
                                                                ? _c(
                                                                    "el-tag",
                                                                    {
                                                                      attrs: {
                                                                        role:
                                                                          "button",
                                                                        size:
                                                                          "medium"
                                                                      },
                                                                      on: {
                                                                        click: function(
                                                                          $event
                                                                        ) {
                                                                          return _vm.changeSubtotal(
                                                                            indexx
                                                                          )
                                                                        }
                                                                      }
                                                                    },
                                                                    [
                                                                      _c("i", {
                                                                        staticClass:
                                                                          "fas fa-edit text-primary"
                                                                      })
                                                                    ]
                                                                  )
                                                                : _c(
                                                                    "el-tag",
                                                                    {
                                                                      attrs: {
                                                                        role:
                                                                          "button",
                                                                        size:
                                                                          "medium"
                                                                      },
                                                                      on: {
                                                                        click: function(
                                                                          $event
                                                                        ) {
                                                                          return _vm.saveSubtotal(
                                                                            indexx
                                                                          )
                                                                        }
                                                                      }
                                                                    },
                                                                    [
                                                                      _c("i", {
                                                                        staticClass:
                                                                          "fas fa-save text-primary"
                                                                      })
                                                                    ]
                                                                  )
                                                            ]
                                                          : _vm._e()
                                                      ],
                                                      2
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                order_pend.food.item
                                                  .series_enabled
                                                  ? _c(
                                                      "div",
                                                      [
                                                        order_pend.series
                                                          .length == 0
                                                          ? [
                                                              _c(
                                                                "el-tag",
                                                                {
                                                                  staticStyle: {
                                                                    "margin-top":
                                                                      "5px"
                                                                  },
                                                                  attrs: {
                                                                    role:
                                                                      "button",
                                                                    type:
                                                                      "danger"
                                                                  },
                                                                  on: {
                                                                    click: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.showSeriesDialog(
                                                                        order_pend,
                                                                        indexx
                                                                      )
                                                                    }
                                                                  }
                                                                },
                                                                [
                                                                  _vm._v(
                                                                    "**Seleccione\n                                                                una serie\n                                                            "
                                                                  )
                                                                ]
                                                              )
                                                            ]
                                                          : [
                                                              _vm._l(
                                                                order_pend.series,
                                                                function(
                                                                  serie,
                                                                  idx
                                                                ) {
                                                                  return _c(
                                                                    "div",
                                                                    {
                                                                      key: idx,
                                                                      staticStyle: {
                                                                        "margin-top":
                                                                          "5px"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "el-tag",
                                                                        {
                                                                          attrs: {
                                                                            type:
                                                                              "primary",
                                                                            closable:
                                                                              "",
                                                                            "disable-transitions": false
                                                                          },
                                                                          on: {
                                                                            close: function(
                                                                              $event
                                                                            ) {
                                                                              return _vm.deleteSerie(
                                                                                indexx,
                                                                                serie.id
                                                                              )
                                                                            }
                                                                          }
                                                                        },
                                                                        [
                                                                          _vm._v(
                                                                            "\n                                                                    " +
                                                                              _vm._s(
                                                                                serie.series
                                                                              ) +
                                                                              "\n                                                                "
                                                                          )
                                                                        ]
                                                                      ),
                                                                      _vm._v(
                                                                        " "
                                                                      ),
                                                                      _c("br")
                                                                    ],
                                                                    1
                                                                  )
                                                                }
                                                              ),
                                                              _vm._v(" "),
                                                              _c(
                                                                "el-tag",
                                                                {
                                                                  staticStyle: {
                                                                    "margin-top":
                                                                      "5px"
                                                                  },
                                                                  attrs: {
                                                                    role:
                                                                      "button",
                                                                    type:
                                                                      "success"
                                                                  },
                                                                  on: {
                                                                    click: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.showSeriesDialog(
                                                                        order_pend,
                                                                        indexx
                                                                      )
                                                                    }
                                                                  }
                                                                },
                                                                [
                                                                  _vm._v(
                                                                    "Ver Series\n                                                            "
                                                                  )
                                                                ]
                                                              )
                                                            ]
                                                      ],
                                                      2
                                                    )
                                                  : _vm._e(),
                                                _vm._v(" "),
                                                order_pend.food.item
                                                  .lots_enabled &&
                                                !order_pend.food.item
                                                  .series_enabled
                                                  ? _c(
                                                      "div",
                                                      [
                                                        order_pend.lotes
                                                          .length == 0
                                                          ? [
                                                              _c(
                                                                "el-tag",
                                                                {
                                                                  staticStyle: {
                                                                    "margin-top":
                                                                      "5px"
                                                                  },
                                                                  attrs: {
                                                                    role:
                                                                      "button",
                                                                    type:
                                                                      "danger"
                                                                  },
                                                                  on: {
                                                                    click:
                                                                      _vm.showLotesDialog
                                                                  }
                                                                },
                                                                [
                                                                  _vm._v(
                                                                    "**Seleccione\n                                                                el\n                                                                lote"
                                                                  )
                                                                ]
                                                              )
                                                            ]
                                                          : [
                                                              _vm._l(
                                                                order_pend.lotes,
                                                                function(
                                                                  lot,
                                                                  idx
                                                                ) {
                                                                  return _c(
                                                                    "div",
                                                                    {
                                                                      directives: [
                                                                        {
                                                                          name:
                                                                            "show",
                                                                          rawName:
                                                                            "v-show",
                                                                          value:
                                                                            lot.quantitySelected >
                                                                            0,
                                                                          expression:
                                                                            "\n                                                                    lot.quantitySelected >\n                                                                        0\n                                                                "
                                                                        }
                                                                      ],
                                                                      key: idx,
                                                                      staticStyle: {
                                                                        "margin-top":
                                                                          "5px"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "el-tooltip",
                                                                        {
                                                                          attrs: {
                                                                            content:
                                                                              "Cant. en almacén: " +
                                                                              lot.quantity
                                                                          }
                                                                        },
                                                                        [
                                                                          _c(
                                                                            "el-tag",
                                                                            {
                                                                              attrs: {
                                                                                type:
                                                                                  "primary"
                                                                              }
                                                                            },
                                                                            [
                                                                              _vm._v(
                                                                                "\n                                                                        " +
                                                                                  _vm._s(
                                                                                    lot.code
                                                                                  ) +
                                                                                  "\n                                                                        "
                                                                              ),
                                                                              order_pend
                                                                                .food
                                                                                .item
                                                                                .lots_group
                                                                                .length >
                                                                              1
                                                                                ? [
                                                                                    _vm._v(
                                                                                      "\n                                                                            -\n                                                                            Cant.\n                                                                            " +
                                                                                        _vm._s(
                                                                                          lot.quantitySelected
                                                                                        ) +
                                                                                        "\n                                                                        "
                                                                                    )
                                                                                  ]
                                                                                : _vm._e()
                                                                            ],
                                                                            2
                                                                          )
                                                                        ],
                                                                        1
                                                                      ),
                                                                      _vm._v(
                                                                        " "
                                                                      ),
                                                                      _c("br")
                                                                    ],
                                                                    1
                                                                  )
                                                                }
                                                              ),
                                                              _vm._v(" "),
                                                              order_pend.food
                                                                .item.lots_group
                                                                .length > 1
                                                                ? _c(
                                                                    "el-tag",
                                                                    {
                                                                      staticStyle: {
                                                                        "margin-top":
                                                                          "5px"
                                                                      },
                                                                      attrs: {
                                                                        role:
                                                                          "button",
                                                                        type:
                                                                          "success"
                                                                      },
                                                                      on: {
                                                                        click: function(
                                                                          $event
                                                                        ) {
                                                                          return _vm.showLotesDialog(
                                                                            order_pend,
                                                                            indexx
                                                                          )
                                                                        }
                                                                      }
                                                                    },
                                                                    [
                                                                      _vm._v(
                                                                        "Ver Lotes\n                                                            "
                                                                      )
                                                                    ]
                                                                  )
                                                                : _vm._e()
                                                            ]
                                                      ],
                                                      2
                                                    )
                                                  : _vm._e(),
                                                _vm._v(" "),
                                                order_pend.observation
                                                  ? _c("div", [
                                                      _c("small", [
                                                        _vm._v(
                                                          "OBS:\n                                                            " +
                                                            _vm._s(
                                                              order_pend.observation
                                                            )
                                                        )
                                                      ])
                                                    ])
                                                  : _vm._e(),
                                                _vm._v(" "),
                                                _vm.isConsignment
                                                  ? _c(
                                                      "div",
                                                      { staticClass: "row" },
                                                      [
                                                        !order_pend.is_penalty
                                                          ? _c(
                                                              "div",
                                                              {
                                                                staticClass:
                                                                  "col-md-4"
                                                              },
                                                              [
                                                                _c(
                                                                  "label",
                                                                  {
                                                                    attrs: {
                                                                      for:
                                                                        "warehouse"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "Para el\n                                                                almacen"
                                                                    )
                                                                  ]
                                                                ),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "el-input-number",
                                                                  {
                                                                    staticClass:
                                                                      "w-100",
                                                                    attrs: {
                                                                      min: 0,
                                                                      "controls-position":
                                                                        "right"
                                                                    },
                                                                    on: {
                                                                      change: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.updateWarehouse(
                                                                          order_pend,
                                                                          indexx
                                                                        )
                                                                      }
                                                                    },
                                                                    model: {
                                                                      value:
                                                                        order_pend.toWarehouse,
                                                                      callback: function(
                                                                        $$v
                                                                      ) {
                                                                        _vm.$set(
                                                                          order_pend,
                                                                          "toWarehouse",
                                                                          $$v
                                                                        )
                                                                      },
                                                                      expression:
                                                                        "\n                                                                    order_pend.toWarehouse\n                                                                "
                                                                    }
                                                                  }
                                                                )
                                                              ],
                                                              1
                                                            )
                                                          : _vm._e()
                                                      ]
                                                    )
                                                  : _vm._e()
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("hr")
                                      ]
                                    )
                                  ]
                                )
                              }),
                              _vm._v(" "),
                              _vm.localOrden.length == 0 && !_vm.variation
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "\n                    d-flex\n                    h-50\n                    justify-content-center\n                    align-items-center\n                  "
                                    },
                                    [
                                      _c(
                                        "p",
                                        { staticClass: "font-weight-lighter" },
                                        [
                                          _vm._v(
                                            "\n                                            Lista vacía.\n                                        "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ],
                            2
                          )
                        ]
                      )
                    ])
                  ]
                )
              ])
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            visible: _vm.dialogLocalObservation,
            "append-to-body": "",
            title: "Editando observación"
          },
          on: { close: _vm.closeLocalObservationDialog }
        },
        [
          _c(
            "span",
            [
              _c("label", { staticClass: "control-label" }, [
                _vm._v(" Observación ")
              ]),
              _vm._v(" "),
              _c("el-input", {
                model: {
                  value: _vm.localObservation,
                  callback: function($$v) {
                    _vm.localObservation = $$v
                  },
                  expression: "localObservation"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c(
                "button",
                {
                  staticClass: "btn btn-sm btn-secondary",
                  on: { click: _vm.changeLocalObservation }
                },
                [_vm._v("\n                Cambiar\n            ")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-sm btn-light",
                  on: { click: _vm.closeLocalObservationDialog }
                },
                [_vm._v("\n                Cerrar\n            ")]
              )
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            visible: _vm.apart,
            "close-on-click-modal": false,
            "close-on-press-escape": false,
            title: "Aparcar orden",
            width: "20%"
          },
          on: {
            close: function($event) {
              _vm.apart = false
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "card p-2" },
            [
              _c("label", { staticClass: "control-label" }, [
                _vm._v("Datos Referenciales")
              ]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "Dni o Nombre" },
                model: {
                  value: _vm.numberCustomerApart,
                  callback: function($$v) {
                    _vm.numberCustomerApart = $$v
                  },
                  expression: "numberCustomerApart"
                }
              }),
              _vm._v(" "),
              _c("div", { staticClass: "d-flex justify-content-end" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-light m-1",
                    on: {
                      click: function($event) {
                        _vm.apart = false
                      }
                    }
                  },
                  [_vm._v("\n                    Cancelar\n                ")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary m-1",
                    on: { click: _vm.pullApartOrden }
                  },
                  [_vm._v("\n                    Aparcar\n                ")]
                )
              ])
            ],
            1
          )
        ]
      ),
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
      }),
      _vm._v(" "),
      _c("show-lotes-product", {
        attrs: {
          idx: _vm.currentIdx,
          orden: _vm.ordenLot,
          showDialog: _vm.showLotes
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showLotes = $event
          },
          "update:show-dialog": function($event) {
            _vm.showLotes = $event
          },
          updateLotes: _vm.updateLotes
        }
      }),
      _vm._v(" "),
      _c("show-series-product", {
        attrs: {
          limitQty: _vm.limitQty,
          idx: _vm.currentIdx,
          item: _vm.currentItem,
          showDialog: _vm.showSeries,
          seriesSelected: _vm.currentSeries,
          establishments: _vm.establishments
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showSeries = $event
          },
          "update:show-dialog": function($event) {
            _vm.showSeries = $event
          },
          "update:seriesSelected": function($event) {
            _vm.currentSeries = $event
          },
          "update:series-selected": function($event) {
            _vm.currentSeries = $event
          },
          updateSeries: _vm.updateSeries
        }
      }),
      _vm._v(" "),
      _c("orden-pull-apart", {
        attrs: { showPullApart: _vm.listApart, ordenInBox: _vm.ordenInBox },
        on: {
          restoreToLocalOrdens: _vm.restoreToLocalOrdens,
          "update:showPullApart": function($event) {
            _vm.listApart = $event
          },
          "update:show-pull-apart": function($event) {
            _vm.listApart = $event
          },
          "update:ordenInBox": function($event) {
            _vm.ordenInBox = $event
          },
          "update:orden-in-box": function($event) {
            _vm.ordenInBox = $event
          }
        }
      }),
      _vm._v(" "),
      _c("table-ordens-pending", {
        attrs: { areas: _vm.areas, showPendingOrdens: _vm.showPendingOrdens },
        on: {
          "update:showPendingOrdens": function($event) {
            _vm.showPendingOrdens = $event
          },
          "update:show-pending-ordens": function($event) {
            _vm.showPendingOrdens = $event
          }
        }
      }),
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
          fromBox: true,
          configuration: _vm.configuration
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
          cash_id: _vm.cash_id,
          establishments: _vm.establishments
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
      _c("observation-form", {
        attrs: {
          current: _vm.current,
          observations: _vm.tags,
          showDialog: _vm.showObservations
        },
        on: {
          "update:observations": function($event) {
            _vm.tags = $event
          },
          "update:showDialog": function($event) {
            _vm.showObservations = $event
          },
          "update:show-dialog": function($event) {
            _vm.showObservations = $event
          },
          addObservation: _vm.addObservation
        }
      }),
      _vm._v(" "),
      _c("quotation-form", {
        attrs: {
          showDialog: _vm.showQuotationForm,
          items: _vm.localOrden,
          customers: _vm.customers,
          cash_id: _vm.cash_id,
          sellers: _vm.sellers
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showQuotationForm = $event
          },
          "update:show-dialog": function($event) {
            _vm.showQuotationForm = $event
          },
          limpiarForm: _vm.limpiarForm
        }
      }),
      _vm._v(" "),
      _c("credit-form", {
        attrs: {
          showDialog: _vm.showCreditForm,
          items: _vm.localOrden,
          customers: _vm.customers,
          cash_id: _vm.cash_id,
          all_series: _vm.all_series,
          establishments: _vm.establishments
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showCreditForm = $event
          },
          "update:show-dialog": function($event) {
            _vm.showCreditForm = $event
          },
          limpiarForm: _vm.limpiarForm,
          "update:all_series": function($event) {
            _vm.all_series = $event
          }
        }
      }),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            visible: _vm.showChangeDescriptionVariation,
            title: "Cambiar descripción"
          },
          on: {
            "update:visible": function($event) {
              _vm.showChangeDescriptionVariation = $event
            },
            close: function($event) {
              _vm.showChangeDescriptionVariation = false
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "card p-3" },
            [
              _c("el-input", {
                attrs: { placeholder: "Nueva descripción" },
                model: {
                  value: _vm.descriptionTemp,
                  callback: function($$v) {
                    _vm.descriptionTemp = $$v
                  },
                  expression: "descriptionTemp"
                }
              }),
              _c("br"),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "d-flex justify-content-end" },
                [
                  _c(
                    "el-button",
                    {
                      attrs: { type: "primary" },
                      on: { click: _vm.changeDescription }
                    },
                    [_vm._v("\n                    Cambiar\n                ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-button",
                    {
                      on: {
                        click: function($event) {
                          _vm.showChangeDescriptionVariation = false
                        }
                      }
                    },
                    [_vm._v("\n                    Cerrar\n                ")]
                  )
                ],
                1
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.deleteOrdenLoading,
              expression: "deleteOrdenLoading"
            }
          ],
          attrs: {
            width: "450px",
            visible: _vm.showPinRequest,
            title: "Ingrese su PIN",
            "append-to-body": ""
          },
          on: {
            "update:visible": function($event) {
              _vm.showPinRequest = $event
            }
          }
        },
        [
          _c("div", { staticClass: "row mt-1" }, [
            _c(
              "p",
              {
                staticClass: "h5",
                staticStyle: { "word-break": "break-word" }
              },
              [
                _vm._v(
                  "\n                Para poder eliminar la orden debe ingresar un motivo y su\n                PIN de usuario.\n            "
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-1" }, [
            _c(
              "div",
              { staticClass: "col-12 " },
              [
                _c("el-input", {
                  attrs: {
                    placeholder: "Ingrese un motivo",
                    type: "textarea",
                    maxlength: "200",
                    "show-word-limit": ""
                  },
                  model: {
                    value: _vm.reasonToDelete,
                    callback: function($$v) {
                      _vm.reasonToDelete = $$v
                    },
                    expression: "reasonToDelete"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-2 " }, [
            _c(
              "div",
              { staticClass: "col-12 " },
              [
                _c("el-input", {
                  attrs: {
                    placeholder: "Ingrese su PIN",
                    type: "password",
                    maxlength: "4",
                    readonly: ""
                  },
                  model: {
                    value: _vm.pin,
                    callback: function($$v) {
                      _vm.pin = $$v
                    },
                    expression: "pin"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col-12 card ",
                staticStyle: {
                  "max-width": "218px",
                  "margin-left": "104px",
                  "margin-top": "14px"
                }
              },
              [
                _c(
                  "div",
                  {
                    staticClass: "row",
                    staticStyle: { "margin-left": "20px" }
                  },
                  _vm._l([1, 2, 3], function(num) {
                    return _c(
                      "el-button",
                      {
                        key: num,
                        staticClass: "m-2 col-md-4 btn-rounded2 btn-primary",
                        staticStyle: {
                          "border-radius": "50% !important",
                          width: "42px",
                          color: "white"
                        },
                        on: {
                          click: function($event) {
                            return _vm.generatePin(num)
                          }
                        }
                      },
                      [_vm._v(_vm._s(num) + "\n                    ")]
                    )
                  }),
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "row",
                    staticStyle: { "margin-left": "20px" }
                  },
                  _vm._l([4, 5, 6], function(num) {
                    return _c(
                      "el-button",
                      {
                        key: num,
                        staticClass: "m-2 col-md-4 btn-primary",
                        staticStyle: {
                          "border-radius": "50% !important",
                          width: "42px",
                          color: "white"
                        },
                        on: {
                          click: function($event) {
                            return _vm.generatePin(num)
                          }
                        }
                      },
                      [_vm._v(_vm._s(num) + "\n                    ")]
                    )
                  }),
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "row",
                    staticStyle: { "margin-left": "20px" }
                  },
                  _vm._l([7, 8, 9], function(num) {
                    return _c(
                      "el-button",
                      {
                        key: num,
                        staticClass: "m-2 col-md-4 btn-primary",
                        staticStyle: {
                          "border-radius": "50% !important",
                          width: "42px",
                          color: "white"
                        },
                        on: {
                          click: function($event) {
                            return _vm.generatePin(num)
                          }
                        }
                      },
                      [_vm._v(_vm._s(num) + "\n                    ")]
                    )
                  }),
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "row",
                    staticStyle: { "margin-left": "20px" }
                  },
                  [
                    _c("el-button", {
                      staticClass: "m-2 col-md-4 ",
                      staticStyle: {
                        "border-radius": "50% !important",
                        width: "42px"
                      },
                      attrs: { type: "danger", icon: "el-icon-delete" },
                      on: {
                        click: function($event) {
                          _vm.pin = ""
                        }
                      }
                    }),
                    _vm._v(" "),
                    _vm._l([0], function(num) {
                      return _c(
                        "el-button",
                        {
                          key: num,
                          staticClass: "m-2 col-md-4 btn-primary",
                          staticStyle: {
                            "border-radius": "50% !important",
                            width: "42px",
                            color: "white"
                          },
                          on: {
                            click: function($event) {
                              return _vm.generatePin(num)
                            }
                          }
                        },
                        [_vm._v(_vm._s(num) + "\n                    ")]
                      )
                    }),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-md-4" })
                  ],
                  2
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "dialog-footer",
              staticStyle: { "text-align": "center !important" },
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      _vm.showPinRequest = false
                    }
                  }
                },
                [_vm._v("Cancelar")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: { type: "primary" },
                  on: { click: _vm.cancelOrdenaPin }
                },
                [_vm._v("Eliminar")]
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("consignment-form", {
        attrs: {
          showDialog: _vm.showConsignmentForm,
          items: _vm.localOrden,
          all_customers: _vm.customers,
          establishments: _vm.establishments
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showConsignmentForm = $event
          },
          "update:show-dialog": function($event) {
            _vm.showConsignmentForm = $event
          },
          limpiarForm: _vm.limpiarForm
        }
      }),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            visible: _vm.showChangeName,
            title: "Cambiar nombre de producto",
            "append-to-body": ""
          },
          on: {
            "update:visible": function($event) {
              _vm.showChangeName = $event
            },
            close: function($event) {
              _vm.showChangeName = false
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "row m-2" },
            [
              _c("el-input", {
                attrs: { placeholder: "Ingrese un nombre" },
                model: {
                  value: _vm.name_pdf,
                  callback: function($$v) {
                    _vm.name_pdf = $$v
                  },
                  expression: "name_pdf"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      _vm.showChangeName = false
                    }
                  }
                },
                [_vm._v("Cancelar")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: { type: "primary" },
                  on: { click: _vm.changeNamePdf }
                },
                [_vm._v("Guardar")]
              )
            ],
            1
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn p-0",
        attrs: {
          type: "button",
          "data-bs-toggle": "dropdown",
          "aria-haspopup": "true",
          "aria-expanded": "false"
        }
      },
      [
        _c(
          "span",
          {
            staticClass: "btn btn-primary dropdown-toggle",
            attrs: {
              "data-bs-toggle": "tooltip",
              "data-bs-placement": "top",
              "data-bs-delay": "0",
              title: "",
              "data-bs-original-title": "Item Count",
              "aria-label": "Item Count"
            }
          },
          [_vm._v("Menu De Acciones\n                    ")]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn p-0",
        staticStyle: { "max-height": "45px", "max-width": "150px" },
        attrs: {
          type: "button",
          "data-bs-toggle": "dropdown",
          "aria-haspopup": "true",
          "aria-expanded": "false"
        }
      },
      [
        _c(
          "span",
          {
            staticClass: "btn btn-light dropdown-toggle",
            attrs: {
              "data-bs-toggle": "tooltip",
              "data-bs-placement": "top",
              "data-bs-delay": "0",
              title: "",
              "data-bs-original-title": "Item Count",
              "aria-label": "Item Count"
            }
          },
          [
            _vm._v("\n                                Mas Opciones.."),
            _c("i", {
              staticClass: "fas fa-list",
              staticStyle: { color: "var(--primary) !important" }
            })
          ]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row col-md-12" }, [
      _c("div", { staticClass: "row col-md-12 mx-1" }, [
        _c("div", { staticClass: "col-md-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-3" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "os-resize-observer-host observed" }, [
      _c("div", {
        staticClass: "os-resize-observer",
        staticStyle: { left: "0px", right: "auto" }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "os-size-auto-observer observed",
        staticStyle: { height: "calc(100% + 1px)", float: "left" }
      },
      [_c("div", { staticClass: "os-resize-observer" })]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-text" }, [
      _c(
        "button",
        {
          staticClass: "spin-up",
          attrs: { type: "button", "data-spin": "up" }
        },
        [_c("span", { staticClass: "arrow" })]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "spin-down",
          attrs: { type: "button", "data-spin": "down" }
        },
        [_c("span", { staticClass: "arrow" })]
      )
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-28dd8919", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-28dd8919\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-28dd8919\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_ordens.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("9295215c", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-28dd8919\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./list_ordens.vue", function() {
     var newContent = require("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-28dd8919\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./list_ordens.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=155.js.map