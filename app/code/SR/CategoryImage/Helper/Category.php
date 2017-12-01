<?php

namespace SR\CategoryImage\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Category extends AbstractHelper
{


    /**
     * @return array
     */
    public function getAdditionalImageTypes()
    {
        return array('thumbnail','landing_how_img1', 'landing_how_img2', 'landing_how_img3', 'landing_how_img4',
                        'landing_what_img1', 'landing_what_img2','landing_what_img3','landing_what_img4',
                        'landing_where_img1', 'landing_where_img2','landing_where_img3','landing_where_img4',
                        'landing_nutrition_facts', 'landing_main_head'); 
    }

    /**
     * Retrieve image URL
     * @param $image
     * @return string
     */
    public function getImageUrl($image)
    {
        $url = false;
        //$image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $url = $this->_urlBuilder->getBaseUrl(
                        ['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

}
