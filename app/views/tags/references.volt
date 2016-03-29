{% extends "index.volt" %}
{% block title %}
    标签的参考主题
{% endblock %}

{% block content %}

    <div class="container">
        <h1>标签：<a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a></h1>
        <h2>参考文档</h2>
        <div class="row">
            <table class="table table-hover table-layout:fixed">
                <tr>
                    <td>#</td>
                    <td>标签主题</td>
                    <td>创建时间</td>
                    <td>删除</td>
                </tr>
                {% for ref in references %}
                <tr>
                    <td>{{ ref.id }}</td>
                    <td><a href="{{ url(['for':'tags.show','tag':ref.id]) }}">{{ ref.name }}</a></td>
                    <td>{{ ref.created_at }}</td>
                    <td><a href="{{ url(['for':'tags.deleteReference','tag':mytag.id,'reference':ref.id]) }}">删除</a></td>
                </tr>
                {% endfor %}

            </table>
        </div>
    </div>

{% endblock %}
