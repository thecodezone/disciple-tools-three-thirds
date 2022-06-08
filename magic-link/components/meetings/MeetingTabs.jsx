import Tab from "../layout/Tab";
import {Tabs} from "react-foundation";
import React, {useContext, useEffect} from "react";
import AppContext from "../../contexts/AppContext";
import MeetingContext from "../../contexts/MeetingContext";
import classNames from "classnames";

/**
 * The meetings tabs.
 * @prop tabs THe array of tab [{key, translation, icon}]
 * @prop active
 * @returns {JSX.Element}
 * @constructor
 */
const MeetingTabs = (props) => {
    let {
        tabs = [],
        active = ''
    } = props

    /**
     * @see /utilities/translations.php
     */
    const {translations} = useContext(AppContext)

    /**
     * The tab state is stored in the meeting context.
     * @see https://reactjs.org/docs/context.html
     */
    const {tab, tabs: availableTabs, setTab} = useContext(MeetingContext)
    if (!tabs.length) {
        tabs = availableTabs.map(t => t.key)
    }
    if (!active) {
        active = tabs[0]
    }
    tabs = tabs.map(key => availableTabs.find(item => item.key === key))

    /**
     * Set the tab by key
     * @param key
     */
    const setTabByKey = (key) => {
        setTab(availableTabs.find(item => item.key === key))
    }

    /**
     * WHen the active tab changes, update the context
     */
    useEffect(() => {
        setTabByKey(active)
    }, [active])

    return (
        <Tabs>
            {
                tabs.map(({key, translation, icon}) => <Tab key={key}
                isActive={tab.key === key}
                onClick={() => setTabByKey(key)}>
                <i className={classNames('icon', icon)}/>
            {translations[translation]}
                </Tab>)
            }
        </Tabs>
    )
}

export default MeetingTabs
