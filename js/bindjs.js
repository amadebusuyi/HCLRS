(function ( $ ) {
 
    $.fn.changeColor = function( options ) {
 
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            color: "red",
            background: "white"
        }, options );
 
        // Greenify the collection based on the settings variable.
        return this.css({
            color: settings.color,
            background: settings.background
        });
 
    };
 
    $.fn.shout = function() {

        swal("Hello World", "Check", "success");
        return this;
 
        // This is the easiest way to have default options.
  /*      var settings = $.extend({
            // These are the defaults.
            color: "red",
            background: "white"
        }, options );
 
        // Greenify the collection based on the settings variable.
        return this.css({
            color: settings.color,
            background: settings.background
        }); */
 
    };

 
}( jQuery ));