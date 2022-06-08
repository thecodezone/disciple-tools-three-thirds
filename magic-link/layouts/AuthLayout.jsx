import React from "react";

/**
 * Layout for the auth screens
 * @param children
 * @returns {JSX.Element}
 * @constructor
 */
const AuthLayout = ({children}) => {
    return (<main className="container auth">
        {children}
    </main>)
}

export default AuthLayout
