import React, {useState} from 'react'
import NextMeeting from './pages/NextMeeting'
import ReactDom from 'react-dom'
import {HashRouter, Routes, Route} from "react-router-dom";
import ApplicationLayout from "./layouts/ApplicationLayout";
import {AppContextProvider} from "./contexts/AppContext";
import Meeting from "./pages/Meeting";
import Login from "./pages/Login";
import NotFound from './pages/NotFound'
import Layout from "./layouts/Layout";
import CreateAccount from './pages/CreateAccount'

function App() {
    const [user] = useState(JSON.parse(magicLink.user))

    //Logged In
    if (user.ID) {
        return (
            <HashRouter>
                <AppContextProvider>
                    <ApplicationLayout>
                        <Routes>
                            <Route path="/"
                                   element={<NextMeeting/>}/>
                            <Route path="/meetings/:id"
                                   element={<Meeting/>}/>
                            <Route
                                path="*"
                                element={
                                    <NotFound />
                                }
                            />
                        </Routes>
                    </ApplicationLayout>
                </AppContextProvider>
            </HashRouter>
        );
    }

    //Not logged in
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
