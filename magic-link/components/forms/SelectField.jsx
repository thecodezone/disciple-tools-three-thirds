import React from 'react'
import Select from 'react-select'

export const SelectField = ({options, field, form,}) => {
    const height = '49px';

    return (<Select
        options={options}
        name={field.name}
        value={options ? options.find(option => option.value === field.value) : ''}
        onChange={(option) => form.setFieldValue(field.name, option.value)}
        onBlur={field.onBlur}
        theme={(theme) => ({
            ...theme,
            borderRadius:"8px",
            colors: {
                ...theme.colors,
                primary: 'var(--color-primary)',
                primary25:'var(--color-light-gray)',
                primary50: 'var(--color-medium-gray)'
            },
        })}
        isSearchable
        styles={{
            control: (provided, state) => ({
                ...provided,
                height,
                boxShadow: state.isFocused ? "0 0 5px var(--color-primary)" : "inset 0 1px 1px rgb(10 10 10 / 10%)",
                backgroundColor: state.isFocused ? 'var(--color-white)' : 'var(--color-light-gray)',
                borderColor: state.isFocused ? 'var(--color-primary)' : '#EDEDED',
                border: "1px solid #EDEDED",
                color: "var(--color-medium-gray)",
                fontWeight: "bold",
                textTransform: "uppercase",
                paddingLeft: "8px"
            }),

            valueContainer: (provided, state) => ({
                ...provided,
                height,
                padding: '0 6px'
            }),

            input: (provided, state) => ({
                ...provided,
                margin: '0px',
            }),
            indicatorSeparator: (provided, state) => ({
                ...provided,
                backgroundColor: '#EDEDED'
            }),
            indicatorsContainer: (provided, state) => ({
                ...provided,
                height,
            }),
            option: (provided, state) => {
                return ({
                ...provided,
                fontWeight: "bold",
                textTransform: "uppercase",
                backgroundColor: state.isSelected ? "var(--color-primary)" : "#F2F2F2"
            })}
        }}
    />)
}

export default SelectField
