/**
 * Comment plugin
 */
;(function ($, document, window, undefined) {
    "use strict";

    var pluginName = 'comments';

    var defaults = {
        wrapperSelector: '.coderius.comments',
        formSelector: '.coderius.form',
        formButtonSelector: '.coderius.button',
        replyLinkSelector: '.actions .reply',
        commentSelectors: {
            commentBlockClass: '.comment',
            likeIconSelector: '.rating > i',
            likeCountSelector: '.rating > .like-count',
            emptyLikeClass: 'outline' //style to not clicked like by current user
        },
        formSelectors: {
            hiddenInputParentId: 'input:hidden[name=parentId]'
        },
    };

    var formSelectors = {
        errorClass: 'error',
        field: '.field',
        fieldError: '.field.error',
        fieldValidationErrorWrapper: '.field-validation-error-wrapper',
        fieldValidationErrorWrapperItem: '.field-validation-error-wrapper p',

    };

    var selectors = {
        spinnerClass: 'loading'
    };

    var methods = {
        init: function (options) {
            return this.each(function () {
                var settings = $.extend({}, defaults, options || {}),
                    $wrapper = $(this),
                    formSelector = settings.formSelector,
                    formButtonSelector = settings.formButtonSelector,
                    replyLinkSelector = settings.replyLinkSelector,
                    likeIconSelector = settings.commentSelectors.likeIconSelector,
                    $form = $(formSelector),
                    formAction = $form.attr('action'),
                    formMethod = $form.attr('method');

                var formHendlerDTO = {
                    $form: $form, 
                    formAction: formAction, 
                    formMethod: formMethod,
                    settings: settings
                };

                var replyDTO = {
                    $form: $form, 
                    formAction: formAction, 
                    formMethod: formMethod,
                    settings: settings
                };

                var likeDTO = {
                    settings: settings
                };

                $wrapper.on('click.like.icon', likeIconSelector, likeDTO, likeComment);
                $wrapper.on('click.reply.link', replyLinkSelector, replyDTO, replyComment);
                $wrapper.on('click.form.button', formButtonSelector, formHendlerDTO, createComment);
            });
        },
        beforeCreate: function (params) {
            return console.log(params);
        },
        afterCreate: function (params) {
            return console.log(params);
        },
    };

/**
 * Create comment from form
 * @param {string} action. Url to php actiin hendler.
 * @param {FormData} formData. 
 */
    function postData(action, method, formData){
        return $.ajax({
            url: action,
            data: formData,
            type: method,
            // processData: false,
            // contentType: false,
            dataType: "json",
        });
    }

    function formValidationClear($form){
        var clear = function(){
            $form.find(formSelectors.fieldError).each(function () {
                $(this).removeClass(formSelectors.errorClass);
                $(this).children(formSelectors.fieldValidationErrorWrapper).empty();
            });
        };

        clear();
    }

    function formDataClear($form){
        var clear = function(){
            $form.find("input[type=text], textarea").val("").each(function () {
                $(this).val("");
            });
        };

        clear();
    }

    function formValidation(result, $form){
        var items = result.data;
        // console.log(items);
        Object.entries(items).map(function(item) {
            createValidationItem(item, $form);
        });
        
    }

    function createValidationItem(item, $form){
        // console.log(item);
        var name = item[0],
            messages = item[1],
            $inputOrTextarea = $form.find("[name=" + name + "]"),
            $field = $inputOrTextarea.parent('.field'),
            errorWrapperSelector = '.field-validation-error-wrapper',
            $errorWrapper = $inputOrTextarea.siblings(errorWrapperSelector);

        $field.addClass( "error" );
        messages.map(function(item) {
            $errorWrapper.append( "<p>"+ item +"</p>" );
            // console.log(item);
        });

        // console.log($errorWrapper);
    }

    function toggleSpinner($container){
        $container.toggleClass(selectors.spinnerClass);
    }


/**
 * Create comment from form
 * @param {Event} e click event objact.
 */
    function createComment(e) {
        e.preventDefault();

        var $form = e.data.$form,
            formContents = $form.serialize(),
            action = e.data.formAction,
            method = e.data.formMethod;
            // formData = new FormData();  
// console.log(formContents);
        // beforeCreateDeferred.done(function() { methods.beforeCreate('beforeCreate'); });
        // afterCreateDeferred.done(function() { methods.afterCreate('afterCreate'); });

        // formData.append("comment", textarea.val());

        var ajx = postData(action, method, formContents);

        var start = $.Deferred();

        toggleSpinner($form);

        start
            .then(function () {
                return methods.beforeCreate('beforeCreate');
            })
            .then(function () {
                return ajx.done(function(result){
                    toggleSpinner($form);
                    formValidationClear($form);
                    if(result.status === 'validation-error'){
                        formValidation(result, $form);
                    }else if(result.status === 'success'){
                        //Hendler result
                        formDataClear($form);
                        // console.log(result.data);
                        console.log('success');
                        location.reload();
                        
                    }

                    
                    

                });
            })
            .then(function () {
                return methods.afterCreate('afterCreate');
            });

        start.resolve();
        // $.when(console.log("th"), ajx, console.log("11"));
        // console.log(e.data.formAction);

    }

    function replyComment(e){
        // console.log($(this));
        e.preventDefault();

        var $form = e.data.$form,
            pluginSettings = e.data.settings,
            $link = $(this),//reply link
            $divActions = $(this).parent(),
            commentBlock = $(this).closest(pluginSettings.commentSelectors.commentBlockClass),
            dataCommentId = commentBlock.data("comment-id"),
            $input = $form.find(pluginSettings.formSelectors.hiddenInputParentId);

            console.log(dataCommentId);

            $form.insertAfter($divActions);
            $input.val(dataCommentId);//set parent comment id to hidden input
    }

    function likeComment(e){
        e.preventDefault();
        var pluginSettings = e.data.settings;
        $.ajax({
            url: "comments/comments/default/like",
            data: '',
            type: 'POST',
            // processData: false,
            // contentType: false,
            dataType: "json",
        }).then(function () {
            console.log($(this));
        });

        // console.log($(this));
    }

    //plugin
    $.fn[pluginName] = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.comment');
            return false;
        }
    };


})(jQuery, document, window);