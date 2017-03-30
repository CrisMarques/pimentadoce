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


class JoomlArt_JmTabs_Model_System_Config_Source_ListAnimation
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'fadeIn', 'label'=>Mage::helper('joomlart_jmtabs')->__('Fade')),
			array('value'=>'animMoveHor', 'label'=>Mage::helper('joomlart_jmtabs')->__('Move Left-Right')),            
            array('value'=>'animMoveVer', 'label'=>Mage::helper('joomlart_jmtabs')->__('Move Top-Down'))    
        );
    }    
}
