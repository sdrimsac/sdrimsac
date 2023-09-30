webpackJsonp([138],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/WhatsappModalReports.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["resource", "message", "showWhatsappForm"],
  data: function data() {
    return {
      loading: false,
      number: null,
      configuration: {}
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.socketWhatsappConfig();

              _context.next = 3;
              return _this.getConfiguration();

            case 3:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    send: function send() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this2.sender == "sdrimsac")) {
                  _context2.next = 5;
                  break;
                }

                _context2.next = 3;
                return _this2.sendWhatsapp();

              case 3:
                _context2.next = 7;
                break;

              case 5:
                _context2.next = 7;
                return _this2.sendFile();

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getConfiguration: function getConfiguration() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _context3.next = 3;
                return _this3.$http("/configurations/record");

              case 3:
                response = _context3.sent;
                data = response.data.data;
                _this3.configuration = data;
                _context3.next = 11;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);

                _this3.$toast.error("No se pudo obtener la configuración");

              case 11:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8]]);
      }))();
    },
    open: function open() {},
    socketWhatsappConfig: function socketWhatsappConfig() {
      var _this4 = this;

      var hostName = window.location.hostname;
      var url = "https://".concat(hostName);
      this.sender = hostName.replace(/https?\:\/\//, "").replace("/", "").split(".").join("");

      try {
        this.socket = io.connect(this.$socketUrl);
      } catch (e) {
        console.log(e);
      }

      this.socket.on("ready", function (message) {
        _this4.showMessage(message);
      });
      this.socket.on("authenticated", function (_ref) {
        var message = _ref.message,
            sender = _ref.sender;
        _this4.sender = sender;

        _this4.showMessage(message);
      });
      this.socket.on("connected", function (_ref2) {
        var message = _ref2.message;

        _this4.$message.success(message);

        _this4.socket.emit("getStatus", url);
      });
      this.socket.on("setStatus", function (_ref3) {
        var status = _ref3.status,
            sender = _ref3.sender;

        if (!status) {
          _this4.sender = "sdrimsac";

          _this4.$message.warning("Sesión iniciada con SDRIMSAC");
        } else {
          _this4.sender = sender;

          _this4.$message.success("Whatsapp Listo!");
        }
      }); //MessageResponse

      this.socket.on("MessageResponse", function (_ref4) {
        var success = _ref4.success,
            message = _ref4.message;

        if (success) {
          _this4.$message.success(message);
        } else {
          _this4.$message.error(message);
        }
      });
    },
    getBase64FromUrl: function getBase64FromUrl(url) {
      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var data, blob;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.next = 2;
                return fetch(url);

              case 2:
                data = _context4.sent;
                _context4.next = 5;
                return data.blob();

              case 5:
                blob = _context4.sent;
                return _context4.abrupt("return", new Promise(function (resolve) {
                  var reader = new FileReader();
                  reader.readAsDataURL(blob);

                  reader.onloadend = function () {
                    var base64data = reader.result;
                    resolve(base64data);
                  };
                }));

              case 7:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    sendFile: function sendFile() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        var b64, extension, msg;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _context5.prev = 0;

                if (!(!_this5.number || _this5.number.length != 9 || isNaN(_this5.number))) {
                  _context5.next = 3;
                  break;
                }

                return _context5.abrupt("return", _this5.$toast.error("Ingrese un número válido"));

              case 3:
                _this5.loading = true;
                _context5.next = 6;
                return _this5.getBase64FromUrl(_this5.resource);

              case 6:
                b64 = _context5.sent;
                extension = ".pdf";
                b64 = b64.split(",")[1];

                _this5.socket.emit("sendFile", {
                  file: b64,
                  name: "".concat(_this5.message.split(" ").join("-")).concat(_this5.message.includes(".xlsx") ? "" : extension),
                  number: "51".concat(_this5.number),
                  sender: _this5.sender
                });

                _this5.$toast.success("Se envió el mensaje");

                _this5.close();

                _context5.next = 19;
                break;

              case 14:
                _context5.prev = 14;
                _context5.t0 = _context5["catch"](0);
                msg = "Ocurrió un error";
                console.log(_context5.t0);

                _this5.$toast.error(msg);

              case 19:
                _context5.prev = 19;
                _this5.loading = false;
                return _context5.finish(19);

              case 22:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, null, [[0, 14, 19, 22]]);
      }))();
    },
    sendWhatsapp: function sendWhatsapp() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        var response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                if (!(!_this6.number || _this6.number.length != 9 || isNaN(_this6.number))) {
                  _context6.next = 2;
                  break;
                }

                return _context6.abrupt("return", _this6.$toast.error("Ingrese un número válido"));

              case 2:
                _this6.loading = true;
                _context6.prev = 3;
                _context6.next = 6;
                return _this6.$http.post("/whatsapp/historial", {
                  number: _this6.number,
                  message: _this6.message,
                  resource: _this6.resource,
                  file_name: _this6.message.split(" ").join("-"),
                  sender: _this6.sender
                });

              case 6:
                response = _context6.sent;

                if (response.status == 200) {
                  _this6.$toast.success("Mensaje enviado");
                }

                _context6.next = 14;
                break;

              case 10:
                _context6.prev = 10;
                _context6.t0 = _context6["catch"](3);

                _this6.$toast.error("Mensaje no enviado");

                console.log(_context6.t0);

              case 14:
                _context6.prev = 14;
                _this6.loading = false;

                _this6.close();

                return _context6.finish(14);

              case 18:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, null, [[3, 10, 14, 18]]);
      }))();
    },
    close: function close() {
      this.number = null;
      this.$emit("update:showWhatsappForm", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-9a297822\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/WhatsappModalReports.vue":
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
        width: "40%",
        title: "Enviar reporte por whatsapp",
        visible: _vm.showWhatsappForm
      },
      on: { close: _vm.close, open: _vm.open }
    },
    [
      _c(
        "div",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading,
              expression: "loading"
            }
          ],
          staticClass: "p-3",
          attrs: { "element-loading-text": "Enviando.." }
        },
        [
          _c("label", { attrs: { for: "" } }, [_vm._v("Número")]),
          _vm._v(" "),
          _c("el-input", {
            staticStyle: { width: "100%" },
            model: {
              value: _vm.number,
              callback: function($$v) {
                _vm.number = $$v
              },
              expression: "number"
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "d-flex justify-content-end p-1" },
            [_c("el-button", { on: { click: _vm.send } }, [_vm._v("Enviar")])],
            1
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
    require("vue-hot-reload-api")      .rerender("data-v-9a297822", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/components/WhatsappModalReports.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/WhatsappModalReports.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-9a297822\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/WhatsappModalReports.vue")
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
Component.options.__file = "resources/js/components/WhatsappModalReports.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-9a297822", Component.options)
  } else {
    hotAPI.reload("data-v-9a297822", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=138.js.map