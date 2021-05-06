import axios from 'axios';
import authHeader from './auth-header';
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

class PostService {
  getPost() {
    return axios.get('post',{ headers: authHeader() });
  }
  putPost(id,data) {
    console.log(data)
    return axios.put(`post/${id}`,data,{ headers: authHeader()})
  }
  deletePost(id){
    return axios.delete(`post/${id}`,{ headers: authHeader()})
  }
  postPost(body){
   return axios.post(`post`, body,{ headers: authHeader()})
  }
  getOnePost(id){
    return axios.get(`post/${id}`,{ headers: authHeader()})
  }
}

export default new PostService();