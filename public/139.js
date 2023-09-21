webpackJsonp([139],{

/***/ "./modules/College/Resources/assets/js/views/classrooms/student_view.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/classrooms/student_view.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0ec93f35\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/classrooms/student_view.vue")
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
Component.options.__file = "modules/College/Resources/assets/js/views/classrooms/student_view.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0ec93f35", Component.options)
  } else {
    hotAPI.reload("data-v-0ec93f35", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/College/Resources/assets/js/views/classrooms/student_view.vue":
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
var PaymentCollege = function PaymentCollege() {
  return __webpack_require__.e/* import() */(125/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/payment_college.vue"));
};

var PaymentsForm = function PaymentsForm() {
  return __webpack_require__.e/* import() */(135/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/payment_form.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "classroomId"],
  components: {
    PaymentCollege: PaymentCollege,
    PaymentsForm: PaymentsForm
  },
  data: function data() {
    return {
      loading: false,
      students: [],
      allStudents: [],
      description: null,
      showPayment: false,
      member: null,
      showPaymentsForm: false
    };
  },
  methods: {
    getRecords: function getRecords() {},
    openFormPayments: function openFormPayments(record) {
      this.showPaymentsForm = true;
      this.member = record.member;
    },
    openPayment: function openPayment(record) {
      this.showPayment = true;
      this.member = record.member;
    },
    searchStudent: function searchStudent() {
      var desc = this.description.toLowerCase();
      this.students = this.allStudents.filter(function (s) {
        if (s.name.toLowerCase().includes(desc) || s.number.toLowerCase().includes(desc)) {
          return s;
        }
      });
    },
    open: function open() {
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
                return _this.$http("/college/classrooms/".concat(_this.classroomId));

              case 4:
                response = _context.sent;
                _this.allStudents = response.data;
                _this.students = _this.allStudents;
                console.log(_this.students);
                _context.next = 13;
                break;

              case 10:
                _context.prev = 10;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);

              case 13:
                _context.prev = 13;
                _this.loading = false;
                return _context.finish(13);

              case 16:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 10, 13, 16]]);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0ec93f35\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/College/Resources/assets/js/views/classrooms/student_view.vue":
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
        width: "650px",
        "append-to-body": "",
        title: "Lista de estudiantes"
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row mt-4" }, [
        _c(
          "div",
          { staticClass: "col-12" },
          [
            _c(
              "el-input",
              {
                attrs: { placeholder: "Nombre/documento" },
                on: { input: _vm.searchStudent },
                model: {
                  value: _vm.description,
                  callback: function($$v) {
                    _vm.description = $$v
                  },
                  expression: "description"
                }
              },
              [
                _c("i", {
                  staticClass: "el-input__icon el-icon-search",
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
      _c("table", { staticClass: "table" }, [
        _c("thead", [
          _c("tr", [
            _c("th", [_vm._v("#")]),
            _vm._v(" "),
            _c("th", [_vm._v("Nombre")]),
            _vm._v(" "),
            _c("th")
          ])
        ]),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.students, function(student, idx) {
            return _c("tr", { key: idx }, [
              _c("td", [_vm._v(_vm._s(idx + 1))]),
              _vm._v(" "),
              _c("td", [
                _vm._v(
                  "\n                    " +
                    _vm._s(student.name) +
                    "\n                    "
                ),
                _c("br"),
                _vm._v(" "),
                _c("small", [_vm._v(_vm._s(student.number))])
              ]),
              _vm._v(" "),
              _c("td", [
                _c(
                  "div",
                  { staticClass: "d-flex justify-content-center" },
                  [
                    !student.incomplete
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "success" },
                            on: {
                              click: function($event) {
                                return _vm.openPayment(student)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Mensualidad\n                        "
                            )
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    !student.incomplete
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "primary" },
                            on: {
                              click: function($event) {
                                return _vm.openFormPayments(student)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Ver tramites\n                        "
                            )
                          ]
                        )
                      : _c(
                          "el-button",
                          {
                            attrs: { type: "danger" },
                            on: {
                              click: function($event) {
                                return _vm.openFormPayments(student)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                            Cancelar pagos\n                        "
                            )
                          ]
                        )
                  ],
                  1
                )
              ])
            ])
          }),
          0
        )
      ]),
      _vm._v(" "),
      _c("payment-college", {
        attrs: {
          title: "Servicio",
          is_payment: _vm.showPayment,
          type: "service",
          member: _vm.member,
          classroomId: _vm.classroomId
        },
        on: {
          "update:is_payment": function($event) {
            _vm.showPayment = $event
          },
          getRecords: _vm.open,
          "update:member": function($event) {
            _vm.member = $event
          }
        }
      }),
      _vm._v(" "),
      _c("payments-form", {
        attrs: {
          title: "Tramites",
          showDialog: _vm.showPaymentsForm,
          member: _vm.member
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showPaymentsForm = $event
          },
          "update:show-dialog": function($event) {
            _vm.showPaymentsForm = $event
          },
          getRecords: _vm.getRecords
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
    require("vue-hot-reload-api")      .rerender("data-v-0ec93f35", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=139.js.map