import React from 'react'
import AsyncCreatableSelect from "react-select/async-creatable";

import RelationshipField from "./RelationshipField";

const CreatableRelationshipField = (props) => {
    return (<RelationshipField
        {...props}
        component={AsyncCreatableSelect}
        isMulti
        isClearable={false}
    />)
}

export default CreatableRelationshipField
