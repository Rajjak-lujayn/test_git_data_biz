import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Home from "./Home";
function App() {
    console.log("Tesing");
    return (
        <Router basename="/jobdata">
            <Routes>
                <Route path='/' element={<Home />} />
            </Routes>
        </Router>
    );
}

export default App;