{% if file.getRevision() %}
    <hr>
    <div id="revisions">
        <h2><a href="{{ url(['for':'revisions.show','rev':file.getRevision().id]) }}">Revisions</a></h2>
        <table class="table table-hover table-condensed">
            <tr>
                <th>#</th>
                <th>标准</th>
                <th>更新时间</th>
            </tr>
            {% for item in file.getRevision().getAllRevisions() %}
                <tr>
                    <td>{{item.id}}</td>
                    <td><a href="{{ url(['for':'standards.show','file':item.file_id]) }}">{{ item.name }}</a></td>
                    <td>--</td>
                </tr>
            {% endfor %}
        </table>
    </div>
{% endif %}