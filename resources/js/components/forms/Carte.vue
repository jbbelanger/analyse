<template>
  <v-form class="form-carte">
    <v-layout row wrap justify-space-around>
      <v-flex xs12 px-3>
        <v-text-field
          :disabled="disabled"
          label="Nom"
          hint="Circonscriptions électorales de 1992"
          v-model="id ? index.data.nom : create.nom"
        />
      </v-flex>

      <v-flex xs12 md6 px-3>
        <v-date-picker
          :disabled="disabled"
          locale="fr-ca"
          landscape
          label="Date d'adoption"
          v-model="id ? index.data.adoption : create.adoption"
        />
      </v-flex>
    </v-layout>

    <v-layout row wrap justify-end v-if="!id">
      <v-btn
        outlined
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
        nom: '',
        adoption: null
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
      axios.post(`/api/cartes`,{
        nom: this.created.nom,
        adoption: this.created.adoption,
        annee: new Date(this.created.adoption).getFullYear()
      })
      .then(response => this.output = response)
      .catch(error => this.output = error)
      .finally(() => this.clear())
    },
    get() {
      this.collection.error = this.collection.data = null
      this.collection.loading = true
      axios.get(`api/cartes`)
      .then(response => this.collection.data = response.data.data)
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
      .then(response => this.index.data = response.data.data)
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
