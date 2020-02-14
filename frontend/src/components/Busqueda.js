import React, {Fragment, useState} from 'react'
import ProfileCard from './ProfileCard';

const Busqueda = ({usuarios, horarios}) => {
    const {nombre} = usuarios

    const [busqueda, actualizarBusqueda] = useState({
        nombre:''
    })

    const [registros, agregarRegistro] = useState({
        id:'',
        usuario_id:'',
        hora_ingreso:'',
        hora_descanso:'',
        hora_regreso:'',
        hora_salida:'',
        fecha:'',
        notas:''
    })

    const actualizarRegistros = (id,mod) =>{
        console.log(id)
    }

    const actualizarState = e => {
        actualizarBusqueda({
            ...busqueda,
            [e.target.name]: e.target.value
        })        
    }

    let filtro = usuarios.filter(
        (usuario) => {
            return usuario.nombre.toLowerCase().indexOf(busqueda.nombre.toLocaleLowerCase()) !== -1
        }
    );

    return (
        <Fragment>
        <form>
            <div className="row justify-content-center">
                <div className="col-4">
                    <input 
                        type="text"
                        className="form-control"
                        placeholder="Introduce tu nombre"
                        name="nombre"
                        onChange={actualizarState}
                        value={nombre}
                    />
                </div>
                <div className="col-1">
                    <input 
                        type="submit"
                        className="btn btn-primary"
                        value="Buscar"
                    />
                </div>
            </div>
        </form>

        <div className="row justify-content-center mt-5">
        <div className="col-md-12">
          {filtro.map(usuario => {
            return (
              <ProfileCard 
                key={usuario.id}
                usuario={usuario}
                actualizarRegistros={actualizarRegistros}
              />
            );
          })}
        </div>
    </div>
    </Fragment>
    )
}

export default Busqueda