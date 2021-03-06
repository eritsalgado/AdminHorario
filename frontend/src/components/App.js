import React, { useState, useEffect } from 'react';
import { BrowserRouter, Switch, Route } from 'react-router-dom';

import Layout from './Layout';
import Home from '../pages/Home';
import Login from '../pages/Login';
import setAuthToken from '../utils/setAuthToken';
import jwt from 'jsonwebtoken'
// import Badges from '../pages/Badges';
// import BadgeNew from '../pages/BadgeNew';
// import NotFound from '../pages/NotFound';

const App = () => {
  const [usuario, actualizarUsuario] = useState({
      id: '',
      no_empleado: '',
      rol:'',
      nombre:''
  })

  useEffect(() => {
    if(localStorage.userToken){
      const token = localStorage.userToken
      setAuthToken(token)
      const {id, no_empleado, rol, nombre} = jwt.decode(token)
      actualizarUsuario({id, no_empleado, rol, nombre})
      
    }
  }, [])

  return (
    <BrowserRouter>
      <Layout>
        <Switch>
        <Route exact path="/" component={Home} />
        <Route exact path="/login" component={Login} />
          {/* <Route exact path="/badges" component={Badges} />
          <Route exact path="/badges/new" component={BadgeNew} />
          <Route component={NotFound} /> */}
        </Switch>
      </Layout>
    </BrowserRouter>
  );
}

export default App;
