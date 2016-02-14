{% extends 'index.volt' %}

{% block content %}
<div class="container">
{{ form(url(['for':'standards.list.addTag']), "method": "post","id":"list-tag-form","class":'form-inline') }}
    <table class="table table-hover table-layout:fixed">
        <tr>
            <th><input width="2%" type="checkbox" id="fileSelect" ></th>
            <th>#</th>
            <th>名称</th>
            <th>文档</th>
            <th>附件</th>
            <th>链接</th>
            <th>评论</th>
            <th>读过</th>
            <th colspan="2"><div align="center">操作</div></th>
        </tr>
        {% for key,item in files %}
            <tr>
                <td><input name="file_id[]" type="checkbox" value="{{ item.f.id }}" class="file_id"></td>
                <td>{{item.f.id}}</td>
                <td>
                    <div class="titleCSS">
                        {% if item.f.type %}
                            <span class="btn-danger">{{ item.f.type }}</span>
                        {% endif %}
                        <a title="{{ item.f.title }}" href="#">{{ item.f.title }}</a>
                    </div>
                </td>
                <td>{{ item.f.updated_at_website | date }}</td>
                <td>{{ item.f.getHtml('attachmentCount') }}</td>
                <td>{{ item.f.getHtml('linkCount') }}</td>
                <td>{{ item.f.getHtml('commentCount') }}</td>
                <td>{{ item.r.created_at }}</td>
                <td><span><a href="#" ><div align="center">想读</div></a></span></td>
                <td><span><a href="#" ><div align="center">在读</div></a></span></td>
            </tr>
        {% endfor %}
    </table>
    {{ endform() }}
</div>
{% endblock %}

