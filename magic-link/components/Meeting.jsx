import React, {useContext, useEffect} from 'react'
import MeetingContext, {MeetingContextProvider} from "../contexts/MeetingContext";
import {getMeeting} from "../src/api";

const Meeting = () => {
    const {meeting} = useContext(MeetingContext)

    return (
        <div className={"meeting"}>
            <h1>Meeting</h1>
        </div>
    )
}

export default Meeting
