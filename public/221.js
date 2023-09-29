webpackJsonp([221],{

/***/ "./modules/College/Resources/assets/js/components/show_payments.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/show_payments.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-66db0968\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/show_payments.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/components/show_payments.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-66db0968", Component.options)
  } else {
    hotAPI.reload("data-v-66db0968", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/components/show_payments.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "payments", "title"],
  data: function data() {
    return {
      records: []
    };
  },
  methods: {
    viewDocument: function viewDocument(url) {
      window.open(url);
    },
    open: function open() {
      this.records = this.payments.map(function (p) {
        if (p.sale_note) {
          p.document = p.sale_note;
          p.a4 = "/sale-notes/print/".concat(p.sale_note.external_id, "/a4");
          p.ticket = "/sale-notes/print/".concat(p.sale_note.external_id, "/ticket");
        } else {
          p.a4 = "/print/document/".concat(p.document.external_id, "/a4");
          p.ticket = "/print/document/".concat(p.document.external_id, "/ticket");
        }

        if (!p.date_of_issue) {
          p.date_of_issue = moment(p.document.date_of_issue).format("DD/MM/YYYY");
        }

        var _p$details = p.details,
            items = _p$details.items,
            penalties = _p$details.penalties;

        if (penalties) {
          p.penalties = penalties.reduce(function (a, b) {
            return a + Number(b.sale_unit_price);
          }, 0);
        }

        p.items = items.reduce(function (a, b) {
          return a + Number(b.sale_unit_price);
        }, 0);
        p.total = p.items + (p.penalties || 0);
        return _objectSpread({}, p);
      });
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-66db0968\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/components/show_payments.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: _vm.title,
        "append-to-body": "",
        visible: _vm.showDialog
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row mt-5 table-responsive" }, [
        _vm.payments.length > 0
          ? _c("table", { staticClass: "table table-striped" }, [
              _c("thead", [
                _c("tr", [
                  _c("th", [_vm._v("#")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Fecha")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Servicio")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Penalidad")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Total")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Pagó")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("Resta")]),
                  _vm._v(" "),
                  _c("th")
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.records, function(payment, idx) {
                  return _c("tr", { key: idx }, [
                    _c("td", [_vm._v(_vm._s(idx + 1))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(payment.date_of_issue))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(payment.items.toFixed(2)))]),
                    _vm._v(" "),
                    payment.penalties
                      ? _c("td", [
                          _vm._v(
                            "\n                            " +
                              _vm._s(payment.penalties.toFixed(2)) +
                              "\n                        "
                          )
                        ])
                      : _c("td", [_vm._v("0.00")]),
                    _vm._v(" "),
                    _c("td", [
                      _vm._v(
                        "\n                            " +
                          _vm._s(payment.total.toFixed(2)) +
                          "\n                        "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(payment.document.total))]),
                    _vm._v(" "),
                    _c("td", [
                      _vm._v(
                        "\n                            " +
                          _vm._s(
                            (payment.total - payment.document.total).toFixed(2)
                          ) +
                          "\n                        "
                      )
                    ]),
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
                                return _vm.viewDocument(payment.a4)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                                A4 PDF\n                            "
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
                                return _vm.viewDocument(payment.ticket)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                                TICKET PDF\n                            "
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
              _c("span", [_vm._v("SIN PAGOS MENSUALES")])
            ])
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
    require("vue-hot-reload-api")      .rerender("data-v-66db0968", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=221.js.map