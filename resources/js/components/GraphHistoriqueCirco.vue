<template>
  <div>
    <line-chart :chart-data="datacollection" :options="options"></line-chart>
    <v-btn
      fab
      small
      absolute
      top
      right
      @click="pourcentage === 0 ? pourcentage = 1 : pourcentage = 0"
    >%</v-btn>
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
      datacollection: {
        labels: [],
        datasets: []
      },
      pourcentage: 0,
      searchString: '',
      timeline: {
        data: null,
        errors: [],
        loading: false
      },
      bvo: null,
    }
  },
  mounted () {
    //this.fillData()
  },
  created () {
    this._get()
  },
  watch: {
    '$route': '_get',
    'pourcentage': 'fillData',
    'options.legend.display': 'fillData'
  },
  computed: {
    options() {
      var max
      if (this.timeline.data) {
        max = Math.max(... this.timeline.data.elections.map(e => {
          return e.circoresultatsgroupes.map(r => {
            return this.pourcentage === 0 ? r.bv : r.bv / r.participation.bv
          })
        }).flat())
      } else {
        max = 0
      }

      return {
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 2,
        legend: {
          display: false,
          position: 'right'
        },
        scales: {
          xAxes: [{
            type: 'time',
            time: {
              unit: 'year',
              min: new Date('2007-01-01')
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              //max: max,// Your absolute max value
              callback: function (value) {
                if (this.pourcentage === 1) {
                  return (value / max * 100).toFixed(0) + '%'; // convert it to percentage
                } else {
                  return value
                }
              },
            },
          }],
        }
      }
    }
  },
  methods: {
    _get() {
      this.timeline.loading = null
      this.loading = true
      axios.get(`/api/circos/${this.$route.params.circoId}?relations=elections.circoresultatsgroupes.parti`)
      .then(response => this.timeline.data = response.data.data)
      .catch(error => this.timeline.errors.push(error))
      .finally(() => {
        this.timeline.loading= false
        this.fillData()
      })
    },
    fillData () {
      let partis_flat = this.timeline.data.elections.map(e => {
        return e.circoresultatsgroupes.map(r => {
          return r.parti
        })
      }).flat()

      this.datacollection = {
        datasets: [... new Set(
          partis_flat.map(p => {return p.id})
        )].map((id) => {
          return {
            id: id,
            label: partis_flat.find(p => p.id === id).nom_usuel,
            borderColor: `#${partis_flat.find(p => p.id === id).couleur}`,
            backgroundColor: 'transparent',
            data: this.timeline.data.elections.map(e => {
              let thisArg = {
                date: e.date,
                pourcentage: this.pourcentage
              }
              //le map après le parti n'est pas dans une fonction fléchée
              //parce qu'on a besoin que la valeur de this soit locale et non globale
              return e.circoresultatsgroupes.filter(c => c.parti.id === id).map(function (r) {
                return {
                  x: new Date(this.date),
                  y: this.pourcentage === 0 ? r.bv : r.bv / r.participation.bv
                }
              }, thisArg)
            }).flat()
          }
        })
      }
    },
    toggleLegend() {
      console.log(this.options.legend.display)
      this.options.legend.display = !this.options.legend.display
    },
  },
}
</script>
