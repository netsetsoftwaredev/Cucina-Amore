<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
    <router id="admin">
        <route id="cna_catalogue" frontName="cna_catalogue">
            <module name="Cna_Catalogue" before="Magento_Backend" />
        </route>
    </router>
</config>
