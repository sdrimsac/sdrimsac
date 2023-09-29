webpackJsonp([174],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6293f490\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6293f490", Component.options)
  } else {
    hotAPI.reload("data-v-6293f490", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue":
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

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showSplitPayment", "total", "orden_items"],
  data: function data() {
    return {
      selectedAccount: undefined,
      splitByAmount: "1",
      number: 2,
      numberProduct: 2,
      payments: [],
      items: []
    };
  },
  created: function created() {
    var payment = _.round(this.total / 2, 1);

    this.payments = [{
      fixed: false,
      amount: payment
    }, {
      fixed: false,
      amount: payment
    }];

    if (this.total != payment * 2) {
      this.payments[0].amount += _.round(payment * 2 - this.total, 1);
    }
  },
  methods: {
    totalItemSelected: function totalItemSelected(products) {
      var total = 0;
      products.forEach(function (p) {
        total += p.quantity * p.price;
      });
      return _.round(total, 2);
    },
    removeItem: function removeItem(id) {
      var idx = this.payments.findIndex(function (p) {
        return p.selected;
      });

      if (idx > -1) {
        var indexItem = this.payments[idx].products.findIndex(function (p) {
          return p.id == id;
        });

        if (indexItem > -1) {
          var quantity = this.payments[idx].products[indexItem].quantity;

          if (quantity == 1) {
            this.payments[idx].products = _toConsumableArray(this.payments[idx].products.filter(function (p) {
              return p.id != id;
            }));
          } else {
            this.payments[idx].products[indexItem].quantity -= 1;
          }

          var item = this.items.find(function (i) {
            return i.id == id;
          });
          ++item.quantity;

          if (item.quantity == 1) {
            this.items = [item].concat(_toConsumableArray(this.items.filter(function (i) {
              return i.id != item.id;
            })));
          }
        }
      }
    },
    addItem: function addItem(item) {
      //checar la lista
      //a que cuenta le estas agregando
      if (item.quantity == 0) {
        this.$toast.warning("No quedan unidades disponibles para dividir el producto");
        return;
      }

      var idx = this.payments.findIndex(function (p) {
        return p.selected;
      });

      if (idx > -1) {
        var indexItem = this.payments[idx].products.findIndex(function (p) {
          return p.id == item.id;
        });

        if (indexItem > -1) {
          this.payments[idx].products[indexItem].quantity += 1;
        } else {
          this.payments[idx].products.push({
            price: item.price,
            description: item.food.description,
            id: item.id,
            quantity: 1
          });
        }

        --item.quantity;

        if (item.quantity == 0) {
          this.items = [].concat(_toConsumableArray(this.items.filter(function (i) {
            return i.id != item.id;
          })), [item]);
        }
      } else {
        this.$toast.warning("Seleccione una cuenta");
      }
    },
    sendPayments: function sendPayments() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!(_this.splitByAmount == "1")) {
                  _context.next = 4;
                  break;
                }

                _this.$emit("receivePayments", _this.payments);

                _context.next = 8;
                break;

              case 4:
                if (!_this.items.some(function (i) {
                  return i.quantity > 0;
                })) {
                  _context.next = 7;
                  break;
                }

                _this.$toast.error("Aún hay productos por dividir");

                return _context.abrupt("return");

              case 7:
                _this.$emit("receiveProducts", _this.payments);

              case 8:
                _this.close();

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    changePayment: function changePayment(idx) {
      var fixed = this.payments.filter(function (p) {
        return p.fixed;
      });
      var numberFixed = fixed.length;

      if (fixed.length > 0) {
        //obtengo el monto de los pagos fijos
        fixed = fixed.reduce(function (a, b) {
          return {
            amount: a.amount + b.amount,
            fixed: true
          };
        });

        if (isNaN(fixed.amount) && fixed.amount > 0) {
          //el monto que resta del total con los pagos fijos
          var rest = this.total - fixed.amount;
          var inputSelected = this.payments[idx]; //encontrar el input modificado y dejar el precio

          rest = rest - inputSelected.amount; //
        }
      }
    },
    paymentByAmount: function paymentByAmount() {
      var payment = _.round(this.total / this.number, 1);

      this.payments = Array.from({
        length: this.number
      }, function (_, i) {
        return {
          fixed: false,
          amount: payment
        };
      });
      payment;

      if (this.total != payment * this.number) {
        this.payments[0].amount += _.round(this.total - payment * this.number, 1);
      }

      this.payments.map(function (p) {
        return _objectSpread(_objectSpread({}, p), {}, {
          amount: _.round(p.amount, 2)
        });
      });
    },
    updatePayments: function updatePayments() {
      if (this.number < 2 || isNaN(this.number)) {
        this.number = 2;
      }

      if (this.splitByAmount == "1") {
        this.paymentByAmount();
      } else {
        this.paymentByProducts();
      }
    },
    selectAccount: function selectAccount(idx) {
      if (this.selectedAccount != undefined || this.selectedAccount != null) {
        this.payments[this.selectedAccount].selected = false;
      }

      this.payments[idx].selected = true;
      this.selectedAccount = idx;
    },
    paymentByProducts: function paymentByProducts() {
      this.payments = [];
      this.restoreItems();
      var hasProducts = this.payments.some(function (p) {
        return p.products;
      });
      var toAdd = this.numberProduct;

      if (hasProducts) {
        toAdd = this.numberProduct - this.payments.length;
      }

      this.payments = [].concat(_toConsumableArray(this.payments), _toConsumableArray(Array.from({
        length: toAdd
      }, function (_, i) {
        return {
          fixed: false,
          amount: 0,
          products: [],
          selected: false
        };
      })));
    },
    restoreItems: function restoreItems() {
      this.items = JSON.parse(JSON.stringify(this.orden_items.items));
    },
    open: function open() {
      this.payments = [];
      this.restoreItems(); //   this.number = 2;
      //  {
      //         fixed: false,
      //         amount: _.round(this.total / 2, 2)
      //     },
      //     {
      //         fixed: false,
      //         amount: _.round(this.total / 2, 2)
      //     }
    },
    close: function close() {
      this.items = [];
      this.$emit("update:showSplitPayment", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6293f490\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/split_payment.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        "append-to-body": "",
        visible: _vm.showSplitPayment,
        title: "Dividir pago: S/. " + _vm.total,
        width: "70%"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "d-flex flex-column p-2" }, [
        _c("div", { staticClass: "d-flex flex-row align-items-end" }, [
          _c(
            "div",
            [
              _c("label", { attrs: { for: "" } }, [_vm._v("Dividir entre:")]),
              _c("br"),
              _vm._v(" "),
              _vm.splitByAmount == "1"
                ? _c("el-input-number", {
                    attrs: { max: 10 },
                    on: { input: _vm.updatePayments },
                    model: {
                      value: _vm.number,
                      callback: function($$v) {
                        _vm.number = $$v
                      },
                      expression: "number"
                    }
                  })
                : _c("el-input-number", {
                    attrs: { max: _vm.items.length },
                    on: { input: _vm.updatePayments },
                    model: {
                      value: _vm.numberProduct,
                      callback: function($$v) {
                        _vm.numberProduct = $$v
                      },
                      expression: "numberProduct"
                    }
                  })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticStyle: { "margin-left": "10px" } },
            [
              _c(
                "el-radio-group",
                {
                  on: { change: _vm.updatePayments },
                  model: {
                    value: _vm.splitByAmount,
                    callback: function($$v) {
                      _vm.splitByAmount = $$v
                    },
                    expression: "splitByAmount"
                  }
                },
                [
                  _c("el-radio-button", { attrs: { label: "1" } }, [
                    _vm._v("Por cuotas")
                  ]),
                  _vm._v(" "),
                  _c("el-radio-button", { attrs: { label: "2" } }, [
                    _vm._v("Por producto")
                  ])
                ],
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _vm.splitByAmount == "1"
          ? _c(
              "div",
              { staticClass: "d-flex flex-wrap " },
              _vm._l(_vm.payments, function(payment, idx) {
                return _c("div", { key: idx, staticClass: "col-3" }, [
                  _c(
                    "div",
                    {
                      staticStyle: {
                        "margin-top": "10px",
                        "margin-right": "5px"
                      }
                    },
                    [
                      _c("h2", { staticClass: "text-muted text-small" }, [
                        _vm._v(
                          "\n                        Cuota " +
                            _vm._s(idx + 1) +
                            "\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        attrs: { readonly: "" },
                        model: {
                          value: payment.amount,
                          callback: function($$v) {
                            _vm.$set(payment, "amount", $$v)
                          },
                          expression: "payment.amount"
                        }
                      })
                    ],
                    1
                  )
                ])
              }),
              0
            )
          : _c("div", [
              _c(
                "div",
                { staticClass: "d-flex flex-wrap" },
                _vm._l(_vm.items, function(item, idx) {
                  return _c("div", { key: idx, staticClass: "col-2" }, [
                    _c(
                      "div",
                      {
                        staticClass: "card p-1",
                        staticStyle: {
                          "margin-top": "10px",
                          "margin-right": "5px"
                        },
                        attrs: { role: "button" },
                        on: {
                          click: function($event) {
                            return _vm.addItem(item)
                          }
                        }
                      },
                      [
                        _c("h2", { staticClass: "text-muted text-small" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(item.food.description) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("h3", { staticClass: "text-muted text-small" }, [
                          _vm._v(
                            "\n                            S/. " +
                              _vm._s(item.price) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "h3",
                          {
                            class:
                              " text-small " +
                              (item.quantity == 0
                                ? "text-danger"
                                : "text-muted")
                          },
                          [
                            _vm._v(
                              "\n                            Cantidad: " +
                                _vm._s(item.quantity) +
                                "\n                        "
                            )
                          ]
                        )
                      ]
                    )
                  ])
                }),
                0
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "d-flex flex-wrap justify-content-center",
                  staticStyle: { "margin-top": "15px" }
                },
                _vm._l(_vm.payments, function(payment, idx) {
                  return _c(
                    "div",
                    {
                      key: idx,
                      staticClass: "col-3 ",
                      staticStyle: { margin: "5px" }
                    },
                    [
                      _c("table", { staticClass: "col-12" }, [
                        _c("thead", [
                          _c(
                            "tr",
                            {
                              class:
                                "" +
                                (payment.selected
                                  ? "bg-primary text-white border rounded-top"
                                  : "border rounded-top"),
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
                                    _vm._v(" CUENTA " + _vm._s(idx + 1) + " ")
                                  ])
                                ]
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        payment.products && payment.products.length > 0
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
                                          staticClass: "text-muted text-small"
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        " +
                                              _vm._s(product.quantity) +
                                              "\n                                    "
                                          )
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _c(
                                        "h3",
                                        {
                                          staticClass: "text-muted text-small"
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        " +
                                              _vm._s(product.description) +
                                              "\n                                    "
                                          )
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      {
                                        staticStyle: { "text-align": "right" }
                                      },
                                      [
                                        _c(
                                          "h3",
                                          {
                                            staticClass: "text-muted text-small"
                                          },
                                          [
                                            _vm._v(
                                              "\n                                        " +
                                                _vm._s(
                                                  product.price *
                                                    product.quantity
                                                ) +
                                                "\n\n                                        "
                                            ),
                                            _c(
                                              "b",
                                              {
                                                staticClass: "text-danger",
                                                attrs: { role: "button" },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.removeItem(
                                                      product.id
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                            x\n                                        "
                                                )
                                              ]
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
                                      staticClass: "text-muted text-small",
                                      staticStyle: { "text-align": "right" },
                                      attrs: { colspan: "2" }
                                    },
                                    [
                                      _c("b", [
                                        _vm._v(
                                          "\n                                        Total\n                                    "
                                        )
                                      ])
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    { staticClass: "text-muted text-small" },
                                    [
                                      _vm._v(
                                        "\n                                    S/.\n                                    " +
                                          _vm._s(
                                            _vm.totalItemSelected(
                                              payment.products
                                            )
                                          ) +
                                          "\n                                "
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
                                      { staticClass: "text-muted text-small" },
                                      [
                                        _vm._v(
                                          "\n                                        Sin productos seleccionados\n                                    "
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            ])
                      ])
                    ]
                  )
                }),
                0
              )
            ]),
        _vm._v(" "),
        _c("div", { staticClass: "row d-flex m-2 justify-content-end" }, [
          _c(
            "div",
            { staticClass: "col-3 d-flex justify-content-end" },
            [
              _c(
                "el-button",
                { attrs: { type: "primary" }, on: { click: _vm.sendPayments } },
                [_vm._v("Listo")]
              )
            ],
            1
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6293f490", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=174.js.map