<template>
  <div class="tableau-resultats-circonscriptions">
    <analyse-toolbar
      :pourcentage.sync="pourcentage"
      :viewRoutes="viewRoutes"
      :activeView="0"
      :widgets="widgets"
    />

    <v-data-table
      class="body-1"
      :loading="loading"
      :headers='headers'
      :items="formattedResults"
      disable-initial-sort
      :rows-per-page-items='[10,20,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
      rows-per-page-text="Lignes par page">

      <template
        v-if="resultats"
        v-slot:items="props"
      >
        <td
          class="text-xs-right"
          :style="`border-left: 24px solid #${props.item.gagnant.couleur}; padding: 0 12px;`"
        >
          <router-link :to="{name: 'circonscriptions_tableau', params: {circonscriptionId: props.item.circonscription.id, electionId: $route.params.electionId}}">
            {{ props.item.circonscription.nom }}
          </router-link>
        </td>
        <td>
          <router-link :to="{name: 'personne', params: {personneId: props.item.personne.id}}">
            {{ props.item.personne.prenom }} <span class="font-weight-bold">{{ props.item.personne.nom }}</span>
          </router-link>
        </td>
        <td class="text-xs-right">
          {{ props.item.bv }}
        </td>
        <td class="text-xs-right">
          {{ formatPercent(props.item.pc_bv)}}
        </td>
        <td class="text-xs-right">
          {{ props.item.d_bv }}
        </td>
        <td class="text-xs-right">
          {{ formatPercent(props.item.d_pc_bv)}}
        </td>
      </template>
    </v-data-table>

    <v-pagination
      v-if="pagination.total > 1"
      v-model="pagination.current"
      :length="pagination.total"
      @input="show"
    ></v-pagination>
  </div>
</template>

<script>

  export default {
    props: {
      electionId: Number,
      circonscriptionId: Number
    },
    data () {
      return {
        pourcentage: 1,
        searchString: '',
        pagination: {
          current: 1,
          total: 0
        },
        loading: false,
        error: null,
        resultats: null,
        bvo: null,
        viewRoutes: {
          tableau: 'sections_tableau',
          graph: 'parti_circonscriptions_graph',
          carte: 'parti_circonscriptions_carte',
        },
        widgets: {
          numberType: false,
          mapType: false,
          partySelect: false,
          colorScale: false
        }
      }
    },
    created () {
      this._get_irconscription()
    },
    watch: {
      '$route':'_get_irconscription'
    },
    computed: {
      headers() {
        var headers = [
          {text: "Circonscription", value: "circonscription.nom", align: "left"},
          {text: "Personne", value: "personne.nom", align: "left"},
          {text: "Nombre", value: "bv", align: "right"},
          {text: "Pourcentage", value: "pc_bv", align: "right"},
          {text: "Majorité / Différence au gagnant", value: "d_bv", align: "right"},
          {text: "Majorité / Différence au gagnant %", value: "d_pc_bv", align: "right"},
        ]
        return headers
      },
      formattedResults() {
        var formatted_results = []

        if (this.resultats) {
          let resultats = this.resultats.data
          for (var r of resultats) {
            var resultat = {
              'id':	r.id,
              'bv':	r.bv,
              'pc_bv': r.bv / r.participation.bv,
              'd_bv':	r.bv - r.circonscription.resultats[0].bv === 0 ? r.bv - r.circonscription.resultats[1].bv : r.bv - r.circonscription.resultats[0].bv,
              'd_pc_bv': r.bv - r.circonscription.resultats[0].bv === 0 ? ( r.bv - r.circonscription.resultats[1].bv ) / r.participation.bv : ( r.bv - r.circonscription.resultats[0].bv ) / r.participation.bv,
              'personne':	r.personne,
              'circonscription': r.circonscription,
              'gagnant': r.circonscription.resultats[0].parti
            }

            formatted_results.push(resultat)
          }
        }

        return formatted_results
      }
    },
    methods: {
      _get_irconscription() {
        this.error = this.resultats = null
        this.loading = true
        axios.get(`api/partis/${this.$route.params.partiId}/elections/${this.$route.params.electionId}/resultats/circonscriptions?page=${this.pagination.current}`)
        .then(response => {
          this.resultats = response.data
          this.pagination.current = response.data.current_page
          this.pagination.total = response.data.last_page
        })
        .catch(e => console.log(e))
        .finally(() => this.loading = false)
      },
      spaceForThousands(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
      },
      formatPercent(n) {
        return +(Math.round(100* n + "e+2")  + "e-2").toString().replace(". ", ",")+" %";
      }
    },
  }
</script>
