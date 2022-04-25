import Meetings from "../components/Meetings";
import Card from "../components/Card";
import CardSection from "../components/CardSection";

const Dashboard = () => {
    return (<main className={"dashboard"}>
        <Card>
            <CardSection>
                <Meetings />
            </CardSection>
        </Card>
    </main>)
}

export default Dashboard
