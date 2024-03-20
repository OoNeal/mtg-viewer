<script>
import { fetchAllCards, fetchSetCode } from '../services/cardService';

export default {
    data() {
        return {
            cards: [],
            displayCards: [],
            loadingCards: false,
            setCodes: [],
            setCode: '',
        };
    },
    methods: {
        loadCards() {
            this.loadingCards = true;
            fetchAllCards(this.search).then((cards) => {
                this.loadingCards = false;
                if (this.setCode !== '') {
                    this.filterCards();
                }
                this.cards = cards;
                this.displayCards = cards;
            });
        },
        clearCodes() {
            this.setCode = '';
            this.displayCards = this.cards;
        },
        filterCards() {
            this.displayCards = this.cards.filter((card) => card.setCode === this.setCode);
            console.log(this.displayCards);
        },
    },
    created() {
        this.loadCards();
        fetchSetCode().then((setCodes) => {
            this.setCodes = setCodes;
        });
    },

};

</script>

<template>
    <div>
        <h1>Toutes les cartes</h1>
    </div>
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
    <div class="card-list">
        <div v-if="loadingCards">Loading...</div>
        <div v-else>
            <div class="card-result" v-for="card in displayCards" :key="card.id">
                <router-link :to="{ name: 'get-card', params: { uuid: card.uuid } }">
                    {{ card.name }} <span>({{ card.uuid }})</span>
                </router-link>
            </div>
        </div>
    </div>
</template>
