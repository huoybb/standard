{% extends 'fileList.volt' %}

{% block title %}
    我的标准库-搜索页
{% endblock %}

{% block listTitle %}
    <h1>搜索关键词：{{ search }}<span class="badge">{{ page.total_items }}</span></h1>
{% endblock %}

{% block listInfo %}

    <p>标准列表显示如下：</p>
{% endblock %}
{% block nav %}
    <div><span class="label label-primary">共计{{ page.total_items }}条标准</span>--<span class="label label-primary">第{{ page.current }}页/总{{ page.total_pages }}页</span></div>
    {% if page.total_items > page.limit %}
        <nav>
            <ul class="pager">
                <li class="previous"><a href="{{ url.get(['for':'standards.search','search':search,'page':page.before]) }}"><span aria-hidden="true">&larr;</span> 上一页</a></li>
                <li class="next"><a href="{{ url.get(['for':'standards.search','search':search,'page':page.next]) }}">下一页 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    {% endif %}
{% endblock %}
{% block content %}
    {{ form(url(['for':'standards.list.addTag']), "method": "post","id":"list-tag-form","class":'form-inline') }}
        <table class="table table-hover">
            <tr>
                <th><input type="checkbox" id="fileSelect" ></th>
                <th>#</th>
                <th>标准</th>
                <th>更新时间</th>
                <th>评论</th>
                <th colspan="2" width="10%"><div align="center">操作</div></th>
            </tr>
            {% for key,item in page.items %}
                <tr>
                    <td><input name="file_id[]" type="checkbox" value="{{ item.id }}" class="file_id"></td>
                    <td>{{item.id}}</td>
                    <td><a title="{{ item.title }}" href="{{ url(['for':'standards.showSearchItem','search':search,'item':key+1+page.limit*(page.current-1)]) }}">{{ item.title | cut }}</a></td>
                    <td>{{ item.updated_at_website }}</td>
                    <td>{{ item.getHtml('commentCount') }}</td>
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
{% endblock %}
