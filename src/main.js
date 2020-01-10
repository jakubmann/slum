//import libraries
import Vue from 'vue'
import Router from 'vue-router'
import Axios from 'axios'

//import components
import App from './App.vue'

import Login from './views/Login.vue'
import Home from './views/Home.vue'
import SearchResults from './views/SearchResults.vue'
import SinglePost from './views/SinglePost.vue'
import Settings from './views/Settings.vue'
import NotFound from './views/NotFound.vue'

//style
import './style/main.scss'

//import store
import store from './store.js'

import i18n from './i18n'

//use libraries
Vue.use(Router)

Vue.config.productionTip = false
Vue.prototype.$http = Axios

let locale = window.localStorage.getItem('slumLocale')
if (typeof locale !== 'undefined' && locale !== null) {
    i18n.locale = locale
}


//routes setup
const routes = [
  {
    path: '/',
    component: Home,
    beforeEnter: (to, from, next) => {
      if (!store.state.authenticated) next('/login')
      else next()
    }
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/search/:query',
    component: SearchResults
  },
  {
    path: '/post/:id',
    component: SinglePost
  },
  {
    path: '/settings',
    component: Settings
  },
  {
    path: '*',
    component: NotFound
  }
]

//create router
const router = new Router({
  routes: routes,
  mode: 'history'
})

//create main vue instance
new Vue({
  el: '#app',
  router,
  store: store,
  i18n,
  render: h => h(App)
}).$mount('#app')
