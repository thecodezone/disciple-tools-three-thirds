import {TabItem} from "react-foundation";
import React, {Fragment} from "react";

/**
 * An individual tab
 *
 * @param isActive
 * @param children
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
const Tab = ({isActive, children, ...props}) => {
    return  <TabItem {...props} isActive={isActive}>
        <a aria-selected={isActive}>{children}</a>
    </TabItem>
}

export default Tab;
