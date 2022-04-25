import Meetings from "../components/meetings/Meetings";
import Card from "../components/layout/cards/Card";
import CardSection from "../components/layout/cards/CardSection";

const Dashboard = () => {
    return (<main className={"dashboard"}>
        <div className={"container"}>
            <Card>
                <CardSection>
                    <Meetings />
                </CardSection>
            </Card>
        </div>

    </main>)
}

export default Dashboard
