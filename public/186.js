webpackJsonp([186],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7e8628c1\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7e8628c1", Component.options)
  } else {
    hotAPI.reload("data-v-7e8628c1", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_query_string__);
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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showPendingOrdens", "areas"],
  data: function data() {
    return {
      form: {},
      ordens: [],
      loading: false,
      pagination: {},
      timer: null
    };
  },
  methods: {
    printTicket: function printTicket(id) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, url, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _context.next = 3;
                return _this.$http.get("/caja/worker/record/".concat(id, "?to_kitchen=1"));

              case 3:
                response = _context.sent;
                url = response.data.print;
                config = qz.configs.create(response.data.printer, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context.next = 9;
                  break;
                }

                _context.next = 9;
                return qz.websocket.connect(config);

              case 9:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: url
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this.$toast.error(e.message);
                }); //this.$toast.success("se esta imprimiendo el comprobante con exito");
                // qz.websocket.disconnect()

                _context.next = 16;
                break;

              case 13:
                _context.prev = 13;
                _context.t0 = _context["catch"](0);

                _this.$toast.error(_context.t0.message);

              case 16:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 13]]);
      }))();
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_1_query_string___default.a.stringify(_objectSpread({
        page: this.pagination.current_page
      }, this.form));
    },
    searchOrden: function searchOrden() {
      var _this2 = this;

      if (this.timer) {
        clearTimeout(this.timer);
      }

      this.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.getRecords();

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      })), 500);
    },
    getRecords: function getRecords() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var query, response, _response$data, data, meta;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                query = _this3.getQueryParameters();
                _context3.prev = 1;
                _this3.loading = true;
                _context3.next = 5;
                return _this3.$http("ordens-pending?".concat(query));

              case 5:
                response = _context3.sent;

                if (response.status == 200) {
                  _response$data = response.data, data = _response$data.data, meta = _response$data.meta;
                  _this3.ordens = data;
                  _this3.pagination = meta;
                }

                _context3.next = 12;
                break;

              case 9:
                _context3.prev = 9;
                _context3.t0 = _context3["catch"](1);

                _this3.$toast.error("Ocurrió un erro");

              case 12:
                _context3.prev = 12;
                _this3.loading = false;
                return _context3.finish(12);

              case 15:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[1, 9, 12, 15]]);
      }))();
    },
    open: function open() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                console.log(_this4.areas);

                _this4.getRecords();

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    close: function close() {
      this.form = {};
      this.$emit("update:showPendingOrdens", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7e8628c1\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/list_pending_ordens.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: { visible: _vm.showPendingOrdens, title: "Ordenes pendientes" },
      on: { close: _vm.close, open: _vm.open }
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
          staticClass: "card"
        },
        [
          _c("div", { staticClass: "d-flex" }, [
            _c(
              "div",
              { staticClass: "col-4", staticStyle: { "margin-top": "15px" } },
              [
                _c("el-input", {
                  attrs: { placeholder: "N° orden" },
                  on: { input: _vm.searchOrden },
                  model: {
                    value: _vm.form.value,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "value", $$v)
                    },
                    expression: "form.value"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "m-1" }),
          _vm._v(" "),
          _c("table", { staticClass: "table" }, [
            _c("thead", [
              _c("tr", [
                _c("th", [_vm._v("#")]),
                _vm._v(" "),
                _c("th", [_vm._v("Mesa")]),
                _vm._v(" "),
                _c("th", [_vm._v("Orden #")]),
                _vm._v(" "),
                _c("th", [_vm._v("Referencia")]),
                _vm._v(" "),
                _c("th", [_vm._v("Cantidad")]),
                _vm._v(" "),
                _c("th", [_vm._v("Hora")]),
                _vm._v(" "),
                _c("th")
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.ordens, function(ord, idx) {
                return _c("tr", { key: idx }, [
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(idx + 1) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(ord.table) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(ord.id) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(ord.ref || "-") +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [_vm._v(_vm._s(ord.orden_items.length))]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(ord.time) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "td",
                    [
                      _c("el-button", {
                        attrs: { type: "primary", icon: "el-icon-printer" },
                        on: {
                          click: function($event) {
                            return _vm.printTicket(ord.id)
                          }
                        }
                      })
                    ],
                    1
                  )
                ])
              }),
              0
            )
          ]),
          _vm._v(" "),
          _c("el-pagination", {
            attrs: {
              layout: "total, prev, pager, next",
              total: _vm.pagination.total,
              "current-page": _vm.pagination.current_page,
              "page-size": Number(_vm.pagination.per_page)
            },
            on: {
              "current-change": _vm.getRecords,
              "update:currentPage": function($event) {
                return _vm.$set(_vm.pagination, "current_page", $event)
              },
              "update:current-page": function($event) {
                return _vm.$set(_vm.pagination, "current_page", $event)
              }
            }
          })
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
    require("vue-hot-reload-api")      .rerender("data-v-7e8628c1", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=186.js.map