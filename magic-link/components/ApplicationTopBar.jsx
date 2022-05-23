import React, {useContext, Fragment} from "react"
import AppContext from "../contexts/AppContext";
import {Link} from "react-router-dom";
import MenuContext from "../contexts/MenuContext";
import TopBar from './TopBar'
import {BreadcrumbItem, Breadcrumbs} from "react-foundation";
import classNames from "classnames";

const ApplicationTopBar = ({title = "", titleTo, titleIcon, iconLabel = "", breadcrumbs = []}) => {
    const {isOpen, setIsOpen} = useContext(MenuContext)

    const heading = <h1 className={"top-bar__heading text-black"}>
        {title}
    </h1>

    const Left = <div>
        {breadcrumbs.length ? <nav aria-label="You are here:"
                                   role="navigation">
            <Breadcrumbs className={"margin-bottom-0"}>
                {breadcrumbs.map(({link, label}, idx) => <BreadcrumbItem key={`breadcrumb-${idx}`}>
                    {link ? <Link to={link}>{label}</Link> : label}
                </BreadcrumbItem>)}
            </Breadcrumbs>
        </nav> : ''}
        {titleTo ? <Link to={titleTo} className={"top-bar__heading-link"}>
            <div className={"grid-x"}>
                {heading}
                {titleIcon ? <div className={"top-bar__heading-icon"}>
                    <span className={classNames('icon', 'text-primary', titleIcon)}/>
                    <span className={"small uppercase"}>{iconLabel}</span>
                </div> : ""}
            </div>

        </Link> : heading}
    </div>

    const Right = <span className="menu__toggle icon-top"
                        onClick={() => {
                            setIsOpen(!isOpen)
                        }}>
      {isOpen ? <i className="fi-x"/> : <i className="fi-list"/>}
  </span>

    return <TopBar
        right={Right}
        left={Left}
    />
}

export default ApplicationTopBar
