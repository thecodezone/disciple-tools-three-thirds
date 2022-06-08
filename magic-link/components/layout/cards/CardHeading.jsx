import classNames from "classnames";

/**
 * A card heading. For use in a card component.
 * @param children
 * @param className
 * @returns {JSX.Element}
 * @constructor
 */
const CardHeading = ({children, className}) => {
    return (
        <div className={classNames("card-heading card-divider align-justify align-middle", className)}>
            {children}
        </div>
    )
}

export default CardHeading
