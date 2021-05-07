// Create.vue

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3>Création d'une Categorie</h3>
      </div>
      <div class="card-body">
        <form v-on:submit.prevent="addItem">
          <div class="form-group">
            <label>Nom de la categorie:</label>
            <input type="text" class="form-control" v-model="item.label" />
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Item" />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import CategorieService from "../services/categorie.service";
export default {
  components: {},
  data() {
    return {
      item: {},
    };
  },
  mounted() {
  },
  methods: {
    async addItem() {
      try {
        await CategorieService.categoriePost(this.item)
        this.$router.push("/categorie");
      } catch (error) {
        throw "Sorry you can't make a categorie now!";
      }
    },
  },
};
</script>