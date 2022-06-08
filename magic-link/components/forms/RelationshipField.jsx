import SelectField from "./SelectField";
import React, {useEffect, useState, Fragment} from "react";
import AsyncSelect from "react-select/async";

/**
 * A searchable relationship multiselect field.
 *
 * @param excludeOptions
 * @param request
 * @param optionProp
 * @param optionMap
 * @param labelField
 * @param valueField
 * @param component
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
const RelationshipField = ({
                               excludeOptions = [],
                               request = false,
                               options: optionProp = [],
                               optionMap = null,
                               labelField = 'label',
                               valueField = 'value',
                                component = null,
                               ...props
                           }) => {
    if (!optionMap) {
        optionMap = (option) => ({
            label: option[labelField],
            value: option[valueField]
        })
    }

    const loadOptions = (inputValue, callback) => {
        const fire = async () => {
            if (!request) {
                callback([])
                return
            }

            try {
                const results = await request({q: inputValue})
                if (!results.posts) {
                    console.log(results)
                    callback([])
                    return
                }
                if (typeof results.posts === "object") {
                    results.posts = Object.values(results.posts)
                }
                callback(results.posts.filter(({value}) => {
                    return !excludeOptions.includes((parseInt(value)))
                }).map(optionMap))
            } catch (ex) {
                console.log(ex)
                callback([])
            }
        }

        fire()
    }


    return <Fragment>
        <SelectField {...props}
                     cacheOptions
                     defaultOptions
                     loadOptions={loadOptions}
                     component={component ? component : AsyncSelect}
        />
    </Fragment>

}

export default RelationshipField
