import React from "react";
import classNames from "classnames";

const Alert = ({theme = 'alert', children, message, active = true}) => {
    if (!active || (!children && !message)) {
        return "";
    }

    const classes = classNames("callout", theme)

    if (message) {
        return (
            <div className={classes} dangerouslySetInnerHTML={{__html: message}} />
        )
    }

    return (<div className={classes}>
        { children }
    </div>)
}

export default Alert
