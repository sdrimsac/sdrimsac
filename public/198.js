webpackJsonp([198],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/payments_internet.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/payments_internet.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-69a7fd82\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/payments_internet.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/payments_internet.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-69a7fd82", Component.options)
  } else {
    hotAPI.reload("data-v-69a7fd82", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/payments_internet.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_query_string__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "registerId", "person", "establishment", "configuration"],
  data: function data() {
    return {
      number: null,
      showWhatsappModal: false,
      payments: [],
      pagination: {},
      loading: false
    };
  },
  methods: {
    openWhatsapp: function openWhatsapp() {
      this.number = this.person.telephone;
    },
    sendWhatsapp: function sendWhatsapp() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var number, linkpdf, file_name, formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                number = _this.number; //check if number is numeric and has 9 digits

                if (!(number && number.length == 9 && !isNaN(number))) {
                  _context.next = 20;
                  break;
                }

                linkpdf = "/payments_print/".concat(_this.registerId);
                file_name = "Estado de cuenta_" + (_this.person ? _this.person.name + "_" : "_") + __WEBPACK_IMPORTED_MODULE_1_moment___default()().format("YYYY-MM-DD") + ".pdf";
                _context.prev = 4;
                _this.loading = true;
                formWhatsapp = {
                  resource: linkpdf,
                  file_name: file_name,
                  number: _this.number,
                  message: "Estado_de_cuenta"
                };
                _context.next = 9;
                return _this.$http.post("/whatsapp/historial", formWhatsapp);

              case 9:
                response = _context.sent;
                _context.next = 14;
                break;

              case 12:
                _context.prev = 12;
                _context.t0 = _context["catch"](4);

              case 14:
                _context.prev = 14;
                _this.loading = false;
                _this.showWhatsappModal = false;
                return _context.finish(14);

              case 18:
                _context.next = 21;
                break;

              case 20:
                _this.$toast.error("Ingrese un número válido");

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[4, 12, 14, 18]]);
      }))();
    },
    print: function print() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var _this2$establishment$;

        var printer, linkpdf, paperConfig, config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                printer = (_this2$establishment$ = _this2.establishment.printer) !== null && _this2$establishment$ !== void 0 ? _this2$establishment$ : _this2.establishment.printer_serve;

                if (printer) {
                  _context2.next = 4;
                  break;
                }

                _this2.$toast.error("No se ha configurado una impresora");

                return _context2.abrupt("return");

              case 4:
                linkpdf = "/payments_print/".concat(_this2.registerId);
                paperConfig = {
                  scaleContent: false
                };
                config = qz.configs.create(printer, paperConfig);

                if (qz.websocket.isActive()) {
                  _context2.next = 10;
                  break;
                }

                _context2.next = 10;
                return qz.websocket.connect(config);

              case 10:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: linkpdf
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this2.$toast.error(e.message);
                });

              case 12:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    open: function open() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                console.log(_this3.establishment);
                _context3.next = 3;
                return _this3.getPayments();

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    close: function close() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.$emit("update:showDialog", false);

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    viewDocument: function viewDocument(url) {
      window.open(url);
    },
    getDocumentName: function getDocumentName(_ref) {
      var document = _ref.document,
          sale_note = _ref.sale_note;
      var doc = document !== null && document !== void 0 ? document : sale_note;

      if (sale_note) {
        doc.a4 = "/sale-notes/print/".concat(sale_note.external_id, "/a4");
        doc.ticket = "/sale-notes/print/".concat(sale_note.external_id, "/ticket");
      } else {
        doc.a4 = "/print/document/".concat(document.external_id, "/a4");
        doc.ticket = "/print/document/".concat(document.external_id, "/ticket");
      }

      return {
        a4: doc.a4,
        ticket: doc.ticket,
        nameDocPayment: "".concat(doc.series, "-").concat(doc.number),
        totalDocPayment: doc.total,
        dateDocPayment: __WEBPACK_IMPORTED_MODULE_1_moment___default()(doc.date_of_issue).format("DD/MM/YYYY")
      };
    },
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_2_query_string___default.a.stringify({
        page: this.pagination.current_page
      });
    },
    getPayments: function getPayments() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, _response$data, data, meta;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.next = 2;
                return _this5.$http("/internet/payments/".concat(_this5.registerId, "?").concat(_this5.getQueryParameters()));

              case 2:
                response = _context5.sent;
                _response$data = response.data, data = _response$data.data, meta = _response$data.meta;
                _this5.pagination = meta;
                _this5.pagination.per_page = parseInt(meta.per_page);
                _this5.payments = data.map(function (p) {
                  return _objectSpread(_objectSpread({}, p), _this5.getDocumentName(p));
                });

              case 7:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-69a7fd82\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/payments_internet.vue":
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
        "close-on-click-modal": true,
        visible: _vm.showDialog,
        title: "Pagos"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "div",
        { staticClass: "d-flex mt-2 justify-content-end" },
        [
          _c(
            "el-button",
            {
              attrs: { type: "primary", size: "mini" },
              on: { click: _vm.print }
            },
            [
              _c("i", { staticClass: "fas fa-print" }),
              _vm._v("\n            Imprimir")
            ]
          ),
          _vm._v(" "),
          _c(
            "el-button",
            {
              attrs: { type: "success", size: "mini" },
              on: {
                click: function($event) {
                  _vm.showWhatsappModal = true
                }
              }
            },
            [
              _c("i", { staticClass: "fab fa-whatsapp" }),
              _vm._v("\n            Whatsapp")
            ]
          )
        ],
        1
      ),
      _vm._v(" "),
      _vm.payments.length > 0
        ? _c(
            "div",
            [
              _c(
                "table",
                { staticClass: "w-100 table table-responsive table-striped" },
                [
                  _c("thead", [
                    _c("tr", [
                      _c("th", [
                        _vm._v(
                          "\n                        #\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("th", [
                        _vm._v(
                          "\n                        Fecha\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("th", [
                        _vm._v(
                          "\n                        Monto\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("th", [
                        _vm._v(
                          "\n                        Documento\n                    "
                        )
                      ]),
                      _vm._v(" "),
                      _c("th")
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    _vm._l(_vm.payments, function(net, idx) {
                      return _c("tr", { key: idx }, [
                        _c("td", [_vm._v(_vm._s(_vm.customIndex(idx)))]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(net.dateDocPayment))]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(net.totalDocPayment))]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(net.nameDocPayment))]),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c(
                              "el-button",
                              {
                                attrs: { type: "secondary", size: "mini" },
                                on: {
                                  click: function($event) {
                                    return _vm.viewDocument(net.a4)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                            A4 PDF\n                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "el-button",
                              {
                                attrs: { type: "secondary", size: "mini" },
                                on: {
                                  click: function($event) {
                                    return _vm.viewDocument(net.ticket)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                            TICKET PDF\n                        "
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
                ]
              ),
              _vm._v(" "),
              _c("el-pagination", {
                attrs: {
                  layout: "total, prev, pager, next",
                  total: _vm.pagination.total,
                  "current-page": _vm.pagination.current_page,
                  "page-size": _vm.pagination.per_page
                },
                on: {
                  "current-change": _vm.getPayments,
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
        : _c("div", { staticClass: "d-flex justify-content-center" }, [
            _c("span", { staticClass: "m-5" }, [_vm._v("SIN PAGOS MENSUALES")])
          ]),
      _vm._v(" "),
      _c(
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
          attrs: {
            visible: _vm.showWhatsappModal,
            title: "Enviar por Whatsapp",
            "append-to-body": ""
          },
          on: {
            "update:visible": function($event) {
              _vm.showWhatsappModal = $event
            },
            close: function($event) {
              _vm.showWhatsappModal = false
            },
            open: _vm.openWhatsapp
          }
        },
        [
          _c("div", { staticClass: "row m-3" }, [
            _c(
              "div",
              { staticClass: "col-8" },
              [
                _c("el-input", {
                  attrs: {
                    placeholder: "Ingrese el número de celular",
                    size: "mini",
                    clearable: ""
                  },
                  model: {
                    value: _vm.number,
                    callback: function($$v) {
                      _vm.number = $$v
                    },
                    expression: "number"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-4" },
              [
                _c(
                  "el-button",
                  {
                    attrs: { type: "primary", size: "mini" },
                    on: { click: _vm.sendWhatsapp }
                  },
                  [_vm._v("Enviar")]
                ),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: { size: "mini" },
                    on: {
                      click: function($event) {
                        _vm.showWhatsappModal = false
                      }
                    }
                  },
                  [_vm._v("Cerrar")]
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row m-3" })
        ]
      )
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
    require("vue-hot-reload-api")      .rerender("data-v-69a7fd82", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=198.js.map