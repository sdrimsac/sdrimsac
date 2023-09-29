webpackJsonp([180],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-3eca56c2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3eca56c2", Component.options)
  } else {
    hotAPI.reload("data-v-3eca56c2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["ordenInBox", "showPullApart"],
  methods: {
    open: function open() {},
    close: function close() {
      this.$emit("update:showPullApart", false);
    },
    restoreOrden: function restoreOrden(ordens) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var res, ref;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.$confirm("Desea restaurar la venta?", "Cancelar", {
                  confirmButtonText: "Ok",
                  cancelButtonText: "Cancelar",
                  type: "success"
                });

              case 2:
                res = _context.sent;

                if (res) {
                  ref = ordens.ref;

                  _this.removeFromStorage(ref);

                  _this.$emit("restoreToLocalOrdens", ordens.ordens);

                  _this.close();
                }

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    removeApart: function removeApart(ref) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var res;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.$confirm("Desea eliminar la venta?", "Cancelar", {
                  confirmButtonText: "Ok",
                  cancelButtonText: "Cancelar",
                  type: "warning"
                });

              case 2:
                res = _context2.sent;

                if (res) {
                  _this2.removeFromStorage(ref);

                  _this2.$toast.success("Venta eliminada");

                  if (newApart.length == 0) {
                    _this2.close();
                  }
                }

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    removeFromStorage: function removeFromStorage(ref) {
      var newApart = this.ordenInBox.filter(function (f) {
        return f.ref != ref;
      });
      localStorage.ordens = JSON.stringify(newApart);
      this.$emit("update:ordenInBox", newApart);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-3eca56c2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/ordens_pull_apart.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        visible: _vm.showPullApart,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "append-to-body": "",
        title: "Ventas Aparcadas"
      },
      on: { close: _vm.close, open: _vm.open }
    },
    [
      _c("div", {}, [
        _vm.ordenInBox.length > 0
          ? _c("table", { staticClass: "table" }, [
              _c("thead", [
                _c("tr", [
                  _c("th", [
                    _vm._v("\n                        #\n                    ")
                  ]),
                  _vm._v(" "),
                  _c("th", { staticClass: "text-center" }, [
                    _vm._v(
                      "\n                        DNI / Referencia\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("th", { staticClass: "text-center" }, [
                    _vm._v(
                      "\n                        Cantidad\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("th")
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.ordenInBox, function(aparted, idx) {
                  return _c("tr", { key: idx }, [
                    _c("td", [_vm._v(_vm._s(idx + 1))]),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(_vm._s(aparted.ref))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(_vm._s(aparted.ordens.length))
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticClass: "text-center" },
                      [
                        _c(
                          "el-button",
                          {
                            attrs: { type: "success" },
                            on: {
                              click: function($event) {
                                return _vm.restoreOrden(aparted)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Restaurar\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "el-button",
                          {
                            attrs: { type: "danger" },
                            on: {
                              click: function($event) {
                                return _vm.removeApart(aparted.ref)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Eliminar\n                        "
                            )
                          ]
                        )
                      ],
                      1
                    )
                  ])
                }),
                0
              )
            ])
          : _c("div", { staticClass: "d-flex justify-content-center" }, [
              _c("span", [_vm._v("Sin ventas aparcadas")])
            ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "p-2 d-flex justify-content-end" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-light",
            attrs: { type: "button" },
            on: { click: _vm.close }
          },
          [_vm._v("\n            CERRAR\n        ")]
        )
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
    require("vue-hot-reload-api")      .rerender("data-v-3eca56c2", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=180.js.map