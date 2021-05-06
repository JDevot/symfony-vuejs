// Index.vue

<template>
  <div>
    <h2>Poste</h2>
    <b-card-group columns>
      <b-card v-for="item in items" :key="item.id" class="text-center">
        <b-card-title> Titre: {{ item.title }} </b-card-title>
        <b-card-text v-if="item.author.email"> auteur: {{item.author.email}} </b-card-text>
        <b-card-text v-if="item.categorie.label"> Categorie: {{item.categorie.label}} </b-card-text>
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
import PostService from "../services/post.service";
export default {
  name: "Index",
  data() {
    
    return {
      items: [],
    };
  },
  mounted() {
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