import {createContext, useState, useEffect} from "react"
import {MenuContextProvider} from "./MenuContext";
import {getMeetings} from "../src/api";
import {chunkArray} from "../src/helpers";
import Fuse from 'fuse.js'

const state = {
  meetings: [],
  meta: {},
  groups: [],
  series: [],
  q: '',
  inProgress: true,
  total: 0,
  offset: 0,
  per_page: 0,
  paged: 0,
  search: () => {}
}

export const MeetingContext = createContext(state)

export const MeetingsContextProvider = ({value, children}) => {
  const [meetings, setMeetings] = useState(state.meetings)
  const [groups, setGroups] = useState(state.groups)
  const [meta, setMeta] = useState(state.total)
  const [series, setSeries] = useState(state.series)

  const search = async (params = {}) => {
    try {
      const data = await getMeetings(params);
      const newMeetings = params.paged ? [...meetings] : []
      newMeetings.push(...data.meetings.posts)
      setMeetings(newMeetings)
      setGroups(data.groups['posts'])
      setSeries(data.series)
      delete(data.meetings['posts'])
      setMeta(data.meetings)
    } catch (ex) {
      console.log(ex)
    }
  }

  useEffect(() => {
    search()
  }, [])

  return <MeetingContext.Provider value={
    {
      meetings,
      meta,
      groups,
      search,
      series
    }
  }>
    {children}
  </MeetingContext.Provider>
}

export default MeetingContext
