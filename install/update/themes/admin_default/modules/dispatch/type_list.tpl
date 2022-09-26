<!-- BEGIN: main -->
<script type="text/javascript">
    var type_del_cofirm = "{LANG.type_del}";
</script>
<table class="table table-striped table-bordered table-hover">
    <caption>{TABLE_CAPTION}</caption>
    <colgroup>
        <col class="w100" />
        <col span="2" />
        <col span="2" class="w200" />
    </colgroup>
    <thead>
        <tr>
            <th>
                {LANG.type_sort}
            </th>
            <th>
                {LANG.type_name}
            </th>
            <th>
                {LANG.type_parent}
            </th>
            <th  class="text-center">
                {LANG.type_active}
            </th>
            <th class="text-center">
                {LANG.feature}
            </th>
        </tr>
    </thead>
    <tbody>
        <!-- BEGIN: row -->
        <tr>
            <td>
                <select class="form-control input-sm" name="weight" id="weight{ROW.id}" onchange="nv_chang_type_weight({ROW.id});">
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
            <td  class="text-center">
                <input type="checkbox" name="active" id="change_status{ROW.id}" value="1"{ROW.status} onclick="nv_chang_type_status({ROW.id});" />
            </td>
            <td  class="text-center">
                <a href="{EDIT_URL}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                <a href="javascript:void(0);" onclick="nv_type_del({ROW.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {GLANG.delete}</a>
            </td>
        </tr>
        <!-- END: row -->
    <tbody>
</table>
<a class="btn btn-primary" href="{ADD_NEW_TYPE}">{LANG.type_add}</a>
<!-- END: main -->
