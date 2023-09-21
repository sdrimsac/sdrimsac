webpackJsonp([185],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/edit_product.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/edit_product.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1a8faddb\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/edit_product.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/edit_product.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1a8faddb", Component.options)
  } else {
    hotAPI.reload("data-v-1a8faddb", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/edit_product.vue":
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var ItemForm = function ItemForm() {
  return __webpack_require__.e/* import() */(127/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/items/form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "allItems"],
  components: {
    ItemForm: ItemForm
  },
  data: function data() {
    return {
      loading: false,
      items: [],
      form: {},
      loadingSearchItem: false,
      showDialogNewItem: false
    };
  },
  created: function created() {
    var _this = this;

    this.$eventHub.$on("reloadData", function () {
      _this.$emit("getFoods");

      _this.form.item_id = null;
    });
  },
  methods: {
    editProduct: function editProduct() {
      this.showDialogNewItem = true;
    },
    searchRemoteItems: function searchRemoteItems(input) {
      var _this2 = this;

      if (input.length > 0) {
        this.loadingSearchItem = true;
        var parameters = "input=".concat(input);
        this.$http.get("/documents/search-items?".concat(parameters)).then(function (response) {
          if (response.data) {
            var items = response.data.items;

            if (items.length > 0) {
              _this2.items = items;
            }
          }

          _this2.loadingSearchItem = false;
        })["catch"](function (_) {
          _this2.loadingSearchItem = false;
        });
      }
    },
    open: function open() {
      this.items = this.allItems.map(function (i) {
        return i.item;
      });
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1a8faddb\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/edit_product.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: "Edición de producto",
        visible: _vm.showDialog,
        "append-to-body": ""
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row mt-2" }, [
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c(
              "el-select",
              {
                attrs: {
                  filterable: "",
                  "remote-method": _vm.searchRemoteItems,
                  loading: _vm.loadingSearchItem,
                  remote: ""
                },
                model: {
                  value: _vm.form.item_id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "item_id", $$v)
                  },
                  expression: "form.item_id"
                }
              },
              _vm._l(_vm.items, function(item) {
                return _c("el-option", {
                  key: item.id,
                  attrs: { label: item.description, value: item.id }
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
          { staticClass: "col-md-4" },
          [
            _c(
              "el-button",
              {
                attrs: { type: "primary", loading: _vm.loading },
                on: { click: _vm.editProduct }
              },
              [
                _c("i", { staticClass: "fas fa-edit" }),
                _vm._v("\n                Editar\n            ")
              ]
            )
          ],
          1
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
        [_c("el-button", { on: { click: _vm.close } }, [_vm._v("Cerrar")])],
        1
      ),
      _vm._v(" "),
      _c("item-form", {
        attrs: {
          showDialog: _vm.showDialogNewItem,
          external: false,
          recordId: _vm.form.item_id
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showDialogNewItem = $event
          },
          "update:show-dialog": function($event) {
            _vm.showDialogNewItem = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-1a8faddb", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=185.js.map