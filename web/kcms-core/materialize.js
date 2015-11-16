/**
 * Created by lmerotta on 02.09.2015.
 */
define(function() {

    var showLoadingPreloader = function() {
        $(defaults.preloader.container).removeClass('hide');
    };

    var hideLoadingPreloader = function() {
        $(defaults.preloader.container).addClass('hide');
    };

    var defaults = {
        sidenav: {
            id: '#slide-out',
            selector: '.button-collapse'
        },
        modals: {
            selector: '.modal-trigger'
        },
        preloader: {
            container: '#preloader-container',
            event_sender: '[data-kcms-preloadable]'
        }
    };
    
    var showToast = function (message, delay, styles) {

        Materialize.toast(message, delay, styles);

    };

    var _preInit = function(parameters)
    {
        if(typeof(parameters) === 'undefined')
        {
            parameters = {};
        }

        $.extend(true, defaults, parameters);
    };

   return {
       options: defaults,
       loadSideNav: function(command) {
           if(typeof(command) === 'undefined')
           {
               $(this.options.sidenav.selector).sideNav();
           }
           else{
               $(this.options.sidenav.selector).sideNav(command);
           }
       },
       loadModals: function() {
           $(this.options.modals.selector).leanModal();
       },
       setupPreloader: function(){
           $(this.options.preloader.event_sender).on('click', function(event){

               if (event.ctrlKey || event.shiftKey || event.metaKey || event.which == 2) {
                   return true;
               }

               showLoadingPreloader();
           });
       },
       showLoadingPreloader: showLoadingPreloader,
       hideLoadingPreloader: hideLoadingPreloader,

       init: function(parameters){
           _preInit(parameters);
           this.loadSideNav();
           this.loadModals();
           this.setupPreloader();
       },

       closeModal: function(selector)
       {
           $(selector).closeModal();
       },

       openModal: function(selector)
       {
           $(selector).openModal();
       },

       showToast: showToast
   }
});