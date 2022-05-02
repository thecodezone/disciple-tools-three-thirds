import React, {Fragment, useContext, useEffect, useState} from 'react'
import MeetingContext from "../contexts/MeetingContext";
import MeetingTabs from "../components/meetings/MeetingTabs";
import Card from "../components/layout/cards/Card";
import {TabPanel, TabsContent} from "react-foundation";
import AppContext from "../contexts/AppContext";
import CardHeading from "../components/layout/cards/CardHeading";
import CardSection from "../components/layout/cards/CardSection";
import Form from "../components/forms/Form";
import FieldGroup from "../components/forms/FieldGroup";
import TextAreaField from "../components/forms/TextAreaField";
import RepeatingField from "../components/forms/RepeatingField";
import ApplicationLayout from "../layouts/ApplicationLayout";
import {saveMeeting} from "../src/api";

const MeetingPage = () => {
    const {translations, pageTitle, setPageTitle} = useContext(AppContext)
    const {meeting, tab, tabs, submission} = useContext(MeetingContext)
    const {LOOKING_BACK, LOOKING_UP, LOOKING_AHEAD} = tabs

    if (!meeting || !submission) {
        return null
    }

    return (
        <ApplicationLayout title={meeting.name} breadcrumbs={[
            {
                link: '/',
                label: 'Dashboard'
            }
        ]}>
            <Form
                initialValues={{
                    ...submission
                }}
            >
                {({values, isSubmitting, setFieldValue, setTouched, ...attrs}) => {


                    const handleBlur = () => {
                        saveMeeting(Object.assign(meeting, values))
                    }

                    return <Fragment>
                        <MeetingTabs/>
                        <main>
                            <div className={"container"}>
                                <TabsContent>
                                    <TabPanel isActive={tab === LOOKING_BACK}>
                                        <Card show={!!meeting.three_thirds_looking_back_content}>
                                            <CardHeading>
                                                <h2>{translations.description}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                {meeting.three_thirds_looking_back_content}
                                            </CardSection>
                                        </Card>

                                        <Card show={meeting.previous_meeting && (meeting.previous_meeting.three_thirds_looking_ahead_prayer_topics || meeting.previous_meeting.three_thirds_looking_ahead_applications)}>
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

                                        <Card>
                                            <CardSection>
                                                <h3>{translations.number_shared_label}</h3>
                                                <div className={"grid-x grid-margin-x align-middle"}>
                                                    <div className="cell small-6">
                                                        <FieldGroup
                                                            type="number"
                                                            name="three_thirds_looking_back_number_shared"
                                                            placeholder={"0"}
                                                            onBlur={handleBlur}
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
                                                    <RepeatingField
                                                        name={'three_thirds_looking_back_new_believers'}
                                                        placeholder={"Name"}
                                                        onBlur={handleBlur}
                                                    />
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
                                                            onBlur={handleBlur}
                                                />
                                            </CardSection>
                                        </Card>

                                    </TabPanel>
                                    <TabPanel isActive={tab === LOOKING_UP}>
                                        <Card>
                                            <CardHeading>
                                                <h2>{values.three_thirds_looking_up_topic}</h2>
                                            </CardHeading>
                                            <CardSection show={!!values.three_thirds_looking_up_content}>
                                                {values.three_thirds_looking_up_content}
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardSection>
                                                <h3>{translations.number_present_label}</h3>
                                                <div className={"grid-x grid-margin-x align-middle"}>
                                                    <div className="cell small-6">
                                                        <FieldGroup
                                                            type="number"
                                                            name="three_thirds_looking_up_number_attendees"
                                                            placeholder={"0"}
                                                            onBlur={handleBlur}
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

                                        <Card show={!!values.three_thirds_looking_up_practice}>
                                            <CardHeading>
                                                <h2>{translations.practice}</h2>
                                            </CardHeading>
                                            <CardSection >
                                                {values.three_thirds_looking_up_practice}
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardSection>
                                                <h3>{translations.notes}</h3>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.notes_label}
                                                            name={`three_thirds_looking_up_notes`}
                                                            rows={3}
                                                            onBlur={handleBlur}
                                                />
                                            </CardSection>
                                        </Card>

                                    </TabPanel>
                                    <TabPanel isActive={tab === LOOKING_AHEAD}>
                                        <Card show={!!meeting.three_thirds_looking_ahead_content}>
                                            <CardHeading>
                                                <h2>{translations.description}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                {meeting.three_thirds_looking_ahead_content}
                                            </CardSection>
                                        </Card>

                                        <Card show={!!meeting.three_thirds_looking_ahead_applications}>
                                            <CardHeading>
                                                <h2>{translations.application}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                {meeting.three_thirds_looking_ahead_applications}
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardSection>
                                                <h3>{translations.share_goal_label}</h3>
                                                <div className={"grid-x grid-margin-x align-middle"}>
                                                    <div className="cell small-6">
                                                        <FieldGroup
                                                            type="number"
                                                            name="three_thirds_looking_ahead_share_goal"
                                                            placeholder={"0"}
                                                            onBlur={handleBlur}
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
                                                <h3>{translations.prayer_requests}</h3>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.prayer_requests_label}
                                                            name={`three_thirds_looking_ahead_prayer_topics`}
                                                            rows={3}
                                                            onBlur={handleBlur}
                                                />
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardSection>
                                                <h3>{translations.notes}</h3>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.notes_label}
                                                            name={`three_thirds_looking_ahead_notes`}
                                                            rows={3}
                                                            onBlur={handleBlur}
                                                />
                                            </CardSection>
                                        </Card>
                                    </TabPanel>
                                </TabsContent>
                            </div>
                        </main>
                    </Fragment>
                }}
            </Form>
        </ApplicationLayout>
    )
}

export default MeetingPage
