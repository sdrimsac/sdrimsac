webpackJsonp([176],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-034492ae\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-034492ae", Component.options)
  } else {
    hotAPI.reload("data-v-034492ae", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue":
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


var PersonForm = function PersonForm() {
  return __webpack_require__.e/* import() */(124/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/persons/form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["items", "cash_id", "all_customers", "showDialog", "sellers"],
  components: {
    PersonForm: PersonForm
  },
  data: function data() {
    return {
      form: {},
      showDialogNewPerson: false,
      customers: [],
      resource: "quotations",
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
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this6.loading = true;
                _this6.form.time_of_issue = __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("HH:mm:ss");
                _context.next = 5;
                return _this6.$http.post("/".concat(_this6.resource), _this6.form);

              case 5:
                response = _context.sent;

                if (response.status == 200) {
                  _this6.$emit("limpiarForm");

                  _this6.close();

                  _this6.$toast.success('Cotizacion creada con exito');
                }

                _context.next = 14;
                break;

              case 9:
                _context.prev = 9;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);

                _this6.$toast.error("Ocurrió un error");

                _this6.$emit("");

              case 14:
                _context.prev = 14;
                _this6.loading = false;
                return _context.finish(14);

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 9, 14, 17]]);
      }))();
    },
    open: function open() {
      this.customers = this.all_customers;
      this.form = {
        date_of_issue: new Date(),
        currency_type_id: "PEN",
        exchange_rate_sale: 1,
        establishment_id: 1,
        prefix: "COT",
        purchase_order: null,
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
        operation_type_id: null,
        date_of_due: null,
        delivery_date: null,
        items: [],
        charges: [],
        discounts: [],
        attributes: [],
        guides: [],
        payment_method_type_id: "10",
        additional_information: null,
        shipping_address: null,
        account_number: null,
        terms_condition: null,
        active_terms_condition: false,
        actions: {
          format_pdf: "a4"
        },
        payments: [],
        sale_opportunity_id: null
      };
      this.paymentsOrden();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-034492ae\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/quotation_modal.vue":
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
      attrs: { title: "Cotización", visible: _vm.showDialog },
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
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", [_vm._v("Vencimiento")]),
              _vm._v(" "),
              _c("el-date-picker", {
                staticClass: "w-100",
                model: {
                  value: _vm.form.date_of_due,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "date_of_due", $$v)
                  },
                  expression: "form.date_of_due"
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
              _c("label", [
                _vm._v(
                  "\n                    Vendedor\n                 \n                "
                )
              ]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  attrs: { filterable: "" },
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
                    attrs: { value: option.id, label: option.name }
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
          _c(
            "div",
            { staticClass: "col-md-12" },
            [
              _c("label", [_vm._v("Descripción")]),
              _vm._v(" "),
              _c("el-input", {
                staticClass: "w-100",
                attrs: {
                  type: "textarea",
                  rows: 2,
                  placeholder: "Descripción"
                },
                model: {
                  value: _vm.form.description,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "description", $$v)
                  },
                  expression: "form.description"
                }
              })
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
                [_c("h6", [_vm._v("S/. " + _vm._s(_vm.form.total.toFixed(2)))])]
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
    require("vue-hot-reload-api")      .rerender("data-v-034492ae", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=176.js.map