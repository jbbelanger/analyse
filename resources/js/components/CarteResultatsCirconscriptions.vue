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
    <v-progress-linear class="py-0 my-0" :height="3" :v-if="page < last_page" :value="100*page/last_page"/>
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
        v-if="sectionsMap"
        v-for="(section,index) in sectionsMap"
        :key="section.id"
        :paths="section.polygone"
        :clickable="true"
        @click="toggleInfoWindow(section,index)"
        :options="{
          strokeColor: '#b0b0b0',
          strokeOpacity: 1,
          strokeWeight: 1,
          fillColor: gagnant === 0 ? section.gagnant.couleur : section.display.couleur,
          fillOpacity: opacity}"
        ref="polygon">
      </gmap-polygon>
      <gmap-info-window
        v-if="infoContent"
        :position="infoWindowPos"
        :opened="infoWinOpen"
        @closeclick="infoWinOpen=false"
      >
        <h4><span class="font-weight-bold">{{ infoContent.nom }}</span></h4>
        <table class="v-table px-2 py-1">
         <tr>
           <th class="px-2 py-1">Parti</th>
           <th class="px-2 py-1">Candidat·e</th>
           <th class="px-2 py-1">Nombre de votes</th>
           <th class="px-2 py-1">Pourcentage</th>
         </tr>
         <tr v-for="r in infoContent.resultats">
           <td
            class="px-2 py-1"
            :style="`border-left: 12px solid #${r.parti.couleur};`"
           >{{ r.parti.nom_usuel }}</td>
           <td class="px-2 py-1">{{ r.personne.prenom }} <span class="font-weight-bold">{{ r.personne.nom }}</span></td>
           <td class="px-2 py-1">{{ r.bv }}</td>
           <td class="px-2 py-1">{{ formatPercent(r.pc_bv) }}</td>
         </tr>
        </table>
        <p class="text-xs-center caption my-2 px-2 py-1">
          Nombre total de bulletins valides : {{ spaceForThousands(infoContent.resultats[0].participation.bv) }} ({{ formatPercent(infoContent.resultats[0].participation.bv/(infoContent.resultats[0].participation.bv+infoContent.resultats[0].participation.br)) }})<br>
          Nombre total de bulletins rejetés : {{ spaceForThousands(infoContent.resultats[0].participation.br) }} ({{ formatPercent(infoContent.resultats[0].participation.br/(infoContent.resultats[0].participation.bv+infoContent.resultats[0].participation.br)) }})<br>
          Vote exercé : {{ spaceForThousands(infoContent.resultats[0].participation.bv+infoContent.resultats[0].participation.br) }}<br>
          Nombre total d'électeurs inscrits : {{ spaceForThousands(infoContent.resultats[0].participation.ei) }}<br>
          Taux de participation : {{ formatPercent((infoContent.resultats[0].participation.bv+infoContent.resultats[0].participation.br)/infoContent.resultats[0].participation.ei) }}
        </p>
        <v-layout row wrap justify-end>
          <v-btn :disabled="$route.params.electionId != 42" small class="primary" depressed :to="{name: 'sections_carte', params: {circonscriptionId: infoContent.id, electionId: $route.params.electionId}}">Sections</v-btn>
        </v-layout>
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
    data () {
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
        error: [],
        resultats: [],
        bvo: null,
        page: 1,
        last_page: 25,
        gagnant: 1,
        opacity: 0.5,
        viewRoutes: {
          tableau: 'sections_tableau',
          graph: 'parti_circonscriptions_graph',
          carte: 'parti_circonscriptions_carte',
        },
        widgets: {
          numberType: true,
          mapType: true,
          partySelect: true,
          colorScale: true
        }
      }
    },
    created () {
      this.get()
    },
    watch: {
      '$route':'get',
      'page': 'getNext'
    },
    computed: {
      displayPartiName() {
        if (this.resultats.length > 0) {
          return this.resultats[0].resultats.filter(r => r.parti.id === this.displayParti)[0].parti.abb_usuelle
        } else {
          return ''
        }
      },
      scaleValues() {
        let _this = this
        if (this.resultats.length > 0) {
          let hex = `#${this.resultats[0].resultats.filter(r => r.parti.id === this.displayParti)[0].parti.couleur}`
          let id = this.resultats[0].resultats.filter(r => r.parti.id === this.displayParti)[0].parti.id
          let minmax = this.minMaxParti(_this.displayParti)
          let scale = [
            minmax[0],
            minmax[1] - ((minmax[1]-minmax[0])/2),
            minmax[1]
          ]
          return [
            {valeur: scale[0] , couleur: this.chromaValue(hex,scale[0],id)},
            {valeur: scale[1] , couleur: this.chromaValue(hex,scale[1],id)},
            {valeur: scale[2] , couleur: this.chromaValue(hex,scale[2],id)}
          ]
        } else {
          return [
            {valeur: 0 , couleur: '#fff'},
            {valeur: 0 , couleur: '#fff'},
            {valeur: 0 , couleur: '#fff'},
          ]
        }
      },
      partis() {
        let _this = this
        if (_this.resultats.length > 0) {
          return _this.resultats[0].resultats.sort(
            (a,b) =>  a.circorang - b.circorang
          ).map(
            (resultat) => {return resultat.parti}
          )
        }
      },
      sectionsMap() {
        let _this = this
        if (_this.resultats.length > 0) {
          let data = _this.resultats
          var circonscriptions = []
          for(var circonscription of data) {
            let geojson = JSON.parse(circonscription.circopolygone.polygone)
            var pgon
            if (geojson.geometry) {
              var arr = []
              for (var a of geojson.geometry.coordinates[0]) {
                arr.push(
                  a.map((p) => {return {lng: p[0], lat: p[1]}})
                )
              }
              pgon = arr
            } else {
              pgon = geojson
            }

            if (circonscription.resultats.length > 0 && circonscription.circopolygone) {
              let display = circonscription.resultats.filter(r => r.parti.id === _this.displayParti)
              var circonscription_info = {
                'id':	circonscription.id,
                'nom':	circonscription.nom,
                'region':	circonscription.region,
                'polygone': pgon,
                'resultats': [],
                'display': {
                  'hex': display[0].parti.couleur,
                  'bv': display[0].bv,
                  'parti': display[0].parti.id,
                  'couleur': _this.chromaValue(display[0].parti.couleur, _this.pourcentage === 1 ? display[0].bv/display[0].participation.bv : display[0].bv, display[0].parti.id)
                },
                'gagnant': {
                  'bv': 0,
                  'couleur': null
                }
              }
              for (var r of circonscription.resultats) {
                if (circonscription_info.gagnant.bv === 0) {
                  circonscription_info.gagnant.bv = r.bv,
                  circonscription_info.gagnant.couleur = `#${r.parti.couleur}`
                } else if (r.bv >= circonscription_info.gagnant.bv) {
                  if (r.bv > circonscription_info.gagnant.bv) {
                    circonscription_info.gagnant.bv = r.bv,
                    circonscription_info.gagnant.couleur = `#${r.parti.couleur}`
                  } else if (r.bv === circonscription_info.gagnant.bv) {
                    circonscription_info.gagnant.couleur = '#ffffff'
                  }
                }
                circonscription_info.resultats.push({
                  'id': r.id,
                  'bv':	r.bv,
                  'pc_bv': r.participation ? r.bv / r.participation.bv : r.bv/r.ps_bv,
                  'rang'	: r.rang,
                  'parti': r.parti,
                  'participation': r.participation ? r.participation : {'bv': r.ps_bv, 'br': r.ps_br, 'ei': r.ps_ei},
                  'personne': r.personne
                })
              }
              circonscriptions.push(circonscription_info)
            }
          }
          return circonscriptions
        } else {
          this.error.push('Erreur dans l\'évaluation de «sectionsMap»: La propriété « resultats » est vide ou introuvable')
          return false
        }
      }
    },
    methods: {
      get() {
        this.displayParti = parseInt(this.$route.params.partiId)
        this.loading = true
        axios.get(`/api/elections/${this.$route.params.electionId}/resultats/circonscriptions/polygones?page=${this.page}`)
        .then(response => {
          for (var d of response.data.data) {
            this.resultats.push(d)
          }
          this.page ++
        })
        .catch(e => {
          console.log(e)
          this.loading = false
        })
      },
      getNext() {
        if (this.page <= this.last_page) {
          this.get()
          if (this.page === this.last_page) {
            this.loading = false
          }
        }
      },
      returnWinner(resultsArray) {
        return resultsArray.sort((a, b) => b.bv - a.bv)[0]
      },
      spaceForThousands(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
      },
      formatPercent(n) {
        return +(Math.round(100* n + "e+2")  + "e-2").toString().replace(". ", ",")+" %";
      },
      chromaValue(hex,value,parti) {
        let _this = this
        if (!hex || !value || !parti) {
          if (!hex) {
            _this.error.push({description: 'Erreur dans l\'évaluation de « chromaValue »: La propriété « hex » est vide ou introuvable', value: hex})
          }
          if (!value) {
            _this.error.push({description: 'Erreur dans l\'évaluation de « chromaValue »: La propriété « value » est vide ou introuvable', value: value})
          }
          if (!parti) {
            _this.error.push({description: 'Erreur dans l\'évaluation de « chromaValue »: La propriété « parti » est vide ou introuvable', value: parti})
          }
        } else {
          let domain = this.minMaxParti(parti)
          let s = chroma.scale(['#ffffff',hex]).mode('lab').domain(domain)
          return s(value).hex()
        }
      },
      minMaxParti(id) {
        let _this = this
        let resultats = this.resultats.filter(
          c => c.resultats.length > 0
        ).map(
          (circonscription) => {
            return circonscription.resultats.filter(
              r => r.parti.id === id
            ).map(
              (resultat) => {
                if (_this.pourcentage === 1 && resultat.participation) {
                  return resultat.bv/resultat.participation.bv
                } else if (_this.pourcentage === 1 && !resultat.participation) {
                  return resultat.bv/resultat.ps_bv
                } else {
                  return resultat.bv
                }
              }
            )
          }
        )
        return [Math.min(...resultats),Math.max(...resultats)]
      },
      toggleInfoWindow(section, index) {
        let lat = section.polygone[0].map((coords) => {return coords.lat})
        let lng = section.polygone[0].map((coords) => {return coords.lng})
        let sectionCenter = {
          lat: Math.min(...lat) + ( Math.max(...lat) - Math.min(...lat) ) / 2,
          lng: Math.min(...lng) + ( Math.max(...lng) - Math.min(...lng) ) / 2
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
      }
    },
  }
</script>
