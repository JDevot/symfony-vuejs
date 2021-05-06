import axios from 'axios';
import authHeader from './auth-header';

class EdlService {
  getEdl() {
    return axios.get('edl',{ headers: authHeader() });
  }
  putEdl(id,data) {
    return axios.put(`edl/${id}`,data,{ headers: authHeader()})
  }
  deleteEdl(id){
    return axios.delete(`edl/${id}`,{ headers: authHeader()})
  }
  postEdl(body){
   return axios.post(`edl`, body,{ headers: authHeader()})
  }
  getOneEdl(id){
    return axios.get(`edl/${id}`,{ headers: authHeader()})
  }
}

export default new EdlService();