<?php

    function getTreeSelect($rows, $tree = 0,$column = 'name') {
            $arrs = [];
            foreach ($rows as $key => $row){
                if($tree){
                    if($row->parent_id == 0 || $row->parent_id == Null) {
                        $arr['id'] = $row->id;
                        $arr['label'] = $row->$column;
                        $arr['children'] = '';
                        $child = getTreeChild($rows, $row->id, $column);
                        if($child){
                            $arr['children'] = $child;
                        }
                        array_push($arrs, $arr);
                    }
                }else{
                    $arr['id'] = $row->id;
                    $arr['label'] = $row->$column;
                    array_push($arrs, $arr);
                }
            }
            return $arrs;
    }
    
    function getTreeChild($rows, $parent_id ,$column) {
            $arrs = [];
            foreach ($rows as $key => $row) {
                if($row->parent_id == $parent_id) {
                    $arr['id'] = $row->id;
                    $arr['label'] = $row->$column;
                    array_push($arrs, $arr);
                }
            }
            // dd($arrs);
            return $arrs;
    }


    function generateSKU($length = 7) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $sku = '';
        for ($i = 0; $i < $length; $i++) {
            $sku .= $characters[rand(0, $charactersLength - 1)];
        }
        return $sku;
    }
    
    /** Slug **/
    
    function slug($string){
        return Str::slug($string);
    }