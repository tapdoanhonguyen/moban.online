<!-- BEGIN: main --><!-- BEGIN: data --><div class="table-responsive">    <div class="text-center clearfix">        <a class="btn btn-primary" href="{add_jobs}">{LANG.add_jobs}</a>        <div class="clearfix">&nbsp;</div>    </div>    <table class="table table-striped table-bordered table-hover">        <colgroup>            <col class="w100">            <col span="1">            <col span="2" class="w150">        </colgroup>        <thead>        <tr class="text-center">            <th>{LANG.order}</th>            <th>{LANG.title}</th>            <th>{LANG.description}</th>            <th>{LANG.status}</th>            <th>{LANG.feature}</th>        </tr>        </thead>        <tbody>        <!-- BEGIN: row -->        <tr>            <td class="text-center">                <select id="change_weight_{ROW.id}" onchange="nv_chang_weight('{ROW.id}', '{op}');" class="form-control">                    <!-- BEGIN: weight -->                    <option value="{WEIGHT.w}"{WEIGHT.selected}>{WEIGHT.w}</option>                    <!-- END: weight -->                </select></td>            <td>{ROW.title}</td>            <td>{ROW.description}</td>            <td class="text-center">                <select id="change_status_{ROW.id}" onchange="nv_chang_status('{ROW.id}', '{op}');" class="form-control">                    <!-- BEGIN: status -->                    <option value="{STATUS.key}"{STATUS.selected}>{STATUS.val}</option>                    <!-- END: status -->                </select></td>            <td class="text-center"><em class="fa fa-edit fa-lg">&nbsp;</em><a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp; <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="javascript:void(0);" onclick="nv_module_del({ROW.id}, '{op}', '{ROW.checkss}');">{GLANG.delete}</a></td>        </tr>        <!-- END: row -->        </tbody>    </table></div><!-- END: data --><!-- BEGIN: add --><!-- BEGIN: error --><div class="alert alert-danger">    {ERROR}</div><!-- END: error --><form action="{FORM_ACTION}" method="post" class="confirm-reload">    <input name="submit" type="hidden" value="1" />    <div class="row">        <div class="table-responsive">            <table class="table table-striped table-bordered table-hover">                <colgroup>                    <col class="w200" />                    <col />                </colgroup>                <tbody>                <tr>                    <td class="text-right"> {LANG.title} <sup class="required">(*)</sup></td>                    <td><input class="w300 form-control pull-left" type="text" value="{DATA.title}" name="title" id="idtitle" maxlength="250" />&nbsp</td>                </tr>                <tr>                    <td class="text-right">                        {LANG.description}                    </td>                    <td><textarea class="form-control" name="description">{DATA.description}</textarea></td>                </tr>                </tbody>            </table>        </div>    </div>    <div class="row text-center">        <input type="submit" value="{LANG.save}" class="btn btn-primary"/>    </div></form><!-- END: add --><!-- END: main -->