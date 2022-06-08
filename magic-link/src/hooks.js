import { useRef, useEffect, useContext, useState } from 'react'
import AppContext from '../contexts/AppContext'

/**
 * A hook that changes on the first tick
 * @param callback
 * @returns {boolean}
 */
export const useInitialized = (callback = ()=>{}) => {
  const [isInitialized, setIsInitialized] = useState(false)

  useEffect(() => {
    if (!isInitialized) {
      setIsInitialized(true)
      callback()
    }
  })

  return isInitialized
}

/**
 * A hook that fires delay a delay
 * @param delay
 * @returns {boolean}
 */
export const useTimer = (delay = 0) => {
  const [completed, setCompleted] = useState(false)

  const callback = () => {
    setCompleted(true)
  }

  // Set up the timeout.
  useEffect(() => {
    // Don't schedule if no delay is specified.
    if (!delay) {
      callback()
      return
    }

    setTimeout(callback, delay)
  }, [delay])

  return completed
}

/**
 * A hook to do things when the page title changes
 * @param title
 */
export const usePageTitle = (title) => {
  const {setPageTitle} = useContext(AppContext);

  useEffect(() => {
    setPageTitle(title)
    document.title = title;
  }, [title]);

  useEffect(() => () => {
    document.title = magicLink.title;
    setPageTitle(magicLink.title)
  }, [])
}
