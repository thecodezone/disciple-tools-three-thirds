import {Link} from "react-router-dom";
import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";
import {logout} from '../src/api'

const LogoutButton = () => {
    const {magicLink} = useContext(AppContext)

    return  <a
        className="logout-button clear alert button"
        href={magicLink.logout_url}
    >
        <i className="icon fa-solid fa-arrow-right-from-bracket"/> {magicLink.translations.logout}
    </a>
}

export default LogoutButton
