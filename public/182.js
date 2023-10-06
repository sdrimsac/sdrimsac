webpackJsonp([182],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/products_due.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/products_due.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0153b98c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/products_due.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/products_due.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0153b98c", Component.options)
  } else {
    hotAPI.reload("data-v-0153b98c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/products_due.vue":
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
var WhatsappModal = function WhatsappModal() {
  return __webpack_require__.e/* import() */(139/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/components/WhatsappModalReports.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    WhatsappModal: WhatsappModal
  },
  props: ["showDialog"],
  data: function data() {
    return {
      showDialogWhatsapp: false,
      records: [],
      pagination: {}
    };
  },
  methods: {
    customIndex: function customIndex(index) {
      return this.pagination.per_page * (this.pagination.current_page - 1) + index + 1;
    },
    getRecords: function getRecords() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, _response$data, data, meta;

        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.$http.get("/lotes/to_due");

              case 2:
                response = _context.sent;
                _response$data = response.data, data = _response$data.data, meta = _response$data.meta;
                _this.records = data;
                _this.pagination = meta;
                console.log(response);

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    clickSendWhatsapp: function clickSendWhatsapp() {
      this.showDialogWhatsapp = true;
    },
    clickDownload: function clickDownload() {
      window.open("/lotes/to_due/excel");
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0153b98c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/products_due.vue":
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
        visible: _vm.showDialog,
        title: "Productos por vencer"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _vm.records != 0
        ? _c(
            "div",
            { staticClass: "d-flex justify-content-end mt-2" },
            [
              _c(
                "el-button",
                {
                  attrs: {
                    type: "success",
                    icon: "el-icon-download",
                    size: "small"
                  },
                  on: { click: _vm.clickDownload }
                },
                [_vm._v("Exportar")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: {
                    type: "success",
                    icon: "el-icon-chat-dot-square",
                    size: "small"
                  },
                  on: { click: _vm.clickSendWhatsapp }
                },
                [_vm._v("Enviar por whatsapp")]
              )
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _vm.records == 0
              ? [
                  _c(
                    "div",
                    { staticClass: "alert alert-info text-center p-2" },
                    [
                      _vm._v(
                        "\n                    No hay productos por vencer\n                "
                      )
                    ]
                  )
                ]
              : [
                  _c("table", { staticClass: "table table-striped" }, [
                    _c("thead", [
                      _c("tr", [
                        _c("th", [_vm._v("#")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Producto")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Fecha de vencimiento")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Cantidad")])
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.records, function(record, index) {
                        return _c("tr", { key: record.id }, [
                          _c("td", [_vm._v(_vm._s(_vm.customIndex(index)))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(record.item.description))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(record.date_of_due))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(record.quantity))])
                        ])
                      }),
                      0
                    )
                  ])
                ]
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "row" },
        [
          _c("el-pagination", {
            attrs: {
              layout: "total, prev, pager, next",
              total: _vm.pagination.total,
              "current-page": _vm.pagination.current_page,
              "page-size": parseInt(_vm.pagination.per_page)
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
      _c("whatsapp-modal", {
        attrs: {
          resource: "/lotes/to_due/excel",
          showWhatsappForm: _vm.showDialogWhatsapp,
          message: "Reporte de lotes vencidos a menos de 60 dias.xlsx"
        },
        on: {
          "update:showWhatsappForm": function($event) {
            _vm.showDialogWhatsapp = $event
          },
          "update:show-whatsapp-form": function($event) {
            _vm.showDialogWhatsapp = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-0153b98c", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=182.js.map