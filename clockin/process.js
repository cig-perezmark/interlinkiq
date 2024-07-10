$(document).ready(function() {
    $(document).on('click', '.get_clockin_records', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var date = $(this).data('date');
        
        $.ajax({
            url: 'clockin/api.php',
            type: 'POST',
            data: {
                id: id,
                date: date,
                get_records: true
            },
            success: function(response) {
                var records = JSON.parse(response);
                var tbody = $('#clockin_records_table tbody');
                tbody.empty();
                var totalMinutesSpan = 0;
                records.forEach(function(record, i) {
                    var notes = record.notes || '';
                    var row = `<tr>
                                <td> ${i + 1} </td>
                                <td> ${record.in_time} </td>
                                <td> ${record.out_time} </td>
                                <td> ${record.minutes_span} </td>
                                <td> ${notes} </td>
                                </tr>`;
                    tbody.append(row);
                    totalMinutesSpan += parseInt(record.minutes_span, 10);
                });
                $('#totalMinutes').html(totalMinutesSpan)
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });
})