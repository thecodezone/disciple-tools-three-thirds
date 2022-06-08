import {Field} from "formik";
import React, {useEffect, useRef} from "react";
import autosize from "autosize/dist/autosize";
import { useField } from 'formik';

/**
 * A text area field
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
const TextAreaField = (props) => {
    const select = useRef()
    const [field] = useField(props.name);

    useEffect(() => {
        autosize(select.current)

        return () => {
            return autosize.destroy(select.current)
        }
    }, [select])

    return  <textarea {...field} {...props} ref={select} />
}

export default TextAreaField
