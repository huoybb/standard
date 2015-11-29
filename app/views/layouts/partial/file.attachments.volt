<hr>
{% if file.attachments().count() %}
    <h2><a href="{{ url(['for':'standards.showAttachments','file':file.id]) }}">Attachments</a></h2>
    <div id="attachments">
        {% for attachment in file.attachments() %}
            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td bgcolor="#FFFF33">id</td>
                    <td bgcolor="#FFFF33"><div align="center">文件下载</div></td>
                    <td bgcolor="#FFFF33"><div align="center">说明</div></td>
                    <td bgcolor="#FFFF33"><div align="center">上传时间</div></td>
                    <td bgcolor="#FFFF33">在线浏览</td>
                </tr>
                <tr>
                    <td rowspan="2"><a href="#" title="修改归属" target="_blank">{{ attachment.id }}</a></td>
                    <td><a href="{{ url.getBaseUri() }}{{ attachment.url }}" target="_blank">下载</a></td>
                    <td>{{ attachment.name }}</td>
                    <td>{{ attachment.updated_at.diffForHumans() }}</td>
                    <td><a href="{{ attachment.getBaiduURL() }}" target="_blank">百度云</a></td>
                </tr>
                <tr>
                    <td colspan="3">{{ attachment.url | basename }}</td><td>{{ attachment.getFileSize() | formatSizeUnits}}</td>
                </tr>
                </tbody></table>
        {% endfor %}
    </div>
{% endif %}
<div class="fileUpload" id="fileUpload">
    <form action="{{ url(['for':'standards.addAttachment','file':file.id]) }}"
          id="my-awesome-dropzone">
        文件上传:<br>请将文件拖拽到这里
    </form>
</div>