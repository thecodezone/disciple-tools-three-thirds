import React, {useContext} from 'react'
import AppContext from "../contexts/AppContext";
import { Formik, Form, Field, ErrorMessage } from 'formik';
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import CardFooter from "../components/CardFooter";

const CreateAccount = () => {
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
                        <Field type="text" name="email" placeholder={"Email"}/>
                        <ErrorMessage name="email" component="div" />
                        <Field type="password" name="password" placeholder={"Password"}/>
                        <ErrorMessage name="password" component="div" />
                        <Field type="password" name="confirm_password" placeholder={"Confirm Password"}/>
                        <ErrorMessage name="confirm_password" component="div" />

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
                    </Form>
                )}
            </Formik>
        </AuthLayout>
    )
}

export default CreateAccount
