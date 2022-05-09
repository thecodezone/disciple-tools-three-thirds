import React from 'react'
import CreatableSelect from "react-select/creatable";
import RelationshipField from "./RelationshipField";

const CreatableRelationshipField = (props) => {
    return (<RelationshipField
        {...props}
        component={CreatableSelect}
        isMulti
        isClearable={false}
    />)
}

export default CreatableRelationshipField
