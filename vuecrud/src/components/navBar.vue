<template>
  <div>
  <b-navbar toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand href="#">Projet web service</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav v-if="loggedIn">
        <b-link :to="{ name: 'Create' }" class="nav-link">nouveau poste</b-link>
        <b-link :to="{ name: 'Index' }" class="nav-link">tous les postes</b-link>
        <b-link :to="{ name: 'Categorie' }" class="nav-link">liste des categories</b-link>
        <b-link :to="{ name: 'AddCategorie' }" class="nav-link">nouvelle categorie</b-link>
        <b-link :to="{ name: 'User' }" class="nav-link">liste des utilisateurs</b-link>
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