import React, {useContext} from "react"
import AppContext from "../contexts/AppContext";
import MenuContext from "../contexts/MenuContext";

const TopBar = () => {
    const {pageTitle} = useContext(AppContext)
    const {isOpen, setIsOpen} = useContext(MenuContext)

    return (
        <header className={"top-bar"}>
            <div className="top-bar-left">
                <h1>
                    {pageTitle}
                </h1>
            </div>
            <div className="top-bar-right">
              <span className="menu__toggle icon-top" onClick={() => {
                  setIsOpen(!isOpen)
              }}>
                  {isOpen ? <i className="fi-x"/> : <i className="fi-list"/>}
              </span>
            </div>
        </header>
    )
}

export default TopBar
