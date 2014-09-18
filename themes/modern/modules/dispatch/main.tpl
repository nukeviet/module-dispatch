<!-- BEGIN: main -->
<style type="text/css">
.thead{
	text-transform:uppercase;
	color: #fff;
}
table.tab1 tbody.r1 {
	background: #E0D0FF;
}
table.tab1 tbody.r2{
	background: #E0F0FF;
}
table.tab1 tbody.r3{
	background: #E0A0FF;
}

</style>
<h4><a href="{MODULE_LINK}"><strong>{LANG.homepage}</strong></a></h4>
<div style="margin-top:8px;">
    <a class="button1" href="{SE_LINK}"><span><span>{LANG.sereach}</span></span></a>   
</div><br />

<div style="margin-top:8px;">

</div>

<script type="text/javascript">
	var pro_del_cofirm = "{LANG.product_del_cofirm}";
</script>

<form class="form-inline" action="{FORM_ACTION}" method="get">

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
         </select>
         </td>
    </tr>
	<tr>
		<td> {LANG.dis_code} </td> <td><input name="code" size="15" value="{code}"> </td>
	</tr>
	<tr>
		<td> {LANG.dis_content} </td> <td><textarea rows="2" cols="40" name="content">{content}</textarea>
		</td>
	</tr>
	<tr>
		<td> {LANG.dis_person} </td> 
		<td><select class="form-control" name="from_signer" id="from_signer_{LISSIS.id}" onchange="nv_link('{LISSIS.id}');" >
			<!-- BEGIN: from_signer -->
			      <option value="{LISSIS.id}"{LISSIS.selected}>{LISSIS.name}</option>
			<!-- END: from_signer -->
			</select> <span id="hienthi">                    
				    {position}                   
				</span>
	 	</td>
	</tr>
	<tr>
		<td>{LANG.chos_dis} </td>
		<td>
			{LANG.from}
			<input class="form-control" value="{FROM}" type="text" id="from" name="from" readonly="readonly" style="width:100px" />
			<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'from', 'dd.mm.yyyy', true);" alt="" height="17" />
			{LANG.to}
			<input class="form-control" value="{TO}" type="text" id="to" name="to" readonly="readonly" style="width:100px" />
			<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'to', 'dd.mm.yyyy', true);" alt="" height="17" />
			<img alt="" src="{NV_BASE_SITEURL}images/refresh.png" style="cursor: pointer; vertical-align: middle;" onclick="nv_clear_text();" />
		
		</td>
	</tr>
	<tr>
	<td colspan="2"><input class="btn btn-primary" type="submit" value="Search" name="timkiem"></td>
	</tr>

</table>
</div>

<!-- END: timkiem -->
<!-- BEGIN: error -->
<div style="width: 780px;" class="quote">
    <blockquote class="error">
            <span>{ERROR}</span>        
    </blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<!-- BEGIN: data -->
<table class="table table-striped table-bordered table-hover">
    <caption>{TABLE_CAPTION}</caption>
    <thead class= "thead">
        <tr>
            <td style="width:25px;text-align:center">
                 {LANG.dis_date_re}
           </td>
            <td style="width:60px;">
                {LANG.dis_code}
            </td>           
            <td style="width:90px;">
                {LANG.dis_souce}
            </td>
            <td>
                {LANG.dis_content}
            </td>
             <td style="width:90px;">
                {LANG.dis_to_org}
            </td>           
            <td style="width:50px;">
                {LANG.dis_status}
            </td>  
        </tr>
    </thead>
    <tbody>
    <!-- BEGIN: row -->
        <tr>
        	 <td>
                {ROW.from_time}
            </td>                       
            <td>
                <a href="{ROW.link_code}">{ROW.code}</a>
            </td>            
             <td>
               {ROW.from_org}
            </td>
            <td>
                {ROW.content}
            </td>          
           
            <td>
               {ROW.to_org}
            </td>
            <td>
               <!-- BEGIN: loop1 -->		                
		                    <a href="{NV_BASE_SITEURL}uploads/{module}/{FILEUPLOAD}" style="text-decoration: none;"><image src="{NV_BASE_SITEURL}themes/{template}/images/{module}/download.png" title={FILEUPLOAD}></a><br />
		      <!-- END: loop1 -->
            </td> 
       </tr>     
    <!-- END: row -->
    <tbody>
    <!-- BEGIN: generate_page -->
    <tr class="footer">
        <td colspan="8">
            {GENERATE_PAGE}
        </td>
    </tr>
    <!-- END: generate_page -->
</table>
<!-- END: data -->
</form>
<!-- END: main -->