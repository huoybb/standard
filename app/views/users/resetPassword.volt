{% extends "index.volt" %}
{% block title %}
    密码重置
{% endblock %}

{% block content %}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">密码重置</div>
                <div class="panel-body">
                    {{ flash.output() }}
                    {{ form("method": "post","class":"form-horizontal","role":"form") }}


                    <div class="form-group">
                        <label class="col-md-4 control-label">输入密码</label>
                        <div class="col-md-6">
                            {{ form.render('password1',['class':"form-control"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">重新输入密码</label>
                        <div class="col-md-6">
                            {{ form.render('password2',['class':"form-control"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ form.render('reset',['class':"btn btn-primary"]) }}
                        </div>
                    </div>

                    {{ endform() }}
                </div>
            </div>
        </div>
    </div>

{% endblock %}
