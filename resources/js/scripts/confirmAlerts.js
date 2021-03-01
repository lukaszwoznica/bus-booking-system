import Swal from 'sweetalert2'

window.deleteConfirm = function(formId, itemName = 'item') {
    Swal.fire({
        title: 'Are you sure?',
        text: `This ${itemName} will be permanently deleted.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#C82333',
        cancelButtonColor: '#212529',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit()
        }
    })
}

window.cancelBookingConfirm = function(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to cancel this booking?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#444444',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit()
        }
    })
}
