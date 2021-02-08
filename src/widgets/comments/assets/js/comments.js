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
            ratingBoxSelector: '.rating',
            likeIconSelector: '.like-icon',
            likeCountSelector: '.like-count',
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
            $field = $inputOrTextarea.closest('.field'),
            errorWrapperSelector = '.field-validation-error-wrapper',
            $errorWrapper = $field.find(errorWrapperSelector);
// console.log($inputOrTextarea);
// console.log($field);
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
            
            //If editor is moved to some next dom element, then needed reinit plugin
            var settingsTinymce = tinymce.activeEditor.settings;
            tinymce.remove();
            $form.insertAfter($divActions);
            tinymce.init(settingsTinymce);
            $input.val(dataCommentId);//set parent comment id to hidden input
    }

    function likeComment(e){
        e.preventDefault();
        var pluginSettings = e.data.settings,
            $commentBlock = $(this).closest(pluginSettings.commentSelectors.commentBlockClass),
            $iconBox = $(this),
            $ratingBox = $iconBox.closest(pluginSettings.commentSelectors.ratingBoxSelector),
            $countBox = $(this).siblings(pluginSettings.commentSelectors.likeCountSelector),
            
            dataCommentId = $commentBlock.data("comment-id");

        toggleSpinner($iconBox);

        $.ajax({
            url: "comments/comments/default/like",
            data: {'commentId':dataCommentId},
            type: 'POST',
            // processData: false,
            // contentType: false,
            dataType: "json",
        }).then(function (res) {
            if(res.status == 'ok'){
                var count = res.data.likesCount;
                var likeStatus = res.data.likeStatus;
                $countBox.text(count);
                if(likeStatus == 0){
                    $iconBox.addClass(pluginSettings.commentSelectors.emptyLikeClass);
                }else if(likeStatus == 1){
                    $iconBox.removeClass(pluginSettings.commentSelectors.emptyLikeClass);
                }

                toggleSpinner($iconBox );
            }else{
                throw new Error('Error in like hendler ajax process');
            }
            console.log(res);
        })
        .catch(function(e) {
            console.error(e);
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