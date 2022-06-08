/**
 * A card section. For use in a card component.
 *
 * @param children
 * @param show
 * @returns {JSX.Element|null}
 * @constructor
 */
const CardSection = ({children, show = true}) => {

    if (!show) {
        return null
    }

    return <div className={"card-section"}>
        {children}
    </div>
}

export default CardSection
