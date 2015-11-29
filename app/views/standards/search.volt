{% extends 'index.volt' %}

{% block title %}
    我的标准库-搜索页
{% endblock %}
{% block content %}
<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.delete.js"></script>
<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.search.selectFiles.js"></script>

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

            {{ form(url(['for':'standards.list.addTag']), "method": "post","id":"list-tag-form","class":'form-inline') }}
            <table class="table table-hover">
                <tr>
                    <th><input type="checkbox" id="fileSelect" ></th>
                    <th>#</th>
                    <th>标准</th>
                    <th>更新时间</th>
                    <th colspan="2"><div align="center">操作</div></th>
                </tr>
                {% for key,item in page.items %}
                    <tr>
                        <th><input name="file_id[]" type="checkbox" value="{{ item.id }}" class="file_id"></th>
                        <td>{{item.id}}</td>
                        <td><a href="{{ url(['for':'standards.showSearchItem','search':search,'item':key+1+page.limit*(page.current-1)]) }}">{{ item.title }}</a></td>
                        <td>{{ item.updated_at_website }}</td>
                        <td><span><a href="{{ url(['for':'standards.edit','file':item.id]) }}" ><div align="center">修改</div></a></span></td>
                        <td><span><a href="{{ url(['for':'standards.delete','file':item.id]) }}" class="delete" ><div align="center">删除</div></a></span></td>
                    </tr>
                {% endfor %}
            </table>
            <div class="form-group">
                <label for="tagName">标签</label>
                <input type="text" class="form-control" id="tagName" name="tagName" value="{{ search }}">
            </div>
            <button type="submit" class="btn btn-default">添加标签</button>
            {{ endform() }}

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