<!-- BEGIN: main -->
<script type="text/javascript">
	var de_del_cofirm = "{LANG.de_del}";
</script>

<div id="users">
    <table class="table table-striped table-bordered table-hover">
        <caption>{TABLE_CAPTION}</caption>
        <colgroup>
        	<col class="w100" />
        	<col span="2" />
        	<col class="w150" />
        </colgroup>
        <thead>
            <tr>
                <th>
                    {LANG.cat_sort}
                </th>
                <th>
                    {LANG.de_name}
                </th>
                <th>
                    {LANG.de_parent}
                </th>
                <th class="text-center">
                    {LANG.feature}
                </th>
            </tr>
        </thead>
        <tbody>
        <!-- BEGIN: row -->
            <tr>
                <td style="width:15px">
                    <select class="form-control" name="weight" id="weight{ROW.id}" onchange="nv_chang_de_weight({ROW.id});">
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
                <td class="text-center">
                    <em class="fa fa-edit fa-lg">&nbsp;</em><a href="{EDIT_URL}">{GLANG.edit}</a></span> - 
                    <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="javascript:void(0);" onclick="nv_de_del({ROW.id});">{GLANG.delete}</a></span>
                </td>
            </tr>
        <!-- END: row -->
        <tbody>
    </table>
</div>

<a class="btn btn-primary" href="{ADD_NEW_DE}">{LANG.de_add}</a>

<!-- END: main -->