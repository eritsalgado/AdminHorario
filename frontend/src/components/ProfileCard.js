import React from 'react';

import './styles/Badge.css';

const Badge = ({usuario}) => {

    const { id,nombre,apellido,rol } = usuario;
    

    return (
      <div className="Badge mt-4 mb-4">
        <div className="Badge__header">
            {/* Imagen de header */}
        </div>

        <div className="Badge__section-name">
          <img
            className="Badge__avatar"
            src='https://es.theepochtimes.com/assets/uploads/2019/01/Boo-ppal.jpg'
            alt="Avatar"
          />
          <h1>
              {nombre} {apellido}
          </h1>
        </div>

        <div className="Badge__section-info">
            <h3>{rol}</h3>
          {/* <h3>{this.props.jobTitle}</h3>
          <div>@{this.props.twitter}</div> */}
        </div>

        <div className="Badge__footer">
            <button className='btn btn-primary mr-2'>ENTRADA</button>
            <button className='btn btn-info mr-2'>INICIO DE COMIDA</button>
            <button className='btn btn-warning mr-2'>TERMINO DE COMIDA</button>
            <button className='btn btn-danger mr-2'>SALIDA</button>
        </div>
      </div>
    );
}

export default Badge;
