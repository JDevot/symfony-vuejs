import axios from 'axios';
import authHeader from './auth-header';
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

class VilleService {
  getVille() {
    return axios.get('villes',{ headers: authHeader() });
  }
  putVille(id,data) {
    return axios.put(`villes/${id}`,data,{ headers: authHeader()})
  }
  deleteVille(id){
    return axios.delete(`villes/${id}`,{ headers: authHeader()})
  }
  postVille(body){
    console.log(body)
    return axios.post(`villes`, body,{ headers: authHeader()})
  }
  getOneVille(id){
    return axios.get(`villes/${id}`,{ headers: authHeader()})
  }
}

export default new VilleService();