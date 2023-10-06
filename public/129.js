webpackJsonp([129],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/items/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_lots_vue__ = __webpack_require__("./resources/js/views/items/partials/lots.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_lots_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__partials_lots_vue__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "recordId", "external", "worker"],
  components: {
    LotsForm: __WEBPACK_IMPORTED_MODULE_1__partials_lots_vue___default.a
  },
  data: function data() {
    return {
      loading: true,
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
      form: {
        promotion_count: null
      },
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

                if (_this.worker) {
                  _this.warehouses = _this.warehouses.filter(function (w) {
                    return w.establishment_id == _this.worker.establishment_id;
                  });
                  _this.form.warehouse_id = _this.warehouses[0].id;
                }

                _this.categories = response.data.categories;
                _this.brands = response.data.brands;
                _this.attribute_types = response.data.attribute_types;
                _this.configuration = response.data.configuration;
                _this.areas = response.data.areas;
                _this.form.sale_affectation_igv_type_id = _this.affectation_igv_types.length > 0 ? _this.affectation_igv_types[0].id : null;
                _this.form.purchase_affectation_igv_type_id = _this.affectation_igv_types.length > 0 ? _this.affectation_igv_types[0].id : null;

                if (!_this.configuration.restaurant) {
                  _this.areas = _this.areas.filter(function (a) {
                    return !["BARRA", "COCINA", "MOZO", "MESA"].some(function (p) {
                      return p == a.description;
                    });
                  });
                } //agregar opciones para entorno restaurante

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
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
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
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
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
              case "end":
                return _context2.stop();
            }
          }
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
    generateCode: function generateCode() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this5.loading = true;
                _context3.next = 3;
                return _this5.$http("/items/generate_code");

              case 3:
                response = _context3.sent;
                _this5.form.internal_id = response.data;
                _this5.loading = false;

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    create: function create() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this6.titleDialog = _this6.recordId ? "Editar Productos" : "Nuevo Producto";

                if (!_this6.recordId) {
                  _context4.next = 5;
                  break;
                }

                _this6.$http.get("/".concat(_this6.resource, "/record/").concat(_this6.recordId)).then(function (response) {
                  _this6.form = response.data.data;

                  if (_this6.form.warehouse_prices.length == 0) {
                    if (_this6.warehouses.length > 0) {
                      _this6.form.warehouse_id = _this6.warehouses[0].id;
                      _this6.form.warehouse_prices = _this6.warehouses.map(function (w) {
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
                    _this6.form.warehouse_prices = _this6.warehouses.map(function (w) {
                      var exist = _this6.form.warehouse_prices.find(function (ww) {
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

                  if (_this6.form.item_unit_types.length != 0) {
                    _this6.restoreUnitTypes();
                  }

                  _this6.has_percentage_perception = _this6.form.percentage_perception ? true : false;

                  _this6.changeAffectationIgvType();

                  _this6.showSeries = true;

                  if (_this6.form.series_enabled == 1) {
                    _this6.form.series_enabled = true;
                  } else _this6.form.series_enabled = false;
                });

                _context4.next = 10;
                break;

              case 5:
                if (_this6.warehouses.length > 0) {
                  _this6.form.warehouse_id = _this6.warehouses[0].id;
                  _this6.form.warehouse_prices = _this6.warehouses.map(function (w) {
                    return {
                      id: null,
                      item_id: null,
                      warehouse_id: w.id,
                      price: null,
                      warehouse: w.description
                    };
                  });
                }

                _context4.next = 8;
                return _this6.generateCode();

              case 8:
                _this6.showSeries = true;
                _this6.form.area_id = 2;

              case 10:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    restoreUnitTypes: function restoreUnitTypes() {
      var _this7 = this;

      var hasSelected = false;
      this.form.item_unit_types = this.form.item_unit_types.map(function (i) {
        var selected = false;

        if (!hasSelected && Number(_this7.form.max_quantity) == Number(i.quantity_unit)) {
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
      var _this8 = this;

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this8.form = response.data.data;

          _this8.changeAffectationIgvType();
        });
      }
    },
    changeWarehouse: function changeWarehouse() {
      var _this9 = this;

      this.$toast.warning("Cambió el destino del producto, verifique los PRECIOS DE ALMACÉN");
      var w = this.form.warehouse_prices.find(function (ww) {
        return ww.warehouse_id == _this9.form.warehouse_id;
      });

      if (w) {
        w.price = this.form.sale_unit_price;
      }

      this.$forceUpdate();
    },
    calculatePercentageOfProfitBySale: function calculatePercentageOfProfitBySale() {
      var _this10 = this;

      var w = this.form.warehouse_prices.find(function (ww) {
        return ww.warehouse_id == _this10.form.warehouse_id;
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
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (!(_this11.form.max_quantity && !_this11.form.max_quantity_description)) {
                  _context5.next = 3;
                  break;
                }

                _this11.$toast.warning("Ingrese una descripción del contenedor para la cantidad máxima");

                return _context5.abrupt("return", false);

              case 3:
                if (_this11.form.category_id) {
                  _context5.next = 6;
                  break;
                }

                _this11.$toast.warning("Seleccione una categoria");

                return _context5.abrupt("return", false);

              case 6:
                if (!(_this11.form.internal_id == null || _this11.form.internal_id == "")) {
                  _context5.next = 9;
                  break;
                }

                _this11.$refs.internal_id.$el.querySelector("input").focus();

                return _context5.abrupt("return", _this11.$toast.warning("No puede guardar Un nuevo Producto sin codigo interno "));

              case 9:
                if (!(_this11.form.has_perception && !_this11.form.percentage_perception)) {
                  _context5.next = 11;
                  break;
                }

                return _context5.abrupt("return", _this11.$toast.error("Ingrese un porcentaje"));

              case 11:
                if (_this11.form.warehouse_id) {
                  _context5.next = 13;
                  break;
                }

                return _context5.abrupt("return", _this11.$toast.error("Seleccione un almacen"));

              case 13:
                if (!_this11.recordId && _this11.form.lots_enabled) {// if (!this.form.lot_code)
                  //     return this.$toast.error("Código de lote es requerido");
                  // if (!this.form.date_of_due)
                  //     return this.$toast.error(
                  //         "Fecha de vencimiento es requerido si lotes esta habilitado."
                  //     );
                }

                if (!(!_this11.recordId && _this11.form.series_enabled)) {
                  _context5.next = 19;
                  break;
                }

                if (!(_this11.form.lots.length > _this11.form.stock)) {
                  _context5.next = 17;
                  break;
                }

                return _context5.abrupt("return", _this11.$toast.error("La cantidad de series registradas es superior al stock"));

              case 17:
                if (!(_this11.form.lots.length != _this11.form.stock)) {
                  _context5.next = 19;
                  break;
                }

                return _context5.abrupt("return", _this11.$toast.error("La cantidad de series registradas son diferentes al stock"));

              case 19:
                _this11.loading_submit = true;
                _this11.form.all_establishment = _this11.allEstablishment;
                _context5.next = 23;
                return _this11.$http.post("/".concat(_this11.resource), _this11.form).then(function (response) {
                  if (response.data.success) {
                    _this11.$toast.success(response.data.message);

                    if (_this11.external) {
                      _this11.$emit("add", response.data.data); //this.$eventHub.$emit('reloadDataItems', response.data.id)

                    } else {
                      _this11.$eventHub.$emit("reloadData");
                    }

                    _this11.close();
                  } else {
                    _this11.$toast.error(response.data.message);
                  }
                })["catch"](function (error) {
                  if (error.response.status === 422) {
                    _this11.errors = error.response.data.errors;
                  } else {
                    console.log(error);
                  }
                }).then(function () {
                  _this11.loading_submit = false;
                });

              case 23:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
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
      var _this12 = this;

      this.form_category.add = false;
      this.$http.post("/items/categories", this.form_category).then(function (response) {
        if (response.data.success) {
          _this12.$toast.success(response.data.message);

          _this12.categories.push(response.data.data);

          _this12.form.category_id = response.data.data.id;
          _this12.form_category.name = null;
        } else {
          _this12.$toast.error("No se guardaron los cambios");
        }
      })["catch"](function (error) {});
    },
    saveBrand: function saveBrand() {
      var _this13 = this;

      this.form_brand.add = false;
      this.$http.post("/brands", this.form_brand).then(function (response) {
        if (response.data.success) {
          _this13.$toast.success(response.data.message);

          _this13.brands.push(response.data.data);

          _this13.form_brand.name = null;
        } else {
          _this13.$toast.error("No se guardaron los cambios");
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "lots", "stock", "recordId"],
  data: function data() {
    return {
      currentPage: 1,
      lots_splice: [],
      titleDialog: "Series",
      loading: false,
      errors: {},
      form: {},
      states: ["Activo", "Inactivo", "Desactivado", "Voz", "M2m"]
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
    handleCurrentChange: function handleCurrentChange(val) {
      this.currentPage = val;
      this.lots_splice = this.lots.slice((val - 1) * 20, val * 20);
    },
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
                  series: data
                });

              case 2:
                duplicates = _context2.sent;

                if (duplicates.length > 1) {
                  _this.lots[index].series = null;
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

        this.lots_splice = this.lots.slice(0, 20);
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
        this.$emit("addRowLot", this.lots);
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
                  message: "El campo serie es obligatorio"
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
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
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
                return _this3.$emit("addRowLot", _this3.lots);

              case 7:
                _context4.next = 9;
                return _this3.$emit("update:showDialog", false);

              case 9:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickAddLot: function clickAddLot() {
      if (!this.recordId) {
        if (this.lots.length >= this.stock) return this.$toast.error("La cantidad de registros es superior al stock o cantidad");
      }

      this.lots.push({
        id: null,
        item_id: null,
        series: null,
        date: moment().format("YYYY-MM-DD"),
        state: "Activo"
      });
      this.$emit("addRowLot", this.lots);
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.$emit("addRowLot", this.lots);
      this.lots_splice = [];
    },
    clickCancel: function clickCancel(index) {
      this.lots.splice(index, 1); // item.deleted = true

      this.$emit("addRowLot", this.lots);
    },
    clickCancelSubmit: function clickCancelSubmit() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this4.$emit("addRowLot", []);

                _context5.next = 3;
                return _this4.$emit("update:showDialog", false);

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }, "close", function close() {
    this.$emit("update:showDialog", false);
  })
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-cd4ba31c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/items/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      attrs: {
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
                            _vm.errors.internal_id
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.internal_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
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
                                attrs: { disabled: _vm.configuration.college },
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
                                  attrs: {
                                    disabled: _vm.configuration.init_stock == 1
                                  },
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
                      _c("div", { staticClass: "col-md-3" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: { "has-danger": _vm.errors.barcode }
                          },
                          [
                            _c(
                              "label",
                              { staticClass: "control-label" },
                              [
                                _vm._v(
                                  "Código Externo\n                            "
                                ),
                                _c(
                                  "el-tooltip",
                                  {
                                    staticClass: "item",
                                    attrs: {
                                      effect: "dark",
                                      content:
                                        "Código Barra de la empresa para el control de sus productos",
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
                                attrs: { dusk: "barcode" },
                                model: {
                                  value: _vm.form.barcode,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "barcode", $$v)
                                  },
                                  expression: "form.barcode"
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
                            _vm.errors.barcode
                              ? _c("small", {
                                  staticClass: "text-danger",
                                  domProps: {
                                    textContent: _vm._s(_vm.errors.barcode[0])
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
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
                                      attrs: {
                                        disabled:
                                          _vm.configuration.college ||
                                          _vm.allEstablishment
                                      },
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
                                  })
                                : _vm._e()
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
                            { staticClass: "form-group" },
                            [
                              _c(
                                "label",
                                { staticClass: "control-label" },
                                [
                                  _vm._v(
                                    "Contenedor\n                                    "
                                  ),
                                  _c(
                                    "el-tooltip",
                                    {
                                      staticClass: "item",
                                      attrs: {
                                        effect: "dark",
                                        content:
                                          "Nombre del contenedor de la cantidad máxima Ej. Botella, Caja, Saco",
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
                                attrs: { disabled: !_vm.form.max_quantity },
                                model: {
                                  value: _vm.form.max_quantity_description,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.form,
                                      "max_quantity_description",
                                      $$v
                                    )
                                  },
                                  expression: "form.max_quantity_description"
                                }
                              })
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
                                    "Add. Delivery\n                                    "
                                  ),
                                  _c(
                                    "el-tooltip",
                                    {
                                      staticClass: "item",
                                      attrs: {
                                        effect: "dark",
                                        content:
                                          "Valor agregado al enviar el producto por delivery",
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
                                model: {
                                  value: _vm.form.delivery_cost,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "delivery_cost", $$v)
                                  },
                                  expression: "form.delivery_cost"
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
                              _vm.form.series_enabled &&
                              _vm.recordId == null
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
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.configuration.promotions_sell
                        ? _c("div", { staticClass: "d-flex" }, [
                            _c("div", { staticClass: "col-md-3" }, [
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
                                  staticClass: "col-md-6 center-el-checkbox"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "form-group" },
                                    [
                                      _c(
                                        "el-checkbox",
                                        {
                                          model: {
                                            value: _vm.form.is_promotion,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.form,
                                                "is_promotion",
                                                $$v
                                              )
                                            },
                                            expression: "form.is_promotion"
                                          }
                                        },
                                        [_vm._v("¿Maneja Promocion ?")]
                                      ),
                                      _c("br")
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "el-input",
                                    {
                                      attrs: { type: "number" },
                                      model: {
                                        value: _vm.form.promotion_count,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.form,
                                            "promotion_count",
                                            $$v
                                          )
                                        },
                                        expression: "form.promotion_count"
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
                                ],
                                1
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
          _c(
            "div",
            { staticClass: "col-lg-12 col-md-12" },
            [
              _c("table", { attrs: { width: "100%" } }, [
                _c("thead", [
                  _c("tr", { attrs: { width: "100%" } }, [
                    _vm.lots.length > 0
                      ? _c("th", [_vm._v("Serie")])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.lots.length > 0
                      ? _c("th", [_vm._v("Estado")])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.lots.length > 0
                      ? _c("th", [_vm._v("Fecha")])
                      : _vm._e(),
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
                  _vm._l(_vm.lots_splice, function(row, index) {
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
              ]),
              _vm._v(" "),
              _c("el-pagination", {
                attrs: {
                  "current-page": _vm.currentPage,
                  "page-size": 20,
                  total: _vm.lots.length,
                  layout: "total, prev, pager, next"
                },
                on: { "current-change": _vm.handleCurrentChange }
              })
            ],
            1
          )
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
    require("vue-hot-reload-api")      .rerender("data-v-f9fd823e", module.exports)
  }
}

/***/ }),

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


/***/ })

});
//# sourceMappingURL=129.js.map