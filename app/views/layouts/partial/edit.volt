<script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/standards.edit.js"></script>
<div class="container">
    <p>{{ flash.output() }}</p>
    {{ form("method": "post",'id':'edit') }}
    {% for item in form.fields %}
        <div class="form-group">
            {{ item }}:{{ form.render(item,['class':'form-control']) }}<br/>
        </div>

    {% endfor %}
    <div class="form-group">
        {{ form.render('修改',['class':'btn btn-primary form-control']) }}
    </div>
    {{ endform() }}

</div>