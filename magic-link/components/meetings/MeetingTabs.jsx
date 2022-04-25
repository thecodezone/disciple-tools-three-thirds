import Tab from "../layout/Tab";
import {Tabs} from "react-foundation";
import React, {useContext} from "react";
import AppContext from "../../contexts/AppContext";
import MeetingContext from "../../contexts/MeetingContext";

const MeetingTabs = () => {
    const {translations} = useContext(AppContext)
    const {tab, tabs, setTab} = useContext(MeetingContext)
    const {LOOKING_BACK, LOOKING_UP, LOOKING_AHEAD} = tabs

    return (
        <Tabs>
            <Tab isActive={tab === LOOKING_BACK} onClick={() => setTab(LOOKING_BACK)}>
                <i className="icon fi-arrow-left"/>
                {translations.looking_back}
            </Tab>
            <Tab isActive={tab === LOOKING_UP}  onClick={() => setTab(LOOKING_UP)}>
                <i className="icon fi-arrow-up"/>
                {translations.looking_up}
            </Tab>
            <Tab isActive={tab === LOOKING_AHEAD}  onClick={() => setTab(LOOKING_AHEAD)}>
                <i className="icon fi-arrow-right"/>
                {translations.looking_ahead}
            </Tab>
        </Tabs>
    )
}

export default MeetingTabs
