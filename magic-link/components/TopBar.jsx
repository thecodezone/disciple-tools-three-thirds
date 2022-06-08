import React from "react"

/**
 * The top bar component.
 *
 * @param left
 * @param right
 * @returns {JSX.Element}
 * @constructor
 */
const TopBar = ({left, right}) => {
    return (
        <header className={"top-bar"}>
            {left ? <div className="top-bar-left">
                {left}
            </div> : ""}
            {right ?  <div className="top-bar-right">
                {right}
            </div> : ""}
        </header>
    )
}

export default TopBar
