// main.js

import Vue from 'vue'
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import NProgress from 'nprogress';
import Navbar from './components/navBar.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VeeValidate from 'vee-validate';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
  faHome,
  faUser,
  faUserPlus,
  faSignInAlt,
  faSignOutAlt
} from '@fortawesome/free-solid-svg-icons';
import App from './App.vue';
import Etats from './components/Etats.vue'
import Create from './components/Create.vue';
import Edit from './components/Edit.vue';
import Index from './components/Index.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import store from './store'
import '../node_modules/bootstrap/dist/css/bootstrap.min.css';
import '../node_modules/nprogress/nprogress.css';
library.add(faHome, faUser, faUserPlus, faSignInAlt, faSignOutAlt);
Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueAxios, axios);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.config.productionTip = false;

const routes = [
  {
    name: 'Login',
    path: '/login',
    component: Login
  },
  {
    name: 'Register',
    path: '/register',
    component: Register
  },
  {
    name: 'NavBar',
    path: '/navBar',
    component: Navbar
  },
  {
    name: 'Create',
    path: '/create',
    component: Create,
    meta: {requiresAuth: true},
  },
  {
    name: 'Edit',
    path: '/edit',
    component: Edit,
    meta: {requiresAuth: true},
  },
  {
    name: 'Index',
    path: '/index',
    component: Index,
    meta: {requiresAuth: true},
  },
  {
    name: 'Etats',
    path: '/etats',
    component: Etats,
    meta: {requiresAuth: true},
  }
];

const router = new VueRouter({ mode: 'history', routes: routes });
router.beforeEach((to, from, next)=> {
  if(to.matched.some(record => record.meta.requiresAuth)){
    if(store.state.auth.status.loggedIn){
      console.log(store.state.auth.status.loggedIn)
      next()
      return
    }
    next('/login')
  }else {
    next()
  }
})
router.beforeResolve((to, from, next) => {
  if (to.name) {
      NProgress.start()
  }
  next()
});

router.afterEach(() => {
  NProgress.done()
});

new Vue({
  render: h => h(App),
  store,
  router
}).$mount('#app')