/**
 * A card footer. For use in a card component.
 * @param children
 * @returns {JSX.Element}
 * @constructor
 */
const CardFooter = ({children}) => {
    return (
        <div className={"card-footer card-section"}>
            {children}
        </div>
    )
}

export default CardFooter
