import React from 'react'
import ReactSelect from 'react-select'
import {theme, styles} from '../../src/reactSelectStyles'
export const SelectField = ({options, onChange = () => {}, field, form, component = ReactSelect}) => {
    const height = '49px';

    const Select = component

    return (<Select
        options={options}
        name={field.name}
        value={options ? options.find(option => option.value === field.value) : ''}
        onChange={(option, meta) => {
            form.setFieldValue(field.name, option.value)
            onChange(option, meta)
        }}
        onBlur={field.onBlur}
        theme={theme}
        isSearchable
        styles={styles}
    />)
}

export default SelectField
