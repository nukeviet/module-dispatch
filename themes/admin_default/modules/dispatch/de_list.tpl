<!-- BEGIN: main -->
<script type="text/javascript">
	var de_del_cofirm = "{LANG.de_del}";
</script>
<div style="margin-top:8px;">
    <a class="button1" href="{ADD_NEW_DE}"><span><span>{LANG.de_add}</span></span></a>
</div>
<div class="clear"></div>
<div id="users">
    <table class="tab1">
        <caption>{TABLE_CAPTION}</caption>
        <thead>
            <tr>
                <td>
                    {LANG.cat_sort}
                </td>
                <td>
                    {LANG.de_name}
                </td>
                <td>
                    {LANG.de_parent}
                </td>
                <td style="width:100px;white-space:nowrap;text-align:center">
                    {LANG.feature}
                </td>
            </tr>
        </thead>
        <!-- BEGIN: row -->
        <tbody{ROW.class}>
            <tr>
                <td style="width:15px">
                    <select name="weight" id="weight{ROW.id}" onchange="nv_chang_de_weight({ROW.id});">
                        <!-- BEGIN: weight -->
                        <option value="{WEIGHT.pos}"{WEIGHT.selected}>{WEIGHT.pos}</option>
                        <!-- END: weight -->
                    </select>
                </td>
                <td>
                    <strong><a href="{ROW.titlelink}">{ROW.title}</a></strong>{ROW.numsub}
                </td>
                <td>
                    {ROW.parentid}
                </td>
                <td style="white-space:nowrap;text-align:center">
                    <span class="edit_icon"><a href="{EDIT_URL}">{GLANG.edit}</a></span>
                    &nbsp;&nbsp;<span class="delete_icon"><a href="javascript:void(0);" onclick="nv_de_del({ROW.id});">{GLANG.delete}</a></span>
                </td>
            </tr>
        </tbody>
        <!-- END: row -->
    </table>
</div>
<!-- END: main -->
