    const Card = ({ children, show = true }) => {

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
