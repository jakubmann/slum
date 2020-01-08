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
        <div class="login-form" v-if="!registerPage">
            <h2 class="login-form__title">Login</h2>
            <span class="login-form__switch" @click="registerPage = true">or Register</span>
             <div class="login-form__input-container">
                 <div class="login-form__error" v-if="error">{{ error }}</div>
                <input class="login-form__input" :class="{ 'login-form__input--success': success }" type="text" v-model="inputUsername" placeholder="Username / Email">
                <input class="login-form__input" :class="{ 'login-form__input--success': success }"  @keyup.enter="login()" type="password" v-model="inputPassword" placeholder="Password">
                <button class="login-form__submit" @click="login()">Login</button>
            </div>
        </div>
        <div class="login-form" v-if="registerPage">
            <h2 class="login-form__title">Register</h2>
            <span class="login-form__switch" @click="registerPage = false">or Login</span>
            <div class="login-form__input-container">
                <div class="login-form__message" v-if="message">{{ message }}</div>
                <div class="login-form__error" v-if="error">{{ error }}</div>
                <input class="login-form__input" :class="{ 'login-form__input--success': success }" type="text" v-model="inputUsername" placeholder="Username">
                <input class="login-form__input" :class="{ 'login-form__input--success': success }" type="text" v-model="inputEmail" placeholder="Email">
                <input class="login-form__input" :class="{ 'login-form__input--success': success }" type="password" v-model="inputPassword" placeholder="Password">
                <input class="login-form__input" :class="{ 'login-form__input--success': success }" @keyup.enter="register()" type="password" v-model="inputPasswordConfirm" placeholder="Confirm Password">
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
            registerPage: false,
            inputUsername: '',
            inputEmail: '',
            inputPassword: '',
            inputPasswordConfirm: '',
            success: false,
            error: '',
            previewPostsLeft: [],
            previewPostsRight: [],
            message: ""
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
                    this.success = true
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
        },
        register() {
            if (!this.inputPassword || !this.inputPasswordConfirm || !this.inputUsername || !this.inputEmail) {
                this.error = "Please fill out all fields"
            }
            else if (this.inputPassword != this.inputPasswordConfirm) {
                this.error = "Passwords must match"
            }
            else if (this.inputUsername.length < 4) {
                this.error = "Username must be at least 4 characters long"
            }
            else if (this.inputUsername.length > 60) {
                this.error = "Username can't be longer than 60 characters"
            }
            else if (this.inputPassword.length < 8) {
                this.error = "Password must be at least 8 characters long"
            }

            else {
                if (this.emailValid) {
                    this.error = '';
                    let data = {
                        username: this.inputUsername,
                        email: this.inputEmail,
                        password: this.inputPassword
                    }
                    this.$http
                    .post('/api/user/register', data)
                    .then((response) => {
                        if (response.data == 'success') {
                            this.success = true
                            this.message = 'Check your email inbox';
                        } else if (response.data == 'email') {
                            this.error='Email taken'
                        } else if (response.data == 'user') {
                            this.error='Username taken'
                        }
                        window.console.log(response.data)
                    })
                } else {
                    this.error = "Invalid email"
                }
            }
        }
    },
    mounted() {
        this.$http
        .get("/api/post/preview")
        .then((response) => {
            this.previewPostsLeft = response.data.slice(0, 20)
            this.previewPostsRight = response.data.slice(20, 40)
        })
    },
    computed: {
        emailValid() {
            let re = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
            if (re.test(this.inputEmail)) {
                return true
            }
            else {
                return false
            }
        }
    }
}
</script>