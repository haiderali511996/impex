-- ============================================================
-- IMPEX Football WooCommerce - Sample Database
-- Version: 1.0.0
-- Generated: 2024-01-01
-- Description: Complete WordPress + WooCommerce database structure
--              with IMPEX Football product categories and sample products.
-- ============================================================
-- Usage: Import this file AFTER a clean WordPress + WooCommerce install.
--        Adjust the table prefix (wp_) if you use a different prefix.
--        Run: mysql -u USERNAME -p DATABASE_NAME < impex-sample-data.sql
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ============================================================
-- TABLE: wp_options  (WordPress settings + WooCommerce config)
-- ============================================================

-- Site Identity
INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES
('blogname',        'IMPEX Football',                                                          'yes'),
('blogdescription', 'Premium Football Manufacturer — Professional, Training & Custom Balls',   'yes'),
('siteurl',         'http://localhost/impex',                                                  'yes'),
('home',            'http://localhost/impex',                                                  'yes'),
('admin_email',     'admin@impexfootball.com',                                                 'yes'),
('blogpublic',      '1',                                                                       'yes'),
('date_format',     'F j, Y',                                                                  'yes'),
('time_format',     'g:i a',                                                                   'yes'),
('timezone_string', 'Asia/Karachi',                                                            'yes'),
('permalink_structure', '/%postname%/',                                                        'yes'),
('active_theme',    'impex-football',                                                          'yes'),
('template',        'impex-football',                                                          'yes'),
('stylesheet',      'impex-football',                                                          'yes')
ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`);

-- WooCommerce Store Settings
INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES
('woocommerce_store_address',          '123 Football Drive',  'yes'),
('woocommerce_store_address_2',        '',                    'yes'),
('woocommerce_store_city',             'Sialkot',             'yes'),
('woocommerce_default_country',        'PK:PB',              'yes'),
('woocommerce_store_postcode',         '51310',               'yes'),
('woocommerce_currency',               'USD',                 'yes'),
('woocommerce_currency_pos',           'left',                'yes'),
('woocommerce_price_thousand_sep',     ',',                   'yes'),
('woocommerce_price_decimal_sep',      '.',                   'yes'),
('woocommerce_price_num_decimals',     '2',                   'yes'),
('woocommerce_weight_unit',            'g',                   'yes'),
('woocommerce_dimension_unit',         'cm',                  'yes'),
('woocommerce_manage_stock',           'yes',                 'yes'),
('woocommerce_notify_low_stock',       'yes',                 'yes'),
('woocommerce_low_stock_amount',       '10',                  'yes'),
('woocommerce_notify_no_stock',        'yes',                 'yes'),
('woocommerce_enable_reviews',         'yes',                 'yes'),
('woocommerce_review_rating_required', 'no',                  'yes'),
('woocommerce_enable_coupon',          'yes',                 'yes'),
('woocommerce_calc_taxes',             'no',                  'yes'),
('woocommerce_enable_guest_checkout',  'yes',                 'yes'),
('woocommerce_enable_signup_and_login_from_checkout', 'yes', 'yes'),
('woocommerce_ship_to_destination',    'billing',             'yes'),
('woocommerce_enable_shipping_calc',   'yes',                 'yes'),
('woocommerce_default_catalog_orderby', 'menu_order',        'yes'),
('woocommerce_catalog_columns',        '4',                   'yes'),
('woocommerce_catalog_rows',           '3',                   'yes')
ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`);

-- ============================================================
-- TABLE: wp_terms (taxonomy terms)
-- ============================================================

-- Product Categories
INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(10, 'Professional Match Balls', 'professional-match-balls', 0),
(11, 'Training Balls',           'training-balls',           0),
(12, 'Youth & Junior Balls',     'youth-junior-balls',       0),
(13, 'Futsal Balls',             'futsal-balls',             0),
(14, 'Beach Soccer Balls',       'beach-soccer-balls',       0),
(15, 'Custom & Branded Balls',   'custom-branded-balls',     0)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `slug` = VALUES(`slug`);

-- Product Tags
INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(20, 'FIFA',         'fifa',         0),
(21, 'Professional', 'professional', 0),
(22, 'Match Ball',   'match-ball',   0),
(23, 'Training',     'training',     0),
(24, 'Youth',        'youth',        0),
(25, 'Futsal',       'futsal',       0),
(26, 'Beach',        'beach',        0),
(27, 'Custom',       'custom',       0),
(28, 'Size 5',       'size-5',       0),
(29, 'Size 4',       'size-4',       0),
(30, 'Size 3',       'size-3',       0),
(31, 'Bulk',         'bulk',         0)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `slug` = VALUES(`slug`);

-- ============================================================
-- TABLE: wp_term_taxonomy
-- ============================================================

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(10, 10, 'product_cat', 'FIFA approved and elite match balls for professional competitions. Built to the highest international standards with premium materials.', 0, 2),
(11, 11, 'product_cat', 'Durable training footballs designed for daily practice sessions, club training, and intensive drill use.',                              0, 2),
(12, 12, 'product_cat', 'Size 3 and Size 4 footballs designed specifically for young players, academies, and junior leagues.',                                  0, 2),
(13, 13, 'product_cat', 'Low-bounce futsal balls designed specifically for indoor futsal courts. Approved for official futsal competitions.',                   0, 2),
(14, 14, 'product_cat', 'Bright, water-resistant beach soccer balls built for sand play. Soft outer panels for barefoot comfort.',                             0, 2),
(15, 15, 'product_cat', 'Custom logo and branded footballs for clubs, teams, schools, and corporate orders. MOQ applies.',                                     0, 2),
(20, 20, 'product_tag', '', 0, 2),
(21, 21, 'product_tag', '', 0, 4),
(22, 22, 'product_tag', '', 0, 4),
(23, 23, 'product_tag', '', 0, 4),
(24, 24, 'product_tag', '', 0, 2),
(25, 25, 'product_tag', '', 0, 2),
(26, 26, 'product_tag', '', 0, 2),
(27, 27, 'product_tag', '', 0, 2),
(28, 28, 'product_tag', '', 0, 6),
(29, 29, 'product_tag', '', 0, 3),
(30, 30, 'product_tag', '', 0, 1),
(31, 31, 'product_tag', '', 0, 3)
ON DUPLICATE KEY UPDATE `description` = VALUES(`description`), `count` = VALUES(`count`);

-- ============================================================
-- TABLE: wp_posts (WooCommerce pages + Products)
-- ============================================================

-- WooCommerce Required Pages
INSERT INTO `wp_posts`
  (`ID`, `post_author`, `post_date`, `post_content`, `post_title`, `post_status`, `comment_status`, `post_name`, `post_type`, `post_modified`, `to_ping`, `pinged`, `post_content_filtered`, `guid`)
VALUES
(100, 1, '2024-01-01 00:00:00', '',                        'Shop',       'publish', 'closed', 'shop',       'page', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?page_id=100'),
(101, 1, '2024-01-01 00:00:00', '[woocommerce_cart]',      'Cart',       'publish', 'closed', 'cart',       'page', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?page_id=101'),
(102, 1, '2024-01-01 00:00:00', '[woocommerce_checkout]',  'Checkout',   'publish', 'closed', 'checkout',   'page', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?page_id=102'),
(103, 1, '2024-01-01 00:00:00', '[woocommerce_my_account]','My Account', 'publish', 'closed', 'my-account', 'page', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?page_id=103')
ON DUPLICATE KEY UPDATE `post_title` = VALUES(`post_title`), `post_status` = VALUES(`post_status`);

-- WooCommerce Page ID Options
INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES
('woocommerce_shop_page_id',       '100', 'yes'),
('woocommerce_cart_page_id',       '101', 'yes'),
('woocommerce_checkout_page_id',   '102', 'yes'),
('woocommerce_myaccount_page_id',  '103', 'yes')
ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`);

-- Products
INSERT INTO `wp_posts`
  (`ID`, `post_author`, `post_date`, `post_content`, `post_excerpt`, `post_title`, `post_status`, `comment_status`, `post_name`, `post_type`, `post_modified`, `to_ping`, `pinged`, `post_content_filtered`, `guid`)
VALUES
(200, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Pro Match Ball is our flagship FIFA Quality Pro certified football. Constructed with 20-panel thermally bonded PU synthetic leather, this ball offers elite-level performance.</p>',
  'FIFA Quality Pro certified match ball. Premium thermally bonded PU construction.',
  'IMPEX Pro Match Ball FIFA Approved', 'publish', 'open', 'impex-pro-match-ball-fifa', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=200'),

(201, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Elite Match Ball delivers tournament-grade performance at an accessible price point. 32-panel hand-stitched construction.</p>',
  'FIFA Quality certified elite match ball. 32-panel hand-stitched for league play.',
  'IMPEX Elite Match Ball', 'publish', 'open', 'impex-elite-match-ball', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=201'),

(202, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Training Pro is engineered for heavy-duty daily training. Featuring a durable 32-panel machine-stitched PVC/PU hybrid outer.</p>',
  'Heavy-duty training football for daily practice on all surfaces.',
  'IMPEX Training Pro', 'publish', 'open', 'impex-training-pro', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=202'),

(203, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Club Trainer is the go-to choice for clubs looking for reliable training balls at a competitive price.</p>',
  'Reliable, durable club training ball. Ideal for bulk orders and squad sessions.',
  'IMPEX Club Trainer', 'publish', 'open', 'impex-club-trainer', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=203'),

(204, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Youth Star is designed for players aged 8–12. Size 4 construction with a softer PU outer provides the right feel for developing skills.</p>',
  'Size 4 youth football for ages 8–12. Soft-touch PU outer.',
  'IMPEX Youth Star', 'publish', 'open', 'impex-youth-star', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=204'),

(205, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Junior League ball is perfect for the youngest players starting their football journey. Size 3 construction.</p>',
  'Size 3 junior ball for under-8 players. Lightweight with fun colours.',
  'IMPEX Junior League', 'publish', 'open', 'impex-junior-league', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=205'),

(206, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Futsal Master is approved for official futsal competitions. Low-bounce foam inner provides the characteristic reduced rebound.</p>',
  'FIFA Futsal Approved ball. Low-bounce foam construction for indoor futsal.',
  'IMPEX Futsal Master', 'publish', 'open', 'impex-futsal-master', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=206'),

(207, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Futsal Club is a durable training futsal ball suitable for regular club and recreational use.</p>',
  'Durable club-level futsal ball with low-bounce foam bladder.',
  'IMPEX Futsal Club', 'publish', 'open', 'impex-futsal-club', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=207'),

(208, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Beach King is our premium beach soccer ball, designed for the sand and sun. Soft, water-resistant PU panels.</p>',
  'Premium beach soccer ball. Water-resistant PU panels for barefoot sand play.',
  'IMPEX Beach King', 'publish', 'open', 'impex-beach-king', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=208'),

(209, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Beach Pro is an excellent all-round beach soccer ball for recreational and club beach soccer.</p>',
  'Recreational beach soccer ball. Water-resistant PVC outer.',
  'IMPEX Beach Pro', 'publish', 'open', 'impex-beach-pro', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=209'),

(210, 1, '2024-01-01 00:00:00',
  '<p>Order your own custom branded IMPEX football with your club, school, or company logo. MOQ 50 balls.</p>',
  'Custom logo footballs with your brand. MOQ 50 units from $12.99/unit.',
  'IMPEX Custom Logo Ball (MOQ 50)', 'publish', 'open', 'impex-custom-logo-ball', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=210'),

(211, 1, '2024-01-01 00:00:00',
  '<p>The IMPEX Branded Team Ball is perfect for academies, schools, and large club orders. Minimum 100 units with full team branding.</p>',
  'Bulk branded team footballs. MOQ 100 units from $10.99/unit.',
  'IMPEX Branded Team Ball (MOQ 100)', 'publish', 'open', 'impex-branded-team-ball', 'product', '2024-01-01 00:00:00', '', '', '', 'http://localhost/impex/?post_type=product&p=211')
ON DUPLICATE KEY UPDATE `post_title` = VALUES(`post_title`), `post_content` = VALUES(`post_content`);

-- ============================================================
-- TABLE: wp_postmeta (WooCommerce product metadata)
-- ============================================================

-- Product 200: IMPEX Pro Match Ball FIFA Approved ($89.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(200, '_sku',              'IMP-PRO-001'),
(200, '_price',            '89.99'),
(200, '_regular_price',    '89.99'),
(200, '_sale_price',       ''),
(200, '_manage_stock',     'yes'),
(200, '_stock',            '150'),
(200, '_stock_status',     'instock'),
(200, '_weight',           '430'),
(200, '_length',           '22'),
(200, '_width',            '22'),
(200, '_height',           '22'),
(200, '_featured',         'yes'),
(200, '_visibility',       'visible'),
(200, 'total_sales',       '47'),
(200, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 201: IMPEX Elite Match Ball ($74.99, was $84.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(201, '_sku',              'IMP-ELT-002'),
(201, '_price',            '74.99'),
(201, '_regular_price',    '84.99'),
(201, '_sale_price',       '74.99'),
(201, '_manage_stock',     'yes'),
(201, '_stock',            '200'),
(201, '_stock_status',     'instock'),
(201, '_weight',           '430'),
(201, '_featured',         'yes'),
(201, '_visibility',       'visible'),
(201, 'total_sales',       '31'),
(201, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 202: IMPEX Training Pro ($45.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(202, '_sku',              'IMP-TRN-003'),
(202, '_price',            '45.99'),
(202, '_regular_price',    '45.99'),
(202, '_sale_price',       ''),
(202, '_manage_stock',     'yes'),
(202, '_stock',            '500'),
(202, '_stock_status',     'instock'),
(202, '_weight',           '420'),
(202, '_featured',         'no'),
(202, '_visibility',       'visible'),
(202, 'total_sales',       '112'),
(202, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 203: IMPEX Club Trainer ($34.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(203, '_sku',              'IMP-CLB-004'),
(203, '_price',            '34.99'),
(203, '_regular_price',    '34.99'),
(203, '_sale_price',       ''),
(203, '_manage_stock',     'yes'),
(203, '_stock',            '750'),
(203, '_stock_status',     'instock'),
(203, '_weight',           '410'),
(203, '_featured',         'no'),
(203, '_visibility',       'visible'),
(203, 'total_sales',       '89'),
(203, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 204: IMPEX Youth Star ($29.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(204, '_sku',              'IMP-YTH-005'),
(204, '_price',            '29.99'),
(204, '_regular_price',    '29.99'),
(204, '_sale_price',       ''),
(204, '_manage_stock',     'yes'),
(204, '_stock',            '400'),
(204, '_stock_status',     'instock'),
(204, '_weight',           '320'),
(204, '_featured',         'no'),
(204, '_visibility',       'visible'),
(204, 'total_sales',       '63'),
(204, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 205: IMPEX Junior League ($24.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(205, '_sku',              'IMP-JNR-006'),
(205, '_price',            '24.99'),
(205, '_regular_price',    '24.99'),
(205, '_sale_price',       ''),
(205, '_manage_stock',     'yes'),
(205, '_stock',            '600'),
(205, '_stock_status',     'instock'),
(205, '_weight',           '250'),
(205, '_featured',         'no'),
(205, '_visibility',       'visible'),
(205, 'total_sales',       '41'),
(205, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 206: IMPEX Futsal Master ($49.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(206, '_sku',              'IMP-FUT-007'),
(206, '_price',            '49.99'),
(206, '_regular_price',    '49.99'),
(206, '_sale_price',       ''),
(206, '_manage_stock',     'yes'),
(206, '_stock',            '250'),
(206, '_stock_status',     'instock'),
(206, '_weight',           '440'),
(206, '_featured',         'yes'),
(206, '_visibility',       'visible'),
(206, 'total_sales',       '28'),
(206, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 207: IMPEX Futsal Club ($39.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(207, '_sku',              'IMP-FUT-008'),
(207, '_price',            '39.99'),
(207, '_regular_price',    '39.99'),
(207, '_sale_price',       ''),
(207, '_manage_stock',     'yes'),
(207, '_stock',            '350'),
(207, '_stock_status',     'instock'),
(207, '_weight',           '430'),
(207, '_featured',         'no'),
(207, '_visibility',       'visible'),
(207, 'total_sales',       '19'),
(207, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 208: IMPEX Beach King ($44.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(208, '_sku',              'IMP-BCH-009'),
(208, '_price',            '44.99'),
(208, '_regular_price',    '44.99'),
(208, '_sale_price',       ''),
(208, '_manage_stock',     'yes'),
(208, '_stock',            '200'),
(208, '_stock_status',     'instock'),
(208, '_weight',           '400'),
(208, '_featured',         'yes'),
(208, '_visibility',       'visible'),
(208, 'total_sales',       '22'),
(208, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 209: IMPEX Beach Pro ($37.99)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(209, '_sku',              'IMP-BCH-010'),
(209, '_price',            '37.99'),
(209, '_regular_price',    '37.99'),
(209, '_sale_price',       ''),
(209, '_manage_stock',     'yes'),
(209, '_stock',            '300'),
(209, '_stock_status',     'instock'),
(209, '_weight',           '395'),
(209, '_featured',         'no'),
(209, '_visibility',       'visible'),
(209, 'total_sales',       '15'),
(209, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 210: IMPEX Custom Logo Ball ($12.99/unit)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(210, '_sku',              'IMP-CUS-011'),
(210, '_price',            '12.99'),
(210, '_regular_price',    '12.99'),
(210, '_sale_price',       ''),
(210, '_manage_stock',     'yes'),
(210, '_stock',            '9999'),
(210, '_stock_status',     'instock'),
(210, '_weight',           '430'),
(210, '_featured',         'yes'),
(210, '_visibility',       'visible'),
(210, 'total_sales',       '5'),
(210, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- Product 211: IMPEX Branded Team Ball ($10.99/unit)
INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
(211, '_sku',              'IMP-CUS-012'),
(211, '_price',            '10.99'),
(211, '_regular_price',    '10.99'),
(211, '_sale_price',       ''),
(211, '_manage_stock',     'yes'),
(211, '_stock',            '9999'),
(211, '_stock_status',     'instock'),
(211, '_weight',           '420'),
(211, '_featured',         'no'),
(211, '_visibility',       'visible'),
(211, 'total_sales',       '3'),
(211, '_product_attributes', 'a:0:{}')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- ============================================================
-- TABLE: wp_term_relationships (Product <-> Category mapping)
-- ============================================================

-- Professional Match Balls category (taxonomy_id=10)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(200, 10, 0),  -- IMPEX Pro Match Ball -> Professional Match Balls
(201, 10, 0)   -- IMPEX Elite Match Ball -> Professional Match Balls
ON DUPLICATE KEY UPDATE `term_order` = VALUES(`term_order`);

-- Training Balls category (taxonomy_id=11)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(202, 11, 0),  -- IMPEX Training Pro -> Training Balls
(203, 11, 0)   -- IMPEX Club Trainer -> Training Balls
ON DUPLICATE KEY UPDATE `term_order` = VALUES(`term_order`);

-- Youth & Junior Balls category (taxonomy_id=12)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(204, 12, 0),  -- IMPEX Youth Star -> Youth & Junior Balls
(205, 12, 0)   -- IMPEX Junior League -> Youth & Junior Balls
ON DUPLICATE KEY UPDATE `term_order` = VALUES(`term_order`);

-- Futsal Balls category (taxonomy_id=13)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(206, 13, 0),  -- IMPEX Futsal Master -> Futsal Balls
(207, 13, 0)   -- IMPEX Futsal Club -> Futsal Balls
ON DUPLICATE KEY UPDATE `term_order` = VALUES(`term_order`);

-- Beach Soccer Balls category (taxonomy_id=14)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(208, 14, 0),  -- IMPEX Beach King -> Beach Soccer Balls
(209, 14, 0)   -- IMPEX Beach Pro -> Beach Soccer Balls
ON DUPLICATE KEY UPDATE `term_order` = VALUES(`term_order`);

-- Custom & Branded Balls category (taxonomy_id=15)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(210, 15, 0),  -- IMPEX Custom Logo Ball -> Custom & Branded Balls
(211, 15, 0)   -- IMPEX Branded Team Ball -> Custom & Branded Balls
ON DUPLICATE KEY UPDATE `term_order` = VALUES(`term_order`);

-- ============================================================
-- TABLE: wp_users (Admin user)
-- ============================================================

-- Note: Password hash is for "ImpexAdmin2024!" — CHANGE IN PRODUCTION
INSERT INTO `wp_users`
  (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`)
VALUES
(1, 'impex_admin',
   '$P$BHFmrWtYsMvnIdpM3dBwRLuv.Kh1Mz.',  -- Hash placeholder — RESET password after import
   'impex-admin',
   'admin@impexfootball.com',
   'http://localhost/impex',
   '2024-01-01 00:00:00',
   '', 0,
   'IMPEX Admin')
ON DUPLICATE KEY UPDATE `user_email` = VALUES(`user_email`), `display_name` = VALUES(`display_name`);

-- ============================================================
-- TABLE: wp_usermeta (Admin user capabilities)
-- ============================================================

INSERT INTO `wp_usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES
(1, 'wp_capabilities',      'a:1:{s:13:"administrator";b:1;}'),
(1, 'wp_user_level',        '10'),
(1, 'first_name',           'IMPEX'),
(1, 'last_name',            'Admin'),
(1, 'nickname',             'impex_admin'),
(1, 'description',          'IMPEX Football Store Administrator'),
(1, 'billing_first_name',   'IMPEX'),
(1, 'billing_last_name',    'Admin'),
(1, 'billing_address_1',    '123 Football Drive'),
(1, 'billing_city',         'Sialkot'),
(1, 'billing_postcode',     '51310'),
(1, 'billing_country',      'PK'),
(1, 'billing_email',        'admin@impexfootball.com'),
(1, 'billing_phone',        '+92 52 123 4567')
ON DUPLICATE KEY UPDATE `meta_value` = VALUES(`meta_value`);

-- ============================================================
-- CLEANUP & FINAL SETTINGS
-- ============================================================

-- Mark setup as complete
INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES
('impex_setup_complete',  NOW(),        'no'),
('impex_setup_version',   '1.0.0',     'no'),
('impex_db_imported',     NOW(),        'no')
ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`);

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- IMPORT COMPLETE
-- Total categories: 6
-- Total products:   12
-- Total pages:      4 (Shop, Cart, Checkout, My Account)
-- Admin user:       impex_admin (reset password after import!)
-- ============================================================
