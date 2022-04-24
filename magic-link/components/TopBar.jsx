import React from "react"

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
