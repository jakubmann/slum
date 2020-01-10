<template>
    <div class="header">
        <img @click="$router.push('/')" src="../assets/title.png" class="header__title" alt="logo">
        <Search v-if="search"/>
        
        <div class="user">
            <div class="settings">
                <router-link to='/settings'><img class="settings__image" src="../assets/settings.png" alt="settings"></router-link>
            </div>
            <img class="user__image" src="../assets/user.png" alt="user">
            <div class="user__text">{{ $store.state.user.username }}</div>
            <button class="user__logout" @click="logout()">{{ $t('header.logout') }}</button>
        </div>
        <div class="navigation">
            <router-link to="/" class="navigation__link">{{ $t('header.home') }}</router-link>
            <router-link to="/categories" class="navigation__link">{{ $t('header.categories') }}</router-link>
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
    props: {
        search: {
            default: true,
            type: Boolean
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

