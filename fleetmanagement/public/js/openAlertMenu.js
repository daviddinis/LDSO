'use strict'

let alertsButton = document.querySelector('#alerts-edit-button')

//sets up the dropdown button for the alerts editing menu

let alertsForm = document.querySelector('#alerts-form')

let yellow_input = alertsForm.querySelector('input[name="yellow"]')
let red_input = alertsForm.querySelector('input[name="red"]')

// let invisible_elems = document.querySelectorAll('.invisible')

setupAlertsComparisonValidator()

//sets up alert values js validation, so the yellow alert is always bigger than red
function setupAlertsComparisonValidator(){
    

    yellow_input.addEventListener('change', updateRedMax)
    red_input.addEventListener('change', updateYellowMin)

    setupCustomInputMessages()

    //updates red input's max value to current yellow value, also updating display values
    function updateRedMax(event){

        let yellow_value = parseInt(event.target.value)      
        if (isNewValueValid(yellow_value, yellow_input)) {
            red_input.setAttribute("max", yellow_value - 1)
            updateYellowValues(parseInt(event.target.defaultValue), yellow_value)
            event.target.defaultValue = event.target.value
        }
        else event.target.value = event.target.defaultValue
    }

    //updates yellow input's min value to current red value, also updating display values
    function updateYellowMin(event) {

        let red_value = parseInt(event.target.value)

        if (isNewValueValid(red_value, red_input)) {

            yellow_input.setAttribute("min", red_value + 1)
            updateRedValues(parseInt(event.target.defaultValue), red_value)
            event.target.defaultValue = event.target.value
        }
        else event.target.value = event.target.defaultValue
    }

    document.addEventListener("DOMContentLoaded", function () {
    })

    //sets up custom messages when the user tries to insert a red alert bigger than the yellow alert...
    //... or a yellow alert that's smaller than the red alert
    function setupCustomInputMessages(){

        let alertsInputs = alertsForm.querySelectorAll('input')
        for (let i = 0; i < alertsInputs.length; i++) {
            alertsInputs[i].oninvalid = enableCustomAlertMessage
            alertsInputs[i].oninput = disableCustomAlertMessage
        }

        function enableCustomAlertMessage(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid && yellow_input.value <= red_input.value) {
                e.target.setCustomValidity("The yellow alert's time must be bigger than the red alert's time");
            }
        }

        function disableCustomAlertMessage(e){
            e.target.setCustomValidity("");
        }
    }

    function updateYellowValues(old_value, new_value) {

        let yellow_values = document.querySelectorAll('.daysYellow')
        findAndUpdateAlertValues(yellow_values, old_value, new_value)
    }

    function updateRedValues(old_value, new_value) {

        let red_values = document.querySelectorAll('.daysRed')
        findAndUpdateAlertValues(red_values, old_value, new_value)
    }
    //updates display values of days till alert for each category.
    //If new value is bigger, then there are fewer days to reach it 
    //ex: yellow alert is set to 90 days before the expiration date. Therefore, increasing it to 100 days means
    //we are now 10 days close to the alert
    function findAndUpdateAlertValues(elems, old_value, new_value) {

        let value_difference = old_value - new_value
        elems.forEach(updateAlertValue, value_difference);
    }

    function updateAlertValue(alertValueElement, index) {
        
        let alert_value_difference = this

        let value = alertValueElement.innerHTML
        let value_num_string = value.replace(/\s/g, '').replace('days', '')
        let num_value = parseInt(value_num_string)

        let new_alert_value = num_value + alert_value_difference

        alertValueElement.innerHTML = new_alert_value.toString() + ' days'
    }

    //checks if the new value respects the current max and min
    function isNewValueValid(new_value, input){
        return new_value >= parseInt(input.getAttribute("min")) && new_value <= parseInt(input.getAttribute("max"))
    }
}