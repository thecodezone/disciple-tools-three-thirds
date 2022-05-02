import {Navigation, Pagination} from "swiper";
import {Link} from "react-router-dom";
import classNames from "classnames";
import {Button, ButtonGroup, Colors} from "react-foundation";
import React, {Fragment, useContext, useState} from "react";
import Form from "../forms/Form";
import FieldGroup from "../forms/FieldGroup";
import AppContext from "../../contexts/AppContext";
import MeetingsContext from "../../contexts/MeetingsContext";
import MeetingsFilterObserver from "./MeetingsFilterObserver";
import SelectField from '../forms/SelectField'

const Meetings = () => {
    const {
        magicLink,
    } = useContext(AppContext)
    const {
        meta,
        meetings,
        groups,
        search
    } = useContext(MeetingsContext)

    const loadMore = () => {
        search({
            q: meta.q,
            filter: meta.filter,
            paged: meta.paged + 1
        }, true)
    }

    return (
        <div className={"meetings"}>
            <Form
                initialValues={{
                    filter: '',
                    q: ''
                }}
            >
                <MeetingsFilterObserver/>
                <div className="grid-x grid-margin-x align-middle">
                    <div className="cell small-6">
                        <FieldGroup
                            type="text"
                            name="q"
                            placeholder={"Search"}
                        />
                    </div>
                    <div className="cell small-6">
                        <FieldGroup as="select"
                                    name="filter"
                                    options={[
                                        { value: '', label: magicLink.translations.all },
                                        { value: 'NO_GROUP', label: magicLink.translations.no_group },
                                        ...groups.map(group => ({ value: group.ID, label: group.title })),
                                    ]}
                                    component={SelectField}
                        >
                            <option value="">{magicLink.translations.all}</option>
                            <option value="NO_GROUP">{magicLink.translations.no_group}</option>
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
                    {meta.total ? <p className={"text-small font-italic text-secondary"}>
                        {meta.total} {meta.total > 1 ? magicLink.translations.meetings_found : magicLink.translations.meeting_found}.
                    </p> : <br/>}
                </div>
            </div>

            {
                meetings.map((meeting) => (
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

            {meta.total > meetings.length ? <ButtonGroup isExpanded>
                <Button onClick={loadMore}
                        color={Colors.SUCCESS}
                        className={'shadow'}> {magicLink.translations.load_more} </Button>
            </ButtonGroup> : ''}

        </div>
    )
}

export default Meetings
