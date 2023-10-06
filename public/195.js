webpackJsonp([195],{

/***/ "./modules/Restaurant/Resources/assets/js/views/pos/partials/college.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/college.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-08a54e86\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/college.vue")
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
Component.options.__file = "modules/Restaurant/Resources/assets/js/views/pos/partials/college.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-08a54e86", Component.options)
  } else {
    hotAPI.reload("data-v-08a54e86", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/college.vue":
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
var CreateForm = function CreateForm() {
  return __webpack_require__.e/* import() */(143/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/views/classrooms/form.vue"));
};

var CreateRegisterForm = function CreateRegisterForm() {
  return __webpack_require__.e/* import() */(130/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/views/classrooms/register_form.vue"));
};

var StudentView = function StudentView() {
  return __webpack_require__.e/* import() */(142/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/views/classrooms/student_view.vue"));
};

var PaymentForm = function PaymentForm() {
  return __webpack_require__.e/* import() */(127/* duplicate */).then(__webpack_require__.bind(null, "./modules/College/Resources/assets/js/components/payment_college.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "configuration"],
  components: {
    CreateForm: CreateForm,
    CreateRegisterForm: CreateRegisterForm,
    PaymentForm: PaymentForm,
    StudentView: StudentView
  },
  created: function created() {
    this.getTables();
  },
  data: function data() {
    return {
      loading: false,
      classes: [],
      pagination: {},
      levels: [],
      degrees: [],
      sections: [],
      turns: [],
      search: {},
      recordViewStudent: null,
      showStudentsView: false,
      recordCreateRegisterForm: null,
      showPayment: false,
      paymentTitle: null
    };
  },
  methods: {
    clickRegister: function clickRegister(record) {
      this.recordCreateRegisterForm = record;
      this.showPayment = true;
      this.paymentTitle = "Matricula ".concat(record.level, " | ").concat(record.degree, "-").concat(record.section, " | ").concat(record.turn);
    },
    clickCreate: function clickCreate() {},
    desactive: function desactive() {},
    viewStudents: function viewStudents(record) {
      this.showStudentsView = true;
      this.recordViewStudent = record;
    },
    query: function query() {
      var _this = this;

      var q = "?";
      Object.keys(this.search).forEach(function (s) {
        q += "".concat(s, "=").concat(_this.search[s], "&");
      });
      return q;
    },
    getRecords: function getRecords() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _this2.loading = true;
                _context.next = 4;
                return _this2.$http("/college/classrooms/records".concat(_this2.query()));

              case 4:
                response = _context.sent;
                data = response.data.data;
                _this2.classes = data;
                _context.next = 11;
                break;

              case 9:
                _context.prev = 9;
                _context.t0 = _context["catch"](0);

              case 11:
                _context.prev = 11;
                _this2.loading = false;
                return _context.finish(11);

              case 14:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 9, 11, 14]]);
      }))();
    },
    getTables: function getTables() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {
        var response, data;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _this3.loading = true;
                _context2.next = 4;
                return _this3.$http("/college/classrooms/tables");

              case 4:
                response = _context2.sent;
                data = response.data;
                _this3.levels = data.levels;
                _this3.degrees = data.degrees;
                _this3.sections = data.sections;
                _this3.turns = data.turns;
                _context2.next = 15;
                break;

              case 12:
                _context2.prev = 12;
                _context2.t0 = _context2["catch"](0);
                console.log(_context2.t0);

              case 15:
                _context2.prev = 15;
                _this3.loading = false;
                return _context2.finish(15);

              case 18:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, null, [[0, 12, 15, 18]]);
      }))();
    },
    open: function open() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee3() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this4.getRecords();

              case 2:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    close: function close() {
      this.$emit("update:showDialog", false);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-08a54e86\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Restaurant/Resources/assets/js/views/pos/partials/college.vue":
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
        title: "Matriculas/Mensualidades",
        visible: _vm.showDialog,
        "append-to-body": ""
      },
      on: { open: _vm.open, close: _vm.close }
    },
    [
      _c("div", { staticClass: "row mt-3" }, [
        _c(
          "div",
          { staticClass: "col-12 col-md-3" },
          [
            _c("label", { staticClass: "label-control w-100" }, [
              _vm._v("\n                Nivel\n            ")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { clearable: "" },
                on: { change: _vm.getRecords },
                model: {
                  value: _vm.search.level_id,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "level_id", $$v)
                  },
                  expression: "search.level_id"
                }
              },
              _vm._l(_vm.levels, function(level) {
                return _c("el-option", {
                  key: level.id,
                  attrs: { value: level.id, label: level.description }
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
          { staticClass: "col-12 col-md-3" },
          [
            _c("label", { staticClass: "label-control w-100" }, [
              _vm._v("\n                Turno\n            ")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { clearable: "" },
                on: { change: _vm.getRecords },
                model: {
                  value: _vm.search.turn_id,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "turn_id", $$v)
                  },
                  expression: "search.turn_id"
                }
              },
              _vm._l(_vm.turns, function(turn) {
                return _c("el-option", {
                  key: turn.id,
                  attrs: { value: turn.id, label: turn.description }
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
          { staticClass: "col-12 col-md-3" },
          [
            _c("label", { staticClass: "label-control w-100" }, [
              _vm._v("\n                Grado\n            ")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { clearable: "" },
                on: { change: _vm.getRecords },
                model: {
                  value: _vm.search.degree_id,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "degree_id", $$v)
                  },
                  expression: "search.degree_id"
                }
              },
              _vm._l(_vm.degrees, function(degree) {
                return _c("el-option", {
                  key: degree.id,
                  attrs: { value: degree.id, label: degree.description }
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
          { staticClass: "col-12 col-md-3" },
          [
            _c("label", { staticClass: "label-control w-100" }, [
              _vm._v("\n                Sección\n            ")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { clearable: "" },
                on: { change: _vm.getRecords },
                model: {
                  value: _vm.search.section_id,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "section_id", $$v)
                  },
                  expression: "search.section_id"
                }
              },
              _vm._l(_vm.sections, function(section) {
                return _c("el-option", {
                  key: section.id,
                  attrs: { value: section.id, label: section.description }
                })
              }),
              1
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
            _c("th", [_vm._v("\n                    SALON\n                ")]),
            _vm._v(" "),
            _c("th", [_vm._v("ALUMNOS")]),
            _vm._v(" "),
            _c("th")
          ])
        ]),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.classes, function(classroom, idx) {
            return _c("tr", { key: idx }, [
              _c("td", [_vm._v(_vm._s(idx + 1))]),
              _vm._v(" "),
              _c("td", [
                _c("span", { staticClass: "d-block" }, [
                  _vm._v(
                    "\n                        " +
                      _vm._s(classroom.degree) +
                      " " +
                      _vm._s(classroom.section)
                  )
                ]),
                _vm._v(" "),
                _c("span", { staticClass: "small" }, [
                  _vm._v(
                    "\n                        " +
                      _vm._s(classroom.level) +
                      " " +
                      _vm._s(classroom.turn) +
                      "\n                    "
                  )
                ])
              ]),
              _vm._v(" "),
              _c(
                "td",
                [
                  _c(
                    "el-button",
                    {
                      attrs: { icon: "el-icon-search" },
                      on: {
                        click: function($event) {
                          return _vm.viewStudents(classroom.id)
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(classroom.students.length) +
                          "/\n                        " +
                          _vm._s(classroom.places) +
                          "\n                    "
                      )
                    ]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("td", [
                _c(
                  "div",
                  { staticClass: "d-flex justify-content-end" },
                  [
                    classroom.students.length != classroom.places
                      ? _c(
                          "el-button",
                          {
                            attrs: { size: "mini", type: "primary" },
                            on: {
                              click: function($event) {
                                return _vm.clickRegister(classroom)
                              }
                            }
                          },
                          [_vm._v("Matricular")]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "el-button",
                      {
                        attrs: { size: "mini", type: "primary" },
                        on: {
                          click: function($event) {
                            return _vm.clickCreate(classroom)
                          }
                        }
                      },
                      [_vm._v("Editar")]
                    ),
                    _vm._v(" "),
                    _c(
                      "el-button",
                      {
                        attrs: {
                          size: "mini",
                          type: classroom.active ? "danger" : "success"
                        },
                        on: {
                          click: function($event) {
                            return _vm.desactive(classroom)
                          }
                        }
                      },
                      [
                        _vm._v(
                          _vm._s(classroom.active ? "Desactivar" : "Activar")
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
      _c("student-view", {
        attrs: {
          showDialog: _vm.showStudentsView,
          classroomId: _vm.recordViewStudent
        },
        on: {
          "update:showDialog": function($event) {
            _vm.showStudentsView = $event
          },
          "update:show-dialog": function($event) {
            _vm.showStudentsView = $event
          }
        }
      }),
      _vm._v(" "),
      _c("payment-form", {
        attrs: {
          type: "register",
          title: _vm.paymentTitle,
          record: _vm.recordCreateRegisterForm,
          is_payment: _vm.showPayment
        },
        on: {
          "update:is_payment": function($event) {
            _vm.showPayment = $event
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
    require("vue-hot-reload-api")      .rerender("data-v-08a54e86", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=195.js.map