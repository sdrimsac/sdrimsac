webpackJsonp([169],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/voided.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['showDialog', 'recordId', 'external'],
  data: function data() {
    return {
      titleDialog: null,
      loading_submit: false,
      resource: null,
      errors: {},
      form: {},
      group_id: null
    };
  },
  created: function created() {
    this.initForm();
  },
  methods: {
    initForm: function initForm() {
      this.loading_submit = false, this.group_id = null, this.errors = {}, this.form = {
        date_of_reference: null,
        summary_status_type_id: '3',
        documents: [{
          document_id: null,
          description: null
        }]
      };
    },
    create: function create() {
      var _this = this;

      this.$http.get("/documents/record/".concat(this.recordId)).then(function (response) {
        var document = response.data.data;
        _this.group_id = document.group_id;
        _this.form.date_of_reference = document.date_of_issue;
        _this.form.documents[0].document_id = document.id;
        _this.titleDialog = 'Comprobante: ' + document.number;
      });
    },
    submit: function submit() {
      var _this2 = this;

      this.loading_submit = true;
      this.resource = this.group_id === '01' ? 'voided' : 'summaries';
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this2.$eventHub.$emit('reloadData');

          _this2.$toast.success(response.data.message);

          if (_this2.external) {
            _this2.$emit('getRecords');
          }

          _this2.close();
        } else {
          _this2.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this2.errors = error.response.data.errors;
        } else {
          _this2.$toast.error(error.response.data.message);
        }
      }).then(function () {
        _this2.loading_submit = false;
      });
    },
    close: function close() {
      this.$emit('update:showDialog', false);
      this.initForm();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4242d5ec\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/voided.vue":
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
        title: _vm.titleDialog,
        visible: _vm.showDialog
      },
      on: { close: _vm.close, open: _vm.create }
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
          _c("div", { staticClass: "form-body" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-12" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.description }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Descripción del motivo de anulación")
                    ]),
                    _vm._v(" "),
                    _c(
                      "el-input",
                      {
                        attrs: { dusk: "description" },
                        model: {
                          value: _vm.form.documents[0].description,
                          callback: function($$v) {
                            _vm.$set(_vm.form.documents[0], "description", $$v)
                          },
                          expression: "form.documents[0].description"
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
                    _vm.errors.description
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.description[0])
                          }
                        })
                      : _vm._e()
                  ],
                  1
                )
              ])
            ])
          ]),
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
                    type: "danger",
                    "native-type": "submit",
                    dusk: "annulment-voided",
                    loading: _vm.loading_submit
                  }
                },
                [_vm._v("Anular")]
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
    require("vue-hot-reload-api")      .rerender("data-v-4242d5ec", module.exports)
  }
}

/***/ }),

/***/ "./resources/js/views/documents/partials/voided.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/documents/partials/voided.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4242d5ec\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/documents/partials/voided.vue")
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
Component.options.__file = "resources/js/views/documents/partials/voided.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4242d5ec", Component.options)
  } else {
    hotAPI.reload("data-v-4242d5ec", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=169.js.map