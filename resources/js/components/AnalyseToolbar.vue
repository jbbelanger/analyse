<template>
  <v-toolbar class="analyse-toolbar my-1" flat dense>

    <v-btn-toggle
      mandatory
      :value="activeView"
      class="transparent"
    >
      <v-btn
        text
        :disabled="!viewRoutes.tableau"
        @click="navigate(viewRoutes.tableau)"
      >
        <v-icon>mdi-table</v-icon>
      </v-btn>
      <!--<v-btn
        text
        :disabled="!viewRoutes.graph"
        @click="navigate(viewRoutes.graph)"
      >
        <v-icon>mdi-chart-bar</v-icon>
      </v-btn>-->
      <v-btn
        text
        :disabled="!viewRoutes.carte"
        @click="navigate(viewRoutes.carte)"
      >
        <v-icon>mdi-map</v-icon>
      </v-btn>
    </v-btn-toggle>

    <template v-if="widgets.numberType">
      <v-divider class="mx-2 mt-0" vertical></v-divider>

      <v-btn-toggle
        mandatory
        :value="pourcentage"
        class="transparent"
      >
        <v-btn
          text
          @click="$emit('update:pourcentage',0)"
        >
          <span class="font-weight-bold"> # </span>
        </v-btn>
        <v-btn
          text
          @click="$emit('update:pourcentage',1)"
        >
          <span class="font-weight-bold"> % </span>
        </v-btn>
      </v-btn-toggle>
    </template>

    <template v-if="widgets.mapType">
      <v-divider
        class="mx-2 mt-0"
        vertical
      />

      <v-btn-toggle
        mandatory
        :value="gagnant"
        class="transparent"
      >
        <v-btn
          text
          @click="$emit('update:gagnant',0)"
        >
          <span class="font-weight-bold"> Gagnant </span>
        </v-btn>
        <v-btn
          text
          @click="$emit('update:gagnant',1)"
        >
          <span class="font-weight-bold">{{ pourcentage === 1 ? ' %' : '' }} Vote {{ displayPartiName }} </span>
        </v-btn>
      </v-btn-toggle>
    </template>

    <template v-if="widgets.partySelect">
      <v-divider
        class="ml-2 mt-0"
        vertical
      />

      <v-overflow-btn
        :items="partis"
        :value="displayParti"
        item-value="id"
        item-text="nom_usuel"
        label="Choisir un parti"
        hide-details
        class="pa-0"
        @change="change"
      ></v-overflow-btn>
    </template>

    <template v-if="widgets.colorScale">
      <v-divider
        class="mr-2 mt-0"
        vertical
      />

      <div>
        <span class="font-weight-bold">{{ pourcentage === 0 ? scaleValues[0].valeur : formatPercent(scaleValues[0].valeur) }}</span>
        <v-avatar :size="25" :color="scaleValues[0].couleur" />
        <v-avatar :size="25" :color="scaleValues[1].couleur" />
        <v-avatar :size="25" :color="scaleValues[2].couleur" />
        <span class="font-weight-bold">{{ pourcentage === 0 ? scaleValues[2].valeur : formatPercent(scaleValues[2].valeur) }}</span>
      </div>
    </template>

  </v-toolbar>
</template>

<script>
export default {
  props: {
    pourcentage: Number,
    gagnant: Number,
    partis: Array,
    displayParti: Number,
    displayPartiName: String,
    scaleValues: Array,
    opacity: Number,
    viewRoutes: Object,
    activeView: Number,
    widgets: Object
  },
  data () {
    return {

    }
  },
  created () {

  },
  computed: {

  },
  methods: {
    navigate(name) {
      this.$router.push({
        name: name,
        params: {
          circonscriptionId: this.$route.params.circonscriptionId,
          electionId: this.$route.params.electionId,
          circoId: this.$route.params.circoId
        }
      })
    },
    formatPercent(n) {
      return +(Math.round(100* n + "e+2")  + "e-2").toString().replace(". ", ",")+" %";
    },
    change(parti) {
      this.$emit('update:displayParti',parti)
    }
  }
}
</script>
