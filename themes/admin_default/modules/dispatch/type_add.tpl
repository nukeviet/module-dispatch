<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<form action="{FORM_ACTION}" method="post">
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <td>
                    {LANG.type_name} (<span style="color:red">*</span>)
                </td>
                <td>
                    <input class="form-control w400" value="{DATA.title}" name="title" id="title" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td>
                    {LANG.alias}
                </td>
                <td>
                    <input class="form-control w400" value="{DATA.alias}" name="alias" id="alias" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td>
                    {LANG.type_parent}
                </td>
                <td>
                    <select class="form-control w200" name="parentid">
                        <!-- BEGIN: parentid -->
                        <option value="{LISTTYPES.id}"{LISTTYPES.selected}>{LISTTYPES.name}</option>
                        <!-- END: parentid -->
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input class="btn btn-primary" type="submit" name="submit" value="{LANG.save}" />
                </td>
            </tr>
        </tbody>
    </table>
</form>
<!-- END: main -->