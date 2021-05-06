// Etats.vue

<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3>Add Item</h3>
      </div>
      <div class="card-body">
        <form v-on:submit.prevent="addItem">
          <div class="form-group">
            <label>Titre:</label>
            <input type="text" class="form-control" v-model="item.titre" />
          </div>
          <div class="form-group">
           <label>Type :</label>
            <select v-model="item.type">
                <option v-for="option in optionsType" v-bind:value="option.libelle" v-bind:key="option.id">
                    {{option.libelle}}
                </option>
            </select>
          </div>
          <div class="form-group">
            <label>nombre de pieces:</label>
            <input type="text" class="form-control" v-model="item.nbPieces" />
          </div>
          <div class="form-group">
            <label>Ville :</label>
            <select v-model="item.nomVille">
                <option v-for="option in optionsVille" v-bind:value="option.nomVille" v-bind:key="option.id">
                    {{option.nomVille}}
                </option>
            </select>
          </div>
          <div class="form-group">
            <label>surface:</label>
            <input type="text" class="form-control" v-model="item.surface" />
          </div>
          <div class="form-group">
            <label>photo:</label>
            <img style="" :src="item.photo" alt="">
            <input type="file" class="form-control" @change="onFileChange" accept="image/*" />
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
import EdlService from "../services/edl.service";
import VillesService from '../services/villes.service'
import TypeService from '../services/type.service'
export default {
  components: {},
  data() {
    return {
      image: '',
      item: {},
      optionsVille: {},
      optionsType: {}
    };
  },
  mounted() {
    VillesService.getVille().then(
      (res) => {
        console.log(this.item)
        this.optionsVille = res.data;
        console.log(this.item)
      },
      (error) => {
        console.log(error);
      })
    TypeService.getType().then((res) =>{
        this.optionsType = res.data
    }
    );
    EdlService.getEdl().then((res)=> console.log(res))
  },
  methods: {
    onFileChange(e){
       var files = e.target.files[0] 
    //  console.log(files)
      this.createBase64Image(files)
      console.log(this.item.photo)
    },
    createBase64Image(fileObject){
      const reader = new FileReader();
      reader.onload = (e)=> {
        this.item.photo = e.target.result
      };
      console.log(this.item.photo)
      reader.readAsDataURL(fileObject)
     // reader.readAsBinaryString(fileObject)
    },
    async addItem() {
      try {
        await EdlService.postEdl(this.item);
       // this.$router.push("/index");
      } catch (error) {
          console.log(error)
         throw error;
      }
    },
  },
};
</script>