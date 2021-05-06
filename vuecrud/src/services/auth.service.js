import axios from 'axios';

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

class AuthService {
  login(user) {
    return axios
      .post('login_check', {
        username: user.username,
        password: user.password
      })
      .then(response => {
        if (response.data.token) {
          localStorage.setItem('user', JSON.stringify(response.data));
        }

        return response.data;
      });
  }

  logout() {
    localStorage.removeItem('user');
  }

  register(user) {
    return axios.post('register', {
      email: user.username,
      password: user.password
    });
  }
}

export default new AuthService();