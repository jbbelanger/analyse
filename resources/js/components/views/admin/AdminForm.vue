<template>
  <div class="admin-etiquettes">
      <v-card :loading="index.loading">
        <v-card-text>

          <v-tabs v-if="model" v-model="active" icons-and-text show-arrows>

            <template v-for="(action, index) in actions">

              <v-tab>{{ action.nom }}</v-tab>

              <v-tab-item>
                <!--Créer-->
                <v-card-text v-if="index === 0">
                  <h5>{{ `${action.nom} ${model.determinants[1]} ${model.nom}` }}</h5>
                  <template v-if="model">
                    <form-carte :disabled="action.disabled" v-if="model.model==='cartes'" />
                    <form-etiquette :disabled="action.disabled" v-if="model.model==='tags'" />
                  </template>
                </v-card-text>

                <!--Trouver-->
                <v-card-text v-if="index === 1">
                  <h5>{{ `${action.active} ${model.determinants[1]} ${model.nom}` }}</h5>
                  <v-autocomplete
                    v-model="select"
                    :items="tags"
                    item-value="id"
                    item-text="description"
                    :loading="index.loading"
                    :disabled="action.disabled"
                  />

                  <template v-if="select && model">
                    <form-carte :disabled="action.actions[0].disabled" :id="select" v-if="model.model==='cartes'" />
                    <form-etiquette :disabled="action.actions[0].disabled" :id="select" v-if="model.model==='tags'" />
                  </template>

                  <v-layout row wrap justify-end v-if="select">
                    <v-btn
                      v-if="action.actions[0].disabled"
                      class="primary"
                      :disabled="action.disabled"
                      @click="modifier"
                    >
                      Modifier
                    </v-btn>

                    <template v-if="!action.actions[0].disabled">
                      <v-btn
                        outlined
                        :disabled="action.disabled"
                        @click="supprimer"
                      >
                        Supprimer
                      </v-btn>
                      <v-btn
                        class="secondary"
                        text
                        :disabled="action.disabled"
                        @click="verrouiller"
                      >
                        Annuler
                      </v-btn>
                      <v-btn
                        class="primary"
                        :disabled="action.disabled"
                        @click="verrouiller"
                      >
                        Enregistrer
                      </v-btn>
                    </template>

                  </v-layout>
                </v-card-text>
              </v-tab-item>

            </template>

          </v-tabs>



      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import FormCarte from '../../forms/Carte.vue'
import FormEtiquette from '../../forms/Etiquette.vue'

export default {
  components: {
    FormCarte,
    FormEtiquette
  },
  props: {
    model: Object
  },
  data () {
    return {
      active: null,
      actions: [],
      index: {
        data: null,
        loading: false,
        error: null
      },
      select: null,
      supprime: null
    }
  },
  created () {
    //this.initialize()
  },
  watch: {
    'select':'verrouiller',
    'model': 'initialize'
  },
  computed: {
    tags() {
      let _this = this
      if (!this.index.data && this.index.loading) {
        return [
          {
            id: 0,
            description: 'En chargement'
          }
        ]
      } else if (this.index.data) {
        var tags = []
        for (var t of _this.index.data) {
          tags.push({
            id: t.id,
            description: t.nom ? t.nom : t.description,
            resultat: t.nom | t.description ? '' : t.id
          })
        }
        return tags
      } else {
        return [
          {
            id: 0,
            description: 'Ceci est weird'
          }
        ]
      }
    }
  },
  methods: {
    get() {
      this.index.error = this.index.data = null
      this.index.loading = true
      axios.get(`api/${this.model.model}`)
      .then(response => this.index.data = response.data.data)
      .catch(error => this.index.error = error )
      .finally(() => this.index.loading = false)
    },
    supprimer() {
      axios.delete(`/api/${this.model.model}/${this.select}`)
      .then(response => this.supprime = response)
      .catch(e => console.log(e))
      .finally()
    },
    modifier() {
      this.actions[1].actions[0].disabled = false
      this.actions[1].active = 'Modifier'
    },
    enregistrer() {
      axios.put(`/api/${this.model.model}/${this.select}`, this.thisTag.data)
      .then(response => this.output = response)
      .catch(e => console.log(e))
      .finally(
        this.fetchthisTagGET()
      )
    },
    verrouiller() {
      this.actions[1].actions[0].disabled = true
      this.actions[1].active = 'Trouver'
      this.get()
    },
    initialize() {
      this.select = null
      this.actions = this.model.actions
      this.get()
    }
  },
}
</script>
