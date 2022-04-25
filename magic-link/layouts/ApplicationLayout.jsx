import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

const ApplicationLayout = ({children}) => {
  return (
    <div id="layout">
      <ApplicationTopBar />
      <Menu />
      <main className={"container"}>
          {children}
      </main>
    </div>
  )
}

export default ApplicationLayout
