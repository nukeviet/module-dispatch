<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css"href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/ddsmoothmenu.css" />
<script type="text/javascript"	src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ddsmoothmenu.js"></script>
<script type="text/javascript">
	ddsmoothmenu.init({
		arrowimages : {
			down : ['downarrowclass', '{NV_BASE_SITEURL}themes/{TEMPLATE}/images/ddsmoothmenu/down.gif', 23],
			right : ['rightarrowclass', '{NV_BASE_SITEURL}themes/{TEMPLATE}/images/ddsmoothmenu/right.gif']
		},
		mainmenuid : "smoothmenu_{BLOCK_ID}", //Menu DIV id
		zIndex : 50,
		orientation : 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname : 'ddsmoothmenu', //class added to menu's outer DIV
		contentsource : "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})
</script>
<div id="smoothmenu_{BLOCK_ID}" class="ddsmoothmenu">
	<ul>
		{HTML_CONTENT}
	</ul>
</div>
<!-- END: main -->