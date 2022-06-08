import React, {useContext} from "react";
import {useFormikContext} from "formik";
import AppContext from "../../contexts/AppContext";

/**
 * A submit button
 * @param children
 * @returns {JSX.Element}
 * @constructor
 */
const SubmitButton = ({children}) => {
    const {magicLink} = useContext(AppContext)
    const {isSubmitting} = useFormikContext()

    return (
        <button type="submit" className="submit success button" disabled={isSubmitting}>
            {children ? children : magicLink.translations.submit}
        </button>
    )
}

export default SubmitButton
