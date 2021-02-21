import dt from 'datatables.net'
import dtResponsive from 'datatables.net-responsive-dt'

        (function ($) {
            "use strict";

            // Datatable
            $('.datatable').DataTable({
                dom: 'l<"#add">frtip',
                responsive: true,
                order: [[0, 'desc']]
            });
        })($);


let cPath = window.location.pathname.split('/');
let currentRoute = cPath[cPath.length - 1];


if (['tickets', 'tickets-all'].includes(currentRoute)) {
    var filterKey = 'filter-ticket-status'; 
    $('<select class="status-select"/>').appendTo('#add');

    let select = $('.status-select');
    let imgX = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='rgb(74, 85, 104)' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-down'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E";

    select.css({
        'position': 'absolute',
        'right': '310px',
        'top': '22px',
        'background-image': 'url("' + imgX + '")',
        'background-size': '15px',
        'background-position': "center right 0.6rem",
        'padding-top': "0.5rem",
        'padding-bottom': "0.5rem",
        'padding-left': "0.75rem",
        'padding-right': "0.75rem",
        'border-radius': "0.375rem",
        '-webkit-appearance': "none",
        '-moz-appearance': "none",
        'appearance': "none",
        'border-width': "1px",
        "margin-left": "0.5rem",
        "margin-right": "0.5rem",
        "--bg-opacity": "1",
        "background-color": "#fff",
        "background-color": 'rgba(255, 255, 255, var(--bg-opacity))',
        "background-repeat": "no-repeat",
        "padding-right": "2rem"
    });

    let options = "<option value=''>Choose Status</option>"
            + "<option value='success'>Success</option>" +
            "<option value='pending'>Pending</option>"
            + "<option value='closed'>Closed</option>"


    select.append(options);
    
    // set current value of select.
    let filteredOption = getFilterFromCookie(filterKey);
    ['','success','pending','closed'].includes(filteredOption) ? select.val(filteredOption) : select.val('');
     
    select.on('change', function () {
        // some TODOS here.
        let status = $(this).val();
        document.cookie = filterKey + '=' + encodeURIComponent(status.trim());
        window.location.reload();
    });

}

function getFilterFromCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    
    // Return null if not found
    return null;
}