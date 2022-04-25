import {useEffect, useContext} from 'react'
import {useFormikContext} from "formik";
import MeetingsContext from "../contexts/MeetingsContext";

const MeetingsFilterObserver = () => {
    const {
        setSearch,
        setGroup
    } = useContext(MeetingsContext)

    const {values} = useFormikContext();

    useEffect(() => {
        setSearch(values.search)
        setGroup(values.group)
    }, [values]);

    return null;
};

export default MeetingsFilterObserver
