// Create.vue

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3>Création d'un post</h3>
      </div>
      <div class="card-body">
        <form v-on:submit.prevent="addItem">
          <div class="form-group">
            <label>Titre du post:</label>
            <input type="text" class="form-control" v-model="item.title" />
          </div>
          <div class="form-group">
            <label>Contenue du post:</label>
            <input type="text" class="form-control" v-model="item.body" />
          </div>
          <div class="form-group">
            <label>Resume du post:</label>
            <input type="text" class="form-control" v-model="item.resume" />
          </div>
          <div class="form-group">
          <label>Categorie:</label>
            <select v-model="item.categorie">
                <option v-for="option in categories" v-bind:value="option.label" v-bind:key="option.id">
                    {{option.label}}
                </option>
            </select>
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
import PostService from "../services/post.service";
import CategorieService from "../services/categorie.service";
export default {
  components: {},
  data() {
    return {
      item: {},
      categories: {}
    };
  },
  mounted() {
    CategorieService.getCategorie().then(
      (res) => {
        console.log(res.data)
        this.categories = res.data;
      },
      (error) => {
        console.log(error);
      })
  },
  methods: {
    async addItem() {
      try {
        await PostService.postPost(this.item)
        this.$router.push("/index");
      } catch (error) {
        throw "Sorry you can't make a post now!";
      }
    },
  },
};
</script>