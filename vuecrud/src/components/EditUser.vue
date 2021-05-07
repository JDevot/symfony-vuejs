// Edit.vue

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3>Edit User</h3>
      </div>
      <div class="card-body">
        <form v-on:submit.prevent="updateItem">
          <div class="form-group">
            <label>Nom User:</label>
            <input type="text" class="form-control" v-model="item.username" />
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
import UserService from "../services/user.service";
export default{
        data(){
            return{
                item:{},
            }
        },
 mounted() {
   UserService.getOneUser(this.$route.params.id).then(
      (res) => {
        this.item = res.data;
      },
      (error) => {
        console.log(error);
      });
  },
  methods: {
      async updateItem(){
          await UserService.putUser(this.$route.params.id,this.item)
          this.$router.push({name: 'User'});
      }
  }
}
</script>