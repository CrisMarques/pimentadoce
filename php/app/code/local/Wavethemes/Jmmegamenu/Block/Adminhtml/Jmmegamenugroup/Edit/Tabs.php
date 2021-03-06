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
  class Wavethemes_Jmmegamenu_Block_Adminhtml_Jmmegamenugroup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
  {
		public function __construct()
		{
			parent::__construct();
			$this->setId('jmmegamenugroup_tabs');
			$this->setDestElementId('edit_form');
			$this->setTitle(Mage::helper('jmmegamenu')->__('Menu Group Configuration'));
		}
		protected function _beforeToHtml()
		{
			$this->addTab('form_section', array(
			'label' => Mage::helper('jmmegamenu')->__('Menu Group Configuration'),
			'title' => Mage::helper('jmmegamenu')->__('Menu Group Configuration'),
			'content' => $this->getLayout()->createBlock('jmmegamenu/adminhtml_jmmegamenugroup_edit_tab_form')->toHtml(),
			));
			return parent::_beforeToHtml();
		}
  }