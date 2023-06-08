<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> master
webpackJsonp([99],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
<<<<<<< HEAD
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__(\"./node_modules/@babel/runtime/regenerator/index.js\");\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_functions__ = __webpack_require__(\"./resources/js/mixins/functions.js\");\n\n\nfunction asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }\n\nfunction _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"next\", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"throw\", err); } _next(undefined); }); }; }\n\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_functions__[\"c\" /* serviceNumber */]],\n  props: [\"worker\", \"showDialog\", \"type\", \"recordId\", \"external\", \"document_type_id\", \"input_person\", \"user_id\"],\n  data: function data() {\n    return {\n      social_medias: [],\n      loading_submit: false,\n      titleDialog: null,\n      resource: this.worker ? \"restaurant/worker/persons\" : \"persons\",\n      errors: {},\n      api_service_token: false,\n      form: {},\n      countries: [],\n      all_departments: [],\n      all_provinces: [],\n      all_districts: [],\n      provinces: [],\n      districts: [],\n      locations: [],\n      person_types: [],\n      identity_document_types: [],\n      all_users: []\n    };\n  },\n  created: function created() {\n    var _this = this;\n\n    return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {\n      return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {\n        while (1) {\n          switch (_context.prev = _context.next) {\n            case 0:\n              _context.next = 2;\n              return _this.initForm();\n\n            case 2:\n              _context.next = 4;\n              return _this.$http.get(\"/\".concat(_this.resource, \"/tables\")).then(function (response) {\n                _this.api_service_token = response.data.api_service_token;\n                _this.social_medias = response.data.social_media;\n                _this.all_users = response.data.users;\n                _this.countries = response.data.countries;\n                _this.all_departments = response.data.departments;\n                _this.all_provinces = response.data.provinces;\n                _this.all_districts = response.data.districts;\n                _this.identity_document_types = response.data.identity_document_types;\n                _this.locations = response.data.locations;\n                _this.person_types = response.data.person_types;\n              });\n\n            case 4:\n            case \"end\":\n              return _context.stop();\n          }\n        }\n      }, _callee);\n    }))();\n  },\n  computed: {\n    maxLength: function maxLength() {\n      if (this.form.identity_document_type_id === \"6\") {\n        return 11;\n      }\n\n      if (this.form.identity_document_type_id === \"1\") {\n        return 8;\n      }\n    }\n  },\n  methods: {\n    nuevoMetodo: function nuevoMetodo() {\n      var admin = this.all_users.find(function (user) {\n        return user.type == \"admin\";\n      });\n\n      if (admin) {\n        this.form.seller_id = admin.id;\n      } else {\n        if (this.all_users.length != 0) {\n          this.form.seller_id = this.all_users[0].id;\n        }\n      }\n    },\n    initForm: function initForm() {\n      this.errors = {};\n      this.form = {\n        id: null,\n        type: this.type,\n        identity_document_type_id: \"6\",\n        number: \"\",\n        name: null,\n        trade_name: null,\n        country_id: \"PE\",\n        department_id: null,\n        province_id: null,\n        district_id: null,\n        address: null,\n        telephone: null,\n        condition: null,\n        state: null,\n        email: null,\n        perception_agent: false,\n        percentage_perception: 0,\n        person_type_id: null,\n        comment: null,\n        addresses: [],\n        seller_id: null\n      };\n    },\n    opened: function opened() {\n      var _this2 = this;\n\n      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee2() {\n        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {\n          while (1) {\n            switch (_context2.prev = _context2.next) {\n              case 0:\n                if (!(_this2.external && _this2.input_person)) {\n                  _context2.next = 8;\n                  break;\n                }\n\n                if (!(_this2.form.number.length === 8 || _this2.form.number.length === 11)) {\n                  _context2.next = 8;\n                  break;\n                }\n\n                if (!(_this2.api_service_token != false)) {\n                  _context2.next = 7;\n                  break;\n                }\n\n                _context2.next = 5;\n                return _this2.$eventHub.$emit(\"enableClickSearch\");\n\n              case 5:\n                _context2.next = 8;\n                break;\n\n              case 7:\n                _this2.searchCustomer();\n\n              case 8:\n              case \"end\":\n                return _context2.stop();\n            }\n          }\n        }, _callee2);\n      }))();\n    },\n    create: function create() {\n      var _this3 = this;\n\n      if (this.external) {\n        if (this.document_type_id === \"01\") {\n          this.form.identity_document_type_id = \"6\";\n        }\n\n        if (this.document_type_id === \"03\") {\n          this.form.identity_document_type_id = \"1\";\n        }\n\n        if (this.input_person) {\n          this.form.identity_document_type_id = this.input_person.identity_document_type_id ? this.input_person.identity_document_type_id : this.form.identity_document_type_id;\n          this.form.number = this.input_person.number ? this.input_person.number : \"\";\n        }\n      }\n\n      if (this.type === \"customers\") {\n        this.titleDialog = this.recordId ? \"Editar Cliente\" : \"Nuevo Cliente\";\n      }\n\n      if (this.type === \"suppliers\") {\n        this.titleDialog = this.recordId ? \"Editar Proveedor\" : \"Nuevo Proveedor\";\n      }\n\n      if (this.recordId) {\n        this.$http.get(\"/\".concat(this.resource, \"/record/\").concat(this.recordId)).then(function (response) {\n          _this3.form = response.data.data;\n\n          _this3.filterProvinces();\n\n          _this3.filterDistricts();\n        });\n      }\n    },\n    clickAddAddress: function clickAddAddress() {\n      /* this.form.more_address.push({\r\n              location_id: [],\r\n              address: null,\r\n          })*/\n      this.form.addresses.push({\n        id: null,\n        country_id: \"PE\",\n        location_id: [],\n        address: null,\n        email: null,\n        phone: null,\n        main: false\n      });\n    },\n    submit: function submit() {\n      var _this4 = this;\n\n      this.nuevoMetodo();\n\n      if (!this.form.seller_id) {\n        this.$toast.error(\"Debe seleccionar un asesor\");\n        return;\n      }\n\n      if (this.form.identity_document_type_id == \"6\" && this.form.number.length != 11) {\n        this.$toast.error(\"La longitud del RUC debe ser de 11\");\n        return;\n      }\n\n      if (this.form.identity_document_type_id == \"1\" && this.form.number.length != 8) {\n        this.$toast.error(\"La longitud del DNI debe ser de 8\");\n        return;\n      }\n\n      this.loading_submit = true;\n      this.$http.post(\"/\".concat(this.resource), this.form).then(function (response) {\n        if (response.data.success) {\n          _this4.$toast.success(response.data.message);\n\n          _this4.$emit(\"add_customer\", response.data.id);\n\n          if (_this4.external) {\n            _this4.$eventHub.$emit(\"reloadDataPersons\", response.data.id);\n          } else {\n            _this4.$eventHub.$emit(\"reloadData\");\n          }\n\n          _this4.close();\n        } else {\n          _this4.$toast.error(response.data.message);\n        }\n      })[\"catch\"](function (error) {\n        if (error.response.status === 422) {\n          console.log(error.response.data.errors);\n          _this4.errors = error.response.data.errors;\n        } else {\n          console.log(error);\n        }\n      }).then(function () {\n        _this4.loading_submit = false;\n      });\n    },\n    changeIdentityDocType: function changeIdentityDocType() {\n      this.recordId == null ? this.setDataDefaultCustomer() : null;\n    },\n    setDataDefaultCustomer: function setDataDefaultCustomer() {\n      if (this.form.identity_document_type_id == \"0\") {\n        this.form.number = \"99999999\";\n        this.form.name = \"Clientes - Varios\";\n      } else {\n        this.form.number = \"\";\n        this.form.name = null;\n      }\n    },\n    close: function close() {\n      this.$eventHub.$emit(\"initInputPerson\");\n      this.$emit(\"update:showDialog\", false);\n      this.initForm();\n    },\n    searchCustomer: function searchCustomer() {\n      this.searchServiceNumberByType();\n    },\n    searchNumber: function searchNumber(data) {\n      this.form.district_id = data.ubigeo[2];\n      this.filterDistricts();\n      this.form.name = this.form.identity_document_type_id === \"1\" ? data.nombre_completo : data.nombre_o_razon_social;\n      this.form.trade_name = this.form.identity_document_type_id === \"6\" ? data.nombre_o_razon_social : \"\";\n      this.form.location_id = data.ubigeo;\n      this.form.department_id = data.ubigeo ? data.ubigeo[0] : null;\n      this.form.province_id = data.ubigeo ? data.ubigeo[1] : null;\n      this.form.district_id = data.ubigeo ? data.ubigeo[2] : null;\n      this.filterProvinces();\n      this.filterDistricts();\n      this.form.address = data.direccion;\n      this.form.condition = data.condicion;\n      this.form.state = data.estado;\n    },\n    clickRemoveAddress: function clickRemoveAddress(index) {\n      this.form.addresses.splice(index, 1);\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2pzL3ZpZXdzL3BlcnNvbnMvZm9ybS52dWU/ZWI4OCJdLCJuYW1lcyI6WyJtaXhpbnMiLCJwcm9wcyIsImRhdGEiLCJzb2NpYWxfbWVkaWFzIiwibG9hZGluZ19zdWJtaXQiLCJ0aXRsZURpYWxvZyIsInJlc291cmNlIiwiZXJyb3JzIiwiYXBpX3NlcnZpY2VfdG9rZW4iLCJmb3JtIiwiY291bnRyaWVzIiwiYWxsX2RlcGFydG1lbnRzIiwiYWxsX3Byb3ZpbmNlcyIsImFsbF9kaXN0cmljdHMiLCJwcm92aW5jZXMiLCJkaXN0cmljdHMiLCJsb2NhdGlvbnMiLCJwZXJzb25fdHlwZXMiLCJpZGVudGl0eV9kb2N1bWVudF90eXBlcyIsImFsbF91c2VycyIsImNyZWF0ZWQiLCJyZXNwb25zZSIsImNvbXB1dGVkIiwibWF4TGVuZ3RoIiwibWV0aG9kcyIsIm51ZXZvTWV0b2RvIiwiaW5pdEZvcm0iLCJpZCIsInR5cGUiLCJpZGVudGl0eV9kb2N1bWVudF90eXBlX2lkIiwibnVtYmVyIiwibmFtZSIsInRyYWRlX25hbWUiLCJjb3VudHJ5X2lkIiwiZGVwYXJ0bWVudF9pZCIsInByb3ZpbmNlX2lkIiwiZGlzdHJpY3RfaWQiLCJhZGRyZXNzIiwidGVsZXBob25lIiwiY29uZGl0aW9uIiwic3RhdGUiLCJlbWFpbCIsInBlcmNlcHRpb25fYWdlbnQiLCJwZXJjZW50YWdlX3BlcmNlcHRpb24iLCJwZXJzb25fdHlwZV9pZCIsImNvbW1lbnQiLCJhZGRyZXNzZXMiLCJzZWxsZXJfaWQiLCJvcGVuZWQiLCJjcmVhdGUiLCJnZXQiLCJ0aGVuIiwiY2xpY2tBZGRBZGRyZXNzIiwibG9jYXRpb25faWQiLCJwaG9uZSIsIm1haW4iLCJzdWJtaXQiLCJwb3N0IiwiY29uc29sZSIsImNoYW5nZUlkZW50aXR5RG9jVHlwZSIsInNldERhdGFEZWZhdWx0Q3VzdG9tZXIiLCJjbG9zZSIsInNlYXJjaEN1c3RvbWVyIiwic2VhcmNoTnVtYmVyIiwiY2xpY2tSZW1vdmVBZGRyZXNzIiwiaW5kZXgiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQTBtQnVEO0FBRXhDO0FBQ2ZBLG9GQURBO0FBRUFDLFVBQ0EsUUFEQSxFQUVBLFlBRkEsRUFHQSxNQUhBLEVBSUEsVUFKQSxFQUtBLFVBTEEsRUFNQSxrQkFOQSxFQU9BLGNBUEEsRUFRQSxTQVJBLENBRkE7QUFZQUMsTUFaQSxrQkFZQTtBQUNBO0FBQ0FDLHVCQURBO0FBRUFDLDJCQUZBO0FBR0FDLHVCQUhBO0FBSUFDLHFFQUpBO0FBS0FDLGdCQUxBO0FBTUFDLDhCQU5BO0FBT0FDLGNBUEE7QUFRQUMsbUJBUkE7QUFTQUMseUJBVEE7QUFVQUMsdUJBVkE7QUFXQUMsdUJBWEE7QUFZQUMsbUJBWkE7QUFhQUMsbUJBYkE7QUFjQUMsbUJBZEE7QUFlQUMsc0JBZkE7QUFnQkFDLGlDQWhCQTtBQWlCQUM7QUFqQkE7QUFtQkEsR0FoQ0E7QUFpQ0FDLFNBakNBLHFCQWlDQTtBQUFBOztBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBLHFCQUNBLGdCQURBOztBQUFBO0FBQUE7QUFBQSxxQkFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsZ0RBQ0FDLHFDQURBO0FBRUE7QUFDQTtBQUNBLGVBWkEsQ0FGQTs7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQWVBLEdBaERBO0FBaURBQztBQUNBQztBQUNBO0FBQ0E7QUFDQTs7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQVJBLEdBakRBO0FBMkRBQztBQUNBQyxlQURBLHlCQUNBO0FBQ0E7QUFBQTtBQUFBOztBQUNBO0FBQ0E7QUFDQSxPQUZBLE1BRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBVkE7QUFXQUMsWUFYQSxzQkFXQTtBQUNBO0FBQ0E7QUFDQUMsZ0JBREE7QUFFQUMsdUJBRkE7QUFHQUMsc0NBSEE7QUFJQUMsa0JBSkE7QUFLQUMsa0JBTEE7QUFNQUMsd0JBTkE7QUFPQUMsd0JBUEE7QUFRQUMsMkJBUkE7QUFTQUMseUJBVEE7QUFVQUMseUJBVkE7QUFXQUMscUJBWEE7QUFZQUMsdUJBWkE7QUFhQUMsdUJBYkE7QUFjQUMsbUJBZEE7QUFlQUMsbUJBZkE7QUFnQkFDLCtCQWhCQTtBQWlCQUMsZ0NBakJBO0FBa0JBQyw0QkFsQkE7QUFtQkFDLHFCQW5CQTtBQW9CQUMscUJBcEJBO0FBcUJBQztBQXJCQTtBQXVCQSxLQXBDQTtBQXFDQUMsVUFyQ0Esb0JBcUNBO0FBQUE7O0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBLHNCQUVBLHNDQUZBO0FBQUE7QUFBQTtBQUFBOztBQUFBLHNCQUlBLG1DQUNBLGdDQUxBO0FBQUE7QUFBQTtBQUFBOztBQUFBLHNCQU9BLGlDQVBBO0FBQUE7QUFBQTtBQUFBOztBQUFBO0FBQUEsdUJBUUEsMkNBUkE7O0FBQUE7QUFBQTtBQUFBOztBQUFBO0FBVUE7O0FBVkE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFjQSxLQW5EQTtBQW9EQUMsVUFwREEsb0JBb0RBO0FBQUE7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esa0VBQ0FwQix5QkFEQSxHQUVBLDJDQUZBLEdBR0EsbUNBSEE7QUFJQSx3REFDQSx3QkFEQSxHQUVBLEVBRkE7QUFHQTtBQUNBOztBQUNBO0FBQ0EsMkNBQ0EsZ0JBREEsR0FFQSxlQUZBO0FBR0E7O0FBQ0E7QUFDQSwyQ0FDQSxrQkFEQSxHQUVBLGlCQUZBO0FBR0E7O0FBRUE7QUFDQSxtQkFDQXFCLEdBREEsWUFDQSxhQURBLHFCQUNBLGFBREEsR0FFQUMsSUFGQSxDQUVBO0FBQ0E7O0FBQ0E7O0FBQ0E7QUFDQSxTQU5BO0FBT0E7QUFDQSxLQTNGQTtBQTRGQUMsbUJBNUZBLDZCQTRGQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQXpCLGdCQURBO0FBRUFNLHdCQUZBO0FBR0FvQix1QkFIQTtBQUlBaEIscUJBSkE7QUFLQUksbUJBTEE7QUFNQWEsbUJBTkE7QUFPQUM7QUFQQTtBQVNBLEtBM0dBO0FBNEdBQyxVQTVHQSxvQkE0R0E7QUFBQTs7QUFDQTs7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFDQSxVQUNBLDhDQUNBLDZCQUZBLEVBR0E7QUFDQTtBQUNBO0FBQ0E7O0FBQ0EsVUFDQSw4Q0FDQSw0QkFGQSxFQUdBO0FBQ0E7QUFDQTtBQUNBOztBQUNBO0FBQ0EsaUJBQ0FDLElBREEsWUFDQSxhQURBLEdBQ0EsU0FEQSxFQUVBTixJQUZBLENBRUE7QUFDQTtBQUNBOztBQUNBOztBQUNBO0FBQ0EsbUNBQ0EsbUJBREEsRUFFQTlCLGdCQUZBO0FBSUEsV0FMQSxNQUtBO0FBQ0E7QUFDQTs7QUFDQTtBQUNBLFNBWkEsTUFZQTtBQUNBO0FBQ0E7QUFDQSxPQWxCQSxXQW1CQTtBQUNBO0FBQ0FxQztBQUNBO0FBQ0EsU0FIQSxNQUdBO0FBQ0FBO0FBQ0E7QUFDQSxPQTFCQSxFQTJCQVAsSUEzQkEsQ0EyQkE7QUFDQTtBQUNBLE9BN0JBO0FBOEJBLEtBL0pBO0FBZ0tBUSx5QkFoS0EsbUNBZ0tBO0FBQ0E7QUFDQSxLQWxLQTtBQW1LQUMsMEJBbktBLG9DQW1LQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BSEEsTUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBM0tBO0FBNEtBQyxTQTVLQSxtQkE0S0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQWhMQTtBQWlMQUMsa0JBakxBLDRCQWlMQTtBQUNBO0FBQ0EsS0FuTEE7QUFxTEFDLGdCQXJMQSx3QkFxTEE3RCxJQXJMQSxFQXFMQTtBQUNBO0FBQ0E7QUFDQSx1QkFDQSw4Q0FDQUEsb0JBREEsR0FFQUEsMEJBSEE7QUFJQSw2QkFDQSw4Q0FDQUEsMEJBREEsR0FFQSxFQUhBO0FBSUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0F6TUE7QUEwTUE4RCxzQkExTUEsOEJBME1BQyxLQTFNQSxFQTBNQTtBQUNBO0FBQ0E7QUE1TUE7QUEzREEiLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz97XCJjYWNoZURpcmVjdG9yeVwiOnRydWUsXCJwcmVzZXRzXCI6W1tcIkBiYWJlbC9wcmVzZXQtZW52XCIse1wibW9kdWxlc1wiOmZhbHNlLFwidGFyZ2V0c1wiOntcImJyb3dzZXJzXCI6W1wiPiAyJVwiXX0sXCJmb3JjZUFsbFRyYW5zZm9ybXNcIjp0cnVlfV1dLFwicGx1Z2luc1wiOltcIkBiYWJlbC9wbHVnaW4tcHJvcG9zYWwtb2JqZWN0LXJlc3Qtc3ByZWFkXCIsW1wiQGJhYmVsL3BsdWdpbi10cmFuc2Zvcm0tcnVudGltZVwiLHtcImhlbHBlcnNcIjpmYWxzZX1dXX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT1zY3JpcHQmaW5kZXg9MCEuL3Jlc291cmNlcy9qcy92aWV3cy9wZXJzb25zL2Zvcm0udnVlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiPHRlbXBsYXRlPlxyXG4gICAgPGVsLWRpYWxvZ1xyXG4gICAgICAgIDp0aXRsZT1cInRpdGxlRGlhbG9nXCJcclxuICAgICAgICA6dmlzaWJsZT1cInNob3dEaWFsb2dcIlxyXG4gICAgICAgIEBjbG9zZT1cImNsb3NlXCJcclxuICAgICAgICBAb3Blbj1cImNyZWF0ZVwiXHJcbiAgICAgICAgYXBwZW5kLXRvLWJvZHlcclxuICAgICAgICBAb3BlbmVkPVwib3BlbmVkXCJcclxuICAgICAgICA6Y2xvc2Utb24tY2xpY2stbW9kYWw9XCJmYWxzZVwiXHJcbiAgICA+XHJcbiAgICAgICAgPGZvcm0gYXV0b2NvbXBsZXRlPVwib2ZmXCIgQHN1Ym1pdC5wcmV2ZW50PVwic3VibWl0XCI+XHJcbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJmb3JtLWJvZHlcIj5cclxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJyb3dcIj5cclxuICAgICAgICAgICAgICAgICAgICA8IS0tIDxkaXYgY2xhc3M9XCJjb2wtbWQtNFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImZvcm0tZ3JvdXBcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgOmNsYXNzPVwieyAnaGFzLWRhbmdlcic6IGVycm9ycy5zZWxsZXJfaWQgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID5WZW5kZWRvciAtIEFzZXNvclxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwidGV4dC1kYW5nZXJcIj4qPC9zcGFuPjwvbGFiZWxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1zZWxlY3RcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LW1vZGVsPVwiZm9ybS5zZWxsZXJfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpbHRlcmFibGVcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBAY2hhbmdlPVwiZmlsdGVyUHJvdmluY2VcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBvcHBlci1jbGFzcz1cImVsLXNlbGVjdC1kZXBhcnRtZW50c1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZHVzaz1cImRlcGFydG1lbnRfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1vcHRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1mb3I9XCJvcHRpb24gaW4gYWxsX3VzZXJzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmtleT1cIm9wdGlvbi5pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDp2YWx1ZT1cIm9wdGlvbi5pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpsYWJlbD1cIm9wdGlvbi5uYW1lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1vcHRpb24+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2VsLXNlbGVjdD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwidGV4dC1kYW5nZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtaWY9XCJlcnJvcnMuc2VsbGVyX2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMuc2VsbGVyX2lkWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj4gLS0+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC02XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJ2hhcy1kYW5nZXInOiBlcnJvcnMuaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID5UaXBvIERvYy4gSWRlbnRpZGFkXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNwYW4gY2xhc3M9XCJ0ZXh0LWRhbmdlclwiPio8L3NwYW4+PC9sYWJlbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLXNlbGVjdFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtbW9kZWw9XCJmb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpbHRlcmFibGVcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwb3BwZXItY2xhc3M9XCJlbC1zZWxlY3QtaWRlbnRpdHlfZG9jdW1lbnRfdHlwZVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZHVzaz1cImlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIEBjaGFuZ2U9XCJjaGFuZ2VJZGVudGl0eURvY1R5cGVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1vcHRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1mb3I9XCJvcHRpb24gaW4gaWRlbnRpdHlfZG9jdW1lbnRfdHlwZXNcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6a2V5PVwib3B0aW9uLmlkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOnZhbHVlPVwib3B0aW9uLmlkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmxhYmVsPVwib3B0aW9uLmRlc2NyaXB0aW9uXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1vcHRpb24+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2VsLXNlbGVjdD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwidGV4dC1kYW5nZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtaWY9XCJlcnJvcnMuaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWRbMF1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvc21hbGw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtNlwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImZvcm0tZ3JvdXBcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgOmNsYXNzPVwieyAnaGFzLWRhbmdlcic6IGVycm9ycy5udW1iZXIgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID5Ow7ptZXJvXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNwYW4gY2xhc3M9XCJ0ZXh0LWRhbmdlclwiPio8L3NwYW4+PC9sYWJlbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxkaXYgdi1pZj1cImFwaV9zZXJ2aWNlX3Rva2VuICE9IGZhbHNlXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPHgtaW5wdXQtc2VydmljZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6aWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZD1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZm9ybS5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtbW9kZWw9XCJmb3JtLm51bWJlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIEBzZWFyY2g9XCJzZWFyY2hOdW1iZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3gtaW5wdXQtc2VydmljZT5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiB2LWVsc2U+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLWlucHV0XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtbW9kZWw9XCJmb3JtLm51bWJlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDptYXhsZW5ndGg9XCJtYXhMZW5ndGhcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkdXNrPVwibnVtYmVyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDx0ZW1wbGF0ZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9PT1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJzYnIHx8XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9PT1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICcxJ1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLWJ1dHRvblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU9XCJwcmltYXJ5XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90PVwiYXBwZW5kXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6bG9hZGluZz1cImxvYWRpbmdfc2VhcmNoXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpY29uPVwiZWwtaWNvbi1zZWFyY2hcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIEBjbGljay5wcmV2ZW50PVwic2VhcmNoQ3VzdG9tZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9lbC1idXR0b24+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvdGVtcGxhdGU+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90PVwicHJlZml4XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9pXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvZWwtaW5wdXQ+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c21hbGxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInRleHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWlmPVwiZXJyb3JzLm51bWJlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLm51bWJlclswXVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9zbWFsbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJyb3dcIj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTZcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJmb3JtLWdyb3VwXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cInsgJ2hhcy1kYW5nZXInOiBlcnJvcnMubmFtZSB9XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPk5vbWJyZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwidGV4dC1kYW5nZXJcIj4qPC9zcGFuPjwvbGFiZWxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1pbnB1dCB2LW1vZGVsPVwiZm9ybS5uYW1lXCIgZHVzaz1cIm5hbWVcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8aVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90PVwicHJlZml4XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJlbC1pY29uLWVkaXQtb3V0bGluZVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvaVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvZWwtaW5wdXQ+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c21hbGxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInRleHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWlmPVwiZXJyb3JzLm5hbWVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtdGV4dD1cImVycm9ycy5uYW1lWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTZcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJmb3JtLWdyb3VwXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cInsgJ2hhcy1kYW5nZXInOiBlcnJvcnMudHJhZGVfbmFtZSB9XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPk5vbWJyZSBjb21lcmNpYWw8L2xhYmVsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtaW5wdXRcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LW1vZGVsPVwiZm9ybS50cmFkZV9uYW1lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkdXNrPVwidHJhZGVfbmFtZVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGlcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdD1cInByZWZpeFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2lcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLWlucHV0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNtYWxsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJ0ZXh0LWRhbmdlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cImVycm9ycy50cmFkZV9uYW1lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMudHJhZGVfbmFtZVswXVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9zbWFsbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICA8L2Rpdj5cclxuXHJcbiAgICAgICAgICAgICAgICA8IS0tIDxkaXYgY2xhc3M9XCJyb3dcIiB2LWlmPVwidHlwZSA9PT0gJ2N1c3RvbWVycydcIj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTRcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIiA6Y2xhc3M9XCJ7J2hhcy1kYW5nZXInOiBlcnJvcnMucGVyc29uX3R5cGVfaWR9XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCI+VGlwbyBkZSBjbGllbnRlPC9sYWJlbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1zZWxlY3Qgdi1tb2RlbD1cImZvcm0ucGVyc29uX3R5cGVfaWRcIiBmaWx0ZXJhYmxlICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLW9wdGlvbiB2LWZvcj1cIm9wdGlvbiBpbiBwZXJzb25fdHlwZXNcIiA6a2V5PVwib3B0aW9uLmlkXCIgOnZhbHVlPVwib3B0aW9uLmlkXCIgOmxhYmVsPVwib3B0aW9uLmRlc2NyaXB0aW9uXCI+PC9lbC1vcHRpb24+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2VsLXNlbGVjdD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbCBjbGFzcz1cInRleHQtZGFuZ2VyXCIgdi1pZj1cImVycm9ycy5wZXJzb25fdHlwZV9pZFwiIHYtdGV4dD1cImVycm9ycy5wZXJzb25fdHlwZV9pZFswXVwiPjwvc21hbGw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtOFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCI+Q29tZW50YXJpbzwvbGFiZWw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtaW5wdXQgdi1tb2RlbD1cImZvcm0uY29tbWVudFwiPiA8aSBzbG90PVwicHJlZml4XCIgY2xhc3M9XCJlbC1pY29uLWVkaXQtb3V0bGluZVwiPjwvaT48L2VsLWlucHV0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgIDwvZGl2PiAtLT5cclxuXHJcbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwicm93XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC00XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLmNvdW50cnlfaWQgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIj5QYcOtczwvbGFiZWw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtc2VsZWN0XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1tb2RlbD1cImZvcm0uY291bnRyeV9pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZmlsdGVyYWJsZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGR1c2s9XCJjb3VudHJ5X2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtb3B0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtZm9yPVwib3B0aW9uIGluIGNvdW50cmllc1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDprZXk9XCJvcHRpb24uaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6dmFsdWU9XCJvcHRpb24uaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6bGFiZWw9XCJvcHRpb24uZGVzY3JpcHRpb25cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLW9wdGlvbj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZWwtc2VsZWN0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNtYWxsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJ0ZXh0LWRhbmdlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cImVycm9ycy5jb3VudHJ5X2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMuY291bnRyeV9pZFswXVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9zbWFsbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC00XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLmRlcGFydG1lbnRfaWQgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIj5EZXBhcnRhbWVudG88L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLXNlbGVjdFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtbW9kZWw9XCJmb3JtLmRlcGFydG1lbnRfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpbHRlcmFibGVcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBAY2hhbmdlPVwiZmlsdGVyUHJvdmluY2VcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBvcHBlci1jbGFzcz1cImVsLXNlbGVjdC1kZXBhcnRtZW50c1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZHVzaz1cImRlcGFydG1lbnRfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1vcHRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1mb3I9XCJvcHRpb24gaW4gYWxsX2RlcGFydG1lbnRzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmtleT1cIm9wdGlvbi5pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDp2YWx1ZT1cIm9wdGlvbi5pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpsYWJlbD1cIm9wdGlvbi5kZXNjcmlwdGlvblwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvZWwtb3B0aW9uPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9lbC1zZWxlY3Q+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c21hbGxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInRleHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWlmPVwiZXJyb3JzLmRlcGFydG1lbnRfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtdGV4dD1cImVycm9ycy5kZXBhcnRtZW50X2lkWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTRcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJmb3JtLWdyb3VwXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cInsgJ2hhcy1kYW5nZXInOiBlcnJvcnMucHJvdmluY2VfaWQgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIj5Qcm92aW5jaWE8L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLXNlbGVjdFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtbW9kZWw9XCJmb3JtLnByb3ZpbmNlX2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWx0ZXJhYmxlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgQGNoYW5nZT1cImZpbHRlckRpc3RyaWN0XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwb3BwZXItY2xhc3M9XCJlbC1zZWxlY3QtcHJvdmluY2VzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkdXNrPVwicHJvdmluY2VfaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1vcHRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1mb3I9XCJvcHRpb24gaW4gcHJvdmluY2VzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmtleT1cIm9wdGlvbi5pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDp2YWx1ZT1cIm9wdGlvbi5pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpsYWJlbD1cIm9wdGlvbi5kZXNjcmlwdGlvblwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvZWwtb3B0aW9uPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9lbC1zZWxlY3Q+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c21hbGxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInRleHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWlmPVwiZXJyb3JzLnByb3ZpbmNlX2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMucHJvdmluY2VfaWRbMF1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvc21hbGw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwicm93XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC00XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLnByb3ZpbmNlX2lkIH1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCI+RGlzdHJpdG88L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLXNlbGVjdFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtbW9kZWw9XCJmb3JtLmRpc3RyaWN0X2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWx0ZXJhYmxlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcG9wcGVyLWNsYXNzPVwiZWwtc2VsZWN0LWRpc3RyaWN0c1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZHVzaz1cImRpc3RyaWN0X2lkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtb3B0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtZm9yPVwib3B0aW9uIGluIGRpc3RyaWN0c1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDprZXk9XCJvcHRpb24uaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6dmFsdWU9XCJvcHRpb24uaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6bGFiZWw9XCJvcHRpb24uZGVzY3JpcHRpb25cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLW9wdGlvbj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZWwtc2VsZWN0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNtYWxsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJ0ZXh0LWRhbmdlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cImVycm9ycy5kaXN0cmljdF9pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLmRpc3RyaWN0X2lkWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLThcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJmb3JtLWdyb3VwXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cInsgJ2hhcy1kYW5nZXInOiBlcnJvcnMuYWRkcmVzcyB9XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiPkRpcmVjY2nDs248L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLWlucHV0IHYtbW9kZWw9XCJmb3JtLmFkZHJlc3NcIiBkdXNrPVwiYWRkcmVzc1wiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q9XCJwcmVmaXhcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImVsLWljb24tZWRpdC1vdXRsaW5lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9pXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1pbnB1dD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwidGV4dC1kYW5nZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtaWY9XCJlcnJvcnMuYWRkcmVzc1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLmFkZHJlc3NbMF1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvc21hbGw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwicm93XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC02XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLnRlbGVwaG9uZSB9XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiPlRlbMOpZm9ubzwvbGFiZWw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtaW5wdXQgdi1tb2RlbD1cImZvcm0udGVsZXBob25lXCIgZHVzaz1cInRlbGVwaG9uZVwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q9XCJwcmVmaXhcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImVsLWljb24tZWRpdC1vdXRsaW5lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9pXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1pbnB1dD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwidGV4dC1kYW5nZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtaWY9XCJlcnJvcnMudGVsZXBob25lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMudGVsZXBob25lWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTZcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJmb3JtLWdyb3VwXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cInsgJ2hhcy1kYW5nZXInOiBlcnJvcnMuZW1haWwgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID5Db3JyZW8gZWxlY3Ryw7NuaWNvPC9sYWJlbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLWlucHV0IHYtbW9kZWw9XCJmb3JtLmVtYWlsXCIgZHVzaz1cImVtYWlsXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGlcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdD1cInByZWZpeFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2lcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLWlucHV0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNtYWxsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJ0ZXh0LWRhbmdlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cImVycm9ycy5lbWFpbFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLmVtYWlsWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cInJvd1wiPlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtNlwiIHYtaWY9XCJmb3JtLnN0YXRlXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+RXN0YWRvIGRlbCBDb250cmlidXllbnRlPC9sYWJlbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHRlbXBsYXRlIHYtaWY9XCJmb3JtLnN0YXRlID09ICdBQ1RJVk8nXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLWFsZXJ0XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDp0aXRsZT1cImAke2Zvcm0uc3RhdGV9YFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU9XCJzdWNjZXNzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2hvdy1pY29uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbG9zYWJsZT1cImZhbHNlXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1hbGVydD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvdGVtcGxhdGU+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8dGVtcGxhdGUgdi1lbHNlPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1hbGVydFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6dGl0bGU9XCJgJHtmb3JtLnN0YXRlfWBcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0eXBlPVwiZXJyb3JcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzaG93LWljb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmNsb3NhYmxlPVwiZmFsc2VcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLWFsZXJ0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPC90ZW1wbGF0ZT5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC02XCIgdi1pZj1cImZvcm0uY29uZGl0aW9uXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+Q29uZGljacOzbiBkZWwgQ29udHJpYnV5ZW50ZTwvbGFiZWxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDx0ZW1wbGF0ZSB2LWlmPVwiZm9ybS5jb25kaXRpb24gPT0gJ0hBQklETydcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtYWxlcnRcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOnRpdGxlPVwiYCR7Zm9ybS5jb25kaXRpb259YFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU9XCJzdWNjZXNzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2hvdy1pY29uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbG9zYWJsZT1cImZhbHNlXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1hbGVydD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvdGVtcGxhdGU+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8dGVtcGxhdGUgdi1lbHNlPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1hbGVydFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6dGl0bGU9XCJgJHtmb3JtLmNvbmRpdGlvbn1gXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHlwZT1cImVycm9yXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2hvdy1pY29uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbG9zYWJsZT1cImZhbHNlXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1hbGVydD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvdGVtcGxhdGU+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwicm93IG10LTJcIiB2LWlmPVwidHlwZSA9PT0gJ3N1cHBsaWVycydcIj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTYgY2VudGVyLWVsLWNoZWNrYm94XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLnBlcmNlcHRpb25fYWdlbnQgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1jaGVja2JveCB2LW1vZGVsPVwiZm9ybS5wZXJjZXB0aW9uX2FnZW50XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+wr9FcyBhZ2VudGUgZGUgcGVyY2VwY2nDs24/PC9lbC1jaGVja2JveFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjxiciAvPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNtYWxsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJ0ZXh0LWRhbmdlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cImVycm9ycy5wZXJjZXB0aW9uX2FnZW50XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMucGVyY2VwdGlvbl9hZ2VudFswXVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9zbWFsbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImNvbC1tZC02XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cInR5cGUgPT09ICdzdXBwbGllcnMnXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgdi1zaG93PVwiZm9ybS5wZXJjZXB0aW9uX2FnZW50XCJcclxuICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+UG9yY2VudGFqZSBkZSBwZXJjZXBjacOzbjwvbGFiZWxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtaW5wdXQgdi1tb2RlbD1cImZvcm0ucGVyY2VudGFnZV9wZXJjZXB0aW9uXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGlcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdD1cInByZWZpeFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2lcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLWlucHV0PlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgIDwvZGl2PlxyXG5cclxuICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInJvdyBtLXQtMTBcIlxyXG4gICAgICAgICAgICAgICAgICAgIHYtZm9yPVwiKHJvdywgaW5kZXgpIGluIGZvcm0uYWRkcmVzc2VzXCJcclxuICAgICAgICAgICAgICAgICAgICA6a2V5PVwiaW5kZXhcIlxyXG4gICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtMTJcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiIHYtaWY9XCJpbmRleCA9PT0gMFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgRGlyZWNjacOzbiBwcmluY2lwYWxcclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9sYWJlbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiIHYtZWxzZT5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIERpcmVjY2nDs24gc2VjdW5kYXJpYSAjIHt7IGluZGV4IH19XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtYnV0dG9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2l6ZT1cIm1pbmlcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGljb249XCJlbC1pY29uLW1pbnVzXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBAY2xpY2sucHJldmVudD1cImNsaWNrUmVtb3ZlQWRkcmVzcyhpbmRleClcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiYnRuLWRlZmF1bHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+RWxpbWluYXIgZGlyZWNjacOzbjwvZWwtYnV0dG9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvbGFiZWw+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cImNvbC1tZC00XCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLmNvdW50cnlfaWQgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIj5QYcOtczwvbGFiZWw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtc2VsZWN0IHYtbW9kZWw9XCJyb3cuY291bnRyeV9pZFwiIGZpbHRlcmFibGU+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLW9wdGlvblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWZvcj1cIm9wdGlvbiBpbiBjb3VudHJpZXNcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6a2V5PVwib3B0aW9uLmlkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOnZhbHVlPVwib3B0aW9uLmlkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmxhYmVsPVwib3B0aW9uLmRlc2NyaXB0aW9uXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1vcHRpb24+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2VsLXNlbGVjdD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwidGV4dC1kYW5nZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtaWY9XCJlcnJvcnMuY291bnRyeV9pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLmNvdW50cnlfaWRbMF1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvc21hbGw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtOFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImZvcm0tZ3JvdXBcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgOmNsYXNzPVwieyAnaGFzLWRhbmdlcic6IGVycm9ycy5sb2NhdGlvbl9pZCB9XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiPlViaWdlbzwvbGFiZWw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtY2FzY2FkZXJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6b3B0aW9ucz1cImxvY2F0aW9uc1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1tb2RlbD1cInJvdy5sb2NhdGlvbl9pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmNsZWFyYWJsZT1cInRydWVcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpbHRlcmFibGVcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L2VsLWNhc2NhZGVyPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNtYWxsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJ0ZXh0LWRhbmdlclwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1pZj1cImVycm9ycy5sb2NhdGlvbl9pZFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi10ZXh0PVwiZXJyb3JzLmxvY2F0aW9uX2lkWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTEyXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxkaXZcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwiZm9ybS1ncm91cFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA6Y2xhc3M9XCJ7ICdoYXMtZGFuZ2VyJzogZXJyb3JzLmFkZHJlc3MgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIj5EaXJlY2Npw7NuPC9sYWJlbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1pbnB1dCB2LW1vZGVsPVwicm93LmFkZHJlc3NcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8aVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90PVwicHJlZml4XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJlbC1pY29uLWVkaXQtb3V0bGluZVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvaVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvZWwtaW5wdXQ+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c21hbGxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInRleHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWlmPVwiZXJyb3JzLmFkZHJlc3NcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtdGV4dD1cImVycm9ycy5hZGRyZXNzWzBdXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID48L3NtYWxsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTZcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGRpdlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJmb3JtLWdyb3VwXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpjbGFzcz1cInsgJ2hhcy1kYW5nZXInOiBlcnJvcnMucGhvbmUgfVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxsYWJlbCBjbGFzcz1cImNvbnRyb2wtbGFiZWxcIj5UZWzDqWZvbm88L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGVsLWlucHV0IHYtbW9kZWw9XCJyb3cucGhvbmVcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8aVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90PVwicHJlZml4XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M9XCJlbC1pY29uLWVkaXQtb3V0bGluZVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvaVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvZWwtaW5wdXQ+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c21hbGxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cInRleHQtZGFuZ2VyXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWlmPVwiZXJyb3JzLnBob25lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LXRleHQ9XCJlcnJvcnMucGhvbmVbMF1cIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPjwvc21hbGw+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtNlwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZGl2XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImZvcm0tZ3JvdXBcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgOmNsYXNzPVwieyAnaGFzLWRhbmdlcic6IGVycm9ycy5lbWFpbCB9XCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPkNvcnJlbyBlbGVjdHLDs25pY288L2xhYmVsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtaW5wdXQgdi1tb2RlbD1cInJvdy5lbWFpbFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q9XCJwcmVmaXhcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGFzcz1cImVsLWljb24tZWRpdC1vdXRsaW5lXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9pXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9lbC1pbnB1dD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzbWFsbFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzPVwidGV4dC1kYW5nZXJcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtaWY9XCJlcnJvcnMuZW1haWxcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHYtdGV4dD1cImVycm9ycy5lbWFpbFswXVwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA+PC9zbWFsbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgIDwhLS0gPGRpdiBjbGFzcz1cInJvd1wiPlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtNFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCI+TGxlZ8OzIGRlPC9sYWJlbD5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGVsLXNlbGVjdCBjbGVhcmFibGUgdi1tb2RlbD1cImZvcm0uc29jaWFsX21lZGlhX2lkXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZWwtb3B0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1mb3I9XCIoZHRhLCBpZHgpIGluIHNvY2lhbF9tZWRpYXNcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDprZXk9XCJpZHhcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpsYWJlbD1cImR0YS5kZXNjcmlwdGlvblwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOnZhbHVlPVwiZHRhLmlkXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZWwtb3B0aW9uPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2VsLXNlbGVjdD5cclxuICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVwiY29sLW1kLTRcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgPGxhYmVsIGNsYXNzPVwiY29udHJvbC1sYWJlbFwiPkNhdCBWaXA8L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZWwtc2VsZWN0IGNsZWFyYWJsZSB2LW1vZGVsPVwiZm9ybS5zb2NpYWxfbWVkaWFfaWRcIj5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxlbC1vcHRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2LWZvcj1cIihkdGEsIGlkeCkgaW4gc29jaWFsX21lZGlhc1wiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmtleT1cImlkeFwiXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgOmxhYmVsPVwiZHRhLmRlc2NyaXB0aW9uXCJcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA6dmFsdWU9XCJkdGEuaWRcIlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9lbC1vcHRpb24+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvZWwtc2VsZWN0PlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJjb2wtbWQtNFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJjb250cm9sLWxhYmVsXCI+TWVuc3VhbGlkYWQ8L2xhYmVsPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8ZWwtaW5wdXQgY2xlYXJhYmxlIHYtbW9kZWw9XCJmb3JtLnZpcF9hbW91bnRcIiAvPlxyXG4gICAgICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICAgICAgPC9kaXY+IC0tPlxyXG4gICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgPGRpdiBjbGFzcz1cImZvcm0tYWN0aW9ucyB0ZXh0LWVuZCBwdC0yIHBiLTJcIj5cclxuICAgICAgICAgICAgICAgIDxlbC1idXR0b24gQGNsaWNrLnByZXZlbnQ9XCJjbG9zZSgpXCI+Q2FuY2VsYXI8L2VsLWJ1dHRvbj5cclxuICAgICAgICAgICAgICAgIDxlbC1idXR0b25cclxuICAgICAgICAgICAgICAgICAgICB0eXBlPVwicHJpbWFyeVwiXHJcbiAgICAgICAgICAgICAgICAgICAgbmF0aXZlLXR5cGU9XCJzdWJtaXRcIlxyXG4gICAgICAgICAgICAgICAgICAgIDpsb2FkaW5nPVwibG9hZGluZ19zdWJtaXRcIlxyXG4gICAgICAgICAgICAgICAgICAgID5HdWFyZGFyPC9lbC1idXR0b25cclxuICAgICAgICAgICAgICAgID5cclxuICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgPC9mb3JtPlxyXG4gICAgPC9lbC1kaWFsb2c+XHJcbjwvdGVtcGxhdGU+XHJcblxyXG48c2NyaXB0PlxyXG5pbXBvcnQgeyBzZXJ2aWNlTnVtYmVyIH0gZnJvbSBcIi4uLy4uL21peGlucy9mdW5jdGlvbnNcIjtcclxuXHJcbmV4cG9ydCBkZWZhdWx0IHtcclxuICAgIG1peGluczogW3NlcnZpY2VOdW1iZXJdLFxyXG4gICAgcHJvcHM6IFtcclxuICAgICAgICBcIndvcmtlclwiLFxyXG4gICAgICAgIFwic2hvd0RpYWxvZ1wiLFxyXG4gICAgICAgIFwidHlwZVwiLFxyXG4gICAgICAgIFwicmVjb3JkSWRcIixcclxuICAgICAgICBcImV4dGVybmFsXCIsXHJcbiAgICAgICAgXCJkb2N1bWVudF90eXBlX2lkXCIsXHJcbiAgICAgICAgXCJpbnB1dF9wZXJzb25cIixcclxuICAgICAgICBcInVzZXJfaWRcIlxyXG4gICAgXSxcclxuICAgIGRhdGEoKSB7XHJcbiAgICAgICAgcmV0dXJuIHtcclxuICAgICAgICAgICAgc29jaWFsX21lZGlhczogW10sXHJcbiAgICAgICAgICAgIGxvYWRpbmdfc3VibWl0OiBmYWxzZSxcclxuICAgICAgICAgICAgdGl0bGVEaWFsb2c6IG51bGwsXHJcbiAgICAgICAgICAgIHJlc291cmNlOiB0aGlzLndvcmtlciA/IFwicmVzdGF1cmFudC93b3JrZXIvcGVyc29uc1wiIDogXCJwZXJzb25zXCIsXHJcbiAgICAgICAgICAgIGVycm9yczoge30sXHJcbiAgICAgICAgICAgIGFwaV9zZXJ2aWNlX3Rva2VuOiBmYWxzZSxcclxuICAgICAgICAgICAgZm9ybToge30sXHJcbiAgICAgICAgICAgIGNvdW50cmllczogW10sXHJcbiAgICAgICAgICAgIGFsbF9kZXBhcnRtZW50czogW10sXHJcbiAgICAgICAgICAgIGFsbF9wcm92aW5jZXM6IFtdLFxyXG4gICAgICAgICAgICBhbGxfZGlzdHJpY3RzOiBbXSxcclxuICAgICAgICAgICAgcHJvdmluY2VzOiBbXSxcclxuICAgICAgICAgICAgZGlzdHJpY3RzOiBbXSxcclxuICAgICAgICAgICAgbG9jYXRpb25zOiBbXSxcclxuICAgICAgICAgICAgcGVyc29uX3R5cGVzOiBbXSxcclxuICAgICAgICAgICAgaWRlbnRpdHlfZG9jdW1lbnRfdHlwZXM6IFtdLFxyXG4gICAgICAgICAgICBhbGxfdXNlcnM6IFtdXHJcbiAgICAgICAgfTtcclxuICAgIH0sXHJcbiAgICBhc3luYyBjcmVhdGVkKCkge1xyXG4gICAgICAgIGF3YWl0IHRoaXMuaW5pdEZvcm0oKTtcclxuICAgICAgICBhd2FpdCB0aGlzLiRodHRwLmdldChgLyR7dGhpcy5yZXNvdXJjZX0vdGFibGVzYCkudGhlbihyZXNwb25zZSA9PiB7XHJcbiAgICAgICAgICAgIHRoaXMuYXBpX3NlcnZpY2VfdG9rZW4gPSByZXNwb25zZS5kYXRhLmFwaV9zZXJ2aWNlX3Rva2VuO1xyXG4gICAgICAgICAgICB0aGlzLnNvY2lhbF9tZWRpYXMgPSByZXNwb25zZS5kYXRhLnNvY2lhbF9tZWRpYTtcclxuICAgICAgICAgICAgdGhpcy5hbGxfdXNlcnMgPSByZXNwb25zZS5kYXRhLnVzZXJzO1xyXG4gICAgICAgICAgICB0aGlzLmNvdW50cmllcyA9IHJlc3BvbnNlLmRhdGEuY291bnRyaWVzO1xyXG4gICAgICAgICAgICB0aGlzLmFsbF9kZXBhcnRtZW50cyA9IHJlc3BvbnNlLmRhdGEuZGVwYXJ0bWVudHM7XHJcbiAgICAgICAgICAgIHRoaXMuYWxsX3Byb3ZpbmNlcyA9IHJlc3BvbnNlLmRhdGEucHJvdmluY2VzO1xyXG4gICAgICAgICAgICB0aGlzLmFsbF9kaXN0cmljdHMgPSByZXNwb25zZS5kYXRhLmRpc3RyaWN0cztcclxuICAgICAgICAgICAgdGhpcy5pZGVudGl0eV9kb2N1bWVudF90eXBlcyA9XHJcbiAgICAgICAgICAgICAgICByZXNwb25zZS5kYXRhLmlkZW50aXR5X2RvY3VtZW50X3R5cGVzO1xyXG4gICAgICAgICAgICB0aGlzLmxvY2F0aW9ucyA9IHJlc3BvbnNlLmRhdGEubG9jYXRpb25zO1xyXG4gICAgICAgICAgICB0aGlzLnBlcnNvbl90eXBlcyA9IHJlc3BvbnNlLmRhdGEucGVyc29uX3R5cGVzO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfSxcclxuICAgIGNvbXB1dGVkOiB7XHJcbiAgICAgICAgbWF4TGVuZ3RoOiBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgaWYgKHRoaXMuZm9ybS5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkID09PSBcIjZcIikge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIDExO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGlmICh0aGlzLmZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9PT0gXCIxXCIpIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiA4O1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgfSxcclxuICAgIG1ldGhvZHM6IHtcclxuICAgICAgICBudWV2b01ldG9kbygpIHtcclxuICAgICAgICAgICAgbGV0IGFkbWluID0gdGhpcy5hbGxfdXNlcnMuZmluZCh1c2VyID0+IHVzZXIudHlwZSA9PSBcImFkbWluXCIpO1xyXG4gICAgICAgICAgICBpZiAoYWRtaW4pIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5zZWxsZXJfaWQgPSBhZG1pbi5pZDtcclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgIGlmICh0aGlzLmFsbF91c2Vycy5sZW5ndGggIT0gMCkge1xyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5zZWxsZXJfaWQgPSB0aGlzLmFsbF91c2Vyc1swXS5pZDtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0sXHJcbiAgICAgICAgaW5pdEZvcm0oKSB7XHJcbiAgICAgICAgICAgIHRoaXMuZXJyb3JzID0ge307XHJcbiAgICAgICAgICAgIHRoaXMuZm9ybSA9IHtcclxuICAgICAgICAgICAgICAgIGlkOiBudWxsLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogdGhpcy50eXBlLFxyXG4gICAgICAgICAgICAgICAgaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZDogXCI2XCIsXHJcbiAgICAgICAgICAgICAgICBudW1iZXI6IFwiXCIsXHJcbiAgICAgICAgICAgICAgICBuYW1lOiBudWxsLFxyXG4gICAgICAgICAgICAgICAgdHJhZGVfbmFtZTogbnVsbCxcclxuICAgICAgICAgICAgICAgIGNvdW50cnlfaWQ6IFwiUEVcIixcclxuICAgICAgICAgICAgICAgIGRlcGFydG1lbnRfaWQ6IG51bGwsXHJcbiAgICAgICAgICAgICAgICBwcm92aW5jZV9pZDogbnVsbCxcclxuICAgICAgICAgICAgICAgIGRpc3RyaWN0X2lkOiBudWxsLFxyXG4gICAgICAgICAgICAgICAgYWRkcmVzczogbnVsbCxcclxuICAgICAgICAgICAgICAgIHRlbGVwaG9uZTogbnVsbCxcclxuICAgICAgICAgICAgICAgIGNvbmRpdGlvbjogbnVsbCxcclxuICAgICAgICAgICAgICAgIHN0YXRlOiBudWxsLFxyXG4gICAgICAgICAgICAgICAgZW1haWw6IG51bGwsXHJcbiAgICAgICAgICAgICAgICBwZXJjZXB0aW9uX2FnZW50OiBmYWxzZSxcclxuICAgICAgICAgICAgICAgIHBlcmNlbnRhZ2VfcGVyY2VwdGlvbjogMCxcclxuICAgICAgICAgICAgICAgIHBlcnNvbl90eXBlX2lkOiBudWxsLFxyXG4gICAgICAgICAgICAgICAgY29tbWVudDogbnVsbCxcclxuICAgICAgICAgICAgICAgIGFkZHJlc3NlczogW10sXHJcbiAgICAgICAgICAgICAgICBzZWxsZXJfaWQ6IG51bGxcclxuICAgICAgICAgICAgfTtcclxuICAgICAgICB9LFxyXG4gICAgICAgIGFzeW5jIG9wZW5lZCgpIHtcclxuICAgICAgICAgICAgLy8gdGhpcy5mb3JtLnNlbGxlcl9pZCA9IHRoaXMudXNlcl9pZDtcclxuICAgICAgICAgICAgaWYgKHRoaXMuZXh0ZXJuYWwgJiYgdGhpcy5pbnB1dF9wZXJzb24pIHtcclxuICAgICAgICAgICAgICAgIGlmIChcclxuICAgICAgICAgICAgICAgICAgICB0aGlzLmZvcm0ubnVtYmVyLmxlbmd0aCA9PT0gOCB8fFxyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5udW1iZXIubGVuZ3RoID09PSAxMVxyXG4gICAgICAgICAgICAgICAgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHRoaXMuYXBpX3NlcnZpY2VfdG9rZW4gIT0gZmFsc2UpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgYXdhaXQgdGhpcy4kZXZlbnRIdWIuJGVtaXQoXCJlbmFibGVDbGlja1NlYXJjaFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnNlYXJjaEN1c3RvbWVyKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSxcclxuICAgICAgICBjcmVhdGUoKSB7XHJcbiAgICAgICAgICAgIGlmICh0aGlzLmV4dGVybmFsKSB7XHJcbiAgICAgICAgICAgICAgICBpZiAodGhpcy5kb2N1bWVudF90eXBlX2lkID09PSBcIjAxXCIpIHtcclxuICAgICAgICAgICAgICAgICAgICB0aGlzLmZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9IFwiNlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgaWYgKHRoaXMuZG9jdW1lbnRfdHlwZV9pZCA9PT0gXCIwM1wiKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdGhpcy5mb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWQgPSBcIjFcIjtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZiAodGhpcy5pbnB1dF9wZXJzb24pIHtcclxuICAgICAgICAgICAgICAgICAgICB0aGlzLmZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9IHRoaXMuaW5wdXRfcGVyc29uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkXHJcbiAgICAgICAgICAgICAgICAgICAgICAgID8gdGhpcy5pbnB1dF9wZXJzb24uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICA6IHRoaXMuZm9ybS5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkO1xyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5udW1iZXIgPSB0aGlzLmlucHV0X3BlcnNvbi5udW1iZXJcclxuICAgICAgICAgICAgICAgICAgICAgICAgPyB0aGlzLmlucHV0X3BlcnNvbi5udW1iZXJcclxuICAgICAgICAgICAgICAgICAgICAgICAgOiBcIlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGlmICh0aGlzLnR5cGUgPT09IFwiY3VzdG9tZXJzXCIpIHtcclxuICAgICAgICAgICAgICAgIHRoaXMudGl0bGVEaWFsb2cgPSB0aGlzLnJlY29yZElkXHJcbiAgICAgICAgICAgICAgICAgICAgPyBcIkVkaXRhciBDbGllbnRlXCJcclxuICAgICAgICAgICAgICAgICAgICA6IFwiTnVldm8gQ2xpZW50ZVwiO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGlmICh0aGlzLnR5cGUgPT09IFwic3VwcGxpZXJzXCIpIHtcclxuICAgICAgICAgICAgICAgIHRoaXMudGl0bGVEaWFsb2cgPSB0aGlzLnJlY29yZElkXHJcbiAgICAgICAgICAgICAgICAgICAgPyBcIkVkaXRhciBQcm92ZWVkb3JcIlxyXG4gICAgICAgICAgICAgICAgICAgIDogXCJOdWV2byBQcm92ZWVkb3JcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYgKHRoaXMucmVjb3JkSWQpIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuJGh0dHBcclxuICAgICAgICAgICAgICAgICAgICAuZ2V0KGAvJHt0aGlzLnJlc291cmNlfS9yZWNvcmQvJHt0aGlzLnJlY29yZElkfWApXHJcbiAgICAgICAgICAgICAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLmZvcm0gPSByZXNwb25zZS5kYXRhLmRhdGE7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMuZmlsdGVyUHJvdmluY2VzKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMuZmlsdGVyRGlzdHJpY3RzKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9LFxyXG4gICAgICAgIGNsaWNrQWRkQWRkcmVzcygpIHtcclxuICAgICAgICAgICAgLyogdGhpcy5mb3JtLm1vcmVfYWRkcmVzcy5wdXNoKHtcclxuICAgICAgICAgICAgICAgICAgICBsb2NhdGlvbl9pZDogW10sXHJcbiAgICAgICAgICAgICAgICAgICAgYWRkcmVzczogbnVsbCxcclxuICAgICAgICAgICAgICAgIH0pKi9cclxuXHJcbiAgICAgICAgICAgIHRoaXMuZm9ybS5hZGRyZXNzZXMucHVzaCh7XHJcbiAgICAgICAgICAgICAgICBpZDogbnVsbCxcclxuICAgICAgICAgICAgICAgIGNvdW50cnlfaWQ6IFwiUEVcIixcclxuICAgICAgICAgICAgICAgIGxvY2F0aW9uX2lkOiBbXSxcclxuICAgICAgICAgICAgICAgIGFkZHJlc3M6IG51bGwsXHJcbiAgICAgICAgICAgICAgICBlbWFpbDogbnVsbCxcclxuICAgICAgICAgICAgICAgIHBob25lOiBudWxsLFxyXG4gICAgICAgICAgICAgICAgbWFpbjogZmFsc2VcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfSxcclxuICAgICAgICBzdWJtaXQoKSB7XHJcbiAgICAgICAgICAgIHRoaXMubnVldm9NZXRvZG8oKTtcclxuICAgICAgICAgICAgaWYgKCF0aGlzLmZvcm0uc2VsbGVyX2lkKSB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLiR0b2FzdC5lcnJvcihcIkRlYmUgc2VsZWNjaW9uYXIgdW4gYXNlc29yXCIpO1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGlmIChcclxuICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkID09IFwiNlwiICYmXHJcbiAgICAgICAgICAgICAgICB0aGlzLmZvcm0ubnVtYmVyLmxlbmd0aCAhPSAxMVxyXG4gICAgICAgICAgICApIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuJHRvYXN0LmVycm9yKFwiTGEgbG9uZ2l0dWQgZGVsIFJVQyBkZWJlIHNlciBkZSAxMVwiKTtcclxuICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBpZiAoXHJcbiAgICAgICAgICAgICAgICB0aGlzLmZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9PSBcIjFcIiAmJlxyXG4gICAgICAgICAgICAgICAgdGhpcy5mb3JtLm51bWJlci5sZW5ndGggIT0gOFxyXG4gICAgICAgICAgICApIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuJHRvYXN0LmVycm9yKFwiTGEgbG9uZ2l0dWQgZGVsIEROSSBkZWJlIHNlciBkZSA4XCIpO1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHRoaXMubG9hZGluZ19zdWJtaXQgPSB0cnVlO1xyXG4gICAgICAgICAgICB0aGlzLiRodHRwXHJcbiAgICAgICAgICAgICAgICAucG9zdChgLyR7dGhpcy5yZXNvdXJjZX1gLCB0aGlzLmZvcm0pXHJcbiAgICAgICAgICAgICAgICAudGhlbihyZXNwb25zZSA9PiB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHJlc3BvbnNlLmRhdGEuc3VjY2Vzcykge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLiR0b2FzdC5zdWNjZXNzKHJlc3BvbnNlLmRhdGEubWVzc2FnZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMuJGVtaXQoXCJhZGRfY3VzdG9tZXJcIiwgcmVzcG9uc2UuZGF0YS5pZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICh0aGlzLmV4dGVybmFsKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB0aGlzLiRldmVudEh1Yi4kZW1pdChcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBcInJlbG9hZERhdGFQZXJzb25zXCIsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmVzcG9uc2UuZGF0YS5pZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMuJGV2ZW50SHViLiRlbWl0KFwicmVsb2FkRGF0YVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLmNsb3NlKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy4kdG9hc3QuZXJyb3IocmVzcG9uc2UuZGF0YS5tZXNzYWdlKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZXJyb3IucmVzcG9uc2Uuc3RhdHVzID09PSA0MjIpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coZXJyb3IucmVzcG9uc2UuZGF0YS5lcnJvcnMpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLmVycm9ycyA9IGVycm9yLnJlc3BvbnNlLmRhdGEuZXJyb3JzO1xyXG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGVycm9yKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLnRoZW4oKCkgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMubG9hZGluZ19zdWJtaXQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0sXHJcbiAgICAgICAgY2hhbmdlSWRlbnRpdHlEb2NUeXBlKCkge1xyXG4gICAgICAgICAgICB0aGlzLnJlY29yZElkID09IG51bGwgPyB0aGlzLnNldERhdGFEZWZhdWx0Q3VzdG9tZXIoKSA6IG51bGw7XHJcbiAgICAgICAgfSxcclxuICAgICAgICBzZXREYXRhRGVmYXVsdEN1c3RvbWVyKCkge1xyXG4gICAgICAgICAgICBpZiAodGhpcy5mb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWQgPT0gXCIwXCIpIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5udW1iZXIgPSBcIjk5OTk5OTk5XCI7XHJcbiAgICAgICAgICAgICAgICB0aGlzLmZvcm0ubmFtZSA9IFwiQ2xpZW50ZXMgLSBWYXJpb3NcIjtcclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5udW1iZXIgPSBcIlwiO1xyXG4gICAgICAgICAgICAgICAgdGhpcy5mb3JtLm5hbWUgPSBudWxsO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSxcclxuICAgICAgICBjbG9zZSgpIHtcclxuICAgICAgICAgICAgdGhpcy4kZXZlbnRIdWIuJGVtaXQoXCJpbml0SW5wdXRQZXJzb25cIik7XHJcbiAgICAgICAgICAgIHRoaXMuJGVtaXQoXCJ1cGRhdGU6c2hvd0RpYWxvZ1wiLCBmYWxzZSk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5pdEZvcm0oKTtcclxuICAgICAgICB9LFxyXG4gICAgICAgIHNlYXJjaEN1c3RvbWVyKCkge1xyXG4gICAgICAgICAgICB0aGlzLnNlYXJjaFNlcnZpY2VOdW1iZXJCeVR5cGUoKTtcclxuICAgICAgICB9LFxyXG5cclxuICAgICAgICBzZWFyY2hOdW1iZXIoZGF0YSkge1xyXG4gICAgICAgICAgICB0aGlzLmZvcm0uZGlzdHJpY3RfaWQgPSBkYXRhLnViaWdlb1syXTtcclxuICAgICAgICAgICAgdGhpcy5maWx0ZXJEaXN0cmljdHMoKTtcclxuICAgICAgICAgICAgdGhpcy5mb3JtLm5hbWUgPVxyXG4gICAgICAgICAgICAgICAgdGhpcy5mb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWQgPT09IFwiMVwiXHJcbiAgICAgICAgICAgICAgICAgICAgPyBkYXRhLm5vbWJyZV9jb21wbGV0b1xyXG4gICAgICAgICAgICAgICAgICAgIDogZGF0YS5ub21icmVfb19yYXpvbl9zb2NpYWw7XHJcbiAgICAgICAgICAgIHRoaXMuZm9ybS50cmFkZV9uYW1lID1cclxuICAgICAgICAgICAgICAgIHRoaXMuZm9ybS5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkID09PSBcIjZcIlxyXG4gICAgICAgICAgICAgICAgICAgID8gZGF0YS5ub21icmVfb19yYXpvbl9zb2NpYWxcclxuICAgICAgICAgICAgICAgICAgICA6IFwiXCI7XHJcbiAgICAgICAgICAgIHRoaXMuZm9ybS5sb2NhdGlvbl9pZCA9IGRhdGEudWJpZ2VvO1xyXG4gICAgICAgICAgICB0aGlzLmZvcm0uZGVwYXJ0bWVudF9pZCA9IGRhdGEudWJpZ2VvID8gZGF0YS51YmlnZW9bMF0gOiBudWxsO1xyXG4gICAgICAgICAgICB0aGlzLmZvcm0ucHJvdmluY2VfaWQgPSBkYXRhLnViaWdlbyA/IGRhdGEudWJpZ2VvWzFdIDogbnVsbDtcclxuICAgICAgICAgICAgdGhpcy5mb3JtLmRpc3RyaWN0X2lkID0gZGF0YS51YmlnZW8gPyBkYXRhLnViaWdlb1syXSA6IG51bGw7XHJcbiAgICAgICAgICAgIHRoaXMuZmlsdGVyUHJvdmluY2VzKCk7XHJcbiAgICAgICAgICAgIHRoaXMuZmlsdGVyRGlzdHJpY3RzKCk7XHJcbiAgICAgICAgICAgIHRoaXMuZm9ybS5hZGRyZXNzID0gZGF0YS5kaXJlY2Npb247XHJcbiAgICAgICAgICAgIHRoaXMuZm9ybS5jb25kaXRpb24gPSBkYXRhLmNvbmRpY2lvbjtcclxuICAgICAgICAgICAgdGhpcy5mb3JtLnN0YXRlID0gZGF0YS5lc3RhZG87XHJcbiAgICAgICAgfSxcclxuICAgICAgICBjbGlja1JlbW92ZUFkZHJlc3MoaW5kZXgpIHtcclxuICAgICAgICAgICAgdGhpcy5mb3JtLmFkZHJlc3Nlcy5zcGxpY2UoaW5kZXgsIDEpO1xyXG4gICAgICAgIH1cclxuICAgIH1cclxufTtcclxuPC9zY3JpcHQ+XHJcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvanMvdmlld3MvcGVyc29ucy9mb3JtLnZ1ZSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue\n");
=======
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

/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_functions__["c" /* serviceNumber */]],
  props: ["worker", "showDialog", "type", "recordId", "external", "document_type_id", "input_person", "user_id"],
  data: function data() {
    return {
      social_medias: [],
      loading_submit: false,
      titleDialog: null,
      resource: this.worker ? "restaurant/worker/persons" : "persons",
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
              _context.next = 2;
              return _this.initForm();

            case 2:
              _context.next = 4;
              return _this.$http.get("/".concat(_this.resource, "/tables")).then(function (response) {
                _this.api_service_token = response.data.api_service_token;
                _this.social_medias = response.data.social_media;
                _this.all_users = response.data.users;
                _this.countries = response.data.countries;
                _this.all_departments = response.data.departments;
                _this.all_provinces = response.data.provinces;
                _this.all_districts = response.data.districts;
                _this.identity_document_types = response.data.identity_document_types;
                _this.locations = response.data.locations;
                _this.person_types = response.data.person_types;
              });

            case 4:
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
        this.titleDialog = 'Nuevo Cliente';
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
>>>>>>> master

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7cc91674\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

<<<<<<< HEAD
eval("var render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\n    \"el-dialog\",\n    {\n      attrs: {\n        title: _vm.titleDialog,\n        visible: _vm.showDialog,\n        \"append-to-body\": \"\",\n        \"close-on-click-modal\": false\n      },\n      on: { close: _vm.close, open: _vm.create, opened: _vm.opened }\n    },\n    [\n      _c(\n        \"form\",\n        {\n          attrs: { autocomplete: \"off\" },\n          on: {\n            submit: function($event) {\n              $event.preventDefault()\n              return _vm.submit.apply(null, arguments)\n            }\n          }\n        },\n        [\n          _c(\n            \"div\",\n            { staticClass: \"form-body\" },\n            [\n              _c(\"div\", { staticClass: \"row\" }, [\n                _c(\"div\", { staticClass: \"col-md-6\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: {\n                        \"has-danger\": _vm.errors.identity_document_type_id\n                      }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\n                          \"Tipo Doc. Identidad\\n                            \"\n                        ),\n                        _c(\"span\", { staticClass: \"text-danger\" }, [\n                          _vm._v(\"*\")\n                        ])\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-select\",\n                        {\n                          attrs: {\n                            filterable: \"\",\n                            \"popper-class\": \"el-select-identity_document_type\",\n                            dusk: \"identity_document_type_id\"\n                          },\n                          on: { change: _vm.changeIdentityDocType },\n                          model: {\n                            value: _vm.form.identity_document_type_id,\n                            callback: function($$v) {\n                              _vm.$set(\n                                _vm.form,\n                                \"identity_document_type_id\",\n                                $$v\n                              )\n                            },\n                            expression: \"form.identity_document_type_id\"\n                          }\n                        },\n                        _vm._l(_vm.identity_document_types, function(option) {\n                          return _c(\"el-option\", {\n                            key: option.id,\n                            attrs: {\n                              value: option.id,\n                              label: option.description\n                            }\n                          })\n                        }),\n                        1\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.identity_document_type_id\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(\n                                _vm.errors.identity_document_type_id[0]\n                              )\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"col-md-6\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.number }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Número\\n                            \"),\n                        _c(\"span\", { staticClass: \"text-danger\" }, [\n                          _vm._v(\"*\")\n                        ])\n                      ]),\n                      _vm._v(\" \"),\n                      _vm.api_service_token != false\n                        ? _c(\n                            \"div\",\n                            [\n                              _c(\"x-input-service\", {\n                                attrs: {\n                                  identity_document_type_id:\n                                    _vm.form.identity_document_type_id\n                                },\n                                on: { search: _vm.searchNumber },\n                                model: {\n                                  value: _vm.form.number,\n                                  callback: function($$v) {\n                                    _vm.$set(_vm.form, \"number\", $$v)\n                                  },\n                                  expression: \"form.number\"\n                                }\n                              })\n                            ],\n                            1\n                          )\n                        : _c(\n                            \"div\",\n                            [\n                              _c(\n                                \"el-input\",\n                                {\n                                  attrs: {\n                                    maxlength: _vm.maxLength,\n                                    dusk: \"number\"\n                                  },\n                                  model: {\n                                    value: _vm.form.number,\n                                    callback: function($$v) {\n                                      _vm.$set(_vm.form, \"number\", $$v)\n                                    },\n                                    expression: \"form.number\"\n                                  }\n                                },\n                                [\n                                  _vm.form.identity_document_type_id === \"6\" ||\n                                  _vm.form.identity_document_type_id === \"1\"\n                                    ? [\n                                        _c(\"el-button\", {\n                                          attrs: {\n                                            slot: \"append\",\n                                            type: \"primary\",\n                                            loading: _vm.loading_search,\n                                            icon: \"el-icon-search\"\n                                          },\n                                          on: {\n                                            click: function($event) {\n                                              $event.preventDefault()\n                                              return _vm.searchCustomer.apply(\n                                                null,\n                                                arguments\n                                              )\n                                            }\n                                          },\n                                          slot: \"append\"\n                                        })\n                                      ]\n                                    : _vm._e(),\n                                  _vm._v(\" \"),\n                                  _c(\"i\", {\n                                    staticClass: \"el-icon-edit-outline\",\n                                    attrs: { slot: \"prefix\" },\n                                    slot: \"prefix\"\n                                  })\n                                ],\n                                2\n                              )\n                            ],\n                            1\n                          ),\n                      _vm._v(\" \"),\n                      _vm.errors.number\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.number[0])\n                            }\n                          })\n                        : _vm._e()\n                    ]\n                  )\n                ])\n              ]),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"row\" }, [\n                _c(\"div\", { staticClass: \"col-md-6\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.name }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Nombre\\n                            \"),\n                        _c(\"span\", { staticClass: \"text-danger\" }, [\n                          _vm._v(\"*\")\n                        ])\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-input\",\n                        {\n                          attrs: { dusk: \"name\" },\n                          model: {\n                            value: _vm.form.name,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"name\", $$v)\n                            },\n                            expression: \"form.name\"\n                          }\n                        },\n                        [\n                          _c(\"i\", {\n                            staticClass: \"el-icon-edit-outline\",\n                            attrs: { slot: \"prefix\" },\n                            slot: \"prefix\"\n                          })\n                        ]\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.name\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.name[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"col-md-6\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.trade_name }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Nombre comercial\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-input\",\n                        {\n                          attrs: { dusk: \"trade_name\" },\n                          model: {\n                            value: _vm.form.trade_name,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"trade_name\", $$v)\n                            },\n                            expression: \"form.trade_name\"\n                          }\n                        },\n                        [\n                          _c(\"i\", {\n                            staticClass: \"el-icon-edit-outline\",\n                            attrs: { slot: \"prefix\" },\n                            slot: \"prefix\"\n                          })\n                        ]\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.trade_name\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.trade_name[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ])\n              ]),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"row\" }, [\n                _c(\"div\", { staticClass: \"col-md-4\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.country_id }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"País\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-select\",\n                        {\n                          attrs: { filterable: \"\", dusk: \"country_id\" },\n                          model: {\n                            value: _vm.form.country_id,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"country_id\", $$v)\n                            },\n                            expression: \"form.country_id\"\n                          }\n                        },\n                        _vm._l(_vm.countries, function(option) {\n                          return _c(\"el-option\", {\n                            key: option.id,\n                            attrs: {\n                              value: option.id,\n                              label: option.description\n                            }\n                          })\n                        }),\n                        1\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.country_id\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.country_id[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"col-md-4\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.department_id }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Departamento\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-select\",\n                        {\n                          attrs: {\n                            filterable: \"\",\n                            \"popper-class\": \"el-select-departments\",\n                            dusk: \"department_id\"\n                          },\n                          on: { change: _vm.filterProvince },\n                          model: {\n                            value: _vm.form.department_id,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"department_id\", $$v)\n                            },\n                            expression: \"form.department_id\"\n                          }\n                        },\n                        _vm._l(_vm.all_departments, function(option) {\n                          return _c(\"el-option\", {\n                            key: option.id,\n                            attrs: {\n                              value: option.id,\n                              label: option.description\n                            }\n                          })\n                        }),\n                        1\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.department_id\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.department_id[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"col-md-4\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.province_id }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Provincia\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-select\",\n                        {\n                          attrs: {\n                            filterable: \"\",\n                            \"popper-class\": \"el-select-provinces\",\n                            dusk: \"province_id\"\n                          },\n                          on: { change: _vm.filterDistrict },\n                          model: {\n                            value: _vm.form.province_id,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"province_id\", $$v)\n                            },\n                            expression: \"form.province_id\"\n                          }\n                        },\n                        _vm._l(_vm.provinces, function(option) {\n                          return _c(\"el-option\", {\n                            key: option.id,\n                            attrs: {\n                              value: option.id,\n                              label: option.description\n                            }\n                          })\n                        }),\n                        1\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.province_id\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.province_id[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ])\n              ]),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"row\" }, [\n                _c(\"div\", { staticClass: \"col-md-4\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.province_id }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Distrito\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-select\",\n                        {\n                          attrs: {\n                            filterable: \"\",\n                            \"popper-class\": \"el-select-districts\",\n                            dusk: \"district_id\"\n                          },\n                          model: {\n                            value: _vm.form.district_id,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"district_id\", $$v)\n                            },\n                            expression: \"form.district_id\"\n                          }\n                        },\n                        _vm._l(_vm.districts, function(option) {\n                          return _c(\"el-option\", {\n                            key: option.id,\n                            attrs: {\n                              value: option.id,\n                              label: option.description\n                            }\n                          })\n                        }),\n                        1\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.district_id\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.district_id[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"col-md-8\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.address }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Dirección\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-input\",\n                        {\n                          attrs: { dusk: \"address\" },\n                          model: {\n                            value: _vm.form.address,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"address\", $$v)\n                            },\n                            expression: \"form.address\"\n                          }\n                        },\n                        [\n                          _c(\"i\", {\n                            staticClass: \"el-icon-edit-outline\",\n                            attrs: { slot: \"prefix\" },\n                            slot: \"prefix\"\n                          })\n                        ]\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.address\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.address[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ])\n              ]),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"row\" }, [\n                _c(\"div\", { staticClass: \"col-md-6\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.telephone }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Teléfono\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-input\",\n                        {\n                          attrs: { dusk: \"telephone\" },\n                          model: {\n                            value: _vm.form.telephone,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"telephone\", $$v)\n                            },\n                            expression: \"form.telephone\"\n                          }\n                        },\n                        [\n                          _c(\"i\", {\n                            staticClass: \"el-icon-edit-outline\",\n                            attrs: { slot: \"prefix\" },\n                            slot: \"prefix\"\n                          })\n                        ]\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.telephone\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.telephone[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"col-md-6\" }, [\n                  _c(\n                    \"div\",\n                    {\n                      staticClass: \"form-group\",\n                      class: { \"has-danger\": _vm.errors.email }\n                    },\n                    [\n                      _c(\"label\", { staticClass: \"control-label\" }, [\n                        _vm._v(\"Correo electrónico\")\n                      ]),\n                      _vm._v(\" \"),\n                      _c(\n                        \"el-input\",\n                        {\n                          attrs: { dusk: \"email\" },\n                          model: {\n                            value: _vm.form.email,\n                            callback: function($$v) {\n                              _vm.$set(_vm.form, \"email\", $$v)\n                            },\n                            expression: \"form.email\"\n                          }\n                        },\n                        [\n                          _c(\"i\", {\n                            staticClass: \"el-icon-edit-outline\",\n                            attrs: { slot: \"prefix\" },\n                            slot: \"prefix\"\n                          })\n                        ]\n                      ),\n                      _vm._v(\" \"),\n                      _vm.errors.email\n                        ? _c(\"small\", {\n                            staticClass: \"text-danger\",\n                            domProps: {\n                              textContent: _vm._s(_vm.errors.email[0])\n                            }\n                          })\n                        : _vm._e()\n                    ],\n                    1\n                  )\n                ])\n              ]),\n              _vm._v(\" \"),\n              _c(\"div\", { staticClass: \"row\" }, [\n                _vm.form.state\n                  ? _c(\"div\", { staticClass: \"col-md-6\" }, [\n                      _c(\n                        \"div\",\n                        { staticClass: \"form-group\" },\n                        [\n                          _c(\"label\", { staticClass: \"control-label\" }, [\n                            _vm._v(\"Estado del Contribuyente\")\n                          ]),\n                          _vm._v(\" \"),\n                          _vm.form.state == \"ACTIVO\"\n                            ? [\n                                _c(\"el-alert\", {\n                                  attrs: {\n                                    title: \"\" + _vm.form.state,\n                                    type: \"success\",\n                                    \"show-icon\": \"\",\n                                    closable: false\n                                  }\n                                })\n                              ]\n                            : [\n                                _c(\"el-alert\", {\n                                  attrs: {\n                                    title: \"\" + _vm.form.state,\n                                    type: \"error\",\n                                    \"show-icon\": \"\",\n                                    closable: false\n                                  }\n                                })\n                              ]\n                        ],\n                        2\n                      )\n                    ])\n                  : _vm._e(),\n                _vm._v(\" \"),\n                _vm.form.condition\n                  ? _c(\"div\", { staticClass: \"col-md-6\" }, [\n                      _c(\n                        \"div\",\n                        { staticClass: \"form-group\" },\n                        [\n                          _c(\"label\", { staticClass: \"control-label\" }, [\n                            _vm._v(\"Condición del Contribuyente\")\n                          ]),\n                          _vm._v(\" \"),\n                          _vm.form.condition == \"HABIDO\"\n                            ? [\n                                _c(\"el-alert\", {\n                                  attrs: {\n                                    title: \"\" + _vm.form.condition,\n                                    type: \"success\",\n                                    \"show-icon\": \"\",\n                                    closable: false\n                                  }\n                                })\n                              ]\n                            : [\n                                _c(\"el-alert\", {\n                                  attrs: {\n                                    title: \"\" + _vm.form.condition,\n                                    type: \"error\",\n                                    \"show-icon\": \"\",\n                                    closable: false\n                                  }\n                                })\n                              ]\n                        ],\n                        2\n                      )\n                    ])\n                  : _vm._e()\n              ]),\n              _vm._v(\" \"),\n              _vm.type === \"suppliers\"\n                ? _c(\"div\", { staticClass: \"row mt-2\" }, [\n                    _c(\"div\", { staticClass: \"col-md-6 center-el-checkbox\" }, [\n                      _c(\n                        \"div\",\n                        {\n                          staticClass: \"form-group\",\n                          class: { \"has-danger\": _vm.errors.perception_agent }\n                        },\n                        [\n                          _c(\n                            \"el-checkbox\",\n                            {\n                              model: {\n                                value: _vm.form.perception_agent,\n                                callback: function($$v) {\n                                  _vm.$set(_vm.form, \"perception_agent\", $$v)\n                                },\n                                expression: \"form.perception_agent\"\n                              }\n                            },\n                            [_vm._v(\"¿Es agente de percepción?\")]\n                          ),\n                          _c(\"br\"),\n                          _vm._v(\" \"),\n                          _vm.errors.perception_agent\n                            ? _c(\"small\", {\n                                staticClass: \"text-danger\",\n                                domProps: {\n                                  textContent: _vm._s(\n                                    _vm.errors.perception_agent[0]\n                                  )\n                                }\n                              })\n                            : _vm._e()\n                        ],\n                        1\n                      )\n                    ]),\n                    _vm._v(\" \"),\n                    _vm.type === \"suppliers\"\n                      ? _c(\n                          \"div\",\n                          {\n                            directives: [\n                              {\n                                name: \"show\",\n                                rawName: \"v-show\",\n                                value: _vm.form.perception_agent,\n                                expression: \"form.perception_agent\"\n                              }\n                            ],\n                            staticClass: \"col-md-6\"\n                          },\n                          [\n                            _c(\n                              \"div\",\n                              { staticClass: \"form-group\" },\n                              [\n                                _c(\"label\", { staticClass: \"control-label\" }, [\n                                  _vm._v(\"Porcentaje de percepción\")\n                                ]),\n                                _vm._v(\" \"),\n                                _c(\n                                  \"el-input\",\n                                  {\n                                    model: {\n                                      value: _vm.form.percentage_perception,\n                                      callback: function($$v) {\n                                        _vm.$set(\n                                          _vm.form,\n                                          \"percentage_perception\",\n                                          $$v\n                                        )\n                                      },\n                                      expression: \"form.percentage_perception\"\n                                    }\n                                  },\n                                  [\n                                    _c(\"i\", {\n                                      staticClass: \"el-icon-edit-outline\",\n                                      attrs: { slot: \"prefix\" },\n                                      slot: \"prefix\"\n                                    })\n                                  ]\n                                )\n                              ],\n                              1\n                            )\n                          ]\n                        )\n                      : _vm._e()\n                  ])\n                : _vm._e(),\n              _vm._v(\" \"),\n              _vm._l(_vm.form.addresses, function(row, index) {\n                return _c(\"div\", { key: index, staticClass: \"row m-t-10\" }, [\n                  _c(\"div\", { staticClass: \"col-md-12\" }, [\n                    index === 0\n                      ? _c(\"label\", { staticClass: \"control-label\" }, [\n                          _vm._v(\n                            \"\\n                        Dirección principal\\n                    \"\n                          )\n                        ])\n                      : _c(\n                          \"label\",\n                          { staticClass: \"control-label\" },\n                          [\n                            _vm._v(\n                              \"\\n                        Dirección secundaria # \" +\n                                _vm._s(index) +\n                                \"\\n                        \"\n                            ),\n                            _c(\n                              \"el-button\",\n                              {\n                                staticClass: \"btn-default-danger\",\n                                attrs: { size: \"mini\", icon: \"el-icon-minus\" },\n                                on: {\n                                  click: function($event) {\n                                    $event.preventDefault()\n                                    return _vm.clickRemoveAddress(index)\n                                  }\n                                }\n                              },\n                              [_vm._v(\"Eliminar dirección\")]\n                            )\n                          ],\n                          1\n                        )\n                  ]),\n                  _vm._v(\" \"),\n                  _c(\"div\", { staticClass: \"col-md-4\" }, [\n                    _c(\n                      \"div\",\n                      {\n                        staticClass: \"form-group\",\n                        class: { \"has-danger\": _vm.errors.country_id }\n                      },\n                      [\n                        _c(\"label\", { staticClass: \"control-label\" }, [\n                          _vm._v(\"País\")\n                        ]),\n                        _vm._v(\" \"),\n                        _c(\n                          \"el-select\",\n                          {\n                            attrs: { filterable: \"\" },\n                            model: {\n                              value: row.country_id,\n                              callback: function($$v) {\n                                _vm.$set(row, \"country_id\", $$v)\n                              },\n                              expression: \"row.country_id\"\n                            }\n                          },\n                          _vm._l(_vm.countries, function(option) {\n                            return _c(\"el-option\", {\n                              key: option.id,\n                              attrs: {\n                                value: option.id,\n                                label: option.description\n                              }\n                            })\n                          }),\n                          1\n                        ),\n                        _vm._v(\" \"),\n                        _vm.errors.country_id\n                          ? _c(\"small\", {\n                              staticClass: \"text-danger\",\n                              domProps: {\n                                textContent: _vm._s(_vm.errors.country_id[0])\n                              }\n                            })\n                          : _vm._e()\n                      ],\n                      1\n                    )\n                  ]),\n                  _vm._v(\" \"),\n                  _c(\"div\", { staticClass: \"col-md-8\" }, [\n                    _c(\n                      \"div\",\n                      {\n                        staticClass: \"form-group\",\n                        class: { \"has-danger\": _vm.errors.location_id }\n                      },\n                      [\n                        _c(\"label\", { staticClass: \"control-label\" }, [\n                          _vm._v(\"Ubigeo\")\n                        ]),\n                        _vm._v(\" \"),\n                        _c(\"el-cascader\", {\n                          attrs: {\n                            options: _vm.locations,\n                            clearable: true,\n                            filterable: \"\"\n                          },\n                          model: {\n                            value: row.location_id,\n                            callback: function($$v) {\n                              _vm.$set(row, \"location_id\", $$v)\n                            },\n                            expression: \"row.location_id\"\n                          }\n                        }),\n                        _vm._v(\" \"),\n                        _vm.errors.location_id\n                          ? _c(\"small\", {\n                              staticClass: \"text-danger\",\n                              domProps: {\n                                textContent: _vm._s(_vm.errors.location_id[0])\n                              }\n                            })\n                          : _vm._e()\n                      ],\n                      1\n                    )\n                  ]),\n                  _vm._v(\" \"),\n                  _c(\"div\", { staticClass: \"col-md-12\" }, [\n                    _c(\n                      \"div\",\n                      {\n                        staticClass: \"form-group\",\n                        class: { \"has-danger\": _vm.errors.address }\n                      },\n                      [\n                        _c(\"label\", { staticClass: \"control-label\" }, [\n                          _vm._v(\"Dirección\")\n                        ]),\n                        _vm._v(\" \"),\n                        _c(\n                          \"el-input\",\n                          {\n                            model: {\n                              value: row.address,\n                              callback: function($$v) {\n                                _vm.$set(row, \"address\", $$v)\n                              },\n                              expression: \"row.address\"\n                            }\n                          },\n                          [\n                            _c(\"i\", {\n                              staticClass: \"el-icon-edit-outline\",\n                              attrs: { slot: \"prefix\" },\n                              slot: \"prefix\"\n                            })\n                          ]\n                        ),\n                        _vm._v(\" \"),\n                        _vm.errors.address\n                          ? _c(\"small\", {\n                              staticClass: \"text-danger\",\n                              domProps: {\n                                textContent: _vm._s(_vm.errors.address[0])\n                              }\n                            })\n                          : _vm._e()\n                      ],\n                      1\n                    )\n                  ]),\n                  _vm._v(\" \"),\n                  _c(\"div\", { staticClass: \"col-md-6\" }, [\n                    _c(\n                      \"div\",\n                      {\n                        staticClass: \"form-group\",\n                        class: { \"has-danger\": _vm.errors.phone }\n                      },\n                      [\n                        _c(\"label\", { staticClass: \"control-label\" }, [\n                          _vm._v(\"Teléfono\")\n                        ]),\n                        _vm._v(\" \"),\n                        _c(\n                          \"el-input\",\n                          {\n                            model: {\n                              value: row.phone,\n                              callback: function($$v) {\n                                _vm.$set(row, \"phone\", $$v)\n                              },\n                              expression: \"row.phone\"\n                            }\n                          },\n                          [\n                            _c(\"i\", {\n                              staticClass: \"el-icon-edit-outline\",\n                              attrs: { slot: \"prefix\" },\n                              slot: \"prefix\"\n                            })\n                          ]\n                        ),\n                        _vm._v(\" \"),\n                        _vm.errors.phone\n                          ? _c(\"small\", {\n                              staticClass: \"text-danger\",\n                              domProps: {\n                                textContent: _vm._s(_vm.errors.phone[0])\n                              }\n                            })\n                          : _vm._e()\n                      ],\n                      1\n                    )\n                  ]),\n                  _vm._v(\" \"),\n                  _c(\"div\", { staticClass: \"col-md-6\" }, [\n                    _c(\n                      \"div\",\n                      {\n                        staticClass: \"form-group\",\n                        class: { \"has-danger\": _vm.errors.email }\n                      },\n                      [\n                        _c(\"label\", { staticClass: \"control-label\" }, [\n                          _vm._v(\"Correo electrónico\")\n                        ]),\n                        _vm._v(\" \"),\n                        _c(\n                          \"el-input\",\n                          {\n                            model: {\n                              value: row.email,\n                              callback: function($$v) {\n                                _vm.$set(row, \"email\", $$v)\n                              },\n                              expression: \"row.email\"\n                            }\n                          },\n                          [\n                            _c(\"i\", {\n                              staticClass: \"el-icon-edit-outline\",\n                              attrs: { slot: \"prefix\" },\n                              slot: \"prefix\"\n                            })\n                          ]\n                        ),\n                        _vm._v(\" \"),\n                        _vm.errors.email\n                          ? _c(\"small\", {\n                              staticClass: \"text-danger\",\n                              domProps: {\n                                textContent: _vm._s(_vm.errors.email[0])\n                              }\n                            })\n                          : _vm._e()\n                      ],\n                      1\n                    )\n                  ])\n                ])\n              })\n            ],\n            2\n          ),\n          _vm._v(\" \"),\n          _c(\n            \"div\",\n            { staticClass: \"form-actions text-end pt-2 pb-2\" },\n            [\n              _c(\n                \"el-button\",\n                {\n                  on: {\n                    click: function($event) {\n                      $event.preventDefault()\n                      return _vm.close()\n                    }\n                  }\n                },\n                [_vm._v(\"Cancelar\")]\n              ),\n              _vm._v(\" \"),\n              _c(\n                \"el-button\",\n                {\n                  attrs: {\n                    type: \"primary\",\n                    \"native-type\": \"submit\",\n                    loading: _vm.loading_submit\n                  }\n                },\n                [_vm._v(\"Guardar\")]\n              )\n            ],\n            1\n          )\n        ]\n      )\n    ]\n  )\n}\nvar staticRenderFns = []\nrender._withStripped = true\nmodule.exports = { render: render, staticRenderFns: staticRenderFns }\nif (false) {\n  module.hot.accept()\n  if (module.hot.data) {\n    require(\"vue-hot-reload-api\")      .rerender(\"data-v-7cc91674\", module.exports)\n  }\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdmlld3MvcGVyc29ucy9mb3JtLnZ1ZT9mOTRmIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUCxXQUFXO0FBQ1gsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0Esa0JBQWtCLHNCQUFzQjtBQUN4QztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBO0FBQ0EsYUFBYSwyQkFBMkI7QUFDeEM7QUFDQSx5QkFBeUIscUJBQXFCO0FBQzlDLDJCQUEyQiwwQkFBMEI7QUFDckQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxxQkFBcUI7QUFDckI7QUFDQSxtQ0FBbUMsK0JBQStCO0FBQ2xFO0FBQ0E7QUFDQTtBQUNBLG9DQUFvQyw2QkFBNkI7QUFDakU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQiwrQkFBK0Isb0NBQW9DO0FBQ25FO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBLHlCQUF5QjtBQUN6QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQix5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkIsMEJBQTBCO0FBQ3JEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsOEJBQThCO0FBQzlCLHFCQUFxQjtBQUNyQjtBQUNBLG1DQUFtQywrQkFBK0I7QUFDbEU7QUFDQSxvQ0FBb0MsNkJBQTZCO0FBQ2pFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlDQUFpQztBQUNqQyxxQ0FBcUMsMkJBQTJCO0FBQ2hFO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsbUNBQW1DO0FBQ25DO0FBQ0E7QUFDQSwrQkFBK0I7QUFDL0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsbUNBQW1DO0FBQ25DO0FBQ0E7QUFDQTtBQUNBO0FBQ0EscUNBQXFDO0FBQ3JDO0FBQ0E7QUFDQSxpQ0FBaUM7QUFDakM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQ0FBMkM7QUFDM0M7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJDQUEyQztBQUMzQztBQUNBLHlDQUF5QztBQUN6QztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNENBQTRDLGlCQUFpQjtBQUM3RDtBQUNBLG1DQUFtQztBQUNuQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBeUIscUJBQXFCO0FBQzlDLDJCQUEyQiwwQkFBMEI7QUFDckQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw4QkFBOEI7QUFDOUIscUJBQXFCO0FBQ3JCO0FBQ0EsbUNBQW1DLCtCQUErQjtBQUNsRTtBQUNBLG9DQUFvQyw2QkFBNkI7QUFDakU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxrQ0FBa0MsZUFBZTtBQUNqRDtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QjtBQUM3QjtBQUNBO0FBQ0EseUJBQXlCO0FBQ3pCO0FBQ0E7QUFDQTtBQUNBLG9DQUFvQyxpQkFBaUI7QUFDckQ7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQiwwQkFBMEI7QUFDckQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw4QkFBOEI7QUFDOUIscUJBQXFCO0FBQ3JCO0FBQ0EsbUNBQW1DLCtCQUErQjtBQUNsRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxrQ0FBa0MscUJBQXFCO0FBQ3ZEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQSx5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0Esb0NBQW9DLGlCQUFpQjtBQUNyRDtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBeUIscUJBQXFCO0FBQzlDLDJCQUEyQiwwQkFBMEI7QUFDckQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw4QkFBOEI7QUFDOUIscUJBQXFCO0FBQ3JCO0FBQ0EsbUNBQW1DLCtCQUErQjtBQUNsRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxrQ0FBa0MscUNBQXFDO0FBQ3ZFO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQSx5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0IseUJBQXlCO0FBQ3pCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkIsMEJBQTBCO0FBQ3JEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsOEJBQThCO0FBQzlCLHFCQUFxQjtBQUNyQjtBQUNBLG1DQUFtQywrQkFBK0I7QUFDbEU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0IsK0JBQStCLDZCQUE2QjtBQUM1RDtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QjtBQUM3QjtBQUNBO0FBQ0EseUJBQXlCO0FBQ3pCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCLHlCQUF5QjtBQUN6QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCLDBCQUEwQjtBQUNyRDtBQUNBO0FBQ0E7QUFDQTtBQUNBLDhCQUE4QjtBQUM5QixxQkFBcUI7QUFDckI7QUFDQSxtQ0FBbUMsK0JBQStCO0FBQ2xFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCLCtCQUErQiw2QkFBNkI7QUFDNUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBLHlCQUF5QjtBQUN6QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQix5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EseUJBQXlCLHFCQUFxQjtBQUM5QywyQkFBMkIsMEJBQTBCO0FBQ3JEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsOEJBQThCO0FBQzlCLHFCQUFxQjtBQUNyQjtBQUNBLG1DQUFtQywrQkFBK0I7QUFDbEU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBLHlCQUF5QjtBQUN6QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQix5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQiwwQkFBMEI7QUFDckQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw4QkFBOEI7QUFDOUIscUJBQXFCO0FBQ3JCO0FBQ0EsbUNBQW1DLCtCQUErQjtBQUNsRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxrQ0FBa0Msa0JBQWtCO0FBQ3BEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQSx5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0Esb0NBQW9DLGlCQUFpQjtBQUNyRDtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBeUIscUJBQXFCO0FBQzlDLDJCQUEyQiwwQkFBMEI7QUFDckQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw4QkFBOEI7QUFDOUIscUJBQXFCO0FBQ3JCO0FBQ0EsbUNBQW1DLCtCQUErQjtBQUNsRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxrQ0FBa0Msb0JBQW9CO0FBQ3REO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQSx5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0Esb0NBQW9DLGlCQUFpQjtBQUNyRDtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsMkJBQTJCLDBCQUEwQjtBQUNyRDtBQUNBO0FBQ0E7QUFDQTtBQUNBLDhCQUE4QjtBQUM5QixxQkFBcUI7QUFDckI7QUFDQSxtQ0FBbUMsK0JBQStCO0FBQ2xFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGtDQUFrQyxnQkFBZ0I7QUFDbEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBLHlCQUF5QjtBQUN6QjtBQUNBO0FBQ0E7QUFDQSxvQ0FBb0MsaUJBQWlCO0FBQ3JEO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLHlCQUF5QixxQkFBcUI7QUFDOUM7QUFDQSwrQkFBK0IsMEJBQTBCO0FBQ3pEO0FBQ0E7QUFDQSx5QkFBeUIsNEJBQTRCO0FBQ3JEO0FBQ0EsdUNBQXVDLCtCQUErQjtBQUN0RTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpQ0FBaUM7QUFDakM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsaUNBQWlDO0FBQ2pDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwrQkFBK0IsMEJBQTBCO0FBQ3pEO0FBQ0E7QUFDQSx5QkFBeUIsNEJBQTRCO0FBQ3JEO0FBQ0EsdUNBQXVDLCtCQUErQjtBQUN0RTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpQ0FBaUM7QUFDakM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsaUNBQWlDO0FBQ2pDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QiwwQkFBMEI7QUFDdkQsK0JBQStCLDZDQUE2QztBQUM1RTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGtDQUFrQztBQUNsQyx5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlDQUFpQztBQUNqQztBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLCtCQUErQjtBQUMvQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQSwrQkFBK0IsNEJBQTRCO0FBQzNEO0FBQ0EsNkNBQTZDLCtCQUErQjtBQUM1RTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsdUNBQXVDO0FBQ3ZDO0FBQ0E7QUFDQSxtQ0FBbUM7QUFDbkM7QUFDQTtBQUNBO0FBQ0EsOENBQThDLGlCQUFpQjtBQUMvRDtBQUNBLHFDQUFxQztBQUNyQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxrQ0FBa0Msd0NBQXdDO0FBQzFFLDZCQUE2QiwyQkFBMkI7QUFDeEQ7QUFDQSxxQ0FBcUMsK0JBQStCO0FBQ3BFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQiwrQkFBK0I7QUFDMUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx3Q0FBd0Msc0NBQXNDO0FBQzlFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLCtCQUErQjtBQUMvQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QiwwQkFBMEI7QUFDdkQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSxnQ0FBZ0M7QUFDaEMsdUJBQXVCO0FBQ3ZCO0FBQ0EscUNBQXFDLCtCQUErQjtBQUNwRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxvQ0FBb0MsaUJBQWlCO0FBQ3JEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsK0JBQStCO0FBQy9CO0FBQ0E7QUFDQSwyQkFBMkI7QUFDM0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSw2QkFBNkI7QUFDN0IsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QjtBQUM3QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSw2QkFBNkIsMEJBQTBCO0FBQ3ZEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsZ0NBQWdDO0FBQ2hDLHVCQUF1QjtBQUN2QjtBQUNBLHFDQUFxQywrQkFBK0I7QUFDcEU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QjtBQUM3QjtBQUNBO0FBQ0EseUJBQXlCO0FBQ3pCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QiwyQkFBMkI7QUFDeEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSxnQ0FBZ0M7QUFDaEMsdUJBQXVCO0FBQ3ZCO0FBQ0EscUNBQXFDLCtCQUErQjtBQUNwRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLCtCQUErQjtBQUMvQjtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBLHNDQUFzQyxpQkFBaUI7QUFDdkQ7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QiwwQkFBMEI7QUFDdkQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSxnQ0FBZ0M7QUFDaEMsdUJBQXVCO0FBQ3ZCO0FBQ0EscUNBQXFDLCtCQUErQjtBQUNwRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLCtCQUErQjtBQUMvQjtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBLHNDQUFzQyxpQkFBaUI7QUFDdkQ7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDZCQUE2QiwwQkFBMEI7QUFDdkQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSxnQ0FBZ0M7QUFDaEMsdUJBQXVCO0FBQ3ZCO0FBQ0EscUNBQXFDLCtCQUErQjtBQUNwRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLCtCQUErQjtBQUMvQjtBQUNBO0FBQ0EsMkJBQTJCO0FBQzNCO0FBQ0E7QUFDQTtBQUNBLHNDQUFzQyxpQkFBaUI7QUFDdkQ7QUFDQSw2QkFBNkI7QUFDN0I7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsNkJBQTZCO0FBQzdCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGVBQWU7QUFDZjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxhQUFhLGlEQUFpRDtBQUM5RDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlCQUFpQjtBQUNqQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsaUJBQWlCO0FBQ2pCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGtCQUFrQjtBQUNsQixJQUFJLEtBQVU7QUFDZDtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6Ii4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3RlbXBsYXRlLWNvbXBpbGVyL2luZGV4LmpzP3tcImlkXCI6XCJkYXRhLXYtN2NjOTE2NzRcIixcImhhc1Njb3BlZFwiOmZhbHNlLFwiYnVibGVcIjp7XCJ0cmFuc2Zvcm1zXCI6e319fSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvci5qcz90eXBlPXRlbXBsYXRlJmluZGV4PTAhLi9yZXNvdXJjZXMvanMvdmlld3MvcGVyc29ucy9mb3JtLnZ1ZS5qcyIsInNvdXJjZXNDb250ZW50IjpbInZhciByZW5kZXIgPSBmdW5jdGlvbigpIHtcbiAgdmFyIF92bSA9IHRoaXNcbiAgdmFyIF9oID0gX3ZtLiRjcmVhdGVFbGVtZW50XG4gIHZhciBfYyA9IF92bS5fc2VsZi5fYyB8fCBfaFxuICByZXR1cm4gX2MoXG4gICAgXCJlbC1kaWFsb2dcIixcbiAgICB7XG4gICAgICBhdHRyczoge1xuICAgICAgICB0aXRsZTogX3ZtLnRpdGxlRGlhbG9nLFxuICAgICAgICB2aXNpYmxlOiBfdm0uc2hvd0RpYWxvZyxcbiAgICAgICAgXCJhcHBlbmQtdG8tYm9keVwiOiBcIlwiLFxuICAgICAgICBcImNsb3NlLW9uLWNsaWNrLW1vZGFsXCI6IGZhbHNlXG4gICAgICB9LFxuICAgICAgb246IHsgY2xvc2U6IF92bS5jbG9zZSwgb3BlbjogX3ZtLmNyZWF0ZSwgb3BlbmVkOiBfdm0ub3BlbmVkIH1cbiAgICB9LFxuICAgIFtcbiAgICAgIF9jKFxuICAgICAgICBcImZvcm1cIixcbiAgICAgICAge1xuICAgICAgICAgIGF0dHJzOiB7IGF1dG9jb21wbGV0ZTogXCJvZmZcIiB9LFxuICAgICAgICAgIG9uOiB7XG4gICAgICAgICAgICBzdWJtaXQ6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICAgICAgICAkZXZlbnQucHJldmVudERlZmF1bHQoKVxuICAgICAgICAgICAgICByZXR1cm4gX3ZtLnN1Ym1pdC5hcHBseShudWxsLCBhcmd1bWVudHMpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuICAgICAgICB9LFxuICAgICAgICBbXG4gICAgICAgICAgX2MoXG4gICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgeyBzdGF0aWNDbGFzczogXCJmb3JtLWJvZHlcIiB9LFxuICAgICAgICAgICAgW1xuICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcInJvd1wiIH0sIFtcbiAgICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbC1tZC02XCIgfSwgW1xuICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIsXG4gICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWRcbiAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXCJUaXBvIERvYy4gSWRlbnRpZGFkXFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwiXG4gICAgICAgICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJzcGFuXCIsIHsgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIipcIilcbiAgICAgICAgICAgICAgICAgICAgICAgIF0pXG4gICAgICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiZWwtc2VsZWN0XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZmlsdGVyYWJsZTogXCJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBcInBvcHBlci1jbGFzc1wiOiBcImVsLXNlbGVjdC1pZGVudGl0eV9kb2N1bWVudF90eXBlXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZHVzazogXCJpZGVudGl0eV9kb2N1bWVudF90eXBlX2lkXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgb246IHsgY2hhbmdlOiBfdm0uY2hhbmdlSWRlbnRpdHlEb2NUeXBlIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWQsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FsbGJhY2s6IGZ1bmN0aW9uKCQkdikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLiRzZXQoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5mb3JtLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBcImlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJCR2XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcImZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX2woX3ZtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVzLCBmdW5jdGlvbihvcHRpb24pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIF9jKFwiZWwtb3B0aW9uXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBrZXk6IG9wdGlvbi5pZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IG9wdGlvbi5pZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGxhYmVsOiBvcHRpb24uZGVzY3JpcHRpb25cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICB9KSxcbiAgICAgICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLmVycm9ycy5pZGVudGl0eV9kb2N1bWVudF90eXBlX2lkXG4gICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcInRleHQtZGFuZ2VyXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5lcnJvcnMuaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZFswXVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNlwiIH0sIFtcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgIGNsYXNzOiB7IFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLm51bWJlciB9XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIk7Dum1lcm9cXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJzcGFuXCIsIHsgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIipcIilcbiAgICAgICAgICAgICAgICAgICAgICAgIF0pXG4gICAgICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uYXBpX3NlcnZpY2VfdG9rZW4gIT0gZmFsc2VcbiAgICAgICAgICAgICAgICAgICAgICAgID8gX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcIngtaW5wdXQtc2VydmljZVwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZDpcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5mb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWRcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb246IHsgc2VhcmNoOiBfdm0uc2VhcmNoTnVtYmVyIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtLm51bWJlcixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJudW1iZXJcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJmb3JtLm51bWJlclwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgICAgICAgIDogX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1pbnB1dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heGxlbmd0aDogX3ZtLm1heExlbmd0aCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGR1c2s6IFwibnVtYmVyXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogX3ZtLmZvcm0ubnVtYmVyLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FsbGJhY2s6IGZ1bmN0aW9uKCQkdikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJudW1iZXJcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4cHJlc3Npb246IFwiZm9ybS5udW1iZXJcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5mb3JtLmlkZW50aXR5X2RvY3VtZW50X3R5cGVfaWQgPT09IFwiNlwiIHx8XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLmZvcm0uaWRlbnRpdHlfZG9jdW1lbnRfdHlwZV9pZCA9PT0gXCIxXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgID8gW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwiZWwtYnV0dG9uXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q6IFwiYXBwZW5kXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IFwicHJpbWFyeVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBsb2FkaW5nOiBfdm0ubG9hZGluZ19zZWFyY2gsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGljb246IFwiZWwtaWNvbi1zZWFyY2hcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9uOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsaWNrOiBmdW5jdGlvbigkZXZlbnQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZXZlbnQucHJldmVudERlZmF1bHQoKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBfdm0uc2VhcmNoQ3VzdG9tZXIuYXBwbHkoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBudWxsLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYXJndW1lbnRzXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdDogXCJhcHBlbmRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKCksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImlcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IHNsb3Q6IFwicHJlZml4XCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q6IFwicHJlZml4XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLm51bWJlclxuICAgICAgICAgICAgICAgICAgICAgICAgPyBfYyhcInNtYWxsXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0Q29udGVudDogX3ZtLl9zKF92bS5lcnJvcnMubnVtYmVyWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgIF0pXG4gICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcInJvd1wiIH0sIFtcbiAgICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbC1tZC02XCIgfSwgW1xuICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIsXG4gICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHsgXCJoYXMtZGFuZ2VyXCI6IF92bS5lcnJvcnMubmFtZSB9XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIk5vbWJyZVxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcInNwYW5cIiwgeyBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiKlwiKVxuICAgICAgICAgICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1pbnB1dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBkdXNrOiBcIm5hbWVcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybS5uYW1lLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbGxiYWNrOiBmdW5jdGlvbigkJHYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS4kc2V0KF92bS5mb3JtLCBcIm5hbWVcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJmb3JtLm5hbWVcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImlcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImVsLWljb24tZWRpdC1vdXRsaW5lXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgc2xvdDogXCJwcmVmaXhcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q6IFwicHJlZml4XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLmVycm9ycy5uYW1lXG4gICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcInRleHQtZGFuZ2VyXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoX3ZtLmVycm9ycy5uYW1lWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNlwiIH0sIFtcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgIGNsYXNzOiB7IFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLnRyYWRlX25hbWUgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCJOb21icmUgY29tZXJjaWFsXCIpXG4gICAgICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiZWwtaW5wdXRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgZHVzazogXCJ0cmFkZV9uYW1lXCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgbW9kZWw6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogX3ZtLmZvcm0udHJhZGVfbmFtZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJ0cmFkZV9uYW1lXCIsICQkdilcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4cHJlc3Npb246IFwiZm9ybS50cmFkZV9uYW1lXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJpXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJlbC1pY29uLWVkaXQtb3V0bGluZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IHNsb3Q6IFwicHJlZml4XCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90OiBcInByZWZpeFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICAgICAgKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5lcnJvcnMudHJhZGVfbmFtZVxuICAgICAgICAgICAgICAgICAgICAgICAgPyBfYyhcInNtYWxsXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0Q29udGVudDogX3ZtLl9zKF92bS5lcnJvcnMudHJhZGVfbmFtZVswXSlcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICA6IF92bS5fZSgpXG4gICAgICAgICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJyb3dcIiB9LCBbXG4gICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgIGNsYXNzOiB7IFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLmNvdW50cnlfaWQgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCJQYcOtc1wiKVxuICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICBcImVsLXNlbGVjdFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBmaWx0ZXJhYmxlOiBcIlwiLCBkdXNrOiBcImNvdW50cnlfaWRcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybS5jb3VudHJ5X2lkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbGxiYWNrOiBmdW5jdGlvbigkJHYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS4kc2V0KF92bS5mb3JtLCBcImNvdW50cnlfaWRcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJmb3JtLmNvdW50cnlfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl9sKF92bS5jb3VudHJpZXMsIGZ1bmN0aW9uKG9wdGlvbikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gX2MoXCJlbC1vcHRpb25cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGtleTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw6IG9wdGlvbi5kZXNjcmlwdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLmNvdW50cnlfaWRcbiAgICAgICAgICAgICAgICAgICAgICAgID8gX2MoXCJzbWFsbFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkb21Qcm9wczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dENvbnRlbnQ6IF92bS5fcyhfdm0uZXJyb3JzLmNvdW50cnlfaWRbMF0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbC1tZC00XCIgfSwgW1xuICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIsXG4gICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHsgXCJoYXMtZGFuZ2VyXCI6IF92bS5lcnJvcnMuZGVwYXJ0bWVudF9pZCB9XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIkRlcGFydGFtZW50b1wiKVxuICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICBcImVsLXNlbGVjdFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpbHRlcmFibGU6IFwiXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJwb3BwZXItY2xhc3NcIjogXCJlbC1zZWxlY3QtZGVwYXJ0bWVudHNcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkdXNrOiBcImRlcGFydG1lbnRfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBvbjogeyBjaGFuZ2U6IF92bS5maWx0ZXJQcm92aW5jZSB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybS5kZXBhcnRtZW50X2lkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbGxiYWNrOiBmdW5jdGlvbigkJHYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS4kc2V0KF92bS5mb3JtLCBcImRlcGFydG1lbnRfaWRcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJmb3JtLmRlcGFydG1lbnRfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl9sKF92bS5hbGxfZGVwYXJ0bWVudHMsIGZ1bmN0aW9uKG9wdGlvbikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gX2MoXCJlbC1vcHRpb25cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGtleTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw6IG9wdGlvbi5kZXNjcmlwdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLmRlcGFydG1lbnRfaWRcbiAgICAgICAgICAgICAgICAgICAgICAgID8gX2MoXCJzbWFsbFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkb21Qcm9wczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dENvbnRlbnQ6IF92bS5fcyhfdm0uZXJyb3JzLmRlcGFydG1lbnRfaWRbMF0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbC1tZC00XCIgfSwgW1xuICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIsXG4gICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHsgXCJoYXMtZGFuZ2VyXCI6IF92bS5lcnJvcnMucHJvdmluY2VfaWQgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCJQcm92aW5jaWFcIilcbiAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1zZWxlY3RcIixcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWx0ZXJhYmxlOiBcIlwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwicG9wcGVyLWNsYXNzXCI6IFwiZWwtc2VsZWN0LXByb3ZpbmNlc1wiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGR1c2s6IFwicHJvdmluY2VfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBvbjogeyBjaGFuZ2U6IF92bS5maWx0ZXJEaXN0cmljdCB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybS5wcm92aW5jZV9pZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJwcm92aW5jZV9pZFwiLCAkJHYpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcImZvcm0ucHJvdmluY2VfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl9sKF92bS5wcm92aW5jZXMsIGZ1bmN0aW9uKG9wdGlvbikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gX2MoXCJlbC1vcHRpb25cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGtleTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw6IG9wdGlvbi5kZXNjcmlwdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLnByb3ZpbmNlX2lkXG4gICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcInRleHQtZGFuZ2VyXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoX3ZtLmVycm9ycy5wcm92aW5jZV9pZFswXSlcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICA6IF92bS5fZSgpXG4gICAgICAgICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJyb3dcIiB9LCBbXG4gICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgIGNsYXNzOiB7IFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLnByb3ZpbmNlX2lkIH1cbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgIF9jKFwibGFiZWxcIiwgeyBzdGF0aWNDbGFzczogXCJjb250cm9sLWxhYmVsXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiRGlzdHJpdG9cIilcbiAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1zZWxlY3RcIixcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWx0ZXJhYmxlOiBcIlwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwicG9wcGVyLWNsYXNzXCI6IFwiZWwtc2VsZWN0LWRpc3RyaWN0c1wiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGR1c2s6IFwiZGlzdHJpY3RfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybS5kaXN0cmljdF9pZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJkaXN0cmljdF9pZFwiLCAkJHYpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcImZvcm0uZGlzdHJpY3RfaWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl9sKF92bS5kaXN0cmljdHMsIGZ1bmN0aW9uKG9wdGlvbikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gX2MoXCJlbC1vcHRpb25cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGtleTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw6IG9wdGlvbi5kZXNjcmlwdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLmRpc3RyaWN0X2lkXG4gICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcInRleHQtZGFuZ2VyXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoX3ZtLmVycm9ycy5kaXN0cmljdF9pZFswXSlcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICA6IF92bS5fZSgpXG4gICAgICAgICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiY29sLW1kLThcIiB9LCBbXG4gICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImZvcm0tZ3JvdXBcIixcbiAgICAgICAgICAgICAgICAgICAgICBjbGFzczogeyBcImhhcy1kYW5nZXJcIjogX3ZtLmVycm9ycy5hZGRyZXNzIH1cbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgIF9jKFwibGFiZWxcIiwgeyBzdGF0aWNDbGFzczogXCJjb250cm9sLWxhYmVsXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiRGlyZWNjacOzblwiKVxuICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICBcImVsLWlucHV0XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IGR1c2s6IFwiYWRkcmVzc1wiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtLmFkZHJlc3MsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FsbGJhY2s6IGZ1bmN0aW9uKCQkdikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLiRzZXQoX3ZtLmZvcm0sIFwiYWRkcmVzc1wiLCAkJHYpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcImZvcm0uYWRkcmVzc1wiXG4gICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwiaVwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBzbG90OiBcInByZWZpeFwiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdDogXCJwcmVmaXhcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLmFkZHJlc3NcbiAgICAgICAgICAgICAgICAgICAgICAgID8gX2MoXCJzbWFsbFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkb21Qcm9wczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dENvbnRlbnQ6IF92bS5fcyhfdm0uZXJyb3JzLmFkZHJlc3NbMF0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwicm93XCIgfSwgW1xuICAgICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiY29sLW1kLTZcIiB9LCBbXG4gICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImZvcm0tZ3JvdXBcIixcbiAgICAgICAgICAgICAgICAgICAgICBjbGFzczogeyBcImhhcy1kYW5nZXJcIjogX3ZtLmVycm9ycy50ZWxlcGhvbmUgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCJUZWzDqWZvbm9cIilcbiAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1pbnB1dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBkdXNrOiBcInRlbGVwaG9uZVwiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtLnRlbGVwaG9uZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJ0ZWxlcGhvbmVcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJmb3JtLnRlbGVwaG9uZVwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwiaVwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBzbG90OiBcInByZWZpeFwiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdDogXCJwcmVmaXhcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLnRlbGVwaG9uZVxuICAgICAgICAgICAgICAgICAgICAgICAgPyBfYyhcInNtYWxsXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0Q29udGVudDogX3ZtLl9zKF92bS5lcnJvcnMudGVsZXBob25lWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgMVxuICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNlwiIH0sIFtcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgIGNsYXNzOiB7IFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLmVtYWlsIH1cbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgIF9jKFwibGFiZWxcIiwgeyBzdGF0aWNDbGFzczogXCJjb250cm9sLWxhYmVsXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiQ29ycmVvIGVsZWN0csOzbmljb1wiKVxuICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICBcImVsLWlucHV0XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IGR1c2s6IFwiZW1haWxcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybS5lbWFpbCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJlbWFpbFwiLCAkJHYpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcImZvcm0uZW1haWxcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImlcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImVsLWljb24tZWRpdC1vdXRsaW5lXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgc2xvdDogXCJwcmVmaXhcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q6IFwicHJlZml4XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgX3ZtLmVycm9ycy5lbWFpbFxuICAgICAgICAgICAgICAgICAgICAgICAgPyBfYyhcInNtYWxsXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0Q29udGVudDogX3ZtLl9zKF92bS5lcnJvcnMuZW1haWxbMF0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwicm93XCIgfSwgW1xuICAgICAgICAgICAgICAgIF92bS5mb3JtLnN0YXRlXG4gICAgICAgICAgICAgICAgICA/IF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiY29sLW1kLTZcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgeyBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiRXN0YWRvIGRlbCBDb250cmlidXllbnRlXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uZm9ybS5zdGF0ZSA9PSBcIkFDVElWT1wiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPyBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwiZWwtYWxlcnRcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0aXRsZTogXCJcIiArIF92bS5mb3JtLnN0YXRlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHlwZTogXCJzdWNjZXNzXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBcInNob3ctaWNvblwiOiBcIlwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xvc2FibGU6IGZhbHNlXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDogW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImVsLWFsZXJ0XCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGl0bGU6IFwiXCIgKyBfdm0uZm9ybS5zdGF0ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IFwiZXJyb3JcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwic2hvdy1pY29uXCI6IFwiXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbG9zYWJsZTogZmFsc2VcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgMlxuICAgICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKCksXG4gICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICBfdm0uZm9ybS5jb25kaXRpb25cbiAgICAgICAgICAgICAgICAgID8gX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNlwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB7IHN0YXRpY0NsYXNzOiBcImZvcm0tZ3JvdXBcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCJDb25kaWNpw7NuIGRlbCBDb250cmlidXllbnRlXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uZm9ybS5jb25kaXRpb24gPT0gXCJIQUJJRE9cIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgID8gW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImVsLWFsZXJ0XCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGl0bGU6IFwiXCIgKyBfdm0uZm9ybS5jb25kaXRpb24sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0eXBlOiBcInN1Y2Nlc3NcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwic2hvdy1pY29uXCI6IFwiXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbG9zYWJsZTogZmFsc2VcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgOiBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwiZWwtYWxlcnRcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0aXRsZTogXCJcIiArIF92bS5mb3JtLmNvbmRpdGlvbixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IFwiZXJyb3JcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwic2hvdy1pY29uXCI6IFwiXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbG9zYWJsZTogZmFsc2VcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgMlxuICAgICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgIF92bS50eXBlID09PSBcInN1cHBsaWVyc1wiXG4gICAgICAgICAgICAgICAgPyBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcInJvdyBtdC0yXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbC1tZC02IGNlbnRlci1lbC1jaGVja2JveFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImZvcm0tZ3JvdXBcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHsgXCJoYXMtZGFuZ2VyXCI6IF92bS5lcnJvcnMucGVyY2VwdGlvbl9hZ2VudCB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBcImVsLWNoZWNrYm94XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbW9kZWw6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtLnBlcmNlcHRpb25fYWdlbnQsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbGxiYWNrOiBmdW5jdGlvbigkJHYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChfdm0uZm9ybSwgXCJwZXJjZXB0aW9uX2FnZW50XCIsICQkdilcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJmb3JtLnBlcmNlcHRpb25fYWdlbnRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgW192bS5fdihcIsK/RXMgYWdlbnRlIGRlIHBlcmNlcGNpw7NuP1wiKV1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJiclwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLmVycm9ycy5wZXJjZXB0aW9uX2FnZW50XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPyBfYyhcInNtYWxsXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0Q29udGVudDogX3ZtLl9zKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLmVycm9ycy5wZXJjZXB0aW9uX2FnZW50WzBdXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgX3ZtLnR5cGUgPT09IFwic3VwcGxpZXJzXCJcbiAgICAgICAgICAgICAgICAgICAgICA/IF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGlyZWN0aXZlczogW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBuYW1lOiBcInNob3dcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmF3TmFtZTogXCJ2LXNob3dcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtLnBlcmNlcHRpb25fYWdlbnQsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4cHJlc3Npb246IFwiZm9ybS5wZXJjZXB0aW9uX2FnZW50XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImNvbC1tZC02XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHsgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwibGFiZWxcIiwgeyBzdGF0aWNDbGFzczogXCJjb250cm9sLWxhYmVsXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIlBvcmNlbnRhamUgZGUgcGVyY2VwY2nDs25cIilcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwiZWwtaW5wdXRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogX3ZtLmZvcm0ucGVyY2VudGFnZV9wZXJjZXB0aW9uLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLiRzZXQoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uZm9ybSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwicGVyY2VudGFnZV9wZXJjZXB0aW9uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkJHZcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4cHJlc3Npb246IFwiZm9ybS5wZXJjZW50YWdlX3BlcmNlcHRpb25cIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJpXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgc2xvdDogXCJwcmVmaXhcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90OiBcInByZWZpeFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgICAgICA6IF92bS5fZSgpXG4gICAgICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgICAgIDogX3ZtLl9lKCksXG4gICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgIF92bS5fbChfdm0uZm9ybS5hZGRyZXNzZXMsIGZ1bmN0aW9uKHJvdywgaW5kZXgpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gX2MoXCJkaXZcIiwgeyBrZXk6IGluZGV4LCBzdGF0aWNDbGFzczogXCJyb3cgbS10LTEwXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtMTJcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgIGluZGV4ID09PSAwXG4gICAgICAgICAgICAgICAgICAgICAgPyBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwiXFxuICAgICAgICAgICAgICAgICAgICAgICAgRGlyZWNjacOzbiBwcmluY2lwYWxcXG4gICAgICAgICAgICAgICAgICAgIFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgICAgICAgIF0pXG4gICAgICAgICAgICAgICAgICAgICAgOiBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXCJsYWJlbFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJcXG4gICAgICAgICAgICAgICAgICAgICAgICBEaXJlY2Npw7NuIHNlY3VuZGFyaWEgIyBcIiArXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fcyhpbmRleCkgK1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBcIlxcbiAgICAgICAgICAgICAgICAgICAgICAgIFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwiZWwtYnV0dG9uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImJ0bi1kZWZhdWx0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBzaXplOiBcIm1pbmlcIiwgaWNvbjogXCJlbC1pY29uLW1pbnVzXCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb246IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjbGljazogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZXZlbnQucHJldmVudERlZmF1bHQoKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIF92bS5jbGlja1JlbW92ZUFkZHJlc3MoaW5kZXgpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgW192bS5fdihcIkVsaW1pbmFyIGRpcmVjY2nDs25cIildXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbC1tZC00XCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImZvcm0tZ3JvdXBcIixcbiAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzOiB7IFwiaGFzLWRhbmdlclwiOiBfdm0uZXJyb3JzLmNvdW50cnlfaWQgfVxuICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIlBhw61zXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1zZWxlY3RcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IGZpbHRlcmFibGU6IFwiXCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IHJvdy5jb3VudHJ5X2lkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FsbGJhY2s6IGZ1bmN0aW9uKCQkdikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChyb3csIFwiY291bnRyeV9pZFwiLCAkJHYpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJyb3cuY291bnRyeV9pZFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uX2woX3ZtLmNvdW50cmllcywgZnVuY3Rpb24ob3B0aW9uKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIF9jKFwiZWwtb3B0aW9uXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGtleTogb3B0aW9uLmlkLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IG9wdGlvbi5pZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbGFiZWw6IG9wdGlvbi5kZXNjcmlwdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5lcnJvcnMuY291bnRyeV9pZFxuICAgICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoX3ZtLmVycm9ycy5jb3VudHJ5X2lkWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtOFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBjbGFzczogeyBcImhhcy1kYW5nZXJcIjogX3ZtLmVycm9ycy5sb2NhdGlvbl9pZCB9XG4gICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiVWJpZ2VvXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcImVsLWNhc2NhZGVyXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBvcHRpb25zOiBfdm0ubG9jYXRpb25zLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNsZWFyYWJsZTogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWx0ZXJhYmxlOiBcIlwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IHJvdy5sb2NhdGlvbl9pZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBfdm0uJHNldChyb3csIFwibG9jYXRpb25faWRcIiwgJCR2KVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJyb3cubG9jYXRpb25faWRcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9KSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLmxvY2F0aW9uX2lkXG4gICAgICAgICAgICAgICAgICAgICAgICAgID8gX2MoXCJzbWFsbFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dENvbnRlbnQ6IF92bS5fcyhfdm0uZXJyb3JzLmxvY2F0aW9uX2lkWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtMTJcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHsgXCJoYXMtZGFuZ2VyXCI6IF92bS5lcnJvcnMuYWRkcmVzcyB9XG4gICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiRGlyZWNjacOzblwiKVxuICAgICAgICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICAgIFwiZWwtaW5wdXRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1vZGVsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZTogcm93LmFkZHJlc3MsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS4kc2V0KHJvdywgXCJhZGRyZXNzXCIsICQkdilcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcInJvdy5hZGRyZXNzXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcImlcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZWwtaWNvbi1lZGl0LW91dGxpbmVcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IHNsb3Q6IFwicHJlZml4XCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsb3Q6IFwicHJlZml4XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5lcnJvcnMuYWRkcmVzc1xuICAgICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoX3ZtLmVycm9ycy5hZGRyZXNzWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgXSksXG4gICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJjb2wtbWQtNlwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgXCJkaXZcIixcbiAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJmb3JtLWdyb3VwXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBjbGFzczogeyBcImhhcy1kYW5nZXJcIjogX3ZtLmVycm9ycy5waG9uZSB9XG4gICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcImxhYmVsXCIsIHsgc3RhdGljQ2xhc3M6IFwiY29udHJvbC1sYWJlbFwiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiVGVsw6lmb25vXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXCJlbC1pbnB1dFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbW9kZWw6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiByb3cucGhvbmUsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazogZnVuY3Rpb24oJCR2KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF92bS4kc2V0KHJvdywgXCJwaG9uZVwiLCAkJHYpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZXhwcmVzc2lvbjogXCJyb3cucGhvbmVcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIF9jKFwiaVwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJlbC1pY29uLWVkaXQtb3V0bGluZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0cnM6IHsgc2xvdDogXCJwcmVmaXhcIiB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xvdDogXCJwcmVmaXhcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgICAgICAgICksXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLmVycm9ycy5waG9uZVxuICAgICAgICAgICAgICAgICAgICAgICAgICA/IF9jKFwic21hbGxcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1kYW5nZXJcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRvbVByb3BzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHRDb250ZW50OiBfdm0uX3MoX3ZtLmVycm9ycy5waG9uZVswXSlcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgICA6IF92bS5fZSgpXG4gICAgICAgICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICAgICAgICAgICAxXG4gICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiY29sLW1kLTZcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZm9ybS1ncm91cFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3M6IHsgXCJoYXMtZGFuZ2VyXCI6IF92bS5lcnJvcnMuZW1haWwgfVxuICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJsYWJlbFwiLCB7IHN0YXRpY0NsYXNzOiBcImNvbnRyb2wtbGFiZWxcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIkNvcnJlbyBlbGVjdHLDs25pY29cIilcbiAgICAgICAgICAgICAgICAgICAgICAgIF0pLFxuICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICAgICAgICBcImVsLWlucHV0XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtb2RlbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU6IHJvdy5lbWFpbCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbGxiYWNrOiBmdW5jdGlvbigkJHYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgX3ZtLiRzZXQocm93LCBcImVtYWlsXCIsICQkdilcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHByZXNzaW9uOiBcInJvdy5lbWFpbFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgX2MoXCJpXCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImVsLWljb24tZWRpdC1vdXRsaW5lXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBzbG90OiBcInByZWZpeFwiIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbG90OiBcInByZWZpeFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgICAgICAgICAgICAgKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uZXJyb3JzLmVtYWlsXG4gICAgICAgICAgICAgICAgICAgICAgICAgID8gX2MoXCJzbWFsbFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ0ZXh0LWRhbmdlclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dENvbnRlbnQ6IF92bS5fcyhfdm0uZXJyb3JzLmVtYWlsWzBdKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgICAgICAgICAgICAgICBdLFxuICAgICAgICAgICAgICAgICAgICAgIDFcbiAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIDJcbiAgICAgICAgICApLFxuICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgX2MoXG4gICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgeyBzdGF0aWNDbGFzczogXCJmb3JtLWFjdGlvbnMgdGV4dC1lbmQgcHQtMiBwYi0yXCIgfSxcbiAgICAgICAgICAgIFtcbiAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgXCJlbC1idXR0b25cIixcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICBvbjoge1xuICAgICAgICAgICAgICAgICAgICBjbGljazogZnVuY3Rpb24oJGV2ZW50KSB7XG4gICAgICAgICAgICAgICAgICAgICAgJGV2ZW50LnByZXZlbnREZWZhdWx0KClcbiAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gX3ZtLmNsb3NlKClcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgW192bS5fdihcIkNhbmNlbGFyXCIpXVxuICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICBfYyhcbiAgICAgICAgICAgICAgICBcImVsLWJ1dHRvblwiLFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IFwicHJpbWFyeVwiLFxuICAgICAgICAgICAgICAgICAgICBcIm5hdGl2ZS10eXBlXCI6IFwic3VibWl0XCIsXG4gICAgICAgICAgICAgICAgICAgIGxvYWRpbmc6IF92bS5sb2FkaW5nX3N1Ym1pdFxuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgW192bS5fdihcIkd1YXJkYXJcIildXG4gICAgICAgICAgICAgIClcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAxXG4gICAgICAgICAgKVxuICAgICAgICBdXG4gICAgICApXG4gICAgXVxuICApXG59XG52YXIgc3RhdGljUmVuZGVyRm5zID0gW11cbnJlbmRlci5fd2l0aFN0cmlwcGVkID0gdHJ1ZVxubW9kdWxlLmV4cG9ydHMgPSB7IHJlbmRlcjogcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnM6IHN0YXRpY1JlbmRlckZucyB9XG5pZiAobW9kdWxlLmhvdCkge1xuICBtb2R1bGUuaG90LmFjY2VwdCgpXG4gIGlmIChtb2R1bGUuaG90LmRhdGEpIHtcbiAgICByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpICAgICAgLnJlcmVuZGVyKFwiZGF0YS12LTdjYzkxNjc0XCIsIG1vZHVsZS5leHBvcnRzKVxuICB9XG59XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvdGVtcGxhdGUtY29tcGlsZXI/e1wiaWRcIjpcImRhdGEtdi03Y2M5MTY3NFwiLFwiaGFzU2NvcGVkXCI6ZmFsc2UsXCJidWJsZVwiOntcInRyYW5zZm9ybXNcIjp7fX19IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3NlbGVjdG9yLmpzP3R5cGU9dGVtcGxhdGUmaW5kZXg9MCEuL3Jlc291cmNlcy9qcy92aWV3cy9wZXJzb25zL2Zvcm0udnVlXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleC5qcz97XCJpZFwiOlwiZGF0YS12LTdjYzkxNjc0XCIsXCJoYXNTY29wZWRcIjpmYWxzZSxcImJ1YmxlXCI6e1widHJhbnNmb3Jtc1wiOnt9fX0hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3IuanM/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vcmVzb3VyY2VzL2pzL3ZpZXdzL3BlcnNvbnMvZm9ybS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSAxMSAxMiAxNCAxNyAxOSAyMCA5OSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-7cc91674\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue\n");
=======
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
                _c("div", { staticClass: "col-md-6" }, [
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
>>>>>>> master

/***/ }),

/***/ "./resources/js/views/persons/form.vue":
/***/ (function(module, exports, __webpack_require__) {

<<<<<<< HEAD
eval("var disposed = false\nvar normalizeComponent = __webpack_require__(\"./node_modules/vue-loader/lib/component-normalizer.js\")\n/* script */\nvar __vue_script__ = __webpack_require__(\"./node_modules/babel-loader/lib/index.js?{\\\"cacheDirectory\\\":true,\\\"presets\\\":[[\\\"@babel/preset-env\\\",{\\\"modules\\\":false,\\\"targets\\\":{\\\"browsers\\\":[\\\"> 2%\\\"]},\\\"forceAllTransforms\\\":true}]],\\\"plugins\\\":[\\\"@babel/plugin-proposal-object-rest-spread\\\",[\\\"@babel/plugin-transform-runtime\\\",{\\\"helpers\\\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/persons/form.vue\")\n/* template */\nvar __vue_template__ = __webpack_require__(\"./node_modules/vue-loader/lib/template-compiler/index.js?{\\\"id\\\":\\\"data-v-7cc91674\\\",\\\"hasScoped\\\":false,\\\"buble\\\":{\\\"transforms\\\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/persons/form.vue\")\n/* template functional */\nvar __vue_template_functional__ = false\n/* styles */\nvar __vue_styles__ = null\n/* scopeId */\nvar __vue_scopeId__ = null\n/* moduleIdentifier (server only) */\nvar __vue_module_identifier__ = null\nvar Component = normalizeComponent(\n  __vue_script__,\n  __vue_template__,\n  __vue_template_functional__,\n  __vue_styles__,\n  __vue_scopeId__,\n  __vue_module_identifier__\n)\nComponent.options.__file = \"resources/js/views/persons/form.vue\"\n\n/* hot reload */\nif (false) {(function () {\n  var hotAPI = require(\"vue-hot-reload-api\")\n  hotAPI.install(require(\"vue\"), false)\n  if (!hotAPI.compatible) return\n  module.hot.accept()\n  if (!module.hot.data) {\n    hotAPI.createRecord(\"data-v-7cc91674\", Component.options)\n  } else {\n    hotAPI.reload(\"data-v-7cc91674\", Component.options)\n  }\n  module.hot.dispose(function (data) {\n    disposed = true\n  })\n})()}\n\nmodule.exports = Component.exports\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdmlld3MvcGVyc29ucy9mb3JtLnZ1ZT9lNmI4Il0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0EseUJBQXlCLG1CQUFPLENBQUMsdURBQStEO0FBQ2hHO0FBQ0EscUJBQXFCLG1CQUFPLENBQUMsMFpBQTRXO0FBQ3pZO0FBQ0EsdUJBQXVCLG1CQUFPLENBQUMsK09BQW9PO0FBQ25RO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxJQUFJLEtBQVUsR0FBRztBQUNqQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsQ0FBQzs7QUFFRCIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy92aWV3cy9wZXJzb25zL2Zvcm0udnVlLmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIGRpc3Bvc2VkID0gZmFsc2VcbnZhciBub3JtYWxpemVDb21wb25lbnQgPSByZXF1aXJlKFwiIS4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9jb21wb25lbnQtbm9ybWFsaXplclwiKVxuLyogc2NyaXB0ICovXG52YXIgX192dWVfc2NyaXB0X18gPSByZXF1aXJlKFwiISFiYWJlbC1sb2FkZXI/e1xcXCJjYWNoZURpcmVjdG9yeVxcXCI6dHJ1ZSxcXFwicHJlc2V0c1xcXCI6W1tcXFwiQGJhYmVsL3ByZXNldC1lbnZcXFwiLHtcXFwibW9kdWxlc1xcXCI6ZmFsc2UsXFxcInRhcmdldHNcXFwiOntcXFwiYnJvd3NlcnNcXFwiOltcXFwiPiAyJVxcXCJdfSxcXFwiZm9yY2VBbGxUcmFuc2Zvcm1zXFxcIjp0cnVlfV1dLFxcXCJwbHVnaW5zXFxcIjpbXFxcIkBiYWJlbC9wbHVnaW4tcHJvcG9zYWwtb2JqZWN0LXJlc3Qtc3ByZWFkXFxcIixbXFxcIkBiYWJlbC9wbHVnaW4tdHJhbnNmb3JtLXJ1bnRpbWVcXFwiLHtcXFwiaGVscGVyc1xcXCI6ZmFsc2V9XV19IS4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9zZWxlY3Rvcj90eXBlPXNjcmlwdCZpbmRleD0wIS4vZm9ybS52dWVcIilcbi8qIHRlbXBsYXRlICovXG52YXIgX192dWVfdGVtcGxhdGVfXyA9IHJlcXVpcmUoXCIhIS4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi90ZW1wbGF0ZS1jb21waWxlci9pbmRleD97XFxcImlkXFxcIjpcXFwiZGF0YS12LTdjYzkxNjc0XFxcIixcXFwiaGFzU2NvcGVkXFxcIjpmYWxzZSxcXFwiYnVibGVcXFwiOntcXFwidHJhbnNmb3Jtc1xcXCI6e319fSEuLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvc2VsZWN0b3I/dHlwZT10ZW1wbGF0ZSZpbmRleD0wIS4vZm9ybS52dWVcIilcbi8qIHRlbXBsYXRlIGZ1bmN0aW9uYWwgKi9cbnZhciBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18gPSBmYWxzZVxuLyogc3R5bGVzICovXG52YXIgX192dWVfc3R5bGVzX18gPSBudWxsXG4vKiBzY29wZUlkICovXG52YXIgX192dWVfc2NvcGVJZF9fID0gbnVsbFxuLyogbW9kdWxlSWRlbnRpZmllciAoc2VydmVyIG9ubHkpICovXG52YXIgX192dWVfbW9kdWxlX2lkZW50aWZpZXJfXyA9IG51bGxcbnZhciBDb21wb25lbnQgPSBub3JtYWxpemVDb21wb25lbnQoXG4gIF9fdnVlX3NjcmlwdF9fLFxuICBfX3Z1ZV90ZW1wbGF0ZV9fLFxuICBfX3Z1ZV90ZW1wbGF0ZV9mdW5jdGlvbmFsX18sXG4gIF9fdnVlX3N0eWxlc19fLFxuICBfX3Z1ZV9zY29wZUlkX18sXG4gIF9fdnVlX21vZHVsZV9pZGVudGlmaWVyX19cbilcbkNvbXBvbmVudC5vcHRpb25zLl9fZmlsZSA9IFwicmVzb3VyY2VzL2pzL3ZpZXdzL3BlcnNvbnMvZm9ybS52dWVcIlxuXG4vKiBob3QgcmVsb2FkICovXG5pZiAobW9kdWxlLmhvdCkgeyhmdW5jdGlvbiAoKSB7XG4gIHZhciBob3RBUEkgPSByZXF1aXJlKFwidnVlLWhvdC1yZWxvYWQtYXBpXCIpXG4gIGhvdEFQSS5pbnN0YWxsKHJlcXVpcmUoXCJ2dWVcIiksIGZhbHNlKVxuICBpZiAoIWhvdEFQSS5jb21wYXRpYmxlKSByZXR1cm5cbiAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICBpZiAoIW1vZHVsZS5ob3QuZGF0YSkge1xuICAgIGhvdEFQSS5jcmVhdGVSZWNvcmQoXCJkYXRhLXYtN2NjOTE2NzRcIiwgQ29tcG9uZW50Lm9wdGlvbnMpXG4gIH0gZWxzZSB7XG4gICAgaG90QVBJLnJlbG9hZChcImRhdGEtdi03Y2M5MTY3NFwiLCBDb21wb25lbnQub3B0aW9ucylcbiAgfVxuICBtb2R1bGUuaG90LmRpc3Bvc2UoZnVuY3Rpb24gKGRhdGEpIHtcbiAgICBkaXNwb3NlZCA9IHRydWVcbiAgfSlcbn0pKCl9XG5cbm1vZHVsZS5leHBvcnRzID0gQ29tcG9uZW50LmV4cG9ydHNcblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vcmVzb3VyY2VzL2pzL3ZpZXdzL3BlcnNvbnMvZm9ybS52dWVcbi8vIG1vZHVsZSBpZCA9IC4vcmVzb3VyY2VzL2pzL3ZpZXdzL3BlcnNvbnMvZm9ybS52dWVcbi8vIG1vZHVsZSBjaHVua3MgPSAxMSAxMiAxNCAxNyAxOSAyMCA5OSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/views/persons/form.vue\n");
=======
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

>>>>>>> master

/***/ })

});
<<<<<<< HEAD
=======
webpackJsonp([99],{"+Cxe":function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],attrs:{"append-to-body":"",title:"Enviar documento por whatsapp",width:"40%",visible:t.showDialog}},[n("div",{staticClass:"card "},[n("div",{staticClass:"row d-flex align-items-center"},[n("div",{staticClass:"col-8"},[n("el-input",{attrs:{placeholder:"tlf: 999999999"},model:{value:t.number,callback:function(e){t.number=e},expression:"number"}})],1),t._v(" "),n("div",{staticClass:"col-4"},[n("el-checkbox",{attrs:{disabled:"80"==t.documentTypeId},model:{value:t.withXml,callback:function(e){t.withXml=e},expression:"withXml"}},[t._v("\n                    Adjuntar XML\n                ")])],1)]),t._v(" "),n("div",{staticClass:"d-flex justify-content-end p-2"},[n("el-button",{attrs:{type:"primary"},on:{click:t.sendFiles}},[t._v("Enviar")]),t._v(" "),n("el-button",{on:{click:t.close}},[t._v("\n                Cerrar\n            ")])],1)])])},staticRenderFns:[]}},GCLO:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".el-dialog__header{background-color:var(--primary)!important}.el-dialog__title{color:var(--light-text)!important}.el-dialog__headerbtn .el-dialog__close{color:#fff!important}",""])},RRfG:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),r=n.n(a);function s(t,e,n,a,r,s,o){try{var i=t[s](o),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,r)}e.default={props:["showDialog","documentId","documentTypeId","company","documentNumber","sender"],data:function(){return{number:null,withXml:!1,loading:!1}},methods:{close:function(){this.$emit("update:showDialog",!1),this.number=null,this.withXml=!1},existNumber:function(){var t=this.number;return!!t.startsWith("9")&&(9==t.length&&!isNaN(Number(t)))},sendFiles:function(){var t,e=this;return(t=r.a.mark(function t(){var n,a;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(e.number){t.next=3;break}return e.$toast.warning("Ingrese un número"),t.abrupt("return");case 3:if(e.existNumber()){t.next=6;break}return e.$toast.error("Número para envío whatsapp inválido"),t.abrupt("return");case 6:return n={document_id:e.documentId,document_type_id:e.documentTypeId,customer_telephone:e.number,sender:e.sender,mensaje:"Su comprobante de pago electrónico "+e.documentNumber+" de *"+e.company.name+"*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"},t.prev=7,e.loading=!0,t.next=11,e.$http.post("/whatsapp",n);case 11:if(a=t.sent,!e.withXml){t.next=17;break}return n.xml=!0,t.next=16,e.$http.post("/whatsapp",n);case 16:a=t.sent;case 17:200==a.status?e.$toast.success("El mensaje se envió correctamente"):e.$toast.error("Ocurrió un error en el envio"),t.next=23;break;case 20:t.prev=20,t.t0=t.catch(7),e.$toast.error("Ocurrió un error en el envio");case 23:return t.prev=23,e.loading=!1,e.close(),t.finish(23);case 27:case"end":return t.stop()}},t,null,[[7,20,23,27]])}),function(){var e=this,n=arguments;return new Promise(function(a,r){var o=t.apply(e,n);function i(t){s(o,a,r,i,c,"next",t)}function c(t){s(o,a,r,i,c,"throw",t)}i(void 0)})})()}}}},XfdS:function(t,e,n){var a=n("VU/8")(n("vPTa"),n("g9l2"),!1,null,null,null);t.exports=a.exports},Zher:function(t,e,n){var a=n("VU/8")(n("RRfG"),n("+Cxe"),!1,null,null,null);t.exports=a.exports},g9l2:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[n("div",{staticClass:"container table-responsive col-md-12"},[n("table",{staticClass:"table table-hover table-striped table-condensed  table-responsive",staticStyle:{width:"100%","white-space":"nowrap"}},[n("thead",[n("tr",["documents"==t.type?n("th",[t._v("SUNAT")]):t._e(),t._v(" "),n("th",[t._v("\n                        Acciones\n                    ")]),t._v(" "),n("th",[t._v("\n                        Número\n                    ")]),t._v(" "),n("th",[t._v("Fecha")]),t._v(" "),n("th",[t._v("\n                        Cliente\n                    ")]),t._v(" "),"documents"==t.type?n("th",[t._v("\n                        Estado\n                    ")]):t._e(),t._v(" "),n("th",[t._v("\n                        Monto\n                    ")])])]),t._v(" "),n("tbody",t._l(t.records,function(e,a){return n("tr",{key:a},["documents"==t.type?n("td",[n("div",{staticClass:"dropdown-as-select d-inline-block",attrs:{"data-childselector":"span"}},[t._m(0,!0),t._v(" "),n("div",{staticClass:"dropdown-menu dropdown-menu-end col-md-2 col-1"},["documents"==t.type&&"11"!=e.state_type_id&&"01"==e.document_type_id?n("el-button",{staticClass:"col-md-12 col-12",on:{click:function(n){return t.clickReStore(e.id)}}},[t._v("\n                                                Recrear\n                                            ")]):t._e(),t._v(" "),"documents"==t.type&&"11"!=e.state_type_id&&"01"==e.document_type_id?n("br"):t._e(),t._v(" "),"documents"==t.type&&"01"==e.document_type_id&&"11"!=e.state_type_id?n("el-button",{staticClass:"col-md-12 col-12",attrs:{plain:""},on:{click:function(n){return t.clickSendOnline(e.id)}}},[t._v("\n                                                Reenviar\n                                            ")]):t._e(),t._v(" "),"documents"==t.type&&"01"==e.document_type_id?n("br"):t._e(),t._v(" "),"documents"==t.type&&"11"!=e.state_type_id?n("el-button",{staticClass:"col-md-12 col-12",on:{click:function(n){return t.clickValidarCpe(e.id)}}},[t._v("\n                                                Validar cpe\n                                            ")]):t._e()],1)])]):t._e(),t._v(" "),n("td",[n("el-button",{staticStyle:{"margin-bottom":"3px"},attrs:{size:"mini",type:"success"},on:{click:function(n){return t.clickOpenWhatsapp(e)}}},[n("i",{staticClass:"fab fa-whatsapp",attrs:{"aria-hidden":"true"}})]),t._v(" "),n("el-button",{attrs:{size:"mini",plain:""},on:{click:function(n){return t.print(e.external_id,e.document_type_id)}}},[n("i",{staticClass:"fas fa-print"})])],1),t._v(" "),"saleNotes"==t.type?n("td",[t._v(t._s(e.full_number))]):n("td",[t._v(t._s(e.number))]),t._v(" "),n("td",[t._v(t._s(e.date_of_issue))]),t._v(" "),n("td",[t._v("\n                        "+t._s(e.customer_name)+" "),n("br"),t._v(" "),n("span",{staticClass:"text-muted"},[t._v(t._s(e.customer_number))])]),t._v(" "),"documents"==t.type?n("td",{class:"Aceptado"==e.state_type_description?"text-success":"Anulado"==e.state_type_description?"text-danger":"Enviado"==e.state_type_description?"text-primary":"text-black"},[n("b",[t._v(" "+t._s(e.state_type_description))])]):t._e(),t._v(" "),n("td",[t._v("\n                        "+t._s(e.total)+"\n                    ")])])}),0)])]),t._v(" "),n("el-pagination",{attrs:{layout:"total, prev, pager, next",total:t.pagination.total,"current-page":t.pagination.current_page,"page-size":t.pagination.per_page},on:{"current-change":t.getRecords,"update:currentPage":function(e){return t.$set(t.pagination,"current_page",e)},"update:current-page":function(e){return t.$set(t.pagination,"current_page",e)}}}),t._v(" "),n("whatsapp-modal",{attrs:{documentNumber:t.currentNumber,company:t.company,documentId:t.currentId,documentTypeId:t.currentType,showDialog:t.showWhatsappModal,sender:t.sender},on:{"update:showDialog":function(e){t.showWhatsappModal=e},"update:show-dialog":function(e){t.showWhatsappModal=e}}})],1)},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn p-0",attrs:{type:"button","data-bs-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("span",{staticClass:"btn btn-primary dropdown-toggle",attrs:{"data-bs-toggle":"tooltip","data-bs-placement":"top","data-bs-delay":"0",title:"","data-bs-original-title":"Item Count","aria-label":"Item Count"}},[e("i",{staticClass:"fas fa-list"})])])}]}},i8Tq:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),r=n.n(a),s=n("XfdS"),o=n.n(s),i=n("OAwv"),c=n.n(i);function u(t,e,n,a,r,s,o){try{var i=t[s](o),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,r)}function l(t){return function(){var e=this,n=arguments;return new Promise(function(a,r){var s=t.apply(e,n);function o(t){u(s,a,r,o,i,"next",t)}function i(t){u(s,a,r,o,i,"throw",t)}o(void 0)})}}e.default={components:{DocumentPrintDetail:o.a},props:["showDialog","company","sender","config","establishment"],data:function(){return{time:null,loading:!1,value:null,typeSearch:"document",saleNotes:[],documents:[],pagination:{saleNotes:{},documents:{}},printer:null,lastDocument:null,activeName:"documents"}},methods:{getRecordsInput:function(){this.getRecords()},printEvent:function(t){var e=this;return l(r.a.mark(function n(){var a,s,o,i,c,u,l;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(a={scaleContent:!1},s=t.split("/"),o=s[s.length-1],i=o.toLowerCase().includes("ticket"),c=e.config.new_old_printer,i||1!=c?i||0!=c||(a.density=350,a.orientation="portrait"):(a.density=600,a.orientation="portrait",a.margins={left:2}),n.prev=6,u=qz.configs.create(e.printer,a),qz.websocket.isActive()){n.next=11;break}return n.next=11,qz.websocket.connect(u);case 11:l=[{type:"pdf",format:"file",data:t}],qz.print(u,l).catch(function(t){e.$toast.error(t.message)}),n.next=17;break;case 15:n.prev=15,n.t0=n.catch(6);case 17:case"end":return n.stop()}},n,null,[[6,15]])}))()},printData:function(t,e){var n=this;return l(r.a.mark(function a(){var s,o;return r.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return s=n.establishment.format_printer,o="","1"==s&&(o="80"==e?"/sale-notes/print/".concat(t,"/a4"):"/print/document/".concat(t,"/a4")),"2"==s&&(o="80"==e?"/sale-notes/print/".concat(t,"/a5"):"/print/document/".concat(t,"/a5")),"3"==s&&(o="80"==e?"/sale-notes/print/".concat(t,"/ticket"):"/print/document/".concat(t,"/ticket")),"4"==s&&(o="80"==e?"/sale-notes/print/".concat(t,"/ticket_50"):"/print/document/".concat(t,"/ticket_50")),a.next=8,n.printEvent(o);case 8:case"end":return a.stop()}},a)}))()},getLastDocument:function(){var t=this;return l(r.a.mark(function e(){var n,a,s;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,t.loading=!0,e.next=4,t.$http("print_last_document");case 4:200==(n=e.sent).status&&(a=n.data.document,t.lastDocument=a,s=t.lastDocument.filename.split("-"),t.lastDocument.numberPrint=s[2]+"-"+s[3]),e.next=11;break;case 8:e.prev=8,e.t0=e.catch(0),t.$toast.error("No se pudo obtener el ultimo documento");case 11:return e.prev=11,t.loading=!1,e.finish(11);case 14:case"end":return e.stop()}},e,null,[[0,8,11,14]])}))()},getPrinter:function(){var t=this;return l(r.a.mark(function e(){var n,a;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$http("cash/get_printer/".concat(t.area_id));case 2:n=e.sent,a=n.data.printer,t.printer=a;case 5:case"end":return e.stop()}},e)}))()},getRecords:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:1;"saleNotes"==this.activeName?this.pagination.saleNotes.current_page=Number(e):this.pagination.documents.current_page=Number(e),this.time&&clearTimeout(this.time),this.time=setTimeout(l(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getLastDocuments();case 2:case"end":return e.stop()}},e)})),500)},getQueryParameters:function(){arguments.length>0&&void 0!==arguments[0]&&arguments[0],"saleNotes"==this.activeName?this.pagination.saleNotes.current_page:this.pagination.documents.current_page;return c.a.stringify({page:"saleNotes"==this.activeName?this.pagination.saleNotes.current_page:this.pagination.documents.current_page,isNote:"saleNotes"==this.activeName,column:this.typeSearch,value:this.value})},handleClick:function(){0!=this.saleNotes.length&&0!=this.documents.length||this.getLastDocuments()},open:function(){var t=this;return l(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getLastDocument();case 2:return e.next=4,t.getLastDocuments();case 4:return e.next=6,t.getPrinter();case 6:case"end":return e.stop()}},e)}))()},close:function(){this.$emit("update:showDialog",!1)},getLastDocuments:function(){var t=this;return l(r.a.mark(function e(){var n,a,s,o;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,t.loading=!0,e.next=4,t.$http("cash/get_last_documents?".concat(t.getQueryParameters()));case 4:200!=(n=e.sent).status?t.$toast.error("No se pudo imprimir"):(a=n.data,s=a.data,o=a.meta,"saleNotes"==t.activeName?(t.saleNotes=s,t.pagination.saleNotes=o):(t.documents=s,t.pagination.documents=o)),e.next=12;break;case 8:e.prev=8,e.t0=e.catch(0),console.log(e.t0),t.$toast.error("No se pudo imprimir");case 12:return e.prev=12,t.loading=!1,e.finish(12);case 15:case"end":return e.stop()}},e,null,[[0,8,12,15]])}))()}}}},jgvo:function(t,e,n){var a=n("GCLO");"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);n("rjj0")("5890b909",a,!0,{})},mNWN:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-dialog",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],attrs:{visible:t.showDialog,"append-to-body":"",width:"60%",title:"Imprimir documento"},on:{close:t.close,open:t.open}},[n("div",{staticClass:"card p-2"},[n("div",{staticClass:"d-flex"},[n("div",{staticClass:"col-6 p-1 col-md-3"},[n("el-select",{model:{value:t.typeSearch,callback:function(e){t.typeSearch=e},expression:"typeSearch"}},[n("el-option",{attrs:{value:"document",label:"N° documento"}}),t._v(" "),n("el-option",{attrs:{value:"client",label:"Cliente"}}),t._v(" "),n("el-option",{attrs:{value:"date",label:"Fecha"}})],1)],1),t._v(" "),n("div",{staticClass:"col-6 p-1 col-md-3"},["date"!=t.typeSearch?n("el-input",{on:{input:t.getRecordsInput},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}}):n("el-date-picker",{attrs:{"value-format":"yyyy-MM-dd"},on:{change:t.getRecordsInput},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}})],1)]),t._v(" "),n("div",{staticClass:"d-flex align-items-center justify-content-end"},[n("span",{staticClass:"p-1"},[t._v("Ultimo documento emitido:\n                "+t._s(t.lastDocument?t.lastDocument.numberPrint:"No se encontró"))]),t._v(" "),n("el-button",{staticClass:"btn btn-primary",on:{click:function(e){return t.printData(t.lastDocument.external_id,t.lastDocument.document_type_id)}}},[n("i",{staticClass:"fas fa-print"})])],1),t._v(" "),n("div",[n("el-tabs",{on:{"tab-click":t.handleClick},model:{value:t.activeName,callback:function(e){t.activeName=e},expression:"activeName"}},[n("el-tab-pane",{attrs:{label:"Notas de venta",name:"saleNotes"}},[n("document-print-detail",{attrs:{company:t.company,records:t.saleNotes,pagination:t.pagination.saleNotes,type:"saleNotes",sender:t.sender},on:{getRecords:t.getRecords,printData:t.printData,"update:records":function(e){t.saleNotes=e},"update:pagination":function(e){return t.$set(t.pagination,"saleNotes",e)}}})],1),t._v(" "),"03"!=t.company.soap_type_id?n("el-tab-pane",{attrs:{label:"Facturas - Boletas",name:"documents"}},[n("document-print-detail",{attrs:{sender:t.sender,company:t.company,records:t.documents,pagination:t.pagination.documents,type:"documents"},on:{getRecords:t.getRecords,printData:t.printData,"update:records":function(e){t.documents=e},"update:pagination":function(e){return t.$set(t.pagination,"documents",e)}}})],1):t._e()],1)],1)])])},staticRenderFns:[]}},oJaa:function(t,e,n){var a=n("VU/8")(n("i8Tq"),n("mNWN"),!1,function(t){n("jgvo")},null,null);t.exports=a.exports},vPTa:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("En79"),r=n.n(a),s=n("Zher"),o=n.n(s);function i(t,e,n,a,r,s,o){try{var i=t[s](o),c=i.value}catch(t){return void n(t)}i.done?e(c):Promise.resolve(c).then(a,r)}function c(t){return function(){var e=this,n=arguments;return new Promise(function(a,r){var s=t.apply(e,n);function o(t){i(s,a,r,o,c,"next",t)}function c(t){i(s,a,r,o,c,"throw",t)}o(void 0)})}}e.default={components:{whatsappModal:o.a},props:["records","pagination","type","company","sender"],data:function(){return{loading:!1,showWhatsappModal:!1,currentId:null,currentType:null,currentNumber:null}},methods:{clickOpenWhatsapp:function(t){this.showWhatsappModal=!0,this.currentId=t.id,this.currentType=t.document_type_id,"saleNotes"==this.type?this.currentNumber=t.full_number:this.currentNumber=t.number},clickSendOnline:function(t){var e=this;return c(r.a.mark(function n(){var a;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.prev=0,e.loading=!0,n.next=4,e.$http.get("/documents/send/".concat(t));case 4:(a=n.sent).data.success?(e.$toast.success("Se envio satisfactoriamente el comprobante."),e.$eventHub.$emit("reloadData")):e.$toast.error(a.data.message),n.next=11;break;case 8:n.prev=8,n.t0=n.catch(0),e.$toast.error(n.t0.response.data.message);case 11:return n.prev=11,e.loading=!1,n.finish(11);case 14:case"end":return n.stop()}},n,null,[[0,8,11,14]])}))()},clickReStore:function(t){var e=this;return c(r.a.mark(function n(){var a;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.prev=0,e.loading=!0,n.next=4,e.$http.get("/documents/re_store/".concat(t));case 4:a=n.sent,console.log(a),a.data.success?e.$toast.success(a.data.message):e.$toast.error(a.data.message),n.next=12;break;case 9:n.prev=9,n.t0=n.catch(0),e.$toast.error(n.t0.response.data.message);case 12:return n.prev=12,e.loading=!1,n.finish(12);case 15:case"end":return n.stop()}},n,null,[[0,9,12,15]])}))()},clickValidarCpe:function(t){var e=this;return c(r.a.mark(function n(){var a;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.prev=0,e.loading=!0,n.next=4,e.$http.get("/documents/validate/".concat(t));case 4:(a=n.sent).data.success?(e.$toast.success(a.data.message),e.$emit("getRecords",e.pagination.current_page)):e.$toast.error(a.data.message),n.next=11;break;case 8:n.prev=8,n.t0=n.catch(0),e.$toast.error(n.t0.response.data.message);case 11:return n.prev=11,e.loading=!1,n.finish(11);case 14:case"end":return n.stop()}},n,null,[[0,8,11,14]])}))()},getRecords:function(){this.$emit("getRecords",this.pagination.current_page)},print:function(t,e){this.$emit("printData",t,e)}}}}});
//# sourceMappingURL=99.js.map
>>>>>>> master
=======
webpackJsonp([99],{D5Hx:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("el-dialog",{attrs:{title:t.titleDialog,visible:t.showDialog,"append-to-body":"","close-on-click-modal":!1},on:{close:t.close,open:t.create,opened:t.opened}},[s("form",{attrs:{autocomplete:"off"},on:{submit:function(e){return e.preventDefault(),t.submit.apply(null,arguments)}}},[s("div",{staticClass:"form-body"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.identity_document_type_id}},[s("label",{staticClass:"control-label"},[t._v("Tipo Doc. Identidad\n                            "),s("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),s("el-select",{attrs:{filterable:"","popper-class":"el-select-identity_document_type",dusk:"identity_document_type_id"},on:{change:t.changeIdentityDocType},model:{value:t.form.identity_document_type_id,callback:function(e){t.$set(t.form,"identity_document_type_id",e)},expression:"form.identity_document_type_id"}},t._l(t.identity_document_types,function(t){return s("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.identity_document_type_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.identity_document_type_id[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.number}},[s("label",{staticClass:"control-label"},[t._v("Número\n                            "),s("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),0!=t.api_service_token?s("div",[s("x-input-service",{attrs:{identity_document_type_id:t.form.identity_document_type_id},on:{search:t.searchNumber},model:{value:t.form.number,callback:function(e){t.$set(t.form,"number",e)},expression:"form.number"}})],1):s("div",[s("el-input",{attrs:{maxlength:t.maxLength,dusk:"number"},model:{value:t.form.number,callback:function(e){t.$set(t.form,"number",e)},expression:"form.number"}},["6"===t.form.identity_document_type_id||"1"===t.form.identity_document_type_id?[s("el-button",{attrs:{slot:"append",type:"primary",loading:t.loading_search,icon:"el-icon-search"},on:{click:function(e){return e.preventDefault(),t.searchCustomer.apply(null,arguments)}},slot:"append"})]:t._e(),t._v(" "),s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})],2)],1),t._v(" "),t.errors.number?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.number[0])}}):t._e()])]),t._v(" "),s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.name}},[s("label",{staticClass:"control-label"},[t._v("Nombre\n                            "),s("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),s("el-input",{attrs:{dusk:"name"},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.name?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.name[0])}}):t._e()],1)])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.trade_name}},[s("label",{staticClass:"control-label"},[t._v("Nombre comercial")]),t._v(" "),s("el-input",{attrs:{dusk:"trade_name"},model:{value:t.form.trade_name,callback:function(e){t.$set(t.form,"trade_name",e)},expression:"form.trade_name"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.trade_name?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.trade_name[0])}}):t._e()],1)])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-3"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.country_id}},[s("label",{staticClass:"control-label"},[t._v("País")]),t._v(" "),s("el-select",{attrs:{filterable:"",dusk:"country_id"},model:{value:t.form.country_id,callback:function(e){t.$set(t.form,"country_id",e)},expression:"form.country_id"}},t._l(t.countries,function(t){return s("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.country_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.country_id[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-3"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.department_id}},[s("label",{staticClass:"control-label"},[t._v("Departamento")]),t._v(" "),s("el-select",{attrs:{filterable:"","popper-class":"el-select-departments",dusk:"department_id"},on:{change:t.filterProvince},model:{value:t.form.department_id,callback:function(e){t.$set(t.form,"department_id",e)},expression:"form.department_id"}},t._l(t.all_departments,function(t){return s("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.department_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.department_id[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-3"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.province_id}},[s("label",{staticClass:"control-label"},[t._v("Provincia")]),t._v(" "),s("el-select",{attrs:{filterable:"","popper-class":"el-select-provinces",dusk:"province_id"},on:{change:t.filterDistrict},model:{value:t.form.province_id,callback:function(e){t.$set(t.form,"province_id",e)},expression:"form.province_id"}},t._l(t.provinces,function(t){return s("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.province_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.province_id[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-3"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.province_id}},[s("label",{staticClass:"control-label"},[t._v("Distrito")]),t._v(" "),s("el-select",{attrs:{filterable:"","popper-class":"el-select-districts",dusk:"district_id"},model:{value:t.form.district_id,callback:function(e){t.$set(t.form,"district_id",e)},expression:"form.district_id"}},t._l(t.districts,function(t){return s("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.district_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.district_id[0])}}):t._e()],1)])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.address}},[s("label",{staticClass:"control-label"},[t._v("Dirección")]),t._v(" "),s("el-input",{attrs:{dusk:"address"},model:{value:t.form.address,callback:function(e){t.$set(t.form,"address",e)},expression:"form.address"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.address?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.address[0])}}):t._e()],1)])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.telephone}},[s("label",{staticClass:"control-label"},[t._v("Teléfono")]),t._v(" "),s("el-input",{attrs:{dusk:"telephone"},model:{value:t.form.telephone,callback:function(e){t.$set(t.form,"telephone",e)},expression:"form.telephone"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.telephone?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.telephone[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.email}},[s("label",{staticClass:"control-label"},[t._v("Correo electrónico")]),t._v(" "),s("el-input",{attrs:{dusk:"email"},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.email?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.email[0])}}):t._e()],1)])]),t._v(" "),s("div",{staticClass:"row"},[t.form.state?s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group"},[s("label",{staticClass:"control-label"},[t._v("Estado del Contribuyente")]),t._v(" "),"ACTIVO"==t.form.state?[s("el-alert",{attrs:{title:""+t.form.state,type:"success","show-icon":"",closable:!1}})]:[s("el-alert",{attrs:{title:""+t.form.state,type:"error","show-icon":"",closable:!1}})]],2)]):t._e(),t._v(" "),t.form.condition?s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group"},[s("label",{staticClass:"control-label"},[t._v("Condición del Contribuyente")]),t._v(" "),"HABIDO"==t.form.condition?[s("el-alert",{attrs:{title:""+t.form.condition,type:"success","show-icon":"",closable:!1}})]:[s("el-alert",{attrs:{title:""+t.form.condition,type:"error","show-icon":"",closable:!1}})]],2)]):t._e()]),t._v(" "),"suppliers"===t.type?s("div",{staticClass:"row mt-2"},[s("div",{staticClass:"col-md-6 center-el-checkbox"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.perception_agent}},[s("el-checkbox",{model:{value:t.form.perception_agent,callback:function(e){t.$set(t.form,"perception_agent",e)},expression:"form.perception_agent"}},[t._v("¿Es agente de percepción?")]),s("br"),t._v(" "),t.errors.perception_agent?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.perception_agent[0])}}):t._e()],1)]),t._v(" "),"suppliers"===t.type?s("div",{directives:[{name:"show",rawName:"v-show",value:t.form.perception_agent,expression:"form.perception_agent"}],staticClass:"col-md-6"},[s("div",{staticClass:"form-group"},[s("label",{staticClass:"control-label"},[t._v("Porcentaje de percepción")]),t._v(" "),s("el-input",{model:{value:t.form.percentage_perception,callback:function(e){t.$set(t.form,"percentage_perception",e)},expression:"form.percentage_perception"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})])],1)]):t._e()]):t._e(),t._v(" "),t._l(t.form.addresses,function(e,r){return s("div",{key:r,staticClass:"row m-t-10"},[s("div",{staticClass:"col-md-12"},[0===r?s("label",{staticClass:"control-label"},[t._v("\n                        Dirección principal\n                    ")]):s("label",{staticClass:"control-label"},[t._v("\n                        Dirección secundaria # "+t._s(r)+"\n                        "),s("el-button",{staticClass:"btn-default-danger",attrs:{size:"mini",icon:"el-icon-minus"},on:{click:function(e){return e.preventDefault(),t.clickRemoveAddress(r)}}},[t._v("Eliminar dirección")])],1)]),t._v(" "),s("div",{staticClass:"col-md-4"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.country_id}},[s("label",{staticClass:"control-label"},[t._v("País")]),t._v(" "),s("el-select",{attrs:{filterable:""},model:{value:e.country_id,callback:function(s){t.$set(e,"country_id",s)},expression:"row.country_id"}},t._l(t.countries,function(t){return s("el-option",{key:t.id,attrs:{value:t.id,label:t.description}})}),1),t._v(" "),t.errors.country_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.country_id[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-8"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.location_id}},[s("label",{staticClass:"control-label"},[t._v("Ubigeo")]),t._v(" "),s("el-cascader",{attrs:{options:t.locations,clearable:!0,filterable:""},model:{value:e.location_id,callback:function(s){t.$set(e,"location_id",s)},expression:"row.location_id"}}),t._v(" "),t.errors.location_id?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.location_id[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.address}},[s("label",{staticClass:"control-label"},[t._v("Dirección")]),t._v(" "),s("el-input",{model:{value:e.address,callback:function(s){t.$set(e,"address",s)},expression:"row.address"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.address?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.address[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.phone}},[s("label",{staticClass:"control-label"},[t._v("Teléfono")]),t._v(" "),s("el-input",{model:{value:e.phone,callback:function(s){t.$set(e,"phone",s)},expression:"row.phone"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.phone?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.phone[0])}}):t._e()],1)]),t._v(" "),s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group",class:{"has-danger":t.errors.email}},[s("label",{staticClass:"control-label"},[t._v("Correo electrónico")]),t._v(" "),s("el-input",{model:{value:e.email,callback:function(s){t.$set(e,"email",s)},expression:"row.email"}},[s("i",{staticClass:"el-icon-edit-outline",attrs:{slot:"prefix"},slot:"prefix"})]),t._v(" "),t.errors.email?s("small",{staticClass:"text-danger",domProps:{textContent:t._s(t.errors.email[0])}}):t._e()],1)])])})],2),t._v(" "),s("div",{staticClass:"form-actions text-end pt-2 pb-2"},[s("el-button",{on:{click:function(e){return e.preventDefault(),t.close()}}},[t._v("Cancelar")]),t._v(" "),s("el-button",{attrs:{type:"primary","native-type":"submit",loading:t.loading_submit}},[t._v("Guardar")])],1)])])},staticRenderFns:[]}},H6o1:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=s("En79"),i=s.n(r),o=s("BDBD");function a(t,e,s,r,i,o,a){try{var n=t[o](a),l=n.value}catch(t){return void s(t)}n.done?e(l):Promise.resolve(l).then(r,i)}function n(t){return function(){var e=this,s=arguments;return new Promise(function(r,i){var o=t.apply(e,s);function n(t){a(o,r,i,n,l,"next",t)}function l(t){a(o,r,i,n,l,"throw",t)}n(void 0)})}}e.default={mixins:[o.c],props:["worker","showDialog","type","recordId","external","document_type_id","input_person","user_id"],data:function(){return{social_medias:[],loading_submit:!1,titleDialog:null,resource:this.worker?"restaurant/worker/persons":"persons",errors:{},api_service_token:!1,form:{},countries:[],all_departments:[],all_provinces:[],all_districts:[],provinces:[],districts:[],locations:[],person_types:[],identity_document_types:[],all_users:[]}},created:function(){var t=this;return n(i.a.mark(function e(){return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.initForm();case 2:return e.next=4,t.$http.get("/".concat(t.resource,"/tables")).then(function(e){t.api_service_token=e.data.api_service_token,t.social_medias=e.data.social_media,t.all_users=e.data.users,t.countries=e.data.countries,t.all_departments=e.data.departments,t.all_provinces=e.data.provinces,t.all_districts=e.data.districts,t.identity_document_types=e.data.identity_document_types,t.locations=e.data.locations,t.person_types=e.data.person_types});case 4:case"end":return e.stop()}},e)}))()},computed:{maxLength:function(){return"6"===this.form.identity_document_type_id?11:"1"===this.form.identity_document_type_id?8:void 0}},methods:{nuevoMetodo:function(){var t=this.all_users.find(function(t){return"admin"==t.type});t?this.form.seller_id=t.id:0!=this.all_users.length&&(this.form.seller_id=this.all_users[0].id)},initForm:function(){this.errors={},this.form={id:null,type:this.type,identity_document_type_id:"6",number:"",name:null,trade_name:null,country_id:"PE",department_id:null,province_id:null,district_id:null,address:null,telephone:null,condition:null,state:null,email:null,perception_agent:!1,percentage_perception:0,person_type_id:null,comment:null,addresses:[],seller_id:null}},opened:function(){var t=this;return n(i.a.mark(function e(){return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(!t.external||!t.input_person){e.next=8;break}if(8!==t.form.number.length&&11!==t.form.number.length){e.next=8;break}if(0==t.api_service_token){e.next=7;break}return e.next=5,t.$eventHub.$emit("enableClickSearch");case 5:e.next=8;break;case 7:t.searchCustomer();case 8:case"end":return e.stop()}},e)}))()},create:function(){var t=this;this.external&&("01"===this.document_type_id&&(this.form.identity_document_type_id="6"),"03"===this.document_type_id&&(this.form.identity_document_type_id="1"),this.input_person&&(this.form.identity_document_type_id=this.input_person.identity_document_type_id?this.input_person.identity_document_type_id:this.form.identity_document_type_id,this.form.number=this.input_person.number?this.input_person.number:"")),void 0==this.type&&(this.titleDialog="Nuevo Cliente"),"customers"===this.type&&(this.titleDialog=this.recordId?"Editar Cliente":"Nuevo Cliente"),"suppliers"===this.type&&(this.titleDialog=this.recordId?"Editar Proveedor":"Nuevo Proveedor"),this.recordId&&this.$http.get("/".concat(this.resource,"/record/").concat(this.recordId)).then(function(e){t.form=e.data.data,t.filterProvinces(),t.filterDistricts()})},clickAddAddress:function(){this.form.addresses.push({id:null,country_id:"PE",location_id:[],address:null,email:null,phone:null,main:!1})},submit:function(){var t=this;this.nuevoMetodo(),this.form.seller_id?"6"!=this.form.identity_document_type_id||11==this.form.number.length?"1"!=this.form.identity_document_type_id||8==this.form.number.length?(this.loading_submit=!0,this.$http.post("/".concat(this.resource),this.form).then(function(e){e.data.success?(t.$toast.success(e.data.message),t.$emit("add_customer",e.data.id),t.external?t.$eventHub.$emit("reloadDataPersons",e.data.id):t.$eventHub.$emit("reloadData"),t.close()):t.$toast.error(e.data.message)}).catch(function(e){422===e.response.status?(console.log(e.response.data.errors),t.errors=e.response.data.errors):console.log(e)}).then(function(){t.loading_submit=!1})):this.$toast.error("La longitud del DNI debe ser de 8"):this.$toast.error("La longitud del RUC debe ser de 11"):this.$toast.error("Debe seleccionar un asesor")},changeIdentityDocType:function(){null==this.recordId&&this.setDataDefaultCustomer()},setDataDefaultCustomer:function(){"0"==this.form.identity_document_type_id?(this.form.number="99999999",this.form.name="Clientes - Varios"):(this.form.number="",this.form.name=null)},close:function(){this.$eventHub.$emit("initInputPerson"),this.$emit("update:showDialog",!1),this.initForm()},searchCustomer:function(){this.searchServiceNumberByType()},searchNumber:function(t){this.form.district_id=t.ubigeo[2],this.filterDistricts(),this.form.name="1"===this.form.identity_document_type_id?t.nombre_completo:t.nombre_o_razon_social,this.form.trade_name="6"===this.form.identity_document_type_id?t.nombre_o_razon_social:"",this.form.location_id=t.ubigeo,this.form.department_id=t.ubigeo?t.ubigeo[0]:null,this.form.province_id=t.ubigeo?t.ubigeo[1]:null,this.form.district_id=t.ubigeo?t.ubigeo[2]:null,this.filterProvinces(),this.filterDistricts(),this.form.address=t.direccion,this.form.condition=t.condicion,this.form.state=t.estado},clickRemoveAddress:function(t){this.form.addresses.splice(t,1)}}}},N7nD:function(t,e,s){var r=s("VU/8")(s("H6o1"),s("D5Hx"),!1,null,null,null);t.exports=r.exports}});
//# sourceMappingURL=99.js.map
>>>>>>> master
=======
//# sourceMappingURL=99.js.map
>>>>>>> master
