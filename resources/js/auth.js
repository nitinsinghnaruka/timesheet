class Auth {
  /**
   * Store auth data to local storage.
   * 
   * @param {*} token
   * @param {*} user
   */
  store (token, user) {
    // Store token
    localStorage.setItem('token', token);
    //------------

    // Store user
    localStorage.setItem('user', JSON.stringify(user));
    //-----------
  }

  /**
   * Clear auth data from local storage.
   */
  clear () {
    // Remove token
    localStorage.removeItem('token');
    //-------------

    // Remove user
    localStorage.removeItem('user');
    //------------
  }
}

export default Auth;
