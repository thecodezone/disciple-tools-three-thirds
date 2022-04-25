import {createContext, useState, useEffect} from "react"
import {MenuContextProvider} from "./MenuContext";
import {MeetingsContextProvider} from "./MeetingsContext";

const state = {
  user: JSON.parse(magicLink.user),
  magicLink: {
    translations: {}
  },
  pageTitle: '',
  setPageTitle: () => {}
}

export const AppContext = createContext(state)

export const AppContextProvider = ({value, children}) => {
  const [pageTitle, setPageTitle] = useState(magicLink.translations.title)

  return <AppContext.Provider value={
    {
      magicLink: window.magicLink,
      pageTitle,
      setPageTitle,
    }
  }>
    <MeetingsContextProvider>
      <MenuContextProvider>
        {children}
      </MenuContextProvider>
    </MeetingsContextProvider>
  </AppContext.Provider>
}

export default AppContext
