<template>
  <div class="carte-resultats-section">
    <analyse-toolbar
      :gagnant.sync="gagnant"
      :partis.sync="partis"
      :displayParti.sync="displayParti"
      :displayPartiName="displayPartiName"
      :pourcentage.sync="pourcentage"
      :scaleValues="scaleValues"
      :opacity="opacity"
      :viewRoutes="viewRoutes"
      :activeView="2"
      :widgets="widgets"
    />
    <v-progress-linear class="pb-0 my-0" :height="2" indeterminate v-if="sections.loading"/>
    <gmap-map
      :center="{lat: 47.487692, lng: -75.025446}"
      :zoom="6"
      :options='{
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true,
        disableDefaultUi: false,
        styles:
          [
            {
              "featureType": "administrative",
              "stylers": [{"visibility": "off"}]
            },{
              "featureType": "landscape",
              "stylers": [{"color": "#fdfdfd"}]
            },{
              "featureType": "landscape",
              "elementType": "labels",
              "stylers": [{"visibility": "off"}]
            },{
              "featureType": "poi",
              "stylers": [{"visibility": "off"}]
            },{
              "featureType": "road",
              "elementType": "labels.icon",
              "stylers": [{"visibility": "off"}]
            },{
              "featureType": "road",
              "elementType": "geometry",
              "stylers": [{"color": "#fbddb5"}]
            },{
              "featureType": "administrative.locality",
              "elementType": "labels.text",
              "stylers": [{"visibility": "on","color": "#404040"}]
            },{
              "featureType": "water",
              "stylers": [{"color": "#e7e9f7"}]
            }
          ]
        }'
      map-type-id="roadmap"
      style="width: 100%; height: calc(100vh - 64px - 24px - 24px)">
      <gmap-polygon
        v-if="resultats"
        v-for="(section,index) in sectionsMap"
        :key="section.id"
        :paths="section.polygone"
        :clickable="true"
        @click="toggleInfoWindow(section, index)"
        :options="{
          strokeColor: '#b0b0b0',
          strokeOpacity: 1,
          strokeWeight: 1,
          fillColor: gagnant === 0 ? section.gagnant.couleur : section.display ? section.display.couleur : '#ffffff',
          fillOpacity: opacity
        }"
        ref="polygon">
      </gmap-polygon>
      <gmap-info-window
        v-if="infoContent"
        :position="infoWindowPos"
        :opened="infoWinOpen"
        @closeclick="infoWinOpen=false"
      >
        <v-sheet light :dark="false">
          <h3><span class="font-weight-bold">Section {{ infoContent.description }}</span> <span v-if="infoContent.municipalite">| {{ infoContent.municipalite.nom }} ({{ infoContent.municipalite.type }})</span></h3>
          <v-data-table
            class="body-1"
            :headers='resultatsTableHeaders'
            :items="infoWindowResultats.length > 0 ? infoWindowResultats : []"
            :dense="true"
            hide-default-footer
          >
            <template v-slot:item.parti.nom_usuel="{ item }">
              <v-tooltip dark bottom>
                <template v-slot:activator="{ on }">
                  <v-avatar :size="28" style="color: white" v-on="on" :color="`#${item.parti.couleur}`"><span class="caption">{{ item.parti.abb_usuelle }}</span></v-avatar>
                </template>
                <span>{{ item.parti.nom_usuel }}</span>
              </v-tooltip>
            </template>

            <template v-slot:item.personne.nom="{ item }">
              {{ item.personne.prenom }} <span class="font-weight-bold">  {{ item.personne.nom }}</span>
            </template>

            <template v-slot:item.bv="{ item }">
              {{ item.bv | numeralFormat }}
            </template>

            <template v-slot:item.pc_bv="{ item }">
              {{ item.pc_bv | numeralFormat('0.00 %') }}
            </template>
          </v-data-table>

          <v-sheet elevation="1" style="margin: 15px 0 -15px;">
            <p class="text-center caption">
              Nombre total de bulletins valides : {{ infoContent.participation.bv | numeralFormat }}
              ({{ infoContent.participation.bv / (infoContent.participation.bv + infoContent.participation.br) | numeralFormat('0.00 %') }})<br>
              Nombre total de bulletins rejetés : {{ infoContent.participation.br | numeralFormat }}
              ({{ infoContent.participation.br / (infoContent.participation.bv + infoContent.participation.br) | numeralFormat('0.00 %') }})<br>
              Vote exercé : {{ infoContent.participation.bv + infoContent.participation.br | numeralFormat }}<br>
              Nombre total d'électeurs inscrits : {{ infoContent.participation.ei | numeralFormat }}<br>
              Taux de participation : {{ (infoContent.participation.bv + infoContent.participation.br) / infoContent.participation.ei | numeralFormat('0.00 %') }}
            </p>
          </v-sheet>
        </v-sheet>
      </gmap-info-window>
    </gmap-map>
  </div>
</template>

<script>
import chroma from 'chroma-js'
export default {
  props: {
      electionId: Number,
      circonscriptionId: Number
  },
  data() {
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

          sections: {
            errors: [],
            loading: false,
            list: []
          },
          mapToolbar: {

          },
          bvo: null,
          page: 1,
          last_page: null,
          gagnant: 1,
          opacity: 0.5,
          viewRoutes: {
              tableau: 'sections_tableau',
              graph: 'sections_graph',
              carte: 'sections_carte',
          },
          widgets: {
              numberType: true,
              mapType: true,
              partySelect: true,
              colorScale: true
          },
          resultatsTableHeaders: [
            {text: "Parti", value: "parti.nom_usuel", align: "left"},
            {text: "Candidat·e", value: "personne.nom", align: "left"},
            {text: "Nombre de votes", value: "bv", align: "right"},
            {text: "Pourcentage", value: "pc_bv", align: "right"}
          ]
      }
  },
  created() {
      this.get()
  },
  watch: {
      '$route': 'get',
      'page': 'getNext'
  },
  computed: {
    infoWindowResultats() {
      if (this.infoContent) {
        return this.infoContent.resultats.sort((a, b) => b.bv - a.bv)
      } else {
        return null
      }
    },

    partis() {
      let flat = this.sections.list.map((s) => {
        return s.resultats.map((r) => {
            return r.parti
          })
        }).flat()

      return [... new Set(flat.map(p => {return p.id}))].map((id) => {
        return {
          id: id,
          nom_usuel: flat.find(p => p.id === id).nom_usuel,
          abb_usuelle: flat.find(p => p.id === id).abb_usuelle,
          couleur: flat.find(p => p.id === id).couleur
        }
      })
    },

    displayPartiName() {
      let sections = this.sections.list
      if (sections.length > 0) {
          return this.partis.filter(p => p.id === this.displayParti)[0].abb_usuelle
      } else {
          return ''
      }
    },
    scaleValues() {
      let _this = this
      let sections = this.sections.list
      if (sections.length > 0) {
        let hex = `#${this.partis.filter(p => p.id === this.displayParti)[0].couleur}`
        let id = this.partis.filter(p => p.id === this.displayParti)[0].id
        let minmax = this.minMaxParti(_this.displayParti)
        let scale = [
            minmax[0],
            minmax[1] - ((minmax[1] - minmax[0]) / 2),
            minmax[1]
        ]
        return [{
            valeur: scale[0],
            couleur: this.chromaValue(hex, scale[0], id)
          },
          {
            valeur: scale[1],
            couleur: this.chromaValue(hex, scale[1], id)
          },
          {
            valeur: scale[2],
            couleur: this.chromaValue(hex, scale[2], id)
          }
        ]
      } else {
        let blank = {valeur: 0, couleur: '#fff'}
        return [blank, blank, blank]
      }
    },
    sectionsMap() {
      let _this = this
      let sectionsList = this.sections.list
      if (sectionsList.length > 0) {
        var sections = []
        for (var section of sectionsList) {
          //reformatter certains polygones
          let polygone = _this.readGeoJSON(section.polygone, section.id)

          //vérifier si la section contient des résultats et un polygone
          if (section.resultats.length > 0 && section.polygone) {
            let filterParti = section.resultats.filter(r => r.parti.id === _this.displayParti)
            let displayParti = null

            //vérifier si la section de vote contien des résultats qui correspondent au parti affiché
            if (filterParti.length > 0) {
              displayParti = {
                hex: filterParti[0].parti.couleur,
                bv: filterParti[0].bv,
                parti: filterParti[0].parti.id,
                couleur: _this.chromaValue(filterParti[0].parti.couleur, _this.pourcentage === 1 ? filterParti[0].bv / section.participation.bv : filterParti[0].bv, filterParti[0].parti.id)
              }
            } else {
              //si non, on met la section en gris
              displayParti = {
                hex: '#cecece',
                bv: 0,
                parti: null,
                couleur: '#cecece'
              }
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
            }
            for (var r of section.resultats) {
              //trouver itérativement le gagnant de la section de vote
              //si le résultat itéré a plus de votes que le précédent consigné, il devient le gagnant
              if (r.bv > section_info.gagnant.bv) {
                section_info.gagnant.bv = r.bv,
                section_info.gagnant.couleur = `#${r.parti.couleur}`
              } else if (r.bv === section_info.gagnant.bv) {
                section_info.gagnant.couleur = '#ffffff'
              }

              section_info.resultats.push({
                id: r.id,
                bv: r.bv,
                pc_bv: r.bv / section.participation.bv,
                circorang: r.circorang,
                parti: r.parti,
                personne: r.personne
              })
            }
            sections.push(section_info)
          }
        }
        return sections
      } else {
        return 'La propriété « resultats » est vide ou introuvable'
      }
    }
  },
  methods: {
    get() {
      this.sections.loading = true
      axios.get(`/api/circonscriptions/${this.$route.params.circonscriptionId}?relations=sections.sectionresultats.parti,sections.sectionresultats.personne,sections.sectionparticipation,sections.municipalite,sections.sectionpolygone&election=${this.$route.params.electionId}&scrutin=1`)
      .then(response => {
        this.sections.list = response.data.data.sections
        this.sections.loading = false
      })
      .catch(error => this.sections.errors.push(error))
    },

    returnWinner(resultsArray) {
      return resultsArray.sort((a, b) => b.bv - a.bv)[0]
    },

    chromaValue(hex, value, parti) {
      let domain = this.minMaxParti(parti)
      let s = chroma.scale(['#ffffff', hex]).mode('lab').domain(domain)
      return s(value).hex()
    },

    minMaxParti(id) {
      let _this = this
      let resultats = this.sections.list.filter(
        s => s.resultats.length > 0
      ).map(
        (section) => {
          return section.resultats.filter(
            r => r.parti.id === id
          ).map(
            (resultat) => {
              if (_this.pourcentage === 1) {
                return resultat.bv / section.participation.bv
              } else {
                return resultat.bv
              }
            }
          )
        }
      )
      return [Math.min(...resultats), Math.max(...resultats)]
    },

    toggleInfoWindow(section, index) {
      let lat = section.polygone[0].map((coords) => {
        return coords.lat
      })
      let lng = section.polygone[0].map((coords) => {
        return coords.lng
      })
      let sectionCenter = {
        lat: Math.min(...lat) + (Math.max(...lat) - Math.min(...lat)) / 2,
        lng: Math.min(...lng) + (Math.max(...lng) - Math.min(...lng)) / 2
      }

      this.infoWindowPos = sectionCenter;
      this.infoContent = section;

      //check if its the same marker that was selected if yes toggle
      if (this.currentSectionIndex == index) {
        this.infoWinOpen = !this.infoWinOpen;
      }
      //if different marker set infowindow to open and reset current marker index
      else {
        this.infoWinOpen = true;
        this.currentSectionIndex = index;
      }
    },

    readGeoJSON(geojson, id) {
      if (geojson) {
        let g = JSON.parse(geojson.polygone)
        if (g.geometry) {
          return g.geometry.coordinates[0].map(c => {
            return c.map(p => {
              return {lng: p[0], lat: p[1]}
            })
          })
        } else {
          return geojson.polygone
        }
      } else {
        return null
      }
    }
  },
}
</script>
