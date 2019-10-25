(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[24],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CarteResultatsSection.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CarteResultatsSection.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      //infowindow
      infoContent: null,
      infoWindowPos: null,
      infoWinOpen: false,
      currentSectionIndex: null,
      //
      displayParti: 17,
      pourcentage: 0,
      searchString: '',
      loading: false,
      error: null,
      resultats: [],
      bvo: null,
      page: 1,
      last_page: null,
      gagnant: 1,
      opacity: 0.5,
      viewRoutes: {
        tableau: 'sections_tableau',
        graph: 'sections_graph',
        carte: 'sections_carte'
      },
      widgets: {
        numberType: true,
        mapType: true,
        partySelect: true,
        colorScale: true
      }
    };
  },
  created: function created() {
    this.get();
  },
  watch: {
    '$route': 'get',
    'page': 'getNext'
  },
  computed: {
    displayPartiName: function displayPartiName() {
      var _this2 = this;

      if (this.resultats.length > 0) {
        return this.resultats[0].sectionresultats.filter(function (r) {
          return r.parti.id === _this2.displayParti;
        })[0].parti.abb_usuelle;
      } else {
        return '';
      }
    },
    scaleValues: function scaleValues() {
      var _this3 = this;

      var _this = this;

      if (this.resultats.length > 0) {
        var hex = "#".concat(this.resultats[0].sectionresultats.filter(function (r) {
          return r.parti.id === _this3.displayParti;
        })[0].parti.couleur);
        var id = this.resultats[0].sectionresultats.filter(function (r) {
          return r.parti.id === _this3.displayParti;
        })[0].parti.id;
        var minmax = this.minMaxParti(_this.displayParti);
        var scale = [minmax[0], minmax[1] - (minmax[1] - minmax[0]) / 2, minmax[1]];
        return [{
          valeur: scale[0],
          couleur: this.chromaValue(hex, scale[0], id)
        }, {
          valeur: scale[1],
          couleur: this.chromaValue(hex, scale[1], id)
        }, {
          valeur: scale[2],
          couleur: this.chromaValue(hex, scale[2], id)
        }];
      } else {
        return [{
          valeur: 0,
          couleur: '#fff'
        }, {
          valeur: 0,
          couleur: '#fff'
        }, {
          valeur: 0,
          couleur: '#fff'
        }];
      }
    },
    partis: function partis() {
      var _this = this;

      if (_this.resultats.length > 0) {
        return _this.resultats[0].sectionresultats.sort(function (a, b) {
          return a.circorang - b.circorang;
        }).map(function (resultat) {
          return resultat.parti;
        });
      }
    },
    sectionsMap: function sectionsMap() {
      var _this = this;

      if (_this.resultats.length > 0) {
        var data = _this.resultats;
        var sections = [];
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = data[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var section = _step.value;

            if (section.sectionresultats.length > 0 && section.sectionpolygone) {
              var display = section.sectionresultats.filter(function (r) {
                return r.parti.id === _this.displayParti;
              });
              var section_info = {
                'id': section.id,
                'description': section.description,
                'municipalite': section.municipalite,
                'polygone': JSON.parse(section.sectionpolygone.polygone),
                'sectionresultats': [],
                'display': {
                  'hex': display[0].parti.couleur,
                  'bv': display[0].bv,
                  'parti': display[0].parti.id,
                  'couleur': _this.chromaValue(display[0].parti.couleur, _this.pourcentage === 1 ? display[0].bv / display[0].ps_bv : display[0].bv, display[0].parti.id)
                },
                'gagnant': {
                  'bv': 0,
                  'couleur': null
                }
              };
              var _iteratorNormalCompletion2 = true;
              var _didIteratorError2 = false;
              var _iteratorError2 = undefined;

              try {
                for (var _iterator2 = section.sectionresultats[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                  var r = _step2.value;

                  if (section_info.gagnant.bv === 0) {
                    section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = "#".concat(r.parti.couleur);
                  } else if (r.bv >= section_info.gagnant.bv) {
                    if (r.bv > section_info.gagnant.bv) {
                      section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = "#".concat(r.parti.couleur);
                    } else if (r.bv === section_info.gagnant.bv) {
                      section_info.gagnant.couleur = '#ffffff';
                    }
                  }

                  section_info.sectionresultats.push({
                    'id': r.id,
                    'bv': r.bv,
                    'pc_bv': r.sectionparticipation ? r.bv / r.sectionparticipation.bv : r.bv / r.ps_bv,
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

              sections.push(section_info);
            }
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

        return sections;
      } else {
        return 'La propriété « resultats » est vide ou introuvable';
      }
    }
  },
  methods: {
    get: function get() {
      var _this4 = this;

      this.error = null;
      this.loading = true;
      axios.get("http://localhost:8000/api/circonscriptions/".concat(this.$route.params.circonscriptionId, "/elections/").concat(this.$route.params.electionId, "/resultats_section/polygones?page=").concat(this.page)).then(function (response) {
        var _iteratorNormalCompletion3 = true;
        var _didIteratorError3 = false;
        var _iteratorError3 = undefined;

        try {
          for (var _iterator3 = response.data.resultats.data[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
            var d = _step3.value;

            _this4.resultats.push(d);
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

        _this4.extremes = response.data.extremes;
        _this4.last_page = response.data.resultats.last_page;
        _this4.page++;
      })["catch"](function (e) {
        console.log(e);
        _this4.loading = false;
      });
    },
    getNext: function getNext() {
      if (this.page <= this.last_page) {
        this.get();

        if (this.page === this.last_page) {
          this.loading = false;
        }
      }
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
    chromaValue: function chromaValue(hex, value, parti) {
      var domain = this.minMaxParti(parti);
      var s = chroma_js__WEBPACK_IMPORTED_MODULE_0___default.a.scale(['#ffffff', hex]).mode('lab').domain(domain);
      return s(value).hex();
    },
    minMaxParti: function minMaxParti(id) {
      var _this = this;

      var resultats = this.resultats.filter(function (s) {
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
    },
    toggleInfoWindow: function toggleInfoWindow(section, index) {
      var lat = section.polygone[0].map(function (coords) {
        return coords.lat;
      });
      var lng = section.polygone[0].map(function (coords) {
        return coords.lng;
      });
      var sectionCenter = {
        lat: Math.min.apply(Math, _toConsumableArray(lat)) + (Math.max.apply(Math, _toConsumableArray(lat)) - Math.min.apply(Math, _toConsumableArray(lat))) / 2,
        lng: Math.min.apply(Math, _toConsumableArray(lng)) + (Math.max.apply(Math, _toConsumableArray(lng)) - Math.min.apply(Math, _toConsumableArray(lng))) / 2
      };
      this.infoWindowPos = sectionCenter;
      this.infoContent = section; //check if its the same marker that was selected if yes toggle

      if (this.currentSectionIndex == index) {
        this.infoWinOpen = !this.infoWinOpen;
      } //if different marker set infowindow to open and reset current marker index
      else {
          this.infoWinOpen = true;
          this.currentSectionIndex = index;
        }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CarteResultatsSection.vue?vue&type=template&id=360a268c&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CarteResultatsSection.vue?vue&type=template&id=360a268c& ***!
  \************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "carte-resultats-section" },
    [
      _c("analyse-toolbar", {
        attrs: {
          gagnant: _vm.gagnant,
          partis: _vm.partis,
          displayParti: _vm.displayParti,
          displayPartiName: _vm.displayPartiName,
          pourcentage: _vm.pourcentage,
          scaleValues: _vm.scaleValues,
          opacity: _vm.opacity,
          viewRoutes: _vm.viewRoutes,
          activeView: 2,
          widgets: _vm.widgets
        },
        on: {
          "update:gagnant": function($event) {
            _vm.gagnant = $event
          },
          "update:partis": function($event) {
            _vm.partis = $event
          },
          "update:displayParti": function($event) {
            _vm.displayParti = $event
          },
          "update:display-parti": function($event) {
            _vm.displayParti = $event
          },
          "update:pourcentage": function($event) {
            _vm.pourcentage = $event
          }
        }
      }),
      _vm._v(" "),
      _c("v-progress-linear", {
        staticClass: "py-0 my-0",
        attrs: {
          height: 3,
          "v-if": _vm.page < _vm.last_page,
          value: (100 * _vm.page) / _vm.last_page
        }
      }),
      _vm._v(" "),
      _c(
        "gmap-map",
        {
          staticStyle: {
            width: "100%",
            height: "calc(100vh - 64px - 24px - 24px)"
          },
          attrs: {
            center: { lat: 47.487692, lng: -75.025446 },
            zoom: 6,
            options: {
              zoomControl: true,
              mapTypeControl: false,
              scaleControl: false,
              streetViewControl: false,
              rotateControl: false,
              fullscreenControl: true,
              disableDefaultUi: false,
              styles: [
                {
                  featureType: "administrative",
                  stylers: [{ visibility: "off" }]
                },
                {
                  featureType: "landscape",
                  stylers: [{ color: "#fdfdfd" }]
                },
                {
                  featureType: "landscape",
                  elementType: "labels",
                  stylers: [{ visibility: "off" }]
                },
                {
                  featureType: "poi",
                  stylers: [{ visibility: "off" }]
                },
                {
                  featureType: "road",
                  elementType: "labels.icon",
                  stylers: [{ visibility: "off" }]
                },
                {
                  featureType: "road",
                  elementType: "geometry",
                  stylers: [{ color: "#fbddb5" }]
                },
                {
                  featureType: "administrative.locality",
                  elementType: "labels.text",
                  stylers: [{ visibility: "on", color: "#404040" }]
                },
                {
                  featureType: "water",
                  stylers: [{ color: "#e7e9f7" }]
                }
              ]
            },
            "map-type-id": "roadmap"
          }
        },
        [
          _vm._l(_vm.sectionsMap, function(section, index) {
            return _vm.resultats
              ? _c("gmap-polygon", {
                  key: section.id,
                  ref: "polygon",
                  refInFor: true,
                  attrs: {
                    paths: section.polygone,
                    clickable: true,
                    options: {
                      strokeColor: "#b0b0b0",
                      strokeOpacity: 1,
                      strokeWeight: 1,
                      fillColor:
                        _vm.gagnant === 0
                          ? section.gagnant.couleur
                          : section.display.couleur,
                      fillOpacity: _vm.opacity
                    }
                  },
                  on: {
                    click: function($event) {
                      return _vm.toggleInfoWindow(section, index)
                    }
                  }
                })
              : _vm._e()
          }),
          _vm._v(" "),
          _vm.infoContent
            ? _c(
                "gmap-info-window",
                {
                  attrs: {
                    position: _vm.infoWindowPos,
                    opened: _vm.infoWinOpen
                  },
                  on: {
                    closeclick: function($event) {
                      _vm.infoWinOpen = false
                    }
                  }
                },
                [
                  _c("h4", [
                    _c("span", { staticClass: "font-weight-bold" }, [
                      _vm._v("Section " + _vm._s(_vm.infoContent.description))
                    ]),
                    _vm._v(" "),
                    _vm.infoContent.municipalite
                      ? _c("span", [
                          _vm._v(
                            "| " +
                              _vm._s(_vm.infoContent.municipalite.nom) +
                              " (" +
                              _vm._s(_vm.infoContent.municipalite.type) +
                              ")"
                          )
                        ])
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _c(
                    "table",
                    { staticClass: "v-table px-2 py-1" },
                    [
                      _c("tr", [
                        _c("th", { staticClass: "px-2 py-1" }, [
                          _vm._v("Parti")
                        ]),
                        _vm._v(" "),
                        _c("th", { staticClass: "px-2 py-1" }, [
                          _vm._v("Candidat·e")
                        ]),
                        _vm._v(" "),
                        _c("th", { staticClass: "px-2 py-1" }, [
                          _vm._v("Nombre de votes")
                        ]),
                        _vm._v(" "),
                        _c("th", { staticClass: "px-2 py-1" }, [
                          _vm._v("Pourcentage")
                        ])
                      ]),
                      _vm._v(" "),
                      _vm._l(_vm.infoContent.sectionresultats, function(r) {
                        return _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "px-2 py-1",
                              style:
                                "border-left: 12px solid #" +
                                r.parti.couleur +
                                ";"
                            },
                            [_vm._v(_vm._s(r.parti.nom_usuel))]
                          ),
                          _vm._v(" "),
                          _c("td", { staticClass: "px-2 py-1" }, [
                            _vm._v(_vm._s(r.personne.prenom) + " "),
                            _c("span", { staticClass: "font-weight-bold" }, [
                              _vm._v(_vm._s(r.personne.nom))
                            ])
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "px-2 py-1" }, [
                            _vm._v(_vm._s(r.bv))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "px-2 py-1" }, [
                            _vm._v(_vm._s(_vm.formatPercent(r.pc_bv)))
                          ])
                        ])
                      })
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c("p", { staticClass: "text-xs-center caption px-2 py-1" }, [
                    _vm._v(
                      "\n        Nombre total de bulletins valides : " +
                        _vm._s(
                          _vm.spaceForThousands(
                            _vm.infoContent.sectionresultats[0]
                              .sectionparticipation.bv
                          )
                        ) +
                        " (" +
                        _vm._s(
                          _vm.formatPercent(
                            _vm.infoContent.sectionresultats[0]
                              .sectionparticipation.bv /
                              (_vm.infoContent.sectionresultats[0]
                                .sectionparticipation.bv +
                                _vm.infoContent.sectionresultats[0]
                                  .sectionparticipation.br)
                          )
                        ) +
                        ")"
                    ),
                    _c("br"),
                    _vm._v(
                      "\n        Nombre total de bulletins rejetés : " +
                        _vm._s(
                          _vm.spaceForThousands(
                            _vm.infoContent.sectionresultats[0]
                              .sectionparticipation.br
                          )
                        ) +
                        " (" +
                        _vm._s(
                          _vm.formatPercent(
                            _vm.infoContent.sectionresultats[0]
                              .sectionparticipation.br /
                              (_vm.infoContent.sectionresultats[0]
                                .sectionparticipation.bv +
                                _vm.infoContent.sectionresultats[0]
                                  .sectionparticipation.br)
                          )
                        ) +
                        ")"
                    ),
                    _c("br"),
                    _vm._v(
                      "\n        Vote exercé : " +
                        _vm._s(
                          _vm.spaceForThousands(
                            _vm.infoContent.sectionresultats[0]
                              .sectionparticipation.bv +
                              _vm.infoContent.sectionresultats[0]
                                .sectionparticipation.br
                          )
                        )
                    ),
                    _c("br"),
                    _vm._v(
                      "\n        Nombre total d'électeurs inscrits : " +
                        _vm._s(
                          _vm.spaceForThousands(
                            _vm.infoContent.sectionresultats[0]
                              .sectionparticipation.ei
                          )
                        )
                    ),
                    _c("br"),
                    _vm._v(
                      "\n        Taux de participation : " +
                        _vm._s(
                          _vm.formatPercent(
                            (_vm.infoContent.sectionresultats[0]
                              .sectionparticipation.bv +
                              _vm.infoContent.sectionresultats[0]
                                .sectionparticipation.br) /
                              _vm.infoContent.sectionresultats[0]
                                .sectionparticipation.ei
                          )
                        ) +
                        "  "
                    )
                  ])
                ]
              )
            : _vm._e()
        ],
        2
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/CarteResultatsSection.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/CarteResultatsSection.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CarteResultatsSection_vue_vue_type_template_id_360a268c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CarteResultatsSection.vue?vue&type=template&id=360a268c& */ "./resources/js/components/CarteResultatsSection.vue?vue&type=template&id=360a268c&");
/* harmony import */ var _CarteResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CarteResultatsSection.vue?vue&type=script&lang=js& */ "./resources/js/components/CarteResultatsSection.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CarteResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CarteResultatsSection_vue_vue_type_template_id_360a268c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CarteResultatsSection_vue_vue_type_template_id_360a268c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/CarteResultatsSection.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/CarteResultatsSection.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/CarteResultatsSection.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CarteResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./CarteResultatsSection.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CarteResultatsSection.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CarteResultatsSection_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/CarteResultatsSection.vue?vue&type=template&id=360a268c&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/CarteResultatsSection.vue?vue&type=template&id=360a268c& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CarteResultatsSection_vue_vue_type_template_id_360a268c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./CarteResultatsSection.vue?vue&type=template&id=360a268c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CarteResultatsSection.vue?vue&type=template&id=360a268c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CarteResultatsSection_vue_vue_type_template_id_360a268c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CarteResultatsSection_vue_vue_type_template_id_360a268c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);