<!-- BEGIN: main -->
<div id="ablist">
	<input name="addNew" type="button" class="btn btn-primary" value="{LANG.addsigner}" />
</div>
<div class="myh3">
	{LANG.signer}
</div>

<div id="pageContent">
	<p class="text-center"><em class="fa fa-spinner fa-spin fa-4x">&nbsp;</em></p>
</div>

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
		<table class="table table-striped table-bordered table-hover">
			<col style="width:200px" />
			<tbody>
				<tr>
					<td >{LANG.title} <span class="red">*</span></td>
					<td><input title="{LANG.title}" class="form-control w400" type="text" name="name" value="{signer.name}" maxlength="100"  /></td>
				</tr>
				<tr>
					<td>{LANG.postion}</td>
					<td ><input title="{LANG.title}" class="form-control w400" type="text" name="positions" value="{signer.positions}" maxlength="100"  /></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="save" value="1" />
		<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
	</form>
</div>
<script type="text/javascript">
	//<![CDATA[
	$("form#addsigner").submit(function() {
		var a = $("input[name=title]").val();
		a = trim(a);
		$("input[name=title]").val(a);
		if (a == "") {
			alert("{LANG.errorIsEmpty}: " + $("input[name=title]").attr("title"));
			$("input[name=title]").select();
			return false
		}
		a = $(this).serialize();
		var c = $(this).attr("action");
		$("input[name=submit]").attr("disabled", "disabled");
		$.ajax({
			type : "POST",
			url : c,
			data : a,
			success : function(b) {
				if (b == "OK") {
					window.location.href = "{MODULE_URL}=signer"
				} else {
					alert(b);
					$("input[name=submit]").removeAttr("disabled")
				}
			}
		});
		return false
	});
	//]]>
</script>
<!-- END: action -->
<!-- BEGIN: list -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<col width="100" />
		<col span="2" />
		<col class="w150" />
		<thead>
			<tr>
				<th> {LANG.pos} </th>
				<th> {LANG.title} </th>
				<th> {LANG.positions} </th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td>
				<select name="p_{LOOP.id}" class="form-control newWeight">
					<!-- BEGIN: option -->
					<option value="{NEWWEIGHT.value}"{NEWWEIGHT.selected}>{NEWWEIGHT.value}</option>
					<!-- END: option -->
				</select></td>
				<td> {LOOP.name} </td>
				<td> {LOOP.positions} </td>
				<td class="text-center">
					<em class="fa fa-edit fa-lg">&nbsp;</em><a href="{MODULE_URL}=signer&edit&id={LOOP.id}">{GLANG.edit}</a> - 
					<em class="fa fa-trash-o fa-lg">&nbsp;</em><a class="del" href="{LOOP.id}">{GLANG.delete}</a>
				</td>
			</tr>
			<!-- END: loop -->
		<tbody>
	</table>
</div>
<script type="text/javascript">
	//<![CDATA[
	$("a.del").click(function() {
		confirm("{LANG.delConfirm} ?") && $.ajax({
			type : "POST",
			url : "{MODULE_URL}=signer",
			data : "del=" + $(this).attr("href"),
			success : function(a) {
				if (a == "OK") {
					window.location.href = window.location.href;
				} else {
					alert(a);
				}
			}
		});
		return false;
	});
	
	$("select.newWeight").change(function() {
		var a = $(this).attr("name").split("_"), c = $(this).val(), d = this;
		a = a[1];
		$(this).attr("disabled", "disabled");
		$.ajax({
			type : "POST",
			url : "{MODULE_URL}=signer",
			data : "cWeight=" + c + "&id=" + a,
			success : function(b) {
				if (b == "OK") {
					$("div#pageContent").load("{MODULE_URL}=signer&list&random=" + nv_randomPassword(10));
				} else {
					alert("{LANG.errorChangeWeight}");
				}
				$(d).removeAttr("disabled");
			}
		});
		return false;
	});
	//]]>
</script>
<!-- END: list -->