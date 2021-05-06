
<template>
  <div id="app" class="container-fluid">
    <nav-bar/>
    <transition name="fade">
      <div class="gap">    
        <router-view></router-view>        
      </div>
    </transition>
  </div>
</template>

<script>
import NavBar from './components/navBar.vue';
export default {
  components:{
    NavBar
  },
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
.container-fluid{
    padding: 0!important;
    margin: 0!important;
}
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