{% extends 'index.volt' %}

{% block title %}
    附件：{{ file.title }}
{% endblock %}
{% block content %}
    <div class="container">
        <h1>附件：<a href="{{ url(['for':'standards.show','file':file.id]) }}">{{ file.title }}</a><span class="badge">{{ file.attachments().count() }}</span></h1>
        <p>标准列表显示如下：</p>

        <div class="row">

            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>附件</th>
                    <th>说明</th>
                    <th>更新时间</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for item in file.attachments() %}
                    <tr>
                        <td>{{item.id}}</td>
                        <td><a href="#">{{ item.name }}</a></td>
                        <td><a href="#">{{ item.description }}</a></td>
                        <td>{{ item.updated_at }}</td>
                        <td><span><a href="{{ url(['for':'standards.editAttachment','attachment':item.id,'file':file.id]) }}" ><div align="center">修改</div></a></span></td>
                        <td><span><a href="{{ url(['for':'standards.deleteAttachment','attachment':item.id,'file':file.id]) }}" ><div align="center">删除</div></a></span></td>
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