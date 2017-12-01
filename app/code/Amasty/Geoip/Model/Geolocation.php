<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Geoip
 */


namespace Amasty\Geoip\Model;

class Geolocation extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Amasty\Geoip\Helper\Data
     */
    public $geoipHelper;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * Geolocation constructor.
     *
     * @param \Amasty\Geoip\Helper\Data                 $geoipHelper
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        \Amasty\Geoip\Helper\Data $geoipHelper,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->geoipHelper = $geoipHelper;
        $this->resource = $resource;
    }

    /**
     * load location data by IP
     *
     * @param string $ip
     *
     * @return $this
     */
    public function locate($ip)
    {
//        $ip = '213.184.226.82';//Minsk
        if ($this->geoipHelper->isDone(false)) {
            $longIP = sprintf("%u", ip2long($ip));

            if (!empty($longIP)) {
                $connection =  $this->resource->getConnection('read');
                $select = $connection->select()
                    ->from(['l' => $this->resource->getTableName('amasty_geoip_location')])
                    ->join(
                        ['b' => $this->resource->getTableName('amasty_geoip_block')],
                        'b.geoip_loc_id = l.geoip_loc_id',
                        []
                    )
                    ->where("$longIP between b.start_ip_num and b.end_ip_num")
                    ->limit(1);

                if ($res = $connection->fetchRow($select))
                    $this->setData($res);
            }
        }

        return $this;
    }
}
