'use strict'

let alertsButton = document.querySelector('#alerts-edit-button')

//sets up the dropdown button for the alerts editing menu
alertsButton.addEventListener('click', openAlertsMenu)

/* When the user clicks on the button,
hides or shows the dropdown content*/
function openAlertsMenu() {
    document.getElementById("myDropdown").classList.toggle("show");
    alertsButton.removeEventListener('click', openAlertsMenu)
    alertsButton.addEventListener('click', closeAlertsMenu)
}

window.addEventListener('click', function (e) {
    if (!document.querySelector('.dropdown').contains(e.target)) {
        closeAlertsMenu();
    }
})

// Closes the dropdown menu if the user clicks outside of it
function closeAlertsMenu() {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
    }

    alertsButton.removeEventListener('click', closeAlertsMenu)
    alertsButton.addEventListener('click', openAlertsMenu)
}