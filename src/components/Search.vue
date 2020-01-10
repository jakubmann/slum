<template>
    <div class="search">
        <input type="text" class="search__input" :placeholder="$t('header.search')" v-model="query" @keyup.enter="search()">
        <img class="search__button" src="../assets/search.png" alt="search" @click="search()">
    </div>
</template>

<script>
export default {
    name: 'search',
    data() {
        return {
            query: ''
        }
    },
    methods: {
        search() {
            if (this.query != '') {
                this.$router.push('/search/' + this.query)
                this.query = ''
            }
        }
    }
}
</script>
