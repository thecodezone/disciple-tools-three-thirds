import React, {Fragment} from "react";
import {ErrorMessage, Field} from "formik";
import {useFormikContext} from 'formik'
import classNames from "classnames";

/**
 * A field group that overloads to the formik Field component. Takes any prop that Formik <Field> takes.
 *
 * @param name
 * @param label
 * @param before
 * @param after
 * @param inputClassNames
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
const FieldGroup = ({name, label, before, after, inputClassNames, ...props}) => {
    const { errors, touched } = useFormikContext()
    const error = errors[name]
    const hasError = !!error && touched

    return (
        <label className={classNames("field-group", {"is-invalid-label": hasError})}>
            {label}
            <div className={classNames({"input-group": before || after}, "margin-bottom-0 display-block")}>
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
