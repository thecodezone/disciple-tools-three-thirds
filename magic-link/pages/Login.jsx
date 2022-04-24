import React, {useContext} from 'react'
import Card from "../components/Card";
import AppContext from "../contexts/AppContext";
import CardHeading from "../components/CardHeading";
import Brand from "../components/Brand";
import { Formik, Form, Field, ErrorMessage } from 'formik';
import CardSection from "../components/CardSection";
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";

const Login = () => {
    const {magicLink} = useContext(AppContext)

    return (
        <AuthLayout>
            <Formik
                initialValues={{ email: '', password: '' }}
                validate={values => {
                    const errors = {};
                    if (!values.email) {
                        errors.email = 'Required';
                    } else if (
                        !/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(values.email)
                    ) {
                        errors.email = 'Invalid email address';
                    }
                    return errors;
                }}
                onSubmit={(values, { setSubmitting }) => {
                    setTimeout(() => {
                        alert(JSON.stringify(values, null, 2));
                        setSubmitting(false);
                    }, 400);
                }}
            >
                {({ isSubmitting }) => (
                    <Form>
                        <Field type="text" name="username" placeholder={"Username"}/>
                        <ErrorMessage name="username" component="div" />
                        <Field type="password" name="password" placeholder={"Password"}/>
                        <ErrorMessage name="password" component="div" />
                        <div className={"auth__reset text-right"}>
                            <a className={"clear button alert small"} href={magicLink.reset_url}>
                                {magicLink.translations.reset_password}
                            </a>
                        </div>

                        <div className={"auth__buttons"}>
                            <button type="submit" className="submit success button" disabled={isSubmitting}>
                                {magicLink.translations.sign_in}
                            </button>

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
