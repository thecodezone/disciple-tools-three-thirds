import React from 'react'
import CreatableSelect from "react-select/creatable";
import RelationshipField from "./RelationshipField";

const CreatableRelationshipField = (props) => {
    return (<RelationshipField
        {...props}
        component={CreatableSelect}
        isClearable
    />)
}

export default CreatableRelationshipField
