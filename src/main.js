//import libraries
import Vue from 'vue'
import Router from 'vue-router'
import Axios from 'axios'

//import components
import App from './App.vue'

import Login from './Login.vue'
import Home from './Home.vue'

//style
import './style/main.scss'

//import store
import store from './store.js'

//use libraries
Vue.use(Router)

Vue.config.productionTip = false
Vue.prototype.$http = Axios

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
  render: h => h(App)
}).$mount('#app')
