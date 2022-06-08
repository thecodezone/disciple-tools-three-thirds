import {connect} from "formik";
import {useEffect} from "react";
import {useInitialized, useTimer} from "../../src/hooks";

/**
 * An observer to fire a callback when a fields value changes. Useful for fields that don't have a reliable onChange event.
 *
 * @type {React.ComponentType<{readonly onChange?: *, readonly name?: *, readonly formik?: {values: {}}}>}
 */
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
