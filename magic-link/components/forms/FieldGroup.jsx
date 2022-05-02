import React, {Fragment} from "react";
import {ErrorMessage, Field} from "formik";
import {useFormikContext} from 'formik'
import classNames from "classnames";

const FieldGroup = ({name, label, before, after, inputClassNames, ...props}) => {
    const { errors, touched } = useFormikContext()
    const error = errors[name]
    const hasError = !!error && touched

    return (
        <label className={classNames("field-group", {"is-invalid-label": hasError})}>
            <div className={"input-group margin-bottom-0 display-block"}>
                {before}
                <Field name={name} {...props} className={classNames(inputClassNames, {"is-invalid-input": hasError})}/>
                {after}
            </div>
            {
                hasError ? (
                    <span className="form-error">{error}</span>
                ) : ''
            }
        </label>
    )
}

export default FieldGroup
