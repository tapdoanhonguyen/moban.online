<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">
    {ERROR}
</div>
<!-- END: error -->
<form action="{FORM_ACTION}" method="post" class="confirm-reload">
    <input name="save" type="hidden" value="1" />
    <input type="hidden" value="{ISCOPY}" name="copy" />
    <div class="row">
        <div class="col-sm-24 col-md-18">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <colgroup>
                        <col class="w200" />
                        <col />
                    </colgroup>
                    <tbody>
                    <tr>
                        <td class="text-right"> {LANG.title} <sup class="required">(*)</sup></td>
                        <td><input class="w300 form-control pull-left" type="text" value="{DATA.title}" name="title" id="idtitle" maxlength="250" />&nbsp;<span class="text-middle"> {GLANG.length_characters}: <span id="titlelength" class="red">0</span>. {GLANG.title_suggest_max} </span></td>
                    </tr>
                    <tr>
                        <td class="text-right">{LANG.alias}</td>
                        <td><input class="w300 form-control pull-left" type="text" value="{DATA.alias}" name="alias" id="idalias" maxlength="250" />&nbsp;<em class="fa fa-refresh fa-lg fa-pointer" onclick="get_alias('{ID}');">&nbsp;</em></td>
                    </tr>
                    <tr>
                        <td class="text-right">{LANG.image}</td>
                        <td><input class="w300 form-control pull-left" type="text" name="image" id="image" value="{DATA.image}" style="margin-right: 5px"/><input type="button" value="Browse server" name="selectimg" class="btn btn-info"/></td>
                    </tr>
                    <tr>
                        <td class="text-right">{LANG.description} </td>
                        <td >							<textarea class="form-control" id="description" name="description" cols="100" rows="5">{DATA.description}</textarea> {GLANG.length_characters}: <span id="descriptionlength" class="red">0</span>. {GLANG.description_suggest_max} </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="strong" > {LANG.bodytext} <sup class="required">(*)</sup>
                            <div>
                                {BODYTEXT}
                            </div></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-24 col-md-6">
            <table class="table table-striped table-bordered table-hover">
                <tbody>
                    <tr>
                        <td>{LANG.price_require} <sup class="required">(*)</sup></td>
                    </tr>
                    <tr>
                        <td><input class="form-control" type="text" value="{DATA.price_require}" name="price_require" /></td>
                    </tr>
                    <tr>
                        <td>{LANG.percent_sale}</td>
                    </tr>
                    <tr>
                        <td><input class="form-control" type="text" value="{DATA.percent_sale}" name="percent_sale" /></td>
                    </tr>
                    <!--
                    <tr>
                        <td>{LANG.number_sale}</td>
                    </tr>
                    <tr>
                        <td><input class="form-control" type="text" value="{DATA.number_sale}" name="number_sale" /></td>
                    </tr>
                    <tr>
                        <td>{LANG.number_gift}</td>
                    </tr>
                    <tr>
                        <td><input class="form-control" type="text" value="{DATA.number_gift}" name="number_gift" /></td>
                    </tr>
                    -->
                    <tr>
                        <td>{LANG.keywords}</td>
                    </tr>
                    <tr>
                        <td><input class="form-control" type="text" value="{DATA.keywords}" name="keywords" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row text-center"><input type="submit" value="{LANG.save}" class="btn btn-primary"/>
    </div>
</form>
<script type="text/javascript">
    var uploads_dir_user = '{UPLOADS_DIR_USER}';
    $("#titlelength").html($("#idtitle").val().length);
    $("#idtitle").bind('keyup paste', function() {
        $("#titlelength").html($(this).val().length);
    });

    $("#descriptionlength").html($("#description").val().length);
    $("#description").bind('keyup paste', function() {
        $("#descriptionlength").html($(this).val().length);
    });
</script>
<!-- BEGIN: get_alias -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#idtitle').change(function() {
            get_alias('{ID}');
        });
    });
</script>
<!-- END: get_alias -->
<!-- END: main -->