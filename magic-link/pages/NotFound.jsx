import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";

const NotFound = () => {
    const {magicLink} = useContext(AppContext)
    return ( <main style={{ padding: "1rem" }}>
        <h1>{magicLink.translations.page_not_found}</h1>
        <a href={magicLink.baseName}>{magicLink.translations.return_home}</a>
    </main>)
}

export default NotFound
