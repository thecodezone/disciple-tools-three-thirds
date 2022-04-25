import {useContext, Fragment} from 'react'
import AppContext from "../contexts/AppContext";
import MenuContext from "../contexts/MenuContext";
import {useLocation} from "react-router-dom";
import classNames from "classnames";
import LogoutButton from "./LogoutLink";

const Menu = () => {
    const {
        magicLink
    } = useContext(AppContext)

    const {
        close,
        isOpen
    } = useContext(MenuContext)

    const location = useLocation()

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
                    <h1>{magicLink.translations.title}</h1>

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

                <div className={"menu__footer"}>
                    <LogoutButton />
                </div>
            </nav>
        </Fragment>
    )
}

export default Menu
