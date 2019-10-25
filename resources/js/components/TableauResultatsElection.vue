<template>
  <div class="tableau-resultats-election">

    <template v-if="election.data">
      <v-data-table
        class="body-1"
        :headers='headers'
        :items="election.data.resultats"
        :loading="election.loading"
        :rows-per-page-items='[{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
        disable-initial-sort
        hide-actions
      >
        <template v-slot:items="props">
          <td
            :style="`border-left: 24px solid #${props.item.couleur}; padding: 0 0 0 24px;`"
          >
            {{ props.item.nom }} ({{ props.item.abb}})
          </td>
          <td class="text-xs-right">{{ spaceForThousands(props.item.bv) }}</td>
          <td class="text-xs-right">{{ formatPercent(props.item.pc_bv) }}</td>
          <td class="text-xs-right">{{ props.item.nb_candidats }}</td>
          <td class="text-xs-right">{{ props.item.nb_deputes }}</td>
        </template>
      </v-data-table>
      <v-sheet elevation="1" style="margin: 15px 0 -15px;">
        <p class="text-xs-center caption">
          Nombre total de bulletins valides : {{ spaceForThousands(participation.bv) }} ({{ formatPercent(participation.pc_bv) }})<br>
          Nombre total de bulletins rejetés : {{ spaceForThousands(participation.br) }} ({{ formatPercent(participation.pc_br) }})<br>
          Vote exercé : {{ spaceForThousands(participation.ve) }}<br>
          Nombre total d'électeurs inscrits : {{ spaceForThousands(participation.ei) }}<br>
          Taux de participation : {{ formatPercent(participation.pc_participation) }}
        </p>
      </v-sheet>
    </template>

  </div>
</template>

<script>
export default {
  props: {
    electionId: Number
  },
  data () {
    return {
      election: {
        data: {
          resultats: [],
          participation: {
            bv: 0,
            br: 0,
            ei: 0
          }
        },
        loading: false,
        error: null
      },
      headers: [
        {text: "Parti", value: "parti.nom_usuel", align: "left"},
        {text: "Nombre de votes", value: "bv", align: "right"},
        {text: "Pourcentage", value: "pc_bv", align: "right"},
        {text: "Candidat·e·s", value: "personne.nom", align: "left"},
        {text: "Député·e·s", value: "personne.nom", align: "left"}
      ]
    }
  },
  created () {
    this.show()
  },
  watch: {
    '$route':'show',
  },
  computed: {
    election_id() {
      if (this.electionId) {
        return this.electionId
      } else if (this.$route.params.electionId) {
        return this.$route.params.electionId
      } else {
        return null
      }
    },
    participation() {
      let participations = this.election.data.participation
      return {
        bv: participations.bv,
        br: participations.br,
        ve: participations.bv + participations.br,
        pc_bv: participations.bv / (participations.bv + participations.br),
        pc_br: participations.br / (participations.bv + participations.br),
        ei: participations.ei,
        pc_participation: (participations.bv + participations.br) / participations.ei
      }
    }
  },
  methods: {
    show() {
      this.election.error = null
      this.election.loading = true
      if (this.election_id) {
        axios.get(`api/elections/${this.election_id}/resultats/partis`)
        .then(response => {
          for (var p of response.data.resultats) {
            this.election.data.resultats.push(p)
          }
          this.election.data.participation.bv = response.data.participation[0].bv
          this.election.data.participation.br = response.data.participation[0].br
          this.election.data.participation.ei = response.data.participation[0].ei
        })
        .catch(error => this.election.error = error )
        .finally(() => {this.election.loading = false})
      } else {
        this.election.error = 'Aucune election choisie'
        this.election.loading = false
      }
    },
    spaceForThousands(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    },
    formatPercent(n) {
      return +(Math.round(100* n + "e+2")  + "e-2").toString().replace(". ", ",")+" %";
    }
  },
}
</script>
