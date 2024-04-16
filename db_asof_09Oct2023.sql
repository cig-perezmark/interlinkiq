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

-- Dumping structure for table qc.temp_inventory_materials_inventory
CREATE TABLE IF NOT EXISTS `temp_inventory_materials_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` varchar(50) DEFAULT NULL,
  `raw_material_id` int(11) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `material_name` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `uom` varchar(50) DEFAULT NULL,
  `incoming` int(11) DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `price_per_unit` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `str_in` int(11) DEFAULT NULL,
  `str_out` int(11) DEFAULT NULL,
  `variance` float DEFAULT NULL,
  `deleted` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=deleted, 0=retained',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `raw_material_id` (`raw_material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_materials_inventory: ~2 rows (approximately)

-- Dumping structure for table qc.temp_inventory_purchase_orders
CREATE TABLE IF NOT EXISTS `temp_inventory_purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po` varchar(50) NOT NULL,
  `logo` mediumtext DEFAULT NULL,
  `currency` varchar(50) NOT NULL,
  `supplier` varchar(50) NOT NULL,
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
  `deleted` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=deleted, 0=retained',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_purchase_orders: ~5 rows (approximately)

-- Dumping structure for table qc.temp_inventory_purchase_order_items
CREATE TABLE IF NOT EXISTS `temp_inventory_purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_purchase_order_items: ~10 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_warehouse_receiving: ~5 rows (approximately)

-- Dumping structure for table qc.temp_inventory_warehouse_receiving_checklist
CREATE TABLE IF NOT EXISTS `temp_inventory_warehouse_receiving_checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_receiving_id` int(11) DEFAULT NULL,
  `item_type` enum('1','2') DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `value` int(1) DEFAULT NULL,
  `corrective_action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table qc.temp_inventory_warehouse_receiving_checklist: ~106 rows (approximately)

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

-- Dumping data for table qc.temp_raw_materials: ~2 rows (approximately)
INSERT INTO `temp_raw_materials` (`id`, `supplier_id`, `raw_materials`, `sku`, `category`, `price_per_unit`, `uom`) VALUES
	(1, 1, 'rawmats1', 'sku1', 'category1', 100, 'm'),
	(2, 1, 'rawmats2', 'sku2', 'category2', 200, 'l');

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
