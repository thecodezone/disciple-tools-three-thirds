import {Navigation, Pagination} from "swiper";
import {Link} from "react-router-dom";
import classNames from "classnames";
import {Button, ButtonGroup, Colors} from "react-foundation";
import React, {Fragment, useContext, useState} from "react";
import {Swiper, SwiperSlide} from "swiper/react";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import Form from "./Form";
import FieldGroup from "./FieldGroup";
import AppContext from "../contexts/AppContext";
import MeetingsContext from "../contexts/MeetingsContext";
import MeetingsFilterObserver from "./MeetingsFilterObserver";

const Meetings = () => {
    const {
        magicLink,
    } = useContext(AppContext)
    const {
        total,
        meetings,
        groups,
        search,
        group,
    } = useContext(MeetingsContext)

    return (
        <div className={"meetings"}>
            <Form
                initialValues={{group, search}}
            >
                <MeetingsFilterObserver/>
                <div className="row">
                    <div className="columns small-6">
                        <FieldGroup
                            type="text"
                            name="search"
                            placeholder={"Search"}
                        />
                    </div>
                    <div className="columns small-6">
                        <FieldGroup as="select"
                                    name="group">
                            <option value="">{magicLink.translations.all}</option>
                            <option value="none">{magicLink.translations.no_group}</option>
                            {
                                groups.map(group => <option value={group.ID}
                                                            key={`group-option-${group.ID}`}>{group.title}</option>)
                            }
                        </FieldGroup>
                    </div>
                </div>
            </Form>
            <div className={"row"}>
                <div className={"columns"}>
                    {total ? <p className={"text-small font-italic text-secondary"}>
                        {total} {total > 1 ? magicLink.translations.meetings_found : magicLink.translations.meeting_found}.
                    </p> : <br/>}
                </div>
            </div>

            {
                <Swiper
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
                    </div>
                </Swiper>
            }

            <ButtonGroup isExpanded>
                <Button color={Colors.SUCCESS}
                        className={'shadow'}> {magicLink.translations.create} </Button>
            </ButtonGroup>
        </div>
    )
}

export default Meetings
