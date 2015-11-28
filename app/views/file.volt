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
        <script language="JavaScript" type="text/javascript" src="{{ url.getBaseUri() }}js/showFile.js"></script>
	</head>
	<body>
        {% include "layouts/header.volt" %}

            <div class="container">
                {% block breadcrumb %}{% endblock %}
                <p>{{ flash.output() }}</p>
                <h2>{{ file.getFileType() }}:<a href="{{ url(['for':'standards.show','file':file.id]) }}">{{ file.title }}</a></h2>
                <div class="col-md-10">
                    {% include 'layouts/partial/file.info.volt' %}

                    {% block nav %}{% endblock %}

                    {% include 'layouts/partial/file.revision.volt' %}
                    {% include 'layouts/partial/file.attachments.volt' %}

                    {% include 'layouts/partial/commentListForFile.volt' %}
                    {% include 'layouts/partial/commentForm.volt' %}
                </div>
                <div class="col-md-2">
                    {% include 'layouts/partial/addRevisionFile.volt' %}
                    {% include 'layouts/partial/addTag.volt' %}
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
