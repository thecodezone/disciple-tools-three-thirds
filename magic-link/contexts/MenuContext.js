import {createContext, useState, useEffect, useContext} from "react"
import AppContext from "./AppContext";
import {getMeetings} from "../src/api";
import {chunkArray} from "../src/helpers";
import {useLocation} from "react-router-dom";

const state = {
  pageTitle: '',
  isOpen: false,
  setIsOpen: () => {
  }
}

export const MenuContext = createContext(state)

export const MenuContextProvider = ({value, children}) => {
  const [isOpen, setIsOpen] = useState(state.isOpen)
  const location = useLocation()

  useEffect(() => {
    setIsOpen(false)
  }, [location.pathname])

  const close = () => {
    setIsOpen(false)
  }

  const open = () => {
    setIsOpen(true)
  }

  return <MenuContext.Provider value={
    {
      isOpen,
      setIsOpen,
      open,
      close
    }
  }>
    {children}
  </MenuContext.Provider>
}

export default MenuContext
