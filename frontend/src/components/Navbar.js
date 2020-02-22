import React from 'react';
import { Link } from 'react-router-dom';

import './styles/Navbar.css';
// import logo from '../images/logo.svg';

class Navbar extends React.Component {
  render() {
    return (
      <div className="Navbar navbar justify-content-between">
        <div className="container-fluid">
          <Link className="Navbar__brand" to="/">
            {/* <img className="Navbar__brand-logo" src={logo} alt="Logo" /> */}
            <span className="font-weight-light">Sistema de control de Horario</span>
            <span className="font-weight-bold"></span>
          </Link>
          <Link className="Navbar__brand" to="/login">
            {/* <img className="Navbar__brand-logo" src={logo} alt="Logo" /> */}
            <span className="font-weight-light">Iniciar Sesión</span>
            <span className="font-weight-bold"></span>
          </Link>
        </div>
      </div>
    );
  }
}

export default Navbar;
