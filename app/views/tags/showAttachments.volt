{% extends 'index.volt' %}

{% block title %}
    附件：{{ mytag.name }}
{% endblock %}
{% block content %}
    <div class="container">
        <h1>附件：<a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a><span class="badge">{{ mytag.attachmentCount }}</span></h1>
        <p>标准列表显示如下：</p>

        <div class="row">
            {% for attachment in mytag.attachments() %}
                <table width="100%" border="1" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td bgcolor="#FFFF33">id</td>
                        <td bgcolor="#FFFF33"><div align="center">文件下载</div></td>
                        <td bgcolor="#FFFF33"><div align="center">说明</div></td>
                        <td bgcolor="#FFFF33"><div align="center">上传时间</div></td>
                        <td bgcolor="#FFFF33">在线浏览</td>
                        <td bgcolor="#FFFF33">操作</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><a href="#" title="修改归属" target="_blank">{{ attachment.id }}</a></td>
                        <td><a href="{{ url.getBaseUri() }}{{ attachment.url }}" target="_blank">下载</a></td>
                        <td>{{ attachment.name }}</td>
                        <td>{{ attachment.getLastEditTime().diffForHumans() }}</td>
                        <td><a href="{{ attachment.getBaiduURL() }}" target="_blank">百度云</a></td>
                        <td rowspan="2"><a href="{{ url(['for':'tags.deleteAttachment','tag':mytag.id,'attachment':attachment.id]) }}">删除</a></td>
                    </tr>
                    <tr>
                        <td colspan="3">{{ attachment.url | basename }}</td><td>{{ attachment.getFileSize() | formatSizeUnits}}</td>
                    </tr>
                    </tbody>
                </table>
            {% endfor %}

        </div>
{% endblock %}