<template>
  <v-container class="circonscription-detail" fill-height>
    <v-layout row wrap align-content-start justify-space-around>

      <v-flex xs12 px-3>
        <v-card>
          <v-card-title class="pb-1">
            <h4>
              <template v-if="$route.params.circonscriptionId">
                <span v-if="!circonscription.data" class="font-weight-bold">Circonscription</span>
                <span v-if="circonscription.data" class="font-weight-bold">{{ circonscription.data.nom }}</span>
              </template>
              <template v-if="$route.params.partiId">
                <span v-if="!parti.data" class="font-weight-bold">Parti</span>
                <span v-if="parti.data" class="font-weight-bold">{{ parti.data.nom_usuel }}</span>
              </template>
              <span>  |  </span>
              <span v-if="!election.data">Élection</span>
              <span v-if="election.data">{{ election.data.nom }}</span>
            </h4>
          </v-card-title>

          <v-card-text class="pt-1">
            <v-tabs :value="tabRoutes.active">
              <v-tab @click="navigate(tabRoutes.section)">
                Sections de vote
              </v-tab>

              <!--<v-tab @click="navigate(tabRoutes.municipalite)">
                Municipalités
              </v-tab>-->

              <v-tab @click="navigate(tabRoutes.circonscription)">
                Circonscription{{ $route.params.partiId ? 's' : '' }}
              </v-tab>
            </v-tabs>
            <router-view />
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>

  export default {
    data () {
      return {
        pourcentage: true,
        parti: {
          data: null,
          loading: null,
          error: null
        },
        circonscription: {
          data: null,
          loading: null,
          error: null
        },
        election: {
          data: null,
          loading: null,
          error: null
        }
      }
    },
    created () {
      this._global_get()
    },
    watch: {
      '$route.params.circonscriptionId':'_get_circonscription',
      '$route.params.partiId':'_get_parti',
      '$route.params.electionId':'_get_election'
    },
    computed: {
      tabRoutes() {
        let _this = this
        function active() {
          switch (_this.$route.name) {
            case 'sections_tableau':
            case 'parti_sections_tableau':
              return 0
              break
            case 'municipalites_tableau':
              return 1
            case 'circonscriptions_tableau':
            case 'parti_circonscriptions_tableau':
            case 'parti_circonscriptions_graph':
            case 'parti_circonscriptions_carte':
              return 2
              break
          }
        }
        if(this.$route.params.circonscriptionId) {
          return {
            active: active(),
            section: 'sections_tableau',
            municipalite: 'municipalites_tableau',
            circonscription: 'circonscriptions_tableau'
          }
        } else if (this.$route.params.partiId) {
          return {
            active: active(),
            section: 'parti_sections_tableau',
            municipalite: 'partis',
            circonscription: 'parti_circonscriptions_tableau'
          }
        }
      }

    },
    methods: {
      _global_get() {
        if (this.$route.params.circonscriptionId) {
          this._get_circonscription()
          this._get_election()
        } else if (this.$route.params.partiId) {
          this._get_parti()
          this._get_election()
        }
      },
      _get_circonscription() {
        this.circonscription.error = this.circonscription.data = null
        this.circonscription.loading = true
        axios.get(`http://localhost:8000/api/circonscriptions/${this.$route.params.circonscriptionId}`)
        .then(response => this.circonscription.data = response.data.data)
        .catch(e => console.log(e))
        .finally(() => this.circonscription.loading = false)
      },
      _get_parti() {
        this.parti.error = this.parti.data = null
        this.parti.loading = true
        axios.get(`http://localhost:8000/api/partis/${this.$route.params.partiId}`)
        .then(response => this.parti.data = response.data)
        .catch(error => this.parti.error = error)
        .finally(() => this.parti.loading = false)
      },
      _get_election() {
        this.election.error = this.election.data = null
        this.election.loading = true
        axios.get(`http://localhost:8000/api/elections/${this.$route.params.electionId}`)
        .then(response => this.election.data = response.data)
        .catch(e => console.log(e))
        .finally(() => this.election.loading = false)
      },
      navigate(name) {
        this.$router.push({name: name, params: {circonscriptionId: this.$route.params.circonscriptionId, electionId: this.$route.params.electionId, circoId: this.$route.params.circoId}})
      },
      setVue() {
        switch(this.$route.name) {
          case 'sections_toolbar':
          case 'sections_tableau':
          case 'sections_graph':
          case 'sections_carte':
            this.vue = 0
            break

          case 'municipalites_toolbar':
          case 'municipalites_tableau':
          case 'municipalites_graph':
            this.vue = 1
            break

          case 'circonscriptions_tableau':
            this.vue = 2
            break
        }
      }
    },
  }
</script>

<style scoped>
  .v-card {
    margin-bottom: 20px;
  }
</style>
