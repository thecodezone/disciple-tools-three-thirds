import {useContext, useState, useEffect} from 'react'
import AppContext from "../contexts/AppContext";
import MenuContext from "../contexts/MenuContext";
import { Navigation, Pagination } from 'swiper';
import {Swiper, SwiperSlide} from 'swiper/react';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import {Link} from "react-router-dom";
import { useLocation } from "react-router-dom";
import classNames from "classnames";
import uniqid from 'uniqid';

const Menu = () => {
    const [swiperKey, setswiperKey] = useState(uniqid());

    const {
        magicLink
    } = useContext(AppContext)

    const {
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
        <nav id={'menu'} className={isOpen ? 'menu--open' : ''}>
            <h1>{magicLink.translations.title}</h1>
            {
                <Swiper
                    key={swiperKey}
                    spaceBetween={50}
                    slidesPerView={1}
                    navigation
                    pagination={{ clickable: true }}
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
                                                )} >
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
                </Swiper>
            }
        </nav>

    )
}

export default Menu
