import Alert from "./Alert";
import {Formik, Form as FormikForm, isFunction} from "formik";
import React, {Fragment, useContext, useState} from "react";
import AppContext from "../contexts/AppContext";

const Form = ({children = () => {}, onSubmit, onSuccess = () => {}, onError = () => {}, request, ...props}) => {
    const {magicLink} = useContext(AppContext)
    const [error, setError] = useState('')
    const hasError = !!error

    return (
        <Formik
            {...props}
            onSubmit={async (values, helpers) => {
                const {setSubmitting} = helpers

                if (onSubmit) {
                    onSubmit(values, helpers)
                    return
                }

                if (!request) {
                    return
                }

                console.log(request)

                setError('')
                try {
                    const response =  await request(values)
                    if ((response.code && response.code !== 200)) {
                        setError(magicLink.translations.form_error)
                        onError(values, helpers, response)
                        return
                    }
                    if (response.error) {
                        setError(response.error)
                        onError(values, helpers, response)
                        return
                    }
                    setError('')
                    onSuccess(values, helpers, response)
                } catch (exception) {
                    console.log(exception)
                    setError(magicLink.translations.form_error)
                }

                setSubmitting(false);
            }}
        >
            {(values) => {
                const formChildren = isFunction(children) ? children(values) : children

                return (<FormikForm onChange={() => {
                    setError(false)
                }}>
                    <Fragment>
                        <Alert active={hasError}
                               message={error}/>
                        {formChildren}
                    </Fragment>
                </FormikForm>)
            }}
        </Formik>
    )
}

export default Form
