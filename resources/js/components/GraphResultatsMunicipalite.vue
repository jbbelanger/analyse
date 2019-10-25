<template>
  <div class="tableau-resultats-section">
    <analyse-toolbar
      :pourcentage.sync="pourcentage"
      :viewRoutes="viewRoutes"
      :activeView="1"
      :widgets="widgets"
    />
    <line-chart :chart-data="datacollection" :options="options"></line-chart>
  </div>
</template>

<script>
import LineChart from './charts/BarChart.js'

export default {
  components: {
    LineChart
  },
  data () {
    return {
      datacollection: null,
      pourcentage: 0,
      searchString: '',
      loading: false,
      error: null,
      resultats: null,
      bvo: null,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: true,
        }
      },
      viewRoutes: {
        tableau: 'municipalites_tableau',
        graph: 'municipalites_graph',
        carte: false,
      },
      widgets: {
        numberType: true,
        mapType: false,
        partySelect: false,
        colorScale: false
      }
    }
  },
  mounted () {
    //this.fillData()
  },
  created () {
    this.get()
  },
  watch: {
    '$route':'get'
  },
  computed: {

  },
  methods: {
    get() {
      this.error = this.resultats = null
      this.loading = true
      axios.get(`/api/circonscriptions/${this.$route.params.circonscriptionId}/elections/${this.$route.params.electionId}/resultats_municipalite`)
      .then(response => this.resultats = response.data)
      .catch(e => console.log(e))
      .finally(() => {
        this.loading = false
        this.fillData()
      })
    },
    fillData () {
      var labels = this.resultats.resultats.map(
          (municipalite) => {
            return municipalite.nom
          })
      var datasets = []
      for (var resultat of this.resultats.resultats[0].sectionresultats) {
        datasets.push({
          label: resultat.parti.nom_usuel,
          backgroundColor: `#${resultat.parti.couleur}`,
          data: this.resultats.resultats.map(
            (municipalite) => {
              return municipalite.sectionresultats.filter(
                r => r.parti.id === resultat.parti.id
              ).map(
                (resultat) => {if (this.pourcentage) {return resultat.bv/resultat.ps_bv} else {return resultat.bv}}
              )
            }
          )
        })
      }
      this.datacollection = {
        labels: labels,
        datasets:datasets
        }
      },
    spaceForThousands(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    },
    formatPercent(n) {
      return +(Math.round(100* n + "e+2")  + "e-2").toString().replace(". ", ",")+" %";
    },
    getRandomInt () {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5
    }
  },
}
</script>
