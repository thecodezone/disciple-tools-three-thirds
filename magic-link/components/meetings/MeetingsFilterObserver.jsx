import {useEffect, useContext} from 'react'
import {useFormikContext} from "formik";
import MeetingsContext from "../../contexts/MeetingsContext";

/**
 * Watch for changes to the search term and fire the search when it changes.
 * @returns {null}
 * @constructor
 */
const MeetingsFilterObserver = () => {
    const {
        search
    } = useContext(MeetingsContext)

    const {values} = useFormikContext();

    useEffect(() => {
        search({
            q: values.q,
            filter: values.filter
        })
    }, [values]);

    return null;
};

export default MeetingsFilterObserver
