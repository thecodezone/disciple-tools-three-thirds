import classNames from "classnames";

const CardHeading = ({children, className}) => {
    return (
        <div className={classNames("card-heading card-divider align-justify align-middle", className)}>
            {children}
        </div>
    )
}

export default CardHeading
