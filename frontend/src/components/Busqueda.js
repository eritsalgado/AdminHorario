import React from 'react'

const Busqueda = () => {
    return (
        <form>
            <div className="row">
                <div className="col-8">
                    <input 
                        type="text"
                        className="form-control"
                        placeholder="Introduce tu nombre"
                    />
                </div>
                <div className="col-4">
                    <input 
                        type="submit"
                        className="btn btn-primary"
                        value="Buscar"
                    />
                </div>
            </div>
        </form>
    )
}

export default Busqueda
