<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
webpackJsonp([104],{

/***/ "./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/persons/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-bf046f30\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/persons/form.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/views/persons/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-bf046f30", Component.options)
  } else {
    hotAPI.reload("data-v-bf046f30", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
=======
webpackJsonp([104],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/form.vue":
>>>>>>> master
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
<<<<<<< HEAD
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

=======
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_lots_vue__ = __webpack_require__("./resources/js/views/items/partials/lots.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_lots_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__partials_lots_vue__);
>>>>>>> master
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

<<<<<<< HEAD
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

=======
>>>>>>> master


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
<<<<<<< HEAD
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "extern"],
  data: function data() {
    return {
      identityDocuments: [],
      tab: "parent",
      title: "Nuevo registro",
      loading: false,
      loading_search: false,
      children: [],
      form: {},
      resource: "college/persons",
      documentNumber: null,
      documentNumberChildren: null,
      documentTypeChildren: null,
      departments: [],
      provinces: [],
      form_attorney: {
        add: false
      },
      countries: [],
      districts: [],
      all_departments: [],
      all_provinces: [],
      all_countries: [],
      all_districts: [],
      errors: {},
      types: [],
      form_children: {
        name: ""
      },
      timer: null
=======
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// import PercentagePerception from './partials/percentage_perception.vue'

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "external"],
  components: {
    LotsForm: __WEBPACK_IMPORTED_MODULE_1__partials_lots_vue___default.a
  },
  data: function data() {
    return {
      allEstablishment: false,
      showDialogLots: false,
      form_category: {
        add: false,
        name: null,
        id: null
      },
      form_brand: {
        add: false,
        name: null,
        id: null
      },
      warehouses: [],
      loading_submit: false,
      showPercentagePerception: false,
      has_percentage_perception: false,
      percentage_perception: null,
      enabled_percentage_of_profit: false,
      titleDialog: null,
      resource: "items",
      errors: {},
      headers: headers_token,
      form: {},
      configuration: {},
      unit_types: [],
      areas: [],
      currency_types: [],
      system_isc_types: [],
      affectation_igv_types: [],
      categories: [],
      brands: [],
      accounts: [],
      show_has_igv: true,
      have_account: false,
      showSeries: false,
      item_unit_type: {
        id: null,
        unit_type_id: null,
        quantity_unit: 0,
        price1: 0,
        price2: 0,
        price3: 0,
        price_default: 2
      },
      attribute_types: [],
      area_id: 2
>>>>>>> master
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
<<<<<<< HEAD
              return _this.getTables();

            case 2:
              _context.next = 4;
              return _this.getAttorneyTypes();

            case 4:
              _this.initForm();

            case 5:
=======
              return _this.initForm();

            case 2:
              _context.next = 4;
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.unit_types = response.data.unit_types;
                _this.accounts = response.data.accounts;
                _this.currency_types = response.data.currency_types;
                _this.system_isc_types = response.data.system_isc_types;
                _this.affectation_igv_types = response.data.affectation_igv_types;
                _this.warehouses = response.data.warehouses;

                if (_this.warehouses.length > 0) {
                  _this.form.warehouse_id = _this.warehouses[0].id;
                  _this.form.warehouse_prices = _this.warehouses.map(function (w) {
                    return {
                      id: null,
                      item_id: null,
                      warehouse_id: w.id,
                      price: null,
                      warehouse: w.description
                    };
                  });
                }

                _this.categories = response.data.categories;
                _this.brands = response.data.brands;
                _this.attribute_types = response.data.attribute_types;
                _this.configuration = response.data.configuration;
                _this.areas = response.data.areas;
                _this.form.sale_affectation_igv_type_id = _this.affectation_igv_types.length > 0 ? _this.affectation_igv_types[0].id : null;
                _this.form.purchase_affectation_igv_type_id = _this.affectation_igv_types.length > 0 ? _this.affectation_igv_types[0].id : null; //agregar opciones para entorno restaurante
              });

            case 4:
              _this.$eventHub.$on("submitPercentagePerception", function (data) {
                _this.form.percentage_perception = data;
                if (!_this.form.percentage_perception) _this.has_percentage_perception = false;
              });

              _this.$eventHub.$on("reloadTables", function () {
                _this.reloadTables();
              });

              _context.next = 8;
              return _this.setDefaultConfiguration();

            case 8:
>>>>>>> master
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
<<<<<<< HEAD
    sendData: function sendData() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, _response$data, success, message;

=======
    selectedMax: function selectedMax(idx) {
      var selected = this.form.item_unit_types[idx].selected;

      for (var i = 0; i < this.form.item_unit_types.length; i++) {
        var it = this.form.item_unit_types[i];
        it.selected = false;
      }

      this.form.item_unit_types[idx].selected = selected;

      if (selected) {
        var qty = Number(this.form.item_unit_types[idx].quantity_unit);
        !isNaN(qty) && (this.form.max_quantity = qty);
      } else {
        this.form.max_quantity = null;
      }

      this.$forceUpdate();
    },
    undToTotal: function undToTotal(idx, amount, qty) {
      var arr = this.form.item_unit_types;

      if (qty > 0) {
        arr[idx].total = Number(amount) * Number(qty);
      } else {
        this.$toast.warning("Ingrese una cantidad válida");
        arr[idx].price2 = 0;
      }
    },
    totalToUnd: function totalToUnd(idx, amount, qty) {
      var arr = this.form.item_unit_types;

      if (qty > 0) {
        arr[idx].price2 = Number(amount) / Number(qty);
      } else {
        this.$toast.warning("Ingrese una cantidad válida");
        arr[idx].total = 0;
      }
    },
    setDefaultConfiguration: function setDefaultConfiguration() {
      var _this2 = this;

      this.form.sale_affectation_igv_type_id = this.configuration ? this.configuration.affectation_igv_type_id : "10";
      this.$http.get("/configurations/record").then(function (response) {
        _this2.form.has_igv = response.data.data.include_igv;
      });
      this.changeAffectationIgvType();
    },
    clickAddAttribute: function clickAddAttribute() {
      this.form.attributes.push({
        attribute_type_id: null,
        description: null,
        value: null,
        start_date: null,
        end_date: null,
        duration: null
      });
    },
    reloadTables: function reloadTables() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
>>>>>>> master
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
<<<<<<< HEAD
                if (!_this2.validForm()) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                console.log(_this2.form);
                _this2.form.children = _this2.children;
                _this2.form.number = _this2.documentNumber;
                _context2.prev = 5;
                _this2.loading = true;
                _context2.next = 9;
                return _this2.$http.post("/".concat(_this2.resource), _this2.form);

              case 9:
                response = _context2.sent;

                if (response.status == 200) {
                  _response$data = response.data, success = _response$data.success, message = _response$data.message;

                  if (success) {
                    _this2.$toast.success(message);

                    if (_this2.extern) {
                      _this2.$emit("memberCreated", _this2.form.number);
                    }

                    _this2.close();
                  } else {
                    _this2.$toast.error(message);
                  }
                }

                _context2.next = 17;
                break;

              case 13:
                _context2.prev = 13;
                _context2.t0 = _context2["catch"](5);

                _this2.$toast.error("Ocurrió un error");

                console.log(_context2.t0);

              case 17:
                _context2.prev = 17;
                _this2.loading = false;
                return _context2.finish(17);

              case 20:
=======
                _context2.next = 2;
                return _this3.$http.get("/".concat(_this3.resource, "/tables")).then(function (response) {
                  _this3.unit_types = response.data.unit_types;
                  _this3.accounts = response.data.accounts;
                  _this3.currency_types = response.data.currency_types;
                  _this3.system_isc_types = response.data.system_isc_types;
                  _this3.affectation_igv_types = response.data.affectation_igv_types;
                  _this3.warehouses = response.data.warehouses;
                  _this3.categories = response.data.categories;
                  _this3.brands = response.data.brands;
                  _this3.form.sale_affectation_igv_type_id = _this3.affectation_igv_types.length > 0 ? _this3.affectation_igv_types[0].id : null;
                  _this3.form.purchase_affectation_igv_type_id = _this3.affectation_igv_types.length > 0 ? _this3.affectation_igv_types[0].id : null;
                });

              case 2:
>>>>>>> master
              case "end":
                return _context2.stop();
            }
          }
<<<<<<< HEAD
        }, _callee2, null, [[5, 13, 17, 20]]);
      }))();
    },
    getDocumentType: function getDocumentType(id) {
      return this.identityDocuments.find(function (i) {
        return i.id == id;
      }).description;
    },
    initForm: function initForm() {
      this.form = {
        country_id: "PE",
        identity_document_type_id: "1",
        type: "mother"
      };
      this.children = [];
      this.documentTypeChildren = "1";
      this.documentNumber = null;
      this.documentNumber = null;
    },
    validForm: function validForm() {
      var error = false;
      var _this$form = this.form,
          name = _this$form.name,
          department_id = _this$form.department_id,
          province_id = _this$form.province_id,
          district_id = _this$form.district_id,
          address = _this$form.address,
          phone = _this$form.phone,
          attorney_id = _this$form.attorney_id,
          type = _this$form.type;

      if (!name) {
        error = true;
        this.$toast.error("El nombre es obligatorio");
      }

      if (!this.documentNumber) {
        error = true;
        this.$toast.error("El documento es obligatorio");
      }

      if (!department_id) {
        error = true;
        this.$toast.error("El departamento es obligatorio");
      }

      if (!province_id) {
        error = true;
        this.$toast.error("La provincia es obligatorio");
      }

      if (!district_id) {
        error = true;
        this.$toast.error("El distrito es obligatorio");
      }

      if (!address) {
        error = true;
        this.$toast.error("La dirección es obligatorio");
      }

      if (!phone) {
        error = true;
        this.$toast.error("El teléfono es obligatorio");
      }

      if (type == "attorney") {
        if (!attorney_id) {
          error = true;
          this.$toast.error("Elija un parentezco");
        }
      }

      if (this.children.length == 0) {
        error = true;
        this.$toast.error("Debe registrar al menos un estudiante");
      }

      return error;
    },
    addChildren: function addChildren() {
      var _this3 = this;

      if (!this.documentNumberChildren) {
        return this.$toast.error("Documento obligatorio");
      }

      if (!this.form_children.name) {
        return this.$toast.error("Nombre obligatorio");
      }

      this.children = [].concat(_toConsumableArray(this.children.filter(function (c) {
        return c.number != _this3.documentNumberChildren;
      })), [_objectSpread(_objectSpread({}, this.form_children), {}, {
        identity_document_type_id: this.documentTypeChildren,
        number: this.documentNumberChildren
      })]);
      this.form_children.name = "";
      this.documentNumberChildren = null;
    },
    deleteChild: function deleteChild(number) {
      this.children = _toConsumableArray(this.children.filter(function (c) {
        return c.number != number;
      }));
    },
    searchType: function searchType() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
=======
        }, _callee2);
      }))();
    },
    changeLotsEnabled: function changeLotsEnabled() {// if(!this.form.lots_enabled){
      //     this.form.lot_code = null
      //     this.form.lots = []
      // }
    },
    addRowLot: function addRowLot(lots) {
      this.form.lots = lots;
    },
    clickLotcode: function clickLotcode() {
      // if(this.form.stock <= 0)
      //     return this.$toast.error('El stock debe ser mayor a 0')
      this.showDialogLots = true;
    },
    changeHaveAccount: function changeHaveAccount() {
      if (!this.have_account) this.form.account_id = null;
    },
    changeEnabledPercentageOfProfit: function changeEnabledPercentageOfProfit() {// if(!this.enabled_percentage_of_profit) this.form.percentage_of_profit = 0
    },
    clickDelete: function clickDelete(id) {
      var _this4 = this;

      this.$http["delete"]("/".concat(this.resource, "/item-unit-type/").concat(id)).then(function (res) {
        if (res.data.success) {
          _this4.loadRecord();

          _this4.$toast.success("Se eliminó correctamente el registro");
        }
      })["catch"](function (error) {
        if (error.response.status === 500) {
          _this4.$toast.error("Error al intentar eliminar");
        } else {
          console.log(error.response.data.message);
        }
      });
    },
    changeHasPerception: function changeHasPerception() {
      if (!this.form.has_perception) {
        this.form.percentage_perception = null;
      }
    },
    clickAddRow: function clickAddRow() {
      this.form.item_unit_types.push({
        id: null,
        description: null,
        unit_type_id: "NIU",
        quantity_unit: 0,
        price1: 0,
        price2: 0,
        price3: 0,
        price_default: 2,
        warehouse_id: null
      });
    },
    clickCancel: function clickCancel(index) {
      this.form.item_unit_types.splice(index, 1); // this.initDocumentTypes()
      // this.showAddButton = true
    },
    initForm: function initForm() {
      this.loading_submit = false, this.errors = {};
      this.form = {
        id: null,
        item_type_id: "01",
        location: null,
        internal_id: null,
        item_code: null,
        item_code_gs1: null,
        description: null,
        name: null,
        second_name: null,
        unit_type_id: "NIU",
        currency_type_id: "PEN",
        sale_unit_price: 0,
        purchase_unit_price: 0,
        has_isc: false,
        system_isc_type_id: null,
        percentage_isc: 0,
        suggested_price: 0,
        sale_affectation_igv_type_id: null,
        purchase_affectation_igv_type_id: null,
        calculate_quantity: false,
        stock: 0,
        stock_min: 1,
        has_igv: true,
        has_perception: false,
        item_unit_types: [],
        percentage_of_profit: 0,
        percentage_perception: 0,
        image: null,
        image_url: null,
        temp_path: null,
        is_set: false,
        account_id: null,
        category_id: null,
        brand_id: null,
        date_of_due: null,
        lot_code: null,
        lots_enabled: false,
        lots: [],
        attributes: [],
        series_enabled: false,
        area_id: 2
      };
      this.show_has_igv = true;
      this.enabled_percentage_of_profit = false;
    },
    onSuccess: function onSuccess(response, file, fileList) {
      if (response.success) {
        this.form.image = response.data.filename;
        this.form.image_url = response.data.temp_image;
        this.form.temp_path = response.data.temp_path;
      } else {
        this.$toast.error(response.message);
      }
    },
    changeAffectationIgvType: function changeAffectationIgvType() {
      var affectation_igv_type_exonerated = [20, 21, 30, 31, 32, 33, 34, 35, 36, 37];
      var is_exonerated = affectation_igv_type_exonerated.includes(parseInt(this.form.sale_affectation_igv_type_id));

      if (is_exonerated) {
        this.show_has_igv = false;
        this.form.has_igv = true;
      } else {
        this.show_has_igv = true;
      }
    },
    resetForm: function resetForm() {
      this.initForm();
      this.form.sale_affectation_igv_type_id = this.affectation_igv_types.length > 0 ? this.affectation_igv_types[0].id : null;
      this.form.purchase_affectation_igv_type_id = this.affectation_igv_types.length > 0 ? this.affectation_igv_types[0].id : null;
      this.setDefaultConfiguration();
    },
    create: function create() {
      var _this5 = this;

      this.titleDialog = this.recordId ? "Editar Productos" : "Nuevo Producto";

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this5.form = response.data.data;

          if (_this5.form.warehouse_prices.length == 0) {
            if (_this5.warehouses.length > 0) {
              _this5.form.warehouse_id = _this5.warehouses[0].id;
              _this5.form.warehouse_prices = _this5.warehouses.map(function (w) {
                return {
                  id: null,
                  item_id: null,
                  warehouse_id: w.id,
                  price: null,
                  warehouse: w.description
                };
              });
            }
          } else {
            _this5.form.warehouse_prices = _this5.warehouses.map(function (w) {
              var exist = _this5.form.warehouse_prices.find(function (ww) {
                return ww.warehouse_id == w.id;
              });

              if (exist) {
                return exist;
              }

              return {
                id: null,
                item_id: null,
                warehouse_id: w.id,
                price: null,
                warehouse: w.description
              };
            });
          }

          if (_this5.form.item_unit_types.length != 0) {
            _this5.restoreUnitTypes();
          }

          _this5.has_percentage_perception = _this5.form.percentage_perception ? true : false;

          _this5.changeAffectationIgvType();

          _this5.showSeries = true;

          if (_this5.form.series_enabled == 1) {
            _this5.form.series_enabled = true;
          } else _this5.form.series_enabled = false;
        });
      } else {
        this.showSeries = true; //this.form.area_id = 2 ;
      } // if(!this.record){
      //     this.form.has_igv= true
      // }

    },
    restoreUnitTypes: function restoreUnitTypes() {
      var _this6 = this;

      var hasSelected = false;
      this.form.item_unit_types = this.form.item_unit_types.map(function (i) {
        var selected = false;

        if (!hasSelected && Number(_this6.form.max_quantity) == Number(i.quantity_unit)) {
          selected = true;
          hasSelected = true;
        }

        return _objectSpread(_objectSpread({}, i), {}, {
          selected: selected,
          total: (Number(i.price2) * Number(i.quantity_unit)).toFixed(2)
        });
      });
    },
    loadRecord: function loadRecord() {
      var _this7 = this;

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this7.form = response.data.data;

          _this7.changeAffectationIgvType();
        });
      }
    },
    changeWarehouse: function changeWarehouse() {
      var _this8 = this;

      this.$toast.warning("Cambió el destino del producto, verifique los PRECIOS DE ALMACÉN");
      var w = this.form.warehouse_prices.find(function (ww) {
        return ww.warehouse_id == _this8.form.warehouse_id;
      });

      if (w) {
        w.price = this.form.sale_unit_price;
      }

      this.$forceUpdate();
    },
    calculatePercentageOfProfitBySale: function calculatePercentageOfProfitBySale() {
      var _this9 = this;

      var w = this.form.warehouse_prices.find(function (ww) {
        return ww.warehouse_id == _this9.form.warehouse_id;
      });

      if (w) {
        w.price = this.form.sale_unit_price;
      }

      var difference = parseFloat(this.form.sale_unit_price) - parseFloat(this.form.purchase_unit_price);

      if (parseFloat(this.form.purchase_unit_price) === 0) {
        this.form.percentage_of_profit = 0;
      } else {
        if (this.enabled_percentage_of_profit) this.form.percentage_of_profit = difference / parseFloat(this.form.purchase_unit_price) * 100;
      }
    },
    calculatePercentageOfProfitByPurchase: function calculatePercentageOfProfitByPurchase() {
      if (this.form.percentage_of_profit === "") {
        this.form.percentage_of_profit = 0;
      }

      if (this.enabled_percentage_of_profit) this.form.sale_unit_price = this.form.purchase_unit_price * (100 + parseFloat(this.form.percentage_of_profit)) / 100;
    },
    calculatePercentageOfProfitByPercentage: function calculatePercentageOfProfitByPercentage() {
      if (this.form.percentage_of_profit === "") {
        this.form.percentage_of_profit = 0;
      }

      if (this.enabled_percentage_of_profit) this.form.sale_unit_price = this.form.purchase_unit_price * (100 + parseFloat(this.form.percentage_of_profit)) / 100;
    },
    submit: function submit() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!(_this10.form.internal_id == null || _this10.form.internal_id == "")) {
                  _context3.next = 3;
                  break;
                }

                _this10.$refs.internal_id.$el.querySelector("input").focus();

                return _context3.abrupt("return", _this10.$toast.warning("No puede guardar Un nuevo Producto sin codigo interno "));

              case 3:
                if (!(_this10.form.has_perception && !_this10.form.percentage_perception)) {
                  _context3.next = 5;
                  break;
                }

                return _context3.abrupt("return", _this10.$toast.error("Ingrese un porcentaje"));

              case 5:
                if (_this10.form.warehouse_id) {
                  _context3.next = 7;
                  break;
                }

                return _context3.abrupt("return", _this10.$toast.error("Seleccione un almacen"));

              case 7:
                if (!_this10.recordId && _this10.form.lots_enabled) {// if (!this.form.lot_code)
                  //     return this.$toast.error("Código de lote es requerido");
                  // if (!this.form.date_of_due)
                  //     return this.$toast.error(
                  //         "Fecha de vencimiento es requerido si lotes esta habilitado."
                  //     );
                }

                if (!(!_this10.recordId && _this10.form.series_enabled)) {
                  _context3.next = 13;
                  break;
                }

                if (!(_this10.form.lots.length > _this10.form.stock)) {
                  _context3.next = 11;
                  break;
                }

                return _context3.abrupt("return", _this10.$toast.error("La cantidad de series registradas es superior al stock"));

              case 11:
                if (!(_this10.form.lots.length != _this10.form.stock)) {
                  _context3.next = 13;
                  break;
                }

                return _context3.abrupt("return", _this10.$toast.error("La cantidad de series registradas son diferentes al stock"));

              case 13:
                _this10.loading_submit = true;
                _this10.form.all_establishment = _this10.allEstablishment;
                _context3.next = 17;
                return _this10.$http.post("/".concat(_this10.resource), _this10.form).then(function (response) {
                  if (response.data.success) {
                    _this10.$toast.success(response.data.message);

                    if (_this10.external) {
                      _this10.$emit("add", response.data.data); //this.$eventHub.$emit('reloadDataItems', response.data.id)

                    } else {
                      _this10.$eventHub.$emit("reloadData");
                    }

                    _this10.close();
                  } else {
                    _this10.$toast.error(response.data.message);
                  }
                })["catch"](function (error) {
                  if (error.response.status === 422) {
                    _this10.errors = error.response.data.errors;
                  } else {
                    console.log(error);
                  }
                }).then(function () {
                  _this10.loading_submit = false;
                });

              case 17:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.showSeries = false;
      this.resetForm();
      this.form.warehouse_prices = this.warehouses.map(function (w) {
        return {
          id: null,
          item_id: null,
          warehouse_id: w.id,
          price: null,
          warehouse: w.description
        };
      });
    },
    changeHasIsc: function changeHasIsc() {
      this.form.system_isc_type_id = null;
      this.form.percentage_isc = 0;
      this.form.suggested_price = 0;
    },
    changeSystemIscType: function changeSystemIscType() {
      if (this.form.system_isc_type_id !== "03") {
        this.form.suggested_price = 0;
      }
    },
    saveCategory: function saveCategory() {
      var _this11 = this;

      this.form_category.add = false;
      this.$http.post("/items/categories", this.form_category).then(function (response) {
        if (response.data.success) {
          _this11.$toast.success(response.data.message);

          _this11.categories.push(response.data.data);

          _this11.form.category_id = response.data.data.id;
          _this11.form_category.name = null;
        } else {
          _this11.$toast.error("No se guardaron los cambios");
        }
      })["catch"](function (error) {});
    },
    saveBrand: function saveBrand() {
      var _this12 = this;

      this.form_brand.add = false;
      this.$http.post("/brands", this.form_brand).then(function (response) {
        if (response.data.success) {
          _this12.$toast.success(response.data.message);

          _this12.brands.push(response.data.data);

          _this12.form_brand.name = null;
        } else {
          _this12.$toast.error("No se guardaron los cambios");
        }
      })["catch"](function (error) {});
    },
    changeAttributeType: function changeAttributeType(index) {
      var attribute_type_id = this.form.attributes[index].attribute_type_id;

      var attribute_type = _.find(this.attribute_types, {
        id: attribute_type_id
      });

      this.form.attributes[index].description = attribute_type.description;
    },
    clickRemoveAttribute: function clickRemoveAttribute(index) {
      this.form.attributes.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/partials/lots.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['showDialog', 'lots', 'stock', 'recordId'],
  data: function data() {
    return {
      titleDialog: 'Series',
      loading: false,
      errors: {},
      form: {},
      states: ['Activo', 'Inactivo', 'Desactivado', 'Voz', 'M2m']
    };
  },
  created: function created() {// await this.$http.get(`/pos/payment_tables`)
    //     .then(response => {
    //         this.payment_method_types = response.data.payment_method_types
    //         this.cards_brand = response.data.cards_brand
    //         this.clickAddLot()
    //     })

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: _defineProperty({
    duplicateSerie: function duplicateSerie(data, index) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var duplicates;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _.filter(_this.lots, {
                  'series': data
                });

              case 2:
                duplicates = _context2.sent;

                if (duplicates.length > 1) {
                  _this.lots[index].series = '';
                }

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    create: function create() {
      if (!this.recordId) {
        if (this.lots.length == 0) {
          this.addMoreLots(this.stock);
        } else {
          var quantity = this.stock - this.lots.length;

          if (quantity > 0) {
            this.addMoreLots(quantity);
          } // else{
          //     this.deleteMoreLots(quantity)
          // }

        }
      }
    },
    addMoreLots: function addMoreLots(number) {
      for (var i = 0; i < number; i++) {
        this.clickAddLot();
      }
    },
    deleteMoreLots: function deleteMoreLots(number) {
      for (var i = 0; i < number; i++) {
        this.lots.pop();
        this.$emit('addRowLot', this.lots);
      }
    },
    validateLots: function validateLots() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var error;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                error = 0;
                _context3.next = 3;
                return _this2.lots.forEach(function (element) {
                  if (element.series == null) {
                    error++;
                  }
                });

              case 3:
                if (!(error > 0)) {
                  _context3.next = 5;
                  break;
                }

                return _context3.abrupt("return", {
                  success: false,
                  message: 'El campo serie es obligatorio'
                });

              case 5:
                return _context3.abrupt("return", {
                  success: true
                });

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    submit: function submit() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var val_lots;
>>>>>>> master
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
<<<<<<< HEAD
                if (_this4.timer) {
                  clearTimeout(_this4.timer);
                }

                _this4.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
                    while (1) {
                      switch (_context3.prev = _context3.next) {
                        case 0:
                          _context3.next = 2;
                          return _this4.getAttorneyTypes();

                        case 2:
                        case "end":
                          return _context3.stop();
                      }
                    }
                  }, _callee3);
                })), 250);

              case 2:
=======
                _context4.next = 2;
                return _this3.validateLots();

              case 2:
                val_lots = _context4.sent;

                if (val_lots.success) {
                  _context4.next = 5;
                  break;
                }

                return _context4.abrupt("return", _this3.$toast.error(val_lots.message));

              case 5:
                _context4.next = 7;
                return _this3.$emit('addRowLot', _this3.lots);

              case 7:
                _context4.next = 9;
                return _this3.$emit('update:showDialog', false);

              case 9:
>>>>>>> master
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
<<<<<<< HEAD
    //       this.countries = response.data.countries;
    // this.all_departments = response.data.departments;
    // this.all_provinces = response.data.provinces;
    // this.all_districts = response.data.districts;
    getAttorneyTypes: function getAttorneyTypes() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, records;
=======
    clickAddLot: function clickAddLot() {
      if (!this.recordId) {
        if (this.lots.length >= this.stock) return this.$toast.error('La cantidad de registros es superior al stock o cantidad');
      }

      this.lots.push({
        id: null,
        item_id: null,
        series: null,
        date: moment().format('YYYY-MM-DD'),
        state: 'Activo'
      });
      this.$emit('addRowLot', this.lots);
    },
    close: function close() {
      this.$emit('update:showDialog', false);
      this.$emit('addRowLot', this.lots);
    },
    clickCancel: function clickCancel(index) {
      this.lots.splice(index, 1); // item.deleted = true

      this.$emit('addRowLot', this.lots);
    },
    clickCancelSubmit: function clickCancelSubmit() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
>>>>>>> master
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
<<<<<<< HEAD
                _context5.prev = 0;
                _this5.loading = true;
                _context5.next = 4;
                return _this5.$http.get("/".concat(_this5.resource, "/attorney/records?description=").concat(_this5.form_attorney.name ? _this5.form_attorney.name : ""));

              case 4:
                response = _context5.sent;

                if (response.status == 200) {
                  records = response.data.records;
                  _this5.types = records;
                }

                _context5.next = 11;
                break;

              case 8:
                _context5.prev = 8;
                _context5.t0 = _context5["catch"](0);
                console.log(_context5.t0);

              case 11:
                _context5.prev = 11;
                _this5.loading = false;
                return _context5.finish(11);

              case 14:
=======
                _this4.$emit('addRowLot', []);

                _context5.next = 3;
                return _this4.$emit('update:showDialog', false);

              case 3:
>>>>>>> master
              case "end":
                return _context5.stop();
            }
          }
<<<<<<< HEAD
        }, _callee5, null, [[0, 8, 11, 14]]);
      }))();
    },
    saveType: function saveType() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var response, _response$data2, id, message, success;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.prev = 0;
                _this6.loading = true;
                _context6.next = 4;
                return _this6.$http.post("/".concat(_this6.resource, "/attorney"), {
                  description: _this6.form_attorney.name
                });

              case 4:
                response = _context6.sent;

                if (response.status == 200) {
                  _response$data2 = response.data, id = _response$data2.id, message = _response$data2.message, success = _response$data2.success;

                  if (success) {
                    _this6.form.attorney_id = id;

                    _this6.$toast.success(message);

                    _this6.getAttorneyTypes();

                    _this6.form_attorney.add = false;
                    _this6.form_attorney.name = null;
                  } else {
                    _this6.$toast.error(message);
                  }
                }

                console.log(response);
                _context6.next = 12;
                break;

              case 9:
                _context6.prev = 9;
                _context6.t0 = _context6["catch"](0);
                console.log(_context6.t0);

              case 12:
                _context6.prev = 12;
                _this6.loading = false;
                return _context6.finish(12);

              case 15:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, null, [[0, 9, 12, 15]]);
      }))();
    },
    getTables: function getTables() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee7() {
        var response, _response$data3, departments, provinces, countries, districts, identity_documents;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _context7.prev = 0;
                _this7.loading = true;
                _context7.next = 4;
                return _this7.$http("/".concat(_this7.resource, "/tables"));

              case 4:
                response = _context7.sent;
                console.log(response);

                if (response.status == 200) {
                  _response$data3 = response.data, departments = _response$data3.departments, provinces = _response$data3.provinces, countries = _response$data3.countries, districts = _response$data3.districts, identity_documents = _response$data3.identity_documents;
                  _this7.all_departments = departments;
                  _this7.all_provinces = provinces;
                  _this7.all_countries = countries;
                  _this7.all_districts = districts;
                  _this7.identityDocuments = identity_documents;
                  _this7.departments = departments;
                  _this7.provinces = provinces;
                  _this7.countries = countries;
                  _this7.districts = districts;
                }

                _this7.form.identity_document_type_id = "1"; // this.form_children.identity_document_type_id = "1";

                _this7.documentTypeChildren = "1";
                _context7.next = 14;
                break;

              case 11:
                _context7.prev = 11;
                _context7.t0 = _context7["catch"](0);
                console.log(_context7.t0);

              case 14:
                _context7.prev = 14;
                _this7.loading = false;
                return _context7.finish(14);

              case 17:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7, null, [[0, 11, 14, 17]]);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    open: function open() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee8() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _this8.initForm();

                _this8.recordId && (_this8.title = "Editar registro");

                if (!_this8.recordId) {
                  _context8.next = 11;
                  break;
                }

                _context8.next = 5;
                return _this8.$http("/".concat(_this8.resource, "/update/").concat(_this8.recordId));

              case 5:
                response = _context8.sent;
                data = response.data.data;
                _this8.form = data;
                _this8.documentNumber = _this8.form.number;
                _this8.children = _this8.form.children;
                console.log(response, " ..");

              case 11:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    searchCustomer: function searchCustomer() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee10() {
        var documentNumber;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                documentNumber = _this9.tab == "parent" ? _this9.documentNumber : _this9.documentNumberChildren;

                if (!(documentNumber == null || documentNumber == "")) {
                  _context10.next = 3;
                  break;
                }

                return _context10.abrupt("return");

              case 3:
                if (!(documentNumber.length != 8 && documentNumber.length != 11)) {
                  _context10.next = 6;
                  break;
                }

                _this9.$toast.error("Ingrese un documento válido");

                return _context10.abrupt("return");

              case 6:
                if (_this9.timer) {
                  clearTimeout(_this9.timer);
                }

                _this9.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee9() {
                  var response, data, _data$ubigeo, department, province, district;

                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee9$(_context9) {
                    while (1) {
                      switch (_context9.prev = _context9.next) {
                        case 0:
                          _context9.prev = 0;
                          _this9.currentCustomer = null;
                          _this9.loading_search = true;
                          _context9.next = 5;
                          return _this9.$http("/".concat(_this9.resource, "/").concat(documentNumber));

                        case 5:
                          response = _context9.sent;

                          if (response.status == 200) {
                            data = response.data;
                            console.log(data);

                            if (data.direccion_completa) {
                              if (_this9.tab == "parent") {
                                if (documentNumber.length == 8) {
                                  _this9.form.name = data.nombre_completo;
                                } else {
                                  _this9.form.name = data.nombre_o_razon_social;
                                  _this9.form.state = data.estado;
                                  _this9.form.condition = data.condicion;
                                }

                                _this9.form.address = data.direccion_completa;

                                if (data.ubigeo.length == 3) {
                                  _data$ubigeo = _slicedToArray(data.ubigeo, 3), department = _data$ubigeo[0], province = _data$ubigeo[1], district = _data$ubigeo[2];
                                  _this9.form.department_id = department;
                                  _this9.form.province_id = province;
                                  _this9.form.district_id = district;
                                }
                              } else {
                                _this9.form_children.name = data.nombre_completo;
                              }
                            } else {
                              _this9.$toast.error("No se encontró el documento");
                            }
                          } else {
                            _this9.$toast.error("No se pudo obtener los datos");
                          }

                          _context9.next = 12;
                          break;

                        case 9:
                          _context9.prev = 9;
                          _context9.t0 = _context9["catch"](0);

                          _this9.$toast.error("No se pudo obtener los datos");

                        case 12:
                          _context9.prev = 12;
                          _this9.loading_search = false;
                          return _context9.finish(12);

                        case 15:
                        case "end":
                          return _context9.stop();
                      }
                    }
                  }, _callee9, null, [[0, 9, 12, 15]]);
                })), 250);

              case 8:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    filterProvince: function filterProvince() {
      this.form.province_id = null;
      this.form.district_id = null;
      this.filterProvinces();
    },
    filterProvinces: function filterProvinces() {
      var _this10 = this;

      this.provinces = this.all_provinces.filter(function (f) {
        return f.department_id === _this10.form.department_id;
      });
    },
    filterDistrict: function filterDistrict() {
      this.form.district_id = null;
      this.filterDistricts();
    },
    filterDistricts: function filterDistricts() {
      var _this11 = this;

      this.districts = this.all_districts.filter(function (f) {
        return f.province_id === _this11.form.province_id;
      });
    },
    closeProperty: function closeProperty() {
      this.form.state = null;
      this.form.condition = null;
    }
  }
=======
        }, _callee5);
      }))();
    }
  }, "close", function close() {
    this.$emit('update:showDialog', false);
  })
>>>>>>> master
});

/***/ }),

<<<<<<< HEAD
/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.to_left .el-input .el-input__inner {\r\n    text-align: left !important;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/restobar/modules/College/Resources/assets/js/views/persons/modules/College/Resources/assets/js/views/persons/form.vue"],"names":[],"mappings":";AA+cA;IACA,4BAAA;CACA","file":"form.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :visible=\"showDialog\"\r\n        append-to-body\r\n        @close=\"close\"\r\n        @open=\"open\"\r\n        :title=\"title\"\r\n    >\r\n        <div class=\"form-body\" v-loading=\"loading\">\r\n            <el-tabs tab-position=\"top\" v-model=\"tab\">\r\n                <el-tab-pane name=\"parent\" label=\"Datos del Cliente\">\r\n                    <div class=\"card\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Tipo de documento</label\r\n                                >\r\n                                <el-select\r\n                                    @change=\"closeProperty\"\r\n                                    style=\"width:100%;\"\r\n                                    v-model=\"form.identity_document_type_id\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in identityDocuments\"\r\n                                        :key=\"option.id\"\r\n                                        :value=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </div>\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Documento</label\r\n                                >\r\n                                <el-input\r\n                                    class=\"to_left\"\r\n                                    style=\"width:100%;\"\r\n                                    v-model=\"documentNumber\"\r\n                                    @input=\"closeProperty\"\r\n                                    :controls=\"false\"\r\n                                >\r\n                                    <el-button\r\n                                        v-if=\"\r\n                                            form.identity_document_type_id ==\r\n                                                1 ||\r\n                                                form.identity_document_type_id ==\r\n                                                    6\r\n                                        \"\r\n                                        slot=\"append\"\r\n                                        :loading=\"loading_search\"\r\n                                        icon=\"el-icon-search\"\r\n                                        @click.prevent=\"searchCustomer\"\r\n                                    ></el-button>\r\n                                </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Nombres</label\r\n                                >\r\n                                <el-input v-model=\"form.name\"> </el-input>\r\n                            </div>\r\n                        </div>\r\n                        <div\r\n                            class=\"row mt-2\"\r\n                            v-if=\"form.state && form.condition\"\r\n                        >\r\n                            <div class=\"col-md-6 col-12\"></div>\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <el-alert\r\n                                    :title=\"form.state\"\r\n                                    :type=\"\r\n                                        `${\r\n                                            form.state == 'ACTIVO'\r\n                                                ? 'success'\r\n                                                : 'error'\r\n                                        }`\r\n                                    \"\r\n                                >\r\n                                </el-alert>\r\n                            </div>\r\n                            <div class=\"col-md-3\">\r\n                                <el-alert\r\n                                    :title=\"form.condition\"\r\n                                    :type=\"\r\n                                        `${\r\n                                            form.condition == 'HABIDO'\r\n                                                ? 'success'\r\n                                                : 'error'\r\n                                        }`\r\n                                    \"\r\n                                >\r\n                                </el-alert>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2\">\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{ 'has-danger': errors.country_id }\"\r\n                                >\r\n                                    <label class=\"control-label\">País</label>\r\n                                    <el-select\r\n                                        v-model=\"form.country_id\"\r\n                                        filterable\r\n                                        dusk=\"country_id\"\r\n                                        disabled\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in countries\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.country_id\"\r\n                                        v-text=\"errors.country_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{\r\n                                        'has-danger': errors.department_id\r\n                                    }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Departamento</label\r\n                                    >\r\n                                    <el-select\r\n                                        v-model=\"form.department_id\"\r\n                                        filterable\r\n                                        @change=\"filterProvince\"\r\n                                        popper-class=\"el-select-departments\"\r\n                                        dusk=\"department_id\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in departments\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.department_id\"\r\n                                        v-text=\"errors.department_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{\r\n                                        'has-danger': errors.province_id\r\n                                    }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Provincia</label\r\n                                    >\r\n                                    <el-select\r\n                                        v-model=\"form.province_id\"\r\n                                        filterable\r\n                                        @change=\"filterDistrict\"\r\n                                        popper-class=\"el-select-provinces\"\r\n                                        dusk=\"province_id\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in provinces\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.province_id\"\r\n                                        v-text=\"errors.province_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-4\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{\r\n                                        'has-danger': errors.district_id\r\n                                    }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Distrito</label\r\n                                    >\r\n                                    <el-select\r\n                                        v-model=\"form.district_id\"\r\n                                        filterable\r\n                                        popper-class=\"el-select-districts\"\r\n                                        dusk=\"district_id\"\r\n                                    >\r\n                                        <el-option\r\n                                            v-for=\"option in districts\"\r\n                                            :key=\"option.id\"\r\n                                            :value=\"option.id\"\r\n                                            :label=\"option.description\"\r\n                                        ></el-option>\r\n                                    </el-select>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.district_id\"\r\n                                        v-text=\"errors.district_id[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-8\">\r\n                                <div\r\n                                    class=\"form-group\"\r\n                                    :class=\"{ 'has-danger': errors.address }\"\r\n                                >\r\n                                    <label class=\"control-label\"\r\n                                        >Dirección</label\r\n                                    >\r\n                                    <el-input\r\n                                        v-model=\"form.address\"\r\n                                        dusk=\"address\"\r\n                                    >\r\n                                        <i\r\n                                            slot=\"prefix\"\r\n                                            class=\"el-icon-edit-outline\"\r\n                                        ></i\r\n                                    ></el-input>\r\n                                    <small\r\n                                        class=\"text-danger\"\r\n                                        v-if=\"errors.address\"\r\n                                        v-text=\"errors.address[0]\"\r\n                                    ></small>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Teléfono</label\r\n                                >\r\n                                <el-input v-model=\"form.phone\"> </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Correo</label\r\n                                >\r\n                                <el-input v-model=\"form.email\"> </el-input>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2\">\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Teléfono secundario</label\r\n                                >\r\n                                <el-input v-model=\"form.extra_phone\">\r\n                                </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Relacion</label\r\n                                >\r\n                                <el-select v-model=\"form.type\">\r\n                                    <el-option\r\n                                        value=\"mother\"\r\n                                        label=\"Madre\"\r\n                                    ></el-option>\r\n                                    <el-option\r\n                                        value=\"father\"\r\n                                        label=\"Padre\"\r\n                                    ></el-option>\r\n                                    <el-option\r\n                                        value=\"attorney\"\r\n                                        label=\"Apoderado\"\r\n                                    ></el-option>\r\n                                </el-select>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2\">\r\n                            <div\r\n                                v-if=\"form.type == 'attorney'\"\r\n                                class=\"col-md-6 col-12\"\r\n                            >\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Tipo de apoderado</label\r\n                                >\r\n\r\n                                <a\r\n                                    href=\"#\"\r\n                                    v-if=\"form_attorney.add == false\"\r\n                                    class=\"control-label font-weight-bold text-info\"\r\n                                    @click=\"form_attorney.add = true\"\r\n                                >\r\n                                    [ + Nuevo]</a\r\n                                >\r\n                                <a\r\n                                    href=\"#\"\r\n                                    v-if=\"form_attorney.add == true\"\r\n                                    class=\"control-label font-weight-bold text-info\"\r\n                                    @click=\"saveType()\"\r\n                                >\r\n                                    [ + Guardar]</a\r\n                                >\r\n                                <a\r\n                                    href=\"#\"\r\n                                    v-if=\"form_attorney.add == true\"\r\n                                    class=\"control-label font-weight-bold text-danger\"\r\n                                    @click=\"form_attorney.add = false\"\r\n                                >\r\n                                    [ Cancelar]</a\r\n                                >\r\n                                <el-input\r\n                                    v-if=\"form_attorney.add == true\"\r\n                                    v-model=\"form_attorney.name\"\r\n                                    dusk=\"item_code\"\r\n                                    @input=\"searchType\"\r\n                                    style=\"margin-bottom:1.5%;\"\r\n                                >\r\n                                    <i\r\n                                        slot=\"prefix\"\r\n                                        class=\"el-icon-edit-outline\"\r\n                                    ></i\r\n                                ></el-input>\r\n\r\n                                <el-select\r\n                                    v-if=\"form_attorney.add == false\"\r\n                                    v-model=\"form.attorney_id\"\r\n                                    filterable\r\n                                    clearable\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in types\"\r\n                                        :key=\"option.id\"\r\n                                        :value=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                    ></el-option>\r\n                                </el-select>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </el-tab-pane>\r\n                <el-tab-pane name=\"children\" label=\"Datos de los estudiantes\">\r\n                    <div class=\"card\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Tipo de documento</label\r\n                                >\r\n                                <el-select\r\n                                    style=\"\r\n                    width:100%;\"\r\n                                    v-model=\"documentTypeChildren\"\r\n                                >\r\n                                    <el-option\r\n                                        v-for=\"option in identityDocuments\"\r\n                                        :key=\"option.id\"\r\n                                        :value=\"option.id\"\r\n                                        :label=\"option.description\"\r\n                                    >\r\n                                    </el-option>\r\n                                </el-select>\r\n                            </div>\r\n                            <div class=\"col-md-3 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Documento</label\r\n                                >\r\n                                <el-input\r\n                                    class=\"to_left\"\r\n                                    style=\"\r\n                    width:100%;\"\r\n                                    v-model=\"documentNumberChildren\"\r\n                                    :controls=\"false\"\r\n                                >\r\n                                    <el-button\r\n                                        v-if=\"documentTypeChildren == '1'\"\r\n                                        slot=\"append\"\r\n                                        :loading=\"loading_search\"\r\n                                        icon=\"el-icon-search\"\r\n                                        @click.prevent=\"searchCustomer\"\r\n                                    ></el-button>\r\n                                </el-input>\r\n                            </div>\r\n                            <div class=\"col-md-6 col-12\">\r\n                                <label for=\"number\" class=\"control-label\"\r\n                                    >Nombres</label\r\n                                >\r\n                                <el-input v-model=\"form_children.name\">\r\n                                </el-input>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row justify-content-end\">\r\n                            <div\r\n                                class=\"col-md-3 col-12 align-self-end d-flex justify-content-end\"\r\n                            >\r\n                                <el-button\r\n                                    class=\" mt-2\"\r\n                                    type=\"primary\"\r\n                                    @click=\"addChildren\"\r\n                                >\r\n                                    Agregar\r\n                                </el-button>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"row mt-2 p-2\">\r\n                            <table class=\"table\">\r\n                                <thead>\r\n                                    <tr>\r\n                                        <th>#</th>\r\n                                        <th>Nombre</th>\r\n                                        <th>Documento</th>\r\n                                        <th></th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody>\r\n                                    <tr\r\n                                        v-for=\"(child, idx) in children\"\r\n                                        :key=\"idx\"\r\n                                    >\r\n                                        <td>{{ idx + 1 }}</td>\r\n                                        <td>{{ child.name }}</td>\r\n                                        <td>\r\n                                            {{ child.number }}\r\n\r\n                                            <br />\r\n                                            <small>\r\n                                                {{\r\n                                                    getDocumentType(\r\n                                                        child.identity_document_type_id\r\n                                                    )\r\n                                                }}\r\n                                            </small>\r\n                                        </td>\r\n                                        <td>\r\n                                            <el-button\r\n                                                type=\"danger\"\r\n                                                size=\"mini\"\r\n                                                icon=\"el-icon-delete\"\r\n                                                circle\r\n                                                @click=\"\r\n                                                    deleteChild(child.number)\r\n                                                \"\r\n                                            ></el-button>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </el-tab-pane>\r\n            </el-tabs>\r\n        </div>\r\n        <div slot=\"footer\" class=\"dialog-footer\">\r\n            <el-button @click=\"close\">Cancelar</el-button>\r\n            <el-button type=\"primary\" @click=\"sendData\">Guardar</el-button>\r\n        </div>\r\n    </el-dialog>\r\n</template>\r\n<style>\r\n.to_left .el-input .el-input__inner {\r\n    text-align: left !important;\r\n}\r\n</style>\r\n<script>\r\nexport default {\r\n    props: [\"showDialog\", \"recordId\", \"extern\"],\r\n    data() {\r\n        return {\r\n            identityDocuments: [],\r\n            tab: \"parent\",\r\n            title: \"Nuevo registro\",\r\n            loading: false,\r\n\r\n            loading_search: false,\r\n            children: [],\r\n            form: {},\r\n            resource: \"college/persons\",\r\n            documentNumber: null,\r\n            documentNumberChildren: null,\r\n            documentTypeChildren: null,\r\n            departments: [],\r\n            provinces: [],\r\n            form_attorney: {\r\n                add: false\r\n            },\r\n            countries: [],\r\n            districts: [],\r\n            all_departments: [],\r\n            all_provinces: [],\r\n            all_countries: [],\r\n            all_districts: [],\r\n            errors: {},\r\n            types: [],\r\n            form_children: {\r\n                name: \"\"\r\n            },\r\n            timer: null\r\n        };\r\n    },\r\n    async created() {\r\n        await this.getTables();\r\n        await this.getAttorneyTypes();\r\n        this.initForm();\r\n    },\r\n    methods: {\r\n        async sendData() {\r\n            if (this.validForm()) {\r\n                return;\r\n            }\r\n            console.log(this.form);\r\n            this.form.children = this.children;\r\n            this.form.number = this.documentNumber;\r\n\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.post(\r\n                    `/${this.resource}`,\r\n                    this.form\r\n                );\r\n                if (response.status == 200) {\r\n                    let { success, message } = response.data;\r\n                    if (success) {\r\n                        this.$toast.success(message);\r\n                        if (this.extern) {\r\n                            this.$emit(\"memberCreated\", this.form.number);\r\n                        }\r\n                        this.close();\r\n                    } else {\r\n                        this.$toast.error(message);\r\n                    }\r\n                }\r\n            } catch (e) {\r\n                this.$toast.error(\"Ocurrió un error\");\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        getDocumentType(id) {\r\n            return this.identityDocuments.find(i => i.id == id).description;\r\n        },\r\n        initForm() {\r\n            this.form = {\r\n                country_id: \"PE\",\r\n                identity_document_type_id: \"1\",\r\n                type: \"mother\"\r\n            };\r\n            this.children = [];\r\n            this.documentTypeChildren = \"1\";\r\n            this.documentNumber = null;\r\n            this.documentNumber = null;\r\n        },\r\n        validForm() {\r\n            let error = false;\r\n            let {\r\n                name,\r\n                department_id,\r\n                province_id,\r\n                district_id,\r\n                address,\r\n                phone,\r\n\r\n                attorney_id,\r\n                type\r\n            } = this.form;\r\n            if (!name) {\r\n                error = true;\r\n                this.$toast.error(\"El nombre es obligatorio\");\r\n            }\r\n            if (!this.documentNumber) {\r\n                error = true;\r\n                this.$toast.error(\"El documento es obligatorio\");\r\n            }\r\n\r\n            if (!department_id) {\r\n                error = true;\r\n                this.$toast.error(\"El departamento es obligatorio\");\r\n            }\r\n            if (!province_id) {\r\n                error = true;\r\n                this.$toast.error(\"La provincia es obligatorio\");\r\n            }\r\n            if (!district_id) {\r\n                error = true;\r\n                this.$toast.error(\"El distrito es obligatorio\");\r\n            }\r\n            if (!address) {\r\n                error = true;\r\n                this.$toast.error(\"La dirección es obligatorio\");\r\n            }\r\n            if (!phone) {\r\n                error = true;\r\n                this.$toast.error(\"El teléfono es obligatorio\");\r\n            }\r\n\r\n            if (type == \"attorney\") {\r\n                if (!attorney_id) {\r\n                    error = true;\r\n                    this.$toast.error(\"Elija un parentezco\");\r\n                }\r\n            }\r\n\r\n            if (this.children.length == 0) {\r\n                error = true;\r\n                this.$toast.error(\"Debe registrar al menos un estudiante\");\r\n            }\r\n\r\n            return error;\r\n        },\r\n        addChildren() {\r\n            if (!this.documentNumberChildren) {\r\n                return this.$toast.error(\"Documento obligatorio\");\r\n            }\r\n\r\n            if (!this.form_children.name) {\r\n                return this.$toast.error(\"Nombre obligatorio\");\r\n            }\r\n            this.children = [\r\n                ...this.children.filter(\r\n                    c => c.number != this.documentNumberChildren\r\n                ),\r\n                {\r\n                    ...this.form_children,\r\n                    identity_document_type_id: this.documentTypeChildren,\r\n                    number: this.documentNumberChildren\r\n                }\r\n            ];\r\n\r\n            this.form_children.name = \"\";\r\n            this.documentNumberChildren = null;\r\n        },\r\n        deleteChild(number) {\r\n            this.children = [...this.children.filter(c => c.number != number)];\r\n        },\r\n        async searchType() {\r\n            if (this.timer) {\r\n                clearTimeout(this.timer);\r\n            }\r\n\r\n            this.timer = setTimeout(async () => {\r\n                await this.getAttorneyTypes();\r\n            }, 250);\r\n        },\r\n        //       this.countries = response.data.countries;\r\n        // this.all_departments = response.data.departments;\r\n        // this.all_provinces = response.data.provinces;\r\n        // this.all_districts = response.data.districts;\r\n        async getAttorneyTypes() {\r\n            //persons/attorney/record\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.get(\r\n                    `/${this.resource}/attorney/records?description=${\r\n                        this.form_attorney.name ? this.form_attorney.name : \"\"\r\n                    }`\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    let { records } = response.data;\r\n                    this.types = records;\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async saveType() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http.post(\r\n                    `/${this.resource}/attorney`,\r\n                    { description: this.form_attorney.name }\r\n                );\r\n\r\n                if (response.status == 200) {\r\n                    let { id, message, success } = response.data;\r\n                    if (success) {\r\n                        this.form.attorney_id = id;\r\n                        this.$toast.success(message);\r\n                        this.getAttorneyTypes();\r\n                        this.form_attorney.add = false;\r\n                        this.form_attorney.name = null;\r\n                    } else {\r\n                        this.$toast.error(message);\r\n                    }\r\n                }\r\n                console.log(response);\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        async getTables() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http(`/${this.resource}/tables`);\r\n                console.log(response);\r\n                if (response.status == 200) {\r\n                    let {\r\n                        departments,\r\n                        provinces,\r\n                        countries,\r\n                        districts,\r\n                        identity_documents\r\n                    } = response.data;\r\n\r\n                    this.all_departments = departments;\r\n                    this.all_provinces = provinces;\r\n                    this.all_countries = countries;\r\n                    this.all_districts = districts;\r\n                    this.identityDocuments = identity_documents;\r\n                    this.departments = departments;\r\n                    this.provinces = provinces;\r\n                    this.countries = countries;\r\n                    this.districts = districts;\r\n                }\r\n\r\n                this.form.identity_document_type_id = \"1\";\r\n                // this.form_children.identity_document_type_id = \"1\";\r\n                this.documentTypeChildren = \"1\";\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        close() {\r\n            this.$emit(\"update:showDialog\", false);\r\n        },\r\n        async open() {\r\n            this.initForm();\r\n            this.recordId && (this.title = \"Editar registro\");\r\n\r\n            if (this.recordId) {\r\n                const response = await this.$http(\r\n                    `/${this.resource}/update/${this.recordId}`\r\n                );\r\n                const { data } = response.data;\r\n                this.form = data;\r\n                this.documentNumber = this.form.number;\r\n                this.children = this.form.children;\r\n                console.log(response, \" ..\");\r\n            }\r\n        },\r\n        async searchCustomer() {\r\n            let documentNumber =\r\n                this.tab == \"parent\"\r\n                    ? this.documentNumber\r\n                    : this.documentNumberChildren;\r\n            if (documentNumber == null || documentNumber == \"\") return;\r\n            if (documentNumber.length != 8 && documentNumber.length != 11) {\r\n                this.$toast.error(\"Ingrese un documento válido\");\r\n                return;\r\n            }\r\n            if (this.timer) {\r\n                clearTimeout(this.timer);\r\n            }\r\n            this.timer = setTimeout(async () => {\r\n                try {\r\n                    this.currentCustomer = null;\r\n                    this.loading_search = true;\r\n                    const response = await this.$http(\r\n                        `/${this.resource}/${documentNumber}`\r\n                    );\r\n\r\n                    if (response.status == 200) {\r\n                        const { data } = response;\r\n                        console.log(data);\r\n                        if (data.direccion_completa) {\r\n                            if (this.tab == \"parent\") {\r\n                                if (documentNumber.length == 8) {\r\n                                    this.form.name = data.nombre_completo;\r\n                                } else {\r\n                                    this.form.name = data.nombre_o_razon_social;\r\n                                    this.form.state = data.estado;\r\n                                    this.form.condition = data.condicion;\r\n                                }\r\n\r\n                                this.form.address = data.direccion_completa;\r\n                                if (data.ubigeo.length == 3) {\r\n                                    let [\r\n                                        department,\r\n                                        province,\r\n                                        district\r\n                                    ] = data.ubigeo;\r\n                                    this.form.department_id = department;\r\n                                    this.form.province_id = province;\r\n                                    this.form.district_id = district;\r\n                                }\r\n                            } else {\r\n                                this.form_children.name = data.nombre_completo;\r\n                            }\r\n                        } else {\r\n                            this.$toast.error(\"No se encontró el documento\");\r\n                        }\r\n                    } else {\r\n                        this.$toast.error(\"No se pudo obtener los datos\");\r\n                    }\r\n                } catch (e) {\r\n                    this.$toast.error(\"No se pudo obtener los datos\");\r\n                } finally {\r\n                    this.loading_search = false;\r\n                }\r\n            }, 250);\r\n        },\r\n        filterProvince() {\r\n            this.form.province_id = null;\r\n            this.form.district_id = null;\r\n            this.filterProvinces();\r\n        },\r\n        filterProvinces() {\r\n            this.provinces = this.all_provinces.filter(f => {\r\n                return f.department_id === this.form.department_id;\r\n            });\r\n        },\r\n        filterDistrict() {\r\n            this.form.district_id = null;\r\n            this.filterDistricts();\r\n        },\r\n        filterDistricts() {\r\n            this.districts = this.all_districts.filter(f => {\r\n                return f.province_id === this.form.province_id;\r\n            });\r\n        },\r\n        closeProperty() {\r\n            this.form.state = null;\r\n            this.form.condition = null;\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-bf046f30\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
=======
/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-cd4ba31c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/form.vue":
>>>>>>> master
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
<<<<<<< HEAD
        visible: _vm.showDialog,
        "append-to-body": "",
        title: _vm.title
      },
      on: { close: _vm.close, open: _vm.open }
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
          staticClass: "form-body"
        },
        [
          _c(
            "el-tabs",
            {
              attrs: { "tab-position": "top" },
              model: {
                value: _vm.tab,
                callback: function($$v) {
                  _vm.tab = $$v
                },
                expression: "tab"
              }
            },
            [
              _c(
                "el-tab-pane",
                { attrs: { name: "parent", label: "Datos del Cliente" } },
                [
                  _c("div", { staticClass: "card" }, [
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Tipo de documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticStyle: { width: "100%" },
                              on: { change: _vm.closeProperty },
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
                            _vm._l(_vm.identityDocuments, function(option) {
                              return _c("el-option", {
                                key: option.id,
                                attrs: {
                                  value: option.id,
                                  label: option.description
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
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-input",
                            {
                              staticClass: "to_left",
                              staticStyle: { width: "100%" },
                              attrs: { controls: false },
                              on: { input: _vm.closeProperty },
                              model: {
                                value: _vm.documentNumber,
                                callback: function($$v) {
                                  _vm.documentNumber = $$v
                                },
                                expression: "documentNumber"
                              }
                            },
                            [
                              _vm.form.identity_document_type_id == 1 ||
                              _vm.form.identity_document_type_id == 6
                                ? _c("el-button", {
                                    attrs: {
                                      slot: "append",
                                      loading: _vm.loading_search,
                                      icon: "el-icon-search"
                                    },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.searchCustomer.apply(
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
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Nombres")]
                          ),
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
                      )
                    ]),
                    _vm._v(" "),
                    _vm.form.state && _vm.form.condition
                      ? _c("div", { staticClass: "row mt-2" }, [
                          _c("div", { staticClass: "col-md-6 col-12" }),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-md-3 col-12" },
                            [
                              _c("el-alert", {
                                attrs: {
                                  title: _vm.form.state,
                                  type:
                                    "" +
                                    (_vm.form.state == "ACTIVO"
                                      ? "success"
                                      : "error")
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-md-3" },
                            [
                              _c("el-alert", {
                                attrs: {
                                  title: _vm.form.condition,
                                  type:
                                    "" +
                                    (_vm.form.condition == "HABIDO"
                                      ? "success"
                                      : "error")
                                }
                              })
                            ],
                            1
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mt-2" }, [
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.country_id }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("País")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  dusk: "country_id",
                                  disabled: ""
                                },
                                model: {
                                  value: _vm.form.country_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "country_id", $$v)
                                  },
                                  expression: "form.country_id"
                                }
                              },
                              _vm._l(_vm.countries, function(option) {
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
                            _vm.errors.country_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.country_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.department_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Departamento")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  "popper-class": "el-select-departments",
                                  dusk: "department_id"
                                },
                                on: { change: _vm.filterProvince },
                                model: {
                                  value: _vm.form.department_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "department_id", $$v)
                                  },
                                  expression: "form.department_id"
                                }
                              },
                              _vm._l(_vm.departments, function(option) {
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
                            _vm.errors.department_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.department_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.province_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Provincia")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  "popper-class": "el-select-provinces",
                                  dusk: "province_id"
                                },
                                on: { change: _vm.filterDistrict },
                                model: {
                                  value: _vm.form.province_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "province_id", $$v)
                                  },
                                  expression: "form.province_id"
                                }
                              },
                              _vm._l(_vm.provinces, function(option) {
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
                            _vm.errors.province_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.province_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.district_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Distrito")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  "popper-class": "el-select-districts",
                                  dusk: "district_id"
                                },
                                model: {
                                  value: _vm.form.district_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "district_id", $$v)
                                  },
                                  expression: "form.district_id"
                                }
                              },
                              _vm._l(_vm.districts, function(option) {
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
                            _vm.errors.district_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.district_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-8" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.address }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Dirección")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: { dusk: "address" },
                                model: {
                                  value: _vm.form.address,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "address", $$v)
                                  },
                                  expression: "form.address"
=======
        width: "65%",
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "close-on-click-modal": false,
        "append-to-body": "",
        top: "7vh"
      },
      on: { close: _vm.close, open: _vm.create }
    },
    [
      _c(
        "form",
        {
          attrs: { autocomplete: "off" },
          on: {
            submit: function($event) {
              $event.preventDefault()
              return _vm.submit.apply(null, arguments)
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "form-body" },
            [
              _c(
                "el-tabs",
                { attrs: { "tab-position": "top" } },
                [
                  _c("el-tab-pane", { attrs: { label: "General" } }, [
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.internal_id
                            }
                          },
                          [
                            _c(
                              "label",
                              { staticClass: "control-label" },
                              [
                                _vm._v(
                                  "Código Interno\n                                    "
                                ),
                                _c(
                                  "el-tooltip",
                                  {
                                    staticClass: "item",
                                    attrs: {
                                      effect: "dark",
                                      content:
                                        "Código interno de la empresa para el control de sus productos",
                                      placement: "top-start"
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "fa fa-info-circle"
                                    })
                                  ]
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                ref: "internal_id",
                                attrs: { dusk: "internal_id" },
                                model: {
                                  value: _vm.form.internal_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "internal_id", $$v)
                                  },
                                  expression: "form.internal_id"
>>>>>>> master
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "el-icon-edit-outline",
                                  attrs: { slot: "prefix" },
                                  slot: "prefix"
                                })
                              ]
                            ),
                            _vm._v(" "),
<<<<<<< HEAD
                            _vm.errors.address
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(_vm.errors.address[0])
=======
                            _vm.errors.internal_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.internal_id[0]
                                    )
>>>>>>> master
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
<<<<<<< HEAD
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Teléfono")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.phone,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "phone", $$v)
                              },
                              expression: "form.phone"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Correo")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.email,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "email", $$v)
                              },
                              expression: "form.email"
                            }
                          })
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mt-2" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Teléfono secundario")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form.extra_phone,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "extra_phone", $$v)
                              },
                              expression: "form.extra_phone"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Relacion")]
                          ),
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
                                attrs: { value: "mother", label: "Madre" }
                              }),
                              _vm._v(" "),
                              _c("el-option", {
                                attrs: { value: "father", label: "Padre" }
                              }),
                              _vm._v(" "),
                              _c("el-option", {
                                attrs: { value: "attorney", label: "Apoderado" }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row mt-2" }, [
                      _vm.form.type == "attorney"
                        ? _c(
                            "div",
                            { staticClass: "col-md-6 col-12" },
                            [
                              _c(
                                "label",
                                {
                                  staticClass: "control-label",
                                  attrs: { for: "number" }
                                },
                                [_vm._v("Tipo de apoderado")]
                              ),
                              _vm._v(" "),
                              _vm.form_attorney.add == false
                                ? _c(
                                    "a",
                                    {
                                      staticClass:
                                        "control-label font-weight-bold text-info",
                                      attrs: { href: "#" },
                                      on: {
                                        click: function($event) {
                                          _vm.form_attorney.add = true
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                [ + Nuevo]"
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == true
                                ? _c(
                                    "a",
                                    {
                                      staticClass:
                                        "control-label font-weight-bold text-info",
                                      attrs: { href: "#" },
                                      on: {
                                        click: function($event) {
                                          return _vm.saveType()
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                [ + Guardar]"
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == true
                                ? _c(
                                    "a",
                                    {
                                      staticClass:
                                        "control-label font-weight-bold text-danger",
                                      attrs: { href: "#" },
                                      on: {
                                        click: function($event) {
                                          _vm.form_attorney.add = false
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                [ Cancelar]"
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == true
                                ? _c(
                                    "el-input",
                                    {
                                      staticStyle: { "margin-bottom": "1.5%" },
                                      attrs: { dusk: "item_code" },
                                      on: { input: _vm.searchType },
                                      model: {
                                        value: _vm.form_attorney.name,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form_attorney,
                                            "name",
                                            $$v
                                          )
                                        },
                                        expression: "form_attorney.name"
                                      }
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "el-icon-edit-outline",
                                        attrs: { slot: "prefix" },
                                        slot: "prefix"
                                      })
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.form_attorney.add == false
                                ? _c(
                                    "el-select",
                                    {
                                      attrs: { filterable: "", clearable: "" },
                                      model: {
                                        value: _vm.form.attorney_id,
                                        callback: function($$v) {
                                          _vm.$set(_vm.form, "attorney_id", $$v)
                                        },
                                        expression: "form.attorney_id"
                                      }
                                    },
                                    _vm._l(_vm.types, function(option) {
=======
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-6" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.description
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Nombre"),
                              _c("span", { staticClass: "text-danger" }, [
                                _vm._v("*")
                              ])
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: { dusk: "description" },
                                model: {
                                  value: _vm.form.description,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "description", $$v)
                                  },
                                  expression: "form.description"
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "el-icon-edit-outline",
                                  attrs: { slot: "prefix" },
                                  slot: "prefix"
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _vm.errors.description
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.description[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.second_name
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "Nombre secundario\n                                "
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: { dusk: "second_name" },
                                model: {
                                  value: _vm.form.second_name,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "second_name", $$v)
                                  },
                                  expression: "form.second_name"
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "el-icon-edit-outline",
                                  attrs: { slot: "prefix" },
                                  slot: "prefix"
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _vm.errors.second_name
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.second_name[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.category_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "\n                                    Categoría\n                                "
                              )
                            ]),
                            _vm._v(" "),
                            _vm.form_category.add == false
                              ? _c(
                                  "a",
                                  {
                                    staticClass:
                                      "control-label font-weight-bold text-info",
                                    attrs: { href: "#" },
                                    on: {
                                      click: function($event) {
                                        _vm.form_category.add = true
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    [ + Nuevo]"
                                    )
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.form_category.add == true
                              ? _c(
                                  "a",
                                  {
                                    staticClass:
                                      "control-label font-weight-bold text-info",
                                    attrs: { href: "#" },
                                    on: {
                                      click: function($event) {
                                        return _vm.saveCategory()
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    [ + Guardar]"
                                    )
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.form_category.add == true
                              ? _c(
                                  "a",
                                  {
                                    staticClass:
                                      "control-label font-weight-bold text-danger",
                                    attrs: { href: "#" },
                                    on: {
                                      click: function($event) {
                                        _vm.form_category.add = false
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    [ Cancelar]"
                                    )
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.form_category.add == true
                              ? _c(
                                  "el-input",
                                  {
                                    staticStyle: { "margin-bottom": "1.5%" },
                                    attrs: { dusk: "item_code" },
                                    model: {
                                      value: _vm.form_category.name,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form_category, "name", $$v)
                                      },
                                      expression: "form_category.name"
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "el-icon-edit-outline",
                                      attrs: { slot: "prefix" },
                                      slot: "prefix"
                                    })
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.form_category.add == false
                              ? _c(
                                  "el-select",
                                  {
                                    attrs: { filterable: "", clearable: "" },
                                    model: {
                                      value: _vm.form.category_id,
                                      callback: function($$v) {
                                        _vm.$set(_vm.form, "category_id", $$v)
                                      },
                                      expression: "form.category_id"
                                    }
                                  },
                                  _vm._l(_vm.categories, function(option) {
                                    return _c("el-option", {
                                      key: option.id,
                                      attrs: {
                                        value: option.id,
                                        label: option.name
                                      }
                                    })
                                  }),
                                  1
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.errors.category_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.category_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger":
                                _vm.errors.sale_affectation_igv_type_id
                            }
                          },
                          [
                            _c(
                              "label",
                              { staticClass: "control-label" },
                              [
                                _vm._v(
                                  "Zona\n                                    "
                                ),
                                _c(
                                  "el-tooltip",
                                  {
                                    staticClass: "item",
                                    attrs: {
                                      effect: "dark",
                                      content:
                                        "Lugar en donde se despacha el producto",
                                      placement: "top-start"
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "fa fa-info-circle"
                                    })
                                  ]
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                model: {
                                  value: _vm.form.area_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "area_id", $$v)
                                  },
                                  expression: "form.area_id"
                                }
                              },
                              _vm._l(_vm.areas, function(option) {
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
                            _vm.errors.sale_affectation_igv_type_id
                              ? _c("small", {
                                  staticClass: "form-control-feedback",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.sale_affectation_igv_type_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
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
                              value: _vm.show_has_igv,
                              expression: "show_has_igv"
                            }
                          ],
                          staticClass: "col-md-3 center-el-checkbox"
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass: "form-group",
                              class: { "has-danger": _vm.errors.has_igv }
                            },
                            [
                              _c(
                                "el-checkbox",
                                {
                                  model: {
                                    value: _vm.form.has_igv,
                                    callback: function($$v) {
                                      _vm.$set(_vm.form, "has_igv", $$v)
                                    },
                                    expression: "form.has_igv"
                                  }
                                },
                                [
                                  _vm._v(
                                    "Incluye Igv\n                                    " +
                                      _vm._s(_vm.configuration.include_igv)
                                  )
                                ]
                              ),
                              _c("br"),
                              _vm._v(" "),
                              _vm.errors.has_igv
                                ? _c("small", {
                                    staticClass: "text-danger",
                                    domProps: {
                                      textContent: _vm._s(_vm.errors.has_igv[0])
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.location }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "Ubicación del producto\n                                "
                              )
                            ]),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { dusk: "name" },
                              model: {
                                value: _vm.form.location,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "location", $$v)
                                },
                                expression: "form.location"
                              }
                            }),
                            _vm._v(" "),
                            _vm.errors.location
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(_vm.errors.location[0])
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.unit_type_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Unidad")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: { dusk: "unit_type_id" },
                                model: {
                                  value: _vm.form.unit_type_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "unit_type_id", $$v)
                                  },
                                  expression: "form.unit_type_id"
                                }
                              },
                              _vm._l(_vm.unit_types, function(option) {
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
                            _vm.errors.unit_type_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.unit_type_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.currency_type_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Moneda")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: { dusk: "currency_type_id" },
                                model: {
                                  value: _vm.form.currency_type_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "currency_type_id", $$v)
                                  },
                                  expression: "form.currency_type_id"
                                }
                              },
                              _vm._l(_vm.currency_types, function(option) {
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
                            _vm.errors.currency_type_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.currency_type_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.sale_unit_price
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v(
                                "Precio Unitario (Venta)\n                                    "
                              ),
                              _c("span", { staticClass: "text-danger" }, [
                                _vm._v("*")
                              ])
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: { dusk: "sale_unit_price" },
                                on: {
                                  input: _vm.calculatePercentageOfProfitBySale
                                },
                                model: {
                                  value: _vm.form.sale_unit_price,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "sale_unit_price", $$v)
                                  },
                                  expression: "form.sale_unit_price"
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "el-icon-edit-outline",
                                  attrs: { slot: "prefix" },
                                  slot: "prefix"
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _vm.errors.sale_unit_price
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.sale_unit_price[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger":
                                _vm.errors.sale_affectation_igv_type_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Tipo de afectación (Venta)")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                on: { change: _vm.changeAffectationIgvType },
                                model: {
                                  value: _vm.form.sale_affectation_igv_type_id,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.form,
                                      "sale_affectation_igv_type_id",
                                      $$v
                                    )
                                  },
                                  expression:
                                    "\n                                        form.sale_affectation_igv_type_id\n                                    "
                                }
                              },
                              _vm._l(_vm.affectation_igv_types, function(
                                option
                              ) {
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
                            _vm.errors.sale_affectation_igv_type_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.sale_affectation_igv_type_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
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
                              value:
                                _vm.recordId == null &&
                                _vm.form.unit_type_id != "ZZ",
                              expression:
                                "\n                                recordId == null &&\n                                    form.unit_type_id != 'ZZ'\n                            "
                            }
                          ],
                          staticClass: "col-md-3"
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass: "form-group",
                              class: { "has-danger": _vm.errors.stock }
                            },
                            [
                              !_vm.allEstablishment
                                ? _c(
                                    "label",
                                    { staticClass: "control-label" },
                                    [_vm._v("Stock Inicial")]
                                  )
                                : _c(
                                    "label",
                                    { staticClass: "control-label" },
                                    [
                                      _vm._v(
                                        "\n                                    Stock Inicial en cada establecimiento\n                                "
                                      )
                                    ]
                                  ),
                              _vm._v(" "),
                              _c(
                                "el-input",
                                {
                                  model: {
                                    value: _vm.form.stock,
                                    callback: function($$v) {
                                      _vm.$set(_vm.form, "stock", $$v)
                                    },
                                    expression: "form.stock"
                                  }
                                },
                                [
                                  _c("i", {
                                    staticClass: "el-icon-edit-outline",
                                    attrs: { slot: "prefix" },
                                    slot: "prefix"
                                  })
                                ]
                              ),
                              _vm._v(" "),
                              _vm.errors.stock
                                ? _c("small", {
                                    staticClass: "text-danger",
                                    domProps: {
                                      textContent: _vm._s(_vm.errors.stock[0])
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _vm.form.unit_type_id != "ZZ"
                        ? _c(
                            "div",
                            {
                              directives: [
                                {
                                  name: "show",
                                  rawName: "v-show",
                                  value: _vm.recordId == null,
                                  expression: "recordId == null"
                                }
                              ],
                              staticClass: "col-md-3"
                            },
                            [
                              _c(
                                "div",
                                {
                                  staticClass: "form-group",
                                  class: {
                                    "has-danger": _vm.errors.warehouse_id
                                  }
                                },
                                [
                                  _c(
                                    "label",
                                    { staticClass: "control-label" },
                                    [
                                      _vm._v(
                                        "\n                                    Almacén\n                                    "
                                      ),
                                      _c(
                                        "el-tooltip",
                                        {
                                          staticClass: "item",
                                          attrs: {
                                            effect: "dark",
                                            content:
                                              "Si no selecciona almacén, se asignará por defecto el relacionado al establecimiento",
                                            placement: "top"
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-info-circle"
                                          })
                                        ]
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "el-select",
                                    {
                                      attrs: { disabled: _vm.allEstablishment },
                                      on: { change: _vm.changeWarehouse },
                                      model: {
                                        value: _vm.form.warehouse_id,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form,
                                            "warehouse_id",
                                            $$v
                                          )
                                        },
                                        expression: "form.warehouse_id"
                                      }
                                    },
                                    _vm._l(_vm.warehouses, function(option) {
>>>>>>> master
                                      return _c("el-option", {
                                        key: option.id,
                                        attrs: {
                                          value: option.id,
                                          label: option.description
                                        }
                                      })
                                    }),
                                    1
<<<<<<< HEAD
                                  )
                                : _vm._e()
                            ],
                            1
                          )
                        : _vm._e()
                    ])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "el-tab-pane",
                {
                  attrs: { name: "children", label: "Datos de los estudiantes" }
                },
                [
                  _c("div", { staticClass: "card" }, [
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Tipo de documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticStyle: { width: "100%" },
                              model: {
                                value: _vm.documentTypeChildren,
                                callback: function($$v) {
                                  _vm.documentTypeChildren = $$v
                                },
                                expression: "documentTypeChildren"
                              }
                            },
                            _vm._l(_vm.identityDocuments, function(option) {
                              return _c("el-option", {
                                key: option.id,
                                attrs: {
                                  value: option.id,
                                  label: option.description
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
                        { staticClass: "col-md-3 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Documento")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-input",
                            {
                              staticClass: "to_left",
                              staticStyle: { width: "100%" },
                              attrs: { controls: false },
                              model: {
                                value: _vm.documentNumberChildren,
                                callback: function($$v) {
                                  _vm.documentNumberChildren = $$v
                                },
                                expression: "documentNumberChildren"
                              }
                            },
                            [
                              _vm.documentTypeChildren == "1"
                                ? _c("el-button", {
                                    attrs: {
                                      slot: "append",
                                      loading: _vm.loading_search,
                                      icon: "el-icon-search"
                                    },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.searchCustomer.apply(
                                          null,
                                          arguments
                                        )
                                      }
                                    },
                                    slot: "append"
=======
                                  ),
                                  _vm._v(" "),
                                  !_vm.recordId
                                    ? _c(
                                        "small",
                                        [
                                          _c(
                                            "el-checkbox",
                                            {
                                              model: {
                                                value: _vm.allEstablishment,
                                                callback: function($$v) {
                                                  _vm.allEstablishment = $$v
                                                },
                                                expression: "allEstablishment"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                        Enviar a todos los almacenes\n                                    "
                                              )
                                            ]
                                          )
                                        ],
                                        1
                                      )
                                    : _vm._e()
                                ],
                                1
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.form.unit_type_id != "ZZ",
                              expression: "form.unit_type_id != 'ZZ'"
                            }
                          ],
                          staticClass: "col-md-3"
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass: "form-group",
                              class: {
                                "has-danger": _vm.errors.date_of_due
                              }
                            },
                            [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Fec. Vencimiento")
                              ]),
                              _vm._v(" "),
                              _c("el-date-picker", {
                                attrs: {
                                  type: "date",
                                  "value-format": "yyyy-MM-dd",
                                  clearable: true
                                },
                                model: {
                                  value: _vm.form.date_of_due,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "date_of_due", $$v)
                                  },
                                  expression: "form.date_of_due"
                                }
                              }),
                              _vm._v(" "),
                              _vm.errors.date_of_due
                                ? _c("small", {
                                    staticClass: "text-danger",
                                    domProps: {
                                      textContent: _vm._s(
                                        _vm.errors.date_of_due[0]
                                      )
                                    }
>>>>>>> master
                                  })
                                : _vm._e()
                            ],
                            1
                          )
<<<<<<< HEAD
                        ],
                        1
=======
                        ]
>>>>>>> master
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
<<<<<<< HEAD
                        { staticClass: "col-md-6 col-12" },
                        [
                          _c(
                            "label",
                            {
                              staticClass: "control-label",
                              attrs: { for: "number" }
                            },
                            [_vm._v("Nombres")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            model: {
                              value: _vm.form_children.name,
                              callback: function($$v) {
                                _vm.$set(_vm.form_children, "name", $$v)
                              },
                              expression: "form_children.name"
                            }
                          })
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row justify-content-end" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-md-3 col-12 align-self-end d-flex justify-content-end"
                        },
                        [
                          _c(
                            "el-button",
                            {
                              staticClass: " mt-2",
                              attrs: { type: "primary" },
                              on: { click: _vm.addChildren }
                            },
                            [
                              _vm._v(
                                "\n                                Agregar\n                            "
                              )
=======
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.form.unit_type_id != "ZZ",
                              expression: "form.unit_type_id != 'ZZ'"
                            }
                          ],
                          staticClass: "col-md-3"
                        },
                        [
                          _c(
                            "div",
                            { staticClass: "form-group" },
                            [
                              _c(
                                "label",
                                { staticClass: "control-label" },
                                [
                                  _vm._v(
                                    "Cantidad Máxima\n                                    "
                                  ),
                                  _c(
                                    "el-tooltip",
                                    {
                                      staticClass: "item",
                                      attrs: {
                                        effect: "dark",
                                        content:
                                          "La cantidad máxima representada en el envase/contenedor",
                                        placement: "top"
                                      }
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "fa fa-info-circle"
                                      })
                                    ]
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("el-input", {
                                attrs: {
                                  disabled: _vm.form.item_unit_types.length != 0
                                },
                                model: {
                                  value: _vm.form.max_quantity,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "max_quantity", $$v)
                                  },
                                  expression: "form.max_quantity"
                                }
                              })
                            ],
                            1
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _vm.showSeries
                        ? _c("div", { staticClass: "d-flex" }, [
                            _c("div", { staticClass: "col-md-4" }, [
                              _c(
                                "div",
                                {
                                  directives: [
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value: _vm.form.unit_type_id != "ZZ",
                                      expression: "form.unit_type_id != 'ZZ'"
                                    }
                                  ],
                                  staticClass: "col-md-3 center-el-checkbox"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "form-group" },
                                    [
                                      _c(
                                        "el-checkbox",
                                        {
                                          on: { change: _vm.changeLotsEnabled },
                                          model: {
                                            value: _vm.form.series_enabled,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form,
                                                "series_enabled",
                                                $$v
                                              )
                                            },
                                            expression: "form.series_enabled"
                                          }
                                        },
                                        [_vm._v("¿Maneja series?")]
                                      ),
                                      _c("br")
                                    ],
                                    1
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _vm.form.unit_type_id != "ZZ" &&
                              _vm.form.series_enabled
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "col-md-4 d-flex align-items-end"
                                    },
                                    [
                                      _c(
                                        "div",
                                        {
                                          staticClass: "form-group ",
                                          class: {
                                            "has-danger": _vm.errors.lot_code
                                          }
                                        },
                                        [
                                          _c(
                                            "label",
                                            { staticClass: "control-label" },
                                            [
                                              _vm._v(
                                                "\n                                            Ingrese series\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c("el-button", {
                                            staticStyle: {
                                              "margin-top": "2%",
                                              "margin-left": "15px"
                                            },
                                            attrs: {
                                              type: "primary",
                                              icon: "el-icon-edit-outline"
                                            },
                                            on: {
                                              click: function($event) {
                                                $event.preventDefault()
                                                return _vm.clickLotcode.apply(
                                                  null,
                                                  arguments
                                                )
                                              }
                                            }
                                          }),
                                          _vm._v(" "),
                                          _vm.errors.lot_code
                                            ? _c("small", {
                                                staticClass: "text-danger",
                                                domProps: {
                                                  textContent: _vm._s(
                                                    _vm.errors.lot_code[0]
                                                  )
                                                }
                                              })
                                            : _vm._e()
                                        ],
                                        1
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "col-md-4" }, [
                              _c(
                                "div",
                                {
                                  directives: [
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value: _vm.form.unit_type_id != "ZZ",
                                      expression: "form.unit_type_id != 'ZZ'"
                                    }
                                  ],
                                  staticClass: "col-md-3 center-el-checkbox"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "form-group" },
                                    [
                                      _c(
                                        "el-checkbox",
                                        {
                                          on: { change: _vm.changeLotsEnabled },
                                          model: {
                                            value: _vm.form.lots_enabled,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form,
                                                "lots_enabled",
                                                $$v
                                              )
                                            },
                                            expression: "form.lots_enabled"
                                          }
                                        },
                                        [_vm._v("¿Maneja lotes?")]
                                      ),
                                      _c("br")
                                    ],
                                    1
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                {
                                  directives: [
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value:
                                        _vm.form.unit_type_id != "ZZ" &&
                                        _vm.form.lots_enabled,
                                      expression:
                                        "\n                                        form.unit_type_id != 'ZZ' &&\n                                            form.lots_enabled\n                                    "
                                    }
                                  ],
                                  staticClass: "col-md-6"
                                },
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "form-group",
                                      class: {
                                        "has-danger": _vm.errors.lot_code
                                      }
                                    },
                                    [
                                      _c(
                                        "label",
                                        { staticClass: "control-label" },
                                        [
                                          _vm._v(
                                            "\n                                            Código lote\n                                        "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "el-input",
                                        {
                                          model: {
                                            value: _vm.form.lot_code,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form,
                                                "lot_code",
                                                $$v
                                              )
                                            },
                                            expression: "form.lot_code"
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "el-icon-edit-outline",
                                            attrs: { slot: "prefix" },
                                            slot: "prefix"
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm.errors.lot_code
                                        ? _c("small", {
                                            staticClass: "text-danger",
                                            domProps: {
                                              textContent: _vm._s(
                                                _vm.errors.lot_code[0]
                                              )
                                            }
                                          })
                                        : _vm._e()
                                    ],
                                    1
                                  )
                                ]
                              )
                            ])
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "col-md-12" }, [
                        _c("h6", { staticClass: "separator-title" }, [
                          _vm._v(
                            "\n                                Campos adicionales\n                            "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row col-md-12" }, [
                        _c("div", { staticClass: "col-md-3" }, [
                          _c(
                            "div",
                            { staticClass: "form-group" },
                            [
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v(
                                  "Imágen\n                                        "
                                ),
                                _c("span", { staticClass: "text-danger" })
                              ]),
                              _vm._v(" "),
                              _c(
                                "el-upload",
                                {
                                  staticClass: "avatar-uploader",
                                  attrs: {
                                    data: { type: "items" },
                                    headers: _vm.headers,
                                    action: "/" + _vm.resource + "/uploads",
                                    "show-file-list": false,
                                    "on-success": _vm.onSuccess
                                  }
                                },
                                [
                                  _vm.form.image_url
                                    ? _c("img", {
                                        staticClass: "avatar",
                                        attrs: { src: _vm.form.image_url }
                                      })
                                    : _c("i", {
                                        staticClass:
                                          "el-icon-plus avatar-uploader-icon"
                                      })
                                ]
                              )
                            ],
                            1
                          )
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-md-9" }, [
                          _c("div", { staticClass: "row" }, [
                            _c("div", { staticClass: "col-md-6" }, [
                              _c(
                                "div",
                                {
                                  staticClass: "form-group",
                                  class: {
                                    "has-danger": _vm.errors.brand_id
                                  }
                                },
                                [
                                  _c(
                                    "label",
                                    { staticClass: "control-label" },
                                    [
                                      _vm._v(
                                        "\n                                                Marca\n                                            "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _vm.form_brand.add == false
                                    ? _c(
                                        "a",
                                        {
                                          staticClass:
                                            "control-label font-weight-bold text-info",
                                          attrs: { href: "#" },
                                          on: {
                                            click: function($event) {
                                              _vm.form_brand.add = true
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                [ + Nuevo]"
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.form_brand.add == true
                                    ? _c(
                                        "a",
                                        {
                                          staticClass:
                                            "control-label font-weight-bold text-info",
                                          attrs: { href: "#" },
                                          on: {
                                            click: function($event) {
                                              return _vm.saveBrand()
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                [ + Guardar]"
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.form_brand.add == true
                                    ? _c(
                                        "a",
                                        {
                                          staticClass:
                                            "control-label font-weight-bold text-danger",
                                          attrs: { href: "#" },
                                          on: {
                                            click: function($event) {
                                              _vm.form_brand.add = false
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                [ Cancelar]"
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.form_brand.add == true
                                    ? _c(
                                        "el-input",
                                        {
                                          staticStyle: {
                                            "margin-bottom": "1.5%"
                                          },
                                          attrs: { dusk: "item_code" },
                                          model: {
                                            value: _vm.form_brand.name,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form_brand,
                                                "name",
                                                $$v
                                              )
                                            },
                                            expression: "form_brand.name"
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "el-icon-edit-outline",
                                            attrs: { slot: "prefix" },
                                            slot: "prefix"
                                          })
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.form_brand.add == false
                                    ? _c(
                                        "el-select",
                                        {
                                          attrs: {
                                            filterable: "",
                                            clearable: ""
                                          },
                                          model: {
                                            value: _vm.form.brand_id,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form,
                                                "brand_id",
                                                $$v
                                              )
                                            },
                                            expression: "form.brand_id"
                                          }
                                        },
                                        _vm._l(_vm.brands, function(option) {
                                          return _c("el-option", {
                                            key: option.id,
                                            attrs: {
                                              value: option.id,
                                              label: option.name
                                            }
                                          })
                                        }),
                                        1
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.errors.brand_id
                                    ? _c("small", {
                                        staticClass: "text-danger",
                                        domProps: {
                                          textContent: _vm._s(
                                            _vm.errors.brand_id[0]
                                          )
                                        }
                                      })
                                    : _vm._e()
                                ],
                                1
                              )
                            ]),
                            _vm._v(" "),
                            _vm.attribute_types.length > 0
                              ? _c("div", { staticClass: "col-md-12" }, [
                                  _c(
                                    "h6",
                                    { staticClass: "separator-title " },
                                    [
                                      _vm._v(
                                        "\n                                            Atributos\n                                            "
                                      ),
                                      _c(
                                        "el-tooltip",
                                        {
                                          staticClass: "item",
                                          attrs: {
                                            effect: "dark",
                                            content:
                                              "Diferentes presentaciones para la venta del producto",
                                            placement: "top"
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-info-circle"
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "a",
                                        {
                                          staticClass:
                                            "control-label font-weight-bold text-info",
                                          attrs: { href: "#" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.clickAddAttribute.apply(
                                                null,
                                                arguments
                                              )
                                            }
                                          }
                                        },
                                        [_vm._v("[+ Agregar]")]
                                      )
                                    ],
                                    1
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.form.attributes.length > 0
                              ? _c("div", { staticClass: "col-md-12" }, [
                                  _c(
                                    "div",
                                    { staticClass: "table-responsive" },
                                    [
                                      _c("table", { staticClass: "table" }, [
                                        _c("thead", [
                                          _c("tr", [
                                            _c("th", [_vm._v("Tipo")]),
                                            _vm._v(" "),
                                            _c("th", [_vm._v("Descripción")]),
                                            _vm._v(" "),
                                            _c("th")
                                          ])
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "tbody",
                                          _vm._l(_vm.form.attributes, function(
                                            row,
                                            index
                                          ) {
                                            return _c("tr", { key: index }, [
                                              _c(
                                                "td",
                                                [
                                                  _c(
                                                    "el-select",
                                                    {
                                                      attrs: { filterable: "" },
                                                      on: {
                                                        change: function(
                                                          $event
                                                        ) {
                                                          return _vm.changeAttributeType(
                                                            index
                                                          )
                                                        }
                                                      },
                                                      model: {
                                                        value:
                                                          row.attribute_type_id,
                                                        callback: function(
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            row,
                                                            "attribute_type_id",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "\n                                                                    row.attribute_type_id\n                                                                "
                                                      }
                                                    },
                                                    _vm._l(
                                                      _vm.attribute_types,
                                                      function(option) {
                                                        return _c("el-option", {
                                                          key: option.id,
                                                          attrs: {
                                                            value: option.id,
                                                            label:
                                                              option.description
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
                                                "td",
                                                [
                                                  _c(
                                                    "el-input",
                                                    {
                                                      model: {
                                                        value: row.value,
                                                        callback: function(
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            row,
                                                            "value",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "\n                                                                    row.value\n                                                                "
                                                      }
                                                    },
                                                    [
                                                      _c("i", {
                                                        staticClass:
                                                          "el-icon-edit-outline",
                                                        attrs: {
                                                          slot: "prefix"
                                                        },
                                                        slot: "prefix"
                                                      })
                                                    ]
                                                  )
                                                ],
                                                1
                                              ),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c(
                                                  "button",
                                                  {
                                                    staticClass:
                                                      "btn btn-danger",
                                                    attrs: { type: "button" },
                                                    on: {
                                                      click: function($event) {
                                                        $event.preventDefault()
                                                        return _vm.clickRemoveAttribute(
                                                          index
                                                        )
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                                x\n                                                            "
                                                    )
                                                  ]
                                                )
                                              ])
                                            ])
                                          }),
                                          0
                                        )
                                      ])
                                    ]
                                  )
                                ])
                              : _vm._e()
                          ])
                        ])
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.form.unit_type_id != "ZZ"
                    ? _c("el-tab-pane", { attrs: { label: "Almacenes" } }, [
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-12" }, [
                            _c("h5", { staticClass: "separator-title mt-0" }, [
                              _vm._v(
                                "\n                                Precios por almacén\n                            "
                              )
                            ]),
                            _vm._v(" "),
                            _c("table", [
                              _c(
                                "tbody",
                                _vm._l(_vm.form.warehouse_prices, function(w) {
                                  return _c("tr", { key: w.id }, [
                                    _c("td", { attrs: { width: "80%" } }, [
                                      _c("h3", [_vm._v(_vm._s(w.warehouse))])
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _c("el-input", {
                                          attrs: {
                                            placeholder: "Precio de almacen"
                                          },
                                          on: {
                                            input: function($event) {
                                              return _vm.$forceUpdate()
                                            }
                                          },
                                          model: {
                                            value: w.price,
                                            callback: function($$v) {
                                              _vm.$set(w, "price", $$v)
                                            },
                                            expression: "w.price"
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ])
                                }),
                                0
                              )
                            ])
                          ])
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("el-tab-pane", { attrs: { label: "Lista de Precios" } }, [
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.form.unit_type_id != "ZZ",
                              expression: "form.unit_type_id != 'ZZ'"
                            }
                          ],
                          staticClass: "col-md-12"
                        },
                        [
                          _c(
                            "h6",
                            { staticClass: "separator-title " },
                            [
                              _vm._v(
                                "\n                                Listado de precios\n                                "
                              ),
                              _c(
                                "el-tooltip",
                                {
                                  staticClass: "item",
                                  attrs: {
                                    effect: "dark",
                                    content:
                                      "Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades",
                                    placement: "top"
                                  }
                                },
                                [_c("i", { staticClass: "fa fa-info-circle" })]
                              ),
                              _vm._v(" "),
                              _c(
                                "a",
                                {
                                  staticClass:
                                    "control-label font-weight-bold text-info",
                                  attrs: { href: "#" },
                                  on: { click: _vm.clickAddRow }
                                },
                                [
                                  _vm._v(
                                    "\n                                    [ + Nuevo]"
                                  )
                                ]
                              )
                            ],
                            1
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _vm.form.item_unit_types.length > 0
                        ? _c(
                            "div",
                            {
                              directives: [
                                {
                                  name: "show",
                                  rawName: "v-show",
                                  value: _vm.form.unit_type_id != "ZZ",
                                  expression: "form.unit_type_id != 'ZZ'"
                                }
                              ],
                              staticClass: "col-md-12"
                            },
                            [
                              _c("div", { staticClass: "table-responsive" }, [
                                _c("table", { staticClass: "table" }, [
                                  _c("thead", [
                                    _c("tr", [
                                      _c("th", { staticClass: "text-center" }, [
                                        _vm._v(
                                          "\n                                                Unidad\n                                            "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("th", { staticClass: "text-center" }, [
                                        _vm._v(
                                          "\n                                                Descripción\n                                            "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-center",
                                          attrs: { width: "13%" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                Cantidad\n                                                "
                                          ),
                                          _c(
                                            "el-tooltip",
                                            {
                                              staticClass: "item",
                                              attrs: {
                                                effect: "dark",
                                                content: "Cantidad de unidades",
                                                placement: "top"
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-info-circle"
                                              })
                                            ]
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-center",
                                          attrs: { width: "13%" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                Precio\n                                                "
                                          ),
                                          _c("br"),
                                          _vm._v(
                                            "\n                                                unitario\n                                            "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-center",
                                          attrs: { width: "13%" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                Total\n                                            "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c("th", { staticClass: "text-center" }, [
                                        _vm._v(
                                          "\n                                                Almacen\n                                            "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("th", [
                                        _vm._v("Max."),
                                        _c("br"),
                                        _vm._v("Cant.")
                                      ])
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "tbody",
                                    _vm._l(_vm.form.item_unit_types, function(
                                      row,
                                      index
                                    ) {
                                      return _c(
                                        "tr",
                                        { key: index },
                                        [
                                          row.id
                                            ? [
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          row.unit_type_id
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          row.description
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          row.quantity_unit
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "el-input",
                                                      {
                                                        on: {
                                                          input: function(
                                                            $event
                                                          ) {
                                                            return _vm.undToTotal(
                                                              index,
                                                              row.price2,
                                                              row.quantity_unit
                                                            )
                                                          }
                                                        },
                                                        model: {
                                                          value: row.price2,
                                                          callback: function(
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              row,
                                                              "price2",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "row.price2"
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "el-icon-edit-outline",
                                                          attrs: {
                                                            slot: "prefix"
                                                          },
                                                          slot: "prefix"
                                                        })
                                                      ]
                                                    )
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "el-input",
                                                      {
                                                        on: {
                                                          input: function(
                                                            $event
                                                          ) {
                                                            return _vm.totalToUnd(
                                                              index,
                                                              row.total,
                                                              row.quantity_unit
                                                            )
                                                          }
                                                        },
                                                        model: {
                                                          value: row.total,
                                                          callback: function(
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              row,
                                                              "total",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "row.total"
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "el-icon-edit-outline",
                                                          attrs: {
                                                            slot: "prefix"
                                                          },
                                                          slot: "prefix"
                                                        })
                                                      ]
                                                    )
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  [
                                                    _c(
                                                      "el-select",
                                                      {
                                                        attrs: {
                                                          clearable: ""
                                                        },
                                                        model: {
                                                          value:
                                                            row.warehouse_id,
                                                          callback: function(
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              row,
                                                              "warehouse_id",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "\n                                                            row.warehouse_id\n                                                        "
                                                        }
                                                      },
                                                      _vm._l(
                                                        _vm.warehouses,
                                                        function(w) {
                                                          return _c(
                                                            "el-option",
                                                            {
                                                              key: w.id,
                                                              attrs: {
                                                                value: w.id,
                                                                label:
                                                                  w.description
                                                              }
                                                            }
                                                          )
                                                        }
                                                      ),
                                                      1
                                                    )
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  [
                                                    _c("el-checkbox", {
                                                      on: {
                                                        change: function(
                                                          $event
                                                        ) {
                                                          return _vm.selectedMax(
                                                            index
                                                          )
                                                        }
                                                      },
                                                      model: {
                                                        value: row.selected,
                                                        callback: function(
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            row,
                                                            "selected",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "\n                                                            row.selected\n                                                        "
                                                      }
                                                    })
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "series-table-actions text-end"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn waves-effect waves-light btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            $event.preventDefault()
                                                            return _vm.clickDelete(
                                                              row.id
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              ]
                                            : [
                                                _c("td", [
                                                  _c(
                                                    "div",
                                                    {
                                                      staticClass: "form-group"
                                                    },
                                                    [
                                                      _c(
                                                        "el-select",
                                                        {
                                                          attrs: {
                                                            dusk:
                                                              "item_unit_type.unit_type_id"
                                                          },
                                                          model: {
                                                            value:
                                                              row.unit_type_id,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                row,
                                                                "unit_type_id",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "\n                                                                row.unit_type_id\n                                                            "
                                                          }
                                                        },
                                                        _vm._l(
                                                          _vm.unit_types,
                                                          function(option) {
                                                            return _c(
                                                              "el-option",
                                                              {
                                                                key: option.id,
                                                                attrs: {
                                                                  value:
                                                                    option.id,
                                                                  label:
                                                                    option.description
                                                                }
                                                              }
                                                            )
                                                          }
                                                        ),
                                                        1
                                                      )
                                                    ],
                                                    1
                                                  )
                                                ]),
                                                _vm._v(" "),
                                                _c("td", [
                                                  _c(
                                                    "div",
                                                    {
                                                      staticClass: "form-group"
                                                    },
                                                    [
                                                      _c(
                                                        "el-input",
                                                        {
                                                          model: {
                                                            value:
                                                              row.description,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                row,
                                                                "description",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "\n                                                                row.description\n                                                            "
                                                          }
                                                        },
                                                        [
                                                          _c("i", {
                                                            staticClass:
                                                              "el-icon-edit-outline",
                                                            attrs: {
                                                              slot: "prefix"
                                                            },
                                                            slot: "prefix"
                                                          })
                                                        ]
                                                      )
                                                    ],
                                                    1
                                                  )
                                                ]),
                                                _vm._v(" "),
                                                _c("td", [
                                                  _c(
                                                    "div",
                                                    {
                                                      staticClass: "form-group"
                                                    },
                                                    [
                                                      _c(
                                                        "el-input",
                                                        {
                                                          on: {
                                                            input: function(
                                                              $event
                                                            ) {
                                                              return _vm.undToTotal(
                                                                index,
                                                                row.price2,
                                                                row.quantity_unit
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              row.quantity_unit,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                row,
                                                                "quantity_unit",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "\n                                                                row.quantity_unit\n                                                            "
                                                          }
                                                        },
                                                        [
                                                          _c("i", {
                                                            staticClass:
                                                              "el-icon-edit-outline",
                                                            attrs: {
                                                              slot: "prefix"
                                                            },
                                                            slot: "prefix"
                                                          })
                                                        ]
                                                      )
                                                    ],
                                                    1
                                                  )
                                                ]),
                                                _vm._v(" "),
                                                _c("td", [
                                                  _c(
                                                    "div",
                                                    {
                                                      staticClass: "form-group"
                                                    },
                                                    [
                                                      _c(
                                                        "el-input",
                                                        {
                                                          on: {
                                                            input: function(
                                                              $event
                                                            ) {
                                                              return _vm.undToTotal(
                                                                index,
                                                                row.price2,
                                                                row.quantity_unit
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value: row.price2,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                row,
                                                                "price2",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "\n                                                                row.price2\n                                                            "
                                                          }
                                                        },
                                                        [
                                                          _c("i", {
                                                            staticClass:
                                                              "el-icon-edit-outline",
                                                            attrs: {
                                                              slot: "prefix"
                                                            },
                                                            slot: "prefix"
                                                          })
                                                        ]
                                                      )
                                                    ],
                                                    1
                                                  )
                                                ]),
                                                _vm._v(" "),
                                                _c("td", [
                                                  _c(
                                                    "div",
                                                    {
                                                      staticClass: "form-group"
                                                    },
                                                    [
                                                      _c(
                                                        "el-input",
                                                        {
                                                          on: {
                                                            input: function(
                                                              $event
                                                            ) {
                                                              return _vm.totalToUnd(
                                                                index,
                                                                row.total,
                                                                row.quantity_unit
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value: row.total,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                row,
                                                                "total",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "\n                                                                row.total\n                                                            "
                                                          }
                                                        },
                                                        [
                                                          _c("i", {
                                                            staticClass:
                                                              "el-icon-edit-outline",
                                                            attrs: {
                                                              slot: "prefix"
                                                            },
                                                            slot: "prefix"
                                                          })
                                                        ]
                                                      )
                                                    ],
                                                    1
                                                  )
                                                ]),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  [
                                                    _c(
                                                      "el-select",
                                                      {
                                                        attrs: {
                                                          clearable: ""
                                                        },
                                                        model: {
                                                          value:
                                                            row.warehouse_id,
                                                          callback: function(
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              row,
                                                              "warehouse_id",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "\n                                                            row.warehouse_id\n                                                        "
                                                        }
                                                      },
                                                      _vm._l(
                                                        _vm.warehouses,
                                                        function(w) {
                                                          return _c(
                                                            "el-option",
                                                            {
                                                              key: w.id,
                                                              attrs: {
                                                                value: w.id,
                                                                label:
                                                                  w.description
                                                              }
                                                            }
                                                          )
                                                        }
                                                      ),
                                                      1
                                                    )
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  [
                                                    _c("el-checkbox", {
                                                      on: {
                                                        change: function(
                                                          $event
                                                        ) {
                                                          return _vm.selectedMax(
                                                            index
                                                          )
                                                        }
                                                      },
                                                      model: {
                                                        value: row.selected,
                                                        callback: function(
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            row,
                                                            "selected",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "\n                                                            row.selected\n                                                        "
                                                      }
                                                    })
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "series-table-actions text-end"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn waves-effect waves-light btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            $event.preventDefault()
                                                            return _vm.clickCancel(
                                                              index
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              ]
                                        ],
                                        2
                                      )
                                    }),
                                    0
                                  )
                                ])
                              ])
                            ]
                          )
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("el-tab-pane", { attrs: { label: "Compras" } }, [
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "short-div col-md-8" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger":
                                _vm.errors.purchase_affectation_igv_type_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Tipo de afectación (Compra)")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                model: {
                                  value:
                                    _vm.form.purchase_affectation_igv_type_id,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.form,
                                      "purchase_affectation_igv_type_id",
                                      $$v
                                    )
                                  },
                                  expression:
                                    "\n                                        form.purchase_affectation_igv_type_id\n                                    "
                                }
                              },
                              _vm._l(_vm.affectation_igv_types, function(
                                option
                              ) {
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
                            _vm.errors.purchase_affectation_igv_type_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors
                                        .purchase_affectation_igv_type_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "short-div col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.purchase_unit_price
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Precio Unitario (Compra)")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: { dusk: "purchase_unit_price" },
                                on: {
                                  input:
                                    _vm.calculatePercentageOfProfitByPurchase
                                },
                                model: {
                                  value: _vm.form.purchase_unit_price,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.form,
                                      "purchase_unit_price",
                                      $$v
                                    )
                                  },
                                  expression: "form.purchase_unit_price"
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "el-icon-edit-outline",
                                  attrs: { slot: "prefix" },
                                  slot: "prefix"
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _vm.errors.purchase_unit_price
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.purchase_unit_price[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "short-div col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.percentage_of_profit
                            }
                          },
                          [
                            _c(
                              "label",
                              { staticClass: "control-label" },
                              [
                                _c("el-checkbox", {
                                  on: {
                                    change: _vm.changeEnabledPercentageOfProfit
                                  },
                                  model: {
                                    value: _vm.enabled_percentage_of_profit,
                                    callback: function($$v) {
                                      _vm.enabled_percentage_of_profit = $$v
                                    },
                                    expression:
                                      "\n                                            enabled_percentage_of_profit\n                                        "
                                  }
                                }),
                                _vm._v(
                                  "\n                                    Porcentaje de ganancia (%)\n                                "
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "el-input",
                              {
                                attrs: {
                                  disabled: !_vm.enabled_percentage_of_profit
                                },
                                on: {
                                  input:
                                    _vm.calculatePercentageOfProfitByPercentage
                                },
                                model: {
                                  value: _vm.form.percentage_of_profit,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.form,
                                      "percentage_of_profit",
                                      $$v
                                    )
                                  },
                                  expression: "form.percentage_of_profit"
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "el-icon-edit-outline",
                                  attrs: { slot: "prefix" },
                                  slot: "prefix"
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _vm.errors.percentage_of_profit
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.percentage_of_profit[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ])
                  ])
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-actions text-end pt-2 pb-2" },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.close()
                    }
                  }
                },
                [_vm._v("Cancelar")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: {
                    type: "primary",
                    "native-type": "submit",
                    loading: _vm.loading_submit
                  }
                },
                [_vm._v("Guardar")]
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("lots-form", {
        attrs: {
          showDialog: _vm.showDialogLots,
          stock: _vm.form.stock,
          recordId: _vm.recordId,
          lots: _vm.form.lots
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogLots = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogLots = $event
          },
          addRowLot: _vm.addRowLot
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
    require("vue-hot-reload-api")      .rerender("data-v-cd4ba31c", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-f9fd823e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/partials/lots.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: _vm.titleDialog,
        width: "40%",
        visible: _vm.showDialog,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "append-to-body": "",
        "show-close": false
      },
      on: { open: _vm.create }
    },
    [
      _c("div", { staticClass: "form-body" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-lg-12 col-md-12" }, [
            _c("table", { attrs: { width: "100%" } }, [
              _c("thead", [
                _c("tr", { attrs: { width: "100%" } }, [
                  _vm.lots.length > 0 ? _c("th", [_vm._v("Serie")]) : _vm._e(),
                  _vm._v(" "),
                  _vm.lots.length > 0 ? _c("th", [_vm._v("Estado")]) : _vm._e(),
                  _vm._v(" "),
                  _vm.lots.length > 0 ? _c("th", [_vm._v("Fecha")]) : _vm._e(),
                  _vm._v(" "),
                  _c("th", { attrs: { width: "15%" } }, [
                    _c(
                      "a",
                      {
                        staticClass: "text-center font-weight-bold text-info",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.clickAddLot.apply(null, arguments)
                          }
                        }
                      },
                      [_vm._v("[+ Agregar]")]
                    )
                  ])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.lots, function(row, index) {
                  return _c("tr", { key: index, attrs: { width: "100%" } }, [
                    _c("td", [
                      _c(
                        "div",
                        { staticClass: "form-group mb-2 mr-2" },
                        [
                          _c(
                            "el-input",
                            {
                              on: {
                                blur: function($event) {
                                  return _vm.duplicateSerie(row.series, index)
                                }
                              },
                              model: {
                                value: row.series,
                                callback: function($$v) {
                                  _vm.$set(row, "series", $$v)
                                },
                                expression: "row.series"
                              }
                            },
                            [
                              _c("i", {
                                staticClass: "el-icon-edit-outline",
                                attrs: { slot: "prefix" },
                                slot: "prefix"
                              })
>>>>>>> master
                            ]
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
<<<<<<< HEAD
                    _c("div", { staticClass: "row mt-2 p-2" }, [
                      _c("table", { staticClass: "table" }, [
                        _c("thead", [
                          _c("tr", [
                            _c("th", [_vm._v("#")]),
                            _vm._v(" "),
                            _c("th", [_vm._v("Nombre")]),
                            _vm._v(" "),
                            _c("th", [_vm._v("Documento")]),
                            _vm._v(" "),
                            _c("th")
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.children, function(child, idx) {
                            return _c("tr", { key: idx }, [
                              _c("td", [_vm._v(_vm._s(idx + 1))]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(child.name))]),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(child.number) +
                                    "\n\n                                        "
                                ),
                                _c("br"),
                                _vm._v(" "),
                                _c("small", [
                                  _vm._v(
                                    "\n                                            " +
                                      _vm._s(
                                        _vm.getDocumentType(
                                          child.identity_document_type_id
                                        )
                                      ) +
                                      "\n                                        "
                                  )
                                ])
                              ]),
                              _vm._v(" "),
                              _c(
                                "td",
                                [
                                  _c("el-button", {
                                    attrs: {
                                      type: "danger",
                                      size: "mini",
                                      icon: "el-icon-delete",
                                      circle: ""
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.deleteChild(child.number)
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
                      ])
                    ])
                  ])
                ]
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
          staticClass: "dialog-footer",
          attrs: { slot: "footer" },
          slot: "footer"
        },
        [
          _c("el-button", { on: { click: _vm.close } }, [_vm._v("Cancelar")]),
          _vm._v(" "),
          _c(
            "el-button",
            { attrs: { type: "primary" }, on: { click: _vm.sendData } },
=======
                    _c("td", [
                      _c(
                        "div",
                        { staticClass: "form-group mb-2 mr-2" },
                        [
                          _c(
                            "el-select",
                            {
                              model: {
                                value: row.state,
                                callback: function($$v) {
                                  _vm.$set(row, "state", $$v)
                                },
                                expression: "row.state"
                              }
                            },
                            _vm._l(_vm.states, function(option, index) {
                              return _c("el-option", {
                                key: index,
                                attrs: { value: option, label: option }
                              })
                            }),
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c(
                        "div",
                        { staticClass: "form-group mb-2 mr-2" },
                        [
                          _c("el-date-picker", {
                            attrs: {
                              type: "date",
                              "value-format": "yyyy-MM-dd",
                              clearable: false
                            },
                            model: {
                              value: row.date,
                              callback: function($$v) {
                                _vm.$set(row, "date", $$v)
                              },
                              expression: "row.date"
                            }
                          })
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticClass: "series-table-actions text-center" },
                      [
                        _c(
                          "button",
                          {
                            staticClass:
                              "btn waves-effect waves-light btn-sm btn-danger",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clickCancel(index)
                              }
                            }
                          },
                          [_c("i", { staticClass: "fa fa-trash" })]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("br")
                  ])
                }),
                0
              )
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "form-actions text-end pt-2 pb-2" },
        [
          _c(
            "el-button",
            {
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.clickCancelSubmit()
                }
              }
            },
            [_vm._v("Cancelar")]
          ),
          _vm._v(" "),
          _c(
            "el-button",
            { attrs: { type: "primary" }, on: { click: _vm.submit } },
>>>>>>> master
            [_vm._v("Guardar")]
          )
        ],
        1
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
<<<<<<< HEAD
    require("vue-hot-reload-api")      .rerender("data-v-bf046f30", module.exports)
=======
    require("vue-hot-reload-api")      .rerender("data-v-f9fd823e", module.exports)
>>>>>>> master
  }
}

/***/ }),

<<<<<<< HEAD
/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/College/Resources/assets/js/views/persons/form.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("6f8e682d", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./form.vue", function() {
     var newContent = require("!!../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-bf046f30\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./node_modules/vue-style-loader/lib/addStylesClient.js":
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__("./node_modules/vue-style-loader/lib/listToStyles.js")

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ "./node_modules/vue-style-loader/lib/listToStyles.js":
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}
=======
/***/ "./resources/js/views/items/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-cd4ba31c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/form.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
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
Component.options.__file = "resources/js/views/items/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cd4ba31c", Component.options)
  } else {
    hotAPI.reload("data-v-cd4ba31c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/items/partials/lots.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/partials/lots.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-f9fd823e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/partials/lots.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
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
Component.options.__file = "resources/js/views/items/partials/lots.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-f9fd823e", Component.options)
  } else {
    hotAPI.reload("data-v-f9fd823e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports
>>>>>>> master


/***/ })

});
<<<<<<< HEAD
=======
webpackJsonp([104],{"38N9":function(t,e,n){var a;window,a=function(){return function(t){var e={};function n(a){if(e[a])return e[a].exports;var r=e[a]={i:a,l:!1,exports:{}};return t[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=t,n.c=e,n.d=function(t,e,a){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)n.d(a,r,function(e){return t[e]}.bind(null,r));return a},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=0)}({"./src/index.js":function(t,e,n){"use strict";n.r(e);n("./src/sass/index.scss");var a=n("./src/js/init.js").default.init;"undefined"!=typeof window&&(window.printJS=a),e.default=a},"./src/js/browser.js":function(t,e,n){"use strict";n.r(e);var a={isFirefox:function(){return"undefined"!=typeof InstallTrigger},isIE:function(){return-1!==navigator.userAgent.indexOf("MSIE")||!!document.documentMode},isEdge:function(){return!a.isIE()&&!!window.StyleMedia},isChrome:function(){return!!(arguments.length>0&&void 0!==arguments[0]?arguments[0]:window).chrome},isSafari:function(){return Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0||-1!==navigator.userAgent.toLowerCase().indexOf("safari")},isIOSChrome:function(){return-1!==navigator.userAgent.toLowerCase().indexOf("crios")}};e.default=a},"./src/js/functions.js":function(t,e,n){"use strict";n.r(e),n.d(e,"addWrapper",function(){return s}),n.d(e,"capitalizePrint",function(){return i}),n.d(e,"collectStyles",function(){return c}),n.d(e,"addHeader",function(){return u}),n.d(e,"cleanUp",function(){return d}),n.d(e,"isRawHTML",function(){return m});var a=n("./src/js/modal.js"),r=n("./src/js/browser.js");function o(t){"@babel/helpers - typeof";return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function s(t,e){return'<div style="'+("font-family:"+e.font+" !important; font-size: "+e.font_size+" !important; width:100%;")+'">'+t+"</div>"}function i(t){return t.charAt(0).toUpperCase()+t.slice(1)}function c(t,e){for(var n="",a=(document.defaultView||window).getComputedStyle(t,""),r=0;r<a.length;r++)(-1!==e.targetStyles.indexOf("*")||-1!==e.targetStyle.indexOf(a[r])||l(e.targetStyles,a[r]))&&a.getPropertyValue(a[r])&&(n+=a[r]+":"+a.getPropertyValue(a[r])+";");return n+="max-width: "+e.maxWidth+"px !important; font-size: "+e.font_size+" !important;"}function l(t,e){for(var n=0;n<t.length;n++)if("object"===o(e)&&-1!==e.indexOf(t[n]))return!0;return!1}function u(t,e){var n=document.createElement("div");if(m(e.header))n.innerHTML=e.header;else{var a=document.createElement("h1"),r=document.createTextNode(e.header);a.appendChild(r),a.setAttribute("style",e.headerStyle),n.appendChild(a)}t.insertBefore(n,t.childNodes[0])}function d(t){t.showModal&&a.default.close(),t.onLoadingEnd&&t.onLoadingEnd(),(t.showModal||t.onLoadingStart)&&window.URL.revokeObjectURL(t.printable);var e="mouseover";(r.default.isChrome()||r.default.isFirefox())&&(e="focus");window.addEventListener(e,function n(){window.removeEventListener(e,n),t.onPrintDialogClose();var a=document.getElementById(t.frameId);a&&a.remove()})}function m(t){return new RegExp("<([A-Za-z][A-Za-z0-9]*)\\b[^>]*>(.*?)</\\1>").test(t)}},"./src/js/html.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/functions.js"),r=n("./src/js/print.js");function o(t){"@babel/helpers - typeof";return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}e.default={print:function(t,e){var n,s="object"===o(n=t.printable)&&n&&(n instanceof HTMLElement||1===n.nodeType)?t.printable:document.getElementById(t.printable);s?(t.printableElement=function t(e,n){var r=e.cloneNode();var o=Array.prototype.slice.call(e.childNodes);for(var s=0;s<o.length;s++)if(-1===n.ignoreElements.indexOf(o[s].id)){var i=t(o[s],n);r.appendChild(i)}n.scanStyles&&1===e.nodeType&&r.setAttribute("style",Object(a.collectStyles)(e,n));switch(e.tagName){case"SELECT":r.value=e.value;break;case"CANVAS":r.getContext("2d").drawImage(e,0,0)}return r}(s,t),t.header&&Object(a.addHeader)(t.printableElement,t),r.default.send(t,e)):window.console.error("Invalid HTML element id: "+t.printable)}}},"./src/js/image.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/functions.js"),r=n("./src/js/print.js"),o=n("./src/js/browser.js");e.default={print:function(t,e){t.printable.constructor!==Array&&(t.printable=[t.printable]),t.printableElement=document.createElement("div"),t.printable.forEach(function(e){var n=document.createElement("img");if(n.setAttribute("style",t.imageStyle),n.src=e,o.default.isFirefox()){var a=n.src;n.src=a}var r=document.createElement("div");r.appendChild(n),t.printableElement.appendChild(r)}),t.header&&Object(a.addHeader)(t.printableElement,t),r.default.send(t,e)}}},"./src/js/init.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/browser.js"),r=n("./src/js/modal.js"),o=n("./src/js/pdf.js"),s=n("./src/js/html.js"),i=n("./src/js/raw-html.js"),c=n("./src/js/image.js"),l=n("./src/js/json.js");function u(t){"@babel/helpers - typeof";return(u="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var d=["pdf","html","image","json","raw-html"];e.default={init:function(){var t={printable:null,fallbackPrintable:null,type:"pdf",header:null,headerStyle:"font-weight: 300;",maxWidth:800,properties:null,gridHeaderStyle:"font-weight: bold; padding: 5px; border: 1px solid #dddddd;",gridStyle:"border: 1px solid lightgray; margin-bottom: -1px;",showModal:!1,onError:function(t){throw t},onLoadingStart:null,onLoadingEnd:null,onPrintDialogClose:function(){},onIncompatibleBrowser:function(){},modalMessage:"Retrieving Document...",frameId:"printJS",printableElement:null,documentTitle:"Document",targetStyle:["clear","display","width","min-width","height","min-height","max-height"],targetStyles:["border","box","break","text-decoration"],ignoreElements:[],repeatTableHeader:!0,css:null,style:null,scanStyles:!0,base64:!1,onPdfOpen:null,font:"TimesNewRoman",font_size:"12pt",honorMarginPadding:!0,honorColor:!1,imageStyle:"max-width: 100%;"},e=arguments[0];if(void 0===e)throw new Error("printJS expects at least 1 attribute.");switch(u(e)){case"string":t.printable=encodeURI(e),t.fallbackPrintable=t.printable,t.type=arguments[1]||t.type;break;case"object":for(var n in t.printable=e.printable,t.fallbackPrintable=void 0!==e.fallbackPrintable?e.fallbackPrintable:t.printable,t.fallbackPrintable=t.base64?"data:application/pdf;base64,".concat(t.fallbackPrintable):t.fallbackPrintable,t)"printable"!==n&&"fallbackPrintable"!==n&&(t[n]=void 0!==e[n]?e[n]:t[n]);break;default:throw new Error('Unexpected argument type! Expected "string" or "object", got '+u(e))}if(!t.printable)throw new Error("Missing printable information.");if(!t.type||"string"!=typeof t.type||-1===d.indexOf(t.type.toLowerCase()))throw new Error("Invalid print type. Available types are: pdf, html, image and json.");t.showModal&&r.default.show(t),t.onLoadingStart&&t.onLoadingStart();var m=document.getElementById(t.frameId);m&&m.parentNode.removeChild(m);var f=document.createElement("iframe");switch(a.default.isFirefox()?f.setAttribute("style","width: 1px; height: 100px; position: fixed; left: 0; top: 0; opacity: 0; border-width: 0; margin: 0; padding: 0"):f.setAttribute("style","visibility: hidden; height: 0; width: 0; position: absolute; border: 0"),f.setAttribute("id",t.frameId),"pdf"!==t.type&&(f.srcdoc="<html><head><title>"+t.documentTitle+"</title>",t.css&&(Array.isArray(t.css)||(t.css=[t.css]),t.css.forEach(function(t){f.srcdoc+='<link rel="stylesheet" href="'+t+'">'})),f.srcdoc+="</head><body></body></html>"),t.type){case"pdf":if(a.default.isIE())try{console.info("Print.js doesn't support PDF printing in Internet Explorer."),window.open(t.fallbackPrintable,"_blank").focus(),t.onIncompatibleBrowser()}catch(e){t.onError(e)}finally{t.showModal&&r.default.close(),t.onLoadingEnd&&t.onLoadingEnd()}else o.default.print(t,f);break;case"image":c.default.print(t,f);break;case"html":s.default.print(t,f);break;case"raw-html":i.default.print(t,f);break;case"json":l.default.print(t,f)}}}},"./src/js/json.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/functions.js"),r=n("./src/js/print.js");function o(t){"@babel/helpers - typeof";return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}e.default={print:function(t,e){if("object"!==o(t.printable))throw new Error("Invalid javascript data object (JSON).");if("boolean"!=typeof t.repeatTableHeader)throw new Error("Invalid value for repeatTableHeader attribute (JSON).");if(!t.properties||!Array.isArray(t.properties))throw new Error("Invalid properties array for your JSON data.");t.properties=t.properties.map(function(e){return{field:"object"===o(e)?e.field:e,displayName:"object"===o(e)?e.displayName:e,columnSize:"object"===o(e)&&e.columnSize?e.columnSize+";":100/t.properties.length+"%;"}}),t.printableElement=document.createElement("div"),t.header&&Object(a.addHeader)(t.printableElement,t),t.printableElement.innerHTML+=function(t){var e=t.printable,n=t.properties,r='<table style="border-collapse: collapse; width: 100%;">';t.repeatTableHeader&&(r+="<thead>");r+="<tr>";for(var o=0;o<n.length;o++)r+='<th style="width:'+n[o].columnSize+";"+t.gridHeaderStyle+'">'+Object(a.capitalizePrint)(n[o].displayName)+"</th>";r+="</tr>",t.repeatTableHeader&&(r+="</thead>");r+="<tbody>";for(var s=0;s<e.length;s++){r+="<tr>";for(var i=0;i<n.length;i++){var c=e[s],l=n[i].field.split(".");if(l.length>1)for(var u=0;u<l.length;u++)c=c[l[u]];else c=c[n[i].field];r+='<td style="width:'+n[i].columnSize+t.gridStyle+'">'+c+"</td>"}r+="</tr>"}return r+="</tbody></table>"}(t),r.default.send(t,e)}}},"./src/js/modal.js":function(t,e,n){"use strict";n.r(e);var a={show:function(t){var e=document.createElement("div");e.setAttribute("style","font-family:sans-serif; display:table; text-align:center; font-weight:300; font-size:30px; left:0; top:0;position:fixed; z-index: 9990;color: #0460B5; width: 100%; height: 100%; background-color:rgba(255,255,255,.9);transition: opacity .3s ease;"),e.setAttribute("id","printJS-Modal");var n=document.createElement("div");n.setAttribute("style","display:table-cell; vertical-align:middle; padding-bottom:100px;");var r=document.createElement("div");r.setAttribute("class","printClose"),r.setAttribute("id","printClose"),n.appendChild(r);var o=document.createElement("span");o.setAttribute("class","printSpinner"),n.appendChild(o);var s=document.createTextNode(t.modalMessage);n.appendChild(s),e.appendChild(n),document.getElementsByTagName("body")[0].appendChild(e),document.getElementById("printClose").addEventListener("click",function(){a.close()})},close:function(){var t=document.getElementById("printJS-Modal");t&&t.parentNode.removeChild(t)}};e.default=a},"./src/js/pdf.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/print.js"),r=n("./src/js/functions.js");function o(t,e,n){var r=new window.Blob([n],{type:"application/pdf"});r=window.URL.createObjectURL(r),e.setAttribute("src",r),a.default.send(t,e)}e.default={print:function(t,e){if(t.base64){var n=Uint8Array.from(atob(t.printable),function(t){return t.charCodeAt(0)});o(t,e,n)}else{t.printable=/^(blob|http|\/\/)/i.test(t.printable)?t.printable:window.location.origin+("/"!==t.printable.charAt(0)?"/"+t.printable:t.printable);var a=new window.XMLHttpRequest;a.responseType="arraybuffer",a.addEventListener("error",function(){Object(r.cleanUp)(t),t.onError(a.statusText,a)}),a.addEventListener("load",function(){if(-1===[200,201].indexOf(a.status))return Object(r.cleanUp)(t),void t.onError(a.statusText,a);o(t,e,a.response)}),a.open("GET",t.printable,!0),a.send()}}}},"./src/js/print.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/browser.js"),r=n("./src/js/functions.js"),o={send:function(t,e){document.getElementsByTagName("body")[0].appendChild(e);var n=document.getElementById(t.frameId);n.onload=function(){if("pdf"!==t.type){var e=n.contentWindow||n.contentDocument;if(e.document&&(e=e.document),e.body.appendChild(t.printableElement),"pdf"!==t.type&&t.style){var r=document.createElement("style");r.innerHTML=t.style,e.head.appendChild(r)}var o=e.getElementsByTagName("img");o.length>0?function(t){var e=t.map(function(t){if(t.src&&t.src!==window.location.href)return function(t){return new Promise(function(e){!function n(){t&&void 0!==t.naturalWidth&&0!==t.naturalWidth&&t.complete?e():setTimeout(n,500)}()})}(t)});return Promise.all(e)}(Array.from(o)).then(function(){return s(n,t)}):s(n,t)}else a.default.isFirefox()?setTimeout(function(){return s(n,t)},1e3):s(n,t)}}};function s(t,e){try{if(t.focus(),a.default.isEdge()||a.default.isIE())try{t.contentWindow.document.execCommand("print",!1,null)}catch(e){t.contentWindow.print()}else t.contentWindow.print()}catch(t){e.onError(t)}finally{a.default.isFirefox()&&(t.style.visibility="hidden",t.style.left="-1px"),Object(r.cleanUp)(e)}}e.default=o},"./src/js/raw-html.js":function(t,e,n){"use strict";n.r(e);var a=n("./src/js/print.js");e.default={print:function(t,e){t.printableElement=document.createElement("div"),t.printableElement.setAttribute("style","width:100%"),t.printableElement.innerHTML=t.printable,a.default.send(t,e)}}},"./src/sass/index.scss":function(t,e,n){},0:function(t,e,n){t.exports=n("./src/index.js")}}).default},t.exports=a()},AhJO:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{staticClass:"algunaClase",attrs:{visible:t.is_payment,"close-on-click-modal":!1,"close-on-press-escape":!1,"modal-append-to-body":!0,"show-close":!1,"append-to-body":!0,width:"770px",top:"2vh",title:"MODULO DE COBRO "+(t.variation?"- Variación":"")},on:{open:function(e){return t.date_of_issue()}}},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:" mb-0"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading_submit,expression:"loading_submit"}],staticClass:"pt-1"},[n("div",{staticClass:"row pt-2"},[n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:"card bg-light"},[n("div",{staticClass:"row "},[n("div",{staticClass:"  col-md-6 col-lg-5 col-sm-6"},[n("label",{staticClass:"control-label"},[t._v("Comprobante de Pago\n                                    ")]),t._v(" "),n("div",{staticClass:"form-group"},[n("el-radio-group",{attrs:{size:"small"},on:{change:function(e){t.date_of_issue(),t.filterSeries()}},model:{value:t.form.document_type_id,callback:function(e){t.$set(t.form,"document_type_id",e)},expression:"form.document_type_id"}},[t.isInterno?t._e():[n("el-radio-button",{attrs:{label:"01"}},[t._v("FACTURA\n                                                ")]),t._v(" "),n("el-radio-button",{attrs:{label:"03"}},[t._v("\n                                                    BOLETA\n                                                ")])],t._v(" "),t.variation?t._e():n("el-radio-button",{attrs:{label:"80"}},[t._v("\n                                                N. VENTA\n                                            ")])],2)],1)]),t._v(" "),n("div",{staticClass:"col-6 col-md-3 col-lg-3 col-xl-3"},[n("label",{staticClass:"control-label"},[t._v("\n                                        Serie\n                                    ")]),t._v(" "),n("div",{staticClass:"form-group"},[n("el-select",{staticClass:"w-100",model:{value:t.form.series_id,callback:function(e){t.$set(t.form,"series_id",e)},expression:"form.series_id"}},t._l(t.series,function(t){return n("el-option",{key:t.id,staticStyle:{"z-index":"2000 !important"},attrs:{label:t.full_number,value:t.id}})}),1)],1)]),t._v(" "),n("div",{staticClass:"col-6 col-md-4 col-lg-4 "},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"control-label"},[t._v("Fecha de Emisión")]),t._v(" "),n("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date","value-format":"yyyy-MM-dd",clearable:!1,format:"dd-MM-yyyy",readonly:"","picker-options":t.datEmision},model:{value:t.form.date_of_issue,callback:function(e){t.$set(t.form,"date_of_issue",e)},expression:"form.date_of_issue"}})],1)])]),t._v(" "),n("div",{staticClass:"row "},[n("div",{staticClass:"col-lg-6 "},[n("div",{staticClass:"form-group"},[[n("div",{staticClass:"el-input el-input-group col-md-6 ",staticStyle:{"margin-bottom":"3px"}},[n("label",{staticClass:"control-label",staticStyle:{"margin-right":"3px"}},[t._v("Seleccion de\n                                                    Cliente")]),t._v(" "),n("el-button",{attrs:{disabled:!t.value},on:{click:function(e){t.showDialogNewPerson=!0}}},[t._v("Editar\n                                                    cliente")]),t._v(" "),n("el-button",{on:{click:t.createClient}},[t._v("Nuevo\n                                                    cliente")])],1)]],2)]),t._v(" "),n("div",{staticClass:"col-12 col-sm-8 col-lg-6"},[n("el-select",{ref:"select_person",staticClass:"col-md-6",attrs:{filterable:"",clearable:"",size:"small",placeholder:"Cliente",disabled:t.loading},on:{change:t.changeCustomer},nativeOn:{keyup:[function(e){return t.keyupCustomer.apply(null,arguments)},function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.keyupCustomer()}]},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.customers,function(t){return n("el-option",{key:t.id,attrs:{label:t.description,value:t.id}})}),1)],1)]),t._v(" "),n("div",{staticClass:"row col-lg-6 col-xl-12"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"control-label"},[t._v("Observaciones")]),t._v(" "),n("el-input",{attrs:{type:"textarea",rows:2},model:{value:t.form.observation,callback:function(e){t.$set(t.form,"observation",e)},expression:"form.observation"}})],1)])])])]),t._v(" "),n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:" mb-2 "},[n("div",{staticClass:" text-center text-dark card  bg-light  "},[n("div",{staticClass:"row"},[n("div",{staticClass:"  col-lg-12 "},[n("div",{staticClass:" align-items-start "},[n("label",{staticClass:"control-label"},[t._v("Medios de Pago")]),t._v(" "),n("label",{staticClass:"text-primary control-label",attrs:{role:"button"}})]),t._v(" "),n("div",{staticClass:"radio-tile-group2 flex-wrap"},[n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"cash",type:"radio",name:"method_payment",value:"01"},domProps:{checked:t._q(t.method_payments,"01")},on:{change:[function(e){t.method_payments="01"},function(e){return t.method_payment("Efectivo")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonEfectivo.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon walk-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"cash"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"culqui",type:"radio",name:"method_payment",value:"02"},domProps:{checked:t._q(t.method_payments,"02")},on:{change:[function(e){t.method_payments="02"},function(e){return t.method_payment("Culqui")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/CulquiIcon.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"05"},domProps:{checked:t._q(t.method_payments,"05")},on:{change:[function(e){t.method_payments="05"},function(e){return t.method_payment("TARJETA: IZYPAY")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonIzipay.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"06"},domProps:{checked:t._q(t.method_payments,"06")},on:{change:[function(e){t.method_payments="06"},function(e){return t.method_payment("TARJETA: NIUBIZ")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/botonNiubiz.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"yape",type:"radio",name:"method_payment",value:"03"},domProps:{checked:t._q(t.method_payments,"03")},on:{change:[function(e){t.method_payments="03"},function(e){return t.method_payment("Yape")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.method_payments,expression:"method_payments"}],staticClass:"radio-button2",attrs:{id:"plin",type:"radio",name:"method_payment",value:"04"},domProps:{checked:t._q(t.method_payments,"04")},on:{change:[function(e){t.method_payments="04"},function(e){return t.method_payment("PLIN")}]}}),t._v(" "),n("div",{staticClass:"radio-tile2",staticStyle:{"background-image":"url('../../images/plin-logo-0C4106153C-seeklogo.com.png')","background-size":"contain","background-repeat":"no-repeat"}},[n("div",{staticClass:"icon bike-icon"}),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}})])])]),t._v(" "),n("div",{staticClass:"row col-md-12"},[n("div",{staticClass:"row"},[n("label",{staticClass:"control-label text-center"},[t._v("Emision de\n                                                comprobante")])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-2 col-md-5 col-xl-6"},[n("label",{staticClass:"control-label text-left  d-flex align-items-start justify-content-start"},[t._v("\n                                                    Ingrese Nro Celular\n                                                ")]),t._v(" "),n("el-input",{model:{value:t.form.customer_telephone,callback:function(e){t.$set(t.form,"customer_telephone",e)},expression:"\n                                                        form.customer_telephone\n                                                    "}},[n("template",{slot:"prepend"},[n("i",{staticClass:"fab fa-whatsapp fa-2x"})])],2)],1),t._v(" "),n("div",{staticClass:"radio-tile-group2 col-lg-6 col-xl-6 d ",staticStyle:{"padding-top":"12px"}},[n("div",{staticClass:"input-container2 border rounded-sm col-lg-3"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.printerOn,expression:"printerOn"}],staticClass:"radio-button2",attrs:{id:"imprimir",type:"radio",name:"imprimir",value:"1"},domProps:{checked:t._q(t.printerOn,"1")},on:{change:function(e){t.printerOn="1"}}}),t._v(" "),n("div",{staticClass:"radio-tile2"},[n("div",{staticClass:"icon walk-icon"},[n("i",{staticClass:"fa fa-print"})]),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"cash"}},[t._v("Imprimir")])])]),t._v(" "),n("div",{staticClass:"input-container2 border rounded-sm col-lg-3"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.printerOn,expression:"printerOn"}],staticClass:"radio-button2",attrs:{id:"noimprimir",type:"radio",name:"noimprimir",value:"0"},domProps:{checked:t._q(t.printerOn,"0")},on:{change:function(e){t.printerOn="0"}}}),t._v(" "),n("div",{staticClass:"radio-tile2"},[n("div",{staticClass:"icon bike-icon"},[n("i",{staticClass:"fa fa-print"})]),t._v(" "),n("label",{staticClass:"radio-tile-label2",attrs:{for:"Tarjeta"}},[t._v("No\n                                                            Imprimir")])])])])])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-8  d-flex flex-row align-items-end"}),t._v(" "),n("div",{staticClass:"d-flex flex-column"})]),t._v(" "),n("div",{staticClass:"row d-flex justify-content-start"},[0!=t.currentPayments.length?n("table",{staticClass:"table"},[n("thead",[n("tr",[n("th",{staticClass:"text-left",attrs:{colspan:"4"}},[t._v("\n                                                        Pagos\n                                                    ")])])]),t._v(" "),n("tbody",t._l(t.currentPayments,function(e,a){return n("tr",{key:a},[n("td",[t._v(t._s(a+1))]),t._v(" "),n("td",[t._v("\n                                                        "+t._s(e.method)+"\n                                                    ")]),t._v(" "),n("td",[n("strong",[t._v(t._s(e.amount))])]),t._v(" "),n("td",[n("label",{staticClass:"text-danger",attrs:{for:"",role:"button"},on:{click:function(n){return t.removePayment(e.id)}}},[n("i",{staticClass:"fa fa-trash"})])])])}),0)]):t._e()])]),t._v(" "),n("div",{staticClass:" card  bg-light col-lg-12  "})])])]),t._v(" "),n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"mb-2"},[n("div",{staticClass:" card  bg-light "},[n("div",{staticClass:"row"},[n("div",{staticClass:" col-xl-4",class:{"has-danger":t.form.difference<0},staticStyle:{"margin-top":"10px","padding-top":"5px"}},[n("label",{staticClass:"control-label h1"},[t._v("Total a cobrar: ")]),n("br"),t._v(" "),n("span",{staticClass:"control-label font-weight-semibold text-center h3"},[t._v("\n                                            S/ "+t._s(" "+t.form.total)+"\n                                        ")])]),t._v(" "),"01"==t.form_payment.payment_method_type_id?n("div",{staticClass:"col-xl-8"},[n("div",{staticClass:"btn-group btn-group-square m-0 flex-wrap justify-content-around",staticStyle:{"padding-top":"12px"},attrs:{role:"group"}},[n("label",{staticClass:"control-label"},[t._v("Ingrese monto")]),t._v(" "),n("div",{staticClass:"row col-12"},[n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(10)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"10\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(20)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"20\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(50)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"50\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(100)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"100\n                                                    ")])]),t._v(" "),n("div",{staticClass:"col-2 col-md-2  col-xl-2"},[n("button",{staticClass:"btn btn-outline-primary btn_responsive m-2",on:{click:function(e){return t.setAmountCash(200)}}},[t._v("\n                                                        "+t._s(t.currencyTypeActive.symbol)+"200\n                                                    ")])])]),t._v(" "),n("div",{staticClass:"row col-xl-12 col-12"},[n("div",{staticClass:"col-xl-6 col-3"},[n("el-input",{ref:"enter_amount",attrs:{id:"inputTotal"},on:{blur:function(e){return t.diferen()},input:function(e){return t.enterAmount()}},nativeOn:{keyup:function(e){if(!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter"))return null;t.sendPayment(),t.inputAmount(t.form.enter_amount)}},model:{value:t.form.enter_amount,callback:function(e){t.$set(t.form,"enter_amount",e)},expression:"\n                                                            form.enter_amount\n                                                        "}},[n("template",{slot:"prepend"},[t._v(t._s(t.currencyTypeActive.symbol))])],2)],1),t._v(" "),n("div",{staticClass:"m-2 col-xl-2 col-2"},[n("el-button",{attrs:{type:"primary"},on:{click:t.addPayment}},[t._v("Agregar")])],1),t._v(" "),n("div",{staticClass:"m-2 col-xl-3 col-3 "},[n("el-button",{attrs:{type:"success"},on:{click:function(e){t.showSplitPayment=!0}}},[t._v("Dividir\n                                                        pago")])],1)])])]):t._e(),t._v(" "),n("div",{staticClass:" row col-xl-4"},[n("div",{staticClass:"col-xl-5",staticStyle:{"margin-bottom":"10px"}})])]),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-xl-3"}),t._v(" "),n("div",{staticClass:"col-xl-5"}),t._v(" "),n("div",{staticClass:"col-xl-4"},[n("div",{staticClass:"form-group d-flex flex-row align-items-end",class:{"has-danger":t.form.difference<0}},[n("label",{staticClass:"control-label display-4",domProps:{textContent:t._s(t.form.difference<0?"Faltante: ":"Vuelto: ")}}),t._v(" "),n("span",{staticClass:"control-label font-weight-semibold text-center display-3 "},[t._v("\n                                                "+t._s(t.currencyTypeActive.symbol)+t._s(t.form.difference.toFixed(2)))])])])])])])])])]),t._v(" "),0!=t.splitPayments.length?n("div",{staticClass:"row m-1 p-2  bg-light rounded"},[n("span",{staticStyle:{"margin-bottom":"5px"}},[t._v("Pagos divididos")]),t._v(" "),n("div",{staticClass:"d-flex flex-wrap "},t._l(t.splitPayments,function(e,a){return n("div",{key:a,staticClass:"col-2"},[t._v("\n                        Pago "+t._s(a+1)+":\n                        "),n("strong",[t._v("S/. "+t._s(e.amount))])])}),0)]):t._e(),t._v(" "),0!=t.splitProducts.length?n("div",{staticClass:"row m-1 p-2  bg-light rounded"},[n("span",{staticStyle:{"margin-bottom":"5px"}},[t._v("Pagos divididos por producto")]),t._v(" "),n("div",{staticClass:"d-flex flex-wrap "},t._l(t.splitProducts,function(e,a){return n("div",{key:a,staticClass:"col-3 m-1"},[e.products&&e.products.length>0?n("table",{staticClass:"col-12"},[n("thead",[n("tr",{class:"bg-primary text-white border rounded-top",attrs:{role:"button"},on:{click:function(e){return t.selectAccount(a)}}},[n("th",{staticClass:"text-center",attrs:{colspan:"3"}},[n("b",[t._v(" CUENTA "+t._s(a+1)+" ")])])])]),t._v(" "),e.products&&e.products.length>0?n("tbody",{staticClass:"border rounded-top "},[t._l(e.products,function(e,a){return n("tr",{key:a},[n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.quantity)+"\n                                        ")])]),t._v(" "),n("td",[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.description)+"\n                                        ")])]),t._v(" "),n("td",{staticStyle:{"text-align":"right"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            "+t._s(e.price*e.quantity)+"\n                                        ")])])])}),t._v(" "),n("tr",[n("td",{staticClass:"text-muted text-small",staticStyle:{"text-align":"right"},attrs:{colspan:"2"}},[n("b",[t._v(" Total")])]),t._v(" "),n("td",{staticClass:"text-muted text-small"},[t._v("\n                                        S/.\n                                        "+t._s(t.totalItemSelected(e.products))+"\n                                    ")])])],2):n("tbody",{staticClass:"border"},[n("tr",[n("td",{staticClass:"text-center",attrs:{colspan:"3"}},[n("h3",{staticClass:"text-muted text-small"},[t._v("\n                                            Sin productos seleccionados\n                                        ")])])])])]):t._e()])}),0)]):t._e(),t._v(" "),n("div",{staticClass:"p-3"},[n("div",{staticClass:"row "},[n("div",{staticClass:"col-lg-4"},[n("div",{staticClass:"btn-group btn-group-square",attrs:{role:"group"}},[n("button",{staticClass:"btn btn-block btn-primary",attrs:{disabled:t.button_payment},on:{click:t.sendPayment}},[n("i",{staticClass:"fas fa-money-bill-alt"}),t._v("\n                                PAGAR\n                            ")]),t._v(" "),n("button",{staticClass:"btn btn-block btn-dark",on:{click:function(e){return t.back(!1)}}},[n("i",{staticClass:"fa fa-reply"}),t._v(" Cerrar\n                            ")])])])])])]),t._v(" "),n("multiple-payment-form",{attrs:{showDialog:t.showDialogMultiplePayment,payments:t.payments},on:{"update:showDialog":function(e){t.showDialogMultiplePayment=e},"update:show-dialog":function(e){t.showDialogMultiplePayment=e},add:t.addRow}}),t._v(" "),n("card-brands-form",{attrs:{showDialog:t.showDialogNewCardBrand,external:!0,recordId:null},on:{"update:showDialog":function(e){t.showDialogNewCardBrand=e},"update:show-dialog":function(e){t.showDialogNewCardBrand=e}}}),t._v(" "),n("person-form",{attrs:{showDialog:t.showDialogNewPerson,type:"customers",input_person:t.input_person,external:!0,user_id:t.form.user_id,document_type_id:t.form.document_type_id,recordId:t.form.customer_id},on:{"update:showDialog":function(e){t.showDialogNewPerson=e},"update:show-dialog":function(e){t.showDialogNewPerson=e},"update:user_id":function(e){return t.$set(t.form,"user_id",e)},add_customer:t.add_customer}}),t._v(" "),n("show-split-payment-form",{attrs:{orden_items:t.orden_items,total:t.form.total,showSplitPayment:t.showSplitPayment},on:{receivePayments:t.receivePayments,receiveProducts:t.receiveProducts,"update:showSplitPayment":function(e){t.showSplitPayment=e},"update:show-split-payment":function(e){t.showSplitPayment=e}}})],1)])},staticRenderFns:[]}},E8J9:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),r=n.n(a),o=n("M4fF"),s=n.n(o),i=n("38N9");n.n(i);function c(t){return function(t){if(Array.isArray(t))return d(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||u(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function l(t,e){var n="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!n){if(Array.isArray(t)||(n=u(t))||e&&t&&"number"==typeof t.length){n&&(t=n);var a=0,r=function(){};return{s:r,n:function(){return a>=t.length?{done:!0}:{done:!1,value:t[a++]}},e:function(t){throw t},f:r}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,s=!0,i=!1;return{s:function(){n=n.call(t)},n:function(){var t=n.next();return s=t.done,t},e:function(t){i=!0,o=t},f:function(){try{s||null==n.return||n.return()}finally{if(i)throw o}}}}function u(t,e){if(t){if("string"==typeof t)return d(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);return"Object"===n&&t.constructor&&(n=t.constructor.name),"Map"===n||"Set"===n?Array.from(t):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?d(t,e):void 0}}function d(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,a=new Array(e);n<e;n++)a[n]=t[n];return a}function m(t,e,n,a,r,o,s){try{var i=t[o](s),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,r)}function f(t){return function(){var e=this,n=arguments;return new Promise(function(a,r){var o=t.apply(e,n);function s(t){m(o,a,r,s,i,"next",t)}function i(t){m(o,a,r,s,i,"throw",t)}s(void 0)})}}e.default={components:{CardBrandsForm:function(){return n.e(111).then(n.bind(null,"c39N"))},MultiplePaymentForm:function(){return n.e(119).then(n.bind(null,"p40F"))},PersonForm:function(){return n.e(98).then(n.bind(null,"N7nD"))},ShowSplitPaymentForm:function(){return n.e(114).then(n.bind(null,"s3Ks"))}},props:["customer_default","customer_variation","variation","establishments","formVariation","documentsType","orden_items","cash_id","form","exchangeRateSale","is_payment","soapCompany","direct_printing","auth_login","payments","configuration","idOrden","company","desarrollador","percentage_igv","all_series","all_customers","personalWhatsapp"],watch:{all_customers:function(t,e){this.customers=t.filter(function(t){return"88888888"!=t.number})}},data:function(){return{started:!0,refCustomer:null,currentDocumentsType:[],time:null,splitPayments:[],splitProducts:[],isInterno:!1,showSplitPayment:!1,currencyTypeActive:{symbol:"S/ "},currentPayments:[],input_person:{},customer:null,value:null,paymentsValue:{"01":"Efectivo","02":"Culqui","03":"Yape","04":"PLIN","05":"TARJETA: IZYPAY","06":"TARJETA: NIUBIZ"},last_number:{},showDialogNewPerson:!1,loading:!1,enabled_discount:!1,discount_amount:0,loading_submit:!1,showDialogOptions:!1,showDialogMultiplePayment:!1,showDialogSaleNote:!1,showDialogNewCardBrand:!1,documentNewId:null,saleNotesNewId:null,resource_options:null,has_card:!1,method_payments:"01",number:null,resource:"pos",resource_documents:"documents",resource_payments:"document_payments",amount:0,printerOn:0,button_payment:!1,input_item:"",form_payment:{},series:[],cards_brand:[],cancel:!1,form_cash_document:{},statusDocument:{},payment_method_types:[],last_date:null,customers:[],datEmision:{disabledDate:function(t){return t.getTime()>moment()}},activeColo:"black"}},created:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,t.currentDocumentsType=t.documentsType,t.form.identity_document_type_id=t.currentDocumentsType[0].id,t.form.customer_id=t.establishments.customer_id,t.value=t.establishments.customer_id,t.isInterno="03"==t.company.soap_type_id,e.next=8,t.date_of_issue();case 8:return e.next=10,t.getLastNumbersDocument();case 10:return e.next=12,t.initFormPayment();case 12:return e.next=14,t.setInitialAmount();case 14:return t.$eventHub.$on("reloadDataCardBrands",function(e){t.reloadDataCardBrands(e)}),e.next=17,t.$eventHub.$on("reloadDataPersons",function(e){t.reloadDataCustomers(e)});case 17:return e.next=19,t.getFormPosLocalStorage();case 19:qz.security.setCertificatePromise(function(e,n){t.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}),qz.security.setSignaturePromise(function(e){return function(n,a){t.$http.post("/api/qz/signing",{request:e}).then(function(t){n(t.data)}).catch(function(t){a(t.data)})}}),t.setAmountCash(t.form.total),t.filterSeries(),t.loading=!1;case 24:case"end":return e.stop()}},e)}))()},mounted:function(){},methods:{existNumber:function(){var t=this.form.customer_telephone;return!!t.startsWith("9")&&(9==t.length&&!isNaN(Number(t)))},createClient:function(){this.value=null,this.form.document_type_id,this.form.customer_id=null,this.showDialogNewPerson=!0},reloadDataCustomers:function(t){var e=this;return f(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:e.$http.get("/pos/table/customers").then(function(){var n=f(r.a.mark(function n(a){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,e.$emit("update:all_customers",a.data);case 2:e.value=t,e.form.customer_id=t,e.changeCustomer();case 5:case"end":return n.stop()}},n)}));return function(t){return n.apply(this,arguments)}}());case 1:case"end":return n.stop()}},n)}))()},totalItemSelected:function(t){var e=0;return t.forEach(function(t){e+=t.quantity*t.price}),s.a.round(e,2)},receivePayments:function(t){this.splitPayments=t},receiveProducts:function(t){this.splitProducts=t},removePayment:function(t){this.currentPayments=this.currentPayments.filter(function(e){return e.id!=t}),this.enterAmount()},addPayment:function(){var t=this.currentPayments.length+1,e=this.paymentsValue[this.method_payments];""==this.form.enter_amount||isNaN(this.form.enter_amount)||void 0==this.form.enter_amount||(this.currentPayments.push({id:t,method_payment_id:this.method_payments,method:e,amount:this.form.enter_amount}),this.form.enter_amount=void 0)},customerForm:function(t){this.form.customer_id=t?void 0:this.value,this.showDialogNewPerson=!0},add_customer:function(t){},reloadDataPersons:function(){},keyupCustomer:function(t){var e=this;this.time&&clearTimeout(this.time),this.time=setTimeout(f(r.a.mark(function t(){var n,a;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.input_person.number=e.$refs.select_person.$el.getElementsByTagName("input")[0].value,t.next=3,e.$http("/restaurant/search_customers?value=".concat(e.input_person.number));case 3:n=t.sent,a=n.data.persons,e.customers=a.filter(function(t){return"88888888"!=t.number}),e.updateAllCustomers(e.customers);case 7:case"end":return t.stop()}},t)})),500)},updateAllCustomers:function(t){var e=this;return f(r.a.mark(function n(){var a,o,s,i,u,d;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a=e.all_customers.map(function(t){return t.id}),o=[],s=l(t);try{for(u=function(){var t=i.value;void 0==a.find(function(e){return e==t.id})&&o.push(t)},s.s();!(i=s.n()).done;)u()}catch(t){s.e(t)}finally{s.f()}if(d=[].concat(c(e.all_customers),o),0==o.length){n.next=8;break}return n.next=8,e.$emit("update:all_customers",d);case 8:case"end":return n.stop()}},n)}))()},changeCustomer:function(){this.form.customer_id=this.value;var t=s.a.find(this.customers,{id:this.form.customer_id});null!=t&&(this.customer=t,"80"!=this.form.document_type_id&&("1"==t.identity_document_type_id||"4"==t.identity_document_type_id?this.form.document_type_id="03":this.form.document_type_id="01"),this.form.customer_telephone=t.phone,this.setLocalStorageIndex("customer",this.customer)),this.setSeries()},setLocalStorageIndex:function(t,e){localStorage.setItem(t,JSON.stringify(e))},getLastNumbersDocument:function(){var t=this;return f(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http.post("".concat(t.resource,"/last_number_documents"),{series:t.all_series,ordenId:t.idOrden});case 2:200==(n=e.sent).status&&(t.last_number=n.data.result,t.refCustomer=n.data.customer,null!=t.refCustomer&&(t.refCustomer.description="".concat(t.refCustomer.number," - ").concat(t.refCustomer.name),t.customers=[t.refCustomer].concat(c(t.customers.filter(function(e){return e.id!=t.refCustomer.id&&"88888888"!=e.number}))),t.value=t.refCustomer.id));case 4:case"end":return e.stop()}},e)}))()},changeEnabledDiscount:function(){this.enabled_discount||(this.discount_amount=0,this.deleteDiscountGlobal(),this.reCalculateTotal())},teclasInit:function(){var t=this;document.onkeydown=function(e){var n=e.key;"F7"==n&&t.form.items.length}},date_of_issue:function(){var t=this;return f(r.a.mark(function e(){var n;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.customers=t.all_customers.filter(function(t){return"88888888"!=t.number}),t.customers=[].concat(c(t.customers.filter(function(e){return e.id!=t.customer_default.id})),[t.customer_default]),t.establishments.customer_id&&(t.value=t.establishments.customer_id,t.form.customer_id=t.establishments.customer_id),n={enter_amount:0,difference:0},e.next=6,t.$http.post("/efectivo",n);case 6:e.sent;case 7:case"end":return e.stop()}},e)}))()},Printer:function(t,e,n){var a=arguments,o=this;return f(r.a.mark(function s(){var i,c,l,u,d,m,f,p;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(i=a.length>3&&void 0!==a[3]?a[3]:null,c=a.length>4&&void 0!==a[4]&&a[4],qz.security.setCertificatePromise(function(t,e){o.$http.get("/api/qz/crt/override",{responseType:"text"}).then(function(e){t(e.data)}).catch(function(t){e(t.data)})}),qz.security.setSignaturePromise(function(t){return function(e,n){o.$http.post("/api/qz/signing",{request:t}).then(function(t){e(t.data)}).catch(function(t){n(t.data)})}}),1!=o.printerOn){r.next=22;break}if(1!=c){r.next=14;break}if(o.auth_login!=i){r.next=14;break}if(l=qz.configs.create(t,{scaleContent:!1}),qz.websocket.isActive()){r.next=11;break}return r.next=11,qz.websocket.connect(l);case 11:for(u=[{type:"pdf",format:"file",data:e}],qz.print(l,u).catch(function(t){o.$toast.error(t.message)}),d=0;d<n;d++)qz.print(l,u).catch(function(t){o.$toast.error(t.message)});case 14:if(0!=c){r.next=22;break}if(m=qz.configs.create(t,{scaleContent:!1}),qz.websocket.isActive()){r.next=19;break}return r.next=19,qz.websocket.connect(m);case 19:for(f=[{type:"pdf",format:"file",data:e}],qz.print(m,f).catch(function(t){o.$toast.error(t.message)}),p=0;p<n;p++)qz.print(m,f).catch(function(t){o.$toast.error(t.message)});case 22:case"end":return r.stop()}},s)}))()},clickSendWhatsapp:function(t,e,n){var a=arguments,o=this;return f(r.a.mark(function s(){var i,c,l;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(null==(i=a.length>3&&void 0!==a[3]?a[3]:{}).customer_telephone){r.next=23;break}return c={id:o.recordId,document_id:e,document_type_id:t,customer_telephone:i.customer_telephone,sender:"sdrimsac",mensaje:"Su comprobante de pago electrónico "+n+" de *"+o.company.name+"*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"},r.prev=3,o.loading=!0,r.next=7,o.$http.post("/whatsapp",c);case 7:if(1==(l=r.sent).data.success&&(o.$toast.success(l.data.message),o.loading=!1),!o.configuration.xml_whatsapp||"80"==t){r.next=15;break}return c.xml=!0,r.next=13,o.$http.post("/whatsapp",c);case 13:1==(l=r.sent).data.success&&(o.$toast.success(l.data.message),o.loading=!1);case 15:r.next=20;break;case 17:r.prev=17,r.t0=r.catch(3),console.log(r.t0," error");case 20:return r.prev=20,o.loading=!1,r.finish(20);case 23:case"end":return r.stop()}},s,null,[[3,17,20,23]])}))()},changeDateOfIssue:function(){var t=this;this.form.date_of_due=this.form.date_of_issue,moment(this.form.date_of_issue)<moment().day(-1)&&this.configuration.restrict_receipt_date?(this.$toast.error("No puede seleccionar una fecha menor a 6 días."),this.dateValid=!1):this.dateValid=!0,this.form.date_of_due=this.form.date_of_issue,this.searchExchangeRateByDate(this.form.date_of_issue).then(function(e){t.form.exchange_rate_sale=e}),this.form.exchange_rate_sale=1},NuevaVenta:function(){this.$parent.nueva_venta()},setInitialAmount:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.enter_amount=t.form.total,t.form.payments=t.payments,e.next=4,t.$refs.enter_amount.$el.getElementsByTagName("input")[0].focus();case 4:return e.next=6,t.$refs.enter_amount.$el.getElementsByTagName("input")[0].select();case 6:case"end":return e.stop()}},e)}))()},inputDiscountAmount:function(){if(this.enabled_discount)if(this.discount_amount&&!isNaN(this.discount_amount)&&parseFloat(this.discount_amount)>0){if(this.discount_amount>=this.form.total)return this.$toast.error("El monto de descuento debe ser menor al total de venta");this.reCalculateTotal()}else this.deleteDiscountGlobal(),this.reCalculateTotal()},discountGlobal:function(){var t=parseFloat(this.discount_amount),e=parseFloat(this.form.total),n=parseFloat(t),a=s.a.round(n/e,4),r=s.a.find(this.form.discounts,{discount_type_id:"03"});if(t>0&&!r)this.form.total_discount=s.a.round(n,2),this.form.total=s.a.round(this.form.total-n,2),this.form.total_value=s.a.round(this.form.total/(1+this.percentage_igv/100),2),this.form.total_taxed=this.form.total_value,this.form.total_igv=s.a.round(this.form.total_value*(this.percentage_igv/100),2),this.form.total_taxes=this.form.total_igv,this.form.discounts.push({discount_type_id:"03",description:"Descuentos globales que no afectan la base imponible del IGV/IVAP",factor:a,amount:n,base:e});else{var o=this.form.discounts.indexOf(r);o>-1&&(this.form.total_discount=s.a.round(n,2),this.form.total=s.a.round(this.form.total-n,2),this.form.total_value=s.a.round(this.form.total/(1+this.percentage_igv/100),2),this.form.total_taxed=this.form.total_value,this.form.total_igv=s.a.round(this.form.total_value*(this.percentage_igv/100),2),this.form.total_taxes=this.form.total_igv,this.form.discounts[o].base=e,this.form.discounts[o].amount=n,this.form.discounts[o].factor=a)}},method_payment:function(t){this.form.payment_condition_id="01",this.form.method_pay=t,this.form.afectar_caja=!0},reCalculateTotal:function(){var t=0,e=0,n=0,a=0,r=0,o=0,i=0,c=0,l=0;this.form.items.forEach(function(s){parseFloat(s.total_discount),parseFloat(s.total_charge),"10"===s.affectation_igv_type_id&&(e+=parseFloat(s.total_value)),"20"===s.affectation_igv_type_id&&(n+=parseFloat(s.total_value)),"30"===s.affectation_igv_type_id&&(a+=parseFloat(s.total_value)),"40"===s.affectation_igv_type_id&&(t+=parseFloat(s.total_value)),["10","20","30","40"].indexOf(s.affectation_igv_type_id)<0&&(r+=parseFloat(s.total_value)),["10","20","30","40"].indexOf(s.affectation_igv_type_id)>-1&&(o+=parseFloat(s.total_igv),c+=parseFloat(s.total)),i+=parseFloat(s.total_value),l+=isNaN(parseFloat(s.total_plastic_bag_taxes))?0:parseFloat(s.total_plastic_bag_taxes)}),this.form.total_exportation=s.a.round(t,2),this.form.total_taxed=s.a.round(e,2),this.form.total_exonerated=s.a.round(n,2),this.form.total_unaffected=s.a.round(a,2),this.form.total_free=s.a.round(r,2),this.form.total_igv=s.a.round(o,2),this.form.total_value=s.a.round(i,2),this.form.total_taxes=s.a.round(o,2),this.form.total_plastic_bag_taxes=s.a.round(l,2),this.form.total=s.a.round(c+this.form.total_plastic_bag_taxes,2),this.discountGlobal()},deleteDiscountGlobal:function(){var t=s.a.find(this.form.discounts,{discount_type_id:"03"}),e=this.form.discounts.indexOf(t);e>-1&&(this.form.discounts.splice(e,1),this.form.total_discount=0)},getFormPosLocalStorage:function(){var t=localStorage.getItem("form_pos");(t=JSON.parse(t))&&(this.form.payments=t.payments)},clickAddPayment:function(){this.showDialogMultiplePayment=!0},reloadDataCardBrands:function(t){var e=this;this.$http.get("/".concat(this.resource,"/table/card_brands")).then(function(n){e.cards_brand=n.data,e.form_payment.card_brand_id=t,e.changePaymentMethodType()})},getDescriptionPaymentMethodType:function(t){var e=s.a.find(this.payment_method_types,{id:t});return e?e.description:""},changePaymentMethodType:function(){var t=s.a.find(this.payment_method_types,{id:this.form_payment.payment_method_type_id});this.has_card=t.has_card,this.form_payment.card_brand_id=t.has_card?this.form_payment.card_brand_id:null},addRow:function(t){this.form.payments=t;var e=0;this.form.payments.forEach(function(t){e+=parseFloat(t.payment)}),this.setAmount(e)},setAmount:function(t){this.form.enter_amount=t,this.amount=parseFloat(t),this.inputAmount(t)},setAmountCash:function(t){this.setAmount(t)},diferen:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:(parseFloat(t.form.enter_amount)||0)+t.totalPayments()-parseFloat(t.form.total)<0&&t.$toast.error("El monto de efectivo es menor al total de venta");case 2:case"end":return e.stop()}},e)}))()},totalPayments:function(){if(0!=this.currentPayments.length){var t=0;return this.currentPayments.forEach(function(e){t+=parseFloat(e.amount)}),t}return 0},enterAmount:function(){var t=arguments,e=this;return f(r.a.mark(function n(){var a,o,s;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a=t.length>0&&void 0!==t[0]?t[0]:0,e.amount=a,o=(parseFloat(e.form.enter_amount)||0)+e.totalPayments(),s=o-parseFloat(e.form.total),e.form.difference=parseFloat(s),e.form.difference<0?(e.button_payment=!0,e.form.difference=s):e.form.difference>=0?(e.button_payment=!1,parseFloat(e.form.enter_amount),parseFloat(e.form.total)):e.button_payment=!0,e.$eventHub.$emit("eventSetFormPosLocalStorage",e.form);case 7:case"end":return n.stop()}},n)}))()},getLocalStoragePayment:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=localStorage.getItem(t);return(n=JSON.parse(n))||e},setLocalStoragePayment:function(t,e){return localStorage.setItem(t,JSON.stringify(e))},inputAmount:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.enterAmount(t),this.form.difference=this.form.enter_amount-this.form.total,isNaN(this.form.difference)?(this.button_payment=!0,this.form.difference="-"):this.form.difference>=0?(this.button_payment=!1,this.form.difference=this.amount-this.form.total):this.button_payment=!0,this.$eventHub.$emit("eventSetFormPosLocalStorage",this.form)},lStoPayment:function(){this.setLocalStoragePayment("enter_amount",this.form.enter_amount),this.setLocalStoragePayment("amount",0==this.amount?this.form.total:this.amount),this.setLocalStoragePayment("difference",0==this.amount?this.form.total-this.amount:0)},initFormPayment:function(){this.form.difference=this.form.total-this.form.enter_amount,this.form_payment={id:null,date_of_payment:moment().format("YYYY-MM-DD"),payment_method_type_id:"01",reference:null,card_brand_id:null,document_id:null,sale_note_id:null,payment:this.form.total},this.form_cash_document={document_id:null,sale_note_id:null}},cleanLocalStoragePayment:function(){this.setLocalStoragePayment("form_pos",null),this.setLocalStoragePayment("amount",null),this.setLocalStoragePayment("enter_amount",null),this.setLocalStoragePayment("difference",null)},sleep:function(t){return new Promise(function(e){return setTimeout(e,t)})},passBoxes:function(t,e){var n=e.reduce(function(t,e){return t+e.amount},0)-t,a=!1;n<0&&(a=!0,n*=-1);var r=c(e);if(0!=n)for(var o=0;o<r.length;o++){var s=r[o];if(a?(s.amount+=n,n=0):s.amount-n>0&&(s.amount-=n,n=0),0==n)break}return r},sendPayment:function(t){var e=arguments,n=this;return f(r.a.mark(function t(){var a,o,s;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return(a=e.length>1&&void 0!==e[1]?e[1]:null)||(a=n.form),a.printerOn=1==n.printerOn,t.next=5,n.clickPayment(a);case 5:if(0==n.formVariation.items.length){t.next=21;break}if((o=n.formVariation).printerOn=!1,o.document_type_id="80",o.customer_telephone=null,o.customer_id=n.customer_variation.id,n.customers=[].concat(c(n.customers.filter(function(t){return t!=n.customer_variation.id})),[n.customer_variation]),o.boxes=n.passBoxes(n.formVariation.total,n.form.boxes),!(s=n.all_series.find(function(t){return"80"==t.document_type_id}))){t.next=20;break}return o.series_id=s.id,t.next=18,n.clickPayment(o);case 18:t.next=21;break;case 20:n.$toast.error("Sin serie en nota de venta");case 21:case"end":return t.stop()}},t)}))()},clickPayment:function(t){var e=this;return f(r.a.mark(function n(){var a,o,s,i,c,l;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(a=e.customers.find(function(e){return e.id==t.customer_id}),null==t.customer_telephone){n.next=5;break}if(e.existNumber()){n.next=5;break}return e.$toast.error("Número para envío whatsapp inválido"),n.abrupt("return");case 5:if(null!=t.customer_id&&""!=t.customer_id){n.next=7;break}return n.abrupt("return",e.$toast.error("Elija un cliente"));case 7:if("1"!=a.identity_document_type_id||"01"!=t.document_type_id){n.next=9;break}return n.abrupt("return",e.$toast.error("No puede emitir Factura con DNI"));case 9:if(t.series_id){n.next=11;break}return n.abrupt("return",e.$toast.warning("El establecimiento no tiene series disponibles para el comprobante"));case 11:if("80"===t.document_type_id?(t.prefix="NV",t.paid=1,e.resource_documents="sale-notes",e.resource_payments="sale_note_payments",e.resource_options=e.resource_documents):(t.prefix=null,e.resource_documents="documents",e.resource_payments="document_payments",e.resource_options=e.resource_documents),null!=e.orden&&(t.additional_information="Orden N°".concat(e.orden)),t.advances=0,t.total_advances=0,t.total_payment=t.total,t.payments=[{payment_method_type_id:"01",date_of_payment:t.date_of_issue,payment:t.total}],t.cash_id=e.cash_id,t.boxes=e.currentPayments,e.addPayment(),e.loading_submit=!0,n.prev=21,{enter_amount:t.enter_amount,difference:t.difference},void 0!=(o=e.idOrden)&&null!=o||void 0!=t.variation&&null!=t.variation){n.next=31;break}return n.next=27,e.$http.post("/restaurant/worker/send-orden",e.orden_items);case 27:if(s=n.sent,o=s.data.id,200==s.status){n.next=31;break}return n.abrupt("return");case 31:return t.orden_id=o,n.next=34,e.$http.post("/".concat(e.resource_documents),t);case 34:if(200!=(i=n.sent).status){n.next=69;break}if(1!=i.data.success){n.next=67;break}if(0,"80"===t.document_type_id?(e.number=i.data.data.number,i.data.data.id,e.form_cash_document.sale_note_id=i.data.data.id):(i.data.data.id,e.form_cash_document.document_id=i.data.data.id,e.number=i.data.data.number),e.documentNewId=i.data.data.id,1!=i.data.success){n.next=67;break}if(!o){n.next=64;break}return n.next=44,e.$http.post("pos/orden_payment",{id:o,customer_id:a.id,document:{isNoteSale:"80"===t.document_type_id,id:e.documentNewId}});case 44:if(1!=n.sent.data.success){n.next=62;break}if(!e.form.customer_telephone){n.next=59;break}if(!e.personalWhatsapp){n.next=52;break}return n.next=50,e.$emit("getFile",{documentId:e.documentNewId,documentTypeId:t.document_type_id,number:e.form.customer_telephone,message:e.form.message});case 50:n.next=54;break;case 52:return n.next=54,e.clickSendWhatsapp(t.document_type_id,e.documentNewId,e.number,t);case 54:e.$emit("limpiarForm"),e.loading_submit=!1,e.back(!0),n.next=62;break;case 59:e.$emit("limpiarForm"),e.loading_submit=!1,e.back(!0);case 62:n.next=67;break;case 64:e.$emit("limpiarForm"),e.loading_submit=!1,e.back(!0);case 67:n.next=71;break;case 69:e.loading_submit=!0,e.$alert("<strong>Ocurrio un error </strong>"+i.statusCode+"<br>"+e.resource_documents,"HTML String",{dangerouslyUseHTMLString:!0});case 71:n.next=80;break;case 73:n.prev=73,n.t0=n.catch(21),console.log(n.t0),c=n.t0.response,l=c.data.message,e.$toast.error(l||"Ocurrió un error"),e.loading_submit=!1;case 80:case"end":return n.stop()}},n,null,[[21,73]])}))()},clickPrintPos:function(t,e){var n=arguments,a=this;return f(r.a.mark(function o(){var s,i;return r.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(n.length>2&&void 0!==n[2]?n[2]:null,r.prev=1,s=qz.configs.create(t,{legacy:!0},{scaleContent:!1}),qz.websocket.isActive()){r.next=6;break}return r.next=6,qz.websocket.connect(s);case 6:i=[{type:"pdf",format:"file",data:e}],qz.print(s,i).catch(function(t){a.$toast.error(t.message)}),r.next=13;break;case 10:r.prev=10,r.t0=r.catch(1),a.$toast.error(r.t0.message);case 13:case"end":return r.stop()}},o,null,[[1,10]])}))()},saveCashDocument:function(){var t=this;this.$http.post("/cash/cash_document",this.form_cash_document).then(function(e){e.data.success||t.$toast.error(e.data.message)}).catch(function(t){console.log(t)})},savePaymentMethod:function(){var t=this;this.$http.post("/".concat(this.resource_payments),this.form_payment).then(function(e){e.data.success||t.$toast.error(e.data.message)}).catch(function(e){422===e.response.status?t.records[index].errors=e.response.data:console.log(e)})},getTables:function(){this.filterSeries()},clickCancel:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.loading_submit=!0,t.loading_submit=!1,t.cleanLocalStoragePayment(),t.$eventHub.$emit("cancelSale");case 4:case"end":return e.stop()}},e)}))()},back:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];this.splitPayments=[],t||this.$emit("openDrawer"),this.$emit("update:is_payment",!1)},initLStoPayment:function(){var t=this;return f(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getLocalStoragePayment("amount",t.form.total);case 2:return t.amount=e.sent,e.next=5,t.getLocalStoragePayment("enter_amount",t.form.total);case 5:return t.form.enter_amount=e.sent,e.next=8,t.getLocalStoragePayment("difference",t.form.total-t.form.enter_amount);case 8:t.form.difference=e.sent;case 9:case"end":return e.stop()}},e)}))()},checkCustomers:function(){return"01"==this.form.document_type_id?this.customers.some(function(t){return"6"==t.identity_document_type_id}):this.customers.some(function(t){return"1"==t.identity_document_type_id})},setSeries:function(){var t=this;this.form.series_id=null,this.series=s.a.filter(this.all_series,{document_type_id:this.form.document_type_id}),this.series.forEach(function(e){e.full_number="".concat(e.number,"-").concat(t.last_number[e.number]||"1")||e.number}),this.form.series_id=this.series.length>0?this.series[0].id:null},filterSeries:function(){var t=this;if(!this.checkCustomers()&&!this.started){var e="DNI";return"01"==this.form.document_type_id?(e="RUC",this.form.document_type_id="03"):this.form.document_type_id="01",this.$toast.warning("Digite el número de ".concat(e)),void this.setSeries()}this.started=!1,"01"==this.form.document_type_id?(this.currentDocumentsType=c(this.documentsType.filter(function(t){return"RUC"==t.description})),this.form.identity_document_type_id=this.currentDocumentsType[0].id):this.currentDocumentsType=this.documentsType,this.setSeries();var n=null;if(null!=this.value&&(n=this.all_customers.find(function(e){return e.id==t.value})),"01"==this.form.document_type_id)if(this.customers=this.all_customers.filter(function(t){return"6"==t.identity_document_type_id}),0==this.customers.length)this.$toast.warning("Digite el número de RUC"),this.form.document_type_id;else{if(n&&this.customers.some(function(t){return t.id==n.id}))return;this.value=this.customers[0].id,this.form.customer_telephone=this.customers[0].phone}else if("03"==this.form.document_type_id||"80"==this.form.document_type_id){if(this.customers=this.all_customers.filter(function(t){return"6"!=t.identity_document_type_id}),this.form.total>300&&(this.customers=this.customers.filter(function(t){return"1"==t.identity_document_type_id})),n&&this.customers.some(function(t){return t.id==n.id}))return;var a=this.customers.find(function(t){return t.name.toLowerCase().includes("varios")});a?(this.value=a.id,this.form.customer_telephone=a.phone):(this.value=this.customers[0].id,this.form.customer_telephone=this.customers[0].phone)}else this.customers=this.all_customers;this.customers=this.customers.filter(function(t){return"88888888"!=t.number}),this.customers=[].concat(c(this.customers.filter(function(e){return e.id!=t.customer_default.id})),[this.customer_default]),this.changeCustomer()}}}},"QeH/":function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".algunaClase .el-dialog .el-dialog__header .el-dialog__title{font-size:35px!important}.el-scrollbar{z-index:2000!important}.c-width{width:80px!important;padding:0!important;margin-right:0!important}.control-label,h4,h5,label{color:#000}",""])},uLqX:function(t,e,n){var a=n("QeH/");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);n("rjj0")("15477698",a,!0,{})},wArv:function(t,e,n){var a=n("VU/8")(n("E8J9"),n("AhJO"),!1,function(t){n("uLqX")},null,null);t.exports=a.exports}});
>>>>>>> master
=======
webpackJsonp([104],{"DiG+":function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-dialog",{attrs:{title:t.titleDialog,width:"40%",visible:t.showDialog,"close-on-click-modal":!1,"close-on-press-escape":!1,"append-to-body":"","show-close":!1},on:{open:t.create}},[a("div",{staticClass:"form-body"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-12 col-md-12"},[a("table",{attrs:{width:"100%"}},[a("thead",[a("tr",{attrs:{width:"100%"}},[t.lots.length>0?a("th",[t._v("Serie")]):t._e(),t._v(" "),t.lots.length>0?a("th",[t._v("Estado")]):t._e(),t._v(" "),t.lots.length>0?a("th",[t._v("Fecha")]):t._e(),t._v(" "),a("th",{attrs:{width:"15%"}},[a("a",{staticClass:"text-center font-weight-bold text-info",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.clickAddLot.apply(null,arguments)}}},[t._v("[+ Agregar]")])])])]),t._v(" "),a("tbody",t._l(t.lots,function(e,s){return a("tr",{key:s,attrs:{width:"100%"}},[a("td",[a("div",{staticClass:"form-group mb-2 mr-2"},[a("el-input",{on:{blur:function(a){return t.duplicateSerie(e.series,s)}},model:{value:e.series,callback:function(a){t.$set(e,"series",a)},expression:"row.series"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1)]),t._v(" "),a("td",[a("div",{staticClass:"form-group mb-2 mr-2"},[a("el-select",{model:{value:e.state,callback:function(a){t.$set(e,"state",a)},expression:"row.state"}},t._l(t.states,function(t,e){return a("el-option",{key:e,attrs:{value:t,label:t}})}),1)],1)]),t._v(" "),a("td",[a("div",{staticClass:"form-group mb-2 mr-2"},[a("el-date-picker",{attrs:{type:"date","value-format":"yyyy-MM-dd",clearable:!1},model:{value:e.date,callback:function(a){t.$set(e,"date",a)},expression:"row.date"}})],1)]),t._v(" "),a("td",{staticClass:"series-table-actions text-center"},[a("button",{staticClass:"btn waves-effect waves-light btn-sm btn-danger",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickCancel(s)}}},[a("i",{staticClass:"fa fa-trash"})])]),t._v(" "),a("br")])}),0)])])])]),t._v(" "),a("div",{staticClass:"form-actions text-end pt-2 pb-2"},[a("el-button",{on:{click:function(e){return e.preventDefault(),t.clickCancelSubmit()}}},[t._v("Cancelar")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.submit}},[t._v("Guardar")])],1)])},staticRenderFns:[]}},Xw1K:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=a("En79"),r=a.n(s),i=a("chin"),o=a.n(i);function n(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),a.push.apply(a,s)}return a}function l(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?n(Object(a),!0).forEach(function(e){c(t,e,a[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):n(Object(a)).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))})}return t}function c(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}function d(t,e,a,s,r,i,o){try{var n=t[i](o),l=n.value}catch(t){return void a(t)}n.done?e(l):Promise.resolve(l).then(s,r)}function u(t){return function(){var e=this,a=arguments;return new Promise(function(s,r){var i=t.apply(e,a);function o(t){d(i,s,r,o,n,"next",t)}function n(t){d(i,s,r,o,n,"throw",t)}o(void 0)})}}e.default={props:["showDialog","recordId","external"],components:{LotsForm:o.a},data:function(){return{showDialogLots:!1,form_category:{add:!1,name:null,id:null},form_brand:{add:!1,name:null,id:null},warehouses:[],loading_submit:!1,showPercentagePerception:!1,has_percentage_perception:!1,percentage_perception:null,enabled_percentage_of_profit:!1,titleDialog:null,resource:"items",errors:{},headers:headers_token,form:{},configuration:{},unit_types:[],areas:[],currency_types:[],system_isc_types:[],affectation_igv_types:[],categories:[],brands:[],accounts:[],show_has_igv:!0,have_account:!1,showSeries:!1,item_unit_type:{id:null,unit_type_id:null,quantity_unit:0,price1:0,price2:0,price3:0,price_default:2},attribute_types:[],area_id:2}},created:function(){var t=this;return u(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.initForm();case 2:return e.next=4,t.$http.get("/".concat(t.resource,"/tables")).then(function(e){t.unit_types=e.data.unit_types,t.accounts=e.data.accounts,t.currency_types=e.data.currency_types,t.system_isc_types=e.data.system_isc_types,t.affectation_igv_types=e.data.affectation_igv_types,t.warehouses=e.data.warehouses,t.warehouses.length>0&&(t.form.warehouse_id=t.warehouses[0].id,t.form.warehouse_prices=t.warehouses.map(function(t){return{id:null,item_id:null,warehouse_id:t.id,price:null,warehouse:t.description}})),t.categories=e.data.categories,t.brands=e.data.brands,t.attribute_types=e.data.attribute_types,t.configuration=e.data.configuration,t.areas=e.data.areas,t.form.sale_affectation_igv_type_id=t.affectation_igv_types.length>0?t.affectation_igv_types[0].id:null,t.form.purchase_affectation_igv_type_id=t.affectation_igv_types.length>0?t.affectation_igv_types[0].id:null});case 4:return t.$eventHub.$on("submitPercentagePerception",function(e){t.form.percentage_perception=e,t.form.percentage_perception||(t.has_percentage_perception=!1)}),t.$eventHub.$on("reloadTables",function(){t.reloadTables()}),e.next=8,t.setDefaultConfiguration();case 8:case"end":return e.stop()}},e)}))()},methods:{selectedMax:function(t){for(var e=this.form.item_unit_types[t].selected,a=0;a<this.form.item_unit_types.length;a++){this.form.item_unit_types[a].selected=!1}if(this.form.item_unit_types[t].selected=e,e){var s=Number(this.form.item_unit_types[t].quantity_unit);!isNaN(s)&&(this.form.max_quantity=s)}else this.form.max_quantity=null;this.$forceUpdate()},undToTotal:function(t,e,a){var s=this.form.item_unit_types;a>0?s[t].total=Number(e)*Number(a):(this.$toast.warning("Ingrese una cantidad válida"),s[t].price2=0)},totalToUnd:function(t,e,a){var s=this.form.item_unit_types;a>0?s[t].price2=Number(e)/Number(a):(this.$toast.warning("Ingrese una cantidad válida"),s[t].total=0)},setDefaultConfiguration:function(){var t=this;this.form.sale_affectation_igv_type_id=this.configuration?this.configuration.affectation_igv_type_id:"10",this.$http.get("/configurations/record").then(function(e){t.form.has_igv=e.data.data.include_igv}),this.changeAffectationIgvType()},clickAddAttribute:function(){this.form.attributes.push({attribute_type_id:null,description:null,value:null,start_date:null,end_date:null,duration:null})},reloadTables:function(){var t=this;return u(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http.get("/".concat(t.resource,"/tables")).then(function(e){t.unit_types=e.data.unit_types,t.accounts=e.data.accounts,t.currency_types=e.data.currency_types,t.system_isc_types=e.data.system_isc_types,t.affectation_igv_types=e.data.affectation_igv_types,t.warehouses=e.data.warehouses,t.categories=e.data.categories,t.brands=e.data.brands,t.form.sale_affectation_igv_type_id=t.affectation_igv_types.length>0?t.affectation_igv_types[0].id:null,t.form.purchase_affectation_igv_type_id=t.affectation_igv_types.length>0?t.affectation_igv_types[0].id:null});case 2:case"end":return e.stop()}},e)}))()},changeLotsEnabled:function(){},addRowLot:function(t){this.form.lots=t},clickLotcode:function(){this.showDialogLots=!0},changeHaveAccount:function(){this.have_account||(this.form.account_id=null)},changeEnabledPercentageOfProfit:function(){},clickDelete:function(t){var e=this;this.$http.delete("/".concat(this.resource,"/item-unit-type/").concat(t)).then(function(t){t.data.success&&(e.loadRecord(),e.$toast.success("Se eliminó correctamente el registro"))}).catch(function(t){500===t.response.status?e.$toast.error("Error al intentar eliminar"):console.log(t.response.data.message)})},changeHasPerception:function(){this.form.has_perception||(this.form.percentage_perception=null)},clickAddRow:function(){this.form.item_unit_types.push({id:null,description:null,unit_type_id:"NIU",quantity_unit:0,price1:0,price2:0,price3:0,price_default:2,warehouse_id:null})},clickCancel:function(t){this.form.item_unit_types.splice(t,1)},initForm:function(){this.loading_submit=!1,this.errors={},this.form={id:null,item_type_id:"01",location:null,internal_id:null,item_code:null,item_code_gs1:null,description:null,name:null,second_name:null,unit_type_id:"NIU",currency_type_id:"PEN",sale_unit_price:0,purchase_unit_price:0,has_isc:!1,system_isc_type_id:null,percentage_isc:0,suggested_price:0,sale_affectation_igv_type_id:null,purchase_affectation_igv_type_id:null,calculate_quantity:!1,stock:0,stock_min:1,has_igv:!0,has_perception:!1,item_unit_types:[],percentage_of_profit:0,percentage_perception:0,image:null,image_url:null,temp_path:null,is_set:!1,account_id:null,category_id:null,brand_id:null,date_of_due:null,lot_code:null,lots_enabled:!1,lots:[],attributes:[],series_enabled:!1,area_id:2},this.show_has_igv=!0,this.enabled_percentage_of_profit=!1},onSuccess:function(t,e,a){t.success?(this.form.image=t.data.filename,this.form.image_url=t.data.temp_image,this.form.temp_path=t.data.temp_path):this.$toast.error(t.message)},changeAffectationIgvType:function(){[20,21,30,31,32,33,34,35,36,37].includes(parseInt(this.form.sale_affectation_igv_type_id))?(this.show_has_igv=!1,this.form.has_igv=!0):this.show_has_igv=!0},resetForm:function(){this.initForm(),this.form.sale_affectation_igv_type_id=this.affectation_igv_types.length>0?this.affectation_igv_types[0].id:null,this.form.purchase_affectation_igv_type_id=this.affectation_igv_types.length>0?this.affectation_igv_types[0].id:null,this.setDefaultConfiguration()},create:function(){var t=this;this.titleDialog=this.recordId?"Editar Productos":"Nuevo Producto",this.recordId?this.$http.get("/".concat(this.resource,"/record/").concat(this.recordId)).then(function(e){t.form=e.data.data,0==t.form.warehouse_prices.length?t.warehouses.length>0&&(t.form.warehouse_id=t.warehouses[0].id,t.form.warehouse_prices=t.warehouses.map(function(t){return{id:null,item_id:null,warehouse_id:t.id,price:null,warehouse:t.description}})):t.form.warehouse_prices=t.warehouses.map(function(e){var a=t.form.warehouse_prices.find(function(t){return t.warehouse_id==e.id});return a||{id:null,item_id:null,warehouse_id:e.id,price:null,warehouse:e.description}}),0!=t.form.item_unit_types.length&&t.restoreUnitTypes(),t.has_percentage_perception=!!t.form.percentage_perception,t.changeAffectationIgvType(),t.showSeries=!0,1==t.form.series_enabled?t.form.series_enabled=!0:t.form.series_enabled=!1}):this.showSeries=!0},restoreUnitTypes:function(){var t=this,e=!1;this.form.item_unit_types=this.form.item_unit_types.map(function(a){var s=!1;return e||Number(t.form.max_quantity)!=Number(a.quantity_unit)||(s=!0,e=!0),l(l({},a),{},{selected:s,total:(Number(a.price2)*Number(a.quantity_unit)).toFixed(2)})})},loadRecord:function(){var t=this;this.recordId&&this.$http.get("/".concat(this.resource,"/record/").concat(this.recordId)).then(function(e){t.form=e.data.data,t.changeAffectationIgvType()})},changeWarehouse:function(){var t=this;this.$toast.warning("Cambió el destino del producto, verifique los PRECIOS DE ALMACÉN");var e=this.form.warehouse_prices.find(function(e){return e.warehouse_id==t.form.warehouse_id});e&&(e.price=this.form.sale_unit_price),this.$forceUpdate()},calculatePercentageOfProfitBySale:function(){var t=this,e=this.form.warehouse_prices.find(function(e){return e.warehouse_id==t.form.warehouse_id});e&&(e.price=this.form.sale_unit_price);var a=parseFloat(this.form.sale_unit_price)-parseFloat(this.form.purchase_unit_price);0===parseFloat(this.form.purchase_unit_price)?this.form.percentage_of_profit=0:this.enabled_percentage_of_profit&&(this.form.percentage_of_profit=a/parseFloat(this.form.purchase_unit_price)*100)},calculatePercentageOfProfitByPurchase:function(){""===this.form.percentage_of_profit&&(this.form.percentage_of_profit=0),this.enabled_percentage_of_profit&&(this.form.sale_unit_price=this.form.purchase_unit_price*(100+parseFloat(this.form.percentage_of_profit))/100)},calculatePercentageOfProfitByPercentage:function(){""===this.form.percentage_of_profit&&(this.form.percentage_of_profit=0),this.enabled_percentage_of_profit&&(this.form.sale_unit_price=this.form.purchase_unit_price*(100+parseFloat(this.form.percentage_of_profit))/100)},submit:function(){var t=this;return u(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(null!=t.form.internal_id&&""!=t.form.internal_id){e.next=3;break}return t.$refs.internal_id.$el.querySelector("input").focus(),e.abrupt("return",t.$toast.warning("No puede guardar Un nuevo Producto sin codigo interno "));case 3:if(!t.form.has_perception||t.form.percentage_perception){e.next=5;break}return e.abrupt("return",t.$toast.error("Ingrese un porcentaje"));case 5:if(t.form.warehouse_id){e.next=7;break}return e.abrupt("return",t.$toast.error("Seleccione un almacen"));case 7:if(!t.recordId&&t.form.lots_enabled,t.recordId||!t.form.series_enabled){e.next=13;break}if(!(t.form.lots.length>t.form.stock)){e.next=11;break}return e.abrupt("return",t.$toast.error("La cantidad de series registradas es superior al stock"));case 11:if(t.form.lots.length==t.form.stock){e.next=13;break}return e.abrupt("return",t.$toast.error("La cantidad de series registradas son diferentes al stock"));case 13:return t.loading_submit=!0,e.next=16,t.$http.post("/".concat(t.resource),t.form).then(function(e){e.data.success?(t.$toast.success(e.data.message),t.external?t.$emit("add",e.data.data):t.$eventHub.$emit("reloadData"),t.close()):t.$toast.error(e.data.message)}).catch(function(e){422===e.response.status?t.errors=e.response.data.errors:console.log(e)}).then(function(){t.loading_submit=!1});case 16:case"end":return e.stop()}},e)}))()},close:function(){this.$emit("update:showDialog",!1),this.showSeries=!1,this.resetForm(),this.form.warehouse_prices=this.warehouses.map(function(t){return{id:null,item_id:null,warehouse_id:t.id,price:null,warehouse:t.description}})},changeHasIsc:function(){this.form.system_isc_type_id=null,this.form.percentage_isc=0,this.form.suggested_price=0},changeSystemIscType:function(){"03"!==this.form.system_isc_type_id&&(this.form.suggested_price=0)},saveCategory:function(){var t=this;this.form_category.add=!1,this.$http.post("/items/categories",this.form_category).then(function(e){e.data.success?(t.$toast.success(e.data.message),t.categories.push(e.data.data),t.form.category_id=e.data.data.id,t.form_category.name=null):t.$toast.error("No se guardaron los cambios")}).catch(function(t){})},saveBrand:function(){var t=this;this.form_brand.add=!1,this.$http.post("/brands",this.form_brand).then(function(e){e.data.success?(t.$toast.success(e.data.message),t.brands.push(e.data.data),t.form_brand.name=null):t.$toast.error("No se guardaron los cambios")}).catch(function(t){})},changeAttributeType:function(t){var e=this.form.attributes[t].attribute_type_id,a=_.find(this.attribute_types,{id:e});this.form.attributes[t].description=a.description},clickRemoveAttribute:function(t){this.form.attributes.splice(t,1)}}}},chin:function(t,e,a){var s=a("VU/8")(a("g4KC"),a("DiG+"),!1,null,null,null);t.exports=s.exports},g4KC:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s,r,i,o=a("En79"),n=a.n(o);function l(t,e,a,s,r,i,o){try{var n=t[i](o),l=n.value}catch(t){return void a(t)}n.done?e(l):Promise.resolve(l).then(s,r)}function c(t){return function(){var e=this,a=arguments;return new Promise(function(s,r){var i=t.apply(e,a);function o(t){l(i,s,r,o,n,"next",t)}function n(t){l(i,s,r,o,n,"throw",t)}o(void 0)})}}e.default={props:["showDialog","lots","stock","recordId"],data:function(){return{titleDialog:"Series",loading:!1,errors:{},form:{},states:["Activo","Inactivo","Desactivado","Voz","M2m"]}},created:function(){return c(n.a.mark(function t(){return n.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:case"end":return t.stop()}},t)}))()},methods:(s={duplicateSerie:function(t,e){var a=this;return c(n.a.mark(function s(){return n.a.wrap(function(s){for(;;)switch(s.prev=s.next){case 0:return s.next=2,_.filter(a.lots,{series:t});case 2:s.sent.length>1&&(a.lots[e].series="");case 4:case"end":return s.stop()}},s)}))()},create:function(){if(!this.recordId)if(0==this.lots.length)this.addMoreLots(this.stock);else{var t=this.stock-this.lots.length;t>0&&this.addMoreLots(t)}},addMoreLots:function(t){for(var e=0;e<t;e++)this.clickAddLot()},deleteMoreLots:function(t){for(var e=0;e<t;e++)this.lots.pop(),this.$emit("addRowLot",this.lots)},validateLots:function(){var t=this;return c(n.a.mark(function e(){var a;return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return a=0,e.next=3,t.lots.forEach(function(t){null==t.series&&a++});case 3:if(!(a>0)){e.next=5;break}return e.abrupt("return",{success:!1,message:"El campo serie es obligatorio"});case 5:return e.abrupt("return",{success:!0});case 6:case"end":return e.stop()}},e)}))()},submit:function(){var t=this;return c(n.a.mark(function e(){var a;return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.validateLots();case 2:if((a=e.sent).success){e.next=5;break}return e.abrupt("return",t.$toast.error(a.message));case 5:return e.next=7,t.$emit("addRowLot",t.lots);case 7:return e.next=9,t.$emit("update:showDialog",!1);case 9:case"end":return e.stop()}},e)}))()},clickAddLot:function(){if(!this.recordId&&this.lots.length>=this.stock)return this.$toast.error("La cantidad de registros es superior al stock o cantidad");this.lots.push({id:null,item_id:null,series:null,date:moment().format("YYYY-MM-DD"),state:"Activo"}),this.$emit("addRowLot",this.lots)},close:function(){this.$emit("update:showDialog",!1),this.$emit("addRowLot",this.lots)},clickCancel:function(t){this.lots.splice(t,1),this.$emit("addRowLot",this.lots)},clickCancelSubmit:function(){var t=this;return c(n.a.mark(function e(){return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.$emit("addRowLot",[]),e.next=3,t.$emit("update:showDialog",!1);case 3:case"end":return e.stop()}},e)}))()}},r="close",i=function(){this.$emit("update:showDialog",!1)},r in s?Object.defineProperty(s,r,{value:i,enumerable:!0,configurable:!0,writable:!0}):s[r]=i,s)}},jmpl:function(t,e,a){var s=a("VU/8")(a("Xw1K"),a("rwMh"),!1,null,null,null);t.exports=s.exports},rwMh:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-dialog",{attrs:{width:"65%",title:t.titleDialog,visible:t.showDialog,"close-on-click-modal":!1,"append-to-body":"",top:"7vh"},on:{close:t.close,open:t.create}},[a("form",{attrs:{autocomplete:"off"},on:{submit:function(e){return e.preventDefault(),t.submit.apply(null,arguments)}}},[a("div",{staticClass:"form-body"},[a("el-tabs",{attrs:{"tab-position":"top"}},[a("el-tab-pane",{attrs:{label:"General"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.internal_id}},[a("label",{staticClass:"control-label"},[t._v("Código Interno\n                                        "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Código interno de la empresa para el control de sus productos",placement:"top-start"}},[a("i",{staticClass:"fa fa-info-circle"})])],1),t._v(" "),a("el-input",{ref:"internal_id",attrs:{dusk:"internal_id"},model:{value:t.form.internal_id,callback:function(e){t.$set(t.form,"internal_id",e)},expression:"form.internal_id"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.internal_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.internal_id[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.description}},[a("label",{staticClass:"control-label"},[t._v("Nombre"),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("el-input",{attrs:{dusk:"description"},model:{value:t.form.description,callback:function(e){t.$set(t.form,"description",e)},expression:"form.description"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.description?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.description[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.second_name}},[a("label",{staticClass:"control-label"},[t._v("Nombre secundario\n                                    ")]),t._v(" "),a("el-input",{attrs:{dusk:"second_name"},model:{value:t.form.second_name,callback:function(e){t.$set(t.form,"second_name",e)},expression:"form.second_name"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.second_name?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.second_name[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.category_id}},[a("label",{staticClass:"control-label"},[t._v("\n                                        Categoría\n                                    ")]),t._v(" "),0==t.form_category.add?a("a",{staticClass:"control-label font-weight-bold text-info",attrs:{href:"#"},on:{click:function(e){t.form_category.add=!0}}},[t._v("\n                                        [ + Nuevo]")]):t._e(),t._v(" "),1==t.form_category.add?a("a",{staticClass:"control-label font-weight-bold text-info",attrs:{href:"#"},on:{click:function(e){return t.saveCategory()}}},[t._v("\n                                        [ + Guardar]")]):t._e(),t._v(" "),1==t.form_category.add?a("a",{staticClass:"control-label font-weight-bold text-danger",attrs:{href:"#"},on:{click:function(e){t.form_category.add=!1}}},[t._v("\n                                        [ Cancelar]")]):t._e(),t._v(" "),1==t.form_category.add?a("el-input",{staticStyle:{"margin-bottom":"1.5%"},attrs:{dusk:"item_code"},model:{value:t.form_category.name,callback:function(e){t.$set(t.form_category,"name",e)},expression:"form_category.name"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]):t._e(),t._v(" "),0==t.form_category.add?a("el-select",{attrs:{filterable:"",clearable:""},model:{value:t.form.category_id,callback:function(e){t.$set(t.form,"category_id",e)},expression:"form.category_id"}},t._l(t.categories,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.name}})}),1):t._e(),t._v(" "),t.errors.category_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.category_id[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.sale_affectation_igv_type_id}},[a("label",{staticClass:"control-label"},[t._v("Zona\n                                        "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Lugar en donde se despacha el producto",placement:"top-start"}},[a("i",{staticClass:"fa fa-info-circle"})])],1),t._v(" "),a("el-select",{model:{value:t.form.area_id,callback:function(e){t.$set(t.form,"area_id",e)},expression:"form.area_id"}},t._l(t.areas,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.sale_affectation_igv_type_id?a("small",{staticClass:"form-control-feedback",domProps:{textContent:t._s(t.errors.sale_affectation_igv_type_id[0])}}):t._e()],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:t.show_has_igv,expression:"show_has_igv"}],staticClass:"col-md-3 center-el-checkbox"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.has_igv}},[a("el-checkbox",{model:{value:t.form.has_igv,callback:function(e){t.$set(t.form,"has_igv",e)},expression:"form.has_igv"}},[t._v("Incluye Igv\n                                        "+t._s(t.configuration.include_igv))]),a("br"),t._v(" "),t.errors.has_igv?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.has_igv[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.location}},[a("label",{staticClass:"control-label"},[t._v("Ubicación del producto\n                                    ")]),t._v(" "),a("el-input",{attrs:{dusk:"name"},model:{value:t.form.location,callback:function(e){t.$set(t.form,"location",e)},expression:"form.location"}}),t._v(" "),t.errors.location?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.location[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.unit_type_id}},[a("label",{staticClass:"control-label"},[t._v("Unidad")]),t._v(" "),a("el-select",{attrs:{dusk:"unit_type_id"},model:{value:t.form.unit_type_id,callback:function(e){t.$set(t.form,"unit_type_id",e)},expression:"form.unit_type_id"}},t._l(t.unit_types,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.unit_type_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.unit_type_id[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.currency_type_id}},[a("label",{staticClass:"control-label"},[t._v("Moneda")]),t._v(" "),a("el-select",{attrs:{dusk:"currency_type_id"},model:{value:t.form.currency_type_id,callback:function(e){t.$set(t.form,"currency_type_id",e)},expression:"form.currency_type_id"}},t._l(t.currency_types,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.currency_type_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.currency_type_id[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.sale_unit_price}},[a("label",{staticClass:"control-label"},[t._v("Precio Unitario (Venta)\n                                        "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("el-input",{attrs:{dusk:"sale_unit_price"},on:{input:t.calculatePercentageOfProfitBySale},model:{value:t.form.sale_unit_price,callback:function(e){t.$set(t.form,"sale_unit_price",e)},expression:"form.sale_unit_price"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.sale_unit_price?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.sale_unit_price[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.sale_affectation_igv_type_id}},[a("label",{staticClass:"control-label"},[t._v("Tipo de afectación (Venta)")]),t._v(" "),a("el-select",{on:{change:t.changeAffectationIgvType},model:{value:t.form.sale_affectation_igv_type_id,callback:function(e){t.$set(t.form,"sale_affectation_igv_type_id",e)},expression:"\n                                        form.sale_affectation_igv_type_id\n                                    "}},t._l(t.affectation_igv_types,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.sale_affectation_igv_type_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.sale_affectation_igv_type_id[0])}}):t._e()],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:null==t.recordId&&"ZZ"!=t.form.unit_type_id,expression:"\n                                recordId == null &&\n                                form.unit_type_id != 'ZZ'\n                            "}],staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.stock}},[a("label",{staticClass:"control-label"},[t._v("Stock Inicial")]),t._v(" "),a("el-input",{model:{value:t.form.stock,callback:function(e){t.$set(t.form,"stock",e)},expression:"form.stock"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.stock?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.stock[0])}}):t._e()],1)]),t._v(" "),"ZZ"!=t.form.unit_type_id?a("div",{directives:[{name:"show",rawName:"v-show",value:null==t.recordId,expression:"recordId == null"}],staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.warehouse_id}},[a("label",{staticClass:"control-label"},[t._v("\n                                        Almacén\n                                        "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Si no selecciona almacén, se asignará por defecto el relacionado al establecimiento",placement:"top"}},[a("i",{staticClass:"fa fa-info-circle"})])],1),t._v(" "),a("el-select",{on:{change:t.changeWarehouse},model:{value:t.form.warehouse_id,callback:function(e){t.$set(t.form,"warehouse_id",e)},expression:"form.warehouse_id"}},t._l(t.warehouses,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.warehouse_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.warehouse_id[0])}}):t._e()],1)]):t._e(),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id,expression:"form.unit_type_id != 'ZZ'"}],staticClass:"col-md-3"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.date_of_due}},[a("label",{staticClass:"control-label"},[t._v("Fec. Vencimiento")]),t._v(" "),a("el-date-picker",{attrs:{type:"date","value-format":"yyyy-MM-dd",clearable:!0},model:{value:t.form.date_of_due,callback:function(e){t.$set(t.form,"date_of_due",e)},expression:"form.date_of_due"}}),t._v(" "),t.errors.date_of_due?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.date_of_due[0])}}):t._e()],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id,expression:"form.unit_type_id != 'ZZ'"}],staticClass:"col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"control-label"},[t._v("Cantidad Máxima\n                                        "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"La cantidad máxima representada en el envase/contenedor",placement:"top"}},[a("i",{staticClass:"fa fa-info-circle"})])],1),t._v(" "),a("el-input",{attrs:{disabled:0!=t.form.item_unit_types.length},model:{value:t.form.max_quantity,callback:function(e){t.$set(t.form,"max_quantity",e)},expression:"form.max_quantity"}})],1)]),t._v(" "),t.showSeries?a("div",{staticClass:"d-flex"},[a("div",{staticClass:"col-md-4"},[a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id,expression:"form.unit_type_id != 'ZZ'"}],staticClass:"col-md-3 center-el-checkbox"},[a("div",{staticClass:"form-group"},[a("el-checkbox",{on:{change:t.changeLotsEnabled},model:{value:t.form.series_enabled,callback:function(e){t.$set(t.form,"series_enabled",e)},expression:"form.series_enabled"}},[t._v("¿Maneja series?")]),a("br")],1)]),t._v(" "),"ZZ"!=t.form.unit_type_id&&t.form.series_enabled?a("div",{staticClass:"col-md-4 d-flex align-items-end"},[a("div",{staticClass:"form-group ",class:{"has-danger":t.errors.lot_code}},[a("label",{staticClass:"control-label"},[t._v("\n                                                Ingrese series\n                                            ")]),t._v(" "),a("el-button",{staticStyle:{"margin-top":"2%","margin-left":"15px"},attrs:{type:"primary",icon:"el-icon-edit-outline"},on:{click:function(e){return e.preventDefault(),t.clickLotcode.apply(null,arguments)}}}),t._v(" "),t.errors.lot_code?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.lot_code[0])}}):t._e()],1)]):t._e()]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id,expression:"form.unit_type_id != 'ZZ'"}],staticClass:"col-md-3 center-el-checkbox"},[a("div",{staticClass:"form-group"},[a("el-checkbox",{on:{change:t.changeLotsEnabled},model:{value:t.form.lots_enabled,callback:function(e){t.$set(t.form,"lots_enabled",e)},expression:"form.lots_enabled"}},[t._v("¿Maneja\n                                                lotes?")]),a("br")],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id&&t.form.lots_enabled,expression:"\n                                        form.unit_type_id != 'ZZ' &&\n                                        form.lots_enabled\n                                    "}],staticClass:"col-md-6"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.lot_code}},[a("label",{staticClass:"control-label"},[t._v("\n                                                Código lote\n                                            ")]),t._v(" "),a("el-input",{model:{value:t.form.lot_code,callback:function(e){t.$set(t.form,"lot_code",e)},expression:"form.lot_code"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.lot_code?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.lot_code[0])}}):t._e()],1)])])]):t._e()]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("h6",{staticClass:"separator-title"},[t._v("\n                                    Campos adicionales\n                                ")])]),t._v(" "),a("div",{staticClass:"row col-md-12"},[a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"control-label"},[t._v("Imágen\n                                            "),a("span",{staticClass:"text-danger"})]),t._v(" "),a("el-upload",{staticClass:"avatar-uploader",attrs:{data:{type:"items"},headers:t.headers,action:"/"+t.resource+"/uploads","show-file-list":!1,"on-success":t.onSuccess}},[t.form.image_url?a("img",{staticClass:"avatar",attrs:{src:t.form.image_url}}):a("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1)]),t._v(" "),a("div",{staticClass:"col-md-9"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.brand_id}},[a("label",{staticClass:"control-label"},[t._v("\n                                                    Marca\n                                                ")]),t._v(" "),0==t.form_brand.add?a("a",{staticClass:"control-label font-weight-bold text-info",attrs:{href:"#"},on:{click:function(e){t.form_brand.add=!0}}},[t._v("\n                                                    [ + Nuevo]")]):t._e(),t._v(" "),1==t.form_brand.add?a("a",{staticClass:"control-label font-weight-bold text-info",attrs:{href:"#"},on:{click:function(e){return t.saveBrand()}}},[t._v("\n                                                    [ + Guardar]")]):t._e(),t._v(" "),1==t.form_brand.add?a("a",{staticClass:"control-label font-weight-bold text-danger",attrs:{href:"#"},on:{click:function(e){t.form_brand.add=!1}}},[t._v("\n                                                    [ Cancelar]")]):t._e(),t._v(" "),1==t.form_brand.add?a("el-input",{staticStyle:{"margin-bottom":"1.5%"},attrs:{dusk:"item_code"},model:{value:t.form_brand.name,callback:function(e){t.$set(t.form_brand,"name",e)},expression:"form_brand.name"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]):t._e(),t._v(" "),0==t.form_brand.add?a("el-select",{attrs:{filterable:"",clearable:""},model:{value:t.form.brand_id,callback:function(e){t.$set(t.form,"brand_id",e)},expression:"form.brand_id"}},t._l(t.brands,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.name}})}),1):t._e(),t._v(" "),t.errors.brand_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.brand_id[0])}}):t._e()],1)]),t._v(" "),t.attribute_types.length>0?a("div",{staticClass:"col-md-12"},[a("h6",{staticClass:"separator-title "},[t._v("\n                                                Atributos\n                                                "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Diferentes presentaciones para la venta del producto",placement:"top"}},[a("i",{staticClass:"fa fa-info-circle"})]),t._v(" "),a("a",{staticClass:"control-label font-weight-bold text-info",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.clickAddAttribute.apply(null,arguments)}}},[t._v("[+ Agregar]")])],1)]):t._e(),t._v(" "),t.form.attributes.length>0?a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table"},[a("thead",[a("tr",[a("th",[t._v("Tipo")]),t._v(" "),a("th",[t._v("Descripción")]),t._v(" "),a("th")])]),t._v(" "),a("tbody",t._l(t.form.attributes,function(e,s){return a("tr",{key:s},[a("td",[a("el-select",{attrs:{filterable:""},on:{change:function(e){return t.changeAttributeType(s)}},model:{value:e.attribute_type_id,callback:function(a){t.$set(e,"attribute_type_id",a)},expression:"\n                                                                    row.attribute_type_id\n                                                                "}},t._l(t.attribute_types,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1)],1),t._v(" "),a("td",[a("el-input",{model:{value:e.value,callback:function(a){t.$set(e,"value",a)},expression:"\n                                                                    row.value\n                                                                "}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1),t._v(" "),a("td",[a("button",{staticClass:"btn btn-danger",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickRemoveAttribute(s)}}},[t._v(" x\n                                                                ")])])])}),0)])])]):t._e()])])])])]),t._v(" "),"ZZ"!=t.form.unit_type_id?a("el-tab-pane",{attrs:{label:"Almacenes"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("h5",{staticClass:"separator-title mt-0"},[t._v("\n                                    Precios por almacén\n                                ")]),t._v(" "),a("table",[a("tbody",t._l(t.form.warehouse_prices,function(e){return a("tr",{key:e.id},[a("td",{attrs:{width:"80%"}},[a("h3",[t._v(t._s(e.warehouse))])]),t._v(" "),a("td",[a("el-input",{attrs:{placeholder:"Precio de almacen"},on:{input:function(e){return t.$forceUpdate()}},model:{value:e.price,callback:function(a){t.$set(e,"price",a)},expression:"w.price"}})],1)])}),0)])])])]):t._e(),t._v(" "),a("el-tab-pane",{attrs:{label:"Lista de Precios"}},[a("div",{staticClass:"row"},[a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id,expression:"form.unit_type_id != 'ZZ'"}],staticClass:"col-md-12"},[a("h6",{staticClass:"separator-title "},[t._v("\n                                    Listado de precios\n                                    "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades",placement:"top"}},[a("i",{staticClass:"fa fa-info-circle"})]),t._v(" "),a("a",{staticClass:"control-label font-weight-bold text-info",attrs:{href:"#"},on:{click:t.clickAddRow}},[t._v("\n                                        [ + Nuevo]")])],1)]),t._v(" "),t.form.item_unit_types.length>0?a("div",{directives:[{name:"show",rawName:"v-show",value:"ZZ"!=t.form.unit_type_id,expression:"form.unit_type_id != 'ZZ'"}],staticClass:"col-md-12"},[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table"},[a("thead",[a("tr",[a("th",{staticClass:"text-center"},[t._v("\n                                                    Unidad\n                                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                                    Descripción\n                                                ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"13%"}},[t._v("\n                                                    Cantidad\n                                                    "),a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Cantidad de unidades",placement:"top"}},[a("i",{staticClass:"fa fa-info-circle"})])],1),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"13%"}},[t._v("\n                                                    Precio\n                                                    "),a("br"),t._v("\n                                                    unitario\n                                                ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"13%"}},[t._v("\n                                                    Total\n                                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                                    Almacen\n                                                ")]),t._v(" "),a("th",[t._v("Max."),a("br"),t._v("Cant.")])])]),t._v(" "),a("tbody",t._l(t.form.item_unit_types,function(e,s){return a("tr",{key:s},[e.id?[a("td",{staticClass:"text-center"},[t._v("\n                                                        "+t._s(e.unit_type_id)+"\n                                                    ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                                                        "+t._s(e.description)+"\n                                                    ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                                                        "+t._s(e.quantity_unit)+"\n                                                    ")]),t._v(" "),a("td",{staticClass:"text-center"},[a("el-input",{on:{input:function(a){return t.undToTotal(s,e.price2,e.quantity_unit)}},model:{value:e.price2,callback:function(a){t.$set(e,"price2",a)},expression:"row.price2"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1),t._v(" "),a("td",{staticClass:"text-center"},[a("el-input",{on:{input:function(a){return t.totalToUnd(s,e.total,e.quantity_unit)}},model:{value:e.total,callback:function(a){t.$set(e,"total",a)},expression:"row.total"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1),t._v(" "),a("td",[a("el-select",{attrs:{clearable:""},model:{value:e.warehouse_id,callback:function(a){t.$set(e,"warehouse_id",a)},expression:"\n                                                            row.warehouse_id\n                                                        "}},t._l(t.warehouses,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1)],1),t._v(" "),a("td",[a("el-checkbox",{on:{change:function(e){return t.selectedMax(s)}},model:{value:e.selected,callback:function(a){t.$set(e,"selected",a)},expression:"\n                                                            row.selected\n                                                        "}})],1),t._v(" "),a("td",{staticClass:"series-table-actions text-end"},[a("button",{staticClass:"btn waves-effect waves-light btn-sm btn-danger",attrs:{type:"button"},on:{click:function(a){return a.preventDefault(),t.clickDelete(e.id)}}},[a("i",{staticClass:"fa fa-trash"})])])]:[a("td",[a("div",{staticClass:"form-group"},[a("el-select",{attrs:{dusk:"item_unit_type.unit_type_id"},model:{value:e.unit_type_id,callback:function(a){t.$set(e,"unit_type_id",a)},expression:"\n                                                                row.unit_type_id\n                                                            "}},t._l(t.unit_types,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1)],1)]),t._v(" "),a("td",[a("div",{staticClass:"form-group"},[a("el-input",{model:{value:e.description,callback:function(a){t.$set(e,"description",a)},expression:"\n                                                                row.description\n                                                            "}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1)]),t._v(" "),a("td",[a("div",{staticClass:"form-group"},[a("el-input",{on:{input:function(a){return t.undToTotal(s,e.price2,e.quantity_unit)}},model:{value:e.quantity_unit,callback:function(a){t.$set(e,"quantity_unit",a)},expression:"\n    row.quantity_unit\n"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1)]),t._v(" "),a("td",[a("div",{staticClass:"form-group"},[a("el-input",{on:{input:function(a){return t.undToTotal(s,e.price2,e.quantity_unit)}},model:{value:e.price2,callback:function(a){t.$set(e,"price2",a)},expression:"\n                                                                row.price2\n                                                            "}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1)]),t._v(" "),a("td",[a("div",{staticClass:"form-group"},[a("el-input",{on:{input:function(a){return t.totalToUnd(s,e.total,e.quantity_unit)}},model:{value:e.total,callback:function(a){t.$set(e,"total",a)},expression:"\n                                                                row.total\n                                                            "}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1)]),t._v(" "),a("td",[a("el-select",{attrs:{clearable:""},model:{value:e.warehouse_id,callback:function(a){t.$set(e,"warehouse_id",a)},expression:"\n                                                            row.warehouse_id\n                                                        "}},t._l(t.warehouses,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1)],1),t._v(" "),a("td",[a("el-checkbox",{on:{change:function(e){return t.selectedMax(s)}},model:{value:e.selected,callback:function(a){t.$set(e,"selected",a)},expression:"\n                                                            row.selected\n                                                        "}})],1),t._v(" "),a("td",{staticClass:"series-table-actions text-end"},[a("button",{staticClass:"btn waves-effect waves-light btn-sm btn-danger",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickCancel(s)}}},[a("i",{staticClass:"fa fa-trash"})])])]],2)}),0)])])]):t._e()])]),t._v(" "),a("el-tab-pane",{attrs:{label:"Compras"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"short-div col-md-8"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.purchase_affectation_igv_type_id}},[a("label",{staticClass:"control-label"},[t._v("Tipo de afectación (Compra)")]),t._v(" "),a("el-select",{model:{value:t.form.purchase_affectation_igv_type_id,callback:function(e){t.$set(t.form,"purchase_affectation_igv_type_id",e)},expression:"\n                                        form.purchase_affectation_igv_type_id\n                                    "}},t._l(t.affectation_igv_types,function(t){return a("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.purchase_affectation_igv_type_id?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.purchase_affectation_igv_type_id[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"short-div col-md-4"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.purchase_unit_price}},[a("label",{staticClass:"control-label"},[t._v("Precio Unitario (Compra)")]),t._v(" "),a("el-input",{attrs:{dusk:"purchase_unit_price"},on:{input:t.calculatePercentageOfProfitByPurchase},model:{value:t.form.purchase_unit_price,callback:function(e){t.$set(t.form,"purchase_unit_price",e)},expression:"form.purchase_unit_price"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.purchase_unit_price?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.purchase_unit_price[0])}}):t._e()],1)]),t._v(" "),a("div",{staticClass:"short-div col-md-4"},[a("div",{staticClass:"form-group",class:{"has-danger":t.errors.percentage_of_profit}},[a("label",{staticClass:"control-label"},[a("el-checkbox",{on:{change:t.changeEnabledPercentageOfProfit},model:{value:t.enabled_percentage_of_profit,callback:function(e){t.enabled_percentage_of_profit=e},expression:"\n                                            enabled_percentage_of_profit\n                                        "}}),t._v("\n                                        Porcentaje de ganancia (%)\n                                    ")],1),t._v(" "),a("el-input",{attrs:{disabled:!t.enabled_percentage_of_profit},on:{input:t.calculatePercentageOfProfitByPercentage},model:{value:t.form.percentage_of_profit,callback:function(e){t.$set(t.form,"percentage_of_profit",e)},expression:"form.percentage_of_profit"}},[a("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.percentage_of_profit?a("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.percentage_of_profit[0])}}):t._e()],1)])])])],1)],1),t._v(" "),a("div",{staticClass:"form-actions text-end pt-2 pb-2"},[a("el-button",{on:{click:function(e){return e.preventDefault(),t.close()}}},[t._v("Cancelar")]),t._v(" "),a("el-button",{attrs:{type:"primary","native-type":"submit",loading:t.loading_submit}},[t._v("Guardar")])],1)]),t._v(" "),a("lots-form",{attrs:{showDialog:t.showDialogLots,stock:t.form.stock,recordId:t.recordId,lots:t.form.lots},on:{"update:showDialog":function(e){t.showDialogLots=e},"update:show-dialog":function(e){t.showDialogLots=e},addRowLot:t.addRowLot}})],1)},staticRenderFns:[]}}});
>>>>>>> master
=======
>>>>>>> master
//# sourceMappingURL=104.js.map