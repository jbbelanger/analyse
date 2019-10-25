(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[25],{

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
      resultats: null,
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
        text: "SV",
        value: "nom",
        align: "right"
      }, {
        text: "Municipalite",
        value: "municipalite.nom",
        align: "left"
      }];
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = this.resultats.resultats[0].sectionresultats[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var r = _step.value;
          headers.push({
            text: "".concat(r.parti.abb_usuelle),
            value: this.pourcentage ? "sectionresultats[".concat(r.circorang - 1, "].pc_bv") : "sectionresultats[".concat(r.circorang - 1, "].bv"),
            align: "left"
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

      return headers;
    },
    formattedResults: function formattedResults() {
      var _this = this;

      var formatted_results = [];

      if (this.resultats.resultats) {
        var resultats = _this.resultats.resultats.filter(function (resultat) {
          return resultat.sectionresultats.length > 0;
        });

        var _iteratorNormalCompletion2 = true;
        var _didIteratorError2 = false;
        var _iteratorError2 = undefined;

        try {
          for (var _iterator2 = resultats[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
            var s = _step2.value;
            var section_info = {
              'id': s.id,
              'description': s.description,
              'circonscription_id': s.circonscription_id,
              'unique_id': s.unique_id,
              'municipalite_id': s.municipalite_id,
              'legislature_id': s.legislature_id,
              'regr_bva': s.regr_bva,
              'scrutin_id': s.scrutin_id,
              'municipalite': s.municipalite,
              'sectionresultats': [],
              'gagnant': {
                'bv': 0,
                'couleur': null
              }
            };
            var _iteratorNormalCompletion3 = true;
            var _didIteratorError3 = false;
            var _iteratorError3 = undefined;

            try {
              for (var _iterator3 = s.sectionresultats[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                var r = _step3.value;

                if (section_info.gagnant.bv === 0) {
                  section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = r.parti.couleur;
                } else if (r.bv >= section_info.gagnant.bv) {
                  if (r.bv > section_info.gagnant.bv) {
                    section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = r.parti.couleur;
                  } else if (r.bv === section_info.gagnant.bv) {
                    section_info.gagnant.couleur = 'ffffff';
                  }
                }

                section_info.sectionresultats.push({
                  'id': r.id,
                  'section_id': r.section_id,
                  'section_description': r.section_description,
                  'election_id': r.election_id,
                  'personne_id': r.personne_id,
                  'parti_id': r.parti_id,
                  'circonscription_id': r.circonscription_id,
                  'scrutin_id': r.scrutin_id,
                  'regr_bvo': r.regr_bvo,
                  'regr_bva': r.regr_bva,
                  'bv': r.bv,
                  'pc_bv': r.sectionparticipation ? r.bv / r.sectionparticipation.bv : r.bv / r.ps_bv,
                  'rang': r.rang,
                  'circorang': r.circorang,
                  'parti': r.parti,
                  'sectionparticipation': r.sectionparticipation ? r.sectionparticipation : {
                    'bv': r.ps_bv,
                    'br': r.ps_br,
                    'ei': r.ps_ei
                  },
                  'personne': r.personne
                });
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

      this.error = null;
      this.loading = true;
      axios.get("http://localhost:8000/api/circonscriptions/".concat(this.$route.params.circonscriptionId, "/elections/").concat(this.$route.params.electionId, "/resultats_section")).then(function (response) {
        return _this2.resultats = response.data;
      })["catch"](function (e) {
        return console.log(e);
      })["finally"](function () {
        return _this2.loading = false;
      });
    },
    returnWinner: function returnWinner(resultsArray) {
      return resultsArray.sort(function (a, b) {
        return b.bv - a.bv;
      })[0];
    },
    spaceForThousands: function spaceForThousands(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    },
    formatPercent: function formatPercent(n) {
      return +(Math.round(100 * n + "e+2") + "e-2").toString().replace(". ", ",") + " %";
    },
    testChroma: function testChroma(hex, value, parti) {
      var domain = this.minMaxParti(parti);
      var s = chroma_js__WEBPACK_IMPORTED_MODULE_0___default.a.scale(['#ffffff', hex]).domain(domain);
      return s(value);
    },
    minMaxParti: function minMaxParti(id) {
      var _this = this;

      var resultats = this.resultats.resultats.filter(function (s) {
        return s.sectionresultats.length > 0;
      }).map(function (section) {
        return section.sectionresultats.filter(function (r) {
          return r.parti.id === id;
        }).map(function (resultat) {
          if (_this.pourcentage === 1) {
            return resultat.bv / resultat.ps_bv;
          } else {
            return resultat.bv;
          }
        });
      });
      return [Math.min.apply(Math, _toConsumableArray(resultats)), Math.max.apply(Math, _toConsumableArray(resultats))];
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
          loading: _vm.loading,
          headers: _vm.headers,
          items: _vm.resultats ? _vm.formattedResults : [],
          "rows-per-page-items": [
            10,
            20,
            { text: "$vuetify.dataIterator.rowsPerPageAll", value: -1 }
          ],
          "rows-per-page-text": "Lignes par page"
        },
        scopedSlots: _vm._u([
          {
            key: "items",
            fn: function(props) {
              return [
                _c(
                  "td",
                  {
                    staticClass: "text-xs-right",
                    style:
                      "border-left: 24px solid #" +
                      props.item.gagnant.couleur +
                      "; /*border-image: repeating-linear-gradient( 135deg, #ff5505, #ff5505 4%, #00a7e7 1%, #00a7e7 8%) 0 0 0 10;*/ padding: 0 12px;"
                  },
                  [
                    _vm._v(
                      "\n        " + _vm._s(props.item.description) + "\n      "
                    )
                  ]
                ),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(props.item.municipalite.nom))]),
                _vm._v(" "),
                _vm._l(props.item.sectionresultats, function(resultat) {
                  return _c(
                    "td",
                    {
                      staticClass: "text-xs-right",
                      style:
                        "border-left: 3px solid #" +
                        resultat.parti.couleur +
                        "; background-color:" +
                        (_vm.pourcentage === 0
                          ? _vm.testChroma(
                              resultat.parti.couleur,
                              resultat.bv,
                              resultat.parti.id
                            )
                          : _vm.testChroma(
                              resultat.parti.couleur,
                              resultat.pc_bv,
                              resultat.parti.id
                            )) +
                        ";"
                    },
                    [
                      _c(
                        "span",
                        {
                          class:
                            resultat.bv === props.item.gagnant.bv
                              ? "font-weight-bold"
                              : ""
                        },
                        [
                          _vm._v(
                            "\n          " +
                              _vm._s(
                                _vm.pourcentage
                                  ? _vm.formatPercent(resultat.pc_bv)
                                  : resultat.bv
                              ) +
                              "\n        "
                          )
                        ]
                      )
                    ]
                  )
                })
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