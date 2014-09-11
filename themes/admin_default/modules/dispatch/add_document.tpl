<!-- BEGIN: inter -->
<!-- BEGIN: error -->
<div style="width: 780px;" class="quote">
    <blockquote class="error">
        <p>
            <span>{ERROR}</span>
        </p>
    </blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="{FORM_ACTION}" method="post">
    <table class="tab1">
        <tbody class="second">
            <tr>
                <td width="200px">
                     <strong> {LANG.dis_name}(<span style="color:red">*</span>)</strong>
                </td>
                <td>
                    <input class="txt" value="{DATA.title}" name="title" id="title" style="width:300px" maxlength="100" />
                    <input type = "hidden" name = "id" value="{id}">
                </td>
            </tr>
        </tbody>
       
       <tbody >
            <tr>
                <td>
                     <strong> {LANG.cat_parent}</strong>
                </td>
                <td>
                    <select name="parentid">
                        <!-- BEGIN: parentid -->
                        <option value="{LISTCATS.id}"{LISTCATS.selected}>{LISTCATS.name}</option>
                        <!-- END: parentid -->
                    </select>
                </td>
            </tr>
        </tbody>
         <tbody class="second">
            <tr>
                <td>
                     <strong> {LANG.type}</strong>
                </td>
                <td>
                    <select name="typeid">
                        <!-- BEGIN: typeid -->
                        <option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
                        <!-- END: typeid -->
                    </select>
                </td>
            </tr>
        </tbody>
       <tbody >
            <tr>
                <td>
                    <strong>  {LANG.dis_date_re}(<span style="color:red">*</span>)</strong>
                </td>
               <td>
                	<input value="{DATA.from_time}" type="text" id="from_time" name="from_time" readonly="readonly" style="width:100px" />
					<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'from_time', 'dd.mm.yyyy', true);" alt="" height="17" />
                    
                </td>
            </tr>
        </tbody>
        
         <tbody class="second" >
            <tr>
                <td>
                     <strong> {LANG.dis_code}(<span style="color:red">*</span>)</strong>
                </td>
                <td>
                    <input class="txt" value="{DATA.code}" name="code" id="code" style="width:100px" maxlength="100" />
                </td>
            </tr>
        </tbody>
        <tbody >
            <tr>
                <td>
                     <strong> {LANG.dis_souce}(<span style="color:red">*</span>)</strong>
                </td>
                <td>
                    <input class="txt" value="{DATA.from_org}" name="from_org" id="from_org" style="width:300px" maxlength="100" />
                </td>
            </tr>
        </tbody>
               
                <tbody class="second">
            <tr>
                <td >
                     <strong> {LANG.dis_to_org}</strong>
                </td>
            <td>
	           <textarea rows="2" cols="50" name="to_org">{DATA.to_org}</textarea> <span style = "vertical-align: top;">&nbsp;&nbsp;{LANG.org}</span>
			</td>	
            </tr>
        </tbody>
         <tbody >
            <tr>
                <td>
                    <strong>  {LANG.from_depid}</strong>
                </td>
                <td>
                    <select name="from_depid">
                        <!-- BEGIN: from_depid -->
                        <option value="{LISTDES.id}"{LISTDES.selected}>{LISTDES.name}</option>
                        <!-- END: from_depid -->
                    </select>
                </td>
            </tr>
        </tbody>
        
        <tbody class="second">
            <tr>
                <td>
                     <strong> {LANG.dis_person}(<span style="color:red">*</span>)</strong>
                </td>
                <td>                    
                    <select name="from_signer" id="from_signer_{LISSIS.id}" onchange="nv_link('{LISSIS.id}');" >
                        <!-- BEGIN: from_signer -->
                        <option value="{LISSIS.id}"{LISSIS.selected}>{LISSIS.name}</option>
                        <!-- END: from_signer -->
                    </select>
                    
                    <span id="hienthi">                    
                    {position}                   
                    </span>
                    
                </td>
            </tr>
        </tbody>
        <tbody >
            <tr>
                <td>
                     <strong> {LANG.dis_date_iss}(<span style="color:red">*</span>)</strong>
                </td>
                <td>
                	<input value="{DATA.date_iss}" type="text" id="date_iss" name="date_iss" readonly="readonly" style="width:100px" />
					<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'date_iss', 'dd.mm.yyyy', true);" alt="" height="17" />
                    
                </td>
            </tr>
        </tbody>
        <tbody class="second">
            <tr>
                <td>
                     <strong> {LANG.dis_date_first}(<span style="color:red">*</span>)</strong>
                </td>
               <td>
                	<input value="{DATA.date_first}" type="text" id="date_first" name="date_first" readonly="readonly" style="width:100px" />
					<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'date_first', 'dd.mm.yyyy', true);" alt="" height="17" />
                    
                </td>
            </tr>
        </tbody>
        <tbody >
            <tr>
                <td>
                     <strong> {LANG.dis_date_die}</strong>
                </td>
               <td>
                	<input value="{DATA.date_die}" type="text" id="date_die" name="date_die" readonly="readonly" style="width:100px" />
					<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'date_die', 'dd.mm.yyyy', true);" alt="" height="17" />
                    
                </td>
            </tr>
        </tbody>
        
        <tbody class="second">
            <tr>
                <td>
                    <strong>  {LANG.dis_content}</strong>
                </td>
                <td>
                	
                    <textarea rows="3" cols="50" name="content">{DATA.content}</textarea>
                </td>
            </tr>
        </tbody>        
        <tbody >
            <tr>
                <td>
                     <strong> {LANG.dis_file}</strong>
                </td>
                <td>
                    <div id="fileupload_items">
				<!-- BEGIN: fileupload --> 
				<input class="txt" type="text" value="{FILEUPLOAD.value}" name="fileupload[]" id="fileupload{FILEUPLOAD.key}" style="width: 300px" maxlength="255" />
				<input type="button" id="button{FILEUPLOAD.key}"  value="{LANG.browse}" name="selectfile" onclick="nv_open_browse_file( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=fileupload{FILEUPLOAD.key}&path={FILES_DIR}&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' );return false;" /><br />
				
				<!-- END: fileupload -->
				
			</div>
			<script type="text/javascript">
                    var file_items={fileupload_num};
                    var file_selectfile='{LANG.browse}';
                    var nv_base_adminurl = '{NV_BASE_ADMINURL}';
                    var file_dir='{FILES_DIR}';                    
                    </script> <input type="button"
				value="{LANG.add_button}" onclick="nv_file_additem();" /></td>

                </td>
            </tr>
        </tbody>
        
        <tbody class="second">
            <tr>
                <td>
                    <strong>  {LANG.dis_status}</strong>
                </td>
                <td>
                    <select name="statusid">
                        <!-- BEGIN: statusid -->
                        <option value="{LISTSTATUS.id}"{LISTSTATUS.selected}>{LISTSTATUS.name}</option>
                        <!-- END: statusid -->
                    </select>
                </td>
            </tr>
        </tbody>
        
        <tbody >
            <tr>
                <td >
                     <strong> {LANG.dis_de}</strong>
                </td>
            
            <td>
	            <div style="padding: 4px; height: 150px; width: 300px; background: none repeat scroll 0% 0% rgb(255, 255, 255); overflow: auto; text-align: left; border: 1px solid rgb(204, 204, 204);">
				<table>
				<tr>
					<th><strong> <input id = "check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />{LANG.dis_cho}</strong></th>
					
				</tr>
				<!-- BEGIN: loop -->
				<tr>
					<td>
						<input name="deid[{ROW.id}]" value="{ROW.id}" type="checkbox"{ROW.checked} id ="idcheck[]"/> {ROW.name}
					</td>					
				</tr>
				<!-- END: loop -->				
				
				</table>
				
				</div>
			</td>
            </tr>
        </tbody>
        
        <tbody  class="second">
		<tr>
                <td style="vertical-align:top">
                   <strong> {LANG.who_view}</strong>
                </td>
                <td>
                    <select name="who_view" id="who_view_{WHO_VIEW.key}" onchange="nv_view_group('{WHO_VIEW.key}');">
                        <!-- BEGIN: who_view -->
                        <option value="{WHO_VIEW.key}"{WHO_VIEW.selected}>{WHO_VIEW.title}</option>
                        <!-- END: who_view -->
                    </select>
                    <span id ="nhom">
                    <!-- BEGIN: group_view_empty -->
                    <br /><br />                    
                        <!-- BEGIN: groups_view -->
                        <input name="groups_view[]" value="{GROUPS_VIEW.key}" type="checkbox"{GROUPS_VIEW.checked} /> {GROUPS_VIEW.title}<br />
                        <!-- END: groups_view -->
                    <!-- END: group_view_empty -->
                    </span>
                </td>
        </tr>
	</tbody>	
        
        <tbody>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="{LANG.save}" />
                </td>
            </tr>
        </tbody>
    </table>
</form>
<!-- END: inter -->