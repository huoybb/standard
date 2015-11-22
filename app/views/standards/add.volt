{% extends "index.volt" %}
{% block title %}
    新增标准
{% endblock %}

{% block content %}
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.edit.js"
            xmlns="http://www.w3.org/1999/html"></script>
    <div class="container">
        <p>{{ flash.output() }}</p>
        <h2>普通标准</h2>
        {{ form("method": "post",'id':'add') }}
        {% for item in form.fields %}
            <div class="form-group">
                {{ item }}:{{ form.render(item,['class':'form-control']) }}<br/>
            </div>

        {% endfor %}
        <div class="form-group">
            {{ form.render('增加',['class':'btn btn-primary form-control']) }}
        </div>
        {{ endform() }}
        <h2>DoD的标准</h2>
        {{ form('method':'post','action':url('standards/addDoD')) }}
        <label for="file_id">文件名</label>
        <div class="form-group">
            {{ text_field("file_id", "size": 32,'class':'form-control') }}
        </div>
        <div class="form-group">
            {{ submit_button('增加','class':'btn btn-primary form-control') }}
        </div>

        {{ endform() }}

    </div>

{% endblock %}

{% block footer %}
    <div class="container">
        <div class="row">
            <?php echo xdebug_time_index();?>
        </div>
    </div>
{% endblock %}