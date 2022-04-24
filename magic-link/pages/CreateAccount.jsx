import React, {Fragment, useContext, useState} from 'react'
import AppContext from "../contexts/AppContext";
import Form from '../components/Form'
import FieldGroup from '../components/FieldGroup'
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import CardFooter from "../components/CardFooter";
import Alert from "../components/Alert";
import {createAccount} from '../src/api'

const CreateAccount = () => {
    const {magicLink} = useContext(AppContext)
    const [success, setSuccess] = useState(false)

    return (
        <AuthLayout>
            {!success ? (
                <Form
                    initialValues={{ username: '', email: '', confirm_password: '', password: '' }}
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
                    {({ isSubmitting }) => (
                        <Fragment>
                            <FieldGroup type="text" name="username" placeholder={"Username"}/>
                            <FieldGroup type="text" name="email" placeholder={"Email"}/>
                            <FieldGroup type="password" name="password" placeholder={"Password"}/>
                            <FieldGroup type="password" name="confirm_password" placeholder={"Confirm Password"}/>

                            <CardFooter>
                                <div className={"auth__buttons"}>
                                    <Link
                                        className="clear button secondary"
                                        to={{
                                            pathname: "/",
                                        }}
                                    >
                                        <i className="icon fa-solid fa-angle-left"/> {magicLink.translations.login}
                                    </Link>

                                    <button type="submit" className="submit success button" disabled={isSubmitting}>
                                        {magicLink.translations.submit}
                                    </button>
                                </div>
                            </CardFooter>
                        </Fragment>
                    )}
                </Form>
            ) : <Alert theme={"success"}>
                {magicLink.translations.registered} <Link to={{
                pathname: "/",
            }}>
                {magicLink.translations.go_to_login}
            </Link>
            </Alert>}
        </AuthLayout>
    )
}

export default CreateAccount
