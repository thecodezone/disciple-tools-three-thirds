import React, {Fragment, useContext, useState} from 'react'
import AppContext from "../contexts/AppContext";
import Form from '../components/forms/Form'
import FieldGroup from '../components/forms/FieldGroup'
import {Link} from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import CardFooter from "../components/layout/cards/CardFooter";
import Alert from "../components/layout/Alert";
import {createAccount} from '../src/api'

const CreateAccount = () => {
    const {magicLink} = useContext(AppContext)
    const [success, setSuccess] = useState(false)

    return (
        <AuthLayout>
            {!success ? (
                <Form
                    initialValues={{
                        username: '',
                        email: '',
                        confirm_password: '',
                        password: '',
                        groups: [],
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
                            <fieldset className="fieldset">
                                <legend>Account</legend>

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
                            </fieldset>


                            <fieldset className="fieldset">
                                <legend>Groups</legend>

                                {values.groups.map((group, idx) => <FieldGroup type="text"
                                                                               placeholder={"Group Name"}
                                                                               key={'group-field'}
                                                                               name={`groups[${idx}]`}/>)}

                                <a className="small button secondary" onClick={(e) => {
                                    e.preventDefault()
                                    values.groups.push('')
                                    setFieldValue( 'groups', values.groups )
                                }}>
                                    Add group
                                </a>

                            </fieldset>



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

                                    <button type="submit"
                                            className="submit success button"
                                            disabled={isSubmitting}>
                                        {magicLink.translations.submit}
                                    </button>
                                </div>
                            </CardFooter>
                        </Fragment>
                    }}
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
