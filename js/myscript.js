
function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'You have a notification'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated bounceInRight'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated bounceOutRight'; }
    var allowDismiss = true;

    $.notify({
        message: text
    },
        {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 1000,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
}

/*
* Project: Bootstrap Notify = v3.1.3
* Description: Turns standard Bootstrap alerts into "Growl-like" notifications.
* Author: Mouse0270 aka Robert McIntosh
* License: MIT License
* Website: https://github.com/mouse0270/bootstrap-growl
*/
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    // Create the defaults once
    var defaults = {
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>'
        };

    String.format = function() {
        var str = arguments[0];
        for (var i = 1; i < arguments.length; i++) {
            str = str.replace(RegExp("\\{" + (i - 1) + "\\}", "gm"), arguments[i]);
        }
        return str;
    };

    function Notify ( element, content, options ) {
        // Setup Content of Notify
        var content = {
            content: {
                message: typeof content == 'object' ? content.message : content,
                title: content.title ? content.title : '',
                icon: content.icon ? content.icon : '',
                url: content.url ? content.url : '#',
                target: content.target ? content.target : '-'
            }
        };

        options = $.extend(true, {}, content, options);
        this.settings = $.extend(true, {}, defaults, options);
        this._defaults = defaults;
        if (this.settings.content.target == "-") {
            this.settings.content.target = this.settings.url_target;
        }
        this.animations = {
            start: 'webkitAnimationStart oanimationstart MSAnimationStart animationstart',
            end: 'webkitAnimationEnd oanimationend MSAnimationEnd animationend'
        }

        if (typeof this.settings.offset == 'number') {
            this.settings.offset = {
                x: this.settings.offset,
                y: this.settings.offset
            };
        }

        this.init();
    };

    $.extend(Notify.prototype, {
        init: function () {
            var self = this;

            this.buildNotify();
            if (this.settings.content.icon) {
                this.setIcon();
            }
            if (this.settings.content.url != "#") {
                this.styleURL();
            }
            this.styleDismiss();
            this.placement();
            this.bind();

            this.notify = {
                $ele: this.$ele,
                update: function(command, update) {
                    var commands = {};
                    if (typeof command == "string") {
                        commands[command] = update;
                    }else{
                        commands = command;
                    }
                    for (var command in commands) {
                        switch (command) {
                            case "type":
                                this.$ele.removeClass('alert-' + self.settings.type);
                                this.$ele.find('[data-notify="progressbar"] > .progress-bar').removeClass('progress-bar-' + self.settings.type);
                                self.settings.type = commands[command];
                                this.$ele.addClass('alert-' + commands[command]).find('[data-notify="progressbar"] > .progress-bar').addClass('progress-bar-' + commands[command]);
                                break;
                            case "icon":
                                var $icon = this.$ele.find('[data-notify="icon"]');
                                if (self.settings.icon_type.toLowerCase() == 'class') {
                                    $icon.removeClass(self.settings.content.icon).addClass(commands[command]);
                                }else{
                                    if (!$icon.is('img')) {
                                        $icon.find('img');
                                    }
                                    $icon.attr('src', commands[command]);
                                }
                                break;
                            case "progress":
                                var newDelay = self.settings.delay - (self.settings.delay * (commands[command] / 100));
                                this.$ele.data('notify-delay', newDelay);
                                this.$ele.find('[data-notify="progressbar"] > div').attr('aria-valuenow', commands[command]).css('width', commands[command] + '%');
                                break;
                            case "url":
                                this.$ele.find('[data-notify="url"]').attr('href', commands[command]);
                                break;
                            case "target":
                                this.$ele.find('[data-notify="url"]').attr('target', commands[command]);
                                break;
                            default:
                                this.$ele.find('[data-notify="' + command +'"]').html(commands[command]);
                        };
                    }
                    var posX = this.$ele.outerHeight() + parseInt(self.settings.spacing) + parseInt(self.settings.offset.y);
                    self.reposition(posX);
                },
                close: function() {
                    self.close();
                }
            };
        },
        buildNotify: function () {
            var content = this.settings.content;
            this.$ele = $(String.format(this.settings.template, this.settings.type, content.title, content.message, content.url, content.target));
            this.$ele.attr('data-notify-position', this.settings.placement.from + '-' + this.settings.placement.align);
            if (!this.settings.allow_dismiss) {
                this.$ele.find('[data-notify="dismiss"]').css('display', 'none');
            }
            if ((this.settings.delay <= 0 && !this.settings.showProgressbar) || !this.settings.showProgressbar) {
                this.$ele.find('[data-notify="progressbar"]').remove();
            }
        },
        setIcon: function() {
            if (this.settings.icon_type.toLowerCase() == 'class') {
                this.$ele.find('[data-notify="icon"]').addClass(this.settings.content.icon);
            }else{
                if (this.$ele.find('[data-notify="icon"]').is('img')) {
                    this.$ele.find('[data-notify="icon"]').attr('src', this.settings.content.icon);
                }else{
                    this.$ele.find('[data-notify="icon"]').append('<img src="'+this.settings.content.icon+'" alt="Notify Icon" />');
                }
            }
        },
        styleDismiss: function() {
            this.$ele.find('[data-notify="dismiss"]').css({
                position: 'absolute',
                right: '10px',
                top: '5px',
                zIndex: this.settings.z_index + 2
            });
        },
        styleURL: function() {
            this.$ele.find('[data-notify="url"]').css({
                backgroundImage: 'url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)',
                height: '100%',
                left: '0px',
                position: 'absolute',
                top: '0px',
                width: '100%',
                zIndex: this.settings.z_index + 1
            });
        },
        placement: function() {
            var self = this,
                offsetAmt = this.settings.offset.y,
                css = {
                    display: 'inline-block',
                    margin: '0px auto',
                    position: this.settings.position ?  this.settings.position : (this.settings.element === 'body' ? 'fixed' : 'absolute'),
                    transition: 'all .5s ease-in-out',
                    zIndex: this.settings.z_index
                },
                hasAnimation = false,
                settings = this.settings;

            $('[data-notify-position="' + this.settings.placement.from + '-' + this.settings.placement.align + '"]:not([data-closing="true"])').each(function() {
                return offsetAmt = Math.max(offsetAmt, parseInt($(this).css(settings.placement.from)) +  parseInt($(this).outerHeight()) +  parseInt(settings.spacing));
            });
            if (this.settings.newest_on_top == true) {
                offsetAmt = this.settings.offset.y;
            }
            css[this.settings.placement.from] = offsetAmt+'px';

            switch (this.settings.placement.align) {
                case "left":
                case "right":
                    css[this.settings.placement.align] = this.settings.offset.x+'px';
                    break;
                case "center":
                    css.left = 0;
                    css.right = 0;
                    break;
            }
            this.$ele.css(css).addClass(this.settings.animate.enter);
            $.each(Array('webkit-', 'moz-', 'o-', 'ms-', ''), function(index, prefix) {
                self.$ele[0].style[prefix+'AnimationIterationCount'] = 1;
            });

            $(this.settings.element).append(this.$ele);

            if (this.settings.newest_on_top == true) {
                offsetAmt = (parseInt(offsetAmt)+parseInt(this.settings.spacing)) + this.$ele.outerHeight();
                this.reposition(offsetAmt);
            }

            if ($.isFunction(self.settings.onShow)) {
                self.settings.onShow.call(this.$ele);
            }

            this.$ele.one(this.animations.start, function(event) {
                hasAnimation = true;
            }).one(this.animations.end, function(event) {
                if ($.isFunction(self.settings.onShown)) {
                    self.settings.onShown.call(this);
                }
            });

            setTimeout(function() {
                if (!hasAnimation) {
                    if ($.isFunction(self.settings.onShown)) {
                        self.settings.onShown.call(this);
                    }
                }
            }, 600);
        },
        bind: function() {
            var self = this;

            this.$ele.find('[data-notify="dismiss"]').on('click', function() {
                self.close();
            })

            this.$ele.mouseover(function(e) {
                $(this).data('data-hover', "true");
            }).mouseout(function(e) {
                $(this).data('data-hover', "false");
            });
            this.$ele.data('data-hover', "false");

            if (this.settings.delay > 0) {
                self.$ele.data('notify-delay', self.settings.delay);
                var timer = setInterval(function() {
                    var delay = parseInt(self.$ele.data('notify-delay')) - self.settings.timer;
                    if ((self.$ele.data('data-hover') === 'false' && self.settings.mouse_over == "pause") || self.settings.mouse_over != "pause") {
                        var percent = ((self.settings.delay - delay) / self.settings.delay) * 100;
                        self.$ele.data('notify-delay', delay);
                        self.$ele.find('[data-notify="progressbar"] > div').attr('aria-valuenow', percent).css('width', percent + '%');
                    }
                    if (delay <= -(self.settings.timer)) {
                        clearInterval(timer);
                        self.close();
                    }
                }, self.settings.timer);
            }
        },
        close: function() {
            var self = this,
                $successors = null,
                posX = parseInt(this.$ele.css(this.settings.placement.from)),
                hasAnimation = false;

            this.$ele.data('closing', 'true').addClass(this.settings.animate.exit);
            self.reposition(posX);

            if ($.isFunction(self.settings.onClose)) {
                self.settings.onClose.call(this.$ele);
            }

            this.$ele.one(this.animations.start, function(event) {
                hasAnimation = true;
            }).one(this.animations.end, function(event) {
                $(this).remove();
                if ($.isFunction(self.settings.onClosed)) {
                    self.settings.onClosed.call(this);
                }
            });

            setTimeout(function() {
                if (!hasAnimation) {
                    self.$ele.remove();
                    if (self.settings.onClosed) {
                        self.settings.onClosed(self.$ele);
                    }
                }
            }, 600);
        },
        reposition: function(posX) {
            var self = this,
                notifies = '[data-notify-position="' + this.settings.placement.from + '-' + this.settings.placement.align + '"]:not([data-closing="true"])',
                $elements = this.$ele.nextAll(notifies);
            if (this.settings.newest_on_top == true) {
                $elements = this.$ele.prevAll(notifies);
            }
            $elements.each(function() {
                $(this).css(self.settings.placement.from, posX);
                posX = (parseInt(posX)+parseInt(self.settings.spacing)) + $(this).outerHeight();
            });
        }
    });

    $.notify = function ( content, options ) {
        var plugin = new Notify( this, content, options );
        return plugin.notify;
    };
    $.notifyDefaults = function( options ) {
        defaults = $.extend(true, {}, defaults, options);
        return defaults;
    };
    $.notifyClose = function( command ) {
        if (typeof command === "undefined" || command == "all") {
            $('[data-notify]').find('[data-notify="dismiss"]').trigger('click');
        }else{
            $('[data-notify-position="'+command+'"]').find('[data-notify="dismiss"]').trigger('click');
        }
    };

}));


/*______________________________________________________________________________________
  __________________________________ General Scripts functions _________________________ 
                                                                                        */

//set userInfo as a global variable

var userInfo = JSON.parse(localStorage.getItem("logged"));
var curr_location = window.location;


if(checkLoc("facility") !== -1){
    var facInfo = JSON.parse(localStorage.getItem("facRepoInfo"));
    //The if else was added for the sake of syncing at facility level where 
    //there's no storage of facility info locally.
    if(isEmpty(facInfo) === false)
    dbSync(facInfo.facid);
    else{
        dbSync(userInfo[0].facid);
    }
}


function xhrError($this){
  const error_notice = "<b>Notice</b>:";
                    
const error_warning = "<b>Warning</b>:";
                    
const error_fatal = "<b>Fatal error</b>:";
                    
const error_parse = "<b>Parse error</b>:";

const error_pdo = "exception 'PDOException'";

  if($this.indexOf(error_fatal) > 0 || $this.indexOf(error_warning) > 0 || $this.indexOf(error_notice) > 0 || $this.indexOf(error_pdo) > 0 || $this.indexOf(error_parse) > 0)
    return 404;
  else 
    return 200;
}

//Date formatter
function formatDate(date){
var now = new Date();
var y = now.getFullYear();
var m = now.getMonth();
var d = now.getDate();
var h = now.getHours();
var min = now.getMinutes();
var s = now.getSeconds();
date = new Date(date);
var ay = date.getFullYear();
var am = date.getMonth();
var ad = date.getDate();
var day = date.getDay();
var ah = date.getHours();
var amin = date.getMinutes();
var as = date.getSeconds();

var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
var abbrDays = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];

var fmin = function(){
if(amin < 10){amin = "0" + amin}
if(ah > 11){amin = amin+"pm"}
else{amin = amin+"am"}
return amin;
};

var fh = function(){
if(ah > 12){ahf = ah - 12;} else{ahf = ah;}
if(ahf < 10){ahf = "0" + ahf}
return ahf;
};

if(ad == 1 || ad == 21 || ad == 31){ads = ad+"st"}
else if(ad == 2 || ad == 22){ads = ad+"nd"}
else if(ad == 3 || ad == 23){ads = ad+"rd"}
else{ads = ad+"th"}

var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var abbrMonths = ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

if (y == ay && m == am && d == ad){
    if(h == ah && min == amin){return "Just now";}
    else if(h == ah && min != amin){if(min-amin == 1){return "1 min ago"}else{return min-amin+" mins ago";}}
    else if(h != ah){if(h-ah == 1){return "1 hour ago"}else{return h-ah+" hours ago";}}
    else{return "Today @ "+fh()+":"+fmin();}
}

else if (y == ay && m == am && d != ad){
    var get = d - ad;
    if(get == 1){
        return "Yesterday @ "+fh()+":"+fmin();
    }
    else if(get < 6){return abbrDays[day] + " @ " +fh()+":"+fmin()}
    else{return abbrDays[day]+", "+ads+" "+months[am]+ " @ "+ fh()+":"+fmin()}
}

else if (y == ay && m != am){
    return ads+" "+months[am]+ " @ "+ fh()+":"+fmin()
}

else{
    ads = String(ads);
    if(ads != "NaNth"){
        return ads+" "+months[am]+ ", "+ ay
    }
}

}

//Checks if an element is empty, returns true for empty elements

function isEmpty($element){
    if($element !== "" && $element !== null && $element !== undefined){
        return false;
    }
    else{
        return true;
    }
}

//check if an element has a value of zero;

function isZero($element){
    if(String($element) === "0")return true;
    else return false; 
}

function closeAlert($element){
    $($element).addClass("hidden");
}

//Compresses health facility name and returns a compressed format of bthe facility name

function compressName($element){
    $elementCopy = $element.toLowerCase();
    var check1 = $elementCopy.search("basic health centre");
    var check2 = $elementCopy.search("comprehensive health centre");
    var check3 = $elementCopy.search("model primary health centre");
    var check4 = $elementCopy.search("general hospital");
    var check5 = $elementCopy.search("state specialist hospital");
    var check6 = $elementCopy.search("mother and child hospital");
    var check7 = $elementCopy.search("model health centre");

    if(check1 !== -1){
        $element = $element.replace(/Basic Health Centre/i, "BHC");
    }
    else if(check2 !== -1){
        $element = $element.replace(/Comprehensive Health Centre/i, "CHC");
    }
    else if(check3 !== -1){
        $element = $element.replace(/Model Primary Health Centre/i, "MPHC");
    }
    else if(check4 !== -1){
        $element = $element.replace(/General Hospital/i, "GH");
    }
    else if(check5 !== -1){
        $element = $element.replace(/State Specialist Hospital/i, "SSH");
    }
    else if(check6 !== -1){
        $element = $element.replace(/Mother And Child Hospital/i, "MCH");
    }
    else if(check7 !== -1){
        $element = $element.replace(/Model Health Centre/i, "MHC");
    }
    else{}
        return $element;
}



/*
    _______________________________________________________________________________________________
    _______________________________________________________________________________________________
    ___________-------- Facilty load and fetch previous/current reports update --------____________
    _______________________________________________________________________________________________

                                                                                                    */
// To update facility info via notifications

function updateFac(){
      swal({
        title: "Are you sure?",
        text: "Please confirm update of new database changes on your browser.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Proceed",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    }, function (isConfirm) {
      if (isConfirm) {
        $.get("pages/dbconn.php?fetch_hfs", function(data){
        if(xhrError(data) === 200 && isEmpty(data) === false){
        localStorage.setItem("hfs", data);
        console.log("HFs stored locally for easy access");
        swal("Updated", "Health facilities' information has been updated.", "success");
        }
        else{
          console.log("Challenges with connecting to database "+ data);
          swal("Error!", "Could not connect with database", "warning");
        }   
        })
      }
    })
  
}

//On reporting page, this function displays a table with list of commodities and their reports

function reportTable(fid, rpid){
    $.get("pages/dbconn.php?fetch_report="+fid+"&rpid="+rpid, function(){
        
    });
}

//Store selected facility information and sync with data from database and sends user to report page

function facRepo(facid, facname, faclga){ 
      var facInfo = {facid: facid, facname: facname, faclga: faclga};
      localStorage.setItem("facRepoInfo", JSON.stringify(facInfo));
      console.log("Facility added to local storage this triggered");
      window.location.assign("facility-report");
}

//This is the function that actually performs the sync

function dbSync(fid){
  if(isEmpty(fid) === false){
    check = JSON.parse(localStorage.getItem("comReport-"+fid));
    if(isEmpty(check) === true){
        loadSync();
    }

    else{
        var exist = 0;

        for(var i = 0; i<check.length; i++){
    if(Number(check[i].rpid) === Number(userInfo[0].rpid) && check[i].status !== "uploaded"){
        exist++;
        //break;
    }
}
//sendNote(exist);
    if(exist === 0){
        loadSync();
    }
    }
//if(isEmpty(localStorage.getItem("comReport-"+fid)) === true){
function loadSync(){
$.get("pages/dbconn.php?pro_record&fid="+fid, function(data){
    if(xhrError(data) === 200 && data !== "[]"){
      var data = JSON.parse(data);
      var comAvailable = [];
      for(var i = 0; i < data.length; i++){
      var comapush = {cid: data[i].cid, value: data[i].value};
      comAvailable.push(comapush);
    }
    
    localStorage.setItem("comAvailability-"+fid, JSON.stringify(comAvailable));
    localStorage.setItem("comReport-"+fid, JSON.stringify(data));
    getStoredRadio(fid);
    updateFormInfo();
     
    }
    else{
      console.log(data);
    }
});
}
}
}

//function sendNote is used to connect with the bootstrap notification js function to send notifications to user

function sendNote(text, bgcolor){
  if(bgcolor === "" || bgcolor === undefined){bgcolor = "bg-black";}
      showNotification(bgcolor, text, "bottom", "right", "animated bounceInRight", "animated bounceOutRight");
  }
  

//function loadcom() gets commodities from localstorage, creates forms for each of the commodities

function loadCom(checkCom){

  var commodities = JSON.parse(checkCom);

    for(var i = 0; i<commodities.length; i++){

      var form = '<form name="stock-repo-form" class="stock-repo-form">\
      <div class="stock-repo-form-'+commodities[i].id+'">\
      <!--<p>'+commodities[i].name+'</p>-->\
      <div class="row clearfix">\
        <div class="col-sm-6">\
          <div class="input-group">\
            <label class="input-group-addon" for="prev-balance-'+commodities[i].id+'">Beginning Balance</label>\
            <input type="number" min="0" class="form-control prev-balance" data-id="'+commodities[i].id+'"\
             id="prev-balance-'+commodities[i].id+'" placeholder="0" autofocus>\
            </div></div>\
            <div class="col-sm-6"><div class="input-group">\
              <label class="input-group-addon" for="received-'+commodities[i].id+'">Quantity Received</label>\
                <input type="number" min="0" class="form-control" data-id="'+commodities[i].id+'" id="received-'+commodities[i].id+'" placeholder="0">\
              </div></div>\
      </div>\
      \
      <div class="row clearfix">\
        <div class="col-sm-6">\
          <div class="input-group">\
            <label class="input-group-addon" for="issued-'+commodities[i].id+'">Quantity Dispensed</label>\
           <input type="number" min="0" class="form-control" data-id="'+commodities[i].id+'" id="issued-'+commodities[i].id+'" placeholder="0">\
          </div></div>\
        <div class="col-sm-6">\
        <div class="input-group">\
          <label class="input-group-addon" for="pos-adjust-'+commodities[i].id+'">Positive Adjustment</label>\
            <input type="number" min="0" class="form-control" data-id="'+commodities[i].id+'" id="pos-adjust-'+commodities[i].id+'" placeholder="0">\
        </div></div>\
      </div>\
      \
      <div class="row clearfix">\
        <div class="col-sm-6">\
          <div class="input-group">\
            <label class="input-group-addon" for="neg-adjust-'+commodities[i].id+'">Negative Adjustment</label>\
            <input type="number" min="0" data-id="'+commodities[i].id+'" id="neg-adjust-'+commodities[i].id+'" class="form-control" placeholder="0">\
        </div></div>\
        <div class="col-sm-6">\
          <div class="input-group">\
            <label class="input-group-addon" for="balance-'+commodities[i].id+'">Ending Balance</label>\
            \
          <input type="number" min="0" class="form-control balance" data-id="'+commodities[i].id+'" id="balance-'+commodities[i].id+'" placeholder="0">\
        </div></div>\
         <p class="col-xs-12 alert bal-alert bal-alert-'+commodities[i].id+' hidden" style="margin-top: -30px"></p>\
         </div>\
        \
      <div class="row clearfix">\
        <div class="col-md-12">\
        <div class="input-group">\
            <label class="input-group-addon" for="expiry-'+commodities[i].id+'">Nearest expiry date</label>\
                    <div class="form-line" id="datepicker-'+commodities[i].id+'"> \
                    <input type="text" class="pick-date form-control" data-id="'+commodities[i].id+'" id="expiry-'+commodities[i].id+'"  placeholder="Please choose a date...">\
                </div></div></div>\
      </div></form>\
        \
      <div class="row clearfix">\
        <div class="col-md-12">\
          <div class="input-group">\
            <label class="input-group-addon" for="remarks-'+commodities[i].id+'">Remarks</label>\
            <input type="text" class="form-control" data-id="'+commodities[i].id+'" id="remarks-'+commodities[i].id+'" placeholder="Enter remarks here">\
          </div></div></div>\
      </div></form>';
  if(i===0){
      var content = '<div id="menu'+i+'" class="tab-pane fade in active">'+form+'</div>';}

  else{
      var content = '<div id="menu'+i+'" class="tab-pane fade">'+form+'</div>';
    }

      $(".com-li-display-sm").append("<li com-li-id='"+commodities[i].id+"'><a data-toggle='tab' data-id='"+commodities[i].id+"' arrayPos='"+i+"' class='com-link-load font-16' href='#menu"+i+"'>"+commodities[i].name+" <br><span class='font-14'>Unit: "+commodities[i].unit+"</span></a></li>");

//for mobile phones only
      $(".com-li-display-xs").append("<li com-li-id='"+commodities[i].id+"'><a data-toggle='tab' data-id='"+commodities[i].id+"' arrayPos='"+i+"' class='com-link-load font-16' href='#menu"+i+"'>"+commodities[i].name+" - "+commodities[i].unit+"</a></li>");
//    }
      $('.report-form .tab-content').append(content);
      $(".wait-loader").empty();
    }
}

//get commodities from database

function getCom(){

$.get("pages/dbconn.php?commodities", function(data){
    if(xhrError(data) !== 404){
      if(data !== 404 || data !== "404"){ 
      localStorage.setItem("commodities", data);
      loadCom(data);
    }
    else
      console.log("error fetching commodities from db "+ data);
    }

    else
      console.log("error fetching commodities from db "+ data);
});
}

//function to check location, since I'm using it frequently

function checkLoc(location){
    var loc = String(window.location).search(location);
    return loc;       
}

//Search database for new notifications and update when there's a new notification

function getNotes(){
    var lnid = localStorage.getItem("lnid-"+userInfo[0].id);
    var store = "notifications-"+userInfo[0].id;
    var check = localStorage.getItem(store);
    if(isEmpty(check) === true){
             var createNote = [];
             localStorage.setItem(store, JSON.stringify(createNote));
        }
    var notes = JSON.parse(localStorage.getItem(store));
    //sendNote(String(lnid));
    $.get("pages/dbconn.php?get_note="+lnid, function(data){
        if(xhrError(data) === 200 && data != "300" && data !== ""){
            //sendNote(data);
            data = JSON.parse(data);
            for(var i = 0; i < data.length; i++){
                var newNote = {msg: data[i].msg, time: data[i].time, id: data[i].id};
                notes.push(newNote);
                if(checkLoc("notifications") !== -1){
                var noMsg = '<p class="no-msg">'+data[i].msg+'</p><p class="no-time"><i class="material-icons">access_time</i> '+formatDate(data[i].time)+'\
                  </p>';
                  
                $(".notifications").prepend("<div class='alert no-display'>"+noMsg+"</div>");
                
            }
            else{ $(".new-note").html('<i class="material-icons">stars</i>');
            $(".notification-icon").html("notifications_active");}

                if(i == data.length-1){
                    localStorage.setItem("lnid-"+userInfo[0].id, data[i].id);
                }
            }

            var audio = new Audio('../media/notify.mp3');
                audio.play();
            //sendNote("You have "+data.length+" new notifications");
            
            localStorage.setItem(store, JSON.stringify(notes));
        }
    })
}

$(document).ready(function(){
/*
  ___________________________________ Profile Scripts __________________________________  
                                                                                        */

                $('.name').text(userInfo[0].lname + " "+ userInfo[0].fname);
                $('.designation').text(userInfo[0].designation);
                $('.address').text(userInfo[0].address);
                $('.gender').text('('+userInfo[0].gender+')');
                $('.phone').text(userInfo[0].phone);
                $('.email').text(userInfo[0].email);

                if(userInfo[0].role === '3') var role = "Administrator";
                
                else if(userInfo[0].role === "2") var role = "State LMCU Officer";
                
                else if(userInfo[0].role === "1") var role = "LGA LMCU officer";
                
                else var role = "Health Facility officer";
                
                $('.role').text(role);

                $('#NameSurname').val(userInfo[0].lname + " "+ userInfo[0].fname).focus();
                $('#Email').val(userInfo[0].email);
                $('#Phone').val(userInfo[0].phone);
                $('#InputAddress').val(userInfo[0].address);
                if(isEmpty(userInfo[0].rpname) === false && userInfo[0].rpname !== " "){
                $('.rep-period').html("Reporting period: "+ userInfo[0].rpname).removeClass("hidden");}
                else{$('.rep-period').addClass("hidden");}
                

/*
    _______________________________________________________________________________________________
    __________________________________ Facilty search scripts _____________________________________

                                                                                                    */

if(checkLoc("reporting") !== -1 && checkLoc("facility") === -1){

var facilities = JSON.parse(localStorage.getItem("hfs"));
if(isEmpty(facilities) === true){
      fetchFac();
}

function listFacilities(){
  var n = 0;
for (var i = 0; i < facilities.length; i++){
    var facname = facilities[i].name;
    var facid = facilities[i].id;
    var faclga = "<p class='search-info'>" +facilities[i].lga + "</p>";
    var output = "<li><a onclick='facRepo("+facid+", \""+facname+"\", \""+facilities[i].lga+"\")'>"+facname+faclga+"</a></li>";
    $('.list-point').append(output);
      n++;
}
$('.search-count').html("("+n+" results)");
}

function listFacilitiesLga(){
  var n = 0;
for (var i = 0; i < facilities.length; i++){
  if(facilities[i].lga == userInfo[0].lga){
    var facname = facilities[i].name;
    var facid = facilities[i].id;
    var faclga = "<p class='search-info'>" +facilities[i].lga + "</p>";
    var output = "<li><a onclick='facRepo("+facid+", \""+facname+"\", \""+facilities[i].lga+"\")'>"+facname+faclga+"</a></li>";
    $('.list-point').append(output);
      n++;
}
else{}
}
$('.search-count').html("("+n+" results)");
}

if(checkLoc("lga") === -1 && checkLoc("facility") === -1){

        $('.fac-search').keyup(function(e){
        e.preventDefault();
        var n = 0;
        $('.list-point').html('');
        var searchText = $(this).val();
        searchText = searchText.toLowerCase().replace("chc", "Comprehensive Health Centre");
        searchText = searchText.toLowerCase().replace("bhc", "Basic Health Centre");
        searchText = searchText.toLowerCase().replace("phc", "Primary Health Centre");
        
        for (var i = 0; i < facilities.length; i++){
                var search = searchText;
                var se = new RegExp(search, "i");
            var fetch1 = facilities[i].name.search(se);
            var fetch2 = facilities[i].lga.search(se);
            if(fetch1 !== -1 || fetch2 !== -1){
                var facname = facilities[i].name;
                var facid = facilities[i].id;
                var faclga = "<p class='search-info'>" +facilities[i].lga + "</p>";

                var output = "<li><a onclick='facRepo("+facid+", \""+facname+"\", \""+facilities[i].lga+"\")'>"+facname+faclga+"</a></li>";
                $('.list-point').append(output);
                n++;
            }
            else{}
        $('.search-count').html("("+n+" results)");
        }         
    })
    }
        if(checkLoc("lga") === -1){
       listFacilities();            
        }
        else{listFacilitiesLga();}
       
}


/* ________________________________________________________________________________________
   __________________-------- When it is not a reporting period ---------__________________

                                                                                            */

if(userInfo[0].rpid === null || userInfo[0].rpid === undefined){
  setInterval(function(){   
  $(".stock-repo-form input").prop("disabled", true);
  $(".com-link-save, .submit-layer").hide();
  $("[type=radio]").prop("disabled", true);
  }, 50);
}

/* ________________________________________________________________________________________
   ______________________-------- get realtime notifications ---------_____________________

                                                                                            */
setInterval(getNotes, 60000);   

getNotes();


//checks whether user is online every 2 seconds
setInterval(function(){
 var status = navigator.onLine;
 if(String(status) !== "true")
 $(".repo-info-note .status").html("<i class ='material-icons col-grey'>settings_input_antenna</i><span class='col-grey status-pos'> OFFLINE </span>");
else
 $(".repo-info-note .status").html("<i class ='material-icons col-brown'>settings_input_antenna</i><span class='col-brown status-pos'> ONLINE </span>");
}, 500);

  //Bootstrap datepicker plugin
 /*   $('#datepicker input').datepicker({
        autoclose: true,
        container: '#datepicker'
    }); */

    $('.pick-date').hover(function(){
       let id = $(this).attr("data-id");
       //alert($(this).val())
       $("#datepicker-"+id+" input").datepicker({
        autoclose: true,
        container: '#datepicker-'+id
        });
    })

   /* $('#bs_datepicker_component_container').datepicker({
        autoclose: true,
        container: '#bs_datepicker_component_container'
    });
    //
    $('#bs_datepicker_range_container').datepicker({
        autoclose: true,
        container: '#bs_datepicker_range_container'
    }); */

//    $(".table-hfs").shout().changeColor({
//        color: "brown"
//    });

}); //document.ready close tag
