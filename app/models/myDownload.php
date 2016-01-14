<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/15
 * Time: 7:17
 */
class myDownload
{

    public function createZipFile($data, $filename)
    {
        $files = Attachments::query()
            ->inWhere('attachable_id',$data['file_id'])
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
            $zip->addFromString($row->file->title.'/info.json',json_encode($row->file->toArray()));//@todo 将来用能够代表文档的数据形式来替代
        }
        $zip->close();
        return $filename;
    }

    public function getAndDeleteZipFile($filename)
    {
        header ( "Cache-Control: max-age=0" );
        header ( "Content-Description: File Transfer" );
        header ( 'Content-disposition: attachment; filename=' . basename ( $filename ) ); // 文件名
        header ( "Content-Type: application/zip" ); // zip格式的
        header ( "Content-Transfer-Encoding: binary" ); // 告诉浏览器，这是二进制文件
        header ( 'Content-Length: ' . filesize ( $filename ) ); // 告诉浏览器，文件大小
        @readfile ( $filename );//输出文件;这里遇到超大文件则会出现问题
        unlink($filename);
    }
}