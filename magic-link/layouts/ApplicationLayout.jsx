import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

/**
 * Application Layout
 * @param children
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
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
