<?php
function check_invoice_from_paysbuy($invoiceNo, $merchantEmail, $strApCode) {

    require_once('Zend/Soap/Client.php');

    $wsdl        = "http://www.paysbuy.com/getinvoicestatus/getinvoicestatus.asmx?WSDL";

    $client = new Zend_Soap_Client($wsdl, array('encoding' => 'UTF-8', 'soap_version' => SOAP_1_1));

    $params = array('invoiceNo' => $invoiceNo, 'merchantEmail' => $merchantEmail,  'strApCode' => $strApCode);
    try {
        $result = $client->GetInvoice($params);

        $xml = new SimpleXMLElement($result->GetInvoiceResult->any);

        // SimpleXMLElement Object ( [StatusResult] => Accept [AmountResult] => 1.00 [MethodResult] => 01 )

        if($xml->StatusResult == 'Accept') {
            $result = array('status' => true, 'amount' => "".$xml->AmountResult, 'method' => "".$xml->MethodResult);
        } else {
            $result = array('status' => false, 'amount' => "".$xml->AmountResult, 'method' => "".$xml->MethodResult);
        }
    } catch (Exception $e) {
        $result = array('status' => false, 'msg' => $e);
    }

    return $result;
}