CREATE TABLE `products_media` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(45) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `asset_type` char(1) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;