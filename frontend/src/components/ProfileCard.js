import React, {useState} from 'react';

import './styles/Badge.css';

const Badge = ({ usuario = [], actualizarRegistros }) => {
    const [botones, modificarBotones] = useState({
        entrada:'btn btn-primary mr-2',
        inicio_comida:'btn btn-info mr-2',
        termino_comida:'btn btn-warning mr-2',
        salida:'btn btn-danger mr-2'
    })

    const { entrada, inicio_comida,termino_comida,salida } = botones

    if (usuario === undefined) {
        usuario.id = ''
        usuario.nombre=''
        usuario.rol=''
        usuario.no_empleado=''
    }
    const { id,nombre,rol,no_empleado } = usuario;
    const crearRegistro = e =>{
      //Funcion que maneja el state, pasa la variable id actual 
      //al componente padre para poder crear un registro
      actualizarRegistros(id)
      
      //Uso este state para modificar el valor de los botones (se deberían bloquear cada que se usan)
      modificarBotones({
        ...botones,
        entrada:'btn btn-primary mr-2 disabled'
      })
  }

    return (
      <div className="Badge mt-4 mb-4">
        <div className="Badge__header">
          <h3 className="text-white">No. Empleado: {no_empleado}</h3>
        </div>

        <div className="Badge__section-name">
          <img
            className="Badge__avatar"
            src='https://es.theepochtimes.com/assets/uploads/2019/01/Boo-ppal.jpg'
            alt="Avatar"
          />
          <h1>
              {nombre}
          </h1>
        </div>

        <div className="Badge__section-info">
            <h3>{rol}</h3>
        </div>

        <div className="Badge__footer">
            <button className={entrada} onClick={crearRegistro} >ENTRADA</button>
            <button className={inicio_comida}>INICIO DE COMIDA</button>
            <button className={termino_comida}>TERMINO DE COMIDA</button>
            <button className={salida}>SALIDA</button>
        </div>
      </div>
    );
}

export default Badge;
