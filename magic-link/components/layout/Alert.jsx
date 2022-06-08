import React from "react";
import classNames from "classnames";

/**
 * A dismissible alert
 *
 * @param theme
 * @param size
 * @param children
 * @param message
 * @param className
 * @param active
 * @returns {JSX.Element|string}
 * @constructor
 */
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
