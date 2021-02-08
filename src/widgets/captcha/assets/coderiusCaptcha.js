/**
 * Yii Captcha widget.
 *
 * This is the JavaScript widget used by coderius\comments\widgets\captcha\CaptchaWidget widget.
 *
 */
(function ($, window, document) {
  $.fn.coderiusCaptcha = function (method) {
    if (methods[method]) {
      return methods[method].apply(
        this,
        Array.prototype.slice.call(arguments, 1)
      );
    } else if (typeof method === "object" || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error("Method " + method + " does not exist in jQuery.coderiusCaptcha");
      return false;
    }
  };

  var defaults = {
    refreshUrl: undefined,
    hashKey: undefined,
    elemSelectorRefresh: undefined,
    beforeRefresh: function ($img, $elem) {},
    afterRefreshSuccess: function ($img, $elem) {},
    afterRefreshError: function (error) {},
  };

  var methods = {
    init: function (options) {
      return this.each(function () {
        var $e = $(this);
        var settings = $.extend({}, defaults, options || {});
        // if(settings.elemRefresh !== undefined && !settings.elemRefresh instanceof jQuery){
        //   $.error("Param elemRefresh does not instance of jQuery object");
        // }
        if(undefined === settings.elemSelectorRefresh){
          settings.elemRefresh = $e;
        }else{
          settings.elemRefresh = $(document).find(settings.elemSelectorRefresh);
          if(false === exists(settings.elemRefresh)){
            $.error("Elem with selector `"+ settings.elemSelectorRefresh +"` not find in `document`");
          }
        }

        

        

        $e.data("coderiusCaptcha", {
          settings: settings,
        });
        
        settings.elemRefresh.on("click.coderiusCaptcha", function () {
          console.log("coderiusCaptcha::beforeRefresh");
          settings.beforeRefresh($e, settings.elemRefresh);
          methods.refresh
            .apply($e)
            .then((data) => {
              console.log("coderiusCaptcha::afterRefreshSuccess");
              settings.afterRefreshSuccess($e, settings.elemRefresh);
            })
            .catch((error) => {
              console.log("coderiusCaptcha::afterRefreshError" ,error);
              settings.afterRefreshError(error);
            });
          return false;
        });
      });
    },

    refresh: function () {
      var $e = this,
        settings = this.data("coderiusCaptcha").settings;

      return new Promise(function (resolve, reject) {
        $.ajax({
          url: $e.data("coderiusCaptcha").settings.refreshUrl,
          dataType: "json",
          cache: false,
          success: function (data) {
            $e.attr("src", data.url);
            $("body").data(settings.hashKey, [data.hash1, data.hash2]);
            
            $e.one('load',function() {
                // fire when image loads
                resolve(data);
            });
            
          },
          error: function (error) {
            reject(error);
          },
        });
      });
    },
    
    destroy: function () {
      this.off(".coderiusCaptcha");
      this.removeData("coderiusCaptcha");
      return this;
    },

    data: function () {
      return this.data("coderiusCaptcha");
    },
  };

  function exists(elem) {
      return elem.length !== 0;
  }

})(window.jQuery, window, document);
