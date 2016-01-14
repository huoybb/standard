<div class="form-group">
    <label for="tagName">标签</label>
    <input type="text" class="form-control" id="tagName" name="tagName" value="{{ search }}">
</div>
<button type="submit" class="btn btn-default">添加标签</button>
<a  id="combineRevisions" href="#" class="btn btn-default">合并版本</a>
<a  id="downloadAttachments" href="{{ url(['for':'standards.downloadAttachment']) }}" class="btn btn-default">下载附件</a>
<a  id="deleteItems" href="#" class="btn btn-danger">删除选中条目</a>
