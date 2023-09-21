webpackJsonp([146,124,169],{

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

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_functions__ = __webpack_require__("./resources/js/mixins/functions.js");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_functions__["c" /* serviceNumber */]],
  props: ["worker", "showDialog", "type", "recordId", "external", "document_type_id", "input_person", "user_id", "newTech"],
  data: function data() {
    return {
      zones: [],
      social_medias: [],
      loading_submit: false,
      titleDialog: null,
      resource: this.worker ? "caja/worker/persons" : "persons",
      errors: {},
      api_service_token: false,
      form: {},
      countries: [],
      all_departments: [],
      all_provinces: [],
      all_districts: [],
      provinces: [],
      districts: [],
      locations: [],
      person_types: [],
      identity_document_types: [],
      all_users: []
    };
  },
  created: function created() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              console.log(_this.newTech, " a");
              _context.next = 3;
              return _this.initForm();

            case 3:
              _context.next = 5;
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.api_service_token = response.data.api_service_token;
                _this.social_medias = response.data.social_media;
                _this.all_users = response.data.users;
                _this.countries = response.data.countries;
                _this.all_departments = response.data.departments;
                _this.all_provinces = response.data.provinces;
                _this.zones = response.data.zones;
                _this.all_districts = response.data.districts;
                _this.identity_document_types = response.data.identity_document_types;
                _this.locations = response.data.locations;
                _this.person_types = response.data.person_types;
              });

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  computed: {
    maxLength: function maxLength() {
      if (this.form.identity_document_type_id === "6") {
        return 11;
      }

      if (this.form.identity_document_type_id === "1") {
        return 8;
      }
    }
  },
  methods: {
    nuevoMetodo: function nuevoMetodo() {
      var admin = this.all_users.find(function (user) {
        return user.type == "admin";
      });

      if (admin) {
        this.form.seller_id = admin.id;
      } else {
        if (this.all_users.length != 0) {
          this.form.seller_id = this.all_users[0].id;
        }
      }
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        type: this.type,
        identity_document_type_id: "6",
        number: "",
        name: null,
        trade_name: null,
        country_id: "PE",
        department_id: null,
        province_id: null,
        district_id: null,
        address: null,
        telephone: null,
        condition: null,
        state: null,
        email: null,
        perception_agent: false,
        percentage_perception: 0,
        person_type_id: null,
        comment: null,
        addresses: [],
        seller_id: null
      };
    },
    opened: function opened() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this2.external && _this2.input_person)) {
                  _context2.next = 8;
                  break;
                }

                if (!(_this2.form.number.length === 8 || _this2.form.number.length === 11)) {
                  _context2.next = 8;
                  break;
                }

                if (!(_this2.api_service_token != false)) {
                  _context2.next = 7;
                  break;
                }

                _context2.next = 5;
                return _this2.$eventHub.$emit("enableClickSearch");

              case 5:
                _context2.next = 8;
                break;

              case 7:
                _this2.searchCustomer();

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    create: function create() {
      var _this3 = this;

      if (this.external) {
        if (this.document_type_id === "01") {
          this.form.identity_document_type_id = "6";
        }

        if (this.document_type_id === "03") {
          this.form.identity_document_type_id = "1";
        }

        if (this.input_person) {
          this.form.identity_document_type_id = this.input_person.identity_document_type_id ? this.input_person.identity_document_type_id : this.form.identity_document_type_id;
          this.form.number = this.input_person.number ? this.input_person.number : "";
        }
      }

      if (this.type == undefined) {
        this.titleDialog = this.newTech ? "Nuevo Técnico" : "Nuevo Cliente";
      }

      if (this.type === "customers") {
        this.titleDialog = this.recordId ? "Editar Cliente" : "Nuevo Cliente";
      }

      if (this.type === "suppliers") {
        this.titleDialog = this.recordId ? "Editar Proveedor" : "Nuevo Proveedor";
      }

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this3.form = response.data.data;

          _this3.filterProvinces();

          _this3.filterDistricts();
        });
      }
    },
    clickAddAddress: function clickAddAddress() {
      /* this.form.more_address.push({
              location_id: [],
              address: null,
          })*/
      this.form.addresses.push({
        id: null,
        country_id: "PE",
        location_id: [],
        address: null,
        email: null,
        phone: null,
        main: false
      });
    },
    submit: function submit() {
      var _this4 = this;

      this.nuevoMetodo();

      if (!this.form.seller_id) {
        this.$toast.error("Debe seleccionar un asesor");
        return;
      }

      if (this.form.identity_document_type_id == "6" && this.form.number.length != 11) {
        this.$toast.error("La longitud del RUC debe ser de 11");
        return;
      }

      if (this.form.identity_document_type_id == "1" && this.form.number.length != 8) {
        this.$toast.error("La longitud del DNI debe ser de 8");
        return;
      }

      this.loading_submit = true;
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this4.$toast.success(response.data.message);

          _this4.$emit("add_customer", response.data.id);

          if (_this4.external) {
            _this4.$eventHub.$emit("reloadDataPersons", response.data.id);
          } else {
            _this4.$eventHub.$emit("reloadData");
          }

          _this4.close();
        } else {
          _this4.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          console.log(error.response.data.errors);
          _this4.errors = error.response.data.errors;
        } else {
          console.log(error);
        }
      }).then(function () {
        _this4.loading_submit = false;
      });
    },
    changeIdentityDocType: function changeIdentityDocType() {
      this.recordId == null ? this.setDataDefaultCustomer() : null;
    },
    setDataDefaultCustomer: function setDataDefaultCustomer() {
      if (this.form.identity_document_type_id == "0") {
        this.form.number = "99999999";
        this.form.name = "Clientes - Varios";
      } else {
        this.form.number = "";
        this.form.name = null;
      }
    },
    close: function close() {
      this.$eventHub.$emit("initInputPerson");
      this.$emit("update:showDialog", false);
      this.initForm();
    },
    searchCustomer: function searchCustomer() {
      this.searchServiceNumberByType();
    },
    searchNumber: function searchNumber(data) {
      this.form.district_id = data.ubigeo[2];
      this.filterDistricts();
      this.form.name = this.form.identity_document_type_id === "1" ? data.nombre_completo : data.nombre_o_razon_social;
      this.form.trade_name = this.form.identity_document_type_id === "6" ? data.nombre_o_razon_social : "";
      this.form.location_id = data.ubigeo;
      this.form.department_id = data.ubigeo ? data.ubigeo[0] : null;
      this.form.province_id = data.ubigeo ? data.ubigeo[1] : null;
      this.form.district_id = data.ubigeo ? data.ubigeo[2] : null;
      this.filterProvinces();
      this.filterDistricts();
      this.form.address = data.direccion;
      this.form.condition = data.condicion;
      this.form.state = data.estado;
    },
    clickRemoveAddress: function clickRemoveAddress(index) {
      this.form.addresses.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sale_notes/partials/option_documents.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__documents_partials_options_vue__ = __webpack_require__("./resources/js/views/documents/partials/options.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__documents_partials_options_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__documents_partials_options_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__persons_form_vue__ = __webpack_require__("./resources/js/views/persons/form.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__persons_form_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__persons_form_vue__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    DocumentOptions: __WEBPACK_IMPORTED_MODULE_1__documents_partials_options_vue___default.a,
    PersonForm: __WEBPACK_IMPORTED_MODULE_2__persons_form_vue___default.a
  },
  props: ["showDialog", "recordId", "showClose", "showGenerate", "fromCaja", "configuration"],
  data: function data() {
    return {
      titleDialog: null,
      loading: false,
      resource: "sale-notes",
      resource_documents: "documents",
      errors: {},
      form: {},
      document: {},
      document_types: [],
      all_document_types: [],
      all_series: [],
      all_customers: [],
      series: [],
      generate: false,
      loading_submit: false,
      loading_documents: false,
      showDialogDocumentOptions: false,
      documentNewId: null,
      flag_generate: true,
      dispatches: [],
      generate_dispatch: false,
      dispatch_id: null,
      loading_search: false,
      has_data_detraction: false,
      customers: [],
      operation_types: [],
      input_person: {},
      showDialogNewPerson: false,
      document_type_03_filter: null
    };
  },
  created: function created() {
    this.initForm();
    this.initDocument();
  },
  methods: {
    initForm: function initForm() {
      this.generate = this.showGenerate ? true : false;
      this.errors = {};
      this.form = {
        id: null,
        external_id: null,
        identifier: null,
        date_of_issue: null,
        sale_note: null
      };
      this.generate_dispatch = false;
    },
    changeOperationType: function changeOperationType() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.filterCustomers();

              case 2:
                _context.next = 4;
                return _this.setDataDetraction();

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    clickRemoveItem: function clickRemoveItem(index) {
      this.document.items.splice(index, 1);
      this.calculateTotal();
    },
    keyupCustomer: function keyupCustomer() {
      if (this.input_person.number) {
        if (!isNaN(parseInt(this.input_person.number))) {
          switch (this.input_person.number.length) {
            case 8:
              this.input_person.identity_document_type_id = "1";
              this.showDialogNewPerson = true;
              break;

            case 11:
              this.input_person.identity_document_type_id = "6";
              this.showDialogNewPerson = true;
              break;

            default:
              this.input_person.identity_document_type_id = "6";
              this.showDialogNewPerson = true;
              break;
          }
        }
      }
    },
    reloadDataCustomers: function reloadDataCustomers(customer_id) {
      var _this2 = this;

      this.$http.get("/documents/search/customer/".concat(customer_id)).then(function (response) {
        _this2.searchRemoteCustomers(response.data.customers.name); //this.customers = response.data.customers


        _this2.form.customer_id = customer_id;
      });
    },
    searchRemoteCustomers: function searchRemoteCustomers(input) {
      var _this3 = this;

      if (input.length > 0) {
        // if (input!="") {
        this.loading_search = true;
        var parameters = "input=".concat(input, "&document_type_id=").concat(this.document.document_type_id, "&operation_type_id=").concat(this.document.operation_type_id, "&seller_id=").concat(this.document.user_id);
        this.$http.get("/".concat(this.resource, "/search/customers?").concat(parameters)).then(function (response) {
          _this3.customers = response.data.customers;
          _this3.loading_search = false;
          _this3.input_person.number = null;

          if (_this3.customers.length == 0) {
            _this3.input_person.number = input;

            _this3.filterCustomers();
          }
        });
      } else {
        // this.customers = []
        this.filterCustomers();
        this.input_person.number = null;
      } // this.filterCustomers()

    },
    addRowCliente: function addRowCliente(data) {
      //console.log(data)
      this.document.customer_id = data.id;
      this.searchRemoteCustomers(data.number);
    },
    filterCustomers: function filterCustomers() {
      if (this.document.operation_type_id === "0101" || this.document.operation_type_id === "1001") {
        if (this.document.document_type_id === "01") {
          var customers_alll = _.filter(this.all_customers, {
            identity_document_type_id: "6",
            seller_id: this.document.user_id
          });

          this.customers = customers_alll;
        } else {
          if (this.document_type_03_filter) {
            this.customers = _.filter(this.all_customers, function (c) {
              return c.identity_document_type_id !== "6";
            });
          } else {
            this.customers = this.all_customers;
          }
        }
      } else {
        this.customers = this.all_customers;
      }
    },
    initDocument: function initDocument() {
      this.document = {
        afectar_caja: false,
        user_id: null,
        payment_condition_id: "01",
        document_type_id: null,
        total_rounded: 0,
        total_payment: 0,
        all_customers: [],
        series_id: null,
        establishment_id: null,
        number: "#",
        date_of_issue: null,
        time_of_issue: null,
        customer_id: null,
        currency_type_id: null,
        purchase_order: null,
        exchange_rate_sale: 0,
        total_prepayment: 0,
        total_charge: 0,
        total_discount: 0,
        total_exportation: 0,
        total_free: 0,
        total_taxed: 0,
        total_unaffected: 0,
        total_exonerated: 0,
        total_igv: 0,
        total_base_isc: 0,
        total_isc: 0,
        total_base_other_taxes: 0,
        total_other_taxes: 0,
        total_taxes: 0,
        total_value: 0,
        total: 0,
        operation_type_id: "1001",
        prepayment_deduction: false,
        date_of_due: null,
        items: [],
        charges: [],
        discounts: [],
        attributes: [],
        guides: [],
        additional_information: null,
        actions: {
          format_pdf: "a4"
        },
        quotation_id: null,
        sale_note_id: null,
        payments: [],
        hotel: {},
        orden_id: null,
        seller_id: null
      };
    },
    resetDocument: function resetDocument() {
      this.generate = this.showGenerate ? true : false;
      this.initDocument();
      this.document.document_type_id = this.document_types.length > 0 ? this.document_types[0].id : null;
      this.changeDocumentType();
    },
    submit: function submit() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var filtrar, findCustomer;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                filtrar = _this4;
                findCustomer = _.find(_this4.all_customers, {
                  id: _this4.document.customer_id
                });

                if (!(findCustomer.number.length < 11 && _this4.document.document_type_id == "01")) {
                  _context2.next = 4;
                  break;
                }

                return _context2.abrupt("return", _this4.$toast.error("Ingrese un numero de Ruc de 11 digitos valido para emitir Factura "));

              case 4:
                if (!(findCustomer.number.length < 8 && _this4.document.document_type_id == "03")) {
                  _context2.next = 6;
                  break;
                }

                return _context2.abrupt("return", _this4.$toast.error("Ingrese un numero de DNI de 8 digitos valido para emitir Boleta "));

              case 6:
                if (!_this4.generate_dispatch) {
                  _context2.next = 9;
                  break;
                }

                if (_this4.dispatch_id) {
                  _context2.next = 9;
                  break;
                }

                return _context2.abrupt("return", _this4.$toast.error("Debe seleccionar una guía base"));

              case 9:
                _this4.loading_submit = true;
                _this4.document.exchange_rate_sale = 1;
                _context2.next = 13;
                return _this4.$http.post("/".concat(_this4.resource_documents), _this4.document).then(function (response) {
                  if (response.data.success) {
                    _this4.documentNewId = response.data.data.id;

                    if (_this4.fromCaja) {
                      _this4.$http.get("/".concat(_this4.resource, "/changed/").concat(_this4.recordId)).then(function () {
                        _this4.$emit("getRecords");
                      });

                      _this4.showDialogDocumentOptions = true;

                      _this4.clickClose();
                    } else {
                      _this4.$http.get("/".concat(_this4.resource, "/changed/").concat(_this4.form.id)).then(function () {
                        _this4.$eventHub.$emit("reloadData");

                        _this4.flag_generate = false;
                      });

                      _this4.resetDocument();

                      _this4.showDialogDocumentOptions = true;
                    } // this.clickClose();

                  } else {
                    _this4.$toast.error(response.data.message);
                  }
                })["catch"](function (error) {
                  if (error.response.status === 422) {
                    _this4.errors = error.response.data;
                  } else {
                    _this4.$toast.error(error.response.data.message);
                  }
                }).then(function () {
                  _this4.loading_submit = false;
                });

              case 13:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    setDataDetraction: function setDataDetraction() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        var legend;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!(_this5.document.operation_type_id === "1001")) {
                  _context3.next = 9;
                  break;
                }

                _this5.showDialogDocumentDetraction = true;
                _context3.next = 4;
                return _.find(_this5.form.legends, {
                  code: "2006"
                });

              case 4:
                legend = _context3.sent;
                if (!legend) _this5.form.legends.push({
                  code: "2006",
                  value: "Operación sujeta a detracción"
                });
                _this5.form.detraction.bank_account = _this5.company.detraction_account;
                _context3.next = 11;
                break;

              case 9:
                _.remove(_this5.form.legends, {
                  code: "2006"
                });

                _this5.document.detraction = {};

              case 11:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    assignDocument: function assignDocument() {
      var q = this.form.sale_note;

      if (q.paid == 1 || q.paid == "1") {
        this.document.payment_condition_id = "01";
      } else {
        this.document.payment_condition_id = "02";
      }

      for (var index = 0; index < q.items.length; index++) {
        q.items[index].item.is_stock = "No";
      }

      this.total_plastic_bag_taxes = 0;
      this.document.user_id = q.user_id;
      this.document.afectar_caja = false, this.document.establishment_id = q.establishment_id;
      this.document.date_of_issue = moment().format("YYYY-MM-DD"); //q.date_of_issue

      this.document.date_of_due = moment().format("YYYY-MM-DD"); //q.date_of_issue

      this.document.time_of_issue = q.time_of_issue;
      this.document.customer_id = q.customer_id;
      this.document.currency_type_id = q.currency_type_id;
      this.document.purchase_order = null;
      this.document.exchange_rate_sale = q.exchange_rate_sale;
      this.document.total_prepayment = q.total_prepayment;
      this.document.total_charge = q.total_charge;
      this.document.total_discount = q.total_discount;
      this.document.total_exportation = q.total_exportation;
      this.document.total_free = q.total_free;
      this.document.total_taxed = q.total_taxed;
      this.document.total_unaffected = q.total_unaffected;
      this.document.total_exonerated = q.total_exonerated;
      this.document.total_igv = q.total_igv;
      this.document.total_base_isc = q.total_base_isc;
      this.document.total_isc = q.total_isc;
      this.document.total_base_other_taxes = q.total_base_other_taxes;
      this.document.total_other_taxes = q.total_other_taxes;
      this.document.total_taxes = q.total_taxes;
      this.document.total_value = q.total_value;
      this.document.total = q.total;
      this.document.operation_type_id = "0101";
      this.document.items = q.items;
      this.document.charges = q.charges;
      this.document.discounts = q.discounts;
      this.document.attributes = [];
      this.document.seller_id = q.seller_id;
      this.document.guides = q.guides;
      this.document.additional_information = null;
      this.document.actions = {
        format_pdf: "a4"
      };
      this.document.sale_note_id = this.form.id;
      this.document.payments = q.payments;
    },
    calculateTotal: function calculateTotal() {
      var total_discount = 0;
      var total_charge = 0;
      var total_exportation = 0;
      var total_taxed = 0;
      var total_exonerated = 0;
      var total_unaffected = 0;
      var total_free = 0;
      var total_igv = 0;
      var total_value = 0;
      var total = 0;
      var total_plastic_bag_taxes = 0;
      this.document.items.forEach(function (row) {
        total_discount += parseFloat(row.total_discount);
        total_charge += parseFloat(row.total_charge);

        if (row.affectation_igv_type_id === "10") {
          total_taxed += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "20") {
          total_exonerated += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "30") {
          total_unaffected += parseFloat(row.total_value);
        }

        if (row.affectation_igv_type_id === "40") {
          total_exportation += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) < 0) {
          total_free += parseFloat(row.total_value);
        }

        if (["10", "20", "30", "40"].indexOf(row.affectation_igv_type_id) > -1) {
          total_igv += parseFloat(row.total_igv);
          total += parseFloat(row.total);
        }

        total_value += parseFloat(row.total_value);
        total_plastic_bag_taxes += parseFloat(row.total_plastic_bag_taxes);
      });
      this.document.total_exportation = _.round(total_exportation, 2);
      this.document.total_taxed = _.round(total_taxed, 2);
      this.document.total_exonerated = _.round(total_exonerated, 2);
      this.document.total_unaffected = _.round(total_unaffected, 2);
      this.document.total_free = _.round(total_free, 2);
      this.document.total_igv = _.round(total_igv, 2);
      this.document.total_value = _.round(total_value, 2);
      this.document.total_taxes = _.round(total_igv, 2);
      this.document.total_plastic_bag_taxes = isNaN(parseFloat(total_plastic_bag_taxes)) ? 0 : total_plastic_bag_taxes;
      this.document.total = _.round(total + this.document.total_plastic_bag_taxes, 2); // if (this.enabled_discount_global)
      //     this.discountGlobal()
      // if (this.prepayment_deduction)
      //     this.discountGlobalPrepayment()
      // if (this.form.operation_type_id === '1001')
      //     this.changeDetractionType()
      // this.setTotalDefaultPayment()

      this.document.total_rounded = 0;
      this.document.total_payment = 0;
    },
    create: function create() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this6.loading_documents = true;
                _context4.next = 3;
                return _this6.$http.get("/".concat(_this6.resource, "/option/tables")).then(function (response) {
                  _this6.all_document_types = response.data.document_types_invoice;
                  _this6.all_series = response.data.series;
                  _this6.all_customers = response.data.customers;
                  _this6.operation_types = response.data.operation_types;
                  _this6.document_type_03_filter = response.data.document_type_03_filter; //this.document.operation_type_id = (this.operation_types.length > 0) ? this.operation_types[0].id : null;
                  // this.document.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null;
                  // this.changeDocumentType();
                });

              case 3:
                _context4.next = 5;
                return _this6.$http.get("/".concat(_this6.resource, "/record/").concat(_this6.recordId)).then(function (response) {
                  _this6.form = response.data.data;

                  _this6.validateIdentityDocumentType();

                  _this6.assignDocument();

                  _this6.titleDialog = "Nota de venta registrada: " + _this6.form.identifier;

                  _this6.searchRemoteCustomers(response.data.data.sale_note.customer.name);

                  _this6.document.customer_id = response.data.data.sale_note.customer_id;
                  _this6.document.user_id = response.data.data.sale_note.user_id;
                });

              case 5:
                // await this.$http
                //     .get(`/${this.resource}/dispatches`)
                //     .then(response => {
                //         this.dispatches = response.data;
                //     });
                _this6.loading_documents = false;

              case 6:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    changeDocumentType: function changeDocumentType() {
      this.filterSeries();
    },
    validateIdentityDocumentType: function validateIdentityDocumentType() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee5() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // let identity_document_types = ['0','1']
                // if(identity_document_types.includes(this.form.sale_note.customer.identity_document_type_id)){
                //     this.document_types = _.filter(this.all_document_types,{'id':'03'})
                // }else{
                _this7.document_types = _this7.all_document_types; // }

                _this7.document.document_type_id = _this7.document_types.length > 0 ? _this7.document_types[0].id : null;
                _context5.next = 4;
                return _this7.changeDocumentType();

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    filterSeries: function filterSeries() {
      this.document.series_id = null;
      this.series = _.filter(this.all_series, {
        document_type_id: this.document.document_type_id
      });
      this.document.series_id = this.series.length > 0 ? this.series[0].id : null;
    },
    clickFinalize: function clickFinalize() {
      location.href = "/".concat(this.resource);
    },
    clickNewQuotation: function clickNewQuotation() {
      this.clickClose();
    },
    clickClose: function clickClose() {
      this.$emit("update:showDialog", false);
      this.initForm();
      this.resetDocument();
      this.flag_generate = true;
    },
    clickToPrint: function clickToPrint() {
      window.open("/downloads/saleNote/sale_note/".concat(this.form.external_id), "_blank");
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-29290804\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sale_notes/partials/option_documents.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "el-dialog",
        {
          attrs: {
            title: _vm.titleDialog,
            visible: _vm.showDialog,
            width: "50%",
            "close-on-click-modal": false,
            "close-on-press-escape": false,
            "show-close": false,
            "append-to-body": ""
          },
          on: { open: _vm.create, close: _vm.clickClose }
        },
        [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading_documents,
                  expression: "loading_documents"
                }
              ],
              staticClass: "row"
            },
            [
              _c("div", { staticClass: "col-lg-8" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.document_type_id }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Tipo comprobante")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        staticClass: "border-left rounded-left border-info",
                        attrs: {
                          "popper-class": "el-select-document_type",
                          dusk: "document_type_id"
                        },
                        on: { change: _vm.changeDocumentType },
                        model: {
                          value: _vm.document.document_type_id,
                          callback: function($$v) {
                            _vm.$set(_vm.document, "document_type_id", $$v)
                          },
                          expression: "document.document_type_id"
                        }
                      },
                      _vm._l(_vm.document_types, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.description }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.document_type_id
                      ? _c("small", {
                          staticClass: "text-danger",
                          domProps: {
                            textContent: _vm._s(_vm.errors.document_type_id[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-4" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.series_id }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Serie")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        model: {
                          value: _vm.document.series_id,
                          callback: function($$v) {
                            _vm.$set(_vm.document, "series_id", $$v)
                          },
                          expression: "document.series_id"
                        }
                      },
                      _vm._l(_vm.series, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.number }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.series_id
                      ? _c("small", {
                          staticClass: "text-danger",
                          domProps: {
                            textContent: _vm._s(_vm.errors.series_id[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-8" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.document_type_id }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Cliente\n                        "),
                      _c(
                        "a",
                        {
                          staticClass: "text-primary",
                          attrs: { href: "#" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              _vm.showDialogNewPerson = true
                            }
                          }
                        },
                        [_vm._v("[+ Nuevo]")]
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        ref: "cliente",
                        staticClass: "border-left rounded-left border-info",
                        attrs: {
                          filterable: "",
                          remote: "",
                          "popper-class": "el-select-customers",
                          dusk: "customer_id",
                          placeholder:
                            "Escriba el nombre o número de documento del cliente",
                          "remote-method": _vm.searchRemoteCustomers,
                          loading: _vm.loading_search
                        },
                        nativeOn: {
                          keyup: function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return _vm.keyupCustomer.apply(null, arguments)
                          }
                        },
                        model: {
                          value: _vm.document.customer_id,
                          callback: function($$v) {
                            _vm.$set(_vm.document, "customer_id", $$v)
                          },
                          expression: "document.customer_id"
                        }
                      },
                      _vm._l(_vm.customers, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.name }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.document_type_id
                      ? _c("small", {
                          staticClass: "text-danger",
                          domProps: {
                            textContent: _vm._s(_vm.errors.document_type_id[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-4" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.operation_type_id }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Tipo Operación ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        on: { change: _vm.changeOperationType },
                        model: {
                          value: _vm.document.operation_type_id,
                          callback: function($$v) {
                            _vm.$set(_vm.document, "operation_type_id", $$v)
                          },
                          expression: "document.operation_type_id"
                        }
                      },
                      _vm._l(_vm.operation_types, function(option) {
                        return _c("el-option", {
                          key: option.id,
                          attrs: { value: option.id, label: option.description }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _vm.errors.operation_type_id
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.operation_type_id[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _vm.document.items.length > 0
                ? _c("div", { staticClass: "col-lg-12" }, [
                    _c("div", { staticClass: "row mt-2" }, [
                      _c("div", { staticClass: "col-md-12" }, [
                        _c("h6", [_vm._v("Detalle")]),
                        _vm._v(" "),
                        _c("div", { staticClass: "table-responsive" }, [
                          _c(
                            "table",
                            { staticClass: "table", attrs: { width: "100%" } },
                            [
                              _c("thead", [
                                _c("tr", [
                                  _c("th", [_vm._v("#")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("Cantidad")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("producto")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("Precio")]),
                                  _vm._v(" "),
                                  _c("th", [_vm._v("Importe")])
                                ])
                              ]),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                _vm._l(_vm.document.items, function(
                                  row,
                                  index
                                ) {
                                  return _c("tr", { key: index }, [
                                    _c("td", [
                                      _c(
                                        "button",
                                        {
                                          staticClass: "btn btn-sm btn-danger",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.clickRemoveItem(index)
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-trash"
                                          })
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(row.quantity))]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(
                                        "\n                                            " +
                                          _vm._s(row.item.description) +
                                          "\n                                            "
                                      ),
                                      _c("br"),
                                      _c("small", [
                                        _vm._v(
                                          _vm._s(
                                            row.affectation_igv_type.description
                                          )
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-center" }, [
                                      _vm._v(
                                        "\n                                            " +
                                          _vm._s(row.item.sale_unit_price) +
                                          "\n                                        "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-end" }, [
                                      _vm._v(
                                        "\n                                            " +
                                          _vm._s(
                                            (
                                              row.quantity *
                                              row.item.sale_unit_price
                                            ).toFixed(2)
                                          ) +
                                          "\n                                        "
                                      )
                                    ])
                                  ])
                                }),
                                0
                              ),
                              _vm._v(" "),
                              _c("tr")
                            ]
                          )
                        ])
                      ])
                    ])
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-12" }, [
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Observaciones")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        attrs: { type: "textarea", autosize: "" },
                        model: {
                          value: _vm.document.additional_information,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.document,
                              "additional_information",
                              $$v
                            )
                          },
                          expression: "document.additional_information"
                        }
                      },
                      [
                        _c("i", {
                          staticClass: "el-icon-edit-outline",
                          attrs: { slot: "prefix" },
                          slot: "prefix"
                        })
                      ]
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-8 mt-3" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.dipatch_id }
                  },
                  [
                    _c(
                      "el-checkbox",
                      {
                        model: {
                          value: _vm.generate_dispatch,
                          callback: function($$v) {
                            _vm.generate_dispatch = $$v
                          },
                          expression: "generate_dispatch"
                        }
                      },
                      [_vm._v("Generar Guía Remisión")]
                    ),
                    _vm._v(" "),
                    _vm.generate_dispatch
                      ? _c(
                          "el-select",
                          {
                            staticClass: "border-left rounded-left border-info",
                            attrs: {
                              "popper-class": "el-select-document_type",
                              filterable: ""
                            },
                            model: {
                              value: _vm.dispatch_id,
                              callback: function($$v) {
                                _vm.dispatch_id = $$v
                              },
                              expression: "dispatch_id"
                            }
                          },
                          _vm._l(_vm.dispatches, function(option) {
                            return _c("el-option", {
                              key: option.id,
                              attrs: {
                                value: option.id,
                                label: option.number_full
                              }
                            })
                          }),
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.errors.dipatch_id
                      ? _c("small", {
                          staticClass: "text-danger",
                          domProps: {
                            textContent: _vm._s(_vm.errors.dipatch_id[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c("el-button", { on: { click: _vm.clickClose } }, [
                _vm._v("Cerrar")
              ]),
              _vm._v(" "),
              _vm.flag_generate
                ? _c(
                    "el-button",
                    {
                      staticClass: "submit",
                      attrs: { type: "primary", loading: _vm.loading_submit },
                      on: { click: _vm.submit }
                    },
                    [_vm._v("Generar")]
                  )
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c("document-options", {
            attrs: {
              showDialog: _vm.showDialogDocumentOptions,
              recordId: _vm.documentNewId,
              generatDispatch: _vm.generate_dispatch,
              dispatchId: _vm.dispatch_id,
              isContingency: false,
              showClose: true,
              configuration: _vm.configuration
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogDocumentOptions = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogDocumentOptions = $event
              }
            }
          }),
          _vm._v(" "),
          _c("person-form", {
            attrs: {
              showDialog: _vm.showDialogNewPerson,
              type: "customers",
              external: true,
              user_id: _vm.document.user_id,
              input_person: _vm.input_person,
              document_type_id: _vm.document.document_type_id
            },
            on: {
              "update:showDialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              "update:show-dialog": function($event) {
                _vm.showDialogNewPerson = $event
              },
              add: _vm.addRowCliente
            }
          })
        ],
        1
      )
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
    require("vue-hot-reload-api")      .rerender("data-v-29290804", module.exports)
  }
}

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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7cc91674\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "append-to-body": "",
        "close-on-click-modal": false
      },
      on: { close: _vm.close, open: _vm.create, opened: _vm.opened }
    },
    [
      _c(
        "form",
        {
          attrs: { autocomplete: "off" },
          on: {
            submit: function($event) {
              $event.preventDefault()
              return _vm.submit.apply(null, arguments)
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "form-body" },
            [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: {
                        "has-danger": _vm.errors.identity_document_type_id
                      }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v(
                          "Tipo Doc. Identidad\n                            "
                        ),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-identity_document_type",
                            dusk: "identity_document_type_id"
                          },
                          on: { change: _vm.changeIdentityDocType },
                          model: {
                            value: _vm.form.identity_document_type_id,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.form,
                                "identity_document_type_id",
                                $$v
                              )
                            },
                            expression: "form.identity_document_type_id"
                          }
                        },
                        _vm._l(_vm.identity_document_types, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.identity_document_type_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(
                                _vm.errors.identity_document_type_id[0]
                              )
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.number }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Número\n                            "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _vm.api_service_token != false
                        ? _c(
                            "div",
                            [
                              _c("x-input-service", {
                                attrs: {
                                  identity_document_type_id:
                                    _vm.form.identity_document_type_id
                                },
                                on: { search: _vm.searchNumber },
                                model: {
                                  value: _vm.form.number,
                                  callback: function($$v) {
                                    _vm.$set(_vm.form, "number", $$v)
                                  },
                                  expression: "form.number"
                                }
                              })
                            ],
                            1
                          )
                        : _c(
                            "div",
                            [
                              _c(
                                "el-input",
                                {
                                  attrs: {
                                    maxlength: _vm.maxLength,
                                    dusk: "number"
                                  },
                                  model: {
                                    value: _vm.form.number,
                                    callback: function($$v) {
                                      _vm.$set(_vm.form, "number", $$v)
                                    },
                                    expression: "form.number"
                                  }
                                },
                                [
                                  _vm.form.identity_document_type_id === "6" ||
                                  _vm.form.identity_document_type_id === "1"
                                    ? [
                                        _c("el-button", {
                                          attrs: {
                                            slot: "append",
                                            type: "primary",
                                            loading: _vm.loading_search,
                                            icon: "el-icon-search"
                                          },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.searchCustomer.apply(
                                                null,
                                                arguments
                                              )
                                            }
                                          },
                                          slot: "append"
                                        })
                                      ]
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c("i", {
                                    staticClass: "el-icon-edit-outline",
                                    attrs: { slot: "prefix" },
                                    slot: "prefix"
                                  })
                                ],
                                2
                              )
                            ],
                            1
                          ),
                      _vm._v(" "),
                      _vm.errors.number
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.number[0])
                            }
                          })
                        : _vm._e()
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.name }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Nombre\n                            "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "name" },
                          model: {
                            value: _vm.form.name,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "name", $$v)
                            },
                            expression: "form.name"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.name
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.name[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.trade_name }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Nombre comercial")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "trade_name" },
                          model: {
                            value: _vm.form.trade_name,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "trade_name", $$v)
                            },
                            expression: "form.trade_name"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.trade_name
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.trade_name[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.country_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("País")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { filterable: "", dusk: "country_id" },
                          model: {
                            value: _vm.form.country_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "country_id", $$v)
                            },
                            expression: "form.country_id"
                          }
                        },
                        _vm._l(_vm.countries, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.country_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.country_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.department_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Departamento")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-departments",
                            dusk: "department_id"
                          },
                          on: { change: _vm.filterProvince },
                          model: {
                            value: _vm.form.department_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "department_id", $$v)
                            },
                            expression: "form.department_id"
                          }
                        },
                        _vm._l(_vm.all_departments, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.department_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.department_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.province_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Provincia")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-provinces",
                            dusk: "province_id"
                          },
                          on: { change: _vm.filterDistrict },
                          model: {
                            value: _vm.form.province_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "province_id", $$v)
                            },
                            expression: "form.province_id"
                          }
                        },
                        _vm._l(_vm.provinces, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.province_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.province_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.province_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Distrito")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            "popper-class": "el-select-districts",
                            dusk: "district_id"
                          },
                          model: {
                            value: _vm.form.district_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "district_id", $$v)
                            },
                            expression: "form.district_id"
                          }
                        },
                        _vm._l(_vm.districts, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.district_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.district_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.address }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Dirección")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "address" },
                          model: {
                            value: _vm.form.address,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "address", $$v)
                            },
                            expression: "form.address"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.address
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.address[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.client_zone_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Zona")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { filterable: "", dusk: "client_zone_id" },
                          model: {
                            value: _vm.form.client_zone_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "client_zone_id", $$v)
                            },
                            expression: "form.client_zone_id"
                          }
                        },
                        _vm._l(_vm.zones, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.client_zone_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.client_zone_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.telephone }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Teléfono")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "telephone" },
                          model: {
                            value: _vm.form.telephone,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "telephone", $$v)
                            },
                            expression: "form.telephone"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.telephone
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.telephone[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.email }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Correo electrónico")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-input",
                        {
                          attrs: { dusk: "email" },
                          model: {
                            value: _vm.form.email,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "email", $$v)
                            },
                            expression: "form.email"
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "el-icon-edit-outline",
                            attrs: { slot: "prefix" },
                            slot: "prefix"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _vm.errors.email
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.email[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _vm.form.state
                  ? _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "div",
                        { staticClass: "form-group" },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Estado del Contribuyente")
                          ]),
                          _vm._v(" "),
                          _vm.form.state == "ACTIVO"
                            ? [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.state,
                                    type: "success",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                            : [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.state,
                                    type: "error",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                        ],
                        2
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.form.condition
                  ? _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "div",
                        { staticClass: "form-group" },
                        [
                          _c("label", { staticClass: "control-label" }, [
                            _vm._v("Condición del Contribuyente")
                          ]),
                          _vm._v(" "),
                          _vm.form.condition == "HABIDO"
                            ? [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.condition,
                                    type: "success",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                            : [
                                _c("el-alert", {
                                  attrs: {
                                    title: "" + _vm.form.condition,
                                    type: "error",
                                    "show-icon": "",
                                    closable: false
                                  }
                                })
                              ]
                        ],
                        2
                      )
                    ])
                  : _vm._e()
              ]),
              _vm._v(" "),
              _vm.type === "suppliers"
                ? _c("div", { staticClass: "row mt-2" }, [
                    _c("div", { staticClass: "col-md-6 center-el-checkbox" }, [
                      _c(
                        "div",
                        {
                          staticClass: "form-group",
                          class: { "has-danger": _vm.errors.perception_agent }
                        },
                        [
                          _c(
                            "el-checkbox",
                            {
                              model: {
                                value: _vm.form.perception_agent,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "perception_agent", $$v)
                                },
                                expression: "form.perception_agent"
                              }
                            },
                            [_vm._v("¿Es agente de percepción?")]
                          ),
                          _c("br"),
                          _vm._v(" "),
                          _vm.errors.perception_agent
                            ? _c("small", {
                                staticClass: "text-danger",
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.errors.perception_agent[0]
                                  )
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _vm.type === "suppliers"
                      ? _c(
                          "div",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.form.perception_agent,
                                expression: "form.perception_agent"
                              }
                            ],
                            staticClass: "col-md-6"
                          },
                          [
                            _c(
                              "div",
                              { staticClass: "form-group" },
                              [
                                _c("label", { staticClass: "control-label" }, [
                                  _vm._v("Porcentaje de percepción")
                                ]),
                                _vm._v(" "),
                                _c(
                                  "el-input",
                                  {
                                    model: {
                                      value: _vm.form.percentage_perception,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.form,
                                          "percentage_perception",
                                          $$v
                                        )
                                      },
                                      expression: "form.percentage_perception"
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "el-icon-edit-outline",
                                      attrs: { slot: "prefix" },
                                      slot: "prefix"
                                    })
                                  ]
                                )
                              ],
                              1
                            )
                          ]
                        )
                      : _vm._e()
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm._l(_vm.form.addresses, function(row, index) {
                return _c("div", { key: index, staticClass: "row m-t-10" }, [
                  _c("div", { staticClass: "col-md-12" }, [
                    index === 0
                      ? _c("label", { staticClass: "control-label" }, [
                          _vm._v(
                            "\n                        Dirección principal\n                    "
                          )
                        ])
                      : _c(
                          "label",
                          { staticClass: "control-label" },
                          [
                            _vm._v(
                              "\n                        Dirección secundaria # " +
                                _vm._s(index) +
                                "\n                        "
                            ),
                            _c(
                              "el-button",
                              {
                                staticClass: "btn-default-danger",
                                attrs: { size: "mini", icon: "el-icon-minus" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.clickRemoveAddress(index)
                                  }
                                }
                              },
                              [_vm._v("Eliminar dirección")]
                            )
                          ],
                          1
                        )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-4" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.country_id }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("País")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            attrs: { filterable: "" },
                            model: {
                              value: row.country_id,
                              callback: function($$v) {
                                _vm.$set(row, "country_id", $$v)
                              },
                              expression: "row.country_id"
                            }
                          },
                          _vm._l(_vm.countries, function(option) {
                            return _c("el-option", {
                              key: option.id,
                              attrs: {
                                value: option.id,
                                label: option.description
                              }
                            })
                          }),
                          1
                        ),
                        _vm._v(" "),
                        _vm.errors.country_id
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.country_id[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.location_id }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Ubigeo")
                        ]),
                        _vm._v(" "),
                        _c("el-cascader", {
                          attrs: {
                            options: _vm.locations,
                            clearable: true,
                            filterable: ""
                          },
                          model: {
                            value: row.location_id,
                            callback: function($$v) {
                              _vm.$set(row, "location_id", $$v)
                            },
                            expression: "row.location_id"
                          }
                        }),
                        _vm._v(" "),
                        _vm.errors.location_id
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.location_id[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-12" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.address }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Dirección")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-input",
                          {
                            model: {
                              value: row.address,
                              callback: function($$v) {
                                _vm.$set(row, "address", $$v)
                              },
                              expression: "row.address"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "el-icon-edit-outline",
                              attrs: { slot: "prefix" },
                              slot: "prefix"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm.errors.address
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.address[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-6" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.phone }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Teléfono")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-input",
                          {
                            model: {
                              value: row.phone,
                              callback: function($$v) {
                                _vm.$set(row, "phone", $$v)
                              },
                              expression: "row.phone"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "el-icon-edit-outline",
                              attrs: { slot: "prefix" },
                              slot: "prefix"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm.errors.phone
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.phone[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-6" }, [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.email }
                      },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Correo electrónico")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-input",
                          {
                            model: {
                              value: row.email,
                              callback: function($$v) {
                                _vm.$set(row, "email", $$v)
                              },
                              expression: "row.email"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "el-icon-edit-outline",
                              attrs: { slot: "prefix" },
                              slot: "prefix"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _vm.errors.email
                          ? _c("small", {
                              staticClass: "text-danger",
                              domProps: {
                                textContent: _vm._s(_vm.errors.email[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ])
                ])
              })
            ],
            2
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-actions text-end pt-2 pb-2" },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.close()
                    }
                  }
                },
                [_vm._v("Cancelar")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: {
                    type: "primary",
                    "native-type": "submit",
                    loading: _vm.loading_submit
                  }
                },
                [_vm._v("Guardar")]
              )
            ],
            1
          )
        ]
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
    require("vue-hot-reload-api")      .rerender("data-v-7cc91674", module.exports)
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


/***/ }),

/***/ "./resources/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7cc91674\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue")
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
Component.options.__file = "resources/js/views/persons/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7cc91674", Component.options)
  } else {
    hotAPI.reload("data-v-7cc91674", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/sale_notes/partials/option_documents.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sale_notes/partials/option_documents.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-29290804\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sale_notes/partials/option_documents.vue")
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
Component.options.__file = "resources/js/views/sale_notes/partials/option_documents.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-29290804", Component.options)
  } else {
    hotAPI.reload("data-v-29290804", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=146.js.map