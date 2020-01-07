<template>
    <div class="addpost" :class="{  'addpost--success': posted }">
        <div class="addpost__error" v-if="error">{{ error }}</div>
        <input class="addpost__title" type="text" v-model="postTitle" placeholder="Title">
        <textarea class="addpost__body" v-model="postBody" rows="10" cols="50" placeholder="Blank page"></textarea>
        <button class="addpost__submit" :class="{ 'addpost__submit--disabled': disabled }" @click="submit()">Submit</button>
    </div>
</template>

<script>
export default {
    name: 'addPost',
    data() {
        return {
            postTitle: "",
            postBody: "",
            error: "",
            posted: false
        }
    },
    methods: {
        submit() {
            if (!this.disabled) {
                let data = {
                    title: this.postTitle,
                    body: this.postBody
                }
                this.$http
                .post("/api/post/submit", data)
                .then((response) => {
                    if (response.data == 'success') {
                        this.posted = true
                        window.setTimeout(() => {
                            this.posted = false
                            this.postTitle = ""
                            this.postBody = ""
                            this.$emit("posted")
                        }, 1000)
                    } else {
                        this.error = response.data
                    }
                })
            }
        }
    },
    computed: {
        disabled() {
            let disabled = false;
            if (this.postTitle == "" || this.postBody == "") {
                disabled = true;
            }
            return disabled;
        }
    }
}
</script>

