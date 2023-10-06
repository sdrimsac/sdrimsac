webpackJsonp([185],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2361a1f8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2361a1f8", Component.options)
  } else {
    hotAPI.reload("data-v-2361a1f8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);


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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['showDialog', 'payments'],
  data: function data() {
    return {
      titleDialog: 'Pagos',
      loading: false,
      errors: {},
      form: {},
      company: {},
      configuration: {},
      activeName: 'first',
      payment_method_types: [],
      payment_destinations: [],
      cards_brand: []
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
              return _this.$http.get("/pos/payment_tables").then(function (response) {
                _this.payment_method_types = response.data.payment_method_types;
                _this.cards_brand = response.data.cards_brand;
                _this.payment_destinations = response.data.payment_destinations; // this.clickAddPayment()

                // this.clickAddPayment()
                _this.getFormPosLocalStorage();
              });

            case 2:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    getFormPosLocalStorage: function getFormPosLocalStorage() {
      var form_pos = localStorage.getItem('form_pos');
      form_pos = JSON.parse(form_pos);

      if (form_pos) {
        if (form_pos.payments.length == 0) {
          this.clickAddPayment();
        } else {
          this.$eventHub.$emit('localSPayments', form_pos.payments);
        }
      }
    },
    create: function create() {},
    clickAddPayment: function clickAddPayment() {
      this.payments.push({
        id: null,
        document_id: null,
        sale_note_id: null,
        date_of_payment: moment().format('YYYY-MM-DD'),
        payment_method_type_id: '01',
        payment_destination_id: 'cash',
        reference: null,
        payment: 0
      });
      this.$emit('add', this.payments);
    },
    close: function close() {
      this.$emit('update:showDialog', false);
      this.$emit('add', this.payments);
    },
    clickCancel: function clickCancel(index) {
      this.payments.splice(index, 1);
      this.$emit('add', this.payments);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2361a1f8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/multiple_payment.vue":
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
        visible: _vm.showDialog,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "show-close": false
      },
      on: { open: _vm.create }
    },
    [
      _c("div", { staticClass: "form-body" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-lg-12" }, [
            _c("table", [
              _c("thead", [
                _c("tr", { attrs: { width: "100%" } }, [
                  _vm.payments.length > 0
                    ? _c("th", [_vm._v("Método de pago")])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.payments.length > 0
                    ? _c("th", [_vm._v("Destino")])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.payments.length > 0
                    ? _c("th", [_vm._v("Referencia")])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.payments.length > 0
                    ? _c("th", [_vm._v("Monto")])
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
                            return _vm.clickAddPayment.apply(null, arguments)
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
                _vm._l(_vm.payments, function(row, index) {
                  return _c("tr", { key: index }, [
                    _c("td", [
                      _c(
                        "div",
                        { staticClass: "form-group mb-2 mr-2" },
                        [
                          _c(
                            "el-select",
                            {
                              model: {
                                value: row.payment_method_type_id,
                                callback: function($$v) {
                                  _vm.$set(row, "payment_method_type_id", $$v)
                                },
                                expression: "row.payment_method_type_id"
                              }
                            },
                            _vm._l(_vm.payment_method_types, function(option) {
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
                              attrs: {
                                filterable: "",
                                disabled: row.payment_destination_disabled
                              },
                              model: {
                                value: row.payment_destination_id,
                                callback: function($$v) {
                                  _vm.$set(row, "payment_destination_id", $$v)
                                },
                                expression: "row.payment_destination_id"
                              }
                            },
                            _vm._l(_vm.payment_destinations, function(option) {
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
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c(
                        "div",
                        { staticClass: "form-group mb-2 mr-2" },
                        [
                          _c("el-input", {
                            model: {
                              value: row.reference,
                              callback: function($$v) {
                                _vm.$set(row, "reference", $$v)
                              },
                              expression: "row.reference"
                            }
                          })
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
                          _c("el-input", {
                            model: {
                              value: row.payment,
                              callback: function($$v) {
                                _vm.$set(row, "payment", $$v)
                              },
                              expression: "row.payment"
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
        { staticClass: "form-actions text-right pt-2" },
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
            [_vm._v("Cerrar")]
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
    require("vue-hot-reload-api")      .rerender("data-v-2361a1f8", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=185.js.map