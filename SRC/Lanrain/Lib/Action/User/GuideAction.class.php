<?php
/**
 *引导页
**/
class GuideAction extends UserAction{
	public $token;
	public $home_db;
	public $back_db;

	public function _initialize() {
		
		parent::_initialize();
		$this->token=$this->_session('token');
		$this->home_db=M('home');
		$this->back_db=D('guide');		
	}
	
	public function index(){

		$db=$this->back_db;
		$where['token']=$this->token;
		$count=$db->where($where)->count();				
		$page=new Page($count,25);
		$info=$db->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		if($info != null){
	   		$info[0]['filename'] = basename($info[0]['guide']);
		}
		$this->assign('page',$page->show());
		$this->assign('info',$info);
		
		
		$data=M('animation')->where($where)->find();
		$this->assign('is_open',$data['open_animation']);		
		
		$this->display();
	}
	
	public function musicAdd(){
		$where['uid']=session('uid');
		$where['token']=$this->token;
		$count=$this->back_db->where($where)->count();
		
		if ($count) {
			$this->error('背景音乐只能有一首！');
		}else{
			$this->display();
		}
	}
	
	public function musicInsert(){
		
		$home=$this->home_db->where(array('token'=>$this->token))->find();
		if ($home) {	
			$this->all_insert();
		}else{
			$this->error('请先进行首页设置！', U('Home/set'));
		}
	}	
			
	public function musicEdit(){
		$where['id']=$this->_get('id','intval');
		$where['upd_type']= '1';
		$res=D('Guide')->where($where)->find();
		$this->assign('info',$res);
		$this->display();
	}
	
	public function musicUpsave(){
		
		$home=$this->home_db->where(array('token'=>$this->token))->find();
		if ($home) {			
			$this->all_save();
		}else{
			$this->error('请先进行首页设置！', U('Home/set'));
		}
	}	
	
	public function musicDel(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		if(D(MODULE_NAME)->where($where)->delete()){
			$this->home_db->where(array('token'=>$this->token))->save(array('homeurl'=>''));
			$this->success('操作成功',U(MODULE_NAME.'/index'));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	
	
	public function changeAnimation(){
		$where['token']=$this->token;
		$data['open_animation'] = $this->_get('open_animation','intval');
		
		$back=M('animation')->where(array('token'=>$this->token))->find();
		if ($back) {
			$back=M('animation')->where($where)->save($data);
		}
		else{
			$data['token']=$where['token'];
			$back=M('animation')->add($data);
		}
		
		if($back){
			echo 1;
		}else{
		    echo 2;				
		}	
	}	


	
}
?>