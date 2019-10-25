import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/bigmap',
      name: 'bigmap',
      component: () => import('./components/views/bigMap.vue')
    },

    {
      path: '/circonscriptions/:circoId',
      name: 'circonscriptions',
      component: () => import('./components/views/Circonscription.vue'),
      children: [
        {
          path: 'historique',
          name: 'historique',
          component: () => import('./components/views/Historique.vue')
        }
      ]
    },
    {
      path: '/circonscription/:circonscriptionId/:electionId',
      name: 'circonscription_detail',
      component: () => import('./components/views/AnalyseDetail.vue'),
      children: [
        {
          path: 'sections/toolbar',
          name: 'sections_toolbar',
          component: () => import('./components/AnalyseToolbar.vue')
        },
              {
                path: 'sections/',
                name: 'sections_tableau',
                component: () => import('./components/TableauResultatsSection.vue')
              },
              {
                path: 'sections/carte',
                name: 'sections_carte',
                component: () => import('./components/CarteResultatsSection.vue')
              },

        {
          path: 'circonscription',
          name: 'circonscriptions_tableau',
          component: () => import('./components/TableauResultats.vue')
        }
      ]
    },

    {
      path: '/admin',
      name: 'admin_root',
      component: () => import('./components/views/admin.vue'),
    }
  ]
})
