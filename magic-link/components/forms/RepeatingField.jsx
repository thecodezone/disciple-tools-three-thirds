import FieldGroup from "./FieldGroup";
import React, {Fragment} from "react";
import {useFormik, useFormikContext} from "formik";

/**
 * A repeatable field group that maps to an array of values.
 *
 * @param name
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
const RepeatingField = ({name, ...props}) => {
    const {setFieldValue, values} = useFormikContext();
    const value = values[name] && values[name].length ? values[name] : [""]
    return <Fragment>
        {
            value.map((group, idx) => <FieldGroup
                    type="text"
                    key={`repeating-${name}-${idx}`}
                    inputClassNames={'padding-right-3'}
                    name={`${name}[${idx}]`}
                    after={
                        idx + 1 === value.length ?
                            (
                                <div className="input-group-button position-absolute"
                                     onClick={() => {
                                         const newValue = [...value]
                                         newValue.push("")
                                         setFieldValue(name, newValue)
                                     }}>
                                    <a className="button clear secondary">
                                        <i className={"icon fi-plus large margin"}/>
                                    </a>
                                </div>
                            )
                            : (
                                <div className="input-group-button position-absolute"
                                     onClick={() => {
                                         const newValue = [...value]
                                         newValue.splice(idx, 1)
                                         setFieldValue(name, newValue)
                                     }}>
                                    <a className="button clear alert">
                                        <i className={"icon fi-minus large margin"}/>
                                    </a>
                                </div>
                            )
                    }
                    {...props}
                />
            )
        }
    </Fragment>
}

export default RepeatingField
