'use strict'

let alertsButton = document.querySelector('#alerts-edit-button')

//sets up the dropdown button for the alerts editing menu

let alertsForm = document.querySelector('#alerts-form')

// let yellow_input = alertsForm.querySelector('input[name="yellow"]')
// let red_input = alertsForm.querySelector('input[name="red"]')

// let invisible_elems = document.querySelectorAll('.invisible')

setupAlertsComparisonValidator()

//sets up alert values js validation, so the yellow alert is always bigger than red
function setupAlertsComparisonValidator(){

    setupCustomInputMessages()

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


    let r_input = document.querySelector('#r-input')
    let y_input = document.querySelector('#y-input')

    r_input.addEventListener('input', handleRedInput)
    y_input.addEventListener('input', handleYellowInput)

    let redYellowDifference = 10

    function handleRedInput(event) {

        this.value = Math.min(this.value, this.parentNode.childNodes[5].value - redYellowDifference);
        let value = (this.value / parseInt(this.max)) * 100
        var children = this.parentNode.childNodes[1].childNodes;
        children[1].style.width = value + '%'; //inverse-left
        children[5].style.left = value + '%'; //range left
        let fixed_sign_val = value - 2
        children[7].style.left = value + '%'; children[11].style.left = fixed_sign_val + '%'; //thumb and sign
        children[11].childNodes[1].innerHTML = this.value; //sign value

        updateRedValues(parseInt(event.target.defaultValue), this.value)
        event.target.defaultValue = event.target.value
    }

    function handleYellowInput(event) {

        this.value = Math.max(this.value, this.parentNode.childNodes[3].value - (-redYellowDifference));
        let value = (this.value / parseInt(this.max)) * 100
        var children = this.parentNode.childNodes[1].childNodes;
        children[3].style.width = (100 - value) + '%'; //inverse-right
        children[5].style.right = (100 - value) + '%'; //range right
        children[9].style.left = value + '%'; children[13].style.left = value + '%'; //thumb and sign
        children[13].childNodes[1].innerHTML = this.value;//sign value

        updateYellowValues(parseInt(event.target.defaultValue), this.value)
        event.target.defaultValue = event.target.value

    }
}


