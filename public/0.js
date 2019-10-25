(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/bigMap.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/bigMap.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      toget: {
        election: 42,
        circonscription: 475
      },
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
      sections: {
        errors: [],
        loading: false,
        list: []
      },
      mapToolbar: {},
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
      },
      resultatsTableHeaders: [{
        text: "Parti",
        value: "parti.nom_usuel",
        align: "left"
      }, {
        text: "Candidat·e",
        value: "personne.nom",
        align: "left"
      }, {
        text: "Nombre de votes",
        value: "bv",
        align: "right"
      }, {
        text: "Pourcentage",
        value: "pc_bv",
        align: "right"
      }]
    };
  },
  created: function created() {},
  watch: {
    '$route': 'get',
    'page': 'getNext'
  },
  computed: {
    infoWindowResultats: function infoWindowResultats() {
      if (this.infoContent) {
        return this.infoContent.resultats.sort(function (a, b) {
          return b.bv - a.bv;
        });
      } else {
        return null;
      }
    },
    partis: function partis() {
      var flat = this.sections.list.map(function (s) {
        return s.resultats.map(function (r) {
          return r.parti;
        });
      }).flat();
      return _toConsumableArray(new Set(flat.map(function (p) {
        return p.id;
      }))).map(function (id) {
        return {
          id: id,
          nom_usuel: flat.find(function (p) {
            return p.id === id;
          }).nom_usuel,
          abb_usuelle: flat.find(function (p) {
            return p.id === id;
          }).abb_usuelle,
          couleur: flat.find(function (p) {
            return p.id === id;
          }).couleur
        };
      });
    },
    displayPartiName: function displayPartiName() {
      var _this2 = this;

      var sections = this.sections.list;

      if (sections.length > 0) {
        return this.partis.filter(function (p) {
          return p.id === _this2.displayParti;
        })[0].abb_usuelle;
      } else {
        return '';
      }
    },
    scaleValues: function scaleValues() {
      var _this3 = this;

      var _this = this;

      var sections = this.sections.list;

      if (sections.length > 0) {
        var hex = "#".concat(this.partis.filter(function (p) {
          return p.id === _this3.displayParti;
        })[0].couleur);
        var id = this.partis.filter(function (p) {
          return p.id === _this3.displayParti;
        })[0].id;
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
        var blank = {
          valeur: 0,
          couleur: '#fff'
        };
        return [blank, blank, blank];
      }
    },
    sectionsMap: function sectionsMap() {
      var _this = this;

      var sectionsList = this.sections.list;

      if (sectionsList.length > 0) {
        var sections = [];
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = sectionsList[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var section = _step.value;

            //reformatter certains polygones
            var polygone = _this.readGeoJSON(section.polygone.polygone); //vérifier si la section contient des résultats et un polygone


            if (section.resultats.length > 0 && section.polygone) {
              var filterParti = section.resultats.filter(function (r) {
                return r.parti.id === _this.displayParti;
              });
              var displayParti = null; //vérifier si la section de vote contien des résultats qui correspondent au parti affiché

              if (filterParti.length > 0) {
                displayParti = {
                  hex: filterParti[0].parti.couleur,
                  bv: filterParti[0].bv,
                  parti: filterParti[0].parti.id,
                  couleur: _this.chromaValue(filterParti[0].parti.couleur, _this.pourcentage === 1 ? filterParti[0].bv / section.participation.bv : filterParti[0].bv, filterParti[0].parti.id)
                };
              } else {
                //si non, on met la section en gris
                displayParti = {
                  hex: '#cecece',
                  bv: 0,
                  parti: null,
                  couleur: '#cecece'
                };
              }

              var section_info = {
                id: section.id,
                description: section.description,
                display: displayParti,
                municipalite: section.municipalite,
                participation: section.participation,
                polygone: polygone,
                resultats: [],
                gagnant: {
                  bv: -1,
                  couleur: null
                }
              };
              var _iteratorNormalCompletion2 = true;
              var _didIteratorError2 = false;
              var _iteratorError2 = undefined;

              try {
                for (var _iterator2 = section.resultats[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                  var r = _step2.value;

                  //trouver itérativement le gagnant de la section de vote
                  //si le résultat itéré a plus de votes que le précédent consigné, il devient le gagnant
                  if (r.bv > section_info.gagnant.bv) {
                    section_info.gagnant.bv = r.bv, section_info.gagnant.couleur = "#".concat(r.parti.couleur);
                  } else if (r.bv === section_info.gagnant.bv) {
                    section_info.gagnant.couleur = '#ffffff';
                  }

                  section_info.resultats.push({
                    id: r.id,
                    bv: r.bv,
                    pc_bv: r.bv / section.participation.bv,
                    circorang: r.circorang,
                    parti: r.parti,
                    personne: r.personne
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

      this.sections.loading = true;
      axios.get("/api/circonscriptions/".concat(this.toget.circonscription, "?relations=sections.sectionresultats.parti,sections.sectionresultats.personne,sections.sectionparticipation,sections.municipalite,sections.sectionpolygone&election=").concat(this.toget.election, "&scrutin=1")).then(function (response) {
        var _this4$sections$list;

        (_this4$sections$list = _this4.sections.list).push.apply(_this4$sections$list, _toConsumableArray(response.data.data.sections));

        _this4.sections.loading = false;
      })["catch"](function (error) {
        return _this4.sections.errors.push(error);
      });
    },
    returnWinner: function returnWinner(resultsArray) {
      return resultsArray.sort(function (a, b) {
        return b.bv - a.bv;
      })[0];
    },
    chromaValue: function chromaValue(hex, value, parti) {
      var domain = this.minMaxParti(parti);
      var s = chroma_js__WEBPACK_IMPORTED_MODULE_0___default.a.scale(['#ffffff', hex]).mode('lab').domain(domain);
      return s(value).hex();
    },
    minMaxParti: function minMaxParti(id) {
      var _this = this;

      var resultats = this.sections.list.filter(function (s) {
        return s.resultats.length > 0;
      }).map(function (section) {
        return section.resultats.filter(function (r) {
          return r.parti.id === id;
        }).map(function (resultat) {
          if (_this.pourcentage === 1) {
            return resultat.bv / section.participation.bv;
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
    },
    readGeoJSON: function readGeoJSON(geojson) {
      var g = JSON.parse(geojson);

      if (g.geometry) {
        return g.geometry.coordinates[0].map(function (c) {
          return c.map(function (p) {
            return {
              lng: p[0],
              lat: p[1]
            };
          });
        });
      } else {
        return geojson;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/bigMap.vue?vue&type=template&id=27566f70&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/views/bigMap.vue?vue&type=template&id=27566f70& ***!
  \***************************************************************************************************************************************************************************************************************/
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
      _c("v-text-field", {
        attrs: { label: "Élection" },
        model: {
          value: _vm.toget.election,
          callback: function($$v) {
            _vm.$set(_vm.toget, "election", $$v)
          },
          expression: "toget.election"
        }
      }),
      _vm._v(" "),
      _c("v-text-field", {
        attrs: { label: "Circonscription" },
        model: {
          value: _vm.toget.circonscription,
          callback: function($$v) {
            _vm.$set(_vm.toget, "circonscription", $$v)
          },
          expression: "toget.circonscription"
        }
      }),
      _vm._v(" "),
      _c("v-btn", { on: { click: _vm.get } }, [_vm._v("GET")]),
      _vm._v(" "),
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
      _vm.sections.loading
        ? _c("v-progress-linear", {
            staticClass: "pb-0 my-0",
            attrs: { height: 2, indeterminate: "" }
          })
        : _vm._e(),
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
                          : section.display
                          ? section.display.couleur
                          : "#ffffff",
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
                  _c(
                    "v-sheet",
                    { attrs: { light: "", dark: false } },
                    [
                      _c("h3", [
                        _c("span", { staticClass: "font-weight-bold" }, [
                          _vm._v(
                            "Section " + _vm._s(_vm.infoContent.description)
                          )
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
                      _c("v-data-table", {
                        staticClass: "body-1",
                        attrs: {
                          headers: _vm.resultatsTableHeaders,
                          items:
                            _vm.infoWindowResultats.length > 0
                              ? _vm.infoWindowResultats
                              : [],
                          dense: true,
                          "hide-default-footer": ""
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "item.parti.nom_usuel",
                              fn: function(ref) {
                                var item = ref.item
                                return [
                                  _c(
                                    "v-tooltip",
                                    {
                                      attrs: { dark: "", bottom: "" },
                                      scopedSlots: _vm._u(
                                        [
                                          {
                                            key: "activator",
                                            fn: function(ref) {
                                              var on = ref.on
                                              return [
                                                _c(
                                                  "v-avatar",
                                                  _vm._g(
                                                    {
                                                      staticStyle: {
                                                        color: "white"
                                                      },
                                                      attrs: {
                                                        size: 28,
                                                        color:
                                                          "#" +
                                                          item.parti.couleur
                                                      }
                                                    },
                                                    on
                                                  ),
                                                  [
                                                    _c(
                                                      "span",
                                                      {
                                                        staticClass: "caption"
                                                      },
                                                      [
                                                        _vm._v(
                                                          _vm._s(
                                                            item.parti
                                                              .abb_usuelle
                                                          )
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                )
                                              ]
                                            }
                                          }
                                        ],
                                        null,
                                        true
                                      )
                                    },
                                    [
                                      _vm._v(" "),
                                      _c("span", [
                                        _vm._v(_vm._s(item.parti.nom_usuel))
                                      ])
                                    ]
                                  )
                                ]
                              }
                            },
                            {
                              key: "item.personne.nom",
                              fn: function(ref) {
                                var item = ref.item
                                return [
                                  _vm._v(
                                    "\n            " +
                                      _vm._s(item.personne.prenom) +
                                      " "
                                  ),
                                  _c(
                                    "span",
                                    { staticClass: "font-weight-bold" },
                                    [_vm._v("  " + _vm._s(item.personne.nom))]
                                  )
                                ]
                              }
                            },
                            {
                              key: "item.bv",
                              fn: function(ref) {
                                var item = ref.item
                                return [
                                  _vm._v(
                                    "\n            " +
                                      _vm._s(_vm._f("numeralFormat")(item.bv)) +
                                      "\n          "
                                  )
                                ]
                              }
                            },
                            {
                              key: "item.pc_bv",
                              fn: function(ref) {
                                var item = ref.item
                                return [
                                  _vm._v(
                                    "\n            " +
                                      _vm._s(
                                        _vm._f("numeralFormat")(
                                          item.pc_bv,
                                          "0.00 %"
                                        )
                                      ) +
                                      "\n          "
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          1866017772
                        )
                      }),
                      _vm._v(" "),
                      _c(
                        "v-sheet",
                        {
                          staticStyle: { margin: "15px 0 -15px" },
                          attrs: { elevation: "1" }
                        },
                        [
                          _c("p", { staticClass: "text-center caption" }, [
                            _vm._v(
                              "\n            Nombre total de bulletins valides : " +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    _vm.infoContent.participation.bv
                                  )
                                ) +
                                "\n            (" +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    _vm.infoContent.participation.bv /
                                      (_vm.infoContent.participation.bv +
                                        _vm.infoContent.participation.br),
                                    "0.00 %"
                                  )
                                ) +
                                ")"
                            ),
                            _c("br"),
                            _vm._v(
                              "\n            Nombre total de bulletins rejetés : " +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    _vm.infoContent.participation.br
                                  )
                                ) +
                                "\n            (" +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    _vm.infoContent.participation.br /
                                      (_vm.infoContent.participation.bv +
                                        _vm.infoContent.participation.br),
                                    "0.00 %"
                                  )
                                ) +
                                ")"
                            ),
                            _c("br"),
                            _vm._v(
                              "\n            Vote exercé : " +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    _vm.infoContent.participation.bv +
                                      _vm.infoContent.participation.br
                                  )
                                )
                            ),
                            _c("br"),
                            _vm._v(
                              "\n            Nombre total d'électeurs inscrits : " +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    _vm.infoContent.participation.ei
                                  )
                                )
                            ),
                            _c("br"),
                            _vm._v(
                              "\n            Taux de participation : " +
                                _vm._s(
                                  _vm._f("numeralFormat")(
                                    (_vm.infoContent.participation.bv +
                                      _vm.infoContent.participation.br) /
                                      _vm.infoContent.participation.ei,
                                    "0.00 %"
                                  )
                                ) +
                                "\n          "
                            )
                          ])
                        ]
                      )
                    ],
                    1
                  )
                ],
                1
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

/***/ "./resources/js/components/views/bigMap.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/views/bigMap.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _bigMap_vue_vue_type_template_id_27566f70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./bigMap.vue?vue&type=template&id=27566f70& */ "./resources/js/components/views/bigMap.vue?vue&type=template&id=27566f70&");
/* harmony import */ var _bigMap_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./bigMap.vue?vue&type=script&lang=js& */ "./resources/js/components/views/bigMap.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _bigMap_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _bigMap_vue_vue_type_template_id_27566f70___WEBPACK_IMPORTED_MODULE_0__["render"],
  _bigMap_vue_vue_type_template_id_27566f70___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/views/bigMap.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/views/bigMap.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/views/bigMap.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_bigMap_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./bigMap.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/bigMap.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_bigMap_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/views/bigMap.vue?vue&type=template&id=27566f70&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/views/bigMap.vue?vue&type=template&id=27566f70& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_bigMap_vue_vue_type_template_id_27566f70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./bigMap.vue?vue&type=template&id=27566f70& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/views/bigMap.vue?vue&type=template&id=27566f70&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_bigMap_vue_vue_type_template_id_27566f70___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_bigMap_vue_vue_type_template_id_27566f70___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);