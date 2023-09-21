webpackJsonp([148],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/item_sets/form.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_item_vue__ = __webpack_require__("./resources/js/views/item_sets/partials/item.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__partials_item_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__partials_item_vue__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["showDialog", "recordId", "external", "establishment_id"],
  components: {
    ItemSetFormItem: __WEBPACK_IMPORTED_MODULE_1__partials_item_vue___default.a
  },
  data: function data() {
    return {
      showDialogAddItem: false,
      warehouses: [],
      loading_submit: false,
      showPercentagePerception: false,
      has_percentage_perception: false,
      percentage_perception: null,
      enabled_percentage_of_profit: false,
      titleDialog: null,
      resource: "item-sets",
      errors: {},
      headers: headers_token,
      form_category: {
        add: false,
        name: null,
        id: null
      },
      form: {},
      areas: [],
      categories: [],
      unit_types: [],
      currency_types: [],
      individual_items: [],
      system_isc_types: [],
      affectation_igv_types: [],
      internal_id: null,
      affectation_igv_type_id: null,
      accounts: [],
      show_has_igv: true,
      have_account: false,
      web_platforms: [],
      item_unit_type: {
        id: null,
        unit_type_id: null,
        quantity_unit: 0,
        price1: 0,
        price2: 0,
        price3: 0,
        price_default: 2
      }
    };
  },
  created: function created() {
    var _this = this;

    this.initForm();
    this.$eventHub.$on("submitPercentagePerception", function (data) {
      _this.form.percentage_perception = data;
      if (!_this.form.percentage_perception) _this.has_percentage_perception = false;
    });
  },
  methods: {
    clickRemoveItem: function clickRemoveItem(index) {
      this.form.individual_items.splice(index, 1);
      this.changeIndividualItems();
    },
    addRow: function addRow(row) {
      var exist = this.form.individual_items.find(function (item) {
        return item.individual_item_id == row.individual_item_id;
      });

      if (exist) {
        exist.quantity += row.quantity;
      } else {
        this.form.individual_items.push(row);
      } // console.log(row)


      this.changeIndividualItems();
    },
    saveCategory: function saveCategory() {
      var _this2 = this;

      this.form_category.add = false;
      this.$http.post("/items/categories", this.form_category).then(function (response) {
        if (response.data.success) {
          _this2.$toast.success(response.data.message);

          _this2.categories.push(response.data.data);

          _this2.form.category_id = response.data.data.id;
          _this2.form_category.name = null;
        } else {
          _this2.$toast.error("No se guardaron los cambios");
        }
      })["catch"](function (error) {});
    },
    changeIndividualItems: function changeIndividualItems() {// let acum_sale_unit_price = 0
      // this.form.individual_items.forEach(row => {
      //     // let individual_item = _.find(this.individual_items,{'id':id})
      //     acum_sale_unit_price += parseFloat(row.sale_unit_price) * parseFloat(row.quantity)
      // });
      // this.form.sale_unit_price = acum_sale_unit_price
      // this.form.sale_unit_price_set = acum_sale_unit_price
    },
    initForm: function initForm() {
      this.loading_submit = false, this.errors = {};
      this.form = {
        warehouse_id: null,
        id: null,
        item_type_id: "01",
        internal_id: null,
        item_code: null,
        item_code_gs1: null,
        description: null,
        name: null,
        second_name: null,
        unit_type_id: "NIU",
        currency_type_id: "PEN",
        sale_unit_price: 0,
        purchase_unit_price: 0,
        has_isc: false,
        system_isc_type_id: null,
        percentage_isc: 0,
        suggested_price: 0,
        sale_affectation_igv_type_id: null,
        purchase_affectation_igv_type_id: null,
        calculate_quantity: false,
        stock: 0,
        stock_min: 1,
        has_igv: true,
        has_perception: false,
        item_unit_types: [],
        percentage_of_profit: 0,
        percentage_perception: 0,
        image: null,
        image_url: null,
        temp_path: null,
        account_id: null,
        is_set: true,
        sale_unit_price_set: 0,
        date_of_due: null,
        web_platform_id: null,
        category_id: null,
        area_id: null,
        individual_items: [],
        attributes: []
      };
      this.show_has_igv = true;
      this.enabled_percentage_of_profit = false;
    },
    onSuccess: function onSuccess(response, file, fileList) {
      if (response.success) {
        this.form.image = response.data.filename;
        this.form.image_url = response.data.temp_image;
        this.form.temp_path = response.data.temp_path;
      } else {
        this.$toast.error(response.message);
      }
    },
    changeAffectationIgvType: function changeAffectationIgvType() {
      var is_exonerated = false;

      if (is_exonerated) {
        this.show_has_igv = false;
        this.form.has_igv = true;
      } else {
        this.show_has_igv = true;
      }
    },
    resetForm: function resetForm() {
      this.initForm();
      this.form.sale_affectation_igv_type_id = this.affectation_igv_types.length > 0 ? this.affectation_igv_types[0].id : null;
      this.form.purchase_affectation_igv_type_id = this.affectation_igv_types.length > 0 ? this.affectation_igv_types[0].id : null;
    },
    create: function create() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, categoria_packs, area_caja;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this3.$http.get("/".concat(_this3.resource, "/tables"));

              case 2:
                response = _context.sent;
                _this3.unit_types = response.data.unit_types;
                _this3.accounts = response.data.accounts;
                _this3.currency_types = response.data.currency_types;
                _this3.system_isc_types = response.data.system_isc_types;
                _this3.affectation_igv_types = response.data.affectation_igv_types;
                _this3.affectation_igv_type_id = response.data.affectation_igv_type_id;
                _this3.internal_id = response.data.internal_id;
                _this3.areas = response.data.areas;
                _this3.categories = response.data.categories; // this.individual_items = response.data.individual_items

                _this3.warehouses = response.data.warehouses;

                if (_this3.warehouses.length > 0) {
                  _this3.form.warehouse_id = _this3.warehouses[0].id;
                }

                if (_this3.establishment_id) {
                  _this3.form.warehouse_id = _this3.establishment_id;
                }

                _this3.web_platforms = response.data.web_platforms;
                _this3.form.sale_affectation_igv_type_id = _this3.affectation_igv_types.length > 0 ? _this3.affectation_igv_types[0].id : null;
                _this3.form.purchase_affectation_igv_type_id = _this3.affectation_igv_types.length > 0 ? _this3.affectation_igv_types[0].id : null;
                _this3.titleDialog = _this3.recordId ? "Editar producto compuesto" : "Nuevo producto compuesto";

                if (_this3.recordId) {
                  _this3.$http.get("/".concat(_this3.resource, "/record/").concat(_this3.recordId)).then(function (response) {
                    _this3.form = response.data.data;

                    _this3.changeAffectationIgvType();
                  });
                } else {}

                if (!_this3.form.category_id && _this3.categories.length > 0) {
                  categoria_packs = _this3.categories.find(function (area) {
                    return area.name == "PACKS";
                  });

                  if (categoria_packs) {
                    _this3.form.category_id = categoria_packs.id;
                  }
                }

                if (!_this3.form.warehouse_id && _this3.warehouses.length > 0) {
                  _this3.form.warehouse_id = _this3.warehouses[0].id;
                }

                if (!_this3.form.area_id && _this3.areas.length > 0) {
                  area_caja = _this3.areas.find(function (area) {
                    return area.description == "CAJA";
                  });

                  if (area_caja) {
                    _this3.form.area_id = area_caja.id;
                  }
                }

                if (_this3.affectation_igv_type_id && !_this3.recordId) {
                  console.log("xd");
                  _this3.form.sale_affectation_igv_type_id = _this3.affectation_igv_type_id;
                }

                if (!_this3.form.internal_id && _this3.internal_id) {
                  _this3.form.internal_id = _this3.internal_id;
                }

              case 25:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    loadRecord: function loadRecord() {
      var _this4 = this;

      if (this.recordId) {
        this.$http.get("/".concat(this.resource, "/record/").concat(this.recordId)).then(function (response) {
          _this4.form = response.data.data;

          _this4.changeAffectationIgvType();
        });
      }
    },
    changeHaveAccount: function changeHaveAccount() {
      if (!this.have_account) this.form.account_id = null;
    },
    changeEnabledPercentageOfProfit: function changeEnabledPercentageOfProfit() {// if(!this.enabled_percentage_of_profit) this.form.percentage_of_profit = 0
    },
    clickDelete: function clickDelete(id) {
      var _this5 = this;

      this.$http["delete"]("/".concat(this.resource, "/item-unit-type/").concat(id)).then(function (res) {
        if (res.data.success) {
          _this5.loadRecord();

          _this5.$toast.success("Se eliminó correctamente el registro");
        }
      })["catch"](function (error) {
        if (error.response.status === 500) {
          _this5.$toast.error("Error al intentar eliminar");
        } else {
          console.log(error.response.data.message);
        }
      });
    },
    changeHasPerception: function changeHasPerception() {
      if (!this.form.has_perception) {
        this.form.percentage_perception = null;
      }
    },
    clickAddRow: function clickAddRow() {
      this.form.item_unit_types.push({
        id: null,
        description: null,
        unit_type_id: "NIU",
        quantity_unit: 0,
        price1: 0,
        price2: 0,
        price3: 0,
        price_default: 2
      });
    },
    clickCancel: function clickCancel(index) {
      this.form.item_unit_types.splice(index, 1); // this.initDocumentTypes()
      // this.showAddButton = true
    },
    calculatePercentageOfProfitBySale: function calculatePercentageOfProfitBySale() {
      var difference = parseFloat(this.form.sale_unit_price) - parseFloat(this.form.purchase_unit_price);

      if (parseFloat(this.form.purchase_unit_price) === 0) {
        this.form.percentage_of_profit = 0;
      } else {
        if (this.enabled_percentage_of_profit) this.form.percentage_of_profit = difference / parseFloat(this.form.purchase_unit_price) * 100;
      }
    },
    calculatePercentageOfProfitByPurchase: function calculatePercentageOfProfitByPurchase() {
      if (this.form.percentage_of_profit === "") {
        this.form.percentage_of_profit = 0;
      }

      if (this.enabled_percentage_of_profit) this.form.sale_unit_price = this.form.purchase_unit_price * (100 + parseFloat(this.form.percentage_of_profit)) / 100;
    },
    calculatePercentageOfProfitByPercentage: function calculatePercentageOfProfitByPercentage() {
      if (this.form.percentage_of_profit === "") {
        this.form.percentage_of_profit = 0;
      }

      if (this.enabled_percentage_of_profit) this.form.sale_unit_price = this.form.purchase_unit_price * (100 + parseFloat(this.form.percentage_of_profit)) / 100;
    },
    submit: function submit() {
      var _this6 = this;

      if (this.form.category_id === null) return this.$toast.error("Debe seleccionar una categoría");
      if (this.form.individual_items.length < 1) return this.$toast.error("Al menos debe elegir 2 productos");
      this.form.sale_unit_price_set = this.form.sale_unit_price;
      this.form.attributes = this.form.attributes ? this.form.attributes : [];
      this.loading_submit = true;
      this.$http.post("/".concat(this.resource), this.form).then(function (response) {
        if (response.data.success) {
          _this6.$toast.success(response.data.message);

          if (_this6.external) {
            _this6.$eventHub.$emit("reloadDataItems", response.data.id);
          } else {
            _this6.$eventHub.$emit("reloadData");
          }

          _this6.close();
        } else {
          _this6.$toast.error(response.data.message);
        }
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this6.errors = error.response.data;
        } else {
          console.log(error);
        }
      }).then(function () {
        _this6.loading_submit = false;
      });
    },
    close: function close() {
      this.$emit("update:showDialog", false);
      this.resetForm();
    },
    changeHasIsc: function changeHasIsc() {
      this.form.system_isc_type_id = null;
      this.form.percentage_isc = 0;
      this.form.suggested_price = 0;
    },
    changeSystemIscType: function changeSystemIscType() {
      if (this.form.system_isc_type_id !== "03") {
        this.form.suggested_price = 0;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/item_sets/partials/item.vue":
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["showDialog", "warehouse_id"],
  data: function data() {
    return {
      titleDialog: "Agregar Producto",
      resource: "item-sets",
      errors: {},
      form: {},
      individual_items: [],
      timer: null
    };
  },
  created: function created() {
    this.initForm();
  },
  methods: {
    getRecords: function getRecords() {
      var _this = this;

      var input = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
      var timeout = 350;

      if (input == "") {
        timeout = 0;
      }

      if (this.timer != null) clearTimeout(this.timer);
      this.timer = setTimeout(function () {
        _this.$http.get("/".concat(_this.resource, "/item/tables?warehouse_id=").concat(_this.warehouse_id || "", "&input=").concat(input || "")).then(function (response) {
          _this.individual_items = response.data.individual_items;
          console.log(_this.individual_items);
        });
      }, timeout);
    },
    initForm: function initForm() {
      this.errors = {};
      this.form = {
        unit_type_description: null,
        individual_item_id: null,
        sale_unit_price: 0,
        quantity: 1,
        full_description: null
      };
    },
    create: function create() {
      this.getRecords();
    },
    close: function close() {
      this.initForm();
      this.$emit("update:showDialog", false);
    },
    changeItem: function changeItem() {
      var item = _.find(this.individual_items, {
        id: this.form.individual_item_id
      });

      this.form.sale_unit_price = item.sale_unit_price;
      this.form.full_description = item.full_description;
      this.form.unit_type_description = item.unit_type_description;
    },
    clickAddItem: function clickAddItem() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.$emit("add", _this2.form);

                _this2.initForm();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e5c2af\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/item_sets/partials/item.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(true);
// imports


// module
exports.push([module.i, "\n.el-select-dropdown {\r\n    max-width: 80% !important;\r\n    margin-right: 5% !important;\n}\r\n", "", {"version":3,"sources":["D:/laragon/www/sdrimsac-tenant/resources/js/views/item_sets/partials/resources/js/views/item_sets/partials/item.vue"],"names":[],"mappings":";AA2EA;IACA,0BAAA;IACA,4BAAA;CACA","file":"item.vue","sourcesContent":["<template>\r\n    <el-dialog\r\n        :title=\"titleDialog\"\r\n        :visible=\"showDialog\"\r\n        @open=\"create\"\r\n        @close=\"close\"\r\n        append-to-body\r\n    >\r\n        <form autocomplete=\"off\" @submit.prevent=\"clickAddItem\">\r\n            <div class=\"form-body\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-8 col-lg-8 col-xl-8 col-sm-8\">\r\n                        <div\r\n                            class=\"form-group\"\r\n                            :class=\"{ 'has-danger': errors.individual_item_id }\"\r\n                        >\r\n                            <label class=\"control-label\">\r\n                                Producto\r\n                            </label>\r\n                            <el-select\r\n                                v-model=\"form.individual_item_id\"\r\n                                @change=\"changeItem\"\r\n                                remote\r\n                                :remote-method=\"getRecords\"\r\n                                filterable\r\n                                placeholder=\"Buscar\"\r\n                            >\r\n                                <el-option\r\n                                    v-for=\"option in individual_items\"\r\n                                    :key=\"option.id\"\r\n                                    :value=\"option.id\"\r\n                                    :label=\"option.full_description\"\r\n                                ></el-option>\r\n                            </el-select>\r\n\r\n                            <small\r\n                                class=\"form-control-feedback\"\r\n                                v-if=\"errors.individual_item_id\"\r\n                                v-text=\"errors.individual_item_id[0]\"\r\n                            ></small>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-md-4\">\r\n                        <div\r\n                            class=\"form-group\"\r\n                            :class=\"{ 'has-danger': errors.quantity }\"\r\n                        >\r\n                            <label class=\"control-label\">Cantidad</label>\r\n                            <el-input-number\r\n                                class=\"w-100\"\r\n                                v-model=\"form.quantity\"\r\n                                :min=\"0.01\"\r\n                            ></el-input-number>\r\n                            <small\r\n                                class=\"form-control-feedback\"\r\n                                v-if=\"errors.quantity\"\r\n                                v-text=\"errors.quantity[0]\"\r\n                            ></small>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"form-actions text-right mt-2\">\r\n                <el-button @click.prevent=\"close()\">Cerrar</el-button>\r\n                <el-button\r\n                    type=\"primary\"\r\n                    native-type=\"submit\"\r\n                    v-if=\"form.individual_item_id\"\r\n                    >Agregar</el-button\r\n                >\r\n            </div>\r\n        </form>\r\n    </el-dialog>\r\n</template>\r\n<style>\r\n.el-select-dropdown {\r\n    max-width: 80% !important;\r\n    margin-right: 5% !important;\r\n}\r\n</style>\r\n<script>\r\nexport default {\r\n    props: [\"showDialog\", \"warehouse_id\"],\r\n    data() {\r\n        return {\r\n            titleDialog: \"Agregar Producto\",\r\n            resource: \"item-sets\",\r\n            errors: {},\r\n            form: {},\r\n            individual_items: [],\r\n            timer: null\r\n        };\r\n    },\r\n    created() {\r\n        this.initForm();\r\n    },\r\n    methods: {\r\n        getRecords(input = \"\") {\r\n            let timeout = 350;\r\n            if (input == \"\") {\r\n                timeout = 0;\r\n            }\r\n            if (this.timer != null) clearTimeout(this.timer);\r\n\r\n            this.timer = setTimeout(() => {\r\n                this.$http\r\n                    .get(\r\n                        `/${this.resource}/item/tables?warehouse_id=${this\r\n                            .warehouse_id || \"\"}&input=${input || \"\"}`\r\n                    )\r\n                    .then(response => {\r\n                        this.individual_items = response.data.individual_items;\r\n                        console.log(this.individual_items);\r\n                    });\r\n            }, timeout);\r\n        },\r\n        initForm() {\r\n            this.errors = {};\r\n\r\n            this.form = {\r\n                unit_type_description: null,\r\n                individual_item_id: null,\r\n                sale_unit_price: 0,\r\n                quantity: 1,\r\n                full_description: null\r\n            };\r\n        },\r\n        create() {\r\n            this.getRecords();\r\n        },\r\n        close() {\r\n            this.initForm();\r\n            this.$emit(\"update:showDialog\", false);\r\n        },\r\n        changeItem() {\r\n            let item = _.find(this.individual_items, {\r\n                id: this.form.individual_item_id\r\n            });\r\n            this.form.sale_unit_price = item.sale_unit_price;\r\n            this.form.full_description = item.full_description;\r\n            this.form.unit_type_description = item.unit_type_description;\r\n        },\r\n        async clickAddItem() {\r\n            this.$emit(\"add\", this.form);\r\n            this.initForm();\r\n        }\r\n    }\r\n};\r\n</script>\r\n"],"sourceRoot":""}]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-36e5c2af\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/item_sets/partials/item.vue":
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
        "append-to-body": ""
      },
      on: { open: _vm.create, close: _vm.close }
    },
    [
      _c(
        "form",
        {
          attrs: { autocomplete: "off" },
          on: {
            submit: function($event) {
              $event.preventDefault()
              return _vm.clickAddItem.apply(null, arguments)
            }
          }
        },
        [
          _c("div", { staticClass: "form-body" }, [
            _c("div", { staticClass: "row" }, [
              _c(
                "div",
                { staticClass: "col-md-8 col-lg-8 col-xl-8 col-sm-8" },
                [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.individual_item_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v(
                          "\n                            Producto\n                        "
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            remote: "",
                            "remote-method": _vm.getRecords,
                            filterable: "",
                            placeholder: "Buscar"
                          },
                          on: { change: _vm.changeItem },
                          model: {
                            value: _vm.form.individual_item_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "individual_item_id", $$v)
                            },
                            expression: "form.individual_item_id"
                          }
                        },
                        _vm._l(_vm.individual_items, function(option) {
                          return _c("el-option", {
                            key: option.id,
                            attrs: {
                              value: option.id,
                              label: option.full_description
                            }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.errors.individual_item_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(
                                _vm.errors.individual_item_id[0]
                              )
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-4" }, [
                _c(
                  "div",
                  {
                    staticClass: "form-group",
                    class: { "has-danger": _vm.errors.quantity }
                  },
                  [
                    _c("label", { staticClass: "control-label" }, [
                      _vm._v("Cantidad")
                    ]),
                    _vm._v(" "),
                    _c("el-input-number", {
                      staticClass: "w-100",
                      attrs: { min: 0.01 },
                      model: {
                        value: _vm.form.quantity,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "quantity", $$v)
                        },
                        expression: "form.quantity"
                      }
                    }),
                    _vm._v(" "),
                    _vm.errors.quantity
                      ? _c("small", {
                          staticClass: "form-control-feedback",
                          domProps: {
                            textContent: _vm._s(_vm.errors.quantity[0])
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
            { staticClass: "form-actions text-right mt-2" },
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
                [_vm._v("Cerrar")]
              ),
              _vm._v(" "),
              _vm.form.individual_item_id
                ? _c(
                    "el-button",
                    { attrs: { type: "primary", "native-type": "submit" } },
                    [_vm._v("Agregar")]
                  )
                : _vm._e()
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
    require("vue-hot-reload-api")      .rerender("data-v-36e5c2af", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-61a1c556\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/item_sets/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        width: "65%",
        title: _vm.titleDialog,
        visible: _vm.showDialog,
        "close-on-click-modal": false,
        "append-to-body": "",
        top: "7vh"
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
            _c(
              "div",
              { staticClass: "row" },
              [
                _c("div", { staticClass: "col-md-8" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.description }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Nombre"),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        attrs: { dusk: "description" },
                        model: {
                          value: _vm.form.description,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "description", $$v)
                          },
                          expression: "form.description"
                        }
                      }),
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
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: {
                        "has-danger": _vm.errors.sale_affectation_igv_type_id
                      }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Lugar de Preparación")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          model: {
                            value: _vm.form.area_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "area_id", $$v)
                            },
                            expression: "form.area_id"
                          }
                        },
                        _vm._l(_vm.areas, function(option) {
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
                      _vm.errors.sale_affectation_igv_type_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(
                                _vm.errors.sale_affectation_igv_type_id[0]
                              )
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-9" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-group",
                      class: { "has-danger": _vm.errors.name }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Descripción")
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        attrs: { dusk: "name" },
                        model: {
                          value: _vm.form.name,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "name", $$v)
                          },
                          expression: "form.name"
                        }
                      }),
                      _vm._v(" "),
                      _vm.errors.name
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.name[0])
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
                      class: { "has-danger": _vm.errors.unit_type_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Unidad")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { dusk: "unit_type_id" },
                          model: {
                            value: _vm.form.unit_type_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "unit_type_id", $$v)
                            },
                            expression: "form.unit_type_id"
                          }
                        },
                        _vm._l(_vm.unit_types, function(option) {
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
                      _vm.errors.unit_type_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.unit_type_id[0])
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
                      class: { "has-danger": _vm.errors.currency_type_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v("Moneda")
                      ]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: { dusk: "currency_type_id" },
                          model: {
                            value: _vm.form.currency_type_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "currency_type_id", $$v)
                            },
                            expression: "form.currency_type_id"
                          }
                        },
                        _vm._l(_vm.currency_types, function(option) {
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
                      _vm.errors.currency_type_id
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(
                                _vm.errors.currency_type_id[0]
                              )
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
                      class: { "has-danger": _vm.errors.sale_unit_price }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v(
                          "Precio Unitario (Venta)\n                            "
                        ),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v("*")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("el-input", {
                        attrs: { dusk: "sale_unit_price" },
                        on: { input: _vm.calculatePercentageOfProfitBySale },
                        model: {
                          value: _vm.form.sale_unit_price,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "sale_unit_price", $$v)
                          },
                          expression: "form.sale_unit_price"
                        }
                      }),
                      _vm._v(" "),
                      _vm.errors.sale_unit_price
                        ? _c("small", {
                            staticClass: "form-control-feedback",
                            domProps: {
                              textContent: _vm._s(_vm.errors.sale_unit_price[0])
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
                      class: { "has-danger": _vm.errors.category_id }
                    },
                    [
                      _c("label", { staticClass: "control-label" }, [
                        _vm._v(
                          "\n                            Categoría\n                        "
                        )
                      ]),
                      _vm._v(" "),
                      _vm.form_category.add == false
                        ? _c(
                            "a",
                            {
                              staticClass:
                                "control-label font-weight-bold text-info",
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  _vm.form_category.add = true
                                }
                              }
                            },
                            [_vm._v("\n                            [ + Nuevo]")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.form_category.add == true
                        ? _c(
                            "a",
                            {
                              staticClass:
                                "control-label font-weight-bold text-info",
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  return _vm.saveCategory()
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n                            [ + Guardar]"
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.form_category.add == true
                        ? _c(
                            "a",
                            {
                              staticClass:
                                "control-label font-weight-bold text-danger",
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  _vm.form_category.add = false
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n                            [ Cancelar]"
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.form_category.add == true
                        ? _c(
                            "el-input",
                            {
                              staticStyle: { "margin-bottom": "1.5%" },
                              attrs: { dusk: "item_code" },
                              model: {
                                value: _vm.form_category.name,
                                callback: function($$v) {
                                  _vm.$set(_vm.form_category, "name", $$v)
                                },
                                expression: "form_category.name"
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
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.form_category.add == false
                        ? _c(
                            "el-select",
                            {
                              attrs: { filterable: "", clearable: "" },
                              model: {
                                value: _vm.form.category_id,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "category_id", $$v)
                                },
                                expression: "form.category_id"
                              }
                            },
                            _vm._l(_vm.categories, function(option) {
                              return _c("el-option", {
                                key: option.id,
                                attrs: { value: option.id, label: option.name }
                              })
                            }),
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.errors.category_id
                        ? _c("small", {
                            staticClass: "text-danger",
                            domProps: {
                              textContent: _vm._s(_vm.errors.category_id[0])
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.recordId == null,
                        expression: "recordId == null"
                      }
                    ],
                    staticClass: "col-md-3"
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass: "form-group",
                        class: { "has-danger": _vm.errors.warehouse_id }
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "control-label" },
                          [
                            _vm._v(
                              "\n                            Almacén\n                            "
                            ),
                            _c(
                              "el-tooltip",
                              {
                                staticClass: "item",
                                attrs: {
                                  effect: "dark",
                                  content:
                                    "Si no selecciona almacén, se asignará por defecto el relacionado al establecimiento",
                                  placement: "top"
                                }
                              },
                              [_c("i", { staticClass: "fa fa-info-circle" })]
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            attrs: {
                              disabled: _vm.establishment_id != null,
                              filterable: ""
                            },
                            model: {
                              value: _vm.form.warehouse_id,
                              callback: function($$v) {
                                _vm.$set(_vm.form, "warehouse_id", $$v)
                              },
                              expression: "form.warehouse_id"
                            }
                          },
                          _vm._l(_vm.warehouses, function(option) {
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
                        _vm.errors.warehouse_id
                          ? _c("small", {
                              staticClass: "form-control-feedback",
                              domProps: {
                                textContent: _vm._s(_vm.errors.warehouse_id[0])
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]
                ),
                _vm._v(" "),
                _vm.form.individual_items.length > 0
                  ? _c("div", { staticClass: "col-md-12 mt-2" }, [
                      _c("div", { staticClass: "table-responsive" }, [
                        _c("table", { staticClass: "table" }, [
                          _c("thead", [
                            _c("tr", [
                              _c("th", [_vm._v("#")]),
                              _vm._v(" "),
                              _c("th", { staticClass: "font-weight-bold" }, [
                                _vm._v(
                                  "\n                                        Descripción\n                                    "
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "th",
                                { staticClass: "text-center font-weight-bold" },
                                [
                                  _vm._v(
                                    "\n                                        Precio Unitario\n                                    "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                { staticClass: "text-right font-weight-bold" },
                                [
                                  _vm._v(
                                    "\n                                        Cantidad\n                                    "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c("th")
                            ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            _vm._l(_vm.form.individual_items, function(
                              row,
                              index
                            ) {
                              return _c("tr", { key: index }, [
                                _c("td", [_vm._v(_vm._s(index + 1))]),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(_vm._s(row.full_description))
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    "\n                                        " +
                                      _vm._s(row.sale_unit_price) +
                                      "\n                                    "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-right" }, [
                                  _vm._v(
                                    "\n                                        " +
                                      _vm._s(row.quantity) +
                                      "\n                                        " +
                                      _vm._s(row.unit_type_description) +
                                      "\n                                    "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-right" }, [
                                  _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn waves-effect waves-light btn-xs btn-danger",
                                      attrs: { type: "button" },
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.clickRemoveItem(index)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                            x\n                                        "
                                      )
                                    ]
                                  )
                                ])
                              ])
                            }),
                            0
                          )
                        ])
                      ])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-3 mt-4" },
                  [
                    _c(
                      "el-button",
                      {
                        attrs: { type: "primary", icon: "el-icon-plus" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            _vm.showDialogAddItem = true
                          }
                        }
                      },
                      [_vm._v("Agregar productos")]
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row col-md-12" }, [
                  _c("div", { staticClass: "col-md-3" }, [
                    _c(
                      "div",
                      { staticClass: "form-group" },
                      [
                        _c("label", { staticClass: "control-label" }, [
                          _vm._v("Imágen "),
                          _c("span", { staticClass: "text-danger" })
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-upload",
                          {
                            staticClass: "avatar-uploader",
                            attrs: {
                              data: { type: "items" },
                              headers: _vm.headers,
                              action: "/" + _vm.resource + "/upload",
                              "show-file-list": false,
                              "on-success": _vm.onSuccess
                            }
                          },
                          [
                            _vm.form.image_url
                              ? _c("img", {
                                  staticClass: "avatar",
                                  attrs: { src: _vm.form.image_url }
                                })
                              : _c("i", {
                                  staticClass:
                                    "el-icon-plus avatar-uploader-icon"
                                })
                          ]
                        )
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-9" }, [
                    _c("div", { staticClass: "row" }, [
                      _c("div", { staticClass: "short-div col-md-8" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger":
                                _vm.errors.purchase_affectation_igv_type_id
                            }
                          },
                          [
                            _c("label", { staticClass: "control-label" }, [
                              _vm._v("Tipo de afectación (Venta)")
                            ]),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                on: { change: _vm.changeAffectationIgvType },
                                model: {
                                  value: _vm.form.sale_affectation_igv_type_id,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.form,
                                      "sale_affectation_igv_type_id",
                                      $$v
                                    )
                                  },
                                  expression:
                                    "\n                                            form.sale_affectation_igv_type_id\n                                        "
                                }
                              },
                              _vm._l(_vm.affectation_igv_types, function(
                                option
                              ) {
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
                            _vm.errors.sale_affectation_igv_type_id
                              ? _c("small", {
                                  staticClass: "form-control-feedback",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.sale_affectation_igv_type_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "short-div col-md-4" }, [
                        _c(
                          "div",
                          {
                            staticClass: "form-group",
                            class: {
                              "has-danger": _vm.errors.internal_id
                            }
                          },
                          [
                            _c(
                              "label",
                              { staticClass: "control-label" },
                              [
                                _vm._v(
                                  "Código Interno\n                                        "
                                ),
                                _c(
                                  "el-tooltip",
                                  {
                                    staticClass: "item",
                                    attrs: {
                                      effect: "dark",
                                      content:
                                        "Código interno de la empresa para el control de sus productos",
                                      placement: "top-start"
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "fa fa-info-circle"
                                    })
                                  ]
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { dusk: "internal_id" },
                              model: {
                                value: _vm.form.internal_id,
                                callback: function($$v) {
                                  _vm.$set(_vm.form, "internal_id", $$v)
                                },
                                expression: "form.internal_id"
                              }
                            }),
                            _vm._v(" "),
                            _vm.errors.internal_id
                              ? _c("small", {
                                  staticClass: "form-control-feedback",
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.errors.internal_id[0]
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("item-set-form-item", {
                  attrs: {
                    warehouse_id: _vm.form.warehouse_id,
                    showDialog: _vm.showDialogAddItem
                  },
                  on: {
                    "update:warehouse_id": function($event) {
                      return _vm.$set(_vm.form, "warehouse_id", $event)
                    },
                    "update:showDialog": function($event) {
                      _vm.showDialogAddItem = $event
                    },
                    "update:show-dialog": function($event) {
                      _vm.showDialogAddItem = $event
                    },
                    add: _vm.addRow
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-actions text-right pt-2" },
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
    require("vue-hot-reload-api")      .rerender("data-v-61a1c556", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e5c2af\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/item_sets/partials/item.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e5c2af\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/item_sets/partials/item.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("34788c69", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e5c2af\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./item.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js?sourceMap!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e5c2af\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./item.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/js/views/item_sets/form.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/item_sets/form.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-61a1c556\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/item_sets/form.vue")
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
Component.options.__file = "resources/js/views/item_sets/form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-61a1c556", Component.options)
  } else {
    hotAPI.reload("data-v-61a1c556", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/views/item_sets/partials/item.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js?sourceMap!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-36e5c2af\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/views/item_sets/partials/item.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/views/item_sets/partials/item.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-36e5c2af\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/views/item_sets/partials/item.vue")
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
Component.options.__file = "resources/js/views/item_sets/partials/item.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-36e5c2af", Component.options)
  } else {
    hotAPI.reload("data-v-36e5c2af", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
//# sourceMappingURL=148.js.map