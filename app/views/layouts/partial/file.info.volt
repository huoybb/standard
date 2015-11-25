<div id="info">
    {% set format = ['url':'相关链接','updated_at_website':'更新时间'] %}
    {% for key,value in format %}
        <div class="row">
            <div class="col-md-2" align="right"><span>{{value}}</span>:</div>
            <div class="col-md-10"><span>{{ file.getHtml(key) }}</span></div>
        </div>
    {% endfor %}

    {% if file.getOaiDticMil() %}
        {% set format = [
            'Accession_Number':'序列号',
            'Descriptive_Note':'文档类型',
            'Corporate_Author':'单位',
            'Personal_Author':'作者',
            'Pagination_or_Media_Count':'页数',
            'Abstract':'摘要',
            'Descriptors':'描述分类',
            'Subject_Categories':'主题分类'
        ] %}
        {% for key,value in format if file.getOaiDticMil().getHtml(key) %}
            <div class="row">
                <div class="col-md-2" align="right"><span>{{value}}</span>:</div>
                <div class="col-md-10"><span>{{ file.getOaiDticMil().getHtml(key) }}</span></div>
            </div>
        {% endfor %}
    {% endif %}

    {% if file.tags().count() %}
        <div class="row">
            <div class="col-md-2" align="right"><span><a href="{{ url(['for':'standards.showTags','file':file.id]) }}">标签</a></span>:</div>
            <div class="col-md-10">
                {% for item in file.tags() %}
                    <span><a href="{{ url(['for':'tags.show','tag':item.id]) }}">{{ item.name }}</a></span>
                {% endfor %}
            </div>
        </div>
    {% endif %}

    <div class="row">
        <div class="col-md-2" align="right"><span>操作</span>:</div>
        <div class="col-md-10">
            <span><a href="{{ url(['for':'standards.edit','file':file.id]) }}">修改</a></span>
            <span><a href="{{ url(['for':'standards.delete','file':file.id]) }}">删除</a></span>
        </div>
    </div>
</div>