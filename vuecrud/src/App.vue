
<template>
  <div id="app" class="container">
    <nav class="navbar navbar-expand-sm bg-light">
      <ul v-if="loggedIn" class="navbar-nav">
        <li class="nav-item">
          <router-link :to="{ name: 'Create' }" class="nav-link">Add Item</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'Index' }" class="nav-link">All Items</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'Etats' }" class="nav-link">Etats</router-link>
        </li>
        <a  class="nav-item" @click="logout">Logout</a>
      </ul>
      <ul v-else class="navbar-nav">
        <li class="nav-item">
          <router-link :to="{ name: 'Register' }" class="nav-link">register</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'Login' }" class="nav-link">login</router-link>
        </li>
      </ul>
    </nav>
    <transition name="fade">
      <div class="gap">
        
        <router-view></router-view>        
      </div>
    </transition>
  </div>
</template>

<script>

export default {
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  },
  created() {
    if (this.loggedIn) {
      this.$router.push('/index');
    }
  },
  methods: {
    async logout(){
      console.log('la')
      await this.$store.dispatch('auth/logout')
      this.$router.push('/login')
    }
  }
}
</script>

<style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
      opacity: 0
    }
    .gap {
      margin-top: 50px;
    }
</style>