<script>
import { fetchCardsByName, fetchSetCode } from '../services/cardService.js';

export default {
    data() {
        return {
            cards: [],
            displayCards: [],
            loadingCards: false,
            search: '',
            setCodes: [],
            setCode: '',
        };
    },
    methods: {
        searchCards() {
            if (this.search.length < 3) {
                this.loadingCards = false;
                return;
            }
            this.loadingCards = true;
            fetchCardsByName(this.search).then((cards) => {
                this.loadingCards = false;
                if (this.setCode !== '') {
                    this.filterCards();
                }
                this.cards = cards;
                this.displayCards = cards;
            });
        },
        clearSearch() {
            this.search = '';
            this.cards = [];
        },
        clearCodes() {
            this.setCode = '';
            this.displayCards = this.cards;
        },
        filterCards() {
            this.displayCards = this.cards.filter((card) => card.setCode === this.setCode);
        },
    },
    created() {
        fetchSetCode().then((setCodes) => {
            this.setCodes = setCodes;
        });
    },

};
</script>

<template>
    <div>
        <h1>Rechercher une Carte</h1>
    </div>
    <div class="flex-row">
        <div>
            Filtrer par :
            <select v-model="setCode">
                <option value="" selected disabled hidden>Choisir un setCode</option>
                <option @click="filterCards" v-for="setCode in setCodes" :key="setCode" :value="setCode">
                    {{ setCode }}
                </option>
            </select>
            <button v-if="setCode" @click="clearCodes">Supprimer le filtre</button>
        </div>
        <div>
            <input type="text" v-model="search" @input="searchCards" />
            <button type="reset" @click="clearSearch">Vider</button>
        </div>
    </div>
    <div class="card-list">
        <div v-if="loadingCards">Loading...</div>
        <div v-else>
            <div class="card" v-for="card in displayCards" :key="card.id">
                <router-link :to="{ name: 'get-card', params: { uuid: card.uuid } }"> {{ card.name }} - {{
                    card.uuid
                }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<style scoped>
h1 {
  color: #333;
  font-size: 2em;
  text-align: center;
  margin-bottom: 20px;
}

select, input[type="text"] {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ddd;
  margin: 5px;
}

button {
  background-color: #007BFF;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: 5px;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.flex-row {
  display: flex;
  justify-content: space-around;
  margin-bottom: 20px;
}

.card-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.card {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  padding: 20px;
  margin-bottom: 20px;
  width: 80%;
  box-sizing: border-box;
}

.card:hover {
  background-color: #e9e9e9;
}

.loading {
  font-size: 1.5em;
  text-align: center;
  color: #999;
}
</style>
