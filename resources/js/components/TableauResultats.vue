<template>
  <v-layout class="results-table px-2" row>
    <v-layout column>
      <v-data-table
        class="body-1"
        :headers='resultatsTableHeaders'
        :items="resultats.data ? sortedResults : []"
        :loading="resultats.loading"
      >
        <template v-slot:item.parti.nom_usuel="{ item }">
          <v-tooltip dark bottom>
            <template v-slot:activator="{ on }">
              <v-avatar dark :light="false" v-on="on" :color="`#${item.parti.couleur}`">{{ item.parti.abb_usuelle }}</v-avatar>
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

        <template v-slot:item:majorite="{ item }">
          {{ item.majorite | numeralFormat }}
        </template>
      </v-data-table>

      <v-sheet elevation="1" style="margin: 15px 0 -15px;">
        <p class="text-center caption">
          Nombre total de bulletins valides : {{ participationData.bv | numeralFormat }} ({{ participationData.pc_bv | numeralFormat('0.00 %') }})<br>
          Nombre total de bulletins rejetés : {{ participationData.br | numeralFormat }} ({{ participationData.pc_br | numeralFormat('0.00 %') }})<br>
          Vote exercé : {{ participationData.ve | numeralFormat }}<br>
          Nombre total d'électeurs inscrits : {{ participationData.ei | numeralFormat }}<br>
          Taux de participation : {{ participationData.pc_participation | numeralFormat('0.00 %') }}
        </p>
      </v-sheet>
    </v-layout>

    <v-menu v-if="resultats.data[0].sectionresultats">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" icon><v-icon>mdi-dots-vertical</v-icon></v-btn>
      </template>
      <v-list>
        <v-list-item-group>
          <v-list-item :to="{name: 'sections_tableau', params: {circonscriptionId: circonscriptionId, electionId:electionId}}">
            <v-list-item-avatar>
              <v-icon>mdi-table</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>Tableau des résultats par section de vote</v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name: 'sections_carte', params: {circonscriptionId: circonscriptionId, electionId:electionId}}">
            <v-list-item-avatar>
              <v-icon>mdi-map</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>Carte des résultats par section de vote</v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-menu>

  </v-layout>
</template>

<script>
  export default {
    props: {
      useProps: Boolean,
      electionId: Number,
      circonscriptionId: Number
    },
    data () {
      return {
        resultats: {
          data: null,
          loading: true,
          error: null
        },
        resultatsTableHeaders: [
          {text: "Parti", value: "parti.nom_usuel", align: "left"},
          {text: "Candidat·e", value: "personne.nom", align: "left"},
          {text: "Nombre de votes", value: "bv", align: "right"},
          {text: "Pourcentage", value: "pc_bv", align: "right"},
          {text: "Majorité", value: "majorite", align: "right"}
        ]
      }
    },
    created () {
      this._get()
    },
    watch: {
      '$route':'_get',
    },
    computed: {
      sortedResults() {
        let majorite = this.resultats.data.filter(r => r.rang === 1)[0].bv - this.resultats.data.filter(r => r.rang === 2)[0].bv
        let rawData = this.resultats.data
        var formattedData = []
        for (var resultat of rawData) {
          formattedData.push({
            bv:	resultat.bv,
            pc_bv: resultat.participation ? resultat.bv / resultat.participation.bv : 0,
            majorite: resultat.rang === 1 ? majorite : "",
            rang:	resultat.rang,
            parti: resultat.parti,
            personne: resultat.personne
          })
        }
        return formattedData
      },
      participationData() {
        if (this.resultats.data) {
          if (this.resultats.data[0].participation) {
            let rawData = this.resultats.data[0].participation
            return {
              'id': rawData.id,
              'bv':	rawData.bv,
              'br':	rawData.br,
              've': rawData.bv + rawData.br,
              'ei':	rawData.ei,
              'pc_bv': rawData.bv / (rawData.bv + rawData.br),
              'pc_br': rawData.br / (rawData.bv + rawData.br),
              'pc_participation': (rawData.bv + rawData.br) / rawData.ei
            }
          }
        } else {
          return {
            'id': 0,
            'bv':	0,
            'br':	0,
            've': 0,
            'ei':	0,
            'pc_bv': 0,
            'pc_br': 0,
            'pc_participation': 0
          }
        }
      }
    },
    methods: {
      _get() {
        this.resultats.error = this.resultats.data = null
        this.resultats.loading = true
        var circonscription_id = null
        var election_id = null

        if (this.circonscriptionId && this.electionId) {
          circonscription_id = this.circonscriptionId
          election_id = this.electionId
        } else if (this.$route.params.circonscriptionId && this.$route.params.electionId) {
          circonscription_id = this.$route.params.circonscriptionId
          election_id = this.$route.params.electionId
        }

        if (circonscription_id === null || election_id === null) {
          if (circonscription_id === null && election_id === null) {
            this.resultats.error = 'Les paramètres d\'élection et de circonscription sont manquants'
            this.resultats.loading = false
          } else if (circonscription_id) {
            this.resultats.error = 'Le paramètre d\'élection est manquant'
            this.resultats.loading = false
          } else if (election_id) {
            this.resultats.error = 'Le paramètre de circonscription est manquant'
            this.resultats.loading = false
          }
        } else {
          axios.get(`api/circonscriptions/${circonscription_id}?relations=circoresultats.parti,circoresultats.personne,circoresultats.circoparticipation&election=${election_id}`)
          .then(response => this.resultats.data = response.data.data.circoresultats)
          .catch(error => this.resultats.error = error )
          .finally(() => this.resultats.loading = false)
        }

      },
    },
  }
</script>
