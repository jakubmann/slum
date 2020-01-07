<template>
    <div class="home">
        <Header />

        <div class="posts">
            <h2 class="posts__heading">Recent posts</h2>
            <Post v-for="post in posts" :key="post.id" :id="post.id" :title="post.title" :body="post.body" :post_date="post.post_date" /> 
        </div>
    </div>
</template>

<script>
import Header from './components/Header.vue'
import Post from './components/Post.vue'

export default {
    name: 'home',
    components: {
        Header,
        Post
    },
    data() {
        return {
            posts: [],
            count: 0
        }
    },
    methods: {
        getPosts() {
            this.$http
            .post("/api/post/scroll", { count: 10, previous: this.count})
            .then((response) => {
                this.posts = response.data
                this.count += 10
            })
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

