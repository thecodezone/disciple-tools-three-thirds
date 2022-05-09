import Alert from "./layout/Alert";
import {types} from 'react-alert'

const AlertTemplate = ({ style, options, message, close }) => {
    let theme = 'primary'
    switch (options.type) {
        case types.ERROR:
            theme = 'alert'
            break;
        case types.INFO:
            theme = 'primary'
            break;
        case types.SUCCESS:
            theme = 'success'
            break;
    }
    return (<div style={style} className={"react-alert"}>
        <Alert theme={theme} size={"small"} className={"margin-bottom-0"}>
            {message}
        </Alert>
    </div>)
}

export default AlertTemplate
