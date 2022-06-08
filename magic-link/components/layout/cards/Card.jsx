/**
 * A card component.
 *
 * @example
 * <Card>
 *     <CardHeader>My header</CardHeader>
 *     <CardSection>Card Content</CardSection>
 *     <CardFooter>Card Footer</CardFooter>
 * </card>
 *
 * @param children
 * @param show
 * @returns {JSX.Element|string}
 * @constructor
 */
const Card = ({children, show = true}) => {

    if (!show) {
        return ""
    }

    return (
        <div className="card">
            {children}
        </div>
    )
}

export default Card
