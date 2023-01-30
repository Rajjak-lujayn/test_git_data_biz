import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { Url, PubliUrl } from "../../Config";

function Form(props) {
    return (
        <div className='bizpros-form-section'>
            <div className='container'>
                <div className='form_wrapper'>
                    <h3>Signup</h3>
                    <form action={`${PubliUrl}/adminRegistration`} method='POST'>
                        <input type="hidden" name='_token' value={props.csrfToken} />
                        <div className="row-field">
                            <label htmlFor="userFullName" className="form-label">Name</label>
                            <input type="text" name="name" className="form-control" id="userFullName" />
                        </div>
                        <div className="row-field">
                            <label htmlFor="userEmail" className="form-label">Email</label>
                            <input type="email" name="email" className="form-control" id="userEmail" />
                        </div>
                        <div className="row-field">
                            <label htmlFor="userPassword" className="form-label">Password</label>
                            <input type="password" name="password" className="form-control" id="userPassword" />
                        </div>
                        <div className='button_wrapper'>
                            <button type="submit" className="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}

const Signup = () => {
    const [csrfToken, setCsrfToken] = useState('');
    useEffect(() => {

        axios.get(`${PubliUrl}/get-csrf-token`).then(res => {
            setCsrfToken(res.data);
        });
    }, ['']);

    return (
        <>
            <Form csrfToken={csrfToken}></Form>
        </>
    )
}

export default Signup