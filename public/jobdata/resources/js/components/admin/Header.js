import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { Link, useLocation } from 'react-router-dom';
// import logo from '/images/bizprospex_logo.png';
import { Url, PubliUrl } from "../../Config";
const Header = () => {
    const [isAdmin, is_admin] = useState(false);

    useEffect(async () => {
        axios.get(`${PubliUrl}/api/isAdmin`).then(res => {
            is_admin(res.data.isAdmin);
        });
    }, [''])

    return (
        <div id="left-sidebar">
            <div className="top_bar">
                <div className='contact-us_wrap'>
                    <div className='email'>
                        <a href="emailto:murtaza@bizprospex.com">
                            <i className="fa-solid fa-envelope"></i> murtaza@bizprospex.com
                        </a>
                    </div>

                    <ul className="social_item">
                        <li>
                            <a href="#"><i className="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="#"><i className="fa-brands fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i className="fa-brands fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>

            </div>
            <div className="body_part-content">
                <div className="brand_wrap">
                    <a className='bizprospex_logo' href={Url}>
                        <img src={`${PubliUrl}/images/bizprospex_logo.png`} alt="logo"></img>
                    </a>
                </div>
                <div className="filter_section" onSubmit={e => e.preventDefault()}>
                    <div className="filter_wrapper">
                        <div className="dashboard-navigation">
                            {
                                isAdmin ?
                                    <>
                                    <ul>
                                        <li><Link className="navbar-items" to="/admin">Dashboard</Link></li>
                                        <li><Link className="navbar-items" to="/admin/file-upload">File Upload</Link></li>
                                        <li><Link className="navbar-items" to="/admin/tracking">Tracking</Link></li>
                                    </ul>
                                        
                                        
                                    </>
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className="copyright_content">
                <p>© 2022 bizb2b. all rights Reserved. powered by bizb2b</p>
            </div>
        </div>
    )
}

export default Header;