webpackJsonp([157],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-63702f89\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-63702f89\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-63702f89", Component.options)
  } else {
    hotAPI.reload("data-v-63702f89", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue":
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
var WhatsappModal = function WhatsappModal() {
  return __webpack_require__.e/* import() */(138/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/components/WhatsappModalReports.vue"));
};

var DispatchCreate = function DispatchCreate() {
  return __webpack_require__.e/* import() */(0/* duplicate */).then(__webpack_require__.bind(null, "./resources/js/views/dispatches/create.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "configuration"],
  components: {
    DispatchCreate: DispatchCreate,
    WhatsappModal: WhatsappModal
  },
  data: function data() {
    return {
      showCreate: false,
      loading: false,
      resource: "dispatches",
      records: [],
      linkResource: null,
      message: null,
      showWhatsappForm: false
    };
  },
  methods: {
    whatsapp: function whatsapp(record) {
      var external_id = record.external_id;
      var formatoPdf = "/print/dispatch/".concat(external_id, "/ticket");
      this.linkResource = formatoPdf;
      this.message = "Su comprobante electrónico *" + record.number + "*, ha sido generado correctamente a través del facturador electrónico de " + "*" + this.$desarrollador + "*";
      this.showWhatsappForm = true;
    },
    openPdf: function openPdf(record, format) {
      window.open("/print/dispatch/".concat(record.external_id, "/").concat(format), "_blank");
    },
    closeDispatch: function closeDispatch() {
      this.showCreate = false;
    },
    getRecords: function getRecords() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this.loading = true;
                _context.next = 4;
                return _this.$http("/dispatches/records");

              case 4:
                response = _context.sent;

                if (response.status == 200) {
                  data = response.data.data;
                  _this.records = data;
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
    close: function close() {
      this.$emit("update:showDialog", false);
    },
    open: function open() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.getRecords();

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

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-63702f89\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.guide-dialog .el-dialog__header {\r\n    display: none;\n}\n.guide-dialog .el-dialog__body {\r\n    padding: 0px !important;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/modules/Restaurant/Resources/assets/js/views/pos/partials/modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue"],"names":[],"mappings":";AAqGA;IACA,cAAA;CACA;AACA;IACA,wBAAA;CACA","file":"dispatch_modal.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        title=\"Lista de guias\"\r\n        :visible=\"showDialog\"\r\n        @open=\"open\"\r\n        @close=\"close\"\r\n        v-loading=\"loading\"\r\n    >\r\n        <div class=\"d-flex justify-content-end mt-2\">\r\n            <el-button type=\"primary\" @click=\"showCreate = true\">\r\n                <i class=\"fas fa-plus\"></i>\r\n                Nuevo\r\n            </el-button>\r\n            <el-button @click=\"close\">\r\n                <i class=\"fas fa-times\"></i>\r\n                Cerrar\r\n            </el-button>\r\n        </div>\r\n        <div class=\"row mt-2\">\r\n            <table\r\n                class=\"table\r\n            table-responsive table-striped table-bordered table-hover\r\n            \"\r\n            >\r\n                <thead>\r\n                    <tr>\r\n                        <th>Fecha</th>\r\n                        <th>Numero</th>\r\n                        <th>Cliente</th>\r\n                        <th>Documento afectado</th>\r\n                        <th>Estado</th>\r\n                        <th>Acciones</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>\r\n                    <tr v-for=\"(record, idx) in records\" :key=\"idx\">\r\n                        <td>\r\n                            {{ record.date_of_issue }}\r\n                        </td>\r\n                        <td>\r\n                            {{ record.number }}\r\n                        </td>\r\n                        <td>\r\n                            {{ record.customer_name }}\r\n                        </td>\r\n                        <td>\r\n                            {{\r\n                                record.documents.length > 0\r\n                                    ? record.documents\r\n                                          .map(r => r.description)\r\n                                          .join(\",\")\r\n                                    : \"\"\r\n                            }}\r\n                        </td>\r\n                        <td>\r\n                            {{ record.state_type_description }}\r\n                        </td>\r\n                        <td>\r\n                            <el-button\r\n                                type=\"primary\"\r\n                                size=\"mini\"\r\n                                @click=\"openPdf(record, 'a4')\"\r\n                            >\r\n                                <i class=\"fas fa-file\"></i>\r\n                                A4\r\n                            </el-button>\r\n                            <el-button\r\n                                type=\"success\"\r\n                                size=\"mini\"\r\n                                @click=\"whatsapp(record)\"\r\n                            >\r\n                                <i class=\"fab fa-whatsapp\"></i>\r\n                            </el-button>\r\n                        </td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n        <el-dialog\r\n            class=\"guide-dialog\"\r\n            width=\"90%\"\r\n            :visible.sync=\"showCreate\"\r\n            append-to-body\r\n        >\r\n            <dispatch-create\r\n                @records=\"getRecords\"\r\n                @closeDispatch=\"closeDispatch\"\r\n                :configuration=\"configuration\"\r\n                :pos=\"true\"\r\n            ></dispatch-create>\r\n            \r\n        </el-dialog>\r\n        <whatsapp-modal\r\n                :resource=\"linkResource\"\r\n                :message=\"message\"\r\n                :showWhatsappForm.sync=\"showWhatsappForm\"\r\n            >\r\n            </whatsapp-modal>\r\n    </el-dialog>\r\n</template>\r\n<style>\r\n.guide-dialog .el-dialog__header {\r\n    display: none;\r\n}\r\n.guide-dialog .el-dialog__body {\r\n    padding: 0px !important;\r\n}\r\n</style>\r\n<script>\r\nconst WhatsappModal = () =>\r\n    import(\r\n        \"../../../../../../../../resources/js/components/WhatsappModalReports.vue\"\r\n    );\r\nconst DispatchCreate = () =>\r\n    import(\"../../../../../../../../resources/js/views/dispatches/create.vue\");\r\n\r\nexport default {\r\n    props: [\"showDialog\", \"configuration\"],\r\n    components: {\r\n        DispatchCreate,\r\n        WhatsappModal\r\n    },\r\n    data() {\r\n        return {\r\n            showCreate: false,\r\n            loading: false,\r\n            resource: \"dispatches\",\r\n            records: [],\r\n            linkResource: null,\r\n            message: null,\r\n            showWhatsappForm:false\r\n        };\r\n    },\r\n    methods: {\r\n        whatsapp(record) {\r\n            let { external_id } = record;\r\n            let formatoPdf = `/print/dispatch/${external_id}/ticket`;\r\n            this.linkResource = formatoPdf;\r\n            this.message =  \"Su comprobante electrónico *\" +\r\n                        record.number +\r\n                        \"*, ha sido generado correctamente a través del facturador electrónico de \" +\r\n                        \"*\" +\r\n                        this.$desarrollador +\r\n                        \"*\"\r\n            this.showWhatsappForm = true;\r\n        },\r\n        openPdf(record, format) {\r\n            window.open(\r\n                `/print/dispatch/${record.external_id}/${format}`,\r\n                \"_blank\"\r\n            );\r\n        },\r\n        closeDispatch() {\r\n            this.showCreate = false;\r\n        },\r\n        async getRecords() {\r\n            try {\r\n                this.loading = true;\r\n                const response = await this.$http(`/dispatches/records`);\r\n                if (response.status == 200) {\r\n                    const { data } = response.data;\r\n                    this.records = data;\r\n                }\r\n            } catch (e) {\r\n                console.log(e);\r\n            } finally {\r\n                this.loading = false;\r\n            }\r\n        },\r\n        close() {\r\n            this.$emit(\"update:showDialog\", false);\r\n        },\r\n        async open() {\r\n            await this.getRecords();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-63702f89\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue":
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
      attrs: { title: "Lista de guias", visible: _vm.showDialog },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c(
        "div",
        { staticClass: "d-flex justify-content-end mt-2" },
        [
          _c(
            "el-button",
            {
              attrs: { type: "primary" },
              on: {
                click: function($event) {
                  _vm.showCreate = true
                }
              }
            },
            [
              _c("i", { staticClass: "fas fa-plus" }),
              _vm._v("\n            Nuevo\n        ")
            ]
          ),
          _vm._v(" "),
          _c("el-button", { on: { click: _vm.close } }, [
            _c("i", { staticClass: "fas fa-times" }),
            _vm._v("\n            Cerrar\n        ")
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c(
          "table",
          {
            staticClass:
              "table\n        table-responsive table-striped table-bordered table-hover\n        "
          },
          [
            _c("thead", [
              _c("tr", [
                _c("th", [_vm._v("Fecha")]),
                _vm._v(" "),
                _c("th", [_vm._v("Numero")]),
                _vm._v(" "),
                _c("th", [_vm._v("Cliente")]),
                _vm._v(" "),
                _c("th", [_vm._v("Documento afectado")]),
                _vm._v(" "),
                _c("th", [_vm._v("Estado")]),
                _vm._v(" "),
                _c("th", [_vm._v("Acciones")])
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.records, function(record, idx) {
                return _c("tr", { key: idx }, [
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(record.date_of_issue) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(record.number) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(record.customer_name) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(
                          record.documents.length > 0
                            ? record.documents
                                .map(function(r) {
                                  return r.description
                                })
                                .join(",")
                            : ""
                        ) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(record.state_type_description) +
                        "\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "td",
                    [
                      _c(
                        "el-button",
                        {
                          attrs: { type: "primary", size: "mini" },
                          on: {
                            click: function($event) {
                              return _vm.openPdf(record, "a4")
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "fas fa-file" }),
                          _vm._v(
                            "\n                            A4\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "el-button",
                        {
                          attrs: { type: "success", size: "mini" },
                          on: {
                            click: function($event) {
                              return _vm.whatsapp(record)
                            }
                          }
                        },
                        [_c("i", { staticClass: "fab fa-whatsapp" })]
                      )
                    ],
                    1
                  )
                ])
              }),
              0
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          staticClass: "guide-dialog",
          attrs: {
            width: "90%",
            visible: _vm.showCreate,
            "append-to-body": ""
          },
          on: {
            "update:visible": function($event) {
              _vm.showCreate = $event
            }
          }
        },
        [
          _c("dispatch-create", {
            attrs: { configuration: _vm.configuration, pos: true },
            on: { records: _vm.getRecords, closeDispatch: _vm.closeDispatch }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("whatsapp-modal", {
        attrs: {
          resource: _vm.linkResource,
          message: _vm.message,
          showWhatsappForm: _vm.showWhatsappForm
        },
        on: {
          "update:showWhatsappForm": function($event) {
            _vm.showWhatsappForm = $event
          },
          "update:show-whatsapp-form": function($event) {
            _vm.showWhatsappForm = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-63702f89", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-63702f89\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-63702f89\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/dispatch_modal.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("1d6b10f0", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-63702f89\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./dispatch_modal.vue", function() {
     var newContent = require("!!../../../../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-63702f89\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./dispatch_modal.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});
//# sourceMappingURL=157.js.map