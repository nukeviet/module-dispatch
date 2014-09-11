<!-- BEGIN: main -->
  <h4 class="cattitle">
        <a href="{MODULE_URL2}"><strong>{LANG.homepage}</strong></a>        
    </h4>
{detail_title} <br /><br />
<table class="tab1" > 
        <tbody >
            <tr>
                <td width="200px">
                    <strong>{LANG.dis}</strong>
                </td>
               <td>
                	<strong><a href="{TYPELINK}">{TYPENAME}</a>  </strong>                  
                </td>
            </tr>
        </tbody>
         <tbody class="second" >
            <tr>
                <td width="200px">
                    <strong>{LANG.dis_code}</strong>
                </td>
                <td>
                    {ROW.code}
                </td>
            </tr>
        </tbody>
        
       <tbody >
            <tr>
                <td>
                    <strong>{LANG.dis_date_re}</strong>
                </td>
               <td>
                	{ROW.from_time}                    
                </td>
            </tr>
        </tbody>
        
        
        <tbody class="second">
            <tr>
                <td>
                    <strong>{LANG.dis_souce}</strong>
                </td>
                <td>
                    {ROW.from_org}
                </td>
            </tr>
        </tbody>
        <tbody >
            <tr>
                <td>
                   <strong> {LANG.dis_to_org}</strong>
                </td>
                <td>
                    {ROW.to_org}
                </td>
            </tr>
        </tbody>
        
          <tbody class="second">
            <tr>
                <td>
                    <strong>{LANG.dis_de}</strong>
                </td>
                <td>
                	<!-- BEGIN: depid -->
                   - {dis_de}<br />
                   <!-- END: depid -->
                </td>
            </tr>
        </tbody>
              
       
        
        
        <tbody >
            <tr>
                <td>
                    <strong>{LANG.dis_date_iss}</strong>
                </td>
                <td>
                	{ROW.date_iss}
                    
                </td>
            </tr>
        </tbody>
        <tbody class="second">
            <tr>
                <td>
                    <strong>{LANG.dis_date_first}</strong>
                </td>
               <td>
                	{ROW.date_first}
                    
                </td>
            </tr>
        </tbody>
        <tbody >
            <tr>
                <td>
                    <strong>{LANG.dis_date_die}</strong>
                </td>
               <td>
                	{ROW.date_die}
                    
                </td>
            </tr>
        </tbody> 
       
        <tbody class="second">
            <tr>
                <td>
                    <strong>{LANG.view}</strong>
                </td>
                <td>                	
                    {ROW.view}
                </td>
            </tr>
        </tbody> 
        <!-- BEGIN: taifile -->
        <tbody >
            <tr>
                <td>
                   <strong> {LANG.file}</strong>
                </td>
                <td>         
                     <!-- BEGIN: row -->		                
		                    <a href="{NV_BASE_SITEURL}uploads/{module}/{FILEUPLOAD}" style="text-decoration: none;"><image src="{NV_BASE_SITEURL}themes/{template}/images/{module}/download.png" title={FILEUPLOAD} width="30px"> {FILEUPLOAD}</a><br />
		             <!-- END: row -->
                </td>
            </tr>
        </tbody> 
        <!-- END: taifile -->
        <tbody >
            <tr>
                <td>
                    <strong>{LANG.dis_content}</strong>
                </td>
                <td></td>
            </tr>
        </tbody>
        <tbody >
        <tr>
                <td colspan="2" style="text-align: justify;">                	
                    {ROW.content}
                </td>
            </tr>
        </tbody>
        
    </table>
    <div style="clear: both;"></div>   
<!-- END: main -->