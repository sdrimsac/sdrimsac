webpackJsonp([194],{

/***/ "./modules/Inventory/Resources/assets/js/stockminReport/genOrdenCompra.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Inventory/Resources/assets/js/stockminReport/genOrdenCompra.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4533c61a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Inventory/Resources/assets/js/stockminReport/genOrdenCompra.vue")
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
Component.options.__file = "modules/Inventory/Resources/assets/js/stockminReport/genOrdenCompra.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4533c61a", Component.options)
  } else {
    hotAPI.reload("data-v-4533c61a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Inventory/Resources/assets/js/stockminReport/genOrdenCompra.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showGenOrdenCompra"],
  data: function data() {
    return {
      resource: 'reports/stockmin',
      loadingGenOrdenCom: false,
      ordenesCompra: [],
      loading_submit: false,
      loading_generar: false
    };
  },
  methods: {
    open: function open() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.loadingGenOrdenCom = true;

                _this.getItemsOrdenCompra();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    close: function close() {
      this.$emit("update:showGenOrdenCompra", false);
    },
    getItemsOrdenCompra: function getItemsOrdenCompra() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, status, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _context2.next = 3;
                return _this2.$http.get("/".concat(_this2.resource, "/recordsOrden"));

              case 3:
                response = _context2.sent;
                status = response.status, data = response.data;

                if (status == 200) {
                  _this2.ordenesCompra = data;
                } else {
                  console.log(response);
                }

                _context2.next = 11;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](0);

                _this2.$toast.error(_context2.t0.message);

              case 11:
                _context2.prev = 11;
                _this2.loadingGenOrdenCom = false;
                return _context2.finish(11);

              case 14:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 8, 11, 14]]);
      }))();
    },
    eliminarProdcutoLista: function eliminarProdcutoLista(id) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, message, status;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.loading_submit = true;
                _context3.prev = 1;
                _context3.next = 4;
                return _this3.$http.post("/".concat(_this3.resource, "/deletefromlist"), {
                  id: id
                });

              case 4:
                response = _context3.sent;
                message = response.message, status = response.status;

                if (!(status == 200)) {
                  _context3.next = 13;
                  break;
                }

                _this3.$toast.success('Producto eliminado de la Orden de compra ');

                _this3.$emit('callBrotherMethod');

                _context3.next = 11;
                return _this3.getItemsOrdenCompra();

              case 11:
                _context3.next = 14;
                break;

              case 13:
                console.log(response);

              case 14:
                _context3.next = 19;
                break;

              case 16:
                _context3.prev = 16;
                _context3.t0 = _context3["catch"](1);

                _this3.$toast.error(_context3.t0.message);

              case 19:
                _context3.prev = 19;
                _this3.loading_submit = false;
                return _context3.finish(19);

              case 22:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[1, 16, 19, 22]]);
      }))();
    },
    generarOrden: function generarOrden() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response, status, data, id;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.loading_generar = true;
                _context4.prev = 1;
                _context4.next = 4;
                return axios.post("/".concat(_this4.resource, "/genOrdenCompra"), {
                  ordenesCompra: _this4.ordenesCompra
                });

              case 4:
                response = _context4.sent;
                status = response.status, data = response.data;

                if (status == 200) {
                  id = data;
                  window.open("/".concat(_this4.resource, "/exportExcel/").concat(id), "_blank");

                  _this4.$toast.success('Orden generada Satisfactoriamente ');

                  _this4.$emit('callBrotherMethod');
                }

                _context4.next = 13;
                break;

              case 9:
                _context4.prev = 9;
                _context4.t0 = _context4["catch"](1);
                console.log(_context4.t0);

                _this4.$toast.error(_context4.t0.response.data.error);

              case 13:
                _context4.prev = 13;
                _this4.loading_generar = false;

                _this4.close();

                return _context4.finish(13);

              case 17:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[1, 9, 13, 17]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4533c61a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Inventory/Resources/assets/js/stockminReport/genOrdenCompra.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        visible: _vm.showGenOrdenCompra,
        "append-to-body": "",
        width: "60%",
        title: "Generar orden de compra "
      },
      on: { close: _vm.close, open: _vm.open }
    },
    [
      _c("div", [
        _c(
          "div",
          {
            directives: [
              {
                name: "loading",
                rawName: "v-loading",
                value: _vm.loadingGenOrdenCom,
                expression: "loadingGenOrdenCom"
              }
            ],
            staticClass: "container container table-responsive col-md-12"
          },
          [
            _c(
              "table",
              {
                staticClass:
                  "table table-hover table-striped table-condensed  table-responsive",
                staticStyle: { width: "100%", "white-space": "nowrap" }
              },
              [
                _c("thead", [
                  _c("tr", [
                    _c("th", [_vm._v("Acciones")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Producto")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Precio")]),
                    _vm._v(" "),
                    _c("th", [_vm._v("Proveedor")])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.ordenesCompra, function(data, idx) {
                    return _c("tr", { key: idx }, [
                      _c(
                        "td",
                        [
                          _c(
                            "el-button",
                            {
                              attrs: {
                                loading: _vm.loading_submit,
                                type: "danger",
                                size: "small"
                              },
                              on: {
                                click: function($event) {
                                  return _vm.eliminarProdcutoLista(data.id)
                                }
                              }
                            },
                            [_c("i", { staticClass: "fas fa-trash" })]
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(data.description))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(data.unit_price))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(data.name))])
                    ])
                  }),
                  0
                )
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "span",
        { attrs: { slot: "footer" }, slot: "footer" },
        [
          _vm.ordenesCompra.length != 0
            ? _c(
                "el-button",
                {
                  staticClass: "btn bg-primary",
                  attrs: { loading: _vm.loading_generar },
                  on: {
                    click: function($event) {
                      return _vm.generarOrden()
                    }
                  }
                },
                [_vm._v("Generar Orden")]
              )
            : _vm._e()
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
    require("vue-hot-reload-api")      .rerender("data-v-4533c61a", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=GenerarOrdenCompra.js.map