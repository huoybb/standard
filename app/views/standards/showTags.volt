{% extends 'index.volt' %}

{% block title %}
    标签：{{ file.title }}
{% endblock %}
{% block content %}
    <div class="container">
        <h1>标签：<a href="{{ url(['for':'standards.show','file':file.id]) }}">{{ file.title }}</a><span class="badge">{{ file.attachments().count() }}</span></h1>
        <p>该文件的标签显示如下：</p>

        <div class="row">

            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>标签</th>
                    <th>打签时间</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for item in file.tags() %}
                    <tr>
                        <td>{{item.id}}</td>
                        <td><a href="#">{{ item.name }}</a></td>
                        <td>{{ item.updated_at }}</td>
                        <td><span><a href="#" ><div align="center">修改</div></a></span></td>
                        <td><span><a href="{{ url(['for':'standards.deleteTag','file':file.id,'taggable':item.tid]) }}" ><div align="center">删除</div></a></span></td>
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