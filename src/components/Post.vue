<template>
    <div class="post">
        <h3 class="post__title">{{ title }}</h3>
        <pre class="post__body">{{ body }}</pre>                
    </div>
</template>

<script>
export default {
    name: 'post',
    props: {
        id: Number,
        author: Number,
        title: String,
        body: String,
        post_date: String
    }
}
</script>

