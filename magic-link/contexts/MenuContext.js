import {createContext, useState, useEffect, useContext} from "react"
import AppContext from "./AppContext";
import {getMeetings} from "../src/api";
import {chunkArray} from "../src/helpers";
import {useLocation} from "react-router-dom";

const state = {
  meetings: [],
  total: 0,
  pages: 0,
  pageTitle: '',
  isOpen: false,
  setIsOpen: () => {}
}

export const MenuContext = createContext(state)

export const MenuContextProvider = ({value, children}) => {
  const [meetings, setMeetings] = useState(state.meetings)
  const [total, setTotal] = useState(state.total)
  const [pages, setPages] = useState(state.pages)
  const [isOpen, setIsOpen] = useState(state.isOpen)
  const location = useLocation()

  useEffect(() => {
    setIsOpen(false)
  }, [location.pathname])

  useEffect(() => {

    const init = async () => {
      try {
        const data = await getMeetings();
        const chunks = chunkArray(data.posts, 5)
        setMeetings(chunks)
        setTotal(meetings.total)
        setPages(chunks.length)
      } catch (ex) {
        console.log(ex)
      }
    }

    init()
  }, [])


  return <MenuContext.Provider value={
    {
      meetings,
      total,
      pages,
      isOpen,
      setIsOpen
    }
  }>
    {children}
  </MenuContext.Provider>
}

export default MenuContext
