// Edit.vue

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3>Edit Post</h3>
      </div>
      <div class="card-body">
        <form v-on:submit.prevent="updateItem">
          <div class="form-group">
            <label>Post Title:</label>
            <input type="text" class="form-control" v-model="item.title" />
          </div>
          <div class="form-group">
            <label>Post Body:</label>
            <input type="text" class="form-control" v-model="item.body" />
          </div>
          <div class="form-group">
          <label>Categorie:</label>
            <select v-if="item.categorie" v-model="item.categorie.label">
                <option v-for="option in categories" v-bind:value="option.label" v-bind:key="option.id">
                    {{option.label}}
                </option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update Item" />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import PostService from "../services/post.service";
import CategorieService from "../services/categorie.service";
export default{
        data(){
            return{
                item:{},
                categories: {}
            }
        },
 mounted() {
   CategorieService.getCategorie().then(
      (res) => {
        this.categories = res.data;
      },
      (error) => {
        console.log(error);
      }),
    PostService.getOnePost(this.$route.params.id).then(
      (res) => {
        this.item = res.data;
      },
      (error) => {
        console.log(error);
      }
    );
  },
  methods: {
      async updateItem(){
          await PostService.putPost(this.$route.params.id,this.item)
          this.$router.push({name: 'Index'});
      }
  }
}
</script>