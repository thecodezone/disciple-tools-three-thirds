import React, {Fragment, useContext, useEffect, useState} from 'react'
import MeetingContext from "../contexts/MeetingContext";
import MeetingTabs from "../components/meetings/MeetingTabs";
import Card from "../components/layout/cards/Card";
import {TabPanel, TabsContent} from "react-foundation";
import AppContext from "../contexts/AppContext";
import CardHeading from "../components/layout/cards/CardHeading";
import CardSection from "../components/layout/cards/CardSection";
import {useHtml} from "../src/helpers";
import Form from "../components/forms/Form";
import FieldGroup from "../components/forms/FieldGroup";
import TextAreaField from "../components/forms/TextAreaField";

const MeetingPage = () => {
    const {translations} = useContext(AppContext)
    const {meeting, tab, tabs, submission} = useContext(MeetingContext)
    const {LOOKING_BACK, LOOKING_UP, LOOKING_AHEAD} = tabs

    if (!meeting || !submission) {
        return null
    }


    return (
        <Form
            initialValues={{
                ...submission
            }}
        >
            {({values, isSubmitting, setFieldValue, setTouched, ...attrs}) => {

                return <Fragment>
                    <MeetingTabs/>
                    <main>
                        <div className={"container"}>
                            <TabsContent>
                                <TabPanel isActive={tab === LOOKING_BACK}>
                                    <Card>
                                        <CardHeading>
                                            <h2>{translations.description}</h2>
                                        </CardHeading>
                                        <CardSection>
                                            {meeting.three_thirds_looking_back_content}
                                        </CardSection>
                                    </Card>

                                    {
                                        (meeting.previous_meeting && (meeting.previous_meeting.three_thirds_looking_ahead_prayer_topics || meeting.previous_meeting.three_thirds_looking_ahead_applications))
                                            ? <Card>
                                                <CardHeading>
                                                    <div>
                                                        <strong>{translations.meeting_date}:</strong>
                                                    </div>
                                                    <div>
                                                        <strong>{meeting.previous_meeting.date?.formatted}</strong>
                                                    </div>
                                                </CardHeading>
                                                <CardSection>
                                                    {(meeting.previous_meeting.three_thirds_looking_ahead_prayer_topics)
                                                        ? <Fragment>
                                                            <h3>{translations.prayer_requests}</h3>
                                                            <p>
                                                                {meeting.previous_meeting.three_thirds_looking_ahead_prayer_topics}
                                                            </p>
                                                        </Fragment>
                                                        : ''}

                                                    {(meeting.previous_meeting.three_thirds_looking_ahead_applications)
                                                        ? <Fragment>
                                                            <h3>{translations.application}</h3>
                                                            <p>
                                                                {meeting.previous_meeting.three_thirds_looking_ahead_applications}
                                                            </p>
                                                        </Fragment>
                                                        : ''}
                                                </CardSection>
                                            </Card>
                                            : ''
                                    }

                                    <Card>
                                        <CardSection>
                                            <h3>{translations.number_shared_label}</h3>
                                            <div className={"grid-x grid-margin-x align-middle"}>
                                                <div className="cell small-6">
                                                    <FieldGroup
                                                        type="number"
                                                        name="three_thirds_looking_back_number_shared"
                                                        placeholder={"0"}
                                                    />
                                                </div>
                                                <div className="cell small-6">
                                                    <label>
                                                        {translations.people}
                                                    </label>
                                                </div>
                                            </div>
                                        </CardSection>
                                    </Card>

                                    <Card>
                                        <CardSection>
                                            <h3 className={"text-center"}>{translations.accepted_christ_label}</h3>
                                            <div>
                                                {!values.three_thirds_looking_back_new_believers.length
                                                    ?  <FieldGroup type="text"
                                                                   placeholder={"Name"}
                                                                   name={`three_thirds_looking_back_new_believers[0]`}/>
                                                    : values.three_thirds_looking_back_new_believers.map((group, idx) =>
                                                        <FieldGroup type="text"
                                                                    after={idx + 1 === values.three_thirds_looking_back_new_believers.length
                                                                        ? (<div className="input-group-button position-absolute" onClick={() => {
                                                                            const newBelievers = [...values.three_thirds_looking_back_new_believers]
                                                                            newBelievers.push([""])
                                                                            setFieldValue('three_thirds_looking_back_new_believers', newBelievers)
                                                                        }}>
                                                                            <a className="button clear secondary">
                                                                                <i className={"icon fi-plus large margin"} />
                                                                            </a>
                                                                        </div>)
                                                                        : (<div className="input-group-button position-absolute" onClick={() => {
                                                                            const newBelievers = [...values.three_thirds_looking_back_new_believers]
                                                                            newBelievers.splice(idx,1)
                                                                            setFieldValue('three_thirds_looking_back_new_believers', newBelievers)
                                                                        }}>
                                                                            <a className="button clear alert">
                                                                                <i className={"icon fi-minus large margin"} />
                                                                            </a>
                                                                        </div>)
                                                                    }
                                                                    inputClassNames={'padding-right-3'}
                                                                    placeholder={"Name"}
                                                                    key={`accepted-christ-${idx}`}
                                                                    name={`three_thirds_looking_back_new_believers[${idx}]`}/>)}
                                            </div>
                                        </CardSection>
                                    </Card>
                                    <Card>
                                        <CardSection>
                                            <h3>{translations.notes}</h3>
                                            <FieldGroup as={TextAreaField}
                                                        placeholder={"Notes go here"}
                                                        name={`three_thirds_looking_back_notes`}
                                                        rows={3}
                                            />
                                        </CardSection>
                                    </Card>

                                </TabPanel>
                                <TabPanel isActive={tab === LOOKING_UP}>
                                    <Card>
                                        <CardHeading>
                                            <h2>Looking Up</h2>
                                        </CardHeading>
                                    </Card>
                                </TabPanel>
                                <TabPanel isActive={tab === LOOKING_AHEAD}>
                                    <Card>
                                        <CardHeading>
                                            <h2>Looking Ahead</h2>
                                        </CardHeading>
                                    </Card>
                                </TabPanel>
                            </TabsContent>
                        </div>
                    </main>
                </Fragment>
            }}
        </Form>
    )
}

export default MeetingPage
