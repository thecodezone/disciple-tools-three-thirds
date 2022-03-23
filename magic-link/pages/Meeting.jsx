import React, {useContext, useEffect, useState} from 'react'
import {MeetingContextProvider} from "../contexts/MeetingContext";
import {getMeeting} from "../src/api";
import Meeting from '../components/Meeting'
import {useParams} from "react-router-dom";

const MeetingPage = () => {
    let { id } = useParams();
    const [meeting, setMeeting] = useState(false)

    useEffect(() => {
        async function fetchMeeting() {
            try {
                const meeting = await getMeeting(id)
                setMeeting(meeting)
            } catch (ex) {
                console.log(ex)
            }
        }

        fetchMeeting()
    }, [id, setMeeting])
    return (
        <MeetingContextProvider
            meeting={meeting}
            setMeeting={setMeeting}
        >
            <Meeting />
        </MeetingContextProvider>
    )
}

export default MeetingPage
