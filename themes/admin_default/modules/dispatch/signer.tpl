<!-- BEGIN: main -->
<div id="ablist">
    <input name="addNew" type="button" value="{LANG.addsigner}" />
</div>
<div class="myh3">{LANG.signer}</div>
<div id="pageContent"></div>
<script type="text/javascript">
//<![CDATA[
$(function() {
  $("div#pageContent").load("{MODULE_URL}=signer&list&random=" + nv_randomPassword(10))
});
$("input[name=addNew]").click(function() {
  window.location.href = "{MODULE_URL}=signer&add";
  return false
});
//]]>
</script>
<!-- END: main -->
<!-- BEGIN: action -->
<div id="pageContent">
    <form id="addsigner" method="post" action="{ACTION_URL}">
        <h3 class="myh3">{PTITLE}</h3>
        <table class="tab1">
            <col style="width:200px" />
            <tbody class="second">
                <tr>
                    <td >{LANG.title} <span style="color:red">*</span></td>
                    <td><input title="{LANG.title}" class="txt" type="text" name="name" value="{signer.name}" style="width:300px" maxlength="100"  /></td>
                </tr>
            </tbody>
             <tbody>
                <tr>
                    <td>{LANG.postion}</td>
                    <td ><input title="{LANG.title}" class="txt" type="text" name="positions" value="{signer.positions}" style="width:300px" maxlength="100"  /></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="save" value="1" />
        <input name="submit" type="submit" value="{LANG.save}" />
    </form>
</div>
<script type="text/javascript">
//<![CDATA[
$("form#addsigner").submit(function() {
  var a = $("input[name=title]").val();
  a = trim(a);
  $("input[name=title]").val(a);
  if(a == "") {
    alert("{LANG.errorIsEmpty}: " + $("input[name=title]").attr("title"));
    $("input[name=title]").select();
    return false
  }
  a = $(this).serialize();
  var c = $(this).attr("action");
  $("input[name=submit]").attr("disabled", "disabled");
  $.ajax({type:"POST", url:c, data:a, success:function(b) {
    if(b == "OK") {
      window.location.href = "{MODULE_URL}=signer"
    }else {
      alert(b);
      $("input[name=submit]").removeAttr("disabled")
    }
  }});
  return false
});
//]]>
</script>
<!-- END: action -->
<!-- BEGIN: list -->
<table class="tab1">
    <col width="50" />
    <col width="250" />
    <thead>
        <tr>
            <td>
                {LANG.pos}
            </td>
            <td>
                {LANG.title}
            </td>
             <td>
                {LANG.positions}
            </td>
            <td>
            </td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody{CLASS}>
        <tr>
            <td>
                <select name="p_{LOOP.id}" class="newWeight">
                    <!-- BEGIN: option -->
                    <option value="{NEWWEIGHT.value}"{NEWWEIGHT.selected}>{NEWWEIGHT.value}</option>
                    <!-- END: option -->
                </select>
            </td>
            <td>
                {LOOP.name}
            </td>
            <td>
                {LOOP.positions}
            </td>
            <td>
            <a href="{MODULE_URL}=signer&edit&id={LOOP.id}">{GLANG.edit}</a> | <a class="del" href="{LOOP.id}">{GLANG.delete}</a>
            </td>
        </tr>
    </tbody>
    <!-- END: loop -->
</table>
<script type="text/javascript">
//<![CDATA[
$("a.del").click(function() {
  confirm("{LANG.delConfirm} ?") && $.ajax({type:"POST", url:"{MODULE_URL}=signer", data:"del=" + $(this).attr("href"), success:function(a) {
    if(a == "OK") {
      window.location.href = window.location.href;
    }else {
      alert(a)
    }
  }});
  return false
});
$("select.newWeight").change(function() {
  var a = $(this).attr("name").split("_"), c = $(this).val(), d = this;
  a = a[1];
  $(this).attr("disabled", "disabled");
  $.ajax({type:"POST", url:"{MODULE_URL}=signer", data:"cWeight=" + c + "&id=" + a, success:function(b) {
    if(b == "OK") {
      $("div#pageContent").load("{MODULE_URL}=signer&list&random=" + nv_randomPassword(10))
    }else {
      alert("{LANG.errorChangeWeight}")
    }
    $(d).removeAttr("disabled")
  }});
  return false
});
//]]>
</script>
<!-- END: list -->
