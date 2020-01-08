<template>
    <div class="singlepost">

    </div>
</template>

<script>
export default {
    name: 'singlePost',
    data() {
        
    },
    props: {
        id: Number,
        author: Number,
        authorName: String,
        title: String,
        body: String,
        post_date: String
    }
}
</script>