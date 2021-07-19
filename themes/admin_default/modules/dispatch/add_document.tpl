<!-- BEGIN: inter -->

<!-- BEGIN: error -->
<div class="alert alert-danger">
	{ERROR}
</div>
<!-- END: error -->

<link rel="stylesheet" type="text/css" href="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">

<form action="{FORM_ACTION}" method="post">
	<table class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td width="200px">{LANG.dis_name} (<span class="red">*</span>)</strong></td>
				<td><input class="form-control w400" value="{DATA.title}" name="title" id="title" maxlength="100" /><input type = "hidden" name = "id" value="{id}"></td>
			</tr>

			<tr>
				<td>{LANG.cat_parent}</td>
				<td>
				<select class="form-control w200" name="parentid">
					<!-- BEGIN: parentid -->
					<option value="{LISTCATS.id}"{LISTCATS.selected}>{LISTCATS.name}</option>
					<!-- END: parentid -->
				</select></td>
			</tr>
			<tr>
				<td>{LANG.type}</td>
				<td>
				<select class="form-control w200" name="typeid">
					<!-- BEGIN: typeid -->
					<option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
					<!-- END: typeid -->
				</select></td>
			</tr>

			<tr>
				<td>{LANG.dis_date_re}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w200 pull-left" value="{DATA.from_time}" type="text" id="from_time" name="from_time" readonly="readonly" /></td>
			</tr>

			<tr>
				<td>{LANG.dis_code}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w400" value="{DATA.code}" name="code" id="code" maxlength="100" /></td>
			</tr>

			<tr>
				<td>{LANG.dis_souce}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w400" value="{DATA.from_org}" name="from_org" id="from_org" maxlength="100" /></td>
			</tr>
			<tr>
				<td >{LANG.dis_to_org}</td>
				<td><textarea class="form-control w400" name="to_org">{DATA.to_org}</textarea><span class="help-block">{LANG.org}</span></td>
			</tr>

			<tr>
				<td>{LANG.from_depid}</td>
				<td>
				<select class="form-control w200" name="from_depid">
					<!-- BEGIN: from_depid -->
					<option value="{LISTDES.id}"{LISTDES.selected}>{LISTDES.name}</option>
					<!-- END: from_depid -->
				</select></td>
			</tr>
			<tr>
				<td>{LANG.dis_person}(<span class="red">*</span>)</strong></td>
				<td>
				<select class="form-control w200" name="from_signer" id="from_signer_{LISSIS.id}" onchange="nv_link('{LISSIS.id}');" >
					<!-- BEGIN: from_signer -->
					<option value="{LISSIS.id}"{LISSIS.selected}>{LISSIS.name}</option>
					<!-- END: from_signer -->
				</select><span id="hienthi"> {position} </span></td>
			</tr>

			<tr>
				<td>{LANG.dis_date_iss}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w200 pull-left" value="{DATA.date_iss}" type="text" id="date_iss" name="date_iss" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>{LANG.dis_date_first}(<span class="red">*</span>)</strong></td>
				<td><input class="form-control w200 pull-left" value="{DATA.date_first}" type="text" id="date_first" name="date_first" readonly="readonly" /></td>
			</tr>

			<tr>
				<td>{LANG.dis_date_die}</td>
				<td><input class="form-control w200 pull-left" value="{DATA.date_die}" type="text" id="date_die" name="date_die" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>{LANG.dis_content}</td>
				<td><textarea class="form-control" rows="8" name="content">{DATA.content}</textarea></td>
			</tr>

			<tr>
				<td>{LANG.dis_file}</td>
				<td>
					<div id="fileupload_items">
						<!-- BEGIN: fileupload -->
						<label>
							<input class="form-control w400 pull-left" style="margin-right: 5px" type="text" value="{FILEUPLOAD.value}" name="fileupload[]" id="fileupload{FILEUPLOAD.key}" style="width: 300px" maxlength="255" />
							<input class="btn btn-primary pull-left" style="margin-right: 5px" type="button" id="button{FILEUPLOAD.key}" value="{LANG.browse}" name="selectfile" onclick="nv_open_browse( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=fileupload{FILEUPLOAD.key}&path={FILES_DIR}&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' );return false;" />
						</label>
						<!-- END: fileupload -->
					</div>
					<script type="text/javascript">
						var file_items = '{fileupload_num}';
						var file_selectfile = '{LANG.browse}';
						var nv_base_adminurl = '{NV_BASE_ADMINURL}';
						var file_dir = '{FILES_DIR}';
					</script>
					<input class="btn btn-success" type="button" value="{LANG.add_button}" onclick="nv_file_additem();" />
				</td>
			</tr>
			<tr>
				<td>{LANG.dis_status}</td>
				<td>
				<select class="form-control w200" name="statusid">
					<!-- BEGIN: statusid -->
					<option value="{LISTSTATUS.id}"{LISTSTATUS.selected}>{LISTSTATUS.name}</option>
					<!-- END: statusid -->
				</select></td>
			</tr>

			<tr>
				<td >{LANG.dis_de}</td>

				<td>
				<div style="padding: 4px; height: 150px; width: 400px; background: none repeat scroll 0% 0% rgb(255, 255, 255); overflow: auto; text-align: left; border: 1px solid rgb(204, 204, 204);">
					<table>
						<tr>
							<td>
								<input id = "check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />{LANG.dis_cho}
							</td>
						</tr>
						<!-- BEGIN: loop -->
						<tr>
							<td>
								<input name="deid[{ROW.id}]" value="{ROW.id}" type="checkbox" {ROW.checked} id="idcheck[]"/> {ROW.name}
							</td>
						</tr>
						<!-- END: loop -->

					</table>

				</div></td>
			</tr>

			<tr>
				<td>{LANG.who_view}</td>
				<td>
					<!-- BEGIN: groups_view -->
					    <div class="row">
                            <label><input name="groups_view[]" type="checkbox" value="{groups_view.value}" {groups_view.checked} />{groups_view.title}</label>
                        </div>
                    <!-- END: groups_view -->
                </td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-primary" type="submit" name="submit" value="{LANG.save}" /></td>
            </tr>
        </tbody>
    </table>
</form>

<script type="text/javascript" src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    $("#from_time,#date_iss, #date_first, #date_die").datepicker({
        showOn : "both",
        dateFormat : "dd.mm.yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true,
        buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
        buttonImageOnly : true
    });
</script>
<!-- END: inter -->