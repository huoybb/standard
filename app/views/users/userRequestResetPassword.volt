{% extends "index.volt" %}
{% block title %}
    申请密码重置
{% endblock %}

{% block content %}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">输入注册时的邮件地址，并查收邮件！</div>
                <div class="panel-body">
                    {{ flash.output() }}
                    {{ form("method": "post","class":"form-horizontal","role":"form") }}
                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            {{ form.render('email',['class':"form-control"]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ form.render('提交',['class':"btn btn-primary"]) }}
                        </div>
                    </div>

                    {{ endform() }}
                </div>
            </div>
        </div>
    </div>

{% endblock %}
