document.addEventListener("DOMContentLoaded", () => {
    const singleRideDateInput = document.querySelector('#ride-date');
    const cyclicRideStartDateInput = document.querySelector('#start-date');
    const cyclicRideEndDateInput = document.querySelector('#end-date');
    const daysCheckboxes = document.querySelectorAll('.day-checkbox');
    const rideTypeRadioButtons = document.querySelectorAll('input[type=radio][name="ride_type"]')
    const singleRideInputsWrapper = document.querySelector('#singleRideInputsWrapper')
    const cyclicRideInputsWrapper = document.querySelector('#cyclicRideInputsWrapper')

    rideTypeRadioButtons.forEach(radioButton => {
        radioButton.addEventListener('change', () => {
            singleRideDateInput.disabled = !singleRideDateInput.disabled
            cyclicRideStartDateInput.disabled = !cyclicRideStartDateInput.disabled
            cyclicRideEndDateInput.disabled = !cyclicRideEndDateInput.disabled
            daysCheckboxes.forEach(checkbox => {
                checkbox.disabled = !checkbox.disabled
            })
            if (singleRideInputsWrapper.style.display === 'none') {
                singleRideInputsWrapper.style.display = 'block'
                cyclicRideInputsWrapper.style.display = 'none'
            } else {
                singleRideInputsWrapper.style.display = 'none'
                cyclicRideInputsWrapper.style.display = 'block'
            }
        })
    })
})
