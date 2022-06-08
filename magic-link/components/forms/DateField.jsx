import React, {useState, Fragment} from "react";
import "react-dates/initialize";
import {SingleDatePicker} from "react-dates";
import "react-dates/lib/css/_datepicker.css";
import moment from 'moment'
import HandleFieldChange from "./HandleFieldChange";
import CardSection from "../layout/cards/CardSection";

/**
 * A datepicker field.
 * @see https://github.com/react-dates/react-dates
 * @param setFieldValue
 * @param values
 * @param field
 * @param onChange
 * @returns {JSX.Element}
 * @constructor
 */
const DateField = ({
                       form: {setFieldValue, values},
                       field,
                       onChange
                   }) => {

    const [focused, setFocused] = React.useState();
    const handleDateChange = (date) => {
        setFieldValue(field.name, date ? date.unix() : null);
    };
    const timestamp = values[field.name]?.timestamp ? values[field.name]?.timestamp : values[field.name]
    const date = timestamp ? moment.unix(timestamp) : null

    return (
        <Fragment>
            {onChange ? <HandleFieldChange name={field.name}
                               onChange={onChange}/> : null }
            <SingleDatePicker
                date={date}
                onDateChange={handleDateChange}
                focused={focused}
                numberOfMonths={1}
                onFocusChange={({focused}) => setFocused(focused)}
            />
        </Fragment>
    );
};

export default DateField;
