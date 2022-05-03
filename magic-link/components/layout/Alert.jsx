import React from "react";
import classNames from "classnames";

const Alert = ({theme = 'alert', size = "", children, message, className, active = true}) => {
    if (!active || (!children && !message)) {
        return "";
    }

    const classes = classNames("callout", theme, size, className)

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
