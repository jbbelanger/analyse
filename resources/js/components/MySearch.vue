<template>
  <ais-instant-search
    :search-client="searchClient"
    index-name="personnes"
  >
    <!-- Other search components go here -->
    <ais-search-box
      placeholder="Chercher une personne"
      submit-title="Recherche en cours"
      reset-title="Effacer"
      autofocus
      show-loading-indicator
    />

    <ais-infinite-hits>
      <v-list slot-scope="{ items, refinePrevious, refineNext }">

        <v-list-tile v-for="item in items" :key="item.objectID">
          <span><router-link :to="{name: 'personne', params: {personneId: item.objectID}}">{{ item.prenom }} {{ item.nom }}</router-link></span>
        </v-list-tile>

      </v-list>
    </ais-infinite-hits>

  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite';

export default {
  data() {
    return {
      searchClient: algoliasearch(
        process.env.MIX_ALGOLIA_APP_ID,
        process.env.MIX_ALGOLIA_SEARCH
      ),
    };
  },
};
</script>
