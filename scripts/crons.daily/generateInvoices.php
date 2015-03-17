<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

define("APP_ROOT", __DIR__ . "/../..");
require_once APP_ROOT . "/Classes/Autoloader.php";

$config = new \Config("config");
$db = new \Database($config->database);

Registry::add("config", $config);
Registry::add("db", $db);

$query = $db->prepareQuery("select id, customer_id, next_bill_date from Item where next_bill_date < date_add(NOW(), INTERVAL 14 DAY) ORDER BY customer_id, next_bill_date");


if($query->execute()){
    $customers = array();
    while($row = $query->fetch()){
        $customers[$row['customer_id']][$row['next_bill_date']][] = $row['id'];
    }
    
    foreach($customers as $customerId => $invoices){
        foreach($invoices as $invoiceDate => $items){
            $invoice = new Model\Invoice();
            $invoice->issue_date = date("Y-m-d");
            $invoice->due_date = $invoiceDate;
            $invoice->paid_date = "0000-00-00";
            $invoice->customer_id = $customerId;
            $invoice->status = "unpaid";
            $invoice->write();
            
            foreach($items as $itemId){
                $item = new Model\Item($itemId);
                $product = $item->getProduct();
                $invoiceItem = new Model\InvoiceItem();
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->item_id = $itemId;
                $invoiceItem->name = $product->name . " for: " . $item->name;
                $invoiceItem->amount = $product->price;
                $invoiceItem->write();
                $item->next_bill_date = date("Y-m-d", strtotime(" + " . $product->repeating . " month", strtotime($item->next_bill_date)));
                $item->write();
            }
        }
    }
}




