webpackJsonp([224],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/modal_generate_cpe.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/modal_generate_cpe.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-c4c906fe\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/modal_generate_cpe.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/modal_generate_cpe.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-c4c906fe", Component.options)
  } else {
    hotAPI.reload("data-v-c4c906fe", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/modal_generate_cpe.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_moment__ = __webpack_require__("./node_modules/moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_moment__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: {
    show: {
      required: true,
      type: Boolean
    }
  },
  data: function data() {
    return {
      title: "",
      loading: false,
      clients: [],
      filter: {
        type: "name",
        name: null
      },
      form: {
        client_id: null,
        selecteds: []
      },
      notes: [],
      errors: {},
      group_items_generate_document: false,
      sum_total: null
    };
  },
  methods: {
    getObjectForNote: function getObjectForNote(data) {
      return {
        number_full: "".concat(data.series, "-").concat(data.number),
        id: data.id,
        items: data.items
      };
    },
    onFetchNoteItems: function onFetchNoteItems() {
      var _this = this;

      if (this.form.selecteds.length === 0) {
        this.$message({
          message: "Seleccione una o más notas de venta por favor",
          type: "warning"
        });
        return;
      }

      this.loading = true; //   if(this.group_items_generate_document){

      if (true) {
        var data = {
          notes_id: this.form.selecteds
        };
        this.$http.post("/sale-notes/items", data).then(function (response) {
          var notes = [];

          _this.notes.map(function (d) {
            if (d.selected) {
              // notes.push(`${d.series}-${d.number}`);
              notes.push(_this.getObjectForNote(d));
            }
          });

          var items = response.data.data;
          var data = [];
          items.map(function (i) {
            var it = {
              id: i.item_id,
              quantity: 0
            };
            items.map(function (ite) {
              if (ite.item_id === it.id) {
                it.quantity = it.quantity + parseFloat(ite.quantity);
              }
            });
            var itemIsDuplicated = data.find(function (item) {
              return item.id === it.id;
            });

            if (itemIsDuplicated) {
              itemIsDuplicated.quantity = it.quantity;
            } else {
              data.push(it);
            }
          });

          var client = _this.clients.find(function (c) {
            return c.id === _this.form.client_id;
          });

          localStorage.setItem("client", JSON.stringify(client));
          localStorage.setItem("itemsForNotes", JSON.stringify(data));
          localStorage.setItem("notes", JSON.stringify(notes));

          _this.onClose();

          window.location.href = "/documents/create";
        })["catch"](function (error) {
          return _this.axiosError(error);
        })["finally"](function () {
          return _this.loading = false;
        });
      } else {
        this.processNotGroupItems();
      }
    },
    processNotGroupItems: function processNotGroupItems() {
      var _this2 = this;

      var data = {
        notes_id: this.form.selecteds,
        select_all: true
      };
      this.$http.post("/sale-notes/items", data).then(function (response) {
        var notes = [];

        _this2.notes.map(function (d) {
          if (d.selected) {
            // notes.push(`${d.series}-${d.number}`);
            notes.push(_this2.getObjectForNote(d));
          }
        });

        var items = response.data.data;

        var client = _this2.clients.find(function (c) {
          return c.id === _this2.form.client_id;
        });

        localStorage.setItem("client", JSON.stringify(client));
        localStorage.setItem("itemsNotGroupForNotes", JSON.stringify(items));
        localStorage.setItem("notes", JSON.stringify(notes));

        _this2.onClose();

        window.location.href = "/documents/create";
      })["catch"](function (error) {
        return _this2.axiosError(error);
      })["finally"](function () {
        return _this2.loading = false;
      });
    },
    onFillSelectedNotes: function onFillSelectedNotes() {
      var _this3 = this;

      this.form.selecteds = [];
      this.sum_total = 0;
      var total = 0;
      this.notes.map(function (d) {
        if (d.selected) {
          total += Number(d.total);

          _this3.form.selecteds.push(d.id);
        }
      });
      this.sum_total += total;
    },
    onFindNotes: function onFindNotes() {
      var _this4 = this;

      this.form.selecteds = [];
      this.loading = true;
      var params = this.form;
      this.$http.get("/sale-notes/list-by-client", {
        params: params
      }).then(function (response) {
        /* this.sum_total = response.data.sum_total; */
        _this4.notes = response.data.data.map(function (d) {
          d.selected = false;
          d.date_of_issue = __WEBPACK_IMPORTED_MODULE_0_moment___default()(d.date_of_issue).format("YYYY-MM-DD");
          d.items = d.items.map(function (item) {
            return {
              id: item.id,
              item_id: item.item_id
            };
          });
          return d;
        });
      })["finally"](function () {
        return _this4.loading = false;
      });
    },
    onFindClients: function onFindClients(query) {
      this.filter.name = query;
      this.onFetchClients();
    },
    onFetchClients: function onFetchClients() {
      var _this5 = this;

      this.loading = true;
      this.notes = [];
      this.form.selecteds = [];
      var params = this.filter;
      this.$http.get("/customers/list", {
        params: params
      }).then(function (response) {
        _this5.clients = response.data.data;
      })["finally"](function () {
        return _this5.loading = false;
      });
    },
    onOpened: function onOpened() {
      this.filter.type = "name";
      this.filter.name = null;
      this.form.client_id = null;
      this.onFetchClients(); //   this.getConfigGroupItems();
    },
    getConfigGroupItems: function getConfigGroupItems() {
      var _this6 = this;

      this.$http.get("/sale-notes/config-group-items").then(function (response) {
        // console.log(response)
        _this6.group_items_generate_document = response.data.group_items_generate_document;
      });
    },
    onClose: function onClose() {
      this.notes = [];
      this.$emit("update:show", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-c4c906fe\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/modal_generate_cpe.vue":
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
            "append-to-body": "",
            title: "Generar comprobante desde múltiples notas",
            visible: _vm.show,
            "close-on-click-modal": false,
            "close-on-press-escape": false
          },
          on: { open: _vm.onOpened, close: _vm.onClose }
        },
        [
          _c("div", { staticClass: "row mt-2" }, [
            _c(
              "div",
              { staticClass: "col-2" },
              [
                _c(
                  "el-select",
                  {
                    attrs: { disabled: _vm.loading },
                    on: { click: _vm.onFetchClients },
                    model: {
                      value: _vm.filter.type,
                      callback: function($$v) {
                        _vm.$set(_vm.filter, "type", $$v)
                      },
                      expression: "filter.type"
                    }
                  },
                  [
                    _c("el-option", {
                      key: "document",
                      attrs: { value: "document", label: "# de documento" }
                    }),
                    _vm._v(" "),
                    _c("el-option", {
                      key: "name",
                      attrs: { value: "name", label: "Nombres" }
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
              { staticClass: "col-3 form-group" },
              [
                _c(
                  "el-select",
                  {
                    attrs: {
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      placeholder: "Ingrese uno más caracteres",
                      "remote-method": _vm.onFindClients,
                      loading: _vm.loading
                    },
                    model: {
                      value: _vm.form.client_id,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "client_id", $$v)
                      },
                      expression: "form.client_id"
                    }
                  },
                  _vm._l(_vm.clients, function(item) {
                    return _c("el-option", {
                      key: item.id,
                      attrs: { label: item.name, value: item.id }
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
              { staticClass: "col-3 form-group" },
              [
                _c("el-date-picker", {
                  staticStyle: { width: "100%" },
                  attrs: {
                    type: "date",
                    placeholder: "Inicio Fecha de emisión",
                    "value-format": "yyyy-MM-dd"
                  },
                  model: {
                    value: _vm.form.date_of_issue,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "date_of_issue", $$v)
                    },
                    expression: "form.date_of_issue"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-3 form-group" },
              [
                _c("el-date-picker", {
                  staticStyle: { width: "100%" },
                  attrs: {
                    type: "date",
                    placeholder: "Final Fecha de emisión",
                    "value-format": "yyyy-MM-dd"
                  },
                  model: {
                    value: _vm.form.date_of_due,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "date_of_due", $$v)
                    },
                    expression: "form.date_of_due"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-2 form-group" },
              [
                _c(
                  "el-button",
                  {
                    staticClass: "btn-block",
                    attrs: { type: "primary" },
                    on: { click: _vm.onFindNotes }
                  },
                  [_c("i", { staticClass: "fa fa-search" })]
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _vm.notes
            ? _c("div", { staticClass: "table-responsive pt-5" }, [
                _c("span", [
                  _vm._v(
                    "Seleccione una o más notas de venta para poder\n                continuar"
                  )
                ]),
                _vm._v(" "),
                _vm.errors.notes_id
                  ? _c(
                      "div",
                      {
                        staticClass: "alert alert-warning",
                        attrs: { role: "alert" }
                      },
                      [
                        _vm._v(
                          "\n                " +
                            _vm._s(_vm.errors.notes_id[0]) +
                            "\n            "
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("table", { staticClass: "table table-hover table-stripe" }, [
                  _c("thead", [
                    _c("tr", [
                      _c("th"),
                      _vm._v(" "),
                      _c("th", [_vm._v("Nota")]),
                      _vm._v(" "),
                      _c("th", [_vm._v("Fecha de emisión")]),
                      _vm._v(" "),
                      _c("th", [_vm._v("Monto")])
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    [
                      _vm._l(_vm.notes, function(dis) {
                        return _c("tr", { key: dis.id }, [
                          _c(
                            "td",
                            [
                              _c("el-switch", {
                                on: { change: _vm.onFillSelectedNotes },
                                model: {
                                  value: dis.selected,
                                  callback: function($$v) {
                                    _vm.$set(dis, "selected", $$v)
                                  },
                                  expression: "dis.selected"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("td", [
                            _c("span", [_vm._v(_vm._s(dis.series))]),
                            _vm._v("-\n                            "),
                            _c("span", [_vm._v(_vm._s(dis.number))])
                          ]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(dis.date_of_issue))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(dis.total))])
                        ])
                      }),
                      _vm._v(" "),
                      _c("tr", [
                        _c("td"),
                        _vm._v(" "),
                        _c("td"),
                        _vm._v(" "),
                        _c("td", [_vm._v("Total")]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(this.sum_total))])
                      ])
                    ],
                    2
                  )
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "text-center" },
                  [
                    _vm.form.selecteds.length > 0
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "primary", disabled: _vm.loading },
                            on: { click: _vm.onFetchNoteItems }
                          },
                          [_vm._v("Generar CPE")]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "el-button",
                      {
                        attrs: { disabled: _vm.loading },
                        on: { click: _vm.onClose }
                      },
                      [_vm._v("Cerrar")]
                    )
                  ],
                  1
                )
              ])
            : _vm._e()
        ]
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
    require("vue-hot-reload-api")      .rerender("data-v-c4c906fe", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=224.js.map