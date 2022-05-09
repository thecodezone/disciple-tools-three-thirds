import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

const ApplicationLayout = ({children, ...props}) => {
    return (
        <div id="layout">
            <ApplicationTopBar {...props} />
            <Menu/>
            {children}
        </div>
    )
}

export default ApplicationLayout
