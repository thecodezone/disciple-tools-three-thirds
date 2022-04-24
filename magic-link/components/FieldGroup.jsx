import React, {Fragment} from "react";
import {ErrorMessage, Field} from "formik";
import {useFormikContext} from 'formik'
import classNames from "classnames";

const FieldGroup = ({name, ...props}) => {
    const { errors } = useFormikContext()
    const error = errors[name]
    const hasError = !!error

    return (
        <label className={classNames("field-group", {"is-invalid-label": hasError})}>
            <Field name={name} {...props} className={classNames({"is-invalid-input": hasError})}/>
            {
                hasError ? (
                    <span className="form-error">{error}</span>
                ) : ''
            }
        </label>
    )
}

export default FieldGroup
