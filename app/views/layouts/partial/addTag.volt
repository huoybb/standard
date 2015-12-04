{{ form(url(['for':'standards.addTag','file':file.id]), "method": "post","id":"tag-form") }}

<!--content Form Input-->
<div class="form-group">
    <label for="tagName">添加标签：</label>
    {{ text_field("tagName",'class':'form-control') }}

</div>

<!--Comment Form Submit Button-->
<div class="form-group">
    {{ submit_button('添加','class':'btn btn-primary form-control') }}
</div>
<div class="form-group">
    {#<?php foreach($this->allTags as $mytag){?>#}
    {% for mytag in this.allTags %}
        <span><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a>({{ mytag.taggableCount }})</span>
    {% endfor %}
    {#<?php }?>#}
</div>
{{ endform() }}