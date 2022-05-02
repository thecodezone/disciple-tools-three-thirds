import React, {Fragment, useContext, useState} from 'react'
import AppContext from "../contexts/AppContext";
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import FieldGroup from "../components/forms/FieldGroup";
import SubmitButton from "../components/forms/SubmitButton";
import {login} from '../src/api'
import Form from "../components/forms/Form";
import Card from "../components/layout/cards/Card";
import CardSection from "../components/layout/cards/CardSection";
import Brand from "../components/Brand";

const Login = () => {
    const {magicLink} = useContext(AppContext)

    return (
        <AuthLayout>
            <Form
                request={login}
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
                onSuccess={() => {
                    window.location = magicLink.redirect_url
                }}
            >
                {
                    () => (
                        <Card>
                            <CardSection>
                                <Brand className={"auth__brand"}/>
                            </CardSection>
                            <CardSection>
                                <Fragment>
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
                                </Fragment>
                            </CardSection>
                        </Card>
                    )}
            </Form>
        </AuthLayout>
    )
}

export default Login
