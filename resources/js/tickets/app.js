$(document).ready(function () {
    function setTicketErrors(errors) {
        if (errors['ticket_department']) {
            $('.help-ticket-department').html(errors['ticket_department'][0])
            $('.error-ticket-department').addClass('has-error')
        }
        if (errors['ticket_level']) {
            $('.help-ticket-level').html(errors['ticket_level'][0])
            $('.error-ticket-level').addClass('has-error')
        }
        if (errors['ticket_message']) {
            $('.help-ticket-message').html(errors['ticket_message'][0])
            $('.error-ticket-message').addClass('has-error')
        }
        if (errors['ticket_name']) {
            $('.help-ticket-name').html(errors['ticket_name'][0])
            $('.error-ticket-name').addClass('has-error')
        }
    }

    async function ticketCreate() {
        // Reset state
        $('#user_form_modal').find('div').removeClass('has-error')
        $('#user_form_modal').find('.help-block').html('')

        // User form
        let department = $('select[name="ticket_department"]').val()
        let category = $('select[name="ticket_category"]').val()
        let message = $('textarea[name="ticket_message"]').val()
        let name = $('input[name="ticket_name"]').val()
        let deadline = $('input[name="ticket_deadline"]').val()
        let level = $('select[name="ticket_level"]').val()
        let additional_departments = $('select[name="additional_departments[]"]').val()
        // Loading state
        $('#btn-ticket-create').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
        await helper.delay(1500)

        let ticketFormObject = {
            ticket_department: department,
            ticket_category: category,
            ticket_name: name,
            ticket_deadline: deadline,
            ticket_level: level,
            ticket_message: message,
            additional_departments: additional_departments
        };
 
        
        axios.post(`tickets/store`, ticketFormObject).then(res => {
            if (res.data) {
                $('.ticket-form').attr('action', `/admin/tickets/store`);
                $('.ticket-form').attr('method', 'post');
                $('.ticket-form').append(`<input type="hidden" name="_method" value="post" />`)
                $('.ticket-form').submit();
            }

        }).catch(err => {
            $('#btn-ticket-create').html('Create')
            if (err.response.data.errors) {
                let errors = err.response.data.errors;
                setTicketErrors(errors);
            }
        })
    }

    $('#login-form').on('keyup', function (e) {
        if (e.keyCode === 13) {
            userCreate()
        }
    })

    $('#btn-ticket-create').on('click', () => {
        ticketCreate();
    })

    $('#create-ticket').on('click', () => {
        let Cont = $('#ticket_form_modal');
        Cont.find('div').removeClass('has-error')
        Cont.find('.help-block').html('')
        $(':input', '#ticket_form_modal')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .prop('checked', false)
            .prop('selected', false);
        Cont.modal('show')
    })

    $('#btn-ticket-close').on('click', () => {
        let Cont = $('#ticket_form_modal');
        Cont.find('div').removeClass('has-error')
        Cont.find('.help-block').html('')
        Cont.modal('hide')
    })

    $('select[name="ticket_department"]').on('change', function (e) {
        let content = `<option value="">Custom</option>`;
        if (e.target.value != '') {
            $.ajax({
                url: `/admin/tickets/departments/${e.target.value}`,
                method: 'get',
                dataType: 'json',
            }).done(function (data) {
                if (data.length > 0) {
                    data.forEach(e => {
                        content = `${content} <option value="${e.id}">${e.name}</option>`
                    })
                    $('select[name="ticket_category"]').html(content);

                }
            });
        } else {
            $('select[name="ticket_category"]').html(content);
            $('.error-ticket-name').show();
        }
    })

    $('select[name="ticket_category"]').on('change', function (e) {
        if (e.target.value != '') {
            $('input[name="ticket_name"]').val('');
            $('.error-ticket-name').hide();

        } else {
            $('input[name="ticket_name"]').val('');
            $('.error-ticket-name').show();
        }
    })
});
