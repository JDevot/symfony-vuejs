import axios from 'axios';
import authHeader from './auth-header';
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

class CategorieService {
    getCategorie() {
        return axios.get('categories', {
            headers: authHeader()
        });
    }
    putCategorie(id, data) {
        return axios.put(`categories/${id}`, data, {
            headers: authHeader()
        })
    }
    deletePost(id) {
        return axios.delete(`categories/${id}`, {
            headers: authHeader()
        })
    }
    categoriePost(body) {
        return axios.post(`categories`, body, {
            headers: authHeader()
        })
    }
    getOnePost(id) {
        return axios.get(`categories/${id}`, {
            headers: authHeader()
        })
    }
}

export default new CategorieService();