import {createContext, useState, useEffect} from "react"

const state = {
  meeting: false,
  setMeeting: () => {},
  lookingBackContent: '',
  setLookingBackContent: () => {},
  numberShared: 0,
  setNumberShared: () => {},
  newBelievers: [],
  setNewBelievers: () => {},
  lookingBackNotes: '',
  setLookingBackNotes: () => {},
  numberAttendees: 0,
  setNumberAttendees: () => {},
  topic: '',
  setTopic: () => {},
  lookingUpContent: '',
  setLookingUpContent: () => {},
  practice: '',
  setPractice: () => {},
  lookingUpNotes: '',
  setLookingUpNotes: () => {},
  lookingAheadContent: '',
  setLookingAheadContent: () => {},
  shareGoal: 0,
  setShareGoal: () => {},
  applications: '',
  setApplications: () => {},
  prayerTopics: '',
  setPrayerTopics: () => {},
  lookingAheadNotes: '',
  setLookingAheadNotes: () => {}
}

export const MeetingContext = createContext(state)

export const MeetingContextProvider = ({meeting, setMeeting = () => {}, children}) => {
  const [lookingBackContent, setLookingBackContent] = useState(state.lookingBackContent)
  const [numberShared, setNumberShared] = useState(state.numberShared)
  const [newBelievers, setNewBelievers] = useState(state.newBelievers)
  const [lookingBackNotes, setLookingBackNotes] = useState(state.lookingBackNotes)
  const [numberAttendees, setNumberAttendees] = useState(state.numberAttendees)
  const [topic, setTopic] = useState(state.topic)
  const [lookingUpContent, setLookingUpContent] = useState(state.lookingUpContent)
  const [practice, setPractice] = useState(state.practice)
  const [lookingUpNotes, setLookingUpNotes] = useState(state.lookingUpNotes)
  const [lookingAheadContent, setLookingAheadContent] = useState(state.lookingAheadContent)
  const [shareGoal, setShareGoal] = useState(state.shareGoal)
  const [applications, setApplications] = useState(state.applications)
  const [prayerTopics, setPrayerTopics] = useState(state.prayerTopics)
  const [lookingAheadNotes, setLookingAheadNotes] = useState(state.lookingAheadNotes)

  useEffect(() => {
    setLookingAheadContent(meeting ? meeting.three_thirds_looking_back_content : '')
    setNumberShared(meeting ? meeting.three_thirds_looking_back_number_shared : 0)
    setNewBelievers(meeting ? meeting.three_thirds_looking_back_new_believers : [])
    setLookingBackNotes(meeting ? meeting.three_thirds_looking_back_notes : '')
    setNumberAttendees(meeting ? meeting.three_thirds_looking_up_number_attendees : 0)
    setTopic(meeting ? meeting.three_thirds_looking_up_topic : '')
    setLookingUpContent(meeting ? meeting.three_thirds_looking_up_content : '')
    setPractice(meeting ? meeting.three_thirds_looking_up_practice : '')
    setLookingUpNotes(meeting ? meeting.three_thirds_looking_up_notes : '')
    setLookingAheadContent(meeting ? meeting.three_thirds_looking_ahead_content : '')
    setShareGoal(meeting ? meeting.three_thirds_looking_ahead_share_goal : 0)
    setApplications(meeting ? meeting.three_thirds_looking_ahead_applications : '')
    setPrayerTopics(meeting ? meeting.three_thirds_looking_ahead_prayer_topics : '')
    setLookingAheadNotes(meeting ? meeting.three_thirds_looking_ahead_notes : '')
  }, [meeting])

  return <MeetingContext.Provider value={
    {
      meeting,
      setMeeting,
      lookingBackContent,
      setLookingBackContent,
      numberShared,
      setNumberShared,
      newBelievers,
      setNewBelievers,
      lookingBackNotes,
      setLookingBackNotes,
      numberAttendees,
      setNumberAttendees,
      topic,
      setTopic,
      lookingUpContent,
      setLookingUpContent,
      practice,
      setPractice,
      lookingUpNotes,
      setLookingUpNotes,
      lookingAheadContent,
      setLookingAheadContent,
      shareGoal,
      setShareGoal,
      applications,
      setApplications,
      prayerTopics,
      setPrayerTopics,
      lookingAheadNotes,
      setLookingAheadNotes
    }
  }>
    {children}
  </MeetingContext.Provider>
}

export default MeetingContext
