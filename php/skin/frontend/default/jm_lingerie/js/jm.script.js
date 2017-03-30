if (window.jQuery && jQuery.noConflict && (typeof $('body') == 'object')) {
	jQuery.noConflict();
/**
	 * ja tabs plugin
	 */
	jQuery(document).ready(function() {
         jQuery(".jm-slide-desc h3").hover(function(){
            jQuery(this).parents(".jm-slidewrap").addClass("deschover");
         },function(){
            jQuery(this).parents(".jm-slidewrap").removeClass("deschover");

         });
	});

	(function($) { 
				$.fn.jaContentTabs = function (_options){
					return this.each( function() {		
						var container = $( this );
						new $.jaContentTabs().setup( this, container );
					} );
				}
				 $.jaContentTabs = function() { 
					var self = this;
					this.lastTab = null;
					this.nextTab=null;
					this.setup=function( obj, o ){
						var contentTabs = o.children( 'div.ja-tab-content' );
						var nav = o.children( 'ul.ja-tab-navigator' );
						contentTabs.children('div').hide();
						nav.children('li:first').addClass('first').addClass( 'active' );	
						contentTabs.children('div:first').show();
						
						nav.children('li').children('a').click( function() {
							self.lastTab = 	nav.children('li.active').children('a').attr('href');										
							nav.children('li.active').removeClass('active')											
							$(this).parent().addClass('active');
							var currentTab = $(this).attr('href'); 
							self.tabActive( contentTabs, currentTab );		
							return false;
						});	
					};
					this.tabActive=function( contentTabs,  currentTab ){
						if(  this.lastTab != currentTab ){
							contentTabs.children( this.lastTab ).hide();	
						}
			
						contentTabs.children( currentTab ).show();
					};
				};
                var isTouch = 'ontouchstart' in window && !(/hp-tablet/gi).test(navigator.appVersion);

                if(isTouch){

                    $.fn.touchproduct = function(){
                        return this.each(function(){
                        	$(this).find("button.btn-cart,ul.add-to-links,a[rel='quickviewbox']").css("display","none");
                            var itemsel = "li.item",jitems = $(this).find(itemsel),
                            reset = function(){
						      $(this).data('noclick', 0);
					        },
					        onTouch = function(e){
                                e.stopPropagation();
								$(document.body).addClass('hoverable');
		            			var jitem = $(this),
								val = !jitem.data('noclick');
								// reset all
						        jitems.data('noclick', 0);
						        jitem.data('noclick', val);
						        jitems.find("button.btn-cart,ul.add-to-links,a[rel='quickviewbox']").css("display","none");
						        if(val){
									$(this) //reset, sometime the mouseenter does not refire, so we reset to enable click
										.data('rsid', setTimeout($.proxy(reset, this), 500));
								}
					        },
					        onClick = function(e){
                                if($(this).data('noclick')){
								    e.preventDefault();
									$(this).find("button.btn-cart,ul.add-to-links,a[rel='quickviewbox']").css("display","block");
								}else{
                            	   if($(e.target).hasClass("jmquickview")){
                            		jitems.find("button.btn-cart,ul.add-to-links,a[rel='quickviewbox']").css("display","none");
                            	   }
								}   
					        };

					        jitems.on('mouseenter', onTouch).data('noclick', 0);

						    $(this).find('li').on('click', onClick);

                        });

                    }
                }

             $(document).ready(function(){
             	   
                	if(isTouch){
                		$('ul.products-grid').touchproduct();
					} 
	         });
			
			})(jQuery);
}

function switchTool (ckname, val) {
	createCookie(ckname, val, 365);
	window.location.reload();
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

function menuFistLastItem () {
	if ((menu = $('nav')) && (children = menu.childElements()) && (children.length)) {
		children[0].addClassName ('first');
		children[children.length-1].addClassName ('last');
	}
}

document.observe("dom:loaded", function() {   
	menuFistLastItem();

	
   jQuery("#ja-mycart .btn-toggle").removeClass("active");

	if(jQuery("select.product-custom-option").length){
    	jQuery("select.product-custom-option").each(function(index,select){
            dd = jQuery(select).parents("dd");
            dtlabel = dd.prev("dt").children("label");
            em = dtlabel.children("em");em.remove();
         	firstop = jQuery(select).children(":first-child");
    		firstop.html(dtlabel.html());
    	})
    }
	jQuery(".block-content .currently ol").children().last().addClass("last");
	jQuery(".btn-toggle").live("click",function () {
			
			if(jQuery("#jmoverlay").length <= 0){
				jmoverlay = jQuery('<div id="jmoverlay" class="jmoverlay"></div>'); 
				jmoverlay.appendTo('#ja-header .main:first');
				jmoverlay.bind("click",function(){
					jQuery("#ja-mainnav-inner").css({"left":"0"});							
					jQuery(".btn-toggle").removeClass("active");
					jQuery(".btn-toggle").siblings(".inner-toggle").removeClass("inneractive");	
					this.remove();
				})
			}	
			
			jQuery(".btn-toggle").not(this).siblings(".inner-toggle").removeClass("inneractive");													  	        
			jQuery(this).siblings(".inner-toggle").toggleClass("inneractive");
			jQuery(".btn-toggle").not(this).removeClass("active");													  	            
			jQuery(this).toggleClass("active");
			if(!jQuery(this).hasClass("active") && jQuery(".jmoverlay").length > 0){
				jQuery(".jmoverlay").remove();
			} 
			if(window.sidebarIScroll){
		       window.sidebarIScroll.refresh();
	        }
			if(jQuery(this).parent("#ja-mycartleft")){
			    jQuery(this).parent("#ja-mycartleft").find("div.buttons").hide();
				if(window.cartsidebarIScrol !== undefined && window.cartsidebarIScrol !== null){
					 window.cartsidebarIScrol.destroy();
			         window.cartsidebarIScrol  = null;
					 
				}
				 if(jQuery("#jmajaxcartscrollleft").length){
				   window.cartsidebarIScrol = new iScroll("jmajaxcartscrollleft",{vScrollbar: true, useTransform: true,hScrollbar: false});
				 }
				 jQuery(this).parent("#ja-mycartleft").find("div.buttons").show(); 	   
				
            }
            if(jQuery(this).parent("#ja-mycart")){
			    jQuery(this).parent("#ja-mycart").find("div.buttons").hide();
				if(window.topcartsidebarIScrol !== undefined && window.topcartsidebarIScrol !== null){
					 window.topcartsidebarIScrol.destroy();
			         window.topcartsidebarIScrol  = null;
					 
				}
				if(jQuery("#jmajaxcartscroll").length){
				   window.topcartsidebarIScrol = new iScroll("jmajaxcartscroll",{vScrollbar: true, useTransform: true,hScrollbar: false});
				 }
				jQuery(this).parent("#ja-mycart").find("div.buttons").show(); 	   
				
            }					
			
		});



     wwidth = jQuery(window).width();
		//iscroll section
	  if(jQuery(".megamenu") !== undefined){
		 jQuery("li.haschild").live("mouseover",function(){
           if(wwidth < 985) { return  false; }														 
		   if(jQuery(this).children(".childcontent").length){
			   childcontent = jQuery(this).find(".childcontent-inner-wrap").first();
			   childcontentheight = (childcontent.find(".childcontent-inner").height() < jQuery(window).height())?childcontent.find(".childcontent-inner").height():jQuery(window).height()-100;	
			   childcontent.height(childcontentheight);
			   childcontentid = childcontent.attr("id");
			  	   
		   } 												  
		 });   
	  }
	   
	  jQuery(window).resize (function() {
		   if(window.shopbyIScrol && window.shopbyIScrol !== undefined)	{
			     window.shopbyIScrol.destroy();
			     window.shopbyIScrol  = null;
			}					  
		   wwidth = jQuery(window).width();	
		   if(wwidth <= 985 && window.sidebarIScroll == undefined){
			  window.sidebarIScroll = new iScroll('ja-mainnav-inner',{vScrollbar: true, useTransform: true,hScrollbar: false});  
		   }else if(window.sidebarIScroll !== undefined && window.sidebarIScroll !== null){
			  jQuery('#jm-megamenu').removeAttr('style');
			  jQuery("#ja-mainnav .btn-toggle").removeClass("active");
			  window.sidebarIScroll.destroy();
			  window.sidebarIScroll = null;
		   }						 
	  });

      /*
	  jQuery(window).scroll(function(){
	  	
           showrightcartheight = jQuery("#ja-header").height();
           if(jQuery("#ja-mass-top").length){
           	 showrightcartheight += jQuery("#ja-mass-top").height();
           }
           if(parseInt(jQuery(window).scrollTop()) >= showrightcartheight){
           	   if(!jQuery("#ja-mycartleft").length) {
           	     jQuery('<div id="ja-mycartleft" />').appendTo(jQuery("#ja-wrapper"));
           	     jQuery("#ja-mycartleft").html(jQuery("#ja-mycart").html());
				 jQuery("#ja-mycartleft #jmajaxcartscroll").attr("id","jmajaxcartscrollleft");
                 mycartobj = jQuery("#ja-mycart").data("mycartobj");
                 mycartobj.bindcartEvents();

                 //update the right cart after topcart is updated
                 jQuery("#ja-mycart").bind("afterupdatecart",function(){
                     jQuery("#ja-mycartleft").html(jQuery("#ja-mycart").html());
					 jQuery("#ja-mycartleft #jmajaxcartscroll").attr("id","jmajaxcartscrollleft");
					 jQuery(".jmoverlay").remove();
                 }); 
                
               }else{
               	 jQuery("#ja-mycartleft").show();
               }
               jQuery("#ja-mycart .btn-toggle").removeClass("active");
           }else{
           	   if(jQuery("#ja-mycartleft").length){
           	   	  if(jQuery("#ja-mycartleft .btn-toggle").hasClass("active")){
           	   	  	 jQuery("#ja-mycartleft .btn-toggle").trigger("click"); 
           	   	  }
           	   	  jQuery("#ja-mycartleft").hide();
           	   }
           }  
            

	  });
	*/
	  jQuery("#ja-mainnav .btn-toggle").live("click",function(event){
			  event.stopPropagation();
			  wwidth = jQuery(window).width();
			  mainnavos = jQuery("#ja-mainnav-inner").offset();
			  totalwidth = mainnavos.left + jQuery("#ja-mainnav-inner").width();
			  
              if(totalwidth > wwidth){
				  left =  wwidth-totalwidth-5;
				  jQuery("#ja-mainnav-inner").css({"left":left});
			  }
			  if(jQuery(this).attr("class").indexOf("active") < 0){
				  jQuery("#ja-mainnav-inner").css({"left":0});
			  }
			  if(wwidth > 985) { 
			     if(window.childcontentIScrol)
			     return  false;
			  }
			  updatemenuheight();			  
	  });

      	jQuery("#ja-quickaccess .btn-toggle").click(function(e){
		 		jQuery("#ja-quickaccess").toggleClass("active");
				if(jQuery("#ja-quickaccess").hasClass("active")){
		               
		                if(window.myaccountIScrol !== undefined && window.myaccountIScrol !== null){

					         window.myaccountIScrol.destroy();
					         window.myaccountIScrol  = null;
					    }

					   	 if(jQuery("#myaccountscroll").length){
					   	  setTimeout(function(){
					   	      window.myaccountIScrol = new iScroll("myaccountscroll",{vScrollbar: true, useTransform: true,hScrollbar: false});	
					   	  },100);	
						  
						 }else{
			               
			                quickaccess = jQuery("#ja-quickaccess .inner-toggle").html();
			                myaccount = jQuery('<div calss="inner-togglecontent" />').append(jQuery("#ja-quickaccess .inner-toggle").html());
			                myaccount.css({float:"left",height:"auto"});
			                jQuery("#ja-quickaccess .inner-toggle").html("");
			                myaccountscroll = jQuery('<div id="myaccountscroll" />');
			                myaccount.appendTo(myaccountscroll);
			               
			                windowheight = jQuery(window).height()-jQuery("#ja-header").height();

			                windowheight = windowheight - parseInt(jQuery("#ja-quickaccess .inner-toggle").css("padding-top"));
			                myaccountscroll.appendTo(jQuery("#ja-quickaccess .inner-toggle"));
			                jQuery("#ja-quickaccess .inner-toggle").append(jQuery('<span class="arrow" />'));
			                    setTimeout(function(){
			                    	  if(jQuery("#ja-quickaccess .inner-toggle").height() > windowheight){
			                    	  	myaccountscroll.css("height",windowheight);
			                            window.myaccountIScrol = new iScroll("myaccountscroll",{vScrollbar: true, useTransform: true,hScrollbar: false});
			                             window.myaccountIScrol.refresh();
			                          }

			                    },100);
			               
			    		   }
						    
					   		
				}

	    }); 

	 
});

function updatemenuheight(object){
	 
		  mainavheight = (jQuery("#jm-megamenu ul.megamenu:first").height() < jQuery(window).height())?jQuery("#jm-megamenu ul.megamenu:first").height():jQuery(window).height()-120;
		  jQuery("#ja-mainnav-inner").height(mainavheight);										   
		  if(window.sidebarIScroll !== undefined && window.sidebarIScroll !== null){
			 window.sidebarIScroll.refresh();
		  }else{
			 window.sidebarIScroll = new iScroll('ja-mainnav-inner',{vScrollbar: true, useTransform: true,hScrollbar: true});   
		  }			
	
} 

//Add hover event for li - hack for IE6
function navMouseHover () {
	var lis = $$('#nav li');
	if (lis && lis.length) {
		lis.each (function(li){
			li.onMouseover = toggleMenu (li, 1);
			li.onMouseout = toggleMenu (li, 0);
		});
	}
}

toggleMenu = function (el, over) {
	  var iS = false;
    if (Element.childElements(el) && Element.childElements(el).length > 1) {
	    var uL = Element.childElements(el)[1];
			iS = true;
		}
    if (over) {
        Element.addClassName(el, 'over');
				Element.addClassName (el.down('a'), 'over');
        if(iS){ uL.addClassName('shown-sub')};
    }
    else {
        Element.removeClassName(el, 'over');
				Element.removeClassName (el.down('a'), 'over');
        if(iS){ uL.removeClassName('shown-sub')};
    }
}
