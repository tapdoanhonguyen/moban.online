<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div style="padding:10px; text-align:center;font-weight:bold; background:#FFE6F2;">
	{error}
</div>
<meta http-equiv="Refresh" content="1;URL={redirect}">
<!-- END: error -->
<form class="form-inline" action="{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method='post'>
	<table class="table table-striped table-bordered table-hover" style="margin-bottom: 8px;">
		<tbody>
			<tr>
				<td class="right w250">{LANG.album_config_imgwidth}</td>
				<td><input class="form-control" type="text" name="imgwidth" value="{DATA.imgwidth}" style="width:50px"/> px</td>
			</tr>
			<tr>
				<td class="right">{LANG.album_config_imgheight}</td>
				<td><input class="form-control" type="text" name="imgheight" value="{DATA.imgheight}" style="width:50px"/> px</td>
			</tr>
			<tr>
				<td class="right">{LANG.config_per_page}</td>
				<td><input class="form-control" type="text" name="per_page" value="{DATA.per_page}" style="width:50px"/></td>
			</tr>
			<tr>
				<td class="right">{LANG.album_config_sort}</td>
				<td><input type="radio" name="sort" {DATA.asc} value="asc" /> {LANG.album_asc} <input type="radio" name="sort" {DATA.des} value="des" /> {LANG.album_des} </td>
			</tr>
			<tr>
				<td class="right">{LANG.album_config_sortoption}</td>
				<td><input type="radio" name="sortoption" id="sapxepoption_0" {DATA.byid} value="byid"/>{LANG.album_config_sortbyid} <input type="radio" name="sortoption" id="sapxepoption_1" {DATA.byrand} value="byrand"/>{LANG.album_config_sortbyrand} <input type="radio" name="sortoption" id="sapxepoption_2" {DATA.bytime} value="bytime"/>{LANG.album_config_sortbytime} <input type="radio" name="sortoption" id="sapxepoption_3" {DATA.byhit} value="byhit"/>{LANG.album_config_sortbyhit} </td>
			</tr>
			<tr>
				<td class="right">{LANG.album_config_showimagelink}</td>
				<td><input type="checkbox"  value="1" name="showlinkimage" {DATA.ck_showlinkimage} /></td>
			</tr>
			<tr>
				<td colspan="2" class="text-center"><input class="btn btn-primary" type="submit" name="submit" value="{LANG.album_submit}"/></td>
			</tr>
		</tbody>
	</table>
</form>
<!-- END: main -->