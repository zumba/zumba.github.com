---
layout: default
title: Zumba EDI - Documentation
description: OAuth documentation
author: aramonc
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li class="active">EDI</li>
</ul>

## EDI Standard

Shipping &amp; receiving communication between Zumba Fitness<sup>&reg;</sup> &amp; trading/shipping partners will take
place by means of EDI document transmissions.
 
The EDI standard being used by Zumba Fitness<sup>&reg;</sup> is the 
[RSX Document Standard v. 7.6.0](https://devcenter.spscommerce.com/retail-standards.aspx) as published by 
[SPS commerce](https://devcenter.spscommerce.com). (You will need to register an account with them to access the spec).
All partner communication should comply with this standard.

## On Boarding as a new Partner

Document transmission will be by means of an SFTP server. After contract finalization and during requirements gathering, 
the partner will receive a set of SFTP credentials and a unique identifier from Zumba. The partner should also provide 
a unique identifier for Zumba on their system. The credentials will grant access to 3 directories (in, out, error) in 
the SFTP server. The **in** directory will be read by Zumba and used by the partner to send documents to Zumba. The 
**out** directory should be read periodically by the partner and will be used by Zumba to send documents to the partner.

![Partner directory structure](resources/dir_structure.png)

During on boarding and for as long as the partner is in the process of implementing the RSX standard, a flag will be 
turned on in our system for the partner to receive error notifications in the **error** directory. These errors will be 
related to XML validation and the reading and writing of the documents to the SFTP server. Once the on boarding period 
is over and any bugs have been resolved, the partner can request to have the flag turned off.

Once an inbound document is processed successfully by Zumba, it will be removed from the **in** directory. Likewise, 
partners are responsible for removing processed documents from the **out** directory periodically.

## Naming Conventions

The Zumba EDI systems expects to read documents from the SFTP with file names in the form of: 

	<document_number>_<some_unique_identifier>.xml


The **document_number** will be one of the recognized X12 EDI codes (ie, 850, 940, 944, etc) to identify what the
document represents.

The **unique_identifier** can be anything that uniquely identifies that document such as an Order ID or a timestamp or
both. This is only so that documents from unrelated transmissions do not overwrite each other.

## Stacking Documents

Should the partner choose, multiple documents can be sent in one transmission. Our system will correctly split these off
into their own documents.

945 example:

	<?xml version="1.0" encoding="utf-8"?>
	<Shipments xmlns="http://www.spscommerce.com/RSX">
		<Shipment>
			.
			.
			.
		</Shipment>
		<Shipment>
			.
			.
			.
		</Shipment>
	</Shipments>
	
## Resources

### Schemas

* [Item Registries](resources/schemas/ItemRegistries.xsd) - [EDI 888](http://www.1edisource.com/transaction-sets?TSet=888)
* [Order Acknowledgement](resources/schemas/OrderAcks.xsd) - [EDI 855](http://www.1edisource.com/transaction-sets?TSet=855)
* [Orders](resources/schemas/Orders.xsd) - [EDI 850](http://www.1edisource.com/transaction-sets?TSet=850), [EDI 940](http://www.1edisource.com/transaction-sets?TSet=940)
* [Shipments](resources/schemas/Shipments.xsd) - [EDI 943](http://www.1edisource.com/transaction-sets?TSet=943), [EDI 940](http://www.1edisource.com/transaction-sets?TSet=945)
* [Warehouse Inventory Adjustment Advices](resources/schemas/WarehouseInventoryAdjustmentAdvices.xsd) - [EDI 944](http://www.1edisource.com/transaction-sets?TSet=944)
* [Warehouse Transfer Receipt Advices](resources/schemas/WarehouseTransferReceiptAdvices.xsd) - [EDI 947](http://www.1edisource.com/transaction-sets?TSet=947)

### Examples

* [850 Document](resources/samples/in/850_1010101010101.xml)
* [940 Document](resources/samples/out/940_A100UAC-150120221355_20150121.xml)
* [855 Document](resources/samples/in/855_A100UAC-150120221355_20150121.xml)
* [945 Document](resources/samples/in/945_A100UAC-150120221355.xml)