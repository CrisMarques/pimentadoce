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

class JoomlArt_Jmtabs_Model_ListData extends Mage_Cms_Model_Mysql4_Block{
	/**
     *
     * @param Mage_Core_Model_Abstract $object
     */
    public function _getBlockId(Mage_Core_Model_Abstract $object, $identifier)
    {    	
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('cms/block'))
            ->where('identifier = ?', $identifier);

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
        	return $data[0]['block_id'];        	
        }
		return 0;
    }
}
?>
