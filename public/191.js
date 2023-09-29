webpackJsonp([191],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_list_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_list_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-50b06be2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_list_modal.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_list_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-50b06be2", Component.options)
  } else {
    hotAPI.reload("data-v-50b06be2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_list_modal.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_query_string__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


var ItemsModal = function ItemsModal() {
  return __webpack_require__.e/* import() */(211).then(__webpack_require__.bind(null, "./modules/Consignment/Resources/assets/js/views/partials/items.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog"],
  components: {
    ItemsModal: ItemsModal
  },
  data: function data() {
    return {
      loading: false,
      showDialogItems: false,
      showDialogDetail: false,
      recordId: null,
      form: {},
      records: [],
      loading_search: false,
      resource: "/consignment",
      pagination: {},
      search: {},
      columns: {
        person_id: "Cliente",
        date_of_issue: "Fecha de consignación",
        date_of_end: "Fecha de liquidación"
      }
    };
  },
  methods: {
    clickDelete: function clickDelete(consignment) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this.$confirm("¿Está seguro de eliminar la consignación?", "Advertencia", {
                  confirmButtonText: "Aceptar",
                  cancelButtonText: "Cancelar",
                  type: "warning"
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
                  var response;
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                      switch (_context.prev = _context.next) {
                        case 0:
                          _context.next = 2;
                          return _this.$http.get("".concat(_this.resource, "/delete/").concat(consignment.id));

                        case 2:
                          response = _context.sent;

                          if (response.status == 200) {
                            if (response.data.success) {
                              _this.$toast.success(response.data.message);

                              _this.getRecords();
                            } else {
                              _this.$toast.error(response.data.message);
                            }
                          } else {
                            _this.$toast.error("Ocurrió un error al eliminar la consignación");
                          }

                        case 4:
                        case "end":
                          return _context.stop();
                      }
                    }
                  }, _callee);
                })))["catch"](function (e) {
                  console.log(e);
                });

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_1_query_string___default.a.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        value: this.search.value,
        column: this.search.column
      });
    },
    clickDownload: function clickDownload(consignment) {
      window.open(consignment.download_url, "_blank");
    },
    changeClearInput: function changeClearInput() {},
    clickSendMessage: function clickSendMessage(id) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _this2.loading = true;
                _context3.next = 4;
                return _this2.$http("".concat(_this2.resource, "/message/").concat(id));

              case 4:
                response = _context3.sent;

                if (response.status == 200) {
                  if (response.data.success) {
                    _this2.$toast.success(response.data.message);
                  } else {
                    _this2.$toast.error(response.data.message);
                  }
                } else {
                  _this2.$toast.error("Ocurrió un error al enviar el mensaje");
                }

                _context3.next = 11;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);

                _this2.$toast.error(_context3.t0.message);

              case 11:
                _context3.prev = 11;
                _this2.loading = false;
                return _context3.finish(11);

              case 14:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8, 11, 14]]);
      }))();
    },
    clickFormat: function clickFormat(id) {
      window.open("/consignment/format/".concat(id), "_blank");
    },
    clickDetail: function clickDetail(consignment) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this3.recordId = consignment.id;
                _this3.showDialogDetail = true;

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickLiquidate: function clickLiquidate(consignment) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var response, foods;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.next = 2;
                return _this4.$http("".concat(_this4.resource, "/liquidate/").concat(consignment.id));

              case 2:
                response = _context5.sent;

                if (response.status == 200) {
                  if (response.data.success) {
                    foods = response.data.foods;
                    foods = foods.map(function (food) {
                      food.toWarehouse = 0;
                      food.originalQuantity = food.quantity;
                      return food;
                    });

                    _this4.$emit("setItemsToLiquidate", foods, consignment.id);

                    _this4.close();
                  } else {
                    _this4.$toast.error(response.data.message);
                  }
                } else {
                  _this4.$toast.error("Ocurrió un error al liquidar la consignación");
                }

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    clickShowProducts: function clickShowProducts(consignment) {
      this.recordId = consignment.id;
      this.showDialogItems = true;
    },
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    getRecords: function getRecords() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.prev = 0;
                _this5.loading = true;
                _context6.next = 4;
                return _this5.$http("".concat(_this5.resource, "/records?").concat(_this5.getQueryParameters()));

              case 4:
                response = _context6.sent;
                console.log(response);
                _this5.records = response.data.data;
                _this5.pagination = response.data.meta;
                _context6.next = 13;
                break;

              case 10:
                _context6.prev = 10;
                _context6.t0 = _context6["catch"](0);

                _this5.$toast.error(_context6.t0.message);

              case 13:
                _context6.prev = 13;
                _this5.loading = false;
                return _context6.finish(13);

              case 16:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, null, [[0, 10, 13, 16]]);
      }))();
    },
    open: function open() {
      this.getRecords();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-50b06be2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/consignment_list_modal.vue":
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
      attrs: {
        visible: _vm.showDialog,
        title: "Lista de Consignaciones",
        width: "90%"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row mt-2" }, [
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("label", { staticClass: "w-100", attrs: { for: "filter" } }, [
              _vm._v("Filtrar por:")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { placeholder: "Selecccionar" },
                model: {
                  value: _vm.search.column,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "column", $$v)
                  },
                  expression: "search.column"
                }
              },
              _vm._l(_vm.columns, function(label, key) {
                return _c("el-option", {
                  key: key,
                  attrs: { value: key, label: label }
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
          { staticClass: "col-md-3" },
          [
            _c("label", { staticClass: "w-100", attrs: { for: "filter" } }, [
              _vm._v("Buscar:")
            ]),
            _vm._v(" "),
            _vm.search.column == "date_of_issue" ||
            _vm.search.column == "date_of_end"
              ? [
                  _c("el-date-picker", {
                    staticStyle: { width: "100%" },
                    attrs: {
                      type: "date",
                      placeholder: "Buscar",
                      "value-format": "yyyy-MM-dd"
                    },
                    on: { change: _vm.getRecords },
                    model: {
                      value: _vm.search.value,
                      callback: function($$v) {
                        _vm.$set(_vm.search, "value", $$v)
                      },
                      expression: "search.value"
                    }
                  })
                ]
              : [
                  _c("el-input", {
                    attrs: { placeholder: "Buscar" },
                    on: { input: _vm.getRecords },
                    model: {
                      value: _vm.search.value,
                      callback: function($$v) {
                        _vm.$set(_vm.search, "value", $$v)
                      },
                      expression: "search.value"
                    }
                  })
                ]
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        [
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
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "row mt-2" },
        [
          _c(
            "table",
            { staticClass: "table table-responsive table-striped table-hover" },
            [
              _c("thead", [
                _c("tr", [
                  _c("th", [_vm._v("#")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Usuario")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Cliente")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Fecha de consignación")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Fecha de liquidación")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Productos")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Total")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Penalidad")]),
                  _vm._v(" "),
                  _c("th"),
                  _vm._v(" "),
                  _c("th")
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.records, function(consignment, idx) {
                  return _c("tr", { key: idx }, [
                    _c("td", [_vm._v(_vm._s(_vm.customIndex(idx)))]),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticClass: "text-small " },
                      [
                        consignment.user_name
                          ? [
                              _c("strong", [_vm._v("CREADO:")]),
                              _vm._v(
                                "\n                            " +
                                  _vm._s(consignment.user_name) +
                                  " "
                              ),
                              _c("br")
                            ]
                          : _vm._e(),
                        _vm._v(" "),
                        consignment.user_liquidated_name
                          ? [
                              _c("strong", [_vm._v("LIQUIDADO:")]),
                              _vm._v(
                                "\n                            " +
                                  _vm._s(consignment.user_liquidated_name) +
                                  "\n                        "
                              )
                            ]
                          : _vm._e()
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(consignment.person.name))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(consignment.date_of_issue))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(consignment.date_of_end))]),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c(
                          "el-button",
                          {
                            attrs: { type: "primary", icon: "el-icon-search" },
                            on: {
                              click: function($event) {
                                return _vm.clickShowProducts(consignment)
                              }
                            }
                          },
                          [_vm._v(_vm._s(consignment.stock))]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(consignment.total))]),
                    _vm._v(" "),
                    _c("td", [
                      _vm._v(
                        "\n                        " +
                          _vm._s(consignment.penalty) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        consignment.expired
                          ? _c(
                              "el-tooltip",
                              {
                                attrs: {
                                  content:
                                    "Enviar mensaje de vencimiento al número de contacto del cliente"
                                }
                              },
                              [
                                _c(
                                  "el-button",
                                  {
                                    attrs: { type: "success" },
                                    on: {
                                      click: function($event) {
                                        return _vm.clickSendMessage(
                                          consignment.id
                                        )
                                      }
                                    }
                                  },
                                  [_c("i", { staticClass: "el-icon-message" })]
                                )
                              ],
                              1
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "el-button",
                          {
                            attrs: { type: "primary" },
                            on: {
                              click: function($event) {
                                return _vm.clickFormat(consignment.id)
                              }
                            }
                          },
                          [_c("i", { staticClass: "el-icon-s-order" })]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        consignment.liquidated && consignment.download_url
                          ? [
                              _c(
                                "el-button",
                                {
                                  attrs: { type: "success" },
                                  on: {
                                    click: function($event) {
                                      return _vm.clickDownload(consignment)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(consignment.number_document) +
                                      "\n                            "
                                  )
                                ]
                              )
                            ]
                          : _vm._e(),
                        _vm._v(" "),
                        !consignment.liquidated
                          ? _c(
                              "el-button",
                              {
                                attrs: { type: "success" },
                                on: {
                                  click: function($event) {
                                    return _vm.clickLiquidate(consignment)
                                  }
                                }
                              },
                              [
                                _c("i", { staticClass: "el-icon-cash" }),
                                _vm._v(
                                  "\n                            Liquidar\n                        "
                                )
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        !consignment.liquidated
                          ? _c(
                              "el-button",
                              {
                                attrs: { size: "mini", type: "danger" },
                                on: {
                                  click: function($event) {
                                    return _vm.clickDelete(consignment)
                                  }
                                }
                              },
                              [_c("i", { staticClass: "el-icon-delete" })]
                            )
                          : _c("span", [
                              _vm._v(
                                "\n                            Liquidado\n                        "
                              )
                            ])
                      ],
                      2
                    )
                  ])
                }),
                0
              )
            ]
          ),
          _vm._v(" "),
          _c("items-modal", {
            attrs: { showDialog: _vm.showDialogItems, recordId: _vm.recordId },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogItems = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogItems = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-50b06be2", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=191.js.map