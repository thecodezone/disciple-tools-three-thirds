import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

const Layout = ({children}) => {
  return (
    <div id="layout" className={"padding-top-2"}>
      {children}
    </div>
  )
}

export default Layout
