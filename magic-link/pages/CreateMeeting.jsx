import React, {Fragment, useCallback, useContext, useEffect, useState} from 'react'
import Card from "../components/layout/cards/Card";
import {Button, ButtonGroup, TabPanel, TabsContent} from "react-foundation";
import AppContext from "../contexts/AppContext";
import CardHeading from "../components/layout/cards/CardHeading";
import CardSection from "../components/layout/cards/CardSection";
import Form from "../components/forms/Form";
import FieldGroup from "../components/forms/FieldGroup";
import ApplicationLayout from "../layouts/ApplicationLayout";
import CardFooter from "../components/layout/cards/CardFooter";
import DateField from "../components/forms/DateField";
import {createMeeting} from '../src/api'
import {useNavigate} from "react-router-dom";

const CreateMeetingPage = () => {
    const {translations} = useContext(AppContext)
    let navigate = useNavigate();


    return (
        <ApplicationLayout title={translations.create_meeting}
                           breadcrumbs={[
                               {
                                   link: '/',
                                   label: 'Dashboard'
                               }
                           ]}>
            <Form
                request={createMeeting}
                initialValues={{
                    name: "",
                    date: ""
                }}
                validate={values => {
                    const errors = {};
                    if (!values.name) {
                        errors.name = 'Required';
                    }
                    if (!values.date) {
                        errors.date = 'Required';
                    }
                    return errors;
                }}
                onSuccess={(values, helpers, response) => {
                    if (response.ID) {
                        navigate('/meetings/edit/' + response.ID)
                    }
                }}
            >
                {({values, isSubmitting, setFieldValue, setTouched, ...attrs}) => {
                    return <Fragment>
                        <main>
                            <div className={"container"}>
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
                                        />
                                        <FieldGroup
                                            label={translations.date}
                                            name="date"
                                            placeholder={translations.date}
                                            component={DateField}
                                        />
                                    </CardSection>
                                    <CardFooter>
                                        <ButtonGroup>
                                            <Button isExpanded color={"success"}>
                                                {translations.create_meeting}
                                            </Button>
                                        </ButtonGroup>
                                    </CardFooter>
                                </Card>

                            </div>
                        </main>
                    </Fragment>
                }}
            </Form>
        </ApplicationLayout>
    )
}

export default CreateMeetingPage
