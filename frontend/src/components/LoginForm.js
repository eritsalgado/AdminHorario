import React, {Fragment, useState} from 'react';
import axios from 'axios';
import setAuthToken from '../utils/setAuthToken'
import jwt from 'jsonwebtoken'

const LoginForm = () => {
    
    //Crear state de Login
    
    const [login, actualizarLogin] = useState({
        no_empleado: '',
        password: ''
    })
    const [ error, actualizarError ] = useState(false)
    const [ detallesError, actualizarDetallesError ] = useState({mensaje:''})
    
    const actualizarState = e => {
        actualizarLogin({
            ...login,
            [e.target.name]: e.target.value
        })
        
    }

    const submitLogin = async  e =>{
        e.preventDefault()

        if(no_empleado.trim() === '' || password.trim() === '' ){
            actualizarError(true)
            actualizarDetallesError({
                mensaje:'Todos los campos son obligatorios'
            })
            return
        }
        actualizarError(false)
        actualizarDetallesError({
            mensaje:''
        })

        actualizarLogin(login)  
        
        const {data} = await axios.post('http://marssa.com.devel/api/login', {
            json: JSON.stringify(login)
          })

        if(typeof(data) === 'string'){
            let token = data
            console.log(jwt.decode(token))
            localStorage.setItem("userToken", token);

            actualizarError(false)
            actualizarDetallesError({
                mensaje:''
            })
            setAuthToken(token)


        }else{
            actualizarError(true)
            actualizarDetallesError({
                mensaje:'El usuario o contraseña no son correctos'
            })
        }
        
    }

    const { no_empleado, password } = login

    return (
        <Fragment>
            
            {error ? <p className="alert alert-danger">{detallesError.mensaje}</p> : null}
            <form
                onSubmit={submitLogin}
            >

                <label 
                    htmlFor="no_empleado"
                    className="h3"
                >Número de empleado</label>
                <input 
                    type="number" 
                    name="no_empleado"
                    id="no_empleado"
                    className="form-control col-md-12"
                    onChange={actualizarState}
                    value={no_empleado}
                    autoFocus
                />

                <label 
                    htmlFor="password"
                    className="h3"
                >Password</label>
                <input 
                    type="password" 
                    name="password"
                    id="password"
                    className="form-control col-md-12"
                    onChange={actualizarState}
                    value={password}
                    />
                    <input 
                        type="submit"
                        value="Ingresar"
                        className="btn btn-primary mt-3 btn-lg btn-block col-12"
                    />
            </form>
        </Fragment>
      
    );
}

export default LoginForm;