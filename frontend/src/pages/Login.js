import React from 'react';

import './styles/Home.css';
import LoginForm from '../components/LoginForm';

const Login = () => {
    return (
      <div className="Home">
        <div className="container">
          <div className="row">
            <div className="Home__col col-12 col-md-4">

              <h1 className="text-sm-right text-center">Sistema de Administración de Horarios</h1>
            </div>

            <div className="Home__col col-md-8">
              <LoginForm/>
            </div>
          </div>
        </div>
      </div>
    );
}

export default Login;