<template>
    <div class="changelocale">
        <select class="changelocale__select" v-model="locale" @change="changeLocale()">
            <option v-for="locale in locales" :key="locale.value" :value="locale.value">{{ locale.name }}</option>
        </select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            locales: [
                {
                    name: 'English',
                    value: 'en'
                },
                {
                    name: 'Čeština',
                    value: 'cz'
                }
            ],
            locale: 'en'
        }
    },
    methods: {
        changeLocale() {
            this.$i18n.locale = this.locale
            window.localStorage.setItem('slumLocale', this.locale)
        }
    },
    mounted() {
        let locale = window.localStorage.getItem('slumLocale')
        if (typeof locale !== 'undefined' && locale !== null) {
            this.locale = locale
        }
    }
}
</script>