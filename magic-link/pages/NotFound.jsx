import React, {useContext} from "react";
import AppContext from "../contexts/AppContext";
import Layout from '../layouts/Layout'
import Card from "../components/layout/cards/Card";
import CardHeading from "../components/layout/cards/CardHeading";
import CardSection from "../components/layout/cards/CardSection";

/**
 * 404
 * @returns {JSX.Element}
 * @constructor
 */
const NotFound = () => {
    const {magicLink} = useContext(AppContext)
    return (<Layout>
        <main style={{padding: "1rem"}}>
            <div className={"container"}>
                <Card>
                    <CardHeading>
                        <h1>{magicLink.translations.page_not_found}</h1>
                    </CardHeading>
                    <CardSection>
                        <a href={magicLink.redirect_url} className={"button"}>
                            <i className={"icon fi-home"} /> <span>{magicLink.translations.return_home}</span>
                        </a>
                    </CardSection>
                </Card>
            </div>
        </main>
    </Layout>)
}

export default NotFound
