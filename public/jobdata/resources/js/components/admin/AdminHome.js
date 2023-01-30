import React, { useState } from "react";
import { BrowserRouter as Router, Route, Routes, useLocation } from "react-router-dom";
import Login from "./Login";
import Dashboard from "./Dashboard";
import Signup from "./Signup";
import FileUpload from "./FileUpload";
import Header from './Header'
import Tracking from "./Tracking";

const AddHeader = ({ props }) => {
    const location = useLocation()
    let curretPageClass = location.pathname.split('/').at(-1);
    props.setCurrentPagheClass(curretPageClass);
    if (curretPageClass !== 'login' && curretPageClass !== 'signup') {
        return (
            <Header />
        )
    } else {
        return (<></>);
    }
}

function AdminHome() {

    const [curretPageClass, setCurrentPagheClass] = useState();

    return (

        <section id="datatable-dashboard" className={curretPageClass}>

            <Router basename="/jobdata/public">
                <AddHeader props={{ curretPageClass, setCurrentPagheClass }} />
                <Routes>
                    <Route path="/admin">
                        <Route index element={<Dashboard />} />
                        <Route path="file-upload" element={<FileUpload />} />
                        
                        <Route path="tracking" element={<Tracking />} />
                    </Route>
                    <Route path="login" element={<Login />} />
                    <Route path="signup" element={<Signup />} />
                </Routes>
            </Router>
        </section>
    );
}

export default AdminHome;