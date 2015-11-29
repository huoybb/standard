{% extends 'index.volt' %}

{% block title %}
    链接：{{ file.title }}
{% endblock %}
{% block content %}
    <div class="container">
        <h1>链接：<a href="{{ url(['for':'standards.show','file':file.id]) }}">{{ file.title }}</a><span class="badge">{{ file.getLinks().count() }}</span></h1>
        <p>该文件的链接显示如下：</p>

        <div class="row">

            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>链接</th>
                    <th>添加时间</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for item in file.getLinks() %}
                    <tr>
                        <td>{{item.id}}</td>
                        <td><a href="{{ item.url }}">{{ item.getSiteName() }}</a></td>
                        <td>{{ item.updated_at }}</td>
                        <td><span><a href="#" ><div align="center">修改</div></a></span></td>
                        <td><span><a href="{{ url(['for':'standards.deleteLink','file':file.id,'link':item.id]) }}" ><div align="center">删除</div></a></span></td>
                    </tr>
                {% endfor %}
            </table>

        </div>
{% endblock %}
