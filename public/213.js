webpackJsonp([213],{

/***/ "./modules/Consignment/Resources/assets/js/views/partials/lot_item.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Consignment/Resources/assets/js/views/partials/lot_item.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6c92cfc1\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Consignment/Resources/assets/js/views/partials/lot_item.vue")
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
Component.options.__file = "modules/Consignment/Resources/assets/js/views/partials/lot_item.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6c92cfc1", Component.options)
  } else {
    hotAPI.reload("data-v-6c92cfc1", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Consignment/Resources/assets/js/views/partials/lot_item.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string__ = __webpack_require__("./node_modules/query-string/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_query_string___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_query_string__);


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

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "limitQty", "item_id", "idx", "seriesSelected", "establishment_id"],
  data: function data() {
    return {
      loading: false,
      series: [],
      pagination: {},
      inputSearch: null,
      timer: null,
      showSelecteds: false
    };
  },
  methods: {
    checkSeries: function checkSeries() {
      var _this = this;

      var _loop = function _loop(i) {
        var serie = _this.seriesSelected.find(function (s) {
          return s.id == _this.series[i].id;
        });

        if (serie) {
          _this.series[i].selected = true;
          _this.series[i].disabled = serie.disabled;
        }
      };

      for (var i = 0; i < this.series.length; i++) {
        _loop(i);
      }
    },
    showSelected: function showSelected() {
      this.showSelecteds = !this.showSelecteds;
    },
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    saveSerie: function saveSerie(serie) {
      var series = _toConsumableArray(this.seriesSelected.filter(function (s) {
        return s.disabled != null && s.disabled == false;
      }));

      if (serie.selected) {
        serie.disabled = false;
        series = [].concat(_toConsumableArray(series), [serie]);
      } else {
        series = series.filter(function (s) {
          return s.id != serie.id;
        });
      }

      console.log(series, " aki");
      this.$forceUpdate();
      this.$emit("update:seriesSelected", series);
    },
    save: function save() {
      if (this.limitQty != 0) {
        if (this.seriesSelected.length > this.limitQty) {
          return this.$toast.error("La cantidad de series no coninciden con la cantidad de venta por politica de precio");
        }
      }

      console.log(this.seriesSelected, " las series");
      this.$emit("updateSeries", this.idx, this.seriesSelected);
      this.close();
    },
    getQueryParameters: function getQueryParameters() {
      return __WEBPACK_IMPORTED_MODULE_1_query_string___default.a.stringify({
        warehouse_id: this.establishment_id,
        page: this.pagination.current_page,
        item_id: this.item_id,
        description: this.inputSearch
      });
    },
    open: function open() {
      if (this.item_id) {
        this.getSeries();
      }
    },
    search: function search() {
      var _this2 = this;

      if (this.timer) {
        clearTimeout(this.timer);
      }

      this.timer = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this2.getSeries();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      })), 350);
    },
    close: function close() {
      this.inputSearch = null;
      this.pagination = {};
      this.series = [];
      this.$emit("update:showDialog", false);
    },
    getSeries: function getSeries() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, _response$data, data, meta;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _this3.loading = true;
                _context2.next = 4;
                return _this3.$http("/lotitem/series-by-item?".concat(_this3.getQueryParameters()));

              case 4:
                response = _context2.sent;
                _response$data = response.data, data = _response$data.data, meta = _response$data.meta;
                _this3.series = data;

                _this3.checkSeries();

                _this3.pagination = meta;
                _this3.pagination.per_page = parseInt(meta.per_page);
                _context2.next = 15;
                break;

              case 12:
                _context2.prev = 12;
                _context2.t0 = _context2["catch"](0);
                console.log(_context2.t0);

              case 15:
                _context2.prev = 15;
                _this3.loading = false;
                return _context2.finish(15);

              case 18:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 12, 15, 18]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6c92cfc1\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Consignment/Resources/assets/js/views/partials/lot_item.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        visible: _vm.showDialog,
        title: "Listado de series",
        "append-to-body": ""
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "div",
        { staticClass: "p-1" },
        [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("el-input", {
                  attrs: { placeholder: "Buscar por serie" },
                  on: { input: _vm.search },
                  model: {
                    value: _vm.inputSearch,
                    callback: function($$v) {
                      _vm.inputSearch = $$v
                    },
                    expression: "inputSearch"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c(
            "table",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading,
                  expression: "loading"
                }
              ],
              staticClass: "table"
            },
            [
              _c("thead", [
                _c("tr", [
                  _c("th", [_vm._v("#")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Serie")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Fecha")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Lote")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Seleccionar")])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.series, function(serie, idx) {
                  return _c("tr", { key: serie.id }, [
                    _c("td", [_vm._v(_vm._s(_vm.customIndex(idx)))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(serie.series))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(serie.date))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(serie.lote))]),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c("el-checkbox", {
                          attrs: { disabled: serie.disabled },
                          on: {
                            change: function($event) {
                              return _vm.saveSerie(serie)
                            }
                          },
                          model: {
                            value: serie.selected,
                            callback: function($$v) {
                              _vm.$set(serie, "selected", $$v)
                            },
                            expression: "serie.selected"
                          }
                        })
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
              "current-change": _vm.getSeries,
              "update:currentPage": function($event) {
                return _vm.$set(_vm.pagination, "current_page", $event)
              },
              "update:current-page": function($event) {
                return _vm.$set(_vm.pagination, "current_page", $event)
              }
            }
          }),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c("el-button", { on: { click: _vm.close } }, [_vm._v("Cerrar")]),
              _vm._v(" "),
              _c(
                "el-button",
                { attrs: { type: "primary" }, on: { click: _vm.save } },
                [_vm._v("Guardar")]
              )
            ],
            1
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
    require("vue-hot-reload-api")      .rerender("data-v-6c92cfc1", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=213.js.map