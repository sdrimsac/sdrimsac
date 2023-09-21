webpackJsonp([187],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-17d3c188\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-17d3c188", Component.options)
  } else {
    hotAPI.reload("data-v-17d3c188", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);


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


var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(124/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["items", "cash_id", "all_customers", "showDialog", "all_series", "establishments"],
  components: {
    PersonForm: PersonForm
  },
  data: function data() {
    return {
      form: {},
      tasaInteres: 17,
      disabled_month: false,
      credit: {},
      showDialogNewPerson: false,
      customers: [],
      errors: {},
      resource: "sale-notes",
      loading_search: false,
      percentage_igv: 18,
      loading: false
    };
  },
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadDataPersons", function (customer_id) {
      _this.reloadDataCustomers(customer_id);
    });
  },
  watch: {
    all_customers: function all_customers(newCustomer, _) {
      this.customers = newCustomer.filter(function (n) {
        return n.number != "88888888";
      });
    }
  },
  methods: {
    validate: function validate() {
      var flag = true;

      if (this.tasaInteres < 0) {
        this.$toast.error("La tasa de interes no puede ser negativa");
        flag = false;
      }

      if (this.credit.advances > this.form.total) {
        this.$toast.error("El monto de adelanto no puede ser mayor a la venta total");
        flag = false;
      }

      if (this.credit.month == 0) {
        this.$toast.error("El tiempo no puede ser 0");
        flag = false;
      }

      if (this.form.customer_id == null) {
        this.$toast.error("Debe seleccionar un cliente");
        flag = false;
      }

      return flag;
    },
    initCredit: function initCredit() {
      this.credit = {
        num_cuota: 0,
        amount: 0,
        month: 0,
        advances: 0
      };
    },
    advances_total: function advances_total() {
      if (this.credit.advances > this.form.total) {
        return this.$toast.error("el monto de adelanto no puede ser mayor ala venta total");
      } else {
        this.credit.total_balance = (this.form.total - this.credit.advances).toFixed(2);
        this.calculate(this.credit.advances);
      }
    },
    calculate: function calculate() {
      var advance = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      // let dias = 0;
      var tasa_interes = 0;

      if (this.form.total > 0 && this.credit.month > 0) {
        switch (this.credit.type_payment) {
          case "Diario":
            this.credit.num_cuota = 26 * parseInt(this.credit.month); // dias = 26 * this.form.month;

            break;

          case "Semanal":
            this.credit.num_cuota = 4 * this.credit.month; // dias = 7 * this.credit.month;

            break;

          case "Mensual":
            this.credit.num_cuota = this.credit.month; // dias = 30 * this.credit.month;

            break;
        }

        if (this.tasaInteres > 0) {
          var total_financiar = parseFloat(this.form.total || "0") - parseFloat(this.credit.advances || "0");
          tasa_interes = this.tasaInteres * this.credit.month || 0;
          tasa_interes = tasa_interes.toFixed(2);
          var calcular_cuota = (total_financiar * (this.tasaInteres * this.credit.month / 100) + total_financiar) / this.credit.num_cuota;
          this.credit.amount = calcular_cuota.toFixed(2);
        } else {
          var amount = parseInt(this.form.total) / parseInt(this.credit.num_cuota);
          this.credit.amount = amount.toFixed(2);
        }

        this.credit.tasadefault = tasa_interes;
      }
    },
    reloadDataCustomers: function reloadDataCustomers(customer_id) {
      var _this2 = this;

      this.$http.get("/documents/search/customer/".concat(customer_id)).then(function (response) {
        _this2.customers = response.data.customers;
        _this2.form.customer_id = customer_id;
      });
    },
    paymentsOrden: function paymentsOrden() {
      var items = this.items;
      var ordens = items;

      for (var i = 0; i < items.length; i++) {
        var item = items[i];
        ordens[i].food.item.from_unit_type_id = item.type_id;
        ordens[i].food.item.from_unit_type_id_desc = item.type_description;
        ordens[i].food.item.quantity = item.quantity;
        ordens[i].food.item.lotes = item.lotes;
        ordens[i].food.item.lots = item.series;
        ordens[i].food.item.sale_unit_price = item.price;
        ordens[i].food.price = item.price;
      }

      this.form.items = ordens.map(function (o) {
        return o.food.item;
      });
      this.formatItems(ordens);
    },
    formatItems: function formatItems(ordens) {
      var _this3 = this;

      this.form.items = this.form.items.map(function (i) {
        var _objectSpread2;

        return _objectSpread(_objectSpread({}, i), {}, (_objectSpread2 = {
          warehouse_id: null,
          item: i,
          item_id: i.id,
          unit_value: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price / (1 + _this3.percentage_igv / 100) : i.sale_unit_price,
          quantity: i.quantity,
          aux_quantity: i.quantity,
          total_base_igv: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this3.percentage_igv / 100) : i.sale_unit_price * i.quantity,
          percentage_igv: _this3.percentage_igv,
          total_igv: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this3.percentage_igv / 100) * (_this3.percentage_igv / 100) : 0,
          total_base_isc: 0.0,
          percentage_isc: 0.0,
          total_isc: 0.0,
          total_base_other_taxes: 0.0,
          percentage_other_taxes: 0.0,
          total_other_taxes: 0.0,
          total_taxes: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this3.percentage_igv / 100) * (_this3.percentage_igv / 100) : 0,
          total_value: i.sale_affectation_igv_type_id == 10 ? i.sale_unit_price * i.quantity / (1 + _this3.percentage_igv / 100) : i.quantity * i.sale_unit_price,
          total_charge: 0.0,
          total_discount: 0.0,
          total: i.sale_unit_price * i.quantity,
          price_type_id: "01",
          unit_price: i.sale_unit_price,
          unit_price_value: i.sale_unit_price,
          has_igv: i.has_igv,
          affectation_igv_type_id: i.sale_affectation_igv_type_id
        }, _defineProperty(_objectSpread2, "unit_price", i.sale_unit_price), _defineProperty(_objectSpread2, "presentation", null), _defineProperty(_objectSpread2, "charges", []), _defineProperty(_objectSpread2, "discounts", []), _defineProperty(_objectSpread2, "attributes", []), _defineProperty(_objectSpread2, "affectation_igv_type", i.sale_affectation_igv_type_id), _objectSpread2));
      });
      this.calculateTotal(ordens);
    },
    calculateTotal: function calculateTotal(ordens) {
      var _this4 = this;

      var total_discount = 0;
      var total_charge = 0;
      var total_exportation = 0;
      var total_taxed = 0;
      var total_taxes = 0;
      var total_exonerated = 0;
      var total_unaffected = 0;
      var total_free = 0;
      var total_igv = 0;
      var total_value = 0;
      var total = 0;
      ordens.forEach(function (orden) {
        total += _.round(orden.food.item.quantity * orden.food.price, 2);
      }); //  total_igv = _.round((total / (1+(this.percentage_igv/100))) * (this.percentage_igv/100), 2);

      this.form.items.forEach(function (row) {
        total_discount += parseFloat(row.total_discount);
        total_charge += parseFloat(row.total_charge);
        total_taxes += parseFloat(row.total_taxes);

        if (row.sale_affectation_igv_type_id === "10") {
          total_igv += _.round(parseFloat(row.total_value) * (_this4.percentage_igv / 100), 2);
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

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
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
    },
    searchRemoteCustomers: function searchRemoteCustomers(input) {
      var _this5 = this;

      if (input.length > 0) {
        this.loading_search = true;
        var parameters = "input=".concat(input);
        this.$http.get("/".concat(this.resource, "/search/customers?").concat(parameters)).then(function (response) {
          _this5.customers = response.data.customers;
          _this5.loading_search = false;

          if (_this5.customers.length == 0) {
            _this5.customers = _this5.all_customers;
          }
        });
      } else {
        this.customers = this.all_customers;
      }
    },
    submit: function submit() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var serie, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (_this6.validate()) {
                  _context.next = 2;
                  break;
                }

                return _context.abrupt("return", false);

              case 2:
                serie = _this6.all_series.find(function (serie) {
                  return serie.document_type_id == "80";
                });

                if (serie) {
                  _context.next = 5;
                  break;
                }

                return _context.abrupt("return", _this6.$toast.error("No se encontró una serie para el comprobante"));

              case 5:
                _this6.form.series_id = serie.id;
                _this6.form.establishment_id = _this6.establishments.id;
                _context.prev = 7;
                _this6.loading = true;
                _this6.form = _objectSpread(_objectSpread({}, _this6.form), _this6.credit);
                _this6.form.time_of_issue = __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("HH:mm:ss");
                _context.next = 13;
                return _this6.$http.post("/".concat(_this6.resource), _this6.form);

              case 13:
                response = _context.sent;

                if (response.status == 200) {
                  _this6.$toast.success("Se el crédito se registró correctamente");

                  _this6.$emit("limpiarForm");

                  _this6.close();
                }

                _context.next = 22;
                break;

              case 17:
                _context.prev = 17;
                _context.t0 = _context["catch"](7);
                console.log(_context.t0);

                _this6.$toast.error("Ocurrió un error");

                _this6.$emit("");

              case 22:
                _context.prev = 22;
                _this6.loading = false;
                return _context.finish(22);

              case 25:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[7, 17, 22, 25]]);
      }))();
    },
    open: function open() {
      this.initCredit();
      this.customers = this.all_customers;
      this.form = {
        id: null,
        afectar_caja: true,
        restaurant: false,
        series_id: null,
        generate: true,
        prefix: "NV",
        month: 0,
        establishment_id: null,
        date_of_issue: __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD"),
        time_of_issue: __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("HH:mm:ss"),
        customer_id: null,
        currency_type_id: "PEN",
        purchase_order: null,
        exchange_rate_sale: 0,
        advances: 0,
        total_balance: 0,
        total_advances: 0,
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
        total_rounded: 0,
        total_payment: 0,
        tasadefault: 0,
        operation_type_id: null,
        items: [],
        charges: [],
        discounts: [],
        attributes: [],
        guides: [],
        payments: [],
        additional_information: null,
        actions: {
          format_pdf: "a4"
        },
        apply_concurrency: false,
        type_period: null,
        quantity_period: 0,
        automatic_date_of_issue: null,
        enabled_concurrency: false,
        license_plate: null,
        paid: false,
        user_id: null,
        observation: null,
        difference: 0,
        type_payment: "Diario",
        num_cuota: 0,
        amount: 0,
        method_pay: "Efectivo"
      };
      this.paymentsOrden();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-17d3c188\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/credit_modal.vue":
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
      attrs: { title: "Crédito", visible: _vm.showDialog, width: "950px" },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "m-2" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", [
                _vm._v("\n                    Cliente\n                    "),
                _c(
                  "a",
                  {
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        _vm.showDialogNewPerson = true
                      }
                    }
                  },
                  [_vm._v("[+ Nuevo]")]
                )
              ]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "border-left rounded-left border-info",
                  attrs: {
                    filterable: "",
                    remote: "",
                    "popper-class": "el-select-customers",
                    dusk: "customer_id",
                    placeholder:
                      "Escriba el nombre o número de documento del cliente",
                    "remote-method": _vm.searchRemoteCustomers,
                    loading: _vm.loading_search
                  },
                  model: {
                    value: _vm.form.customer_id,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "customer_id", $$v)
                    },
                    expression: "form.customer_id"
                  }
                },
                _vm._l(_vm.customers, function(option) {
                  return _c("el-option", {
                    key: option.id,
                    attrs: { value: option.id, label: option.description }
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
              _c("label", [_vm._v("Fecha de emisión")]),
              _vm._v(" "),
              _c("el-date-picker", {
                staticClass: "w-100",
                attrs: { "value-format": "Y-m-d" },
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
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c(
              "div",
              { staticClass: "form-group" },
              [
                _c("label", { staticClass: "control-label w-100" }, [
                  _vm._v("Tiempo (Mes)")
                ]),
                _vm._v(" "),
                _c("el-input-number", {
                  attrs: {
                    disabled: _vm.disabled_month,
                    controls: false,
                    min: 0,
                    max: 60
                  },
                  on: { change: _vm.calculate },
                  model: {
                    value: _vm.credit.month,
                    callback: function($$v) {
                      _vm.$set(_vm.credit, "month", $$v)
                    },
                    expression: "credit.month"
                  }
                }),
                _vm._v(" "),
                _vm.errors.month
                  ? _c("small", {
                      staticClass: "text-danger",
                      domProps: { textContent: _vm._s(_vm.errors.month[0]) }
                    })
                  : _vm._e()
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4" },
            [
              _c("label", { staticClass: "control-label w-100" }, [
                _vm._v("Cronograma de Pago\n                    "),
                _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
              ]),
              _vm._v(" "),
              _c(
                "el-radio-group",
                {
                  attrs: { size: "mini" },
                  on: { change: _vm.calculate },
                  model: {
                    value: _vm.credit.type_payment,
                    callback: function($$v) {
                      _vm.$set(_vm.credit, "type_payment", $$v)
                    },
                    expression: "credit.type_payment"
                  }
                },
                [
                  _c("el-radio-button", { attrs: { label: "Diario" } }),
                  _vm._v(" "),
                  _c("el-radio-button", { attrs: { label: "Semanal" } }),
                  _vm._v(" "),
                  _c("el-radio-button", { attrs: { label: "Mensual" } })
                ],
                1
              ),
              _vm._v(" "),
              _vm.errors.type_payment
                ? _c("small", {
                    staticClass: "text-danger",
                    domProps: {
                      textContent: _vm._s(_vm.errors.type_payment[0])
                    }
                  })
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c("label", { staticClass: "control-label w-100" }, [
              _vm._v("Nº Cuota "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ]),
            _vm._v(" "),
            _c("b", [_vm._v(_vm._s(_vm.credit.num_cuota) + " ")]),
            _vm._v(" "),
            _vm.errors.num_cuota
              ? _c("small", {
                  staticClass: "text-danger",
                  domProps: { textContent: _vm._s(_vm.errors.num_cuota[0]) }
                })
              : _vm._e()
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-2" },
            [
              _c("label", { staticClass: "control-label w-100" }, [
                _vm._v("Tasa %"),
                _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
              ]),
              _vm._v(" "),
              _c("el-input-number", {
                attrs: { controls: false },
                on: { change: _vm.calculate },
                model: {
                  value: _vm.tasaInteres,
                  callback: function($$v) {
                    _vm.tasaInteres = $$v
                  },
                  expression: "tasaInteres"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c("label", { staticClass: "control-label w-100" }, [
              _vm._v("Cuota "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ]),
            _vm._v(" "),
            _c("b", [_vm._v(_vm._s(_vm.credit.amount))]),
            _vm._v(" "),
            _vm.errors.amount
              ? _c("small", {
                  staticClass: "text-danger",
                  domProps: { textContent: _vm._s(_vm.errors.amount[0]) }
                })
              : _vm._e()
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-2" },
            [
              _c("label", { staticClass: "control-label w-100" }, [
                _vm._v("Adelanto "),
                _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
              ]),
              _vm._v(" "),
              _c("el-input-number", {
                attrs: { "controls-position": "right" },
                on: {
                  blur: function($event) {
                    return _vm.advances_total()
                  }
                },
                model: {
                  value: _vm.credit.advances,
                  callback: function($$v) {
                    _vm.$set(_vm.credit, "advances", $$v)
                  },
                  expression: "credit.advances"
                }
              }),
              _vm._v(" "),
              _vm.errors.advances
                ? _c("small", {
                    staticClass: "text-danger",
                    domProps: { textContent: _vm._s(_vm.errors.advances[0]) }
                  })
                : _vm._e()
            ],
            1
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "dialog-footer",
          attrs: { slot: "footer" },
          slot: "footer"
        },
        [
          _vm.form.total
            ? _c(
                "span",
                {
                  staticStyle: {
                    "margin-right": "auto",
                    display: "inline-block"
                  }
                },
                [_c("h6", [_vm._v("S/. " + _vm._s(_vm.form.total))])]
              )
            : _vm._e(),
          _vm._v(" "),
          _c("el-button", { on: { click: _vm.close } }, [_vm._v("Cancelar")]),
          _vm._v(" "),
          _c(
            "el-button",
            { attrs: { type: "primary" }, on: { click: _vm.submit } },
            [_vm._v("Enviar")]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("person-form", {
        attrs: {
          showDialog: _vm.showDialogNewPerson,
          type: "customers",
          external: true
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogNewPerson = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogNewPerson = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-17d3c188", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=187.js.map