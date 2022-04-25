import React, {Fragment, useContext, useEffect, useState} from 'react'
import MeetingContext from "../contexts/MeetingContext";
import MeetingTabs from "../components/meetings/MeetingTabs";
import Card from "../components/layout/cards/Card";
import {TabPanel, TabsContent} from "react-foundation";
import AppContext from "../contexts/AppContext";
import CardHeading from "../components/layout/cards/CardHeading";
import CardSection from "../components/layout/cards/CardSection";

const MeetingPage = () => {
    const {translations} = useContext(AppContext)
    const {meeting, tab, tabs, lookingBackContent} = useContext(MeetingContext)
    const {LOOKING_BACK, LOOKING_UP, LOOKING_AHEAD} = tabs

    return (
        <Fragment>
            <MeetingTabs />
            <main>
                <div className={"container"}>
                    <TabsContent>
                        <TabPanel isActive={tab === LOOKING_BACK}>
                            <Card>
                                <CardHeading>
                                    <h2>Description</h2>
                                </CardHeading>
                                <CardSection>
                                    <div dangerouslySetInnerHTML={{__html: lookingBackContent}} />
                                </CardSection>
                            </Card>
                        </TabPanel>
                        <TabPanel isActive={tab === LOOKING_UP}>
                            <Card>
                                <CardHeading>
                                    <h2>Looking Up</h2>
                                </CardHeading>
                            </Card>
                        </TabPanel>
                        <TabPanel isActive={tab === LOOKING_AHEAD}>
                            <Card>
                                <CardHeading>
                                    <h2>Looking Ahead</h2>
                                </CardHeading>
                            </Card>
                        </TabPanel>
                    </TabsContent>
                </div>
            </main>
        </Fragment>
    )
}

export default MeetingPage
