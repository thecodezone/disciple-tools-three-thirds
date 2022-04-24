import React, {useContext, useMemo} from "react"
import AppContext from "../contexts/AppContext";
import MenuContext from "../contexts/MenuContext";
import TopBar from './TopBar'

const ApplicationTopBar = () => {
    const {pageTitle} = useContext(AppContext)
    const {isOpen, setIsOpen} = useContext(MenuContext)

    const Left = <h1>
        {pageTitle}
    </h1>

    const Right = <span className="menu__toggle icon-top" onClick={() => {
        setIsOpen(!isOpen)
    }}>
      {isOpen ? <i className="fi-x"/> : <i className="fi-list"/>}
  </span>

    return  <TopBar
        right={Right}
        left={Left}
    />
}

export default ApplicationTopBar
