-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.25-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for qc
CREATE DATABASE IF NOT EXISTS `qc` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `qc`;

-- Dumping structure for table qc.temp_inventory_comments
CREATE TABLE IF NOT EXISTS `temp_inventory_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `comment_type` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `datetime` datetime DEFAULT current_timestamp(),
  `commenter` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_comments: ~0 rows (approximately)
INSERT INTO `temp_inventory_comments` (`id`, `po_id`, `comment_type`, `parent_id`, `comment`, `datetime`, `commenter`) VALUES
	(12, 8, 'str', NULL, 'note 1', '2023-10-27 16:09:18', 'Alex Polo'),
	(13, 8, 'str', NULL, 'note 2', '2023-10-27 16:09:21', 'Alex Polo'),
	(14, 8, 'str', 12, 'reply note', '2023-10-27 16:09:30', 'Alex Polo');

-- Dumping structure for table qc.temp_inventory_locations
CREATE TABLE IF NOT EXISTS `temp_inventory_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_locations: ~2 rows (approximately)
INSERT INTO `temp_inventory_locations` (`id`, `location`) VALUES
	(1, 'Warehouse 1'),
	(2, 'Warehouse 2'),
	(3, 'Warehouse 3');

-- Dumping structure for table qc.temp_inventory_materials_inventory
CREATE TABLE IF NOT EXISTS `temp_inventory_materials_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_material_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `incoming` int(11) DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `price_per_unit` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `str_in` int(11) DEFAULT NULL,
  `str_out` int(11) DEFAULT NULL,
  `variance` float DEFAULT NULL,
  `deleted` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=deleted, 0=retained',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `raw_material_id_location_id` (`raw_material_id`,`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_materials_inventory: ~8 rows (approximately)
INSERT INTO `temp_inventory_materials_inventory` (`id`, `raw_material_id`, `location_id`, `po_id`, `incoming`, `reorder`, `price_per_unit`, `total_amount`, `quantity`, `str_in`, `str_out`, `variance`, `deleted`, `date_added`, `date_updated`) VALUES
	(32, 1, 2, 17, 0, NULL, 100, 2000, 0, NULL, 0, NULL, '0', '2023-10-27 14:06:35', NULL),
	(33, 2, 2, 17, 0, NULL, 200, 4000, 20, NULL, NULL, NULL, '0', '2023-10-27 14:06:35', NULL),
	(34, 4, 2, 17, 0, NULL, 300, 6000, 20, NULL, NULL, NULL, '0', '2023-10-27 14:06:35', NULL),
	(35, 1, 1, 16, 0, 10, 100, 2000, 40, 0, NULL, NULL, '0', '2023-10-27 14:06:40', NULL),
	(36, 2, 1, 16, 0, 25, 200, 4000, 20, NULL, NULL, NULL, '0', '2023-10-27 14:06:40', NULL),
	(37, 4, 1, 16, 0, NULL, 300, 6000, 20, NULL, NULL, NULL, '0', '2023-10-27 14:06:40', NULL);

-- Dumping structure for table qc.temp_inventory_purchase_orders
CREATE TABLE IF NOT EXISTS `temp_inventory_purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po` varchar(50) NOT NULL,
  `logo` mediumtext DEFAULT NULL,
  `currency` varchar(50) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `expected_arrival` date NOT NULL,
  `created_date` date NOT NULL,
  `sub_total` float DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `shipping` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `remarks` mediumtext DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'drafted',
  `drafted_by_sig` mediumtext DEFAULT NULL,
  `drafted_by_name` varchar(100) DEFAULT NULL,
  `drafted_by_position` varchar(100) DEFAULT NULL,
  `date_drafted` datetime DEFAULT NULL,
  `approved_by_sig` mediumtext DEFAULT NULL,
  `approved_by_name` varchar(100) DEFAULT NULL,
  `approved_by_position` varchar(100) DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `cancelled_by_sig` mediumtext DEFAULT NULL,
  `cancelled_by_name` varchar(100) DEFAULT NULL,
  `cancelled_by_position` varchar(100) DEFAULT NULL,
  `date_cancelled` datetime DEFAULT NULL,
  `total_comments` int(11) NOT NULL DEFAULT 0,
  `deleted` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=deleted, 0=retained',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_purchase_orders: ~4 rows (approximately)
INSERT INTO `temp_inventory_purchase_orders` (`id`, `po`, `logo`, `currency`, `supplier_id`, `location_id`, `expected_arrival`, `created_date`, `sub_total`, `tax`, `shipping`, `total_price`, `remarks`, `date_added`, `date_updated`, `status`, `drafted_by_sig`, `drafted_by_name`, `drafted_by_position`, `date_drafted`, `approved_by_sig`, `approved_by_name`, `approved_by_position`, `date_approved`, `cancelled_by_sig`, `cancelled_by_name`, `cancelled_by_position`, `date_cancelled`, `total_comments`, `deleted`) VALUES
	(16, 'PO-01', 'https://interlinkiq.com/companyDetailsFolder/133548%20-%20Fat%20and%20Weird%20Cookies%20-%20FINAL.png', 'USD', 1, 1, '2023-10-31', '2023-10-27', 12000, 0, 0, 12000, '', '2023-10-27 22:05:51', '2023-10-27 22:07:10', 'received', 'data:image/png;base64,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', 'aaa', 'bbb', '2023-10-27 22:06:28', 'data:image/png;base64,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', 'aaa', 'aaa', '2023-10-27 22:06:40', NULL, NULL, NULL, NULL, 0, '0'),
	(17, 'PO-02', 'https://interlinkiq.com/companyDetailsFolder/133548%20-%20Fat%20and%20Weird%20Cookies%20-%20FINAL.png', 'USD', 1, 2, '2023-10-31', '2023-10-27', 12000, 0, 0, 12000, '', '2023-10-27 22:06:16', '2023-10-27 22:07:20', 'received', 'data:image/png;base64,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', 'aaa', 'bbbb', '2023-10-27 22:06:23', 'data:image/png;base64,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', 'aaa', 'aaa', '2023-10-27 22:06:35', NULL, NULL, NULL, NULL, 0, '0');

-- Dumping structure for table qc.temp_inventory_purchase_order_items
CREATE TABLE IF NOT EXISTS `temp_inventory_purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `raw_material_id` int(11) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `item` varchar(50) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `quantity_received` float DEFAULT NULL,
  `uom` varchar(50) DEFAULT NULL,
  `price_per_unit` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `deleted` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=deleted, 0=retained',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_purchase_order_items: ~8 rows (approximately)
INSERT INTO `temp_inventory_purchase_order_items` (`id`, `po_id`, `raw_material_id`, `sku`, `item`, `category`, `quantity`, `quantity_received`, `uom`, `price_per_unit`, `total_price`, `tax`, `deleted`) VALUES
	(39, 16, 1, 'sku1', 'rawmats1', 'category1', 20, 20, 'm', 100, 2000, 0, '0'),
	(40, 16, 2, 'sku2', 'rawmats2', 'category2', 20, 20, 'l', 200, 4000, 0, '0'),
	(41, 16, 4, 'sku4', 'rawmats4', 'category4', 20, 20, 'm', 300, 6000, 0, '0'),
	(42, 17, 1, 'sku1', 'rawmats1', 'category1', 20, 20, 'm', 100, 2000, 0, '0'),
	(43, 17, 2, 'sku2', 'rawmats2', 'category2', 20, 20, 'l', 200, 4000, 0, '0'),
	(44, 17, 4, 'sku4', 'rawmats4', 'category4', 20, 20, 'm', 300, 6000, 0, '0');

-- Dumping structure for table qc.temp_inventory_stock_card
CREATE TABLE IF NOT EXISTS `temp_inventory_stock_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_material_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `value` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL COMMENT '1=transfer_out, 2=transfer_in, 3=deliveries',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_stock_card: ~8 rows (approximately)
INSERT INTO `temp_inventory_stock_card` (`id`, `raw_material_id`, `location_id`, `date`, `value`, `action`) VALUES
	(18, 1, 1, '2023-10-27 22:07:10', 20, 3),
	(19, 2, 1, '2023-10-27 22:07:10', 20, 3),
	(20, 4, 1, '2023-10-27 22:07:10', 20, 3),
	(21, 1, 2, '2023-10-27 22:07:20', 20, 3),
	(22, 2, 2, '2023-10-27 22:07:20', 20, 3),
	(23, 4, 2, '2023-10-27 22:07:20', 20, 3),
	(24, 1, 2, '2023-10-27 22:10:30', 20, 1),
	(25, 1, 1, '2023-10-27 22:10:30', 20, 2);

-- Dumping structure for table qc.temp_inventory_stock_transfers
CREATE TABLE IF NOT EXISTS `temp_inventory_stock_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_no` varchar(50) DEFAULT NULL,
  `lot_batch_no` varchar(50) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `raw_material_id` int(11) DEFAULT NULL,
  `current_stock` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `transfer_for` varchar(50) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `transfer_type` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `received_by_sig` mediumtext DEFAULT NULL,
  `received_by_img` mediumtext DEFAULT NULL,
  `received_by_name` varchar(100) DEFAULT NULL,
  `received_by_position` varchar(100) DEFAULT NULL,
  `date_received` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `total_comments` int(11) NOT NULL DEFAULT 0,
  `deleted` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=deleted, 0=retained',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_stock_transfers: ~0 rows (approximately)
INSERT INTO `temp_inventory_stock_transfers` (`id`, `stock_no`, `lot_batch_no`, `location_id`, `raw_material_id`, `current_stock`, `quantity`, `transfer_for`, `transfer_date`, `notes`, `transfer_type`, `status`, `received_by_sig`, `received_by_img`, `received_by_name`, `received_by_position`, `date_received`, `date_added`, `date_updated`, `total_comments`, `deleted`) VALUES
	(8, 'STR-01', 'Lot 1', 1, 1, 20, 20, 'reason', '2023-10-27', '', 'str_out', 'received', 'data:image/png;base64,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', NULL, 'aaaa', 'bbb', '2023-10-27 22:10:30', '2023-10-27 22:08:40', NULL, 3, '0');

-- Dumping structure for table qc.temp_inventory_stock_transfers_sources
CREATE TABLE IF NOT EXISTS `temp_inventory_stock_transfers_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_transfer_id` int(11) NOT NULL DEFAULT 0,
  `materials_inventory_id` int(11) NOT NULL DEFAULT 0,
  `current_stock` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_stock_transfers_sources: ~0 rows (approximately)
INSERT INTO `temp_inventory_stock_transfers_sources` (`id`, `stock_transfer_id`, `materials_inventory_id`, `current_stock`, `quantity`) VALUES
	(8, 8, 32, 20, 20);

-- Dumping structure for table qc.temp_inventory_warehouse_receiving
CREATE TABLE IF NOT EXISTS `temp_inventory_warehouse_receiving` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `po_received_by_sig` mediumtext DEFAULT NULL,
  `po_received_by_img` mediumtext DEFAULT NULL,
  `po_received_by_name` varchar(100) DEFAULT NULL,
  `po_received_by_position` varchar(100) DEFAULT NULL,
  `date_po_received` datetime DEFAULT NULL,
  `po_verified_by_sig` mediumtext DEFAULT NULL,
  `po_verified_by_img` mediumtext DEFAULT NULL,
  `po_verified_by_name` varchar(100) DEFAULT NULL,
  `po_verified_by_position` varchar(100) DEFAULT NULL,
  `date_po_verified` datetime DEFAULT NULL,
  `supplier_inspected_by_sig` mediumtext DEFAULT NULL,
  `supplier_inspected_by_img` mediumtext DEFAULT NULL,
  `supplier_inspected_by_name` varchar(100) DEFAULT NULL,
  `supplier_inspected_by_position` varchar(100) DEFAULT NULL,
  `date_supplier_inspected` datetime DEFAULT NULL,
  `supplier_verified_by_sig` mediumtext DEFAULT NULL,
  `supplier_verified_by_img` mediumtext DEFAULT NULL,
  `supplier_verified_by_name` varchar(100) DEFAULT NULL,
  `supplier_verified_by_position` varchar(100) DEFAULT NULL,
  `date_supplier_verified` datetime DEFAULT NULL,
  `remarks` mediumtext DEFAULT NULL,
  `date_received` date DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `trailer_no` varchar(50) DEFAULT NULL,
  `trailer_plate` varchar(50) DEFAULT NULL,
  `trailer_seal` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_warehouse_receiving: ~4 rows (approximately)
INSERT INTO `temp_inventory_warehouse_receiving` (`id`, `po_id`, `po_received_by_sig`, `po_received_by_img`, `po_received_by_name`, `po_received_by_position`, `date_po_received`, `po_verified_by_sig`, `po_verified_by_img`, `po_verified_by_name`, `po_verified_by_position`, `date_po_verified`, `supplier_inspected_by_sig`, `supplier_inspected_by_img`, `supplier_inspected_by_name`, `supplier_inspected_by_position`, `date_supplier_inspected`, `supplier_verified_by_sig`, `supplier_verified_by_img`, `supplier_verified_by_name`, `supplier_verified_by_position`, `date_supplier_verified`, `remarks`, `date_received`, `arrival_time`, `invoice`, `trailer_no`, `trailer_plate`, `trailer_seal`) VALUES
	(16, 16, 'data:image/png;base64,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', NULL, 'aaa', 'bbbb', '2023-10-27 22:07:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
	(17, 17, 'data:image/png;base64,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', NULL, 'aaa', 'aaa', '2023-10-27 22:07:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);

-- Dumping structure for table qc.temp_inventory_warehouse_receiving_checklist
CREATE TABLE IF NOT EXISTS `temp_inventory_warehouse_receiving_checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_receiving_id` int(11) DEFAULT NULL,
  `item_type` enum('1','2') DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `value` int(1) DEFAULT NULL,
  `corrective_action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_warehouse_receiving_checklist: ~80 rows (approximately)
INSERT INTO `temp_inventory_warehouse_receiving_checklist` (`id`, `warehouse_receiving_id`, `item_type`, `description`, `value`, `corrective_action`) VALUES
	(302, 16, '1', 'Approved Supplier/Vendor', NULL, NULL),
	(303, 16, '1', 'BOL/Quantity Ordered', NULL, NULL),
	(304, 16, '1', 'Certificate of Guarantee (COG)', NULL, NULL),
	(305, 16, '1', 'Certificate of Analysis (COA)', NULL, NULL),
	(306, 16, '1', 'Safety Data Sheets (SDS)', NULL, NULL),
	(307, 16, '1', 'Kosher Ingredient Logo', NULL, NULL),
	(308, 16, '1', 'Halal Ingredient Logo', NULL, NULL),
	(309, 16, '1', 'Organic Ingredient Logo', NULL, NULL),
	(310, 16, '1', 'Gluten Free Ingredient Logo', NULL, NULL),
	(311, 16, '1', 'Certificate of Origin (COO)', NULL, NULL),
	(312, 16, '2', 'Trailer Internal & External Damaged', NULL, NULL),
	(313, 16, '2', 'Signs of Pest Activity/Vermin', NULL, NULL),
	(314, 16, '2', 'Checmical Spill/Stains or smell', NULL, NULL),
	(315, 16, '2', 'Signs of Odors Chemical or Spoiled', NULL, NULL),
	(316, 16, '2', 'Shipment Mixed Toxic Material', NULL, NULL),
	(317, 16, '2', 'Ingredients Sealed or Intact', NULL, NULL),
	(318, 16, '2', 'Ingredients Record Damaged', NULL, NULL),
	(319, 16, '2', 'Ingredients Quantity Received', NULL, NULL),
	(320, 16, '2', 'Ingredients Proper Identification', NULL, NULL),
	(321, 16, '2', 'MFG Expiry/Lot Number/Retest Date', NULL, NULL),
	(322, 17, '1', 'Approved Supplier/Vendor', NULL, NULL),
	(323, 17, '1', 'BOL/Quantity Ordered', NULL, NULL),
	(324, 17, '1', 'Certificate of Guarantee (COG)', NULL, NULL),
	(325, 17, '1', 'Certificate of Analysis (COA)', NULL, NULL),
	(326, 17, '1', 'Safety Data Sheets (SDS)', NULL, NULL),
	(327, 17, '1', 'Kosher Ingredient Logo', NULL, NULL),
	(328, 17, '1', 'Halal Ingredient Logo', NULL, NULL),
	(329, 17, '1', 'Organic Ingredient Logo', NULL, NULL),
	(330, 17, '1', 'Gluten Free Ingredient Logo', NULL, NULL),
	(331, 17, '1', 'Certificate of Origin (COO)', NULL, NULL),
	(332, 17, '2', 'Trailer Internal & External Damaged', NULL, NULL),
	(333, 17, '2', 'Signs of Pest Activity/Vermin', NULL, NULL),
	(334, 17, '2', 'Checmical Spill/Stains or smell', NULL, NULL),
	(335, 17, '2', 'Signs of Odors Chemical or Spoiled', NULL, NULL),
	(336, 17, '2', 'Shipment Mixed Toxic Material', NULL, NULL),
	(337, 17, '2', 'Ingredients Sealed or Intact', NULL, NULL),
	(338, 17, '2', 'Ingredients Record Damaged', NULL, NULL),
	(339, 17, '2', 'Ingredients Quantity Received', NULL, NULL),
	(340, 17, '2', 'Ingredients Proper Identification', NULL, NULL),
	(341, 17, '2', 'MFG Expiry/Lot Number/Retest Date', NULL, NULL);

-- Dumping structure for table qc.temp_raw_materials
CREATE TABLE IF NOT EXISTS `temp_raw_materials` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `raw_materials` varchar(50) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `price_per_unit` float DEFAULT NULL,
  `uom` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_raw_materials: ~4 rows (approximately)
INSERT INTO `temp_raw_materials` (`id`, `supplier_id`, `raw_materials`, `sku`, `category`, `price_per_unit`, `uom`) VALUES
	(1, 1, 'rawmats1', 'sku1', 'category1', 100, 'm'),
	(2, 1, 'rawmats2', 'sku2', 'category2', 200, 'l'),
	(3, 2, 'rawmats3', 'sku3', 'category3', 200, 'm'),
	(4, 1, 'rawmats4', 'sku4', 'category4', 300, 'm');

-- Dumping structure for table qc.temp_suppliers
CREATE TABLE IF NOT EXISTS `temp_suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_suppliers: ~2 rows (approximately)
INSERT INTO `temp_suppliers` (`id`, `supplier_name`) VALUES
	(1, 'Supplier1'),
	(2, 'Supplier2');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
