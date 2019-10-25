<template>
  <router-view />
</template>

<script>
export default {
  created() {
    this.setViewName()
  },
  watch: {
    '$route': 'setViewName'
  },
  methods: {
    setViewName() {
      axios.get(`/api/circos/${this.$route.params.circoId}`)
      .then(response => document.title = `${response.data.data.nom} - UQÀM Analytica`)
    }
  }
}
</script>
