webpackJsonp([143],{

/***/ "./modules/College/Resources/assets/js/components/service_create.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/service_create.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1fb1bd46\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/service_create.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/components/service_create.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1fb1bd46", Component.options)
  } else {
    hotAPI.reload("data-v-1fb1bd46", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/service_create.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId", "external"],
  components: {},
  data: function data() {
    return {
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
        unit_type_id: "ZZ",
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
                _context3.next = 16;
                return _this10.$http.post("/".concat(_this10.resource), _this10.form).then(function (response) {
                  if (response.data.success) {
                    _this10.$toast.success(response.data.message);

                    _this10.$emit("add", response.data.data);

                    console.log(response); //this.$eventHub.$emit('reloadDataItems', response.data.id)

                    //this.$eventHub.$emit('reloadDataItems', response.data.id)
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

              case 16:
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1fb1bd46\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/service_create.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
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
                                attrs: { disabled: "", dusk: "unit_type_id" },
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
                              _c("label", { staticClass: "control-label" }, [
                                _vm._v("Stock Inicial")
                              ]),
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
                      )
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
    require("vue-hot-reload-api")      .rerender("data-v-1fb1bd46", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=143.js.map