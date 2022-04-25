import {createContext, useState, useEffect} from "react"
import {MenuContextProvider} from "./MenuContext";
import {getMeetings} from "../src/api";
import {chunkArray} from "../src/helpers";
import Fuse from 'fuse.js'

const state = {
  all: {
    posts: [],
    total: 0
  },
  meetings: [],
  groups: [],
  group: '',
  search: '',
  inProgress: true,
  total: 0,
  pages: 0,
}

export const MeetingContext = createContext(state)

const filterByGroup = (group) => (meeting) => {
    if (!group) {
      return true
    }

    if (group === 'none') {
      return meeting.groups.total === 0
    }

    return meeting.groups.posts.some(({ID}) => {
      console.log(ID, group)
      return ID === group
    })
}

const meetingsGroupsReducer = (groups, meeting) => {
  if (!meeting.groups || !meeting.groups.total) {
    return groups
  }

  meeting.groups.posts.forEach((group) => {
    if (!groups.some(({ID}) => ID === group.ID)) {
      groups.push(group)
    }
  })

  return groups
}

const sortGroupsByTitle = ( a, b ) => a.title.localeCompare(b.title)

export const MeetingsContextProvider = ({value, children}) => {
  const [all, setAll] = useState(state.all)
  const [meetings, setMeetings] = useState(state.meetings)
  const [groups, setGroups] = useState(state.groups)
  const [total, setTotal] = useState(state.total)
  const [pages, setPages] = useState(state.pages)
  const [group, setGroup] = useState(state.group)
  const [search, setSearch] = useState(state.search)

  useEffect(() => {
    const init = async () => {
      try {
        const data = await getMeetings();
        setAll(data)
      } catch (ex) {
        console.log(ex)
      }
    }

    init()
  }, [])

  useEffect(() => {
    let filtered = all.posts.filter(filterByGroup(group))
    if (search) {
      const fuse = new Fuse(filtered, {
        shouldSort: false,
        keys: ['ID', 'name']
      })
      const results = fuse.search(search)
      filtered = results.map(({item}) => item)
    }
    const chunks = chunkArray(filtered, 5)
    setGroups(all.posts.reduce(meetingsGroupsReducer, []).sort(sortGroupsByTitle))
    setMeetings(chunks)
    setTotal(filtered.length)
    setPages(chunks.length)
  }, [all, group, search])

  return <MeetingContext.Provider value={
    {
      meetings,
      groups,
      total,
      pages,
      group,
      setGroup,
      search,
      setSearch
    }
  }>
    {children}
  </MeetingContext.Provider>
}

export default MeetingContext
