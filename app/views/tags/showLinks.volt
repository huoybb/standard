{% extends 'index.volt' %}

{% block title %}
    链接：{{ mytag.name }}
{% endblock %}
{% block content %}
    <div class="container">
        <h1>链接：<a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a><span class="badge">{{ mytag.linkCount }}</span></h1>
        <p>该标签下的链接显示如下：</p>

        <div class="row">

            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>链接</th>
                    <th>添加时间</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for item in mytag.getLinks() %}
                    <tr>
                        <td>{{item.id}}</td>
                        <td><a href="{{ item.url }}" target="_blank">链接</a></td>
                        <td>{{ item.updated_at }}</td>
                        <td><span><a href="#" ><div align="center">修改</div></a></span></td>
                        <td><span><a href="{{ url(['for':'tags.deleteLink','tag':mytag.id,'link':item.id]) }}" ><div align="center">删除</div></a></span></td>
                    </tr>
                {% endfor %}
            </table>

        </div>
{% endblock %}

{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}