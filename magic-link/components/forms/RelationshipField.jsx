import SelectField from "./SelectField";
import React, {useEffect, useState, Fragment} from "react";

const RelationshipField = ({
                               excludeOptions = [],
                               request = false,
                               options: optionProp = [],
                               optionMap = null,
                               labelField = 'label',
                               valueField = 'value',
                               ...props
                           }) => {
    const [options, setOptions] = useState(optionProp)

    if (!optionMap) {
        optionMap = (option) => ({
            label: option[labelField],
            value: option[valueField]
        })
    }

    const makeRequest = async () => {
        if (!request) {
            return
        }

        try {
            const results = await request()
            if (!results.posts) {
                console.log(results)
                return
            }
            if (typeof results.posts === "object") {
                results.posts = Object.values(results.posts)
            }
            setOptions(results.posts.filter(({value}) => {
                return !excludeOptions.includes((parseInt(value)))
            }).map(optionMap))
        } catch (ex) {
            console.log(ex)
        }
    }

    useEffect(async () => {
        return await makeRequest()
    }, [request])

    if (!options.length) {
        return null
    }


    return <Fragment>
        <SelectField {...props}
                     options={options}
        />
    </Fragment>

}

export default RelationshipField
