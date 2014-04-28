<?php

class brandlistAction extends backendAction
{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('brandlist');
    }

    public function _before_index() {
        $big_menu = array(
            'title' => L('添加品牌'),
            'iframe' => U('brandlist/add'),
            'id' => 'add',
            'width' => '400',
            'height' => '130'
        );
        $this->assign('big_menu', $big_menu);

        //默认排序
        $this->sort = 'ordid';
        $this->order = 'ASC';
    }

    public function _before_insert($data) {
    	$data['tokenTall'] = $this->getTokenTall();
    	return $data;
    }
    protected function _after_insert($id) {
    	//如果是主号，则同步其他号
    	if ($_SESSION['is_master'] === "true") {
    		$item_other_mod = D('brandlist');
    		$item_other = $item_other_mod->where('id='.$id)->find();
    		unset($item_other['id']);
    		$item_other['fromid'] = $id;
    
    		$alltoken = M('wxuser')->where("token !='".$_SESSION['master_token']."'")->select();
    		foreach ($alltoken as $onetoken){
    			$item_other['tokenTall'] = $onetoken['token'];
    			$item_other_mod->add($item_other);
    		}
    	}
    }
    protected function _after_update($id) {
    	//如果是主号，则同步其他号
    	if ($_SESSION['is_master'] === "true") {
    		$item_other_mod = D('brandlist');
    		$item_other = $item_other_mod->where('id='.$id)->find();
    
    		$item_other_data = $item_other;
    		unset($item_other_data['id']);
    		unset($item_other_data['tokenTall']);
    		unset($item_other_data['fromid']);
    
    
    		$alltoken = $item_other_mod->where(array('fromid'=>$id))->select();
    		foreach ($alltoken as $onetoken){
    			$item_other_data['id'] = $onetoken['id'];
    			$item_other_mod->save($item_other_data);
    		}
    	}
    }
    
    protected function _search() {
        $map = array();
        $map['tokenTall'] = $this->getTokenTall();
        ($keyword = $this->_request('keyword', 'trim')) && $map['name'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'keyword' => $keyword,
        ));
        return $map;
    }

    public function ajax_check_name() {
        $name = $this->_get('name', 'trim');
        $id = $this->_get('id', 'intval');
        if (D('score_item_cate')->name_exists($name, $id)) {
            $this->ajaxReturn(0, L('该分类名称已存在'));
        } else {
            $this->ajaxReturn(1);
        }
    }
    
      public function deletebrand()
    {
    	 
        $mod = D($this->_name);
      
        $pk = $mod->getPk();
        $ids = trim($this->_request($pk), ',');
        
       
        if ($ids) {
        	$count=M('item')->where("brand in (".$ids.")")->count();
        	if($count>0)
        	{
          IS_AJAX && $this->ajaxReturn(0,'品牌被引用，不能删除');exit;
        	}
        	
            if (false !== $mod->delete($ids)) {
            	
            	//如果是主号，则同步其他号
            	if ($_SESSION['is_master'] === "true") {
            		$mod->where('fromid in('.$ids.')')->delete();
            	}
            	
                IS_AJAX && $this->ajaxReturn(1, L('operation_success'));
                $this->success(L('operation_success'));
            } else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
                $this->error(L('operation_failure'));
            }
        } else {
            IS_AJAX && $this->ajaxReturn(0, L('illegal_parameters'));
            $this->error(L('illegal_parameters'));
        }
    }
    
}