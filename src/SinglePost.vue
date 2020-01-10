<template>
    <div class="singlepost">
        <Header />
        <div class="singlepost__container">
            <h2 class="singlepost__title">{{ postdata.title }}</h2>
            <h3 class="singlepost__author">{{ postdata.author_name }}</h3>
            <pre class="singlepost__body">{{ postdata.body }}</pre>
            <p class="singlepost__post-date">{{ postdata.postdate }}</p>
        </div>
    </div>
</template>

<script>
import Header from './components/Header.vue'

export default {
    name: 'singlePost',
    components: {
        Header
    },
    data() {
        return {
            postdata: {}
        }
    },
    mounted() {
        this.$http
        .get("/api/post/id/" + this.$route.params.id)
        .then((response) => {
            if (response.data) {
                this.postdata = response.data
            } else {
                
                this.$router.push("/")
            }
        })
    }
}
</script>