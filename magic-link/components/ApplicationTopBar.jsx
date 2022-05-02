import React, {useContext, useMemo} from "react"
import AppContext from "../contexts/AppContext";
import {Link} from "react-router-dom";
import MenuContext from "../contexts/MenuContext";
import TopBar from './TopBar'
import {BreadcrumbItem, Breadcrumbs} from "react-foundation";

const ApplicationTopBar = ({title = "", breadcrumbs = []}) => {
    const {isOpen, setIsOpen} = useContext(MenuContext)

    const Left = <div>
        {breadcrumbs.length ? <nav aria-label="You are here:" role="navigation">
            <Breadcrumbs className={"margin-bottom-0"}>
                {breadcrumbs.map(({link, label}, idx) => <BreadcrumbItem key={`breadcrumb-${idx}`}>
                    {link ? <Link to={link}>{label}</Link> : label}
                </BreadcrumbItem>)}
            </Breadcrumbs>
        </nav> : ''}
        <h1>
            {title}
        </h1>
    </div>

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
