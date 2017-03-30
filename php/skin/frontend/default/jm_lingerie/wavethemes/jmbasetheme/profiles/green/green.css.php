<?php

 $mageFilename = "../../../../../../../../app/Mage.php";
 require_once $mageFilename; 
 umask(0);
 Mage::app();
 $baseconfig = Mage::helper("jmbasetheme")->getactiveprofile();
 header("Content-type: text/css; charset: UTF-8");
?>


/* Base settings */
body#bd {
   background-color: <?php echo $baseconfig["bgolor"]; ?>;
   background-image:url("images/<?php echo $baseconfig["bgimage"]; ?>");
}


#ja-header {
   background-color: <?php echo $baseconfig["headerolor"]?> !important;
   background-image:url("images/<?php echo $baseconfig["headerimage"] ?>")!important;}


#ja-footer {
   background-color: <?php echo $baseconfig["footerolor"]?>!important;
   background-image:url("images/<?php echo $baseconfig["footerimage"]?>")!important;
}


#ja-mycart .btn-toggle strong a,
#ja-mycart .amount a,
#ja-mycart .mini-products-list li .product-details .price,
#ja-mycart .summary .subtotal .price,
#ja-mycartleft .mini-products-list li .product-details .price,
#ja-mycartleft .summary .subtotal .price,
#ja-botsl .block-magazine a,
#ja-botsl .col-4 a,
label.required em,
p.required,
.account-inner-page a:hover,
.inner-page-button-link .back-link a:focus,
.regular-price,
.regular-price .price,
.special-price .price,
.product-essential .product-shop .add-to-links li a:hover,
.side-col .block-cart .price,
.block-cart .amount a,
.block-cart .subtotal .price,
.block-compare button + a,
.block-layered-nav .currently ol li .value,
.block-reorder .actions  a:hover,
.products-list .product-shop a.link-learn,
.products-list .product-shop .add-to-links li a:hover,
.cart .crosssell .product-details .add-to-links li a:hover,
#checkout-step-login .buttons-set .button + a,
.please-wait,
.account-form .foget-password,
.account-form  p.required,
.account-buttons-set  p.required,
.block-account li.current,
.my-account  a:hover,
.page-sitemap  a:hover,
#ja-mass-bottom  .block:hover a,
#ja-mass-bottom  .block  a:hover,
.side-col .jm-product-list a.viewall,
#jm-error .disc a,

.block-account li a:hover,
.block-account li a:active,
.block-account li a:focus,

.off-canvas #off-canvas-nav .jm-mainnav .level0 li a:hover,
.off-canvas #off-canvas-nav .jm-mainnav .level0 li.active a,
#off-canvas-nav .megamenu.level2 li a:hover,
#off-canvas-nav .megamenu.level2 li.active a,
.jm-megamenu ul.level0 li.mega a.mega:hover,
.jm-megamenu ul.level0 li.mega:hover > a.mega,
.jm-megamenu ul.level1 li.mega a.mega:hover span.menu-title,

.jm-slide-thumb,
.jm-slide-thumbs-handles span,
.jm-slide-thumbs .jm-slide-thumb span,
.jm-slide-thumbs .jm-slide-thumb.active span + span
 {
	color:<?php echo $baseconfig["color"] ?>!important
}


#off-canvas-nav .megamenu.level2 li a:hover,
#off-canvas-nav .megamenu.level2 li.active a {
	color:<?php echo $baseconfig["color"] ?>!important
}


.input-text:focus, select:focus, textarea:focus,
#ja-mycart .buttons button.button:hover,
#ja-mycartleft .buttons button.button:hover,
button.button:hover,
button.button:focus,
button:hover,
button:focus,
.product-essential .product-shop button,
.product-img-box .more-views li a:hover img,
.opc .allow .number,
.opc .active .number,
.account-form .input-text:focus

 {
	border-color:<?php echo $baseconfig["color"]; ?>;
}

#ja-mycart .amount a {
	border-bottom-color:<?php echo $baseconfig["color"]; ?>;
}

ul.ja-tab-navigator li.active {
	border-top-color:<?php echo $baseconfig["color"]; ?>;
}

#ja-mycart .buttons button.button:hover,
#ja-mycartleft .btn-toggle,
#ja-mycartleft .buttons button.button:hover,
button.button:hover,
button.button:focus,
button:hover,
button:focus,
.opc .allow .number,
.opc .active .number,
.checkout-progress li.active,
.account-form button:focus,
.block-account .block-title,
.jm-thumbprogessbar .progressrunning,

.box-account ol .number,

#ja-header .ground-menu1:before,
.jm-megamenu ul.level0 li.active a.mega:before

{
	background-color:<?php echo $baseconfig["color"]; ?> ;
}

.products-list .product-shop .desc-info .button-set button:hover,
.product-essential .product-shop button,
.cart .crosssell .product-details .button:hover  {
	background-color:<?php echo $baseconfig["color"]; ?> ;
}


.product-img-box .product-image-zoom {
	width: <?php echo $baseconfig["productlimagewidth"]; ?>px;
	height: <?php echo $baseconfig["productlimageheight"]; ?>px;
}

/* Profile settings */

#ja-mass-top1 {
   background-color: <?php echo $baseconfig["masstop1color"]; ?>;
   background-image:url("images/<?php echo $baseconfig["masstop1image"]; ?>");
}


#ja-mass-bottom {
   background-color: <?php echo $baseconfig["massbottomcolor"]; ?>;
   background-image:url("images/<?php echo $baseconfig["massbottomimage"]; ?>");
}

#ja-botsl {
   background-color: <?php echo $baseconfig["botslcolor"]; ?>;
   background-image:url("images/<?php echo $baseconfig["bostslimage"]; ?>");
}


.jm-slide-buttons span.jm-slide-prev:hover {
	background-image: url("images/<?php echo $baseconfig["buttonpreslideshow"] ?>");
}

.jm-slide-buttons span.jm-slide-next:hover {
	background-image: url("images/<?php echo $baseconfig["buttonnextslideshow"]; ?>");
}

.products-grid li.item button.btn-cart {
	background-image: url("images/<?php echo $baseconfig["buttonaddtocart"]; ?>");
}

.products-grid li.item .jmquickview {
	background-image: url("images/<?php echo $baseconfig["buttonquickview"]?>")!important;
}

.products-grid .add-to-links a.link-wishlist {
	background-image: url("images/<?php echo $baseconfig["buttonwishlist"]?>")!important;
}

.products-grid .add-to-links a.link-compare {
	background-image: url("images/<?php echo $baseconfig["buttoncompare"]?>")!important;
}

ul.list-social li a {
	background-image: url("images/<?php echo $baseconfig["iconsocial"]; ?>");
}

.jm-megamenu ul.level0 li.last a.mega {
	color:<?php echo $baseconfig["megamenulinklast"]; ?>;
}

.jm-product-list-bycat .category-listing h2 { color:#000!important; }

#ja-header .ground-menu1:before {
	background:#111;
    opacity:1;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	-moz-opacity:1;
	-khtml-opacity: 1;
}

.jm-megamenu ul.level0 li.active a.mega:before {
	opacity:1;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	-moz-opacity:1;
	-khtml-opacity: 1;
    z-index:-2;
    top:-1px;
}

#ja-mass-top1 {border-bottom: 1px solid #E5E5E5;}
#ja-mass-bottom {border-top: 1px solid #E5E5E5;}
#ja-mass-bottom .block { background:none}

.jm-megamenu ul.level0 li.mega.active:hover span.menu-title { color:#fff; }