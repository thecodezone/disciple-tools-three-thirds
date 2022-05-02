import React, {Fragment, useContext, useState} from 'react'
import AppContext from "../contexts/AppContext";
import Form from '../components/forms/Form'
import FieldGroup from '../components/forms/FieldGroup'
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import CardFooter from "../components/layout/cards/CardFooter";
import Alert from "../components/layout/Alert";
import {createAccount} from '../src/api'
import CardSection from "../components/layout/cards/CardSection";
import Brand from "../components/Brand";
import SubmitButton from "../components/forms/SubmitButton";
import Card from "../components/layout/cards/Card";
import CardHeading from "../components/layout/cards/CardHeading";
import RepeatingField from "../components/forms/RepeatingField";

const CreateAccount = () => {
    const {magicLink} = useContext(AppContext)
    const [success, setSuccess] = useState(false)

    return <AuthLayout>
            <Brand className={"auth__brand padding-bottom-4"}/>

           <Form
                initialValues={{
                    username: '',
                    email: '',
                    confirm_password: '',
                    password: '',
                    groups: [''],
                    create_group: false
                }}
                validate={values => {
                    const errors = {};
                    if (!values.username) {
                        errors.username = 'Required';
                    }
                    if (!values.email) {
                        errors.email = 'Required';
                    }
                    if (!values.confirm_password) {
                        errors.confirm_password = "Required"
                    }
                    if (!values.password) {
                        errors.password = 'Required';
                    }
                    if (values.password !== values.confirm_password) {
                        errors.confirm_password = 'Must match';
                    }
                    return errors;
                }}
                request={createAccount}
                onSuccess={() => {
                    setSuccess(true)
                }}
            >
                {({values, isSubmitting, setFieldValue, setTouched, ...attrs}) => {
                    return <Fragment>
                        <Card>
                            <CardHeading>
                                <h2>Create Account</h2>

                                <Link
                                    className="clear button white"
                                    to={{
                                        pathname: "/",
                                    }}
                                >
                                    <i className="icon fa-solid fa-angle-left"/> {magicLink.translations.login}
                                </Link>
                            </CardHeading>

                            {!success ? (<CardSection>

                                <FieldGroup type="text"
                                            name="username"
                                            placeholder={"Username"}/>
                                <FieldGroup type="text"
                                            name="email"
                                            placeholder={"Email"}/>
                                <FieldGroup type="password"
                                            name="password"
                                            placeholder={"Password"}/>
                                <FieldGroup type="password"
                                            name="confirm_password"
                                            placeholder={"Confirm Password"}/>
                            </CardSection>) : <CardSection>
                                <Alert theme={"success white"}>
                                    {magicLink.translations.registered}
                                </Alert>
                            </CardSection>
                            }
                        </Card>

                        {!success ? <Fragment>
                            <Card>
                                <CardSection>
                                    <h3>Groups</h3>
                                    <p className="help-text">Would you like to create any groups along with your
                                                             account?</p>
                                    <RepeatingField
                                        name="groups"
                                        placeholder={"Add group name"}
                                        type={"text"}
                                    />
                                </CardSection>

                            </Card>

                            <Card>
                                <CardFooter>
                                    <button type="submit"
                                            className="submit success button"
                                            disabled={isSubmitting}>
                                        {magicLink.translations.submit}
                                    </button>
                                </CardFooter>
                            </Card>
                        </Fragment> : ''}
                    </Fragment>
                }}
            </Form>
    </AuthLayout>

}

export default CreateAccount
