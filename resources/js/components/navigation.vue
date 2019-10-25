<template>
  <div>
    <v-list shaped>
      <v-list-item-group>

        <v-list-item
          @click="changeView('historique', 0)"
        >
          <v-list-item-avatar>
            <v-icon>mdi-history</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>
              Historique
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item
          @click="changeView('sections_tableau', 1)"
        >
          <v-list-item-avatar>
            <v-icon>mdi-map</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>
              Cartographier
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>

      </v-list-item-group>
    </v-list>

    <v-text-field
      placeholder="Chercher une cironscription"
      prepend-inner-icon="mdi-magnify"
      v-model="searchString"
    />

    <v-list dense shaped>
      <v-subheader>CIRCONSCRIPTIONS</v-subheader>
      <v-list-item-group>
        <v-list-item
          v-for="(c,i) in filteredCircos"
          :key="c.id"
          @click="chooseCirco(c,i)"
        >
          <v-list-item-avatar>
            <v-icon>mdi-map-marker</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>
              {{ c.nom }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </div>
</template>

<script>
export default {
  data () {
    return {
      circos: {
        data: null,
        loading: true,
        error: null
      },
      searchString: ''
    }
  },
  computed: {
    filteredCircos() {
      let filter = new RegExp(this.searchString, 'i')
      if (this.circos.data) {
        return this.circos.data.filter(
          circo => circo.nom.match(filter)
        ).sort((a, b) => a.nom.localeCompare(b.nom))
      } else {
        return []
      }
    },
    selectedCircoIndex() {
      return this.$store.state.index
    },
    selectedCirco() {
      return this.$store.state.circo
    },
    selectedViewIndex() {
      return this.$store.state.view.index
    },
    selectedView() {
      return this.$store.state.view.name
    }
  },
  created () {
    this.getCirconscriptions()
  },
  methods: {
    getCirconscriptions() {
      this.circos.error = this.circos.data = null
      this.circos.loading = true
      axios.get(`api/circos?carte=4&per_page=140&relations=circonscriptions`)
      .then(response => this.circos.data = response.data.data)
      .catch(error => this.circos.error = error )
      .finally(() => this.circos.loading = false)
    },
    chooseCirco(c) {
      this.$store.commit('chooseCirco', c)
      this.$router.push({
        name: this.selectedView,
        params: {
          circonscriptionId: c.circonscriptions[0].id,
          circoId: c.id,
          electionId: 42
        }
      })
    },
    changeView(v, i) {
      let c = this.selectedCirco
      this.$store.commit('chooseView', v, i)
      this.$router.push({
        name: v,
        params: {
          circonscriptionId: c.circonscriptions[0].id,
          circoId: c.id,
          electionId: 42
        }
      })
    }
  }
}
</script>
