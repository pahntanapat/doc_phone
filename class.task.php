<?php
require_once('class.base.php');
class Task extends Base{
	const COL_ID = 'id';
	const COL_NAME='name';
	const COL_PARENT='parent';
	const COL_DETAIL='detail';
	const TABLE='task_type';
	
	public function getList(){
		#$this->sql=new PDO('','','');
		$s = $this->sql->query('SELECT * FROM '.(self::TABLE).' ORDER BY '.(self::COL_PARENT).', '.(self::COL_NAME));
		
		return($s?$s->fetchall(PDO::FETCH_ASSOC):$s);
	}
}

class LoopTask{
	public $id=0, $name='', $detail='', $child = array(), $parent;
	
	public function __construct($assoc_array=NULL){
		if(is_null($assoc_array))
			return;
		$this->id = $assoc_array[Task::COL_ID];
		$this->name=$assoc_array[Task::COL_NAME];
		$this->detail=$assoc_array[Task::COL_DETAIL];
		$this->parent=$assoc_array[Task::COL_PARENT];
	}
	public function addChild($assoc_array, $deep_count=0){
		#$this->child[]=new self($assoc_array);
		#return(count($this->child));
		#$root=array();
		
		# generate the child
		foreach($flat_assoc_array as $k=>$v){
			if($v[(Task::COL_PARENT)]==$this->parent){
				$this->child[]=new self($v);
				unset($flat_assoc_array[$k]);
			}
		}
		
		# loop in each child
		if(count($this->child)>1){
			$deep_count++;
			$d=$deep_count;
			for($k=0;$k<count($this->child);$k++){
				$v=$this->child[$k]->addChild($flat_assoc_array, $deep_count);
				if($v>$d)
					$d=$v;
			}
			$deep_count=$d;
		}		
		
		return($deep_count);
	}
	public static function generate($flat_assoc_array, $parent=0){
		$root=NULL;
		foreach($flat_assoc_array as $k=>$v){
			if($v[(Task::COL_ID)]==$parent){
				$root=new self($v);
				unset($flat_assoc_array[$k]);
				break;
			}
		}
		if(is_null($root)){
			$root=new self();
			$root->id=$parent;
		}
		$d = $root->addChild($flat_assoc_array);
		return(array($root,$d));
	}
	public function __toString(){
		// Render to HTML
		return($this->toHTML());
	}
	
	public function toHTML($edible=false, $ul=true){
		$html=$ul?"<ul id=\"taskList\" class=\"jslists\">":'';
		$child = count($this->detail)>0;
		if($this->id>0){
			$html.="<li><div class=\"tooltip\">";
			$html.=$this->name;
			if(count($this->detail)>0)
				$html.="<span class=\"tooltiptext\">".($this->detail)."</span>";
			$html.="</div>";
			if($child||$edible)
				$html.="<ul>";
		}
		
		if($child){
			foreach($this->child as $v){
				$html.=$v->toHTML($edible, false);
			}
		}elseif($edible){
			$html.=self::addBtnHTML($this->id);
		}
		if($this->id>0){
			if($child||$edible)
				$html.="</ul>";
			$html.="</li>";
			if($edible)
				$html.=self::addBtnHTML($this->parent);
		}
		
		if($ul)
			$html.="</ul>";
		return($html);
	}
	
	protected static function addBtnHTML($parent){
		return("<li><button data-parent=\"".($parent)."\" class=\"add\">Add</button></li>");
	}
}
?>