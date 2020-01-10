<template>
    <div class="search-results">
        <Header :search="false"/>

        <div class="search">
            <input class="search__input" type="text" placeholder="Search" v-model="queryInput" @keyup.enter="search()">
            <button class="search__button" @click="search()"><img class="search__image" src="../assets/search-white.png" alt="Search"></button>
        </div>
        
        
        <div class="search-results__container">
            <h2 class="search-results__heading">Search results: {{ query }}</h2>
            <select class="search-results__type" v-model="type" @change="search()">
                <option v-for="type in searchTypes" :key="type.query" :value="type.query">{{ type.name }}</option>
            </select>
            <div class="search-results__results" v-if="this.type == 'posts'">
                
                <div :key="result.id" class="search-results__result" v-for="result in results">
                    <h3 class="search-results__result--title">{{ result.title }}</h3>
                    <pre class="search-results__result--body">{{ result.body.slice(0, 501) }} <span v-if="result.body.length > 499">...</span></pre>
                </div>
            </div>
            <div class="search-results__results" v-else-if="this.type == 'users'">
                <div :key="result.id" class="search-results__result" v-for="result in results">
                    <h3 class="search-results__result--username">{{ result.username }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue'

export default {
    name: 'searchResults',
    components: {
        Header
    },
    data() {
        return {
            results: [],
            searchTypes: [
                {
                    name: 'Posts',
                    query: 'posts'
                },
                {
                    name: 'Users',
                    query: 'users'
                }
            ],
            type: 'posts',
            query: '',
            queryInput: ''
        }
    },
    methods: {
        search() {
            this.query = this.queryInput;
            let url = "/api/search/" + this.type

            this.$http
            .post(url, { search: this.query })
            .then((response) => {
                this.results = response.data
                window.console.log(response.data)
            })
        }
    },
    mounted() {
        this.query = this.$route.params.query;
        this.queryInput = this.$route.params.query;
        this.search()
    }
}
</script>