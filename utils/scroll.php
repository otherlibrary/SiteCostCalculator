	<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.6.0/build/utilities/utilities.js&2.6.0/build/container/container_core-min.js"></script> 
	<script type="text/javascript" src="../scripts/carousel.js"></script>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.6.0/build/reset-fonts-grids/reset-fonts-grids.css&2.6.0/build/base/base-min.css">
	<link href="../css/carousel.css" rel="stylesheet" type="text/css">
	<link href="../css/yui.css" rel="stylesheet" type="text/css">
<style type="text/css">
.carousel-component { 
	padding:10px 16px 4px 16px;
	margin:0;
}

.carousel-component .carousel-list li { 
	margin:5px;
	width:174px; /* img width is 75 px from flickr + a.border-left (1) + a.border-right(1) + 
	               img.border-left (1) + img.border-right (1)*/
	height:158px; /* image + row of text (87) + border-top (1) + border-bottom(1) + margin-bottom(4) */
	/*	margin-left: auto;*/ /* for testing IE auto issue */
}

.carousel-component .carousel-list li a { 
	display:block;
	border:1px solid #e2edfa;
	outline:none;
}

.carousel-component .carousel-list li a:hover { 
	border: 1px solid #aaaaaa; 
}

.carousel-component .carousel-list li img { 
	border:1px solid #999;
	display:block; 
}
								
.carousel-component .carousel-prev { 
	position:absolute;
	top:70px;
	z-index:3;
	cursor:pointer; 
	left:5px; 
}

.carousel-component .carousel-next { 
	position:absolute;
	top:70px;
	z-index:3;
	cursor:pointer; 
	right:5px; 
}
</style>

<script type="text/javascript">
var handlePrevButtonState = function(type, args) {

	var enabling = args[0];
	var leftImage = args[1];
	if(enabling) {
		leftImage.src = "images/left-enabled.gif";	
	} else {
		leftImage.src = "images/left-disabled.gif";	
	}
	
};
var handleNextButtonState = function(type, args) {

	var enabling = args[0];
	var rightImage = args[1];
	
	if(enabling) {
		rightImage.src = "images/right-enabled.gif";
	} else {
		rightImage.src = "images/right-disabled.gif";
	}
	
};

var carousel; // for ease of debugging; globals generally not a good idea
var pageLoad = function() 
{
	carousel = new YAHOO.extension.Carousel("mycarousel", 
		{
			numVisible:        5,
			animationSpeed:    1,
			scrollInc:         5,
			navMargin:         20,
			prevElement:     "prev-arrow",
			nextElement:     "next-arrow",
			size:              10,
			prevButtonStateHandler:   handlePrevButtonState,
			nextButtonStateHandler:   handleNextButtonState
		}
	);

};

YAHOO.util.Event.addListener(window, 'load', pageLoad);

</script>