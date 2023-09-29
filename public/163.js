webpackJsonp([163],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/toll/form_add.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "elements"],
  data: function data() {
    return {
      loading: false,
      resource: "toll",
      loading_item: false,
      loading_search: false,
      items: [],
      selected: [],
      form: {
        item_id: null,
        warehouse_id: 1
      }
    };
  },
  methods: {
    addItems: function addItems() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var ids, response, message;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                ids = _this.selected.map(function (s) {
                  return s.id;
                });
                _context.prev = 1;
                _this.loading = true;
                _context.next = 5;
                return _this.$http.post("".concat(_this.resource), {
                  ids: ids
                });

              case 5:
                response = _context.sent;
                message = response.data.message;

                _this.$toast.success(message);

                _this.$emit("reloadData");

                _this.close();

                _context.next = 16;
                break;

              case 12:
                _context.prev = 12;
                _context.t0 = _context["catch"](1);

                _this.$toast.error("Ocurrió un problema");

                console.log(_context.t0);

              case 16:
                _context.prev = 16;
                _this.loading = false;
                return _context.finish(16);

              case 19:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[1, 12, 16, 19]]);
      }))();
    },
    saveItems: function saveItems() {
      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    removeSelected: function removeSelected(id) {
      this.selected = this.selected.filter(function (i) {
        return i.id != id;
      });
    },
    searchItem: function searchItem(input) {
      var _this2 = this;

      if (input.length > 2) {
        if (this.time) {
          clearTimeout(this.time);
        }

        this.time = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
          var query;
          return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
            while (1) {
              switch (_context3.prev = _context3.next) {
                case 0:
                  query = "?description=".concat(input);
                  _context3.next = 3;
                  return _this2.searchItems(query);

                case 3:
                case "end":
                  return _context3.stop();
              }
            }
          }, _callee3);
        })), 500);
      }
    },
    searchItems: function searchItems(query) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.prev = 0;
                _this3.loading_item = true;
                _context4.next = 4;
                return _this3.$http.get("/".concat(_this3.resource, "/items/").concat(_this3.form.warehouse_id).concat(query));

              case 4:
                response = _context4.sent;

                if (response.status == 200) {
                  _this3.items = response.data.items;
                }

                _context4.next = 11;
                break;

              case 8:
                _context4.prev = 8;
                _context4.t0 = _context4["catch"](0);
                console.log(_context4.t0);

              case 11:
                _context4.prev = 11;
                _this3.loading_item = false;
                return _context4.finish(11);

              case 14:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, null, [[0, 8, 11, 14]]);
      }))();
    },
    changeItem: function changeItem() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var item_id, added, item;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                item_id = _this4.form.item_id;
                added = _this4.selected.some(function (i) {
                  return i.id == item_id;
                });

                if (!added) {
                  _context5.next = 4;
                  break;
                }

                return _context5.abrupt("return", _this4.$toast.error("Ya fue agregado."));

              case 4:
                added = _this4.elements.some(function (i) {
                  return i.id == item_id;
                });

                if (!added) {
                  _context5.next = 7;
                  break;
                }

                return _context5.abrupt("return", _this4.$toast.error("Ya fue agregado."));

              case 7:
                item = _this4.items.find(function (i) {
                  return i.id == item_id;
                });
                _this4.selected = [].concat(_toConsumableArray(_this4.selected), [item]);

              case 9:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    open: function open() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return _this5.searchItems();

              case 2:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    } // async records(input = null) {
    //     try {
    //         this.loading = true;
    //         const response = await this.$http(
    //             `/${this.resource}/items/1?${
    //                 input ? `description=${input}` : ""
    //             }`
    //         );
    //         console.log(response);
    //     } catch (e) {
    //         console.log(e);
    //     } finally {
    //         this.loading = false;
    //     }
    // }

  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-b85664ea\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/toll/form_add.vue":
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
      staticClass: "p-2",
      attrs: { "append-to-body": "", visible: _vm.showDialog },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "p-3" }, [
        _c(
          "div",
          [
            _c("label", { staticClass: "control-label" }, [
              _vm._v("Buscar producto")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: {
                  "remote-method": _vm.searchItem,
                  filterable: "",
                  remote: "",
                  loading: _vm.loading_item,
                  "popper-class": "el-select-document_type"
                },
                on: { change: _vm.changeItem },
                model: {
                  value: _vm.form.item_id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "item_id", $$v)
                  },
                  expression: "form.item_id"
                }
              },
              _vm._l(_vm.items, function(option) {
                return _c("el-option", {
                  key: option.id,
                  attrs: { value: option.id, label: option.description }
                })
              }),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _vm.selected.length != 0
          ? _c(
              "div",
              {
                staticClass: "d-flex flex-wrap justify-content-center",
                staticStyle: { "margin-top": "15px" }
              },
              _vm._l(_vm.selected, function(item, idx) {
                return _c(
                  "el-tag",
                  {
                    key: idx,
                    staticStyle: { margin: "0 5px" },
                    attrs: { closable: "" },
                    on: {
                      close: function($event) {
                        return _vm.removeSelected(item.id)
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n                " +
                        _vm._s(item.description) +
                        "\n            "
                    )
                  ]
                )
              }),
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "d-flex justify-content-end mt-3" },
          [
            _c("el-button", { on: { click: _vm.close } }, [
              _vm._v("\n                Cerrar\n            ")
            ]),
            _vm._v(" "),
            _c(
              "el-button",
              { attrs: { type: "primary" }, on: { click: _vm.addItems } },
              [_vm._v("\n                Agregar\n            ")]
            )
          ],
          1
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
    require("vue-hot-reload-api")      .rerender("data-v-b85664ea", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/toll/form_add.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/toll/form_add.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-b85664ea\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/toll/form_add.vue")
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
Component.options.__file = "resources/js/views/toll/form_add.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b85664ea", Component.options)
  } else {
    hotAPI.reload("data-v-b85664ea", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=163.js.map