webpackJsonp([166],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sale_notes/partials/options.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "configuration", "recordId", "showClose", "editSale", "showSchedule", "company"],
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
      all_series: [],
      series: [],
      loading_submit: false,
      showDialogOptions: false,
      documentNewId: null,
      activeName: "first",
      sender: null
    };
  },
  created: function created() {
    var _this = this;

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
    });
    this.initForm();
    this.socketWhatsappConfig();
  },
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

        _this2.showMessage(message);
      });
      this.socket.on("connected", function (_ref2) {
        var message = _ref2.message;

        // this.$message.success(message);
        _this2.socket.emit("getStatus", url);
      });
      this.socket.on("setStatus", function (_ref3) {// if (!status) {
        //     this.sender = "sdrimsac";
        //     this.$message.warning("Sesión iniciada con SDRIMSAC");
        // } else {
        //     this.sender = sender;
        //     this.$message.success("Whatsapp Listo!");
        // }

        var status = _ref3.status,
            sender = _ref3.sender;
      }); //MessageResponse
    },
    clickSendWhatsapp: function clickSendWhatsapp() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var formWhatsapp, response;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!(_this3.form.customer_telephone != null)) {
                  _context.next = 16;
                  break;
                }

                formWhatsapp = {
                  id: _this3.form.id,
                  sender: _this3.sender,
                  document_id: _this3.form.id,
                  document_type_id: "80",
                  customer_telephone: _this3.form.customer_telephone,
                  mensaje: "Su comprobante de pago electrónico " + _this3.form.identifier + " por S/" + _this3.form.total + " de *" + _this3.form.establishment_description + "*, ha sido generado correctamente a través del facturador electrónico de " + "*" + _this3.$desarrollador + "*"
                };
                _context.prev = 2;
                _this3.loading = true;
                _context.next = 6;
                return _this3.$http.post("/whatsapp", formWhatsapp);

              case 6:
                response = _context.sent;

                if (response.status == 200) {
                  _this3.$toast.success("Mensaje enviado");

                  _this3.loading = false;
                }

                _context.next = 13;
                break;

              case 10:
                _context.prev = 10;
                _context.t0 = _context["catch"](2);
                console.log(_context.t0, " error");

              case 13:
                _context.prev = 13;
                _this3.loading = false;
                return _context.finish(13);

              case 16:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[2, 10, 13, 16]]);
      }))();
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        id: null,
        external_id: null,
        identifier: null,
        date_of_issue: null,
        print_ticket: null,
        schedule: null,
        print_a4: null,
        print_a5: null,
        series: null,
        number: null,
        view_schedule: null
      };
    },
    clickPrintPos: function clickPrintPos(printerName, formatoPdf) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.$confirm("Elija una de las opciones", "Imprimir", {
                  confirmButtonText: "Impresión directa",
                  cancelButtonText: "Descargar PDF",
                  type: "warning"
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
                  var paperConfig, partsUrl, document, isTicket, isA4, isA5, tipoBandejaImpresora, orientation, a5_orientation, margins, config, data;
                  return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                    while (1) {
                      switch (_context2.prev = _context2.next) {
                        case 0:
                          _context2.prev = 0;
                          _this4.message = "Espere imprimiendo el Comprobante " + _this4.form.number;
                          _this4.loading_print = true;
                          paperConfig = {
                            scaleContent: false
                          };
                          partsUrl = formatoPdf.split("/");
                          document = partsUrl[partsUrl.length - 1];
                          isTicket = document.toLowerCase().includes("ticket");
                          isA4 = document.toLowerCase().includes("a4");
                          isA5 = document.toLowerCase().includes("a5");
                          tipoBandejaImpresora = _this4.configuration.new_old_printer;

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
                              a5_orientation = _this4.configuration.a5_orientation;
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

                          _this4.message = "Espere imprimiendo el Comprobante " + _this4.form.number;
                          _this4.loading_print = true;
                          config = qz.configs.create(printerName, paperConfig, {
                            jobName: _this4.form.number
                          }); // let config = qz.configs.create(
                          //     printerName,
                          //     { scaleContent: false },
                          //     { jobName: this.form.number }
                          // );

                          if (qz.websocket.isActive()) {
                            _context2.next = 17;
                            break;
                          }

                          _context2.next = 17;
                          return qz.websocket.connect(config);

                        case 17:
                          data = [{
                            type: "pdf",
                            format: "file",
                            data: formatoPdf
                          }];
                          qz.print(config, data)["catch"](function (e) {
                            _this4.$toast.error(e.message);
                          });
                          _this4.loading_print = false;

                          _this4.clickClose();

                          _context2.next = 26;
                          break;

                        case 23:
                          _context2.prev = 23;
                          _context2.t0 = _context2["catch"](0);

                          _this4.$toast.error(_context2.t0.message);

                        case 26:
                        case "end":
                          return _context2.stop();
                      }
                    }
                  }, _callee2, null, [[0, 23]]);
                })))["catch"](function () {
                  window.open(formatoPdf, "_blank");

                  _this4.clickClose();
                });

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    clickPrint: function clickPrint(format) {
      if (this.configuration.print_direct == 1) {
        if (format == "a4") {
          this.clickPrintPos(this.form.printer, this.form.print_a4);
        }

        if (format == "a5") {
          this.clickPrintPos(this.form.printer, this.form.print_a5);
        }

        if (format == "ticket") {
          this.clickPrintPos(this.form.printer, this.form.print_ticket);
        }

        if (format == "ticket_50") {
          this.clickPrintPos(this.form.printer, this.form.ticket_50);
        }

        if (format == "cronograma") {
          this.clickPrintPos(this.form.printer, this.form.schedule);
        }
      }
    },
    create: function create() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee4() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                qz.security.setCertificatePromise(function (resolve, reject) {
                  _this5.$http.get("/api/qz/crt/override", {
                    responseType: "text"
                  }).then(function (response) {
                    resolve(response.data);
                  })["catch"](function (error) {
                    reject(error.data);
                  });
                });
                qz.security.setSignaturePromise(function (toSign) {
                  return function (resolve, reject) {
                    _this5.$http.post("/api/qz/signing", {
                      request: toSign
                    }).then(function (response) {
                      resolve(response.data);
                    })["catch"](function (error) {
                      reject(error.data);
                    });
                  };
                });
                _context4.next = 4;
                return _this5.$http.get("/".concat(_this5.resource, "/record/").concat(_this5.recordId)).then(function (response) {
                  console.log(response);
                  _this5.form = response.data.data;
                  _this5.titleDialog = "Nota de venta registrada:  ".concat(_this5.form.serie, "-").concat(_this5.form.number);
                });

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clickFinalize: function clickFinalize() {
      location.href = "/".concat(this.resource);
    },
    clickNewSaleNote: function clickNewSaleNote() {
      this.clickClose();
    },
    clickClose: function clickClose() {
      this.$emit("update:showDialog", false);
      this.$emit("update:showSchedule", false);
      this.initForm();
    },
    clickDownload: function clickDownload() {
      window.open("/downloads/saleNote/sale_note/".concat(this.form.external_id), "_blank");
    },
    clickToPrint: function clickToPrint(format) {
      window.open("/".concat(this.resource, "/print/").concat(this.form.id, "/").concat(format), "_blank");
    },
    clickSendEmail: function clickSendEmail() {
      var _this6 = this;

      this.loading = true;
      this.$http.post("/".concat(this.resource, "/email"), {
        customer_email: this.form.customer_email,
        id: this.form.id
      }).then(function (response) {
        if (response.data.success) {
          _this6.$toast.success("El correo fue enviado satisfactoriamente");
        } else {
          _this6.$toast.error("Error al enviar el correo");
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this6.errors = error.response.data.errors;
        } else {
          _this6.$toast.error(error.response.data.message);
        }
      }).then(function () {
        _this6.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7d684f78\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sale_notes/partials/options.vue":
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
            "close-on-click-modal": false,
            "close-on-press-escape": false,
            "show-close": false
          },
          on: { open: _vm.create }
        },
        [
          _vm.configuration.print_direct == false
            ? [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-lg-12 col-md-12 col-sm-12  " },
                    [
                      _c(
                        "el-tabs",
                        {
                          model: {
                            value: _vm.activeName,
                            callback: function($$v) {
                              _vm.activeName = $$v
                            },
                            expression: "activeName"
                          }
                        },
                        [
                          _c(
                            "el-tab-pane",
                            { attrs: { label: "Imprimir A4", name: "first" } },
                            [
                              _c("embed", {
                                attrs: {
                                  src: _vm.form.print_a4,
                                  type: "application/pdf",
                                  width: "100%",
                                  height: "400px"
                                }
                              })
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-tab-pane",
                            { attrs: { label: "Imprimir A5", name: "second" } },
                            [
                              _c("embed", {
                                attrs: {
                                  src: _vm.form.print_a5,
                                  type: "application/pdf",
                                  width: "100%",
                                  height: "400px"
                                }
                              })
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-tab-pane",
                            {
                              attrs: { label: "Imprimir Ticket", name: "third" }
                            },
                            [
                              _c("embed", {
                                attrs: {
                                  src: _vm.form.print_ticket,
                                  type: "application/pdf",
                                  width: "100%",
                                  height: "400px"
                                }
                              })
                            ]
                          ),
                          _vm._v(" "),
                          _vm.showSchedule
                            ? _c(
                                "el-tab-pane",
                                {
                                  attrs: {
                                    label: "Imprimir Cronograma",
                                    name: "schedule"
                                  }
                                },
                                [
                                  _c("embed", {
                                    attrs: {
                                      src: _vm.form.schedule,
                                      type: "application/pdf",
                                      width: "100%",
                                      height: "400px"
                                    }
                                  })
                                ]
                              )
                            : _vm._e()
                        ],
                        1
                      )
                    ],
                    1
                  )
                ])
              ]
            : [
                _c("div", { staticClass: "row justify-content-center" }, [
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
                          staticClass:
                            "btn btn-lg btn-info waves-effect waves-light",
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
                          staticClass:
                            "btn btn-lg btn-info waves-effect waves-light",
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
                          staticClass:
                            "btn btn-lg btn-info waves-effect waves-light",
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
                      _c("p", [_vm._v("Imprimir Ticket")])
                    ]
                  ),
                  _vm._v(" "),
                  _vm.form.view_schedule
                    ? _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-3 col-md-3 col-sm-12 text-center font-weight-bold mt-3"
                        },
                        [
                          _c(
                            "button",
                            {
                              staticClass:
                                "btn btn-lg btn-info waves-effect waves-light",
                              attrs: { type: "button" },
                              on: {
                                click: function($event) {
                                  return _vm.clickPrint("cronograma")
                                }
                              }
                            },
                            [_c("i", { staticClass: "fa fa-receipt" })]
                          ),
                          _vm._v(" "),
                          _c("p", [_vm._v("Imprimir Cronograma")])
                        ]
                      )
                    : _vm._e()
                ])
              ],
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "dialog-footer row",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
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
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "col-md-12",
                  staticStyle: { "margin-top": "5px" }
                },
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
                      _c(
                        "el-button",
                        {
                          attrs: {
                            slot: "append",
                            icon: "fab fa-whatsapp",
                            loading: _vm.loading
                          },
                          on: { click: _vm.clickSendWhatsapp },
                          slot: "append"
                        },
                        [_vm._v("Enviar")]
                      ),
                      _vm._v(" "),
                      _c("i", {
                        staticClass: "fab fa-whatsapp",
                        attrs: { slot: "prefix" },
                        slot: "prefix"
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
                { staticClass: "col-md-12 m-t-10" },
                [
                  _vm.showClose == true
                    ? [
                        _vm.editSale == false
                          ? _c("el-button", { on: { click: _vm.clickClose } }, [
                              _vm._v("Cerrar")
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.editSale == true
                          ? _c(
                              "el-button",
                              { on: { click: _vm.clickFinalize } },
                              [_vm._v("Ir al listado")]
                            )
                          : _vm._e()
                      ]
                    : [
                        _c("el-button", { on: { click: _vm.clickFinalize } }, [
                          _vm._v("Ir al listado")
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-button",
                          {
                            attrs: { type: "primary" },
                            on: { click: _vm.clickNewSaleNote }
                          },
                          [_vm._v("Nuevo Nota de venta")]
                        )
                      ]
                ],
                2
              )
            ]
          )
        ],
        2
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
    require("vue-hot-reload-api")      .rerender("data-v-7d684f78", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/sale_notes/partials/options.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/sale_notes/partials/options.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7d684f78\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/sale_notes/partials/options.vue")
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
Component.options.__file = "resources/js/views/sale_notes/partials/options.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7d684f78", Component.options)
  } else {
    hotAPI.reload("data-v-7d684f78", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=166.js.map