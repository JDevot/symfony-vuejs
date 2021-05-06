<template>
  <div>
  <b-navbar toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand href="#">NavBar</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav v-if="loggedIn">
        <b-link :to="{ name: 'Create' }" class="nav-link">Nouveau Poste</b-link>
        <b-link :to="{ name: 'Index' }" class="nav-link">Tous les Postes</b-link>
        <b-link :to="{ name: 'Etats' }" class="nav-link">Etats des lieux</b-link>
        <b-nav-item href="#" @click="logout">Logout</b-nav-item>
      </b-navbar-nav>
       <b-navbar-nav v-else>
          <b-link :to="{ name: 'Register' }" class="nav-link">register</b-link>
          <b-link :to="{ name: 'Login' }" class="nav-link">login</b-link>
        </b-navbar-nav>
    </b-collapse>
      <!-- Right aligned nav items -->
     
  </b-navbar>
</div>
</template>

<script>
export default {
    computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
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

</style>