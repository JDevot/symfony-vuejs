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
                        <input type="text" class="form-control" v-model="item.title"/>
                    </div>
                    <div class="form-group">
                        <label>Post Body:</label>
                        <input type="text" class="form-control" v-model="item.body" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update Item"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default{
        data(){
            return{
                item:{}
            }
        },

        created: function(){
            this.getItem();
        },

        methods: {
            getItem()
            {
              let uri = 'http://127.0.0.1:8000/post/' + this.$route.params.id;
                this.axios.get(uri).then((response) => {
                    this.item = response.data;
                });
            },

            updateItem()
            {
              let uri = 'http://127.0.0.1:8000/post/' + this.$route.params.id;
                this.axios.put(uri, this.item).then((response) => {
                  this.$router.push({name: 'Index'});
                  console.log(response)
                });
            }
        }
    }
</script>