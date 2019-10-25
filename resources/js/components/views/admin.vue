<template>
  <v-layout row wrap align-content-center justify-space-around px-3>
    <v-flex xs12 sm5 md4 px-3 py-2>
      <v-list dense rounded style="background-color: transparent">
        <v-list-item-group>
          <v-list-item v-for="(model,index) in models" :key="index" @click="changeView(index)">
            <v-list-item-content>
              {{ format(model.nom,true,true) }}
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-flex>
    <v-flex xs12 sm7 md8 px-3 py-2>
      <v-card>
        <admin-form :model="view" />
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import AdminForm from './admin/AdminForm.vue'
export default {
  components: {
    AdminForm
  },
  props: {
  },
  data () {
    return {
      active: null,
      models: [
        {nom: 'carte',
          model: 'cartes',
          determinants: ['la','une'],
          actions: [
            {nom: 'Créer', active: 'Créer', disabled: true},
            {
              active: 'Trouver',
              nom: 'Trouver',
              disabled: false,
              actions: [
                {
                  nom: 'Modifier',
                  disabled: true
                },
                {
                  nom: 'Supprimer',
                  disabled: true
                }
              ]
            }
          ]
        },
        {nom: 'circonscription', model: 'circonscriptions', determinants: ['la','une']},
        {nom: 'circo', model: 'circos', determinants: ['la','une']},
        {nom: 'comté', model: 'comtes', determinants: ['le','un']},
        {nom: 'élection', model: 'elections', determinants: ['la','une']},
        {nom: 'parti', model: 'partis', determinants: ['le','un']},
        {nom: 'personne', model: 'personnes', determinants: ['la','une']},
        {nom: 'région', model: 'regions', determinants: ['la','une']},
        {nom: 'étiquette',
          model: 'tags',
          determinants: ['la','une'],
          actions: [
            {nom: 'Créer', active: 'Créer', disabled: false},
            {
              active: 'Trouver',
              nom: 'Trouver',
              disabled: false,
              actions: [
                {
                  nom: 'Modifier',
                  disabled: true
                },
                {
                  nom: 'Supprimer',
                  disabled: false
                }
              ]
            }
          ]
        },
        {nom: 'circorésultat',
          model: 'circoresultats',
          determinants: ['le','un'],
          actions: [
            {nom: 'Créer', active: 'Créer', disabled: true},
            {
              active: 'Trouver',
              nom: 'Trouver',
              disabled: false,
              actions: [
                {
                  nom: 'Modifier',
                  disabled: true
                },
                {
                  nom: 'Supprimer',
                  disabled: false
                }
              ]
            }
          ]
        }
      ],
      view: null,
    }
  },
  created () {
    //this.show()
  },
  watch: {
    //'$route':'show'
  },
  computed: {

  },
  methods: {
    changeView(v) {
      //this.$router.push({name: `admin_${this.models[v].model}`})
      this.view = this.models[v]
    },
    format(s,c,p) {
      let original_string = s
      var returned_string = ''
      if (c) {
        returned_string = s.charAt(0).toUpperCase()+s.slice(1)
      }
      if (p) {
        returned_string = returned_string+'s'
      }
      return returned_string
    }
  },
}
</script>
