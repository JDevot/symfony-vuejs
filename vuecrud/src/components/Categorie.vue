<template>

  <div>
    <h2>Categorie</h2>
    <b-card-group columns>
      <b-card v-for="item in items" :key="item.id" class="text-center">
        <b-card-text v-if="item.label"> Nom Categorie: {{item.label}} </b-card-text>
        <b-link
          :to="{ name: 'EditCategorie', params: { id: item.id } }"
          class="btn btn-primary"
        >
          Edit</b-link
        >
        <b-button class="btn btn-danger ml-3" v-on:click="deleteItem(item.id)">
          Delete</b-button
        >
      </b-card>
    </b-card-group>
  </div>
</template>


<script>
import CategorieService from "../services/categorie.service";
export default {
  name: "Categorie",
  data() {
    
    return {
      items: [],
    };
  },
  mounted() {
  CategorieService.getCategorie().then(
      (res) => {
        this.items = res.data;
      },
      (error) => {
        console.log(error);
      }
    );
  },
  methods: {
    async deleteItem(id) {
      await CategorieService.deleteCategorie(id);
      CategorieService.getCategorie().then(
        (res) => (this.items = res.data),
        (err) => console.log(err)
      );
    },
  },
};
</script>

<style>

</style>