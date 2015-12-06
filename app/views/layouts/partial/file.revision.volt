{% if file.getRevision() %}
    <hr>
    <div id="revisions">
        <h2><a href="{{ url(['for':'revisions.show','rev':file.getRevision().id]) }}">Revisions</a></h2>
        <table class="table table-hover table-condensed">
            <tr>
                <th>#</th>
                <th>标准号</th>
                <th>名称</th>
                <th>更新时间</th>
            </tr>
            {% for item in file.getRevision().getAllRevisions() %}
                <tr>
                    <td>{{item.file.id}}</td>
                    <td>{{item.file.standard_number}}</td>
                    <td><a href="{{ url(['for':'standards.show','file':item.file.id]) }}">{{ item.file.title|cut }}</a></td>
                    <td>{{ item.file.updated_at_website }}</td>
                </tr>
            {% endfor %}
        </table>
    </div>
{% endif %}