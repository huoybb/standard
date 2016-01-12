{{ form(url(['for':'tags.addLink','tag':mytag.id]), "method": "post","id":"addLink-form") }}

<!--content Form Input-->
<div class="form-group">
    <label for="addLink">添加链接：</label>
    {{ text_field("link",'class':'form-control') }}

</div>

<!--Comment Form Submit Button-->
<div class="form-group">
    {{ submit_button('添加','class':'btn btn-primary form-control') }}
</div>
{{ endform() }}