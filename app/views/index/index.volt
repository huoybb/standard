{% extends 'index.volt' %}

{% block title %}
    我的标准库-首页
{% endblock %}

{% block content %}
<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.delete.js"></script>
    <div class="container">
        <h1>标准汇总<span class="badge">{{ page.total_items }}</span></h1>
        <p>标准列表显示如下：</p>
        <div class="row">
            <div class="col-md-10">
                {% if page.total_items > page.limit %}
                    <nav>
                        <ul class="pager">
                            <li class="previous"><a href="{{ url.get(['for':'index','page':page.before]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                            <li class="next"><a href="{{ url.get(['for':'index','page':page.next]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>
                {% endif %}
                <table class="table table-hover table-layout:fixed">
                    <tr>
                        <th width="10%">#</th>
                        <th width="65%">标准</th>
                        <th width="15">更新时间</th>
                        <th colspan="2" width="10%"><div align="center">操作</div></th>
                    </tr>
                    {% for item in page.items %}
                        <tr>
                            <td>{{item.id}}</td>
                            <td><a href="{{ url(['for':'standards.show','file':item.id]) }}">{{ item.title }}</a></td>
                            <td>{{ item.updated_at_website }}</td>
                            <td><span><a href="{{ url(['for':'standards.edit','file':item.id]) }}" ><div align="center">修改</div></a></span></td>
                            <td><span><a href="{{ url(['for':'standards.delete','file':item.id]) }}" class="delete" ><div align="center">删除</div></a></span></td>
                        </tr>
                    {% endfor %}
                </table>

            </div>
            <div class="col-md-2">
            <h2>标签</h2>
            <?php foreach($this->allTags as $mytag){?>
            {#{% for mytag in allTags %}#}
                <span><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a>({{ mytag.tagCounts() }})</span>
            {#{% endfor %}#}
            <?php }?>
            </div>
    </div>
{% endblock %}

{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}