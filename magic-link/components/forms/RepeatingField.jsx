import FieldGroup from "./FieldGroup";
import React from "react";
import {useFormik, useFormikContext} from "formik";

const RepeatingField = ({name, ...props}) => {
    const {setFieldValue, values} = useFormikContext();

    const value = values[name] && values[name].length ? values[name] : [""]

    return value.map((group, idx) => (<FieldGroup type="text"
                after={idx + 1 === value.length
                    ? (<div className="input-group-button position-absolute" onClick={() => {
                        const newValue = [...value]
                        newValue.push([""])

                        setFieldValue(name, newValue)
                    }}>
                        <a className="button clear secondary">
                            <i className={"icon fi-plus large margin"} />
                        </a>
                    </div>)
                    : (<div className="input-group-button position-absolute" onClick={() => {
                        const newValue = [...value]
                        newValue.splice(idx,1)
                        setFieldValue(name, newValue)
                    }}>
                        <a className="button clear alert">
                            <i className={"icon fi-minus large margin"} />
                        </a>
                    </div>)
                }
                inputClassNames={'padding-right-3'}
                {...props}
                key={`repeating-field-${idx}`}
                name={`${name}[${idx}]`}/>)
    )
}

export default RepeatingField
