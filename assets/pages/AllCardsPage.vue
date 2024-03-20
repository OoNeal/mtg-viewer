<script>
import { fetchAllCardsWithPagination, fetchCardsBySetCode, fetchSetCode } from '../services/cardService';

export default {
    data() {
        return {
            cards: [],
            loadingCards: false,
            setCodes: [],
            setCode: '',
            page: 1,
            totalPages: 0,
        };
    },
    methods: {
        loadCards() {
            this.loadingCards = true;
            if (this.setCode !== '') {
                fetchCardsBySetCode(this.setCode, this.page).then((data) => {
                    this.loadingCards = false;
                    this.cards = data.cards;
                    this.totalPages = data.totalPages;
                });
            } else {
                fetchAllCardsWithPagination(this.page).then((data) => {
                    this.loadingCards = false;
                    this.cards = data.cards;
                    this.totalPages = data.totalPages;
                });
            }
        },
        clearCodes() {
            this.setCode = '';
            this.page = 1;
        },
        switchPage(number) {
            this.page += number;
            this.verifyPage();
        },
        verifyPage() {
            if (this.page < 1) {
                this.page = 1;
            } else if (this.page > this.totalPages) {
                this.page = this.totalPages;
            }
        },
    },
    created() {
        this.loadCards();
        fetchSetCode().then((setCodes) => {
            this.setCodes = setCodes;
        });
    },
    watch: {
        page() {
            this.loadCards();
        },
        setCode() {
            this.page = 1;
            this.loadCards();
        },
    },
};
</script>

<template>
    <div>
        <h1>Toutes les cartes</h1>
    </div>
    <div class="flex-row">
        <div>
            Filtrer par :
            <select v-model="setCode">
                <option value="" selected disabled hidden>Choisir un setCode</option>
                <option v-for="setCode in setCodes" :key="setCode" :value="setCode">
                    {{ setCode }}
                </option>
            </select>
            <button v-if="setCode" @click="clearCodes">Supprimer le filtre</button>
        </div>
        <div>
            Pagination :
            <button @click="switchPage(-10)"><<<</button>
            <button @click="switchPage(-1)"><</button>
            <span>{{ page }}</span>
            <button @click="switchPage(1)">></button>
            <button @click="switchPage(10)">>>></button>
        </div>
    </div>
    <div class="card-list">
        <div v-if="loadingCards">Loading...</div>
        <div v-else>
            <div class="card-result" v-for="card in cards" :key="card.id">
                <router-link :to="{ name: 'get-card', params: { uuid: card.uuid } }">
                    {{ card.name }} <span>({{ card.uuid }})</span>
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

select {
  cursor: pointer;
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

.card-result {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  padding: 20px;
  margin-bottom: 20px;
  width: 80%;
  box-sizing: border-box;
}

.card-result:hover {
  background-color: #e9e9e9;
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

select {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ddd;
}

</style>
