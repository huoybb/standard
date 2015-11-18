{% extends 'index.volt' %}

{% block title %}
    我的标准库-搜索页
{% endblock %}
{% block content %}
<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.delete.js"></script>

    <div class="container">
        <h1>搜索关键词：{{ search }}<span class="badge">{{ page.total_items }}</span></h1>
        <p>标准列表显示如下：</p>

        <div class="row">
        <div class="col-md-10">
            {% if page.total_items > page.limit %}
                <nav>
                    <ul class="pager">
                        <li class="previous"><a href="{{ url.get(['for':'standards.search','search':search,'page':page.before]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                        <li class="next"><a href="{{ url.get(['for':'standards.search','search':search,'page':page.next]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </nav>
            {% endif %}
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>标准</th>
                    <th>更新时间</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for key,item in page.items %}
                    <tr>
                        <td>{{item.id}}</td>
                        <td><a href="{{ url(['for':'standards.showSearchItem','search':search,'item':key+1+page.limit*(page.current-1)]) }}">{{ item.title }}</a></td>
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