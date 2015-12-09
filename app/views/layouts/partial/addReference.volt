{{ form(url(['for':'standards.addReference','file':file.id,'file2':'']), "method": "post","id":"addReference-form") }}

<!--content Form Input-->
<div class="form-group">
    <label for="addReference">增加引用文档：</label>
    {{ text_field("addReference",'class':'form-control') }}

</div>

<!--Comment Form Submit Button-->
<div class="form-group">
    {{ submit_button('添加','class':'btn btn-primary form-control') }}
</div>
{{ endform() }}