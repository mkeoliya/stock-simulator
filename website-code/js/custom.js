(function($) {
	
    "use strict";

    $(window).on("load", function() {
		
		/* ----------------------------------------------------------- */
		/*  BITCOIN PRELOADER
		/* ----------------------------------------------------------- */
		
        if ($("#preloader")[0]) {
            $("#preloader").delay(1000).fadeTo(800, 0, function() {
                $(this).remove();
            });
        }
		
    });

    $(document).ready(function() {
		
		/* ----------------------------------------------------------- */
		/*  REMOVE # FROM URL
		/* ----------------------------------------------------------- */
		
		$("a[href='#']").on("click", (function(e) {
			e.preventDefault();
		}));
		
		/* ----------------------------------------------------------- */
		/*  FIXED HEADER ON SCROLL
		/* ----------------------------------------------------------- */
		
		var navsite = $("#site-navigation");
		if (navsite.length) {
			var offset = $("#site-navigation").offset().top;
		}
        $(document).scroll(function() {
            var scrollTop = $(document).scrollTop();
            if (scrollTop > offset) {
                $("#site-navigation").addClass("fixed");

            } else {
                $("#site-navigation").removeClass("fixed");
            }
        });
		
		/* ----------------------------------------------------------- */
		/*  ADD HEIGHT TO NAVBAR IN MOBILE DEVICES
		/* ----------------------------------------------------------- */
		
		$(".navbar-collapse").css({ maxHeight: $(window).height() - $(".navbar-header").height() + "px" });
		
		/* ----------------------------------------------------------- */
		/*  BOOTSTRAP CAROUSEL
		/* ----------------------------------------------------------- */
		
		$("#main-slide").carousel({
			pause: true,
			interval: 100000,
		});
		
		/* ----------------------------------------------------------- */
		/*  BACK TO TOP
		/* ----------------------------------------------------------- */
		
        $(window).scroll(function() {
            if ($(this).scrollTop() > 800) {
                $("#back-to-top").addClass("show-back-to-top");
            } else {
                $("#back-to-top").removeClass("show-back-to-top");
            }
        });
        $("#back-to-top").on("click", function() {
            $("html, body").animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
		
		

	});
		
		/* ----------------------------------------------------------- */
		
        

})(jQuery);