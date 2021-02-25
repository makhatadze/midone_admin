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
    const FILTERS = {
        'status': 'filter-ticket-status',
        'department': 'filter-ticket-department'
    };

    $('<select class="status-select"/>').appendTo('#add');

    let statusSelect = $('.status-select');
    let inputStyle = getDropdownStyle();

    inputStyle.right = '310px';

    statusSelect.css(inputStyle);

    let StatusOptions = "<option value=''>Choose Status</option>"
            + "<option value='success'>Success</option>"
            + "<option value='pending'>Pending</option>"
            + "<option value='closed'>Closed</option>"


    statusSelect.append(StatusOptions);

    // set current value of select.
    setDatatableDropdownValue(FILTERS.status, statusSelect, ['', 'success', 'pending', 'closed']);

    statusSelect.on('change', function () {
        // some TODOS here.
        let status = $(this).val();
        document.cookie = FILTERS.status + '=' + encodeURIComponent(status.trim());
        window.location.reload();
    });


    // Create Search bar for departments
    $('<select id="department_search" class="department_select"/>').appendTo('#add');
    let departmentSelect = $('.department_select');
    inputStyle.right = '460px';
    departmentSelect.css(inputStyle);

    // Populate departments from ajax call
    populateDatatableDropwdown(departmentSelect, true, FILTERS.department);
    departmentSelect.on('change', function () {
        let departmentId = $(this).val();
        document.cookie = FILTERS.department + '=' + encodeURIComponent(departmentId);
        window.location.reload();
    });
}

function getFilterFromCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");

    // Loop through the array elements
    for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");

        /* Removing whitespace at the beginning of the cookie name
         and compare it with the given string */
        if (name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }

    // Return null if not found
    return null;
}

function populateDatatableDropwdown(element, setSeleceted = false, filter = '')
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: "departments/list",
        data: {
            '_token': csrfToken
        },
        success: function (response) {
            var opt = '<option value="">Choose Department</option>';
            let keys = [];
            for (var i = 0; i < response.length; i++) {
                let departmentId = String(response[i].id);
                keys.push(departmentId);
                opt += '<option value="' + departmentId + '">' + response[i].name + '</option>';
            }
            element.append(opt);
            // Set selected values if exists
            if (setSeleceted) {
                setDatatableDropdownValue(filter, element, keys);
            }
        }
    });
}

function getDropdownStyle() {

    let imgX = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='rgb(74, 85, 104)' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-down'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E";

    return {
        'position': 'absolute',
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
    };
}

function setDatatableDropdownValue(filterName, dropdownElement, availableKeys) {
    let filteredOption = getFilterFromCookie(filterName);
    availableKeys.includes(filteredOption) ? dropdownElement.val(filteredOption) : dropdownElement.val('');
}