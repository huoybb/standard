<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/15
 * Time: 7:17
 */
class myDownload
{

    public function createZipFile(array $file_Ids, $filename)
    {
        $files = Attachments::query()
            ->inWhere('attachable_id',$file_Ids)
            ->andWhere('attachable_type =:type:',['type'=>'Files'])
            ->leftJoin('Files','file.id = Attachments.attachable_id','file')
            ->columns(['Attachments.*','file.*'])
            ->execute();
        $path = 'E:\php\standard\public/';
        $zip = new ZipArchive();
        if($zip->open($path.$filename,ZIPARCHIVE::CREATE) !== TRUE){
            dd('无法生成ZIP文件，请检查是否具有写权限');
        }
        foreach($files as $row){
            $zip->addFile($path.$row->attachments->url,$row->file->title.'/'.$row->attachments->name);
            $zip->addFromString($row->file->title.'/info.txt',$this->getFileInfo($row->file));//@todo 将来用能够代表文档的数据形式来替代
        }
        $zip->close();
        return $filename;
    }

    public function getFileInfo(Files $file)
    {
        $result = '';
        $result .= '文档:'.$file->title.PHP_EOL;
        $result .= '网址:'.$file->url.PHP_EOL;
        return $result;
    }


    /*
     * @param $filename
     */
    public function getAndDeleteZipFile($filename)
    {
        $this->downloadFile($filename);
        unlink($filename);
    }

    public function downloadFile($filename,$showName = null)
    {
        set_time_limit(0);//避免超时？
        $file_size = filesize ( $filename );
        header ( "Cache-Control: max-age=0" );
        header ( "Content-Description: File Transfer" );
        if(null == $showName) $showName = basename ( $filename ) ;
        header ( 'Content-disposition: attachment; filename=' . $showName ); // 文件名
        if (preg_match('/.zip$/m', $filename)) header ( "Content-Type: application/zip" ); // zip格式的
        header ( 'Content-Length: ' . $file_size ); // 告诉浏览器，文件大小

        //下面的两条是下载大文件的关键所在
        ob_clean();
        ob_end_flush();

        //下面的这种用法对比readfile好好很多
        $handle = fopen($filename, "rb");
        while (!feof($handle)) {
            echo fread($handle, 1000);
        }
    }

}