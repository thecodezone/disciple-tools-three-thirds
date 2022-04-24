import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

const Layout = ({children}) => {
  return (
    <div id="layout">
      <TopBar />
      {children}
    </div>
  )
}

export default Layout
