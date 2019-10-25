<template>
  <div class="circonscription">
    <v-container fill-height>
      <v-layout>
        <v-row>
          <v-col xs12>
            <v-card class="mt-4 mx-auto">
              <v-sheet
                class="v-sheet--offset mx-auto pa-3"
                elevation="12"
                max-width="calc(100% - 64px)"
              >
                <graph-historique />
              </v-sheet>
              <v-card-text>
                <v-progress-linear v-if="circo.loading" indeterminate />
                <v-tabs vertical>
                  <v-tab v-for="(e, i) in elections" :key="i"><span :class="e.type === 'P' ? 'font-italic' : 'font-weight-bold' ">{{ e.date | year }}</span></v-tab>
                  <v-tab-item v-for="(e, i) in elections" :key="i">
                    <tableau-resultats v-for="(c, ii) in e.circonscriptions" :key="ii" :electionId="e.id" :circonscriptionId="c.id" />
                  </v-tab-item>
                </v-tabs>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
  import GraphHistorique from '../GraphHistoriqueCirco.vue'
  export default {
    components: {
      GraphHistorique
    },
    data () {
      return {
        circo: {
          data: null,
          loading: false,
          errors: []
        },
      }
    },
    created () {
      this._get_elections_circonscriptions()
    },
    watch: {
      '$route': '_get_elections_circonscriptions'
    },
    computed: {
      elections() {
        if (this.circo.data) {
          return this.circo.data.elections.sort((a, b) => b.date.localeCompare(a.date))
        } else {
          return []
        }
      },
    },
    filters: {
      year(d) {
        return new Date(d).getFullYear()
      }
    },
    methods: {
      _get_elections_circonscriptions() {
        this.circo.data = null
        this.circo.loading = true
        axios.get(`/api/circos/${this.$route.params.circoId}?relations=elections.circonscriptions`)
        .then(response => this.circo.data = response.data.data)
        .catch(error => this.circo.errors.push(error))
        .finally(() => this.circo.loading = false)
      }
    },
  }
</script>

<style>
  .v-sheet--offset {
    top: -24px;
    position: relative;
  }
</style>
