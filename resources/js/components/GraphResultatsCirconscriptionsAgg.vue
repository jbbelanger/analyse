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
import LineChart from './charts/LineChart.js'

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
        tableau: 'parti_circonscriptions_tableau',
        graph: 'parti_circonscriptions_graph',
        carte: 'parti_circonscriptions_carte',
      },
      widgets: {
        numberType: false,
        mapType: false,
        partySelect: false,
        colorScale: false,
        electionSelect: true
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
      axios.get(`/api/elections/${this.$route.params.electionId}/resultats/partis/circonscriptions`)
      .then(response => this.resultats = response.data)
      .catch(e => console.log(e))
      .finally(() => {
        this.loading = false
        this.fillData()
      })
    },
    fillData () {
      var labels = [
        '0 % à 5%',
        '5 % à 10%',
        '10 % à 15%',
        '15 % à 20%',
        '20 % à 25%',
        '25 % à 30%',
        '30 % à 35%',
        '35 % à 40%',
        '40 % à 45%',
        '45 % à 50%',
        '50 % à 55%',
        '55 % à 60%',
        '60 % à 65%',
        '65 % à 70%',
        '70 % à 75%',
        '75 % à 80%',
        '80 % à 95%',
        '85 % à 90%',
        '90 % à 100%'
      ]
      var datasets = []
      for (var p of this.resultats) {
        datasets.push({
          label: p.nom_usuel,
          borderColor: `#${p.couleur}`,
          backgroundColor: `#${p.couleur}`,
          fill: false,
          data: [p.q1, p.q2, p.q3, p.q4, p.q5, p.q6, p.q7, p.q8, p.q9, p.q10, p.q11, p.q12, p.q13, p.q14, p.q15, p.q16, p.q17, p.q18, p.q19]
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
