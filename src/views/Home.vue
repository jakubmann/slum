<template>
    <div class="home">
        <Header />

        <AddPost @posted="reloadPosts()"/>
        <div class="posts">
            <h2 class="posts__heading">{{ $t('home.heading') }}</h2>
            <Post v-for="post in posts" :key="post.id" 
                :id="post.id"
                :title="post.title"
                :body="post.body" 
                :post_date="post.post_date"
                :author_name="post.author_name"
            /> 
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue'
import Post from '../components/Post.vue'
import AddPost from '../components/AddPost.vue'

export default {
    name: 'home',
    components: {
        Header,
        Post,
        AddPost
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
            .post("/api/post/scroll", { count: 50, previous: this.count})
            .then((response) => {
                this.posts = response.data
                this.count += 50
            })
        },
        reloadPosts() {
            this.count = 0
            this.$http
            .post("/api/post/scroll", { count: 50, previous: this.count})
            .then((response) => {
                this.posts = response.data
                this.count += 50
            })
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

