<!-- BEGIN: main -->
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
<script type="text/javascript">
	var pro_del_cofirm = "{LANG.product_del_cofirm}";
</script>
<form action="{FORM_ACTION}" method="get">
<input type="hidden" name ='nv' value={MODULE_NAME}>
<input type="hidden" name ='op' value={OP}>
{LANG.dis} &nbsp;&nbsp;
<select name="type">
   <!-- BEGIN: typeid -->
          <option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
  <!-- END: typeid -->                    
</select>

{LANG.chos_dis} 
{LANG.from}
<input value="{FROM}" type="text" id="from" name="from" readonly="readonly" style="width:100px" />
<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'from', 'dd.mm.yyyy', true);" alt="" height="17" />
{LANG.to}
<input value="{TO}" type="text" id="to" name="to" readonly="readonly" style="width:100px" />
<img src="{NV_BASE_SITEURL}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'to', 'dd.mm.yyyy', true);" alt="" height="17" />
<img alt="" src="{NV_BASE_SITEURL}images/refresh.png" style="cursor: pointer; vertical-align: middle;" onclick="nv_clear_text();" />

<input type="submit" value="Search" name="timkiem">
<table class="tab1">
    <caption><a href="{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}={MODULE_NAME}">{TABLE_CAPTION}</a></caption>
    				   
    <thead>
        <tr>
            <td style="width:40px;text-align:center">
                 {LANG.stt}
           </td>
            <td>
                {LANG.dis_name}
            </td>           
            <td style="width:110px;">
                {LANG.dis_code}
            </td>
            <td style="width:120px;">
                {LANG.dis}
            </td>
             <td style="width:110px;">
                {LANG.cat_parent}
            </td>
           <td style="width:110px;">
                {LANG.dis_person}
            </td>
            <td style="width:250px;">
                {LANG.dis_content}
            </td>
            <td style="width:70px;">
                {LANG.dis_date_re}
            </td>            
            <td style="width:70px;white-space:nowrap;text-align:center">
                {LANG.detail}
            </td>
            <td style="width:100px;white-space:nowrap;text-align:center">
                {LANG.feature}
            </td>
            
        </tr>
    </thead>
    <!-- BEGIN: row -->
    <tbody{CLASS}>
        <tr>
        	 <td>
                {ROW.stt}
            </td>
            <td>
                {ROW.title}
            </td>             
             <td>
                {ROW.code}
            </td>            
             <td>
                <a href="{ROW.link_type}">{ROW.type}</a>
            </td>
            <td>
                <a href="{ROW.link_cat}">{ROW.cat}</a>
            </td> 
             <td>
                <a href="{ROW.link_singer}">{ROW.from_signer}</a>
            </td> 
                      
            <td>
                {ROW.content}
            </td>
            <td>
               {ROW.from_time}
            </td>
            
             <td>
                <a href="{ROW.link_detail}">{LANG.detail}</a>
            </td>
            <td style="width:100px;white-space:nowrap;text-align:center">
                <span class="edit_icon"><a href="{EDIT_URL}">{GLANG.edit}</a></span>
                &nbsp;&nbsp;<span class="delete_icon"><a href="javascript:void(0);" onclick="nv_pro_del({ROW.id});">{GLANG.delete}</a></span>
            </td>
            
       </tr>     
    </tbody>
    <!-- END: row -->
    <!-- BEGIN: generate_page -->
    <tr class="footer">
        <td colspan="8">
            {GENERATE_PAGE}
        </td>
    </tr>
    <!-- END: generate_page -->
</table>
</form>
<!-- END: main -->

