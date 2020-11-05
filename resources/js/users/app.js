$(document).ready(function () {
    function setErrors(errors) {
        if (errors['first_name']) {
            $('.help-user-first_name').html(errors['first_name'][0])
            $('.error-user-first_name').addClass('has-error')
        }
        if (errors['last_name']) {
            $('.help-user-last_name').html(errors['last_name'][0])
            $('.error-user-last_name').addClass('has-error')
        }
        if (errors['email']) {
            $('.help-user-email').html(errors['email'][0])
            $('.error-user-email').addClass('has-error')
        }
        if (errors['birthday']) {
            $('.help-user-birthday').html(errors['birthday'][0])
            $('.error-user-birthday').addClass('has-error')
        }
        if (errors['password']) {
            $('.help-user-password').html(errors['password'][0])
            $('.error-user-password').addClass('has-error')
        }
        if (errors['password_confirmation']) {
            $('.help-user-password_confirmation').html(errors['password_confirmation'][0])
            $('.error-user-password_confirmation').addClass('has-error')
        }
    }

    async function userCreate() {
        // Reset state
        $('#user_form_modal').find('div').removeClass('has-error')
        $('#user_form_modal').find('.help-block').html('')

        // User form
        let first_name = $('input[name="first_name"]').val()
        let last_name = $('input[name="last_name"]').val()
        let phone = $('input[name="phone"]').val()
        let country = $('select[name="country"]').val()
        let birthday = $('input[name="birthday"]').val()
        let email = $('input[name="email"]').val()
        let password = $('input[name="password"]').val()
        let password_confirm = $('input[name="password_confirmation"]').val()
        let role = $('select[name="user_role"]').val();
        let permissions = []
        $.each($("input[name='permissions[]']:checked"), function () {
            permissions.push($(this).val());
        });
        let data =
            // Loading state
            $('#btn-user-create').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
        await helper.delay(1500)
        let user_id = $('input[name="user_id"]').val();
        if (user_id != '') {
            axios.put(`users/${user_id}`, {
                first_name: first_name,
                last_name: last_name,
                phone: phone,
                country: country,
                birthday: birthday,
                email: email,
                password: password,
                password_confirmation: password_confirm,
                role: role,
                permissions: permissions
            }).then(res => {
                if (res.data) {
                    $('.user-form').attr('action', `/admin/users/${user_id}`);
                    $('.user-form').attr('method', 'post');
                    $('.user-form').append(`<input type="hidden" name="_method" value="put" />`)
                    $('.user-form').submit();
                }
            }).catch(err => {
                $('#btn-user-create').html('Update')
                if (err.response.data.errors) {
                    let errors = err.response.data.errors;
                    setErrors(errors);
                }
            })
        } else {
            axios.post(`users/store`, {
                first_name: first_name,
                last_name: last_name,
                phone: phone,
                country: country,
                birthday: birthday,
                email: email,
                password: password,
                password_confirmation: password_confirm,
                role: role,
                permissions: permissions
            }).then(res => {
                if (res.data) {
                    $('.user-form').attr('action', `/admin/users/store`);
                    $('.user-form').attr('method', 'post');
                    $('.user-form').append(`<input type="hidden" name="_method" value="post" />`)
                    $('.user-form').submit();
                }

            }).catch(err => {
                $('#btn-user-create').html('Create')
                if (err.response.data.errors) {
                    let errors = err.response.data.errors;
                    setErrors(errors);
                }
            })
        }
    }

    $('#login-form').on('keyup', function (e) {
        if (e.keyCode === 13) {
            userCreate()
        }
    })

    $('#btn-user-create').on('click', () => {
        userCreate();
    })


    // $('#permissions_box').hide(); // hide all boxes


    $('#btn-close').on('click', () => {
        let Cont = $('#user_form_modal');
        Cont.find('div').removeClass('has-error')
        Cont.find('.help-block').html('')
        Cont.modal('hide')
    })

    $('#create-user').on('click', function () {
        let Cont = $('#user_form_modal');
        Cont.find('div').removeClass('has-error')
        Cont.find('.help-block').html('')
        $('#user-form-title').text('User Create')
        $('#btn-user-create').text('create')
        $(':input', '#user_form_modal')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .prop('checked', false)
            .prop('selected', false);
        $('input[name="user_id"]').val('')
        Cont.modal('show')

    })

    $('.user-edit').on('click', (e) => {
        let Cont = $('#user_form_modal');
        $(':input', '#user_form_modal')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .prop('checked', false)
        let list = $('.permissions_checkbox_list');

        list.empty();
        $('input[name="user_id"]').val(e.target.id)
        $('#user-form-title').text('User Update')

        $('#btn-user-create').text('update')
        $.ajax({
            url: `/admin/users/${e.target.id}/edit`,
            method: 'get',
            dataType: 'json',
        }).done(function (data) {
            if (data.profile) {
                $('input[name="first_name"]').val(data.profile.first_name)
                $('input[name="last_name"]').val(data.profile.last_name)
                $('input[name="phone"]').val(data.profile.phone)
                $('select[name="country"]').val(data.profile.country).trigger('change')
                $('input[name="birthday"]').val(data.profile.birthday)
            }
            $('input[name="email"]').val(data.user.email)
            $('input[name="password"]').val('')
            $('input[name="password_confirmation"]').val('')

            if (data.allRoles) {
                let content = '';
                data.allRoles.forEach(function (el) {
                    if (data.roles.length > 0) {
                        if (data.roles[0].id == el.id) {
                            content = `${content} <option selected value="${el.id}">${el.name}</option>`
                        } else {
                            content = `${content} <option value="${el.id}">${el.name}</option>`
                        }
                    } else {
                        content = `${content} <option value="${el.id}">${el.name}</option>`
                    }
                    $('.roles-container').html(`
                    <select name="user_role" class="select2 w-full" id="roles-select2" onchange="roleChange(event)">
                                    <option value="0">Select Role...</option>
                                    ${content}
                    </select>`)
                })
                $('#roles-select2').select2()
            }

            if (data.roles.length > 0) {
                if (data.rolePermissions.length > 0) {
                    let content = '';
                    data.rolePermissions.forEach(function (el) {
                        content = `${content} <div class="flex items-center text-gray-700 mt-2">
                      <input type="checkbox" name="permissions[]" value="${el.id}" id="checkbox-${el.id}" class="input border mr-2" >
                      <label class="cursor-pointer select-none" for="vertical-checkbox-chris-evans">${el.name}</label>
                    </div>`
                    })
                    list.html(content)
                }

                if (data.permissions.length > 0) {
                    data.permissions.forEach(function (el) {
                        $(`#checkbox-${el.id}`).prop('checked', true)
                    })
                }
            }
            Cont.modal('show')
        });
    })

    $('.user-view').on('click', (e) => {
        let Cont = $('#user_view_modal');
        $(':input', '#user_view_modal')
            .val('')
        $.ajax({
            url: `/admin/users/${e.target.id}`,
            method: 'get',
            dataType: 'json',
        }).done(function (data) {
            $('.view-fullName').text(data.user.name)
            $('.view-birthday').text(data.profile.birthday)
            $('.view-email').text(data.user.email)
            if (data.country.length) {
                $('.view-country').text(data.country[0].name)

            }
            $('.view-phone').text(data.profile.phone)
            if (data.roles.length > 0) {
                let roles = data.roles[0].name;
                $('.view-role').text(roles)
            }
            if (data.permissions.length > 0) {
                let permissions = ``;
                data.permissions.forEach(function (el) {
                    (!permissions) ? permissions = `${el.name}` : permissions = `${permissions}, ${el.name}`
                })
                $('.view-permissions').text(permissions)

            }
        });
        Cont.modal('show')
    })
    $('#btn-view-close').on('click', function () {
        $('#user_view_modal').modal('hide')

    })
});
