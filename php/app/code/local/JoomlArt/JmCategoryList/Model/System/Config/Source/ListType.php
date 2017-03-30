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


class JoomlArt_JmCategoryList_Model_System_Config_Source_ListType
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('-- Please select --')),
            array('value'=>'latest', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('Latest')),
            array('value'=>'best_buy', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('Best Buy')),
            array('value'=>'most_viewed', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('Most Viewed')),
            array('value'=>'most_reviewed', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('Most Reviewed')),
            array('value'=>'top_rated', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('Top Rated')),
            array('value'=>'attribute', 'label'=>Mage::helper('joomlart_jmcategorylist')->__('Featured Product'))
        );
    }    
}