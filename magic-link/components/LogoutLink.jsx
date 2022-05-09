import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";
import classNames from "classnames";

const LogoutButton = ({className}) => {
    const {magicLink} = useContext(AppContext)

    return  <a
        className={classNames("logout-button clear alert button", className)}
        href={magicLink.logout_url}
    >
        <i className="icon fa-solid fa-arrow-right-from-bracket"/> {magicLink.translations.logout}
    </a>
}

export default LogoutButton
