import React, {useEffect, useState} from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Busqueda from '../components/Busqueda';
import ProfileCard from '../components/ProfileCard';

import './styles/Badges.css';
// import confLogo from '../images/badge-header.svg';
// import BadgesList from '../components/BadgesList';


const Home = () => {

  const [usuarios,guardarUsuario] = useState([])

  useEffect(()=>{
    const obtenerUsuarios = async ()=> {
      const url = `http://tu-link.com.devel/api/usuarios`;
      const usuarios = await axios.get(url);
      let datausuarios = usuarios.data.empleados;
      guardarUsuario(datausuarios)
    }
    obtenerUsuarios()
  },[])


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
        
        <div className="container">

          <div className="row justify-content-center">
              <div className="col-md-6">
                  <Busqueda/>
              </div>
          </div>

          <div className="row justify-content-center mt-5">
              <div className="col-md-9">
                {usuarios.map(usuario => {
                  return (
                    <ProfileCard 
                      key={usuario.id}
                      usuario={usuario}
                    />
                  );
                })}
              </div>
          </div>

        </div>
        
        
      </React.Fragment>
    )
}



export default Home;