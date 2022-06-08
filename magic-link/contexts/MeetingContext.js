import {createContext, useState, useEffect} from "react"
import {getMeeting, getMeetings} from "../src/api";
import {chunkArray} from "../src/helpers";
import {useNavigate, useParams, useLocation} from "react-router-dom";

/**
 * @see https://reactjs.org/docs/context.html
 * @type {{tab: string, tabs: [{translation: string, icon: string, key: string}, {translation: string, icon: string, key: string}, {translation: string, icon: string, key: string}, {translation: string, icon: string, key: string}], submission: {}, meeting: boolean}}
 */
const state = {
  meeting: false,
  tabs: [
    {
      key: 'DETAILS',
      translation: 'details',
      icon: 'fi-info',
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
  let navigate = useNavigate();
  const [tab, setTab] = useState(state.tab)
  const [meeting, setMeeting] = useState(false)
  const [submission, setSubmission] = useState(false)
  const location = useLocation();


  useEffect(() => {

    async function fetchMeeting() {
      try {
        const meeting = await getMeeting(id)
        setMeeting(meeting)
        setSubmission(Object.assign({}, meeting, {
          "groups": meeting.groups.posts.map(group => group.ID),
          "three_thirds_previous_meetings": meeting.three_thirds_previous_meetings.posts.map(meeting => meeting.ID)
        }))
      } catch (ex) {
        console.log(ex);
        navigate('/');
      }
    }

    fetchMeeting()
  }, [id, location])

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
