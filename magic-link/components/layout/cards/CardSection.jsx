const CardSection = ({children, show = true}) => {

    if (!show) {
        return null
    }

    return <div className={"card-section"}>
        {children}
    </div>
}

export default CardSection
