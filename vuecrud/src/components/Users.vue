<template>

  <div>
    <h2>User</h2>
    <b-card-group columns>
      <b-card v-for="item in items" :key="item.id" class="text-center">
        <b-card-text v-if="item.username"> Nom User: {{item.username}} </b-card-text>
        <b-link
          :to="{ name: 'EditUser', params: { id: item.id } }"
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
import UserService from "../services/user.service";
export default {
  name: "User",
  data() {
    
    return {
      items: [],
    };
  },
  mounted() {
  UserService.getUser().then(
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
      await UserService.deleteUser(id);
      UserService.getUser().then(
        (res) => (this.items = res.data),
        (err) => console.log(err)
      );
    },
  },
};
</script>

<style>

</style>