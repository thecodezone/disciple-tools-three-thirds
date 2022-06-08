import {Link} from "react-router-dom";
import classNames from "classnames";
import {Button, ButtonGroup, Colors} from "react-foundation";
import React, {useContext} from "react";
import Form from "../forms/Form";
import FieldGroup from "../forms/FieldGroup";
import AppContext from "../../contexts/AppContext";
import MeetingsContext from "../../contexts/MeetingsContext";
import MeetingsFilterObserver from "./MeetingsFilterObserver";
import SelectField from '../forms/SelectField'
import Alert from "../layout/Alert";

/**
 * The meetings search screen
 * @returns {JSX.Element}
 * @constructor
 */
const Meetings = () => {
    /**
     * The magic link data from the server
     * @see /magic-link/magic-link.php#localazations()
     */
    const {
        magicLink,
    } = useContext(AppContext)

    /**
     * @see https://reactjs.org/docs/context.html
     */
    const {
        meta,
        meetings,
        groups,
        search
    } = useContext(MeetingsContext)

    /**
     * Fetch the next page of meetings from the server
     */
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
                            inputClassNames={"margin-bottom-0"}
                        />
                    </div>
                    <div className="cell small-6">
                        <FieldGroup as="select"
                                    name="filter"
                                    options={[
                                        {value: '', label: magicLink.translations.all},
                                        {value: 'NO_GROUP', label: magicLink.translations.no_group},
                                        ...groups.map(group => ({value: group.ID, label: group.title})),
                                    ]}
                                    component={SelectField}
                        />
                    </div>
                </div>
            </Form>
            <div className={"row"}>
                <div className={"columns"}>
                    {meta.total ? <Alert theme={"success"}
                                         size="small"
                                         className={"font-italic margin-top-1"}>{meta.total} {meta.total > 1 ? magicLink.translations.meetings_found : magicLink.translations.meeting_found}.</Alert> : ''}
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
                            "menu__item menu__item--border-left",
                            location.pathname === "/meetings/" + meeting["ID"] ? 'menu__item--active' : false
                        )}>
                            <strong className={"menu__item-title"}>
                                {meeting.name}
                            </strong>
                            {
                                (meeting.date) ?  <div className={"menu__item-date"}>
                                    {meeting.date.formatted}
                                </div> : ''
                            }
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
