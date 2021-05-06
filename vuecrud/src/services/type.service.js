import axios from 'axios';
import authHeader from './auth-header';
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

class TypeService {
  getType() {
    return axios.get('types',{ headers: authHeader() });
  }
  putType(id,data) {
    return axios.put(`types/${id}`,data,{ headers: authHeader()})
  }
  deleteType(id){
    return axios.delete(`types/${id}`,{ headers: authHeader()})
  }
  postType(body){
    console.log(body)
    return axios.post(`types`, body,{ headers: authHeader()})
  }
  getOneType(id){
    return axios.get(`types/${id}`,{ headers: authHeader()})
  }
}

export default new TypeService();