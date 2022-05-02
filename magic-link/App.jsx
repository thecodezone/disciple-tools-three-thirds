import React, {useState} from 'react'
import ReactDom from 'react-dom'
import {HashRouter, Routes, Route, useParams} from "react-router-dom";
import {AppContextProvider} from "./contexts/AppContext";
import Meeting from "./pages/Meeting";
import EditMeeting from "./pages/EditMeeting";
import NotFound from './pages/NotFound'
import Dashboard from "./pages/Dashboard";
import {MeetingContextProvider} from "./contexts/MeetingContext";

function App() {
    return (
        <HashRouter>
            <AppContextProvider>
                <Routes>
                    <Route path="/"
                           element={<Dashboard/>}/>
                    <Route path="/meetings/edit/:id"
                           element={<MeetingContextProvider><EditMeeting/></MeetingContextProvider>}/>
                    <Route path="/meetings/:id"
                           element={<MeetingContextProvider><Meeting/></MeetingContextProvider>}/>
                    <Route
                        path="*"
                        element={
                            <NotFound/>
                        }
                    />
                </Routes>
            </AppContextProvider>
        </HashRouter>
    );


}

ReactDom.render(
    <App/>,
    document.getElementById('app')
);
