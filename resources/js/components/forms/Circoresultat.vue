<template>
  <v-form class="form-circoresultat">
    <v-layout row wrap justify-space-around>
      <v-flex xs12 px-3>
        <v-autocomplete
          :items="regions"
          item-value="id"
          item-text="nom"
          label="Associer à une région"
          v-model="shown.data.region_id"
        >
      </v-flex>

      <v-flex xs12 md6 px-3>
        <v-text-field
          :disabled="disabled"
          type="number"
          label="Bulletins valides"
          hint="42"
          v-model="id ? index.data.nom : create.nom"
        />
      </v-flex>
    </v-layout>

    <v-layout row wrap justify-end v-if="!id">
      <v-btn
        outline
        :disabled="disabled"
        @click="clear"
      >
        Effacer
      </v-btn>
      <v-btn
        class="primary"
        :disabled="disabled"
        @click="post"
      >
        Créer
      </v-btn>
    </v-layout>
  </v-form>
</template>

<script>
export default {
  props: {
    disabled: Boolean,
    id: Number
  },
  data () {
    return {
      collection: {
        data: null,
        loading: false,
        error: null
      },
      index: {
        data: [],
        loading: false,
        error: null
      },
      create: {
        election_id: 0
        personne_id: 0
        parti_id: 0
        circonscription_id: 0
        participation_id: 0
        bv: 0
        rang: 0
      },
      output: null
    }
  },
  created () {
    this.get()
  },
  watch: {
    'id':'find'
  },
  computed: {

  },
  methods: {
    post() {
      axios.post(`/api/circoresultats`,{
        election_id: this.create.election_id
        personne_id: this.create.personne_id
        parti_id: this.create.parti_id
        circonscription_id: this.create.circonscription_id
        participation_id: this.create.participation_id
        bv: this.create.bv
        rang: this.create.rang
      })
      .then(response => this.output = response)
      .catch(error => this.output = error)
      .finally(() => this.clear())
    },
    get() {
      this.collection.error = this.collection.data = null
      this.collection.loading = true
      axios.get(`api/cartes`)
      .then(response => this.collection.data = response.data)
      .catch(error => this.collection.error = error )
      .finally(() => {
        this.collection.loading = false
        if (this.id) {
          this.find()
        }
      })
    },
    find() {
      this.index.error = null
      this.index.loading = true
      axios.get(`api/cartes/${this.id}`)
      .then(response => this.index.data = response.data)
      .catch(error => this.index.error = error )
      .finally(() => this.index.loading = false)
    },
    clear() {
      this.created.nom = '',
      this.created.adoption = null
    },
  },
}
</script>
