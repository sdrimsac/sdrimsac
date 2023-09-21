webpackJsonp([196],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/tables.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/tables.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-118dd22e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/tables.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/tables.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-118dd22e", Component.options)
  } else {
    hotAPI.reload("data-v-118dd22e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/tables.vue":
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
//
//
//
//
//
//
//
//
//
//
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
      screenWidth: 0
    };
  },
  methods: {
    handleResize: function handleResize() {
      this.screenWidth = window.innerWidth;
    },
    addOrden: function addOrden() {
      this.addingOrden = !this.addingOrden;
    },
    closeOrden: function closeOrden() {
      this.ordens = [];
    },
    sendOrdens: function sendOrdens(orden) {
      this.$emit("sendOrdens", orden);
      this.close();
    },
    selectTable: function selectTable(table) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, ordens;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.addingOrden) {
                  _context.next = 4;
                  break;
                }

                _this.$emit("creatingOrden", table.number, table.id);

                _this.close();

                return _context.abrupt("return");

              case 4:
                if (!(table.status_table_id == 1)) {
                  _context.next = 7;
                  break;
                }

                _this.$toast.warning("La mesa no tiene ordenes");

                return _context.abrupt("return");

              case 7:
                _this.loading = true;
                _this.tableSelectedNumber = table.number;
                _context.prev = 9;
                _context.next = 12;
                return _this.$http("/caja/tables/orden/".concat(table.id));

              case 12:
                response = _context.sent;

                if (response.status == 200) {
                  ordens = response.data.ordens;
                  _this.ordens = ordens;

                  if (ordens.length == 1) {
                    _this.sendOrdens(_this.ordens[0]);
                  } else {
                    _this.showOrdens = true;
                  }
                }

                _this.loading = false;
                _context.next = 21;
                break;

              case 17:
                _context.prev = 17;
                _context.t0 = _context["catch"](9);
                _this.loading = false;
                console.log(_context.t0);

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[9, 17]]);
      }))();
    },
    open: function open() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, tables;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.closeOrden();

                _context2.prev = 1;
                _this2.loading = true;
                _context2.next = 5;
                return _this2.$http(_this2.resource);

              case 5:
                response = _context2.sent;

                if (response.status == 200) {
                  tables = response.data.tables; //  this.tables = tables.filter(f => f.number != "caja");

                  _this2.tables = tables;
                } else {
                  _this2.$toast.warning("Ocurrió un error");
                }

                _this2.loading = false;
                _context2.next = 15;
                break;

              case 10:
                _context2.prev = 10;
                _context2.t0 = _context2["catch"](1);
                _this2.loading = false;
                console.log(_context2.t0);

                _this2.$toast.warning("Ocurrió un error");

              case 15:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[1, 10]]);
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-118dd22e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/tables.vue":
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
      _vm.ordens.length == 0
        ? _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "d-flex justify-content-end p-2" }, [
              _c(
                "button",
                {
                  class:
                    "btn " + (_vm.addingOrden ? "btn-danger" : "btn-primary"),
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
      _vm.ordens.length > 0
        ? _c("div", { staticClass: "card-body p-2" }, [
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
    require("vue-hot-reload-api")      .rerender("data-v-118dd22e", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=196.js.map