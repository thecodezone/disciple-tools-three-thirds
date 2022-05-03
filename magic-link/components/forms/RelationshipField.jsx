import SelectField from "./SelectField";
import {useEffect, useState} from "react";

const RelationshipField = ({request = false, options: optionProp = [], optionMap = null, labelField = 'label', valueField = 'value', ...props}) => {
    const [options, setOptions] = useState(optionProp)

    if (!optionMap) {
        optionMap = (option) => ({
            label: option[labelField],
            value: option[valueField]
        })
    }

    useEffect(async () => {
        if (!request) {
            return
        }

        try {
            const results = await request()
            if (!results.posts) {
                console.log(result)
                return
            }
            if (typeof results.posts === "object") {
                results.posts = Object.values(results.posts)
            }
            setOptions(results.posts.map(optionMap))
        } catch (ex) {
            console.log(ex)
        }

    }, [request])

    if (!options.length) {
        return null
    }

    return <SelectField {...props} options={options} />
}

export default RelationshipField
