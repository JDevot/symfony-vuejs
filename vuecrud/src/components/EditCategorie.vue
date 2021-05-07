// Edit.vue

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3>Edit Categorie</h3>
      </div>
      <div class="card-body">
        <form v-on:submit.prevent="updateItem">
          <div class="form-group">
            <label>Nom Categorie:</label>
            <input type="text" class="form-control" v-model="item.label" />
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
import CategorieService from "../services/categorie.service";
export default{
        data(){
            return{
                item:{},
            }
        },
 mounted() {
   CategorieService.getOneCategorie(this.$route.params.id).then(
      (res) => {
        this.item = res.data;
      },
      (error) => {
        console.log(error);
      });
  },
  methods: {
      async updateItem(){
          await CategorieService.putCategorie(this.$route.params.id,this.item)
          this.$router.push({name: 'Categorie'});
      }
  }
}
</script>