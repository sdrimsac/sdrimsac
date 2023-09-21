webpackJsonp([203],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/change_data_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/change_data_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0838561a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/change_data_modal.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/change_data_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0838561a", Component.options)
  } else {
    hotAPI.reload("data-v-0838561a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/change_data_modal.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

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
//
//
//
//
//
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
  props: ["showDialog", "record"],
  data: function data() {
    return {
      form: {},
      loading: false
    };
  },
  methods: {
    transformMac: function transformMac(mac) {
      mac = mac.replace(/:/g, "");
      var regex = /\b([\w:]+)\b/g;
      var words = [];
      mac.replace(regex, function (_, word) {
        if (/^[a-zA-Z0-9:]+$/.test(word)) {
          words.push(word);
        }
      });
      var formatedMac = words.map(function (word) {
        if (word.length > 2) {
          var chars = word.split("");
          var two = [];

          for (var i = 0; i < chars.length; i += 2) {
            two.push(chars.slice(i, i + 2).join(""));
          }

          return two.join(":");
        } else {
          return word;
        }
      }).join(" ");
      this.form.mac = formatedMac;
    },
    getRecord: function getRecord() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, register;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this.loading = true;
                _context.next = 4;
                return _this.$http("/internet/register/data/".concat(_this.record.id));

              case 4:
                response = _context.sent;

                if (response.status == 200) {
                  register = response.data.register;
                  _this.form = register;
                }

                _context.next = 11;
                break;

              case 8:
                _context.prev = 8;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);

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
    },
    openDialog: function openDialog() {
      this.getRecord();
    },
    closeDialog: function closeDialog() {
      this.$emit("update:showDialog", false);
    },
    validate: function validate() {
      var fail = false;
      var errors = {
        type: "El tipo de instalación es obligatorio",
        mac: "La MAC es obligatoria",
        installation_address: "La dirección es obligatoria",
        identifier: "El id es obligatorio",
        supplie: "El suministro eléctrico es obligatorio"
      };

      var _iterator = _createForOfIteratorHelper(Object.keys(errors).reverse()),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var error = _step.value;

          if (!this.form[error]) {
            fail = true;
            this.$toast.error(errors[error]);
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      if (!this.form.telephone) {
        fail = true;
        this.$toast.error("El teléfono es obligatorio");
      } else {
        if (this.form.telephone.length != 9) {
          fail = true;
          this.$toast.error("El teléfono debe tener 9 dígitos");
        }
      }

      if (this.form.mac) {
        var mac = this.form.mac;
        mac = mac.split(":");

        if (mac.length != 6) {
          fail = true;
          this.$toast.error("La MAC debe tener 6 pares de caracteres separados por dos puntos (:)");
        } else {
          for (var i = 0; i < mac.length; i++) {
            if (mac[i].length != 2) {
              fail = true;
              this.$toast.error("La MAC debe tener 6 pares de caracteres separados por dos puntos (:)");
            }
          }
        }
      }

      if (this.form.supplie) {
        if (Number.isNaN(this.form.supplie)) {
          fail = true;
          this.$toast.error("El suministro debe ser numérico");
        }

        if (this.form.supplie.toString().length != 8) {
          fail = true;
          this.$toast.error("El suministro debe tener 8 dígitos");
        }
      }

      return fail;
    },
    submit: function submit() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!_this2.validate()) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                _context2.prev = 2;
                _this2.loading = true;
                _context2.next = 6;
                return _this2.$http.post("/internet/register/data", _this2.form);

              case 6:
                response = _context2.sent;

                if (response.status == 200) {
                  _this2.$toast.success("Datos actualizados");

                  _this2.$emit("getRecords");

                  _this2.$emit("update:showDialog", false);
                }

                _context2.next = 13;
                break;

              case 10:
                _context2.prev = 10;
                _context2.t0 = _context2["catch"](2);
                console.log(_context2.t0);

              case 13:
                _context2.prev = 13;
                _this2.loading = false;
                return _context2.finish(13);

              case 16:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[2, 10, 13, 16]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0838561a\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/change_data_modal.vue":
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
        title: "Actualizar datos",
        "append-to-body": ""
      },
      on: { open: _vm.openDialog, close: _vm.closeDialog }
    },
    [
      _c("div", { staticClass: "row mt-2" }, [
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "type" } }, [_vm._v("Tipo")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
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
                  attrs: { value: "antena", label: "Antena", id: "antena" }
                }),
                _vm._v(" "),
                _c("el-option", {
                  attrs: { value: "fibra", label: "Fibra", id: "fibra" }
                })
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "id" } }, [_vm._v("Id Precinto")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "Id Precinto" },
              model: {
                value: _vm.form.identifier,
                callback: function($$v) {
                  _vm.$set(_vm.form, "identifier", $$v)
                },
                expression: "form.identifier"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "mac" } }, [_vm._v("MAC")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "MAC" },
              on: { input: _vm.transformMac },
              model: {
                value: _vm.form.mac,
                callback: function($$v) {
                  _vm.$set(_vm.form, "mac", $$v)
                },
                expression: "form.mac"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "supplie" } }, [
              _vm._v("Suministro eléctrico")
            ]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "Suministro eléctrico" },
              model: {
                value: _vm.form.supplie,
                callback: function($$v) {
                  _vm.$set(_vm.form, "supplie", $$v)
                },
                expression: "form.supplie"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "ip" } }, [_vm._v("Dirección")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "Dirección" },
              model: {
                value: _vm.form.installation_address,
                callback: function($$v) {
                  _vm.$set(_vm.form, "installation_address", $$v)
                },
                expression: "form.installation_address"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "ip" } }, [_vm._v("Referencia")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "Referencia" },
              model: {
                value: _vm.form.reference_installation_address,
                callback: function($$v) {
                  _vm.$set(_vm.form, "reference_installation_address", $$v)
                },
                expression: "form.reference_installation_address"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { attrs: { for: "ip" } }, [_vm._v("Celular")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { placeholder: "Celular" },
              model: {
                value: _vm.form.telephone,
                callback: function($$v) {
                  _vm.$set(_vm.form, "telephone", $$v)
                },
                expression: "form.telephone"
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
          _c("el-button", { on: { click: _vm.closeDialog } }, [
            _vm._v("Cancelar")
          ]),
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
    require("vue-hot-reload-api")      .rerender("data-v-0838561a", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=203.js.map