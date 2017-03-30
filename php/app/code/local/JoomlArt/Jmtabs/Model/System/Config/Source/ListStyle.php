<?php
/*------------------------------------------------------------------------
# $JA#PRODUCT_NAME$ - Version $JA#VERSION$ - Licence Owner $JA#OWNER$
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites: http://www.joomlart.com - http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/ 

class JoomlArt_JmTabs_Model_System_Config_Source_ListStyle
{
    public function toOptionArray()
    {       
		/*return array(
        	array('value'=>'default', 'label'=>Mage::helper('joomlart_jmtabs')->__('default')),
            array('value'=>'barite', 'label'=>Mage::helper('joomlart_jmtabs')->__('barite')),
            array('value'=>'kulanite', 'label'=>Mage::helper('joomlart_jmtabs')->__('kulanite')),
            array('value'=>'labra', 'label'=>Mage::helper('joomlart_jmtabs')->__('labra')),
			array('value'=>'pyrite', 'label'=>Mage::helper('joomlart_jmtabs')->__('pyrite')),
			array('value'=>'sanidine', 'label'=>Mage::helper('joomlart_jmtabs')->__('sanidine')),
			array('value'=>'teline_ii', 'label'=>Mage::helper('joomlart_jmtabs')->__('teline_ii')),
            array('value'=>'trona', 'label'=>Mage::helper('joomlart_jmtabs')->__('trona'))
        );*/
		
		$d = dir(BP . DS . 'skin' . DS . 'frontend'  . DS . 'default' . DS . 'default'  . DS . 'joomlart' . DS . 'jmtabs' . DS . 'themes');
		while (false !== ($entry = $d->read())) {
			if ($entry != "." && $entry != "..") {
				$a[] = $entry;
			}	
		}
		
		reset($a);
		foreach ($a as $v) {
		   $arr[] = array('value' => $v, 'label' => ucfirst($v));
		}

		return $arr;
		
		
    }    
}
