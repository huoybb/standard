<div class="col-md-2">
    {{ form(url(['for':'standards.addRevisionsTo','file':file.id,'file2':'']), "method": "post","id":"addRev-form") }}

    <!--content Form Input-->
    <div class="form-group">
        <label for="addRev">关联版本：</label>
        {{ text_field("addRev",'class':'form-control') }}

    </div>

    <!--Comment Form Submit Button-->
    <div class="form-group">
        {{ submit_button('添加','class':'btn btn-primary form-control') }}
    </div>
    {{ endform() }}


</div>