import React, {useState} from 'react'
import ReactDom from 'react-dom'
import {HashRouter, Routes, Route, useParams} from "react-router-dom";
import ApplicationLayout from "./layouts/ApplicationLayout";
import {AppContextProvider} from "./contexts/AppContext";
import Meeting from "./pages/Meeting";
import NotFound from './pages/NotFound'
import Dashboard from "./pages/Dashboard";
import {MeetingContextProvider} from "./contexts/MeetingContext";

function App() {
    let {id} = useParams();

    return (
        <HashRouter>
            <AppContextProvider>
                <ApplicationLayout>
                    <Routes>
                        <Route path="/"
                               element={<Dashboard/>}/>
                        <Route path="/meetings/:id"
                               element={<MeetingContextProvider id={id}><Meeting/></MeetingContextProvider>}/>
                        <Route
                            path="*"
                            element={
                                <NotFound/>
                            }
                        />
                    </Routes>
                </ApplicationLayout>
            </AppContextProvider>
        </HashRouter>
    );


}

ReactDom.render(
    <App/>,
    document.getElementById('app')
);
