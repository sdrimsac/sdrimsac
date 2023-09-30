webpackJsonp([140],{

/***/ "./modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2c2e76ba\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue")
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
Component.options.__file = "modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2c2e76ba", Component.options)
  } else {
    hotAPI.reload("data-v-2c2e76ba", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog"],
  data: function data() {
    return {
      resource: '/consignment/penalty',
      loading: false,
      form: {
        id: null,
        description: null,
        type: 'percent',
        amount: 0.0
      }
    };
  },
  methods: {
    open: function open() {
      this.form = {
        id: null,
        description: null,
        type: 'percent',
        amount: 0.0
      };
    },
    close: function close() {
      this.$emit('update:showDialog', false);
    },
    create: function create() {
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
                return _this.$http.post(_this.resource, _this.form);

              case 4:
                response = _context.sent;

                if (response.data.success) {
                  _this.$message({
                    type: 'success',
                    message: 'Penalización creada correctamente'
                  });

                  _this.$emit('reloadPenalties', response.data.id);

                  _this.close();
                }

                _context.next = 11;
                break;

              case 8:
                _context.prev = 8;
                _context.t0 = _context["catch"](0);

                _this.$message({
                  type: 'error',
                  message: 'Ocurrió un error al crear la penalización'
                });

              case 11:
                _context.prev = 11;
                _this.loading = false;
                return _context.finish(11);

              case 14:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 8, 11, 14]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2c2e76ba\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Consignment/Resources/assets/js/views/partials/penalty_form.vue":
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
        title: "Creación de penalización",
        "append-to-body": "",
        width: "500px"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row m-2" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c("label", { attrs: { for: "description" } }, [
              _vm._v("Descripción")
            ]),
            _vm._v(" "),
            _c("el-input", {
              staticClass: "w-100",
              attrs: {
                placeholder: "Descripción de la penalización",
                type: "text",
                dusk: "description"
              },
              model: {
                value: _vm.form.description,
                callback: function($$v) {
                  _vm.$set(_vm.form, "description", $$v)
                },
                expression: "form.description"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c("label", { attrs: { for: "type" } }, [_vm._v("Tipo")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: { placeholder: "Seleccione un tipo", dusk: "type" },
                model: {
                  value: _vm.form.type,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "type", $$v)
                  },
                  expression: "form.type"
                }
              },
              [
                _c("el-option", {
                  attrs: { label: "Porcentaje", value: "percent" }
                }),
                _vm._v(" "),
                _c("el-option", { attrs: { label: "Fijo", value: "fixed" } })
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c("label", { attrs: { for: "amount" } }, [_vm._v("Valor")]),
            _vm._v(" "),
            _c("el-input", {
              staticClass: "w-100",
              attrs: {
                placeholder: "Valor de la penalización",
                type: "number",
                dusk: "amount"
              },
              model: {
                value: _vm.form.amount,
                callback: function($$v) {
                  _vm.$set(_vm.form, "amount", $$v)
                },
                expression: "form.amount"
              }
            })
          ],
          1
        )
      ]),
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
            { attrs: { type: "primary" }, on: { click: _vm.create } },
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
    require("vue-hot-reload-api")      .rerender("data-v-2c2e76ba", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=140.js.map