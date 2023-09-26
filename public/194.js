webpackJsonp([194],{

/***/ "./modules/LotItem/Resources/assets/js/view/form_edit.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/LotItem/Resources/assets/js/view/form_edit.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-12f5c520\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/LotItem/Resources/assets/js/view/form_edit.vue")
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
Component.options.__file = "modules/LotItem/Resources/assets/js/view/form_edit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-12f5c520", Component.options)
  } else {
    hotAPI.reload("data-v-12f5c520", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/LotItem/Resources/assets/js/view/form_edit.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "recordId"],
  data: function data() {
    return {
      titleDialog: "Series",
      loading: false,
      errors: {},
      form: {}
    };
  },
  created: function created() {
    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    initForm: function initForm() {
      this.form = {
        series: null,
        date: null
      };
    },
    open: function open() {
      var _this = this;

      this.initForm();
      this.loading = true;
      this.$http.get("/lotitem/record/".concat(this.recordId)).then(function (response) {
        _this.form = response.data.record;
        console.log(_this.form);
        _this.loading = false;
      })["catch"](function (error) {
        _this.loading = false;
        _this.errors = error.response.data.errors;
      });
    },
    close: function close() {
      this.form = {};
      this.errors = {};
      this.$emit("update:showDialog", false);
    },
    submit: function submit() {
      var _this2 = this;

      this.loading = true;
      this.$http.post("/lotitem/record", this.form).then(function (response) {
        var message = response.data.message;
        _this2.loading = false;

        _this2.$toast.success(message);

        _this2.$emit("update:showDialog", false);

        _this2.$emit("reload");
      })["catch"](function (error) {
        _this2.loading = false;
        _this2.errors = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-12f5c520\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/LotItem/Resources/assets/js/view/form_edit.vue":
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
      attrs: { title: _vm.titleDialog, visible: _vm.showDialog },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row m-2" }, [
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", { attrs: { for: "serie" } }, [_vm._v("Serie")]),
            _vm._v(" "),
            _c("el-input", {
              staticClass: "w-100",
              model: {
                value: _vm.form.series,
                callback: function($$v) {
                  _vm.$set(_vm.form, "series", $$v)
                },
                expression: "form.series"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", { attrs: { for: "serie" } }, [_vm._v("Fecha")]),
            _vm._v(" "),
            _c("el-date-picker", {
              staticClass: "w-100",
              attrs: {
                type: "date",
                "value-format": "yyyy-MM-dd",
                "default-timezone": "local"
              },
              model: {
                value: _vm.form.date,
                callback: function($$v) {
                  _vm.$set(_vm.form, "date", $$v)
                },
                expression: "form.date"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", { attrs: { for: "serie" } }, [_vm._v("Estado")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                model: {
                  value: _vm.form.state,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "state", $$v)
                  },
                  expression: "form.state"
                }
              },
              [
                _c("el-option", { attrs: { value: "Activo" } }, [
                  _vm._v("Activo")
                ]),
                _vm._v(" "),
                _c("el-option", { attrs: { value: "Inactivo" } }, [
                  _vm._v("Inactivo")
                ])
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row m-2" }),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "dialog-footer",
          attrs: { slot: "footer" },
          slot: "footer"
        },
        [
          _c("el-button", { on: { click: _vm.close } }, [_vm._v("Cancelar")]),
          _vm._v(" "),
          _c(
            "el-button",
            { attrs: { type: "primary" }, on: { click: _vm.submit } },
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
    require("vue-hot-reload-api")      .rerender("data-v-12f5c520", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=194.js.map