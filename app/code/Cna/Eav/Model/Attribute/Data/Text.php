<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cna\Eav\Model\Attribute\Data;

use Magento\Framework\App\RequestInterface;

/**
 * EAV Entity Attribute Text Data Model
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Text extends \Magento\Eav\Model\Attribute\Data\Text
{
   
    public function validateValue($value)
    {
        $errors = [];
        $attribute = $this->getAttribute();
        $label = __($attribute->getStoreLabel());

        if ($value === false) {
            // try to load original value and validate it
            $value = $this->getEntity()->getDataUsingMethod($attribute->getAttributeCode());
        }
        if($label != "First Name" ){
            if($label != "Last Name"){
                if ($attribute->getIsRequired() && empty($value) && $value !== '0') {
                    $errors[] = __('"%1" is a required  '.$label.' value.', $label);
                }
            }
        }
        if (!$errors && !$attribute->getIsRequired() && empty($value)) {
            return true;
        }
        
        
        // validate length
        $length = $this->_string->strlen(trim($value));

        $validateRules = $attribute->getValidateRules();
        
        if($label != "First Name"){
            if($label != "Last Name"){
                if (!empty($validateRules['min_text_length']) && $length < $validateRules['min_text_length']) {
                    $v = $validateRules['min_text_length'];
                    $errors[] = __('"%1" length must be equal or '.$label.' greater than %2 characters.', $label, $v);
                }
                if (!empty($validateRules['max_text_length']) && $length > $validateRules['max_text_length']) {
                    $v = $validateRules['max_text_length'];
                    $errors[] = __('"%1" length must be equal or '.$label.' less than %2 characters.', $label, $v);
                }
            }
        }
        $result = $this->_validateInputRule($value);
        if ($result !== true) {
            $errors = array_merge($errors, $result);
        }
        if (count($errors) == 0) {
            return true;
        }

        return $errors;
    }

   
}
