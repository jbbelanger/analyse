<template>
  <div class="form-circo">
    <v-layout row wrap align-content-center justify-space-around>
      <v-flex xs12>

        <template v-if="shown.data && circoId">
            <v-form>
              <v-layout row wrap align-content-center justify-space-around>
                <v-flex xs10>
                  <v-text-field
                    label="Nom de la circonscription"
                    v-model="shown.data.nom"
                  />
                  <v-text-field
                    label="Déterminant"
                    v-model="shown.data.determinant"
                  />
                  <v-select
                    :items="regions"
                    item-value="id"
                    item-text="nom"
                    label="Associer à une région"
                    v-model="shown.data.region_id"
                  >
                  </v-select>
                </v-flex>
                <v-flex xs10>
                  <v-layout row wrap justify-end>
                    <v-btn class="secondary" outlined @click="deleteC">Supprimer</v-btn>
                    <v-btn class="primary" depressed @click="update">Mettre à jour</v-btn>
                  </v-layout>
                </v-flex>
              </v-layout>
            </v-form>
        </template>

        <template v-if="showCreate">
          <v-btn v-if="!created.show" block text @click="created.show = true">Créer une circonscription</v-btn>
            <v-form  v-if="created.show">
              <v-layout row wrap align-content-center justify-space-around>
                <v-flex xs10>
                  <v-text-field
                    label="Nom de la circonscription"
                    v-model="created.data.nom"
                  />
                  <v-text-field
                    label="Déterminant"
                    v-model="created.data.determinant"
                  />
                  <v-select
                    :items="regions"
                    item-value="id"
                    item-text="nom"
                    label="Associer à une région"
                    v-model="created.data.region_id"
                  >
                  </v-select>
                </v-flex>
                <v-flex xs10>
                  <v-layout row wrap justify-end>
                    <v-btn class="secondary" outlined @click="clearForm">Annuler</v-btn>
                    <v-btn class="primary" depressed @click="create">Créer</v-btn>
                  </v-layout>
                </v-flex>
              </v-layout>
            </v-form>
        </template>

      </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
  props: {
    showShown: Boolean,
    showCreate: Boolean,
    showDelete: Boolean,
    circoId: Number
  },
  data () {
    return {
      shown: {
        loading: false,
        error: null,
        data: null
      },
      created: {
        show: false,
        loading: false,
        error: null,
        data: {
          nom: '',
          determinant: '',
          region_id: null
        },
        response: null
      },
      deleted: {
        loading: false,
        error: null,
        data: null
      },
      regions: [
        {id: 1, nom: 'Bas-Saint-Laurent'},
        {id: 2, nom: 'Saguenay–Lac-Saint-Jean'},
        {id: 3, nom: 'Capitale-Nationale'},
        {id: 4, nom: 'Mauricie'},
        {id: 5, nom: 'Estrie'},
        {id: 6, nom: 'Montréal'},
        {id: 7, nom: 'Outaouais'},
        {id: 8, nom: 'Abitibi-Témiscamingue'},
        {id: 9, nom: 'Côte-Nord'},
        {id: 10, nom: 'Nord-du-Québec'},
        {id: 11, nom: 'Gaspésie–Îles-de-la-Madeleine'},
        {id: 12, nom: 'Chaudière-Appalaches'},
        {id: 13, nom: 'Laval'},
        {id: 14, nom: 'Lanaudière'},
        {id: 15, nom: 'Laurentides'},
        {id: 16, nom: 'Montérégie'},
        {id: 17,nom: 'Centre-du-Québec'},
      ]
    }
  },
  created () {
    this.show()
  },
  watch: {
    '$route':'show'
  },
  computed: {

  },
  methods: {
    show() {
      this.shown.error = this.shown.data = null
      this.shown.loading = true
      let that  = this
      if (this.circoId) {
        axios.get(`api/circos/${that.circoId}`)
        .then(response => that.shown.data = response.data)
        .catch(error => that.shown.error = error )
        .finally(() => that.shown.loading = false)
      }
    },

    create() {
      this.created.loading = true
      axios.post('/api/circos', {
        nom: this.created.data.nom,
        determinant: this.created.data.determinant,
        region_id: this.created.data.region_id
      })
      .then(response => this.output = response)
      .catch(e => console.log(e))
      .finally(
        this.show(),
        this.clearForm()
      )
    },

    update() {
      this.created.loading = true
      axios.put(`/api/circos/${this.circoId}`, {
        nom: this.shown.data.nom,
        determinant: this.shown.data.determinant,
        region_id: this.shown.data.region_id
      })
      .then(response => this.output = response)
      .catch(e => console.log(e))
      .finally(
        this.show(),
        this.clearForm()
      )
    },

    deleteC(circonscriptionId) {
      this.deleted.loading = true
      axios.delete(`api/circos/${this.circoId}`)
      .then(response => this.deleted.data = response)
      .catch(e => console.log(e))
      .finally(this.show())
      this.deleted.loading = false
    },

    clearForm() {
      this.created.data.nom = null
      this.created.data.determinant = null
      this.created.data.region_id = null
      this.created.show = false
    }
  },
}
</script>
