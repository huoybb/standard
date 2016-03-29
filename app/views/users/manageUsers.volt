{% extends "index.volt" %}
{% block title %}
    用户管理
{% endblock %}

{% block content %}

    <div class="container">
        <div>创建新用户：<a href="{{ url(['for':'users.createNewUser']) }}">创建</a></div>
        <div class="row">
            <table class="table table-hover table-layout:fixed">
                <tr>
                    <td>#</td>
                    <td>姓名</td>
                    <td>邮件</td>
                    <td>创建时间</td>
                    <td>角色</td>
                    <td>状态</td>
                    <td colspan="3"><span>操作</span></td>
                </tr>
                {% for user in users %}
                <tr>
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>{{ user.role }}</td>
                    <td>{{ user.accountStatus }}</td>
                    <td><a href="{{ url(['for':'users.deleteUser','user':user.id]) }}">删除</a></td>
                    <td><a href="#">锁死</a></td>
                    <td><a href="{{ url(['for':'users.sendPasswordResetEmail','user':user.id]) }}">发送密码重置邮件</a></td>
                </tr>
                {% endfor %}
            </table>
        </div>
    </div>

{% endblock %}
