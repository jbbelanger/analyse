(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TableauResultatsSection.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TableauResultatsSection.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var chroma_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! chroma-js */ "./node_modules/chroma-js/chroma.js");
/* harmony import */ var chroma_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(chroma_js__WEBPACK_IMPORTED_MODULE_0__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    electionId: Number,
    circonscriptionId: Number
  },
  data: function data() {
    return {
      pourcentage: 1,
      searchString: '',
      loading: false,
      error: null,
      resultats: {
        data: null,
        errors: [],
        loading: false
      },
      bvo: null,
      viewRoutes: {
        tableau: 'sections_tableau',
        graph: 'sections_graph',
        carte: 'sections_carte'
      },
      widgets: {
        numberType: true,
        mapType: false,
        partySelect: false,
        colorScale: false
      }
    };
  },
  created: function created() {
    this.getResulatsElection();
  },
  watch: {
    '$route': 'getResulatsElection'
  },
  computed: {
    headers: function headers() {
      var headers = [{
        text: "Section",
        value: "description",
        align: "left",
        color: "transparent"
      }, {
        text: "Municipalite",
        value: "municipalite",
        align: "left",
        color: "transparent"
      }];

      if (this.resultats.data) {
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = this.resultats.data.sections[0].resultats[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var r = _step.value;
            headers.push({
              text: "".concat(r.parti.abb_usuelle),
              value: "resultats[".concat(r.parti.abb_usuelle, "].value"),
              align: "right",
              color: "#".concat(r.parti.couleur)
            });
          }
        } catch (err) {
          _didIteratorError = true;
          _iteratorError = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion && _iterator["return"] != null) {
              _iterator["return"]();
            }
          } finally {
            if (_didIteratorError) {
              throw _iteratorError;
            }
          }
        }
      }

      return headers;
    },
    formattedResults: function formattedResults() {
      var _this = this;

      var formatted_results = [];

      if (this.resultats.data) {
        var _iteratorNormalCompletion2 = true;
        var _didIteratorError2 = false;
        var _iteratorError2 = undefined;

        try {
          for (var _iterator2 = this.resultats.data.sections[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
            var s = _step2.value;
            var section_info = {
              'description': s.description,
              'municipalite': s.municipalite ? s.municipalite.nom : '',
              'resultats': {},
              'gagnant': {
                'bv': 0,
                'couleur': null
              }
            };
            var _iteratorNormalCompletion3 = true;
            var _didIteratorError3 = false;
            var _iteratorError3 = undefined;

            try {
              for (var _iterator3 = s.resultats[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                var r = _step3.value;

                if (section_info.gagnant.bv === 0) {
                  section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = '#' + r.parti.couleur;
                } else if (r.bv >= section_info.gagnant.bv) {
                  if (r.bv > section_info.gagnant.bv) {
                    section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = '#' + r.parti.couleur;
                  } else if (r.bv === section_info.gagnant.bv) {
                    section_info.gagnant.couleur = 'transparent';
                  }
                }

                section_info.resultats[r.parti.abb_usuelle] = {
                  'value': this.pourcentage ? r.bv / s.participation.bv : r.bv,
                  'circorang': r.circorang,
                  'parti': r.parti,
                  'personne': r.personne
                };
              }
            } catch (err) {
              _didIteratorError3 = true;
              _iteratorError3 = err;
            } finally {
              try {
                if (!_iteratorNormalCompletion3 && _iterator3["return"] != null) {
                  _iterator3["return"]();
                }
              } finally {
                if (_didIteratorError3) {
                  throw _iteratorError3;
                }
              }
            }

            formatted_results.push(section_info);
          }
        } catch (err) {
          _didIteratorError2 = true;
          _iteratorError2 = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
              _iterator2["return"]();
            }
          } finally {
            if (_didIteratorError2) {
              throw _iteratorError2;
            }
          }
        }
      } else {
        return [];
      }

      return formatted_results;
    }
  },
  methods: {
    getResulatsElection: function getResulatsElection() {
      var _this2 = this;

      this.resultats.data = null;
      this.resultats.loading = true;
      axios.get("/api/circonscriptions/".concat(this.$route.params.circonscriptionId, "?relations=sections.sectionresultats.parti,sections.sectionresultats.personne,sections.sectionparticipation,sections.municipalite&election=").concat(this.$route.params.electionId, "&scrutin=1")).then(function (response) {
        return _this2.resultats.data = response.data.data;
      })["catch"](function (error) {
        return _this2.resultats.errors.push(error);
      })["finally"](function () {
        return _this2.resultats.loading = false;
      });
    },
    returnWinner: function returnWinner(resultsArray) {
      return resultsArray.sort(function (a, b) {
        return b.bv - a.bv;
      })[0];
    },
    chromaValue: function chromaValue(hex, value, parti, section) {
      //console.log(hex, value, parti, section)
      var domain = this.minMaxParti(parti);

      if (chroma_js__WEBPACK_IMPORTED_MODULE_0___default.a.valid(hex)) {
        var s = chroma_js__WEBPACK_IMPORTED_MODULE_0___default.a.scale(['rgba(255,255,255,0)', "#".concat(hex)]).mode('lab').domain(domain);
        return s(value).hex();
      } else {
        return 'transparent';
      }
    },
    minMaxParti: function minMaxParti(id) {
      var _this = this;

      var resultats = this.resultats.data.sections.filter(function (s) {
        return s.resultats.length > 0;
      }).map(function (section) {
        return section.resultats.filter(function (r) {
          return r.parti.id === id;
        }).map(function (resultat) {
          if (_this.pourcentage === 1 && !isNaN(resultat.bv)) {
            return resultat.bv / section.participation.bv;
          } else if (!isNaN(resultat.bv)) {
            return resultat.bv;
          }
        });
      });
      return [Math.min.apply(Math, _toConsumableArray(resultats)), Math.max.apply(Math, _toConsumableArray(resultats))];
    },
    csvThis: function csvThis() {
      var json = this.formattedResults;
      var csv = this.$papa.unparse(json);
      var title = 'Jean-Talon 2018';
      this.$papa.download(csv, title);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TableauResultatsSection.vue?vue&type=template&id=7c49fa09&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TableauResultatsSection.vue?vue&type=template&id=7c49fa09& ***!
  \**************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "tableau-resultats-section" },
    [
      _c("analyse-toolbar", {
        attrs: {
          pourcentage: _vm.pourcentage,
          viewRoutes: _vm.viewRoutes,
          activeView: 0,
          widgets: _vm.widgets
        },
        on: {
          "update:pourcentage": function($event) {
            _vm.pourcentage = $event
          }
        }
      }),
      _vm._v(" "),
      _c("v-data-table", {
        staticClass: "body-1",
        attrs: {
          loading: _vm.resultats.loading,
          headers: _vm.headers,
          items: _vm.formattedResults,
          search: ""
        },
        scopedSlots: _vm._u([
          {
            key: "item.description",
            fn: function(ref) {
              var item = ref.item
              return undefined
            }
          },
          {
            key: "item",
            fn: function(ref) {
              var item = ref.item
              return [
                _c(
                  "tr",
                  [
                    _c(
                      "td",
                      [
                        _c(
                          "v-avatar",
                          { attrs: { small: "", color: item.gagnant.couleur } },
                          [_vm._v(_vm._s(item.description))]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(item.municipalite))]),
                    _vm._v(" "),
                    _vm._l(item.resultats, function(resultat) {
                      return _c(
                        "td",
                        {
                          staticClass: "text-xs-right",
                          style:
                            "border-left: 3px solid #" +
                            resultat.parti.couleur +
                            "; background-color:" +
                            _vm.chromaValue(
                              resultat.parti.couleur,
                              resultat.value,
                              resultat.parti.id,
                              item.description
                            ) +
                            ";"
                        },
                        [
                          _c(
                            "span",
                            {
                              class:
                                resultat.bv === item.gagnant.bv
                                  ? "font-weight-bold"
                                  : ""
                            },
                            [
                              _vm.pourcentage
                                ? [
                                    _vm._v(
                                      _vm._s(
                                        _vm._f("numeralFormat")(
                                          resultat.value,
                                          "0.00 %"
                                        )
                                      )
                                    )
                                  ]
                                : _vm._e(),
                              _vm._v(" "),
                              !_vm.pourcentage
                                ? [
                                    _vm._v(
                                      _vm._s(
                                        _vm._f("numeralFormat")(resultat.value)
                                      )
                                    )
                                  ]
                                : _vm._e()
                            ],
                            2
                          )
                        ]
                      )
                    })
                  ],
                  2
                )
              ]
            }
          }
        ])
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/TableauResultatsSection.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/TableauResultatsSection.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TableauResultatsSection_vue_vue_type_template_id_7c49fa09___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableauResultatsSection.vue?vue&type=template&id=7c49fa09& */ "./resources/js/components/TableauResultatsSection.vue?vue&type=template&id=7c49fa09&");
/* harmony import */ var _TableauResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableauResultatsSection.vue?vue&type=script&lang=js& */ "./resources/js/components/TableauResultatsSection.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TableauResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TableauResultatsSection_vue_vue_type_template_id_7c49fa09___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TableauResultatsSection_vue_vue_type_template_id_7c49fa09___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/TableauResultatsSection.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/TableauResultatsSection.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/TableauResultatsSection.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableauResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TableauResultatsSection.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TableauResultatsSection.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableauResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/TableauResultatsSection.vue?vue&type=template&id=7c49fa09&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/TableauResultatsSection.vue?vue&type=template&id=7c49fa09& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableauResultatsSection_vue_vue_type_template_id_7c49fa09___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TableauResultatsSection.vue?vue&type=template&id=7c49fa09& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TableauResultatsSection.vue?vue&type=template&id=7c49fa09&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableauResultatsSection_vue_vue_type_template_id_7c49fa09___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableauResultatsSection_vue_vue_type_template_id_7c49fa09___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);