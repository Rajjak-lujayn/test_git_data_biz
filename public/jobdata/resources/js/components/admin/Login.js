import React, { useEffect, useState } from 'react';
import { Url, PubliUrl } from "../../Config";

function Form(props) {
  return (
    <div className='bizpros-form-section'>
      <div className='container'>
        <div className='form_wrapper'>
          <h3>Login</h3>
          <form action={`${PubliUrl}/adminLogin`} method='post'>
            <input type='hidden' name='_token' value={props.csrfToken} />
            <div className="row-field">
              <label htmlFor="userEmail" className="form-label">Email address</label>
              <input type="email" name="email" className="form-control" id="userEmail" />
            </div>
            <div className="row-field">
              <label htmlFor="userPassword" className="form-label">Password</label>
              <input type="password" name="password" className="form-control" id="userPassword" />
            </div>
            <div className='button_wrapper'>
              <button type="submit" className="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

const Login = () => {
  const [csrfToken, setCsrfToken] = useState('');
  useEffect(() => {
    axios.get(`${PubliUrl}/get-csrf-token`).then(res => {
      setCsrfToken(res.data);
    });
  }, []);

  return (
    <>
      <Form csrfToken={csrfToken} />
    </>
  )
}

export default Login