import React, {Fragment, useCallback, useContext, useEffect, useState} from 'react'
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
import {saveMeeting, searchGroups, searchMeetings} from "../src/api";
import RelationshipField from "../components/forms/RelationshipField";
import CreatableRelationshipField from "../components/forms/CreatableRelationshipField";
import MeetingsContext from "../contexts/MeetingsContext";
import { useAlert } from 'react-alert'
import HandleFieldChange from "../components/forms/HandleFieldChange";
import DateField from '../components/forms/DateField'

/**
 * The edit meeting page
 * @returns {JSX.Element|null}
 * @constructor
 */
const EditMeetingPage = () => {
    const {translations} = useContext(AppContext)
    const {meetings} = useContext(MeetingsContext)
    const {meeting, tab, submission} = useContext(MeetingContext)
    const alert = useAlert()

    if (!meeting || !submission) {
        return null
    }

    return (
        <ApplicationLayout title={translations.edit + ": " + meeting.name}
                           breadcrumbs={[
                               {
                                   link: '/',
                                   label: 'Dashboard'
                               },
                               {
                                   link: '/meetings/' + meeting.ID,
                                   label: meeting.name
                               }
                           ]}>
            <Form
                initialValues={{
                    ...submission
                }}
            >
                {({values, isSubmitting, setFieldValue, setTouched, ...attrs}) => {
                    const save = useCallback(async () => {
                        try {
                            await saveMeeting(Object.assign(meeting, values))
                            alert.show('Saved')
                        } catch (ex) {
                            if (ex.statusText !== "abort") {
                                console.log(ex)
                                alert.show('Error', {
                                    type: 'error',
                                })
                            }
                        }
                    }, [values])

                    return <Fragment>
                        <MeetingTabs/>
                        <main>
                            <div className={"container"}>
                                <TabsContent>
                                    <TabPanel isActive={tab.key === 'DETAILS'}>
                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.meeting}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup
                                                    label={translations.name}
                                                    type={"text"}
                                                    name="name"
                                                    placeholder={translations.name}
                                                    onBlur={save}
                                                />
                                                <FieldGroup
                                                    label={translations.date}
                                                    name="date"
                                                    placeholder={translations.date}
                                                    component={DateField}
                                                    onChange={save}
                                                />
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.group}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup name="groups"
                                                            request={searchGroups}
                                                            defaultValue={meeting.groups?.posts}
                                                            component={CreatableRelationshipField}
                                                            isMulti
                                                            onChange={save}
                                                />
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.previous_meeting}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup name="three_thirds_previous_meetings"
                                                            excludeOptions={[meeting.ID]}
                                                            request={searchMeetings}
                                                            defaultValue={meeting.three_thirds_previous_meetings?.posts}
                                                            component={RelationshipField}
                                                            isMulti
                                                            onChange={save}
                                                />
                                            </CardSection>
                                        </Card>

                                    </TabPanel>
                                    <TabPanel isActive={tab.key === 'LOOKING_BACK'}>
                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.description}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup
                                                    as={TextAreaField}
                                                    name="three_thirds_looking_back_content"
                                                    placeholder={translations.description}
                                                    rows={3}
                                                    onBlur={save}
                                                />
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
                                                            onBlur={save}
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
                                                        onBlur={save}
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
                                                            onBlur={save}
                                                />
                                            </CardSection>
                                        </Card>

                                    </TabPanel>
                                    <TabPanel isActive={tab.key === 'LOOKING_UP'}>
                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.topic}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.topic}
                                                            name={`three_thirds_looking_up_topic`}
                                                            rows={3}
                                                            onBlur={save}
                                                />
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
                                                            onBlur={save}
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
                                            <CardHeading>
                                                <h2>{translations.practice}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.practice}
                                                            name={`three_thirds_looking_up_practice`}
                                                            rows={3}
                                                            onBlur={save}
                                                />
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardSection>
                                                <h3>{translations.notes}</h3>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.notes_label}
                                                            name={`three_thirds_looking_up_notes`}
                                                            rows={3}
                                                            onBlur={save}
                                                />
                                            </CardSection>
                                        </Card>
                                    </TabPanel>

                                    <TabPanel isActive={tab.key === 'LOOKING_AHEAD'}>
                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.description}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.notes_label}
                                                            name={`three_thirds_looking_ahead_content`}
                                                            rows={3}
                                                            onBlur={save}
                                                />
                                            </CardSection>
                                        </Card>

                                        <Card>
                                            <CardHeading>
                                                <h2>{translations.application}</h2>
                                            </CardHeading>
                                            <CardSection>
                                                <FieldGroup as={TextAreaField}
                                                            placeholder={translations.application}
                                                            name={`three_thirds_looking_ahead_applications`}
                                                            rows={3}
                                                            onBlur={save}
                                                />
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
                                                            onBlur={save}
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
                                                            onBlur={save}
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
                                                            onBlur={save}
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

export default EditMeetingPage
