import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

const ApplicationLayout = ({children}) => {
  return (
    <div id="layout">
      <ApplicationTopBar />
      <Menu />
      {children}
    </div>
  )
}

export default ApplicationLayout
