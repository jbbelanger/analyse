import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    circo: {
      id: 47,
      nom: 'Jean-Talon',
      determinant: 'de ',
      circonscriptions: [{
        id: 47,
        nom: 'Jean-Talon',
        determinant: 'de '}],
    },
    index: null,
    view: {
      index: 1,
      name: 'historique'
    }
  },
  mutations: {
    chooseCirco(state, circo, index) {
      state.circo.id = circo.id
      state.circo.determinant = circo.determinant
      state.circo.circonscriptions = circo.circonscriptions
      state.index = index
    },
    chooseView(state, name, index) {
      state.view.name = name
      state.view.index = index
    },
  },
  actions: {

  }
})
