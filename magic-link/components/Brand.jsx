import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";
import classNames from "classnames";
const Brand = ({className}) => {
    const {magicLink} = useContext(AppContext)

    return (
        <div className={classNames("brand", className)}>
            <img src={magicLink.files.icon} title={magicLink.translations.title} width={75} className={"brand__icon"}/> <h1 className={"brand__heading"}>{magicLink.translations.title}</h1>
        </div>
    )
}

export default Brand
