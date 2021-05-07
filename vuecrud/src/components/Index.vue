// Index.vue

<template>
  <div>
    <h2>Poste</h2>
    <form v-on:submit.prevent="searchItem">
      <div class="form-group">
        <label>Recherche:</label>
        <input type="text" class="form-control" v-model="item.mots" />
      </div>
      <div v-if="categories" class="form-group">
        <label>Categorie:</label>
        <select v-model="item.categorie">
          <option
            v-for="option in categories"
            v-bind:value="option.id"
            v-bind:key="option.id"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Search" />
      </div>
    </form>
    <b-card-group columns>
      <b-card v-for="item in items" :key="item.id" class="text-center">
        <b-card-title> Titre: {{ item.title }} </b-card-title>
        <b-card-text v-if="item.user">
          auteur: {{  item.user.email }}
        </b-card-text>
        <b-card-text v-if="item.categorie">
          Categorie: {{ item.categorie.label }}
        </b-card-text>
        <b-card-text v-if="item.resume">
          Resume: {{ item.resume }}
        </b-card-text>
        <b-card-text>Contenue: {{ item.body }}</b-card-text>
        <b-link
          :to="{ name: 'Edit', params: { id: item.id } }"
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
import PostService from "../services/post.service";
export default {
  name: "Index",
  data() {
    return {
      item: {},
      items: [],
    };
  },
  mounted() {
    CategorieService.getCategorie().then(
      (res) => {
        this.categories = res.data;
      },
      (error) => {
          console.log(error);
      }
    ),
      PostService.getPost().then(
        (res) => {
          this.items = res.data;
        },
        (error) => {
          console.log(error);
        }
      );
  },
  methods: {
    async searchItem() {
      PostService.searchPoste(this.item).then((res) => {
        this.items = res.data;
      });
    },
    async deleteItem(id) {
      await PostService.deletePost(id);
      PostService.getPost().then(
        (res) => (this.items = res.data),
        (err) => console.log(err)
      );
    },
  },
};
</script>