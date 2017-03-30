// JavaScript Document
(function($){

   var defaults  = {
   	  btnCart:".btn-cart",
   	  showcartrightaway:false
   } 

   var jmquickview = function(options){
      this.options = $.extend({}, defaults, options);
  	  this.initialize(); 
   }


   jmquickview.prototype = {
   	   bindcartEvents:function(){
               if(this.options.showcartrightaway){
                             
	             	        //bind cart's buttons on the popup
							var urlcart = false;
							$(".btn-remove2").bind("click",function(e){
										e.preventDefault();
										href = $(this).attr("href");
										newhref = href.replace("checkout/cart","quickview/index");
										newtag = $("</a>");
										newtag.attr("href",newhref)
										$.colorbox({href:newhref,onComplete:$.proxy(function(){
											 this.addComplete();  
										},this)});
										
							});
						

							$(".btn-update,.btn-empty").bind("click",function(e){
								   e.preventDefault();
								   if(!urlcart) {
									   urlcart = $('.jmquickview_cart_form').attr('action');
								   }
								   urlcart = urlcart.replace("checkout/cart","quickview/index");
								   var datacart = $('.jmquickview_cart_form').serialize();
								   datacart = datacart + "&update_cart_action=" + $(this).attr("value");
								   urlcart = urlcart+"?"+datacart
								   $.colorbox({href:urlcart,onComplete:$.proxy(function(){
											 this.addComplete();  
								   },this)});
							});
                }else{
                            $("#cart-sidebar .btn-remove").unbind("click");
							//bind cart's buttons on the header
                            $("#cart-sidebar .btn-remove").bind("click",$.proxy(function(e){
				            	    e.stopPropagation();
									e.preventDefault();
								    if(confirm('Are you sure you would like to remove this item from the shopping cart?')){
						    	    	$(".jmajaxcartLoading").show();
					                  	urldelete = $(e.target).attr("href");
						    	    	urldelete = urldelete.replace("checkout/cart/delete","quickview/index/deletecartsidebar");
										this.toggleloading();
						    	    	$.ajax({
						                    url:urldelete,
						                    dataType:'json',
						                    success:$.proxy(function(data) {
						                    	//$(".jmajaxcartLoading").hide();
						                        if(data.status == 'ERROR'){
												    this.toggleloading();
													alert(data.message);
												}else{
													this.addComplete();
												}
						                    },this)

						    	    	});

						    	    }
						    },this));

                            $(".jmquickview_cart_form button.btn-update,.jmquickview_cart_form button.btn-empty").unbind("click");
	                        $(".jmquickview_cart_form button.btn-update,.jmquickview_cart_form button.btn-empty").bind("click",$.proxy(function(e){
                               
						       e.preventDefault();
						       //loading();
						       form = $(e.target).parents(".jmquickview_cart_form");
						       urlcart = form.attr('action');
							   urlcart = urlcart.replace("checkout/cart","quickview/index");
							   var datacart = form.serialize();
							   datacart = datacart + "&update_cart_action=" + $(e.target).attr("value");
							   urlcart = urlcart+"?"+datacart
							   this.toggleloading();
							   $.post(urlcart,$.proxy(function(data){
						       	    this.addComplete();
							   },this));
							  

						    },this));

                }


   	   },
       addComplete:function(){

               $.post(baseurl+"quickview/links/index",$.proxy(function(data){
								  if($(".top-link-cart")) $(".top-link-cart").html(data);
								  $.post(baseurl+"quickview/links/sum",$.proxy(function(totalcart){
									if($(".totalcart")) $(".totalcart").html(totalcart);
								  },this));
								  $.post(baseurl+"quickview/links/updatecart",$.proxy(function(datacart){
									if($("#ja-mycart .inner-toggle")) {

									    $("#ja-mycart .inner-toggle").html(datacart);
										$("#ja-mycart .btn-toggle").removeClass("active");
									    $("#ja-mycart").trigger("afterupdatecart");
									     this.toggleloading();
									     this.bindcartEvents();
									 }   
								  },this));
			    },this));      
                      
       },
       ajaxaddtocart:function(url){
       	    $.ajax({
			            url:url,
			            dataType:'json',
			            success:$.proxy(function(data) {
			            	
			                if(data.status == 'ERROR'){
								alert(data.message);
							}else{
					                this.addComplete();
			        		}
			            },this)

		    });
       },
       deletesidebarItem:function(){
              //remove item from cart sidebar
				$("#cart-sidebar .btn-remove").attr("onclick","");
			    $("#cart-sidebar .btn-remove").bind("click",function(e){
			    	    e.preventDefault();
			    	    if(confirm('Are you sure you would like to remove this item from the shopping cart?')){
		                    loading	 = $("<div/>",{
		                    	"id":"cboxLoadingGraphic",
		                    	"width":"100%",
		                    	"position":"absolute",
		                    	"width":"32px",
						        "height":"32px"
		                    });

		                    $(this).after(loading);   	    	
			    	    	urldelete = $(this).attr("href");
			    	    	urldelete = urldelete.replace("checkout/cart/delete","quickview/index/deletecartsidebar");
			    	    	$.ajax({
			                    url:urldelete,
			                    dataType:'json',
			                    success:function(data) {
			                        if(data.status == 'ERROR'){
										alert(data.message);
									}else{
										$.post(baseurl+"quickview/links/index",function(data){
											  if($(".top-link-cart")) $(".top-link-cart").html(data);
											  $.post(baseurl+"quickview/links/total",function(totalcart){
							                       if($(".totalcart")) $(".totalcart").html(totalcart);
						                      })
											  $.post(baseurl+"quickview/links/updatecart",function(datacart){
												if($(".block-cart")) {
												    $(".block-cart").html(datacart);
												    deletesidebarItem(); 
												}   
											  })
					                    });
			                            
									}
			                    }

			    	    	});

			    	    }
			    	    
			    });
       },
       toggleloading:function(){
           if($(".jmajaxloading").css("display") == "none"){
           	  $(".jmajaxloading").show();
           }else{
           	  $(".jmajaxloading").hide();
           }
       },
   	   initialize:function(){
             
            $("#ja-mycart").data("mycartobj",this);
		    this.bindcartEvents();
		    options = this.options;
            $(options.btnCart).each($.proxy(function(index,bcart){
			    productlink = $(bcart).siblings("ul.add-to-links").find("li a.link-compare").attr("href");
			    if((productlink != null) && (productlink != undefined) && (product = productlink.match(/product\/\d+/)) ){
				      productid = product[0].replace("product/","");
					  quickviewtag = $("<a/>",{
							"rel":"quickviewbox",
							"href":"quickview/index",
							"id":"quickviewbox"+productid,
							"title":"Product quick view"
					  });
					  quickviewtag.attr("href",baseurl+"quickview/index?id="+productid);
					  quickviewtag.append(' <button class="form-button jmquickview"><span>quickview</span></button>');
					  $(bcart).after(quickviewtag);
				      quickviewtag.colorbox({current: "Product {current} of {total}",onComplete:$.proxy(function(){
				             
				              // add product to wishlist 
							  $("a.link-wishlist").bind("click",function(e){
								    e.preventDefault();
									if(!productAddToCartForm.submitLight(this,$(this).attr("href"))) return false;
									ulrwishlist = $(this).attr("href");
									ulrwishlist = ulrwishlist.replace("wishlist/index/add","quickview/wishlist/addwishlist");
									var data = $('.product_addtocart_form').serialize();
									$("#cboxLoadingGraphic").show();
									$.ajax( {
										url : ulrwishlist,
										dataType : 'json',
										type : 'post',
										data : data,
										success : function(data) {
											$("#cboxLoadingGraphic").hide();
											if(data.status == 'ERROR'){
												alert(data.message);
											}else{
												alert(data.message);
												if($('.block-wishlist').length){
													$('.block-wishlist').replaceWith(data.sidebar);
												}else{
													if($('.col-right').length){
														$('.col-right').prepend(data.sidebar);
													}
												}
												if($('.header .links').length){
													$('.header .links').replaceWith(data.toplink);
												}
											}
										}
									});
							  });
							  
							  // add product to compare 
							  $("a.link-compare").bind("click",function(e){
								    e.preventDefault();
									urlcompare = $(this).attr("href");
									urlcompare = urlcompare.replace("catalog/product_compare/add","quickview/index/compare");
									$("#cboxLoadingGraphic").show();
									$.ajax({
										 url:urlcompare,
										 dataType:'json',
										 success : function(data) {
											    $("#cboxLoadingGraphic").hide();
												if(data.status == 'ERROR'){
													alert(data.message);
												}else{
													alert(data.message);
													if($('.block-compare').length){
														$('.block-compare').replaceWith(data.sidebar);
													}else{
														if($('.col-right').length){
															$('.col-right').prepend(data.sidebar);
														}
													}
												}
										 }
									})
							  });
							  
							   $(".optionsboxadd").bind("click",$.proxy(function(e){
							   	  
			                        e.preventDefault();
			                        urladdcart = $(e.target).parents("a.optionsboxadd").attr("href");
			                        urladdcart =  urladdcart + "?qty=" + $("input.qty").val();
			                         if(this.options.showcartrightaway){
				                         $.colorbox({href:urladdcart,onComplete:$.proxy(function(){
				                         	 this.addComplete();  
								         },this)});
			                         }else{
			                           urladdcart = urladdcart + "&onlyadd=1";	
			                           this.ajaxaddtocart(urladdcart)	  
							           $("#cboxClose").trigger("click");
							           this.toggleloading();
							         }                  

							  },this));

							  $(".optionsbox").colorbox({height:400,onComplete:$.proxy(function(){
								 //$(".optionsboxcart").colorbox();
								   var url =  false;
								   $(".btn-cart").bind("click",$.proxy(function(event){
												if(!productAddToCartForm.submit($(this).children("button")[0])) return false;
												if(!url){
												  url = $('.product_addtocart_form_options').attr('action');
												}
												url = url.replace("checkout/cart","quickview/index"); // New Code
												var data = $('.product_addtocart_form_options').serialize();
												data += '&isAjax=1';
												url = url+"?"+data;
												if(this.options.showcartrightaway){
                                                    $(".optionsboxcart").attr("href",url);
													$(".optionsboxcart").colorbox({onComplete:$.proxy(function(){
										               this.addComplete();
													},this)});
													$(".optionsboxcart").trigger("click");
												}else{
													 url += "&onlyadd=1";
													 this.ajaxaddtocart(url)	  
											         $("#cboxClose").trigger("click");
											         this.toggleloading();
												}
												
												
												
												return true;
								  },this));
							  },this)

							});																			 
					   
					   },this)});
				 
		         }
	        },this));								 
   	   }
   }

   $.fn.jmquickview = function(options){
			new jmquickview(options);
		
   };

   
})(jQuery)


jQuery(document).ready(function($) {
    $("#jm-product-list").jmquickview({});
 });  
