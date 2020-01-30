document.onreadystatechange = function(){

    if(document.readyState === 'complete'){

        function newpage() {

            window.location = newLocation;

        }

        function sortDivtable(){
            var $divs = $(".account-right-box .payment-table .table-body .table-row");

            $('.orderBnt').on('click', function () {

                $(this).parent().find('.orderBnt').removeClass('sorted');
                $(this).addClass('sorted');

                var numer = $(this).data('number');

                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).removeClass('down')
                    /*a-z*/
                    var orderedDivs = $divs.sort(function (a, b) {
                        console.log($(a).find(".cell[data-number='" + numer +"'] .el").text());
                        return $(a).find(".cell[data-number='" + numer +"'] .el").text() > $(b).find(".cell[data-number='" + numer +"'] .el").text();
                    });
                    $(".payment-table .table-body").html(orderedDivs);

                } else{
                    $(this).addClass('active');
                    $(this).addClass('down')
                    /*z-a*/
                    var orderedDivs = $divs.sort(function (a, b) {
                        return $(a).find(".cell[data-number='" + numer +"'] .el").text() < $(b).find(".cell[data-number='" + numer +"'] .el").text();
                    });
                    $(".payment-table .table-body").html(orderedDivs);
                }


            });

            /*double scroll*/
            $(".payment-table-holder").scroll(function(){
                $(".topScrollVisible").scrollLeft($(".payment-table-holder").scrollLeft());
            });

            $(".topScrollVisible").scroll(function(){
                $(".payment-table-holder").scrollLeft($(".topScrollVisible").scrollLeft());
            });

        }

        function clickFunctions() {


            $('.logged .opener-el').on('click', function(){
                if($(this).hasClass('active')){
                    $(this).removeClass('active')
                } else {
                    $(this).addClass('active');

                    if($('.mobile-btn').hasClass('open')){
                        $('header .nav').fadeOut();
                        $('.mobile-btn').removeClass('open');
                    }
                }

            });

            $('.logged .opener-el').on('clickout', function () {
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                }
            });

            function resizable (el, factor) {
                var int = Number(factor) || 7.7;
                function resize() {el.style.width = ((el.value.length+1) * int) + 'px'}
                var e = 'keyup,keypress,focus,blur,change'.split(',');
                for (var i in e) el.addEventListener(e[i],resize,false);
                resize();
            }

            if($('#txt').length){
                resizable(document.getElementById('txt'),28);

                $('#txt').on('focus', function(){
                    $('.mobile-fixed-panel > .holder').fadeOut();
            }).on('blur', function(){
                    $('.mobile-fixed-panel > .holder').fadeIn();
                })
            }

            if($('#txt2').length){
                resizable(document.getElementById('txt2'),28);

                $('#txt2').on('focus', function(){
                    $('.mobile-fixed-panel > .holder').fadeOut();
                }).on('blur', function(){
                    $('.mobile-fixed-panel > .holder').fadeIn();
                })
            }

            $('.close-mob-bid-input').on('click', function(){

                $('.mobile-fixed-panel').find('.input-bid-mob-box').removeClass('active');
                unlockScroll();
                if($('body').hasClass('ios')){
                    $('body').css('overflow','auto');
                }
                $('.open-mob-bid-input').removeClass('active');
            });

            $('.open-mob-bid-input').on('click', function(){
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).closest('.mobile-fixed-panel').find('.input-bid-mob-box').removeClass('active');
                    unlockScroll();
                    if($('body').hasClass('ios')){
                        $('body').css('overflow','auto');
                    }
                } else {
                    $(this).addClass('active');
                    $(this).closest('.mobile-fixed-panel').find('.input-bid-mob-box').addClass('active');

                    lockScroll();

                    if($('body').hasClass('ios')){
                        $('body').css('overflow','hidden');
                    }
                }
            });

            $('.open-bid-input').on('click', function(){
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).closest('.buttons').find('.input-box').removeClass('active');
                    $(this).closest('.buttons').find('.buttons-box').removeClass('input-active');
                } else {
                    $(this).addClass('active');
                    $(this).closest('.buttons').find('.input-box').addClass('active');
                    $(this).closest('.buttons').find('.buttons-box').addClass('input-active');
                }

            });
            (function auctionDrop(){
                $('.top-panel-auction .opener-buttons').on('click', function(){
                    var activeclass = 'active';
                    if($(this).hasClass(activeclass)){
                        $(this).removeClass(activeclass);
                        $(this).parent().find('.buttons').removeClass(activeclass);
                        unlockScroll();
                        if($('body').hasClass('ios')){
                            $('body').css('overflow','auto');
                            $(this).closest('.top-panel-auction').removeClass('fixed');
                        }
                    } else {
                        $(this).addClass(activeclass);
                        $(this).parent().find('.buttons').addClass(activeclass);
                        lockScroll();
                        $('body').css('margin-right', 0);

                        if($('body').hasClass('ios')){
                            $('body').css('overflow','hidden');

                            $(this).closest('.top-panel-auction').addClass('fixed');
                        }




                            var openerHeight =  $('.top-panel-auction').outerHeight();

                            $('.top-panel-auction .buttons.active').css('top', openerHeight);


                    }
                })


            })();
            var nmb;

            $('.view-switcher .button').on('click', function(){

                nmb = $(this).attr('data-number');
                var self = $(this);


               /* if(number>1){
                    $('.subpage').css('display', 'none');
                    $('.subpage-' + number).fadeIn();

                    if(!self.hasClass('active')){
                        self.parent().find('.button').removeClass('active');
                        self.addClass('active');
                    }
                } else {
                    $('#request').trigger('click');

                }
*/

                $('#request').trigger('click');

            });

            $('.switch-it').on('click', function(){

                var self = $('.view-switcher .button[data-number=' + nmb + ']');

                if(!self.hasClass('active')){
                    self.parent().find('.button').removeClass('active');
                    self.addClass('active');
                }

                $('.subpage').css('display', 'none');
                $('.subpage-' + nmb).fadeIn();

                if($('.popup-box').hasClass('active')){
                    $('.popup-box').removeClass('active');
                }
            });

            $('.filter-add-btn .open-button').on('click', function(){
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).parent().removeClass('active')
                } else {
                    $(this).addClass('active');
                    $(this).parent().addClass('active');
                }
            })
            $('.filter-add-btn').on('clickout', function () {
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).find('.open-button').removeClass('active');
                }
            });



            $('.account-right-box .content-blocks .add').on('click', function(){
                var template = '<div class="content-blocks">                    <div class="header-group">                <label class="small">Title</label>                <input type="text" value=""/> <span class="line"></span>               </div>                <div class="text-group">                <label class="small">Text</label>                <textarea cols="30"></textarea>                </div>                <div class="button-group">                <a href="#" class="btn-2 black">Save</a>                <a href="#" class="btn-2 blue">Delete</a>                </div>                </div>';
                $(this).closest('.content-blocks-holder').append(template);
                autosize($('.content-blocks-holder textarea'));
            });

            if($("#dropzone").length){
                $("#dropzone").dropzone({
                    url: "/file/post",
                    maxFiles: 1,
                    accept: function(file, done) {
                        done();
                    },
                    init: function() {
                        this.on("maxfilesexceeded", function(file){
                            this.removeAllFiles(); this.addFile(file); });
                    }
                });
                $(document).on('click', '.dz-error-mark', function(){
                    $(this).closest('.dz-preview').remove()
                })
            }

            if($("#dropzone-dealer").length){
                $("#dropzone-dealer").dropzone({
                    url: "/file/post",
                    maxFiles: 1,
                    accept: function(file, done) {
                        done();
                    },
                    init: function() {
                        this.on("maxfilesexceeded", function(file){
                            this.removeAllFiles(); this.addFile(file); });
                    }
                });
                $(document).on('click', '.dz-error-mark', function(){
                    $(this).closest('.dz-preview').remove()
                })
            }
            if($("#dropzoneMulty").length){
                $("#dropzoneMulty").dropzone({
                    url: "/file/post",
                    maxFiles: 1000,
                    accept: function(file, done) {
                        done();

                            var images = $(".dz-preview");

                            if ( images.parent().is( "#preview-wrapper" ) ) {
                                images.unwrap("#preview-wrapper");
                                images.wrapAll("<div id='preview-wrapper'></div>");
                            } else {
                                $('#preview-wrapper').remove();
                                images.wrapAll("<div id='preview-wrapper'></div>");
                            }
                    },
                    init: function(){
                        this.on("success", function(file, serverFileName) {


                        });
                    }

                });
                $(document).on('click', '.dz-error-mark', function(){
                    $(this).closest('.dz-preview').remove()
                })
            }


            function toggleBtnFix(){
                var k = 0;
                $('.toggle_radio').each(function(){
                    $(this).find('input[type="radio"]:first-of-type').attr('name', 'toggle_option'+k).attr('id', 'first_toggle'+k);
                    $(this).find('input[type="radio"]:last-of-type').attr('name', 'toggle_option'+k).attr('id', 'first_toggle'+k+'_2');

                    $(this).find('label:first-of-type').attr('for', 'first_toggle'+k);
                    $(this).find('label:last-of-type').attr('for', 'first_toggle'+k+'_2');
                    k++
                })
            }
            toggleBtnFix();
            $(document).on("click", ".account-left-box .page-links-list .btn", function(event) {
                //alert("working");
                //   event.preventDefault();

                var allSubContentMenu = $(this).parent().find('.btn');
                var targetContent = $(this).index();
                var allSubContent = $('.account-right-box').find('.page');
                var targetSubContent = $('.account-right-box').find('.page').eq(targetContent);
                var subContentHolder = $('.account-right-box');

                allSubContentMenu.removeClass('active');
                //   allSubContent.removeClass('active');

                $(this).addClass('active');
                //   targetSubContent.addClass('active');
                targetSubContent.closest('.baron__scroller').stop().animate({scrollTop:0}, 500);

                var SubContentAnimation = new TimelineMax();
                SubContentAnimation
                    .to(subContentHolder, 0.3, { opacity: 0, x: 0, ease: Power3.easeInOut,onCompleteParams:["{self}"], onComplete:function(){allSubContent.removeClass('active'); targetSubContent.addClass('active');}})
                    .to(subContentHolder, 0.3, { opacity: 1, x: 0, ease: Power3.easeInOut})
                ;

                if($('.left-panel-close-button').length){
                    setTimeout(function(){
                        $('.left-panel-close-button').trigger('click');
                    }, 300)

                }
                /*add sticky scroll*/
                if( $('#sticky').length){
                    if($(this).hasClass('activate-sticky-scroll')){
                        $('#sticky').addClass('active')
                    } else {
                        $('#sticky').removeClass('active')
                    }
                }


            });

            $(document).on("click", ".module-steps .item.done", function(event) {
                var activenumber = $(this).attr('data-number');
                var subSubPagesHolder = $(this).closest('.module-steps').parent().find('.inner-subpage-box'),
                    subPages = subSubPagesHolder.find('.sub-sub-page'),
                    steps = $(this).closest('.module-steps').find('.item');
                /*activate step*/
                steps.each(function(){
                    var self = $(this);
                    var stepNumber = self.attr('data-number');

                    if(stepNumber == activenumber){
                        self.addClass('active');
                    } else {
                        self.removeClass('active');
                    }

                });


                /*activate subpage*/
                (function switchPage(){
                    var SubContentAnimation = new TimelineMax();
                    SubContentAnimation
                        .to(subSubPagesHolder, 0.3, { opacity: 0, ease: Power3.easeInOut,onCompleteParams:["{self}"], onComplete:function(){showProperPage()}})
                        .to(subSubPagesHolder, 0.3, { opacity: 1, ease: Power3.easeInOut})
                    ;

                    function showProperPage(){

                        subPages.hide().removeClass('active');
                        subSubPagesHolder.find(".sub-sub-page[data-number='" + activenumber + "']").fadeIn().addClass('active');
                    }
                })();

            });
            /*account create edit*/
            $(document).on("click", ".sub-sub-page .switchSubSubPage", function(event) {
                //alert("working");
                   event.preventDefault();
                var subSubPagesHolder = $(this).closest('.inner-subpage-box'),
                    subPages = subSubPagesHolder.find('.sub-sub-page'),
                    steps = $(this).closest('.inner-subpage-box').parent().find('.module-steps .item');


                var activenumber = $(this).attr('data-number');
                if ($(this).text() == 'next'){
                    /*this was a next button clicked*/

                    /*activate subpage*/
                        subPages.each(function(){
                            var self = $(this);
                            var pageNumber = self.attr('data-number');
                            if(pageNumber > activenumber){
                                /*check if it is a next page*/
                                if( pageNumber - activenumber === 1){

                                    var SubContentAnimation = new TimelineMax();
                                    SubContentAnimation
                                        .to(subSubPagesHolder, 0.3, { opacity: 0, ease: Power3.easeInOut,onCompleteParams:["{self}"], onComplete:function(){showProperPage()}})
                                        .to(subSubPagesHolder, 0.3, { opacity: 1,  ease: Power3.easeInOut})
                                    ;

                                    function showProperPage(){
                                         subPages.hide().removeClass('active');
                                         self.fadeIn().addClass('active')
                                    }

                                }
                            }
                        });

                    /*activate step*/
                    steps.each(function(){
                        var self = $(this);
                        var stepNumber = self.attr('data-number');

                        if(stepNumber === activenumber){

                            self.addClass('done').removeClass('active');
                        }
                        if(stepNumber > activenumber ){
                           // self.removeClass('active').removeClass('done');
                            self.removeClass('active');
                        }
                        if(stepNumber - activenumber === 1){
                          //  self.addClass('active').removeClass('done');
                            self.addClass('active');
                        }


                    });

                } else {
                    /*this was a prev button clicked*/

                    /*activate subpage*/
                    subPages.each(function(){
                        var self = $(this);
                        var pageNumber = self.attr('data-number');
                        /*check if it is a prev page*/
                        if(pageNumber < activenumber){

                            if( activenumber - pageNumber === 1){

                                var SubContentAnimation = new TimelineMax();
                                SubContentAnimation
                                    .to(subSubPagesHolder, 0.3, { opacity: 0,  ease: Power3.easeInOut,onCompleteParams:["{self}"], onComplete:function(){showProperPage()}})
                                    .to(subSubPagesHolder, 0.3, { opacity: 1,  ease: Power3.easeInOut})
                                ;

                                function showProperPage(){
                                    subPages.hide().removeClass('active');
                                    self.fadeIn().addClass('active')
                                }
                            }
                        }
                    });
                    /*activate step*/
                    steps.each(function(){
                        var self = $(this);
                        var stepNumber = self.attr('data-number');
                        if(stepNumber == activenumber){
                            // self.removeClass('done').removeClass('active');
                          // !!!!!  self.removeClass('active').addClass('done');
                            self.removeClass('active');
                        }
                        if(stepNumber > activenumber){
                           // self.removeClass('done').removeClass('active');
                            self.removeClass('active');
                        }
                        if(stepNumber < activenumber ){
                            self.removeClass('active').addClass('done');
                        }
                        if( activenumber - stepNumber === 1){
                           // self.addClass('active').removeClass('done');
                            self.addClass('active');
                        }


                    });


                }


                $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop:0}, 500);
                autoHeightAuctionTextarea();

            });



            $('.tablet-left-panel-opener-box .left-panel-opener-button').on('click', function(){
                if(!$('.t2 .sec-1').hasClass('active')){$('.t2 .sec-1').addClass('active')}
                if(!$('.t2-top-panel .sec-1').hasClass('active')){$('.t2-top-panel .sec-1').addClass('active')}
            });
            $('.left-panel-close-button').on('click', function(){
                if($('.t2 .sec-1').hasClass('active')){$('.t2 .sec-1').removeClass('active')}
                if($('.t2-top-panel .sec-1').hasClass('active')){$('.t2-top-panel .sec-1').removeClass('active')}
            });

            $(document).on("click", ".module-tab-1 .tab-index .item", function() {

                if ( !$( this ).hasClass( "active" ) ) {

                    var targettab = $(this);

                    var tabindex = $(this).index();

                    var alltabs = $(this).parent().children();
                    var contentHolder = $(this).parent().parent().siblings('.tab-content');
                    var allcontent = $(this).parent().parent().siblings('.tab-content').children('.tab-item');
                    var targetcontent = $(this).parent().parent().siblings('.tab-content').children('.tab-item').eq(tabindex);

                    alltabs.removeClass('active');
                    targettab.addClass('active');

                    var tabAnimation = new TimelineMax();
                    tabAnimation
                        .to(allcontent, 0.3, { opacity: 0, x: 0, ease: Power3.easeInOut,onCompleteParams:["{self}"], onComplete:recount()})
                        .to(targetcontent, 0.3, { opacity: 1, x: 0, ease: Power3.easeInOut});

                    if(targetcontent.find('.chart-pie').length > 0){
                        setTimeout(function(){
                            chartPie();
                        },300);
                    }

                    function recount(){
                        allcontent.removeClass('active');
                        targetcontent.addClass('active');

                        tabsSystem();
                        alignGrid();
                    }

                }

            });
            $(document).on('click', '.seller-profile-module .img-holder .star', function(e){
                e.preventDefault();
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                }  else {
                    $(this).addClass('active');
                }
            });
            $(document).on('click', '.auction-detail .img-holder .star', function(e){
                e.preventDefault();
                if($(this).hasClass('active')){
                 //   alert('switch off')
                    $(this).removeClass('active');
                }  else {
                 //   alert('switch on')
                    $(this).addClass('active');
                }
            });

            $('.module-search-listing .listing-1 .img-holder .star').on('click', function(e){
                e.preventDefault();
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                }  else {
                    $(this).addClass('active');
                }
            });

            $('.top-controll-panel .btn').on('click', function(){
                if(!$(this).hasClass('active')){
                    $('.top-controll-panel .btn').removeClass('active');
                    $(this).addClass('active');
                }

                if($(this).hasClass('gridview')){
                    $('.module-search-listing .listing-1').fadeOut(400);
                    setTimeout(function(){
                        $('.module-search-listing .listing-1').addClass('gridview');
                        $('.module-search-listing .listing-1').fadeIn();
                    },400)

                } else{
                    $('.module-search-listing .listing-1').fadeOut(400);
                    setTimeout(function(){
                        $('.module-search-listing .listing-1').removeClass('gridview');
                        $('.module-search-listing .listing-1').fadeIn();
                    },400)
                }
            });

            $('.fake-link').click(function(){
               var link = $(this).data('link');
                window.location = link;
            });

            $('a').click(function() {

                if (($(this).attr('target') == '') || ($(this).attr('target') == '_self') && ($(this).attr('href').indexOf("#") == -1)) {

                    event.preventDefault();
                    newLocation = this.href;

                    TweenMax.to("html", 0.5, {opacity: 0, ease: Expo.easeOut, onComplete: newpage});

                }

            });

            $('.mobile-btn').click(function() {
                if($(this).hasClass('open')){
                    $('header .nav').fadeOut();
                    $(this).removeClass('open');
                } else {
                    $('header .nav').fadeIn();
                    $(this).addClass('open');

                    /*close account dropdown*/
                    if($('.logged .opener-el').length){
                        if($('.logged .opener-el').hasClass('active')){
                            $('.logged .opener-el').removeClass('active');
                        }
                    }

                    /*close filters if open*/
                    if($('.cpt-filter .filter-box-opener').length){
                        if($('.cpt-filter .filter-box-opener').hasClass('active')){
                            $('.cpt-filter .filter-box-opener').removeClass('active');
                            $('.cpt-filter .filter-box').removeClass('active');
                            unlockScroll();
                        }
                    }
                    if($('.left-panel-close-button').length){
                        setTimeout(function(){
                            $('.left-panel-close-button').trigger('click');
                        }, 300)

                    }

                    if($('.auction-detail .top-panel .opener-buttons').length){
                        if($('.auction-detail .top-panel .opener-buttons').hasClass('active')){
                            $('.auction-detail .top-panel .opener-buttons').trigger('click')
                        }
                    }

                }
            });


            function lockScroll(){
                $html = $('html');
                $body = $('body');
                var initWidth = $body.outerWidth();
                var initHeight = $body.outerHeight();

                var scrollPosition = [
                    self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
                    self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
                ];
                $html.data('scroll-position', scrollPosition);
                $html.data('previous-overflow', $html.css('overflow'));
                $html.css('overflow', 'hidden');
                window.scrollTo(scrollPosition[0], scrollPosition[1]);

                var marginR = $body.outerWidth()-initWidth;
                var marginB = $body.outerHeight()-initHeight;
                $body.css({'margin-right': marginR,'margin-bottom': marginB});

                console.log('scroll is locked');

            }

            function unlockScroll(){
                $html = $('html');
                $body = $('body');
                $html.css('overflow', $html.data('previous-overflow'));
                var scrollPosition = $html.data('scroll-position');
                window.scrollTo(scrollPosition[0], scrollPosition[1]);

                $body.css({'margin-right': 0, 'margin-bottom': 0});
                console.log('scroll is unlocked')
            }

            $('.cpt-filter .filter-box-opener').click(function(){

                if($(this).hasClass('active')){

                    $(this).removeClass('active');
                    $('.cpt-filter .filter-box').removeClass('active');
                    if($('.search-float-panel').length){
                        $('.search-float-panel').css('height', 'auto');
                    }
                    unlockScroll();

                } else {

                    $(this).addClass('active');
                    $('.cpt-filter .filter-box').addClass('active');

                    if($('.search-float-panel').length){
                        $('.search-float-panel').css('height', '100%');
                    }
                    lockScroll();
                }

            });
            $('.cpt-filter .filter-box .closer .close').click(function(){

                $('.cpt-filter .filter-box-opener').removeClass('active');
                $('.cpt-filter .filter-box').removeClass('active');
                if($('.search-float-panel').length){
                    $('.search-float-panel').css('height', 'auto');
                }
                unlockScroll();

            });
        }

        function alignGrid() {

            $('.container > *, .balancer > *').each(function() {

                $(this).removeClass("last");
                $(this).removeClass("first");

                var  targetItem;
                var  targetParent;

                targetItem = Math.round( $(this).offset().left + $(this).outerWidth(false) + ( ( $(this).outerWidth(true) - $(this).outerWidth(false) ) / 2 ) );
                targetParent = Math.round( $(this).parent().offset().left + $(this).parent().width() + ( ( $(this).parent().outerWidth(false) - $(this).parent().width() ) / 2 ) );

            //    console.log(targetItem + ' and ' + targetParent);

                if(targetItem - 20 <= targetParent && targetParent <= targetItem + 20) {

                    $(this).addClass("last");

                }

                targetItem = Math.round( $(this).offset().left );

                targetParent = Math.round( $(this).parent().offset().left );

             //   console.log(targetItem + ' and ' + targetParent);

                if(targetItem - 20 <= targetParent && targetParent <= targetItem + 20) {

                    $(this).addClass("first");

                }


            });

        }

        function mouseScroll() {

        /*    var $window = $(window);		//Window object

            var scrollTime = 0.5;			//Scroll time
            var scrollDistance = 200;		//Distance. Use smaller value for shorter scroll and greater value for longer scroll

            $window.on("DOMMouseScroll", function(event){

                event.preventDefault();

                var delta = event.originalEvent.wheelDelta/120 || -event.originalEvent.detail/3;
                var scrollTop = $window.scrollTop();
                var finalScroll = scrollTop - parseInt(delta*scrollDistance);

                TweenMax.to($window, scrollTime, {
                    scrollTo : { y: finalScroll, autoKill:true },
                    ease: Power1.easeinOut,	//For more easing functions see http://api.greensock.com/js/com/greensock/easing/package-detail.html
                    autoKill: true,
                    overwrite: 5
                });

            });*/

        }

        function pageAnimation() {

            //page-general fade in -------------------------------------------------->
            TweenMax.to("html", 1, {delay: 0.1, opacity: 1, ease: Expo.easeOut});

        }

        function cutNewsText(){
            (function (global, factory) {
                typeof exports === 'object' && typeof module !== 'undefined' ? factory() :
                    typeof define === 'function' && define.amd ? define(factory) :
                        (factory());
            }(this, (function () { 'use strict';

                function shave(target, maxHeight) {
                    var opts = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

                    if (!maxHeight) throw Error('maxHeight is required');
                    var els = typeof target === 'string' ? document.querySelectorAll(target) : target;

                    var character = opts.character || '…';
                    var classname = opts.classname || 'js-shave';
                    var spaces = opts.spaces || false;
                    var charHtml = '<span class="js-shave-char">' + character + '</span>';

                    if (!('length' in els)) els = [els];
                    for (var i = 0; i < els.length; i += 1) {
                        var el = els[i];
                        var styles = el.style;
                        var span = el.querySelector('.' + classname);
                        var textProp = el.textContent === undefined ? 'innerText' : 'textContent';

                        // If element text has already been shaved
                        if (span) {
                            // Remove the ellipsis to recapture the original text
                            el.removeChild(el.querySelector('.js-shave-char'));
                            el[textProp] = el[textProp]; // nuke span, recombine text
                        }

                        var fullText = el[textProp];
                        var words = spaces ? fullText.split(' ') : fullText;

                        // If 0 or 1 words, we're done
                        if (words.length < 2) continue;

                        // Temporarily remove any CSS height for text height calculation
                        var heightStyle = styles.height;
                        styles.height = 'auto';
                        var maxHeightStyle = styles.maxHeight;
                        styles.maxHeight = 'none';

                        // If already short enough, we're done
                        if (el.offsetHeight <= maxHeight) {
                            styles.height = heightStyle;
                            styles.maxHeight = maxHeightStyle;
                            continue;
                        }

                        // Binary search for number of words which can fit in allotted height
                        var max = words.length - 1;
                        var min = 0;
                        var pivot = void 0;
                        while (min < max) {
                            pivot = min + max + 1 >> 1; // eslint-disable-line no-bitwise
                            el[textProp] = spaces ? words.slice(0, pivot).join(' ') : words.slice(0, pivot);
                            el.insertAdjacentHTML('beforeend', charHtml);
                            if (el.offsetHeight > maxHeight) max = spaces ? pivot - 1 : pivot - 2;else min = pivot;
                        }

                        el[textProp] = spaces ? words.slice(0, max).join(' ') : words.slice(0, max);
                        el.insertAdjacentHTML('beforeend', charHtml);
                        var diff = spaces ? words.slice(max).join(' ') : words.slice(max);

                        el.insertAdjacentHTML('beforeend', '<span class="' + classname + '" style="display:none;">' + diff + '</span>');

                        styles.height = heightStyle;
                        styles.maxHeight = maxHeightStyle;
                    }
                }

                /* global window */
                if (typeof window !== 'undefined') {
                    var plugin = window.$ || window.jQuery || window.Zepto;
                    if (plugin) {
                        plugin.fn.shave = function shavePlugin(maxHeight, opts) {
                            shave(this, maxHeight, opts);
                            return this;
                        };
                    }
                }

                if($('.news-listing').length){
                    $('.news-listing .listing-1 .item').each(function(){
                        var parentH = $(this).find('.box').outerHeight(),
                            titleH = $(this).find('.title').outerHeight(),
                            textbox =  $(this).find('.stamp'),
                            text = $(this).find('.stamp p');
                        var leftHeight = parentH - titleH;
                        var leftHeightText = parentH - titleH - 10;

                        textbox.height(leftHeight);
                        shave(text, leftHeightText);

                    })

                }

            })));




        }

        function infiniteScrollSearch(){
            var text = $('.module-search-listing .listing-1 .item').html();
            var k=0;
            var footerH=$('.footer').outerHeight();
            var listing = $('.listing-1');

            function chk_scroll(e) {
                var elem = $(e.currentTarget);
                var lOH = listing.outerHeight();

                console.log((elem[0].scrollHeight-footerH) , (elem.scrollTop()) , elem.outerHeight())
                 //   if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
                    if ((elem[0].scrollHeight-footerH) - elem.scrollTop() <= elem.outerHeight()) {
                       // alert('end', k);
                        console.log('end');
                        k++;
                        if(k<10){
                            if ($(".module-search-listing .listing-1").hasClass('gridview')) {
                                for (i = 0; i <= 3; i++) {
                                    addItem();
                                }
                            } else {
                                addItem();


                            }
                            clickFunctions();
                        }


                            function addItem(){
                                var newItem = $("<div>").addClass("item").appendTo(".module-search-listing .listing-1").html(text);


                                /*start a new timer*/
                                $(newItem).find('.timer').each(function(){
                                    if($(this).data('started') !== 'started'){
                                        $(this).backward_timer({
                                            seconds: $(this).data('left'),
                                            on_tick: function(timer) {
                                                var color = ((timer.seconds_left < 30) == 0)
                                                    ? "#53c00b"
                                                    : "red";
                                                timer.target.css('color', color);
                                                $(timer.target)[0].setAttribute('data-started', "started");
                                            }
                                        })
                                    }
                                });

                                $(newItem).find('.timer').backward_timer('start')
                            }



                    }


            }
           /* $('.search-list-content .baron__scroller').on('scroll', function(e){
                chk_scroll(e);
            })*/

            $('.search-list-container.baron__scroller').on('scroll', function(e){
                chk_scroll(e);
            })


        }

        function rangeYear(){


            if($('#yearrange').length){
                var html5Slider = document.getElementById('yearrange');

                noUiSlider.create(html5Slider, {
                    start: [ 2000, 2015 ],
                    connect: true,
                    range: {
                        'min': 1980,
                        'max': 2050
                    }
                });

                var inputNumber3 = document.getElementById('input-number3');
                var inputNumber4 = document.getElementById('input-number4');
                inputNumber3.style.width = ((inputNumber3.value.length + 1) * 8) + 'px';
                inputNumber4.style.width = ((inputNumber4.value.length + 1) * 9) + 'px';

                html5Slider.noUiSlider.on('update', function( values, handle ) {

                    var value = values[handle];

                    if ( handle ) {
                        inputNumber4.value =  Math.round(value);
                    } else {
                        inputNumber3.value =   Math.round(value);
                    }

                    inputNumber3.style.width = ((inputNumber3.value.length + 1) * 8) + 'px';
                    inputNumber4.style.width = ((inputNumber4.value.length + 1) * 9) + 'px';
                });
                $(inputNumber3)
                    .on('change', function(e){
                        e.preventDefault();
                        html5Slider.noUiSlider.set([this.value, null]);
                    })
                    .on('keypress', function(){
                        inputNumber3.style.width = ((inputNumber3.value.length + 1) * 8) + 'px';
                    })
                    .on('focus', function(){
                        $(this).closest('.fake-input').addClass('active');
                    }).on('blur', function(){
                        $(this).closest('.fake-input').removeClass('active');
                    });
                $(inputNumber4)
                    .on('change', function(e){
                        e.preventDefault();
                        html5Slider.noUiSlider.set([null, this.value]);
                    })
                    .on('keypress', function(){
                        inputNumber4.style.width = ((inputNumber4.value.length + 1) * 8) + 'px';
                    })
                    .on('focus', function(){
                        $(this).closest('.fake-input').addClass('active');
                    }).on('blur', function(){
                        $(this).closest('.fake-input').removeClass('active');
                    });

                $('.fake-input').on('click', function(e){
                    var inputNumber1 =$(this).find('.class1');
                    var inputNumber2 =$(this).find('.class2');

                    var senderElementName = event.target.className.toLowerCase();
                    if(senderElementName.indexOf("class1") >= 0){
                        $(this).find(inputNumber1).focus();
                    }
                    else if(senderElementName.indexOf("class2") >= 0){
                        $(this).find(inputNumber2).focus();
                    }
                    else {
                        $(this).find(inputNumber1).focus();
                    }
                });

                $('.form').on("keypress", function(e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        return false;
                    }
                });
            }

        }

        function rangePrice(){

            if($('#pricerange').length){

                var html5Slider = document.getElementById('pricerange');

                noUiSlider.create(html5Slider, {
                    start: [ 0, 5000 ],
                    connect: true,
                    range: {
                        'min': 0,
                        'max': 20000
                    }
                });

                var inputNumber1 = document.getElementById('input-number1');
                var inputNumber2 = document.getElementById('input-number2');
                inputNumber1.style.width = ((inputNumber1.value.length + 1) * 8) + 'px';
                inputNumber2.style.width = ((inputNumber2.value.length + 1) * 9) + 'px';

                html5Slider.noUiSlider.on('update', function( values, handle ) {

                    var value = values[handle];

                    if ( handle ) {
                        inputNumber2.value =  Math.round(value);
                    } else {
                        inputNumber1.value =   Math.round(value);
                    }

                    inputNumber1.style.width = ((inputNumber1.value.length + 1) * 8) + 'px';
                    inputNumber2.style.width = ((inputNumber2.value.length + 1) * 9) + 'px';
                });
                $(inputNumber1)
                    .on('change', function(e){
                        e.preventDefault();
                        html5Slider.noUiSlider.set([this.value, null]);
                    })
                    .on('keypress', function(){
                        inputNumber1.style.width = ((inputNumber1.value.length + 1) * 8) + 'px';
                    })
                    .on('focus', function(){
                        $(this).closest('.fake-input').addClass('active');
                    }).on('blur', function(){
                        $(this).closest('.fake-input').removeClass('active');
                    });
                $(inputNumber2)
                    .on('change', function(e){
                        e.preventDefault();
                        html5Slider.noUiSlider.set([null, this.value]);
                    })
                    .on('keypress', function(){
                        inputNumber2.style.width = ((inputNumber2.value.length + 1) * 8) + 'px';
                    })
                    .on('focus', function(){
                        $(this).closest('.fake-input').addClass('active');
                    }).on('blur', function(){
                        $(this).closest('.fake-input').removeClass('active');
                    });
            }



        }

        function rangeMiles(){

            if($('#milesrange').length){

                var html5Slider = document.getElementById('milesrange');

                noUiSlider.create(html5Slider, {
                    start: [ 10, 12000 ],
                    connect: true,
                    range: {
                        'min': 0,
                        'max': 20000
                    }
                });

                var inputNumber5 = document.getElementById('input-number5');
                var inputNumber6 = document.getElementById('input-number6');
                inputNumber5.style.width = ((inputNumber5.value.length + 1) * 8) + 'px';
                inputNumber6.style.width = ((inputNumber6.value.length + 1) * 9) + 'px';

                html5Slider.noUiSlider.on('update', function( values, handle ) {

                    var value = values[handle];

                    if ( handle ) {
                        inputNumber6.value =  Math.round(value);
                    } else {
                        inputNumber5.value =   Math.round(value);
                    }

                    inputNumber5.style.width = ((inputNumber5.value.length + 1) * 8) + 'px';
                    inputNumber6.style.width = ((inputNumber6.value.length + 1) * 9) + 'px';
                });


                $(inputNumber5)
                    .on('change', function(e){
                        e.preventDefault();
                        html5Slider.noUiSlider.set([this.value, null]);
                    })
                    .on('keypress', function(){
                        inputNumber5.style.width = ((inputNumber5.value.length + 1) * 8) + 'px';
                    })
                    .on('focus', function(){
                        $(this).closest('.fake-input').addClass('active');
                    }).on('blur', function(){
                        $(this).closest('.fake-input').removeClass('active');
                    });
                $(inputNumber6)
                    .on('change', function(e){
                        e.preventDefault();
                        html5Slider.noUiSlider.set([null, this.value]);
                    })
                    .on('keypress', function(){
                        inputNumber6.style.width = ((inputNumber6.value.length + 1) * 8) + 'px';
                    })
                    .on('focus', function(){
                        $(this).closest('.fake-input').addClass('active');
                    }).on('blur', function(){
                        $(this).closest('.fake-input').removeClass('active');
                    });
            }

        }

        function tabsSystem() {

            var tabInstance = $('.module-tab-1 .tab-content');
            tabInstance.each(function() {
                var tabchildrenheight = $(this).find('.tab-item.active').outerHeight();
                $(this).css('min-height', tabchildrenheight);
            });
            tabInstance.each(function() {

                if($(this).find('.module-tab-1').length > 0){
                    $(this).addClass('top-tabs');
                   /* if($('.module-login').length){
                        $('.top-tabs').css('min-height', $('.module-login .right').outerHeight() -100);
                    }*/
                }

            });

/*

            var tabInstance = $('.module-tab-1 .tab-content');
            tabInstance.each(function() {

                if($(this).find('.module-tab-1').length > 0){
                    var $this = $(this);

                    var innerTabs = $this.find('.module-tab-1');
                    console.log(innerTabs);

                    var tabchildrenheight = innerTabs.find('.tab-item.active').outerHeight();
                    innerTabs.css('min-height', tabchildrenheight);

                    setTimeout(function(){
                        var tabchildrenheight2 = $this.find('.tab-item.active').outerHeight() + 120;
                        $this.css('min-height', tabchildrenheight2);
                    },200)

                } else {
                    var tabchildrenheight = $(this).find('.tab-item.active').outerHeight();
                    $(this).css('min-height', tabchildrenheight);
                }

            });
*/

        }

        function tabsPreSet(){
            /*tabs pre set*/
            $('.module-tab-1 .tab-index .item').each( function() {

                if ( !$( this ).hasClass( "active" ) ) {

                    var targettab = $(this);

                    var tabindex = $(this).index();

                    var alltabs = $(this).parent().children();
                    var contentHolder = $(this).parent().parent().siblings('.tab-content');
                    var allcontent = $(this).parent().parent().siblings('.tab-content').children('.tab-item');
                    var targetcontent = $(this).parent().parent().siblings('.tab-content').children('.tab-item').eq(tabindex);

                    var tabAnimation = new TimelineMax();
                    tabAnimation
                        .to(allcontent, 0.3, { opacity: 1, x:0, ease: Power3.easeInOut,onCompleteParams:["{self}"], onComplete:recount()})
                        .to(targetcontent, 0.3, { opacity: 0, x:  0, ease: Power3.easeInOut});


                    function recount(){
                        tabsSystem();
                        alignGrid();
                    }

                }

            });
        }

        function loadInstance(){

            $(document).on("click", '.ajaxtrigger-forgot', function(event) {
                event.preventDefault();

                var targetLink = $(this).attr('href');

                loginTransition();


                function loginTransition() {

                    $.get(targetLink, {}, function(data){

                        $(".module-tab-2").fadeOut(300, function() {
                            $(".module-tab-2").html(data);
                            $(".module-tab-2").fadeIn(300);
                        });

                    });
                }

            });

            $(document).on("click", '.ajaxtrigger-login', function(event) {
                event.preventDefault();
                if($(this).hasClass('fake-tab') && !$(this).hasClass('active')){
                    $('.fake-tab').removeClass('active');
                    $(this).addClass('active');
                }

                var targetLink = $(this).attr('href');

                loginTransition();


                function loginTransition() {

                    $.get(targetLink, {}, function(data){

                        $(".module-tab-2 .content > .tab-content > .tab-item").fadeOut(300, function() {
                            $(".module-tab-2 .content > .tab-content > .tab-item").html(data);
                            $(".module-tab-2 .content > .tab-content > .tab-item").fadeIn(300);
                        });

                    });
                }

            });


            $(document).on("click", '.ajaxtrigger-login-inner', function(event) {
                event.preventDefault();
                if($(this).hasClass('fake-tab-inner') && !$(this).hasClass('active')){
                    $('.fake-tab-inner').removeClass('active');
                    $(this).addClass('active');
                }

                var targetLink = $(this).attr('href');

                loginTransition();


                function loginTransition() {

                    $.get(targetLink, {}, function(data){

                        $(".module-tab-3 .content > .tab-content > .tab-item").fadeOut(300, function() {
                            $(".module-tab-3 .content > .tab-content > .tab-item").html(data);
                            $(".module-tab-3 .content > .tab-content > .tab-item").fadeIn(300);
                            if($('#fileuploader').length){
                                fileUploader()
                            }
                        });

                    });
                }

            });

        }


        function fileUploader(){

            var init = $('.module-uploader .uploadFile');
            $(document).on('change', '.module-uploader .uploadFile', function(){

                var  parent = $(this).parent().parent().parent(), //$(this).closest('.module-uploader')
                    files = parent.find(".files"),
                    error = parent.find(".fileUploadError"),
                    progressTemplate = parent.find(".fileUploadProgressTemplate"),
                    uploadTemplate = parent.find(".fileUploadItemTemplate");
                var formData = new FormData();
             //   formData.append('file', this.files[0]);


                $.each($("input[type='file']")[0].files, function(i, file) {
                    formData.append('file', file);
                });
                var oldInput = parent.find(".uploadFile");

                var newInput = document.createElement("input");

                newInput.type = "file";
                newInput.id = oldInput.id;
                newInput.name = oldInput.name;
                newInput.className = 'uploadFile';
                // copy any other relevant attributes
                var inputParent = oldInput.parent();
                oldInput.parent().find(oldInput).remove();
                inputParent.append(newInput);
               // oldInput.parentNode.replaceChild(newInput, oldInput);

                files.append(progressTemplate.tmpl());
                error.addClass("hide");

                $.ajax({
                    url: '',
                    type: 'POST',
                    xhr: function() {
                        var xhr = $.ajaxSettings.xhr();
                      /*  if (xhr.upload) {
                            xhr.upload.addEventListener('progress', function(evt) {
                                var percent = (evt.loaded / evt.total) * 100;
                                files.find(".progress-bar").width(percent + "%");
                            }, false);
                        }*/
                        return xhr;
                    },
                    success: function(datas) {
                        files.children().last().remove();
                        files.append(uploadTemplate.tmpl(datas));
                       // init.closest("form").trigger("reset");


                    },
                    error: function() {
                        error.removeClass("hide").text("An error occured!");
                        files.children().last().remove();
                        alert(error);
                      //  init.closest("form").trigger("reset");
                    },
                    datas: formData,
                    cache: false,
                   // contentType: false,
                  //  processData: false
                }, 'json');


                $(document).on('click', '.module-uploader .closed', function(){
                    $(this).closest('.list-group-item').remove();
                });

                previewUpload();
            })
        }

        function previewUpload(){
            $(document).on('click', '.popup', function(e){
                e.preventDefault();
               /* if(!$('.popup-box').hasClass('active')){
                    $('.popup-box').addClass('active');
                }*/
                $('.popup-box').hide();
                var number = $(this).attr('data-number');

                if($('.popup-box-' + number).hasClass('active')){
                    return false;
                } else {
                    $('.popup-box-' + number).addClass('active');
                    $('.popup-box-' + number).show();
                }

            });

            $(document).on('click', '.popup-box .close', function(){
                if($('.popup-box').hasClass('active')){
                    $('.popup-box').removeClass('active');
                }
            })

            $(document).on('click', '.popup-box .close-it', function(){
                if($('.popup-box').hasClass('active')){
                    $('.popup-box').removeClass('active');
                }
            })
        }


        function timer(){
            $('.timer').each(function(){
                if($(this).data('started') !== 'started'){
                    $(this).backward_timer({
                        seconds: $(this).data('left'),
                        on_tick: function(timer) {
                            var color = ((timer.seconds_left < 30) == 0)
                                ? "#53c00b"
                                : "red";
                            timer.target.css('color', color);
                            $(timer.target)[0].setAttribute('data-started', "started");
                        }
                    })
                }


            })

            $('.timer').backward_timer('start')
        }

        function customScroll(){
            var scroller0 =  $('.baron').baron({
                root: '.baron',
                scroller: '.baron__scroller',
                bar: '.baron__bar',
                scrollingCls: '_scrolling',
                draggingCls: '_dragging'
            });

            if($('body').hasClass('tablet') || $('body').hasClass('mobile')){
                scroller0.dispose();
            } else {
                scroller0.update();
            }
        }


        function detectWinWidth(){

            function checkWindowSize() {
                var width = $(window).width(),
                    new_class = width > 10000 ? 'desktop' :
                        width > 1008 ? 'desktop' :
                            width > 752 ? 'tablet' :
                                width > 0 ? 'mobile' : '';

                $(document.body).removeClass('desktop tablet mobile').addClass(new_class);
            }
            checkWindowSize();

        }

        function alerts(){
            /*$.iaoAlert({

                // default message
                msg: "This is default iao alert message.",

                // or 'success', 'error', 'warning'
                type: "notification",

                // or dark
                mode: "light",

                // auto hide
                autoHide: true,

                // fade animation speed
                fadeTime: "500",

                // shows close button
                closeButton: true,

                // close on click
                closeOnClick: false,

                // custom position
                position: 'top-right',

                // fade on hover
                fadeOnHover: true,

                // z-index
                zIndex: '999',

                // additional CSS class(es)
                alertClass: ''

            })*/

            $( ".alert-default" ).click(function() {
                var msg = $(this).find('.io-text').html();
                $.iaoAlert({
                    msg: msg,
                    autoHide: false,
                    type: "notification",
                    position: 'bottom-right',
                    fadeOnHover: false,
                    //   fadeTime: "1500",
                    mode: "dark"})
            });

            $( ".alert-warning" ).click(function() {
                var msg = $(this).find('.io-text').html();
                $.iaoAlert({
                    msg: msg,
                    type: "error",
                    autoHide: false,
                    position: 'bottom-right',
                    fadeOnHover: false,
                  //  fadeTime: "1500",
                    mode: "dark"})
            });
            $( ".alert-success" ).click(function() {
                var msg = $(this).find('.io-text').html();
                $.iaoAlert({
                    msg: msg,
                    type: "success",
                    autoHide: false,
                    position: 'bottom-right',
                    fadeOnHover: false,
                 //   fadeTime: "1500",
                    mode: "dark"})
            });

        }

        function customBuyerScroll(){
            var scroller1 =  $('.baron-table').baron({
                root: '.baron-table',
                scroller: '.baron__scroller',
                bar: '.baron__bar',
                direction: 'h',
                scrollingCls: '_scrolling',
                draggingCls: '_dragging'
            });

           /* if($('body').hasClass('tablet') || $('body').hasClass('mobile')){
                scroller1.dispose();
            } else {
                scroller1.update();
            }*/
        }

        function isInView(){


            !function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){function i(){var b,c,d={height:f.innerHeight,width:f.innerWidth};return d.height||(b=e.compatMode,(b||!a.support.boxModel)&&(c="CSS1Compat"===b?g:e.body,d={height:c.clientHeight,width:c.clientWidth})),d}function j(){return{top:f.pageYOffset||g.scrollTop||e.body.scrollTop,left:f.pageXOffset||g.scrollLeft||e.body.scrollLeft}}function k(){if(b.length){var e=0,f=a.map(b,function(a){var b=a.data.selector,c=a.$element;return b?c.find(b):c});for(c=c||i(),d=d||j();e<b.length;e++)if(a.contains(g,f[e][0])){var h=a(f[e]),k={height:h[0].offsetHeight,width:h[0].offsetWidth},l=h.offset(),m=h.data("inview");if(!d||!c)return;l.top+k.height>d.top&&l.top<d.top+c.height&&l.left+k.width>d.left&&l.left<d.left+c.width?m||h.data("inview",!0).trigger("inview",[!0]):m&&h.data("inview",!1).trigger("inview",[!1])}}}var c,d,h,b=[],e=document,f=window,g=e.documentElement;a.event.special.inview={add:function(c){b.push({data:c,$element:a(this),element:this}),!h&&b.length&&(h=setInterval(k,250))},remove:function(a){for(var c=0;c<b.length;c++){var d=b[c];if(d.element===this&&d.data.guid===a.guid){b.splice(c,1);break}}b.length||(clearInterval(h),h=null)}},a(f).on("scroll resize scrollstop",function(){c=d=null}),!g.addEventListener&&g.attachEvent&&g.attachEvent("onfocusin",function(){d=null})});
        }

        isInView();

        function buttonVisible(){


                $('footer').on('inview', function(event, visible) {
                    if (visible) {
                        $('.abs').addClass('static')
                    } else {
                        // element has gone out of viewport
                        $('.abs').removeClass('static')
                    }
                });


        }


        function additionalCustomScroll(){
            $(".t2 .baron__scroller").on('scroll', function(){
                var offset1 = $('#flag1').offset(),
                    offT1 = offset1.top,
                    offset2 = $('#flag2').offset(),
                    offT2 = offset2.top,
                    tableHeight = $('.payment-table-holder').outerHeight(),
                    winHeight = $(window).height();



                if($('.abs').length){
                    buttonVisible();
                }

                if($('.payment-table-holder').visible()){


                    if(offT1 < 0){
                        if((offT2 - 100) < winHeight){
                        //    console.log('bottom of table')
                            $('#sticky').removeClass('active')
                        }
                       /* else  if((offT2 + 50) > tableHeight){
                            console.log('top of table')
                            $('#sticky').removeClass('active')
                        }*/

                        else {
                         //   console.log('sticky')

                            $('#sticky').addClass('active')
                        }
                    }
                }


            });
        }

        function autoHeightAuctionTextarea(){
            if($('.module-create-edit').length){
                autosize($('.module-create-edit textarea'));
            }
        }


        function auctionDetailTopPanel1Col(){

            var panel = $('.auction-detail.in-one-col .top-panel');
            var panelHeight = panel.outerHeight();
            var headerHeight = $('.header').outerHeight();
            var content = $('.auction-detail.in-one-col');

            if ($('body').hasClass('desktop') || $('body').hasClass('tablet')){
                content.css('padding-top', panelHeight + headerHeight);

                $("html").on('DOMSubtreeModified', ".desktop .auction-detail.in-one-col .top-panel .title", function() {
                    setTimeout(function(){
                        var panelHeight = $('.auction-detail.in-one-col .top-panel').outerHeight();
                        content.css('padding-top', panelHeight + headerHeight);
                    },300)

                });

            }
            if ($('body').hasClass('mobile')){
                $('.auction-detail.in-one-col').css('padding-top', headerHeight);

                $("html").on('DOMSubtreeModified', ".desktop .auction-detail.in-one-col .top-panel .title", function() {
                    setTimeout(function(){
                        content.css('padding-top', headerHeight);
                    },300)

                });
            }



        }
        function auctionDetailTopPanel2Col(){
            var panel = $('.auction-detail.in-two-col .top-panel');
            var panelHeight = panel.outerHeight();
            var headerHeight = $('.header').outerHeight();
            var content = $('.auction-detail.in-two-col');

            if ($('body').hasClass('desktop') || $('body').hasClass('tablet')){
                content.css('padding-top', panelHeight);

                $("html").on('DOMSubtreeModified', ".desktop .auction-detail.in-two-col .top-panel .title", function() {
                    setTimeout(function(){
                        var panelHeight = $('.auction-detail.in-two-col .top-panel').outerHeight();
                        content.css('padding-top', panelHeight);
                    },300)

                });

            }
            if ($('body').hasClass('mobile')){
                $('.auction-detail.in-two-col').css('padding-top', 0);

                $("html").on('DOMSubtreeModified', ".desktop .auction-detail.in-two-col .top-panel .title", function() {
                    setTimeout(function(){
                        content.css('padding-top', 0);
                    },300)

                });
            }

        }


        function detectBrowser(){
            /**
             * Gets the browser name or returns an empty string if unknown.
             * This function also caches the result to provide for any
             * future calls this function has.
             *
             * @returns {string}
             */
            var browser = function() {
                // Return cached result if avalible, else get result then cache it.
                if (browser.prototype._cachedResult)
                    return browser.prototype._cachedResult;

                // Opera 8.0+
                var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

                // Firefox 1.0+
                var isFirefox = typeof InstallTrigger !== 'undefined';

                // Safari 3.0+ "[object HTMLElementConstructor]"
                var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

                // Internet Explorer 6-11
                var isIE = /*@cc_on!@*/false || !!document.documentMode;

                // Edge 20+
                var isEdge = !isIE && !!window.StyleMedia;

                // Chrome 1+
                var isChrome = !!window.chrome && !!window.chrome.webstore;

                // Blink engine detection
                var isBlink = (isChrome || isOpera) && !!window.CSS;

                return browser.prototype._cachedResult =
                    isOpera ? 'opera' :
                        isFirefox ? 'firefox' :
                            isSafari ? 'Safari' :
                                isChrome ? 'chrome' :
                                    isIE ? 'ie' :
                                        isEdge ? 'edge' :
                                            isBlink ? 'blink' :
                                                "Don't know";
            };

            $('body').addClass(browser());

        }

        function auctionLayoutFix(){
            var windowHeight = $(window).height();
            var topSpace = $('.t2-top-panel-instance').outerHeight();
            $('.sec-holder-inner').css('height', windowHeight-topSpace);
        }


        function infiniteScrollAuctionSeller(){
            var text = $('.auction-detail .payment-table-holder .table-row.new').html();
            var k=0;
            var footerH=$('.footer').outerHeight();
            var listing = $('.auction-detail .payment-table-holder');

            function chk_scroll(e) {
                var elem = $(e.currentTarget);
                var lOH = listing.outerHeight();

             //   console.log((elem[0].scrollHeight-footerH) , (elem.scrollTop()) , elem.outerHeight())
                //   if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
                if ((elem[0].scrollHeight-footerH) - elem.scrollTop() <= elem.outerHeight()) {
                    // alert('end', k);
                    console.log('end');
                    k++;
                    if(k<100){
                        addItem();
                    }


                    function addItem(){
                        var newItem = $("<div>").addClass("table-row").appendTo(".auction-detail .payment-table .table-body").html(text);

                    }

                }


            }


            $('.t1-top-panel .sec-1').on('scroll', function(e){
                chk_scroll(e);
            })


        }

        function dragTables(){
            (function ($, global) {
                var doc = global.document,
                //body = $(doc.body),
                    $global = $(global),

                // sc_listener = $.browser.msie && $.browser.version < 9 ? $('html') : $global;
                    sc_listener = $global;

                function scrollbarDimension(c, b, method) {
                    var a = c[0]['scroll' + method] / b['outer' + method]();
                    return [a, Math.floor(b['inner' + method]() / a)];
                }

                function DragScroll() {
                    this.init.apply(this, arguments);
                }

                DragScroll.prototype = {
                    name: 'dragscroll',
                    isTouchDevice: global.ontouchstart !== void 0
                };

                $.extend(DragScroll.prototype, {
                    events: {

                        M_DOWN: DragScroll.prototype.isTouchDevice ? 'touchstart.' + DragScroll.prototype.name: 'mousedown.' + DragScroll.prototype.name,
                        M_UP: DragScroll.prototype.isTouchDevice ? 'touchend.' + DragScroll.prototype.name: 'mouseup.' + DragScroll.prototype.name,
                        M_MOVE: DragScroll.prototype.isTouchDevice ? 'touchmove.' + DragScroll.prototype.name: 'mousemove.' + DragScroll.prototype.name,
                        M_ENTER: 'mouseenter.' + DragScroll.prototype.name,
                        M_LEAVE: 'mouseleave.' + DragScroll.prototype.name,
                        M_WHEEL: 'mousewheel.' + DragScroll.prototype.name,
                        S_STOP: 'scrollstop.' + DragScroll.prototype.name,
                        S_START: 'scrollstart.' + DragScroll.prototype.name,
                        SCROLL: 'scroll.' + DragScroll.prototype.name,
                        RESIZE: DragScroll.prototype.isTouchDevice ? 'orientationchange.' + DragScroll.prototype.name: 'resize.' + DragScroll.prototype.name

                    },
                    init: function (elem, options) {
                        var div = '<div/>',
                            that = this;
                        this.options = options;
                        this.elem = elem;
                        this.innerElem = this.elem.wrapInner(div).children(0);
                        this.scrollElem = this.innerElem.wrap(div).parent();
                        this.elem.addClass(this.name + '-container');
                        this.innerElem.addClass(this.name + '-inner');
                        this.scrollElem.addClass(this.name + '-scroller');
                        var $div = $(div);

                        this.scrollBarContainer = $([$div, $div.clone()]);
                        this.scrollBar = $([$div.clone(), $div.clone()]);
                        this.scrollBarContainer.each(function (i) {
                            var o = i === 0 ? 'h': 'v',
                                ah = that.options.autoFadeBars ? ' autohide': '';
                            that.scrollBarContainer[i].addClass(that.name + '-scrollbar-container ' + o + ah).append(that.scrollBar[i].addClass(that.name + '-scrollbar ' + o));
                            that._addBars(i);
                        });

                        this.elem.css('overflow', 'visible');

                        this.mx = 0;
                        this.my = 0;
                        this.__tmp__ = {
                            _diff_x: 0,
                            _diff_y: 0,
                            _temp_x: 0,
                            _temp_y: 0,
                            _x: 0,
                            _y: 0,
                            _mx: 0,
                            _my: 0,
                            _deltaX: 0,
                            _deltaY: 0,
                            _start: {
                                x: 0,
                                y: 0
                            }
                        };
                        this.__tmp__._scrolls = false;
                        this._buildIndex();
                        this.timer = void 0;
                        this._bind();
                        this.elem.trigger(this.name + 'ready');
                    },
                    /**
                     *  call this on changes of the scrollcontainer, e.g updated content, size changes, etc.
                     */
                    reInit: function () {
                        return this._buildIndex();
                    },
                    _addBars: function (i) {
                        if (this.options.scrollBars) {
                            this.scrollBarContainer[i].appendTo(this.elem);
                        }
                    },
                    _buildIndex: function () {
                        this.barIndex = {
                            X: scrollbarDimension(this.scrollElem, this.scrollElem, 'Width'),
                            Y: scrollbarDimension(this.scrollElem, this.scrollElem, 'Height')
                        };
                        this._getContainerOffset();
                        this.scrollBar[0].css({
                            width: this.barIndex.X[1]
                        });
                        this.scrollBar[1].css({
                            height: this.barIndex.Y[1]
                        });

                        this.__tmp__._cdd = {
                            x: this.options.scrollBars ? this.scrollBarContainer[0].innerWidth() : this.scrollElem.innerWidth(),
                            y: this.options.scrollBars ? this.scrollBarContainer[1].innerHeight() : this.scrollElem.innerHeight()
                        };
                        this.barIndex.X[0] === 1 ? this.scrollBarContainer[0].detach() : this._addBars(0);
                        this.barIndex.Y[0] === 1 ? this.scrollBarContainer[1].detach() : this._addBars(1);

                    },
                    _bind: function () {
                        var that = this;
                        sc_listener.bind(this.events.RESIZE, $.proxy(this._buildIndex, this));
                        this.elem.bind('destroyed', $.proxy(this.teardown, this));
                        this.elem.bind(this.name + 'ready', $.proxy(this.onInitReady, this));
                        //this.scrollBarContainer.bind(this.events.M_DOWN,$.proxy(this.scrollStart,this));
                        this.elem.delegate('.' + this.name + '-scrollbar-container', this.events.M_DOWN, $.proxy(this.scrollStart, this));

                        // bind the mouseWheel unless requested otherwise
                        if (false === this.options.ignoreMouseWheel) {
                            this.elem.bind(this.events.M_WHEEL, $.proxy(this.scrollStart, this));
                        }

                        this.scrollElem.bind(this.events.M_DOWN, $.proxy(this.dragScrollStart, this));

                        if (this.options.autoFadeBars) {
                            this.elem.delegate('.' + this.name + '-scrollbar-container', 'mouseenter', $.proxy(this.showBars, this)).delegate('.' + this.name + '-scrollbar-container', 'mouseleave', $.proxy(this.hideBars, this));
                        }
                        this.elem.bind(this.events.S_START, function () {
                            that.options.onScrollStart.call(that.elem.addClass('scrolls'));
                            that.options.autoFadeBars && that.showBars();
                        }).bind(this.events.S_STOP, function () {
                            that.options.onScrollEnd.call(that.elem.removeClass('scrolls'));
                            that.options.autoFadeBars && that.hideBars();
                        });

                    },
                    _unbind: function () {
                        this.elem.unbind(this.name + 'ready').undelegate('.' + this.name + '-scrollbar-container', this.events.M_DOWN).undelegate('.' + this.name + '-scrollbar-container', 'mouseenter').undelegate('.' + this.name + '-scrollbar-container', 'mouseleave').unbind(this.events.M_WHEEL).unbind(this.events.S_STOP).unbind(this.events.S_START);
                        this.scrollElem.unbind(this.events.M_DOWN);
                        sc_listener.unbind(this.events.M_MOVE).unbind(this.events.M_UP).unbind(this.events.RESIZE);
                    },
                    onInitReady: function () {

                        if (this.options.autoFadeBars) {
                            this.showBars().hideBars();
                        } else {
                            this.showBars();
                        }
                    },
                    initMouseWheel: function (mode) {
                        if (true === this.options.ignoreMouseWheel) {
                            return false;
                        }
                        if (mode === 'rebind') {
                            this.elem.unbind(this.events.M_WHEEL).bind(this.events.M_WHEEL, $.proxy(this.scrollStart, this));
                        } else {
                            this.elem.unbind(this.events.M_WHEEL).bind(this.events.M_WHEEL, $.proxy(this._getMousePosition, this));
                        }
                    },

                    _getContainerOffset: function () {
                        this.containerOffset = this.elem.offset();
                    },
                    _pageXY: (function () {
                        if (DragScroll.prototype.isTouchDevice) {
                            return function (e) {
                                return {
                                    X: e.originalEvent.touches[0].pageX,
                                    Y: e.originalEvent.touches[0].pageY
                                };
                            };
                        } else {
                            return function (e) {
                                return {
                                    X: e.pageX,
                                    Y: e.pageY
                                };
                            };
                        }
                    } ()),
                    _getScrollOffset: function () {
                        return {
                            x: this.scrollElem[0].scrollLeft,
                            y: this.scrollElem[0].scrollTop
                        };
                    },
                    _getMousePosition: function (e, delta, deltaX, deltaY) {

                        e.preventDefault();

                        if (!delta) {
                            var page = this._pageXY.apply(this, arguments);
                            this.mx = this.__tmp__._scrollsX ? Math.max(0, Math.min(this.__tmp__._cdd.x, page.X - this.containerOffset.left)) : this.mx;
                            this.my = this.__tmp__._scrollsY ? Math.max(0, Math.min(this.__tmp__._cdd.y, page.Y - this.containerOffset.top)) : this.my;
                        } else {

                            //deltaX = deltaX !== void 0 ? -deltaX : delta;
                            //deltaY = deltaY !== void 0 ? deltaY : delta;
                            deltaX = deltaX !== undefined ? - deltaX: delta;
                            deltaY = deltaY !== undefined ? deltaY: delta;
                            // try to normalize delta (in case of magic mouse )
                            deltaX = Math.min(5, Math.max(deltaX, - 5));
                            deltaY = Math.min(5, Math.max(deltaY, - 5));

                            // TODO: revisit mousewheel normalisation
                            this.__tmp__._deltaX = deltaX;
                            this.__tmp__._deltaY = deltaY;
                            //				this.__tmp__._deltaX = null;
                            //				this.__tmp__._deltaY = null;
                            if (deltaX === 0 && deltaY === 0) {
                                this.scrollStop();
                            }

                        }
                    },
                    _getWheelDelta: function () {
                        var mH = this.scrollElem.innerHeight(),
                            mW = this.scrollElem.innerWidth();
                        this.mx -= this.mx <= mW ? this.__tmp__._deltaX * (this.options.mouseWheelVelocity) : 0;
                        this.my -= this.my <= mH ? this.__tmp__._deltaY * (this.options.mouseWheelVelocity) : 0;
                        this.mx = Math.min(Math.max(0, this.mx), mW);
                        this.my = Math.min(Math.max(0, this.my), mH);
                        this.__tmp__._deltaX = null;
                        this.__tmp__._deltaY = null;
                    },
                    _getDragScrollPosition: function () {
                        var tempX, tempY, sm = this.options.smoothness;

                        this.__tmp__._diff_x = this.__tmp__._diff_x > 0 ? this.__tmp__._diff_x++ - (this.__tmp__._diff_x++ / sm) :
                        this.__tmp__._diff_x-- - (this.__tmp__._diff_x-- /
                        sm);
                        this.__tmp__._diff_y = this.__tmp__._diff_y > 0 ? this.__tmp__._diff_y++ - (this.__tmp__._diff_y++ / sm) :
                        this.__tmp__._diff_y-- - (this.__tmp__._diff_y-- /
                        sm);

                        tempX = Math.round(Math.max(Math.min(this.scrollElem[0].scrollLeft + this.__tmp__._diff_x, this.scrollElem[0].scrollWidth), 0));
                        tempY = Math.round(Math.max(Math.min(this.scrollElem[0].scrollTop + this.__tmp__._diff_y, this.scrollElem[0].scrollHeight), 0));

                        this.__tmp__._x = tempX;
                        this.__tmp__._y = tempY;
                        return [this.__tmp__._x, this.__tmp__._y];
                    },
                    _hasScrolledSince: function () {
                        var sl = this.scrollElem[0].scrollLeft,
                            st = this.scrollElem[0].scrollTop;
                        return {
                            verify: this.__tmp__._temp_x !== sl || this.__tmp__._temp_y !== st,
                            scrollLeft: sl,
                            scrollTop: st
                        };
                    },
                    _getScrollPosition: function (posL, posT) {
                        var tempX, tempY;
                        tempX = posL * this.barIndex.X[0];
                        tempY = posT * this.barIndex.Y[0];

                        this.__tmp__._x += (tempX - this.__tmp__._x) / this.options.smoothness;
                        this.__tmp__._y += (tempY - this.__tmp__._y) / this.options.smoothness;

                        return [this.__tmp__._x, this.__tmp__._y];
                    },
                    _getDiff: function () {
                        var t = this.scrollElem[0].scrollTop,
                            l = this.scrollElem[0].scrollLeft;

                        this.__tmp__._diff_x = l - this.__tmp__._temp_x;
                        this.__tmp__._diff_y = t - this.__tmp__._temp_y;
                        this.__tmp__._temp_x = l;
                        this.__tmp__._temp_y = t;

                    },

                    setScrollbar: function () {
                        this.scrollBar[0].css({
                            left: Math.abs(Math.ceil(this.scrollElem[0].scrollLeft / this.barIndex.X[0]))
                        });
                        this.scrollBar[1].css({
                            top: Math.abs(Math.ceil(this.scrollElem[0].scrollTop / this.barIndex.Y[0]))
                        });
                    },

                    scroll: function (l, t) {
                        var sl = this.scrollElem[0].scrollLeft,
                            st = this.scrollElem[0].scrollTop;
                        l = this.__tmp__._scrollsX ? Math.round(l) : sl;
                        t = this.__tmp__._scrollsY ? Math.round(t) : st;
                        this.scrollElem.scrollLeft(l).scrollTop(t);
                    },
                    /**
                     * SCROLL START
                     * ====================================================================================
                     */
                    scrollStart: function (e, delta) {
                        this.stopScroll();
                        var target = e.target,
                            targetX = target === this.scrollBar[0][0],
                            targetY = target === this.scrollBar[1][0],
                            targetCX = target === this.scrollBarContainer[0][0],
                            targetCY = target === this.scrollBarContainer[1][0];

                        e.preventDefault();

                        this.scrollElem.unbind(this.events.SCROLL);

                        this.__tmp__._scrollsX = targetX || targetCX;
                        this.__tmp__._scrollsY = targetY || targetCY;

                        this._getMousePosition.apply(this, arguments);

                        if (delta) {

                            this.__tmp__._scrollsX = true;
                            this.__tmp__._scrollsY = true;
                            this.__tmp__._mode = 'wheel';
                            this.__tmp__._start.x = 0;
                            this.__tmp__._start.y = 0;
                            this._checkDragMXYPos();
                            this.initMouseWheel();
                        } else {

                            sc_listener.bind(this.events.M_MOVE, $.proxy(this._getMousePosition, this));
                            sc_listener.bind(this.events.M_UP, $.proxy(this.scrollStop, this));

                            this.__tmp__._start.x = targetX ? this.mx - this.scrollBar[0].offset().left + this.scrollBarContainer[0].offset().left: targetCX ? Math.round(this.scrollBar[0].outerWidth() / 2) : 0;
                            this.__tmp__._start.y = targetY ? this.my - this.scrollBar[1].offset().top + this.scrollBarContainer[1].offset().top: targetCY ? Math.round(this.scrollBar[1].outerHeight() / 2) : 0;
                            this.__tmp__._mode = 'scrollbar';
                        }

                        this.startTimer('scrollBPos');
                        this.elem.trigger(this.events.S_START);
                    },

                    scrollBPos: function () {
                        var t, l, pos;

                        this._getDiff();
                        if (this.__tmp__._mode === 'wheel') {
                            this._getWheelDelta();
                        }
                        l = Math.min(Math.max(0, this.mx - this.__tmp__._start.x), this.__tmp__._cdd.x - this.barIndex.X[1]);
                        t = Math.min(Math.max(0, this.my - this.__tmp__._start.y), this.__tmp__._cdd.y - this.barIndex.Y[1]);

                        pos = this._getScrollPosition(l, t);

                        this.__tmp__._scrollsX && this.scrollBar[0].css({
                            left: l
                        });
                        this.__tmp__._scrollsY && this.scrollBar[1].css({
                            top: t
                        });

                        this.scroll(pos[0], pos[1]);
                        this.startTimer('scrollBPos');

                        if (this.__tmp__._mode === 'wheel' && this.__tmp__._scrolls && ! this._hasScrolledSince().verify) {
                            this.scrollStop();
                        }

                        if (!this.__tmp__._scrolls) {
                            this.__tmp__._scrolls = true;
                        }

                        this.__tmp__.mx = this.mx;
                        this.__tmp__.my = this.my;
                    },

                    scrollStop: function (e) {
                        var hasScrolled = this._hasScrolledSince();

                        sc_listener.unbind(this.events.M_MOVE);
                        sc_listener.unbind(this.events.M_UP);

                        if (hasScrolled.verify) {
                            this.startTimer('scrollStop');
                        } else {
                            this.stopScroll();
                            this._clearScrollStatus(false);
                            this.initMouseWheel('rebind');
                            this.elem.trigger(this.events.S_STOP);
                            this.__tmp__._mx = null;
                            this.__tmp__._my = null;
                            this.__tmp__._start.x = 0;
                            this.__tmp__._start.y = 0;
                        }
                        this.__tmp__._temp_x = hasScrolled.scrollLeft;
                        this.__tmp__._temp_y = hasScrolled.scrollTop;
                    },

                    /**
                     * DRAGSCROLL START
                     * ====================================================================================
                     */

                    dragScrollStart: function (e) {
                        this.stopScroll();
                        e.preventDefault();
                        this._clearScrollStatus(true);
                        this._getMousePosition.apply(this, arguments);

                        this.__tmp__._start.x = this.mx + this.scrollElem[0].scrollLeft;
                        this.__tmp__._start.y = this.my + this.scrollElem[0].scrollTop;

                        // start to record the mouse distance
                        sc_listener.bind(this.events.M_MOVE, $.proxy(this._getMousePosition, this));
                        sc_listener.bind(this.events.M_UP, $.proxy(this._initDragScrollStop, this));

                        this.scrollElem.bind(this.events.SCROLL, $.proxy(this.setScrollbar, this));
                        this.startTimer('dragScrollMove');
                        this.elem.trigger(this.events.S_START);
                    },
                    _checkDragMXYPos: function () {
                        var pos = this._getScrollOffset();
                        this.mx = Math.round((pos.x) / this.barIndex.X[0]);
                        this.my = Math.round((pos.y) / this.barIndex.Y[0]);
                    },
                    dragScrollMove: function () {
                        //this._checkDragMXYPos();
                        this.stop = false;
                        var sl = Math.min(Math.max(this.__tmp__._start.x - this.mx, 0), this.scrollElem[0].scrollWidth),
                            st = Math.min(Math.max(this.__tmp__._start.y - this.my, 0), this.scrollElem[0].scrollHeight),
                            scrolled = this._getScrollOffset();
                        this._getDiff();
                        this.scroll(sl, st);

                        this.__tmp__.temp_x = scrolled.x;
                        this.__tmp__.temp_y = scrolled.y;

                        this.startTimer('dragScrollMove');
                    },
                    _initDragScrollStop: function () {
                        sc_listener.unbind(this.events.M_MOVE);
                        sc_listener.unbind(this.events.M_UP);
                        this.elem.removeClass('scrolls');
                        this.stopScroll();
                        this.dragScrollStop();
                    },
                    dragScrollStop: function () {
                        var hasScrolled = this._hasScrolledSince(),
                            pos;

                        if (hasScrolled.verify) {
                            pos = this._getDragScrollPosition();
                            this.scroll(pos[0], pos[1]);
                            this.startTimer('dragScrollStop');
                            this.__tmp__._temp_x = hasScrolled.scrollLeft;
                            this.__tmp__._temp_y = hasScrolled.scrollTop;
                        } else {

                            this.stopScroll();
                            this.scrollElem.unbind(this.events.SCROLL);
                            this._clearScrollStatus(false);
                            this.elem.trigger(this.events.S_STOP);
                        }
                    },
                    _clearScrollStatus: function () {
                        var args = arguments,
                            l = args.length,
                            a = args[0],
                            b = args[1],
                            c = args[2];
                        if (l === 1) {
                            b = a;
                            c = a;
                        }
                        if (l === 2) {
                            c = b;
                        }
                        this.__tmp__._scrolls = a;
                        this.__tmp__._scrollsX = b;
                        this.__tmp__._scrollsY = c;
                    },
                    hideBars: function () {
                        if (this.__tmp__._scrolls) {
                            return this;
                        }
                        this.scrollBarContainer.each(function () {
                            this.stop().delay(100).fadeTo(250, 0);
                        });
                        return this;
                    },
                    showBars: function () {

                        this.scrollBarContainer.each(function () {
                            if (parseInt(this.css('opacity'), 10) < 1) {
                                this.css({
                                    opacity: 0,
                                    display: 'block'
                                });
                                this.stop().delay(100).fadeTo(250, 1);
                            }
                        });
                        return this;
                    },
                    startTimer: function (fn) {
                        var that = this;
                        this.timer = global.setTimeout(function () {
                                that[fn]();
                            },
                            15);
                    },
                    stopScroll: function () {
                        global.clearTimeout(this.timer);
                        this.timer = void 0;
                    },

                    teardown: function (e) {
                        var i = 2;
                        this.elem.removeClass('scrolls');
                        this._unbind();
                        this.elem.unbind('destroyed');
                        while (i--) {
                            this.scrollBarContainer[i].empty().remove();
                        }
                        $.removeData(this.name);
                    }
                });

                $.fn.dragscroll = function (options) {
                    var defaults = {
                            scrollClassName: '',
                            scrollBars: true,
                            smoothness: 15,
                            mouseWheelVelocity: 2,
                            autoFadeBars: true,
                            onScrollStart: function () {},
                            onScrollEnd: function () {},
                            ignoreMouseWheel: false
                        },
                        o = $.extend({},
                            defaults, options),
                        elem = this;
                    return this.each(function () {
                        $(this).data(DragScroll.prototype.name, new DragScroll(elem, o));
                    });
                };
            } (this.jQuery, this));


            $('.dragscroll-holder').dragscroll({
                scrollBars : true,
                autoFadeBars : true,
                smoothness : 15,
                mouseWheelVelocity : 2,
                ignoreMouseWheel: true
            });
        }

        //---on document ready, all functions & conditions will be triggered below---------//

        $(function () {

            clickFunctions();
            alignGrid();
            mouseScroll();
            fileUploader();
            detectWinWidth();
            cutNewsText();
          //  infiniteScrollSearch();

            rangeYear();
            rangePrice();
            rangeMiles();
            tabsSystem();
            loadInstance();
            customScroll();
            alerts();
            sortDivtable();
            previewUpload();
            customBuyerScroll();
            additionalCustomScroll();
            if($('.content-blocks-holder').length){
                autosize($('.content-blocks-holder textarea'));
            }

            autoHeightAuctionTextarea();
           // auctionDetailTopPanel1Col();
          //  auctionDetailTopPanel2Col();

            detectBrowser();
            auctionLayoutFix();

            infiniteScrollAuctionSeller();

            dragTables();


            window.addEventListener("orientationchange", function() {
                if($('.top-panel-auction').length){
                    var openerHeight =  $('.top-panel-auction').outerHeight();
                    $('.top-panel-auction .buttons.active').css('top', openerHeight);



                    $('.sec-holder-inner .toggle-block').each(function(){
                        if(!$(this).hasClass('expanded')){
                            $(this).find('.opener').trigger('click');
                        }
                    });

                    auctionLayoutFix();


                }


            });

        $('#color-selectize').selectize({
                valueField: 'url',
                labelField: 'name',
                searchField: 'url',
                create: false,
                render: {
                    item: function(item, escape) {
                        return'<div>' +

                            '<span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' +item.url + '"></i>' +'</span>' +
                            '<span class="by">' + item.url +' ('+ item.name + ')' + '</span>' +

                            '</div>';
                    },
                    option: function(item, escape) {
                        console.log(item);
                        return '<div>' +

                            '<span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' +item.url + '"></i>' +'</span>' +
                            '<span class="by">' + item.url +' ('+ item.name + ')' + '</span>' +

                            '</div>';
                    }
                }

            });

            $('#color-selectize-2').selectize({
                valueField: 'url',
                labelField: 'name',
                searchField: 'url',
                create: false,
                render: {
                    item: function(item, escape) {
                        return'<div>' +

                            '<span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' +item.url + '"></i>' +'</span>' +
                            '<span class="by">' + item.url +' '+ item.name + '' + '</span>' +

                            '</div>';
                    },
                    option: function(item, escape) {
                        console.log(item);
                        return '<div>' +

                            '<span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' +item.url + '"></i>' +'</span>' +
                            '<span class="by">' + item.url +' '+ item.name + '' + '</span>' +

                            '</div>';
                    }
                }

            });


            $(window).scroll(function() {
            });

            $(window).resize(function(){
                var wWidth = $(window).width();
                if(wWidth > 736) {
                    $('header .nav').removeAttr('style');
                }
                detectWinWidth();
                cutNewsText();
                customScroll();

                customBuyerScroll();

                auctionLayoutFix();

                if($('.content-blocks-holder').length){
                    autosize($('.content-blocks-holder textarea'));
                }
                autoHeightAuctionTextarea();

               // auctionDetailTopPanel1Col();
               // auctionDetailTopPanel2Col();

                $('.sec-holder-inner .toggle-block').each(function(){
                    if(!$(this).hasClass('expanded')){
                        $(this).find('.opener').trigger('click');
                    }
                })
            });

            $(window).scroll(function() {
                if( $(window).scrollTop() >= 20 ) {
                    $("header").addClass("second");
                } else {
                    $("header").removeClass("second");
                }
            });




            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });
            $('.slider-nav').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                dots: true,
                centerMode: true,
                focusOnSelect: true,
                arrows: false,
                infinite: true,
                adaptiveHeight: true
            });

            $('.slider-car').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                focusOnSelect: true,
                arrows: false,
                infinite: true,
                adaptiveHeight: true
            });

            $('#next-prev-arrow	.prev-slide').click(function () {
                $(".slider-car").slick('slickPrev');
            });

            $('#next-prev-arrow	.next-slide').click(function () {
                $(".slider-car").slick('slickNext');
            });


            $('select').selectize();

            pageAnimation();

            timer();


            if($('.module-tab-1').length){
                tabsPreSet();
                tabsSystem();
            }

            //Add Modernizr test
            Modernizr.addTest('isios', function() {
                return navigator.userAgent.match(/(iPad|iPhone|iPod)/g);
            });

            //usage
            if (Modernizr.isios) {
                //this adds ios class to body
                Modernizr.prefixed('ios');
                $('body').addClass('ios');

            } else {
                //this adds notios class to body
                Modernizr.prefixed('notios');
                $('body').addClass('notios');



                if (navigator.userAgent.indexOf('Mac OS X') != -1) {

                    $('body').addClass('mac');
                }
            }


        });

    }

};
