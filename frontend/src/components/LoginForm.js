import React, {Fragment, useState} from 'react';

const LoginForm = () => {
    
    //Crear state de Login
    const [json, crearJson] = useState({
        json: ''
    })
    
    const [login, actualizarLogin] = useState({
        no_empleado: '',
        password: ''
    })
    const [ error, actualizarError ] = useState(false)
    
    const actualizarState = e => {
        actualizarLogin({
            ...login,
            [e.target.name]: e.target.value
        })
        crearJson({
            ...json,
            json: {
                ...login,
                [e.target.name]: e.target.value
            }
        })
        
    }

    const submitLogin = e =>{
        e.preventDefault()

        if(no_empleado.trim() === '' || password.trim() === '' ){
            actualizarError(true)
            return
        }
        actualizarError(false)
        actualizarLogin(login)  
        
        console.log(json);
        
    }

    const { no_empleado, password } = login

    return (
        <Fragment>
            
            {error ? <p className="alert alert-danger">Todos los campos son obligatorios</p> : null}
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