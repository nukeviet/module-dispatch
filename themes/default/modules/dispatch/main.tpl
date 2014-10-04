<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.datepicker.css" rel="stylesheet" />

<a class="btn btn-primary" href="{SE_LINK}">{LANG.sereach}</a>

<script type="text/javascript">var pro_del_cofirm = "{LANG.product_del_cofirm}";</script>

<form action="{FORM_ACTION}" method="get">
	<!-- BEGIN: timkiem -->
	<div style= "margin-bottom: 10px; margin-top: 10px;">
		<input type="hidden" name ='nv' value="{MODULE_NAME}">
		<input type="hidden" name ='op' value="{OP}">
		<input type="hidden" name ='se' value="1">
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<td> {LANG.type} </td>
				<td>
				<select class="form-control" name="type">
					<!-- BEGIN: typeid -->
					<option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
					<!-- END: typeid -->
				</select></td>
			</tr>
			<tr>
				<td> {LANG.dis_code} </td>
				<td><input name="code" class="form-control" style="width: 200px" size="15" value="{code}"></td>
			</tr>
			<tr>
				<td> {LANG.dis_content} </td>
				<td><textarea class="form-control" name="content">{content}</textarea></td>
			</tr>
			<tr>
				<td> {LANG.dis_person} </td>
				<td>
				<select class="form-control" style="width: 200px" name="from_signer" id="from_signer_{LISSIS.id}" onchange="nv_link('{LISSIS.id}');" >
					<!-- BEGIN: from_signer -->
					<option value="{LISSIS.id}"{LISSIS.selected}>{LISSIS.name}</option>
					<!-- END: from_signer -->
				</select><span id="hienthi"> {position} </span></td>
			</tr>
			<tr>
				<td>{LANG.chos_dis} </td>
				<td class="form-inline">
					<label>
					{LANG.from}
					<input class="form-control" value="{FROM}" type="text" id="from" name="from" readonly="readonly" style="width:100px" />
					{LANG.to}
					<input class="form-control" value="{TO}" type="text" id="to" name="to" readonly="readonly" style="width:100px" />
					</label>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input class="btn btn-primary" type="submit" value="Search" name="timkiem"></td>
			</tr>

		</table>
	</div>

	<!-- END: timkiem -->

	<!-- BEGIN: error -->
	<div class="alert alert-danger">
		{ERROR}
	</div>
	<!-- END: error -->

	<!-- BEGIN: data -->
	<table class="table table-striped table-bordered table-hover">
		<caption>
			{TABLE_CAPTION}
		</caption>
		<thead>
			<tr>
				<th> {LANG.dis_date_re} </th>
				<th> {LANG.dis_code} </th>
				<th> {LANG.dis_souce} </th>
				<th> {LANG.dis_to_org} </th>
				<th> {LANG.file} </th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: row -->
			<tr>
				<td> {ROW.from_time} </td>
				<td><a href="{ROW.link_code}">{ROW.code}</a></td>
				<td> {ROW.from_org} </td>
				<td> {ROW.to_org} </td>
				<td>
					<!-- BEGIN: loop1 -->
					<a href="{NV_BASE_SITEURL}uploads/{module}/{FILEUPLOAD}" title="Download"><em class="fa fa-download">&nbsp;</em></a>
					<!-- END: loop1 -->
				</td>
			</tr>
			<!-- END: row -->
		<tbody>
			<!-- BEGIN: generate_page -->
			<tr>
				<td colspan="5"> {GENERATE_PAGE} </td>
			</tr>
			<!-- END: generate_page -->
	</table>
	<!-- END: data -->
</form>

<script type="text/javascript" src="{NV_BASE_SITEURL}js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}js/ui/jquery.ui.autocomplete.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
	$("#from, #to").datepicker({
		showOn : "both",
		dateFormat : "dd.mm.yy",
		changeMonth : true,
		changeYear : true,
		showOtherMonths : true,
		buttonImage : nv_siteroot + "images/calendar.gif",
		buttonImageOnly : true
	});
</script>

<!-- END: main -->