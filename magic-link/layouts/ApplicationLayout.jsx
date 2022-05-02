import TopBar from "../components/TopBar";
import Menu from '../components/Menu'
import ApplicationTopBar from "../components/ApplicationTopBar";

const ApplicationLayout = ({children, title, breadcrumbs}) => {
    return (
        <div id="layout">
            <ApplicationTopBar title={title}
                               breadcrumbs={breadcrumbs}/>
            <Menu/>
            {children}
        </div>
    )
}

export default ApplicationLayout
