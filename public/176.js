webpackJsonp([176],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/tables.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/tables.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-513fc1c6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/tables.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/tables.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-513fc1c6", Component.options)
  } else {
    hotAPI.reload("data-v-513fc1c6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/tables.vue":
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  //tabla color verde
  props: ["showTables", "table"],
  data: function data() {
    return {
      addingOrden: false,
      ordens: [],
      loading: false,
      resource: "/caja/tables/tables",
      tables: [],
      showOrdens: false,
      ordensSaved: [],
      top: "rounded-top",
      screenWidth: 0,
      hasTableOcuped: false,
      changingOrden: false,
      hasSelectedTableToChange: false,
      hasSelectedOrdenToChange: false,
      ordenToChange: null
    };
  },
  methods: {
    changeOrden: function changeOrden() {
      console.log("object");
      this.changingOrden = !this.changingOrden;
    },
    handleResize: function handleResize() {
      this.screenWidth = window.innerWidth;
    },
    addOrden: function addOrden() {
      this.addingOrden = !this.addingOrden;
    },
    sendOrdenToNewTable: function sendOrdenToNewTable(orden, table) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var orden_id, table_id, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                orden_id = orden.id;
                table_id = table.id;
                _context.prev = 2;
                _this.loading = true;
                _context.next = 6;
                return _this.$http.post("change-orden", {
                  orden_id: orden_id,
                  table_id: table_id
                });

              case 6:
                response = _context.sent;

                if (response.status == 200) {
                  _this.$toast.success("Orden cambiada con éxito");
                } else {
                  _this.$toast.error("Ocurrió un error, al cambiar la orden");
                }

                _context.next = 14;
                break;

              case 10:
                _context.prev = 10;
                _context.t0 = _context["catch"](2);
                console.log(_context.t0);

                _this.$toast.error("Ocurrió un error, al cambiar la orden");

              case 14:
                _context.prev = 14;
                _this.loading = false;

                _this.close();

                return _context.finish(14);

              case 18:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[2, 10, 14, 18]]);
      }))();
    },
    closeOrden: function closeOrden() {
      this.ordens = [];
      this.changingOrden = false;
      this.hasSelectedTableToChange = false;
      this.hasSelectedOrdenToChange = false;
      this.ordenToChange = null;
    },
    sendOrdens: function sendOrdens(orden) {
      if (this.changingOrden && !this.hasSelectedTableToChange) {
        this.hasSelectedTableToChange = true;
      } else if (this.changingOrden && this.hasSelectedTableToChange) {
        this.ordenToChange = orden;
        this.hasSelectedOrdenToChange = true;
        this.hasSelectedTableToChange = false;
      } else {
        this.$emit("sendOrdens", orden);
        this.close();
      }
    },
    selectTable: function selectTable(table) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, ordens;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this2.changingOrden && !_this2.hasSelectedTableToChange && _this2.hasSelectedOrdenToChange)) {
                  _context2.next = 8;
                  break;
                }

                if (!(table.status_table_id == 2)) {
                  _context2.next = 6;
                  break;
                }

                _this2.$toast.warning("La mesa no esta libre");

                return _context2.abrupt("return");

              case 6:
                _this2.sendOrdenToNewTable(_this2.ordenToChange, table);

                return _context2.abrupt("return");

              case 8:
                if (!_this2.addingOrden) {
                  _context2.next = 12;
                  break;
                }

                _this2.$emit("creatingOrden", table.number, table.id);

                _this2.close();

                return _context2.abrupt("return");

              case 12:
                if (!(table.status_table_id == 1)) {
                  _context2.next = 15;
                  break;
                }

                _this2.$toast.warning("La mesa no tiene ordenes");

                return _context2.abrupt("return");

              case 15:
                _this2.loading = true;
                _this2.tableSelectedNumber = table.number;
                _context2.prev = 17;
                _context2.next = 20;
                return _this2.$http("/caja/tables/orden/".concat(table.id));

              case 20:
                response = _context2.sent;

                if (response.status == 200) {
                  ordens = response.data.ordens;
                  _this2.ordens = ordens;

                  if (ordens.length == 1) {
                    _this2.sendOrdens(_this2.ordens[0]);
                  } else {
                    if (_this2.changingOrden) {
                      _this2.hasSelectedTableToChange = true;
                    }
                  }
                }

                _this2.loading = false;
                _context2.next = 29;
                break;

              case 25:
                _context2.prev = 25;
                _context2.t0 = _context2["catch"](17);
                _this2.loading = false;
                console.log(_context2.t0);

              case 29:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[17, 25]]);
      }))();
    },
    open: function open() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, tables;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.closeOrden();

                _context3.prev = 1;
                _this3.loading = true;
                _context3.next = 5;
                return _this3.$http(_this3.resource);

              case 5:
                response = _context3.sent;

                if (response.status == 200) {
                  tables = response.data.tables; //  this.tables = tables.filter(f => f.number != "caja");

                  _this3.tables = tables;
                  _this3.hasTableOcuped = tables.some(function (s) {
                    return s.status_table_id == 2;
                  });
                } else {
                  _this3.$toast.warning("Ocurrió un error");
                }

                _this3.loading = false;
                _context3.next = 15;
                break;

              case 10:
                _context3.prev = 10;
                _context3.t0 = _context3["catch"](1);
                _this3.loading = false;
                console.log(_context3.t0);

                _this3.$toast.warning("Ocurrió un error");

              case 15:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[1, 10]]);
      }))();
    },
    close: function close() {
      this.addingOrden = false;
      this.$emit("update:showTables", false);
    }
  },
  mounted: function mounted() {
    this.screenWidth = window.innerWidth;
    window.addEventListener("resize", this.handleResize);
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-513fc1c6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/tables.vue":
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
      class: { top: _vm.top },
      attrs: {
        visible: _vm.showTables,
        width: "70%",
        title: "ZONA DE ATENCIÓN ",
        "close-on-click-modal": false
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _vm.ordens.length == 0 || _vm.hasSelectedOrdenToChange
        ? _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "d-flex justify-content-end p-2" }, [
              _vm.hasTableOcuped
                ? _c(
                    "button",
                    {
                      class:
                        "btn " +
                        (_vm.changingOrden ? "btn-warning" : "btn-primary"),
                      attrs: { type: "button" },
                      on: { click: _vm.changeOrden }
                    },
                    [
                      _vm._v(
                        "\n                " +
                          _vm._s(
                            _vm.changingOrden
                              ? _vm.hasSelectedOrdenToChange
                                ? "Seleccione a la mesa destino"
                                : "Seleccionar mesa"
                              : "Cambiar orden"
                          ) +
                          "\n            "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "button",
                {
                  class:
                    "btn " + (_vm.addingOrden ? "btn-danger" : "btn-primary"),
                  staticStyle: { "margin-left": "15px" },
                  attrs: { type: "button" },
                  on: { click: _vm.addOrden }
                },
                [
                  _vm._v(
                    "\n                " +
                      _vm._s(
                        _vm.addingOrden ? "Seleccione mesa" : "Nueva orden"
                      ) +
                      "\n            "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-light",
                  staticStyle: { "margin-left": "15px" },
                  attrs: { type: "button" },
                  on: { click: _vm.close }
                },
                [_vm._v("\n                Cerrar\n            ")]
              )
            ]),
            _vm._v(" "),
            _vm.tables.length > 0
              ? _c(
                  "div",
                  { staticClass: "d-flex flex-wrap justify-content-center" },
                  _vm._l(_vm.tables, function(table, idx) {
                    return _c(
                      "div",
                      {
                        key: idx,
                        staticClass:
                          " col-2 btn   m-1 d-flex flex-column justify-content-center align-items-center ",
                        class:
                          "" +
                          (table.status_table_id == 1
                            ? "btn-primary"
                            : "btn-danger"),
                        staticStyle: {
                          "max-height": "136px",
                          "max-width": "135px"
                        },
                        on: {
                          click: function($event) {
                            return _vm.selectTable(table)
                          }
                        }
                      },
                      [
                        _c("strong", { staticClass: "h3 text-white  " }, [
                          _vm._v("Mesa")
                        ]),
                        _vm._v(" "),
                        _c("i", {
                          staticClass: "icofont-dining-table icofont-4x"
                        }),
                        _vm._v(" "),
                        _c("span", { staticClass: "h2  text-white" }, [
                          _vm._v(
                            "\n                    " +
                              _vm._s(table.number) +
                              "\n                "
                          )
                        ])
                      ]
                    )
                  }),
                  0
                )
              : _c(
                  "div",
                  {
                    staticClass:
                      "h-25 d-flex justify-content-center align-items-center"
                  },
                  [_c("span", [_vm._v("Sin mesas")])]
                )
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.ordens.length > 0 && !_vm.hasSelectedOrdenToChange
        ? _c("div", { staticClass: "card-body p-2" }, [
            _vm.hasSelectedTableToChange
              ? _c("div", { staticClass: "row" }, [
                  _c("h3", [_vm._v("Seleccione la orden a cambiar")])
                ])
              : _vm._e(),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "d-flex flex-wrap justify-content-left" },
              _vm._l(_vm.ordens, function(ord, idx) {
                return _c("div", { key: idx, staticClass: "col-3" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary p-1 m-1 ",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.sendOrdens(ord)
                        }
                      }
                    },
                    [
                      _c("span", { staticClass: "h3 text-white" }, [
                        _vm._v("#" + _vm._s(ord.id))
                      ]),
                      _c("br"),
                      _vm._v(" "),
                      _c("span", { staticClass: "h4 text-white" }, [
                        _vm._v(_vm._s(ord.ref ? ord.ref : "Sin referencia"))
                      ])
                    ]
                  )
                ])
              }),
              0
            ),
            _vm._v(" "),
            _c("div", { staticClass: "d-flex justify-content-end" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-light",
                  attrs: { type: "button" },
                  on: { click: _vm.closeOrden }
                },
                [_vm._v("\n                Regresar\n            ")]
              )
            ])
          ])
        : _vm._e()
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-513fc1c6", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=176.js.map