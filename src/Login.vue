<template>
<div class="login">
    <div class="login__left">
        <div class="preview">
            <div class="preview__left">
                <div :key="post.id" v-for="post in previewPostsLeft" class="preview__post">
                    <h3 class="title">{{ post.title }}</h3>
                    <pre class="body">{{ post.body }}</pre>
                </div>
            </div>
            <div class="preview__right">
                <div :key="post.id" v-for="post in previewPostsRight" class="preview__post">
                    <h3 class="title">{{ post.title }}</h3>
                    <pre class="body">{{ post.body }}</pre>
                </div>
            </div>
        </div>
    </div>
    <div class="login__right">
        <div class="login-form" v-if="!register">
            <h2 class="login-form__title">Login</h2>
            <span class="login-form__switch" @click="register = true">or Register</span>
             <div class="login-form__input-container">
                 <div class="login-form__error" v-if="error">{{ error }}</div>
                <input class="login-form__input" :class="{ 'login-form__input--success': loggedIn }" type="text" v-model="inputUsername" placeholder="Username / Email">
                <input class="login-form__input" :class="{ 'login-form__input--success': loggedIn }"  @keyup.enter="login()" type="password" v-model="inputPassword" placeholder="Password">
                <button class="login-form__submit" @click="login()">Login</button>
            </div>
        </div>
        <div class="login-form" v-if="register">
            <h2 class="login-form__title">Register</h2>
            <span class="login-form__switch" @click="register = false">or Login</span>
            <div class="login-form__input-container">
                <div class="login-form__error" v-if="error">{{ error }}</div>
                <input class="login-form__input" :class="{ 'login-form__input--success': loggedIn }" type="text" v-model="inputUsername" placeholder="Username">
                <input class="login-form__input" :class="{ 'login-form__input--success': loggedIn }" type="text" v-model="Email" placeholder="Email">
                <input class="login-form__input" :class="{ 'login-form__input--success': loggedIn }" type="password" v-model="inputPassword" placeholder="Password">
                <input class="login-form__input" :class="{ 'login-form__input--success': loggedIn }" @keyup.enter="register()" type="password" v-model="inputPasswordConfirm" placeholder="Confirm Password">
                <button class="login-form__submit" @click="register()">Register</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'login',
    data() {
        return {
            register: false,
            inputUsername: '',
            inputEmail: '',
            inputPassword: '',
            inputPasswordConfirm: '',
            loggedIn: false,
            error: '',
            previewPostsLeft: [],
            previewPostsRight: [],
        }
    },
    methods: {
        login() {
            let data = {
                email: this.inputUsername,
                password: this.inputPassword
            }
            this.$http
            .post('/api/user/login', data)
            .then((response) => {
                if (response.data == 'success') {
                    this.loggedIn = true
                    this.$store.commit('setAuthentication', true)
                    this.$store.dispatch('getUser')
                    window.setTimeout(() => {
                        this.$router.replace('/')
                    }, 600)
                } else if (response.data == 'error') {
                    this.error='Incorrect password'
                } else if (response.data == 'user') {
                    this.error='This user doesn\'t exist'
                }
                window.console.log(response.data)
            })
        }
    },
    mounted() {
        this.$http
        .get("/api/post/preview")
        .then((response) => {
            this.previewPostsLeft = response.data.slice(0, 20)
            this.previewPostsRight = response.data.slice(20, 40)
        })
    }
}
</script>