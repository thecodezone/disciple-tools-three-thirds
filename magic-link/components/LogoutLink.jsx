import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";
import classNames from "classnames";

/**
 * The logout button.
 *
 * @param className
 * @returns {JSX.Element}
 * @constructor
 */
const LogoutButton = ({className}) => {
    /**
     * The magic link data from the server
     * @see /magic-link/magic-link.php#localazations()
     */
    const {magicLink} = useContext(AppContext)

    /**
     * Logs the user out when clicked by redirecting to the logout URL.
     */
    return  <a
        className={classNames("logout-button clear alert button", className)}
        href={magicLink.logout_url}
    >
        <i className="icon fa-solid fa-arrow-right-from-bracket"/> {magicLink.translations.logout}
    </a>
}

export default LogoutButton
