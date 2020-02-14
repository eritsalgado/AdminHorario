import React, {useEffect, useState} from 'react';
import axios from 'axios';

import Busqueda from '../components/Busqueda';

import './styles/Badges.css';
// import confLogo from '../images/badge-header.svg';
// import BadgesList from '../components/BadgesList';


const Home = () => {

  const [usuarios,guardarUsuario] = useState([])
  const [horarios,guardarHorario] = useState([])

  useEffect(()=>{
    const obtenerUsuarios = async ()=> {
      const url = `http://marssa.com.devel/api/usuarios`;
      const usuarios = await axios.get(url);
      let datausuarios = usuarios.data.empleados;
      guardarUsuario(datausuarios)
    }
    const obtenerAsistencias = async ()=> {
      const url_horario = `http://marssa.com.devel/api/horario`;
      const horarios = await axios.get(url_horario);
      let datahorarios = horarios.data.registro;

      guardarHorario(datahorarios)
    }
    obtenerUsuarios()
    obtenerAsistencias()
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

          <div className="row">
              <div className="col-md-12 text-center">
                  <Busqueda
                    usuarios = {usuarios}
                    horarios = {horarios}
                  />
              </div>
          </div>

          

        </div>
        
        
      </React.Fragment>
    )
}



export default Home;