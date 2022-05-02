import {createContext, useState, useEffect} from "react"
import {getMeeting, getMeetings} from "../src/api";
import {chunkArray} from "../src/helpers";
import {useParams} from "react-router-dom";

const state = {
  meeting: false,
  tabs: [
    {
      key: 'SETTINGS',
      translation: 'settings',
      icon: 'fi-widget',
    },
    {
      key: 'LOOKING_BACK',
      translation: 'looking_back',
      icon: 'fi-arrow-left',
    },
    {
      key: 'LOOKING_UP',
      translation: 'looking_up',
      icon: 'fi-arrow-up',
    },
    {
      key: 'LOOKING_AHEAD',
      translation: 'looking_ahead',
      icon: 'fi-arrow-right'
    }
  ],
  tab: 'LOOKING_BACK',
  submission: {}
}

export const MeetingContext = createContext(state)

export const MeetingContextProvider = ({children}) => {
  let {id} = useParams();
  const [tab, setTab] = useState(state.tab)
  const [meeting, setMeeting] = useState(false)
  const [submission, setSubmission] = useState(false)



  useEffect(() => {
    async function fetchMeeting() {
      try {
        const meeting = await getMeeting(id)
        setMeeting(meeting)
        setSubmission(Object.assign({}, meeting))
      } catch (ex) {
        console.log(ex)
      }
    }

    fetchMeeting()
  }, [id])

  return <MeetingContext.Provider value={
    {
      meeting,
      setMeeting,
      tab,
      tabs: state.tabs,
      setTab,
      submission,
      setSubmission
    }
  }>
    {children}
  </MeetingContext.Provider>
}

export default MeetingContext
