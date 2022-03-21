import { useRef, useEffect, useContext } from 'react'
import AppContext from '../contexts/AppContext'

function usePageTitle(title) {
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

export default usePageTitle
