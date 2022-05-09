export const theme = (theme) => ({
  ...theme,
  borderRadius:"8px",
  colors: {
    ...theme.colors,
    primary: 'var(--color-primary)',
    primary25:'var(--color-light-gray)',
    primary50: 'var(--color-medium-gray)'
  },
})

export const styles = {
  control: (provided, state) => ({
    ...provided,
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
    padding: '0 6px'
  }),

  input: (provided, state) => {
    return ({
    ...provided,
    margin: '0px'
  })},
  indicatorSeparator: (provided, state) => ({
    ...provided,
    backgroundColor: '#EDEDED'
  }),
  indicatorsContainer: (provided, state) => ({
    ...provided,
  }),
  option: (provided, state) => {
    let backgroundColor = "#F2F2F2"

    return ({
      ...provided,
      fontWeight: "bold",
      textTransform: "uppercase",
      backgroundColor: state.isSelected ? "var(--color-primary)" : "#F2F2F2",
      "&:hover": {
        backgroundColor: state.isSelected ? "var(--color-primary)" : "var(--color-light-gray)",
        cursor: 'pointer'
      }
    })}
}

export default {
  styles,
  theme
}

