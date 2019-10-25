<template>
  <v-form class="form-etiquette">
    <v-layout row wrap justify-space-around>
      <v-flex xs12 md6 px-3>
        <v-select
          :items="collection.data"
          :loading="collection.loading"
          item-value="id"
          item-text="description"
          :disabled="disabled"
          v-model="id ? index.data.parent_id : create.parent_id"
          label="Parent"
        >
        </v-select>
      </v-flex>

      <v-flex xs12 md6 px-3>
        <v-text-field
          label="Description"
          :disabled="disabled"
          v-model="id ? index.data.description : create.description"
        ></v-text-field>
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
        description: '',
        parent_id: 0
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
      axios.post('/api/tags', {
        description: this.create.description,
        parent_id: this.create.parent_id
      })
      .then(response => this.output = response)
      .catch(error => this.output = error)
      .finally(() => this.clear())
    },
    get() {
      this.collection.error = this.collection.data = null
      this.collection.loading = true
      axios.get(`api/tags`)
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
      axios.get(`api/tags/${this.id}`)
      .then(response => this.index.data = response.data.data)
      .catch(error => this.index.error = error )
      .finally(() => this.index.loading = false)
    },
    clear() {
      this.create.description = ''
      this.create.parent_id = 0
    }
  },
}
</script>
