import React, {useState} from 'react'
import ReactDom from 'react-dom'
import {HashRouter, Routes, Route} from "react-router-dom";
import {AppContextProvider} from "./contexts/AppContext";
import Login from "./pages/Login";
import NotFound from './pages/NotFound'
import Layout from "./layouts/Layout";
import CreateAccount from './pages/CreateAccount'

/**
 * The logged-out part of the magic link react app
 * @returns {JSX.Element}
 * @constructor
 */
function App() {
    return (
        <HashRouter>
            <AppContextProvider>
                <Layout>
                    <Routes>
                        <Route path="/"
                               element={<Login/>}/>
                        <Route path="/create-account"
                               element={<CreateAccount/>}/>
                        <Route
                            path="*"
                            element={
                                <NotFound />
                            }
                        />
                    </Routes>
                </Layout>
            </AppContextProvider>
        </HashRouter>
    );
}

ReactDom.render(
    <App/>,
    document.getElementById('app')
);
