<?php
namespace Cna\Catalogue\Ui\Component\Listing\Column\Cnacataloguecustomers;

class PageActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";
                if(isset($item["cna_catalogue_customers_id"]))
                {
                    $id = $item["cna_catalogue_customers_id"];
                }
                $item[$name]["view"] = [
                    "href"=>$this->getContext()->getUrl(
                        "cna_catalogue_customers/customers/edit",["cna_catalogue_customers_id"=>$id]),
                    "label"=>__("Edit")
                ];
            }
        }

        return $dataSource;
    }    
    
}
