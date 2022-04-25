import Card from "../components/layout/cards/Card";
import Brand from "../components/Brand";
import CardSection from "../components/layout/cards/CardSection";
import React from "react";

const AuthLayout = ({children}) => {
    return (<main className="container auth">
        <Card>
            <CardSection>
                <Brand className={"auth__brand"}/>
            </CardSection>
            <CardSection>
                {children}
            </CardSection>
        </Card>
    </main>)
}

export default AuthLayout
