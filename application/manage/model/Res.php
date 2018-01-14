<?php
namespace app\manage\model;

use think\Model;
use think\Db;

class Res extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @author cyk
     * @return mixed
     */
    public function get_list($url)
    {
        $raw_list = Db::query("SELECT * FROM `t_res` WHERE 1 = 1 ");
        $tmp_list = array();
        $tmp_check_list = array();
        foreach ($raw_list as $k => $v) {
            if ($v['is_menu'] == "Y") {
                $tmp_check_list[$v['urlcode']] = $v['id'];
                if ($url == $v['urlcode']) {
                    $raw_list[$k]['active'] = true;
                } else {
                    $raw_list[$k]['active'] = false;
                }
                $tmp_list[$v['id']] = $raw_list[$k];
            }
        }
        $tmp_parent = isset($tmp_check_list[$url]) ? $tmp_check_list[$url] : 0;
        while ($tmp_parent > 0 && isset($tmp_list[$tmp_parent])) {
            $tmp_list[$tmp_parent]['active'] = true;
            $tmp_parent = $tmp_list[$tmp_parent]['parent_id'];
        }

        $menu_tree = $this->_tree($tmp_list);
        return $menu_tree;
    }

    /**
     * @param array $items
     * @return array
     */
    private function _tree($items)
    {
        $tree = array(); //格式化好的树
        foreach ($items as $item) {
            $parent_id = intval($item['parent_id']);
            if ($parent_id == -1) {
                continue;
            }
            if ($parent_id > 0 && isset($items[$parent_id])) {
                $items[$parent_id]['sub'][$item['id']] = &$items[$item['id']];
            } else {
                $tree[$item['id']] = &$items[$item['id']];
            }
        }
        return $tree;
    }

}