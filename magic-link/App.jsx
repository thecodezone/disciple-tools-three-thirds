import React from 'react'
import NextMeeting from './pages/NextMeeting'
import ReactDom from 'react-dom'
import {HashRouter, Routes, Route} from "react-router-dom";
import Layout from "./components/Layout";

import {AppContextProvider} from "./contexts/AppContext";
import Meeting from "./pages/Meeting";

function App() {
    return (
        <HashRouter>
            <AppContextProvider>
                <Layout>
                    <Routes>
                        <Route path="/"
                               element={<NextMeeting/>}/>
                        <Route path="/meetings/:id"
                               element={<Meeting/>}/>
                        <Route
                            path="*"
                            element={
                                <main style={{ padding: "1rem" }}>
                                    <h1>Page not found.</h1>
                                    <a href={magicLink.baseName}>Return home.</a>
                                </main>
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
