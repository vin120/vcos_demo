<?php
/**
 * Created by PhpStorm.
 * User: RockLei
 * Date: 2016/5/4
 * Time: 11:01
 */

namespace app\modules\orgmanagement\components;

/**
 * 由一个带fid的数组生成一个带children的树形数组
 * 专为EasyUI的Tree的json格式设计
 * @author ljb
 *
 */
class BuildTreeArray
{
    private $idKey = 'id'; //主键的键名
    private $fidKey = 'fid'; //父ID的键名
    private $name = 'name'; //
    private $root = 0; //最顶层fid
    private $data = array(); //源数据
    private $treeArray = array(); //属性数组

    function __construct($data,$idKey,$fidKey,$name,$root) {
        if($idKey) $this->idKey = $idKey;
        if($fidKey) $this->fidKey = $fidKey;
        if($name) $this->name = $name;
        if($root) $this->root = $root;
        if($data) {
            $this->data = $data;
            $this->getChildren($this->root);
        }
    }

    /**
     * 获得一个带children的树形数组
     * @return multitype:
     */
    public function getTreeArray()
    {
        //去掉键名
        return array_values($this->treeArray);
    }

    public function  getLinkageselData()
    {
        $data = array_values($this->treeArray);
        $json_data = $this->createLinkageselData($data);

        return $json_data;
    }
    /**
     * @param int $root 父id值
     * @return null or array
     */
    private function getChildren($root)
    {
//        echo $this->fidKey;
//        echo $this->idKey;
//        exit;
        $children = array();
        foreach ($this->data as &$node){
            if($root == $node[$this->fidKey]){
                $node['cell'] = $this->getChildren($node[$this->idKey]);
                $children[] = $node;


            }
            //只要一级节点
            if($this->root == $node[$this->fidKey]){
                $this->treeArray[$node[$this->idKey]] = $node;
            }
        }
        return $children;
    }

    private function createLinkageselData($data)
    {
        $data_length = count($data);
        $temp_count = 0;

        $link_str = '{';
        foreach ($data as $linkagesel)
        {
            $cell = $linkagesel['cell'];

            if($temp_count != 0 && $temp_count < $data_length){
                $link_str .= ',';
            }

            $link_str .= '"'.$linkagesel[$this->idKey].'":{"name":"'.$linkagesel[$this->name].'"';

            if(!empty($cell)){
                $link_str .= ',';
                $link_str .= '"cell":';
                $link_str .= $this->createLinkageselData($cell);
            }

            $link_str .= '}';
            $temp_count ++;
        }
        $link_str .= '}';

        return $link_str;
    }
    
    
    public function getDevTree(){
    	$data = array_values($this->treeArray);
    	return $this->createDevTree($data);
    }
    
    protected function createDevTree($data)
    {
    	$tree_str = '<ul>';
    	foreach ($data as $linkagesel)
    	{
    		$cell = $linkagesel['cell'];
    		if(!empty($cell)){
    			$tree_str .= '<li class="open"><input type="checkbox" value="'.$linkagesel[$this->idKey].'"></input>'.$linkagesel[$this->name].'</li>';
    		}else{
    			$tree_str .= '<li class="no-child"><input type="checkbox" value="'.$linkagesel[$this->idKey].'"></input>'.$linkagesel[$this->name].'</li>';
    		}
    		if(!empty($cell)){
    			$tree_str .= $this->createDevTree($cell);

    		}
    	}
    	$tree_str .= '</ul>';
    	
    	return $tree_str;
    }
}