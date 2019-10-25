<template>
  <v-form>
    <v-layout row wrap align-content-center justify-start>
      <v-flex xs12 sm12 px-3>
        <v-text-field
          label="Nom"
          hint="Circonscriptions électorales de 1992"
          type="number"
          v-model="find"
          :loading="loading"
          @input="get()"
        />
      </v-flex>
      <v-flex xs12 sm12 px-3>

      </v-flex>
    </v-layout>
  </v-form>
</template>

<script>
export default {
  props: {
    model: String,
    find: String
  },
  data () {
    return {
      id: null,
      data: null,
      loading: false,
      error: null,
    }
  },
  created () {
    this.id = this.find
  },
  watch: {

  },
  computed: {

  },
  methods: {
    get() {
      this.error = this.data = null
      this.loading = true
      axios.get(`/api/${this.model}/${this.find}`)
      .then(response => {
        this.data = response.data
        this.$emit(response.data)
      })
      .finally(() => this.loading = false)
    }
  },
}
</script>
