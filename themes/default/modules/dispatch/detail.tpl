<!-- BEGIN: main -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td width="200px"><strong>{LANG.dis}</strong></td>
				<td><strong><a href="{TYPELINK}">{TYPENAME}</a> </strong></td>
			</tr>

			<tr>
				<td width="200px"><strong>{LANG.dis_code}</strong></td>
				<td> {ROW.code} </td>
			</tr>

			<tr>
				<td><strong>{LANG.dis_date_re}</strong></td>
				<td> {ROW.from_time} </td>
			</tr>
			<tr>
				<td><strong>{LANG.dis_souce}</strong></td>
				<td> {ROW.from_org} </td>
			</tr>

			<tr>
				<td><strong> {LANG.dis_to_org}</strong></td>
				<td> {ROW.to_org} </td>
			</tr>
			<tr>
				<td><strong>{LANG.dis_de}</strong></td>
				<td><!-- BEGIN: depid --> - {dis_de}
				<br />
				<!-- END: depid --></td>
			</tr>

			<tr>
				<td><strong>{LANG.dis_date_iss}</strong></td>
				<td> {ROW.date_iss} </td>
			</tr>
			<tr>
				<td><strong>{LANG.dis_date_first}</strong></td>
				<td> {ROW.date_first} </td>
			</tr>

			<tr>
				<td><strong>{LANG.dis_date_die}</strong></td>
				<td> {ROW.date_die} </td>
			</tr>
			<tr>
				<td><strong>{LANG.view}</strong></td>
				<td> {ROW.view} </td>
			</tr>
			<!-- BEGIN: taifile -->
			<tr>
				<td><strong> {LANG.file}</strong></td>
				<td><!-- BEGIN: row --><a href="{NV_BASE_SITEURL}uploads/{module}/{FILEUPLOAD}"><em class="fa fa-download">&nbsp;</em>{FILEUPLOAD} </a>
				<br />
				<!-- END: row --></td>
			</tr>
			<!-- END: taifile -->

			<tr>
				<td><strong>{LANG.dis_content}</strong></td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td colspan="2" style="text-align: justify;"> {ROW.content} </td>
			</tr>
		</tbody>
	</table>
</div>
<div style="clear: both;"></div>
<!-- END: main -->