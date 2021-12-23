document.addEventListener("DOMContentLoaded", function () {

//permission for sent form via checkbox selection
    $('.js-checkbox-validate').change(function () {
        if (this.checked) {
            $(this).parents('form').find('.btn').prop('disabled', false)
        } else {
            $(this).parents('form').find('.btn').prop('disabled', true)
        }
    })

//permission for sent form via field validate check
    $('.js-field-validate').on('input', function () {
        $(this).parents('form').find('.btn').prop('disabled', !this.validity.valid);
    })

//mobile menu
    $('.mobile-menu-btn').click(function () {
        $('.header').toggleClass('active');
        $(this).toggleClass('active');
        $('.menu').toggleClass('open');
    })

//context menu in table
    $('.tools-btn').click(function () {
        var currentList = $(this).siblings('.tools-list');
        $(this).toggleClass('active');
        currentList.toggleClass('active');
        $('.tools-list').not(currentList).removeClass('active');
        $('.tools-btn').not(this).removeClass('active');
    })


    $(document).on('click', function (e) {
        if (!$(e.target).closest('.tools-list,.tools-btn').length) {
            $('.tools-list').removeClass('active');
            $('.tools-btn').removeClass('active');
        }
    })

//confirmations
    var notificationTimer = 0;

    $('.js-confirmation-btn').click(function (e) {
        e.preventDefault();
        if (this.hash) {
            $.fancybox.close();
            var targetNotification = $(this.hash + '.notification')

            clearTimeout(notificationTimer);
            $('.notification').removeClass('active').filter(this.hash).addClass('active');
            setTimeout(function () {
                targetNotification.removeClass('active');
            }, 3000)
        }
    })

    //tablesorter
    //$(".tablesorter").tablesorter();


    //load files
    $('.field-file input').change(function () {
        $(this).parents('.field-file').find('.field-file-text').text(this.files[0].name);
    })

    //tabs
    $('.unit-item').click(function () {
        var href = $(this).data('href');
        $('.unit-column-wide .unit-column-body').fadeIn(300);
        $(this).closest('.unit-column').next('.unit-column').find('.unit-column-body').hide().filter(href).fadeIn(300);
        $(this).addClass('active').siblings().removeClass('active');
    })


    var newBlockMarkup = '<div class="unit-text-item"><p><strong>#006-1</strong> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo</p><div class="unit-tеxt-controls"><button class="unit-text-btn unit-text-btn-up icon-carret-top" type="button"></button><button class="unit-text-btn unit-text-btn-down icon-carret-bottom active" type="button"></button><button class="unit-text-btn unit-text-btn-remove icon-trash-basket" type="button"></button></div></div>';


    //разукрашивание стрелок блоков в редакторе в зависимости от положения блока
    function paintArrows() {
        $('.unit-text-item').filter(':visible').each(function () {

            var upArrow = $(this).find('.unit-text-btn-up'),
                downArrow = $(this).find('.unit-text-btn-down');

            if ($(this).is(':first-child')) {
                upArrow.removeClass('active');
                downArrow.addClass('active');
            } else if ($(this).is(':last-child')) {
                upArrow.addClass('active');
                downArrow.removeClass('active');
            } else {
                upArrow.addClass('active');
                downArrow.addClass('active');
            }
        })
    }

    $('.unit-block').click(function () {
        //не знаю как разработчику удобнее подшружать разметку блока, может ajax-ом или ещё как. Поэтому в вёрстке добавляю демонстрационный блок;
        var contentWrapper = $('.unit-text').filter(':visible');
        let url = $(this).data('block-variant'),
            elements = $('#tq_result_page').find('[data-variant-id]'),
            data = [];
        if (elements.length > 0) {
            $.each(elements, function (index, value) {
                data.push($(this).data('variant-id'));
            })
        }

        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            type: "POST",             // Type of request to be send, called as method
            data: {
                variants: data
            },
            success: function (result) {
                contentWrapper.append(result);
                paintArrows();
                contentWrapper.animate({
                    scrollTop: contentWrapper.prop('scrollHeight')
                }, 1000)
            },
            error: function (result) {

                $('#tq-error').html(result.responseJSON.message);
                notificate('#tq-error')
            }
        });

    })
    $(document).ready(function () {
        paintArrows();
    })

    $('.unit-text').on('click', '.unit-text-btn-remove', function () {
        var block = $(this).closest('.unit-text-item');
        block.fadeOut(300, function () {
            block.remove();
            paintArrows();
        })
    })

    $('.unit-text').on('click', '.unit-text-btn-up', function () {
        if ($(this).is('.active')) {
            var block = $(this).closest('.unit-text-item'),
                contentWrapper = block.closest('.unit-text');
            block.prev('.unit-text-item').insertAfter(block);
            paintArrows();
            contentWrapper.scrollTop(block.position().top + contentWrapper.scrollTop())
        }
    })

    $('.unit-text').on('click', '.unit-text-btn-down', function () {
        if ($(this).is('.active')) {
            var block = $(this).closest('.unit-text-item'),
                contentWrapper = block.closest('.unit-text');
            block.next('.unit-text-item').insertBefore(block);
            paintArrows();
            contentWrapper.scrollTop(contentWrapper.scrollTop() + contentWrapper.outerHeight() - block.outerHeight())
        }
    })


});
