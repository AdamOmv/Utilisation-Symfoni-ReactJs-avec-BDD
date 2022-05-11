import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import TabDonnees from "./pages/tabDonnees.jsx";
import TabPossessions from "./pages/tabPossessions.jsx";


const App = () => {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/home" element={<TabDonnees />} />
                <Route path="/possession" element={<TabPossessions />} />
            </Routes>
        </BrowserRouter>
    );
};

export default App;