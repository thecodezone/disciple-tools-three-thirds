import React, {useContext, useState} from 'react'
import AppContext from "../contexts/AppContext";
import { Formik, Form } from 'formik';
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import FieldGroup from "../components/FieldGroup";
import SubmitButton from "../components/SubmitButton";
import {login as postLogin} from '../src/api'
import Alert from "../components/Alert";

const Login = () => {
    const {magicLink} = useContext(AppContext)
    const [error, setError] = useState('')
    const hasError = !!error

    return (
        <AuthLayout>
            <Formik
                initialValues={{ username: '', password: '' }}
                validate={values => {
                    const errors = {};
                    if (!values.username) {
                        errors.username = 'Required';
                    }
                    if (!values.password) {
                        errors.password = 'Required';
                    }
                    return errors;
                }}
                onSubmit={async (values, { setSubmitting }) => {
                    setError('')
                    try {
                        const response =  await postLogin(values)
                        if (response.success) {
                            window.location = magicLink.redirect_url
                            return;
                        } else {
                            setError(response.error ?? magicLink.translations.form_error)
                        }
                    } catch (exception) {
                        console.log(exception)
                        setError(magicLink.translations.form_error)
                    }

                    setSubmitting(false);
                }}
            >
                {() => (
                    <Form  onChange={() => {
                        setError(false)
                    }}>
                        <Alert active={hasError} message={error} />

                        <FieldGroup type="text" name="username" placeholder={"Username"}/>
                        <FieldGroup type="password" name="password" placeholder={"Password"}/>
                        <div className={"auth__reset text-right"}>
                            <a className={"clear button alert small"} href={magicLink.reset_url}>
                                {magicLink.translations.reset_password}
                            </a>
                        </div>

                        <div className={"auth__buttons"}>
                            <SubmitButton>
                                {magicLink.translations.sign_in}
                            </SubmitButton>

                            <Link
                                className="clear button secondary"
                                to={{
                                    pathname: "/create-account",
                                }}
                            >
                                {magicLink.translations.create_account} <i className="icon fa-solid fa-angle-right"/>
                            </Link>
                        </div>

                    </Form>
                )}
            </Formik>
        </AuthLayout>
    )
}

export default Login
