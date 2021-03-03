<script>
    window.addEventListener('load', function () {
        flatpickr('.datepicker', {
            allowInput: true,
            minDate: 'today',
            position: 'auto left',
            locale: {
                firstDayOfWeek: 1
            },
        });

        flatpickr('#departure-time', {
            allowInput: true,
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i",
            position: 'auto left',
        })

        $('#route').select2({
            placeholder: 'Select route',
            width: '100%'
        })

        $('#bus').select2({
            placeholder: 'Select bus',
            width: '100%'
        })
    })
</script>
