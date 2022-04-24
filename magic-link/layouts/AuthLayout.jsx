import Card from "../components/Card";
import CardHeading from "../components/CardHeading";
import Brand from "../components/Brand";
import CardSection from "../components/CardSection";
import React from "react";

const AuthLayout = ({children}) => {
    return (<main className="container auth">
        <Card>
            <CardHeading>
                <Brand className={"auth__brand"}/>
            </CardHeading>
            <CardSection>
                {children}
            </CardSection>
        </Card>
    </main>)
}

export default AuthLayout
