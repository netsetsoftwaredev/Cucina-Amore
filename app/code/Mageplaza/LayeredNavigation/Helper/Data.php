<?php

namespace Mageplaza\LayeredNavigation\Helper;

use Mageplaza\Core\Helper\AbstractData;

class Data extends AbstractData
{
	public function isEnabled($storeId = null)
	{
		return $this->getConfigValue('layered_navigation/general/enable', $storeId);
	}
}
