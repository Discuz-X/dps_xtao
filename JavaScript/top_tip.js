(function() {
	var k, i, d, b, a, f = 1000,
		c = "fast",
		e = false;

	function j() {
		if(!k) {
			i = jQuery('<div class="go-top" title="回到顶部" href="javascript:;" style="display:none;"></div>').appendTo("body").click(function() {
				jQuery.scrollToTop(0)
			});
			d = i.css("position") == "fixed";
			h();
			var l = function() {
				if(jQuery(window).scrollTop() > 200) {
					if(e == false) {
						i.fadeIn(c);
						e = true
					}
				} else {
					if(e == true) {
						e = false;
						i.fadeOut(c)
					}
				}
			};
			jQuery(window).resize(g);
			jQuery.windowScroll(l)
		}
	}

	function h() {
		if(d) {
			i.css({
				right: "10px",
				bottom: "10px"
			})
		} else {
			i.css({
				right: "10px",
				"margin-bottom": "10px"
			})
		}
	}

	function g() {
		jQuery.clearTimer(b);
		b = setTimeout(h, f)
	}

	jQuery.extend({
		showGoToTop: j
	})
})();


var scrollMethodArrary = new Array();
var scrollArgsArrary = new Array();
jQuery.extend({
	windowScroll: function(a, b) {
		scrollArgsArrary.push(b);
		scrollMethodArrary.push(a)
	}
});
(function() {
	if(scrollMethodArrary != null) {
		jQuery(window).scroll(function() {
			for(var b = 0; b < scrollMethodArrary.length; b++) {
				var c = scrollMethodArrary[b];
				var a = scrollArgsArrary[b];
				c(a)
			}
		})
	}
})();
(function() {
	var a;
	jQuery.extend({
		scrollToTop: function(b) {
			if(a) {
				return false
			}
			a = true;
			jQuery("html,body").animate({
					scrollTop: b
				},
				800,
				function() {
					a = false
				})
		}
	})
})();

//首页顶部固定
if(!(jQuery.browser.msie && jQuery.browser.version == 6.0)) {
	jQuery.windowScroll(topIndexScroll);
}
function topIndexScroll() {
	if(jQuery(window).scrollTop() > 70) {
		jQuery('#fixHeader').show();
		jQuery('#unlogin_fixHeader').show();
		jQuery('#header').css('visibility', 'hidden');
	}
	else {
		jQuery('#unlogin_fixHeader').hide();
		jQuery('#header').css('visibility', 'visible');
		jQuery('#fixHeader').hide();

	}
}

//返回顶部
jQuery(function() {
	jQuery.showGoToTop();
	jQuery("#header .add").click(function() {
		jQuery.openAddBox()
	});
	jQuery("#fixHeader .add").click(function() {
		jQuery.openAddBox()
	})
});

