<?php 

class Enum extends CApplicationComponent
{

	
	
	public function items($model, $attr){
		CHtml::resolveName($model,$attr);
		preg_match('/\((.*)\)/',$model->tableSchema->columns[$attr]->dbType,$matches);
		$values = array();
		foreach(explode(',', $matches[1]) as $value) {
				$value=str_replace("'",null,$value);
//				$values[$value]=Yii::t('enumItem',$value);
				array_push($values, $value);
		}
		return $values;
		
	}
}