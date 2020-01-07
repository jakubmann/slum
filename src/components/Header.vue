<template>
    <div class="header">
        <img src="../assets/title.png" class="header__title" alt="logo">
        <Search />
        <div class="user">
            <img class="user__image" src="../assets/user.png" alt="user">
            <div class="user__text">{{ $store.state.user.username }}</div>
            <button class="user__logout" @click="logout()">Log Out</button>
        </div>
    </div>
</template>

<script>
import Search from './Search.vue'

export default {
    name: 'Header',
    components: {
        Search
    },
    data() {
        return {

        }
    },
    methods: {
        logout() {
            this.$store.dispatch('logout')
            this.$router.push('/login')
        },
    }
}
</script>

