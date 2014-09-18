<!-- BEGIN: main -->
<script type="text/javascript">
	var cat_del_cofirm = "{LANG.cat_del}";
</script>

<div id="users">
    <table class="table table-striped table-bordered table-hover">
        <caption>{TABLE_CAPTION}</caption>
        <colgroup>
        	<col class="w100" />
        	<col span="2" />
        	<col span="2" class="w150" />
        </colgroup>
        <thead>
            <tr>
                <th>{LANG.cat_sort}</th>
                <th>{LANG.cat_name}</th>
                <th>{LANG.cat_parent}</th>
                <th class="text-center">{LANG.cat_active}</th>
                <th class="text-center">{LANG.feature}</th>
            </tr>
        </thead>
        <tbody>
        <!-- BEGIN: row -->
            <tr>
                <td>
                    <select class="form-control" name="weight" id="weight{ROW.id}" onchange="nv_chang_cat_weight({ROW.id});">
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
                    <input type="checkbox" name="active" id="change_status{ROW.id}" value="1"{ROW.status} onclick="nv_chang_cat_status({ROW.id});" />
                </td>
                <td class="text-center">
                    <em class="fa fa-edit fa-lg">&nbsp;</em><a href="{EDIT_URL}">{GLANG.edit}</a> - 
                    <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="javascript:void(0);" onclick="nv_cat_del({ROW.id});">{GLANG.delete}</a>
                </td>
            </tr>
        <!-- END: row -->
        <tbody>
    </table>
</div>

<a class="btn btn-primary" href="{ADD_NEW_CAT}">{LANG.cat_add}</a>

<!-- END: main -->