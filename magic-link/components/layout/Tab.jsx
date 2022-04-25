import {TabItem} from "react-foundation";
import React, {Fragment} from "react";

const Tab = ({isActive, children, ...props}) => {
    return  <TabItem {...props} isActive={isActive}>
        <a aria-selected={isActive}>{children}</a>
    </TabItem>
}

export default Tab;
