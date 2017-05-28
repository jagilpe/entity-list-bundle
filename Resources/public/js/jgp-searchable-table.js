;
(function($, window, document, undefined) {
    var pluginName = 'jgpSearchableTable',
        dataKey = 'plugin_' + pluginName;

    var Plugin = function(element, options) {
        this.element = element;
        this.options = {
            pagination: true,
            onUpdate: function(listElement) {}
        };

        this.init(options);
    };

    Plugin.prototype = {
        init: function(options) {
            $.extend(this.options, options);
            var plugin = this;
            var $element = $(this.element);

            this.searchFields = $element.attr("data-terms").split(',');
            this.pagerItemsPerPage = parseInt($element.attr("data-items-per-page"));

            var listOptions = {
                valueNames: this.searchFields,
                page: this.pagerItemsPerPage,
                pagination: this._loadPagination()
            };

            this.list = new List(this.element, listOptions);
            this.list.on('updated', function() {
                plugin.options.onUpdate(plugin.element);
            });
        },

        setOnUpdateCallback: function(callback) {
            this.options.onUpdate = callback;
        },

        _loadPagination: function() {
            if (this.options.pagination) {
                var list = $(this.element).find('.list').first();
                var items = list.children();

                return items.length > this.pagerItemsPerPage;
            } else {
                return false;
            }
        }
    };

    $.fn[pluginName] = function(options) {
        var args = arguments;

        if (options === undefined || typeof options === 'object') {
            // Creates a new plugin instance, for each selected element, and
            // stores a reference withint the element's data
            return this.each(function() {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName, new Plugin(this,
                        options));
                }
            });
        } else if (typeof options === 'string' && options[0] !== '_' &&
            options !== 'init') {
            // Call a public plugin method (not starting with an
            // underscore) for each
            // selected element.
            if (Array.prototype.slice.call(args, 1).length == 0 &&
                $.inArray(options, $.fn[pluginName].getters) != -1) {
                // If the user does not pass any arguments and the method
                // allows to
                // work as a getter then break the chainability so we can
                // return a value
                // instead the element reference.
                var instance = $.data(this[0], 'plugin_' + pluginName);
                return instance[options].apply(instance, Array.prototype.slice
                    .call(args, 1));
            } else {
                // Invoke the speficied method on each selected element
                return this.each(function() {
                    var instance = $.data(this, 'plugin_' + pluginName);
                    if (instance instanceof Plugin &&
                        typeof instance[options] === 'function') {
                        instance[options].apply(instance, Array.prototype.slice
                            .call(args, 1));
                    }
                });
            }
        }
    };

    // Load the plugin for the ajax blocks in the document
    $(document).ready(function() {
        $('[data-target="jgp-searchable-table"]').jgpSearchableTable();
    });

})(jQuery, window, document);
