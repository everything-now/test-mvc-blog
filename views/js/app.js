jQuery(function($){

    $('#form-register').on('submit', function() {

        var $form = $(this);

        $(this).find('.has-error').removeClass('has-error');
        $form.find('.help-block').text('');

        $.post($form.attr('action'), $form.serialize(), function(data) {
            
            window.location.replace('/');

        }, 'json')
        .fail(function(data) {
            $.each(data.responseJSON, function(el, index) {
                
                $form.find('[name="' + el + '"]').siblings('.help-block').text(index).parent().addClass('has-error');
            });

        });

        return false;
    });


    $('#form-login').on('submit', function() {

        var $form = $(this);

        $(this).find('.has-error').removeClass('has-error');
        $form.find('.help-block').text('');
        
        $.post($form.attr('action'), $form.serialize(), function(data) {

            window.location.replace('/');

        }, 'json')
        .fail(function(data) {
            $.each(data.responseJSON, function(el, index) {

                $form.find('[name="' + el + '"]').siblings('.help-block').text(index).parent().addClass('has-error');
            })

        });

        return false;
    });

    var formCreate = function() {
        
        var $form = $(this);
            
        $form.find('.has-error').removeClass('has-error');
        
        $.post($form.attr('action'), $form.serialize(), function(data) {

            var comment = $('.media:first').clone();

            $(comment).find('.media-object').attr('src', 'https://randomuser.me/api/portraits/men/' + data.user_id + '.jpg');
            $(comment).find('.author').text(data.user_name);
            $(comment).find('.date').text(data.created_at);
            $(comment).find('.media-text').text(data.body);
            $(comment).find('.form-create').hide();

            $(comment).find('.panel-footer').html('');

            if(data.parent_id){
                $('#' + data.parent_id).find('.media-body:first').append($('<div class="media" id="'+ data.id +'"></div>').append(comment.html()));
                $form.hide();
            } else {
                $('.title-comments').after($('<div class="media" id="'+ data.id +'"></div>').append(comment.html()));
            }

            $form.find('[name="body"]').val('');

            $('.count').text(+$('.count').text() + 1);

        }, 'json')
        .fail(function(data) {

            $form.find('[name="body"]').parent().addClass('has-error');

        });

        return false;
    };

    
    $('.form-create').on('submit', formCreate);


    $('.js-reply').on('click', function() {

        if(!window.user){
            return $('#login-modal').modal();
        }

        var $form = $('.form-create:first').clone();

        $form.append('<input name="parent_id" type="hidden" value="'+ $(this).data('id') +'">');

        $form = $(this).parent().parent().after(
                '<form action="/comment/create" class="form-create">' +
                $form.html() + 
                '</form>'
            );

        $form.next().on('submit', formCreate);

        return false;
    });


    $('.js-edit').on('click', function() {
        
        var formBody = $(this).parent().parent().find('.panel-body');

        form = formBody.html(
            '<form action="/comment/update" class="form-create">' +
            '<textarea class="form-control" name="body">'+ $.trim(formBody.text()) +'</textarea>' +
            '<input type="hidden" name="id" value="'+ $(this).data('id') +'" />' +
            '<button class="btn pull-right btn-md btn-success">Зберегти</button>' +
            '</form>'
            );

        form.children().on('submit', function() {
            
            var $form = $(this);

            $form.find('.has-error').removeClass('has-error');
            
            $.post($form.attr('action'), $form.serialize(), function(data) {
                
                $form.parent().html('<div class="media-text text-justify">'+ data.body +'</div>');

            }, 'json')
            .fail(function(data) {

                $form.find('[name="body"]').parent().addClass('has-error');

            });
            return false;
        });
        return false;
    });

    $('.js-delete').on('click', function() {
        
        var data = {id: $(this).data('id')};
        var comment = $(this).parent();

        $.post('comment/delete', data, function(data) {
            comment.parent().find('.media-text').addClass('text-danger').text(data.message);
            comment.hide();
            $('.count').text(+$('.count').text() - 1);

        }, 'json');

        return false;
    });


    $('.js-vote').on('click', function() {
        if(!window.user){
            return $('#login-modal').modal();
        }
        data = {
            id: $(this).parent().data('id'),
            value: $(this).data('value')
        };

        var $comment = $(this).parent();

        $.post('comment/vote', data, function(data) {
            if(data.value == '+'){
                $comment.find('.rating').text(+$comment.find('.rating').text() + 1);
            } else {
                $comment.find('.rating').text(+$comment.find('.rating').text() - 1);
            }

            $comment.append($('<span class="text-success">Ваш голос врахований</span>'));

        }, 'json')
        .fail(function(data) {
            $comment.append($('<span class="text-danger">'+ data.responseJSON.message +'</span>'));
        });

        return false;
    });

});