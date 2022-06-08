import React from 'react'
import AsyncCreatableSelect from "react-select/async-creatable";

import RelationshipField from "./RelationshipField";

/**
 * A searchable multiselect field for DT relationships.
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
const CreatableRelationshipField = (props) => {
    return (<RelationshipField
        {...props}
        component={AsyncCreatableSelect}
        isMulti
        isClearable={false}
    />)
}

export default CreatableRelationshipField
