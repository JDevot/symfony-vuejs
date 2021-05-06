// Index.vue

<template>
  <div>
    <h1>Items</h1>

    <table class="table table-hover">
      <thead>
        <tr>
          <td>ID</td>
          <td>Post item</td>
          <td>Body item</td>
          <td>Actions</td>
        </tr>
      </thead>
      <tbody v-if="items">
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.body }}</td>
          <td>
            <router-link
              :to="{ name: 'Edit', params: { id: item.id } }"
              class="btn btn-primary"
              >Edit</router-link
            >
          </td>
          <td>
            <button class="btn btn-danger" v-on:click="deleteItem(item.id)">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
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
      async deleteItem(id){
          await PostService.deletePost(id)
          PostService.getPost().then((res) => this.items = res.data,err => console.log(err));
      }
  }
};
</script>