import Meetings from "../components/meetings/Meetings";
import Card from "../components/layout/cards/Card";
import CardSection from "../components/layout/cards/CardSection";
import ApplicationLayout from "../layouts/ApplicationLayout";
import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";
import {Button, ButtonGroup} from "react-foundation";
import {Link} from "react-router-dom";

const Dashboard = () => {
    const {magicLink, translations} = useContext(AppContext)

    return (<ApplicationLayout title={translations.title}>
        <main className={"dashboard"}>
            <div className={"container"}>
                <ButtonGroup isExpanded className={"margin-bottom-1"}>
                    <Link to={"/meetings/create"} className={"button"}>
                        {translations.create_meeting}
                    </Link>
                </ButtonGroup>
                <Card>
                    <CardSection>
                        <Meetings />
                    </CardSection>
                </Card>
            </div>

        </main>
    </ApplicationLayout>)
}

export default Dashboard
