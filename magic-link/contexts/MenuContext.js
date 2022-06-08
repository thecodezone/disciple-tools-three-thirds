import {createContext, useState, useEffect} from "react"
import {useLocation} from "react-router-dom";

/**
 * @see https://reactjs.org/docs/context.html
 * @type {{isOpen: boolean, setIsOpen: state.setIsOpen, pageTitle: string}}
 */
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

  const close = () => {
    setIsOpen(false)
  }

  const open = () => {
    setIsOpen(true)
  }


  useEffect(() => {
    setIsOpen(false)
  }, [location.key])

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
