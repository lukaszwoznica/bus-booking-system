document.addEventListener("DOMContentLoaded", () => {
    const singleRideDateInput = document.querySelector('#ride-date');
    const cyclicRideStartDateInput = document.querySelector('#start-date');
    const cyclicRideEndDateInput = document.querySelector('#end-date');
    const daysCheckboxes = document.querySelectorAll('.day-checkbox');
    const rideTypeRadioButtons = document.querySelectorAll('input[type=radio][name="ride_type"]')

    rideTypeRadioButtons.forEach(radioButton => {
        radioButton.addEventListener('change', () => {
            singleRideDateInput.disabled = !singleRideDateInput.disabled
            cyclicRideStartDateInput.disabled = !cyclicRideStartDateInput.disabled
            cyclicRideEndDateInput.disabled = !cyclicRideEndDateInput.disabled
            daysCheckboxes.forEach(checkbox => {
                checkbox.disabled = !checkbox.disabled
            })
        })
    })
})
