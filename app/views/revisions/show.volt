{% extends 'index.volt' %}

{% block title %}
    版本：{{ rev.name }}
{% endblock %}
{% block content %}
    <div class="container">
        <h1>标准版本：{{ rev.name }}<span class="badge">{{ rev.getAllRevisions().count() }}</span></h1>
        <p>版本列表显示如下：</p>

        <div class="row">

            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for item in rev.getAllRevisions() %}
                    <tr>
                        <td>{{item.revisions.id}}</td>
                        <td><a href="{{ url(['for':'standards.show','file':item.file.id]) }}">{{ item.file.title }}</a></td>
                        <td><span><a href="#" ><div align="center">修改</div></a></span></td>
                        <td><span><a href="{{ url(['for':'revisions.delete','rev':item.revisions.id]) }}" ><div align="center">删除</div></a></span></td>
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