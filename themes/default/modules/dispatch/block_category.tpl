<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css"	href="{NV_BASE_SITEURL}themes/{TEMPLATE_CSS}/css/jquery.metisMenu.css" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.metisMenu.js"></script>

<div class="clearfix panel metismenu">
	<aside class="sidebar">
		<nav class="sidebar-nav">
			<ul id="block{UNIQUE_KEY_ID}_{BLOCK_ID}">
				<!-- BEGIN: cat -->
				<li>
					<a href="{CAT.link}" title="{CAT.title}">{CAT.title0}</a>
					<!-- BEGIN: subcat -->
					<span class="fa arrow expand">&nbsp;</span>
					{SUBCAT}
					<!-- END: subcat -->
				</li>
				<!-- END: cat -->
			</ul>
		</nav>
	</aside>
</div>
<script type="text/javascript">
$(function () {
	$('#block{UNIQUE_KEY_ID}_{BLOCK_ID}').metisMenu({
        toggle: false
    });
});
</script>
<!-- END: main -->