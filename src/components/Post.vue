<template>
    <div class="post">
        <h3 @click="$router.push('/post/' + id)" class="post__title">{{ title }}</h3>
        <h4 class="post__author">{{ author_name }}</h4>
        <pre class="post__body">{{ body }}</pre>                
    </div>
</template>

<script>
export default {
    name: 'post',
    props: {
        id: Number,
        author: Number,
        author_name: String,
        title: String,
        body: String,
        post_date: String
    }
}
</script>

