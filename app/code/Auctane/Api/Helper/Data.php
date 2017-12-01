<?php

namespace Auctane\Api\Helper;

class Data
{
    /**
     * Dispatch webservice fault
     *
     * @param integer $code    code
     * @param string  $message message
     * 
     * @return exception
     */
    public function fault($code, $message)
    {
        if (is_numeric($code) && strlen((int) $code) === 3) {
            header(':', true, $code);
        } else {
            header(':', true, 400);
        }
    
        header('Content-Type: text/xml; charset=UTF-8');
        die(
            '<?xml version="1.0" encoding="UTF-8"?>
            <fault>
                <faultcode>' . $code . '</faultcode>
                <faultstring>' . $message . '</faultstring>
            </fault>'
        );
    }
}