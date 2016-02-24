{% extends "index.volt" %}
{% block title %}
    创建新用户
{% endblock %}

{% block content %}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">创建新用户</div>
                <div class="panel-body">
                    {{ flash.output() }}
                    {{ form("method": "post","class":"form-horizontal","role":"form") }}
                    <div class="form-group">
                        <label class="col-md-4 control-label">用户名</label>
                        <div class="col-md-6">
                            {{ form.render('name',['class':"form-control"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">邮件地址</label>
                        <div class="col-md-6">
                            {{ form.render('email',['class':"form-control"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密码</label>
                        <div class="col-md-6">
                            {{ form.render('password',['class':"form-control"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">角色</label>
                        <div class="col-md-6">
                            {{ form.render('role',['class':"form-control"]) }}
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ form.render('创建',['class':"btn btn-primary"]) }}
                        </div>
                    </div>
                    {{ endform() }}
                </div>
            </div>
        </div>
    </div>

{% endblock %}
