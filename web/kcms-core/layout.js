/**
 * Created by lmerotta on 09.09.2015.
 * Layout component using packery
 */
define(['Packery'], function(Packery) {
    var _defaults = {
        selector: '[data-kcms-masonry]',
        draggable: false,
        packery_options: {
            itemSelector: "[data-kcms-sortable]",
            columnWidth: '.col.s12',
            percentPosition: true,
            isInitLayout: false
        },
        packery_events: {
            layoutComplete: function () {
                var itemElems = _instance.getItemElements();

                /* --------------------------------------------------- */
                // reset / empty oder array
                var sortOrder = [];
                for (var i=0; i< itemElems.length; i++) {
                    sortOrder[i] = itemElems[i].getAttribute("data-kcms-id");
                }
                // save tabindex ordering
                localStorage.setItem('sortOrder', JSON.stringify(sortOrder));

            },
            dragItemPositioned:  function( pckryInstance, draggedItem ) {
                setTimeout(function(){
                    _instance.layout();
                },100);
            }
        },
        events: {
            loaded: function() {
                var sortOrder = [];
                var storedSortOrder = localStorage.getItem('sortOrder');
                if ( storedSortOrder ) {

                    storedSortOrder = JSON.parse( storedSortOrder );
                    // create a hash of items by their tabindex
                    var itemsByTabIndex = {};
                    for ( var i=0, len = _instance.items.length; i < len; i++ ) {
                        var item = _instance.items[i];
                        var tabIndex = item.element.getAttribute('data-kcms-id');
                        console.log(tabIndex);
                        itemsByTabIndex[ tabIndex ] = item;
                    }
                    // overwrite packery item order
                    i = 0; len = storedSortOrder.length;
                    for (; i < len; i++ ) {
                        var tabIndex = storedSortOrder[i];
                        _instance.items[i] = itemsByTabIndex[ tabIndex ];
                    }
                }


                _instance.layout();
            }
        }
    };

    var _instance = undefined;

    var _preInit = function(parameters)
    {
        if(typeof(parameters) === 'undefined')
        {
            parameters = {};
        }

        $.extend(true, _defaults, parameters);
    };

    return {
        options: _defaults,
        instance: _instance,
        init: function(parameters) {

            _preInit(parameters);

            // create instance
            _instance = this.instance =  new Packery(this.options.selector, this.options.packery_options);

            // if draggable, create the draggability with jquery-ui
            if(this.options.draggable == true){
                var itemElems = $(this.options.selector).find(this.options.packery_options.itemSelector);
                // make item elements draggable
                itemElems.draggable();
                // bind Draggable events to Packery
                _instance.bindUIDraggableEvents(itemElems);
            }

            // bind events
            var events = Object.keys(this.options.packery_events);
            for(ev in events)
            {
                this.instance.on(events[ev], this.options.packery_events[events[ev]]);
            }

            // run loaded
            this.options.events.loaded();

        }
    }
});