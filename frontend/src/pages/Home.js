import React from 'react';
import { Link } from 'react-router-dom';
import Busqueda from '../components/Busqueda'

import './styles/Badges.css';
// import confLogo from '../images/badge-header.svg';
// import BadgesList from '../components/BadgesList';


const Home = () => {
    return (
        <React.Fragment>
        <div className="Badges">
          <div className="Badges__hero">
            <div className="Badges__container">
              {/* <img
                className="Badges_conf-logo"
                src={confLogo}
                alt="Conf Logo"
              /> */}
            </div>
          </div>
        </div>
        
        <div className="row justify-content-center">
            <div className="col-md-6">
                <Busqueda/>
            </div>
        </div>
        
      </React.Fragment>
    )
}



export default Home;