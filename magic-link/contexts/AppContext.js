import {createContext, useState, useEffect} from "react"
import {MenuContextProvider} from "./MenuContext";
import {MeetingsContextProvider} from "./MeetingsContext";

/**
 * General context that could be used across the entire app.
 *
 * @see https://reactjs.org/docs/context.html
 * @type {{pageTitle: string, translations: *, setPageTitle: state.setPageTitle, magicLink: *, user: any}}
 */
const state = {
  user: JSON.parse(magicLink.user),
  magicLink: magicLink,
  pageTitle: '',
  setPageTitle: () => {},
  translations: magicLink.translations
}

export const AppContext = createContext(state)

export const AppContextProvider = ({value, children}) => {
  return <AppContext.Provider value={
    {
      user: state.user,
      magicLink: state.magicLink,
      translations: state.magicLink.translations
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
