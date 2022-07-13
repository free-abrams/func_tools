<?php


namespace FreeAbrams\FuncTools\Handlers\File;

/**
 * Created By FreeAbrams
 * Date: 2022/7/11
 */
class BaseFile
{
	public function saveAs()
    {

    }

    __tostring()
    {
        $arr = [];
        foreach($this as $k => $v){
            $arr[$k] = $v;
        }
        return $arr;
    }
}