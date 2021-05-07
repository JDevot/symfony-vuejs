import axios from 'axios';
import authHeader from './auth-header';
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

class UserService {
  getUser() {
    return axios.get('user',{ headers: authHeader() });
  }
  putUser(id,data) {
    console.log(data)
    return axios.put(`user/${id}`,data,{ headers: authHeader()})
  }
  deleteUser(id){
    return axios.delete(`user/${id}`,{ headers: authHeader()})
  }
  postUser(body){
   return axios.post(`user`, body,{ headers: authHeader()})
  }
  getOneUser(id){
    return axios.get(`user/${id}`,{ headers: authHeader()})
  }
}

export default new UserService();