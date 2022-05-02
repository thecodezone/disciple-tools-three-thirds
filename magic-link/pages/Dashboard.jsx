import Meetings from "../components/meetings/Meetings";
import Card from "../components/layout/cards/Card";
import CardSection from "../components/layout/cards/CardSection";
import ApplicationLayout from "../layouts/ApplicationLayout";
import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";

const Dashboard = () => {
    const {magicLink} = useContext(AppContext)

    return (<ApplicationLayout title={magicLink.translations.title}>
        <main className={"dashboard"}>
            <div className={"container"}>
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
