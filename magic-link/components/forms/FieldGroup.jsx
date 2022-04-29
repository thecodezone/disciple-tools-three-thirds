import React, {Fragment} from "react";
import {ErrorMessage, Field} from "formik";
import {useFormikContext} from 'formik'
import classNames from "classnames";

const FieldGroup = ({name, label, before, after, inputClassNames, ...props}) => {
    const { errors } = useFormikContext()
    const error = errors[name]
    const hasError = !!error

    return (
        <label className={classNames("field-group", {"is-invalid-label": hasError})}>
            <div className={"input-group"}>
                {before}
                <Field name={name} {...props} className={classNames(inputClassNames, {"is-invalid-input": hasError})}/>
                {
                    hasError ? (
                        <span className="form-error">{error}</span>
                    ) : ''
                }
                {after}
            </div>
        </label>
    )
}

export default FieldGroup
