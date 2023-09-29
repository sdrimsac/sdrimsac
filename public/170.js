webpackJsonp([170],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/options.vue":
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["company", "showDialog", "recordId", "configuration", "showClose", "isContingency", "generatDispatch", "dispatchId", "editDocument", "print"],
  data: function data() {
    return {
      titleDialog: null,
      loading: false,
      resource: "documents",
      errors: {},
      form: {},
      // company: {},
      locked_emission: {},
      loading_print: false,
      message: "",
      sender: null
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.initForm();

              _this.socketWhatsappConfig();

              qz.security.setCertificatePromise(function (resolve, reject) {
                _this.$http.get("/api/qz/crt/override", {
                  responseType: "text"
                }).then(function (response) {
                  resolve(response.data);
                })["catch"](function (error) {
                  reject(error.data);
                });
              });
              qz.security.setSignaturePromise(function (toSign) {
                return function (resolve, reject) {
                  _this.$http.post("/api/qz/signing", {
                    request: toSign
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                };
              }); // await this.$http.get(`/companies/record`).then(response => {
              //     if (response.data !== "") {
              //         this.company = response.data.data;
              //     }
              // });

            case 4:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  mounted: function mounted() {},
  methods: {
    socketWhatsappConfig: function socketWhatsappConfig() {
      var _this2 = this;

      var hostName = window.location.hostname;
      var url = "https://".concat(hostName);
      this.sender = hostName.replace(/https?\:\/\//, "").replace("/", "").split(".").join("");

      try {
        this.socket = io.connect(this.$socketUrl);
      } catch (e) {
        console.log(e);
      }

      this.socket.on("ready", function (message) {
        _this2.showMessage(message);
      });
      this.socket.on("authenticated", function (_ref) {
        var message = _ref.message,
            sender = _ref.sender;
        _this2.sender = sender;
        console.log(sender, " xddd");

        _this2.showMessage(message);
      });
      this.socket.on("connected", function (_ref2) {
        var message = _ref2.message;

        // this.$message.success(message);
        _this2.socket.emit("getStatus", url);
      });
      this.socket.on("setStatus", function (_ref3) {
        var status = _ref3.status,
            sender = _ref3.sender;
        _this2.sender = sender || 'sdrimsac'; // if (!status) {
        //     this.sender = "sdrimsac";
        //     this.$message.warning("Sesión iniciada con SDRIMSAC");
        // } else {
        //     this.sender = sender;
        //     this.$message.success("Whatsapp Listo!");
        // }
      }); //MessageResponse
    },
    clickSendWhatsapp: function clickSendWhatsapp() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this3.form.customer_telephone != null)) {
                  _context2.next = 22;
                  break;
                }

                formWhatsapp = {
                  id: _this3.recordId,
                  sender: _this3.sender,
                  document_id: _this3.recordId,
                  document_type_id: _this3.form.document_type_id,
                  customer_telephone: _this3.form.customer_telephone,
                  mensaje: "Su comprobante de pago electrónico " + _this3.form.number + " por S/" + _this3.form.total + " de *" + _this3.form.establishment_description + "*, ha sido generado correctamente a través del facturador electrónico de " + "*" + _this3.$desarrollador + "*"
                };
                _context2.prev = 2;
                _this3.loading = true;
                _context2.next = 6;
                return _this3.$http.post("/whatsapp", formWhatsapp);

              case 6:
                response = _context2.sent;

                if (response.status == 200) {
                  _this3.$toast.success("Mensaje enviado");

                  _this3.loading = false;
                }

                if (!_this3.configuration.xml_whatsapp) {
                  _context2.next = 14;
                  break;
                }

                formWhatsapp.xml = true;
                _context2.next = 12;
                return _this3.$http.post("/whatsapp", formWhatsapp);

              case 12:
                response = _context2.sent;

                if (response.status == 200) {
                  _this3.$toast.success("Mensaje enviado");

                  _this3.loading = false;
                }

              case 14:
                _context2.next = 19;
                break;

              case 16:
                _context2.prev = 16;
                _context2.t0 = _context2["catch"](2);
                console.log(_context2.t0, " error");

              case 19:
                _context2.prev = 19;
                _this3.loading = false;
                return _context2.finish(19);

              case 22:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[2, 16, 19, 22]]);
      }))();
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        customer_email: null,
        download_pdf: null,
        external_id: null,
        number: null,
        image_detraction: null,
        id: null,
        response_message: null,
        response_type: null,
        customer_telephone: null,
        message_text: null
      };
      this.locked_emission = {
        success: true,
        message: null
      };
    },
    print_pdf: function print_pdf(PrinterName, FileLink) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var config, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                config = qz.configs.create(PrinterName, {
                  scaleContent: false
                });

                if (qz.websocket.isActive()) {
                  _context3.next = 5;
                  break;
                }

                _context3.next = 5;
                return qz.websocket.connect(config);

              case 5:
                data = [{
                  type: "pdf",
                  format: "file",
                  data: FileLink
                }];
                qz.print(config, data)["catch"](function (e) {
                  _this4.$toast.error(e.message);
                });
                _context3.next = 12;
                break;

              case 9:
                _context3.prev = 9;
                _context3.t0 = _context3["catch"](0);

                _this4.$toast.error(_context3.t0.message);

              case 12:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 9]]);
      }))();
    },
    create: function create() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        var printer_directo, printer, formatoPdf;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this5.loading_print = true;
                _this5.message = "Cargando la información del Comprobante";
                printer_directo = null;
                printer = null;
                formatoPdf = null;
                _context4.next = 7;
                return _this5.$http.get("/".concat(_this5.resource, "/record/").concat(_this5.recordId)).then(function (response) {
                  _this5.form = response.data.data;
                  _this5.titleDialog = "Comprobante: " + _this5.form.number;
                  _this5.loading_print = false; // }

                  // }
                  if (_this5.generatDispatch) window.open("/dispatches/create/".concat(_this5.form.id, "/i/").concat(_this5.dispatchId));
                });

              case 7:
                _context4.next = 9;
                return _this5.$http.get("/".concat(_this5.resource, "/locked_emission")).then(function (response) {
                  _this5.locked_emission = response.data;
                });

              case 9:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickPrintPos: function clickPrintPos(printerName, formatoPdf) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee6() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _this6.$confirm("Elija una de las opciones", "Imprimir", {
                  confirmButtonText: "Impresión directa",
                  cancelButtonText: "Descargar PDF",
                  type: "warning"
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
                  var paperConfig, partsUrl, document, isTicket, isA4, isA5, tipoBandejaImpresora, orientation, a5_orientation, margins, config, data;
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
                    while (1) {
                      switch (_context5.prev = _context5.next) {
                        case 0:
                          _context5.prev = 0;
                          paperConfig = {
                            scaleContent: false
                          };
                          partsUrl = formatoPdf.split("/");
                          document = partsUrl[partsUrl.length - 1];
                          isTicket = document.toLowerCase().includes("ticket");
                          isA4 = document.toLowerCase().includes("a4");
                          isA5 = document.toLowerCase().includes("a5");
                          console.log(_this6.configuration, " configuraccion");
                          tipoBandejaImpresora = _this6.configuration.new_old_printer;

                          if (isA4) {
                            if (tipoBandejaImpresora == 1) {
                              paperConfig.density = 700;
                              paperConfig.orientation = "portrait";
                            } else {
                              paperConfig.density = 350;
                              paperConfig.orientation = "portrait";
                            }
                          } else {
                            orientation = "portrait";

                            if (isA5) {
                              a5_orientation = _this6.configuration.a5_orientation;
                              orientation = a5_orientation ? "landscape" : "portrait";
                            }

                            if (!isTicket && tipoBandejaImpresora == 1) {
                              //opciones que permiten hacer una impresion correcta en impresoras nuevas
                              paperConfig.density = 600;
                              paperConfig.orientation = orientation;
                              paperConfig.margins = {
                                left: 2
                              };
                            } else if (!isTicket && tipoBandejaImpresora == 0) {
                              paperConfig.density = 350;
                              paperConfig.orientation = orientation;
                              margins = {};

                              if (orientation == "landscape") {
                                margins = {
                                  top: 1.1,
                                  left: 0.95,
                                  right: 0.3,
                                  bottom: 1.1
                                };
                              } else {
                                margins = {
                                  left: 1.5
                                };
                              }

                              paperConfig.margins = margins;
                            }
                          }

                          _this6.message = "Espere imprimiendo el Comprobante " + _this6.form.number;
                          _this6.loading_print = true;
                          config = qz.configs.create(printerName, paperConfig, {
                            jobName: _this6.form.number
                          });

                          if (qz.websocket.isActive()) {
                            _context5.next = 16;
                            break;
                          }

                          _context5.next = 16;
                          return qz.websocket.connect(config);

                        case 16:
                          data = [{
                            type: "pdf",
                            format: "file",
                            data: formatoPdf
                          }];
                          qz.print(config, data)["catch"](function (e) {
                            _this6.$toast.error(e.message);
                          });
                          _this6.loading_print = false;

                          _this6.clickClose();

                          _context5.next = 25;
                          break;

                        case 22:
                          _context5.prev = 22;
                          _context5.t0 = _context5["catch"](0);

                          _this6.$toast.error(_context5.t0.message);

                        case 25:
                        case "end":
                          return _context5.stop();
                      }
                    }
                  }, _callee5, null, [[0, 22]]);
                })))["catch"](function () {
                  window.open(formatoPdf, "_blank");

                  _this6.clickClose();
                });

              case 1:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    clickPrint: function clickPrint(format) {
      if (format == "a4") {
        this.clickPrintPos(this.form.printer, this.form.print_a4);
      }

      if (format == "a5") {
        this.clickPrintPos(this.form.printer, this.form.print_a5);
      }

      if (format == "ticket") {
        console.log(this.form);
        this.clickPrintPos(this.form.printer, this.form.ticket);
      }

      if (format == "ticket_50") {
        this.clickPrintPos(this.form.printer, this.form.ticket_50);
      }
    },
    clickDownloadImage: function clickDownloadImage() {
      window.open("".concat(this.form.image_detraction), "_blank");
    },
    clickDownload: function clickDownload(format) {
      window.open("".concat(this.form.download_pdf, "/").concat(format), "_blank");
    },
    clickSendEmail: function clickSendEmail() {
      var _this7 = this;

      this.loading = true;
      this.$http.post("/".concat(this.resource, "/email"), {
        customer_email: this.form.customer_email,
        id: this.form.id
      }).then(function (response) {
        if (response.data.success) {
          _this7.$toast.success("El correo fue enviado satisfactoriamente");
        } else {
          _this7.$toast.error("Error al enviar el correo");
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this7.errors = error.response.data.errors;
        } else {
          _this7.$toast.error(error.response.data.message);
        }
      }).then(function () {
        _this7.loading = false;
      });
    },
    clickConsultCdr: function clickConsultCdr(document_id) {
      var _this8 = this;

      this.$http.get("/".concat(this.resource, "/consultarcdr/").concat(document_id)).then(function (response) {
        if (response.data.success) {
          _this8.$toast.success(response.data.message);

          _this8.$eventHub.$emit("reloadData");
        } else {
          _this8.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        _this8.$toast.error(error.response.data.message);
      });
    },
    clickFinalize: function clickFinalize() {
      location.href = this.isContingency ? "/contingencies" : "/".concat(this.resource);
    },
    clickNewDocument: function clickNewDocument() {
      this.clickClose();
    },
    clickClose: function clickClose() {
      this.$emit("update:showDialog", false);

      if (this.editDocument == true) {
        location.href = "/".concat(this.resource);
      }

      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6b0da757\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/options.vue":
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
          value: _vm.loading_print,
          expression: "loading_print"
        }
      ],
      attrs: {
        "element-loading-text": _vm.message,
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "close-on-click-modal": false,
        "close-on-press-escape": false,
        "show-close": false,
        "append-to-body": ""
      },
      on: { open: _vm.create }
    },
    [
      _vm.form.response_message
        ? _c("div", { staticClass: "row mb-4" }, [
            _c(
              "div",
              { staticClass: "col-md-12" },
              [
                _c("el-alert", {
                  attrs: {
                    title: _vm.form.response_message,
                    type: _vm.form.response_type,
                    "show-icon": ""
                  }
                })
              ],
              1
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        !_vm.locked_emission.success
          ? _c(
              "div",
              {
                staticClass:
                  "col-lg-12 col-md-12 col-sm-12 text-center font-weight-bold"
              },
              [
                _c("el-alert", {
                  attrs: {
                    title: _vm.locked_emission.message,
                    type: "warning",
                    "show-icon": ""
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-lg btn-info waves-effect waves-light",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.clickPrint("a4")
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-file-alt" })]
            ),
            _vm._v(" "),
            _c("p", [_vm._v("Imprimir A4")])
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-lg btn-info waves-effect waves-light",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.clickPrint("a5")
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-receipt" })]
            ),
            _vm._v(" "),
            _c("p", [_vm._v("Imprimir A5")])
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-lg btn-info waves-effect waves-light",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.clickPrint("ticket")
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-receipt" })]
            ),
            _vm._v(" "),
            _c("p", [_vm._v("Imprimir Ticket 80MM")])
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-lg btn-info waves-effect waves-light",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.clickPrint("ticket_50")
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-receipt" })]
            ),
            _vm._v(" "),
            _c("p", [_vm._v("Imprimir Ticket 50MM")])
          ]
        ),
        _vm._v(" "),
        _vm.form.image_detraction
          ? _c(
              "div",
              {
                staticClass:
                  "col-lg-12 col-md-12 col-sm-12 text-center font-weight-bold mt-3"
              },
              [
                _c(
                  "a",
                  {
                    staticClass: "text-center font-weight-bold ",
                    attrs: {
                      href: "" + this.form.image_detraction,
                      download: ""
                    }
                  },
                  [_vm._v("Descargar constancia de pago - detracción")]
                )
              ]
            )
          : _vm._e()
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-3" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "el-input",
              {
                model: {
                  value: _vm.form.customer_email,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "customer_email", $$v)
                  },
                  expression: "form.customer_email"
                }
              },
              [
                _c(
                  "el-button",
                  {
                    attrs: {
                      slot: "append",
                      icon: "el-icon-message",
                      loading: _vm.loading
                    },
                    on: { click: _vm.clickSendEmail },
                    slot: "append"
                  },
                  [_vm._v("Enviar")]
                ),
                _vm._v(" "),
                _c("i", {
                  staticClass: "el-icon-edit-outline",
                  attrs: { slot: "prefix" },
                  slot: "prefix"
                })
              ],
              1
            ),
            _vm._v(" "),
            _vm.errors.customer_email
              ? _c("small", {
                  staticClass: "form-control-feedback",
                  domProps: {
                    textContent: _vm._s(_vm.errors.customer_email[0])
                  }
                })
              : _vm._e()
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-3" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "el-input",
              {
                model: {
                  value: _vm.form.customer_telephone,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "customer_telephone", $$v)
                  },
                  expression: "form.customer_telephone"
                }
              },
              [
                _c("template", { slot: "prepend" }, [_vm._v("+51")]),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: { slot: "append" },
                    on: { click: _vm.clickSendWhatsapp },
                    slot: "append"
                  },
                  [
                    _vm._v("Enviar\n                    "),
                    _c(
                      "el-tooltip",
                      {
                        staticClass: "item",
                        attrs: {
                          effect: "dark",
                          content: "Es necesario tener aperturado Whatsapp web",
                          placement: "top-start"
                        }
                      },
                      [_c("i", { staticClass: "fab fa-whatsapp" })]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c("i", {
                  staticClass: "el-icon-edit-outline",
                  attrs: { slot: "prefix" },
                  slot: "prefix"
                })
              ],
              2
            ),
            _vm._v(" "),
            _vm.errors.customer_telephone
              ? _c("small", {
                  staticClass: "form-control-feedback",
                  domProps: {
                    textContent: _vm._s(_vm.errors.customer_telephone[0])
                  }
                })
              : _vm._e()
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
        [
          _vm.showClose
            ? [
                _c("el-button", { on: { click: _vm.clickClose } }, [
                  _vm._v("Cerrar")
                ])
              ]
            : [
                _c(
                  "el-button",
                  { staticClass: "list", on: { click: _vm.clickFinalize } },
                  [_vm._v("Ir al listado")]
                ),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: { type: "primary" },
                    on: { click: _vm.clickNewDocument }
                  },
                  [_vm._v("Nuevo comprobante")]
                )
              ]
        ],
        2
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
    require("vue-hot-reload-api")      .rerender("data-v-6b0da757", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/documents/partials/options.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/options.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-6b0da757\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/options.vue")
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
Component.options.__file = "resources/js/views/documents/partials/options.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6b0da757", Component.options)
  } else {
    hotAPI.reload("data-v-6b0da757", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=170.js.map