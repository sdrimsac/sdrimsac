webpackJsonp([211],{

/***/ "./modules/Consignment/Resources/assets/js/views/partials/items.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Consignment/Resources/assets/js/views/partials/items.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2d272e20\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Consignment/Resources/assets/js/views/partials/items.vue")
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
Component.options.__file = "modules/Consignment/Resources/assets/js/views/partials/items.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2d272e20", Component.options)
  } else {
    hotAPI.reload("data-v-2d272e20", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Consignment/Resources/assets/js/views/partials/items.vue":
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
var ItemsLotView = function ItemsLotView() {
  return __webpack_require__.e/* import() */(209).then(__webpack_require__.bind(null, "./modules/Consignment/Resources/assets/js/views/partials/lot_item_view.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ItemsLotView: ItemsLotView
  },
  props: ["showDialog", "recordId"],
  data: function data() {
    return {
      form: {},
      items: [],
      loading: false,
      showDialogItemsLot: false,
      itemId: null,
      isLiquidated: false
    };
  },
  methods: {
    clickShowLots: function clickShowLots(item) {
      this.itemId = item.id;
      this.showDialogItemsLot = true;
    },
    getItems: function getItems() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this.loading = true;
                _context.next = 4;
                return _this.$http("/consignment/items/".concat(_this.recordId));

              case 4:
                response = _context.sent;
                console.log(response);

                if (response.status == 200) {
                  _this.items = response.data.items;
                  _this.isLiquidated = response.data.liquidated;
                }

                _context.next = 13;
                break;

              case 9:
                _context.prev = 9;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);

                _this.$toast.error("Error al obtener los productos");

              case 13:
                _context.prev = 13;
                _this.loading = false;
                return _context.finish(13);

              case 16:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 9, 13, 16]]);
      }))();
    },
    open: function open() {
      this.getItems();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2d272e20\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Consignment/Resources/assets/js/views/partials/items.vue":
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
        title: "Productos",
        "append-to-body": ""
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row" }, [
        _c("table", { staticClass: "table table-responsive table-stripe" }, [
          _c("thead", [
            _c("tr", [
              _c("th", [_vm._v("#")]),
              _vm._v(" "),
              _c("th", [_vm._v("Producto")]),
              _vm._v(" "),
              _c("th", [_vm._v("Cantidad")]),
              _vm._v(" "),
              _vm.isLiquidated ? _c("th", [_vm._v("Vendido")]) : _vm._e(),
              _vm._v(" "),
              _vm.isLiquidated ? _c("th", [_vm._v("Regresado")]) : _vm._e(),
              _vm._v(" "),
              _c("th", [_vm._v("Precio")]),
              _vm._v(" "),
              _c("th", [_vm._v("Total")])
            ])
          ]),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.items, function(item, index) {
              return _c("tr", { key: index }, [
                _c("td", [_vm._v(_vm._s(index + 1))]),
                _vm._v(" "),
                _c(
                  "td",
                  [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.name) +
                        "\n                        "
                    ),
                    item.has_lots
                      ? [
                          _c("br"),
                          _vm._v(" "),
                          _c("small", [
                            _c(
                              "a",
                              {
                                attrs: { href: "#" },
                                on: {
                                  click: function($event) {
                                    return _vm.clickShowLots(item)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                    Ver series\n                                "
                                )
                              ]
                            )
                          ])
                        ]
                      : _vm._e()
                  ],
                  2
                ),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(item.quantity))]),
                _vm._v(" "),
                _vm.isLiquidated
                  ? _c("td", [_vm._v(_vm._s(item.selled))])
                  : _vm._e(),
                _vm._v(" "),
                _vm.isLiquidated
                  ? _c("td", [_vm._v(_vm._s(item.returned))])
                  : _vm._e(),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(item.price))]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(item.total.toFixed(2)))])
              ])
            }),
            0
          )
        ])
      ]),
      _vm._v(" "),
      _c("items-lot-view", {
        attrs: { showDialog: _vm.showDialogItemsLot, recordId: _vm.itemId },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogItemsLot = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogItemsLot = $event
          }
        }
      })
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
    require("vue-hot-reload-api")      .rerender("data-v-2d272e20", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=211.js.map