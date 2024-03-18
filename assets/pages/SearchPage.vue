<script>
export default {
  data() {
    return {
      cards: [],
      loadingCards: false,
      search: "",
    };
  },
  methods: {
    searchCards() {
      if (this.search.length < 3) {
        this.loadingCards = false;
        return;
      }
      this.loadingCards = true;
      fetch(`http://localhost/api/card/search/${this.search}`)
          .then((response) => response.json())
          .then((data) => {
            this.cards = data;
            this.loadingCards = false;
          });
      this.cards = this.cards.slice(0, 20);
    },
    clearAll() {
      this.search = "";
      this.cards = [];
    },
  },
};
</script>

<template>
  <div>
    <h1>Rechercher une Carte</h1>
  </div>
  <div>
    <input type="text" v-model="search" @input="searchCards"/>
    <button @click="clearAll">Vider</button>
  </div>
  <div class="card-list">
    <div v-if="loadingCards">Loading...</div>
    <div v-else>
      <div class="card" v-for="card in cards" :key="card.id">
        <router-link :to="{ name: 'get-card', params: { uuid: card.uuid } }"> {{ card.name }} - {{
            card.uuid
          }}
        </router-link>
      </div>
    </div>
  </div>
</template>
