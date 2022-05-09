import {connect} from "formik";
import {useEffect} from "react";
import {useInitialized, useTimer} from "../../src/hooks";

const HandleFieldChange = connect(
    ({name, formik: {values: { [name]: value }}, onChange}) => {
        const initialised = useTimer(50)

        useEffect(() => {
            if (!initialised) {
                return
            }
            onChange(value, name);
        }, [value]);
        return null;
    }
);

export default HandleFieldChange
