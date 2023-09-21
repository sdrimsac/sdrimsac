webpackJsonp([175],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-48b30c8e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-48b30c8e", Component.options)
  } else {
    hotAPI.reload("data-v-48b30c8e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "idx", "orden"],
  data: function data() {
    return {
      lotes: []
    };
  },
  methods: {
    save: function save() {
      this.$emit("updateLotes", this.idx, this.lotes);
      this.close();
    },
    open: function open() {
      if (this.orden) {
        this.lotes = this.orden.lotes;
      }
    },
    checkStock: function checkStock(idx) {
      var lote = this.lotes[idx];

      if (lote.quantitySelected > lote.quantity) {
        this.lotes[idx].quantitySelected = lote.quantity;
        this.$toast.warning("Limite sobrepasado");
      }

      if (0 > lote.quantitySelected) {
        this.$toast.warning("Numero invalido");
        this.lotes[idx].quantitySelected = 1;
      }
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    getLotes: function getLotes() {}
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-48b30c8e\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/show_lotes_product.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: { title: "Lotes", visible: _vm.showDialog },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("table", { staticClass: "table" }, [
        _c("thead", [
          _c("tr", [
            _c("th", [_vm._v("#")]),
            _vm._v(" "),
            _c("th", [_vm._v("Lote")]),
            _vm._v(" "),
            _c("th", [_vm._v("Vencimiento")]),
            _vm._v(" "),
            _c("th", [_vm._v("Cantidad")]),
            _vm._v(" "),
            _c("th", { attrs: { width: "20%" } }, [_vm._v("Seleccionado")])
          ])
        ]),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.lotes, function(lote, idx) {
            return _c("tr", { key: idx }, [
              _c("td", [_vm._v(_vm._s(idx + 1))]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(lote.code))]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(lote.date_of_due))]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(lote.quantity))]),
              _vm._v(" "),
              _c(
                "td",
                [
                  _c("el-input", {
                    on: {
                      input: function($event) {
                        return _vm.checkStock(idx)
                      }
                    },
                    model: {
                      value: lote.quantitySelected,
                      callback: function($$v) {
                        _vm.$set(lote, "quantitySelected", $$v)
                      },
                      expression: "lote.quantitySelected"
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
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-48b30c8e", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=175.js.map