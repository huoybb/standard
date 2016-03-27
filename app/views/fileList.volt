{{ content() }}

<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="{{ url.getBaseUri() }}css/app.css">
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/jquery-2.1.4.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/keymaster.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/dropzone.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/my.js"></script>
    <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/maniputateFileList.js"></script>
</head>
<body>
    {{ startMeasure('s1','页头加载') }}
    {% include "layouts/header.volt" %}
    {{ stopMeasure('s1') }}

    {{ startMeasure('s2','内容加载') }}
    <div class="container">
        {{ startMeasure('s2-1','页面头内容') }}
        {% block breadcrumb %}{% endblock %}
        {% block listTitle %}{% endblock %}
        {{ stopMeasure('s2-1') }}
        <div class="row">
            {{ startMeasure('s2-2','页面主内容') }}
            <div class="col-md-10">
                {{ flash.output() }}
                {% block listInfo %}{% endblock %}
                {% block nav %}{% endblock %}
                {% block content %}{% endblock %}
                {% block comments %}{% endblock %}
            </div>
            {{ stopMeasure('s2-2') }}
            {{ startMeasure('s2-3','sidebar加载') }}
            <div class="col-md-2">
                {% block sidebar %}
                    {% include "layouts/partial/allTagList.volt" %}
                {% endblock %}
            </div>
            {{ stopMeasure('s2-3') }}
        </div>
    </div>
    {{ stopMeasure('s2') }}
    {{ startMeasure('s3','页尾加载') }}
    {% block footer %}
        <div class="container">
            <div class="row">
                <?php echo xdebug_time_index();?>
            </div>
        </div>
    {% endblock %}
    {{ stopMeasure('s3') }}
</body>
</html>