webpackJsonp([172],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-ad626c8c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ad626c8c", Component.options)
  } else {
    hotAPI.reload("data-v-ad626c8c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue":
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
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog"],
  data: function data() {
    return {
      loading: false,
      code: null,
      pin: null,
      transfer: null,
      time: null
    };
  },
  methods: {
    acceptTransfers: function acceptTransfers() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var form, response, _response$data, success, message;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this.loading = true;
                form = {
                  code: _this.code,
                  pin: _this.pin
                };
                _context.next = 5;
                return _this.$http.post("/transfers/accept_transfer", form);

              case 5:
                response = _context.sent;
                _response$data = response.data, success = _response$data.success, message = _response$data.message;

                if (success) {
                  _this.$toast.success(message);
                } else {
                  _this.$toast.error(message);
                }

                _this.close();

                _context.next = 15;
                break;

              case 11:
                _context.prev = 11;
                _context.t0 = _context["catch"](0);

                _this.$toast.error("Ocurri\xF3 un error ".concat(_context.t0));

                console.log(_context.t0);

              case 15:
                _context.prev = 15;
                _this.loading = false;
                return _context.finish(15);

              case 18:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 11, 15, 18]]);
      }))();
    },
    getTransfer: function getTransfer() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (_this2.code.length == 5) {
                  if (_this2.time) {
                    clearTimeout(_this2.time);
                  }

                  _this2.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
                    var response, _response$data2, message, success, transfer;

                    return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                      while (1) {
                        switch (_context2.prev = _context2.next) {
                          case 0:
                            _context2.prev = 0;
                            _this2.loading = true;
                            _context2.next = 4;
                            return _this2.$http("/transfers/places?code=".concat(_this2.code));

                          case 4:
                            response = _context2.sent;
                            _response$data2 = response.data, message = _response$data2.message, success = _response$data2.success, transfer = _response$data2.transfer;

                            if (success) {
                              _this2.transfer = transfer;
                            } else {
                              _this2.$toast.warning(message);
                            }

                            _context2.next = 12;
                            break;

                          case 9:
                            _context2.prev = 9;
                            _context2.t0 = _context2["catch"](0);
                            console.log(_context2.t0);

                          case 12:
                            _context2.prev = 12;
                            _this2.loading = false;
                            return _context2.finish(12);

                          case 15:
                          case "end":
                            return _context2.stop();
                        }
                      }
                    }, _callee2, null, [[0, 9, 12, 15]]);
                  })), 500);
                }

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.code = null;
      this.pin = null;
      this.transfer = null;
      this.time = null;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-ad626c8c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/transfer_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        "close-on-click-modal": false,
        width: "40%",
        visible: _vm.showDialog,
        title: "Aceptar Mercaderia "
      },
      on: { close: _vm.close }
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
          staticClass: "p-2"
        },
        [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("span", [_vm._v("Código de transferencia")]),
                _vm._v(" "),
                _c("el-input", {
                  on: { input: _vm.getTransfer },
                  model: {
                    value: _vm.code,
                    callback: function($$v) {
                      _vm.code = $$v
                    },
                    expression: "code"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("span", [_vm._v("PIN")]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { disabled: !_vm.transfer, "show-password": "" },
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
            _vm.transfer
              ? _c(
                  "div",
                  {
                    staticClass:
                      "col-md-4 d-flex align-items-end justify-content-start"
                  },
                  [
                    _c(
                      "el-button",
                      {
                        attrs: { type: "primary" },
                        on: { click: _vm.acceptTransfers }
                      },
                      [
                        _vm._v(
                          "\n                    Aceptar\n                "
                        )
                      ]
                    )
                  ],
                  1
                )
              : _vm._e()
          ]),
          _vm._v(" "),
          _vm.transfer
            ? [
                _c(
                  "div",
                  {
                    staticClass: "d-flex flex-column",
                    staticStyle: { "margin-top": "10px" }
                  },
                  [
                    _c("h5", [
                      _vm._v("\n                    De:\n                    "),
                      _c("strong", [
                        _vm._v(_vm._s(_vm.transfer.warehouse.description))
                      ])
                    ]),
                    _vm._v(" "),
                    _c("h5", [
                      _vm._v("\n                    A:\n                    "),
                      _c("strong", [
                        _vm._v(
                          _vm._s(_vm.transfer.warehouse_destination.description)
                        )
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "row", staticStyle: { "margin-top": "10px" } },
                  [
                    _c("table", [
                      _c("thead", [
                        _c("tr", [
                          _c("th", [_vm._v("#")]),
                          _vm._v(" "),
                          _c("th", [_vm._v("Producto")]),
                          _vm._v(" "),
                          _c("th", [_vm._v("Cantidad")])
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.transfer.detail, function(data, idx) {
                          return _c("tr", { key: idx }, [
                            _c("td", [_vm._v(_vm._s(idx + 1))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(data.item.description))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(data.quantity))])
                          ])
                        }),
                        0
                      )
                    ])
                  ]
                )
              ]
            : _vm._e(),
          _vm._v(" "),
          _c("div", { staticClass: "p-3" })
        ],
        2
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
    require("vue-hot-reload-api")      .rerender("data-v-ad626c8c", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=172.js.map