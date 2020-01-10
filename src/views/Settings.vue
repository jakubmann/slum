<template>
    <div class="settings">
        <Header />
        <div class="settings__container">
            <ChangeLocale />
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue'
import ChangeLocale from '../components/ChangeLocale.vue'

export default {
    name: 'settings',
    components: {
        Header,
        ChangeLocale
    }
}
</script>