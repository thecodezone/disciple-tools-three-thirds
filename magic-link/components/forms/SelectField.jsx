import React, {Fragment} from 'react'
import ReactSelect from 'react-select'
import {theme, styles} from '../../src/reactSelectStyles'
import {useFormikContext} from "formik";
import {useInitialized, useTimer} from "../../src/hooks";
import HandleFieldChange from "./HandleFieldChange";

export const SelectField = ({
                            options,
                            isMulti = false,
                            onChange = () => {},
                            field,
                            form,
                            component = ReactSelect,
                            defaultValue
                        }) => {

    const {initialValues, values} = useFormikContext()
    const Select = component


    const getValue = () => {
        let current = field.value ? field.value : values[field.name]

        if (options) {
            return isMulti
                ? options.filter(option => current.includes(option.value))
                : options.find(option => option.value === current);
        } else {
            return isMulti ? [] : "";
        }
    }

    return (<Fragment>
        <Select
            className={"react-select"}
            options={options}
            name={field.name}
            defaultValue={defaultValue ? defaultValue : getValue()}
            onChange={(option, meta) => {
                form.setFieldValue(
                    field.name,
                    isMulti
                        ? option.map(item => item.value)
                        : option.value
                )
            }}
            theme={theme}
            isSearchable
            styles={styles}
            isMulti={isMulti}
            isClearable={false}
        />
        <HandleFieldChange name={field.name}
                           onChange={onChange}/>
    </Fragment>)
}

export default SelectField
