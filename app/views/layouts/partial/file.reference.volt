{% if file.getReferences().count() %}
    <hr>
    <div id="revisions">
        <h2>Reference</h2>
        <table class="table table-hover table-condensed">
            <tr>
                <th>#</th>
                <th>标准号</th>
                <th>名称</th>
                <th>更新时间</th>
            </tr>
            {% for item in file.getReferences() %}
                <tr>
                    <td>{{item.id}}</td>
                    <td>{{item.standard_number}}</td>
                    <td><a href="{{ url(['for':'standards.show','file':item.id]) }}">{{ item.title|cut }}</a></td>
                    <td>{{ item.updated_at_website }}</td>
                </tr>
            {% endfor %}
        </table>
    </div>
{% endif %}