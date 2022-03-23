import {useContext, useState, useEffect, Fragment} from 'react'
import AppContext from "../contexts/AppContext";
import MenuContext from "../contexts/MenuContext";
import {Navigation, Pagination} from 'swiper';
import {Swiper, SwiperSlide} from 'swiper/react';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import {Link} from "react-router-dom";
import {useLocation} from "react-router-dom";
import classNames from "classnames";
import uniqid from 'uniqid';
import {Button, ButtonGroup, Colors} from "react-foundation";

const Menu = () => {
    const [swiperKey, setswiperKey] = useState(uniqid());

    const {
        magicLink
    } = useContext(AppContext)

    const {
        close,
        isOpen,
        meetings,
        total,
        pages
    } = useContext(MenuContext)

    const location = useLocation()

    useEffect(() => {
        setswiperKey(uniqid())
    }, [isOpen])

    return (
        <Fragment>
            { isOpen ? <div className={"menu__backdrop"} onClick={close}/> : ''}
            <nav id={'menu'}
                 className={
                     classNames(
                         isOpen ? 'menu--open' : '',
                         'shadow'
                     )}>
                <h1>{magicLink.translations.title}</h1>
                {
                    <Swiper
                        key={swiperKey}
                        spaceBetween={50}
                        slidesPerView={1}
                        navigation={{
                            nextEl: '.menu__next',
                            prevEl: '.menu__prev',
                        }}
                        pagination={{
                            el: '.menu__pagination',
                            clickable: true
                        }}
                        modules={[
                            Navigation,
                            Pagination
                        ]}
                    >
                        {
                            meetings.map((page, idx) => (
                                    <SwiperSlide key={`menu-page-${idx}`}>
                                        {
                                            page.map((meeting) => (
                                                <Link
                                                    key={`menu-meeting-${meeting["ID"]}`}
                                                    to={{
                                                        pathname: "/meetings/" + meeting["ID"]
                                                    }}
                                                >
                                                    <div className={classNames(
                                                        "menu__item",
                                                        location.pathname === "/meetings/" + meeting["ID"] ? 'menu__item--active' : false
                                                    )}>
                                                        <strong className={"menu__item-title"}>
                                                            {meeting.name}
                                                        </strong>
                                                        <div className={"menu__item-date"}>
                                                            {meeting.date.formatted}
                                                        </div>
                                                    </div>
                                                </Link>
                                            ))
                                        }
                                    </SwiperSlide>
                                )
                            )
                        }
                        <div slot="container-end"
                             className={"menu-controls"}>
                            <div className={"menu__pagination"}/>
                            <ButtonGroup isExpanded
                                         className={"menu__buttons"}>
                                <Button color={Colors.PRIMARY}
                                        className={"menu__prev"}> <i className="icon fi-arrow-left"/>
                                    <span>{magicLink.translations.previous}</span></Button>
                                <Button color={Colors.PRIMARY}
                                        className={"menu__next"}><span>{magicLink.translations.next}</span>
                                    <i className="icon fi-arrow-right"/> </Button>
                            </ButtonGroup>
                            <ButtonGroup isExpanded>
                                <Button color={Colors.SUCCESS} className={'shadow'}> {magicLink.translations.create} </Button>
                            </ButtonGroup>
                            <p className={"margin-top-1 margin-bottom-0"}>
                                <small>
                                    {magicLink.translations.learn_more_about} <a href={"https://zume.training/3-3-group-meeting-pattern/"}
                                                                                 title={`${magicLink.translations.learn_more_about} ${magicLink.translations.title}`}
                                                                                 target="_blank">{magicLink.translations.title}</a> {magicLink.translations.on_zume}.
                                </small>
                            </p>
                            <p className={"margin-bottom-0"}>
                                <small>
                                    {magicLink.translations.powered_by} <a href={"https://disciple.tools/"}
                                                                           title={`${magicLink.translations.powered_by} ${magicLink.translations.disciple_tools}`}
                                                                           target="_blank">{magicLink.translations.disciple_tools}</a>.
                                </small>
                            </p>
                        </div>
                    </Swiper>
                }
            </nav>
        </Fragment>
    )
}

export default Menu
