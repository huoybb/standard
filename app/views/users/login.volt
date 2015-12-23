{% extends "index.volt" %}
{% block title %}
    登录页面
{% endblock %}

{% block content %}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
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
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                {{ form.render('password',['class':"form-control"]) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        {{ form.render('remember') }} Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ form.render('Login',['class':"btn btn-primary"]) }}
                                <a class="btn btn-link" href="#">Forgot Your Password?</a>
                            </div>
                        </div>
                    {{ endform() }}
                </div>
            </div>
        </div>
    </div>

{% endblock %}
