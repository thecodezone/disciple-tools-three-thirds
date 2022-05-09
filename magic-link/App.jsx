import React, {useState} from 'react'
import ReactDom from 'react-dom'
import {HashRouter, Routes, Route, useParams} from "react-router-dom";
import {AppContextProvider} from "./contexts/AppContext";
import Meeting from "./pages/Meeting";
import EditMeeting from "./pages/EditMeeting";
import NotFound from './pages/NotFound'
import Dashboard from "./pages/Dashboard";
import {MeetingContextProvider} from "./contexts/MeetingContext";
import { transitions, positions,types, Provider as AlertProvider } from 'react-alert'
import AlertTemplate from './components/ReactAlertTemplate'
import CreateMeeting from "./pages/CreateMeeting";

const alertOptions = {
    // you can also just use 'bottom center'
    position: positions.BOTTOM_RIGHT,
    timeout: 3000,
    offset: '10px',
    type: types.INFO,
    transition: transitions.SCALE
}

function App() {
    return (
        <HashRouter>
            <AppContextProvider>
                <AlertProvider template={AlertTemplate} {...alertOptions}>
                    <Routes>
                        <Route path="/"
                               element={<Dashboard/>}/>
                        <Route path="/meetings/create"
                               element={<CreateMeeting/>}/>
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
                </AlertProvider>
            </AppContextProvider>
        </HashRouter>
    );


}

ReactDom.render(
    <App/>,
    document.getElementById('app')
);
