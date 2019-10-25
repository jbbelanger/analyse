<template>
  <div class="tableau-resultats-section">
    <analyse-toolbar
      :pourcentage.sync="pourcentage"
      :viewRoutes="viewRoutes"
      :activeView="0"
      :widgets="widgets"
    />
    <v-data-table
      class="body-1"
      :loading="resultats.loading"
      :headers='headers'
      :items="formattedResults"
      search
    >
      <template v-slot:item.description="{ item }">

      </template>

      <template v-slot:item="{ item }">
        <tr>
          <td><v-avatar small :color="item.gagnant.couleur">{{ item.description }}</v-avatar></td>
          <td>{{ item.municipalite }}</td>
          <td
            class="text-xs-right"
            v-for="resultat in item.resultats"
            :style="`border-left: 3px solid #${resultat.parti.couleur}; background-color:${chromaValue(resultat.parti.couleur, resultat.value, resultat.parti.id, item.description)};`">
            <span :class="resultat.bv === item.gagnant.bv ? 'font-weight-bold' : '' ">
              <template v-if="pourcentage">{{ resultat.value | numeralFormat('0.00 %') }}</template>
              <template v-if="!pourcentage">{{ resultat.value | numeralFormat }}</template>
            </span>
          </td>
        </tr>
      </template>

    </v-data-table>

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
          carte: 'sections_carte',
        },
        widgets: {
          numberType: true,
          mapType: false,
          partySelect: false,
          colorScale: false
        }
      }
    },
    created () {
      this.getResulatsElection()
    },
    watch: {
      '$route':'getResulatsElection'
    },
    computed: {
      headers() {
        var headers = [
          {text: "Section", value: "description", align: "left", color: "transparent"},
          {text: "Municipalite", value: "municipalite", align: "left", color: "transparent"}
        ]
        if (this.resultats.data) {
          for (var r of this.resultats.data.sections[0].resultats) {
            headers.push({
              text: `${r.parti.abb_usuelle}`,
              value: `resultats[${r.parti.abb_usuelle}].value`,
              align: "right",
              color: `#${r.parti.couleur}`
            })
          }
        }

        return headers
      },
      formattedResults() {
        let _this = this
        var formatted_results = []
        if (this.resultats.data) {
          for (var s of this.resultats.data.sections) {
            var section_info = {
              'description':	s.description,
              'municipalite': s.municipalite ? s.municipalite.nom : '',
              'resultats': {},
              'gagnant': {
                'bv': 0,
                'couleur': null
              }
            }

            for (var r of s.resultats) {
              if (section_info.gagnant.bv === 0) {
                section_info.gagnant.bv = r.bv,
                section_info.gagnant.couleur = '#' + r.parti.couleur
              } else if (r.bv >= section_info.gagnant.bv) {
                if (r.bv > section_info.gagnant.bv) {
                  section_info.gagnant.bv = r.bv,
                  section_info.gagnant.couleur = '#' + r.parti.couleur
                } else if (r.bv === section_info.gagnant.bv) {
                  section_info.gagnant.couleur = 'transparent'
                }
              }
              section_info.resultats[r.parti.abb_usuelle] = {
                'value': this.pourcentage ? r.bv / s.participation.bv : r.bv,
                'circorang'	: r.circorang,
                'parti': r.parti,
                'personne': r.personne
              }
            }

            formatted_results.push(section_info)
          }
        } else {
          return []
        }
        return formatted_results
      }
    },
    methods: {
      getResulatsElection() {
        this.resultats.data = null
        this.resultats.loading = true
        axios.get(`/api/circonscriptions/${this.$route.params.circonscriptionId}?relations=sections.sectionresultats.parti,sections.sectionresultats.personne,sections.sectionparticipation,sections.municipalite&election=${this.$route.params.electionId}&scrutin=1`)
        .then(response => this.resultats.data = response.data.data)
        .catch(error => this.resultats.errors.push(error))
        .finally(() => this.resultats.loading = false)
      },
      returnWinner(resultsArray) {
        return resultsArray.sort((a, b) => b.bv - a.bv)[0]
      },
      chromaValue(hex, value, parti, section) {
        //console.log(hex, value, parti, section)
        let domain = this.minMaxParti(parti)
        if (chroma.valid(hex)) {
          let s = chroma.scale(['rgba(255,255,255,0)',`#${hex}`]).mode('lab').domain(domain)
          return s(value).hex()
        } else {
          return 'transparent'
        }

      },
      minMaxParti(id) {
        let _this = this
        let resultats = this.resultats.data.sections.filter(
          s => s.resultats.length > 0
        ).map(
          (section) => {
            return section.resultats.filter(
              r => r.parti.id === id
            ).map(
              (resultat) => {
                if (_this.pourcentage === 1 && !isNaN(resultat.bv)) {
                  return resultat.bv/section.participation.bv
                } else if (!isNaN(resultat.bv)){
                  return resultat.bv
                }
              }
            )
          }
        )
        return [Math.min(...resultats),Math.max(...resultats)]
      },
      csvThis() {
        let json = this.formattedResults
        let csv = this.$papa.unparse(json)
        let title = 'Jean-Talon 2018'
        this.$papa.download(csv, title)
      }
    },
  }
</script>
