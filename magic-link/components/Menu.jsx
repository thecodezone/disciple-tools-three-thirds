import React, {useContext, Fragment, useEffect} from 'react'
import AppContext from "../contexts/AppContext";
import MenuContext from "../contexts/MenuContext";
import {Link, useLocation} from "react-router-dom";
import classNames from "classnames";
import LogoutButton from "./LogoutLink";
import Brand from "./Brand";

const Menu = () => {
    const location = useLocation()

    const {
        magicLink
    } = useContext(AppContext)

    const {
        close,
        isOpen
    } = useContext(MenuContext)

    return (
        <Fragment>
            { isOpen ? <div className={"menu__backdrop"} onClick={close}/> : ''}
            <nav id={'menu'}
                 className={
                     classNames(
                         isOpen ? 'menu--open' : '',
                         'shadow'
                     )}>
                <div className={"menu__content"}>
                    <Brand />

                    <div className={"menu__items-wrapper"}>
                        <div className={"menu__items"}>
                            <Link className={classNames("menu__item menu__item--border-bottom", location.pathname === "/" ? 'menu__item--active' : false)} to={"/"}>
                                <strong className={"menu__item-title"}>Go to Dashboard</strong>
                                <div className={"menu__item-icon"}>
                                    <span className="icon fa-solid fa-border-all" />
                                </div>
                            </Link>

                            <Link className={classNames("menu__item menu__item--border-bottom", location.pathname === "/meetings/create" ? 'menu__item--active' : false)} to={"/meetings/create"}>
                                <strong className={"menu__item-title"}>Create Meeting</strong>
                                <div className={"menu__item-icon"}>
                                    <span className="icon fa-regular fa-calendar-days" />
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <div className={"menu__footer"}>
                    <LogoutButton className={"margin-bottom-2"}/>

                    <p className={"margin-bottom-0"}>
                        <small>
                            {magicLink.translations.powered_by} <a href={"https://disciple.tools/"}
                                                                   title={`${magicLink.translations.powered_by} ${magicLink.translations.disciple_tools}`}
                                                                   target="_blank">{magicLink.translations.disciple_tools}</a>.
                        </small>
                    </p>

                    <p className={"margin-top-1 margin-bottom-0"}>
                        <small>
                            {magicLink.translations.learn_more_about} <a href={"https://zume.training/3-3-group-meeting-pattern/"}
                                                                         title={`${magicLink.translations.learn_more_about} ${magicLink.translations.title}`}
                                                                         target="_blank">{magicLink.translations.title}</a> {magicLink.translations.on_zume}.
                        </small>
                    </p>
                </div>
            </nav>
        </Fragment>
    )
}

export default Menu
