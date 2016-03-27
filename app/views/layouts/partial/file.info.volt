<div id="info">
    {% if file.getFileable() %}

        {% for key,value in file.getFileable().format() if file.getFileable().getHtml(key) %}
            <div class="row">
                <div class="col-md-2" align="right"><span>{{value}}</span>:</div>
                <div class="col-md-10">{{ file.getFileable().getHtml(key) }}</div>
            </div>
        {% endfor %}
    {% endif %}
    {% if file.myTags().count() %}
        <div class="row">
            <div class="col-md-2" align="right"><span><a href="{{ url(['for':'standards.showTags','file':file.id]) }}">我的标签</a></span>:</div>
            <div class="col-md-10">
                {% for item in file.myTags() %}
                    <span><a href="{{ url(['for':'tags.show','tag':item.id]) }}">{{ item.name }}</a></span>
                {% endfor %}
            </div>
        </div>
    {% endif %}
    <div class="row">
        <div class="col-md-2" align="right"><span><a href="{{ url(['for':'standards.showLinks','file':file.id]) }}">相关链接</a></span>:</div>
        <div class="col-md-10">
            <span>{{ file.getHtml('url') }}</span>
            {% for link in file.getLinks() %}
                <span><a href="{{ link.url }}" target="_blank">{{ link.getSiteName() }}</a></span>
            {% endfor %}
        </div>
    </div>

    {% set format = ['updated_at_website':'更新时间'] %}
    {% for key,value in format if file.getHtml(key) %}
        <div class="row">
            <div class="col-md-2" align="right"><span>{{value}}</span>:</div>
            <div class="col-md-10"><span>{{ file.getHtml(key) }}</span></div>
        </div>
    {% endfor %}


    <div class="row">
        <div class="col-md-2" align="right"><span>操作</span>:</div>
        <div class="col-md-10">
            <span><a href="{{ url(['for':'standards.updateFromWeb','file':file.id]) }}">更新</a></span>
            <span><a href="{{ url(['for':'standards.edit','file':file.id]) }}">修改</a></span>
            <span><a href="{{ url(['for':'standards.delete','file':file.id]) }}">删除</a></span>

            {% if not auth.isSubscribedTo(file) %}
                <a href="{{ url(['for':'standards.subscribe','file':file.id]) }}">关注</a>
            {% else %}
                <a href="{{ url(['for':'standards.unsubscribe','file':file.id]) }}">取消关注</a>
            {% endif %}
        </div>
    </div>
    <div class="row">
        <div class="col-md-2" align="right"><span><a href="{{ url(['for':'standards.readinglog','file':file.id]) }}">阅读记录</a></span>:</div>
        <div class="col-md-10">
                <span class="readingStatus">{{ auth.getReadingStatusFor(file) }}</span>
                <span><a class="reading" href="{{ url(['for':'reading.want','file':file.id]) }}">想读</a></span>
                <span><a class="reading" href="{{ url(['for':'reading.reading','file':file.id]) }}">在读</a></span>
                <span><a class="reading" href="{{ url(['for':'reading.done','file':file.id]) }}">读过</a></span>
        </div>
    </div>
    {% if file.tags().count() %}
        <div class="row">
            <div class="col-md-2" align="right"><span><a href="{{ url(['for':'standards.showTags','file':file.id]) }}">成员标签</a></span>:</div>
            <div class="col-md-10">
                {% for item in file.tags() %}
                    <span><a href="{{ url(['for':'tags.show','tag':item.id]) }}">{{ item.name }}</a>({{ item.Count }})</span>
                {% endfor %}
            </div>
        </div>
    {% endif %}
</div>