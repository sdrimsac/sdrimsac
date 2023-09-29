webpackJsonp([201],{

/***/ "./modules/Internet/Resources/assets/js/view/pos/partials/list_food_mobiles.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/list_food_mobiles.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5e43b95d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/list_food_mobiles.vue")
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
Component.options.__file = "modules/Internet/Resources/assets/js/view/pos/partials/list_food_mobiles.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5e43b95d", Component.options)
  } else {
    hotAPI.reload("data-v-5e43b95d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/list_food_mobiles.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["foods", "configuration", "worker", "pagination", "blockAdd", "localOrden", "category", "categories", "showDialogViewItems", "selectOption"],
  data: function data() {
    var _settings, _settings_tables;

    return {
      selectCategory: 0,
      activeName: "menu",
      loading: true,
      ordenItems: [],
      orden: [],
      currentFood: {},
      item: null,
      search: "Buscar por Codigo",
      currentImage: null,
      showImage: false,
      listFoods: [],
      selectedFood: null,
      allFalse: true,
      title: null,
      total: null,
      ordenId: null,
      optionsSelected: 0,
      generalOrdens: 1,
      establishmentId: this.worker.establishment_id,
      settings: (_settings = {
        dots: false,
        dotsClass: "slick-dots custom-dot-class",
        edgeFriction: 0.35,
        infinite: false,
        speed: 500,
        centerMode: true,
        centerPadding: "10px",
        focusOnSelect: true
      }, _defineProperty(_settings, "infinite", true), _defineProperty(_settings, "slidesToShow", 3), _defineProperty(_settings, "slidesToScroll", 3), _defineProperty(_settings, "swipeToSlide", true), _defineProperty(_settings, "speed", 500), _defineProperty(_settings, "responsive", [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      }, {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          initialSlide: 2
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }]), _settings),
      settings_tables: (_settings_tables = {
        dots: true,
        dotsClass: "slick-dots custom-dot-class",
        infinite: false,
        speed: 500,
        centerMode: true,
        centerPadding: "10px",
        focusOnSelect: true
      }, _defineProperty(_settings_tables, "infinite", true), _defineProperty(_settings_tables, "slidesToShow", 5), _defineProperty(_settings_tables, "slidesToScroll", 5), _defineProperty(_settings_tables, "swipeToSlide", true), _defineProperty(_settings_tables, "responsive", [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          infinite: true,
          dots: true
        }
      }, {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          initialSlide: 2
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }]), _settings_tables),
      screenWidth: 0,
      input_itemMobil: "",
      categoryChild: ""
    };
  },
  mounted: function mounted() {
    this.screenWidth = window.innerWidth;
    window.addEventListener('resize', this.handleResize);

    if (this.foods.length > 0) {
      this.loading = false;
    }
  },
  watch: {
    foods: function foods(__, _) {
      this.updateListFoods();
    }
  },
  created: function created() {
    this.ordenItems = [];
    this.orden = [];
    this.updateListFoods();
  },
  methods: {
    UpdateparentCategory: function UpdateparentCategory() {
      this.$emit("update:category", this.categoryChild);
      this.$emit('data-received', this.input_itemMobil);
    },
    emitData: function emitData() {
      //this.$emit("update:category")
      if (this.input_itemMobil.length > 2) {
        this.$emit('data-received', this.input_itemMobil);
      }
    },
    handleResize: function handleResize() {
      this.screenWidth = window.innerWidth;
    },
    nthing: function nthing() {},
    getDefaultPrice: function getDefaultPrice(type) {
      var listPricesDescription = ["price1", "price2", "price3"];
      var currentPriceIndx = listPricesDescription[type.price_default - 1];
      var price = type[currentPriceIndx];

      if (type.total == null) {// this.$toast.error(
        //     "Politica de precio sin total: Tomando precio unitario.."
        // );
      } else {
        price = Number(type.total);
      }

      return price;
    },
    formatDescriptionType: function formatDescriptionType(type) {
      var price = this.getDefaultPrice(type);
      return "".concat(type.description, " (").concat(Number(type.quantity_unit), ") - S/ ").concat(price);
    },
    clickCommand: function clickCommand(type) {
      var idxFood = this.listFoods.findIndex(function (food) {
        return food.item.id == type.item_id;
      });

      if (idxFood >= 0) {
        this.addFood(idxFood, type);
      }
    },
    updateListFoods: function updateListFoods() {
      this.listFoods = this.foods.map(function (f) {
        return _objectSpread(_objectSpread({}, f), {}, {
          select: false
        });
      });
    },
    formatedStockPresentation: function formatedStockPresentation(_ref, stock) {
      var max_quantity = _ref.max_quantity,
          item_unit_types = _ref.item_unit_types,
          unit_type = _ref.unit_type;
      var general = Math.trunc(stock / max_quantity);
      var part = (stock / max_quantity % 1).toFixed(2);
      var text = "".concat(general, " ").concat(unit_type.id);

      if (part != 0) {
        var item_unit = item_unit_types.find(function (i) {
          return Number(i.quantity_unit) == Number(max_quantity);
        });

        if (item_unit) {
          text += " ".concat(part * max_quantity, " ").concat(item_unit.unit_type.id);
        }
      }

      return text;
    },
    getRecords: function getRecords() {
      var currentPage = this.pagination.current_page;
      this.$emit("changePage", currentPage);
    },
    deleteOrden: function deleteOrden(id) {
      this.ordenItems = this.ordenItems.filter(function (o) {
        return o.id != id;
      });
    },
    calculateOrden: function calculateOrden() {// this.$refs.ordenRef.calculateTotal();
    },
    selectSearch: function selectSearch(value) {
      this.optionsSelected = value;
    },
    deleteFood: function deleteFood(idx) {
      this.orden.splice(idx, 1);
    },
    setCategory: function setCategory(id) {
      this.selectCategory = id;
      !this.allFalse && this.setFalse();

      if (id == 0) {
        this.listFoods = this.foods;
      } else {
        this.listFoods = [];
        this.listFoods = _.filter(this.foods, {
          category_food_id: id
        });
      }
    },
    addFood: function addFood() {
      var _this = this;

      var index = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

      if (this.blockAdd && !this.configuration.box_orden) {
        this.$toast.error("No puede agregar productos a esta orden.");
        return;
      }

      this.selectedFood = JSON.parse(JSON.stringify(this.listFoods[index]));
      if (!this.selectedFood) return;

      if (Number(this.selectedFood.item.stock) <= 0 && this.configuration.sales_stock == true) {
        this.$toast.warning("Stock insuficiente");
        return;
      }

      var foodFound = this.localOrden.filter(function (f) {
        return f.id == _this.selectedFood.id;
      });

      if (foodFound.length != 0) {
        var item = this.selectedFood.item;

        if (item.lots_enabled) {
          if (item.item_unit_types.length == 0) {
            var message = "Producto con lote, ya  agregado";
            this.$toast.warning(message);
            return;
          }
        }

        if (item.series_enabled) {
          if (item.item_unit_types.length == 0) {
            var _message = "Producto con serie, ya  agregado";
            this.$toast.warning(_message);
            return;
          } else {
            if (type) {
              if (foodFound.some(function (i) {
                return i.type_id == type.id;
              })) {
                var _message2 = "Producto con serie, ya  agregado";
                this.$toast.warning(_message2);
                return;
              }
            }
          }
        }

        var qty = foodFound.reduce(function (a, b) {
          return a + Number(b.quantity);
        }, 0);

        if (type) {
          // qty += Number(type.quantity_unit);
          qty += 1;
        } else {
          qty += 1;
        }

        if (this.configuration.sales_stock == true) {
          if (qty > Number(this.selectedFood.item.stock)) {
            this.$toast.warning("Limite de stock alcanzado");
            return;
          }
        }
      } else {
        if (type) {
          var _qty = type.quantity_unit;

          if (this.configuration.sales_stock == true) {
            var stock = Number(this.selectedFood.item.stock);

            if (_qty == stock || _qty > stock) {
              this.$toast.warning("Limite de stock alcanzado");
              return;
            }
          }
        }
      }

      this.currentFood = {
        id: this.selectedFood.id,
        food: this.selectedFood,
        observation: null,
        price: this.selectedFood.price,
        quantity: !!this.selectedFood.item.series_enabled ? 0 : 1
      };
      this.$emit("insertOrden", this.currentFood, this.selectedFood.id, type);
      this.$notify({
        title: this.currentFood.food.description.toLowerCase(),
        duration: 800,
        iconClass: "el-icon-food",
        message: "Agregado con èxito",
        position: "bottom-left"
      });
      this.currentFood = {
        food: null,
        observation: null,
        quantity: 0,
        price: 0
      };
      this.selectedFood = null;
      this.item = null; //this.setFalse();
      //this.$emit("buscarnuevo");
      //this.$forceUpdate();
    },
    setFalse: function setFalse() {
      this.listFoods = this.listFoods.map(function (f) {
        f.select = false;
        return f;
      });
      this.allFalse = true;
    },
    selectFood: function selectFood(index) {
      //  this.$refs.description.$el.getElementsByTagName("input")[0].focus();
      if (this.listFoods[index].select) {
        this.listFoods[index].select = false;
        this.allFalse = true;
        this.selectedFood = null;
        return;
      }

      !this.allFalse && this.setFalse();
      this.listFoods[index].select = true;
      this.selectedFood = this.listFoods[index];
      this.allFalse = false;
    },
    searchFoodCategories: function searchFoodCategories(value) {
      if (value == 0) {
        this.listFoods = this.foods;
      } else {
        this.listFoods = _.filter(this.foods, {
          category_food_id: value
        });
      }
    },
    searchFood: function searchFood() {
      var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var optionsSelected = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "Descripcion";
      !this.allFalse && this.setFalse();

      if (value) {
        if (optionsSelected == "Descripcion") {
          this.listFoods = this.foods.filter(function (f) {
            return f.description.toLowerCase().includes(value);
          });
        } else {
          //this.listFoods=_.filter(this.foods,{'code':value})
          this.listFoods = this.foods.filter(function (ff) {
            return ff.code.toLowerCase().includes(value);
          });
        }
      } else {
        this.listFoods = this.foods;
      }
    },
    formatUrlImage: function formatUrlImage(url) {
      if (!url) return;
      var formated = "storage/uploads/items/" + url;
      return "/".concat(formated);
    },
    open: function open() {
      var _this2 = this;

      this.ordenItems = [];
      this.orden = [];

      if (this.table.orden.length != 0) {
        this.ordenItems = this.table.orden.orden_items; // this.activeName = "orden";

        this.ordenId = this.table.orden.id;
        setTimeout(function () {
          return _this2.calculateOrden();
        }, 50);
      }

      if (!this.categories.some(function (c) {
        return c.id == 0;
      })) {
        this.categories.unshift({
          id: 0,
          description: "todos"
        });
      }

      this.listFoods = this.foods.map(function (f) {
        return _objectSpread(_objectSpread({}, f), {}, {
          select: false
        });
      });
      this.title = "Mesa N\xB0".concat(this.table.number);
    },
    close: function close() {
      this.$emit("update:showDialogViewItems");
    },
    clear_input: function clear_input() {
      this.input_itemMobil = "";
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5e43b95d\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./modules/Internet/Resources/assets/js/view/pos/partials/list_food_mobiles.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-dialog",
    {
      attrs: {
        title: "Buscar Producto",
        width: "30%",
        visible: _vm.showDialogViewItems
      },
      on: { close: _vm.close }
    },
    [
      _c("div", { staticClass: "row col-12" }, [
        _c(
          "div",
          { staticClass: "col-6" },
          [
            [
              _c("h2", { staticClass: "text-muted text-small" }, [
                _vm._v("\n                    Categorias\n                ")
              ]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  attrs: {
                    filterable: "",
                    clearable: "",
                    placeholder: "Selecionar aqui...."
                  },
                  on: { change: _vm.UpdateparentCategory },
                  model: {
                    value: _vm.categoryChild,
                    callback: function($$v) {
                      _vm.categoryChild = $$v
                    },
                    expression: "categoryChild"
                  }
                },
                _vm._l(_vm.categories, function(item) {
                  return _c("el-option", {
                    key: item.id,
                    attrs: { label: item.name, value: item.id }
                  })
                }),
                1
              )
            ]
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-6 " },
          [
            _c("h2", { staticClass: "text-muted text-small" }, [
              _vm._v("\n                Buscar\n            ")
            ]),
            _vm._v(" "),
            _vm.selectOption == 4
              ? [
                  _c(
                    "el-input",
                    {
                      ref: "input_items",
                      attrs: {
                        size: "small",
                        autofocus: "",
                        placeholder: "Ingrese aca Un Producto"
                      },
                      on: {
                        input: function($event) {
                          return _vm.emitData()
                        },
                        focus: function($event) {
                          return _vm.clear_input()
                        }
                      },
                      model: {
                        value: _vm.input_itemMobil,
                        callback: function($$v) {
                          _vm.input_itemMobil = $$v
                        },
                        expression: "input_itemMobil"
                      }
                    },
                    [
                      _c("el-button", {
                        attrs: { slot: "append", icon: "el-icon-search" },
                        on: { click: _vm.emitData },
                        slot: "append"
                      })
                    ],
                    1
                  )
                ]
              : [
                  _c(
                    "el-input",
                    {
                      ref: "input_itemMobil",
                      attrs: {
                        size: "small",
                        autofocus: "",
                        placeholder: "Ingrese aca Un Producto"
                      },
                      on: {
                        input: function($event) {
                          return _vm.emitData()
                        },
                        focus: function($event) {
                          return _vm.clear_input()
                        }
                      },
                      model: {
                        value: _vm.input_itemMobil,
                        callback: function($$v) {
                          _vm.input_itemMobil = $$v
                        },
                        expression: "input_itemMobil"
                      }
                    },
                    [
                      _c("el-button", {
                        attrs: { slot: "append", icon: "el-icon-search" },
                        on: { click: _vm.emitData },
                        slot: "append"
                      })
                    ],
                    1
                  )
                ]
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "row" },
        _vm._l(_vm.foods, function(data, index) {
          return _c(
            "div",
            {
              key: index,
              staticClass: "col-6 col-lg-4 col-xl-4 col-xxl-4 p-1"
            },
            [
              _c(
                "el-tooltip",
                {
                  attrs: {
                    effect: "dark",
                    disabled:
                      data.item.warehouses.length == 1 ||
                      !_vm.configuration.show_stock_establishment_box
                  }
                },
                [
                  _c(
                    "div",
                    { attrs: { slot: "content" }, slot: "content" },
                    [
                      _vm._v("\n                            Stock Almacenes "),
                      _c("br"),
                      _vm._v(" "),
                      _vm._l(data.item.warehouses, function(info, idx) {
                        return _c("span", { key: idx }, [
                          info.warehouse.id != _vm.establishmentId
                            ? _c(
                                "label",
                                [
                                  data.item.max_quantity
                                    ? [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.formatedStockPresentation(
                                                data.item,
                                                info.stock
                                              )
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
                                    : [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              info.warehouse.description +
                                                ": " +
                                                Number(info.stock).toFixed(2)
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
                                ],
                                2
                              )
                            : _vm._e(),
                          _c("br")
                        ])
                      })
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "\n                                    overflow-hidden\n                                    coupon\n                                    rounded\n                                    d-flex\n                                    flex-column\n                                    justify-content-between\n                                    p-1\n                                    ",
                      attrs: { id: "card" }
                    },
                    [
                      _c(
                        "div",
                        {
                          on: {
                            click: function($event) {
                              return _vm.addFood(index)
                            }
                          }
                        },
                        [
                          _c("div", [
                            _c(
                              "span",
                              { staticClass: "lead-font-weight-700 h5" },
                              [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(data.description.toUpperCase()) +
                                    "\n                                    "
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "d-flex align-items-end justify-content-between"
                            },
                            [
                              _c("div", { staticClass: "p-1" }, [
                                _c("div", { staticClass: "icon-container" }, [
                                  _c(
                                    "div",
                                    { staticClass: "icon-container_box" },
                                    [
                                      data.image == "imagen-no-disponible.jpg"
                                        ? [
                                            _c("img", {
                                              staticClass: "thumbail",
                                              attrs: {
                                                hidden: "",
                                                src:
                                                  "/images/imagen-no-disponible.jpg",
                                                alt: "User Img"
                                              }
                                            })
                                          ]
                                        : [
                                            _c("img", {
                                              staticClass: "thumbail",
                                              attrs: {
                                                src: _vm.formatUrlImage(
                                                  data.image
                                                )
                                              }
                                            })
                                          ]
                                    ],
                                    2
                                  )
                                ])
                              ]),
                              _vm._v(" "),
                              _c("div", [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(data.code) +
                                    "\n                                    "
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "d-flex flex-column align-items-end"
                                },
                                [
                                  _c("div", { staticClass: "block mb-2" }, [
                                    _c(
                                      "span",
                                      { staticClass: "time font-weight-light" },
                                      [
                                        _c(
                                          "span",
                                          {
                                            staticClass:
                                              "text-muted lead-font-weight-700"
                                          },
                                          [
                                            _vm._v(
                                              "\n                                                    S/\n                                                    " +
                                                _vm._s(data.price)
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    [
                                      data.item.stock > 0
                                        ? [
                                            _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge rounded-pill bg-primary m-l-0"
                                              },
                                              [
                                                _vm._v(
                                                  "Stock\n                                                    "
                                                ),
                                                data.item.max_quantity
                                                  ? [
                                                      _vm._v(
                                                        "\n                                                        " +
                                                          _vm._s(
                                                            _vm.formatedStockPresentation(
                                                              data.item,
                                                              data.item.stock
                                                            )
                                                          ) +
                                                          "\n                                                        "
                                                      )
                                                    ]
                                                  : [
                                                      _vm._v(
                                                        "\n                                                        " +
                                                          _vm._s(
                                                            parseFloat(
                                                              data.item.stock
                                                            )
                                                          ) +
                                                          "\n                                                    "
                                                      )
                                                    ]
                                              ],
                                              2
                                            )
                                          ]
                                        : [
                                            _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge rounded-pill bg-danger m-l-0"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                                    Agotado\n                                                "
                                                )
                                              ]
                                            )
                                          ]
                                    ],
                                    2
                                  )
                                ]
                              )
                            ]
                          )
                        ]
                      ),
                      _vm._v(" "),
                      data.types.length > 0
                        ? _c(
                            "div",
                            {
                              staticClass: "d-flex justify-content-end",
                              staticStyle: {
                                "padding-right": "10px",
                                "margin-top": "5px"
                              },
                              on: { click: _vm.nthing }
                            },
                            [
                              _c(
                                "el-dropdown",
                                { on: { command: _vm.clickCommand } },
                                [
                                  _c(
                                    "span",
                                    { staticClass: "el-dropdown-link" },
                                    [
                                      _vm._v(
                                        "\n                                        Precios"
                                      ),
                                      _c("i", {
                                        staticClass:
                                          "el-icon-arrow-down el-icon--right"
                                      })
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "el-dropdown-menu",
                                    {
                                      attrs: { slot: "dropdown" },
                                      slot: "dropdown"
                                    },
                                    _vm._l(data.types, function(type, idx) {
                                      return _c(
                                        "el-dropdown-item",
                                        { key: idx, attrs: { command: type } },
                                        [
                                          _vm._v(
                                            "\n                                            " +
                                              _vm._s(
                                                _vm.formatDescriptionType(type)
                                              ) +
                                              "\n                                        "
                                          )
                                        ]
                                      )
                                    }),
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          )
                        : _vm._e()
                    ]
                  )
                ]
              )
            ],
            1
          )
        }),
        0
      ),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-6" },
          [_c("el-button", { on: { click: _vm.close } }, [_vm._v("Cancel")])],
          1
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5e43b95d", module.exports)
  }
}

/***/ })

});
//# sourceMappingURL=201.js.map