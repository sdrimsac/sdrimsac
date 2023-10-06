webpackJsonp([205],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/image_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/image_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6d77fff5\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/image_modal.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/image_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6d77fff5", Component.options)
  } else {
    hotAPI.reload("data-v-6d77fff5", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/image_modal.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "record"],
  data: function data() {
    return {
      loading: false,
      imageSaved: null
    };
  },
  methods: {
    open: function open() {
      this.imageSaved = this.record.house_photo;
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    changeImage: function changeImage() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var files, file, reader;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                files = _this.$refs.file.files;

                if (files.length > 0) {
                  file = files[0];

                  try {
                    reader = new FileReader();

                    reader.onload = /*#__PURE__*/function () {
                      var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee(e) {
                        var base64Image, response, image, message;
                        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                          while (1) {
                            switch (_context.prev = _context.next) {
                              case 0:
                                base64Image = e.target.result;
                                _this.loading = true;
                                _context.prev = 2;
                                _context.next = 5;
                                return _this.$http.post("/internet/image", {
                                  image: base64Image,
                                  id: _this.record.id
                                });

                              case 5:
                                response = _context.sent;

                                _this.$emit("getRecords");

                                _this.$toast.success("Imagen actualizada");

                                image = response.data.image;
                                _this.imageSaved = image;
                                _this.loading = false;
                                _context.next = 18;
                                break;

                              case 13:
                                _context.prev = 13;
                                _context.t0 = _context["catch"](2);
                                message = _context.t0.response.data.message;

                                _this.$toast.error(message);

                                _this.loading = false;

                              case 18:
                              case "end":
                                return _context.stop();
                            }
                          }
                        }, _callee, null, [[2, 13]]);
                      }));

                      return function (_x) {
                        return _ref.apply(this, arguments);
                      };
                    }();

                    reader.readAsDataURL(file);
                  } catch (e) {
                    console.log(e);
                  }
                }

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6d77fff5\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/image_modal.vue":
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
        "append-to-body": "",
        visible: _vm.showDialog,
        title: "Imagen de la casa"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "div",
        {
          staticClass:
            " d-flex flex-column justify-content-center align-items-center"
        },
        [
          _vm.imageSaved
            ? _c(
                "div",
                {
                  staticClass: "col-12 mb-2 d-flex  justify-content-center ",
                  staticStyle: { "max-width": "350px" }
                },
                [
                  _c("img", {
                    staticClass: "img-thumbnail",
                    attrs: { src: _vm.imageSaved, alt: "imagen" }
                  })
                ]
              )
            : _c("div", [_c("el-empty", { attrs: { "image-size": 350 } })], 1),
          _vm._v(" "),
          _c(
            "el-button",
            {
              staticClass: "m-2",
              attrs: { type: "success" },
              on: {
                click: function($event) {
                  return _vm.$refs.file.click()
                }
              }
            },
            [_vm._v("\n            Subir imagen\n        ")]
          ),
          _vm._v(" "),
          _c("p", [_c("em", [_vm._v("JPG, PNG, JPEG ")])]),
          _vm._v(" "),
          _c("input", {
            ref: "file",
            staticStyle: { display: "none" },
            attrs: { accept: "image/png, image/jpeg, image/jpg", type: "file" },
            on: { change: _vm.changeImage }
          })
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
    require("vue-hot-reload-api")      .rerender("data-v-6d77fff5", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=205.js.map