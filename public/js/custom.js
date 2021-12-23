$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function notificate(id) {
    let notificationTimer = 0;
    let targetNotification = $(id + '.notification')
    clearTimeout(notificationTimer);
    $('.notification').removeClass('active').filter(id).addClass('active');
    setTimeout(function () {
        targetNotification.removeClass('active');
    }, 3000)
}


$(document).on('submit', '#authForm', function () {
    $.ajax({
        url: $(this).attr('action'),
        data: $(this).serialize(),
        method: 'POST',
        success: function (data) {
            location.href = data.link;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            notificate('#remove-notification');
        }
    });
    return false;
});

$(document).on('click', '[data-submit]', function () {
    $('.content-block form').submit();
});

$(document).on('click', '[data-action]', function () {
    $('#remove-modal').attr('action', $(this).data('action'));
    $('#titleForm').text($(this).data('title'));
    $.fancybox.open({src: '#remove-modal', type: 'inline'});

})


$(document).on('click', '[data-delete]', function () {
    $.ajax({
        url: $('#remove-modal').attr('action'),
        data: $('#remove-modal').serialize(),
        method: $('#remove-modal').find('[name=_method]').length>0?$('#remove-modal').find('[name=_method]').val():'POST',
        success: function (data) {
            $('.table-block').html($(data).find('.table-block').html());
            $('.table-block .tools-btn').click(function () {
                var currentList = $(this).siblings('.tools-list');
                $(this).toggleClass('active');
                currentList.toggleClass('active');
                $('.tools-list').not(currentList).removeClass('active');
                $('.tools-btn').not(this).removeClass('active');
            })

            $.fancybox.close();
            notificate('#remove-notification');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            notificate('#remove-notification');
        }
    });
    return false;
})

$(document).on('click', '[data-sort-link]', function () {
    location.href = $(this).attr('data-sort-link');
});

$(document).on('change', '#fileChange', function () {
    for (var i = 0, f; f = this.files[i]; i++) {
        var reader = new FileReader();
        reader.onload = (function (f) {
            return function (e) {
                if ($('#previewImage').length > 0) {
                    $('#previewImage').attr('src', e.target.result);
                } else {
                    $('#previewBlocks').append('<img id="previewImage" src="' + e.target.result + '" alt="">')
                }
            }
        })(f);
        reader.readAsDataURL(f);
    }
})

$(document).on('click', '[data-status]', function () {
    $('#status').val($(this).attr('data-status'));
    $('.content-block form').submit();
})
$(document).on('click', '#tq_save_page', function () {
    let url = $(this).data('url'),
        elements = $('#tq_result_page').find('[data-variant-id]'),
        form = $('<form action="' + url + '" method="post">' +
            '<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">'+
            '</form>');
    $('body').append(form);

    if (elements.length > 0) {
        $.each(elements, function (index, value) {
            form.append('<input type="hidden" name="variants[]" value="' + $(this).data('variant-id') + '">')
        })
    }
    form.submit();
})

