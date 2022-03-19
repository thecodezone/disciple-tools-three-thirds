import React from 'react'
import NextMeeting from './pages/NextMeeting'
import ReactDom from 'react-dom'
import {BrowserRouter, Routes, Route} from "react-router-dom";

function App() {
  return (
    <BrowserRouter>
      <div>
        <h1>Hello, React Router!</h1>
        <Routes>
          <Route path="/"
                 element={<NextMeeting/>}/>
        </Routes>
      </div>
    </BrowserRouter>
  );
}

ReactDom.render(
  <App/>,
  document.getElementById('app')
);
