{{ content() }}
<!DOCTYPE html>
<html>
	<head>
		<title>
            {% block title %}
                {{ file.getFileType() }}：{{ file.title }}
            {% endblock %}
        </title>
        <link rel="stylesheet" href="{{ url.getBaseUri() }}css/app.css">
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/jquery-2.1.4.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/keymaster.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/dropzone.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/my.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/file.js"></script>
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/manipulateRelationMap.js"></script>
	</head>
	<body>
        {% include "layouts/header.volt" %}

            <div class="container">
                {% block breadcrumb %}{% endblock %}
                <p>{{ flash.output() }}</p>

                <h1>{{ file.present().repository }}<a href="{{ url(['for':'standards.show','file':file.id]) }}">{{ file.present().title }}</a></h1>
                <div class="col-md-10">
                    {{ startMeasure('s1','正文加载') }}
                    {{ startMeasure('s1-1','加载文件信息') }}
                    {% include 'layouts/partial/file.info.volt' %}
                    {{ stopMeasure('s1-1') }}

                    {% block nav %}{% endblock %}

                    {#{% include 'layouts/partial/file.reference.volt' %}#}
                    {#{% include 'layouts/partial/file.citation.volt' %}#}
                    {{ startMeasure('s1-2','版本加载') }}
                    {% include 'layouts/partial/file.revision.volt' %}
                    {{ stopMeasure('s1-2') }}
                    {{ startMeasure('s1-3','附件加载') }}
                    {% include 'layouts/partial/file.attachments.volt' %}
                    {{ stopMeasure('s1-3') }}
                    {{ startMeasure('s1-4','评论加载') }}
                    {% include 'layouts/partial/commentListForFile.volt' %}
                    {% block otherCommentList %}{% endblock %}
                    {{ stopMeasure('s1-4') }}
                    {% include 'layouts/partial/commentForm.volt' %}
                    {% include 'layouts/partial/file.citeRelation.volt' %}
                    {{ stopMeasure('s1') }}
                </div>
                <div class="col-md-2">
                    {{ startMeasure('s2','sidebar加载') }}
                    {% include 'layouts/partial/file.addLink.volt' %}
                    {% include 'layouts/partial/file.addReference.volt' %}
                    {% include 'layouts/partial/addRevisionFile.volt' %}
                    {{ startMeasure('s2-1','标签加载') }}
                    {% include 'layouts/partial/addTag.volt' %}
                    {{ stopMeasure('s2-1') }}
                    {{ stopMeasure('s2') }}
                </div>
            </div>
        {% block footer %}
            <div class="container">
                <div class="row">
                    <?php echo xdebug_time_index();?>
                </div>
            </div>
        {% endblock %}
    </body>
</html>
